<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use App\Models\ElevatorCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ElevatorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Elevator::with(['category', 'media']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name->ar', 'like', "%{$search}%")
                  ->orWhere('name->en', 'like', "%{$search}%")
                  ->orWhere('slug->ar', 'like', "%{$search}%")
                  ->orWhere('slug->en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $elevators = $query->orderBy('sort_order')->orderByDesc('id')->paginate(12)->withQueryString();
        $categories = ElevatorCategory::orderBy('sort_order')->get();

        return view('admin.elevators.index', compact('elevators', 'categories'));
    }

    public function create(): View
    {
        $categories = ElevatorCategory::where('status', 'published')->orderBy('sort_order')->get();

        return view('admin.elevators.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:elevator_categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'short_description_ar' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:published,draft,archived',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'cover' => 'nullable|image|max:10240',
            'gallery.*' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->name_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->name_en);

        // Parse specifications from dynamic inputs if present
        $specs = $this->buildSpecificationsArray($request);

        $elevator = Elevator::create([
            'category_id' => $request->category_id,
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
            ],
            'slug' => [
                'ar' => $slugAr ?: Str::random(8),
                'en' => $slugEn ?: Str::random(8),
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
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'publish_at' => $request->status === 'published' ? now() : null,
        ]);

        if ($request->hasFile('cover')) {
            $elevator->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $elevator->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.elevators.index')->with('success', __('admin.saved'));
    }

    public function edit(Elevator $elevator): View
    {
        $categories = ElevatorCategory::orderBy('sort_order')->get();

        return view('admin.elevators.edit', compact('elevator', 'categories'));
    }

    public function update(Request $request, Elevator $elevator): RedirectResponse
    {
        $request->validate([
            'category_id' => 'required|exists:elevator_categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'short_description_ar' => 'nullable|string|max:500',
            'short_description_en' => 'nullable|string|max:500',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'status' => 'required|in:published,draft,archived',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'cover' => 'nullable|image|max:10240',
            'gallery.*' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->name_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->name_en);

        $specs = $this->buildSpecificationsArray($request);

        $elevator->category_id = $request->category_id;
        $elevator->setTranslation('name', 'ar', $request->name_ar);
        $elevator->setTranslation('name', 'en', $request->name_en);
        $elevator->setTranslation('slug', 'ar', $slugAr ?: Str::random(8));
        $elevator->setTranslation('slug', 'en', $slugEn ?: Str::random(8));
        $elevator->setTranslation('short_description', 'ar', $request->short_description_ar);
        $elevator->setTranslation('short_description', 'en', $request->short_description_en);
        $elevator->setTranslation('description', 'ar', $request->description_ar);
        $elevator->setTranslation('description', 'en', $request->description_en);
        $elevator->specifications = $specs;
        $elevator->status = $request->status;
        $elevator->is_featured = $request->boolean('is_featured');
        $elevator->sort_order = $request->input('sort_order', 0) ?: 0;

        if ($request->status === 'published' && ! $elevator->publish_at) {
            $elevator->publish_at = now();
        }

        $elevator->save();

        if ($request->hasFile('cover')) {
            $elevator->clearMediaCollection('cover');
            $elevator->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $elevator->addMedia($file)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.elevators.index')->with('success', __('admin.saved'));
    }

    public function destroy(Elevator $elevator): RedirectResponse
    {
        $elevator->delete();

        return redirect()->route('admin.elevators.index')->with('success', 'تم الحذف بنجاح.');
    }

    public function destroyMedia(Elevator $elevator, Media $media): RedirectResponse
    {
        if ($media->model_type === Elevator::class && $media->model_id == $elevator->id) {
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
