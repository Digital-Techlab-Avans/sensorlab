@props(['lang_file', 'loaners'])
<div class="d-flex justify-content-center tab-pane">
    <div class="overflow-hidden table-responsive m-3" style="width: min(100%, 75em)">
        <table id="loaner_table" class="table table-hover table-striped dt-responsive ml-lg-5 mr-lg-5 loaner_table" style="width: 100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Archived</th>
                <th>{{__($lang_file.'name')}}</th>
                <th class="d-none d-lg-table-cell">{{__($lang_file.'email')}}</th>
                <th class="d-none d-sm-table-cell">{{__($lang_file.'currently_loaned')}}</th>
                <th class="d-none d-md-table-cell">{{__($lang_file.'too_late_returned')}}</th>
                <th class="d-none d-lg-table-cell"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($loaners as $loaner)
                <tr>
                    <td>
                        {{$loaner->id}}
                    </td>
                    <td>
                        {{ $loaner->active() ? 'true' : 'false' }}
                    </td>
                    <td style="width: 20%">
                        <a class="text-decoration-none text-dark"
                           href="{{route("loaners_details", ['id'=> $loaner->id])}}">
                            {{$loaner->name}}
                        </a>
                    </td>
                    <td class="d-none d-lg-table-cell" style="width: 30%">
                        {{$loaner->email}}
                    </td>
                    <td aria-description="producten momenteel geleend"
                        class="d-none d-sm-table-cell">{{$loaner->totalCurrentlyLoanedAmount() ?? "0"}}</td>
                    <td aria-description="producten te laat ingeleverd"
                        class="d-none d-md-table-cell {{$loaner->totalOverDueAmount() > 0 ? 'text-danger' : ''}}">{{$loaner->totalOverDueAmount()}}</td>
                    <td class="d-none d-lg-table-cell" aria-hidden="true" style="width: 10%">
                        <a aria-label="open details van {{$loaner->name}}"
                           href="{{route("loaners_details", ['id'=> $loaner->id])}}"
                           class="btn btn-dark">{{__($lang_file.'details')}}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>