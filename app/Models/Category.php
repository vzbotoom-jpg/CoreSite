<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'type',
        'is_active',
        // Blog fields
        'type', // 'product' or 'blog'
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'total_products_count',
        'path',
        'posts_count',
        'url',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
            if (empty($category->type)) {
                $category->type = 'product';
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the store that owns the category.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the products in this category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the blog posts in this category.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // ==================== SCOPES ====================

    /**
     * Scope for active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for product categories.
     */
    public function scopeProduct($query)
    {
        return $query->where('type', 'product');
    }

    /**
     * Scope for blog categories.
     */
    public function scopeBlog($query)
    {
        return $query->where('type', 'blog');
    }

    /**
     * Scope for categories with posts count.
     */
    public function scopeWithPostsCount($query)
    {
        return $query->withCount('posts');
    }

    /**
     * Scope for ordered categories.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ==================== ATTRIBUTES ====================

    /**
     * Get total products count including from child categories.
     */
    public function getTotalProductsCountAttribute(): int
    {
        $count = $this->products()->count();
        
        foreach ($this->children as $child) {
            $count += $child->total_products_count;
        }
        
        return $count;
    }

    /**
     * Get total posts count including from child categories.
     */
    public function getTotalPostsCountAttribute(): int
    {
        $count = $this->posts()->count();
        
        foreach ($this->children as $child) {
            $count += $child->total_posts_count;
        }
        
        return $count;
    }

    /**
     * Get full path of category (parent > child).
     */
    public function getPathAttribute(): string
    {
        $path = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Get posts count for the category.
     */
    public function getPostsCountAttribute(): int
    {
        return $this->posts()->count();
    }

    /**
     * Get URL for the category.
     */
    public function getUrlAttribute(): string
    {
        if ($this->type === 'blog') {
            return route('blog.category', $this->slug);
        }
        return route('catalog.category', $this->slug);
    }

    /**
     * Get category tree as array.
     */
    public function getTreeAttribute(): array
    {
        $tree = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'children' => $this->children->map->tree->toArray(),
        ];
        
        return $tree;
    }

    // ==================== METHODS ====================

    /**
     * Get all category IDs including children.
     */
    public function getAllChildrenIds(): array
    {
        $ids = [$this->id];
        
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }
        
        return $ids;
    }

    /**
     * Check if category has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if category is root.
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Get category breadcrumb.
     */
    public function getBreadcrumb(): array
    {
        $breadcrumb = [];
        $current = $this;
        
        while ($current) {
            array_unshift($breadcrumb, [
                'name' => $current->name,
                'slug' => $current->slug,
                'url' => $current->url,
            ]);
            $current = $current->parent;
        }
        
        return $breadcrumb;
    }

    /**
     * Get sibling categories.
     */
    public function getSiblings()
    {
        return self::where('parent_id', $this->parent_id)
            ->where('id', '!=', $this->id)
            ->get();
    }

    /**
     * Get popular categories (with most posts or products).
     */
    public static function getPopular($limit = 5, $type = 'blog')
    {
        return self::where('type', $type)
            ->where('is_active', true)
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Create a new blog category.
     */
    public static function createBlogCategory(array $data)
    {
        $data['type'] = 'blog';
        return self::create($data);
    }

    /**
     * Create a new product category.
     */
    public static function createProductCategory(array $data)
    {
        $data['type'] = 'product';
        return self::create($data);
    }

    /**
     * Scope for search.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Get category with all relationships for API.
     */
    public function toApiResponse()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'type' => $this->type,
            'posts_count' => $this->posts_count,
            'total_products_count' => $this->total_products_count,
            'path' => $this->path,
            'url' => $this->url,
            'is_active' => $this->is_active,
            'children' => $this->children->map->toApiResponse(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}