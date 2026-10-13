@extends('admin.auth.layout')

@section('title', 'Reset Password')

@section('content')
<h1 class="text-xl font-serif text-[#F5F1E8] mb-1 font-semibold tracking-wide">
    {{ app()->getLocale() === 'ar' ? 'استعادة كلمة المرور' : 'Password Recovery' }}
</h1>
<p class="text-xs text-[#778087] mb-6">
    {{ app()->getLocale() === 'ar' ? 'أدخل بريدك الإلكتروني المسجل وسنرسل لك رابطاً مشفراً لتعيين كلمة مرور جديدة.' : 'Enter your registered email address and we will send you a secure password reset link.' }}
</p>

<form method="POST" action="{{ route('password.email') }}" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
        </label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            required 
            autofocus 
            value="{{ old('email') }}"
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] placeholder-[#596269] focus:outline-none focus:border-[#A99776] transition-colors"
            placeholder="admin@eldeeb.com"
        >
    </div>

    <div class="pt-3 space-y-3">
        <button 
            type="submit" 
            class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] font-medium py-3 px-4 text-xs uppercase tracking-widest transition-all duration-200 cursor-pointer"
        >
            {{ app()->getLocale() === 'ar' ? 'إرسال رابط الاستعادة' : 'Send Reset Link' }}
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-xs text-[#778087] hover:text-[#C8C0B5] transition-colors">
                &larr; {{ app()->getLocale() === 'ar' ? 'العودة لتسجيل الدخول' : 'Back to Sign In' }}
            </a>
        </div>
    </div>
</form>
@endsection
