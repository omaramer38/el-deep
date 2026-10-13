@extends('layouts.site')

@section('meta_title', $service->title . ' — EL DEEB ELEVATOR & BUILDING SYSTEM')
@section('meta_description', $service->description)

@section('content')
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <nav class="flex items-center gap-2 text-[11px] uppercase tracking-wider text-[#778087] mb-6">
            <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.home') }}</a>
            <span>&bull;</span>
            <a href="{{ route('site.services.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.services') }}</a>
            <span>&bull;</span>
            <span class="text-[#A99776]">{{ $service->title }}</span>
        </nav>

        <div class="max-w-3xl space-y-4">
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#F5F1E8]">
                {{ $service->title }}
            </h1>
            <p class="text-sm sm:text-base text-[#C8C0B5] font-light leading-relaxed">
                {{ $service->description }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 bg-white p-8 border border-[#C8C0B5] space-y-6">
                <div class="prose prose-sm max-w-none text-[#596269] leading-relaxed">
                    {!! clean($service->content ?? $service->description) !!}
                </div>
            </div>

            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#172A35] text-[#F5F1E8] p-8 border border-[#233642] sticky top-28 space-y-6">
                    <h3 class="text-xl font-serif font-bold">
                        {{ app()->getLocale() === 'ar' ? 'طلب هذه الخدمة' : 'Request Service Consultation' }}
                    </h3>
                    <p class="text-xs text-[#C8C0B5] leading-relaxed">
                        {{ app()->getLocale() === 'ar' ? 'تواصل مع فريق الدعم الفني لتحديد موعد المعاينة الهندسية.' : 'Get in touch with our specialized technicians to schedule a site inspection.' }}
                    </p>
                    <a href="{{ route('site.contact', ['locale' => app()->getLocale(), 'subject' => $service->title]) }}" class="block text-center bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] py-3.5 text-xs uppercase tracking-widest font-bold transition-colors">
                        {{ __('site.common.request_quote') }} &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
