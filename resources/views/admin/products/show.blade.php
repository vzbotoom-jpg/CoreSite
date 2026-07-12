{{-- resources/views/admin/products/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card mb-6">
        <div class="card-header flex justify-between items-center">
            <h3 class="font-semibold">{{ $product->name }}</h3>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary text-sm">
                    Edit Produk
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline text-sm">
                    Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <div class="bg-light-surface dark:bg-dark-surface rounded-lg aspect-square flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <svg class="w-24 h-24 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-text-secondary">Kategori</label>
                        <p class="font-medium">{{ $product->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Harga</label>
                        <p class="text-2xl font-bold text-accent">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Stok</label>
                        <p class="font-medium {{ $product->stock <= $product->min_stock_alert ? 'text-warning' : '' }}">
                            {{ number_format($product->stock) }} unit
                            @if($product->stock <= $product->min_stock_alert && $product->stock > 0)
                                <span class="text-xs text-warning ml-2">(Stok menipis)</span>
                            @elseif($product->stock <= 0)
                                <span class="text-xs text-error ml-2">(Habis)</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Status</label>
                        <div>
                            @if($product->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-error">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm text-text-secondary">Deskripsi</label>
                        <p class="text-text-secondary">{{ $product->description ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Inventory Logs -->
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold">Riwayat Stok</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Tanggal</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Tipe</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Jumlah</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Stok Lama</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Stok Baru</th>
                        <th class="text-left px-6 py-3 text-sm font-medium text-text-secondary">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($product->inventoryLogs as $log)
                        <tr class="border-b hover:bg-light-surface/50">
                            <td class="px-6 py-3 text-sm">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3">
                                <span class="badge badge-sm 
                                    @if($log->type === 'sale') badge-success
                                    @elseif($log->type === 'restock') badge-primary
                                    @elseif($log->type === 'adjustment') badge-warning
                                    @else badge-info
                                    @endif">
                                    {{ ucfirst($log->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-sm">{{ $log->quantity }}</td>
                            <td class="px-6 py-3 text-sm">{{ $log->old_stock }}</td>
                            <td class="px-6 py-3 text-sm">{{ $log->new_stock }}</td>
                            <td class="px-6 py-3 text-sm text-text-secondary">{{ $log->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-text-secondary">
                                Belum ada riwayat stok
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection