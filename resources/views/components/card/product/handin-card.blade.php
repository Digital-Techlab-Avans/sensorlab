@props(['loanArray', 'productAmount', 'productId', 'image' => null])

<div class="mb-10 w-100">
    <div class="card mb-3 rounded-4 border-primary-subtle">
        <div class="card-body p-2">
            <div class="row align-items-center">
                <div class="col-2 col-sm-1 order-1 order-sm-0">
                    @if($image)
                        <img src="{{ $image ? $image->getImagePath() : asset('/img/no-image.png') }}"
                             class="w-100 mt-1 mb-1 m-2"
                             alt="product image" style="max-width: 10em">
                    @endif
                </div>
                <div class="col-12 mt-0 mb-0 m-2 text-start text-sm-start col-sm-6 text-wrap order-0 order-sm-1">
                    <span>{{ $loanArray[0]->product->name }} ({{ $productAmount }})</span>
                </div>
                <div class="col order-2">
                    <div class="input-group pt-0 pb-0 p-2 p-sm-0">
                        <button type="button" class="btn decrease-amount-btn text-primary rounded-4"
                                aria-label="verlaag hoeveelheid"><i class="bi bi-dash-lg pt-0 pb-0 fw-bold"></i>
                        </button>
                        <input type="number" aria-label="Huidige hoeveelheid: 0" onclick="updateAriaValue(this)"
                               class="form-control amount-input border-0 shadow-none text-center p-0 m-0 fw-bold"
                               id="amount-{{ $productId }}" name="amounts[{{$productId}}]" value="0"
                               data-product-id="{{ $productId }}" max="{{$productAmount }}">
                        <button type="button" class="btn increase-amount-btn text-primary rounded-4"
                                aria-label="verhoog hoeveelheid" dusk="verhoog-hoeveelheid"><i
                                class="bi bi-plus-lg pt-0 pb-0"></i></button>
                        <button type="button" class="btn btn-warning rounded-4 add-comment-btn ml-2"
                                aria-label="Open commentaar veld"
                                data-target="{{ $productId }}" dusk="open-comentaar-veld">
                            <i id="dropdown-icon" class="bi bi-chat-dots-fill text-white"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 comment-row" id="comment-row-{{ $productId }}" style="display:none">
                    <label for="comment-{{ $productId}}" class="text-left text-primary fst-italic">Opmerking:</label>
                    <textarea aria-label="Typ je commentaar hier in" class="form-control bg-light"
                              id="comment-{{$productId }}" name="comments[{{ $productId }}]"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
