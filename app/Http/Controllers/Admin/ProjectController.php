<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['category', 'media']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title->ar', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%")
                  ->orWhere('location->ar', 'like', "%{$search}%")
                  ->orWhere('location->en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status_publish')) {
            $query->where('status_publish', $request->status_publish);
        }

        $projects = $query->orderBy('sort_order')->orderByDesc('id')->paginate(12)->withQueryString();
        $categories = ProjectCategory::orderBy('sort_order')->get();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();

        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'service_type_ar' => 'nullable|string|max:255',
            'service_type_en' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'elevators_count' => 'nullable|integer',
            'short_description_ar' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'nullable|string|max:100',
            'status_publish' => 'required|in:published,draft,archived',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'cover' => 'nullable|image|max:10240',
            'gallery.*' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $specs = $this->buildSpecificationsArray($request);

        $project = Project::create([
            'category_id' => $request->category_id,
            'title' => [
                'ar' => $request->title_ar,
                'en' => $request->title_en,
            ],
            'slug' => [
                'ar' => $slugAr ?: Str::random(8),
                'en' => $slugEn ?: Str::random(8),
            ],
            'location' => [
                'ar' => $request->location_ar,
                'en' => $request->location_en,
            ],
            'service_type' => [
                'ar' => $request->service_type_ar,
                'en' => $request->service_type_en,
            ],
            'short_description' => [
                'ar' => $request->short_description_ar,
                'en' => $request->short_description_en,
            ],
            'description' => [
                'ar' => $request->description_ar,
                'en' => $request->description_en,
            ],
            'specifications' => $specs,
            'year' => $request->year,
            'elevators_count' => $request->elevators_count ?: 1,
            'status' => $request->status ?: 'Completed',
            'status_publish' => $request->status_publish,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'publish_at' => $request->status_publish === 'published' ? now() : null,
        ]);

        if ($request->hasFile('cover')) {
            $project->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $project->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.projects.index')->with('success', __('admin.saved'));
    }

    public function edit(Project $project): View
    {
        $categories = ProjectCategory::orderBy('sort_order')->get();

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'service_type_ar' => 'nullable|string|max:255',
            'service_type_en' => 'nullable|string|max:255',
            'year' => 'nullable|integer',
            'elevators_count' => 'nullable|integer',
            'short_description_ar' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'nullable|string|max:100',
            'status_publish' => 'required|in:published,draft,archived',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'cover' => 'nullable|image|max:10240',
            'gallery.*' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $specs = $this->buildSpecificationsArray($request);

        $project->category_id = $request->category_id;
        $project->setTranslation('title', 'ar', $request->title_ar);
        $project->setTranslation('title', 'en', $request->title_en);
        $project->setTranslation('slug', 'ar', $slugAr ?: Str::random(8));
        $project->setTranslation('slug', 'en', $slugEn ?: Str::random(8));
        $project->setTranslation('location', 'ar', $request->location_ar);
        $project->setTranslation('location', 'en', $request->location_en);
        $project->setTranslation('service_type', 'ar', $request->service_type_ar);
        $project->setTranslation('service_type', 'en', $request->service_type_en);
        $project->setTranslation('short_description', 'ar', $request->short_description_ar);
        $project->setTranslation('short_description', 'en', $request->short_description_en);
        $project->setTranslation('description', 'ar', $request->description_ar);
        $project->setTranslation('description', 'en', $request->description_en);
        $project->specifications = $specs;
        $project->year = $request->year;
        $project->elevators_count = $request->elevators_count ?: 1;
        $project->status = $request->status ?: 'Completed';
        $project->status_publish = $request->status_publish;
        $project->is_featured = $request->boolean('is_featured');
        $project->sort_order = $request->input('sort_order', 0) ?: 0;

        if ($request->status_publish === 'published' && ! $project->publish_at) {
            $project->publish_at = now();
        }

        $project->save();

        if ($request->hasFile('cover')) {
            $project->clearMediaCollection('cover');
            $project->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $project->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.projects.index')->with('success', __('admin.saved'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع بنجاح.');
    }

    public function destroyMedia(Project $project, Media $media): RedirectResponse
    {
        if ($media->model_type === Project::class && $media->model_id == $project->id) {
            $media->delete();
        }

        return back()->with('success', 'تم حذف الصورة بنجاح.');
    }

    private function buildSpecificationsArray(Request $request): array
    {
        $specKeysAr = $request->input('spec_key_ar', []);
        $specValuesAr = $request->input('spec_value_ar', []);
        $specKeysEn = $request->input('spec_key_en', []);
        $specValuesEn = $request->input('spec_value_en', []);

        $arSpecs = [];
        if (is_array($specKeysAr)) {
            foreach ($specKeysAr as $i => $key) {
                $key = trim($key);
                if ($key !== '') {
                    $arSpecs[$key] = $specValuesAr[$i] ?? '';
                }
            }
        }

        $enSpecs = [];
        if (is_array($specKeysEn)) {
            foreach ($specKeysEn as $i => $key) {
                $key = trim($key);
                if ($key !== '') {
                    $enSpecs[$key] = $specValuesEn[$i] ?? '';
                }
            }
        }

        return [
            'ar' => $arSpecs,
            'en' => $enSpecs,
        ];
    }
}
