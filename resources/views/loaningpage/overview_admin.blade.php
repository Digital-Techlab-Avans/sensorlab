@extends('shared.layout')
@section('content')
    @props([
        'products',
        'categories',
        'sort_columns',
        'sort',
        'order',
        'loaner',
        'added_products'
    ])
    @php
        $lang_file = 'admin.loan_for_loaner.'
    @endphp

    <script src="{{ asset('/js/button.js') }}" defer></script>
    <script src="{{ asset('/js/submitCart.js') }}" defer></script>
    <script src="{{ asset('/js/nav_tabs.js') }}" defer></script>
    <x-situational.session-alert/>

    <div class="container">

        <div class="mt-3">
            <div class="mx-auto">
                <div class="col-11 mb-2">
                    <h1>{{__($lang_file.'page_header', ['name' => $loaner->name])}}</h1>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs flex-column flex-sm-row text-center" role="tablist">
            <li class="nav-item flex-sm-fill" role="presentation">
                <a class="nav-link active" id="lening-opstellen-tab" aria-label="tab" data-bs-toggle="tab"
                   href="#lening-opstellen"
                   role="tab" aria-controls="lening-opstellen" aria-selected="true" tabindex="0">{{__($lang_file.'create_loan_cart_tab')}}</a>
            </li>

            <li class="nav-item flex-sm-fill" role="presentation">
                <a class="nav-link" id="lening-bevestigen-tab" data-bs-toggle="tab" href="#lening-bevestigen" role="tab"
                   aria-controls="lening-bevestigen" aria-selected="false" tabindex="-1" dusk="lening-bevestigen">{{__($lang_file.'submit_loan_cart_tab')}}</a>
            </li>
        </ul>

        {{--        first tab--}}

        <div class="tab-content" id="myTabsContent">
            <div class="tab-pane fade show active" id="lening-opstellen" role="tabpanel"
                 aria-labelledby="lening-opstellen-tab">

                <x-form.search-product :categories="$categories" :sort_columns="$sort_columns" :sort="$sort"
                                       :order="$order"/>

                <div class="overflow-auto" style="max-height: 65vh">
                    <x-list.product.list-view :products="$products" :hide="false" isAdmin="true"
                                              :loanerId="$loaner->id"/>
                </div>

                @if($products->count() == 0)
                    <p class="text-center">{{__($lang_file.'create_loan_cart_tab_empty_message')}}</p>
                @endif
            </div>


            {{--        second tab--}}

            <div class="tab-pane fade" id="lening-bevestigen" role="tabpanel"
                 aria-labelledby="lening-bevestigen-tab">

                @if (!$added_products == null)
                    <p class="h3 mb-3 mt-3 text-center fw-bold text-decoration-underline">{{__($lang_file.'selected_products')}}</p>
                    <div class="overflow-auto" style="max-height: 72vh">
                        @foreach ($added_products as $product)
                            <x-card.product.loan-card :productName="$product['name']"
                                                      :productAmount="$product['amount']"
                                                      :productId="$product['id']" :userId="$loaner->id"
                                                      :route="route('loaners_product_delete', ['userId' => $loaner->id])"/>
                        @endforeach
                    </div>


                    <form method="POST" action="{{ route('loaners_loaning_store', ['id' => $loaner->id]) }}"
                          style="display: none" id="all-products">
                        @csrf
                        @foreach ($added_products as $product)
                            <x-form.hidden-loan-card :productName="$product['name']" :productAmount="$product['amount']"
                                                     :productId="$product['id']" :product="$product"/>
                        @endforeach
                    </form>

                    <div class=" text-center mt-4">
                        <div class="row justify-content-center">
                            <div class="card col-10 col-sm-6 mb-2 p-2 border-warning">
                                @php
                                    $activeDueDate = \App\Models\DueDate::activeDueDate() ?? \App\Models\DueDate::defaultDueDate();
                                    $date = date('d-m-Y',strtotime($activeDueDate->due_date));
                                @endphp
                                <p class="m-0">{{__($lang_file.'return_date_message', ['date' => $date])}}</p>
                            </div>
                        </div>
                        <a href="{{ route('loaners_details', ['id' => $loaner->id]) }}"
                           class="btn btn-outline-dark me-3">{{__($lang_file.'cancel')}}</a>

                        <button type="button" onclick="submitForm()" class="btn btn-dark" dusk="lening-verzenden">{{__($lang_file.'confirm')}}</button>
                    </div>

                @else
                    <div class="row justify-content-center align-items-center pt-4 text-center">
                        <div class="col-12 col-sm-5">
                            <p class="h3 mb-3 mt-3 text-center fw-bold ">{{__($lang_file.'loan_cart_tab_empty_message')}}</p>
                            <a href="{{ route('loaners_details', ['id' => $loaner->id]) }}"
                               class="btn btn-outline-dark me-3">{{__($lang_file.'return')}}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection


