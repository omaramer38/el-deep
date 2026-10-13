<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::orderBy('sort_order')->paginate(15);

        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'logo' => 'required|image|max:5120',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $logoPath = Storage::disk('public')->url($path);
        }

        Partner::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'url' => $request->url,
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        return back()->with('success', 'تمت إضافة الشريك / العميل بنجاح.');
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
            'logo' => 'nullable|image|max:5120',
        ]);

        $logoPath = $partner->logo;
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $logoPath = Storage::disk('public')->url($path);
        }

        $partner->update([
            'name' => $request->name,
            'logo' => $logoPath,
            'url' => $request->url,
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        return back()->with('success', 'تم تعديل بيانات الشريك بنجاح.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $partner->delete();

        return back()->with('success', 'تم حذف الشريك بنجاح.');
    }
}
