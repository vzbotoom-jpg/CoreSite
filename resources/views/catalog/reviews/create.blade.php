{{-- resources/views/catalog/reviews/create.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Tulis Ulasan')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card">
        <div class="card-header">
            <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Tulis Ulasan</h3>
            <p class="text-sm text-text-secondary dark:text-text-dark-secondary mt-1">Bagikan pengalaman Anda dengan produk ini</p>
        </div>
        <div class="card-body">
            <!-- Product Info -->
            <div class="flex items-center gap-4 p-4 bg-light-surface/50 dark:bg-dark-surface/50 rounded-lg mb-6">
                <div class="w-16 h-16 bg-light-surface dark:bg-dark-surface rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">Smartphone Pro Max</h4>
                    <p class="text-sm text-text-secondary">Kategori: Elektronik</p>
                </div>
            </div>

            <form action="#" method="POST" x-data="reviewForm()" @submit.prevent="submitReview">
                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Rating *</label>
                    <div class="flex items-center gap-1">
                        <template x-for="star in 5" :key="star">
                            <button type="button" @click="rating = star" class="text-4xl transition-transform hover:scale-110">
                                <span x-text="star <= rating ? '⭐' : '☆'" class="text-4xl"></span>
                            </button>
                        </template>
                        <span class="ml-2 text-sm text-text-secondary" x-text="ratingText"></span>
                    </div>
                </div>

                <!-- Review Text -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Ulasan *</label>
                    <textarea x-model="review" rows="5" required class="input" placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>
                    <p class="text-xs text-text-secondary mt-1" x-text="review.length + ' / 500 karakter'"></p>
                </div>

                <!-- Pros & Cons -->
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Kelebihan</label>
                        <input type="text" x-model="pros" class="input" placeholder="Apa yang Anda sukai dari produk ini?">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Kekurangan</label>
                        <input type="text" x-model="cons" class="input" placeholder="Apa yang bisa ditingkatkan?">
                    </div>
                </div>

                <!-- Photos -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Foto (Opsional)</label>
                    <div class="border-2 border-dashed border-light-border/40 dark:border-dark-border/40 rounded-lg p-8 text-center hover:border-accent/50 transition cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-text-secondary/50 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-text-secondary">Klik untuk upload foto</p>
                        <p class="text-xs text-text-secondary/60 mt-1">Format: JPG, PNG • Maks: 2MB</p>
                        <input type="file" accept="image/*" multiple class="hidden">
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                    <a href="#" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary" :disabled="loading">
                        <span x-show="!loading">Kirim Ulasan</span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <div class="spinner w-4 h-4"></div>
                            Mengirim...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function reviewForm() {
    return {
        rating: 0,
        review: '',
        pros: '',
        cons: '',
        loading: false,
        
        get ratingText() {
            const texts = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
            return texts[this.rating] || '';
        },
        
        async submitReview() {
            if (this.rating === 0) {
                window.showToast('Silakan beri rating terlebih dahulu', 'warning');
                return;
            }
            
            this.loading = true;
            await new Promise(resolve => setTimeout(resolve, 1500));
            this.loading = false;
            window.showToast('Ulasan berhasil dikirim!', 'success');
        }
    }
}
</script>
@endpush
@endsection