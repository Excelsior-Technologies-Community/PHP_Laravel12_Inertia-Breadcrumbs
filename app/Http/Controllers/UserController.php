<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use RobertBoes\InertiaBreadcrumbs\Breadcrumb;
use RobertBoes\InertiaBreadcrumbs\InertiaBreadcrumbs;

class UserController extends Controller
{
    private $users = [
        [
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'Admin',
        ],
        [
            'id' => 2,
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'role' => 'Manager',
        ],
        [
            'id' => 3,
            'name' => 'Robert Brown',
            'email' => 'robert@example.com',
            'role' => 'User',
        ],
    ];

    public function index(InertiaBreadcrumbs $breadcrumbs)
    {
        $breadcrumbs->for(fn () => [
            Breadcrumb::make('Dashboard', route('dashboard')),
            Breadcrumb::make('Users', route('users.index')),
        ]);

        return Inertia::render('Users/Index', [
            'users' => $this->users,
        ]);
    }

    public function show($id, InertiaBreadcrumbs $breadcrumbs)
    {
        $user = collect($this->users)->firstWhere('id', (int)$id);

        abort_if(!$user, 404);

        $breadcrumbs->for(fn () => [
            Breadcrumb::make('Dashboard', route('dashboard')),
            Breadcrumb::make('Users', route('users.index')),
            Breadcrumb::make($user['name']),
        ]);

        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = collect($this->users)->firstWhere('id', (int)$id);

        abort_if(!$user, 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string'
        ]);

        // Update user data (in real app, this would update database)
        $userIndex = collect($this->users)->search(fn($u) => $u['id'] === (int)$id);
        if ($userIndex !== false) {
            $this->users[$userIndex] = [
                'id' => $user['id'],
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}