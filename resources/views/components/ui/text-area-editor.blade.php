 <textarea id="content-{{ $this->getId() }}" class="tinymce-editor">{!! $slot !!}</textarea>
 <script>
     const editorId = 'content-' + $wire.__instance.id;

     const initEditor = () => {
         if (typeof tinymce === 'undefined') {
             setTimeout(initEditor, 100);
             return;
         }

         if (tinymce.get(editorId)) {
             tinymce.get(editorId).remove();
         }

         tinymce.init({
             selector: '#' + editorId,
             plugins: 'code table lists link image media preview',
             toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | link image media | code preview',
             height: 400,
             menubar: false,
             branding: false,
             license_key: 'gpl',

             setup: (editor) => {
                 editor.on('init', () => {
                     editor.setContent($wire.content || '');
                 });

                 editor.on('blur', () => {
                     $wire.content = editor.getContent();
                 });
             }
         });
     };

     document.addEventListener('livewire:initialized', initEditor);
     //  initEditor();
 </script>
