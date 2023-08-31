$(document).ready(function () {
    const existingCategories = JSON.parse($('#existing_categories').val()).map(category => category.name.toLowerCase());

    const createCategoryTag = params => {
        const term = params.term.toLowerCase();
        if (existingCategories.includes(term)) {
            return null;
        }

        return {
            id: params.term,
            text: params.term,
            newOption: true,
        };
    };

    const renderCategoryTag = data => {
        const $result = $("<span></span>");
        $result.text(data.text);

        if (data.newOption) {
            $result.append(" <em>(Nieuw)</em>");
        }
        return $result;
    };

    const handleCategorySelection = e => {
        if (e.params.data.newOption) {
            const categoryName = e.params.data.text;
            let newCategories = $('#new_categories').val();
            newCategories += newCategories.length > 0 ? ',' : '';
            newCategories += categoryName;
            $('#new_categories').val(newCategories);
        }
    };

    $(".select2").select2({
        tags: true,
        tokenSeparators: [','],
        createTag: createCategoryTag,
        templateResult: renderCategoryTag,
    }).on('select2:select', handleCategorySelection);
});
