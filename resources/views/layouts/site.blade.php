<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('meta_title', 'EL DEEB ELEVATOR & BUILDING SYSTEM — Moving People. Building Confidence.')</title>
    <meta name="description" content="@yield('meta_description', 'Premium architectural elevator and building systems engineered for safety, precision, and enduring performance.')">
    <link rel="icon" type="image/png" href="{{ \App\Models\Setting::get('site_favicon') ?: asset('images/brand/PN 2.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="@yield('meta_title', 'EL DEEB ELEVATOR & BUILDING SYSTEM')">
    <meta property="og:description" content="@yield('meta_description', 'Premium architectural elevator and building systems.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', asset('images/brand/PN.png'))">

    <!-- Alternates / Hreflang -->
    @php
        $currentLocale = app()->getLocale();
        $altLocale = $currentLocale === 'ar' ? 'en' : 'ar';
        $currentUrl = url()->current();
        $altUrl = str_replace("/{$currentLocale}", "/{$altLocale}", $currentUrl);
        if ($altUrl === $currentUrl) {
            $altUrl = url("/{$altLocale}");
        }
    @endphp
    <link rel="alternate" hreflang="en" href="{{ str_replace('/ar', '/en', $currentUrl) }}">
    <link rel="alternate" hreflang="ar" href="{{ str_replace('/en', '/ar', $currentUrl) }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/en') }}">

    <!-- Google Fonts for Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#F5F1E8] text-[#172A35] antialiased selection:bg-[#A99776] selection:text-white" x-data="{ mobileMenuOpen: false }">
    <!-- Skip to Content for Accessibility (WCAG 2.2 AA) -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:start-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-[#172A35] focus:text-[#F5F1E8] text-xs uppercase tracking-widest outline-none">
        Skip to main content
    </a>

    <!-- Global Header (Public Header) -->
    <header 
        data-header 
        class="fixed top-0 inset-x-0 z-40 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-[#E4DFD8] shadow-xs"
    >
        <div class="container-custom">
            <div class="flex items-center justify-between h-20 md:h-22">
                <!-- Brand Wordmark Logo -->
                <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-3 group py-1 shrink-0">
                    @php
                        $customHeaderLogo = \App\Models\Setting::get('site_logo');
                        $isAr = app()->getLocale() === 'ar';
                        $brandTitle = $isAr ? 'الديب' : 'EL DEEB';
                        $brandSubtitle = $isAr ? 'للمصاعد وأنظمة المباني' : 'ELEVATOR & BUILDING SYSTEM';
                    @endphp
                    @if($customHeaderLogo)
                        <img src="{{ $customHeaderLogo }}" alt="{{ $brandTitle }}" class="h-10 md:h-12 w-auto object-contain">
                    @else
                        <div class="flex flex-col text-start leading-none select-none">
                            <span class="font-serif text-2xl md:text-[26px] font-bold tracking-[0.12em] text-[#172A35] group-hover:text-[#A99776] transition-colors whitespace-nowrap">
                                {{ $brandTitle }}
                            </span>
                            <span class="text-[9px] uppercase tracking-[0.22em] text-[#596269] font-medium mt-1.5 font-sans whitespace-nowrap">
                                {{ $brandSubtitle }}
                            </span>
                        </div>
                    @endif
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-7 text-xs font-medium text-[#172A35]">
                    <a href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.home') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ __('site.nav.home') }}
                    </a>
                    <a href="{{ route('site.about', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.about') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ __('site.nav.about') }}
                    </a>
                    <a href="{{ route('site.elevators.index', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.elevators.*') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ __('site.nav.elevators') }}
                    </a>
                    <a href="{{ route('site.services.index', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.services.*') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ __('site.nav.services') }}
                    </a>
                    <a href="{{ route('site.projects.index', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.projects.*') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ __('site.nav.projects') }}
                    </a>
                    <a href="{{ route('site.blog.index', ['locale' => app()->getLocale()]) }}" class="transition-colors py-1 relative {{ request()->routeIs('site.blog.*') ? 'text-[#A99776] font-semibold after:content-[\'\'] after:absolute after:-bottom-1 after:inset-x-0 after:h-[2px] after:bg-[#A99776]' : 'text-[#596269] hover:text-[#172A35]' }}">
                        {{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}
                    </a>

                    @php
                        $navCatalogues = \App\Models\Catalogue::active()->get();
                    @endphp
                    @if($navCatalogues->count() > 0)
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="transition-colors py-1 flex items-center gap-1 text-[#596269] hover:text-[#172A35] focus:outline-none cursor-pointer">
                                <span>{{ app()->getLocale() === 'ar' ? 'الكتالوجات' : 'Catalogues' }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                class="absolute {{ app()->getLocale() === 'ar' ? 'right-0' : 'left-0' }} top-full mt-1 w-60 bg-white border border-[#E4DFD8] shadow-xl py-2 z-50"
                                style="display: none;"
                            >
                                @foreach($navCatalogues as $cat)
                                    <a 
                                        href="{{ $cat->pdf_url }}" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="flex items-center justify-between px-4 py-2.5 text-xs text-[#172A35] hover:bg-[#F5F1E8] hover:text-[#A99776] transition-colors font-medium border-b border-[#F5F1E8] last:border-0"
                                    >
                                        <span>{{ $cat->getTranslation('title', app()->getLocale()) }}</span>
                                        <span class="text-[10px] text-[#A99776] uppercase tracking-wider font-bold">PDF ↗</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </nav>

                <!-- Actions: Language Switcher + Request a quote CTA -->
                <div class="hidden lg:flex items-center gap-5">
                    <!-- Language Switcher -->
                    <a 
                        href="{{ $altUrl }}" 
                        class="text-xs text-[#596269] hover:text-[#172A35] font-medium transition-colors"
                    >
                        {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
                    </a>

                    <!-- Request a quote CTA button -->
                    <a 
                        href="{{ route('site.contact', ['locale' => app()->getLocale()]) }}" 
                        class="inline-flex items-center justify-center bg-[#A99776] hover:bg-[#8A7755] text-white px-5 py-2.5 text-xs font-medium rounded-[2px] transition-all duration-200 shadow-xs cursor-pointer"
                    >
                        {{ app()->getLocale() === 'ar' ? 'طلب عرض سعر' : 'Request a quote' }}
                    </a>
                </div>

                <!-- Mobile Menu Hamburger Button -->
                <div class="lg:hidden flex items-center gap-4">
                    <a href="{{ $altUrl }}" class="text-xs uppercase font-bold text-[#596269]">
                        {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                    </a>
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2 text-[#172A35] focus:outline-none"
                        aria-label="Toggle Navigation Menu"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Full-screen Navigation Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="lg:hidden bg-[#172A35] text-[#F5F1E8] px-6 py-8 border-t border-[#233642] shadow-2xl"
            style="display: none;"
        >
            <div class="flex flex-col space-y-5 text-sm uppercase tracking-wider font-medium">
                <a @click="mobileMenuOpen = false" href="{{ route('site.home', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.home') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.about', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.about') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.elevators.index', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.elevators') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.services.index', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.services') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.projects.index', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.projects') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.blog.index', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.blog') }}</a>
                @if($navCatalogues->count() > 0)
                    <div x-data="{ catOpen: false }">
                        <button @click="catOpen = !catOpen" type="button" class="w-full flex items-center justify-between py-1 text-start hover:text-[#A99776] cursor-pointer">
                            <span>{{ app()->getLocale() === 'ar' ? 'الكتالوجات' : 'Catalogues' }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': catOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="catOpen" class="mt-2 space-y-2 border-s-2 border-[#A99776] ps-4 py-1 text-xs" style="display: none;">
                            @foreach($navCatalogues as $cat)
                                <a 
                                    href="{{ $cat->pdf_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="flex items-center justify-between py-1 text-[#C8C0B5] hover:text-[#A99776]"
                                >
                                    <span>{{ $cat->getTranslation('title', app()->getLocale()) }}</span>
                                    <span class="text-[10px] text-[#A99776] font-bold">PDF ↗</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <a @click="mobileMenuOpen = false" href="{{ route('site.faq', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.faq') }}</a>
                <a @click="mobileMenuOpen = false" href="{{ route('site.contact', ['locale' => app()->getLocale()]) }}" class="py-1 hover:text-[#A99776]">{{ __('site.nav.contact') }}</a>
            </div>

            <div class="mt-8 pt-6 border-t border-[#233642]">
                <a 
                    href="{{ route('site.contact', ['locale' => app()->getLocale()]) }}" 
                    class="block text-center bg-[#A99776] text-[#0F1C23] py-3 text-xs uppercase tracking-widest font-semibold"
                >
                    {{ __('site.nav.consultation') }}
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content" class="pt-20 md:pt-24 min-h-screen">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-[#172A35] text-[#F5F1E8] border-t border-[#233642] pt-16 md:pt-24 pb-12">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 pb-16 border-b border-[#233642]">
                <!-- Column 1: Brand Info -->
                <div class="lg:col-span-2 space-y-6">
                    <img src="{{ \App\Models\Setting::get('site_logo_dark') ?: asset('images/brand/PN 2.png') }}" alt="EL DEEB" class="h-12 w-auto object-contain brightness-110">
                    <p class="text-sm text-[#C8C0B5] max-w-md leading-relaxed font-light">
                        {{ __('site.footer.description') }}
                    </p>
                    <div class="text-xs text-[#A99776] tracking-widest uppercase font-medium">
                        {{ \App\Models\Setting::get('site_tagline')[app()->getLocale()] ?? 'Moving People • Building Confidence' }}
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#A99776]">
                        {{ __('site.footer.quick_links') }}
                    </h3>
                    <ul class="space-y-2.5 text-xs text-[#C8C0B5]">
                        <li><a href="{{ route('site.about', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.about') }}</a></li>
                        <li><a href="{{ route('site.elevators.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.elevators') }}</a></li>
                        <li><a href="{{ route('site.services.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.services') }}</a></li>
                        <li><a href="{{ route('site.projects.index', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.projects') }}</a></li>
                        <li><a href="{{ route('site.faq', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.faq') }}</a></li>
                        <li><a href="{{ route('site.contact', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('site.nav.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Column 3: Headquarters / Contact -->
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#A99776]">
                        {{ __('site.footer.headquarters') }}
                    </h3>
                    <div class="space-y-3 text-xs text-[#C8C0B5] leading-relaxed">
                        @php
                            $addr = \App\Models\Setting::get('contact_address');
                            $addrText = is_array($addr) ? ($addr[app()->getLocale()] ?? '') : $addr;
                        @endphp
                        <p>{{ $addrText ?: 'Financial & Business District, New Cairo, Egypt' }}</p>
                        <p><a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="hover:text-white">{{ \App\Models\Setting::get('contact_phone') ?? '+20 2 0000 0000' }}</a></p>
                        <p><a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="hover:text-white">{{ \App\Models\Setting::get('contact_email') ?? 'info@eldeeb-elevators.com' }}</a></p>
                    </div>
                </div>

                <!-- Column 4: Newsletter -->
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-[#A99776]">
                        {{ __('site.footer.newsletter_title') }}
                    </h3>
                    <p class="text-xs text-[#C8C0B5] leading-relaxed">
                        {{ __('site.footer.newsletter_desc') }}
                    </p>
                    <form method="POST" action="{{ route('site.newsletter.subscribe', ['locale' => app()->getLocale()]) }}" class="space-y-2">
                        @csrf
                        @honeypot
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            placeholder="{{ __('site.newsletter.email_placeholder') }}"
                            class="w-full bg-[#0F1C23] border border-[#233642] px-3 py-2.5 text-xs text-[#F5F1E8] placeholder-[#596269] focus:outline-none focus:border-[#A99776]"
                        >
                        <button type="submit" class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] py-2.5 text-xs uppercase tracking-widest font-semibold transition-colors">
                            {{ __('site.footer.subscribe') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom Bar -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-[#778087] gap-4">
                <div>
                    &copy; {{ date('Y') }} EL DEEB Elevator & Building System. {{ __('site.footer.rights') }}
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('site.privacy', ['locale' => app()->getLocale()]) }}" class="hover:text-[#C8C0B5] transition-colors">{{ __('site.footer.privacy') }}</a>
                    <a href="{{ route('site.terms', ['locale' => app()->getLocale()]) }}" class="hover:text-[#C8C0B5] transition-colors">{{ __('site.footer.terms') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp CTA (Section 5.1) -->
    <a 
        href="https://wa.me/20000000000" 
        target="_blank" 
        rel="noopener noreferrer"
        aria-label="Contact us on WhatsApp" 
        class="fixed bottom-6 {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }} z-30 w-12 h-12 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-105 transition-transform"
    >
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>

    @stack('scripts')
</body>
</html>
