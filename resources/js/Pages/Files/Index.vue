<template>
    <AppLayout>
        <div class="file-manager">
            <div class="file-header">
                <h2>Cloud File Manager</h2>
                <p>Drag and drop files to upload</p>
            </div>

            <!-- Upload Area -->
            <div
                class="upload-area"
                :class="{ 'drag-over': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop"
            >
                <div class="upload-content">
                    <div class="upload-icon">📁</div>
                    <p>Drag & drop files here</p>
                    <p class="upload-or">or</p>
                    <label class="upload-btn">
                        Browse Files
                        <input
                            type="file"
                            @change="handleFileSelect"
                            multiple
                            accept="image/*,.pdf,.doc,.docx,.txt,.zip"
                        />
                    </label>
                </div>
            </div>

            <!-- Upload Progress -->
            <div v-if="uploadProgress.length > 0" class="upload-progress">
                <div
                    v-for="upload in uploadProgress"
                    :key="upload.id"
                    class="progress-item"
                >
                    <div class="progress-info">
                        <span class="file-name">{{ upload.name }}</span>
                        <span class="upload-status">{{ upload.status }}</span>
                    </div>
                    <div class="progress-bar">
                        <div
                            class="progress-fill"
                            :style="{ width: upload.progress + '%' }"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Files List -->
            <div v-if="files.length > 0" class="files-list">
                <div class="files-header">
                    <h3>Uploaded Files ({{ files.length }})</h3>
                </div>
                <div class="files-grid">
                    <div
                        v-for="file in files"
                        :key="file.id"
                        class="file-card"
                    >
                        <div class="file-preview">
                            <div class="file-type-icon">
                                {{ getFileIcon(file.mime_type) }}
                            </div>
                        </div>
                        <div class="file-info">
                            <p class="file-name">{{ file.original_name }}</p>
                            <p class="file-meta">{{ formatSize(file.size) }}</p>
                            <p class="file-date">{{ formatDate(file.created_at) }}</p>
                        </div>
                        <div class="file-actions">
                            <a
                                :href="`/storage/${file.path}`"
                                target="_blank"
                                class="action-btn download"
                                title="Download"
                            >
                                ⬇
                            </a>
                            <button
                                @click="deleteFile(file.id)"
                                class="action-btn delete"
                                title="Delete"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="empty-state">
                <div class="empty-icon">📭</div>
                <p>No files uploaded yet</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
    files: Array
})

const isDragging = ref(false)
const uploadProgress = ref([])

const handleDrop = (e) => {
    isDragging.value = false
    const droppedFiles = Array.from(e.dataTransfer.files)
    uploadFiles(droppedFiles)
}

const handleFileSelect = (e) => {
    const selectedFiles = Array.from(e.target.files)
    uploadFiles(selectedFiles)
}

const uploadFiles = async (files) => {
    for (const file of files) {
        const uploadId = Date.now() + Math.random()
        uploadProgress.value.push({
            id: uploadId,
            name: file.name,
            progress: 0,
            status: 'Uploading...'
        })

        const formData = new FormData()
        formData.append('file', file)

        try {
            const xhr = new XMLHttpRequest()
            
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const upload = uploadProgress.value.find(u => u.id === uploadId)
                    if (upload) {
                        upload.progress = Math.round((e.loaded / e.total) * 100)
                    }
                }
            })

            xhr.addEventListener('load', () => {
                const upload = uploadProgress.value.find(u => u.id === uploadId)
                if (upload) {
                    if (xhr.status === 200) {
                        upload.status = 'Completed'
                        upload.progress = 100
                        setTimeout(() => {
                            uploadProgress.value = uploadProgress.value.filter(u => u.id !== uploadId)
                        }, 2000)
                        window.location.reload()
                    } else {
                        upload.status = 'Failed'
                        try {
                            const response = JSON.parse(xhr.responseText)
                            window.showToast({
                                type: 'error',
                                title: 'Upload Failed',
                                message: response.message || 'Unknown error occurred'
                            })
                        } catch {
                            window.showToast({
                                type: 'error',
                                title: 'Upload Failed',
                                message: 'Server error occurred'
                            })
                        }
                    }
                }
            })

            xhr.addEventListener('error', () => {
                const upload = uploadProgress.value.find(u => u.id === uploadId)
                if (upload) {
                    upload.status = 'Failed'
                    window.showToast({
                        type: 'error',
                        title: 'Upload Failed',
                        message: 'Network error occurred'
                    })
                }
            })

            xhr.open('POST', '/files')
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
            
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            if (csrfToken) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken)
            }

            xhr.send(formData)

        } catch (error) {
            const upload = uploadProgress.value.find(u => u.id === uploadId)
            if (upload) {
                upload.status = 'Failed'
                window.showToast({
                    type: 'error',
                    title: 'Upload Failed',
                    message: error.message
                })
            }
        }
    }
}

const deleteFile = async (fileId) => {
    if (confirm('Are you sure you want to delete this file?')) {
        await useForm().delete(`/files/${fileId}`)
        window.location.reload()
    }
}

const getFileIcon = (mimeType) => {
    if (mimeType?.startsWith('image/')) return '🖼'
    if (mimeType?.includes('pdf')) return '📄'
    if (mimeType?.includes('word') || mimeType?.includes('document')) return '📝'
    if (mimeType?.includes('zip') || mimeType?.includes('compressed')) return '📦'
    return '📁'
}

const formatSize = (bytes) => {
    if (bytes === 0) return '0 Bytes'
    const k = 1024
    const sizes = ['Bytes', 'KB', 'MB', 'GB']
    const i = Math.floor(Math.log(bytes) / Math.log(k))
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i]
}

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}
</script>

<style scoped>
.file-manager {
    padding: 20px;
}

.file-header {
    text-align: center;
    margin-bottom: 30px;
}

.file-header h2 {
    color: #f1f5f9;
    margin-bottom: 8px;
}

.file-header p {
    color: #94a3b8;
}

.upload-area {
    border: 2px dashed #374151;
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    background: #111827;
    transition: 0.3s;
    margin-bottom: 20px;
}

.upload-area.drag-over {
    border-color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
}

.upload-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.upload-icon {
    font-size: 48px;
}

.upload-content p {
    color: #94a3b8;
    margin: 0;
}

.upload-or {
    color: #64748b;
    font-size: 14px;
}

.upload-btn {
    padding: 12px 24px;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
    font-weight: 500;
}

.upload-btn:hover {
    background: #2563eb;
}

.upload-btn input {
    display: none;
}

.upload-progress {
    margin-bottom: 20px;
}

.progress-item {
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 8px;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.file-name {
    color: #f1f5f9;
    font-size: 14px;
}

.upload-status {
    color: #94a3b8;
    font-size: 13px;
}

.progress-bar {
    height: 6px;
    background: #1f2937;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    transition: width 0.3s;
}

.files-list {
    margin-top: 30px;
}

.files-header {
    margin-bottom: 20px;
}

.files-header h3 {
    color: #f1f5f9;
    margin: 0;
}

.files-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}

.file-card {
    background: #111827;
    border: 1px solid #1f2937;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: 0.2s;
}

.file-card:hover {
    border-color: #374151;
    transform: translateY(-2px);
}

.file-preview {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1f2937;
    border-radius: 8px;
    font-size: 24px;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-info .file-name {
    color: #f1f5f9;
    font-size: 14px;
    font-weight: 500;
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-meta {
    color: #94a3b8;
    font-size: 12px;
    margin: 0 0 2px 0;
}

.file-date {
    color: #64748b;
    font-size: 11px;
    margin: 0;
}

.file-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}

.action-btn.download {
    background: #1f2937;
    color: #60a5fa;
    text-decoration: none;
}

.action-btn.download:hover {
    background: #2563eb;
    color: white;
}

.action-btn.delete {
    background: #1f2937;
    color: #ef4444;
}

.action-btn.delete:hover {
    background: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 16px;
}

.empty-state p {
    color: #94a3b8;
    font-size: 16px;
}
</style>
