@push('head')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
@endpush

@push('scripts')
<script type="importmap">
    {
        "imports": {
            "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
            "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
        }
    }
</script>
<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Font,
        Paragraph,
        Heading,
        Link,
        List,
        BlockQuote,
        Indent,
        MediaEmbed,
        Table,
        TableToolbar,
        Alignment,
        HorizontalLine,
        SourceEditing,
        HtmlEmbed,
        GeneralHtmlSupport
    } from 'ckeditor5';

    const editorConfig = {
        plugins: [
            Essentials, Bold, Italic, Underline, Strikethrough,
            Font, Paragraph, Heading, Link, List, BlockQuote,
            Indent, MediaEmbed, Table, TableToolbar, Alignment,
            HorizontalLine, SourceEditing, HtmlEmbed, GeneralHtmlSupport
        ],
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'fontSize', 'fontColor', '|',
                'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'blockQuote', 'horizontalLine', '|',
                'link', 'insertTable', 'mediaEmbed', '|',
                'htmlEmbed', 'sourceEditing', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        },
        htmlSupport: {
            allow: [{ name: /.*/, attributes: true, classes: true, styles: true }]
        }
    };

    document.querySelectorAll('.ckeditor').forEach(el => {
        ClassicEditor.create(el, editorConfig)
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    el.value = editor.getData();
                });
            })
            .catch(error => console.error(error));
    });
</script>
<style>
    .ck-editor__editable { min-height: 250px; }
</style>
@endpush
