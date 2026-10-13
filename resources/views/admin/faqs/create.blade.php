@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة سؤال شائع جديد' : 'New FAQ')
@section('header_title', app()->getLocale() === 'ar' ? 'إضافة سؤال شائع جديد' : 'New FAQ')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إضافة سؤال شائع جديد' : 'Create FAQ Item' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'يرجى كتابة نص السؤال والجواب باللغتين العربية والإنجليزية.' : 'Provide the question and answer in both Arabic and English.' }}
            </p>
        </div>

        <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2 text-xs font-medium border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] transition-colors">
            {{ __('admin.back') }}
        </a>
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

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-6" x-data="{ currentLang: 'ar' }">
        @csrf

        <div class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <!-- Language Tab Switcher -->
            <div class="flex items-center justify-between border-b border-[#E4DFD8] pb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'بيانات السؤال والجواب' : 'Question & Answer Content' }}
                </span>

                <div class="flex items-center gap-1 bg-[#F8F9FA] p-1 border border-[#E4DFD8]">
                    <button type="button" @click="currentLang = 'ar'" :class="currentLang === 'ar' ? 'bg-[#172A35] text-white' : 'text-[#596269] hover:text-[#172A35]'" class="px-3 py-1 text-xs font-semibold transition-colors cursor-pointer">
                        العربية (AR)
                    </button>
                    <button type="button" @click="currentLang = 'en'" :class="currentLang === 'en' ? 'bg-[#172A35] text-white' : 'text-[#596269] hover:text-[#172A35]'" class="px-3 py-1 text-xs font-semibold transition-colors cursor-pointer">
                        English (EN)
                    </button>
                </div>
            </div>

            <!-- Arabic Fields -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        نص السؤال بالعربية *
                    </label>
                    <input type="text" name="question_ar" value="{{ old('question_ar') }}" required placeholder="مثال: ما هي المدة الزمنية المستغرقة لتوريد وتركيب المصعد؟" class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:border-[#172A35] focus:bg-white focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        الإجابة والتفاصيل الفنية بالعربية *
                    </label>
                    <textarea name="answer_ar" rows="5" required placeholder="اكتب الإجابة النموذجية المعتمدة هنا بالتفصيل..." class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:border-[#172A35] focus:bg-white focus:outline-hidden leading-relaxed">{{ old('answer_ar') }}</textarea>
                </div>
            </div>

            <!-- English Fields -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        Question in English *
                    </label>
                    <input type="text" name="question_en" value="{{ old('question_en') }}" required placeholder="e.g. What is the typical lead time for elevator installation?" class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:border-[#172A35] focus:bg-white focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        Answer in English *
                    </label>
                    <textarea name="answer_en" rows="5" required placeholder="Write the verified technical answer here..." class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:border-[#172A35] focus:bg-white focus:outline-hidden leading-relaxed">{{ old('answer_en') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Meta & Organization -->
        <div class="bg-white border border-[#E4DFD8] p-6 shadow-xs grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">
                    {{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}
                </label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">
                    {{ __('admin.status') }}
                </label>
                <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.faqs.index') }}" class="px-5 py-2.5 text-xs font-semibold text-[#596269] hover:text-[#172A35] transition-colors">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'حفظ السؤال' : 'Save FAQ' }}
            </button>
        </div>
    </form>
</div>
@endsection
