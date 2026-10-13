@extends('layouts.admin')

@section('title', __('admin.projects'))
@section('header_title', __('admin.projects'))

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إدارة المشروعات الهندسية' : 'Engineering Projects Portfolio' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة سابقة الأعمال والمشاريع المنفذة مع الصور وبيانات المواقع والمواصفات الفنية باللغتين.' : 'Manage portfolio projects, site locations, engineering scopes, and photo galleries.' }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.project-categories.index') }}" class="px-4 py-2.5 text-xs font-medium border border-[#C8C0B5] text-[#172A35] hover:bg-[#F5F1E8] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'تصنيفات المشاريع' : 'Project Categories' }}</span>
            </a>

            <a href="{{ route('admin.projects.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إضافة مشروع جديد' : 'New Project' }}</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('admin.projects.index') }}" class="bg-white p-4 border border-[#E4DFD8] flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[220px]">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="{{ app()->getLocale() === 'ar' ? 'بحث باسم المشروع أو الموقع...' : 'Search by project name or location...' }}" 
                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]"
            >
        </div>

        <div class="w-48">
            <select name="category_id" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]">
                <option value="">{{ app()->getLocale() === 'ar' ? '-- كل التصنيفات --' : '-- All Categories --' }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->getTranslation('name', app()->getLocale()) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-36">
            <select name="status_publish" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35]">
                <option value="">{{ app()->getLocale() === 'ar' ? '-- حالة النشر --' : '-- All Statuses --' }}</option>
                <option value="published" {{ request('status_publish') === 'published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                <option value="draft" {{ request('status_publish') === 'draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                <option value="archived" {{ request('status_publish') === 'archived' ? 'selected' : '' }}>{{ __('admin.archived') }}</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-2 bg-[#233642] text-white text-xs hover:bg-[#172A35] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'تصفية' : 'Filter' }}
            </button>
            @if(request()->anyFilled(['search', 'category_id', 'status_publish']))
                <a href="{{ route('admin.projects.index') }}" class="px-3 py-2 text-xs text-[#778087] hover:text-[#172A35] hover:underline">
                    {{ app()->getLocale() === 'ar' ? 'إعادة تعيين' : 'Reset' }}
                </a>
            @endif
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-4 text-start w-16">{{ app()->getLocale() === 'ar' ? 'الغلاف' : 'Cover' }}</th>
                        <th class="py-3.5 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المشروع' : 'Project Title' }}</th>
                        <th class="py-3.5 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الموقع' : 'Location' }}</th>
                        <th class="py-3.5 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'التصنيف' : 'Category' }}</th>
                        <th class="py-3.5 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'المصاعد' : 'Elevators' }}</th>
                        <th class="py-3.5 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'السنة' : 'Year' }}</th>
                        <th class="py-3.5 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3.5 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8] text-[#172A35]">
                    @forelse($projects as $item)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-12 h-12 bg-[#F5F1E8] border border-[#C8C0B5] flex items-center justify-center overflow-hidden">
                                    @if($item->hasMedia('cover'))
                                        <img src="{{ $item->getFirstMediaUrl('cover') }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="font-bold text-[#172A35] text-sm flex items-center gap-2">
                                    <span>{{ $item->getTranslation('title', 'ar') }}</span>
                                    <span class="text-[10px] text-[#A99776] bg-[#F5F1E8] px-1.5 py-0.5 border border-[#E4DFD8]">AR</span>
                                </div>
                                <div class="text-[11px] text-[#596269] flex items-center gap-2 mt-0.5">
                                    <span>{{ $item->getTranslation('title', 'en') }}</span>
                                    <span class="text-[10px] text-[#596269] bg-[#E4DFD8] px-1 py-0.2">EN</span>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-[#596269]">
                                <div>{{ $item->getTranslation('location', app()->getLocale()) ?: '—' }}</div>
                            </td>

                            <td class="py-3 px-4">
                                <span class="bg-[#F5F1E8] text-[#172A35] px-2.5 py-1 text-[11px] border border-[#C8C0B5]">
                                    {{ $item->category ? $item->category->getTranslation('name', app()->getLocale()) : '—' }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-center font-bold text-[#172A35]">
                                {{ $item->elevators_count }}
                            </td>

                            <td class="py-3 px-4 text-center text-[#778087]">
                                {{ $item->year ?: '—' }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($item->status_publish === 'published')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620] border border-[#BDE0C3]">
                                        {{ __('admin.published') }}
                                    </span>
                                @elseif($item->status_publish === 'draft')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#FFFBEA] text-[#713F12] border border-[#FEF08A]">
                                        {{ __('admin.draft') }}
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#F3F4F6] text-[#374151] border border-[#D1D5DB]">
                                        {{ __('admin.archived') }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    @php
                                        $viewLocale = in_array(app()->getLocale(), ['ar', 'en']) ? app()->getLocale() : 'ar';
                                        $itemSlug = $item->getTranslation('slug', $viewLocale) 
                                            ?: $item->getTranslation('slug', 'ar') 
                                            ?: $item->getTranslation('slug', 'en') 
                                            ?: (string)$item->id;
                                    @endphp
                                    <a 
                                        href="{{ route('site.projects.show', ['locale' => $viewLocale, 'slug' => $itemSlug]) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-[#778087] hover:text-[#172A35] transition-colors" 
                                        title="{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع' : 'View on website' }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a 
                                        href="{{ route('admin.projects.edit', $item) }}" 
                                        class="px-3 py-1 bg-[#172A35] text-white hover:bg-[#A99776] transition-colors text-[11px] font-medium"
                                    >
                                        {{ __('admin.edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.projects.destroy', $item) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:text-white hover:bg-red-600 border border-red-200 transition-colors text-[11px]">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-[#778087]">
                                <p>{{ app()->getLocale() === 'ar' ? 'لا توجد مشاريع مسجلة حالياً.' : 'No engineering projects found.' }}</p>
                                <a href="{{ route('admin.projects.create') }}" class="inline-block text-xs text-[#A99776] font-semibold hover:underline mt-2">
                                    + {{ app()->getLocale() === 'ar' ? 'إضافة مشروع جديد الآن' : 'Create new project now' }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
