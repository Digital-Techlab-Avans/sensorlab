@props(['name' =>"Naam"])
@php($lang_file = 'navbar.')

<div class="row align-items-center justify-content-center">
    <span aria-label="Je bent ingelogd als {{ $name }}"></span>
    <p aria-hidden="true" class="m-1 my-0 h5">{{__($lang_file.'logged_in_user', ['name' => $name])}}</p>
</div>
<form action="{{ route('logout') }}" method="POST" id="logout-form">
    @csrf
    <button type="submit" class="btn btn-dark mt-lg-0 mt-2 me-4">{{__($lang_file.'logout')}}</button>
</form>

