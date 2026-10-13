@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تعديل الدور والصلاحيات' : 'Edit Role')
@section('header_title', app()->getLocale() === 'ar' ? 'تعديل الدور والصلاحيات' : 'Edit Role')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تعديل الدور والصلاحيات' : 'Edit Role & Permissions' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تعديل اسم الدور وتحديث الصلاحيات الممنوحة له.' : 'Modify role definition and toggle assigned permissions.' }}
            </p>
        </div>

        <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-xs font-medium border border-[#C8C0B5] hover:bg-[#F5F1E8] hover:border-[#172A35] text-[#172A35] transition-colors flex items-center gap-1.5">
            <span>&larr;</span>
            <span>{{ app()->getLocale() === 'ar' ? 'العودة لقائمة الأدوار' : 'Back to Roles' }}</span>
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

    <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-[#E4DFD8] p-6 shadow-xs">
            <label class="block text-xs font-semibold text-[#172A35] mb-1">اسم الدور *</label>
            <input type="text" name="name" value="{{ old('name', $role->name) }}" required {{ $role->name === 'Super Admin' ? 'readonly' : '' }} class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            @if($role->name === 'Super Admin')
                <p class="text-[11px] text-[#A99776] mt-1 font-semibold">يمتلك دور Super Admin كافة الصلاحيات بصورة مطلقة ولا يمكن تقييده.</p>
            @endif
        </div>

        @if($role->name !== 'Super Admin')
            <div class="bg-white border border-[#E4DFD8] p-6 shadow-xs space-y-6">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                    {{ app()->getLocale() === 'ar' ? 'جدول الصلاحيات حسب الوحدة' : 'Module Permissions' }}
                </h2>

                @include('admin.roles._permissions_matrix', ['selectedPermissions' => $rolePermissions])
            </div>
        @endif

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 text-xs font-semibold text-[#596269] hover:text-[#172A35]">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'تحديث الدور' : 'Update Role' }}
            </button>
        </div>
    </form>
</div>
@endsection
