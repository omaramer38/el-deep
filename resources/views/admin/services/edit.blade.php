@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل الخدمة: ' . $service->getTranslation('title', 'ar') : 'Edit Service: ' . $service->getTranslation('title', 'en'))
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل الخدمة' : 'Edit Service')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تعديل بيانات الخدمة' : 'Edit Service Details' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ $service->getTranslation('title', 'ar') }} &bull; {{ $service->getTranslation('title', 'en') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            @php
                $viewLocale = in_array(app()->getLocale(), ['ar', 'en']) ? app()->getLocale() : 'ar';
                $serviceSlug = $service->getTranslation('slug', $viewLocale) 
                    ?: $service->getTranslation('slug', 'ar') 
                    ?: $service->getTranslation('slug', 'en') 
                    ?: (string)$service->id;
            @endphp
            <a 
                href="{{ route('site.services.show', ['locale' => $viewLocale, 'slug' => $serviceSlug]) }}" 
                target="_blank" 
                class="px-3 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] flex items-center gap-1.5 transition-colors"
            >
                <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع' : 'View on site' }}</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
                &larr; {{ app()->getLocale() === 'ar' ? 'الرجوع للقائمة' : 'Back to list' }}
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <div class="font-bold mb-1">{{ app()->getLocale() === 'ar' ? 'يرجى تصحيح الأخطاء التالية:' : 'Please correct errors:' }}</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left / Main: Bilingual Content (8 cols) -->
            <div class="lg:col-span-8 space-y-6" x-data="{ currentLang: 'ar' }">
                <!-- Language Switcher Tabs -->
                <div class="bg-white border border-[#E4DFD8] p-2 flex items-center gap-2">
                    <button 
                        type="button" 
                        @click="currentLang = 'ar'" 
                        :class="currentLang === 'ar' ? 'bg-[#172A35] text-white' : 'bg-transparent text-[#778087] hover:text-[#172A35]'" 
                        class="px-4 py-2 text-xs font-bold transition-colors flex items-center gap-2"
                    >
                        <span>🇸🇦</span>
                        <span>{{ app()->getLocale() === 'ar' ? 'المحتوى العربي (Arabic)' : 'Arabic Content' }}</span>
                    </button>

                    <button 
                        type="button" 
                        @click="currentLang = 'en'" 
                        :class="currentLang === 'en' ? 'bg-[#172A35] text-white' : 'bg-transparent text-[#778087] hover:text-[#172A35]'" 
                        class="px-4 py-2 text-xs font-bold transition-colors flex items-center gap-2"
                    >
                        <span>🇬🇧</span>
                        <span>{{ app()->getLocale() === 'ar' ? 'المحتوى الإنجليزي (English)' : 'English Content' }}</span>
                    </button>
                </div>

                <!-- Arabic Inputs -->
                <div x-show="currentLang === 'ar'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="rtl">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">بيانات الخدمة باللغة العربية</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            عنوان الخدمة (بالعربية) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_ar" 
                            value="{{ old('title_ar', $service->getTranslation('title', 'ar')) }}" 
                            required 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            الرابط الدائم المخصص (Slug بالعربية)
                        </label>
                        <input 
                            type="text" 
                            name="slug_ar" 
                            value="{{ old('slug_ar', $service->getTranslation('slug', 'ar')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            الوصف الموجز (يظهر في كروت الخدمات)
                        </label>
                        <textarea 
                            name="description_ar" 
                            rows="3" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('description_ar', $service->getTranslation('description', 'ar')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            التفاصيل الكاملة ونطاق العمل
                        </label>
                        <textarea 
                            name="content_ar" 
                            rows="6" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('content_ar', $service->getTranslation('content', 'ar')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            نص زر الإجراء (CTA Button بالعربية)
                        </label>
                        <input 
                            type="text" 
                            name="cta_ar" 
                            value="{{ old('cta_ar', $service->getTranslation('cta', 'ar')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >
                    </div>
                </div>

                <!-- English Inputs -->
                <div x-show="currentLang === 'en'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="ltr" style="display: none;">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">Service Content in English</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Service Title (English) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_en" 
                            value="{{ old('title_en', $service->getTranslation('title', 'en')) }}" 
                            required 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Custom Slug (English)
                        </label>
                        <input 
                            type="text" 
                            name="slug_en" 
                            value="{{ old('slug_en', $service->getTranslation('slug', 'en')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Short Summary
                        </label>
                        <textarea 
                            name="description_en" 
                            rows="3" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('description_en', $service->getTranslation('description', 'en')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Full Service Scope & Deliverables
                        </label>
                        <textarea 
                            name="content_en" 
                            rows="6" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('content_en', $service->getTranslation('content', 'en')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Call to Action Button (English)
                        </label>
                        <input 
                            type="text" 
                            name="cta_en" 
                            value="{{ old('cta_en', $service->getTranslation('cta', 'en')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'إعدادات الخدمة' : 'Service Settings' }}
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ __('admin.status') }}
                        </label>
                        <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="published" {{ old('status', $service->status) === 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                            <option value="draft" {{ old('status', $service->status) === 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'اسم الأيقونة' : 'Icon Key' }}
                        </label>
                        <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div class="pt-3 border-t border-[#F0ECE1]">
                        <button type="submit" class="w-full py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                            {{ app()->getLocale() === 'ar' ? 'تحديث وحفظ الخدمة' : 'Update & Save Service' }}
                        </button>
                    </div>
                </div>

                <!-- Service Image Upload -->
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4" x-data="{
                    imagePreview: null,
                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.imagePreview = URL.createObjectURL(file);
                        }
                    }
                }">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'صورة الخدمة' : 'Service Image' }}
                    </h3>

                    @if($service->hasMedia('image'))
                        <div class="mb-3">
                            <span class="text-[10px] text-[#778087] block mb-1">{{ app()->getLocale() === 'ar' ? 'الصورة الحالية:' : 'Current Image:' }}</span>
                            <div class="border border-[#C8C0B5] overflow-hidden">
                                <img src="{{ $service->getFirstMediaUrl('image') }}" alt="Current Image" class="h-40 w-full object-cover">
                            </div>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA]">
                        <template x-if="imagePreview">
                            <div class="mb-3">
                                <img :src="imagePreview" alt="Preview" class="h-40 w-full object-cover mx-auto border border-[#C8C0B5]">
                            </div>
                        </template>

                        <div class="space-y-2">
                            <svg class="w-8 h-8 mx-auto text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <label class="inline-block px-3 py-1.5 bg-[#172A35] text-[#F5F1E8] text-xs font-medium cursor-pointer hover:bg-[#A99776] transition-colors">
                                <span>{{ $service->hasMedia('image') ? (app()->getLocale() === 'ar' ? 'تغيير الصورة' : 'Replace Image') : (app()->getLocale() === 'ar' ? 'اختيار صورة الخدمة' : 'Choose Image') }}</span>
                                <input type="file" name="image" accept="image/*" @change="previewImage($event)" class="hidden">
                            </label>
                            <p class="text-[10px] text-[#778087]">JPG, PNG, WebP (Max: 10MB)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
