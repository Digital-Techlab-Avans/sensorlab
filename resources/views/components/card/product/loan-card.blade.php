@props(['productName', 'productAmount', 'productId', 'userId' => null, 'route', 'image' => null])

<form method="POST" action="{{ $route }}">
    @csrf
    <div class="w-100">
        <div class="card mb-3 rounded-4 border-primary-subtle">
            <div class="card-body p-2" id="productRow-{{ $productId }}">
                <div class="row align-items-center">
                    <div class="col-2 col-sm-1 order-1 order-sm-0">
                        @if($image)
                            <img src="{{ $image ? $image->getImagePath() : asset('/img/no-image.png') }}"
                                 class="w-100 mt-1 mb-1 m-2"
                                 style="max-width: 10em">
                        @endif
                    </div>
                    <div class="col-12 mt-0 mb-0 m-2 text-start text-sm-start col-sm-6 text-wrap order-0 order-sm-1">
                        <span>{{ $productName }}</span>
                    </div>
                    <div class="col order-2">
                        <div id="input-section-{{ $productId }}" data-productId="{{ $productId }}"
                             class="input-group pt-0 pb-0 p-2 p-sm-0">
                            <button type="button" class="btn decrease-amount-btn text-primary rounded-4"
                                    aria-label="verlaag hoeveelheid"><i class="bi bi-dash-lg pt-0 pb-0 fw-bold"></i>
                            </button>
                            <input type="number" aria-label="Huidige hoeveelheid: 0"
                                   class="form-control amount-input border-0 shadow-none text-center loan-card-input p-0 m-0 fw-bold"
                                   id="amount-{{ $productId }}" type="number" name="products[{{ $productId }}][amount]"
                                   value="{{ $productAmount }}">
                            <input type="hidden" name="id" value="{{ $productId }}" id="user-input{{ $productId }}">
                            <x-form.hidden-field :productId="$productId" :arrayType="'name'" :value="$productName"/>
                            <button type="button" class="btn increase-amount-btn text-primary rounded-4"
                                    aria-label="verhoog hoeveelheid" dusk="verhoog-hoeveelheid"><i
                                    class="bi bi-plus-lg pt-0 pb-0"></i></button>
                            <button type="submit" class="btn btn-warning rounded-4 ml-2 delete-btn text-white"
                                    data-target="{{ $productId }}"
                                    id="deleteButton-{{ $productId }}" aria-label="verwijder product van winkelwagen">
                                <x-icons.trash-icon/>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
