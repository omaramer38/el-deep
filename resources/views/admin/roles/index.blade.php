@extends('layouts.admin')

@section('title', __('admin.roles'))
@section('header_title', __('admin.roles'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'الأدوار والصلاحيات الأمنية' : 'Roles & Access Permissions' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تخصيص مستويات الوصول وتحديد الصلاحيات الممنوحة لكل دور داخل لوحة التحكم.' : 'Manage granular permissions, RBAC policies, and role privileges.' }}
            </p>
        </div>

        <a href="{{ route('admin.roles.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إنشاء دور جديد' : 'New Role' }}</span>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <table class="w-full text-start text-xs border-collapse">
            <thead>
                <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم الدور' : 'Role Name' }}</th>
                    <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'المستخدمون المعينون' : 'Assigned Users' }}</th>
                    <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'عدد الصلاحيات' : 'Permissions' }}</th>
                    <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E4DFD8]">
                @foreach($roles as $role)
                    <tr class="hover:bg-[#F8F9FA] transition-colors">
                        <td class="py-3.5 px-4 font-bold text-[#172A35]">
                            <div class="flex items-center gap-2">
                                <span>{{ $role->name }}</span>
                                @if($role->name === 'Super Admin')
                                    <span class="px-2 py-0.5 bg-[#A99776] text-[#0F1C23] text-[9px] font-bold uppercase tracking-wider">Full Access</span>
                                @endif
                            </div>
                        </td>

                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] text-[11px] font-bold">
                                {{ $role->users_count }}
                            </span>
                        </td>

                        <td class="py-3.5 px-4 text-center font-mono text-[#596269]">
                            @if($role->name === 'Super Admin')
                                <span class="text-[#A99776] font-bold">الكل (45+)</span>
                            @else
                                {{ $role->permissions_count }}
                            @endif
                        </td>

                        <td class="py-3.5 px-4 text-end">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px] font-medium hover:bg-[#A99776]">
                                    {{ __('admin.edit') }}
                                </a>

                                @if(!in_array($role->name, ['Super Admin', 'Admin']))
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:bg-red-50 text-[11px] cursor-pointer">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
