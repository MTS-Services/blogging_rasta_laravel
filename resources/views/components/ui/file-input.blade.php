@props([
    'label' => null,
    'accept' => null,
    'multiple' => false,
    'error' => null,
    'hint' => null,
])

@php
    $inputId = 'file-' . uniqid();
@endphp

<div class="w-full">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
        </label>
    @endif

    <div x-data="{
        preview: null,
        previews: [],
        isDragging: false,
        isUpdating: false,

        showPreview(event) {
            if (this.isUpdating) return;
            const files = event.target.files;
            if (!files || files.length === 0) return;

            if ({{ $multiple ? 'true' : 'false' }}) {
                const filesData = event.target.files;
                const newFiles = Array.from(filesData).map(file => ({
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    url: URL.createObjectURL(file),
                    file: file
                }));
                this.previews = newFiles;
            } else {
                const file = files[0];
                this.preview = {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    url: URL.createObjectURL(file)
                };
            }
        },

        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (!files || files.length === 0) return;

            this.$refs.fileInput.files = files;
            this.showPreview({ target: { files } });
        },

        updateFileInput(previews = null) {
            this.isUpdating = true;

            const dt = new DataTransfer();
            previews = previews ?? this.previews;

            // Add files to DataTransfer
            previews.forEach(f => {
                dt.items.add(f.file);
            });
            this.$refs.fileInput.files = dt.files;

            console.log('New files (input.files):', this.$refs.fileInput.files);

            this.$nextTick(() => {
                this.$wire.upload(
                    '{{ $attributes->wire('model')->value() }}',
                    this.$refs.fileInput.files,
                    () => { this.isUpdating = false; }, // Success callback
                    () => { this.isUpdating = false; } // Error callback
                );
            });
        },

        removeFile(index) {
            URL.revokeObjectURL(this.previews[index].url);
            this.previews.splice(index, 1);
            const dt = new DataTransfer();
            this.previews.forEach(f => dt.items.add(f.file));
            this.$refs.fileInput.files = dt.files;

            if (this.previews.length > 0) {
                this.$refs.fileInput.dispatchEvent(new Event('change'));

            } else {
                this.$refs.fileInput.value = '';
                this.$wire.set('{{ $attributes->wire('model')->value() }}', null);
            }

            console.log('Updated previews:', this.previews);
        },

        clearFile() {
            this.preview = null;
            this.previews.forEach(f => URL.revokeObjectURL(f.url));
            this.previews = [];
            this.$refs.fileInput.value = '';
            @this.set('{{ $attributes->wire('model')->value() }}', null);
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


        <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop($event)"
            :class="isDragging || preview || previews.length > 0 ? '!border-zinc-600 bg-zinc-50 dark:bg-zinc-900/20' :
                'border-gray-300 dark:border-gray-600'"
            class="border-2 border-dashed rounded-xl transition-all duration-300 bg-bg-primary! hover:border-accent hover:shadow-lg cursor-pointer relative overflow-hidden w-full p-2">

            <input type="file" id="{{ $inputId }}" {{ $attributes->wire('model') }}
                @if ($accept) accept="{{ $accept }}" @endif
                @if ($multiple) multiple @endif @change="showPreview($event)" x-ref="fileInput"
                class="hidden">

            <!-- SINGLE FILE MODE -->
            <template x-if="!{{ $multiple ? 'true' : 'false' }}">
                <div>
                    <!-- Upload Area -->
                    <label x-show="!preview" for="{{ $inputId }}" class="block cursor-pointer p-12 text-center">
                        <div class="space-y-3">
                            <div class="flex justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{__('Click to upload')}}</span>
                                    {{ __('or drag and drop') }}
                                </p>
                                @if ($hint)
                                    <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
                                @endif
                            </div>
                        </div>
                    </label>

                    <!-- Single Preview -->
                    <div x-show="preview" x-cloak class="p-4">
                        <div class="relative group">
                            <!-- Image -->
                            <template x-if="preview && getFileType(preview.type) === 'image'">
                                <div class="relative rounded-lg overflow-hidden">
                                    <img :src="preview.url" :alt="preview.name"
                                        class="w-full h-64 object-contain bg-gray-100 dark:bg-gray-900">
                                    <div
                                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end">
                                        <div class="p-4 text-white w-full">
                                            <p class="text-sm font-medium truncate" x-text="preview.name"></p>
                                            <p class="text-xs opacity-90" x-text="formatSize(preview.size)"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="clearFile()"
                                        class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <!-- Video -->
                            <template x-if="preview && getFileType(preview.type) === 'video'">
                                <div class="relative rounded-lg overflow-hidden">
                                    <video :src="preview.url" controls
                                        class="w-full h-64 bg-gray-100 dark:bg-gray-900"></video>
                                    <button type="button" @click="clearFile()"
                                        class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <!-- Other Files -->
                            <template
                                x-if="preview && getFileType(preview.type) !== 'image' && getFileType(preview.type) !== 'video'">
                                <div class="flex items-center gap-4 p-6 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                    <div
                                        class="flex-shrink-0 w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"
                                            x-text="preview.name"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400"
                                            x-text="formatSize(preview.size)"></p>
                                    </div>
                                    <button type="button" @click="clearFile()"
                                        class="flex-shrink-0 p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- MULTIPLE FILES MODE -->
            <template x-if="{{ $multiple ? 'true' : 'false' }}">
                <div>
                    <!-- Upload Area (Always visible) -->
                    <label for="{{ $inputId }}" class="block cursor-pointer p-8 text-center">
                        <div class="space-y-3">
                            <div class="flex justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <span class="font-semibold text-blue-600 dark:text-blue-400">{{__('Click to upload')}}</span>
                                    {{ __('or drag and drop') }}
                                </p>
                                @if ($hint)
                                    <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
                                @endif
                            </div>
                        </div>
                    </label>

                    <!-- Grid Preview -->
                    <div x-show="previews.length > 0" x-cloak
                        class="border-t border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span x-text="previews.length"></span> {{ __('file(s) selected') }}
                            </p>
                            <button type="button" @click="clearFile()"
                                class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 font-medium">
                                {{ __('Clear all') }}
                            </button>
                        </div>
                        <div class="grid grid-cols-3 md:grid-cols-4 2xl:grid-cols-6 gap-3">
                            <template x-for="(file, index) in previews" :key="index">
                                <div class="relative group">
                                    <!-- Image Thumbnail -->
                                    <template x-if="getFileType(file.type) === 'image'">
                                        <div
                                            class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                                            <img :src="file.url" :alt="file.name"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end">
                                                <p class="text-white text-xs p-2 truncate w-full" x-text="file.name">
                                                </p>
                                            </div>
                                            <button type="button" @click="removeFile(index)"
                                                class="absolute top-1 right-1 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="getFileType(file.type) == 'video'">
                                        <div
                                            class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                                            <video :src="file.url" controls class="w-full h-full object-cover">
                                            </video>
                                            <div
                                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-end">
                                                <p class="text-white text-xs p-2 truncate w-full" x-text="file.name">
                                                </p>
                                            </div>
                                            <button type="button" @click="removeFile(index)"
                                                class="absolute top-1 right-1 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>


                                    <!-- File Icon -->
                                    <template
                                        x-if="getFileType(file.type) !== 'image' && getFileType(file.type) !== 'video'">
                                        <div
                                            class="relative aspect-square rounded-lg bg-gray-50 dark:bg-gray-900 p-3 flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 text-zinc-600 mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 text-center truncate w-full"
                                                x-text="file.name"></p>
                                            <button type="button" @click="removeFile(index)"
                                                class="absolute top-1 right-1 p-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-lg transition-all">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Error Message -->
    @if ($error)
        <div class="mt-2 flex items-center gap-2 text-sm text-red-600 dark:text-red-400">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
            <span>{{ $error }}</span>
        </div>
    @endif
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
