@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'حلول وأنظمة المصاعد — الديب للمصاعد' : 'Elevator Systems & Solutions — EL DEEB')

@section('content')
<!-- Header -->
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-2xl space-y-3" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'منتجاتنا وحلولنا' : 'Engineered Systems' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold">
                {{ app()->getLocale() === 'ar' ? 'المصاعد وأنظمة النقل الرأسي' : 'Elevators & Vertical Systems' }}
            </h1>
            <p class="text-xs sm:text-sm text-[#C8C0B5] font-light">
                {{ app()->getLocale() === 'ar' ? 'مجموعة متكاملة من مصاعد الركاب، البانوراما، المستشفيات، والفلل السكنية بأعلى كفاءة ميكانيكية.' : 'Complete portfolio of passenger, panoramic, medical, and residential elevator technologies.' }}
            </p>
        </div>
    </div>
</section>

<!-- Main Listing with Category Filter -->
<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <!-- Categories Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 mb-12 border-b border-[#C8C0B5]/40 pb-4">
            <a href="{{ route('site.elevators.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 text-xs uppercase tracking-wider font-semibold {{ !request('category') ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-white text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ __('site.common.all') }}
            </a>
            @foreach($categories as $category)
                <a href="{{ route('site.elevators.index', ['locale' => app()->getLocale(), 'category' => $category->slug]) }}" class="px-4 py-2 text-xs uppercase tracking-wider font-semibold {{ request('category') == $category->slug ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-white text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Elevators Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($elevators as $elevator)
                <x-ui.product-card
                    :title="$elevator->name"
                    :category="$elevator->category->name ?? 'Standard'"
                    :description="$elevator->short_description"
                    :image="$elevator->getFirstMediaUrl('cover') ?: asset('images/brand/PN 3.png')"
                    :url="route('site.elevators.show', ['locale' => app()->getLocale(), 'slug' => $elevator->slug])"
                />
            @empty
                <div class="col-span-full py-16 text-center text-[#778087] text-xs">
                    {{ app()->getLocale() === 'ar' ? 'لا توجد مصاعد مطابقة للتصفية المختارة.' : 'No elevators found matching this selection.' }}
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $elevators->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection
