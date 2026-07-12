{{-- resources/views/admin/products/partials/category-tree.blade.php --}}
@props(['categories', 'selectedId' => null, 'level' => 0])

@foreach($categories as $category)
    <option value="{{ $category->id }}" 
            {{ $selectedId == $category->id ? 'selected' : '' }}
            style="padding-left: {{ $level * 20 }}px">
        {{ str_repeat('—', $level) }} {{ $category->name }}
    </option>
    @if($category->children && $category->children->count() > 0)
        <x-admin.products.partials.category-tree 
            :categories="$category->children" 
            :selectedId="$selectedId" 
            :level="$level + 1" />
    @endif
@endforeach