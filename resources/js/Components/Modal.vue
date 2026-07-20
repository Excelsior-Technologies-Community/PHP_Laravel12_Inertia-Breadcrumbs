<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="modal-overlay" @click="closeOnOverlay && $emit('close')">
                <div class="modal-container" @click.stop>
                    <div class="modal-header">
                        <h3>{{ title }}</h3>
                        <button @click="$emit('close')" class="modal-close">×</button>
                    </div>
                    <div class="modal-body">
                        <slot />
                    </div>
                    <div v-if="$slots.footer" class="modal-footer">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Modal'
    },
    closeOnOverlay: {
        type: Boolean,
        default: true
    }
})

defineEmits(['close'])
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
}

.modal-container {
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 16px;
    max-width: 500px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #1f2937;
}

.modal-header h3 {
    color: #f1f5f9;
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.modal-close {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: 24px;
    cursor: pointer;
    border-radius: 6px;
    transition: 0.2s;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #f1f5f9;
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 24px;
    border-top: 1px solid #1f2937;
}

.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from {
    opacity: 0;
}

.modal-enter-from .modal-container {
    transform: scale(0.9) translateY(-20px);
}

.modal-leave-to {
    opacity: 0;
}

.modal-leave-to .modal-container {
    transform: scale(0.9) translateY(-20px);
}
</style>
