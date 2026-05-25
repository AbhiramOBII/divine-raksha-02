<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::latest();

        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        $media = $query->paginate(24)->withQueryString();
        $folders = Media::select('folder')->distinct()->pluck('folder');

        return view('admin.media.index', compact('media', 'folders'));
    }

    public function api(Request $request)
    {
        $query = Media::latest();

        if ($request->filled('folder')) {
            $query->where('folder', $request->folder);
        }

        if ($request->filled('search')) {
            $query->where('original_name', 'like', '%' . $request->search . '%');
        }

        $media = $query->limit(60)->get();
        $folders = Media::select('folder')->distinct()->pluck('folder');

        return response()->json([
            'media' => $media,
            'folders' => $folders,
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array|max:20',
            'files.*' => 'required|image|mimes:jpeg,jpg,png,gif,webp,svg|max:5120',
            'folder' => 'nullable|string|max:100',
        ]);

        $folder = $request->input('folder', 'general');
        $folder = Str::slug($folder);
        $uploaded = 0;

        foreach ($request->file('files') as $file) {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media/' . $folder, $filename, 'public');

            Media::create([
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'folder' => $folder,
            ]);

            $uploaded++;
        }

        return back()->with('success', $uploaded . ' file(s) uploaded successfully.');
    }

    public function update(Request $request, Media $medium)
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
        ]);

        $medium->update(['alt_text' => $request->alt_text]);

        return back()->with('success', 'Media updated.');
    }

    public function destroy(Media $medium)
    {
        $medium->delete();
        return back()->with('success', 'Media deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:media,id',
        ]);

        $media = Media::whereIn('id', $request->ids)->get();

        foreach ($media as $item) {
            $item->delete();
        }

        return back()->with('success', count($request->ids) . ' file(s) deleted.');
    }
}
