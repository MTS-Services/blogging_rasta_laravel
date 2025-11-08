@props([
    'wire:model' => null,
    'label' => null,
    'accept' => null,
    'required' => false,
    'multiple' => false,
    'disabled' => false,
    'name' => null,
    'preview' => true,
    'existingFiles' => [],
    'error' => null,
    'hint' => null,
    'maxSize' => '10MB',
])

@php
    $wireModel = $attributes->wire('model')->value();
    $uniqueId = 'file-input-' . uniqid();
    $inputId = 'file-input-' . uniqid();
@endphp

<div class="relative w-full" wire:ignore.self x-data="{
    uploading: false,
    progress: 0,
    previewFiles: [],
    existingFiles: @js($existingFiles),
    inputId: '{{ $inputId }}',

    get hasFiles() {
        return this.previewFiles.length > 0 || this.existingFiles.length > 0;
    },

    get allFiles() {
        return [...this.existingFiles, ...this.previewFiles];
    },

    handleFiles(event) {
        const files = event.target.files;
        if (!files || files.length === 0) return;

        this.previewFiles = [];

        Array.from(files).forEach(file => {
            this.previewFiles.push({
                name: file.name,
                size: file.size,
                type: file.type,
                url: URL.createObjectURL(file),
                isNew: true
            });
        });
    },

    removeFile(index) {
        // Remove from preview
        const fileToRemove = this.allFiles[index];

        if (fileToRemove.isNew) {
            const previewIndex = this.previewFiles.findIndex(f => f.url === fileToRemove.url);
            if (previewIndex > -1) {
                URL.revokeObjectURL(this.previewFiles[previewIndex].url);
                this.previewFiles.splice(previewIndex, 1);
            }
        } else {
            const existingIndex = this.existingFiles.findIndex(f => f === fileToRemove);
            if (existingIndex > -1) {
                this.existingFiles.splice(existingIndex, 1);
            }
        }

        // Reset the file input
        const input = document.getElementById(this.inputId);
        if (input) {
            input.value = '';
        }

        // Call Livewire method to remove from backend
        if (typeof @this.removeAvatar === 'function') {
            @this.call('removeAvatar');
        }

        // Clear preview if no files left
        if (!{{ $multiple ? 'true' : 'false' }} && this.previewFiles.length === 0) {
            this.previewFiles = [];
        }
    },

    getFileType(file) {
        if (!file) return 'unknown';

        const type = file.type || '';
        const name = file.name || file.path || '';

        if (type.startsWith('image/') || /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(name)) {
            return 'image';
        }
        if (type.startsWith('video/') || /\.(mp4|webm|ogg|avi)$/i.test(name)) {
            return 'video';
        }
        if (type.startsWith('audio/') || /\.(mp3|wav|ogg)$/i.test(name)) {
            return 'audio';
        }
        if (type.includes('pdf') || name.endsWith('.pdf')) {
            return 'pdf';
        }
        return 'document';
    },

    formatFileSize(bytes) {
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    },

    getFileUrl(file) {
        return file.url || file.path || '';
    },

    resetPreview() {
        this.previewFiles.forEach(file => {
            if (file.url) {
                URL.revokeObjectURL(file.url);
            }
        });
        this.previewFiles = [];
    }
}"
    x-on:livewire-upload-start="uploading = true; progress = 0"
    x-on:livewire-upload-finish="uploading = false; progress = 100; setTimeout(() => progress = 0, 500)"
    x-on:livewire-upload-error="uploading = false; progress = 0; resetPreview()"
    x-on:livewire-upload-progress="progress = $event.detail.progress || 0">
    {{-- Border color changes based on file state --}}
    <div class="border-2 border-dashed rounded-xl transition-all duration-300 bg-white dark:bg-gray-800 hover:border-accent hover:shadow-lg cursor-pointer relative overflow-hidden w-full p-2"
        :class="{
            'border-accent': hasFiles,
            'border-gray-300 dark:border-gray-600': !hasFiles
        }">
        <input type="file" :id="inputId" {{ $attributes->wire('model') }}
            @if ($accept) accept="{{ $accept }}" @endif
            @if ($multiple) multiple @endif @if ($disabled) disabled @endif
            @if ($name) name="{{ $name }}" @endif class="hidden"
            x-on:change="handleFiles($event)">

        {{-- Show upload prompt when no files or when multiple is enabled --}}
        <div x-show="(!hasFiles || {{ $multiple ? 'true' : 'false' }}) && !uploading" x-transition>
            <label :for="inputId" class="cursor-pointer block">
                {{-- Upload Prompt --}}
                <div class="py-12 px-6">
                    <div class="flex flex-col items-center space-y-5">
                        {{-- Icon with Loading Animation --}}
                        <div class="relative">
                            <div class="relative w-24 h-24">
                                <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                                    <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8"
                                        fill="none" class="text-gray-200 dark:text-gray-800" />
                                    <circle cx="50" cy="50" r="40"
                                        stroke="url(#gradient-{{ $uniqueId }})" stroke-width="8" fill="none"
                                        stroke-linecap="round"
                                        style="stroke-dasharray: 251.2; stroke-dashoffset: 251.2; animation: fillProgress 2s ease-in-out infinite;" />
                                    <defs>
                                        <linearGradient id="gradient-{{ $uniqueId }}" x1="0%" y1="0%"
                                            x2="100%" y2="100%">
                                            <stop offset="0%"
                                                style="stop-color: var(--color-accent);stop-opacity:1" />
                                            <stop offset="100%"
                                                style="stop-color: var(--color-accent);stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div
                                        class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-transparent via-accent/20 to-transparent rounded-full">
                                        <flux:icon name="cloud-arrow-up" class="w-10 h-10 stroke-accent" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Text Content --}}
                        <div class="text-center space-y-2">
                            <div>
                                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-accent-content to-zinc-600 dark:from-accent dark:to-zinc-400">
                                        Drop your files here
                                    </span>
                                    <span class="text-gray-600 dark:text-gray-400"> or </span>
                                    <span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-accent-content to-zinc-600 dark:from-accent dark:to-zinc-400 hover:from-zinc-600 hover:to-accent transition-all duration-300">
                                        browse
                                    </span>
                                </p>
                                <div
                                    class="flex items-center justify-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mt-3">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        @if ($accept)
                                            {{ $accept }}
                                        @else
                                            All formats
                                        @endif
                                    </span>
                                    <span class="text-gray-400">•</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
                                        </svg>
                                        Max {{ $maxSize }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </label>
        </div>

        {{-- On Upload Time Show the content --}}
        <div class="py-12 px-6" x-show="uploading" x-cloak x-transition>
            <div class="flex flex-col items-center space-y-5">
                <div class="relative">
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8"
                                fill="none" class="text-gray-200 dark:text-gray-800" />
                            <circle cx="50" cy="50" r="40"
                                stroke="url(#gradient-progress-{{ $uniqueId }})" stroke-width="8" fill="none"
                                stroke-linecap="round"
                                :style="`stroke-dasharray: 251.2; stroke-dashoffset: ${251.2 - (251.2 * progress) / 100}`"
                                class="transition-all duration-300" />
                            <defs>
                                <linearGradient id="gradient-progress-{{ $uniqueId }}" x1="0%"
                                    y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color: var(--color-accent);stop-opacity:1" />
                                    <stop offset="100%" style="stop-color: var(--color-accent);stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-lg font-bold text-accent" x-text="Math.round(progress) + '%'"></span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2">
                    <p
                        class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-accent-content to-zinc-600 dark:from-accent dark:to-zinc-400">
                        Uploading...
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Please wait while we process your file
                    </p>
                </div>
            </div>
        </div>

        {{-- Preview Files --}}
        @if ($preview)
            {{-- Single File Preview --}}
            <div x-show="!{{ $multiple ? 'true' : 'false' }} && hasFiles && !uploading" x-cloak x-transition>
                <template x-for="(file, index) in allFiles" :key="index">
                    <div class="relative group p-4">
                        {{-- Image Preview --}}
                        <template x-if="getFileType(file) === 'image'">
                            <div class="relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <img :src="getFileUrl(file)" :alt="file.name" class="w-full h-64 object-contain">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <p class="text-white text-sm font-medium truncate" x-text="file.name"></p>
                                        <p class="text-white/80 text-xs" x-text="formatFileSize(file.size)"></p>
                                    </div>
                                </div>
                                <button type="button" @click.prevent="removeFile(index)"
                                    class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform hover:scale-110">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        {{-- Video Preview --}}
                        <template x-if="getFileType(file) === 'video'">
                            <div class="relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <video :src="getFileUrl(file)" controls class="w-full h-64 object-contain"></video>
                                <button type="button" @click.prevent="removeFile(index)"
                                    class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        {{-- Document/PDF Preview --}}
                        <template x-if="getFileType(file) !== 'image' && getFileType(file) !== 'video'">
                            <div
                                class="relative rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 p-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-accent/20 to-accent/10 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"
                                            x-text="file.name"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400"
                                            x-text="formatFileSize(file.size)"></p>
                                    </div>
                                    <button type="button" @click.prevent="removeFile(index)"
                                        class="flex-shrink-0 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Multiple Files Preview Grid --}}
            <div x-show="{{ $multiple ? 'true' : 'false' }} && hasFiles && !uploading" x-cloak x-transition
                class="p-4">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="(file, index) in allFiles" :key="index">
                        <div class="relative group">
                            {{-- Image Thumbnail --}}
                            <template x-if="getFileType(file) === 'image'">
                                <div
                                    class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                    <img :src="getFileUrl(file)" :alt="file.name"
                                        class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute bottom-0 left-0 right-0 p-2">
                                            <p class="text-white text-xs font-medium truncate" x-text="file.name"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click.prevent="removeFile(index)"
                                        class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            {{-- File Icon for Other Types --}}
                            <template x-if="getFileType(file) !== 'image'">
                                <div
                                    class="relative aspect-square rounded-lg border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/50 p-3">
                                    <div class="flex flex-col items-center justify-center h-full space-y-2">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-accent/20 to-accent/10 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-xs text-center font-medium text-gray-700 dark:text-gray-300 truncate w-full"
                                            x-text="file.name"></p>
                                    </div>
                                    <button type="button" @click.prevent="removeFile(index)"
                                        class="absolute top-2 right-2 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        @endif
    </div>

    {{-- Error Message --}}
    @if ($error || $attributes->has('error'))
        <div
            class="mt-3 flex items-start space-x-2 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-lg p-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm font-medium">{{ $error ?? $attributes->get('error') }}</span>
        </div>
    @endif
</div>

<style>
    [x-cloak] {
        display: none !important;
    }

    @keyframes fillProgress {
        0% {
            stroke-dashoffset: 251.2;
        }

        100% {
            stroke-dashoffset: 0;
        }
    }
</style>
