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
                                        const formData = new FormData();
                                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                                        const xhr = new XMLHttpRequest();
                                        xhr.open('POST', '{{ route('admin.tinymce.upload-image') }}');
                                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content')); xhr.upload.onprogress=function(e) { if
    (e.lengthComputable) { progress(e.loaded / e.total * 100); } }; xhr.onload=function() { if (xhr.status===200) {
    const json=JSON.parse(xhr.responseText); resolve(json.location); } else if (xhr.status===422) { const
    json=JSON.parse(xhr.responseText); reject('Validation error: ' + (json.message || ' Invalid image file.')); } else {
    reject('Image upload failed. HTTP Error: ' + xhr.status);
                        }
                    };

                    xhr.onerror = function() {
                        reject(' Image upload failed due to a network error.'); }; xhr.send(formData); }); },
    media_url_resolver: function(data, resolve) { const url=data.url || '' ; const
    appUrl = '{{ rtrim(config('app.url'), '/') }}'; const videoPagePattern=new RegExp('^' +
    appUrl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&' ) + '/video/(.+)$' ); const match=url.match(videoPagePattern); if
    (match) { const slug=match[1]; const embedUrl=appUrl + '/embed/' + slug; resolve({
    html: '<iframe src="' + embedUrl + '" width="560" height="600" frameborder="0" allowfullscreen style="border-radius:12px; max-width:100%;"></iframe>'
    }); } else { resolve({ html: '' }); } }, setup: function(editor) { self.editor=editor; // Set initial content
    editor.on('init', function() { editor.setContent(self.value || '' ); // Watch for external updates from Livewire
    self.$watch('value', (newValue)=> {
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
