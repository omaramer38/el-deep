@extends('layouts.admin')

@section('title', __('admin.testimonials'))
@section('header_title', __('admin.testimonials'))

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'آراء وتقييمات العملاء' : 'Client Testimonials' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة شهادات الثقة وتقييمات كبرى الشركات والمطورين العقاريين باللغتين.' : 'Manage client feedback, customer quotes, and ratings bilingually.' }}
            </p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة تقييم جديد' : 'New Testimonial' }}</span>
        </a>
    </div>

    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start w-16">{{ app()->getLocale() === 'ar' ? 'الصورة' : 'Avatar' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم العميل / الشركة' : 'Client / Company' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'المنصب / الصفة' : 'Role' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'نص الرأي' : 'Quote' }}</th>
                        <th class="py-3 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($testimonials as $t)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-10 h-10 rounded-full bg-[#172A35] text-white flex items-center justify-center overflow-hidden border border-[#C8C0B5]">
                                    @if($t->avatar)
                                        <img src="{{ $t->avatar }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="font-bold text-xs uppercase">{{ substr($t->name, 0, 1) }}</span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="font-bold text-[#172A35]">{{ $t->name }}</div>
                                @if($t->company)
                                    <div class="text-[11px] text-[#778087]">{{ $t->company }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-[#596269]">
                                <div>{{ $t->getTranslation('role', 'ar') }}</div>
                                <div class="text-[10px] text-[#778087]">{{ $t->getTranslation('role', 'en') }}</div>
                            </td>

                            <td class="py-3 px-4 text-[#596269] max-w-xs">
                                <div class="line-clamp-2 italic">"{{ $t->getTranslation('quote', app()->getLocale()) }}"</div>
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($t->status === 'published')
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
                                    <a href="{{ route('admin.testimonials.edit', $t) }}" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px] font-medium hover:bg-[#A99776]">
                                        {{ __('admin.edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:bg-red-50 text-[11px]">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#778087]">
                                لا توجد تقييمات مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
