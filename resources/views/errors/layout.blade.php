<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — EL DEEB ELEVATOR & BUILDING SYSTEM</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0F1C23] text-[#F5F1E8] min-h-screen flex flex-col justify-between selection:bg-[#A99776] selection:text-white font-sans">
    <!-- Header -->
    <header class="h-24 px-6 md:px-12 flex items-center justify-between border-b border-[#233642]/60">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/brand/PN 2.png') }}" alt="EL DEEB" class="h-10 md:h-12 w-auto object-contain brightness-110">
        </a>
        <div class="text-[10px] uppercase tracking-[0.25em] text-[#A99776] font-semibold">
            Elevator & Building System
        </div>
    </header>

    <!-- Main Error Content -->
    <main class="flex-1 flex items-center justify-center p-6 md:p-12 relative overflow-hidden">
        <div class="absolute -top-40 -start-40 w-96 h-96 bg-[#A99776]/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-40 -end-40 w-96 h-96 bg-[#233642]/40 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-xl w-full text-center space-y-6 relative z-10">
            <div class="font-serif text-7xl md:text-9xl font-bold tracking-wider text-[#A99776] select-none">
                @yield('code')
            </div>

            <div class="space-y-2">
                <h1 class="text-xl md:text-2xl font-serif font-bold text-[#F5F1E8]">
                    @yield('heading')
                </h1>
                <p class="text-xs md:text-sm text-[#C8C0B5] max-w-md mx-auto leading-relaxed font-light">
                    @yield('message')
                </p>
            </div>

            <div class="pt-6 flex items-center justify-center gap-3 flex-wrap">
                <a 
                    href="{{ url('/') }}" 
                    class="bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] px-6 py-3 text-xs uppercase tracking-widest font-semibold transition-all duration-200 cursor-pointer shadow-lg"
                >
                    {{ app()->getLocale() === 'ar' ? 'العودة للرئيسية' : 'Return to Home' }}
                </a>

                <button 
                    onclick="window.history.back()" 
                    class="border border-[#233642] hover:border-[#A99776] text-[#C8C0B5] hover:text-white px-5 py-3 text-xs uppercase tracking-widest font-semibold transition-all duration-200 cursor-pointer"
                >
                    {{ app()->getLocale() === 'ar' ? 'الصفحة السابقة' : 'Go Back' }}
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="h-16 px-6 flex items-center justify-center border-t border-[#233642]/60 text-xs text-[#596269]">
        <span>&copy; {{ date('Y') }} EL DEEB. {{ app()->getLocale() === 'ar' ? 'كافة الحقوق محفوظة.' : 'All rights reserved.' }}</span>
    </footer>
</body>
</html>
