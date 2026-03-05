@props(['model', 'id', 'placeholder' => '', 'height' => 400, 'disabled' => false])

@php
    $editorId = $id ?? 'tinymce-' . uniqid();
@endphp

<div wire:ignore x-data="tinyEditor_{{ $editorId }}()" x-init="initEditor()">
    <textarea id="{{ $editorId }}" class="tinymce-editor" style="width: 100%;" {{ $disabled ? 'disabled' : '' }}></textarea>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.js') }}" referrerpolicy="origin"></script>
    @endpush
@endonce

@push('scripts')
<script>
    function tinyEditor_{{ $editorId }}() {
        return {
            value: @entangle($model).live,
            editor: null,
            editorId: '{{ $editorId }}',

            initEditor() {
                const self = this;

                tinymce.init({
                    selector: '#' + this.editorId,
                    height: {{ $height }},
                    menubar: false,
                    branding: false,
                    license_key: 'gpl',
                    promotion: false,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: false,
                    sandbox_iframes: false,

                    plugins: [
                        'code', 'table', 'lists', 'link', 'image',
                        'preview', 'anchor', 'searchreplace', 'visualblocks',
                        'fullscreen', 'insertdatetime', 'charmap', 'wordcount'
                    ],

                    toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen preview',

                    toolbar_mode: 'sliding',
                    contextmenu: 'link image table',
                    placeholder: '{{ $placeholder }}',
                    readonly: {{ $disabled ? 'true' : 'false' }},

                    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; font-size: 14px; padding: 10px; }',

                    images_upload_handler: function(blobInfo, progress) {
                        return new Promise((resolve, reject) => {
                            const formData = new FormData();
                            formData.append('file', blobInfo.blob(), blobInfo.filename());

                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route("admin.tinymce.upload-image") }}');
                            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

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
                                    reject('Validation error: ' + (json.message || 'Invalid image file.'));
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

                    setup: function(editor) {
                        self.editor = editor;

                        editor.on('init', function() {
                            editor.setContent(self.value || '');

                            self.$watch('value', (newValue) => {
                                if (editor.getContent() !== newValue) {
                                    editor.setContent(newValue || '');
                                }
                            });
                        });

                        editor.on('change keyup', function() {
                            self.value = editor.getContent();
                        });

                        editor.on('blur', function() {
                            self.value = editor.getContent();
                        });
                    }
                });
            }
        };
    }

    document.addEventListener('livewire:navigating', () => {
        if (typeof tinymce !== 'undefined') {
            tinymce.remove();
        }
    });
</script>
@endpush
