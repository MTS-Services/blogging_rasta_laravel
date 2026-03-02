<div class="w-full">
    @if ($label)
        <label for="{{ $editorId }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div wire:ignore>
        <textarea id="{{ $editorId }}" class="tinymce-editor" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
    </div>

    @if ($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>

@assets
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
@endassets

@script
    <script>
        const editorId = @js($editorId);
        const componentId = @js($this->getId());

        const initEditor = () => {
            if (typeof tinymce === 'undefined') {
                setTimeout(initEditor, 100);
                return;
            }

            // Remove existing instance if any
            if (tinymce.get(editorId)) {
                tinymce.get(editorId).remove();
            }

            tinymce.init({
                selector: '#' + editorId,
                plugins: @js($plugins),
                toolbar: @js($toolbar),
                height: @js($height),
                menubar: @js($menubar),
                branding: false,
                license_key: 'gpl',
                readonly: @js($readonly),
                placeholder: @js($placeholder),

                images_upload_handler: function(blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', @js(route('admin.tinymce.upload-image')));
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector(
                            'meta[name="csrf-token"]').getAttribute('content'));

                        xhr.upload.onprogress = function(e) {
                            if (e.lengthComputable) {
                                progress(e.loaded / e.total * 100);
                            }
                        };

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                const json = JSON.parse(xhr.responseText);
                                resolve(json.location);
                            } else if (xhr.status === 422) {
                                const json = JSON.parse(xhr.responseText);
                                reject('Validation error: ' + (json.message ||
                                    'Invalid image file.'));
                            } else {
                                reject('Image upload failed. HTTP Error: ' + xhr.status);
                            }
                        };

                        xhr.onerror = function() {
                            reject('Image upload failed due to a network error.');
                        };

                        xhr.send(formData);
                    });
                },

                media_url_resolver: function(data, resolve, reject) {
                    try {
                        const url = data.url || '';
                        const appUrl = @js(rtrim(config('app.url'), '/'));

                        const videoPagePattern = new RegExp('^' + appUrl.replace(/[.*+?^${}()|[\]\\]/g,
                            '\\$&') + '/video/(.+)$');
                        const match = url.match(videoPagePattern);

                        if (match) {
                            const slug = match[1];
                            const embedUrl = appUrl + '/embed/' + slug;
                            resolve({
                                html: '<iframe src="' + embedUrl +
                                    '" width="560" height="600" frameborder="0" allowfullscreen style="border-radius:12px; max-width:100%;"></iframe>'
                            });
                        } else {
                            resolve({
                                html: ''
                            });
                        }
                    } catch (error) {
                        console.error('Media resolver error:', error);
                        resolve({
                            html: ''
                        });
                    }
                },

                setup: (editor) => {
                    // Set initial content
                    editor.on('init', () => {
                        editor.setContent($wire.value || '');
                    });

                    // Sync on change
                    editor.on('change', () => {
                        $wire.value = editor.getContent();
                    });

                    // Sync on blur
                    editor.on('blur', () => {
                        $wire.value = editor.getContent();
                    });

                    // Listen for external updates
                    $wire.on('tinymce-updated-' + editorId, (event) => {
                        if (editor.getContent() !== event.content) {
                            editor.setContent(event.content || '');
                        }
                    });
                }
            });
        };

        // Initialize editor
        initEditor();

        // Cleanup on component destroy
        document.addEventListener('livewire:navigating', () => {
            if (tinymce.get(editorId)) {
                tinymce.get(editorId).remove();
            }
        });
    </script>
@endscript
