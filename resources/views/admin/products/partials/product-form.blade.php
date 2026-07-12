{{-- resources/views/admin/products/partials/product-form.blade.php --}}
@props(['product' => null, 'categories' => []])

<div class="space-y-4">
    <!-- Name -->
    <div>
        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Produk *</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required 
               class="input @error('name') input-error @enderror" placeholder="Nama produk">
        @error('name')
            <p class="text-error text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <!-- Category -->
    <div>
        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Kategori</label>
        <select name="category_id" class="input">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <!-- Description -->
    <div>
        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Deskripsi</label>
        <textarea name="description" rows="4" class="input" placeholder="Deskripsi produk">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    
    <!-- Price & Stock -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Harga *</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-secondary">Rp</span>
                <input type="number" name="price" value="{{ old('price', $product->price ?? 0) }}" required 
                       min="0" step="1000" class="input pl-10 @error('price') input-error @enderror" placeholder="0">
            </div>
            @error('price')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Stok *</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required 
                   min="0" class="input @error('stock') input-error @enderror" placeholder="0">
            @error('stock')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <!-- Min Stock Alert -->
    <div>
        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Minimal Stok Peringatan</label>
        <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', $product->min_stock_alert ?? 5) }}" 
               min="0" class="input">
        <p class="text-xs text-text-secondary dark:text-text-dark-secondary mt-1">Akan mendapat notifikasi saat stok mencapai angka ini</p>
    </div>
    
    <!-- Is Active -->
    <div>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" 
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent">
            <span class="text-sm text-text-primary dark:text-text-dark-primary">Produk Aktif</span>
        </label>
    </div>
</div>