<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Elevator;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'projects' => Project::count(),
            'elevators' => Elevator::count(),
            'services' => Service::count(),
            'articles' => Article::count(),
            'unread_messages' => ContactMessage::where('status', 'new')->count(),
            'users' => User::count(),
        ];

        // Failed jobs count for queue health widget
        $failedJobsCount = DB::table('failed_jobs')->count();

        // Recent contact messages
        $recentMessages = ContactMessage::latest()->take(5)->get();

        // Recent activity
        $recentActivities = class_exists(Activity::class)
            ? Activity::with('causer')->latest()->take(8)->get()
            : collect();

        return view('admin.dashboard', compact('stats', 'failedJobsCount', 'recentMessages', 'recentActivities'));
    }

    public function switchLocale(string $locale): RedirectResponse
    {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}
