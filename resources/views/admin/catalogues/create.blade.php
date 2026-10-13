@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة كتالوج جديد' : 'New Catalogue')
@section('header_title', app()->getLocale() === 'ar' ? 'إضافة كتالوج جديد' : 'New Catalogue')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between bg-white p-4 sm:p-6 border border-[#E4DFD8] shadow-xs">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إضافة كتالوج جديد (PDF)' : 'Add New PDF Catalogue' }}
            </h1>
            <p class="text-xs text-[#778087] mt-1">
                {{ app()->getLocale() === 'ar' ? 'قم بإدخال عنوان الكتالوج بالعربية والإنجليزية ورفع ملف الـ PDF المخصص.' : 'Enter catalogue title in Arabic & English and upload the PDF file.' }}
            </p>
        </div>

        <a href="{{ route('admin.catalogues.index') }}" class="px-4 py-2 text-xs font-semibold bg-[#F5F1E8] text-[#172A35] hover:bg-[#E4DFD8] transition-colors">
            &rarr; {{ app()->getLocale() === 'ar' ? 'عودة للكتالوجات' : 'Back to Catalogues' }}
        </a>
    </div>

    <form method="POST" action="{{ route('admin.catalogues.store') }}" enctype="multipart/form-data" class="bg-white p-6 border border-[#E4DFD8] space-y-6 shadow-xs">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title Arabic -->
            <div>
                <label for="title_ar" class="block text-xs font-bold text-[#172A35] uppercase tracking-wider mb-2">
                    {{ app()->getLocale() === 'ar' ? 'اسم الكتالوج بالعربية' : 'Catalogue Title (Arabic)' }} <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title[ar]" 
                    id="title_ar" 
                    value="{{ old('title.ar') }}" 
                    required 
                    placeholder="مثال: الكابينة / الأبواب / سابقة أعمالنا"
                    class="w-full bg-[#F8F9FA] border border-[#E4DFD8] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776] focus:bg-white"
                >
                @error('title.ar')
                    <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title English -->
            <div>
                <label for="title_en" class="block text-xs font-bold text-[#172A35] uppercase tracking-wider mb-2">
                    {{ app()->getLocale() === 'ar' ? 'اسم الكتالوج بالإنجليزية' : 'Catalogue Title (English)' }}
                </label>
                <input 
                    type="text" 
                    name="title[en]" 
                    id="title_en" 
                    value="{{ old('title.en') }}" 
                    placeholder="e.g. Cabins / Doors / Company Profile"
                    class="w-full bg-[#F8F9FA] border border-[#E4DFD8] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776] focus:bg-white"
                >
                @error('title.en')
                    <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- PDF Upload -->
        <div>
            <label for="pdf_file" class="block text-xs font-bold text-[#172A35] uppercase tracking-wider mb-2">
                {{ app()->getLocale() === 'ar' ? 'ملف الـ PDF' : 'PDF File' }} <span class="text-red-500">*</span>
            </label>
            <div class="border-2 border-dashed border-[#E4DFD8] p-6 text-center hover:border-[#A99776] transition-colors bg-[#F8F9FA]">
                <input 
                    type="file" 
                    name="pdf_file" 
                    id="pdf_file" 
                    accept="application/pdf" 
                    required
                    class="block w-full text-xs text-[#596269] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-[#172A35] file:text-white hover:file:bg-[#A99776]"
                >
                <p class="text-[11px] text-[#778087] mt-2">
                    {{ app()->getLocale() === 'ar' ? 'الملفات المسموح بها: PDF فقط بحجم أقصاه 90 ميجابايت.' : 'Allowed file type: PDF only (Max: 90MB).' }}
                </p>
            </div>
            @error('pdf_file')
                <p class="text-red-600 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-[#E4DFD8]">
            <!-- Sort Order -->
            <div>
                <label for="sort_order" class="block text-xs font-bold text-[#172A35] uppercase tracking-wider mb-2">
                    {{ app()->getLocale() === 'ar' ? 'ترتيب الظهور' : 'Sort Order' }}
                </label>
                <input 
                    type="number" 
                    name="sort_order" 
                    id="sort_order" 
                    value="{{ old('sort_order', 0) }}" 
                    min="0"
                    class="w-full bg-[#F8F9FA] border border-[#E4DFD8] px-3.5 py-2.5 text-xs text-[#172A35] focus:outline-none focus:border-[#A99776] focus:bg-white"
                >
                <p class="text-[11px] text-[#778087] mt-1">
                    {{ app()->getLocale() === 'ar' ? 'القيم الأصغر تظهر أولاً في القائمة المنسدلة.' : 'Lower numbers appear first in dropdown.' }}
                </p>
            </div>

            <!-- Is Active Toggle -->
            <div class="flex items-center gap-3 pt-6">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    id="is_active" 
                    value="1" 
                    {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 text-[#A99776] border-[#E4DFD8] rounded focus:ring-[#A99776]"
                >
                <label for="is_active" class="text-xs font-bold text-[#172A35] cursor-pointer">
                    {{ app()->getLocale() === 'ar' ? 'تفعيل وإظهار الكتالوج بالموقع' : 'Active (Visible in Website Navbar)' }}
                </label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-6 border-t border-[#E4DFD8] flex items-center justify-end gap-3">
            <a href="{{ route('admin.catalogues.index') }}" class="px-5 py-2.5 text-xs font-medium text-[#596269] hover:text-[#172A35]">
                {{ __('admin.cancel') }}
            </a>
            <button type="submit" class="px-6 py-2.5 text-xs font-bold bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] transition-colors uppercase tracking-wider cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'حفظ الكتالوج' : 'Save Catalogue' }}
            </button>
        </div>
    </form>
</div>
@endsection
