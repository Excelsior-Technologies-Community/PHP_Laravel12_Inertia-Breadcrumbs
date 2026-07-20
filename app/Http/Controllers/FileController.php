<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use RobertBoes\InertiaBreadcrumbs\Breadcrumb;
use RobertBoes\InertiaBreadcrumbs\InertiaBreadcrumbs;

class FileController extends Controller
{
    public function index(InertiaBreadcrumbs $breadcrumbs)
    {
        $breadcrumbs->for(fn () => [
            Breadcrumb::make('Dashboard', route('dashboard')),
            Breadcrumb::make('Files', route('files.index')),
        ]);

        $files = File::latest()->get();

        return Inertia::render('Files/Index', [
            'files' => $files
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240',
            ]);

            $uploadedFile = $request->file('file');
            
            // Ensure upload directory exists
            if (!Storage::disk('public')->exists('uploads')) {
                Storage::disk('public')->makeDirectory('uploads');
            }

            $path = $uploadedFile->store('uploads', 'public');

            $file = File::create([
                'name' => $uploadedFile->hashName(),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'mime_type' => $uploadedFile->getClientMimeType(),
                'path' => $path,
                'size' => $uploadedFile->getSize(),
                'disk' => 'public'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'file' => $file
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()['file'] ?? ['Invalid file'])
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'File upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(File $file)
    {
        Storage::disk($file->disk)->delete($file->path);
        $file->delete();

        return back()->with('success', 'File deleted successfully!');
    }
}
