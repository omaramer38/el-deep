@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل صفحة عن الشركة' : 'Edit About Page')
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل صفحة عن الشركة' : 'Edit About Page')

@section('content')
@php
    $hero = $page->getSectionData('hero');
    $visionMission = $page->getSectionData('vision_mission');
@endphp

<div class="max-w-4xl mx-auto space-y-6" x-data="{ currentLang: 'ar', activeTab: 'hero' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 border border-[#E4DFD8] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 bg-[#172A35] text-[#A99776] text-[10px] font-mono font-bold uppercase">PAGE</span>
                <h1 class="text-xl font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'محتوى صفحة عن الشركة' : 'About Us Page Editor' }}
                </h1>
            </div>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة قصة النجاح، الرؤية والرسالة، وصورة التراث الهندسي باللغتين.' : 'Manage corporate heritage, vision, mission and architectural values.' }}
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

            <a href="{{ route('site.about', ['locale' => app()->getLocale()]) }}" target="_blank" class="px-3.5 py-1.5 text-xs font-medium border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] transition-colors flex items-center gap-1">
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
            1. {{ app()->getLocale() === 'ar' ? 'الهيرو ومقدمة الصفحة' : 'Hero Section' }}
        </button>
        <button type="button" @click="activeTab = 'story'" :class="activeTab === 'story' ? 'border-[#A99776] text-[#172A35] font-bold border-b-2' : 'border-transparent text-[#778087] hover:text-[#172A35]'" class="px-4 py-2.5 text-xs uppercase tracking-wider transition-colors cursor-pointer">
            2. {{ app()->getLocale() === 'ar' ? 'الرؤية والرسالة والقصة' : 'Vision, Mission & Story' }}
        </button>
    </div>

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- TAB 1: HERO -->
        <div x-show="activeTab === 'hero'" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'قسم الهيرو ومقدمة الشركة' : 'Hero Introduction' }}
            </h2>

            <!-- AR -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الفرعي (AR)</label>
                    <input type="text" name="hero_eyebrow_ar" value="{{ old('hero_eyebrow_ar', $hero['eyebrow']['ar'] ?? 'عن الشركة ومسيرتنا') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">العنوان الرئيسي (AR) *</label>
                    <input type="text" name="hero_headline_ar" value="{{ old('hero_headline_ar', $hero['headline']['ar'] ?? 'نبني الثقة، ونحرك المستقبل بمعايير هندسية لا تقبل المساومة.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">النص التمهيدي (AR)</label>
                    <textarea name="hero_description_ar" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('hero_description_ar', $hero['description']['ar'] ?? 'تأسست مصاعد الديب بهدف تقديم أعلى مستويات السلامة والاعتمادية في النقل الرأسي داخل مصر والشرق الأوسط.') }}</textarea>
                </div>
            </div>

            <!-- EN -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Eyebrow (EN)</label>
                    <input type="text" name="hero_eyebrow_en" value="{{ old('hero_eyebrow_en', $hero['eyebrow']['en'] ?? 'About Our Company') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Headline (EN) *</label>
                    <input type="text" name="hero_headline_en" value="{{ old('hero_headline_en', $hero['headline']['en'] ?? 'Engineering Trust. Moving Forward with Architectural Precision.') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Description (EN)</label>
                    <textarea name="hero_description_en" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('hero_description_en', $hero['description']['en'] ?? 'Founded to set a higher benchmark for vertical mobility, combining robust engineering with refined architectural craftsmanship.') }}</textarea>
                </div>
            </div>
        </div>

        <!-- TAB 2: STORY, VISION & MISSION -->
        <div x-show="activeTab === 'story'" style="display: none;" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'الرؤية والرسالة والقصة الهندسية' : 'Vision, Mission & Corporate Story' }}
            </h2>

            <!-- Section Image -->
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-2">
                    {{ app()->getLocale() === 'ar' ? 'صورة القسم المعمارية (About Section Image)' : 'Section Image' }}
                </label>
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-48 h-32 bg-[#172A35] border border-[#C8C0B5] flex items-center justify-center overflow-hidden">
                        <img src="{{ $visionMission['image'] ?? asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="space-y-1">
                        <input type="file" name="about_image" accept="image/*" class="text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <p class="text-[11px] text-[#778087]">JPG, PNG, WEBP.</p>
                    </div>
                </div>
            </div>

            <!-- AR -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">عنوان القسم (AR)</label>
                    <input type="text" name="story_headline_ar" value="{{ old('story_headline_ar', $visionMission['headline']['ar'] ?? 'رؤيتنا ورسالتنا الهندسية') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">القصة والمسيرة (AR)</label>
                    <textarea name="story_text_ar" rows="4" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('story_text_ar', $visionMission['story']['ar'] ?? 'نؤمن في مصاعد الديب بأن المصعد ليس مجرد وسيلة نقل ميكانيكية، بل هو الشريان الحيوي للمبنى وأول انطباع يتركه المكان في نفوس زائريه. لهذا نضع الأمان والسلامة والراحة الصوتية في قمة أولوياتنا.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-[#172A35]">عنوان الرؤية (AR)</label>
                        <input type="text" name="vision_title_ar" value="{{ old('vision_title_ar', $visionMission['vision_title']['ar'] ?? 'رؤيتنا') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">

                        <label class="block text-xs font-semibold text-[#172A35]">نص الرؤية (AR)</label>
                        <textarea name="vision_text_ar" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('vision_text_ar', $visionMission['vision_text']['ar'] ?? 'أن نكون الشريك الهندسي الأول والموثوق لكبرى المشروعات المعمارية.') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-[#172A35]">عنوان الرسالة (AR)</label>
                        <input type="text" name="mission_title_ar" value="{{ old('mission_title_ar', $visionMission['mission_title']['ar'] ?? 'رسالتنا') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">

                        <label class="block text-xs font-semibold text-[#172A35]">نص الرسالة (AR)</label>
                        <textarea name="mission_text_ar" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('mission_text_ar', $visionMission['mission_text']['ar'] ?? 'توفير أنظمة مصاعد مستدامة مدعومة بخدمات صيانة وقائية على مدار الساعة.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- EN -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Section Headline (EN)</label>
                    <input type="text" name="story_headline_en" value="{{ old('story_headline_en', $visionMission['headline']['en'] ?? 'Our Vision & Purpose') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Story & Heritage (EN)</label>
                    <textarea name="story_text_en" rows="4" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('story_text_en', $visionMission['story']['en'] ?? 'We believe elevators are the vital pulse of any modern structure. From commercial skyscrapers to private luxury residences, our focus remains firmly on absolute safety, whisper-quiet operation, and long-term durability.') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#F0ECE1]">
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-[#172A35]">Vision Title (EN)</label>
                        <input type="text" name="vision_title_en" value="{{ old('vision_title_en', $visionMission['vision_title']['en'] ?? 'Our Vision') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">

                        <label class="block text-xs font-semibold text-[#172A35]">Vision Statement (EN)</label>
                        <textarea name="vision_text_en" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('vision_text_en', $visionMission['vision_text']['en'] ?? 'To be the most trusted vertical transportation partner for ambitious architectural projects.') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-[#172A35]">Mission Title (EN)</label>
                        <input type="text" name="mission_title_en" value="{{ old('mission_title_en', $visionMission['mission_title']['en'] ?? 'Our Mission') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">

                        <label class="block text-xs font-semibold text-[#172A35]">Mission Statement (EN)</label>
                        <textarea name="mission_text_en" rows="3" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] leading-relaxed">{{ old('mission_text_en', $visionMission['mission_text']['en'] ?? 'Delivering sustainable, energy-efficient elevators backed by round-the-clock proactive maintenance.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer Save -->
        <div class="bg-white border border-[#E4DFD8] p-4 flex items-center justify-between sticky bottom-4 z-20 shadow-lg">
            <span class="text-xs text-[#778087]">
                {{ app()->getLocale() === 'ar' ? 'تأكد من مراجعة اللغتين العربية والإنجليزية قبل الحفظ النهائي.' : 'Make sure both language tabs are reviewed before saving.' }}
            </span>

            <button type="submit" class="px-8 py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors shadow-md cursor-pointer flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'حفظ وتحديث صفحة عن الشركة' : 'Save About Page' }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
