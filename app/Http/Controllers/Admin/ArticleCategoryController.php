<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ArticleCategory::withCount('articles')->orderBy('sort_order')->get();

        return view('admin.blog-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        ArticleCategory::create([
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

        return back()->with('success', 'تمت إضافة تصنيف المقالات بنجاح.');
    }

    public function update(Request $request, ArticleCategory $articleCategory): RedirectResponse
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $articleCategory->setTranslation('name', 'ar', $request->name_ar);
        $articleCategory->setTranslation('name', 'en', $request->name_en);
        $articleCategory->setTranslation('slug', 'ar', Str::slug($request->name_ar) ?: Str::random(6));
        $articleCategory->setTranslation('slug', 'en', Str::slug($request->name_en) ?: Str::random(6));
        $articleCategory->sort_order = $request->input('sort_order', 0) ?: 0;
        $articleCategory->save();

        return back()->with('success', 'تم تعديل تصنيف المقالات بنجاح.');
    }

    public function destroy(ArticleCategory $articleCategory): RedirectResponse
    {
        $articleCategory->articles()->update(['category_id' => null]);
        $articleCategory->delete();

        return back()->with('success', 'تم حذف تصنيف المقالات بنجاح ونقل المقالات المرتبطة إلى بدون تصنيف.');
    }
}
