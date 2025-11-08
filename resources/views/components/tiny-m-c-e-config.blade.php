<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea.tinymce',
                plugins: 'code table lists link image media preview',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code preview',
                height: 400,
                menubar: false,
                branding: false,
                license_key: 'gpl',

                // Important for Livewire
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save();
                    });
                    editor.on('blur', function() {
                        editor.save();
                    });
                }
            });
        }
    });
</script>
