@extends('layouts.admin')

@section('title', __('admin.settings'))
@section('header_title', __('admin.settings'))

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إعدادات الموقع وهوية المنظومة' : 'Website Settings & Brand Identity' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'التحكم باللوجو، ومعلومات التواصل، وساعات العمل، وعناوين الفروع، وروابط التواصل الاجتماعي.' : 'Configure company branding, logos, contact info, working hours, and social media.' }}
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Section 1: Brand & Logos -->
        <div class="bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
            <div class="border-b border-[#F0ECE1] pb-3">
                <h2 class="text-sm font-serif font-bold text-[#172A35] uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#A99776]"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'الهوية البصرية والشعارات (Logos)' : 'Brand Assets & Logos' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Header Logo -->
                <div class="p-4 bg-[#F8F9FA] border border-[#C8C0B5] space-y-3" x-data="{ preview: null }">
                    <label class="block text-xs font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'شعار الترويسة الرئيسي (Header Logo)' : 'Header Logo' }}
                    </label>

                    <div class="h-28 bg-[#172A35] flex items-center justify-center p-3 border border-[#C8C0B5] relative">
                        <template x-if="preview">
                            <img :src="preview" class="max-h-full max-w-full object-contain">
                        </template>
                        <template x-if="!preview">
                            <img src="{{ $settings['site_logo'] ?: asset('images/brand/PN 2.png') }}" class="max-h-full max-w-full object-contain">
                        </template>
                    </div>

                    <div>
                        <label class="inline-block w-full text-center px-3 py-1.5 bg-white border border-[#C8C0B5] text-[#172A35] text-xs font-semibold cursor-pointer hover:bg-[#F5F1E8]">
                            <span>{{ app()->getLocale() === 'ar' ? 'رفع شعار جديد' : 'Upload New Logo' }}</span>
                            <input type="file" name="site_logo" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Footer Dark Logo -->
                <div class="p-4 bg-[#F8F9FA] border border-[#C8C0B5] space-y-3" x-data="{ preview: null }">
                    <label class="block text-xs font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'شعار التذييل (Footer Logo)' : 'Footer Logo' }}
                    </label>

                    <div class="h-28 bg-[#0F1C23] flex items-center justify-center p-3 border border-[#C8C0B5] relative">
                        <template x-if="preview">
                            <img :src="preview" class="max-h-full max-w-full object-contain">
                        </template>
                        <template x-if="!preview">
                            <img src="{{ $settings['site_logo_dark'] ?: asset('images/brand/PN 2.png') }}" class="max-h-full max-w-full object-contain">
                        </template>
                    </div>

                    <div>
                        <label class="inline-block w-full text-center px-3 py-1.5 bg-white border border-[#C8C0B5] text-[#172A35] text-xs font-semibold cursor-pointer hover:bg-[#F5F1E8]">
                            <span>{{ app()->getLocale() === 'ar' ? 'رفع شعار التذييل' : 'Upload Footer Logo' }}</span>
                            <input type="file" name="site_logo_dark" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="p-4 bg-[#F8F9FA] border border-[#C8C0B5] space-y-3" x-data="{ preview: null }">
                    <label class="block text-xs font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'أيقونة الموقع (Favicon)' : 'Browser Favicon' }}
                    </label>

                    <div class="h-28 bg-white flex items-center justify-center p-3 border border-[#C8C0B5] relative">
                        <template x-if="preview">
                            <img :src="preview" class="w-12 h-12 object-contain">
                        </template>
                        <template x-if="!preview">
                            <img src="{{ $settings['site_favicon'] ?: asset('images/brand/PN 2.png') }}" class="w-12 h-12 object-contain">
                        </template>
                    </div>

                    <div>
                        <label class="inline-block w-full text-center px-3 py-1.5 bg-white border border-[#C8C0B5] text-[#172A35] text-xs font-semibold cursor-pointer hover:bg-[#F5F1E8]">
                            <span>{{ app()->getLocale() === 'ar' ? 'تغيير Favicon' : 'Upload Favicon' }}</span>
                            <input type="file" name="site_favicon" accept=".ico,.png,.svg" @change="preview = URL.createObjectURL($event.target.files[0])" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Bilingual Names & Slogans -->
        <div class="bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
            <div class="border-b border-[#F0ECE1] pb-3">
                <h2 class="text-sm font-serif font-bold text-[#172A35] uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#A99776]"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'اسم المنظومة والشعار اللفظي (باللغتين)' : 'Company Name & Slogan' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Arabic -->
                <div class="space-y-4" dir="rtl">
                    <span class="text-xs font-bold text-[#A99776] uppercase">المحتوى العربي 🇸🇦</span>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">اسم الشركة (عربي) *</label>
                        <input type="text" name="site_name_ar" value="{{ old('site_name_ar', $settings['site_name']['ar'] ?? '') }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">الشعار اللفظي / السلوجان (عربي)</label>
                        <input type="text" name="site_tagline_ar" value="{{ old('site_tagline_ar', $settings['site_tagline']['ar'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>

                <!-- English -->
                <div class="space-y-4" dir="ltr">
                    <span class="text-xs font-bold text-[#A99776] uppercase">English Content 🇬🇧</span>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Company Name (English) *</label>
                        <input type="text" name="site_name_en" value="{{ old('site_name_en', $settings['site_name']['en'] ?? '') }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">Tagline / Slogan (English)</label>
                        <input type="text" name="site_tagline_en" value="{{ old('site_tagline_en', $settings['site_tagline']['en'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Contact & Working Hours -->
        <div class="bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
            <div class="border-b border-[#F0ECE1] pb-3">
                <h2 class="text-sm font-serif font-bold text-[#172A35] uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#A99776]"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'معلومات التواصل وساعات العمل' : 'Contact Information & Hours' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف الرئيسي' : 'Main Phone' }}</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'رقم الواتساب' : 'WhatsApp Number' }}</label>
                    <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني الرسمي' : 'Official Email' }}</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الجغرافي (عربي)' : 'Address (Arabic)' }}</label>
                    <input type="text" name="contact_address_ar" value="{{ old('contact_address_ar', $settings['contact_address']['ar'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'العنوان الجغرافي (English)' : 'Address (English)' }}</label>
                    <input type="text" name="contact_address_en" value="{{ old('contact_address_en', $settings['contact_address']['en'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'أوقات العمل (عربي)' : 'Working Hours (Arabic)' }}</label>
                    <input type="text" name="contact_hours_ar" value="{{ old('contact_hours_ar', $settings['contact_hours']['ar'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ app()->getLocale() === 'ar' ? 'أوقات العمل (English)' : 'Working Hours (English)' }}</label>
                    <input type="text" name="contact_hours_en" value="{{ old('contact_hours_en', $settings['contact_hours']['en'] ?? '') }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>
            </div>
        </div>

        <!-- Section 4: Social Media Links -->
        <div class="bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
            <div class="border-b border-[#F0ECE1] pb-3">
                <h2 class="text-sm font-serif font-bold text-[#172A35] uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 bg-[#A99776]"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'روابط منصات التواصل الاجتماعي' : 'Social Media Channels' }}</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">LinkedIn</label>
                    <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin']) }}" placeholder="https://linkedin.com/company/eldeeb" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Facebook</label>
                    <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']) }}" placeholder="https://facebook.com/eldeeb" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">Instagram</label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/eldeeb" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">X (Twitter)</label>
                    <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter']) }}" placeholder="https://x.com/eldeeb" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">YouTube</label>
                    <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube']) }}" placeholder="https://youtube.com/@eldeeb" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>
            </div>
        </div>

        <!-- Sticky Save Bar -->
        <div class="sticky bottom-4 bg-[#172A35] p-4 text-white flex items-center justify-between shadow-2xl">
            <span class="text-xs text-[#C8C0B5]">
                {{ app()->getLocale() === 'ar' ? 'تأكد من مراجعة التعديلات قبل الحفظ النهائي.' : 'Review changes before saving.' }}
            </span>

            <button type="submit" class="px-8 py-2.5 bg-[#A99776] text-[#0F1C23] hover:bg-white text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'حفظ كافة الإعدادات' : 'Save All Settings' }}
            </button>
        </div>
    </form>
</div>
@endsection
