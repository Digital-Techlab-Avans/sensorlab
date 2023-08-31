   @props(['dropdown_text_card' ?? '', 'dropdown_text_list' ?? ''])

    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        Weergave: {{ $dropdown_text_card}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#" id="cardViewBtn">{{$dropdown_text_card}}</a>
        <a class="dropdown-item" href="#" id="listViewBtn">{{$dropdown_text_list}}</a>
    </div>
