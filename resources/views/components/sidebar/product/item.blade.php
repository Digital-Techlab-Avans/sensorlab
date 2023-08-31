@props(['name', 'route', 'showError' => false, 'headerTotal', 'bodyHeader'])
<script>
    function toggleSubItems(element) {
        // get the parent element of the clicked element
        let subItems = element.parentElement.querySelector("#sidebar-sub-items");
        if (subItems.style.display === "none") {
            subItems.style.display = "block";
            element.querySelector("#dropdown-icon").classList.remove("fa-caret-down");
            element.querySelector("#dropdown-icon").classList.add("fa-caret-up");
        } else {
            subItems.style.display = "none";
            element.querySelector("#dropdown-icon").classList.add("fa-caret-down");
            element.querySelector("#dropdown-icon").classList.remove("fa-caret-up");
        }
    }

</script>
<div class="card sidebar-item {{$showError ? 'border-danger border-2' : ''}}">
    <details>
        <summary class="card-header row main-item" onclick="toggleSubItems(this)">
            <div class="col">
                <div class="fw-bold">
                    <a aria-label="Navigeer naar {{$name}}" href="{{$route}}" class="item-link">
                        {{$name}}
                    </a>
                </div>
            </div>
            <div class="col-3">Totaal: {{$headerTotal}}</div>
            <i id="dropdown-icon" class="col-1 align-self-center text-center bi bi-caret-down-fill"></i>
            <span aria-label="Druk op enter om card te openen"></span>
        </summary>
        <div class="card-body" id="sidebar-sub-items" style="display: none">
            <div>{{$bodyHeader}}</div>
            {{$body}}
        </div>
    </details>
</div>


