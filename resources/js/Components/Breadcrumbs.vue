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