@props(['ledger'])

<table class="table">
    <thead>
    <tr>
        <th>Tijd</th>
        <th>Gebruiker</th>
        <th>Actie</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ledger as $transaction)
        @php
            if ($transaction->amount > 0) {
                $amount_str = $transaction->amount . ' geleend';
                $table_class = 'table-danger';
            }
            else {
                $amount_str = (-$transaction->amount) . ' teruggebracht';
                $table_class = 'table-success';
            }
        @endphp
        <tr class="{{ $table_class }}">
            <td>
                @php
                    [$date, $time] = explode(' ', $transaction->moment);
                @endphp
                <span style="font-weight: bold">
                                                {{ $date }}
                                            </span>
                <span style="font-style: italic">
                                                {{ $time }}
                                            </span>
            </td>
            <td>
                <a href="{{route('loaners_details', $transaction->user->id)}}" class="item-link">
                    {{ $transaction->user->name }}
                </a>
            </td>
            <td>
                {{ $amount_str }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
