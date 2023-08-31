@props(['active_loans_dictionary'])

@if(!empty($active_loans_dictionary))

    <div class="text-center"><i>Gesorteerd op de meeste recente lening </i></div>

    @foreach($active_loans_dictionary as $user_id => $loans_list)
        @php
            $total_loans = 0;
            foreach ($loans_list as $loan_item) {
                $total_loans += $loan_item->remainingAmount();
            }
            $loansIsOverdue = array_reduce($loans_list, function($carry, $loan_item) {
        return $carry || $loan_item->isOverdue();}, false);
        @endphp

        <x-sidebar.product.item
            name="{{$loan_item->user->name }}"
            route="{{ route('loaners_details', $user_id) }}"
            headerTotal="{{ $total_loans }}"
            showError="{{$loansIsOverdue}}"
            bodyHeader="Individuele leningen:"
        >
            <x-slot name="body">
                @foreach($loans_list as $item)
                    <x-sidebar.loan-subitem :showError="$item->isOverdue()" name="Lening {{$loan_item->user->name}}"
                                            :loan="$item" :due_date="$item->due_at"
                                            :amount="$item->amount" :editable="true">
                    </x-sidebar.loan-subitem>
                @endforeach
            </x-slot>
        </x-sidebar.product.item>
    @endforeach

@else
    <div class="text-center"><i> Momenteel is dit product niet geleend. </i></div>
@endif

