{{-- resources/views/catalog/order/partials/timeline.blade.php --}}
@props(['steps' => []])

<div class="relative">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-0">
        @foreach($steps as $index => $step)
            <div class="flex items-center gap-4 md:gap-0">
                <div class="flex flex-col items-center">
                    <div class="relative">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-2xl border-2 transition-all duration-500"
                             :class="'{{ $step['status'] }}' === 'completed' ? 'bg-accent text-white border-accent' :
                                     '{{ $step['status'] }}' === 'active' ? 'bg-accent/20 text-accent border-accent animate-pulse' :
                                     'bg-light-surface dark:bg-dark-surface text-text-secondary border-light-border/40 dark:border-dark-border/40'">
                            <span>{{ $step['icon'] }}</span>
                        </div>
                        @if($step['status'] === 'completed')
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-accent rounded-full flex items-center justify-center text-white text-xs">
                                ✓
                            </div>
                        @endif
                    </div>
                    <div class="mt-2 text-center max-w-[80px]">
                        <p class="text-xs font-medium" 
                           :class="'{{ $step['status'] }}' === 'completed' ? 'text-accent' : '{{ $step['status'] }}' === 'active' ? 'text-text-primary dark:text-text-dark-primary' : 'text-text-secondary'">
                            {{ $step['label'] }}
                        </p>
                        <p class="text-[10px] text-text-secondary mt-0.5" x-text="{{ $step['time'] }}"></p>
                    </div>
                </div>
                @if($index < count($steps) - 1)
                    <div class="hidden md:block flex-1 h-0.5 min-w-[40px]"
                         :class="'{{ $step['status'] }}' === 'completed' ? 'bg-accent' : '{{ $step['status'] }}' === 'active' ? 'bg-accent/50' : 'bg-light-border/40 dark:bg-dark-border/40'">
                    </div>
                    <div class="block md:hidden w-0.5 h-8 ml-7"
                         :class="'{{ $step['status'] }}' === 'completed' ? 'bg-accent' : '{{ $step['status'] }}' === 'active' ? 'bg-accent/50' : 'bg-light-border/40 dark:bg-dark-border/40'">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>