{{-- resources/views/catalog/order/partials/status-badge.blade.php --}}
@props(['status'])

@php
    $config = [
        'completed' => [
            'class' => 'badge-success',
            'icon' => '✅',
            'text' => 'Selesai'
        ],
        'pending' => [
            'class' => 'badge-warning',
            'icon' => '⏳',
            'text' => 'Menunggu'
        ],
        'processing' => [
            'class' => 'badge-info',
            'icon' => '📦',
            'text' => 'Diproses'
        ],
        'shipped' => [
            'class' => 'badge-primary',
            'icon' => '🚚',
            'text' => 'Dikirim'
        ],
        'cancelled' => [
            'class' => 'badge-error',
            'icon' => '❌',
            'text' => 'Dibatalkan'
        ]
    ];
    
    $current = $config[$status] ?? [
        'class' => 'badge-secondary',
        'icon' => '📌',
        'text' => $status
    ];
@endphp

<span class="badge {{ $current['class'] }} flex items-center gap-1.5">
    <span>{{ $current['icon'] }}</span>
    <span>{{ $current['text'] }}</span>
</span>