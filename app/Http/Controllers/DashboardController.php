<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use RobertBoes\InertiaBreadcrumbs\Breadcrumb;
use RobertBoes\InertiaBreadcrumbs\InertiaBreadcrumbs;

class DashboardController extends Controller
{
    public function index(InertiaBreadcrumbs $breadcrumbs)
{
    $breadcrumbs->for(fn () => [
        Breadcrumb::make('Dashboard', route('dashboard')),
    ]);

    return Inertia::render('Dashboard');
}
}