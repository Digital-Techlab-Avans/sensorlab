@props(['title' => 'title',
'method' => 'POST',
'formAction' => null,
'enctype' => 'multipart/form-data',
'left' => 'edit',
'showRight' => true,
'right' => null,
])

<div class="container-fluid">
    <x-situational.session-alert/>
    <div class="row">
        <div class="d-flex">
            <p class="h1 mx-auto mx-lg-0">
                {{$title}}
            </p>
        </div>
        <form method="POST" action="{{$formAction}}" enctype="{{$enctype}}">
            @csrf
            @method($method)
            <div class="d-flex flex-column flex-lg-row">
                <div class="col m-1 mt-0 mb-0">
                    {{$left}}
                </div>
                @if($showRight)
                    <div class="col m-1 mt-0 mb-0 col-lg-5">
                        @if($right)
                            {{$right}}
                        @endif
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
