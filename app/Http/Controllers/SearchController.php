<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $results = [];

        if ($query && strlen($query) >= 2) {
            // Search files
            $files = File::where('original_name', 'like', "%{$query}%")
                ->get()
                ->map(function ($file) {
                    return [
                        'id' => 'file-' . $file->id,
                        'title' => $file->original_name,
                        'subtitle' => $this->formatFileSize($file->size),
                        'type' => 'file',
                        'url' => '/files'
                    ];
                });

            // Search users
            $users = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => 'user-' . $user->id,
                        'title' => $user->name,
                        'subtitle' => $user->email,
                        'type' => 'user',
                        'url' => '/users/' . $user->id
                    ];
                });

            // Add dashboard page
            if (stripos('dashboard', $query) !== false) {
                $results[] = [
                    'id' => 'dashboard',
                    'title' => 'Dashboard',
                    'subtitle' => 'Main dashboard page',
                    'type' => 'dashboard',
                    'url' => '/dashboard'
                ];
            }

            $results = array_merge($results, $files->toArray(), $users->toArray());
        }

        return response()->json([
            'results' => $results
        ]);
    }

    private function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i) * 100) / 100 . ' ' . $sizes[$i];
    }
}
