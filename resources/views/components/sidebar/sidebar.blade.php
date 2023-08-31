@props(['title' => 'Title'])
<link rel="stylesheet" href="/css/product-sidebar-item.css">
<link rel="stylesheet" href="/css/sidebar.css">
<script>
    const toggleListIds = ["first_tab_button", "second_tab_button"];

    function toggleProducts(element) {
        toggleListIds.forEach(id => {
            if (id !== element.id) {
                document.getElementById(id).classList.remove("fw-bold");
            }
        });
        element.classList.add("fw-bold");

        if (element.id === "first_tab_button") {
            $("#first_tab_content").show();
            $("#second_tab_content").hide();
        } else {
            $("#first_tab_content").hide();
            $("#second_tab_content").show();
        }
    }
</script>

<p class="text-center mt-2 h5">{{$title}}</p>

<div class="row text-center">
    <div class="col clickable">
        <button class="btn text-center fw-light fw-bold h5" id="first_tab_button" onclick="toggleProducts(this)">
            {{$first_tab_button}}
        </button>
    </div>
    <div class="col clickable">
        <button class="btn text-center fw-light h5" id="second_tab_button" onclick="toggleProducts(this)">
            {{$second_tab_button}}
        </button>
    </div>
</div>

<div id="first_tab_content" class="mt-2">
    {{$first_tab_content}}
</div>
<div id="second_tab_content" class="mt-2">
    {{$second_tab_content}}
</div>
