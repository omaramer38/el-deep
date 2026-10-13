@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل المشروع: ' . $project->getTranslation('title', 'ar') : 'Edit Project: ' . $project->getTranslation('title', 'en'))
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل المشروع' : 'Edit Project')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تعديل بيانات المشروع' : 'Edit Project Details' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ $project->getTranslation('title', 'ar') }} &bull; {{ $project->getTranslation('title', 'en') }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            @php
                $viewLocale = in_array(app()->getLocale(), ['ar', 'en']) ? app()->getLocale() : 'ar';
                $projectSlug = $project->getTranslation('slug', $viewLocale) 
                    ?: $project->getTranslation('slug', 'ar') 
                    ?: $project->getTranslation('slug', 'en') 
                    ?: (string)$project->id;
            @endphp
            <a 
                href="{{ route('site.projects.show', ['locale' => $viewLocale, 'slug' => $projectSlug]) }}" 
                target="_blank" 
                class="px-3 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] flex items-center gap-1.5 transition-colors"
            >
                <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع' : 'View on site' }}</span>
            </a>

            <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
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

    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="space-y-6">
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
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">بيانات المشروع باللغة العربية</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            اسم المشروع (بالعربية) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_ar" 
                            value="{{ old('title_ar', $project->getTranslation('title', 'ar')) }}" 
                            required 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                الموقع الجغرافي (بالعربية)
                            </label>
                            <input 
                                type="text" 
                                name="location_ar" 
                                value="{{ old('location_ar', $project->getTranslation('location', 'ar')) }}" 
                                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                نوع الخدمة / نطاق العمل (بالعربية)
                            </label>
                            <input 
                                type="text" 
                                name="service_type_ar" 
                                value="{{ old('service_type_ar', $project->getTranslation('service_type', 'ar')) }}" 
                                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            الرابط الدائم المخصص (Slug بالعربية)
                        </label>
                        <input 
                            type="text" 
                            name="slug_ar" 
                            value="{{ old('slug_ar', $project->getTranslation('slug', 'ar')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            نبذة سريعة عن المشروع
                        </label>
                        <textarea 
                            name="short_description_ar" 
                            rows="3" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('short_description_ar', $project->getTranslation('short_description', 'ar')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            التفاصيل الكاملة وحيثيات التنفيذ الهندسي
                        </label>
                        <textarea 
                            name="description_ar" 
                            rows="6" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('description_ar', $project->getTranslation('description', 'ar')) }}</textarea>
                    </div>
                </div>

                <!-- English Inputs -->
                <div x-show="currentLang === 'en'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="ltr" style="display: none;">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">Project Content in English</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Project Title (English) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_en" 
                            value="{{ old('title_en', $project->getTranslation('title', 'en')) }}" 
                            required 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                Location (English)
                            </label>
                            <input 
                                type="text" 
                                name="location_en" 
                                value="{{ old('location_en', $project->getTranslation('location', 'en')) }}" 
                                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                Service Scope (English)
                            </label>
                            <input 
                                type="text" 
                                name="service_type_en" 
                                value="{{ old('service_type_en', $project->getTranslation('service_type', 'en')) }}" 
                                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Custom Slug (English)
                        </label>
                        <input 
                            type="text" 
                            name="slug_en" 
                            value="{{ old('slug_en', $project->getTranslation('slug', 'en')) }}" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Short Summary
                        </label>
                        <textarea 
                            name="short_description_en" 
                            rows="3" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('short_description_en', $project->getTranslation('short_description', 'en')) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Comprehensive Engineering Scope
                        </label>
                        <textarea 
                            name="description_en" 
                            rows="6" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('description_en', $project->getTranslation('description', 'en')) }}</textarea>
                    </div>
                </div>

                <!-- Specifications Builder -->
                @php
                    $rawSpecs = $project->specifications;
                    if (is_string($rawSpecs)) {
                        $rawSpecs = json_decode($rawSpecs, true) ?: [];
                    }
                    $rawSpecs = is_array($rawSpecs) ? $rawSpecs : [];

                    $arSpecs = [];
                    $enSpecs = [];

                    if (isset($rawSpecs['ar']) || isset($rawSpecs['en'])) {
                        $arSpecs = is_array($rawSpecs['ar'] ?? null) ? $rawSpecs['ar'] : [];
                        $enSpecs = is_array($rawSpecs['en'] ?? null) ? $rawSpecs['en'] : [];
                    } else {
                        $enSpecs = $rawSpecs;
                        $dictionary = [
                            'Payload Capacity' => 'سعة الحمولة',
                            'Rated Capacity' => 'سعة الحمولة المقدرة',
                            'Rated Speed' => 'سرعة المصعد',
                            'Max Travel Height' => 'أقصى ارتفاع حركة',
                            'Cabin Finish' => 'تشطيب الكابينة',
                            'Control System' => 'نظام التحكم',
                            'Stops' => 'عدد المحطات / الطوابق',
                            'Elevator Speed' => 'سرعة المصعد',
                        ];
                        foreach ($rawSpecs as $k => $v) {
                            $arKey = $dictionary[$k] ?? $k;
                            $arSpecs[$arKey] = $v;
                        }
                    }

                    $compiledSpecs = [];
                    $arKeys = array_keys($arSpecs);
                    $enKeys = array_keys($enSpecs);
                    $maxCount = max(count($arKeys), count($enKeys));

                    for ($i = 0; $i < $maxCount; $i++) {
                        $kAr = $arKeys[$i] ?? '';
                        $vAr = $kAr !== '' ? ($arSpecs[$kAr] ?? '') : '';
                        $kEn = $enKeys[$i] ?? '';
                        $vEn = $kEn !== '' ? ($enSpecs[$kEn] ?? '') : '';
                        $compiledSpecs[] = [
                            'key_ar' => $kAr,
                            'val_ar' => $vAr,
                            'key_en' => $kEn,
                            'val_en' => $vEn,
                        ];
                    }

                    if (empty($compiledSpecs)) {
                        $compiledSpecs = [
                            ['key_ar' => '', 'val_ar' => '', 'key_en' => '', 'val_en' => '']
                        ];
                    }
                @endphp

                <div class="bg-white p-6 border border-[#E4DFD8] space-y-4" x-data="{
                    specs: {{ json_encode($compiledSpecs) }},
                    addSpec() {
                        this.specs.push({ key_ar: '', val_ar: '', key_en: '', val_en: '' });
                    },
                    removeSpec(index) {
                        this.specs.splice(index, 1);
                    }
                }">
                    <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-3">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35]">
                                {{ app()->getLocale() === 'ar' ? 'المواصفات الفنية للمشروع' : 'Project Engineering Specs' }}
                            </h3>
                        </div>
                        <button type="button" @click="addSpec()" class="px-3 py-1 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] hover:bg-[#172A35] hover:text-white transition-colors text-xs font-semibold">
                            + {{ app()->getLocale() === 'ar' ? 'إضافة بند' : 'Add Spec' }}
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="p-3 bg-[#F8F9FA] border border-[#E4DFD8] space-y-2 relative">
                                <button type="button" @click="removeSpec(index)" class="absolute top-2 end-2 text-red-500 hover:text-red-700 text-xs font-bold px-2 py-0.5">
                                    &times;
                                </button>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-[#A99776] font-bold">عربي</span>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" :name="'spec_key_ar[' + index + ']'" x-model="spec.key_ar" placeholder="البند" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                            <input type="text" :name="'spec_value_ar[' + index + ']'" x-model="spec.val_ar" placeholder="القيمة" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-[#596269] font-bold">English</span>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" :name="'spec_key_en[' + index + ']'" x-model="spec.key_en" placeholder="Key" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                            <input type="text" :name="'spec_value_en[' + index + ']'" x-model="spec.val_en" placeholder="Value" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Media (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Status & Publish Box -->
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'إعدادات المشروع' : 'Project Settings' }}
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'تصنيف المشروع' : 'Category' }} <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $project->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->getTranslation('name', app()->getLocale()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                {{ app()->getLocale() === 'ar' ? 'عدد المصاعد' : 'Elevators' }}
                            </label>
                            <input type="number" name="elevators_count" value="{{ old('elevators_count', $project->elevators_count) }}" min="1" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-[#172A35] mb-1">
                                {{ app()->getLocale() === 'ar' ? 'سنة التنفيذ' : 'Year' }}
                            </label>
                            <input type="number" name="year" value="{{ old('year', $project->year) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'حالة الإنجاز الميداني' : 'Field Status' }}
                        </label>
                        <input type="text" name="status" value="{{ old('status', $project->status) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ __('admin.status') }} (حالة النشر)
                        </label>
                        <select name="status_publish" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="published" {{ old('status_publish', $project->status_publish) === 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                            <option value="draft" {{ old('status_publish', $project->status_publish) === 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                            <option value="archived" {{ old('status_publish', $project->status_publish) === 'archived' ? 'selected' : '' }}>{{ __('admin.archived') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div class="pt-2 border-t border-[#F0ECE1]">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} class="w-4 h-4 text-[#A99776]">
                            <span class="text-xs font-semibold text-[#172A35]">
                                {{ app()->getLocale() === 'ar' ? 'تمييز في الصفحة الرئيسية' : 'Featured Project' }}
                            </span>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-[#F0ECE1]">
                        <button type="submit" class="w-full py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                            {{ app()->getLocale() === 'ar' ? 'تحديث وحفظ المشروع' : 'Update & Save Project' }}
                        </button>
                    </div>
                </div>

                <!-- Cover Image Upload -->
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
                        {{ app()->getLocale() === 'ar' ? 'صورة الغلاف الأساسية' : 'Cover Image' }}
                    </h3>

                    @if($project->hasMedia('cover'))
                        <div class="mb-3">
                            <span class="text-[10px] text-[#778087] block mb-1">{{ app()->getLocale() === 'ar' ? 'الصورة الحالية:' : 'Current Image:' }}</span>
                            <div class="border border-[#C8C0B5] overflow-hidden">
                                <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="Current Cover" class="h-40 w-full object-cover">
                            </div>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA]">
                        <template x-if="imagePreview">
                            <div class="mb-3">
                                <img :src="imagePreview" alt="Cover Preview" class="h-40 w-full object-cover mx-auto border border-[#C8C0B5]">
                            </div>
                        </template>

                        <div class="space-y-2">
                            <svg class="w-8 h-8 mx-auto text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <label class="inline-block px-3 py-1.5 bg-[#172A35] text-[#F5F1E8] text-xs font-medium cursor-pointer hover:bg-[#A99776] transition-colors">
                                <span>{{ $project->hasMedia('cover') ? (app()->getLocale() === 'ar' ? 'تغيير صورة الغلاف' : 'Replace Cover') : (app()->getLocale() === 'ar' ? 'رفع صورة الغلاف' : 'Upload Cover') }}</span>
                                <input type="file" name="cover" accept="image/*" @change="previewImage($event)" class="hidden">
                            </label>
                            <p class="text-[10px] text-[#778087]">JPG, PNG, WebP (Max: 10MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images Upload -->
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'معرض صور المشروع' : 'Project Photo Gallery' }}
                    </h3>

                    @if($project->getMedia('gallery')->count() > 0)
                        <div class="space-y-2">
                            <span class="text-[10px] text-[#778087] block">{{ app()->getLocale() === 'ar' ? 'الصور الحالية:' : 'Current Photos:' }}</span>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach($project->getMedia('gallery') as $photo)
                                    <div class="relative group border border-[#C8C0B5] aspect-square overflow-hidden bg-black">
                                        <img src="{{ $photo->getUrl() }}" alt="" class="w-full h-full object-cover">
                                        <button 
                                            type="button" 
                                            onclick="if(confirm('{{ app()->getLocale() === 'ar' ? 'هل تريد حذف هذه الصورة؟' : 'Delete photo?' }}')) document.getElementById('delete-media-{{ $photo->id }}').submit();"
                                            class="absolute inset-0 bg-red-900/70 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs font-bold"
                                        >
                                            {{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA]">
                        <svg class="w-8 h-8 mx-auto text-[#778087]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <div class="mt-2">
                            <label class="inline-block px-3 py-1.5 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] text-xs font-medium cursor-pointer hover:bg-[#172A35] hover:text-white transition-colors">
                                <span>{{ app()->getLocale() === 'ar' ? 'إضافة صور جديدة للمعرض' : 'Upload More Photos' }}</span>
                                <input type="file" name="gallery[]" multiple accept="image/*" class="hidden">
                            </label>
                            <p class="text-[10px] text-[#778087] mt-1">{{ app()->getLocale() === 'ar' ? 'تحديد أكثر من صورة' : 'Select multiple images' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Hidden forms for deleting media -->
    @foreach($project->getMedia('gallery') as $photo)
        <form id="delete-media-{{ $photo->id }}" action="{{ route('admin.projects.media.destroy', [$project, $photo]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>
@endsection
