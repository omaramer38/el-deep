<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::with('media');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title->ar', 'like', "%{$search}%")
                  ->orWhere('title->en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $services = $query->orderBy('sort_order')->paginate(12)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'cta_ar' => 'nullable|string|max:255',
            'cta_en' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $service = Service::create([
            'title' => [
                'ar' => $request->title_ar,
                'en' => $request->title_en,
            ],
            'slug' => [
                'ar' => $slugAr ?: Str::random(8),
                'en' => $slugEn ?: Str::random(8),
            ],
            'description' => [
                'ar' => $request->description_ar,
                'en' => $request->description_en,
            ],
            'content' => [
                'ar' => $request->content_ar,
                'en' => $request->content_en,
            ],
            'cta' => [
                'ar' => $request->cta_ar ?: 'طلب الخدمة والاستشارة',
                'en' => $request->cta_en ?: 'Request Service Consultation',
            ],
            'icon' => $request->icon ?: 'elevator',
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        if ($request->hasFile('image')) {
            $service->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.services.index')->with('success', __('admin.saved'));
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug_ar' => 'nullable|string|max:255',
            'slug_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string|max:500',
            'description_en' => 'nullable|string|max:500',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'cta_ar' => 'nullable|string|max:255',
            'cta_en' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|max:10240',
        ]);

        $slugAr = $request->slug_ar ? Str::slug($request->slug_ar) : Str::slug($request->title_ar);
        $slugEn = $request->slug_en ? Str::slug($request->slug_en) : Str::slug($request->title_en);

        $service->setTranslation('title', 'ar', $request->title_ar);
        $service->setTranslation('title', 'en', $request->title_en);
        $service->setTranslation('slug', 'ar', $slugAr ?: Str::random(8));
        $service->setTranslation('slug', 'en', $slugEn ?: Str::random(8));
        $service->setTranslation('description', 'ar', $request->description_ar);
        $service->setTranslation('description', 'en', $request->description_en);
        $service->setTranslation('content', 'ar', $request->content_ar);
        $service->setTranslation('content', 'en', $request->content_en);
        $service->setTranslation('cta', 'ar', $request->cta_ar ?: 'طلب الخدمة والاستشارة');
        $service->setTranslation('cta', 'en', $request->cta_en ?: 'Request Service Consultation');
        $service->icon = $request->icon ?: $service->icon;
        $service->sort_order = $request->input('sort_order', 0) ?: 0;
        $service->status = $request->status;
        $service->save();

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('image');
            $service->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.services.index')->with('success', __('admin.saved'));
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة بنجاح.');
    }
}
