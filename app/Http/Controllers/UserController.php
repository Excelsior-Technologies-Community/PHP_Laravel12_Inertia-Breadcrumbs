<?php

namespace App\Http\Controllers;

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
}