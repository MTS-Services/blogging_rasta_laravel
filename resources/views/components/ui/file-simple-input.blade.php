@props([
    'label' => null,
    'accept' => null,
    'multiple' => false,
    'error' => null,
    'hint' => null,
])

<div class="w-full">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <div x-data="{
        files: [],

        handleFileSelect(event) {
            const selectedFiles = Array.from(event.target.files);
            this.files = selectedFiles.map(file => ({
                name: file.name,
                size: file.size,
                type: file.type,
                url: URL.createObjectURL(file),
                file: file
            }));
        },

        removeFile(index) {
            URL.revokeObjectURL(this.files[index].url);

            const newFiles = this.files.filter((_, i) => i !== index);
            this.files = newFiles;
            const dt = new DataTransfer();
            this.files.forEach(f => dt.items.add(f.file)); // Use the stored 'f.file'
            this.$refs.fileInput.files = dt.files;

            if (this.files.length > 0) {
                this.$refs.fileInput.dispatchEvent(new Event('change'));
            } else {
                this.$refs.fileInput.value = '';
                this.$refs.fileInput.dispatchEvent(new Event('change'));
            }
        },

        getFileType(type) {
            if (type.startsWith('image/')) return 'image';
            if (type.startsWith('video/')) return 'video';
            if (type.startsWith('audio/')) return 'audio';
            if (type.includes('pdf')) return 'pdf';
            return 'document';
        },

        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
    }">
        <!-- File Input -->
        <input type="file" {{ $attributes->wire('model') }}
            @if ($accept) accept="{{ $accept }}" @endif
            @if ($multiple) multiple @endif @change="handleFileSelect($event)" x-ref="fileInput"
            class="block w-full text-sm text-gray-900 dark:text-gray-100
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-lg file:border-0
                   file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700
                   hover:file:bg-blue-100
                   dark:file:bg-blue-900 dark:file:text-blue-300
                   dark:hover:file:bg-blue-800
                   border border-gray-300 dark:border-gray-600
                   rounded-lg cursor-pointer
                   bg-white dark:bg-gray-800
                   focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Preview Section -->
        <div x-show="files.length > 0" x-cloak class="mt-4 space-y-3">
            <template x-for="(file, index) in files" :key="index">
                <div
                    class="relative border border-gray-200 dark:border-gray-700 rounded-lg p-3 bg-gray-50 dark:bg-gray-800">
                    <div class="flex items-start gap-3">
                        <!-- Preview Thumbnail -->
                        <div class="flex-shrink-0">
                            <!-- Image Preview -->
                            <template x-if="getFileType(file.type) === 'image'">
                                <img :src="file.url" :alt="file.name"
                                    class="w-16 h-16 object-cover rounded-lg">
                            </template>

                            <!-- Video Preview -->
                            <template x-if="getFileType(file.type) === 'video'">
                                <video :src="file.url" class="w-16 h-16 object-cover rounded-lg">
                                </video>
                            </template>

                            <!-- Audio Preview -->
                            <template x-if="getFileType(file.type) === 'audio'">
                                <div
                                    class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                            </template>

                            <!-- PDF Preview -->
                            <template x-if="getFileType(file.type) === 'pdf'">
                                <div
                                    class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>

                            <!-- Document Preview -->
                            <template x-if="getFileType(file.type) === 'document'">
                                <div
                                    class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </template>
                        </div>

                        <!-- File Info -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate" x-text="file.name">
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="formatSize(file.size)"></p>
                        </div>

                        <!-- Remove Button -->
                        <button type="button" @click="removeFile(index)"
                            class="flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Hint Text -->
    @if ($hint)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $hint }}
        </p>
    @endif

    <!-- Error Message -->
    @if ($error)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">
            {{ $error }}
        </p>
    @endif
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
