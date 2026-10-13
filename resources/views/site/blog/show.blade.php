@extends('layouts.site')

@section('meta_title', $article->title . ' — EL DEEB ELEVATOR & BUILDING SYSTEM')
@section('meta_description', $article->excerpt)

@section('content')
@php
    $coverUrl = $article->getFirstMediaUrl('cover');
    if (!$coverUrl && !empty($article->cover_image)) {
        $coverUrl = str_starts_with($article->cover_image, 'http') 
            ? $article->cover_image 
            : asset('storage/' . ltrim($article->cover_image, '/'));
    }
@endphp

<!-- Article Header Section -->
<section class="py-16 md:py-20 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642] relative overflow-hidden">
    <div class="container-custom max-w-4xl relative z-10 space-y-6">
        <!-- Breadcrumb Navigation -->
        <nav class="flex flex-wrap items-center gap-2 text-xs uppercase tracking-wider text-[#C8C0B5]">
            <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="hover:text-[#A99776] transition-colors">{{ __('site.nav.home') }}</a>
            <span class="text-[#A99776]">&bull;</span>
            <a href="{{ route('site.blog.index', ['locale' => app()->getLocale()]) }}" class="hover:text-[#A99776] transition-colors">{{ app()->getLocale() === 'ar' ? 'المقالات والبحوث' : 'Articles & Insights' }}</a>
            <span class="text-[#A99776]">&bull;</span>
            <span class="text-[#A99776] truncate max-w-xs sm:max-w-md">{{ $article->title }}</span>
        </nav>

        <!-- Category & Reading time -->
        <div class="flex items-center gap-3 text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
            <span>{{ $article->category->name ?? (app()->getLocale() === 'ar' ? 'دراسات هندسية' : 'Technical Paper') }}</span>
            <span>&bull;</span>
            <span>{{ $article->reading_time ?: 4 }} {{ app()->getLocale() === 'ar' ? 'دقائق قراءة' : 'min read' }}</span>
        </div>

        <!-- Article Main Title -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-bold text-[#F5F1E8] leading-tight tracking-tight">
            {{ $article->title }}
        </h1>

        <!-- Author & Date info strip -->
        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-[#233642] text-xs text-[#C8C0B5]">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-[#A99776] text-[#0F1C23] flex items-center justify-center font-bold text-xs uppercase">
                    {{ substr($article->author->name ?? 'E', 0, 1) }}
                </div>
                <span class="font-medium text-[#F5F1E8]">{{ $article->author->name ?? 'EL DEEB Editorial Team' }}</span>
            </div>
            <span>&bull;</span>
            <span>{{ app()->getLocale() === 'ar' ? 'تاريخ النشر: ' : 'Published on ' }}{{ $article->publish_at ? $article->publish_at->format('M d, Y') : date('M d, Y') }}</span>
        </div>
    </div>
</section>

<!-- Article Main Content Container -->
<section class="py-16 md:py-24 bg-[#F5F1E8]">
    <div class="container-custom max-w-4xl space-y-12">
        <div class="bg-white border border-[#E4DFD8] shadow-xl overflow-hidden">
            <!-- Featured Cover Image -->
            @if($coverUrl)
                <div class="w-full h-80 sm:h-96 md:h-[420px] bg-[#172A35] overflow-hidden relative">
                    <img src="{{ $coverUrl }}" alt="{{ $article->title }}" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#172A35]/30 to-transparent pointer-events-none"></div>
                </div>
            @endif

            <div class="p-8 sm:p-12 md:p-16 space-y-8">
                <!-- Excerpt / Summary Quote Box -->
                @if($article->excerpt)
                    <div class="p-6 bg-[#FAF8F4] border-s-4 border-[#A99776] text-base text-[#172A35] font-serif italic leading-relaxed">
                        "{{ $article->excerpt }}"
                    </div>
                @endif

                <!-- HTML Article Body -->
                <div class="prose prose-slate prose-base sm:prose-lg max-w-none text-[#2D3748] leading-relaxed font-sans prose-headings:font-serif prose-headings:font-bold prose-headings:text-[#172A35] prose-a:text-[#A99776] prose-a:no-underline hover:prose-a:underline prose-img:border prose-img:border-[#E4DFD8] prose-img:my-6">
                    {!! clean($article->content) !!}
                </div>

                <!-- Tags if present -->
                @if($article->tags && $article->tags->count() > 0)
                    <div class="pt-6 border-t border-[#E4DFD8] flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-[#172A35] uppercase tracking-wider me-2">{{ app()->getLocale() === 'ar' ? 'الوسوم:' : 'Tags:' }}</span>
                        @foreach($article->tags as $tag)
                            <span class="px-3 py-1 bg-[#F5F1E8] border border-[#E4DFD8] text-[11px] font-medium text-[#596269]">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- Share Actions Bar -->
                <div class="pt-8 border-t border-[#E4DFD8] flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex flex-wrap items-center gap-2.5 text-xs font-bold uppercase tracking-wider text-[#172A35]">
                        <span class="me-1">{{ app()->getLocale() === 'ar' ? 'مشاركة المقال:' : 'Share Article:' }}</span>
                        
                        <!-- WhatsApp -->
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" style="background-color: #25D366; color: #ffffff;" class="px-3.5 py-2 hover:opacity-90 transition-opacity flex items-center gap-2 font-semibold shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>WhatsApp</span>
                        </a>

                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" style="background-color: #0A66C2; color: #ffffff;" class="px-3.5 py-2 hover:opacity-90 transition-opacity flex items-center gap-2 font-semibold shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                            <span>LinkedIn</span>
                        </a>

                        <!-- X / Twitter -->
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" style="background-color: #172A35; color: #ffffff;" class="px-3.5 py-2 hover:bg-[#233642] transition-colors flex items-center gap-2 font-semibold shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            <span>X</span>
                        </a>
                    </div>

                    <a href="{{ route('site.blog.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-2 px-4 py-2 border border-[#172A35] text-[#172A35] hover:bg-[#172A35] hover:text-[#F5F1E8] text-xs uppercase tracking-widest font-bold transition-all shadow-xs">
                        <span>{{ app()->getLocale() === 'ar' ? 'العودة للمقالات' : 'Back to Articles' }}</span>
                        <span class="{{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Articles Section -->
        @if(isset($relatedArticles) && $relatedArticles->count() > 0)
            <div class="space-y-6 pt-6">
                <h3 class="text-2xl font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'مقالات ذات صلة' : 'Related Insights' }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        @php
                            $relImg = $rel->getFirstMediaUrl('cover');
                            if (!$relImg && !empty($rel->cover_image)) {
                                $relImg = str_starts_with($rel->cover_image, 'http') ? $rel->cover_image : asset('storage/' . ltrim($rel->cover_image, '/'));
                            }
                        @endphp
                        <div class="bg-white border border-[#E4DFD8] hover:border-[#A99776] transition-all duration-300 flex flex-col justify-between group shadow-sm hover:shadow-xl overflow-hidden">
                            @if($relImg)
                                <div class="h-44 w-full bg-[#172A35] overflow-hidden relative">
                                    <img src="{{ $relImg }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="p-5 space-y-2 flex-1 flex flex-col">
                                <span class="text-[10px] uppercase font-bold text-[#A99776]">{{ $rel->category->name ?? 'Article' }}</span>
                                <h4 class="text-sm font-serif font-bold text-[#172A35] group-hover:text-[#A99776] transition-colors line-clamp-2">
                                    <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $rel->slug]) }}">
                                        {{ $rel->title }}
                                    </a>
                                </h4>
                            </div>
                            <div class="px-5 py-3 bg-[#FAF8F4] border-t border-[#E4DFD8] text-[11px] font-bold text-[#172A35]">
                                <a href="{{ route('site.blog.show', ['locale' => app()->getLocale(), 'slug' => $rel->slug]) }}" class="hover:text-[#A99776] flex items-center justify-between">
                                    <span>{{ __('site.common.read_more') }}</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
