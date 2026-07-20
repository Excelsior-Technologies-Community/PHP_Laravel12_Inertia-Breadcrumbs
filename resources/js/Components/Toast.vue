<template>
    <Teleport to="body">
        <div class="toast-container">
            <TransitionGroup name="toast">
                <div
                    v-for="toast in toasts"
                    :key="toast.id"
                    :class="['toast', `toast-${toast.type}`]"
                >
                    <div class="toast-icon">
                        <span v-if="toast.type === 'success'">✓</span>
                        <span v-else-if="toast.type === 'error'">✕</span>
                        <span v-else-if="toast.type === 'warning'">⚠</span>
                        <span v-else>ℹ</span>
                    </div>
                    <div class="toast-content">
                        <h4>{{ toast.title }}</h4>
                        <p>{{ toast.message }}</p>
                    </div>
                    <button @click="removeToast(toast.id)" class="toast-close">×</button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const toasts = ref([])

const addToast = (toast) => {
    const id = Date.now()
    toasts.value.push({
        id,
        ...toast
    })
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        removeToast(id)
    }, 5000)
}

const removeToast = (id) => {
    const index = toasts.value.findIndex(t => t.id === id)
    if (index > -1) {
        toasts.value.splice(index, 1)
    }
}

// Listen for custom events from Laravel flash messages
onMounted(() => {
    window.addEventListener('toast', (event) => {
        addToast(event.detail)
    })
})

// Expose methods globally
window.showToast = addToast
</script>

<style scoped>
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 300px;
    max-width: 400px;
    padding: 16px;
    border-radius: 12px;
    background: #1e293b;
    border: 1px solid #334155;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    animation: slideIn 0.3s ease;
}

.toast-success {
    border-left: 4px solid #10b981;
}

.toast-error {
    border-left: 4px solid #ef4444;
}

.toast-warning {
    border-left: 4px solid #f59e0b;
}

.toast-info {
    border-left: 4px solid #3b82f6;
}

.toast-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 16px;
    font-weight: bold;
}

.toast-success .toast-icon {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.toast-error .toast-icon {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.toast-warning .toast-icon {
    background: rgba(245, 158, 11, 0.2);
    color: #f59e0b;
}

.toast-info .toast-icon {
    background: rgba(59, 130, 246, 0.2);
    color: #3b82f6;
}

.toast-content {
    flex: 1;
}

.toast-content h4 {
    margin: 0 0 4px 0;
    font-size: 14px;
    color: #f1f5f9;
    font-weight: 600;
}

.toast-content p {
    margin: 0;
    font-size: 13px;
    color: #94a3b8;
}

.toast-close {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: 20px;
    cursor: pointer;
    border-radius: 6px;
    transition: 0.2s;
}

.toast-close:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #f1f5f9;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast-enter-active,
.toast-leave-active {
    transition: all 0.3s ease;
}

.toast-enter-from {
    transform: translateX(100%);
    opacity: 0;
}

.toast-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
</style>
