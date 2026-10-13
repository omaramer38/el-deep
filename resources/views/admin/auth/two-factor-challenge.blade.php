@extends('admin.auth.layout')

@section('title', 'Two-Factor Authentication')

@section('content')
<div x-data="{ recovery: false }">
    <div class="mb-4">
        <h1 class="text-xl font-serif text-[#F5F1E8] mb-1 font-semibold tracking-wide">
            {{ app()->getLocale() === 'ar' ? 'المصادقة الثنائية (2FA)' : 'Two-Factor Verification' }}
        </h1>
        <p class="text-xs text-[#778087]" x-show="!recovery">
            {{ app()->getLocale() === 'ar' ? 'يرجى تأكيد الدخول عن طريق إدخال الرمز من تطبيق المصادقة (Google Authenticator).' : 'Please confirm access by entering the authentication code provided by your authenticator app.' }}
        </p>
        <p class="text-xs text-[#778087]" x-show="recovery" style="display: none;">
            {{ app()->getLocale() === 'ar' ? 'يرجى تأكيد الدخول باستخدام أحد رموز الاسترداد الخاصة بك.' : 'Please confirm access by entering one of your emergency recovery codes.' }}
        </p>
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-4">
        @csrf

        <div x-show="!recovery">
            <label for="code" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
                {{ app()->getLocale() === 'ar' ? 'رمز المصادقة (6 أرقام)' : 'Authentication Code' }}
            </label>
            <input 
                type="text" 
                name="code" 
                id="code" 
                inputmode="numeric" 
                autofocus 
                autocomplete="one-time-code"
                class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-center text-lg tracking-widest text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
                placeholder="123456"
            >
        </div>

        <div x-show="recovery" style="display: none;">
            <label for="recovery_code" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
                {{ app()->getLocale() === 'ar' ? 'رمز الاسترداد للطوارئ' : 'Emergency Recovery Code' }}
            </label>
            <input 
                type="text" 
                name="recovery_code" 
                id="recovery_code" 
                autocomplete="one-time-code"
                class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
                placeholder="abcdef-123456"
            >
        </div>

        <div class="pt-2 flex items-center justify-between text-xs">
            <button 
                type="button" 
                class="text-[#A99776] hover:text-[#C4B598] transition-colors underline cursor-pointer"
                x-show="!recovery"
                @click="recovery = true; $nextTick(() => { $refs.recovery_code?.focus() })"
            >
                {{ app()->getLocale() === 'ar' ? 'استخدام رمز استرداد للطوارئ' : 'Use emergency recovery code' }}
            </button>

            <button 
                type="button" 
                class="text-[#A99776] hover:text-[#C4B598] transition-colors underline cursor-pointer"
                x-show="recovery"
                style="display: none;"
                @click="recovery = false; $nextTick(() => { $refs.code?.focus() })"
            >
                {{ app()->getLocale() === 'ar' ? 'استخدام تطبيق المصادقة' : 'Use authenticator app code' }}
            </button>
        </div>

        <div class="pt-3">
            <button 
                type="submit" 
                class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] font-medium py-3 px-4 text-xs uppercase tracking-widest transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer"
            >
                <span>{{ app()->getLocale() === 'ar' ? 'تحقق ومتابعة' : 'Verify & Sign In' }}</span>
            </button>
        </div>
    </form>
</div>
@endsection
