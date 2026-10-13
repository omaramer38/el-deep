<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request, string $locale): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => $validated['email']],
            [
                'token' => Str::random(40),
                'confirmed_at' => now(), // Double opt-in queue job in production
            ]
        );

        return back()->with('newsletter_success', __('site.newsletter.success'));
    }
}
