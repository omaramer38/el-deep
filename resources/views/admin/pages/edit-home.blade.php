@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل الصفحة الرئيسية' : 'Edit Home Page')
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل الصفحة الرئيسية' : 'Edit Home Page')

@section('content')
@php
    $hero = $page->getSectionData('hero');
    $stats = $page->getSectionData('stats');
    $aboutTeaser = $page->getSectionData('about_teaser');
    $pillars = $page->getSectionData('pillars');
    $cta = $page->getSectionData('cta');
@endphp

<div class="max-w-5xl mx-auto space-y-6" x-data="{ currentLang: 'ar', activeTab: 'hero' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 border border-[#E4DFD8] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 bg-[#172A35] text-[#A99776] text-[10px] font-mono font-bold uppercase">PAGE</span>
                <h1 class="text-xl font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'محتوى الصفحة الرئيسية' : 'Home Page Editor' }}
                </h1>
            </div>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تحكم كامل في نصوص، صور، وإحصائيات الواجهة الأمامية للموقع.' : 'Manage all banners, stats, texts and promotional blocks.' }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Language Switcher -->
            <div class="flex items-center gap-1 bg-[#F8F9FA] p-1 border border-[#E4DFD8]">
                <button type="button" @click="currentLang = 'ar'" :class="currentLang === 'ar' ? 'bg-[#172A35] text-white' : 'text-[#596269] hover:text-[#172A35]'" class="px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer">
                    العربية (AR)
                </button>
                <button type="button" @click="currentLang = 'en'" :class="currentLang === 'en' ? 'bg-[#172A35] text-white' : 'text-[#596269] hover:text-[#172A35]'" class="px-3 py-1.5 text-xs font-semibold transition-colors cursor-pointer">
                    English (EN)
                </button>
            </div>

            <a href="{{ url('/') }}" target="_blank" class="px-3.5 py-1.5 text-xs font-medium border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] transition-colors flex items-center gap-1">
                <span>{{ app()->getLocale() === 'ar' ? 'معاينة' : 'Preview' }}</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Section Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E4DFD8] bg-white px-4 pt-2">
        <button type="button" @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            1. {{ app()->getLocale() === 'ar' ? 'الهيرو الرئيسي' : 'Hero Banner' }}
        </button>
        <button type="button" @click="activeTab = 'stats'" :class="activeTab === 'stats' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            2. {{ app()->getLocale() === 'ar' ? 'شريط الإحصائيات' : 'Stats Bar' }}
        </button>
        <button type="button" @click="activeTab = 'about'" :class="activeTab === 'about' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            3. {{ app()->getLocale() === 'ar' ? 'نبذة التميز' : 'About Teaser' }}
        </button>
        <button type="button" @click="activeTab = 'pillars'" :class="activeTab === 'pillars' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            4. {{ app()->getLocale() === 'ar' ? 'ركائز الأمان' : 'Pillars & Safety' }}
        </button>
        <button type="button" @click="activeTab = 'cta'" :class="activeTab === 'cta' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            5. {{ app()->getLocale() === 'ar' ? 'الدعوة لطلب السعر' : 'Global CTA' }}
        </button>
    </div>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- TAB 1: HERO -->
        <div x-show="activeTab === 'hero'" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'قسم الهيرو والواجهة الرئيسية (Hero Section)' : 'Hero Banner Section' }}
            </h2>

            <!-- Hero Background Image -->
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-2">
                    {{ app()->getLocale() === 'ar' ? 'صورة خلفية الهيرو الترويجية (Hero Background Image)' : 'Hero Background Image' }}
                </label>
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-48 h-28 bg-[#172A35] border border-[#C8C0B5] flex items-center justify-center overflow-hidden">
                        <img src="{{ $hero['bg_image'] ?? asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-1">
                        <input type="file" name="hero_bg_image" accept="image/*" class="text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <p class="text-[11px] text-[#778087]">JPG, PNG, WEBP (يفضل دقة عالية 1920x1080 بكسل).</p>
                    </div>
                </div>
            </div>

            <!-- Hero AR -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الفرعي الصغير (Eyebrow - AR)</label>
                    <input type="text" name="hero_eyebrow_ar" value="{{ old('hero_eyebrow_ar', $hero['eyebrow']['ar'] ?? 'الديب للمصاعد والأنظمة الهندسية') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الرئيسي الكبير (Headline - AR) *</label>
                    <input type="text" name="hero_headline_ar" value="{{ old('hero_headline_ar', $hero['headline']['ar'] ?? 'تحريك الأفراد. بناء الثقة والاعتمادية.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">النص الوصفي التعريفي (Description - AR)</label>
                    <textarea name="hero_description_ar" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('hero_description_ar', $hero['description']['ar'] ?? 'حلول مصاعد وأنظمة مباني متطورة تجمع بين الدقة الهندسية السويسرية، وأعلى معايير السلامة الأوروبية، والأناقة المعمارية الخالدة.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">نص الزر الأساسي (AR)</label>
                        <input type="text" name="hero_cta1_text_ar" value="{{ old('hero_cta1_text_ar', $hero['cta_primary']['text']['ar'] ?? 'استكشف الحلول والمصاعد') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">نص الزر الثانوي (AR)</label>
                        <input type="text" name="hero_cta2_text_ar" value="{{ old('hero_cta2_text_ar', $hero['cta_secondary']['text']['ar'] ?? 'طلب استشارة هندسية') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>
            </div>

            <!-- Hero EN -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Eyebrow (EN)</label>
                    <input type="text" name="hero_eyebrow_en" value="{{ old('hero_eyebrow_en', $hero['eyebrow']['en'] ?? 'EL DEEB ELEVATOR & BUILDING SYSTEM') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Headline (EN) *</label>
                    <input type="text" name="hero_headline_en" value="{{ old('hero_headline_en', $hero['headline']['en'] ?? 'Moving People. Building Confidence.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Description (EN)</label>
                    <textarea name="hero_description_en" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('hero_description_en', $hero['description']['en'] ?? 'Premium elevator and building solutions engineered for safety, reliability, and long-term mechanical performance.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Primary CTA Text (EN)</label>
                        <input type="text" name="hero_cta1_text_en" value="{{ old('hero_cta1_text_en', $hero['cta_primary']['text']['en'] ?? 'Explore Our Solutions') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Secondary CTA Text (EN)</label>
                        <input type="text" name="hero_cta2_text_en" value="{{ old('hero_cta2_text_en', $hero['cta_secondary']['text']['en'] ?? 'Request Consultation') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>
            </div>

            <!-- Button URLs (Language Agnostic) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">رابط الزر الأول (Primary URL)</label>
                    <input type="text" name="hero_cta1_url" value="{{ old('hero_cta1_url', $hero['cta_primary']['url'] ?? '') }}" placeholder="/elevators (أو اتركه فارغاً للافتراضي)" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">رابط الزر الثاني (Secondary URL)</label>
                    <input type="text" name="hero_cta2_url" value="{{ old('hero_cta2_url', $hero['cta_secondary']['url'] ?? '') }}" placeholder="/contact (أو اتركه فارغاً للافتراضي)" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>
            </div>
        </div>

        <!-- TAB 2: STATS BAR -->
        <div x-show="activeTab === 'stats'" style="display: none;" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'شريط الأرقام والإحصائيات (Stats Bar)' : 'Stats Bar Metrics' }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">المعيار الأول #1</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الرقم / القيمة *</label>
                        <input type="text" name="stat_1_value" value="{{ old('stat_1_value', $stats['items'][0]['value'] ?? '500+') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5] font-bold text-[#A99776]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">التسمية (AR)</label>
                        <input type="text" name="stat_1_label_ar" value="{{ old('stat_1_label_ar', $stats['items'][0]['label']['ar'] ?? 'مشروع منجز') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Label (EN)</label>
                        <input type="text" name="stat_1_label_en" value="{{ old('stat_1_label_en', $stats['items'][0]['label']['en'] ?? 'Elevators Installed') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">المعيار الثاني #2</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الرقم / القيمة *</label>
                        <input type="text" name="stat_2_value" value="{{ old('stat_2_value', $stats['items'][1]['value'] ?? '99.9%') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5] font-bold text-[#A99776]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">التسمية (AR)</label>
                        <input type="text" name="stat_2_label_ar" value="{{ old('stat_2_label_ar', $stats['items'][1]['label']['ar'] ?? 'نسبة الجاهزية والتشغيل') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Label (EN)</label>
                        <input type="text" name="stat_2_label_en" value="{{ old('stat_2_label_en', $stats['items'][1]['label']['en'] ?? 'Uptime Reliability') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">المعيار الثالث #3</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الرقم / القيمة *</label>
                        <input type="text" name="stat_3_value" value="{{ old('stat_3_value', $stats['items'][2]['value'] ?? '15+') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5] font-bold text-[#A99776]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">التسمية (AR)</label>
                        <input type="text" name="stat_3_label_ar" value="{{ old('stat_3_label_ar', $stats['items'][2]['label']['ar'] ?? 'عاماً من الخبرة الهندسية') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Label (EN)</label>
                        <input type="text" name="stat_3_label_en" value="{{ old('stat_3_label_en', $stats['items'][2]['label']['en'] ?? 'Years Experience') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">المعيار الرابع #4</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الرقم / القيمة *</label>
                        <input type="text" name="stat_4_value" value="{{ old('stat_4_value', $stats['items'][3]['value'] ?? '24/7') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5] font-bold text-[#A99776]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">التسمية (AR)</label>
                        <input type="text" name="stat_4_label_ar" value="{{ old('stat_4_label_ar', $stats['items'][3]['label']['ar'] ?? 'استجابة وصيانة فورية') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Label (EN)</label>
                        <input type="text" name="stat_4_label_en" value="{{ old('stat_4_label_en', $stats['items'][3]['label']['en'] ?? 'Emergency Support') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: ABOUT TEASER -->
        <div x-show="activeTab === 'about'" style="display: none;" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'نبذة عن التميز الهندسي (About Teaser)' : 'About Teaser Section' }}
            </h2>

            <!-- Teaser Image -->
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-2">
                    {{ app()->getLocale() === 'ar' ? 'صورة القسم المعمارية (Section Image)' : 'Section Image' }}
                </label>
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-48 h-32 bg-[#172A35] border border-[#C8C0B5] flex items-center justify-center overflow-hidden">
                        <img src="{{ $aboutTeaser['image'] ?? asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-1">
                        <input type="file" name="about_image" accept="image/*" class="text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <p class="text-[11px] text-[#778087]">JPG, PNG, WEBP.</p>
                    </div>
                </div>
            </div>

            <!-- About Teaser AR -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الفرعي (AR)</label>
                    <input type="text" name="about_eyebrow_ar" value="{{ old('about_eyebrow_ar', $aboutTeaser['eyebrow']['ar'] ?? 'الهندسة والريادة') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الرئيسي (AR)</label>
                    <input type="text" name="about_headline_ar" value="{{ old('about_headline_ar', $aboutTeaser['headline']['ar'] ?? 'أكثر من مجرد مصعد. معايير هندسية ترتقي بالمكان.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">النص التعريفي (AR)</label>
                    <textarea name="about_description_ar" rows="4" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('about_description_ar', $aboutTeaser['description']['ar'] ?? 'في مصاعد الديب، لا نكتفي بتركيب المعدات، بل نتولى مسؤولية مستمرة تمتد لعقود. نبتكر حلولاً رأسية متكاملة تمنح المبنى هيبته، وتضمن لشاغليه حركة انسيابية هادئة بأعلى معايير الأمان العالمية EN 81-20.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">عنوان شارة الصورة (AR)</label>
                        <input type="text" name="about_badge_title_ar" value="{{ old('about_badge_title_ar', $aboutTeaser['badge_title']['ar'] ?? 'Quality In Every Detail') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">وصف شارة الصورة (AR)</label>
                        <input type="text" name="about_badge_subtitle_ar" value="{{ old('about_badge_subtitle_ar', $aboutTeaser['badge_subtitle']['ar'] ?? 'دقة الصنع، متانة الخامات، وسكون الحركة.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>
            </div>

            <!-- About Teaser EN -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Eyebrow (EN)</label>
                    <input type="text" name="about_eyebrow_en" value="{{ old('about_eyebrow_en', $aboutTeaser['eyebrow']['en'] ?? 'Architectural Engineering') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Headline (EN)</label>
                    <input type="text" name="about_headline_en" value="{{ old('about_headline_en', $aboutTeaser['headline']['en'] ?? 'More Than an Elevator. A Higher Standard in Every Space.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Description (EN)</label>
                    <textarea name="about_description_en" rows="4" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('about_description_en', $aboutTeaser['description']['en'] ?? 'At EL DEEB, we don’t just install elevators; we stay accountable. We engineer seamless vertical systems that harmonize with architectural ambition while maintaining uncompromising mechanical safety and longevity.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Badge Title (EN)</label>
                        <input type="text" name="about_badge_title_en" value="{{ old('about_badge_title_en', $aboutTeaser['badge_title']['en'] ?? 'Quality In Every Detail') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Badge Subtitle (EN)</label>
                        <input type="text" name="about_badge_subtitle_en" value="{{ old('about_badge_subtitle_en', $aboutTeaser['badge_subtitle']['en'] ?? 'Engineered for a higher standard.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: PILLARS & SAFETY -->
        <div x-show="activeTab === 'pillars'" style="display: none;" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'ركائز الأمان والهندسة الأربعة (Engineering & Safety Pillars)' : 'Engineering & Safety Pillars' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pillar 1 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">الركيزة الأولى #1 (المعايير الأوروبية)</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">العنوان (AR)</label>
                        <input type="text" name="pillar_1_title_ar" value="{{ old('pillar_1_title_ar', $pillars['items'][0]['title']['ar'] ?? 'المعايير الأوروبية EN 81-20') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Title (EN)</label>
                        <input type="text" name="pillar_1_title_en" value="{{ old('pillar_1_title_en', $pillars['items'][0]['title']['en'] ?? 'EN 81-20/50 Certified') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الوصف (AR)</label>
                        <textarea name="pillar_1_desc_ar" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_1_desc_ar', $pillars['items'][0]['desc']['ar'] ?? 'مطابقة كاملة لأدق مواصفات الأمان الأوروبية لمنع أي مخاطر وضمان سلامة الركاب التامة.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Description (EN)</label>
                        <textarea name="pillar_1_desc_en" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_1_desc_en', $pillars['items'][0]['desc']['en'] ?? 'Complete adherence to European mechanical and electrical safety codes with dual redundant failsafes.') }}</textarea>
                    </div>
                </div>

                <!-- Pillar 2 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">الركيزة الثانية #2 (كفاءة الطاقة)</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">العنوان (AR)</label>
                        <input type="text" name="pillar_2_title_ar" value="{{ old('pillar_2_title_ar', $pillars['items'][1]['title']['ar'] ?? 'كفاءة طاقة قصوى (PMSM)') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Title (EN)</label>
                        <input type="text" name="pillar_2_title_en" value="{{ old('pillar_2_title_en', $pillars['items'][1]['title']['en'] ?? 'Green Energy (PMSM)') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الوصف (AR)</label>
                        <textarea name="pillar_2_desc_ar" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_2_desc_ar', $pillars['items'][1]['desc']['ar'] ?? 'ماكينات لاترسية متزامنة صديقة للبيئة توفر حتى 40% من الطاقة المستهلكة بدون زيوت ملوثة.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Description (EN)</label>
                        <textarea name="pillar_2_desc_en" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_2_desc_en', $pillars['items'][1]['desc']['en'] ?? 'Permanent magnet gearless motors reducing building power consumption by up to 40% without grease or oil.') }}</textarea>
                    </div>
                </div>

                <!-- Pillar 3 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">الركيزة الثالثة #3 (التشطيب المعماري)</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">العنوان (AR)</label>
                        <input type="text" name="pillar_3_title_ar" value="{{ old('pillar_3_title_ar', $pillars['items'][2]['title']['ar'] ?? 'تشطيب معماري مخصص') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Title (EN)</label>
                        <input type="text" name="pillar_3_title_en" value="{{ old('pillar_3_title_en', $pillars['items'][2]['title']['en'] ?? 'Bespoke Fabrication') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الوصف (AR)</label>
                        <textarea name="pillar_3_desc_ar" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_3_desc_ar', $pillars['items'][2]['desc']['ar'] ?? 'تنفيذ كبائن فاخرة بمواد معمارية راقية كالرخام الطبيعي، الفولاذ المحفور، والبرونز الإيطالي.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Description (EN)</label>
                        <textarea name="pillar_3_desc_en" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_3_desc_en', $pillars['items'][2]['desc']['en'] ?? 'Customized architectural finishes incorporating genuine marble, etched metals, and dynamic lighting.') }}</textarea>
                    </div>
                </div>

                <!-- Pillar 4 -->
                <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
                    <span class="text-[10px] font-bold text-[#A99776] uppercase">الركيزة الرابعة #4 (طوارئ على مدار الساعة)</span>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">العنوان (AR)</label>
                        <input type="text" name="pillar_4_title_ar" value="{{ old('pillar_4_title_ar', $pillars['items'][3]['title']['ar'] ?? 'استجابة طوارئ على مدار الساعة') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Title (EN)</label>
                        <input type="text" name="pillar_4_title_en" value="{{ old('pillar_4_title_en', $pillars['items'][3]['title']['en'] ?? '24/7 Rapid Response') }}" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">الوصف (AR)</label>
                        <textarea name="pillar_4_desc_ar" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_4_desc_ar', $pillars['items'][3]['desc']['ar'] ?? 'فرق فنية متنقلة ومهندسو صيانة جاهزون للتدخل الفوري على مدار 24 ساعة طوال أيام الأسبوع.') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[#172A35] mb-1">Description (EN)</label>
                        <textarea name="pillar_4_desc_en" rows="2" class="w-full text-xs px-3 py-1.5 bg-white border border-[#C8C0B5]">{{ old('pillar_4_desc_en', $pillars['items'][3]['desc']['en'] ?? 'Dedicated technical teams equipped with real-time telemetry to guarantee uninterrupted elevator uptime.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 5: GLOBAL CTA -->
        <div x-show="activeTab === 'cta'" style="display: none;" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'شريط الدعوة لطلب السعر والاستشارة (Global CTA)' : 'Global Call To Action' }}
            </h2>

            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الفرعي (AR)</label>
                    <input type="text" name="cta_eyebrow_ar" value="{{ old('cta_eyebrow_ar', $cta['eyebrow']['ar'] ?? 'ارتقِ بمشروعك القادم') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الرئيسي (AR)</label>
                    <input type="text" name="cta_headline_ar" value="{{ old('cta_headline_ar', $cta['headline']['ar'] ?? 'جاهزون لمناقشة المتطلبات الهندسية لمشروعك') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">النص الوصفي (AR)</label>
                    <textarea name="cta_description_ar" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">{{ old('cta_description_ar', $cta['description']['ar'] ?? 'تواصل مع فريقنا الاستشاري اليوم للحصول على دراسة فنية وعرض سعر مخصص.') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">نص الزر (AR)</label>
                    <input type="text" name="cta_btn_text_ar" value="{{ old('cta_btn_text_ar', $cta['btn_text']['ar'] ?? 'طلب استشارة هندسية') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>
            </div>

            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Eyebrow (EN)</label>
                    <input type="text" name="cta_eyebrow_en" value="{{ old('cta_eyebrow_en', $cta['eyebrow']['en'] ?? 'Elevate Your Next Project') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Headline (EN)</label>
                    <input type="text" name="cta_headline_en" value="{{ old('cta_headline_en', $cta['headline']['en'] ?? 'Ready to Engineer Your Vertical Transportation?') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Description (EN)</label>
                    <textarea name="cta_description_en" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">{{ old('cta_description_en', $cta['description']['en'] ?? 'Contact our specialized engineering team today for technical consultation and customized quotation.') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Button Text (EN)</label>
                    <input type="text" name="cta_btn_text_en" value="{{ old('cta_btn_text_en', $cta['btn_text']['en'] ?? 'Request Consultation') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>
            </div>

            <div class="pt-2 border-t border-[#F0ECE1]">
                <label class="block text-xs font-semibold text-[#172A35] mb-1">رابط الزر (Button URL)</label>
                <input type="text" name="cta_btn_url" value="{{ old('cta_btn_url', $cta['btn_url'] ?? '') }}" placeholder="/contact (أو اتركه فارغاً للافتراضي)" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
            </div>
        </div>

        <!-- Sticky Footer Save -->
        <div class="bg-white border border-[#E4DFD8] p-4 flex items-center justify-between sticky bottom-4 z-20 shadow-lg">
            <span class="text-xs text-[#778087]">
                {{ app()->getLocale() === 'ar' ? 'تأكد من مراجعة اللغتين العربية والإنجليزية قبل الحفظ النهائي.' : 'Make sure both language tabs are reviewed before saving.' }}
            </span>

            <button type="submit" class="px-8 py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors shadow-md cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'حفظ وتحديث الصفحة الرئيسية' : 'Save Home Page' }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
