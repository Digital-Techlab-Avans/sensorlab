@props(['products', 'hide' => true, 'isAdmin' => false, 'loanerId' => null, 'secure_product_text' => 'Beveiligd product, klik voor meer informatie'])

<div class="container col-md-9" id="listView" style="{{ $hide ? 'display:none' : '' }}">
    <div class="container mb-10 col-md-9">
        <div id="productList">
            @foreach ($products as $product)
                @php
                    $productId = $product->id;
                    $productName = $product->name;
                @endphp
                <div class="card-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <a href="{{ route('product_loaner_details', ['product' => $productId]) }}"
                               class="text-decoration-none link-dark">
                                <p>
                                    {{ $productName }}
                                    @if($product->is_secured && $isAdmin)
                                        <span class="fw-bold fst-italic">(Beveiligd)</span>
                                    @endif
                                </p>
                            </a>
                        </div>
                        <div class="col">
                            @if ($product->is_secured && !$isAdmin)
                                <p class="fst-italic ">{{$secure_product_text}}</p>
                            @else
                                <x-interactive.amount-input between="list-" :productId="$productId" :isAdmin="$isAdmin"
                                                            :loanerId="$loanerId"/>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

