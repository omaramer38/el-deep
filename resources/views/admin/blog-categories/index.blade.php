@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'تصنيفات المدونة' : 'Blog Categories')
@section('header_title', app()->getLocale() === 'ar' ? 'تصنيفات المدونة' : 'Blog Categories')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'تصنيفات المقالات والمدونة' : 'Blog Categories' }}
            </h1>
            <p class="text-xs text-[#778087] mt-0.5">
                {{ app()->getLocale() === 'ar' ? 'تنظيم تصنيفات المقالات مثل: دراسات تقنية، معايير الأمان والسلامة، أخبار الصناعة.' : 'Manage blog categories and content classifications.' }}
            </p>
        </div>

        <a href="{{ route('admin.blog.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
            &larr; {{ app()->getLocale() === 'ar' ? 'العودة للمدونة' : 'Back to Blog' }}
        </a>
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
        <!-- Categories Table (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-[#E4DFD8] shadow-xs overflow-hidden">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-[#172A35] text-[#F5F1E8] uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'ar' ? 'التصنيف (عربي / English)' : 'Category Name' }}</th>
                        <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'المقالات' : 'Articles' }}</th>
                        <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Order' }}</th>
                        <th class="py-3 px-4 text-end">{{ __('admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E4DFD8]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-[#F8F9FA] transition-colors" x-data="{ editing: false }">
                            <td class="py-3 px-4">
                                <div x-show="!editing">
                                    <div class="font-bold text-[#172A35]">{{ $category->getTranslation('name', 'ar') }}</div>
                                    <div class="text-[11px] text-[#778087]">{{ $category->getTranslation('name', 'en') }}</div>
                                </div>

                                <form 
                                    x-show="editing" 
                                    method="POST" 
                                    action="{{ route('admin.blog-categories.update', $category) }}" 
                                    class="space-y-2 py-2"
                                    style="display: none;"
                                >
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" name="name_ar" value="{{ $category->getTranslation('name', 'ar') }}" required class="text-xs px-2 py-1 bg-white border border-[#C8C0B5]" placeholder="الاسم بالعربية">
                                        <input type="text" name="name_en" value="{{ $category->getTranslation('name', 'en') }}" required class="text-xs px-2 py-1 bg-white border border-[#C8C0B5]" placeholder="Name in English">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="sort_order" value="{{ $category->sort_order }}" class="w-16 text-xs px-2 py-1 bg-white border border-[#C8C0B5]">
                                        <button type="submit" class="px-2.5 py-1 bg-[#172A35] text-white text-[11px]">حفظ</button>
                                        <button type="button" @click="editing = false" class="px-2 py-1 border text-[#778087] text-[11px]">إلغاء</button>
                                    </div>
                                </form>
                            </td>

                            <td class="py-3 px-4 text-center">
                                <span class="bg-[#F5F1E8] text-[#172A35] font-bold px-2 py-0.5 border border-[#C8C0B5]">
                                    {{ $category->articles_count }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-center font-mono text-xs text-[#778087]">
                                {{ $category->sort_order }}
                            </td>

                            <td class="py-3 px-4 text-end">
                                <div class="inline-flex items-center gap-2" x-show="!editing">
                                    <button 
                                        type="button" 
                                        @click="editing = true" 
                                        class="px-2.5 py-1 bg-[#F5F1E8] border border-[#C8C0B5] text-[#172A35] hover:bg-[#172A35] hover:text-white transition-colors text-[11px]"
                                    >
                                        {{ __('admin.edit') }}
                                    </button>

                                    <form method="POST" action="{{ route('admin.blog-categories.destroy', $category) }}" onsubmit="return confirm('{{ $category->articles_count > 0 ? (app()->getLocale() === 'ar' ? 'تنبيه: هذا التصنيف مرتبط بعدد ' . $category->articles_count . ' مقال. عند حذفه ستتحول هذه المقالات إلى (بدون تصنيف). هل تريد بالتأكيد حذفه؟' : 'Warning: This category has ' . $category->articles_count . ' articles. Deleting will make them uncategorized. Continue?') : __('admin.delete_confirm') }}');" class="inline">
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
                            <td colspan="4" class="py-8 text-center text-[#778087]">
                                لا توجد تصنيفات حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add Category Form (4 cols) -->
        <div class="lg:col-span-4 bg-white p-5 border border-[#E4DFD8] shadow-xs space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#172A35] border-b border-[#F0ECE1] pb-2">
                {{ app()->getLocale() === 'ar' ? 'إضافة تصنيف جديد' : 'New Category' }}
            </h3>

            <form method="POST" action="{{ route('admin.blog-categories.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        اسم التصنيف (بالعربية) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_ar" required placeholder="مثال: دراسات تقنية وأمان" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        اسم التصنيف (بالإنجليزي) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_en" required placeholder="e.g. Safety & Standards" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-[#172A35] mb-1">
                        {{ app()->getLocale() === 'ar' ? 'الترتيب' : 'Sort Order' }}
                    </label>
                    <input type="number" name="sort_order" value="0" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                </div>

                <button type="submit" class="w-full py-2.5 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                    {{ app()->getLocale() === 'ar' ? 'حفظ التصنيف' : 'Save Category' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
