@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'المقالات والأخبار الهندسية — الديب للمصاعد' : 'Engineering Insights & Articles — EL DEEB')

@section('content')
<!-- Blog Hero Header -->
<section class="py-16 md:py-20 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-3xl space-y-4" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'رؤى هندسية ومقالات' : 'Technical Insights & News' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold leading-tight">
                {{ app()->getLocale() === 'ar' ? 'المقالات والأبحاث الهندسية' : 'Articles & Industry Insights' }}
            </h1>
            <p class="text-sm sm:text-base text-[#C8C0B5] font-light leading-relaxed">
                {{ app()->getLocale() === 'ar' ? 'أحدث الدراسات المتخصصة في تكنولوجيا المصاعد، كفاءة الطاقة، والسلامة المعمارية.' : 'Engineering perspectives on vertical transportation, energy efficiency, and European safety compliance.' }}
            </p>

            <!-- Category Filter Tabs -->
            @if(isset($categories) && $categories->count() > 0)
                <div class="pt-4 flex flex-wrap items-center gap-2">
                    <a 
                        href="{{ route('site.blog.index', ['locale' => app()->getLocale()]) }}" 
                        class="px-4 py-2 text-xs font-semibold rounded-[2px] transition-all duration-200 {{ !request('category') ? 'bg-[#A99776] text-[#0F1C23]' : 'bg-[#233642] text-[#C8C0B5] hover:bg-[#A99776] hover:text-[#0F1C23]' }}"
                    >
                        {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }}
                    </a>
                    @foreach($categories as $cat)
                        @php
                            $catSlug = $cat->getTranslation('slug', app()->getLocale());
                            $catName = $cat->getTranslation('name', app()->getLocale());
                            $isActive = request('category') === $catSlug;
                        @endphp
                        <a 
                            href="{{ route('site.blog.index', ['locale' => app()->getLocale(), 'category' => $catSlug]) }}" 
                            class="px-4 py-2 text-xs font-semibold rounded-[2px] transition-all duration-200 {{ $isActive ? 'bg-[#A99776] text-[#0F1C23]' : 'bg-[#233642] text-[#C8C0B5] hover:bg-[#A99776] hover:text-[#0F1C23]' }}"
                        >
                            {{ $catName }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Blog Articles Main Container -->
<section class="py-16 md:py-24 bg-[#F5F1E8]">
    <div class="container-custom">
        <!-- Featured Article Banner -->
        @if($featuredArticle)
            @php
                $featImg = $featuredArticle->getFirstMediaUrl('cover');
                if (!$featImg && !empty($featuredArticle->cover_image)) {
                    $featImg = str_starts_with($featuredArticle->cover_image, 'http') ? $featuredArticle->cover_image : asset('storage/' . ltrim($featuredArticle->cover_image, '/'));
                }
                $featImg = $featImg ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg');
            @endphp
            <div class="mb-16 md:mb-20 bg-white border border-[#E4DFD8] shadow-md hover:shadow-2xl transition-all duration-300 grid grid-cols-1 lg:grid-cols-12 overflow-hidden group">
                <div class="lg:col-span-7 p-6 sm:p-10 md:p-12 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-xs text-[#778087]">
                            <span class="px-2.5 py-1 bg-[#F5F1E8] border border-[#E4DFD8] text-[#A99776] font-semibold uppercase tracking-wider text-[11px]">
                                {{ $featuredArticle->category->name ?? (app()->getLocale() === 'ar' ? 'مقال مميز' : 'Featured') }}
                            </span>
                            <span>&bull;</span>
                            <span>{{ $featuredArticle->reading_time ?: 4 }} {{ app()->getLocale() === 'ar' ? 'دقائق قراءة' : 'min read' }}</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-[#172A35] group-hover:text-[#A99776] transition-colors leading-snug">
                            <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $featuredArticle->slug]) }}">
                                {{ $featuredArticle->title }}
                            </a>
                        </h2>
                        <p class="text-xs sm:text-sm text-[#596269] leading-relaxed line-clamp-3">
                            {{ $featuredArticle->excerpt }}
                        </p>
                    </div>

                    <div class="pt-6 border-t border-[#E4DFD8] flex items-center justify-between mt-auto">
                        <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $featuredArticle->slug]) }}" class="inline-flex items-center gap-2 text-xs uppercase tracking-widest font-bold text-[#172A35] group-hover:text-[#A99776] transition-colors">
                            <span>{{ __('site.common.read_more') }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <span class="text-xs text-[#778087] font-medium">{{ $featuredArticle->publish_at ? $featuredArticle->publish_at->format('M d, Y') : date('M d, Y') }}</span>
                    </div>
                </div>

                <div class="lg:col-span-5 bg-[#172A35] h-64 sm:h-80 lg:h-auto min-h-[300px] overflow-hidden relative">
                    <img src="{{ $featImg }}" alt="{{ $featuredArticle->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#172A35]/40 to-transparent pointer-events-none"></div>
                </div>
            </div>
        @endif

        <!-- Section Header for Articles Grid -->
        @if($articles->count() > 0)
            <div class="mb-8 flex items-center justify-between border-b border-[#E4DFD8] pb-4">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 bg-[#A99776]"></span>
                    <h3 class="text-xl sm:text-2xl font-serif font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'أحدث المقالات والأبحاث' : 'Latest Articles & Publications' }}
                    </h3>
                </div>
                <span class="text-xs text-[#778087] font-medium">
                    {{ $articles->total() }} {{ app()->getLocale() === 'ar' ? 'مقال' : 'articles' }}
                </span>
            </div>

            <!-- Articles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    @php
                        $artImg = $article->getFirstMediaUrl('cover');
                        if (!$artImg && !empty($article->cover_image)) {
                            $artImg = str_starts_with($article->cover_image, 'http') ? $article->cover_image : asset('storage/' . ltrim($article->cover_image, '/'));
                        }
                        $artImg = $artImg ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg');
                    @endphp
                    <div class="bg-white border border-[#E4DFD8] hover:border-[#A99776] transition-all duration-300 flex flex-col justify-between group shadow-sm hover:shadow-xl overflow-hidden h-full">
                        <!-- Cover Image Wrapper with Fixed Height -->
                        <div class="h-56 w-full bg-[#172A35] overflow-hidden relative shrink-0">
                            <img src="{{ $artImg }}" alt="{{ $article->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#172A35]/30 to-transparent pointer-events-none"></div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-3 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 text-[11px] text-[#778087] font-medium">
                                <span class="text-[#A99776] font-semibold uppercase tracking-wider">{{ $article->category->name ?? (app()->getLocale() === 'ar' ? 'مقالات' : 'Engineering') }}</span>
                                <span>&bull;</span>
                                <span>{{ $article->reading_time ?: 3 }} {{ app()->getLocale() === 'ar' ? 'دقائق' : 'min read' }}</span>
                            </div>

                            <h4 class="text-lg font-serif font-bold text-[#172A35] group-hover:text-[#A99776] transition-colors leading-snug line-clamp-2">
                                <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}">
                                    {{ $article->title }}
                                </a>
                            </h4>

                            <p class="text-xs text-[#596269] line-clamp-3 leading-relaxed flex-1">
                                {{ $article->excerpt }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-[#FAF8F4] border-t border-[#E4DFD8] flex items-center justify-between mt-auto">
                            <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $article->slug]) }}" class="text-xs uppercase tracking-wider font-semibold text-[#172A35] group-hover:text-[#A99776] flex items-center gap-2 transition-colors">
                                <span>{{ __('site.common.read_more') }}</span>
                                <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }} group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <span class="text-[11px] text-[#778087] font-medium">{{ $article->publish_at ? $article->publish_at->format('M d, Y') : date('M d, Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white border border-[#E4DFD8] p-8">
                <p class="text-sm text-[#596269]">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد مقالات مضافة في هذا القسم حتى الآن.' : 'No articles available in this category yet.' }}
                </p>
            </div>
        @endif

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $articles->withQueryString()->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
