@extends('layouts.site')

@section('meta_title', $project->title . ' — EL DEEB ELEVATOR & BUILDING SYSTEM')
@section('meta_description', $project->short_description)

@section('content')
<!-- Header Hero -->
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[11px] uppercase tracking-wider text-[#778087] mb-6">
            <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.home') }}</a>
            <span>&bull;</span>
            <a href="{{ route('site.projects.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white">{{ __('site.nav.projects') }}</a>
            <span>&bull;</span>
            <span class="text-[#A99776]">{{ $project->title }}</span>
        </nav>

        <div class="max-w-3xl space-y-4">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ $project->category->name ?? 'Commercial Portfolio' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#F5F1E8]">
                {{ $project->title }}
            </h1>
            <p class="text-sm sm:text-base text-[#C8C0B5] font-light leading-relaxed">
                {{ $project->short_description }}
            </p>
        </div>
    </div>
</section>

<!-- Key Facts Bar (Section 5.6) -->
<section class="bg-white border-b border-[#C8C0B5]">
    <div class="container-custom py-6">
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-6 text-xs">
            <div>
                <span class="block text-[#778087] uppercase tracking-wider text-[10px]">{{ __('site.common.location') }}</span>
                <span class="font-bold text-[#172A35] mt-1 block">{{ $project->location ?? 'Cairo, Egypt' }}</span>
            </div>
            <div>
                <span class="block text-[#778087] uppercase tracking-wider text-[10px]">Project Category</span>
                <span class="font-bold text-[#172A35] mt-1 block">{{ $project->category->name ?? 'Commercial' }}</span>
            </div>
            <div>
                <span class="block text-[#778087] uppercase tracking-wider text-[10px]">{{ __('site.common.year') }}</span>
                <span class="font-bold text-[#172A35] mt-1 block">{{ $project->year ?? 2025 }}</span>
            </div>
            <div>
                <span class="block text-[#778087] uppercase tracking-wider text-[10px]">{{ __('site.common.elevators_count') }}</span>
                <span class="font-bold text-[#A99776] mt-1 block">{{ $project->elevators_count }} Units</span>
            </div>
            <div>
                <span class="block text-[#778087] uppercase tracking-wider text-[10px]">{{ __('site.common.service_type') }}</span>
                <span class="font-bold text-[#172A35] mt-1 block">{{ $project->service_type ?? 'Full Turnkey' }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Content & Imagery -->
<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 space-y-8">
                <!-- Cover Image -->
                <div class="bg-[#172A35] border border-[#C8C0B5] p-2">
                    <img src="{{ $project->getFirstMediaUrl('cover') ?: asset('images/brand/WhatsApp Image 2026-10-02 at 2.07.16 PM.jpeg') }}" alt="{{ $project->title }}" class="w-full h-96 object-cover">
                </div>

                @if($project->getMedia('gallery')->count() > 0)
                    <!-- Gallery -->
                    <div class="space-y-3">
                        <h3 class="text-xs uppercase tracking-wider font-bold text-[#172A35]">
                            {{ app()->getLocale() === 'ar' ? 'معرض صور المشروع والموقع' : 'Project & Site Gallery' }}
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach($project->getMedia('gallery') as $galleryImg)
                                <a href="{{ $galleryImg->getUrl() }}" target="_blank" class="block border border-[#C8C0B5] overflow-hidden aspect-[4/3] bg-[#172A35]">
                                    <img src="{{ $galleryImg->getUrl() }}" alt="{{ $project->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                <div class="bg-white p-8 border border-[#C8C0B5] space-y-4">
                    <h2 class="text-xl font-serif font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'تفاصيل التنفيذ الهندسي' : 'Project Engineering Details' }}
                    </h2>
                    <div class="text-sm text-[#596269] leading-relaxed">
                        {{ $project->description }}
                    </div>
                </div>

                <!-- Project Engineering Specs Table -->
                @if(!empty($project->specifications))
                    @php
                        $locale = app()->getLocale();
                        $specs = is_array($project->specifications) ? ($project->specifications[$locale] ?? $project->specifications['en'] ?? $project->specifications) : [];
                    @endphp
                    @if(count($specs) > 0)
                        <div class="bg-white p-8 border border-[#C8C0B5] space-y-6">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-[1px] bg-[#A99776]"></span>
                                <h2 class="text-lg font-serif font-bold text-[#172A35]">
                                    {{ app()->getLocale() === 'ar' ? 'المواصفات والمعايير الهندسية للمشروع' : 'Project Engineering Specifications' }}
                                </h2>
                            </div>

                            <div class="overflow-x-auto border border-[#E4DFD8]">
                                <table class="w-full text-xs text-start">
                                    <tbody class="divide-y divide-[#E4DFD8]">
                                        @foreach($specs as $key => $val)
                                            <tr class="hover:bg-[#FAF8F4] transition-colors">
                                                <td class="px-5 py-3.5 font-semibold text-[#172A35] bg-[#FAF8F4] w-1/3">{{ $key }}</td>
                                                <td class="px-5 py-3.5 text-[#596269]">{{ is_array($val) ? json_encode($val) : $val }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Sidebar Inquiry CTA -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-[#172A35] text-[#F5F1E8] p-8 border border-[#233642] sticky top-28 space-y-6">
                    <div class="text-xs uppercase tracking-widest text-[#A99776] font-semibold">
                        {{ app()->getLocale() === 'ar' ? 'مشروع مماثل' : 'Similar Project Scope' }}
                    </div>
                    <h3 class="text-xl font-serif font-bold">
                        {{ app()->getLocale() === 'ar' ? 'هل تخطط لمشروع مشابه؟' : 'Planning a Similar Architectural Project?' }}
                    </h3>
                    <p class="text-xs text-[#C8C0B5] leading-relaxed">
                        {{ app()->getLocale() === 'ar' ? 'يمكننا تقديم استشارة هندسية ودراسة جدوى للأحمال الرأسية لمشروعك.' : 'Our engineering division can draft traffic analysis and turnkey solutions for your development.' }}
                    </p>
                    <a href="{{ route('site.contact', ['locale' => app()->getLocale()]) }}" class="block text-center bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] py-3.5 text-xs uppercase tracking-widest font-bold transition-colors">
                        {{ __('site.nav.consultation') }} &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
