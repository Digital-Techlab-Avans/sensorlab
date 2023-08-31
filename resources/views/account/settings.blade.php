@php($lang_file = 'loaner.settings.')

@extends('shared.layout')
@section('content')
    <div class="container">
        <p aria-hidden="true" class="mt-4 mb-2 h2 text-center">{{__($lang_file.'title')}}</p>
        <form action="{{route('settings')}}" method="POST" class="col-12 col-md-8 col-lg-6 m-auto">
            @csrf
            <div class="card mb-3 rounded-3">
                <div class="card-title card-header">
                    <p aria-hidden="true" class="h5 m-0 text-center">{{__($lang_file.'turnin.title')}}</p>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input border-primary" type="checkbox" value="1" name="reminder_7_days"
                               id="reminder_7_days" {{$emailPreferences['reminder_7_days'] ==1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="reminder_7_days">
                            {{__($lang_file.'turnin.oneweek')}}
                        </label>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input border-primary" type="checkbox" value="1"
                               name="reminder_same_day"
                               id="reminder_same_day" {{$emailPreferences['reminder_same_day'] ==1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="reminder_same_day">
                            {{__($lang_file.'turnin.sameday')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="card rounded-3">
                <div class="card-title card-header">
                    <p aria-hidden="true" class="m-0 h5 text-center">{{__($lang_file.'status.title')}}</p>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input border-primary" type="checkbox" value="1"
                               name="approved_or_denied_message"
                               id="approved_or_denied_message" {{$emailPreferences['approved_or_denied_message'] ==1 ? 'checked' : ''}}>
                        <label class="form-check-label" for="approved_or_denied_message">
                            {{__($lang_file.'status.message')}}
                        </label>
                    </div>
                </div>
            </div>

            <div class="text-center m-2 row justify-content-around">
                <input class="btn btn-warning col-12 col-sm-5 m-2 rounded-3" type="submit" name="reset" value="{{__($lang_file.'reset')}}">
                <input class="btn btn-primary col-12 col-sm-5 m-2 rounded-3" type="submit" name="save" value="{{__($lang_file.'save')}}">
            </div>
        </form>
    </div>
@endsection
