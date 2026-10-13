<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();
        $query = Project::published()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request, $locale) {
                $q->where("slug->{$locale}", $request->category)
                    ->orWhere('id', $request->category);
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $locale) {
                $q->where("title->{$locale}", 'like', "%{$search}%")
                    ->orWhere("description->{$locale}", 'like', "%{$search}%")
                    ->orWhere("location->{$locale}", 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('sort_order')->paginate(9);

        // If AJAX request for filtering
        if ($request->ajax()) {
            return view('site.projects._grid', compact('projects'));
        }

        return view('site.projects.index', compact('categories', 'projects'));
    }

    public function show(string $locale, string $slug): View
    {
        $project = Project::published()
            ->with('category')
            ->where("slug->{$locale}", $slug)
            ->firstOrFail();

        $relatedProjects = Project::published()
            ->with('category')
            ->where('id', '!=', $project->id)
            ->where('category_id', $project->category_id)
            ->take(3)
            ->get();

        return view('site.projects.show', compact('project', 'relatedProjects'));
    }
}
