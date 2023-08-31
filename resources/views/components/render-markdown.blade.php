@props([
    'markdown' => '',
    'parent_element_id' => ''
])

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="{{ asset('/js/render-markdown.js') }}"></script>
<script>
    document.getElementById('{{$parent_element_id}}').innerHTML = marked.parse({!! json_encode($markdown) !!}, {renderer: renderer});
</script>
