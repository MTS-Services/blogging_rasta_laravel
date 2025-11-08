<div class="w-full">
    @if($label)
        <label for="{{ $editorId }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div wire:ignore>
        <textarea 
            id="{{ $editorId }}" 
            class="tinymce-editor"
            placeholder="{{ $placeholder }}"
        >{{ $value }}</textarea>
    </div>

    @if($error)
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