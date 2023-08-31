@props(['between', 'productId', 'isAdmin' => false, 'loanerId' => null, 'disabled' => false, 'wideDisplay'=>false ])

<div class="w-100 m-auto {{!$wideDisplay ? 'border-top input-group' : 'row'}}"
     id="inputCard{{ $productId }}">
    @if($wideDisplay)
        <div class="col-12 col-sm input-group border border-1 border-primary rounded-4 m-2 p-0">
            @endif
            @php($rounded1 = $wideDisplay ? '' : 'rounded-top-0 rounded-end-0')
            <button type="button" class="btn decrease-amount-btn text-primary rounded-4 {{$rounded1}}"
                    aria-label="Verminder hoeveelheid"
                    @if($disabled) disabled
                    @endif dusk="decrease-amount"><i class="bi bi-dash-lg pt-0 pb-0 p-2 fw-bold"></i>
            </button>
            <input type="number" name="products[{{$productId}}][amount]" value="1" min="1"
                   class="form-control amount-input border-0 shadow-none text-center p-0 m-0"
                   id="amount-{{$between}}{{ $productId }}"
                   aria-label="Huidige hoeveelheid:" onclick="updateAriaValue(this)" @if($disabled) disabled @endif >
            @php($rounded2 = $wideDisplay ? 'rounded-4' : 'rounded-0')
            <button type="button" class="btn increase-amount-btn text-primary {{$rounded2}}" aria-label="Verhoog hoeveelheid"
                    dusk="increase-amount"><i
                    class="bi bi-plus-lg pt-0 pb-0 p-2 "></i>
            </button>
            @if($wideDisplay)
        </div>
    @endif

    @if($isAdmin)
        <button type="button" aria-label="Voeg toe aan winkelwagen"
                class="btn btn-dark admin-add-to-cart text-white" data-between="{{$between}}"
                data-product-id="{{ $productId }}"
                data-loaner-id="{{ $loanerId}}" @if($disabled) disabled @endif dusk="add-to-cart-button">
            <x-icons.backpack/>
        </button>

    @else
        @if($wideDisplay)
            <div class="col-12 col-sm m-2 p-0">
                @endif
                <button type="button" aria-label="Voeg toe aan winkelwagen"
                        class="{{$wideDisplay ?'w-100 rounded-4' : 'rounded-0 rounded-start-0 rounded-bottom-4'}} btn btn-warning add-to-cart text-white  "
                        data-between="{{$between}}"
                        data-product-id="{{ $productId }}" @if($disabled) disabled @endif dusk="add-to-cart-button">
                    @if($wideDisplay)<span class="mt-0 mb-0 m-3">Toevoegen</span>@endif<x-icons.backpack/>
                </button>
                @if($wideDisplay)
            </div>
        @endif
    @endif
</div>
