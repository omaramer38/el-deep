<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CatalogueController extends Controller
{
    public function index(): View
    {
        $catalogues = Catalogue::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->paginate(15);

        return view('admin.catalogues.index', compact('catalogues'));
    }

    public function create(): View
    {
        return view('admin.catalogues.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'pdf_file' => 'required|file|mimes:pdf|max:92160',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('pdf_file')) {
            $filePath = $request->file('pdf_file')->store('catalogues', 'public');
        }

        $catalogue = new Catalogue();
        $catalogue->setTranslation('title', 'ar', $request->input('title.ar'));
        if ($request->filled('title.en')) {
            $catalogue->setTranslation('title', 'en', $request->input('title.en'));
        } else {
            $catalogue->setTranslation('title', 'en', $request->input('title.ar'));
        }

        $catalogue->file_path = $filePath;
        $catalogue->sort_order = $request->input('sort_order', 0) ?: 0;
        $catalogue->is_active = $request->has('is_active');
        $catalogue->save();

        if ($request->hasFile('pdf_file')) {
            $catalogue->addMediaFromRequest('pdf_file')->toMediaCollection('pdf', 'public');
        }

        return redirect()->route('admin.catalogues.index')->with('success', 'تمت إضافة الكتالوج بنجاح.');
    }

    public function edit(Catalogue $catalogue): View
    {
        return view('admin.catalogues.edit', compact('catalogue'));
    }

    public function update(Request $request, Catalogue $catalogue): RedirectResponse
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:92160',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $catalogue->setTranslation('title', 'ar', $request->input('title.ar'));
        if ($request->filled('title.en')) {
            $catalogue->setTranslation('title', 'en', $request->input('title.en'));
        }

        if ($request->hasFile('pdf_file')) {
            // Delete old file if exists
            if ($catalogue->file_path && Storage::disk('public')->exists($catalogue->file_path)) {
                Storage::disk('public')->delete($catalogue->file_path);
            }
            $catalogue->file_path = $request->file('pdf_file')->store('catalogues', 'public');
            $catalogue->clearMediaCollection('pdf');
            $catalogue->addMediaFromRequest('pdf_file')->toMediaCollection('pdf', 'public');
        }

        $catalogue->sort_order = $request->input('sort_order', 0) ?: 0;
        $catalogue->is_active = $request->has('is_active');
        $catalogue->save();

        return redirect()->route('admin.catalogues.index')->with('success', 'تم تعديل الكتالوج بنجاح.');
    }

    public function destroy(Catalogue $catalogue): RedirectResponse
    {
        if ($catalogue->file_path && Storage::disk('public')->exists($catalogue->file_path)) {
            Storage::disk('public')->delete($catalogue->file_path);
        }

        $catalogue->delete();

        return redirect()->route('admin.catalogues.index')->with('success', 'تم حذف الكتالوج بنجاح.');
    }
}
