@extends('layouts.admin')

@section('title', __('admin.faqs'))
@section('header_title', __('admin.faqs'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'الأسئلة الشائعة والاستفسارات' : 'Frequently Asked Questions' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة بنك الأسئلة الشائعة والأجوبة الفنية المعتمدة باللغتين العربية والإنجليزية.' : 'Manage FAQ items, technical answers, and categories bilingually.' }}
            </p>
        </div>

        <a href="{{ route('admin.faqs.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة سؤال جديد' : 'New Question' }}</span>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start w-12">#</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'السؤال' : 'Question' }}</th>
                        <th class="py-3 px-4 text-center w-20">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3 px-4 text-center w-24">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-end w-32">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4 text-[#778087] font-mono">
                                {{ $loop->iteration + ($faqs->currentPage() - 1) * $faqs->perPage() }}
                            </td>

                            <td class="py-3 px-4 max-w-md">
                                <div class="font-bold text-[#172A35] text-sm">
                                    {{ $faq->getTranslation('question', 'ar') }}
                                </div>
                                <div class="text-[11px] text-[#778087] mt-0.5">
                                    {{ $faq->getTranslation('question', 'en') }}
                                </div>
                                <div class="text-xs text-[#596269] mt-1 line-clamp-1 italic">
                                    {{ $faq->getTranslation('answer', app()->getLocale()) }}
                                </div>
                            </td>

                            <td class="py-3 px-4 text-center font-mono text-[#596269]">
                                {{ $faq->sort_order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($faq->status === 'published')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">
                                        {{ __('admin.published') }}
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#FFFBEA] text-[#713F12]">
                                        {{ __('admin.draft') }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px] font-medium hover:bg-[#A99776] transition-colors">
                                        {{ __('admin.edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
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
                            <td colspan="5" class="py-8 text-center text-[#778087]">
                                لا توجد أسئلة شائعة مسجلة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
