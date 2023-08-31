@extends('shared.login_layout')
@section('content')
    @php($lang_file = 'login.')

    <x-situational.session-alert/>

    <div class="text-center">
        <div class="pt-5 pt-md-0">
            <p class="h6 fw-bolder mb-0">{{__($lang_file.'login_header')}}</p>
            <img src="{{ asset('images/icons/Sensorlab_logo.png') }}" alt="Image 1" class="footer-img">
        </div>

        <form action="{{ route('login_proccess') }}" method="POST" class="mx-auto mt-5">
            @csrf
            <div class="col-10 col-sm-8 col-md-6 col-lg-4 m-auto">
                <input dusk="email" type="email" class="form-control bg-light" id="email" name="email"
                       value="{{old('email', "")}}"
                       placeholder="{{__($lang_file.'email_placeholder')}}">
                <x-situational.error-message error="email"></x-situational.error-message>

                @if(session()->pull('password'))
                    <input type="password" class="form-control bg-light mt-3" id="password" name="password"
                           placeholder="{{__($lang_file.'password')}}" required>
                    <x-situational.error-message error="password"></x-situational.error-message>
                @endif

                <br>
                <button dusk="login_button" type="submit"
                        class="btn btn-primary fw-bold w-100">{{__($lang_file.'login_button')}}</button>
            </div>

        </form>
    </div>
    </body>
    </html>
@endsection
