<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request, string $locale): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:120'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp,docx', 'max:10240'], // 10MB cap
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('contact_attachments', 'local');
        }

        // Store contact message with hashed IP
        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'subject_ref' => $validated['subject'] ?? null,
            'message' => strip_tags($validated['message']),
            'attachment_path' => $attachmentPath,
            'status' => 'new',
            'ip_hash' => hash('sha256', $request->ip()),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
        ]);

        return back()->with('contact_success', __('site.contact.success'));
    }
}
