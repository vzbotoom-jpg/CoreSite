<?php
// app/Http/Controllers/BlogController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Subscriber;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $posts = Post::with(['category', 'tags', 'user'])
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // Handle categories with or without 'type' column
        $categories = $this->getBlogCategories();
        
        $recentPosts = Post::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'tags'));
    }

    /**
     * Display a single blog post.
     */
    public function show($slug)
    {
        $post = Post::with(['category', 'tags', 'user', 'comments.user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $post->increment('views');

        $categories = $this->getBlogCategories();
        $recentPosts = Post::where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.post', compact('post', 'categories', 'recentPosts', 'tags'));
    }

    /**
     * Display posts by category.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Check if category is blog type
        if (Schema::hasColumn('categories', 'type') && $category->type !== 'blog') {
            abort(404, 'Category not found');
        }
        
        $posts = Post::where('category_id', $category->id)
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = $this->getBlogCategories();
        $recentPosts = Post::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'tags', 'category'));
    }

    /**
     * Display posts by tag.
     */
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = $this->getBlogCategories();
        $recentPosts = Post::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'tags', 'tag'));
    }

    /**
     * Search blog posts.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('blog.index');
        }

        $posts = Post::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = $this->getBlogCategories();
        $recentPosts = Post::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $tags = Tag::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'tags'));
    }

    /**
     * Get blog categories with fallback if 'type' column doesn't exist.
     */
    protected function getBlogCategories()
    {
        try {
            // Check if 'type' column exists in categories table
            if (Schema::hasColumn('categories', 'type')) {
                return Category::where('type', 'blog')->withCount('posts')->get();
            }
            
            // Fallback: get all categories and filter those that have blog posts
            return Category::withCount('posts')
                ->having('posts_count', '>', 0)
                ->get();
                
        } catch (\Exception $e) {
            Log::warning('Error fetching blog categories: ' . $e->getMessage());
            
            // Ultimate fallback: return empty collection
            return collect([]);
        }
    }

    /**
     * Handle newsletter subscription.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        try {
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'verification_token' => Str::random(64),
                'source' => 'blog',
            ]);

            // TODO: Send verification email
            // Mail::to($subscriber->email)->send(new VerifySubscriberMail($subscriber));

            return back()->with('success', 'Thank you for subscribing! Please check your email to verify.');
            
        } catch (\Exception $e) {
            Log::error('Subscription failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to subscribe. Please try again.');
        }
    }

    /**
     * Verify subscriber.
     */
    public function verifySubscriber($token)
    {
        try {
            $subscriber = Subscriber::where('verification_token', $token)->firstOrFail();
            $subscriber->is_verified = true;
            $subscriber->verified_at = now();
            $subscriber->save();

            return redirect()->route('blog.index')
                ->with('success', 'Email verified successfully! You are now subscribed.');
                
        } catch (\Exception $e) {
            Log::error('Verification failed: ' . $e->getMessage());
            return redirect()->route('blog.index')
                ->with('error', 'Invalid verification token. Please try again.');
        }
    }

    /**
     * Unsubscribe subscriber.
     */
    public function unsubscribe($token, $email = null)
    {
        try {
            $subscriber = Subscriber::where('verification_token', $token)
                ->when($email, function ($query, $email) {
                    return $query->where('email', $email);
                })
                ->firstOrFail();

            $subscriber->is_active = false;
            $subscriber->unsubscribed_at = now();
            $subscriber->save();

            return redirect()->route('blog.index')
                ->with('success', 'You have been unsubscribed successfully.');
                
        } catch (\Exception $e) {
            Log::error('Unsubscribe failed: ' . $e->getMessage());
            return redirect()->route('blog.index')
                ->with('error', 'Invalid unsubscribe link. Please try again.');
        }
    }

    /**
     * Store a comment.
     */
    public function comment(Request $request, $slug)
    {
        try {
            $post = Post::where('slug', $slug)->firstOrFail();

            $request->validate([
                'content' => 'required|string|min:3|max:5000',
            ]);

            $comment = Comment::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'content' => $request->content,
                'author_name' => auth()->check() ? auth()->user()->name : ($request->name ?? 'Guest'),
                'author_email' => auth()->check() ? auth()->user()->email : ($request->email ?? null),
                'author_ip' => $request->ip(),
                'is_approved' => true, // Auto-approve comments
            ]);

            return back()->with('success', 'Comment posted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Comment failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to post comment. Please try again.');
        }
    }

    /**
     * Like a comment.
     */
    public function likeComment($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->increment('likes');

            return response()->json([
                'success' => true,
                'likes' => $comment->likes,
                'message' => 'Comment liked successfully!'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Like comment failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to like comment.'
            ], 500);
        }
    }

    /**
     * Get subscriber statistics (for admin).
     */
    public function subscriberStats()
    {
        try {
            $stats = Subscriber::getStats();

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Subscriber stats failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get subscriber statistics.'
            ], 500);
        }
    }

    /**
     * Get subscriber growth data (for admin).
     */
    public function subscriberGrowth(Request $request)
    {
        try {
            $days = $request->get('days', 30);
            $data = Subscriber::getGrowthData($days);

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Subscriber growth failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get subscriber growth data.'
            ], 500);
        }
    }

    /**
     * Get blog posts for API (AJAX loading).
     */
    public function getPosts(Request $request)
    {
        try {
            $posts = Post::with(['category', 'tags', 'user'])
                ->where('is_published', true)
                ->when($request->category, function ($query, $category) {
                    return $query->whereHas('category', function ($q) use ($category) {
                        $q->where('slug', $category);
                    });
                })
                ->when($request->tag, function ($query, $tag) {
                    return $query->whereHas('tags', function ($q) use ($tag) {
                        $q->where('slug', $tag);
                    });
                })
                ->when($request->search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('content', 'like', "%{$search}%")
                            ->orWhere('excerpt', 'like', "%{$search}%");
                    });
                })
                ->orderBy($request->sort ?? 'created_at', $request->direction ?? 'desc')
                ->paginate($request->per_page ?? 9);

            return response()->json([
                'success' => true,
                'data' => $posts,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get posts failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get posts.'
            ], 500);
        }
    }

    /**
     * Get single post for API.
     */
    public function getPost($slug)
    {
        try {
            $post = Post::with(['category', 'tags', 'user', 'comments.user'])
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $post,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get post failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Post not found.'
            ], 404);
        }
    }

    /**
     * Get blog categories for API.
     */
    public function getCategories()
    {
        try {
            $categories = $this->getBlogCategories();

            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get categories failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get categories.'
            ], 500);
        }
    }

    /**
     * Get blog tags for API.
     */
    public function getTags()
    {
        try {
            $tags = Tag::withCount('posts')->get();

            return response()->json([
                'success' => true,
                'data' => $tags,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get tags failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get tags.'
            ], 500);
        }
    }
}