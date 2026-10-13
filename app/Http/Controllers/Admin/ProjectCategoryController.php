<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ProjectCategory::withCount('projects')->orderBy('sort_order')->get();

        return view('admin.project-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        ProjectCategory::create([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
            ],
            'slug' => [
                'ar' => Str::slug($request->name_ar) ?: Str::random(6),
                'en' => Str::slug($request->name_en) ?: Str::random(6),
            ],
            'sort_order' => $request->input('sort_order', 0) ?: 0,
        ]);

        return back()->with('success', 'تمت إضافة تصنيف المشاريع بنجاح.');
    }

    public function update(Request $request, ProjectCategory $projectCategory): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $projectCategory->setTranslation('name', 'ar', $request->name_ar);
        $projectCategory->setTranslation('name', 'en', $request->name_en);
        $projectCategory->setTranslation('slug', 'ar', Str::slug($request->name_ar) ?: Str::random(6));
        $projectCategory->setTranslation('slug', 'en', Str::slug($request->name_en) ?: Str::random(6));
        $projectCategory->sort_order = $request->input('sort_order', 0) ?: 0;
        $projectCategory->save();

        return back()->with('success', 'تم تعديل تصنيف المشاريع بنجاح.');
    }

    public function destroy(ProjectCategory $projectCategory): RedirectResponse
    {
        $projectCategory->projects()->update(['category_id' => null]);
        $projectCategory->delete();

        return back()->with('success', 'تم حذف تصنيف المشاريع بنجاح ونقل المشاريع المرتبطة إلى بدون تصنيف.');
    }
}
