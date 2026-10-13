@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'كتابة مقال جديد' : 'New Article')
@section('header_title', app()->getLocale() === 'ar' ? 'كتابة مقال جديد' : 'New Article')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'كتابة مقال أو دراسة فنية جديدة' : 'Compose New Article' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'أدخل محتوى المقال والمقتطف باللغتين العربية والإنجليزية.' : 'Write bilingual content for engineering blog & insights.' }}
            </p>
        </div>

        <a href="{{ route('admin.blog.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
            &larr; {{ app()->getLocale() === 'ar' ? 'الرجوع للمدونة' : 'Back to Blog' }}
        </a>
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

    <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

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
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">محتوى المقال باللغة العربية</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            عنوان المقال (بالعربية) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_ar" 
                            value="{{ old('title_ar') }}" 
                            required 
                            placeholder="مثال: المعايير الأوروبية EN 81-20 في سلامة المصاعد الحديثة" 
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
                            value="{{ old('slug_ar') }}" 
                            placeholder="يترك فارغاً للتوليد التلقائي" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            المقتطف المختصر (Excerpt)
                        </label>
                        <textarea 
                            name="excerpt_ar" 
                            rows="3" 
                            placeholder="ملخص يظهر في صفحة المدونة وبطاقات الأخبار..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('excerpt_ar') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            نص المقال الكامل
                        </label>
                        <textarea 
                            name="content_ar" 
                            rows="10" 
                            placeholder="اكتب المحتوى الكامل للمقال هنا بالتفصيل..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-sans leading-relaxed"
                        >{{ old('content_ar') }}</textarea>
                    </div>
                </div>

                <!-- English Inputs -->
                <div x-show="currentLang === 'en'" class="bg-white p-6 border border-[#E4DFD8] space-y-5" dir="ltr" style="display: none;">
                    <div class="border-b border-[#F0ECE1] pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">Article Content in English</span>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Article Title (English) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title_en" 
                            value="{{ old('title_en') }}" 
                            required 
                            placeholder="e.g. European Standards EN 81-20 in Modern Elevator Safety" 
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
                            value="{{ old('slug_en') }}" 
                            placeholder="Leave empty for auto-generation" 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] text-[#778087]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Short Excerpt
                        </label>
                        <textarea 
                            name="excerpt_en" 
                            rows="3" 
                            placeholder="Brief summary for blog cards..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('excerpt_en') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            Full Article Body
                        </label>
                        <textarea 
                            name="content_en" 
                            rows="10" 
                            placeholder="Write comprehensive article content..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-sans leading-relaxed"
                        >{{ old('content_en') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Cover Image (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-5 border border-[#E4DFD8] space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                        {{ app()->getLocale() === 'ar' ? 'إعدادات النشر والتصنيف' : 'Publishing Options' }}
                    </h3>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'تصنيف المقال' : 'Category' }} <span class="text-red-500">*</span>
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
                            {{ app()->getLocale() === 'ar' ? 'وقت القراءة المقدر (بالدقائق)' : 'Reading Time (Minutes)' }}
                        </label>
                        <input type="number" name="reading_time" value="{{ old('reading_time', 5) }}" min="1" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div class="pt-2 border-t border-[#F0ECE1]">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 text-[#A99776]">
                            <span class="text-xs font-semibold text-[#172A35]">
                                {{ app()->getLocale() === 'ar' ? 'تثبيت كمقال مميز في الواجهة' : 'Featured Article' }}
                            </span>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-[#F0ECE1]">
                        <button type="submit" class="w-full py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                            {{ app()->getLocale() === 'ar' ? 'نشر المقال' : 'Publish Article' }}
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
                        {{ app()->getLocale() === 'ar' ? 'صورة المقال الرئيسية' : 'Article Cover Image' }}
                    </h3>

                    <div class="border-2 border-dashed border-[#C8C0B5] p-4 text-center bg-[#F8F9FA]">
                        <template x-if="imagePreview">
                            <div class="mb-3">
                                <img :src="imagePreview" alt="Preview" class="h-40 w-full object-cover mx-auto border border-[#C8C0B5]">
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
            </div>
        </div>
    </form>
</div>
@endsection
