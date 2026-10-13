@extends('layouts.admin')

@section('title', __('admin.users'))
@section('header_title', __('admin.users'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إدارة المستخدمين وحسابات المديرين' : 'Admin & User Accounts' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة حسابات الفريق وصلاحيات الدخول وحالة الأمان الثنائي.' : 'Manage staff accounts, administrative roles, and security authentication.' }}
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة مستخدم جديد' : 'New User' }}</span>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المستخدم' : 'User' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الأدوار' : 'Roles' }}</th>
                        <th class="py-3 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'الأمان الثنائي (2FA)' : 'Two-Factor' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'آخر دخول' : 'Last Login' }}</th>
                        <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($users as $user)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#172A35] text-white flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#172A35]">{{ $user->name }}</div>
                                        <div class="text-[11px] text-[#778087] font-mono">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#F5F1E8] text-[#172A35] border border-[#C8C0B5]">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($user->is_active)
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">
                                        نشط
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#FDEAEA] text-[#6E1A1A]">
                                        معطّل
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($user->two_factor_secret)
                                    <span class="inline-flex items-center gap-1 text-[11px] text-[#1E4620] font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        <span>مفعّل</span>
                                    </span>
                                @else
                                    <span class="text-[11px] text-[#778087]">غير مفعّل</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-[11px] text-[#596269] font-mono">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '—' }}
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px] font-medium hover:bg-[#A99776]">
                                        {{ __('admin.edit') }}
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
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
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#778087]">
                                لا يوجد مستخدمين مسجلين.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
