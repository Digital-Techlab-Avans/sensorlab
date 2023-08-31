@extends('shared.layout')
@section('content')
    @php($lang_file = 'admin.categories_overview.')
    @php($categories_text = __($lang_file.'page_header'))
    <x-layout.page-top :title="$categories_text">
        <a href="{{route('category_create')}}">
            <div class="btn text-light bg-primary">{{__($lang_file.'create')}}</div>
        </a>
    </x-layout.page-top>
    <div class="d-flex justify-content-center">
        <div class="m-4 overflow-hidden" style="width: min(100%, 60em)">
            <table id="category_table" class="table table-striped table-hover dt-responsive  ml-lg-5 mr-lg-5">
                <thead>
                <tr>
                    <th hidden>ID</th>
                    <th>{{__($lang_file.'name')}}</th>
                    <th class="d-none d-lg-table-cell"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr class="{{$category->archived ? 'text-muted' : ''}}">
                        <td hidden>{{$category->id}}</td>
                        <td>
                            <a aria-label="open details van {{ $category->name }}" href="{{route("category_details", ['category' => $category])}}"
                               class="text-decoration-none text-dark">
                                {{$category->name}}
                            </a>
                        </td>
                        <td class="d-none d-lg-table-cell" aria-hidden="true">
                            <a   aria-label="open details van {{ $category->name }}" href="{{route("category_details", ['category' => $category])}}"
                                 class="btn {{$category->archived ? 'btn-secondary' : 'btn-dark'}}">
                                {{__($lang_file.'details')}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const DETAIL_COLUMN_INDEX = 4;

        dataTableConfig.orderCellsTop = true;
        dataTableConfig.columns = [
            {
                width: '2em',
            },
            {},
            {
                sortable: false,
                searchable: false,
            },
        ];
        dataTableConfig.initComplete = function () {
            globalThis.table = this;
        };

        let table = new DataTable('#category_table', dataTableConfig);
    </script>
@endsection
