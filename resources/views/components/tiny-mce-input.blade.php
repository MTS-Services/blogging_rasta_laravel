@props([
    'id',
    'name',
    'value',
    'placeholder',
    'height',
    'plugins',
    'toolbar',
    'menubar',
    'readonly',
    'label',
    'required',
    'class',
])

<div class="w-full {{ $class }}">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $id }}" name="{{ $name }}" class="tinymce-input" placeholder="{{ $placeholder }}"
        @if ($required) required @endif>{!! $slot !!}</textarea>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof tinymce !== 'undefined') {
                    // Initialize all TinyMCE inputs on the page
                    document.querySelectorAll('.tinymce-input').forEach(function(element) {
                        const editorId = element.id;
                        const height = element.dataset.height || 400;
                        const plugins = element.dataset.plugins || 'code table lists link image media preview';
                        const toolbar = element.dataset.toolbar ||
                            'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link image media | code preview';
                        const menubar = element.dataset.menubar === 'true';
                        const readonly = element.dataset.readonly === 'true';

                        tinymce.init({
                            selector: '#' + editorId,
                            plugins: plugins,
                            toolbar: toolbar,
                            height: parseInt(height),
                            menubar: menubar,
                            branding: false,
                            license_key: 'gpl',
                            readonly: readonly,
                        });
                    });
                }
            });
        </script>
    @endpush
@endonce
@script
    <script>
        // Store config in data attributes for the initialization script
        document.getElementById('{{ $id }}').dataset.height = '{{ $height }}';
        document.getElementById('{{ $id }}').dataset.plugins = '{{ $plugins }}';
        document.getElementById('{{ $id }}').dataset.toolbar = '{{ $toolbar }}';
        document.getElementById('{{ $id }}').dataset.menubar = '{{ $menubar ? 'true' : 'false' }}';
        document.getElementById('{{ $id }}').dataset.readonly = '{{ $readonly ? 'true' : 'false' }}';
    </script>
@endscript
