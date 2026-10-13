@extends('layouts.admin')

@section('title', app()->getLocale() === 'ar' ? 'إضافة تقييم جديد' : 'New Testimonial')
@section('header_title', app()->getLocale() === 'ar' ? 'إضافة تقييم جديد' : 'New Testimonial')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-serif font-bold text-[#172A35]">
                {{ app()->getLocale() === 'ar' ? 'إضافة رأي / تقييم عميل جديد' : 'Add New Client Testimonial' }}
            </h1>
        </div>

        <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 text-xs border border-[#C8C0B5] hover:bg-[#F5F1E8] text-[#172A35] transition-colors">
            &larr; {{ app()->getLocale() === 'ar' ? 'الرجوع للقائمة' : 'Back to list' }}
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

    <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data" class="bg-white border border-[#E4DFD8] p-6 space-y-6 shadow-xs">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">اسم العميل / الشخص *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: م. أحمد السعيد" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">اسم الشركة / المؤسسة</label>
                <input type="text" name="company" value="{{ old('company') }}" placeholder="مثال: مجموعة إعمار للتطوير العقاري" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">المنصب (عربي)</label>
                <input type="text" name="role_ar" value="{{ old('role_ar') }}" placeholder="مثال: رئيس قطاع المشروعات الهندسية" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">Role / Title (English)</label>
                <input type="text" name="role_en" value="{{ old('role_en') }}" placeholder="e.g. Chief Projects Director" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">نص التقييم / الرأي (عربي) *</label>
            <textarea name="quote_ar" rows="3" required placeholder="رأي العميل في منظومة المصاعد وسرعة التركيب وخدمة الصيانة..." class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">{{ old('quote_ar') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-semibold text-[#172A35] mb-1">Quote in English *</label>
            <textarea name="quote_en" rows="3" required placeholder="Client quote in English..." class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">{{ old('quote_en') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">صورة العميل الشخصية (Avatar)</label>
                <input type="file" name="avatar" accept="image/*" class="w-full text-xs px-2 py-1.5 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">الترتيب</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
            </div>

            <div>
                <label class="block text-xs font-semibold text-[#172A35] mb-1">{{ __('admin.status') }}</label>
                <select name="status" class="w-full text-xs px-3 py-2 bg-[#F8F9FA] border border-[#C8C0B5]">
                    <option value="published">{{ __('admin.published') }}</option>
                    <option value="draft">{{ __('admin.draft') }}</option>
                </select>
            </div>
        </div>

        <div class="pt-4 border-t border-[#F0ECE1]">
            <button type="submit" class="w-full py-3 bg-[#172A35] text-[#F5F1E8] hover:bg-[#A99776] text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer">
                {{ app()->getLocale() === 'ar' ? 'حفظ التقييم' : 'Save Testimonial' }}
            </button>
        </div>
    </form>
</div>
@endsection
