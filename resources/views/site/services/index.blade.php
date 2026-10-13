@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'الخدمات الهندسية والصيانة — الديب للمصاعد' : 'Engineering Services & Maintenance — EL DEEB')

@section('content')
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-2xl space-y-3" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'خدمات متكاملة' : 'Lifecycle Services' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold">
                {{ app()->getLocale() === 'ar' ? 'الخدمات الهندسية الشاملة' : 'Elevator Engineering Services' }}
            </h1>
            <p class="text-xs sm:text-sm text-[#C8C0B5] font-light">
                {{ app()->getLocale() === 'ar' ? 'من التخطيط والتوريد وحتى الصيانة الوقائية والتحديث المستمر على مدار الساعة.' : 'From initial shaft engineering to 24/7 telemetry monitoring and modernization.' }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($services as $service)
                @php
                    $serviceImg = null;
                    if ($service->hasMedia('image')) {
                        $serviceImg = $service->getFirstMediaUrl('image');
                    } elseif (!empty($service->image)) {
                        $serviceImg = str_starts_with($service->image, 'http') 
                            ? $service->image 
                            : asset('storage/' . ltrim($service->image, '/'));
                    }
                @endphp
                <div class="bg-white border border-[#E4DFD8] hover:border-[#A99776] transition-all duration-300 flex flex-col justify-between group shadow-sm hover:shadow-2xl overflow-hidden" data-reveal="fade-up">
                    @if($serviceImg)
                        <div class="h-64 sm:h-72 w-full bg-[#172A35] overflow-hidden relative shrink-0">
                            <img src="{{ $serviceImg }}" alt="{{ $service->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#172A35]/60 via-transparent to-transparent"></div>
                        </div>
                    @endif

                    <div class="p-6 sm:p-8 space-y-4 flex-1 flex flex-col">
                        <div class="w-12 h-12 bg-[#172A35] text-[#A99776] group-hover:bg-[#A99776] group-hover:text-[#0F1C23] flex items-center justify-center transition-colors shrink-0 shadow-xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        </div>
                        <h2 class="text-xl font-serif font-bold text-[#172A35] group-hover:text-[#A99776] transition-colors leading-snug">
                            {{ $service->title }}
                        </h2>
                        <p class="text-xs text-[#596269] leading-relaxed flex-1">
                            {{ $service->description }}
                        </p>
                    </div>

                    <div class="px-6 sm:px-8 py-4 bg-[#FAF8F4] border-t border-[#E4DFD8] flex items-center justify-between mt-auto">
                        <a href="{{ route('site.contact', ['locale' => app()->getLocale(), 'subject' => $service->title]) }}" class="text-xs uppercase tracking-wider font-semibold text-[#172A35] group-hover:text-[#A99776] flex items-center gap-2 transition-colors">
                            <span>{{ __('site.common.request_quote') }}</span>
                            <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
