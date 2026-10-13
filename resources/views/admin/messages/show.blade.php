@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تفاصيل الرسالة: ' . $message->name : 'Message: ' . $message->name)
@section('header_title', app()->getLocale() === 'ar' ? 'تفاصيل رسالة التواصل' : 'Message Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ $message->subject_ref ?: (app()->getLocale() === 'ar' ? 'طلب استشارة وتواصل' : 'Inquiry') }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'واردة بتاريخ:' : 'Received:' }} {{ $message->created_at->format('Y-m-d H:i') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
                &larr; {{ app()->getLocale() === 'ar' ? 'الرجوع للرسائل' : 'Back to Inbox' }}
            </a>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-2 text-xs bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 transition-colors">
                    {{ __('admin.delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Message Content (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
            <div class="border-b border-[#F0ECE1] pb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-[#A99776]">نص الرسالة والطلب</span>
            </div>

            <div class="bg-[#F8F9FA] p-6 border border-[#E4DFD8] text-sm text-[#172A35] leading-relaxed whitespace-pre-line font-sans">
                {{ $message->message }}
            </div>

            <!-- Attachment Download -->
            @if($message->attachment_path)
                <div class="p-4 bg-[#F5F1E8] border border-[#C8C0B5] flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        <div>
                            <div class="text-xs font-bold text-[#172A35]">{{ app()->getLocale() === 'ar' ? 'ملف مرفق مع الرسالة (PDF / صورة)' : 'Attached File' }}</div>
                            <div class="text-[11px] text-[#778087]">{{ basename($message->attachment_path) }}</div>
                        </div>
                    </div>

                    <a href="{{ route('admin.messages.download', $message) }}" class="px-4 py-2 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-semibold transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'تحميل المرفق' : 'Download' }}</span>
                    </a>
                </div>
            @endif

            <!-- Quick Action Links -->
            <div class="pt-4 border-t border-[#F0ECE1] flex items-center gap-4 text-xs font-medium">
                @if($message->email)
                    <a href="mailto:{{ $message->email }}?subject=رد: {{ $message->subject_ref }}" class="px-4 py-2 bg-[#172A35] text-white hover:bg-[#A99776] transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'الرد عبر الإيميل' : 'Reply via Email' }}</span>
                    </a>
                @endif

                @if($message->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="px-4 py-2 bg-[#25D366] text-white hover:opacity-90 transition-opacity flex items-center gap-2">
                        <span>واتساب WhatsApp</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Sidebar / Contact Details & Internal Notes (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Client Info Card -->
            <div class="bg-white border border-[#E4DFD8] p-5 space-y-4 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                    {{ app()->getLocale() === 'ar' ? 'بيانات العميل' : 'Client Profile' }}
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-[#778087] block text-[10px] uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'الاسم:' : 'Name:' }}</span>
                        <span class="font-bold text-[#172A35] text-sm">{{ $message->name }}</span>
                    </div>

                    @if($message->company)
                        <div>
                            <span class="text-[#778087] block text-[10px] uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'الشركة / المؤسسة:' : 'Company:' }}</span>
                            <span class="font-medium text-[#172A35]">{{ $message->company }}</span>
                        </div>
                    @endif

                    <div>
                        <span class="text-[#778087] block text-[10px] uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف:' : 'Phone:' }}</span>
                        <a href="tel:{{ $message->phone }}" class="font-mono text-[#172A35] hover:text-[#A99776]">{{ $message->phone ?: '—' }}</a>
                    </div>

                    <div>
                        <span class="text-[#778087] block text-[10px] uppercase tracking-wider">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني:' : 'Email:' }}</span>
                        <a href="mailto:{{ $message->email }}" class="text-[#172A35] hover:underline">{{ $message->email ?: '—' }}</a>
                    </div>
                </div>
            </div>

            <!-- Status & Internal Notes Update -->
            <div class="bg-white border border-[#E4DFD8] p-5 space-y-4 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                    {{ app()->getLocale() === 'ar' ? 'حالة المتابعة والملاحظات' : 'Status & Internal Notes' }}
                </h3>

                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ __('admin.status') }}
                        </label>
                        <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>جديدة (New)</option>
                            <option value="read" {{ $message->status === 'read' ? 'selected' : '' }}>مقروءة (Read)</option>
                            <option value="replied" {{ $message->status === 'replied' ? 'selected' : '' }}>تم الرد (Replied)</option>
                            <option value="archived" {{ $message->status === 'archived' ? 'selected' : '' }}>مؤرشفة (Archived)</option>
                            <option value="spam" {{ $message->status === 'spam' ? 'selected' : '' }}>بريد مزعج (Spam)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'ملاحظات داخلية لفريق العمل' : 'Internal Team Notes' }}
                        </label>
                        <textarea 
                            name="notes" 
                            rows="4" 
                            placeholder="سجل ملاحظاتك حول الاتصال بالعميل أو نتيجة المعاينة..." 
                            class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]"
                        >{{ old('notes', $message->notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'حفظ التحديثات' : 'Update Message' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
