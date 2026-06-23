<template>
    <div class="app-bg">
        <div class="container">
            <div class="card">

                <div class="header">

                    <h1>Laravel Inertia Breadcrumb System</h1>
                    <p>Professional Dark Dashboard UI</p>

                    <div class="nav">

                        <Link
                            href="/dashboard"
                            class="btn"
                            :class="{ activeBtn: page.url === '/dashboard' }"
                        >
                            Dashboard
                        </Link>

                        <Link
                            href="/users"
                            class="btn"
                            :class="{ activeBtn: page.url.includes('/users') }"
                        >
                            Users
                        </Link>

                    </div>

                </div>

                <Breadcrumbs />

                <div class="content">
                    <slot />
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import Breadcrumbs from '../Components/Breadcrumbs.vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
</script>

<style>
.app-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
}

.container {
    width: 100%;
    max-width: 1000px;
}

.card {
    background: #0b1220;
    border-radius: 18px;
    padding: 25px;
    border: 1px solid #1f2937;
    box-shadow: 0 10px 40px rgba(0,0,0,.5);
}

.header {
    text-align: center;
}

.header h1 {
    color: white;
}

.header p {
    color: #94a3b8;
}

.nav {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 15px;
}

.btn {
    padding: 10px 18px;
    border-radius: 8px;
    background: #1f2937;
    color: white;
    text-decoration: none;
    transition: .3s;
}

.btn:hover {
    background: #2563eb;
}

.activeBtn {
    background: #2563eb;
    border: 1px solid #3b82f6;
}

.content {
    margin-top: 20px;
}
</style>