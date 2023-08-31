@props(['placeholder' => 'Ik ben op zoek naar ...', 'description' => 'Zoek ook in product omschrijving'])

@php(
    $search_lang_file = 'loaner.search_bar.'
)
<div class="bg-primary">
    <div class="col-11 col-sm-8 col-md-5 pt-4 pb-2 m-auto">
        <div class="d-flex mb-2">
            <div class="input-group">
                <input value="{{request('search')}}" autocomplete="off" name="search" placeholder="{{$placeholder}}" aria-label="Vul zoekterm in" class="form-control border-0 shadow-none bg-white" type="text" onkeyup="load_data(this.value)">
                <button type="submit" aria-label="Start zoekopdracht" class="btn bg-white">
                    <i class="bi bi-search text-warning fw-bold fs-5"></i>
                </button>
            </div>
            <div id="product_list"></div>
        </div>
        <div class="bg-opacity-50 bg-light rounded-2">
            <span id="search_result" class="text-start"></span>
        </div>
        <div class="form-check form-check-lg text-start mt-2">
            <input class="form-check-input border-2 border-warning" type="checkbox" value="{{true}}" id="description" name="description" @if(request('description')) checked @endif>
            <label class="form-check-label text-white" for="description">{{$description}}</label>
        </div>
    </div>
</div>


<script>

function load_data(query)
{
    if(query.length > 0)
    {
        query = query.trim();
        //create FormData
        let form_data = new FormData();
        form_data.append('query', query);

        //create ajax request
        let ajax_request = new XMLHttpRequest();

        //create route to Controller Logic
        let route = '{{route('autocomplete', ':query')}}'
        route = route.replace(':query', query);

        ajax_request.open('GET', route);

        ajax_request.send(form_data);

        ajax_request.onreadystatechange = function()
        {
            if(ajax_request.readyState == 4 && ajax_request.status == 200){

                //retrieve data from Controller Logic
                let response = JSON.parse(ajax_request.responseText);

                //create shell for list of search suggestions
                //let html = '<div class="list-group">';
                let html = document.createElement("div");
                html.className = "list-group";

                if(response.length > 0)
                {
                    for(let i = 0; i < response.length && i < 5; i++)
                    {
                        //generate path to the detail pages of the search suggestions
                        let url = "{{route('product_loaner_details', ':product_id')}}";
                        url = url.replace(':product_id', response[i].id);

                        //making the search query bold in the search suggestion
                        response[i].name = response[i].name.replace(new RegExp(`(${query})`, 'ig'), "<b>$1</b>");

                        //adding the search suggestion to the list of search suggestions
                        let newListItem = document.createElement("a");
                        newListItem.href = url;
                        newListItem.className = "list-group-item list-group-item-action pt-1 pb-1 p-2";
                        newListItem.innerHTML = response[i].name;

                        html.appendChild(newListItem);
                    }
                }
                else
                {
                    //display for empty state
                    let newListItem = document.createElement("a");
                    newListItem.href = '#';
                    newListItem.className = "list-group-item list-group-item-action disabled p-2";
                    newListItem.innerHTML = '{{__($search_lang_file.'empty_message')}}';

                    html.appendChild(newListItem);
                }

                document.getElementById('search_result').innerHTML = html.innerHTML;
            }
        }
    }
    else
    {
        //empty list of search suggestions if there is no query
        document.getElementById('search_result').innerHTML = '';
    }
}

</script>
