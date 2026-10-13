@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل بيانات المستخدم' : 'Edit User')
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل بيانات المستخدم' : 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تعديل بيانات المستخدم' : 'Edit User Account' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تعديل بيانات الحساب والأدوار وصلاحيات الدخول.' : 'Update user profile, credentials, and roles.' }}
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

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">الاسم الكامل *</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">البريد الإلكتروني *</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
        </div>

        <div class="p-4 bg-[#F8F9FA] border border-[#E4DFD8] space-y-3">
            <div class="text-xs font-bold text-[#172A35]">تغيير كلمة المرور (اختياري)</div>
            <div class="text-[11px] text-[#778087]">اترك الحقول فارغة إذا كنت لا ترغب بتغيير كلمة المرور الحالية.</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">كلمة المرور الجديدة</label>
                    <input type="password" name="password" minlength="8" class="w-full text-xs px-3 py-2 bg-white border border-[#C8C0B5]">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" minlength="8" class="w-full text-xs px-3 py-2 bg-white border border-[#C8C0B5]">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-2">الأدوار الممنوحة (Roles) *</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-[#F8F9FA] p-4 border border-[#E4DFD8]">
                @foreach($roles as $role)
                    <label class="flex items-center gap-2 cursor-pointer text-xs">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->roles->pluck('name')->toArray())) ? 'checked' : '' }} class="rounded-none border-[#C8C0B5] text-[#172A35]">
                        <span class="font-medium text-[#172A35]">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer text-xs">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded-none border-[#C8C0B5] text-[#172A35]">
                <span class="font-semibold text-[#172A35]">الحساب نشط ويمكنه تسجيل الدخول</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#F0ECE1]">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-xs font-semibold text-[#596269] hover:text-[#172A35]">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'تحديث البيانات' : 'Update User' }}
            </button>
        </div>
    </form>
</div>
@endsection
