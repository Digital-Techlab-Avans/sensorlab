@props(['loan', 'due_date', 'amount', 'editable' => true, 'name' => 'Lening', 'showError' => false])
@php
    $lang_file = 'admin.sidebar_loan.';
    $loan_id = $loan->id;
@endphp
<x-sidebar.subitem :showError="$showError" :name="$name" :loan_id="$loan_id" :due_date="$due_date" :amount="$amount"
                   :editable="$editable">
    <x-slot name="main_text">
        Van: {{date('d-m-Y', strtotime($loan->loaned_at))}},
        Tot: {{date('d-m-Y', strtotime($loan->due_at))}}
    </x-slot>
    <x-slot name="optional_extra">
        @if($editable)
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" role="button" data-bs-toggle="modal"
                           data-bs-target="#dueDateModal{{-$loan_id}}">{{__($lang_file.'edit')}}</a></li>
                </ul>
            </div>
        @endif
    </x-slot>
</x-sidebar.subitem>

{{-- This modal opens when pressing the edit button for a loan --}}
<x-situational.modal modalId="dueDateModal-{{ $loan_id }}" formAction="{{ route('loan.update', $loan_id) }}"
                     title="{{ $name ?? 'Lening' }}">
    <x-slot name="body">
        <label for="due_date" class="form-label">{{__($lang_file.'new_due_date')}}</label>
        <x-interactive.datetimepicker-flatpickr name="due_date" :button_id="'due_date-'.$loan_id"
                                                :input_id="'due-date-'.$loan_id"
                                                :value="$due_date ?? strtotime('d-m-Y H:i', $due_date)"></x-interactive.datetimepicker-flatpickr>
        <label for="amount" class="form-label">{{__($lang_file.'new_amount')}}</label>
        <x-form.basic-input name="amount" type="number" :min="1" :value="$amount"
                            placeholder="Geef een getal vanaf 1"></x-form.basic-input>
    </x-slot>
    <x-slot name="footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__($lang_file.'cancel')}}</button>
        <button type="submit" class="btn btn-primary">{{__($lang_file.'save')}}</button>
    </x-slot>
</x-situational.modal>
