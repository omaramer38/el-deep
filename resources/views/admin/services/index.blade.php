@extends('layouts.admin')

@section('title', __('admin.services'))
@section('header_title', __('admin.services'))

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إدارة خدمات المصاعد والأنظمة' : 'Engineering Services' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'إدارة باقات التركيب، عقود الصيانة، التحديث والترقية، والاستشارات الهندسية باللغتين.' : 'Manage turnkey installations, maintenance packages, modernization, and consulting services.' }}
            </p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="px-5 py-2.5 text-xs font-semibold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors flex items-center gap-2 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'إضافة خدمة جديدة' : 'New Service' }}</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white border border-[#E4DFD8] overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3.5 px-4 text-start w-16">{{ app()->getLocale() === 'ar' ? 'الصورة' : 'Image' }}</th>
                        <th class="py-3.5 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'عنوان الخدمة (عربي / English)' : 'Service Title' }}</th>
                        <th class="py-3.5 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الأيقونة' : 'Icon' }}</th>
                        <th class="py-3.5 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3.5 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3.5 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8] text-[#172A35]">
                    @forelse($services as $service)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-12 h-12 bg-[#F5F1E8] border border-[#C8C0B5] flex items-center justify-center overflow-hidden">
                                    @if($service->hasMedia('image'))
                                        <img src="{{ $service->getFirstMediaUrl('image') }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-[#A99776]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="font-bold text-[#172A35] text-sm flex items-center gap-2">
                                    <span>{{ $service->getTranslation('title', 'ar') }}</span>
                                    <span class="text-[10px] text-[#A99776] bg-[#F5F1E8] px-1.5 py-0.5 border border-[#E4DFD8]">AR</span>
                                </div>
                                <div class="text-[11px] text-[#596269] flex items-center gap-2 mt-0.5">
                                    <span>{{ $service->getTranslation('title', 'en') }}</span>
                                    <span class="text-[10px] text-[#596269] bg-[#E4DFD8] px-1 py-0.2">EN</span>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-[#778087] font-mono text-[11px]">
                                {{ $service->icon ?: 'default' }}
                            </td>

                            <td class="py-3 px-4 text-center font-mono text-xs text-[#778087]">
                                {{ $service->sort_order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($service->status === 'published')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620] border border-[#BDE0C3]">
                                        {{ __('admin.published') }}
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#FFFBEA] text-[#713F12] border border-[#FEF08A]">
                                        {{ __('admin.draft') }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    @php
                                        $viewLocale = in_array(app()->getLocale(), ['ar', 'en']) ? app()->getLocale() : 'ar';
                                        $serviceSlug = $service->getTranslation('slug', $viewLocale) 
                                            ?: $service->getTranslation('slug', 'ar') 
                                            ?: $service->getTranslation('slug', 'en') 
                                            ?: (string)$service->id;
                                    @endphp
                                    <a 
                                        href="{{ route('site.services.show', ['locale' => $viewLocale, 'slug' => $serviceSlug]) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-[#778087] hover:text-[#172A35] transition-colors" 
                                        title="{{ app()->getLocale() === 'ar' ? 'معاينة في الموقع' : 'View on website' }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    <a 
                                        href="{{ route('admin.services.edit', $service) }}" 
                                        class="px-3 py-1 bg-[#172A35] text-white hover:bg-[#A99776] transition-colors text-[11px] font-medium"
                                    >
                                        {{ __('admin.edit') }}
                                    </a>

                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-red-600 hover:text-white hover:bg-red-600 border border-red-200 transition-colors text-[11px]">
                                            {{ __('admin.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-[#778087]">
                                <p>{{ app()->getLocale() === 'ar' ? 'لا توجد خدمات مضافة حالياً.' : 'No services found.' }}</p>
                                <a href="{{ route('admin.services.create') }}" class="inline-block text-xs text-[#A99776] font-semibold hover:underline mt-2">
                                    + {{ app()->getLocale() === 'ar' ? 'إضافة خدمة جديدة الآن' : 'Create new service now' }}
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
