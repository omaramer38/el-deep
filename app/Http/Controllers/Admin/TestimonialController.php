<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'role_ar' => 'nullable|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'quote_ar' => 'required|string',
            'quote_en' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $avatarPath = Storage::disk('public')->url($path);
        }

        Testimonial::create([
            'name' => $request->name,
            'company' => $request->company,
            'role' => [
                'ar' => $request->role_ar,
                'en' => $request->role_en,
            ],
            'quote' => [
                'ar' => $request->quote_ar,
                'en' => $request->quote_en,
            ],
            'avatar' => $avatarPath,
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.saved'));
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'role_ar' => 'nullable|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'quote_ar' => 'required|string',
            'quote_en' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $avatarPath = $testimonial->avatar;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('testimonials', 'public');
            $avatarPath = Storage::disk('public')->url($path);
        }

        $testimonial->name = $request->name;
        $testimonial->company = $request->company;
        $testimonial->setTranslation('role', 'ar', $request->role_ar);
        $testimonial->setTranslation('role', 'en', $request->role_en);
        $testimonial->setTranslation('quote', 'ar', $request->quote_ar);
        $testimonial->setTranslation('quote', 'en', $request->quote_en);
        $testimonial->avatar = $avatarPath;
        $testimonial->sort_order = $request->input('sort_order', 0) ?: 0;
        $testimonial->status = $request->status;
        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', __('admin.saved'));
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'تم حذف التقييم بنجاح.');
    }
}
