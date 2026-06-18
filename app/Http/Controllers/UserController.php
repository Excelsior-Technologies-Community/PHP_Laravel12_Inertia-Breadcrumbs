<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use RobertBoes\InertiaBreadcrumbs\Breadcrumb;
use RobertBoes\InertiaBreadcrumbs\InertiaBreadcrumbs;

class UserController extends Controller
{
    public function index(InertiaBreadcrumbs $breadcrumbs)
{
    $breadcrumbs->for(fn () => [
        Breadcrumb::make('Dashboard', route('dashboard')),
        Breadcrumb::make('Users', route('users.index')),
    ]);

    return Inertia::render('Users/Index');
}
}