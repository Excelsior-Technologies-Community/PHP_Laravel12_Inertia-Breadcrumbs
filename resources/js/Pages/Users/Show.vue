<template>
    <AppLayout>

        <div class="card">

            <h2>User Details</h2>

            <div class="info">
                <strong>Name:</strong>
                {{ user.name }}
            </div>

            <div class="info">
                <strong>Email:</strong>
                {{ user.email }}
            </div>

            <div class="info">
                <strong>Role:</strong>
                {{ user.role }}
            </div>

            <Link
                href="/users"
                class="backBtn"
            >
                Back To Users
            </Link>

        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    user: Object
})
</script>

<style scoped>
.card {
    background: #111827;
    padding: 25px;
    border-radius: 12px;
}

h2 {
    color: white;
    margin-bottom: 20px;
}

.info {
    color: white;
    margin-bottom: 15px;
}

.backBtn {
    display: inline-block;
    margin-top: 20px;
    background: #2563eb;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 6px;
}
</style>