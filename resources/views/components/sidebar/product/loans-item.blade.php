@props(['activeLoans'])

<div class="text-center"><i>Gesorteerd op de meeste recente lening</i></div>
@foreach($activeLoans as $product_id => $loanArray)
    @php
        $totalLoans = 0;
        foreach ($loanArray as $loan) {
            $totalLoans += $loan->remainingAmount();
        }
        $loansIsOverdue = array_reduce($loanArray, function($carry, $loan) {
        return $carry || $loan->isOverdue();}, false);
    @endphp
    <x-sidebar.product.item
        :name="$loanArray[0]->product->name"
         route="{{ route('product_details', $product_id)}}"
        :headerTotal="$totalLoans"
        :showError="$loansIsOverdue"
        :bodyHeader="'Individuele leningen:'"
    >
        <x-slot name="body">
{{--            Show all the loan items--}}
            @foreach($loanArray as $loan)
                <x-sidebar.loan-subitem :showError="$loan->isOverdue()" name="{{$loanArray[0]->product->name}} lening" :loan="$loan" :due_date="$loan->due_at" :amount="$loan->remainingAmount()" :editable="true">
                </x-sidebar.loan-subitem>
            @endforeach
        </x-slot>
    </x-sidebar.product.item>
@endforeach





