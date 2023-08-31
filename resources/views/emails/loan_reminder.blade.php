@php($lang_file = 'email.reminder.')

    <!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['title'] }}</title>
</head>
<body>
<h1>{{ $mailData['title'] }}</h1>
<p>{{__($lang_file. 'salutation', ['name' => $mailData['user']->name])}} </p>

@foreach($mailData['products'] as $loan)
    @php($product = $loan->product)
    @if($mailData['days'] == 1)
        <p>{{__($lang_file. 'messageToday', ['product' => $product->name,  'amount' => $loan->amount])}}</p>

    @else
        <p>{{__($lang_file. 'messageXDays', ['product' => $product->name,  'amount' => $loan->amount, 'days' => $mailData['days'], 'date' => date('d-m-Y H:i',strtotime($loan->due_at))])}}</p>

    @endif
@endforeach
<p>{{__($lang_file. 'greeting')}}</p>
<p>{{__($lang_file. 'signature')}}</p>
</body>
</html>
