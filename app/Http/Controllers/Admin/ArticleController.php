<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['category', 'author', 'media']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title->ar', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $articles = $query->orderByDesc('id')->paginate(12)->withQueryString();
        $categories = ArticleCategory::orderBy('sort_order')->get();

        return view('admin.blog.index', compact('articles', 'categories'));
    }

    public function create(): View
    {
        $categories = ArticleCategory::orderBy('sort_order')->get();

        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'excerpt_ar' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'reading_time' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:published,draft,archived',
            'cover' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $article = Article::create([
            'category_id' => $request->category_id,
            'author_id' => auth()->id() ?: 1,
            'title' => [
                'ar' => $request->title_ar,
                'en' => $request->title_en,
            ],
            'slug' => [
                'ar' => $slugAr ?: Str::random(8),
                'en' => $slugEn ?: Str::random(8),
            ],
            'excerpt' => [
                'ar' => $request->excerpt_ar,
                'en' => $request->excerpt_en,
            ],
            'content' => [
                'ar' => $request->filled('content_ar') ? clean($request->content_ar) : null,
                'en' => $request->filled('content_en') ? clean($request->content_en) : null,
            ],
            'reading_time' => $request->input('reading_time', 5) ?: 5,
            'is_featured' => $request->boolean('is_featured'),
            'status' => $request->status,
            'publish_at' => $request->status === 'published' ? now() : null,
        ]);

        if ($request->hasFile('cover')) {
            $article->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return redirect()->route('admin.blog.index')->with('success', __('admin.saved'));
    }

    public function edit(Article $article): View
    {
        $categories = ArticleCategory::orderBy('sort_order')->get();

        return view('admin.blog.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:article_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'excerpt_ar' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'reading_time' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:published,draft,archived',
            'cover' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $article->category_id = $request->category_id;
        $article->setTranslation('title', 'ar', $request->title_ar);
        $article->setTranslation('title', 'en', $request->title_en);
        $article->setTranslation('slug', 'ar', $slugAr ?: Str::random(8));
        $article->setTranslation('slug', 'en', $slugEn ?: Str::random(8));
        $article->setTranslation('excerpt', 'ar', $request->excerpt_ar);
        $article->setTranslation('excerpt', 'en', $request->excerpt_en);
        $article->setTranslation('content', 'ar', $request->filled('content_ar') ? clean($request->content_ar) : null);
        $article->setTranslation('content', 'en', $request->filled('content_en') ? clean($request->content_en) : null);
        $article->reading_time = $request->input('reading_time', 5) ?: 5;
        $article->is_featured = $request->boolean('is_featured');
        $article->status = $request->status;

        if ($request->status === 'published' && ! $article->publish_at) {
            $article->publish_at = now();
        }

        $article->save();

        if ($request->hasFile('cover')) {
            $article->clearMediaCollection('cover');
            $article->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return redirect()->route('admin.blog.index')->with('success', __('admin.saved'));
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.blog.index')->with('success', 'تم حذف المقال بنجاح.');
    }
}
