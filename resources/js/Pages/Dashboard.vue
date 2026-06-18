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