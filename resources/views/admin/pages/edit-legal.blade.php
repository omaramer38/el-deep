@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل الصفحة القانونية' : 'Edit Legal Page')
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل الصفحة القانونية' : 'Edit Legal Page')

@section('content')
@php
    $legal = $page->getSectionData('legal_content');
@endphp

<div class="max-w-4xl mx-auto space-y-6" x-data="{ currentLang: 'ar' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 border border-[#E4DFD8] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 bg-[#172A35] text-[#A99776] text-[10px] font-mono font-bold uppercase">{{ $page->key }}</span>
                <h1 class="text-xl font-serif font-bold text-[#172A35]">
                    {{ $page->title }}
                </h1>
            </div>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تعديل بنود الصفحة القانونية والمحتوى التعاقدي باللغتين العربية والإنجليزية.' : 'Edit legal documentation, terms, and policies bilingually.' }}
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

            <a href="{{ route('site.'.$page->key, ['locale' => app()->getLocale()]) }}" target="_blank" class="px-3.5 py-1.5 text-xs font-medium border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] transition-colors flex items-center gap-1">
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

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
            <!-- AR -->
            <div x-show="currentLang === 'ar'" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        عنوان الصفحة بالعربية *
                    </label>
                    <input type="text" name="title_ar" value="{{ old('title_ar', $page->getTranslation('title', 'ar')) }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        نصوص ومحتوى الصفحة بالعربية *
                    </label>
                    <textarea name="content_ar" rows="16" required class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] font-mono leading-relaxed">{{ old('content_ar', $legal['content']['ar'] ?? '') }}</textarea>
                    <p class="text-[11px] text-[#778087]">يمكنك كتابة الفقرات وHTML البسيط لتنسيق البنود.</p>
                </div>
            </div>

            <!-- EN -->
            <div x-show="currentLang === 'en'" style="display: none;" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        Page Title in English *
                    </label>
                    <input type="text" name="title_en" value="{{ old('title_en', $page->getTranslation('title', 'en')) }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-serif text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        Page Content & Documentation in English *
                    </label>
                    <textarea name="content_en" rows="16" required class="w-full text-xs px-3 py-2.5 bg-[#F8F9FA] border border-[#C8C0B5] font-mono leading-relaxed">{{ old('content_en', $legal['content']['en'] ?? '') }}</textarea>
                    <p class="text-[11px] text-[#778087]">Standard text and simple HTML markup supported.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.pages.index') }}" class="px-5 py-2.5 text-xs font-semibold text-[#596269] hover:text-[#172A35] transition-colors">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-8 py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors shadow-md cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'حفظ الصفحة القانونية' : 'Save Legal Page' }}
            </button>
        </div>
    </form>
</div>
@endsection
