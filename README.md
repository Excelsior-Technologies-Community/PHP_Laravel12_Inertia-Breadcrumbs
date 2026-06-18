# PHP_Laravel12_Inertia-Breadcrumbs


## Project Description

This project is a modern Laravel 12 + Inertia.js + Vue 3 SPA with dynamic breadcrumb navigation and dark dashboard UI.

It provides a simple dashboard and user management module where navigation is enhanced using dynamic breadcrumbs generated through the robertboes/inertia-breadcrumbs package.

The system is built as a Single Page Application (SPA) using Inertia, making navigation fast, smooth, and modern without full page reloads.


## Key Features

🌐 Laravel 12 + Inertia.js SPA architecture

🧭 Dynamic breadcrumb navigation system

🎨 Modern dark UI dashboard design

📊 Dashboard and Users module pages

🔗 Header navigation with buttons

⚡ Fast page transitions without reload

🧩 Component-based Vue 3 structure

🛠 Clean and reusable layout system

📱 Responsive and professional UI

📦 Modular folder structure



## Technologies Used

- Laravel 12
- PHP 8+
- Vue 3
- Inertia.js
- Vite
- MySQL
- Bootstrap 5 (optional)
- HTML5
- CSS3

## Project Highlights

- Breadcrumbs are automatically generated from controllers
- Navigation path updates dynamically on each page
- Shared layout used across all pages
- Vue components handle UI rendering
- Laravel handles routing and backend logic
- Inertia bridges frontend and backend seamlessly



## Application Flow

1. Open Dashboard Page
2. Navigate using Header Buttons (Dashboard / Users)
3. Controller sends breadcrumb data
4. Inertia passes data to Vue frontend
5. Breadcrumbs are displayed dynamically
6. Navigate between pages without reload

---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Inertia-Breadcrumbs "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Inertia-Breadcrumbs

```

#### Explanation:

Creates a fresh Laravel 12 application with all required dependencies installed.

This becomes the base structure for building the Inertia + Breadcrumb system.



## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_Inertia_Breadcrumbs
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_Inertia_Breadcrumbs


```

### Then Run:

```
php artisan migrate

```


#### Explanation:

Configures MySQL database connection inside .env file.

Used to store application data like users and future records.




## STEP 3: Install Inertia

### Run:

```
composer require inertiajs/inertia-Laravel

php artisan inertia:middleware

```
 
### Register Middleware

#### bootstrap/app.php

```
->withMiddleware(function ($middleware) {
    $middleware->web(append: [
        App\Http\Middleware\HandleInertiaRequests::class,
    ]);
});

```


#### Explanation: 

Installs Inertia.js Laravel adapter to connect backend with Vue frontend.

Middleware is registered to enable SPA-like behavior.




## STEP 4: Install Vue 3

### Run:

```
npm install vue @inertiajs/vue3

npm install

```

#### Explanation: 

Installs Vue 3 and Inertia Vue adapter for frontend rendering.

Enables component-based UI for Laravel pages.



## STEP 5: Install Breadcrumb Package

### Run:

```
composer require robertboes/inertia-breadcrumbs

```
#### Explanation: 

Adds robertboes/inertia-breadcrumbs package via Composer.

This helps generate dynamic breadcrumbs easily in controllers.




## STEP 6: Publish Config

### Run:

```
php artisan vendor:publish --tag=inertia-breadcrumbs-config

```


#### Explanation: 

Publishes package configuration file into Laravel config folder.

Allows customization of breadcrumb behavior.




## STEP 7: Configure Package

### config/inertia-breadcrumbs.php

```
return [

    /*
    |--------------------------------------------------------------------------
    | Breadcrumb Collector
    |--------------------------------------------------------------------------
    */

    'collector' => \RobertBoes\InertiaBreadcrumbs\Collectors\ClosureBreadcrumbsCollector::class,

];

```

#### Explanation: 

Sets breadcrumb collector class inside config file.

This defines how breadcrumbs are generated and managed.




## STEP 8: Create Controller

### Run:

```
php artisan make:controller DashboardController

php artisan make:controller UserController

```

### app/Http/Controllers/DashboardController.php

```
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

```

### app/Http/Controllers/UserController.php

```
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

```


#### Explanation: 

Creates Dashboard and User controllers using Artisan commands.

Controllers handle page logic and send breadcrumb data to Vue.





## STEP 9: Add Routes

### routes/web.php

```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

```

#### Explanation: 

Defines application URLs and maps them to controllers.

Routes decide which page opens for each URL.



## STEP 10: Vue Setup (Inertia App)


### resources/js/Layouts/AppLayout.vue

``` 
<template>
    <div class="app-bg">

        <div class="container">

            <div class="card">

                <!-- HEADER -->
                <div class="header">

                    <h1>Laravel Inertia Breadcrumb System</h1>
                    <p>Professional Dark Dashboard UI</p>

                    <!-- NAV BUTTONS -->
                    <div class="nav">
                        <Link href="/dashboard" class="btn">Dashboard</Link>
                        <Link href="/users" class="btn">Users</Link>
                    </div>

                </div>

                <!-- BREADCRUMB -->
                <Breadcrumbs />

                <!-- CONTENT -->
                <div class="content">
                    <slot />
                </div>

            </div>

        </div>

    </div>
</template>

<script setup>
import Breadcrumbs from '../Components/Breadcrumbs.vue'
import { Link } from '@inertiajs/vue3'
</script>

<style>
.app-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px;
}

.container {
    width: 100%;
    max-width: 950px;
}

.card {
    background: #0b1220;
    border-radius: 18px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.6);
    overflow: hidden;
    padding: 25px;
    border: 1px solid #1f2937;
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 22px;
    color: #f1f5f9;
}

.header p {
    color: #94a3b8;
}

.nav {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn {
    padding: 8px 16px;
    background: #1f2937;
    color: #e5e7eb;
    border: 1px solid #374151;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s;
}

.btn:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
}

.content {
    margin-top: 20px;
}
</style>

```


### resources/js/Components/Breadcrumbs.vue
   
```
<template>
    <div v-if="page.props.breadcrumbs?.length" class="breadcrumb">

        <span v-for="(item, index) in page.props.breadcrumbs"
              :key="index"
              class="crumb">

            <a v-if="item.url" :href="item.url">
                {{ item.title }}
            </a>

            <span v-else class="active">
                {{ item.title }}
            </span>

            <span v-if="index < page.props.breadcrumbs.length - 1" class="sep">
                /
            </span>

        </span>

    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
const page = usePage()
</script>

<style>
.breadcrumb {
    background: #111827;
    padding: 10px 15px;
    border-radius: 12px;
    font-size: 14px;
    margin-bottom: 15px;
    border: 1px solid #1f2937;
}

.crumb a {
    color: #60a5fa;
    text-decoration: none;
}

.crumb a:hover {
    color: #93c5fd;
}

.active {
    color: #e5e7eb;
    font-weight: 600;
}

.sep {
    margin: 0 8px;
    color: #64748b;
}
</style>

```


### resources/js/Pages/Dashboard.vue

```
<template>
    <AppLayout>
        <div class="box">
            <h2>Dashboard</h2>
            <p>Welcome to Laravel Inertia System</p>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
</script>

<style>
.box {
    text-align: center;
    padding: 30px;
    background: #111827;
    border-radius: 14px;
    border: 1px solid #1f2937;
}

.box h2 {
    color: #f1f5f9;
}

.box p {
    color: #94a3b8;
}
</style>

```


### resources/js/Pages/Users/Index.vue

```
<template>
    <AppLayout>
        <div class="box">
            <h2>Users Management</h2>
            <p>Professional user listing system</p>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
</script>

<style>
.box {
    text-align: center;
    padding: 30px;
    background: #111827;
    border-radius: 14px;
    border: 1px solid #1f2937;
}

.box h2 {
    color: #f1f5f9;
}

.box p {
    color: #94a3b8;
}
</style>

```


### resources/js/app.js

```
import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});

```



### Create file: resources/views/app.blade.php

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel Inertia App</title>

    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body>
    @inertia
</body>
</html>

```



#### Explanation: 

Sets up Vue entry file and Inertia rendering system.

Connects Laravel backend with Vue frontend components.




## STEP 11: Update vite.config.js

### Open: vite.config.js

```
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});

```

#### Explanation: 

Configures Vite for compiling Vue + Laravel assets.

Enables fast frontend development and hot reload.






## STEP 12: Run the Application  

### Start dev server:

```
php artisan serve

```

### Open New Project Terminal:

```
npm install

npm run dev

```


### Open in browser:

```
http://127.0.0.1:8000/dashboard 

```

#### Explanation:

Starts Laravel backend and Vite frontend server.

Allows testing project in browser with live updates.



## Expected Output:

### Dashboard Page


<img width="1858" height="960" alt="Screenshot 2026-06-18 111614" src="https://github.com/user-attachments/assets/d9ae2924-d6cf-43c8-b1d4-43418a2d2645" />


### User Page


<img width="1859" height="964" alt="Screenshot 2026-06-18 111633" src="https://github.com/user-attachments/assets/7506f95f-63f7-489e-b50e-212e1e9cb0e3" />



---


## Project Folder Structure

```
PHP_Laravel12_Inertia-Breadcrumbs/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   └── UserController.php
│   │   │
│   │   └── Middleware/
│   │       └── HandleInertiaRequests.php
│   │
│   └── Models/
│
├── bootstrap/
│
├── config/
│   ├── app.php
│   ├── inertia-breadcrumbs.php   (published config)
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── public/
│   ├── index.php
│
├── resources/
│   │
│   ├── js/
│   │   ├── app.js
│   │   │
│   │   ├── Components/
│   │   │   └── Breadcrumbs.vue
│   │   │
│   │   ├── Layouts/
│   │   │   └── AppLayout.vue
│   │   │
│   │   ├── Pages/
│   │   │   ├── Dashboard.vue
│   │   │   └── Users/
│   │   │       └── Index.vue
│   │   │
│   │   └── bootstrap.js
│   │
│   ├── css/
│   │
│   └── views/
│       └── app.blade.php   ← Inertia root file
│
├── routes/
│   ├── web.php
│   ├── api.php
│
├── storage/
│
├── vendor/
│
├── vite.config.js
├── package.json
├── composer.json
├── artisan
└── README.md

```
