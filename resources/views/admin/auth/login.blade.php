@extends('admin.auth.layout')

@section('title', 'Sign In')

@section('content')
<h1 class="text-xl font-serif text-[#F5F1E8] mb-1 font-semibold tracking-wide">
    {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Sign In' }}
</h1>
<p class="text-xs text-[#778087] mb-6">
    {{ app()->getLocale() === 'ar' ? 'أدخل بيانات الدخول للمتابعة إلى لوحة الإدارة' : 'Enter your administrative credentials to continue' }}
</p>

<form method="POST" action="{{ route('login') }}" class="space-y-4">
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

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-medium text-[#C8C0B5] uppercase tracking-wider">
                {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}
            </label>
            <a href="{{ route('password.request') }}" class="text-xs text-[#A99776] hover:text-[#C4B598] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}
            </a>
        </div>
        <input 
            type="password" 
            name="password" 
            id="password" 
            required 
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] placeholder-[#596269] focus:outline-none focus:border-[#A99776] transition-colors"
            placeholder="••••••••••••"
        >
    </div>

    <div class="flex items-center pt-1">
        <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="w-4 h-4 rounded-none bg-[#0F1C23] border-[#233642] text-[#A99776] focus:ring-0">
            <span class="text-xs text-[#778087]">
                {{ app()->getLocale() === 'ar' ? 'تذكر هذا الجهاز' : 'Remember this session' }}
            </span>
        </label>
    </div>

    <div class="pt-3">
        <button 
            type="submit" 
            class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] font-medium py-3 px-4 text-xs uppercase tracking-widest transition-all duration-200 flex items-center justify-center gap-2 font-sans shadow-lg cursor-pointer"
        >
            <span>{{ app()->getLocale() === 'ar' ? 'دخول إلى النظام' : 'Authenticate' }}</span>
            <svg class="w-4 h-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </button>
    </div>
</form>
@endsection
