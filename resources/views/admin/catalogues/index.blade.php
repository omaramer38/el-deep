@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'الكتالوجات والـ PDF' : 'Catalogues & PDFs')
@section('header_title', app()->getLocale() === 'ar' ? 'إدارة الكتالوجات' : 'Catalogues Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'ملفات الكتالوجات والـ PDF' : 'Product Catalogues & PDFs' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'رفع وإدارة كتالوجات المنتجات والمصاعد التي تظهر في القائمة المنسدلة بالموقع.' : 'Manage product catalogues and PDFs visible in the website navigation dropdown.' }}
            </p>
        </div>

        <a href="{{ route('admin.catalogues.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة كتالوج جديد' : 'New Catalogue' }}</span>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start w-12">#</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم الكتالوج' : 'Catalogue Title' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'ملف الـ PDF' : 'PDF File' }}</th>
                        <th class="py-3 px-4 text-center w-20">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3 px-4 text-center w-24">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-end w-36">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($catalogues as $catalogue)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4 text-[#778087] font-mono">
                                {{ $loop->iteration + ($catalogues->currentPage() - 1) * $catalogues->perPage() }}
                            </td>

                            <td class="py-3 px-4">
                                <div class="font-bold text-[#172A35] text-sm">
                                    {{ $catalogue->getTranslation('title', 'ar') }}
                                </div>
                                <div class="text-[11px] text-[#778087] mt-0.5">
                                    {{ $catalogue->getTranslation('title', 'en') }}
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                @if($catalogue->pdf_url && $catalogue->pdf_url !== '#')
                                    <a href="{{ $catalogue->pdf_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#F5F1E8] border border-[#A99776]/40 text-[#172A35] font-medium hover:bg-[#A99776] hover:text-white transition-colors">
                                        <svg class="w-3.5 h-3.5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M11.362 2c-.194 0-.387.079-.53.223L4.3 8.756a.747.747 0 0 0-.22.529v11.966c0 .414.336.749.75.749h14.34a.747.747 0 0 0 .75-.749V2.75a.747.747 0 0 0-.75-.75H11.362zm.388 1.5h6.75v16.5H5.58V9.75h5.42a.747.747 0 0 0 .75-.75V3.5z"/></svg>
                                        <span>{{ app()->getLocale() === 'ar' ? 'عرض الكتالوج (PDF)' : 'View PDF' }}</span>
                                    </a>
                                @else
                                    <span class="text-xs text-[#778087] italic">—</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center font-mono text-[#596269]">
                                {{ $catalogue->sort_order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($catalogue->is_active)
                                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">
                                        {{ app()->getLocale() === 'ar' ? 'نشط' : 'Active' }}
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 text-[10px] font-semibold bg-[#FFFBEA] text-[#713F12]">
                                        {{ app()->getLocale() === 'ar' ? 'مخفي' : 'Disabled' }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.catalogues.edit', $catalogue) }}" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px] font-medium hover:bg-[#A99776] transition-colors">
                                        {{ __('admin.edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.catalogues.destroy', $catalogue) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:bg-red-50 text-[11px] cursor-pointer">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#778087]">
                                {{ app()->getLocale() === 'ar' ? 'لا توجد كتالوجات مسجلة حالياً.' : 'No catalogues uploaded yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($catalogues->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $catalogues->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
