@extends('layouts.admin')

@section('title', __('admin.partners'))
@section('header_title', __('admin.partners'))

@section('content')
<div class="space-y-6" x-data="{ 
    editModal: false, 
    editId: null, 
    editName: '', 
    editUrl: '', 
    editSort: 0, 
    editStatus: 'published', 
    editLogo: '', 
    updateAction: '',
    openEdit(partner, url) {
        this.editId = partner.id;
        this.editName = partner.name;
        this.editUrl = partner.url || '';
        this.editSort = partner.sort_order || 0;
        this.editStatus = partner.status || 'published';
        this.editLogo = partner.logo || '';
        this.updateAction = url;
        this.editModal = true;
    }
}">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إدارة الشركاء والعملاء' : 'Partners & Clients' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'إضافة وتعديل شعارات كبرى الشركات والمطورين العقاريين الشركاء.' : 'Manage client and partner logos, brands, and links.' }}
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-[#FDEAEA] border border-[#F5C2C2] text-[#6E1A1A] text-xs">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Partners Grid / Table (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E4DFD8] shadow-xs overflow-hidden">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start w-20">{{ app()->getLocale() === 'ar' ? 'الشعار' : 'Logo' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'اسم الشريك / الشركة' : 'Partner Name' }}</th>
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'الموقع' : 'URL' }}</th>
                        <th class="py-3 px-4 text-center">{{ __('admin.status') }}</th>
                        <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-[#F8F9FA] transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-16 h-10 bg-white border border-[#C8C0B5] flex items-center justify-center p-1 overflow-hidden">
                                    @if($partner->logo)
                                        <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="text-[10px] text-[#778087]">No logo</span>
                                    @endif
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="font-bold text-[#172A35]">{{ $partner->name }}</div>
                            </td>

                            <td class="py-3 px-4 text-[#596269] font-mono text-[11px]">
                                @if($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" class="hover:text-[#A99776] hover:underline">{{ $partner->url }}</a>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($partner->status === 'published')
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#EAF5EC] text-[#1E4620]">منشور</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-[#FFFBEA] text-[#713F12]">مسودة</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2">
                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($partner) }}, '{{ route('admin.partners.update', $partner) }}')" 
                                        class="px-2.5 py-1 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] hover:bg-[#172A35] hover:text-white transition-colors text-[11px] cursor-pointer"
                                    >
                                        {{ __('admin.edit') }}
                                    </button>

                                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" onsubmit="return confirm('{{ __('admin.delete_confirm') }}');" class="inline">
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
                                لا يوجد شركاء مسجلين حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($partners->hasPages())
                <div class="p-4 border-t border-[#E4DFD8] bg-[#F8F9FA]">
                    {{ $partners->links() }}
                </div>
            @endif
        </div>

        <!-- Add Partner Form (4 cols) -->
        <div class="lg:col-span-4 bg-white p-5 border border-[#E4DFD8] shadow-xs space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'إضافة شريك جديد' : 'Add New Partner' }}
            </h3>

            <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">اسم الشريك / الشركة *</label>
                    <input type="text" name="name" required placeholder="مثال: أوراسكوم للإنشاءات" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">رابط الموقع الإلكتروني للشريك</label>
                    <input type="url" name="url" placeholder="https://company.com" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">شعار الشريك (Logo) *</label>
                    <input type="file" name="logo" required accept="image/*" class="w-full text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
                    <span class="text-[10px] text-[#778087]">PNG, SVG, JPG (يفضل خلفية شفافة)</span>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">الترتيب</label>
                    <input type="number" name="sort_order" value="0" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ __('admin.status') }}</label>
                    <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                        <option value="published">{{ __('admin.published') }}</option>
                        <option value="draft">{{ __('admin.draft') }}</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                    {{ app()->getLocale() === 'ar' ? 'حفظ الشريك' : 'Save Partner' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Edit Partner Modal -->
    <div 
        x-show="editModal" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div 
            class="bg-white max-w-lg w-full border border-[#C8C0B5] shadow-2xl p-6 relative" 
            @click.away="editModal = false"
        >
            <div class="flex items-center justify-between border-b border-[#F0ECE1] pb-3 mb-4">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#172A35]">
                    {{ app()->getLocale() === 'ar' ? 'تعديل بيانات الشريك / العميل' : 'Edit Partner / Client' }}
                </h3>
                <button type="button" @click="editModal = false" class="text-[#778087] hover:text-[#172A35] text-xl font-bold cursor-pointer">
                    &times;
                </button>
            </div>

            <form method="POST" :action="updateAction" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'اسم الشريك / الشركة *' : 'Partner Name *' }}
                    </label>
                    <input type="text" name="name" x-model="editName" required class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'رابط الموقع الإلكتروني للشريك' : 'Partner Website URL' }}
                    </label>
                    <input type="url" name="url" x-model="editUrl" placeholder="https://company.com" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5] font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'الشعار الحالي' : 'Current Logo' }}
                    </label>
                    <div class="w-24 h-14 bg-white border border-[#C8C0B5] flex items-center justify-center p-1 mb-2 overflow-hidden">
                        <template x-if="editLogo">
                            <img :src="editLogo" alt="Logo" class="max-h-full max-w-full object-contain">
                        </template>
                        <template x-if="!editLogo">
                            <span class="text-[10px] text-[#778087]">No logo</span>
                        </template>
                    </div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'تغيير الشعار (اختياري)' : 'Replace Logo (Optional)' }}
                    </label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
                    <span class="text-[10px] text-[#778087]">PNG, SVG, JPG (يفضل خلفية شفافة)</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Sort Order' }}
                        </label>
                        <input type="number" name="sort_order" x-model="editSort" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-[#172A35] mb-1">
                            {{ __('admin.status') }}
                        </label>
                        <select name="status" x-model="editStatus" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                            <option value="published">{{ __('admin.published') }}</option>
                            <option value="draft">{{ __('admin.draft') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#F0ECE1]">
                    <button type="button" @click="editModal = false" class="px-4 py-2 border border-[#C8C0B5] text-[#596269] hover:bg-[#F5F1E8] text-xs cursor-pointer">
                        {{ __('admin.cancel') }}
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                        {{ app()->getLocale() === 'ar' ? 'حفظ التعديلات' : 'Save Changes' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
