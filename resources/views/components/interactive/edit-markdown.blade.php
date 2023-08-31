@props([
    'linked_field',
    'markdown' => '',
    'editor_id' => 'markdown_editor'
])

@php
    $field_hash = hash('sha256', $linked_field);
    $editor_id = "markdown_editor_$field_hash";
@endphp

<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script src="{{ asset('/js/edit_markdown.js') }}"></script>
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
<a href="{{ asset('/markdown_guide.pdf') }}" style="text-decoration: none" target="_blank">
    <i class="bi bi-question-circle"></i>
    <span class="text-muted">{{__('admin.product_edit.markdown_guide')}}</span>
</a>
<div id="{{$editor_id}}">

</div>
<script>
    create_editor('{!! $editor_id !!}', '{!! $linked_field !!}', {!! json_encode(old('description', $markdown)) !!});
</script>
