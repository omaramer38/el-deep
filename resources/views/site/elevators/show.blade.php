@extends('layouts.site')

@section('meta_title', $elevator->name . ' — EL DEEB ELEVATOR & BUILDING SYSTEM')
@section('meta_description', $elevator->short_description)

@section('content')
<!-- Header Hero -->
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <!-- Breadcrumbs (Section 5.1 with JSON-LD) -->
        <nav class="flex items-center gap-2 text-[11px] uppercase tracking-wider text-[#778087] mb-6">
            <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.home') }}</a>
            <span>&bull;</span>
            <a href="{{ route('site.elevators.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.elevators') }}</a>
            <span>&bull;</span>
            <span class="text-[#A99776]">{{ $elevator->name }}</span>
        </nav>

        <div class="max-w-3xl space-y-4">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ $elevator->category->name ?? 'Standard Solution' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#F5F1E8]">
                {{ $elevator->name }}
            </h1>
            <p class="text-sm sm:text-base text-[#C8C0B5] font-light leading-relaxed">
                {{ $elevator->short_description }}
            </p>
        </div>
    </div>
</section>

<!-- Product Detail Body -->
<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left 8 Cols: Overview, Image, Specs Table -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Visual Showcase -->
                <div class="bg-[#172A35] p-6 border border-[#C8C0B5] flex items-center justify-center">
                    <img src="{{ $elevator->getFirstMediaUrl('cover') ?: asset('images/brand/PN.png') }}" alt="{{ $elevator->name }}" class="max-h-96 w-auto object-contain brightness-105">
                </div>

                @if($elevator->getMedia('gallery')->count() > 0)
                    <!-- Gallery Grid -->
                    <div class="space-y-3">
                        <h3 class="text-xs uppercase tracking-wider font-bold text-[#172A35]">
                            {{ app()->getLocale() === 'ar' ? 'معرض صور المنظومة' : 'System Gallery' }}
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($elevator->getMedia('gallery') as $galleryImg)
                                <a href="{{ $galleryImg->getUrl() }}" target="_blank" class="block border border-[#C8C0B5] overflow-hidden aspect-[4/3] bg-[#172A35] hover:opacity-90">
                                    <img src="{{ $galleryImg->getUrl() }}" alt="{{ $elevator->name }}" class="w-full h-full object-cover">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                <div class="bg-white p-8 border border-[#C8C0B5] space-y-4">
                    <h2 class="text-xl font-serif font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'الوصف الهندسي والميكانيكي' : 'Engineering Overview' }}
                    </h2>
                    <div class="text-sm text-[#596269] leading-relaxed">
                        {{ $elevator->description }}
                    </div>
                </div>

                <!-- Technical Specifications Table (Section 5.4) -->
                @if(!empty($elevator->specifications))
                    <div class="bg-white p-8 border border-[#C8C0B5] space-y-6">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-[1px] bg-[#A99776]"></span>
                            <h2 class="text-lg font-serif font-bold text-[#172A35]">
                                {{ __('site.common.specifications') }}
                            </h2>
                        </div>

                        <div class="overflow-x-auto border border-[#E4DFD8]">
                            <table class="w-full text-xs text-start">
                                <tbody class="divide-y divide-[#E4DFD8]">
                                    @php
                                        $locale = app()->getLocale();
                                        $specs = is_array($elevator->specifications) ? ($elevator->specifications[$locale] ?? $elevator->specifications['en'] ?? $elevator->specifications) : [];
                                    @endphp
                                    @foreach($specs as $key => $val)
                                        <tr class="hover:bg-[#FAF8F4] transition-colors">
                                            <td class="px-5 py-3.5 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">{{ $key }}</td>
                                            <td class="px-5 py-3.5 text-[#596269]">{{ is_array($val) ? json_encode($val) : $val }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right 4 Cols: CTA & Quick Inquiry Box -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#172A35] text-[#F5F1E8] p-8 border border-[#233642] sticky top-28 space-y-6">
                    <div class="text-xs uppercase tracking-widest text-[#A99776] font-semibold">
                        {{ __('site.common.request_quote') }}
                    </div>
                    <h3 class="text-xl font-serif font-bold">
                        {{ app()->getLocale() === 'ar' ? 'طلب عرض سعر واستشارة' : 'Consultation for this System' }}
                    </h3>
                    <p class="text-xs text-[#C8C0B5] leading-relaxed">
                        {{ app()->getLocale() === 'ar' ? 'مهندسونا على استعداد لحساب الأحمال وسرعات النقل المطلوبة لمشروعك.' : 'Our engineers will calculate traffic flow, shaft requirements, and power loads for your building.' }}
                    </p>

                    <a href="{{ route('site.contact', ['locale' => app()->getLocale(), 'subject' => $elevator->name]) }}" class="block text-center bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] py-3.5 px-6 text-xs uppercase tracking-widest font-bold transition-colors">
                        {{ __('site.common.request_quote') }} &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
