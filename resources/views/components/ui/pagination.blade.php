{{-- resources/views/components/ui/pagination.blade.php --}}
@props([
    'paginator',
    'size' => 'md',
    'showInfo' => true,
    'showPages' => true,
    'showPerPage' => false,
    'perPageOptions' => [10, 25, 50, 100],
    'perPage' => 10,
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'text-sm gap-1',
        'lg' => 'text-lg gap-3',
        default => 'text-base gap-2',
    };
    
    $buttonSize = match ($size) {
        'sm' => 'px-2.5 py-1.5 text-xs',
        'lg' => 'px-5 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };
    
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $perPage = $paginator->perPage();
    $total = $paginator->total();
    $firstItem = $paginator->firstItem();
    $lastItem = $paginator->lastItem();
@endphp

@if($paginator->hasPages())
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 {{ $sizeClasses }}">
    <!-- Info -->
    @if($showInfo)
        <div class="text-sm text-text-secondary dark:text-text-dark-secondary order-2 sm:order-1">
            Menampilkan 
            <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $firstItem }}</span>
            -
            <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $lastItem }}</span>
            dari
            <span class="font-medium text-text-primary dark:text-text-dark-primary">{{ $total }}</span>
            data
        </div>
    @endif
    
    <!-- Per Page Selector -->
    @if($showPerPage)
        <div class="flex items-center gap-2 order-3 sm:order-2">
            <span class="text-sm text-text-secondary dark:text-text-dark-secondary">Tampilkan</span>
            <select x-model="perPage" 
                    @change="$dispatch('per-page-change', perPage)"
                    class="input w-20 text-sm py-1.5">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
    
    <!-- Pagination Buttons -->
    @if($showPages)
        <div class="flex items-center gap-1 order-1 sm:order-3">
            <!-- Previous Page Link -->
            @if($paginator->onFirstPage())
                <button disabled class="btn btn-sm btn-outline opacity-50 cursor-not-allowed">
                    <span class="sr-only">Previous</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-outline">
                    <span class="sr-only">Previous</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif
            
            <!-- Page Numbers -->
            @php
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
                
                if ($start > 1) {
                    echo '<a href="' . $paginator->url(1) . '" class="btn btn-sm btn-outline">1</a>';
                }
                
                if ($start > 2) {
                    echo '<span class="px-3 py-1.5 text-text-secondary">...</span>';
                }
                
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $currentPage) {
                        echo '<span class="btn btn-sm btn-primary">' . $i . '</span>';
                    } else {
                        echo '<a href="' . $paginator->url($i) . '" class="btn btn-sm btn-outline">' . $i . '</a>';
                    }
                }
                
                if ($end < $lastPage - 1) {
                    echo '<span class="px-3 py-1.5 text-text-secondary">...</span>';
                }
                
                if ($end < $lastPage) {
                    echo '<a href="' . $paginator->url($lastPage) . '" class="btn btn-sm btn-outline">' . $lastPage . '</a>';
                }
            @endphp
            
            <!-- Next Page Link -->
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-outline">
                    <span class="sr-only">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <button disabled class="btn btn-sm btn-outline opacity-50 cursor-not-allowed">
                    <span class="sr-only">Next</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            @endif
        </div>
    @endif
</div>
@endif