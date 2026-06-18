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