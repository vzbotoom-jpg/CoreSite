{{-- resources/views/components/tables/data-table.blade.php --}}
@props([
    'headers' => [],
    'rows' => [],
    'emptyMessage' => 'Tidak ada data',
    'showSearch' => true,
    'showPagination' => true,
    'perPage' => 10,
    'searchPlaceholder' => 'Cari...'
])

<div x-data="dataTable(@js($headers), @js($rows), {{ $perPage }})" x-init="init()" class="space-y-4">
    <!-- Search & Filters -->
    @if($showSearch)
        <div class="flex justify-between items-center gap-4">
            <div class="relative flex-1 max-w-sm">
                <input type="text" 
                       x-model="search" 
                       @input="filterData"
                       placeholder="{{ $searchPlaceholder }}"
                       class="input pl-10">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-text-secondary" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-text-secondary">Tampilkan</span>
                <select x-model="perPage" @change="changePerPage" class="input w-20">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-text-secondary">per halaman</span>
            </div>
        </div>
    @endif
    
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-light-border dark:border-dark-border">
                    @foreach($headers as $header)
                        <th class="text-left px-4 py-3 text-sm font-medium text-text-secondary">
                            @if($header['sortable'] ?? false)
                                <button @click="sortBy('{{ $header['key'] }}')" 
                                        class="flex items-center gap-1 hover:text-accent">
                                    {{ $header['label'] }}
                                    <svg x-show="sortField === '{{ $header['key'] }}' && sortDirection === 'asc'" 
                                         class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                    <svg x-show="sortField === '{{ $header['key'] }}' && sortDirection === 'desc'" 
                                         class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            @else
                                {{ $header['label'] }}
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <template x-for="item in paginatedData" :key="item.id">
                    <tr class="border-b border-light-border dark:border-dark-border hover:bg-light-surface/50 transition-colors">
                        @foreach($headers as $header)
                            <td class="px-4 py-3 text-sm">
                                <span x-text="item.{{ $header['key'] }}"></span>
                            </td>
                        @endforeach
                    </tr>
                </template>
                <tr x-show="filteredData.length === 0 && !loading">
                    <td colspan="{{ count($headers) }}" class="px-4 py-12 text-center text-text-secondary">
                        {{ $emptyMessage }}
                    </td>
                </tr>
                <tr x-show="loading">
                    <td colspan="{{ count($headers) }}" class="px-4 py-12 text-center">
                        <div class="spinner mx-auto"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($showPagination)
        <div x-show="filteredData.length > 0" class="flex justify-between items-center">
            <div class="text-sm text-text-secondary">
                Menampilkan <span x-text="startItem"></span> - <span x-text="endItem"></span> 
                dari <span x-text="filteredData.length"></span> data
            </div>
            <div class="flex gap-2">
                <button @click="prevPage" :disabled="currentPage === 1"
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 disabled:cursor-not-allowed">
                    Sebelumnya
                </button>
                <span class="px-3 py-1 text-text-secondary">
                    Halaman <span x-text="currentPage"></span> dari <span x-text="totalPages"></span>
                </span>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 disabled:cursor-not-allowed">
                    Selanjutnya
                </button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function dataTable(headers, initialData, defaultPerPage) {
    return {
        headers: headers,
        allData: initialData,
        filteredData: [],
        paginatedData: [],
        search: '',
        sortField: '',
        sortDirection: 'asc',
        currentPage: 1,
        perPage: defaultPerPage,
        loading: false,
        
        init() {
            this.filteredData = [...this.allData];
            this.updatePaginatedData();
        },
        
        filterData() {
            this.currentPage = 1;
            if (!this.search.trim()) {
                this.filteredData = [...this.allData];
            } else {
                const searchLower = this.search.toLowerCase();
                this.filteredData = this.allData.filter(item => {
                    return this.headers.some(header => {
                        const value = item[header.key];
                        return value && String(value).toLowerCase().includes(searchLower);
                    });
                });
            }
            this.applySort();
        },
        
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
            this.applySort();
        },
        
        applySort() {
            if (this.sortField) {
                this.filteredData.sort((a, b) => {
                    let aVal = a[this.sortField];
                    let bVal = b[this.sortField];
                    
                    if (typeof aVal === 'string') {
                        aVal = aVal.toLowerCase();
                        bVal = bVal.toLowerCase();
                    }
                    
                    if (aVal < bVal) return this.sortDirection === 'asc' ? -1 : 1;
                    if (aVal > bVal) return this.sortDirection === 'asc' ? 1 : -1;
                    return 0;
                });
            }
            this.updatePaginatedData();
        },
        
        updatePaginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            this.paginatedData = this.filteredData.slice(start, end);
        },
        
        changePerPage() {
            this.currentPage = 1;
            this.updatePaginatedData();
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.updatePaginatedData();
            }
        },
        
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.updatePaginatedData();
            }
        },
        
        get startItem() {
            if (this.filteredData.length === 0) return 0;
            return (this.currentPage - 1) * this.perPage + 1;
        },
        
        get endItem() {
            return Math.min(this.currentPage * this.perPage, this.filteredData.length);
        },
        
        get totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        }
    }
}
</script>
@endpush