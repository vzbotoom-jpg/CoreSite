{{-- resources/views/catalog/partials/pagination.blade.php --}}
<div class="flex justify-center items-center gap-2">
    <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 disabled:cursor-not-allowed">
        Sebelumnya
    </button>
    
    <template x-for="page in getPageNumbers()" :key="page">
        <button @click="goToPage(page)" 
                :class="page === currentPage ? 'bg-accent text-white' : 'hover:bg-light-surface'"
                class="px-3 py-1 border rounded transition-colors"
                x-text="page"></button>
    </template>
    
    <button @click="goToPage(currentPage + 1)" :disabled="currentPage === lastPage"
            class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 disabled:cursor-not-allowed">
        Selanjutnya
    </button>
</div>

<script>
function getPageNumbers() {
    const delta = 2;
    const range = [];
    const rangeWithDots = [];
    let l;
    
    for (let i = 1; i <= this.lastPage; i++) {
        if (i === 1 || i === this.lastPage || (i >= this.currentPage - delta && i <= this.currentPage + delta)) {
            range.push(i);
        }
    }
    
    for (let i of range) {
        if (l) {
            if (i - l === 2) {
                rangeWithDots.push(l + 1);
            } else if (i - l !== 1) {
                rangeWithDots.push('...');
            }
        }
        rangeWithDots.push(i);
        l = i;
    }
    
    return rangeWithDots;
}
</script>