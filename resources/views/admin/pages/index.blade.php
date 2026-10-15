@extends('layouts.admin')

@section('title', __('admin.website_content'))
@section('header_title', __('admin.website_content'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إدارة صفحات ومحتوى الموقع' : 'Website Pages & Content' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تعديل كافة النصوص، العناوين، الإحصائيات، والصور الترويجية في صفحات الموقع باللغتين العربية والإنجليزية.' : 'Customize all texts, headlines, stats, banners, and imagery across all website pages bilingually.' }}
            </p>
        </div>

        <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 text-xs font-semibold border border-[#172A35] hover:bg-[#172A35] hover:text-white transition-colors flex items-center gap-2 uppercase tracking-wider">
            <span>{{ app()->getLocale() === 'ar' ? 'معاينة الموقع مباشرة' : 'Live Preview' }}</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-start text-xs border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 text-start w-28">{{ app()->getLocale() === 'ar' ? 'المعرّف' : 'Identifier' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم الصفحة' : 'Page Name' }}</th>
                    <th class="py-3 px-4 text-center w-28">{{ app()->getLocale() === 'ar' ? 'الأقسام المفعّلة' : 'Sections' }}</th>
                    <th class="py-3 px-4 text-center w-24">{{ __('admin.status') }}</th>
                    <th class="py-3 px-4 text-end w-36">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4DFD8]">
                @foreach($pages as $page)
                    <tr class="hover:bg-[#F8F9FA] transition-colors">
                        <td class="py-3.5 px-4 font-mono font-bold text-[#A99776]">
                            /{{ $page->key }}
                        </td>

                        <td class="py-3.5 px-4">
                            <div class="font-bold text-[#172A35] text-sm">
                                {{ $page->getTranslation('title', 'ar') }}
                            </div>
                            <div class="text-[11px] text-[#778087]">
                                {{ $page->getTranslation('title', 'en') }}
                            </div>
                        </td>

                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] text-[11px] font-bold">
                                {{ $page->sections_count }} {{ app()->getLocale() === 'ar' ? 'أقسام' : 'sections' }}
                            </span>
                        </td>

                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">
                                {{ __('admin.published') }}
                            </span>
                        </td>

                        <td class="py-3.5 px-4 text-end">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#172A35] hover:bg-[#A99776] text-white text-[11px] font-semibold transition-colors uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'تعديل المحتوى' : 'Edit Page' }}</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
