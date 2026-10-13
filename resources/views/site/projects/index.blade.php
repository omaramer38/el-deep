@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'سجل المشروعات والأعمال — الديب للمصاعد' : 'Portfolio of Engineering Projects — EL DEEB')

@section('content')
<!-- Header -->
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-2xl space-y-3" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'معرض الأعمال' : 'Architectural Portfolio' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold">
                {{ app()->getLocale() === 'ar' ? 'المشروعات والإنجازات الهندسية' : 'Engineering Projects' }}
            </h1>
            <p class="text-xs sm:text-sm text-[#C8C0B5] font-light">
                {{ app()->getLocale() === 'ar' ? 'نخبة من كبرى المشروعات التجارية والسكنية والطبية التي شيدت بأعلى معايير الحركة والجمال.' : 'Selected prestigious installations across commercial, residential, and healthcare sectors.' }}
            </p>
        </div>
    </div>
</section>

<!-- Filter & Grid -->
<section class="py-16 bg-[#F5F1E8]" x-data="{
    filterCategory: '{{ request('category') }}',
    filterYear: '{{ request('year') }}',
    search: '{{ request('search') }}',
    applyFilter() {
        const params = new URLSearchParams();
        if (this.filterCategory) params.set('category', this.filterCategory);
        if (this.filterYear) params.set('year', this.filterYear);
        if (this.search) params.set('search', this.search);
        window.location.search = params.toString();
    }
}">
    <div class="container-custom">
        <!-- Filter Toolbar -->
        <div class="bg-white p-6 border border-[#C8C0B5] mb-12 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Categories Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <button 
                    @click="filterCategory = ''; applyFilter()" 
                    :class="!filterCategory ? 'bg-[#172A35] text-white' : 'bg-[#FAF8F4] text-[#596269] hover:text-[#172A35]'"
                    class="px-4 py-2 text-xs uppercase tracking-wider font-semibold border border-[#C8C0B5] transition-colors cursor-pointer"
                >
                    {{ __('site.common.all') }}
                </button>
                @foreach($categories as $cat)
                    <button 
                        @click="filterCategory = '{{ $cat->slug }}'; applyFilter()" 
                        :class="filterCategory === '{{ $cat->slug }}' ? 'bg-[#172A35] text-white' : 'bg-[#FAF8F4] text-[#596269] hover:text-[#172A35]'"
                        class="px-4 py-2 text-xs uppercase tracking-wider font-semibold border border-[#C8C0B5] transition-colors cursor-pointer"
                    >
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

            <!-- Search Field -->
            <div class="flex items-center gap-2">
                <input 
                    type="search" 
                    x-model="search" 
                    @keydown.enter="applyFilter()"
                    placeholder="{{ __('site.common.filter_by') }}..."
                    class="bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-2 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"
                >
                <button @click="applyFilter()" class="bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] px-4 py-2 text-xs uppercase tracking-wider font-semibold transition-colors cursor-pointer">
                    {{ __('admin.search') }}
                </button>
            </div>
        </div>

        <!-- Dynamic Grid Partial -->
        @include('site.projects._grid')
    </div>
</section>
@endsection
