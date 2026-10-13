@extends('layouts.admin')

@section('title', $module)
@section('header_title', $module)

@section('content')
<div class="bg-white p-12 border border-[#E4DFD8] text-center max-w-2xl mx-auto my-8">
    <div class="w-16 h-16 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] mx-auto flex items-center justify-center mb-6">
        <svg class="w-8 h-8 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
    </div>
    <h2 class="text-xl font-serif font-bold text-[#172A35] mb-2">{{ $module }}</h2>
    <p class="text-xs text-[#596269] mb-6 leading-relaxed">
        {{ app()->getLocale() === 'ar' ? 'هذه الوحدة مجهزة ومربوطة بقاعدة البيانات وجاهزة لإضافة شاشات التخصيص الكاملة في المراحل القادمة.' : 'This module is database-migrated and ready for full CRUD interface implementation in the upcoming phases.' }}
    </p>
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-[#172A35] text-[#F5F1E8] px-5 py-2.5 text-xs uppercase tracking-wider hover:bg-[#A99776] transition-colors">
        <span>&larr; {{ app()->getLocale() === 'ar' ? 'العودة للوحة التحكم' : 'Back to Dashboard' }}</span>
    </a>
</div>
@endsection
