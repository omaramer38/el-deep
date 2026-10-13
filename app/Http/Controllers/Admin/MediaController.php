<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Elevator;
use App\Models\MediaFolder;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $folders = MediaFolder::withCount('media')->orderBy('name')->get();
        $currentFolderId = $request->query('folder');
        $section = $request->query('section');
        $collection = $request->query('collection');

        $query = Media::query()->with('model')->latest();

        if ($currentFolderId) {
            $query->where('folder_id', $currentFolderId);
        }

        // Filter by website section / model
        if ($section) {
            switch ($section) {
                case 'projects':
                    $query->where('model_type', Project::class);
                    break;
                case 'elevators':
                    $query->where('model_type', Elevator::class);
                    break;
                case 'blog':
                    $query->where('model_type', Article::class);
                    break;
                case 'services':
                    $query->where('model_type', Service::class);
                    break;
                case 'general':
                    $query->where(function ($q) {
                        $q->where('model_type', MediaFolder::class)
                          ->orWhereNull('model_type');
                    });
                    break;
            }
        }

        // Filter by placement / collection
        if ($collection) {
            $query->where('collection_name', $collection);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            if ($request->type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->type === 'document') {
                $query->where('mime_type', 'like', 'application/%');
            }
        }

        $media = $query->paginate(24)->withQueryString();

        $totalMediaCount = Media::count();
        $totalBytes = Media::sum('size');
        $totalSizeMb = round($totalBytes / (1024 * 1024), 2);

        // Calculate counts for section filter pills
        $sectionCounts = [
            'all' => $totalMediaCount,
            'projects' => Media::where('model_type', Project::class)->count(),
            'elevators' => Media::where('model_type', Elevator::class)->count(),
            'blog' => Media::where('model_type', Article::class)->count(),
            'services' => Media::where('model_type', Service::class)->count(),
            'general' => Media::where(function ($q) {
                $q->where('model_type', MediaFolder::class)->orWhereNull('model_type');
            })->count(),
        ];

        return view('admin.media.index', compact(
            'media',
            'folders',
            'currentFolderId',
            'section',
            'collection',
            'totalMediaCount',
            'totalSizeMb',
            'sectionCounts'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'file|mimes:jpg,jpeg,png,webp,avif,pdf,mp4|max:51200',
            'folder_id' => 'nullable|exists:media_folders,id',
        ]);

        $folder = null;
        if ($request->filled('folder_id')) {
            $folder = MediaFolder::find($request->folder_id);
        }

        if (! $folder) {
            $folder = MediaFolder::firstOrCreate(['name' => 'General / عام']);
        }

        $files = $request->file('files');
        if (! is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $mediaItem = $folder->addMedia($file)->toMediaCollection('library', 'public');
            if ($request->filled('folder_id')) {
                $mediaItem->folder_id = $request->folder_id;
                $mediaItem->save();
            }
        }

        return back()->with('success', 'تم رفع الملفات إلى مكتبة الوسائط بنجاح.');
    }

    public function storeFolder(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:media_folders,id',
        ]);

        MediaFolder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'تم إنشاء المجلد بنجاح.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $media->delete();

        return back()->with('success', 'تم حذف الملف من مكتبة الوسائط بنجاح.');
    }

    public function destroyFolder(MediaFolder $folder): RedirectResponse
    {
        $folder->delete();

        return redirect()->route('admin.media.index')->with('success', 'تم حذف المجلد بنجاح.');
    }
}
