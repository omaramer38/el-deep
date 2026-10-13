<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Login') — EL DEEB ELEVATOR & BUILDING SYSTEM</title>

    <!-- Google Fonts for typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="bg-[#0F1C23] text-[#F5F1E8] min-h-screen flex items-center justify-center p-4 selection:bg-[#A99776] selection:text-white">
    <div class="w-full max-w-md">
        <!-- Logo & Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center mb-4">
                <img src="{{ asset('images/brand/PN 2.png') }}" alt="EL DEEB" class="h-16 w-auto object-contain brightness-110">
            </div>
            <div class="text-xs tracking-[0.25em] uppercase text-[#A99776] font-medium">Elevator & Building System</div>
            <div class="text-sm text-[#778087] mt-1">Administrative Control Portal</div>
        </div>

        <!-- Auth Card -->
        <div class="bg-[#172A35] border border-[#233642] p-8 shadow-2xl relative">
            <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-transparent via-[#A99776] to-transparent"></div>
            
            @if(session('status'))
                <div class="mb-5 p-3.5 bg-[#1B382B] border border-[#2D5A46] text-[#A3E635] text-xs leading-relaxed">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 bg-[#381F1F] border border-[#5A2D2D] text-[#FCA5A5] text-xs leading-relaxed">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Security Notice Footer -->
        <div class="mt-8 text-center text-xs text-[#596269] flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span>Authorized access only &bull; Fortified with 2FA</span>
        </div>
    </div>
</body>
</html>
