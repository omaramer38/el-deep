@props([
    'type' => 'success', // success, warning, error, info
    'title' => null,
    'message' => null,
])

@php
    $configs = [
        'success' => [
            'bar' => 'bg-[#2E6B4F]',
            'bg' => 'bg-[#EDF3EE]',
            'border' => 'border-[#D1E0D4]',
            'iconColor' => 'text-[#2E6B4F]',
            'defaultTitle' => app()->getLocale() === 'ar' ? 'تم بنجاح' : 'Success',
            'icon' => '<svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9.5"></circle><polyline points="8 12.5 11 15.5 16 9.5"></polyline></svg>',
        ],
        'warning' => [
            'bar' => 'bg-[#A97B34]',
            'bg' => 'bg-[#F7F3EB]',
            'border' => 'border-[#E5DAC8]',
            'iconColor' => 'text-[#A97B34]',
            'defaultTitle' => app()->getLocale() === 'ar' ? 'تنبيه' : 'Warning',
            'icon' => '<svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9.5"></circle><line x1="12" y1="7.5" x2="12" y2="12.5"></line><circle cx="12" cy="16" r="0.75" fill="currentColor"></circle></svg>',
        ],
        'error' => [
            'bar' => 'bg-[#A33B32]',
            'bg' => 'bg-[#F8EFEF]',
            'border' => 'border-[#E8D0CE]',
            'iconColor' => 'text-[#A33B32]',
            'defaultTitle' => app()->getLocale() === 'ar' ? 'خطأ' : 'Error',
            'icon' => '<svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9.5"></circle><line x1="12" y1="7.5" x2="12" y2="12.5"></line><circle cx="12" cy="16" r="0.75" fill="currentColor"></circle></svg>',
        ],
    ];

    $cfg = $configs[$type] ?? $configs['success'];
    $finalTitle = $title ?? $cfg['defaultTitle'];
@endphp

<div {{ $attributes->merge(['class' => 'relative flex items-center overflow-hidden border ' . $cfg['border'] . ' ' . $cfg['bg'] . ' px-5 py-4 shadow-xs']) }}>
    <!-- Leading colored vertical bar -->
    <div class="absolute inset-y-0 start-0 w-1.5 {{ $cfg['bar'] }}"></div>

    <!-- Circular Icon -->
    <div class="shrink-0 ps-1.5 pe-4 {{ $cfg['iconColor'] }}">
        {!! $cfg['icon'] !!}
    </div>

    <!-- Content Area -->
    <div class="flex-1 min-w-0">
        @if($finalTitle)
            <div class="text-sm font-bold text-[#172A35] leading-tight">
                {{ $finalTitle }}
            </div>
        @endif

        <div class="text-xs text-[#596269] mt-0.5 leading-relaxed">
            @if($message)
                {{ $message }}
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>
