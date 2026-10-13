@extends('layouts.admin')

@section('title', __('admin.dashboard'))
@section('header_title', __('admin.dashboard'))

@section('content')
<div class="space-y-8">
    <!-- Overview Header & Welcome -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif text-[#172A35] font-bold">
                {{ app()->getLocale() === 'ar' ? 'مرحباً، ' . auth()->user()->name : 'Welcome back, ' . auth()->user()->name }}
            </h1>
            <p class="text-xs text-[#596269] mt-1">
                {{ app()->getLocale() === 'ar' ? 'لوحة القيادة المركزية وإدارة محتوى ونظام مصاعد الديب' : 'Central command for EL DEEB Elevator & Building System content and operations' }}
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#EAF5EC] text-[#1E4620] text-xs font-medium">
                <span class="w-2 h-2 rounded-full bg-[#22C55E] animate-pulse"></span>
                {{ app()->getLocale() === 'ar' ? 'النظام متصل ونشط' : 'System Operational' }}
            </span>
            <a href="{{ route('admin.styleguide') }}" class="px-3.5 py-1.5 bg-[#172A35] text-[#F5F1E8] text-xs uppercase tracking-wider font-medium hover:bg-[#A99776] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'دليل التصميم (Styleguide)' : 'UI Styleguide' }}
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid (Section 6.3) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Projects -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.projects') }}</div>
            <div class="text-3xl font-serif font-bold text-[#172A35]">{{ $stats['projects'] }}</div>
        </div>

        <!-- Elevators -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.elevators') }}</div>
            <div class="text-3xl font-serif font-bold text-[#172A35]">{{ $stats['elevators'] }}</div>
        </div>

        <!-- Services -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.services') }}</div>
            <div class="text-3xl font-serif font-bold text-[#172A35]">{{ $stats['services'] }}</div>
        </div>

        <!-- Articles -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.blog') }}</div>
            <div class="text-3xl font-serif font-bold text-[#172A35]">{{ $stats['articles'] }}</div>
        </div>

        <!-- Unread Messages -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.messages') }}</div>
            <div class="text-3xl font-serif font-bold {{ $stats['unread_messages'] > 0 ? 'text-[#A99776]' : 'text-[#172A35]' }}">
                {{ $stats['unread_messages'] }}
            </div>
        </div>

        <!-- Users -->
        <div class="bg-white p-5 border border-[#E4DFD8] hover:border-[#A99776] transition-colors">
            <div class="text-[11px] font-semibold uppercase tracking-wider text-[#778087] mb-2">{{ __('admin.users') }}</div>
            <div class="text-3xl font-serif font-bold text-[#172A35]">{{ $stats['users'] }}</div>
        </div>
    </div>

    <!-- Health Widget & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Queue & System Health -->
        <div class="bg-white p-6 border border-[#E4DFD8]">
            <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-[#172A35] mb-4 pb-2 border-b border-[#E4DFD8]">
                {{ app()->getLocale() === 'ar' ? 'صحة النظام وجدولة المهام' : 'Queue & Infrastructure Health' }}
            </h3>
            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between py-1">
                    <span class="text-[#596269]">Horizon / Queues:</span>
                    <span class="font-medium text-[#1E4620] bg-[#EAF5EC] px-2 py-0.5">Active</span>
                </div>
                <div class="flex items-center justify-between py-1">
                    <span class="text-[#596269]">Failed Queue Jobs:</span>
                    <span class="font-medium {{ $failedJobsCount > 0 ? 'text-red-700 bg-red-100' : 'text-[#1E4620] bg-[#EAF5EC]' }} px-2 py-0.5">
                        {{ $failedJobsCount }}
                    </span>
                </div>
                <div class="flex items-center justify-between py-1">
                    <span class="text-[#596269]">MySQL Database:</span>
                    <span class="font-medium text-[#1E4620] bg-[#EAF5EC] px-2 py-0.5">eldeeb (Connected)</span>
                </div>
                <div class="flex items-center justify-between py-1">
                    <span class="text-[#596269]">Security Hardening:</span>
                    <span class="font-medium text-[#172A35] bg-[#F5F1E8] px-2 py-0.5">Strict CSP + Argon2id</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="lg:col-span-2 bg-white p-6 border border-[#E4DFD8]">
            <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-[#172A35] mb-4 pb-2 border-b border-[#E4DFD8]">
                {{ app()->getLocale() === 'ar' ? 'إجراءات سريعة' : 'Quick Actions' }}
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <a href="{{ route('admin.projects.index') }}" class="p-4 border border-[#E4DFD8] hover:border-[#172A35] hover:bg-[#F5F1E8] transition-all text-center flex flex-col items-center gap-2 group">
                    <div class="w-9 h-9 bg-[#172A35] text-[#F5F1E8] group-hover:bg-[#A99776] flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'مشروع جديد' : 'New Project' }}</span>
                </a>

                <a href="{{ route('admin.elevators.index') }}" class="p-4 border border-[#E4DFD8] hover:border-[#172A35] hover:bg-[#F5F1E8] transition-all text-center flex flex-col items-center gap-2 group">
                    <div class="w-9 h-9 bg-[#172A35] text-[#F5F1E8] group-hover:bg-[#A99776] flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'مصعد جديد' : 'New Elevator' }}</span>
                </a>

                <a href="{{ route('admin.blog.index') }}" class="p-4 border border-[#E4DFD8] hover:border-[#172A35] hover:bg-[#F5F1E8] transition-all text-center flex flex-col items-center gap-2 group">
                    <div class="w-9 h-9 bg-[#172A35] text-[#F5F1E8] group-hover:bg-[#A99776] flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'مقال جديد' : 'New Article' }}</span>
                </a>

                <a href="{{ route('admin.media.index') }}" class="p-4 border border-[#E4DFD8] hover:border-[#172A35] hover:bg-[#F5F1E8] transition-all text-center flex flex-col items-center gap-2 group">
                    <div class="w-9 h-9 bg-[#172A35] text-[#F5F1E8] group-hover:bg-[#A99776] flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-xs font-medium text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'رفع وسائط' : 'Upload Media' }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Messages / Inquiries -->
    <div class="bg-white border border-[#E4DFD8]">
        <div class="p-6 border-b border-[#E4DFD8] flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'أحدث رسائل التواصل والاستشارات' : 'Recent Inquiries & Consultation Requests' }}
            </h3>
            <a href="{{ route('admin.messages.index') }}" class="text-xs text-[#A99776] hover:underline font-medium">
                {{ app()->getLocale() === 'ar' ? 'عرض كافة الرسائل' : 'View All Messages' }} &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-start">
                <thead class="bg-[#FAF8F4] text-[#596269] uppercase tracking-wider text-[11px] border-b border-[#E4DFD8]">
                    <tr>
                        <th class="px-6 py-3 text-start">{{ __('admin.messages') }}</th>
                        <th class="px-6 py-3 text-start">Email</th>
                        <th class="px-6 py-3 text-start">Phone</th>
                        <th class="px-6 py-3 text-start">Status</th>
                        <th class="px-6 py-3 text-start">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($recentMessages as $msg)
                        <tr class="hover:bg-[#FAF8F4] transition-colors">
                            <td class="px-6 py-3.5 font-medium text-[#172A35]">{{ $msg->name }}</td>
                            <td class="px-6 py-3.5 text-[#596269]">{{ $msg->email }}</td>
                            <td class="px-6 py-3.5 text-[#596269]">{{ $msg->phone ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase {{ $msg->status === 'new' ? 'bg-[#A99776] text-[#0F1C23]' : 'bg-[#E4DFD8] text-[#596269]' }}">
                                    {{ $msg->status }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-[#778087]">{{ $msg->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#778087]">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد رسائل واردة حالياً.' : 'No incoming messages yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
