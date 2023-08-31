@props(['returns_dictionary'])

@if(!empty($returns_dictionary))
    <div class="text-center"><i>Gesorteerd op de meest recente inlevering</i></div>

    @foreach($returns_dictionary as $user_id => $returns_list)
        @php
            $total_returns = 0;
            foreach ($returns_list as $return_item) {
                $total_returns += $return_item->amount;
            }
        @endphp
        <x-sidebar.product.item
            name="{{ $return_item->name }}"
            route="{{ route('loaners_details', $user_id) }}"
            headerTotal="{{$total_returns}}"
            showError=""
            bodyHeader="Individuele leningen:"
        >
            <x-slot name="body">
                @foreach($returns_list as $item)
                <x-sidebar.subitem :amount="$item->amount" :status_id="$item->status_id">
                    <x-slot name="main_text">
                        Ingeleverd: {{date('d-m-Y', strtotime($item->returned_at))  }}
                    </x-slot>
                    <x-slot name="sub_text">
                        @if($item->comment)
                            Opmerking: <i>{{$item->comment}}</i>
                        @endif
                    </x-slot>
                    <x-slot name="sub_text1">
                        @if ($return_item->admin_comment)
                            Admin Opmerking: <i>{{$return_item->admin_comment}}</i>
                        @endif
                    </x-slot>
                </x-sidebar.subitem>
                @endforeach
            </x-slot>
        </x-sidebar.product.item>
    @endforeach

@else
    <div class="text-center"><i> Momenteel is dit product niet ingeleverd. </i></div>
@endif
