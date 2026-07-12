{{-- resources/views/layouts/partials/catalog-footer.blade.php --}}
<footer class="bg-light-surface dark:bg-dark-surface border-t border-light-border dark:border-dark-border mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center text-text-secondary text-sm">
            <p>&copy; {{ date('Y') }} {{ $store->name ?? 'CoreSite' }} - Powered by CoreSite</p>
        </div>
    </div>
</footer>