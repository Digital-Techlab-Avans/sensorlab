@props(['returnItem', 'productId' =>1, 'userId' => 1, 'showStatusText' => true])
@php
    $lang_file = 'loaner.returns.';

    $productAmount = $returnItem->pivot->amount;
    $borderStyle = 'border-2 ';
    $statusText = 'Onbekend';
    if ($returnItem->status_id == \App\Models\ReturnStatus::getPendingId()) {
        $borderStyle .= 'border-warning';
        $statusText = __($lang_file.'pending_status');
    } elseif ($returnItem->status_id == \App\Models\ReturnStatus::getApprovedId()) {
        $borderStyle .= 'border-success';
        $statusText = __($lang_file.'approved_status');
    } elseif ($returnItem->status_id == \App\Models\ReturnStatus::getRejectedId()) {
        $borderStyle .= 'border-danger';
        $statusText = __($lang_file.'rejected_status');
    }
    $randomId = rand();
@endphp
<link rel="stylesheet" href="{{ asset('css/return-return-card.css') }}">

<div class="card mt-2 mb-2 {{$borderStyle}}">
    <div class="card-header">
        <div class="row justify-content-between">
            <div class="d-flex w-100">
                <div class="row flex-grow-1">
                    @php($smallScreenColSize = $showStatusText ? 'col-sm-4' : 'col-sm-6')
                    <div class="col-12 {{$smallScreenColSize}} mt-1 mb-0">
                        <b>{{ $returnItem->product->name }}</b> ({{ $productAmount }})
                    </div>
                    <div class="col-12 {{$smallScreenColSize}} mt-1 mb-1">
                        {{date('d-m-Y H:i', strtotime($returnItem->returned_at))}}
                    </div>
                    @if($showStatusText)
                        <div class="col-12 {{$smallScreenColSize}} mt-1 mb-0">
                            Status: {{$statusText}}
                        </div>
                    @endif
                </div>
                <div class="d-flex flex-grow-0 align-self-center">
                    <a class="btn text-toggle {{($returnItem->admin_comment != null || $returnItem->comment != null) ? 'btn-primary' : 'bg-dark-subtle'}}"
                       data-bs-toggle="collapse" data-bs-target="#return-card-{{$returnItem->id}}-{{$randomId}}" aria-expanded="false"
                       aria-controls="return-card-{{$returnItem->id}}">
                        <i class="bi bi-caret-up-fill text-collapsed"></i>
                        <i class="bi bi-caret-down-fill text-expanded"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="collapse" id="return-card-{{$returnItem->id}}-{{$randomId}}">
        <div class="card-body pt-0 pb-0">
            <div class="row">
                @if (!empty($returnItem->comment))
                    <div class="mt-1" id="loaner-comment">
                        <h6>Jouw opmerking:</h6>
                        <p class="mb-1">{{ $returnItem->comment }}</p>
                    </div>
                @endif
                @if(!empty($returnItem->admin_comment))
                    <div class="mt-1" id="loaner-comment">
                        <h6>Admin opmerking:</h6>
                        <p class="mb-1">{{ $returnItem->admin_comment }}</p>
                    </div>
                @endif
                @if(empty($returnItem->admin_comment) && empty($returnItem->comment))
                    <div class="mt-1" id="loaner-comment">
                        <h6>Geen opmerkingen</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

