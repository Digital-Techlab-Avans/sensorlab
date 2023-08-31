@props(['name', 'route', 'isAssigned' => false, 'productId', 'category'])
<div class="card sidebar-item product-card" data-product-name="{{ $name }}" id="product-card-{{ $productId }}">
    <div class="card-header row main-item">
        <div class="col">
            <div class="fw-bold">
                <a href="{{ $route }}" class="item-link">
                    {{ $name }}
                </a>
            </div>
        </div>
        @if ($isAssigned)
            <div class="col-2 align-self-center text-center">
                <button class="btn btn-dark delete-btn" id="delete-btn-{{ $productId }}"
                    data-product-id="{{ $productId }}" data-category-id="{{ $category->id }}">
                    <x-icons.trash-icon />
                </button>
            </div>
        @else
            <div class="col-2 align-self-center text-center">
                <button class="btn btn-dark add-btn" data-product-id="{{ $productId }}"
                    data-category-id="{{ $category->id }}">
                    +
                </button>
            </div>
        @endif
    </div>
</div>
