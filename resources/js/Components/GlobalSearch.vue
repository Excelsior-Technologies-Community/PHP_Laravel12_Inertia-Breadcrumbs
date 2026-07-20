<template>
    <div class="global-search">
        <div class="search-container">
            <div class="search-icon">🔍</div>
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search..."
                class="search-input"
                @input="handleSearch"
            />
            <button
                v-if="searchQuery"
                @click="clearSearch"
                class="clear-btn"
            >
                ✕
            </button>
        </div>

        <!-- Search Results Dropdown -->
        <Transition name="dropdown">
            <div v-if="showResults && searchQuery" class="search-results">
                <div v-if="loading" class="loading">
                    <div class="spinner"></div>
                    <p>Searching...</p>
                </div>
                <div v-else-if="results.length > 0" class="results-list">
                    <div
                        v-for="result in results"
                        :key="result.id"
                        class="result-item"
                        @click="navigateTo(result)"
                    >
                        <div class="result-icon">{{ getResultIcon(result.type) }}</div>
                        <div class="result-content">
                            <p class="result-title">{{ result.title }}</p>
                            <p class="result-subtitle">{{ result.subtitle }}</p>
                        </div>
                        <div class="result-type">{{ result.type }}</div>
                    </div>
                </div>
                <div v-else class="no-results">
                    <p>No results found for "{{ searchQuery }}"</p>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash'

const searchQuery = ref('')
const results = ref([])
const loading = ref(false)
const showResults = ref(false)

const handleSearch = debounce(async () => {
    if (searchQuery.value.length < 2) {
        results.value = []
        showResults.value = false
        return
    }

    loading.value = true
    showResults.value = true

    try {
        const response = await fetch(`/search?q=${searchQuery.value}`)
        const data = await response.json()
        results.value = data.results || []
    } catch (error) {
        console.error('Search error:', error)
        results.value = []
    } finally {
        loading.value = false
    }
}, 300)

const clearSearch = () => {
    searchQuery.value = ''
    results.value = []
    showResults.value = false
}

const navigateTo = (result) => {
    router.visit(result.url)
    clearSearch()
}

const getResultIcon = (type) => {
    const icons = {
        user: '👤',
        file: '📁',
        dashboard: '📊',
        page: '📄'
    }
    return icons[type] || '📌'
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.global-search')) {
        showResults.value = false
    }
})
</script>

<style scoped>
.global-search {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.search-container {
    display: flex;
    align-items: center;
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 10px;
    padding: 10px 16px;
    gap: 10px;
    transition: 0.3s;
}

.search-container:focus-within {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-icon {
    font-size: 16px;
    color: #94a3b8;
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: #f1f5f9;
    font-size: 14px;
}

.search-input::placeholder {
    color: #64748b;
}

.clear-btn {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: transparent;
    color: #64748b;
    cursor: pointer;
    border-radius: 4px;
    transition: 0.2s;
    font-size: 14px;
}

.clear-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #f1f5f9;
}

.search-results {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
}

.loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 30px;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 2px solid #1f2937;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading p {
    color: #94a3b8;
    margin: 0;
    font-size: 14px;
}

.results-list {
    padding: 8px;
}

.result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.result-item:hover {
    background: #1f2937;
}

.result-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1f2937;
    border-radius: 8px;
    font-size: 18px;
}

.result-content {
    flex: 1;
    min-width: 0;
}

.result-title {
    color: #f1f5f9;
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 4px 0;
}

.result-subtitle {
    color: #94a3b8;
    font-size: 12px;
    margin: 0;
}

.result-type {
    font-size: 11px;
    color: #64748b;
    text-transform: uppercase;
    padding: 4px 8px;
    background: #1f2937;
    border-radius: 4px;
}

.no-results {
    padding: 30px;
    text-align: center;
}

.no-results p {
    color: #94a3b8;
    margin: 0;
    font-size: 14px;
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.2s ease;
}

.dropdown-enter-from {
    opacity: 0;
    transform: translateY(-10px);
}

.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
