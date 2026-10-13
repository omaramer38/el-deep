<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = ArticleCategory::orderBy('sort_order')->get();
        
        $featuredArticle = Article::published()
            ->with(['category', 'author'])
            ->where('is_featured', true)
            ->latest('publish_at')
            ->first();

        $query = Article::published()->with(['category', 'author']);

        if ($featuredArticle) {
            $query->where('id', '!=', $featuredArticle->id);
        } else {
            // Fallback: If no article is explicitly featured, pick the latest published article as featured
            $featuredArticle = (clone $query)->latest('publish_at')->first();
            if ($featuredArticle) {
                $query->where('id', '!=', $featuredArticle->id);
            }
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request, $locale) {
                $q->where("slug->{$locale}", $request->category);
            });
        }

        $articles = $query->latest('publish_at')->paginate(6);

        return view('site.blog.index', compact('categories', 'featuredArticle', 'articles'));
    }

    public function category(string $locale, string $slug): View
    {
        $category = ArticleCategory::where("slug->{$locale}", $slug)->firstOrFail();
        $categories = ArticleCategory::orderBy('sort_order')->get();
        $articles = Article::published()
            ->with(['category', 'author'])
            ->where('category_id', $category->id)
            ->latest('publish_at')
            ->paginate(9);

        return view('site.blog.category', compact('category', 'categories', 'articles'));
    }

    public function show(string $locale, string $slug): View
    {
        $article = Article::published()
            ->where("slug->{$locale}", $slug)
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();

        $relatedArticles = Article::published()
            ->with(['category', 'author'])
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        return view('site.blog.show', compact('article', 'relatedArticles'));
    }
}
