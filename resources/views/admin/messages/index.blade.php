@extends('layouts.admin')

@section('title', __('admin.messages'))
@section('header_title', __('admin.messages'))

@section('content')
<div class="space-y-6">
    <!-- Header & Quick Counters -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'صندوق رسائل التواصل وطلبات المعاينة' : 'Inquiries & Contact Inbox' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'متابعة رسائل العملاء، طلبات عروض الأسعار، والمرفقات والملاحظات الداخلية.' : 'Manage client requests, consultation inquiries, notes, and attachments.' }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] text-xs font-semibold">
                {{ app()->getLocale() === 'ar' ? 'غير مقروءة:' : 'New:' }} <strong class="text-[#A99776]">{{ $counts['new'] }}</strong>
            </span>
            <span class="px-3 py-1.5 bg-[#F8F9FA] border border-[#E4DFD8] text-[#596269] text-xs">
                {{ app()->getLocale() === 'ar' ? 'الإجمالي:' : 'Total:' }} {{ $counts['all'] }}
            </span>
        </div>
    </div>

    <!-- Status Tabs & Search -->
    <div class="bg-white border border-[#E4DFD8] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-1.5 text-xs">
            <a href="{{ route('admin.messages.index') }}" class="px-3 py-1.5 font-medium {{ !request('status') ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-[#F8F9FA] text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'الكل' : 'All' }} ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="px-3 py-1.5 font-medium {{ request('status') === 'new' ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-[#F8F9FA] text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'جديدة' : 'New' }} ({{ $counts['new'] }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="px-3 py-1.5 font-medium {{ request('status') === 'read' ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-[#F8F9FA] text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'مقروءة' : 'Read' }} ({{ $counts['read'] }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="px-3 py-1.5 font-medium {{ request('status') === 'replied' ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-[#F8F9FA] text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'تم الرد' : 'Replied' }} ({{ $counts['replied'] }})
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'archived']) }}" class="px-3 py-1.5 font-medium {{ request('status') === 'archived' ? 'bg-[#172A35] text-[#F5F1E8]' : 'bg-[#F8F9FA] text-[#596269] hover:text-[#172A35]' }} border border-[#C8C0B5] transition-colors">
                {{ app()->getLocale() === 'ar' ? 'مؤرشفة' : 'Archived' }} ({{ $counts['archived'] }})
            </a>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('admin.messages.index') }}" class="flex items-center gap-2">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="{{ app()->getLocale() === 'ar' ? 'بحث بالاسم، الإيميل، الهاتف...' : 'Search by name, email, phone...' }}" 
                class="text-xs px-3 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5] focus:outline-hidden focus:border-[#172A35] w-56"
            >
            <button type="submit" class="px-3 py-1.5 bg-[#233642] text-white text-xs hover:bg-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المرسل' : 'Sender' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'بيانات التواصل' : 'Contact Details' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الموضوع / الخدمة' : 'Subject' }}</th>
                        <th class="py-3 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'التاريخ' : 'Date' }}</th>
                        <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8] text-[#172A35]">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-[#F8F9FA] transition-colors {{ $msg->status === 'new' ? 'bg-[#FDFBF7] font-semibold' : '' }}">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-[#172A35] text-sm">{{ $msg->name }}</div>
                                @if($msg->company)
                                    <div class="text-[11px] text-[#778087]">{{ $msg->company }}</div>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-xs space-y-0.5">
                                <div class="font-mono text-[11px] text-[#172A35]">
                                    <a href="tel:{{ $msg->phone }}" class="hover:text-[#A99776] hover:underline">{{ $msg->phone ?: '—' }}</a>
                                </div>
                                <div class="text-[11px] text-[#778087]">
                                    <a href="mailto:{{ $msg->email }}" class="hover:text-[#172A35] hover:underline">{{ $msg->email ?: '—' }}</a>
                                </div>
                            </td>

                            <td class="py-3.5 px-4">
                                <div class="font-medium text-[#172A35]">{{ $msg->subject_ref ?: (app()->getLocale() === 'ar' ? 'استشارة عامة' : 'General Inquiry') }}</div>
                                <div class="text-[11px] text-[#596269] line-clamp-1 max-w-xs">{{ $msg->message }}</div>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                @if($msg->status === 'new')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-bold bg-[#A99776] text-[#0F1C23]">
                                        {{ app()->getLocale() === 'ar' ? 'جديدة' : 'New' }}
                                    </span>
                                @elseif($msg->status === 'read')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium bg-[#E4DFD8] text-[#596269]">
                                        {{ app()->getLocale() === 'ar' ? 'مقروءة' : 'Read' }}
                                    </span>
                                @elseif($msg->status === 'replied')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">
                                        {{ app()->getLocale() === 'ar' ? 'تم الرد' : 'Replied' }}
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-medium bg-[#F3F4F6] text-[#6B7280]">
                                        {{ $msg->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center font-mono text-[11px] text-[#778087]">
                                {{ $msg->created_at->format('Y-m-d H:i') }}
                            </td>

                            <td class="py-3.5 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a 
                                        href="{{ route('admin.messages.show', $msg) }}" 
                                        class="px-3 py-1 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-[11px] font-medium transition-colors"
                                    >
                                        {{ app()->getLocale() === 'ar' ? 'عرض التفاصيل' : 'View' }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:text-white hover:bg-red-600 text-[11px] border border-red-200 transition-colors">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-[#778087]">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد رسائل واردة حالياً.' : 'No inquiries found.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
