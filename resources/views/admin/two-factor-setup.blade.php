@extends('layouts.admin')

@section('title', __('admin.two_factor'))
@section('header_title', __('admin.two_factor'))

@section('content')
<div class="max-w-3xl space-y-6" x-data="{ copiedSecret: false, copiedCodes: false }">
    <!-- Header Banner -->
    <div class="bg-white p-6 border border-[#E4DFD8] shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-[#A99776]"></span>
                <h1 class="text-xl font-serif font-bold text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'المصادقة الثنائية (TOTP 2FA)' : 'Two-Factor Authentication' }}
                </h1>
            </div>
            <p class="text-xs text-[#596269] mt-1.5 leading-relaxed">
                {{ app()->getLocale() === 'ar' 
                    ? 'طبقة حماية إضافية لحسابك تتطلب إدخال رمز أمان مؤقت من هاتفك المحمول عند كل تسجيل دخول.' 
                    : 'Add an extra layer of security to your admin account by requiring an authenticator code when signing in.' }}
            </p>
        </div>

        <div>
            @if(auth()->user()->two_factor_confirmed_at)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'المصادقة نشطة ومؤكدة' : '2FA Active & Confirmed' }}</span>
                </span>
            @elseif(auth()->user()->two_factor_secret)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-300 text-amber-900 text-xs font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4 text-amber-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'في انتظار إدخال كود التأكيد' : 'Pending Confirmation' }}</span>
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 text-red-800 text-xs font-bold uppercase tracking-wider">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'غير مفعّلة حالياً' : '2FA Disabled' }}</span>
                </span>
            @endif
        </div>
    </div>

    <!-- Status Alerts -->
    @if(session('status') == 'two-factor-authentication-confirmed')
        <div class="p-4 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'تم تأكيد وتفعيل المصادقة الثنائية بنجاح! تم تأمين حسابك بالكامل.' : 'Two-factor authentication has been confirmed and enabled successfully!' }}</span>
        </div>
    @endif

    @if(session('status') == 'recovery-codes-generated')
        <div class="p-4 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] text-xs font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'تم إنشاء وتجديد رموز الاسترداد الجديدة بنجاح.' : 'New recovery codes have been generated successfully.' }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs space-y-1">
            @foreach($errors->all() as $error)
                <div>&bull; {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- STATE 1: NOT ENABLED YET -->
    @if(! auth()->user()->two_factor_secret)
        <div class="bg-white p-8 border border-[#E4DFD8] shadow-xs space-y-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#FAF8F4] border border-[#C8C0B5] flex items-center justify-center shrink-0 text-[#172A35]">
                    <svg class="w-6 h-6 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="space-y-2">
                    <h3 class="text-sm font-bold text-[#172A35]">
                        {{ app()->getLocale() === 'ar' ? 'كيف تعمل المصادقة الثنائية؟' : 'How does Two-Factor Authentication work?' }}
                    </h3>
                    <p class="text-xs text-[#596269] leading-relaxed">
                        {{ app()->getLocale() === 'ar' 
                            ? 'عند تفعيل هذه الخاصية، ستقوم بمسح رمز QR باستخدام تطبيق مثل Google Authenticator أو 1Password أو Microsoft Authenticator على هاتفك، ثم إدخال الرمز لتأكيد الربط. سيُطلب منك هذا الرمز دائماً عند تسجيل الدخول لحماية لوحة التحكم من أي اختراق.' 
                            : 'When enabled, you will scan a QR code using an authenticator app (Google Authenticator, 1Password, etc.) and enter the 6-digit code. Future logins will require this temporary code to prevent unauthorized access.' }}
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-[#E4DFD8] flex items-center justify-end">
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                    @csrf
                    <button type="submit" class="bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] px-6 py-3 text-xs uppercase tracking-widest font-bold transition-all duration-200 cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'تفعيل المصادقة الثنائية الآن' : 'Enable 2FA Now' }}</span>
                    </button>
                </form>
            </div>
        </div>

    <!-- STATE 2: ENABLED BUT PENDING CONFIRMATION -->
    @elseif(! auth()->user()->two_factor_confirmed_at)
        <div class="bg-white p-8 border border-amber-300 shadow-xs space-y-8">
            <div class="border-b border-[#E4DFD8] pb-4">
                <h3 class="text-sm font-bold text-[#172A35] flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                    <span>{{ app()->getLocale() === 'ar' ? 'الخطوة الأخيرة: مسح الرمز وتأكيد التفعيل' : 'Final Step: Scan QR & Confirm 2FA' }}</span>
                </h3>
                <p class="text-xs text-[#596269] mt-1">
                    {{ app()->getLocale() === 'ar' 
                        ? 'امسح رمز الاستجابة السريعة (QR) أو اكتب المفتاح السري يدوياً في تطبيقك، ثم أدخل كود التحقق المكون من 6 أرقام لتأكيد التفعيل.' 
                        : 'Scan the QR code below or enter the key manually into your authenticator app, then enter the 6-digit code to complete setup.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- QR Code Box -->
                <div class="flex flex-col items-center justify-center p-6 bg-[#FAF8F4] border border-[#C8C0B5]">
                    <div class="p-3 bg-white border border-[#E4DFD8] shadow-sm inline-block">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    <span class="text-[11px] text-[#778087] mt-3 font-semibold uppercase tracking-wider">
                        Google Authenticator / 1Password
                    </span>
                </div>

                <!-- Manual Secret Key & Instructions -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#172A35] uppercase tracking-wider mb-1">
                            {{ app()->getLocale() === 'ar' ? 'المفتاح السري للإدخال اليدوي:' : 'Secret Key (Manual Entry):' }}
                        </label>
                        @php
                            $secretKey = decrypt(auth()->user()->two_factor_secret);
                        @endphp
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                readonly 
                                value="{{ $secretKey }}" 
                                class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-3 py-2 text-xs font-mono text-[#172A35] select-all focus:outline-none"
                            >
                            <button 
                                type="button" 
                                @click="navigator.clipboard.writeText('{{ $secretKey }}'); copiedSecret = true; setTimeout(() => copiedSecret = false, 2500)"
                                class="px-3 py-2 bg-[#172A35] text-white hover:bg-[#A99776] text-xs font-semibold transition-colors cursor-pointer shrink-0"
                            >
                                <span x-show="!copiedSecret">{{ app()->getLocale() === 'ar' ? 'نسخ' : 'Copy' }}</span>
                                <span x-show="copiedSecret" style="display: none;">{{ app()->getLocale() === 'ar' ? 'تم!' : 'Copied' }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation Form -->
                    <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}" class="space-y-4 pt-2">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-[#172A35] uppercase tracking-wider mb-1.5">
                                {{ app()->getLocale() === 'ar' ? 'أدخل الرمز المكون من 6 أرقام للتأكيد: *' : 'Enter 6-digit Verification Code: *' }}
                            </label>
                            <input 
                                type="text" 
                                name="code" 
                                required 
                                autofocus 
                                inputmode="numeric" 
                                maxlength="6" 
                                placeholder="123456" 
                                class="w-full bg-[#FAF8F4] border border-[#C8C0B5] px-4 py-2.5 text-center text-lg tracking-widest font-mono text-[#172A35] focus:outline-none focus:border-[#A99776]"
                            >
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit" class="flex-1 bg-[#172A35] hover:bg-[#A99776] text-[#F5F1E8] py-2.5 px-4 text-xs font-bold uppercase tracking-widest transition-colors cursor-pointer">
                                {{ app()->getLocale() === 'ar' ? 'تأكيد وحفظ التفعيل' : 'Confirm & Enable 2FA' }}
                            </button>
                        </div>
                    </form>

                    <!-- Cancel Button -->
                    <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="pt-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 hover:underline cursor-pointer">
                            {{ app()->getLocale() === 'ar' ? 'إلغاء التفعيل والرجوع' : 'Cancel Setup' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    <!-- STATE 3: CONFIRMED & ACTIVE -->
    @else
        <div class="bg-white p-8 border border-[#E4DFD8] shadow-xs space-y-8">
            <!-- Active Summary Card -->
            <div class="p-5 bg-[#FAF8F4] border border-[#C8C0B5] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#EAF5EC] border border-[#BDE0C3] text-[#1E4620] flex items-center justify-center font-bold">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#172A35]">
                            {{ app()->getLocale() === 'ar' ? 'المصادقة الثنائية نشطة ومفعلة بالكامل' : 'Two-Factor Authentication is Active' }}
                        </div>
                        <div class="text-[11px] text-[#596269] mt-0.5">
                            {{ app()->getLocale() === 'ar' ? 'تاريخ التفعيل والتأكيد:' : 'Confirmed on:' }}
                            <span class="font-mono">{{ auth()->user()->two_factor_confirmed_at?->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Disable 2FA Form -->
                <form method="POST" action="{{ url('user/two-factor-authentication') }}" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من رغبتك في تعطيل المصادقة الثنائية؟ سيقلل ذلك من أمان حسابك.' : 'Are you sure you want to disable two-factor authentication? This will lower your account security.' }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 border border-red-300 text-red-700 hover:bg-red-50 text-xs font-semibold uppercase tracking-wider transition-colors cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'تعطيل المصادقة الثنائية' : 'Disable 2FA' }}
                    </button>
                </form>
            </div>

            <!-- Emergency Recovery Codes -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            <span>{{ app()->getLocale() === 'ar' ? 'رموز الاسترداد للطوارئ (Recovery Codes)' : 'Emergency Recovery Codes' }}</span>
                        </h3>
                        <p class="text-[11px] text-[#596269] mt-0.5">
                            {{ app()->getLocale() === 'ar' 
                                ? 'احتفظ بهذه الرموز في مكان آمن. يمكن استخدام كل رمز لمرة واحدة فقط لتسجيل الدخول في حال فقدت هاتفك.' 
                                : 'Store these codes safely. Each code can be used once if you lose access to your authenticator app.' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Regenerate Codes Form -->
                        <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'سيتم إبطال كافة الرموز السابقة وتوليد رموز جديدة. هل تريد المتابعة؟' : 'Previous recovery codes will be invalidated. Generate new ones?' }}');">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 bg-[#FAF8F4] border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] text-[11px] font-semibold transition-colors cursor-pointer">
                                {{ app()->getLocale() === 'ar' ? 'تجديد الرموز' : 'Regenerate Codes' }}
                            </button>
                        </form>
                    </div>
                </div>

                @php
                    $recoveryCodes = auth()->user()->recoveryCodes();
                    $allCodesText = implode("\n", $recoveryCodes);
                @endphp

                <!-- Codes Grid -->
                <div class="p-4 bg-[#FAF8F4] border border-[#C8C0B5] relative group">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-center">
                        @foreach($recoveryCodes as $code)
                            <div class="p-2 bg-white border border-[#E4DFD8] font-mono text-xs text-[#172A35] font-semibold tracking-wider select-all">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 border-t border-[#E4DFD8] flex items-center justify-between text-xs">
                        <span class="text-[11px] text-[#778087]">
                            {{ app()->getLocale() === 'ar' ? 'عدد الرموز المتاحة: 8 رموز' : 'Available: 8 one-time emergency codes' }}
                        </span>

                        <button 
                            type="button" 
                            @click="navigator.clipboard.writeText(`{{ $allCodesText }}`); copiedCodes = true; setTimeout(() => copiedCodes = false, 2500)"
                            class="text-xs font-bold text-[#172A35] hover:text-[#A99776] transition-colors flex items-center gap-1 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            <span x-show="!copiedCodes">{{ app()->getLocale() === 'ar' ? 'نسخ كافة الرموز دفعة واحدة' : 'Copy All Codes' }}</span>
                            <span x-show="copiedCodes" style="display: none;" class="text-emerald-700">{{ app()->getLocale() === 'ar' ? 'تم نسخ الرموز!' : 'Copied to Clipboard!' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
