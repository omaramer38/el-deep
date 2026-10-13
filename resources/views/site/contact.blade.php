@extends('layouts.site')

@section('meta_title', app()->getLocale() === 'ar' ? 'اتصل بنا وطلب استشارة هندسية — الديب للمصاعد' : 'Contact Us & Request Consultation — EL DEEB')

@section('content')
<section class="py-16 bg-[#172A35] text-[#F5F1E8] border-b border-[#233642]">
    <div class="container-custom">
        <div class="max-w-2xl space-y-3" data-reveal="fade-up">
            <div class="text-xs uppercase tracking-[0.2em] text-[#A99776] font-semibold">
                {{ app()->getLocale() === 'ar' ? 'قنوات التواصل' : 'Direct Engineering Inquiries' }}
            </div>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold">
                {{ __('site.contact.title') }}
            </h1>
            <p class="text-xs sm:text-sm text-[#C8C0B5] font-light">
                {{ __('site.contact.subtitle') }}
            </p>
        </div>
    </div>
</section>

<section class="py-16 bg-[#F5F1E8]">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Contact Info & Privacy Map Placeholder (4 Cols) -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white p-8 border border-[#C8C0B5] space-y-6">
                    <h2 class="text-lg font-serif font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'المقر الرئيسي وخدمة العملاء' : 'Headquarters & Engineering' }}
                    </h2>

                    <div class="space-y-4 text-xs text-[#596269] leading-relaxed">
                        <div>
                            <span class="block text-[10px] uppercase tracking-wider text-[#778087] font-semibold mb-1">{{ __('site.common.location') }}</span>
                            <span class="text-[#172A35] font-medium">[PLACEHOLDER] Business District, New Cairo, Egypt</span>
                        </div>

                        <div>
                            <span class="block text-[10px] uppercase tracking-wider text-[#778087] font-semibold mb-1">{{ __('site.contact.phone') }}</span>
                            <span class="text-[#172A35] font-medium">[PLACEHOLDER] +20 2 0000 0000</span>
                        </div>

                        <div>
                            <span class="block text-[10px] uppercase tracking-wider text-[#778087] font-semibold mb-1">{{ __('site.contact.email') }}</span>
                            <span class="text-[#172A35] font-medium">[PLACEHOLDER] info@eldeeb-elevators.com</span>
                        </div>

                        <div>
                            <span class="block text-[10px] uppercase tracking-wider text-[#778087] font-semibold mb-1">WhatsApp Emergency 24/7</span>
                            <a href="https://wa.me/20000000000" target="_blank" rel="noopener noreferrer" class="text-[#A99776] font-bold hover:underline">
                                [PLACEHOLDER] +20 100 000 0000 &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Privacy-Friendly Map Area (Section 5.9: no third-party requests until consent/click) -->
                <div class="bg-[#172A35] text-[#F5F1E8] p-8 border border-[#233642] text-center space-y-4" x-data="{ mapLoaded: false }">
                    <div x-show="!mapLoaded">
                        <div class="w-12 h-12 bg-[#233642] text-[#A99776] mx-auto flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <h3 class="text-xs font-bold uppercase tracking-wider">Interactive Map</h3>
                        <p class="text-[11px] text-[#C8C0B5] mt-1 mb-4 leading-relaxed">
                            Click below to load the interactive Google Map (complies with privacy guidelines).
                        </p>
                        <button @click="mapLoaded = true" class="bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] px-4 py-2 text-xs uppercase tracking-wider font-semibold cursor-pointer">
                            Load Interactive Map
                        </button>
                    </div>

                    <div x-show="mapLoaded" style="display: none;" class="h-64 w-full">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110502.6118504787!2d31.3285049!3d30.0594885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e8423bba!2sCairo%2C%20Egypt!5e0!3m2!1sen!2seg!4v1600000000000!5m2!1sen!2seg" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>
            </div>

            <!-- Contact Form (8 Cols) -->
            <div class="lg:col-span-8 bg-white p-8 md:p-12 border border-[#C8C0B5] shadow-xs">
                @if(session('contact_success'))
                    <div class="mb-8 p-5 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs leading-relaxed">
                        {{ session('contact_success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('site.contact.submit', ['locale' => app()->getLocale()]) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @honeypot

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                                {{ __('site.contact.name') }} *
                            </label>
                            <input type="text" name="name" required class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                                {{ __('site.contact.email') }} *
                            </label>
                            <input type="email" name="email" required class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                                {{ __('site.contact.phone') }}
                            </label>
                            <input type="tel" name="phone" class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                                {{ __('site.contact.company') }}
                            </label>
                            <input type="text" name="company" class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                            {{ __('site.contact.subject') }}
                        </label>
                        <select name="subject" class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]">
                            <option value="">-- {{ app()->getLocale() === 'ar' ? 'اختر المنتج أو الخدمة المطلوبة' : 'Select Service or Elevator System' }} --</option>
                            @foreach($elevators as $el)
                                <option value="{{ $el->name }}" {{ request('subject') == $el->name ? 'selected' : '' }}>{{ $el->name }}</option>
                            @endforeach
                            @foreach($services as $srv)
                                <option value="{{ $srv->title }}" {{ request('subject') == $srv->title ? 'selected' : '' }}>{{ $srv->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                            {{ __('site.contact.message') }} *
                        </label>
                        <textarea name="message" rows="5" required placeholder="{{ app()->getLocale() === 'ar' ? 'حدد عدد الطوابق، السرعة، نوع المبنى، وأي متطلبات خاصة...' : 'Provide project details, number of stops, building type, special requirements...' }}" class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3.5 py-3 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776]"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[#596269] mb-1.5">
                            {{ __('site.contact.attachment') }}
                        </label>
                        <input type="file" name="attachment" accept=".pdf,.png,.jpg,.jpeg,.docx" class="w-full text-xs text-[#596269] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-[#172A35] file:text-white hover:file:bg-[#A99776]">
                        <span class="text-[10px] text-[#778087] mt-1 block">Supported: PDF, JPG, PNG, DOCX (Max 10MB)</span>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] px-8 py-4 text-xs uppercase tracking-widest font-semibold transition-all duration-300 cursor-pointer shadow-lg flex items-center gap-2">
                            <span>{{ __('site.contact.send') }}</span>
                            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
