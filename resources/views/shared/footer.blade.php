@php
    use App\Models\User;
    $user = User::getLoggedInUser();
    $name = $user->name ?? '';
    $lang_file = 'footer.';
@endphp
<link rel="stylesheet" href="{{asset('css/footer.css')}}">
<div class="container mt-5">
    @if ($user == null)
        <div class="row">
            <div class="col-md text-center text-md-center">
                <img src="{{ asset('images/footers/CMD_logo.png') }}" alt="CMD logo" class="footer-img mx-auto d-block"
                    style="width: 220px; height: auto;">
                <div class="footer-line"></div>
            </div>

        </div>
        <div class="row">
            <div class="col-md text-center text-md-center">

                <p class="footer-text">{{ __($lang_file . 'developed_by') }}</p>
            </div>
            <div class="col-md text-center text-md-start">
                <p class="footer-text">{{ __($lang_file . 'questions_about_sensorlab') }}</p>
            </div>
        </div>
    @elseif(!$user->is_admin)
        <div class="footer-line"></div>
        <div class="row align-items-center">
            <div class="col d-flex justify-content-center">
                <img src="{{ asset('images/icons/Sensorlab_logo.png') }}" alt="Image 1" class="footer-img">
            </div>
            <div class="col d-flex justify-content-center">
                <img src="{{ asset('images/footers/CMD_logo.png') }}" alt="CMD logo" class="footer-img">
            </div>
            <div class="col d-flex justify-content-center">
                <img src="{{ asset('images/footers/ATD_logo_kleur.png') }}" alt="Image 3" class="footer-img">
            </div>
        </div>
    @endif
</div>
