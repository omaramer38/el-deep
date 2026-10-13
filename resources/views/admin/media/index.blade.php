@extends('layouts.admin')

@section('title', __('admin.media_library'))
@section('header_title', __('admin.media_library'))

@section('content')
<div class="space-y-6" x-data="{ 
    viewMode: 'grid', 
    uploadModal: false, 
    folderModal: false, 
    previewModal: false, 
    previewData: {
        url: '',
        name: '',
        file_name: '',
        size: '',
        section: '',
        placement: '',
        item_title: '',
        edit_url: '',
        site_url: ''
    },
    openPreview(data) {
        this.previewData = data;
        this.previewModal = true;
    },
    copied: false,
    copyLink(url) {
        navigator.clipboard.writeText(url);
        this.copied = true;
        setTimeout(() => this.copied = false, 2500);
    }
}">
    <!-- Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 border border-[#E4DFD8] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-[#A99776]"></span>
                <h1 class="text-xl font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'مكتبة الوسائط والملفات' : 'Media & Asset Library' }}
                </h1>
            </div>
            <p class="text-xs text-[#778087] mt-1.5 leading-relaxed">
                {{ app()->getLocale() === 'ar' ? 'تتبع وإدارة كافة صور وملفات الموقع، ومعرفة موضع ظهور كل صورة في صفحات الموقع بدقة (مشاريع، مصاعد، مقالات، خدمات).' : 'Track and manage all website media, blueprints, and assets with exact context of where each image appears.' }}
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button type="button" @click="folderModal = true" class="px-3.5 py-2 text-xs font-semibold border border-[#C8C0B5] hover:border-[#172A35] hover:bg-[#F5F1E8] text-[#172A35] transition-colors flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'مجلد جديد' : 'New Folder' }}</span>
            </button>

            <button type="button" @click="uploadModal = true" class="px-4 py-2 text-xs font-bold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] hover:text-[#0F1C23] transition-colors flex items-center gap-2 cursor-pointer uppercase tracking-wider shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'رفع ملفات جديدة' : 'Upload Files' }}</span>
            </button>
        </div>
    </div>

    <!-- Storage & Placement Stats Strip -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'إجمالي الملفات' : 'Total Assets' }}</div>
            <div class="text-xl font-bold font-serif text-[#172A35] mt-1">{{ $totalMediaCount }}</div>
        </div>
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'المساحة المستخدمة' : 'Storage Used' }}</div>
            <div class="text-xl font-bold font-serif text-[#A99776] mt-1">{{ $totalSizeMb }} MB</div>
        </div>
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'صور المشاريع' : 'Projects Media' }}</div>
            <div class="text-xl font-bold font-serif text-[#172A35] mt-1">{{ $sectionCounts['projects'] }}</div>
        </div>
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'صور المصاعد' : 'Elevators Media' }}</div>
            <div class="text-xl font-bold font-serif text-[#172A35] mt-1">{{ $sectionCounts['elevators'] }}</div>
        </div>
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'صور المدونة' : 'Blog Media' }}</div>
            <div class="text-xl font-bold font-serif text-[#172A35] mt-1">{{ $sectionCounts['blog'] }}</div>
        </div>
        <div class="p-3.5 bg-white border border-[#E4DFD8] shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#778087]">{{ app()->getLocale() === 'ar' ? 'وسائط عامة ومجلدات' : 'General & Folders' }}</div>
            <div class="text-xl font-bold font-serif text-[#172A35] mt-1">{{ $sectionCounts['general'] }}</div>
        </div>
    </div>

    <!-- Location & Section Filter Tabs (Where each image belongs) -->
    <div class="bg-white p-3 border border-[#E4DFD8] shadow-xs space-y-3">
        <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-2.5">
            <div class="text-xs font-bold uppercase tracking-wider text-[#172A35] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'تصفية حسب موضع الاستخدام في الموقع:' : 'Filter by Website Section:' }}</span>
            </div>

            <!-- View Mode Switcher (Grid vs Table) -->
            <div class="flex items-center gap-1 bg-[#F8F9FA] p-1 border border-[#E4DFD8]">
                <button 
                    type="button" 
                    @click="viewMode = 'grid'" 
                    :class="viewMode === 'grid' ? 'bg-[#172A35] text-white shadow-xs' : 'text-[#778087] hover:text-[#172A35]'" 
                    class="px-2.5 py-1 text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer"
                    title="{{ app()->getLocale() === 'ar' ? 'عرض شبكي' : 'Grid View' }}"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'بطاقات' : 'Cards' }}</span>
                </button>
                <button 
                    type="button" 
                    @click="viewMode = 'list'" 
                    :class="viewMode === 'list' ? 'bg-[#172A35] text-white shadow-xs' : 'text-[#778087] hover:text-[#172A35]'" 
                    class="px-2.5 py-1 text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer"
                    title="{{ app()->getLocale() === 'ar' ? 'عرض جدول تفصيلي' : 'Table View' }}"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'جدول تفصيلي' : 'Table' }}</span>
                </button>
            </div>
        </div>

        <!-- Section Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['section', 'page']))) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ empty($section) ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'كافة الوسائط' : 'All Media' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ empty($section) ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['all'] }}</span>
            </a>

            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['section' => 'projects'])) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $section === 'projects' ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $section === 'projects' ? 'bg-[#A99776] text-[#0F1C23] font-bold' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['projects'] }}</span>
            </a>

            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['section' => 'elevators'])) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $section === 'elevators' ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'المصاعد والمنتجات' : 'Elevators' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $section === 'elevators' ? 'bg-[#A99776] text-[#0F1C23] font-bold' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['elevators'] }}</span>
            </a>

            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['section' => 'blog'])) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $section === 'blog' ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'المدونة والمقالات' : 'Blog' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $section === 'blog' ? 'bg-emerald-500 text-white font-bold' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['blog'] }}</span>
            </a>

            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['section' => 'services'])) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $section === 'services' ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'الخدمات' : 'Services' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $section === 'services' ? 'bg-teal-500 text-white font-bold' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['services'] }}</span>
            </a>

            <a 
                href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['section' => 'general'])) }}" 
                class="px-3 py-1.5 text-xs font-semibold border transition-all whitespace-nowrap flex items-center gap-1.5 {{ $section === 'general' ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'مكتبة عامة ومجلدات' : 'General Assets' }}</span>
                <span class="text-[10px] px-1.5 py-0.2 rounded-full {{ $section === 'general' ? 'bg-[#A99776] text-[#0F1C23] font-bold' : 'bg-gray-200 text-gray-700' }}">{{ $sectionCounts['general'] }}</span>
            </a>
        </div>
    </div>

    <!-- Secondary Filters (Placement, Type, Search) -->
    <div class="bg-white p-3.5 border border-[#E4DFD8] shadow-xs flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
        <div class="flex items-center gap-2 flex-wrap">
            <!-- Placement Sub-filter (Cover vs Gallery) -->
            <div class="flex items-center gap-1 text-xs text-[#778087]">
                <span class="font-semibold text-[#172A35] text-[11px]">{{ app()->getLocale() === 'ar' ? 'الظهور:' : 'Placement:' }}</span>
                <a href="{{ route('admin.media.index', array_merge(request()->except(['collection', 'page']))) }}" class="px-2 py-1 border text-[11px] {{ empty($collection) ? 'bg-[#172A35] text-white border-[#172A35]' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}">
                    {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                </a>
                <a href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['collection' => 'cover'])) }}" class="px-2 py-1 border text-[11px] {{ $collection === 'cover' ? 'bg-amber-700 text-white border-amber-800' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}">
                    {{ app()->getLocale() === 'ar' ? 'غلاف رئيسي' : 'Cover Image' }}
                </a>
                <a href="{{ route('admin.media.index', array_merge(request()->except(['page']), ['collection' => 'gallery'])) }}" class="px-2 py-1 border text-[11px] {{ $collection === 'gallery' ? 'bg-blue-700 text-white border-blue-800' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }}">
                    {{ app()->getLocale() === 'ar' ? 'معرض صور' : 'Gallery' }}
                </a>
            </div>

            <span class="text-[#E4DFD8] hidden sm:inline">|</span>

            <!-- Folders Dropdown / Links -->
            @if($folders->count() > 0)
                <div class="flex items-center gap-1">
                    <span class="font-semibold text-[#172A35] text-[11px]">{{ app()->getLocale() === 'ar' ? 'المجلد:' : 'Folder:' }}</span>
                    @foreach($folders->take(3) as $folder)
                        <a href="{{ route('admin.media.index', array_merge(request()->except(['folder', 'page']), ['folder' => $folder->id])) }}" class="px-2 py-1 text-[11px] border {{ $currentFolderId == $folder->id ? 'bg-[#A99776] text-[#0F1C23] border-[#8E7E60] font-bold' : 'bg-[#F8F9FA] text-[#596269] border-[#E4DFD8] hover:bg-[#F0ECE1]' }} flex items-center gap-1">
                            <svg class="w-3 h-3 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            <span>{{ $folder->name }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Search input -->
        <form method="GET" action="{{ route('admin.media.index') }}" class="w-full lg:w-72 flex items-center">
            @if(request('section'))
                <input type="hidden" name="section" value="{{ request('section') }}">
            @endif
            @if(request('collection'))
                <input type="hidden" name="collection" value="{{ request('collection') }}">
            @endif
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="{{ app()->getLocale() === 'ar' ? 'بحث باسم الملف أو العنصر...' : 'Search by file name...' }}" 
                class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] focus:bg-white focus:outline-hidden"
            >
            <button type="submit" class="px-3.5 py-2 bg-[#172A35] text-white hover:bg-[#A99776] text-xs transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    <!-- Active Filters Notice -->
    @if(request('section') || request('collection') || request('folder') || request('search'))
        <div class="flex items-center justify-between bg-[#FAF8F4] px-4 py-2 border border-[#E4DFD8] text-xs">
            <div class="flex items-center gap-2 text-[#172A35]">
                <span class="font-bold">{{ app()->getLocale() === 'ar' ? 'تصفية مفعلة:' : 'Active filters:' }}</span>
                @if(request('section'))
                    <span class="px-2 py-0.5 bg-white border border-[#C8C0B5]">{{ request('section') }}</span>
                @endif
                @if(request('collection'))
                    <span class="px-2 py-0.5 bg-white border border-[#C8C0B5]">{{ request('collection') }}</span>
                @endif
                @if(request('search'))
                    <span class="px-2 py-0.5 bg-white border border-[#C8C0B5]">"{{ request('search') }}"</span>
                @endif
            </div>
            <a href="{{ route('admin.media.index') }}" class="text-red-600 hover:text-red-800 font-semibold underline text-xs">
                {{ app()->getLocale() === 'ar' ? 'إعادة ضبط كافة الفلاتر' : 'Reset all filters' }}
            </a>
        </div>
    @endif

    <!-- GRID VIEW -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($media as $item)
            @php
                $isImage = str_starts_with($item->mime_type, 'image/');
                $url = $item->getUrl();
                $sizeKb = round($item->size / 1024, 1);
                $model = $item->model;

                $context = [
                    'section' => app()->getLocale() === 'ar' ? 'مكتبة الوسائط العامة' : 'General Media Library',
                    'section_color' => 'bg-gray-800 text-white',
                    'page_name' => app()->getLocale() === 'ar' ? 'مستودع الوسائط العام' : 'General Asset Repository',
                    'item_title' => $item->name,
                    'edit_url' => null,
                    'site_url' => null,
                    'placement' => app()->getLocale() === 'ar' ? 'ملف عام' : 'General Asset',
                    'placement_color' => 'bg-gray-100 text-gray-800 border-gray-300',
                ];

                if ($model instanceof \App\Models\Project) {
                    $slug = $model->getTranslation('slug', app()->getLocale(), false) 
                        ?: $model->getTranslation('slug', 'ar', false) 
                        ?: $model->getTranslation('slug', 'en', false) 
                        ?: (string)$model->id;
                    $title = $model->getTranslation('title', app()->getLocale(), false) 
                        ?: $model->getTranslation('title', 'ar', false) 
                        ?: $model->getTranslation('title', 'en', false) 
                        ?: ('#' . $model->id);

                    $context['section'] = app()->getLocale() === 'ar' ? 'المشاريع الهندسية' : 'Engineering Projects';
                    $context['section_color'] = 'bg-[#172A35] text-[#F5F1E8] border border-[#233642]';
                    $context['page_name'] = app()->getLocale() === 'ar' ? 'صفحة تفاصيل المشروع' : 'Project Details Page';
                    $context['item_title'] = $title;
                    $context['edit_url'] = route('admin.projects.edit', $model);
                    $context['site_url'] = route('site.projects.show', ['locale' => app()->getLocale(), 'slug' => $slug]);

                    if ($item->collection_name === 'cover') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'صورة الغلاف الرئيسية (Hero)' : 'Main Cover Image (Hero)';
                        $context['placement_color'] = 'bg-amber-100 text-amber-900 border-amber-300';
                    } elseif ($item->collection_name === 'gallery') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'معرض صور المشروع (Gallery)' : 'Project Gallery Image';
                        $context['placement_color'] = 'bg-blue-100 text-blue-900 border-blue-300';
                    }
                } elseif ($model instanceof \App\Models\Elevator) {
                    $slug = $model->getTranslation('slug', app()->getLocale(), false) 
                        ?: $model->getTranslation('slug', 'ar', false) 
                        ?: $model->getTranslation('slug', 'en', false) 
                        ?: (string)$model->id;
                    $name = $model->getTranslation('name', app()->getLocale(), false) 
                        ?: $model->getTranslation('name', 'ar', false) 
                        ?: $model->getTranslation('name', 'en', false) 
                        ?: ('#' . $model->id);

                    $context['section'] = app()->getLocale() === 'ar' ? 'أنظمة وموديلات المصاعد' : 'Elevator Models';
                    $context['section_color'] = 'bg-[#A99776] text-[#0F1C23] border border-[#8E7E60] font-bold';
                    $context['page_name'] = app()->getLocale() === 'ar' ? 'صفحة تفاصيل المصعد' : 'Elevator Details Page';
                    $context['item_title'] = $name;
                    $context['edit_url'] = route('admin.elevators.edit', $model);
                    $context['site_url'] = route('site.elevators.show', ['locale' => app()->getLocale(), 'slug' => $slug]);

                    if ($item->collection_name === 'cover') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'صورة الغلاف والكتالوج' : 'Cover & Catalog Image';
                        $context['placement_color'] = 'bg-amber-100 text-amber-900 border-amber-300';
                    } elseif ($item->collection_name === 'gallery') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'معرض صور الكابينة والمكونات' : 'Cabin Gallery Image';
                        $context['placement_color'] = 'bg-blue-100 text-blue-900 border-blue-300';
                    }
                } elseif ($model instanceof \App\Models\Article) {
                    $slug = $model->getTranslation('slug', app()->getLocale(), false) 
                        ?: $model->getTranslation('slug', 'ar', false) 
                        ?: $model->getTranslation('slug', 'en', false) 
                        ?: (string)$model->id;
                    $title = $model->getTranslation('title', app()->getLocale(), false) 
                        ?: $model->getTranslation('title', 'ar', false) 
                        ?: $model->getTranslation('title', 'en', false) 
                        ?: ('#' . $model->id);

                    $context['section'] = app()->getLocale() === 'ar' ? 'المدونة والمقالات' : 'Blog & News';
                    $context['section_color'] = 'bg-emerald-800 text-white border border-emerald-900';
                    $context['page_name'] = app()->getLocale() === 'ar' ? 'صفحة المقال' : 'Article Page';
                    $context['item_title'] = $title;
                    $context['edit_url'] = route('admin.blog.edit', $model);
                    $context['site_url'] = route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $slug]);

                    if ($item->collection_name === 'cover') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'صورة واجهة المقال (Cover)' : 'Article Cover Image';
                        $context['placement_color'] = 'bg-amber-100 text-amber-900 border-amber-300';
                    }
                } elseif ($model instanceof \App\Models\Service) {
                    $slug = $model->getTranslation('slug', app()->getLocale(), false) 
                        ?: $model->getTranslation('slug', 'ar', false) 
                        ?: $model->getTranslation('slug', 'en', false) 
                        ?: (string)$model->id;
                    $title = $model->getTranslation('title', app()->getLocale(), false) 
                        ?: $model->getTranslation('title', 'ar', false) 
                        ?: $model->getTranslation('title', 'en', false) 
                        ?: ('#' . $model->id);

                    $context['section'] = app()->getLocale() === 'ar' ? 'الخدمات الهندسية' : 'Services';
                    $context['section_color'] = 'bg-teal-800 text-white border border-teal-900';
                    $context['page_name'] = app()->getLocale() === 'ar' ? 'صفحة الخدمة' : 'Service Page';
                    $context['item_title'] = $title;
                    $context['edit_url'] = route('admin.services.edit', $model);
                    $context['site_url'] = route('site.services.show', ['locale' => app()->getLocale(), 'slug' => $slug]);

                    if ($item->collection_name === 'cover') {
                        $context['placement'] = app()->getLocale() === 'ar' ? 'صورة واجهة الخدمة' : 'Service Cover Image';
                        $context['placement_color'] = 'bg-amber-100 text-amber-900 border-amber-300';
                    }
                }

                $previewData = [
                    'url' => $url,
                    'name' => $item->name,
                    'file_name' => $item->file_name,
                    'size' => $sizeKb . ' KB',
                    'section' => $context['section'],
                    'placement' => $context['placement'],
                    'item_title' => $context['item_title'],
                    'edit_url' => $context['edit_url'],
                    'site_url' => $context['site_url'],
                ];
            @endphp

            <div class="bg-white border border-[#E4DFD8] hover:border-[#172A35] transition-all duration-200 shadow-xs flex flex-col justify-between group overflow-hidden">
                <!-- Image Box with Badges -->
                <div class="relative aspect-16/10 bg-[#172A35] flex items-center justify-center overflow-hidden cursor-pointer" @click="openPreview({{ \Illuminate\Support\Js::from($previewData) }})">
                    @if($isImage)
                        <img src="{{ $url }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="flex flex-col items-center justify-center p-3 text-center text-[#F5F1E8]">
                            <svg class="w-10 h-10 text-[#A99776] mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-mono uppercase">{{ $item->extension ?? 'DOC' }}</span>
                        </div>
                    @endif

                    <!-- Top Floating Badges (Section & Placement) -->
                    <div class="absolute top-2 inset-x-2 flex items-center justify-between gap-1 pointer-events-none">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-none shadow-sm {{ $context['section_color'] }}">
                            {{ $context['section'] }}
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 border rounded-none shadow-sm {{ $context['placement_color'] }}">
                            {{ $context['placement'] }}
                        </span>
                    </div>

                    <!-- Center Hover Indicator -->
                    <div class="absolute inset-0 bg-[#0F1C23]/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                        <span class="px-3 py-1.5 bg-white text-[#172A35] text-xs font-bold shadow-lg flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'معاينة وتكبير' : 'Click to Preview' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-3.5 space-y-3 flex-1 flex flex-col justify-between">
                    <!-- File Name & Meta -->
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold text-xs text-[#172A35] truncate flex-1" title="{{ $item->name }}">
                                {{ $item->name }}
                            </h3>
                            <span class="text-[10px] font-mono font-bold px-1.5 py-0.5 bg-[#F0ECE1] text-[#172A35] shrink-0 uppercase">
                                {{ $item->extension ?? 'FILE' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-[10px] text-[#778087] font-mono mt-1">
                            <span>{{ $sizeKb }} KB</span>
                            <span>&bull;</span>
                            <span>{{ $item->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>

                    <!-- Usage Context Box (Where it appears on the website) -->
                    <div class="p-2.5 bg-[#F8F9FA] border border-[#E4DFD8] space-y-2 text-xs">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-[#778087] font-semibold">{{ app()->getLocale() === 'ar' ? 'موضع الصورة في الموقع:' : 'Used in:' }}</span>
                            <span class="font-bold text-[#172A35] text-[10px] px-1.5 py-0.2 bg-white border border-[#E4DFD8]">
                                {{ $context['page_name'] }}
                            </span>
                        </div>

                        <div class="font-semibold text-[#172A35] text-xs truncate flex items-center gap-1.5" title="{{ $context['item_title'] }}">
                            <svg class="w-3.5 h-3.5 text-[#A99776] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span class="truncate">{{ $context['item_title'] }}</span>
                        </div>

                        <!-- Direct quick links to Edit parent or View on live site -->
                        @if($context['edit_url'] || $context['site_url'])
                            <div class="flex items-center gap-2 pt-1 border-t border-[#E4DFD8]/80">
                                @if($context['edit_url'])
                                    <a 
                                        href="{{ $context['edit_url'] }}" 
                                        class="text-[11px] font-bold text-[#172A35] hover:text-[#A99776] flex items-center gap-1 transition-colors"
                                    >
                                        <svg class="w-3 h-3 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'تعديل الأصل' : 'Edit' }}</span>
                                    </a>
                                @endif

                                @if($context['site_url'])
                                    <a 
                                        href="{{ $context['site_url'] }}" 
                                        target="_blank" 
                                        class="text-[11px] font-bold text-[#778087] hover:text-[#172A35] flex items-center gap-1 transition-colors ms-auto"
                                    >
                                        <span>{{ app()->getLocale() === 'ar' ? 'عرض بالموقع' : 'View on site' }}</span>
                                        <svg class="w-3 h-3 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Footer Action Buttons (Visible, stylish, clearly labeled) -->
                <div class="px-3 py-2.5 bg-[#FAF8F4] border-t border-[#E4DFD8] flex items-center justify-between gap-1.5">
                    <div class="flex items-center gap-1">
                        <!-- Preview Button -->
                        <button 
                            type="button" 
                            @click="openPreview({{ \Illuminate\Support\Js::from($previewData) }})" 
                            class="px-2 py-1.5 bg-white border border-[#C8C0B5] hover:border-[#172A35] hover:bg-[#172A35] hover:text-white text-[#172A35] transition-colors text-[11px] font-semibold flex items-center gap-1 cursor-pointer"
                            title="{{ app()->getLocale() === 'ar' ? 'معاينة وتكبير' : 'Preview' }}"
                        >
                            <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'معاينة' : 'View' }}</span>
                        </button>

                        <!-- Copy URL Button -->
                        <button 
                            type="button" 
                            @click="copyLink('{{ $url }}')" 
                            class="px-2 py-1.5 bg-white border border-[#C8C0B5] hover:border-[#172A35] hover:bg-[#172A35] hover:text-white text-[#172A35] transition-colors text-[11px] font-semibold flex items-center gap-1 cursor-pointer"
                            title="{{ app()->getLocale() === 'ar' ? 'نسخ الرابط المباشر' : 'Copy direct URL' }}"
                        >
                            <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}</span>
                        </button>
                    </div>

                    <!-- Delete Button Form -->
                    <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذه الصورة؟ سيتم إزالتها من الموقع ومن الملف التابع لها نهائياً.' : 'Are you sure you want to permanently delete this media file?' }}');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="px-2.5 py-1.5 bg-white border border-red-200 hover:bg-red-600 hover:border-red-600 hover:text-white text-red-600 transition-colors text-[11px] font-bold flex items-center gap-1 cursor-pointer" 
                            title="{{ app()->getLocale() === 'ar' ? 'حذف الصورة نهائياً' : 'Delete file' }}"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}</span>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-[#778087] bg-white border border-[#E4DFD8] shadow-xs">
                <svg class="w-12 h-12 mx-auto text-[#C8C0B5] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <div class="font-bold text-base text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'لا توجد وسائط أو ملفات مطابقة' : 'No media files found' }}</div>
                <div class="text-xs text-[#778087] mt-1">{{ app()->getLocale() === 'ar' ? 'جرب تغيير خيارات التصفية أو اضغط "رفع ملفات جديدة" لإضافة صور إلى المكتبة.' : 'Try changing your filter options or click "Upload Files" to add new images.' }}</div>
            </div>
        @endforelse
    </div>

    <!-- TABLE / LIST VIEW -->
    <div x-show="viewMode === 'list'" style="display: none;" class="bg-white border border-[#E4DFD8] shadow-xs overflow-x-auto">
        <table class="w-full text-start text-xs border-collapse">
            <thead>
                <tr class="bg-[#FAF8F4] border-b border-[#E4DFD8] text-[#172A35] text-[11px] font-bold uppercase tracking-wider">
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المعاينة' : 'Thumbnail' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم الملف والنوع' : 'File Name & Size' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'القسم في الموقع' : 'Section' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'موضع الظهور / نوع الاستخدام' : 'Placement' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'العنصر التابع له' : 'Linked Entity' }}</th>
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'تاريخ الرفع' : 'Date' }}</th>
                    <th class="py-3 px-4 text-end">{{ app()->getLocale() === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4DFD8]">
                @forelse($media as $item)
                    @php
                        $isImage = str_starts_with($item->mime_type, 'image/');
                        $url = $item->getUrl();
                        $sizeKb = round($item->size / 1024, 1);
                        $model = $item->model;

                        $context = [
                            'section' => app()->getLocale() === 'ar' ? 'مكتبة عامة' : 'General',
                            'section_color' => 'bg-gray-800 text-white',
                            'item_title' => $item->name,
                            'edit_url' => null,
                            'site_url' => null,
                            'placement' => app()->getLocale() === 'ar' ? 'ملف عام' : 'General Asset',
                            'placement_color' => 'bg-gray-100 text-gray-800 border-gray-300',
                        ];

                        if ($model instanceof \App\Models\Project) {
                            $slug = $model->getTranslation('slug', app()->getLocale(), false) ?: $model->getTranslation('slug', 'ar', false) ?: (string)$model->id;
                            $title = $model->getTranslation('title', app()->getLocale(), false) ?: $model->getTranslation('title', 'ar', false) ?: ('#' . $model->id);
                            $context['section'] = app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects';
                            $context['section_color'] = 'bg-[#172A35] text-[#F5F1E8]';
                            $context['item_title'] = $title;
                            $context['edit_url'] = route('admin.projects.edit', $model);
                            $context['site_url'] = route('site.projects.show', ['locale' => app()->getLocale(), 'slug' => $slug]);
                            $context['placement'] = $item->collection_name === 'cover' ? 'غلاف رئيسي (Hero)' : 'معرض صور (Gallery)';
                            $context['placement_color'] = $item->collection_name === 'cover' ? 'bg-amber-100 text-amber-900 border-amber-300' : 'bg-blue-100 text-blue-900 border-blue-300';
                        } elseif ($model instanceof \App\Models\Elevator) {
                            $slug = $model->getTranslation('slug', app()->getLocale(), false) ?: $model->getTranslation('slug', 'ar', false) ?: (string)$model->id;
                            $name = $model->getTranslation('name', app()->getLocale(), false) ?: $model->getTranslation('name', 'ar', false) ?: ('#' . $model->id);
                            $context['section'] = app()->getLocale() === 'ar' ? 'المصاعد' : 'Elevators';
                            $context['section_color'] = 'bg-[#A99776] text-[#0F1C23] font-bold';
                            $context['item_title'] = $name;
                            $context['edit_url'] = route('admin.elevators.edit', $model);
                            $context['site_url'] = route('site.elevators.show', ['locale' => app()->getLocale(), 'slug' => $slug]);
                            $context['placement'] = $item->collection_name === 'cover' ? 'صورة الغلاف' : 'معرض الصور';
                            $context['placement_color'] = $item->collection_name === 'cover' ? 'bg-amber-100 text-amber-900 border-amber-300' : 'bg-blue-100 text-blue-900 border-blue-300';
                        } elseif ($model instanceof \App\Models\Article) {
                            $slug = $model->getTranslation('slug', app()->getLocale(), false) ?: $model->getTranslation('slug', 'ar', false) ?: (string)$model->id;
                            $title = $model->getTranslation('title', app()->getLocale(), false) ?: $model->getTranslation('title', 'ar', false) ?: ('#' . $model->id);
                            $context['section'] = app()->getLocale() === 'ar' ? 'المدونة' : 'Blog';
                            $context['section_color'] = 'bg-emerald-800 text-white';
                            $context['item_title'] = $title;
                            $context['edit_url'] = route('admin.blog.edit', $model);
                            $context['site_url'] = route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $slug]);
                            $context['placement'] = 'صورة الغلاف';
                            $context['placement_color'] = 'bg-amber-100 text-amber-900 border-amber-300';
                        }

                        $previewData = [
                            'url' => $url,
                            'name' => $item->name,
                            'file_name' => $item->file_name,
                            'size' => $sizeKb . ' KB',
                            'section' => $context['section'],
                            'placement' => $context['placement'],
                            'item_title' => $context['item_title'],
                            'edit_url' => $context['edit_url'],
                            'site_url' => $context['site_url'],
                        ];
                    @endphp

                    <tr class="hover:bg-[#FAF8F4] transition-colors">
                        <!-- Thumbnail -->
                        <td class="py-3 px-4">
                            <div class="w-14 h-14 bg-[#172A35] border border-[#E4DFD8] overflow-hidden cursor-pointer shrink-0" @click="openPreview({{ \Illuminate\Support\Js::from($previewData) }})">
                                @if($isImage)
                                    <img src="{{ $url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[10px] font-mono text-[#A99776]">
                                        {{ $item->extension ?? 'DOC' }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Name & Size -->
                        <td class="py-3 px-4">
                            <div class="font-bold text-xs text-[#172A35] max-w-xs truncate" title="{{ $item->name }}">
                                {{ $item->name }}
                            </div>
                            <div class="text-[10px] text-[#778087] font-mono mt-0.5">
                                {{ $item->file_name }} &bull; {{ $sizeKb }} KB &bull; {{ strtoupper($item->extension ?? '') }}
                            </div>
                        </td>

                        <!-- Section Badge -->
                        <td class="py-3 px-4">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-none {{ $context['section_color'] }}">
                                {{ $context['section'] }}
                            </span>
                        </td>

                        <!-- Placement Badge -->
                        <td class="py-3 px-4">
                            <span class="text-[10px] font-bold px-2 py-0.5 border rounded-none {{ $context['placement_color'] }}">
                                {{ $context['placement'] }}
                            </span>
                        </td>

                        <!-- Linked Entity -->
                        <td class="py-3 px-4 max-w-xs">
                            <div class="font-semibold text-xs text-[#172A35] truncate" title="{{ $context['item_title'] }}">
                                {{ $context['item_title'] }}
                            </div>
                            @if($context['edit_url'] || $context['site_url'])
                                <div class="flex items-center gap-2 mt-1">
                                    @if($context['edit_url'])
                                        <a href="{{ $context['edit_url'] }}" class="text-[10px] text-[#A99776] hover:underline font-bold">
                                            {{ app()->getLocale() === 'ar' ? 'تعديل الأصل ↗' : 'Edit Parent ↗' }}
                                        </a>
                                    @endif
                                    @if($context['site_url'])
                                        <a href="{{ $context['site_url'] }}" target="_blank" class="text-[10px] text-[#596269] hover:underline">
                                            {{ app()->getLocale() === 'ar' ? 'معاينة بالموقع ↗' : 'Live Site ↗' }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </td>

                        <!-- Upload Date -->
                        <td class="py-3 px-4 text-[#778087] font-mono text-[11px] whitespace-nowrap">
                            {{ $item->created_at->format('Y-m-d') }}
                        </td>

                        <!-- Actions -->
                        <td class="py-3 px-4 text-end whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5">
                                <button 
                                    type="button" 
                                    @click="openPreview({{ \Illuminate\Support\Js::from($previewData) }})" 
                                    class="p-1.5 bg-white border border-[#C8C0B5] hover:bg-[#172A35] hover:text-white text-[#172A35] transition-colors cursor-pointer"
                                    title="{{ app()->getLocale() === 'ar' ? 'معاينة' : 'Preview' }}"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>

                                <button 
                                    type="button" 
                                    @click="copyLink('{{ $url }}')" 
                                    class="p-1.5 bg-white border border-[#C8C0B5] hover:bg-[#172A35] hover:text-white text-[#172A35] transition-colors cursor-pointer"
                                    title="{{ app()->getLocale() === 'ar' ? 'نسخ الرابط' : 'Copy URL' }}"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>

                                <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذه الصورة؟' : 'Are you sure you want to delete this media file?' }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="p-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-600 hover:text-white transition-colors cursor-pointer"
                                        title="{{ app()->getLocale() === 'ar' ? 'حذف' : 'Delete' }}"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-[#778087]">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد وسائط مطابقة' : 'No media records found.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($media->hasPages())
        <div class="p-4 bg-white border border-[#E4DFD8] shadow-xs">
            {{ $media->links() }}
        </div>
    @endif

    <!-- Toast Notification for Copied URL -->
    <div 
        x-show="copied" 
        x-transition 
        class="fixed bottom-6 start-6 z-50 bg-[#172A35] text-[#F5F1E8] px-4 py-2.5 text-xs font-semibold shadow-2xl border border-[#A99776] flex items-center gap-2"
        style="display: none;"
    >
        <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span>{{ app()->getLocale() === 'ar' ? 'تم نسخ رابط الصورة إلى الحافظة بنجاح!' : 'Media URL copied to clipboard!' }}</span>
    </div>

    <!-- LIGHTBOX PREVIEW MODAL -->
    <div 
        x-show="previewModal" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F1C23]/80 backdrop-blur-xs p-4 sm:p-6" 
        style="display: none;"
        @click.self="previewModal = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <div class="bg-white max-w-4xl w-full border border-[#E4DFD8] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-[#F0ECE1] bg-[#FAF8F4]">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-[#A99776]"></span>
                    <h3 class="font-serif font-bold text-sm text-[#172A35] truncate" x-text="previewData.name"></h3>
                </div>
                <button @click="previewModal = false" class="text-[#778087] hover:text-[#172A35] text-xl font-bold p-1 leading-none">&times;</button>
            </div>

            <!-- Modal Content (Image + Details) -->
            <div class="grid grid-cols-1 md:grid-cols-3 flex-1 overflow-y-auto">
                <!-- Large Image Viewer -->
                <div class="md:col-span-2 bg-[#0F1C23] flex items-center justify-center p-4 min-h-[300px]">
                    <img :src="previewData.url" :alt="previewData.name" class="max-h-[60vh] max-w-full object-contain">
                </div>

                <!-- Side Details Panel -->
                <div class="p-5 bg-white border-t md:border-t-0 md:border-s border-[#E4DFD8] space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[#A99776] border-b border-[#F0ECE1] pb-1.5">
                            {{ app()->getLocale() === 'ar' ? 'معلومات موضع الاستخدام' : 'Usage & Context' }}
                        </div>

                        <div>
                            <span class="block text-[11px] text-[#778087]">{{ app()->getLocale() === 'ar' ? 'القسم في الموقع:' : 'Section:' }}</span>
                            <span class="font-bold text-xs text-[#172A35]" x-text="previewData.section"></span>
                        </div>

                        <div>
                            <span class="block text-[11px] text-[#778087]">{{ app()->getLocale() === 'ar' ? 'نوع الظهور:' : 'Placement:' }}</span>
                            <span class="font-bold text-xs text-[#A99776]" x-text="previewData.placement"></span>
                        </div>

                        <div>
                            <span class="block text-[11px] text-[#778087]">{{ app()->getLocale() === 'ar' ? 'العنصر التابع له:' : 'Attached To:' }}</span>
                            <span class="font-bold text-xs text-[#172A35]" x-text="previewData.item_title"></span>
                        </div>

                        <div>
                            <span class="block text-[11px] text-[#778087]">{{ app()->getLocale() === 'ar' ? 'حجم الملف:' : 'File Size:' }}</span>
                            <span class="font-mono text-xs text-[#172A35]" x-text="previewData.size"></span>
                        </div>

                        <div>
                            <span class="block text-[11px] text-[#778087] mb-1">{{ app()->getLocale() === 'ar' ? 'الرابط المباشر:' : 'Direct URL:' }}</span>
                            <div class="flex items-center gap-1.5">
                                <input type="text" readonly :value="previewData.url" class="w-full text-[10px] font-mono px-2 py-1 bg-[#F8F9FA] border border-[#C8C0B5]">
                                <button type="button" @click="copyLink(previewData.url)" class="px-2 py-1 bg-[#172A35] text-white hover:bg-[#A99776] text-[10px] font-bold shrink-0 transition-colors">
                                    {{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Links in Modal -->
                    <div class="pt-4 border-t border-[#F0ECE1] space-y-2">
                        <template x-if="previewData.edit_url">
                            <a :href="previewData.edit_url" class="w-full text-center block px-3 py-2 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] hover:text-[#0F1C23] text-xs font-bold uppercase tracking-wider transition-colors">
                                {{ app()->getLocale() === 'ar' ? 'فتح صفحة تعديل الأصل ↗' : 'Edit Parent Item ↗' }}
                            </a>
                        </template>

                        <template x-if="previewData.site_url">
                            <a :href="previewData.site_url" target="_blank" class="w-full text-center block px-3 py-2 border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] text-xs font-semibold transition-colors">
                                {{ app()->getLocale() === 'ar' ? 'معاينة في الموقع الحي ↗' : 'View on Live Site ↗' }}
                            </a>
                        </template>

                        <a :href="previewData.url" target="_blank" download class="w-full text-center block px-3 py-1.5 text-xs text-[#778087] hover:text-[#172A35] hover:underline">
                            {{ app()->getLocale() === 'ar' ? 'تحميل الصورة الأصلية' : 'Download Original' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div 
        x-show="uploadModal" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F1C23]/60 backdrop-blur-xs p-4" 
        style="display: none;"
        @click.self="uploadModal = false"
    >
        <div class="bg-white max-w-lg w-full p-6 border border-[#E4DFD8] shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-3">
                <h3 class="font-serif font-bold text-base text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'رفع ملفات جديدة إلى المكتبة' : 'Upload New Media' }}
                </h3>
                <button @click="uploadModal = false" class="text-[#778087] hover:text-[#172A35] text-lg font-bold p-1 leading-none">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'المجلد الهدف' : 'Target Folder' }}
                    </label>
                    <select name="folder_id" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <option value="">{{ app()->getLocale() === 'ar' ? '— المجلد الافتراضي (عام) —' : '— Default (General) —' }}</option>
                        @foreach($folders as $folder)
                            <option value="{{ $folder->id }}" {{ $currentFolderId == $folder->id ? 'selected' : '' }}>{{ $folder->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="border-2 border-dashed border-[#C8C0B5] p-8 text-center bg-[#F8F9FA] hover:bg-[#F5F1E8] transition-colors">
                    <svg class="w-10 h-10 mx-auto text-[#A99776] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <label class="block cursor-pointer">
                        <span class="text-xs font-bold text-[#172A35] block mb-1">
                            {{ app()->getLocale() === 'ar' ? 'اختر ملفات من جهازك أو اسحبها هنا' : 'Choose files from device or drag here' }}
                        </span>
                        <span class="text-[11px] text-[#778087] block mb-3">JPG, PNG, WEBP, SVG, PDF, DOCX (حتى 20 ميجابايت لكل ملف)</span>
                        <input type="file" name="files[]" multiple required class="text-xs w-full">
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="uploadModal = false" class="px-4 py-2 text-xs font-semibold text-[#596269] hover:text-[#172A35]">
                        {{ __('admin.cancel') }}
                    </button>
                    <button type="submit" class="px-6 py-2 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'بدء الرفع' : 'Start Upload' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- New Folder Modal -->
    <div 
        x-show="folderModal" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F1C23]/60 backdrop-blur-xs p-4" 
        style="display: none;"
        @click.self="folderModal = false"
    >
        <div class="bg-white max-w-sm w-full p-6 border border-[#E4DFD8] shadow-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-3">
                <h3 class="font-serif font-bold text-base text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'إنشاء مجلد وسائط جديد' : 'New Media Folder' }}
                </h3>
                <button @click="folderModal = false" class="text-[#778087] hover:text-[#172A35] text-lg font-bold p-1 leading-none">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.media.folder.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'اسم المجلد *' : 'Folder Name *' }}
                    </label>
                    <input type="text" name="name" required placeholder="مثال: كتالوجات 2026 أو صور الفيلات" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" @click="folderModal = false" class="px-4 py-2 text-xs font-semibold text-[#596269] hover:text-[#172A35]">
                        {{ __('admin.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'إنشاء' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
