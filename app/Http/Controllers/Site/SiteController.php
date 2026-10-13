<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function root(Request $request)
    {
        $preferredLocale = $request->getPreferredLanguage(['ar', 'en']) ?: 'ar';
        $locale = session('locale', $preferredLocale);
        if (! in_array($locale, ['ar', 'en'])) {
            $locale = 'ar';
        }

        return redirect()->route('site.home', ['locale' => $locale]);
    }

    public function home(string $locale): View
    {
        $page = Page::with(['activeSections'])->where('key', 'home')->first();
        $featuredProjects = Project::published()->with('category')->where('is_featured', true)->take(4)->get();
        $featuredElevators = Elevator::published()->with('category')->where('is_featured', true)->take(4)->get();
        $services = Service::published()->take(6)->get();
        $testimonials = Testimonial::published()->take(4)->get();
        $partners = Partner::published()->take(8)->get();

        return view('site.home', compact('page', 'featuredProjects', 'featuredElevators', 'services', 'testimonials', 'partners'));
    }

    public function about(string $locale): View
    {
        $page = Page::with(['activeSections'])->where('key', 'about')->first();
        $testimonials = Testimonial::published()->get();
        $partners = Partner::published()->get();

        return view('site.about', compact('page', 'testimonials', 'partners'));
    }

    public function faq(string $locale): View
    {
        $categories = FaqCategory::with(['faqs' => fn ($q) => $q->where('status', 'published')->orderBy('sort_order')])->get();
        $faqs = Faq::published()->whereNull('category_id')->get();

        return view('site.faq', compact('categories', 'faqs'));
    }

    public function contact(string $locale): View
    {
        $services = Service::published()->get();
        $elevators = Elevator::published()->get();

        return view('site.contact', compact('services', 'elevators'));
    }

    public function privacy(string $locale): View
    {
        $page = Page::where('key', 'privacy')->first();

        return view('site.page', compact('page'));
    }

    public function terms(string $locale): View
    {
        $page = Page::where('key', 'terms')->first();

        return view('site.page', compact('page'));
    }

    public function sitemap()
    {
        return response()->view('site.sitemap', [], 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $robots = Setting::get('robots_txt', "User-agent: *\nDisallow: /admin\nDisallow: /login\nSitemap: ".url('/sitemap.xml'));

        return response($robots, 200, ['Content-Type' => 'text/plain']);
    }
}
