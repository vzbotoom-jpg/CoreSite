{{-- resources/views/landing/components/pricing-card.blade.php --}}
@props(['name', 'price', 'period', 'features', 'recommended' => false, 'buttonText' => 'Pilih Paket', 'buttonLink' => '/register'])

<div class="card {{ $recommended ? 'border-2 border-accent shadow-lg relative' : 'hover:shadow-lg transition-shadow' }}">
    @if($recommended)
        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-accent text-white px-4 py-1 rounded-full text-sm font-medium">
            Populer
        </div>
    @endif
    <div class="card-body text-center">
        <h3 class="text-xl font-bold mb-2">{{ $name }}</h3>
        <div class="text-3xl font-bold text-accent mb-2">{{ $price }}</div>
        <p class="text-text-secondary text-sm mb-6">{{ $period }}</p>
        <ul class="space-y-3 text-left mb-8">
            @foreach($features as $feature)
                <li class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ $feature }}</span>
                </li>
            @endforeach
        </ul>
        <a href="{{ $buttonLink }}" class="{{ $recommended ? 'btn-primary' : 'btn-outline' }} w-full">
            {{ $buttonText }}
        </a>
    </div>
</div>