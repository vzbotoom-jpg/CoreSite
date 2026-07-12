{{-- resources/views/admin/dashboard/components/stat-card.blade.php --}}
@props([
    'title', 
    'value', 
    'icon', 
    'trend' => null, 
    'trendDirection' => 'up',
    'iconColor' => 'accent'
])

<div class="card hover:shadow-lg transition-all duration-200 group">
    <div class="card-body">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-text-secondary mb-1">{{ $title }}</p>
                <p class="text-2xl font-bold">{{ $value }}</p>
                @if($trend)
                    <div class="flex items-center gap-1 mt-2">
                        @if($trendDirection === 'up')
                            <svg class="w-4 h-4 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-xs text-success">{{ $trend }}</span>
                        @elseif($trendDirection === 'down')
                            <svg class="w-4 h-4 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                            </svg>
                            <span class="text-xs text-error">{{ $trend }}</span>
                        @else
                            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>
                            </svg>
                            <span class="text-xs text-text-secondary">{{ $trend }}</span>
                        @endif
                        <span class="text-xs text-text-secondary">dari bulan lalu</span>
                    </div>
                @endif
            </div>
            <div class="w-12 h-12 bg-{{ $iconColor }}/10 rounded-xl flex items-center justify-center group-hover:bg-{{ $iconColor }}/20 transition-colors">
                @if($icon === 'revenue')
                    <svg class="w-6 h-6 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($icon === 'products')
                    <svg class="w-6 h-6 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                @elseif($icon === 'transactions')
                    <svg class="w-6 h-6 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                @elseif($icon === 'average')
                    <svg class="w-6 h-6 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-{{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
                    </svg>
                @endif
            </div>
        </div>
    </div>
</div>