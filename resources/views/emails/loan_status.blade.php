@php($lang_file = 'email.status.')

    <!DOCTYPE html>
<html>
<head>
    <title>{{ $mailData['title'] }}</title>
</head>
<body>
<h1>{{ $mailData['title'] }}</h1>
<p>{{__($lang_file. 'salutation', ['name' => $mailData['user']->name])}} </p>
@foreach($mailData['returnEntry'] as $returnEntry)
    @php($amount = 0)
    @foreach($returnEntry->loans as $loan)
        @php($amount += $loan->amount)
    @endforeach

    <p>{{__($lang_file. 'message', ['product' => $returnEntry->loans[0]->product->name,  'amount' => $amount, 'status' => $mailData['type']])}}</p>
    @if($returnEntry->admin_comment != null)
        <p>{{__($lang_file. 'comment', ['comment' => $returnEntry->admin_comment])}}</p>
    @endif
@endforeach
<p>{{__($lang_file. 'greeting')}}</p>
<p>{{__($lang_file. 'signature')}}</p>
</body>
</html>
