<template>
    <nav v-if="page.props.breadcrumbs?.length" class="breadcrumb">
        <div class="breadcrumb-container">
            <div class="breadcrumb-icon">🧭</div>
            <ol class="breadcrumb-list">
                <li
                    v-for="(item, index) in page.props.breadcrumbs"
                    :key="index"
                    class="breadcrumb-item"
                >
                    <Link
                        v-if="item.url && index < page.props.breadcrumbs.length - 1"
                        :href="item.url"
                        class="breadcrumb-link"
                    >
                        <span class="breadcrumb-text">{{ item.title }}</span>
                    </Link>
                    <span v-else class="breadcrumb-active">
                        <span class="breadcrumb-text">{{ item.title }}</span>
                    </span>
                    <span
                        v-if="index < page.props.breadcrumbs.length - 1"
                        class="breadcrumb-separator"
                    >
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </span>
                </li>
            </ol>
        </div>
    </nav>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

const page = usePage()
</script>

<style scoped>
.breadcrumb {
    background: linear-gradient(135deg, #111827 0%, #1e293b 100%);
    padding: 12px 20px;
    border-radius: 14px;
    margin-bottom: 20px;
    border: 1px solid #1f2937;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.breadcrumb-container {
    display: flex;
    align-items: center;
    gap: 12px;
}

.breadcrumb-icon {
    font-size: 20px;
    opacity: 0.8;
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 8px;
    flex: 1;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.breadcrumb-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.2s ease;
    position: relative;
}

.breadcrumb-link:hover {
    transform: translateX(2px);
}

.breadcrumb-link .breadcrumb-text {
    color: #60a5fa;
    font-size: 13px;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.breadcrumb-link:hover .breadcrumb-text {
    background: rgba(59, 130, 246, 0.15);
    color: #93c5fd;
}

.breadcrumb-active {
    display: flex;
    align-items: center;
}

.breadcrumb-active .breadcrumb-text {
    color: #f1f5f9;
    font-size: 13px;
    font-weight: 600;
    padding: 6px 12px;
    background: rgba(59, 130, 246, 0.2);
    border-radius: 6px;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.breadcrumb-separator {
    display: flex;
    align-items: center;
    color: #64748b;
    opacity: 0.5;
}

.breadcrumb-separator svg {
    width: 14px;
    height: 14px;
}

@media (max-width: 640px) {
    .breadcrumb {
        padding: 10px 16px;
    }

    .breadcrumb-icon {
        font-size: 16px;
    }

    .breadcrumb-link .breadcrumb-text,
    .breadcrumb-active .breadcrumb-text {
        font-size: 12px;
        padding: 4px 8px;
    }
}
</style>