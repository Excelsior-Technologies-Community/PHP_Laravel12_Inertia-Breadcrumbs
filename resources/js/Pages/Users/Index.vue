<template>
    <AppLayout>
        <div class="box">

            <h2>Users Management</h2>

            <div class="search-wrapper">

                <span class="search-icon">🔍</span>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Search users..."
                    class="search"
                />

                <button
                    v-if="search"
                    @click="search = ''"
                    class="clear-btn"
                >
                    ✕
                </button>

            </div>

            <table class="table">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr
                        v-for="user in filteredUsers"
                        :key="user.id"
                    >
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role }}</td>

                        <td>
                            <Link
                                :href="`/users/${user.id}`"
                                class="viewBtn"
                            >
                                View Details
                            </Link>
                        </td>
                    </tr>

                    <tr v-if="filteredUsers.length === 0">
                        <td colspan="4" class="empty">
                            No users found
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>
    </AppLayout>
</template>


<script setup>

import AppLayout from '../../Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
    users:Array
})

const search = ref('')

const filteredUsers = computed(() => {

    return props.users.filter(user => {

        return (
            user.name.toLowerCase().includes(search.value.toLowerCase()) ||
            user.email.toLowerCase().includes(search.value.toLowerCase()) ||
            user.role.toLowerCase().includes(search.value.toLowerCase())
        )

    })

})

</script>


<style scoped>

.box {
    background:#111827;
    padding:25px;
    border-radius:14px;
    overflow:hidden;
}

h2 {
    color:white;
    margin-bottom:25px;
}

.search-wrapper {
    position:relative;
    width:100%;
    margin-bottom:25px;
}

.search {
    width:100%;
    box-sizing:border-box;
    padding:13px 50px 13px 45px;
    background:#0f172a;
    color:white;
    border:1px solid #374151;
    border-radius:12px;
    outline:none;
    font-size:15px;
    transition:.3s;
}

.search:focus {
    border-color:#2563eb;
    box-shadow:0 0 15px rgba(37,99,235,.35);
}

.search::placeholder {
    color:#64748b;
}

.search-icon {
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    font-size:18px;
}

.clear-btn {
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    width:28px;
    height:28px;
    border:none;
    border-radius:50%;
    background:#374151;
    color:white;
    cursor:pointer;
}

.clear-btn:hover {
    background:#ef4444;
}

.table {
    width:100%;
    border-collapse:collapse;
}

.table th,
.table td {
    padding:13px;
    border:1px solid #374151;
    color:white;
}

.table th {
    background:#1f2937;
}

.viewBtn {
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:9px 14px;
    border-radius:8px;
}

.viewBtn:hover {
    background:#1d4ed8;
}

.empty {
    text-align:center;
    color:#94a3b8;
}

</style>