@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'الديب للمصاعد وأنظمة المباني — Moving People. Building Confidence.' : 'EL DEEB ELEVATOR & BUILDING SYSTEM — Moving People. Building Confidence.')

@section('content')
@php
    $locale = app()->getLocale();
    $hero = $page?->getSectionData('hero') ?? [];
    $stats = $page?->getSectionData('stats') ?? [];
    $aboutTeaser = $page?->getSectionData('about_teaser') ?? [];
    $pillars = $page?->getSectionData('pillars') ?? [];
    $cta = $page?->getSectionData('cta') ?? [];

    $statItems = $stats['items'] ?? [
        ['value' => '500+', 'label' => ['ar' => 'مشروع منجز', 'en' => 'Elevators Installed']],
        ['value' => '99.9%', 'label' => ['ar' => 'نسبة الجاهزية والتشغيل', 'en' => 'Uptime Reliability']],
        ['value' => '15+', 'label' => ['ar' => 'عاماً من الخبرة الهندسية', 'en' => 'Years Experience']],
        ['value' => '24/7', 'label' => ['ar' => 'استجابة وصيانة فورية', 'en' => 'Emergency Support']],
    ];

    $defaultPillars = [
        [
            'title' => ['ar' => 'المعايير الأوروبية EN 81-20', 'en' => 'EN 81-20/50 Certified'],
            'desc' => ['ar' => 'مطابقة كاملة لأدق مواصفات الأمان الأوروبية لمنع أي مخاطر وضمان سلامة الركاب التامة.', 'en' => 'Complete adherence to European mechanical and electrical safety codes with dual redundant failsafes.'],
        ],
        [
            'title' => ['ar' => 'كفاءة طاقة قصوى (PMSM)', 'en' => 'Green Energy (PMSM)'],
            'desc' => ['ar' => 'ماكينات لاترسية متزامنة صديقة للبيئة توفر حتى 40% من الطاقة المستهلكة بدون زيوت ملوثة.', 'en' => 'Permanent magnet gearless motors reducing building power consumption by up to 40% without grease or oil.'],
        ],
        [
            'title' => ['ar' => 'تشطيب معماري مخصص', 'en' => 'Bespoke Fabrication'],
            'desc' => ['ar' => 'تنفيذ كبائن فاخرة بمواد معمارية راقية كالرخام الطبيعي، الفولاذ المحفور، والبرونز الإيطالي.', 'en' => 'Customized architectural finishes incorporating genuine marble, etched metals, and dynamic lighting.'],
        ],
        [
            'title' => ['ar' => 'استجابة طوارئ على مدار الساعة', 'en' => '24/7 Rapid Response'],
            'desc' => ['ar' => 'فرق فنية متنقلة ومهندسو صيانة جاهزون للتدخل الفوري على مدار 24 ساعة طوال أيام الأسبوع.', 'en' => 'Dedicated technical teams equipped with real-time telemetry to guarantee uninterrupted elevator uptime.'],
        ],
    ];
    $pillarItems = $pillars['items'] ?? $defaultPillars;

    $heroCta1Url = !empty($hero['cta_primary']['url']) ? $hero['cta_primary']['url'] : route('site.elevators.index', ['locale' => $locale]);
    $heroCta1Text = $hero['cta_primary']['text'][$locale] ?? ($locale === 'ar' ? 'استكشف الحلول والمصاعد' : 'Explore Our Solutions');
    $heroCta2Url = !empty($hero['cta_secondary']['url']) ? $hero['cta_secondary']['url'] : route('site.contact', ['locale' => $locale]);
    $heroCta2Text = $hero['cta_secondary']['text'][$locale] ?? ($locale === 'ar' ? 'طلب استشارة هندسية' : 'Request Consultation');
@endphp

<!-- 1. Hero Section -->
<section class="relative min-h-[90vh] bg-[#172A35] text-[#F5F1E8] flex items-center overflow-hidden">
    <!-- Architectural Grid Background with dynamic upload or fallback -->
    <div class="absolute inset-0 opacity-25 mix-blend-luminosity bg-cover bg-center pointer-events-none" style="background-image: url('{{ $hero['bg_image'] ?? asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#172A35] via-[#172A35]/80 to-transparent"></div>

    <div class="container-custom relative z-10 py-24 lg:py-32">
        <div class="max-w-4xl space-y-8">
            <!-- Eyebrow -->
            <div data-reveal="fade-up" class="inline-flex items-center gap-3">
                <span class="w-8 h-[1px] bg-[#A99776]"></span>
                <span class="text-xs uppercase tracking-[0.25em] text-[#A99776] font-medium font-sans">
                    {{ $hero['eyebrow'][$locale] ?? ($locale === 'ar' ? 'الديب للمصاعد والأنظمة الهندسية' : 'EL DEEB ELEVATOR & BUILDING SYSTEM') }}
                </span>
            </div>

            <!-- Headline -->
            <h1 data-reveal="fade-up" data-delay="0.1" class="text-4xl sm:text-6xl lg:text-7xl font-serif font-bold tracking-tight text-[#F5F1E8] leading-[1.1]">
                {{ $hero['headline'][$locale] ?? ($locale === 'ar' ? 'تحريك الأفراد. بناء الثقة والاعتمادية.' : 'Moving People. Building Confidence.') }}
            </h1>

            <!-- Description -->
            <p data-reveal="fade-up" data-delay="0.2" class="text-base sm:text-lg text-[#C8C0B5] max-w-2xl font-light leading-relaxed">
                {{ $hero['description'][$locale] ?? ($locale === 'ar' 
                    ? 'حلول مصاعد وأنظمة مباني متطورة تجمع بين الدقة الهندسية السويسرية، وأعلى معايير السلامة الأوروبية، والأناقة المعمارية الخالدة.' 
                    : 'Premium elevator and building solutions engineered for safety, reliability, and long-term mechanical performance.') }}
            </p>

            <!-- Actions CTAs -->
            <div data-reveal="fade-up" data-delay="0.3" class="pt-4 flex flex-wrap items-center gap-4">
                <a href="{{ $heroCta1Url }}" class="inline-flex items-center gap-3 bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] px-8 py-4 text-xs uppercase tracking-widest font-semibold transition-all duration-300 shadow-xl group">
                    <span>{{ $heroCta1Text }}</span>
                    <svg class="w-4 h-4 {{ $locale === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <a href="{{ $heroCta2Url }}" class="inline-flex items-center gap-2 border border-[#C8C0B5]/40 hover:border-[#F5F1E8] text-[#F5F1E8] px-8 py-4 text-xs uppercase tracking-widest font-semibold transition-all duration-300">
                    <span>{{ $heroCta2Text }}</span>
                </a>
            </div>

            <!-- Stats Bar -->
            <div data-reveal="fade-up" data-delay="0.4" class="pt-12 grid grid-cols-2 sm:grid-cols-4 gap-8 border-t border-[#233642]">
                @foreach($statItems as $stat)
                    <div>
                        <div class="text-3xl lg:text-4xl font-serif font-bold text-[#A99776] tabular-nums">
                            {{ $stat['value'] ?? '—' }}
                        </div>
                        <div class="text-[11px] uppercase tracking-wider text-[#C8C0B5] mt-1">
                            {{ $stat['label'][$locale] ?? ($stat['label']['ar'] ?? '') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- 2. About Teaser Section -->
<section class="py-24 bg-[#F5F1E8] border-b border-[#C8C0B5]/40">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6" data-reveal="fade-up">
                <div class="inline-flex items-center gap-3">
                    <span class="w-8 h-[1px] bg-[#A99776]"></span>
                    <span class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                        {{ $aboutTeaser['eyebrow'][$locale] ?? ($locale === 'ar' ? 'الهندسة والريادة' : 'Architectural Engineering') }}
                    </span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-[#172A35] leading-tight">
                    {{ $aboutTeaser['headline'][$locale] ?? ($locale === 'ar' ? 'أكثر من مجرد مصعد. معايير هندسية ترتقي بالمكان.' : 'More Than an Elevator. A Higher Standard in Every Space.') }}
                </h2>
                <p class="text-sm text-[#596269] leading-relaxed">
                    {{ $aboutTeaser['description'][$locale] ?? ($locale === 'ar'
                        ? 'في مصاعد الديب، لا نكتفي بتركيب المعدات، بل نتولى مسؤولية مستمرة تمتد لعقود. نبتكر حلولاً رأسية متكاملة تمنح المبنى هيبته، وتضمن لشاغليه حركة انسيابية هادئة بأعلى معايير الأمان العالمية EN 81-20.'
                        : 'At EL DEEB, we don’t just install elevators; we stay accountable. We engineer seamless vertical systems that harmonize with architectural ambition while maintaining uncompromising mechanical safety and longevity.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('site.about', ['locale' => $locale]) }}" class="inline-flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-[#172A35] hover:text-[#A99776] border-b-2 border-[#172A35] hover:border-[#A99776] pb-1 transition-all">
                        <span>{{ __('site.common.learn_more') }}</span>
                        <svg class="w-4 h-4 {{ $locale === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6" data-reveal="fade-slide">
                @php
                    $rawHomeAboutImg = !empty($aboutTeaser['image']) ? $aboutTeaser['image'] : null;
                    if ($rawHomeAboutImg && str_contains($rawHomeAboutImg, '/storage/')) {
                        $homeAboutImg = asset('storage/' . explode('/storage/', $rawHomeAboutImg)[1]);
                    } else {
                        $homeAboutImg = $rawHomeAboutImg ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg');
                    }
                @endphp
                <div class="relative bg-[#172A35] p-4 border border-[#C8C0B5] shadow-xl">
                    <img src="{{ $homeAboutImg }}" alt="EL DEEB Engineering" class="w-full h-80 object-cover">
                    <div class="p-6 bg-[#172A35] text-[#F5F1E8]">
                        <div class="text-xs uppercase tracking-widest text-[#A99776]">
                            {{ $aboutTeaser['badge_title'][$locale] ?? 'Quality In Every Detail' }}
                        </div>
                        <div class="text-sm text-[#C8C0B5] mt-1 font-light">
                            {{ $aboutTeaser['badge_subtitle'][$locale] ?? ($locale === 'ar' ? 'دقة الصنع، متانة الخامات، وسكون الحركة.' : 'Engineered for a higher standard.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3. Featured Elevators / Solutions Preview -->
<section class="py-24 bg-[#FAF8F4] border-b border-[#C8C0B5]/40">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16" data-reveal="fade-up">
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold mb-2">
                    {{ __('site.common.explore') }}
                </div>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-[#172A35]">
                    {{ $locale === 'ar' ? 'حلول المصاعد المتقدمة' : 'Engineered Elevator Solutions' }}
                </h2>
            </div>
            <a href="{{ route('site.elevators.index', ['locale' => $locale]) }}" class="text-xs uppercase tracking-widest font-semibold text-[#172A35] hover:text-[#A99776] border-b border-[#172A35] hover:border-[#A99776] pb-1 transition-all">
                {{ $locale === 'ar' ? 'عرض كافة الحلول' : 'View All Systems' }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredElevators as $elevator)
                <div data-reveal="fade-up">
                    <x-ui.product-card
                        :title="$elevator->name"
                        :category="$elevator->category->name ?? 'Elevator'"
                        :description="$elevator->short_description"
                        :image="$elevator->getFirstMediaUrl('cover') ?: asset('images/brand/PN 3.png')"
                        :url="route('site.elevators.show', ['locale' => $locale, 'slug' => $elevator->slug])"
                    />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 4. Featured Projects Showcase -->
<section class="py-24 bg-[#172A35] text-[#F5F1E8]">
    <div class="container-custom">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16" data-reveal="fade-up">
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold mb-2">
                    {{ $locale === 'ar' ? 'سجل الإنجازات' : 'Architectural Portfolio' }}
                </div>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-[#F5F1E8]">
                    {{ $locale === 'ar' ? 'مشروعات هندسية رائدة' : 'Featured Installations' }}
                </h2>
            </div>
            <a href="{{ route('site.projects.index', ['locale' => $locale]) }}" class="text-xs uppercase tracking-widest font-semibold text-[#C8C0B5] hover:text-[#A99776] border-b border-[#C8C0B5] hover:border-[#A99776] pb-1 transition-all">
                {{ $locale === 'ar' ? 'استعراض كل المشروعات' : 'Browse All Projects' }} &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredProjects as $project)
                <div data-reveal="fade-up">
                    <x-ui.product-card
                        :title="$project->title"
                        :category="$project->category->name ?? 'Commercial'"
                        :meta="$project->location . ' • ' . $project->year . ' (' . $project->elevators_count . ' ' . __('site.common.elevators_count') . ')'"
                        :description="$project->short_description"
                        :image="$project->getFirstMediaUrl('cover') ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg')"
                        :url="route('site.projects.show', ['locale' => $locale, 'slug' => $project->slug])"
                    />
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. Engineering & Safety Pillars -->
<section class="py-24 bg-[#F5F1E8] border-b border-[#C8C0B5]/40">
    <div class="container-custom">
        <div class="text-center max-w-2xl mx-auto mb-16" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold mb-2">
                {{ $locale === 'ar' ? 'لماذا مصاعد الديب؟' : 'Why EL DEEB' }}
            </div>
            <h2 class="text-3xl sm:text-4xl font-serif font-bold text-[#172A35]">
                {{ $locale === 'ar' ? 'الهندسة، الأمان، والمسؤولية المستمرة' : 'Engineered for Performance & Uncompromised Safety' }}
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($pillarItems as $index => $pillar)
                <div class="p-8 bg-white border border-[#C8C0B5]/60 hover:border-[#A99776] transition-colors" data-reveal="fade-up" data-delay="{{ $index * 0.1 }}">
                    <div class="w-12 h-12 bg-[#172A35] text-[#A99776] flex items-center justify-center mb-6">
                        @if($index === 0)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        @elseif($index === 1)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        @elseif($index === 2)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-base font-serif font-bold text-[#172A35] mb-2">
                        {{ $pillar['title'][$locale] ?? ($pillar['title']['ar'] ?? '') }}
                    </h3>
                    <p class="text-xs text-[#596269] leading-relaxed">
                        {{ $pillar['desc'][$locale] ?? ($pillar['desc']['ar'] ?? '') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 6. Partners Strip -->
<section class="py-16 bg-[#FAF8F4] border-b border-[#C8C0B5]/40">
    <div class="container-custom">
        <div class="text-center mb-8">
            <span class="text-xs uppercase tracking-[0.2em] text-[#778087] font-semibold">
                {{ $locale === 'ar' ? 'شركاء النجاح وكبرى شركات التطوير' : 'Trusted by Leading Developers' }}
            </span>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-8 md:gap-16">
            @foreach($partners as $partner)
                <div class="flex items-center justify-center grayscale hover:grayscale-0 transition-all opacity-75 hover:opacity-100">
                    @if($partner->logo)
                        @if($partner->url)
                            <a href="{{ $partner->url }}" target="_blank" rel="noopener">
                                <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="h-10 max-w-[140px] object-contain">
                            </a>
                        @else
                            <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="h-10 max-w-[140px] object-contain">
                        @endif
                    @else
                        <span class="text-sm font-serif font-bold uppercase tracking-wider text-[#596269] hover:text-[#172A35] transition-colors">
                            {{ $partner->name }}
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 7. Global CTA Band -->
@php
    $ctaUrl = !empty($cta['btn_url']) ? $cta['btn_url'] : route('site.contact', ['locale' => $locale]);
    $ctaText = $cta['btn_text'][$locale] ?? __('site.nav.consultation');
@endphp
<section class="py-20 bg-[#172A35] text-[#F5F1E8] relative overflow-hidden">
    <div class="container-custom relative z-10 text-center max-w-3xl mx-auto space-y-6">
        <div class="text-xs uppercase tracking-[0.25em] text-[#A99776] font-semibold">
            {{ $cta['eyebrow'][$locale] ?? ($locale === 'ar' ? 'ارتقِ بمشروعك القادم' : 'Elevate Your Next Project') }}
        </div>
        <h2 class="text-3xl sm:text-5xl font-serif font-bold text-[#F5F1E8]">
            {{ $cta['headline'][$locale] ?? ($locale === 'ar' ? 'جاهزون لمناقشة المتطلبات الهندسية لمشروعك' : 'Ready to Engineer Your Vertical Transportation?') }}
        </h2>
        <p class="text-sm text-[#C8C0B5] font-light leading-relaxed">
            {{ $cta['description'][$locale] ?? ($locale === 'ar' ? 'تواصل مع فريقنا الاستشاري اليوم للحصول على دراسة فنية وعرض سعر مخصص.' : 'Contact our specialized engineering team today for technical consultation and customized quotation.') }}
        </p>
        <div class="pt-4">
            <a href="{{ $ctaUrl }}" class="inline-flex items-center gap-2 bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] px-8 py-4 text-xs uppercase tracking-widest font-semibold transition-all shadow-xl">
                <span>{{ $ctaText }}</span>
                <svg class="w-4 h-4 {{ $locale === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection
