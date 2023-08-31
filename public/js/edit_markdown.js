const Editor = toastui.Editor;

function create_editor(editor_id, linked_field, content) {
    let editor = new Editor({
        el: document.getElementById(editor_id),
        height: '500px',
        width: '100%',
        initialEditType: 'wysiwyg',
        previewStyle: 'vertical'
    });
    editor.replaceSelection(content, 0, 1);

    // Add hook to update hidden input on change
    editor.on('change', function() {
        document.getElementById(linked_field).value = editor.getMarkdown();
    });

    // Ensure that the input field has the same value when the event is not triggered
    document.getElementById(linked_field).value = editor.getMarkdown();

    return editor;
}
