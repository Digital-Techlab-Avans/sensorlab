@php
    use App\Models\User;
    $user = User::getLoggedInUser();
    $name = $user->name ?? '';
    $lang_file = 'navbar.';
    $categories = \App\Models\Category::all();
@endphp

{{-- Define the routes for the admin and the loaner --}}
@php
    $menuItems = [];
    if ($user?->is_admin) {
        $menuItems = [
            [
                'route' => 'product_index',
                'label' => __('products'),
            ],
            [
                'route' => 'loaners_overview',
                'label' => __('loaners'),
            ],
            [
                'route' => 'category_overview',
                'label' => __('categories'),
            ],
            [
                'route' => 'due_dates_overview',
                'label' => __('due_dates'),
            ],
        ];
    } else {
        $menuItems = [
            [
                'route' => 'login',
                'label' => __('overview'),
            ],
            [
                'route' => 'loaning_index',
                'label' => __('all_products'),
            ],
            [
                'route' => 'hand_in',
                'label' => __('return'),
            ],
        ];
    }
@endphp
<script src="{{ asset('/js/alert_toast.js') }}" defer></script>
<script src="{{ asset('/js/cart-badge.js') }}" defer></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        @if ($user != null)
            <button class="navbar-toggler custom-navbar-toggler ps-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span>
                    <x-icons.navbar-hamburger/>
                </span>
            </button>
        @endif
        <a aria-label="ga naar de hoofdpagina" class="navbar-brand d-block d-lg-none m-0" href="/"><img
                src="{{ asset('images/icons/Sensorlab_logo.png') }}" alt="Image 1" class="navbar-img"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="dropdown-divider"></div>
            @if ($user != null)
                <ul class="navbar-nav col-lg-5 mb-2 mb-lg-0 d-flex text-black ">
                    @foreach ($menuItems as $menuItem)
                        <li class="nav-item">
                            <a class="nav-link fw-bold"
                               href="{{ route($menuItem['route']) }}">{{ __($lang_file . $menuItem['label']) }}</a>
                        </li>
                    @endforeach
                    @if(!$user->is_admin)
                        <li class="nav-item dropdown bg-light">
                            <a class="nav-link dropdown-toggle fw-bold .bg-light pb-0" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                {{ __('navbar.categories') }}
                            </a>
                            <ul class="dropdown-menu border-0 .bg-light pt-1" style="background-color: #F8F9FA" aria-labelledby="navbarDropdown">
                                @php($loaningRoute = route('loaning_index'))
                                @foreach($categories->sortBy('name') as $category)
                                    @php($categoryId = $category->id)
                                    <li><a class="dropdown-item"
                                           href="{{ "${loaningRoute}?category=${categoryId}" }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
                <a aria-label="ga naar de hoofdpagina" class="col-lg-2 navbar-brand d-lg-flex justify-content-center d-none" href="/"><img
                        src="{{ asset('images/icons/Sensorlab_logo.png') }}" alt="Image 1" class="navbar-img"></a>
                <div class="dropdown-divider"></div>
                @if ($user->is_admin)
                    <div class="col-lg-5 d-flex justify-content-end">
                    @include('shared.profile', ['name' => $name])
                    </div>
                @endif
            @endif
        </div>
        <div>
            @if ($user != null && !$user->is_admin)
                <a class="navbar-brand text-warning" href="{{ route('account', ['id' => $user->id]) }}"
                   aria-label="profiel" dusk="profiel">
                    <x-icons.user/>
                </a>
                <a class="navbar-brand cart text-warning" href="{{ route('loaning_checkout') }}"
                   aria-label="winkelwagen"
                   dusk="checkout">
                    <x-icons.navbar-backpack/>
                    <span class="badge bg-primary" id="cart-badge" style="display: none"
                          aria-label="Aantal producten in winkelwagen: 0" aria-live="polite"></span>
                </a>
            @endif
        </div>
    </div>
</nav>
<x-card.alerts.alert-toast/>
