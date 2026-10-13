@extends('layouts.site')

@section('meta_title', ($page->title ?? 'Page') . ' — EL DEEB ELEVATOR & BUILDING SYSTEM')

@section('content')
@php
    $locale = app()->getLocale();
    $legal = $page?->getSectionData('legal_content') ?? [];
    $content = $legal['content'][$locale] ?? null;
@endphp

<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-3xl space-y-2" data-reveal="fade-up">
            <span class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ $locale === 'ar' ? 'الوثائق القانونية والمعايير' : 'Legal & Compliance' }}
            </span>
            <h1 class="text-3xl sm:text-4xl font-serif font-bold">
                {{ $page->title ?? 'Information' }}
            </h1>
        </div>
    </div>
</section>

<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom max-w-4xl">
        <div class="bg-white p-8 md:p-12 border border-[#C8C0B5] shadow-sm space-y-6 text-sm text-[#596269] leading-relaxed font-sans">
            @if(!empty($content))
                <div class="prose max-w-none space-y-4">
                    {!! nl2br(e($content)) !!}
                </div>
            @else
                <div class="space-y-4">
                    <p class="font-semibold text-[#172A35]">
                        {{ $locale === 'ar' ? 'الوثائق والسياسات الرسمية لشركة الديب للمصاعد وأنظمة المباني.' : 'Official legal documentation and client privacy terms for EL DEEB Elevator & Building System.' }}
                    </p>
                    <p>
                        {{ $locale === 'ar' 
                            ? 'نلتزم بأعلى معايير الشفافية، حماية بيانات العملاء والمستخدمين، وتوفير كافة الضمانات الفنية والقانونية لكافة مشروعاتنا الهندسية وأنظمة النقل الرأسي.' 
                            : 'We adhere to the highest international standards of transparency, data protection, and comprehensive technical warranties for all vertical transportation systems.' }}
                    </p>
                    <p class="text-xs text-[#778087] pt-4 border-t border-[#E4DFD8]">
                        {{ $locale === 'ar' ? 'لأي استفسارات قانونية أو تفاصيل تعاقدية إضافية، يرجى التواصل مع الإدارة القانونية عبر صفحة اتصل بنا.' : 'For legal inquiries or contract documentation, please contact our legal counsel via the contact page.' }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
