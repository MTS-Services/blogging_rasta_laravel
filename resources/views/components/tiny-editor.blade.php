@props(['model', 'id', 'placeholder' => '', 'height' => 400, 'disabled' => false])

@php
    $editorId = $id ?? 'tinymce-' . uniqid();
@endphp

<div wire:ignore x-data="{
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

            plugins: [
                'code', 'table', 'lists', 'link', 'image', 'media',
                'preview', 'anchor', 'searchreplace', 'visualblocks',
                'fullscreen', 'insertdatetime', 'charmap', 'wordcount'
            ],

            toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat code fullscreen preview',

            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            placeholder: '{{ $placeholder }}',
            readonly: {{ $disabled ? 'true' : 'false' }},

            content_style: `
                    body { 
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; 
                        font-size: 14px;
                        padding: 10px;
                    }
                `,

            images_upload_handler: function(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        resolve(reader.result);
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(blobInfo.blob());
                });
            },

            setup: function(editor) {
                self.editor = editor;

                // Set initial content
                editor.on('init', function() {
                    editor.setContent(self.value || '');

                    // Watch for external updates from Livewire
                    self.$watch('value', (newValue) => {
                        if (editor.getContent() !== newValue) {
                            editor.setContent(newValue || '');
                        }
                    });
                });

                // Update Livewire on change
                editor.on('change keyup', function() {
                    self.value = editor.getContent();
                });

                // Update on blur
                editor.on('blur', function() {
                    self.value = editor.getContent();
                });
            }
        });
    }
}" x-init="initEditor()">
    <textarea id="{{ $editorId }}" class="tinymce-editor" style="width: 100%;" {{ $disabled ? 'disabled' : '' }}></textarea>
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.js') }}" referrerpolicy="origin"></script>
        <script>
            // Cleanup on page navigation
            document.addEventListener('livewire:navigating', () => {
                if (typeof tinymce !== 'undefined') {
                    tinymce.remove();
                }
            });
        </script>
    @endpush
@endonce
