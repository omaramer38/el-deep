@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة مستخدم جديد' : 'Create User')
@section('header_title', app()->getLocale() === 'ar' ? 'إضافة مستخدم جديد' : 'Create User')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إضافة مستخدم / مدير جديد' : 'Create New Account' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تعيين بيانات الحساب والأدوار الإدارية الممنوحة.' : 'Create an administrative user and assign system roles.' }}
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-xs font-medium border border-[#C8C0B5] hover:border-[#172A35] text-[#172A35] transition-colors">
            {{ __('admin.back') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">الاسم الكامل *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: م. أحمد الديب" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">البريد الإلكتروني *</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@eldeeb.com" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">كلمة المرور *</label>
                <input type="password" name="password" required minlength="8" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">تأكيد كلمة المرور *</label>
                <input type="password" name="password_confirmation" required minlength="8" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-2">الأدوار الممنوحة (Roles) *</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-[#F8F9FA] p-4 border border-[#E4DFD8]">
                @foreach($roles as $role)
                    <label class="flex items-center gap-2 cursor-pointer text-xs">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }} class="rounded-none border-[#C8C0B5] text-[#172A35]">
                        <span class="font-medium text-[#172A35]">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer text-xs">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded-none border-[#C8C0B5] text-[#172A35]">
                <span class="font-semibold text-[#172A35]">الحساب نشط ويمكنه تسجيل الدخول</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#F0ECE1]">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-xs font-semibold text-[#596269] hover:text-[#172A35]">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'إنشاء الحساب' : 'Create User' }}
            </button>
        </div>
    </form>
</div>
@endsection
