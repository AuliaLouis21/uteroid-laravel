{{-- Shared Quill.js editor partial
     
     STEP 1: Place container HTML inline in your form (before the textarea):
         @include('admin.partials._quill', ['textareaId' => 'content', 'height' => '300px'])
     
     The HTML (div, CSS) renders inline. Only JS goes to @push('scripts').
--}}

{{-- CSS --}}
<link href="{{ asset('quill/quill.snow.css') }}" rel="stylesheet">
<style>
    .quill-editor-wrapper {
        margin-bottom: 1rem;
    }
    .quill-editor-wrapper .ql-toolbar.ql-snow {
        border-radius: 6px 6px 0 0;
        background: #f8f9fa;
    }
    .quill-editor-wrapper .ql-container.ql-snow {
        border-radius: 0 0 6px 6px;
        min-height: {{ $height ?? '300px' }};
        font-size: 14px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .quill-editor-wrapper .ql-editor {
        min-height: {{ $height ?? '300px' }};
    }
    .quill-editor-wrapper .ql-editor.ql-blank::before {
        color: #adb5bd;
        font-style: normal;
    }
</style>

{{-- Editor container div (rendered inline in form) --}}
<div class="quill-editor-wrapper">
    <div id="quill-editor-{{ $textareaId ?? 'content' }}"></div>
</div>

{{-- JavaScript initialization (also inline, no @push needed) --}}
<script src="{{ asset('quill/quill.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var textareaId = '{{ $textareaId ?? "content" }}';
    var textarea = document.getElementById(textareaId);

    // Hide the original textarea
    if (textarea) {
        textarea.style.display = 'none';
    }

    // Initialize Quill
    var quill = new Quill('#quill-editor-' + textareaId, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Tulis konten di sini...'
    });

    // Load existing content from textarea into Quill
    if (textarea && textarea.value) {
        quill.root.innerHTML = textarea.value;
    }

    // Sync Quill content to textarea before form submit
    var form = textarea ? textarea.closest('form') : null;
    if (form) {
        form.addEventListener('submit', function() {
            textarea.value = quill.root.innerHTML;
        });
    }
});
</script>
