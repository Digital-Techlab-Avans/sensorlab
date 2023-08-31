@props(['due_dates' => [], 'empty_message' => 'Er zijn geen eindtermijnen', 'delete_button' => true, 'lang_file'])

@php($active_due_date = \App\Models\DueDate::activeDueDate())
@if(isset($due_dates) && count($due_dates) > 0)
    @foreach($due_dates as $due_date)
        @php($isActive = $due_date->id == $active_due_date?->id)
        <div class="card mb-2 {{ $isActive ? 'border-3 border-success' : ''}} ">
            <div class="row card-body">
                <div class="col flex-grow-1">
                    <p class="card-text m-2">
                        @php($due_date_date = date('d-m-Y H:i', strtotime($due_date->due_date)))
                        Eindtermijn: {{$due_date_date}} {{ $isActive ? '(Actief)' : ''}}
                    </p>
                </div>
                @if($delete_button)
                    <div class="col flex-grow-0">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal{{$due_date->id}}"><x-icons.trash-icon></x-icons.trash-icon></button>
                    </div>
                @endif
            </div>
        </div>

        <x-card.alerts.delete-confirmation-modal :id="$due_date->id" :lang_file="$lang_file" :action="route('due_dates_delete', ['id'=>$due_date->id])"/>

    @endforeach
@else
    <p class="text-center">{{$empty_message}}</p>
@endif
