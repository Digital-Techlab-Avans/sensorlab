@php
    use App\Models\User;
        $user = User::getLoggedInUser();
        $name = $user->name ?? '';
        $counted_return = count($user->returns());

        $lang_file = 'loaner.account.'


@endphp
@extends('shared.layout')
@section('content')
    <x-situational.session-alert :success="'success'"/>
    <div class="row justify-content-center m-0 w-100">
        <div class="bg-primary pt-5 pb-5 p-4 justify-content-center rounded-bottom-4">
            <div class="col-12 col-md-10 m-auto">
                <p aria-hidden="true"
                   class="mb-0 h4 text-center text-white fw-bold">{{__($lang_file.'title', ['name' => $name])}}</p>
                <div class="row align-items-center justify-content-center mt-3">
                    <div class="card col-9 col-lg-5 p-0 m-3 rounded-3">
                        <div class="card-body row">
                            <div class="col text-wrap flex-grow-1 pe-0">
                                <p class="fw-bold row m-0">{{__($lang_file.'hand_in.message_header')}}</p>
                                <p class="row m-0">{{__($lang_file.'hand_in.message')}}</p>
                            </div>
                            <div class="col flex-grow-0 ps-0">
                                <i class="text-warning"><x-icons.hand-in/></i>
                            </div>
                        </div>
                        <a class="btn btn-warning rounded-3 text-white w-100 fw-bold"
                           href="{{ route('hand_in') }}">{{__($lang_file.'hand_in.button')}}</a>
                    </div>
                    <div class="card col-9 col-lg-5 p-0 m-3 rounded-3">
                        <div class="card-body row">
                            <div class="col text-wrap flex-grow-1 pe-0">
                                <p class="fw-bold row m-0">{{__($lang_file.'returns.message_header')}}</p>
                                <p class="row m-0"> {{__($lang_file.'status_returns_message',  ['amount' => $counted_return])}}</p>
                            </div>
                            <div class="col flex-grow-0 ps-0">
                                <i class="text-warning"><x-icons.hand-in-status/></i>
                            </div>
                        </div>
                        <a class="btn btn-warning rounded-3 text-white w-100 fw-bold"
                           href="{{ route('loaner_returns') }}">{{__($lang_file.'status_returns_button')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a class="text-white rounded-3 btn btn-info mt-lg-0 mt-2 col-9 col-md-6 fw-bold"
               href="{{ route('settings') }}">{{__($lang_file.'settings.button')}}</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-flex justify-content-center mt-3">
            @csrf
            <button type="submit"
                    class="btn btn-primary rounded-3 mt-lg-0 mt-2 col-9 col-md-6 fw-bold">{{__($lang_file.'logout')}}</button>
        </form>
    </div>
@endsection
