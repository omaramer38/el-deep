<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ElevatorCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ElevatorCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ElevatorCategory::withCount('elevators')->orderBy('sort_order')->get();

        return view('admin.elevator-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
        ]);

        ElevatorCategory::create([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
            ],
            'slug' => [
                'ar' => Str::slug($request->name_ar) ?: Str::random(6),
                'en' => Str::slug($request->name_en) ?: Str::random(6),
            ],
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        return back()->with('success', 'تمت إضافة التصنيف بنجاح.');
    }

    public function update(Request $request, ElevatorCategory $elevatorCategory): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
        ]);

        $elevatorCategory->setTranslation('name', 'ar', $request->name_ar);
        $elevatorCategory->setTranslation('name', 'en', $request->name_en);
        $elevatorCategory->setTranslation('slug', 'ar', Str::slug($request->name_ar) ?: Str::random(6));
        $elevatorCategory->setTranslation('slug', 'en', Str::slug($request->name_en) ?: Str::random(6));
        $elevatorCategory->sort_order = $request->input('sort_order', 0) ?: 0;
        $elevatorCategory->status = $request->status;
        $elevatorCategory->save();

        return back()->with('success', 'تم تعديل التصنيف بنجاح.');
    }

    public function destroy(ElevatorCategory $elevatorCategory): RedirectResponse
    {
        $elevatorCategory->elevators()->update(['category_id' => null]);
        $elevatorCategory->delete();

        return back()->with('success', 'تم حذف التصنيف بنجاح ونقل المصاعد المرتبطة إلى بدون تصنيف.');
    }
}
