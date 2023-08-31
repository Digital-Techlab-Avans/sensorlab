@extends('shared.layout')
@props(['returnsByUser'])
@section('content')
    <script src="{{ asset('/js/returns.js') }}" defer></script>

    @php
        $lang_file = 'admin.'
    @endphp

    <p class="text-center mt-4 h1">{{__($lang_file.'dashboard')}}</p>
    <div class="d-flex flex-wrap flex-md-nowrap flex-column-reverse flex-md-row">
        <div class="col-12 col-md-5">
            <div class="container">
                <p class="mb-4 h4 text-center">{{__($lang_file.'returns.all_to_approve')}}</p>
                @foreach ($returnsByUser as $userId => $returns)
                    @php
                        $user = $returns[0]->loans[0]->user;
                        $totalAmount = 0;
                        foreach ($returns as $return) {
                            $totalAmount += $return->total_amount;
                        }
                        $amountOfReturns = count($returns);
                    @endphp
                    <div class="card mb-3 border-secondary user-card" id="user-card-{{ $userId }}">
                        <div class="card-header d-flex justify-content-between">
                            <a href="{{ route('loaners_details', $userId) }}"
                               class="h5 m-0 item-link text-decoration-none">{{ $user->name }}</a>
                            <div class="d-flex align-items-center">
                                <div class="me-3">{{__($lang_file.'returns.total').': ' . $totalAmount }}</div>
                                <button type="button" class="btn btn-dark open-user-card show-body-btn"
                                        aria-label="Open gebruiker {{ $user->name }}" data-user="{{ $userId }}">
                                    <i id="dropdown-icon" class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body pb-2 pt-2">
                            <h6>{{__($lang_file.'returns.returned_products')}}:</h6>
                            @foreach ($returns as $return)
                                <x-card.product.return-card :returnItem="$return" :productAmount="$return->total_amount"
                                                            :productId="$return->loans[0]->product->id"
                                                            :userId="$user->id" :userName="$user->name"/>
                            @endforeach
                        </div>

                        @if ($amountOfReturns > 1)
                            <div class="card-footer all-buttons-{{ $user->id }}">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-danger reject-all-btn  me-2" data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">{{__($lang_file.'returns.reject_all')}}
                                    </button>
                                    <button class="btn btn-success approve-all-btn" data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}">{{__($lang_file.'returns.approve_all')}}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                <div class="no-returns text-center" style="display: none">
                    <p>{{__($lang_file.'returns.no_items')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="col-12 col-md-5">
            <div class="d-flex w-100">
                <div class="container">
                    <div class="card m-2 row pt-2 pb-2">
                        <div class="d-flex mb-1">
                            <div class="col">
                                <p class="m-0">{{__($lang_file.'due_date.current')}}:</p>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <a href="{{ route('due_dates_overview') }}" class="text-decoration-none">{{__($lang_file.'due_date.see_all')}}</a>
                            </div>
                        </div>
                        <div class="d-flex w-100">
                            @php($active_due_date = \App\Models\DueDate::activeDueDate())
                            @if ($active_due_date)
                                <div class="card border-success w-100 p-2">
                                    @php($days_left = \Carbon\Carbon::now()->diffInDays($active_due_date->due_date, false) + 1)
                                    <p class="m-0">{{ date('d-m-Y H:i', strtotime($active_due_date->due_date)) }}
                                        - <i>nog {{ $days_left }} {{ $days_left == 1 ? 'dag' : 'dagen' }}</i></p>
                                </div>
                            @else
                                <div class="card border-danger w-100 p-2">
                                    <p class="m-0">{{__($lang_file.'due_date.no_due_date')}}</p>
                                    <p class="m-0">{{__($lang_file.'due_date.default_period', ['weeks' => \App\Models\DueDate::defaultAmountOfWeeks()])}}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
