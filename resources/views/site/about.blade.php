@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'عن شركة الديب — الريادة الهندسية وتاريخ الثقة' : 'About EL DEEB — Engineering Heritage & Trust')

@section('content')
@php
    $locale = app()->getLocale();
    $hero = $page?->getSectionData('hero') ?? [];
    $visionMission = $page?->getSectionData('vision_mission') ?? [];
    
    $homePage = \App\Models\Page::where('key', 'home')->first();
    $homeAboutTeaser = $homePage?->getSectionData('about_teaser') ?? [];
    $rawImg = !empty($visionMission['image']) ? $visionMission['image'] : (!empty($homeAboutTeaser['image']) ? $homeAboutTeaser['image'] : null);
    if ($rawImg) {
        if (str_contains($rawImg, '/storage/')) {
            $storagePath = 'storage/' . explode('/storage/', $rawImg)[1];
            $aboutImage = asset($storagePath);
        } else {
            $aboutImage = $rawImg;
        }
    } else {
        $aboutImage = asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg');
    }
@endphp

<!-- Hero -->
<section class="py-20 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-3xl space-y-4" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.25em] text-[#A99776] font-semibold">
                {{ $hero['eyebrow'][$locale] ?? ($locale === 'ar' ? 'عن الشركة ومسيرتنا' : 'About Our Company') }}
            </div>
            <h1 class="text-4xl sm:text-5xl font-serif font-bold leading-tight">
                {{ $hero['headline'][$locale] ?? ($locale === 'ar' ? 'نبني الثقة، ونحرك المستقبل بمعايير هندسية لا تقبل المساومة.' : 'Engineering Trust. Moving Forward with Architectural Precision.') }}
            </h1>
            <p class="text-sm sm:text-base text-[#C8C0B5] font-light leading-relaxed">
                {{ $hero['description'][$locale] ?? ($locale === 'ar' ? 'تأسست مصاعد الديب بهدف تقديم أعلى مستويات السلامة والاعتمادية في النقل الرأسي داخل مصر والشرق الأوسط.' : 'Founded to set a higher benchmark for vertical mobility, combining robust engineering with refined architectural craftsmanship.') }}
            </p>
        </div>
    </div>
</section>

<!-- Story & Heritage -->
<section class="py-20 bg-[#F5F1E8] border-b border-[#C8C0B5]/40">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6" data-reveal="fade-up">
                <h2 class="text-3xl font-serif font-bold text-[#172A35]">
                    {{ $visionMission['headline'][$locale] ?? ($locale === 'ar' ? 'رؤيتنا ورسالتنا الهندسية' : 'Our Vision & Purpose') }}
                </h2>
                <p class="text-sm text-[#596269] leading-relaxed">
                    {{ $visionMission['story'][$locale] ?? ($locale === 'ar' ? 'نؤمن في مصاعد الديب بأن المصعد ليس مجرد وسيلة نقل ميكانيكية، بل هو الشريان الحيوي للمبنى وأول انطباع يتركه المكان في نفوس زائريه. لهذا نضع الأمان والسلامة والراحة الصوتية في قمة أولوياتنا.' : 'We believe elevators are the vital pulse of any modern structure. From commercial skyscrapers to private luxury residences, our focus remains firmly on absolute safety, whisper-quiet operation, and long-term durability.') }}
                </p>
                <div class="grid grid-cols-2 gap-6 pt-4 border-t border-[#C8C0B5]/40">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-[#A99776] mb-1">
                            {{ $visionMission['vision_title'][$locale] ?? ($locale === 'ar' ? 'رؤيتنا' : 'Our Vision') }}
                        </div>
                        <p class="text-xs text-[#596269]">
                            {{ $visionMission['vision_text'][$locale] ?? ($locale === 'ar' ? 'أن نكون الشريك الهندسي الأول والموثوق لكبرى المشروعات المعمارية.' : 'To be the most trusted vertical transportation partner for ambitious architectural projects.') }}
                        </p>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-[#A99776] mb-1">
                            {{ $visionMission['mission_title'][$locale] ?? ($locale === 'ar' ? 'رسالتنا' : 'Our Mission') }}
                        </div>
                        <p class="text-xs text-[#596269]">
                            {{ $visionMission['mission_text'][$locale] ?? ($locale === 'ar' ? 'توفير أنظمة مصاعد مستدامة مدعومة بخدمات صيانة وقائية على مدار الساعة.' : 'Delivering sustainable, energy-efficient elevators backed by round-the-clock proactive maintenance.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="relative bg-[#172A35] p-4 border border-[#C8C0B5] shadow-lg" data-reveal="fade-slide">
                <img src="{{ $aboutImage }}" alt="EL DEEB Standards" class="w-full h-80 object-cover">
            </div>
        </div>
    </div>
</section>
@endsection
