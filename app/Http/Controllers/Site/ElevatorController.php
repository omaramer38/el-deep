<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Elevator;
use App\Models\ElevatorCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElevatorController extends Controller
{
    public function index(Request $request, string $locale): View
    {
        $categories = ElevatorCategory::where('status', 'published')->orderBy('sort_order')->get();
        $query = Elevator::published()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request, $locale) {
                $q->where("slug->{$locale}", $request->category)
                    ->orWhere('id', $request->category);
            });
        }

        $elevators = $query->orderBy('sort_order')->paginate(9);

        return view('site.elevators.index', compact('categories', 'elevators'));
    }

    public function show(string $locale, string $slug): View
    {
        $elevator = Elevator::published()
            ->with('category')
            ->where("slug->{$locale}", $slug)
            ->firstOrFail();

        $relatedElevators = Elevator::published()
            ->with('category')
            ->where('id', '!=', $elevator->id)
            ->where('category_id', $elevator->category_id)
            ->take(3)
            ->get();

        return view('site.elevators.show', compact('elevator', 'relatedElevators'));
    }
}
