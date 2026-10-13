@extends('layouts.admin')

@section('title', __('admin.activity_log'))
@section('header_title', __('admin.activity_log'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'سجل النشاطات والعمليات' : 'Audit Trail & Activity Log' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'تتبع زمني لكافة الإجراءات والتعديلات المنفذة على النظام لضمان أعلى معايير الأمان والشفافية.' : 'Full chronological audit log of all system changes, user actions, and modifications.' }}
            </p>
        </div>

        <form method="GET" action="{{ route('admin.activity.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ app()->getLocale() === 'ar' ? 'بحث في السجل...' : 'Search logs...' }}" class="text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            <button type="submit" class="px-4 py-2 bg-[#172A35] text-white text-xs font-semibold uppercase tracking-wider">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
        </form>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start w-36">{{ app()->getLocale() === 'ar' ? 'الوقت' : 'Timestamp' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المستخدم' : 'Causer / User' }}</th>
                        <th class="py-3 px-4 text-center w-24">{{ app()->getLocale() === 'ar' ? 'الحدث' : 'Event' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الوصف' : 'Description' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الهدف / العنصر' : 'Subject' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($activities as $act)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4 text-[11px] text-[#596269] font-mono whitespace-nowrap">
                                <div>{{ $act->created_at->format('Y-m-d H:i') }}</div>
                                <div class="text-[10px] text-[#778087]">{{ $act->created_at->diffForHumans() }}</div>
                            </td>

                            <td class="py-3 px-4">
                                @if($act->causer)
                                    <div class="font-bold text-[#172A35]">{{ $act->causer->name }}</div>
                                    <div class="text-[10px] text-[#778087] font-mono">{{ $act->causer->email }}</div>
                                @else
                                    <span class="text-[#778087] italic">نظام آلي (System)</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center">
                                @php
                                    $event = $act->event ?? 'action';
                                    $color = match($event) {
                                        'created' => 'bg-[#EAF5EC] text-[#1E4620]',
                                        'updated' => 'bg-[#EBF3FB] text-[#1A446C]',
                                        'deleted' => 'bg-[#FDEAEA] text-[#6E1A1A]',
                                        default => 'bg-[#F5F1E8] text-[#172A35]',
                                    };
                                @endphp
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $color }}">
                                    {{ $event }}
                                </span>
                            </td>

                            <td class="py-3 px-4 font-medium text-[#172A35]">
                                {{ $act->description }}
                            </td>

                            <td class="py-3 px-4 text-[#596269] font-mono text-[11px]">
                                @if($act->subject)
                                    <span>{{ class_basename($act->subject_type) }} #{{ $act->subject_id }}</span>
                                @else
                                    <span class="text-[#778087]">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-[#778087]">
                                <svg class="w-10 h-10 mx-auto text-[#C8C0B5] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <div>لا توجد سجلات نشاط مسجلة حتى الآن.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
