@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة مصعد جديد' : 'New Elevator')
@section('header_title', app()->getLocale() === 'ar' ? 'إضافة مصعد جديد' : 'New Elevator')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إضافة موديل / منظومة مصعد جديدة' : 'Add New Elevator Model' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'يرجى إدخال البيانات باللغتين العربية والإنجليزية لضمان ظهورها بشكل متناسق في الموقع.' : 'Please enter bilingual content in both Arabic and English.' }}
            </p>
        </div>

        <a href="{{ route('admin.elevators.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
            &larr; {{ app()->getLocale() === 'ar' ? 'الرجوع للقائمة' : 'Back to list' }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <div class="font-bold mb-1">{{ app()->getLocale() === 'ar' ? 'يرجى تصحيح الأخطاء التالية:' : 'Please correct the following errors:' }}</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.elevators.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left / Main: Translatable Content & Specs (8 cols) -->
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
                        <span class="text-[10px] text-[#A99776]">*</span>
                    </button>

                    <button 
                        type="button" 
                        @click="currentLang = 'en'" 
                        :class="currentLang === 'en' ? 'bg-[#172A35] text-white' : 'bg-transparent text-[#778087] hover:text-[#172A35]'" 
                        class="px-4 py-2 text-xs font-bold transition-colors flex items-center gap-2"
                    >
                        <span>🇬🇧</span>
                        <span>{{ app()->getLocale() === 'ar' ? 'المحتوى الإنجليزي (English)' : 'English Content' }}</span>
                        <span class="text-[10px] text-[#A99776]">*</span>
                    </button>
                </div>

                <!-- Arabic Inputs -->
                <div x-show="currentLang === 'ar'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="rtl">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">بيانات المصعد باللغة العربية</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            اسم المصعد / الطراز (بالعربية) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name_ar" 
                            value="{{ old('name_ar') }}" 
                            required 
                            placeholder="مثال: مصعد الركاب التجاري AeroLine" 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            الرابط الدائم المخصص (Slug بالعربية - اختياري)
                        </label>
                        <input 
                            type="text" 
                            name="slug_ar" 
                            value="{{ old('slug_ar') }}" 
                            placeholder="يترك فارغاً للتوليد التلقائي من الاسم" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            نبذة مختصرة (تظهر في الكروت وصفحات العرض)
                        </label>
                        <textarea 
                            name="short_description_ar" 
                            rows="3" 
                            placeholder="نبذة سريعة عن الاستخدامات والمميزات الأساسية..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >{{ old('short_description_ar') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            الوصف الهندسي والمواصفات الكاملة
                        </label>
                        <textarea 
                            name="description_ar" 
                            rows="6" 
                            placeholder="تفاصيل التكنولوجيا، أنظمة المحركات، الكابينة، أنظمة الأمان والسلامة..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >{{ old('description_ar') }}</textarea>
                    </div>
                </div>

                <!-- English Inputs -->
                <div x-show="currentLang === 'en'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="ltr" style="display: none;">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">Elevator Content in English</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Elevator / Model Name (English) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name_en" 
                            value="{{ old('name_en') }}" 
                            required 
                            placeholder="e.g. AeroLine Commercial Passenger Elevator" 
                            class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Custom Slug (English - Optional)
                        </label>
                        <input 
                            type="text" 
                            name="slug_en" 
                            value="{{ old('slug_en') }}" 
                            placeholder="Leave empty to generate automatically from name" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087] focus:outline-hidden focus:border-[#172A35]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Short Summary (Card Preview)
                        </label>
                        <textarea 
                            name="short_description_en" 
                            rows="3" 
                            placeholder="Brief highlights for cards and overview listings..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >{{ old('short_description_en') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Detailed Technical Description
                        </label>
                        <textarea 
                            name="description_en" 
                            rows="6" 
                            placeholder="Engineering details, drive type, cabin options, safety compliance..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
                        >{{ old('description_en') }}</textarea>
                    </div>
                </div>

                <!-- Technical Specifications Builder (Key-Value pairs) -->
                <div class="bg-white p-6 border border-[#E4DFD8] space-y-4" x-data="{
                    specs: [
                        { key_ar: 'الحمولة الاسمية', val_ar: '630 كجم - 2,500 كجم', key_en: 'Rated Capacity', val_en: '630 kg - 2,500 kg' },
                        { key_ar: 'السرعة الاسمية', val_ar: '1.0 م/ث - 4.0 م/ث', key_en: 'Rated Speed', val_en: '1.0 m/s - 4.0 m/s' },
                        { key_ar: 'نظام التحكم', val_ar: 'VVVF Microprocessor', key_en: 'Control System', val_en: 'VVVF Microprocessor' }
                    ],
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
                                {{ app()->getLocale() === 'ar' ? 'جدول المواصفات الفنية الميكانيكية' : 'Technical Specifications Table' }}
                            </h3>
                            <p class="text-[11px] text-[#778087]">
                                {{ app()->getLocale() === 'ar' ? 'أضف البنود الفنية وقيمها باللغتين العربية والإنجليزية لتظهر كجدول منظم في صفحة المنتج.' : 'Add key-value engineering attributes in both languages.' }}
                            </p>
                        </div>
                        <button type="button" @click="addSpec()" class="px-3 py-1 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] hover:bg-[#172A35] hover:text-white transition-colors text-xs font-semibold">
                            + {{ app()->getLocale() === 'ar' ? 'إضافة بند مواصفة' : 'Add Spec' }}
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="p-3 bg-[#F8F9FA] border border-[#E4DFD8] space-y-2 relative">
                                <button type="button" @click="removeSpec(index)" class="absolute top-2 end-2 text-red-500 hover:text-red-700 text-xs font-bold px-2 py-0.5">
                                    &times;
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <!-- Arabic Key/Value -->
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-[#A99776] font-bold">المواصفة (عربي)</span>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" :name="'spec_key_ar[' + index + ']'" x-model="spec.key_ar" placeholder="البند (مثلاً: الحمولة)" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                            <input type="text" :name="'spec_value_ar[' + index + ']'" x-model="spec.val_ar" placeholder="القيمة (مثلاً: 1000 كجم)" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                        </div>
                                    </div>

                                    <!-- English Key/Value -->
                                    <div class="space-y-1">
                                        <span class="text-[10px] text-[#596269] font-bold">Specification (English)</span>
                                        <div class="grid grid-cols-2 gap-2">
                                            <input type="text" :name="'spec_key_en[' + index + ']'" x-model="spec.key_en" placeholder="Key (e.g. Capacity)" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                            <input type="text" :name="'spec_value_en[' + index + ']'" x-model="spec.val_en" placeholder="Value (e.g. 1000 kg)" class="w-full text-xs px-2 py-1.5 bg-white border border-[#C8C0B5]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Right Column: Media & Publish Settings (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Status & Publish Box -->
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'إعدادات النشر والتصنيف' : 'Publish & Category' }}
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'تصنيف المصعد' : 'Category' }} <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="">{{ app()->getLocale() === 'ar' ? '-- اختر التصنيف --' : '-- Select Category --' }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->getTranslation('name', app()->getLocale()) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ __('admin.status') }}
                        </label>
                        <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>{{ __('admin.archived') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}
                        </label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <span class="text-[10px] text-[#778087]">{{ app()->getLocale() === 'ar' ? 'الرقم الأصغر يظهر أولاً' : 'Lower numbers appear first' }}</span>
                    </div>

                    <div class="pt-2 border-t border-[#F0ECE1]">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-[#A99776]">
                            <span class="text-xs font-semibold text-[#172A35]">
                                {{ app()->getLocale() === 'ar' ? 'تمييز في الصفحة الرئيسية (Featured)' : 'Featured on Home Page' }}
                            </span>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-[#F0ECE1]">
                        <button type="submit" class="w-full py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                            {{ app()->getLocale() === 'ar' ? 'حفظ ونشر المصعد' : 'Save & Publish Elevator' }}
                        </button>
                    </div>
                </div>

                <!-- Primary Cover Image Upload -->
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

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA] relative">
                        <template x-if="imagePreview">
                            <div class="mb-3">
                                <img :src="imagePreview" alt="Cover Preview" class="h-40 w-full object-cover mx-auto border border-[#C8C0B5]">
                            </div>
                        </template>

                        <div class="space-y-2">
                            <svg class="w-8 h-8 mx-auto text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <label class="inline-block px-3 py-1.5 bg-[#172A35] text-[#F5F1E8] text-xs font-medium cursor-pointer hover:bg-[#A99776] transition-colors">
                                <span>{{ app()->getLocale() === 'ar' ? 'اختيار صورة الغلاف' : 'Choose Cover' }}</span>
                                <input type="file" name="cover" accept="image/*" @change="previewImage($event)" class="hidden">
                            </label>
                            <p class="text-[10px] text-[#778087]">JPG, PNG, WebP (Max: 10MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images Upload -->
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'معرض الصور الإضافية' : 'Photo Gallery' }}
                    </h3>

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA]">
                        <svg class="w-8 h-8 mx-auto text-[#778087]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <div class="mt-2">
                            <label class="inline-block px-3 py-1.5 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] text-xs font-medium cursor-pointer hover:bg-[#172A35] hover:text-white transition-colors">
                                <span>{{ app()->getLocale() === 'ar' ? 'رفع صور متعددة للمعرض' : 'Upload Gallery Photos' }}</span>
                                <input type="file" name="gallery[]" multiple accept="image/*" class="hidden">
                            </label>
                            <p class="text-[10px] text-[#778087] mt-1">{{ app()->getLocale() === 'ar' ? 'يمكنك تحديد أكثر من صورة معاً' : 'Select multiple images' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
