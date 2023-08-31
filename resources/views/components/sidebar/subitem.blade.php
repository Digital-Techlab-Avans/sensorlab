@props(['showError' => false, 'name' => 'Lening', 'loan_id' => 0, 'amount', 'due_date' => now(), 'sub_text'=> '', 'sub_text1'=> '', 'status_id'=>'', 'optional_extra'=>''])

@php
    $status_text = '';
    $borderStyle = '';
    if($status_id != '') {
        $borderStyle = 'border-2 ';
         if($status_id == \App\Models\ReturnStatus::getPendingId()) {
             $borderStyle .= 'border-warning';
             $status_text = 'In afwachting';
         }
         elseif($status_id == \App\Models\ReturnStatus::getApprovedId()) {
             $borderStyle .= 'border-success';
             $status_text = 'Goedgekeurd';
         }
         elseif($status_id == \App\Models\ReturnStatus::getRejectedId()) {
            $borderStyle .= 'border-danger';
            $status_text = 'Afgekeurd';
         }
    };
    $lang_file = 'admin.sidebar_subitem.';
@endphp

<div class="row sidebar-sub-item {{$borderStyle}} {{$showError ? 'border-danger border-2' : ''}}">
    <div class="col">
        <div class="text">
            {{$main_text}}
        </div>
        <div class="text text-wrap">
            {{$sub_text}}
        </div>
        <div class="text text-wrap">
            @if($status_text != '')
                Status: {{$status_text}}
            @endif
        </div>
        <div class="text text-wrap">
            {{$sub_text1}}
        </div>
    </div>
    <div class="col-auto">{{$amount}}</div>
    <div class="col-auto">{{$optional_extra}}</div>
</div>


