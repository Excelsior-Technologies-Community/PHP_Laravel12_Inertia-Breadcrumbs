<template>
    <AppLayout>
        <div class="user-profile">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ user.name.charAt(0).toUpperCase() }}
                </div>
                <div class="profile-info">
                    <h2>{{ user.name }}</h2>
                    <p>{{ user.email }}</p>
                    <span class="role-badge">{{ user.role }}</span>
                </div>
                <button @click="showEditModal = true" class="edit-btn">
                    ✏ Edit Profile
                </button>
            </div>

            <div class="profile-details">
                <div class="detail-card">
                    <h3>Personal Information</h3>
                    <div class="detail-row">
                        <span class="label">Full Name</span>
                        <span class="value">{{ user.name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Email Address</span>
                        <span class="value">{{ user.email }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Role</span>
                        <span class="value">{{ user.role }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">User ID</span>
                        <span class="value">#{{ user.id }}</span>
                    </div>
                </div>
            </div>

            <Link href="/users" class="back-btn">
                ← Back to Users
            </Link>
        </div>

        <!-- Edit Profile Modal -->
        <Modal
            :show="showEditModal"
            title="Edit Profile"
            @close="showEditModal = false"
        >
            <form @submit.prevent="updateProfile">
                <div class="form-group">
                    <label>Full Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        required
                        class="form-input"
                    />
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="form-input"
                    />
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select v-model="form.role" required class="form-input">
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manager</option>
                        <option value="User">User</option>
                    </select>
                </div>
            </form>
            <template #footer>
                <button
                    type="button"
                    @click="showEditModal = false"
                    class="btn btn-secondary"
                >
                    Cancel
                </button>
                <button
                    @click="updateProfile"
                    :disabled="form.processing"
                    class="btn btn-primary"
                >
                    {{ form.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </template>
        </Modal>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import Modal from '../../Components/Modal.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    user: Object
})

const showEditModal = ref(false)

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role
})

const updateProfile = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => {
            showEditModal.value = false
            window.showToast({
                type: 'success',
                title: 'Success',
                message: 'Profile updated successfully!'
            })
        }
    })
}
</script>

<style scoped>
.user-profile {
    padding: 20px;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
    padding: 30px;
    border-radius: 16px;
    border: 1px solid #1f2937;
    margin-bottom: 30px;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    border-radius: 50%;
    font-size: 32px;
    font-weight: bold;
    color: white;
}

.profile-info {
    flex: 1;
}

.profile-info h2 {
    color: #f1f5f9;
    margin: 0 0 8px 0;
    font-size: 24px;
}

.profile-info p {
    color: #94a3b8;
    margin: 0 0 12px 0;
    font-size: 14px;
}

.role-badge {
    display: inline-block;
    padding: 6px 12px;
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.edit-btn {
    padding: 12px 24px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
}

.edit-btn:hover {
    background: #2563eb;
}

.profile-details {
    margin-bottom: 30px;
}

.detail-card {
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 12px;
    padding: 24px;
}

.detail-card h3 {
    color: #f1f5f9;
    margin: 0 0 20px 0;
    font-size: 18px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 16px 0;
    border-bottom: 1px solid #1f2937;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    color: #94a3b8;
    font-size: 14px;
}

.detail-row .value {
    color: #f1f5f9;
    font-size: 14px;
    font-weight: 500;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: #1f2937;
    color: #94a3b8;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.2s;
}

.back-btn:hover {
    background: #374151;
    color: #f1f5f9;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #f1f5f9;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    background: #1f2937;
    border: 1px solid #374151;
    border-radius: 8px;
    color: #f1f5f9;
    font-size: 14px;
    transition: 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
    color: #64748b;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-secondary {
    background: #1f2937;
    color: #94a3b8;
}

.btn-secondary:hover {
    background: #374151;
    color: #f1f5f9;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
}
</style>