<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->paginate(15);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question_ar' => 'required|string|max:500',
            'question_en' => 'required|string|max:500',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
        ]);

        Faq::create([
            'category_id' => $request->category_id,
            'question' => [
                'ar' => $request->question_ar,
                'en' => $request->question_en,
            ],
            'answer' => [
                'ar' => $request->answer_ar,
                'en' => $request->answer_en,
            ],
            'sort_order' => $request->input('sort_order', 0) ?: 0,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.faqs.index')->with('success', __('admin.saved'));
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $request->validate([
            'category_id' => 'nullable|exists:faq_categories,id',
            'question_ar' => 'required|string|max:500',
            'question_en' => 'required|string|max:500',
            'answer_ar' => 'required|string',
            'answer_en' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:published,draft',
        ]);

        $faq->category_id = $request->category_id;
        $faq->setTranslation('question', 'ar', $request->question_ar);
        $faq->setTranslation('question', 'en', $request->question_en);
        $faq->setTranslation('answer', 'ar', $request->answer_ar);
        $faq->setTranslation('answer', 'en', $request->answer_en);
        $faq->sort_order = $request->input('sort_order', 0) ?: 0;
        $faq->status = $request->status;
        $faq->save();

        return redirect()->route('admin.faqs.index')->with('success', __('admin.saved'));
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'تم حذف السؤال بنجاح.');
    }
}
