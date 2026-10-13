@extends('admin.auth.layout')

@section('title', app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password')

@section('content')
<div class="mb-5">
    <h1 class="text-xl font-serif text-[#F5F1E8] mb-1 font-semibold tracking-wide">
        {{ app()->getLocale() === 'ar' ? 'تأكيد الأمان وكلمة المرور' : 'Security Confirmation' }}
    </h1>
    <p class="text-xs text-[#778087] leading-relaxed">
        {{ app()->getLocale() === 'ar' 
            ? 'هذه منطقة أمان حساسة. يرجى إدخال كلمة المرور الحالية لحسابك للمتابعة.' 
            : 'This is a secure area of the system. Please confirm your current password before proceeding.' }}
    </p>
</div>

<form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
    @csrf

    <div>
        <label for="password" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
            {{ app()->getLocale() === 'ar' ? 'كلمة المرور' : 'Password' }}
        </label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            required 
            autocomplete="current-password"
            autofocus
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-xs text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
            placeholder="••••••••••••"
        >
    </div>

    <div class="pt-2">
        <button 
            type="submit" 
            class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] font-medium py-3 px-4 text-xs uppercase tracking-widest transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer"
        >
            <span>{{ app()->getLocale() === 'ar' ? 'تأكيد ومتابعة' : 'Confirm & Proceed' }}</span>
        </button>
    </div>
</form>
@endsection
