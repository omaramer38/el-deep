@extends('admin.auth.layout')

@section('title', 'Set New Password')

@section('content')
<h1 class="text-xl font-serif text-[#F5F1E8] mb-1 font-semibold tracking-wide">
    {{ app()->getLocale() === 'ar' ? 'تعيين كلمة مرور جديدة' : 'Set New Password' }}
</h1>
<p class="text-xs text-[#778087] mb-6">
    {{ app()->getLocale() === 'ar' ? 'أدخل كلمة المرور الجديدة لتحديث حسابك.' : 'Enter your new password to update your credentials.' }}
</p>

<form method="POST" action="{{ route('password.update') }}" class="space-y-4">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div>
        <label for="email" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
            {{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }}
        </label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            required 
            value="{{ old('email', $request->email) }}"
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
        >
    </div>

    <div>
        <label for="password" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
            {{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}
        </label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            required 
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
            placeholder="••••••••••••"
        >
    </div>

    <div>
        <label for="password_confirmation" class="block text-xs font-medium text-[#C8C0B5] mb-1.5 uppercase tracking-wider">
            {{ app()->getLocale() === 'ar' ? 'تأكيد كلمة المرور' : 'Confirm Password' }}
        </label>
        <input 
            type="password" 
            name="password_confirmation" 
            id="password_confirmation" 
            required 
            class="w-full bg-[#0F1C23] border border-[#233642] px-3.5 py-2.5 text-sm text-[#F5F1E8] focus:outline-none focus:border-[#A99776] transition-colors"
            placeholder="••••••••••••"
        >
    </div>

    <div class="pt-3">
        <button 
            type="submit" 
            class="w-full bg-[#A99776] hover:bg-[#C4B598] text-[#0F1C23] font-medium py-3 px-4 text-xs uppercase tracking-widest transition-all duration-200 cursor-pointer"
        >
            {{ app()->getLocale() === 'ar' ? 'تحديث كلمة المرور' : 'Reset Password' }}
        </button>
    </div>
</form>
@endsection
