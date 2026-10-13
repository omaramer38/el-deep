@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'الأسئلة الشائعة — الديب للمصاعد' : 'Frequently Asked Questions — EL DEEB')

@section('content')
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-2xl space-y-3" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'الدعم والمعلومات' : 'Support & Specifications' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold">
                {{ app()->getLocale() === 'ar' ? 'الأسئلة الأكثر شيوعاً' : 'Frequently Asked Questions' }}
            </h1>
            <p class="text-xs sm:text-sm text-[#C8C0B5] font-light">
                {{ app()->getLocale() === 'ar' ? 'إجابات وافية حول اشتراطات السلامة، فترات التوريد، وعقود الصيانة الوقائية.' : 'Answers regarding European safety compliance, lead times, warranties, and emergency systems.' }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom max-w-4xl">
        <div class="space-y-4">
            @foreach($faqs as $idx => $faq)
                <div class="bg-white border border-[#C8C0B5] shadow-xs" x-data="{ expanded: false }">
                    <button 
                        @click="expanded = !expanded" 
                        :aria-expanded="expanded" 
                        aria-controls="faq-ans-{{ $faq->id }}"
                        class="w-full text-start p-6 flex items-center justify-between gap-4 font-serif font-bold text-base text-[#172A35] hover:text-[#A99776] transition-colors cursor-pointer"
                    >
                        <span>{{ $faq->question }}</span>
                        <span class="text-lg text-[#A99776] font-sans font-light" x-text="expanded ? '—' : '+'"></span>
                    </button>

                    <div 
                        id="faq-ans-{{ $faq->id }}" 
                        x-show="expanded" 
                        x-collapse
                        class="px-6 pb-6 text-xs text-[#596269] leading-relaxed border-t border-[#E4DFD8] pt-4"
                        style="display: none;"
                    >
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
