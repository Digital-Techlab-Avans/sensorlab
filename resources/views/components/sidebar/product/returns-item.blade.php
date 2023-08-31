@props(['returns'])

<div class="text-center"><i>Gesorteerd op de meest recente inlevering</i></div>
@foreach($returns as $return)
    @php
        $totalLoans = 0;
        foreach ($return as $returnItem) {
            $totalLoans += $returnItem->pivot->amount;
        }
    @endphp
    <x-sidebar.product.item
        :name="$return[0]->product->name"
         route="{{ route('product_details', $return[0]->product->id)}}"
        :headerTotal="$totalLoans"
        :bodyHeader="'Individuele inleveringen:'"
    >
        <x-slot name="body">
            {{--            Show all the return items--}}
            @foreach($return as $returnItem)
                <x-sidebar.subitem :amount="$returnItem->pivot->amount" :status_id="$returnItem->status_id">
                    <x-slot name="main_text">
                        Ingeleverd: {{date('d-m-Y', strtotime($returnItem->returned_at))  }}
                    </x-slot>
                    <x-slot name="sub_text">
                        @if($returnItem->comment)
                            Opmerking: <i>{{$returnItem->comment}}</i>
                        @endif
                    </x-slot>
                    <x-slot name="sub_text1">
                        @if ($returnItem->admin_comment)
                            Admin Opmerking: <i>{{$returnItem->admin_comment}}</i>
                        @endif
                    </x-slot>
                </x-sidebar.subitem>
            @endforeach
        </x-slot>
    </x-sidebar.product.item>
@endforeach
