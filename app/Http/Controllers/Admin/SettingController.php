<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        if (! auth()->user()->can('settings.view')) {
            abort(403, 'لا تملك الصلاحية لعرض إعدادات الموقع.');
        }

        $settings = [
            'site_name' => Setting::get('site_name', ['ar' => 'الديب', 'en' => 'EL DEEB']),
            'site_tagline' => Setting::get('site_tagline', ['ar' => 'تحريك الأفراد. بناء الثقة.', 'en' => 'Moving People. Building Confidence.']),
            'contact_phone' => Setting::get('contact_phone', '+20 2 0000 0000'),
            'contact_whatsapp' => Setting::get('contact_whatsapp', '+20 100 000 0000'),
            'contact_email' => Setting::get('contact_email', 'info@eldeeb-elevators.com'),
            'contact_address' => Setting::get('contact_address', [
                'ar' => 'حي المال والأعمال، القاهرة الجديدة، مصر',
                'en' => 'Financial & Business District, New Cairo, Egypt',
            ]),
            'contact_hours' => Setting::get('contact_hours', [
                'ar' => 'الأحد - الخميس: 9:00 ص - 6:00 م',
                'en' => 'Sun - Thu: 9:00 AM - 6:00 PM',
            ]),
            'social_facebook' => Setting::get('social_facebook', ''),
            'social_linkedin' => Setting::get('social_linkedin', ''),
            'social_instagram' => Setting::get('social_instagram', ''),
            'social_twitter' => Setting::get('social_twitter', ''),
            'social_youtube' => Setting::get('social_youtube', ''),
            'map_embed_url' => Setting::get('map_embed_url', ''),
            'site_logo' => Setting::get('site_logo', ''),
            'site_logo_dark' => Setting::get('site_logo_dark', ''),
            'site_favicon' => Setting::get('site_favicon', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        if (! auth()->user()->can('settings.manage')) {
            abort(403, 'لا تملك الصلاحية لتعديل إعدادات وهوية الموقع.');
        }

        $request->validate([
            'site_name_ar' => 'required|string|max:255',
            'site_name_en' => 'required|string|max:255',
            'site_tagline_ar' => 'nullable|string|max:255',
            'site_tagline_en' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'contact_whatsapp' => 'nullable|string|max:100',
            'contact_email' => 'nullable|email|max:150',
            'contact_address_ar' => 'nullable|string|max:500',
            'contact_address_en' => 'nullable|string|max:500',
            'contact_hours_ar' => 'nullable|string|max:255',
            'contact_hours_en' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'site_logo' => 'nullable|image|max:5120',
            'site_logo_dark' => 'nullable|image|max:5120',
            'site_favicon' => 'nullable|file|mimes:ico,png|max:2048',
        ]);

        // Bilingual Site Name & Tagline
        Setting::set('site_name', [
            'ar' => $request->site_name_ar,
            'en' => $request->site_name_en,
        ]);

        Setting::set('site_tagline', [
            'ar' => $request->site_tagline_ar,
            'en' => $request->site_tagline_en,
        ]);

        // Contact info
        Setting::set('contact_phone', $request->contact_phone);
        Setting::set('contact_whatsapp', $request->contact_whatsapp);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_address', [
            'ar' => $request->contact_address_ar,
            'en' => $request->contact_address_en,
        ]);
        Setting::set('contact_hours', [
            'ar' => $request->contact_hours_ar,
            'en' => $request->contact_hours_en,
        ]);

        // Social Links
        Setting::set('social_facebook', $request->social_facebook);
        Setting::set('social_linkedin', $request->social_linkedin);
        Setting::set('social_instagram', $request->social_instagram);
        Setting::set('social_twitter', $request->social_twitter);
        Setting::set('social_youtube', $request->social_youtube);
        Setting::set('map_embed_url', $request->map_embed_url);

        // Upload Logo
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('branding', 'public');
            Setting::set('site_logo', Storage::disk('public')->url($path));
        }

        // Upload Dark Logo
        if ($request->hasFile('site_logo_dark')) {
            $path = $request->file('site_logo_dark')->store('branding', 'public');
            Setting::set('site_logo_dark', Storage::disk('public')->url($path));
        }

        // Upload Favicon
        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('branding', 'public');
            Setting::set('site_favicon', Storage::disk('public')->url($path));
        }

        return back()->with('success', 'تم حفظ وتحديث كافة إعدادات وهوية الموقع بنجاح.');
    }
}
