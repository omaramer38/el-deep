<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('subject_ref', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => ContactMessage::count(),
            'new' => ContactMessage::where('status', 'new')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
            'archived' => ContactMessage::where('status', 'archived')->count(),
        ];

        return view('admin.messages.index', compact('messages', 'counts'));
    }

    public function show(ContactMessage $message): View
    {
        if ($message->status === 'new') {
            $message->update(['status' => 'read']);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        if (! auth()->user()->can('messages.manage')) {
            abort(403, 'لا تملك الصلاحية لتحديث حالة أو ملاحظات الرسائل.');
        }

        $request->validate([
            'status' => 'required|in:new,read,replied,archived,spam',
            'notes' => 'nullable|string',
        ]);

        $message->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'تم تحديث حالة الرسالة والملاحظات بنجاح.');
    }

    public function downloadAttachment(ContactMessage $message): StreamedResponse|RedirectResponse
    {
        if (! auth()->user()->can('messages.view')) {
            abort(403, 'لا تملك الصلاحية لتحميل مرفقات الرسائل.');
        }

        if (! $message->attachment_path || ! Storage::disk('local')->exists($message->attachment_path)) {
            return back()->with('error', 'الملف المرفق غير موجود أو تعذر تحميله.');
        }

        return Storage::disk('local')->download($message->attachment_path);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        if (! auth()->user()->can('messages.manage')) {
            abort(403, 'لا تملك الصلاحية لحذف رسائل التواصل.');
        }

        if ($message->attachment_path && Storage::disk('local')->exists($message->attachment_path)) {
            Storage::disk('local')->delete($message->attachment_path);
        }

        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'تم حذف الرسالة بنجاح.');
    }
}
