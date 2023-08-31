@props(['title' => 'title',
'buttons' => null,
'badges' => null,
'detailsTitle' => 'Details Title',
'details' => 'Details',
'detailsRight' => null,
'detailsBottom' => null]
)

<div class="container-fluid">
    <div class="row vh-100">
        {{--        Content--}}
        <div class="col">
            <div class="row">
                <div class="d-flex justify-content-between">
                    <p class="h1">
                        {{$title}}
                    </p>
                    @if($badges)
                        <div class="row m-2 w-25 h-50 flex-wrap">
                            {{$badges}}
                        </div>
                    @endif
                    @if($buttons)
                        <div class="m-2">
                            {{$buttons}}
                        </div>
                    @endif
                </div>
                <div>
                    <details open>
                        <summary class="fs-3">{{$detailsTitle}}</summary>
                        <div class="d-flex flex-column flex-lg-row">
                            <div class="col">
                                {{$details}}
                            </div>
                            @if($detailsRight)
                                <div class="col col-lg-5 align-self-center">
                                    {{$detailsRight}}
                                </div>
                            @endif
                        </div>
                    </details>
                    @if($detailsBottom)
                        <div class="row">
                            {{$detailsBottom}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{--        Sidebar--}}
        <div class="col-12 col-md-5 col-xl-4 sidebar">
            {{$right}}
        </div>
    </div>
</div>
