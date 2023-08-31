@props(['productName', 'productAmount', 'productId'])
<div id="hidden-card{{ $productId }}">
    <x-form.hidden-field :productId="$productId" :arrayType="'id'" :value="$productId"/>
    <x-form.hidden-field :productId="$productId" :arrayType="'name'" :value="$productName"/>
    <input type="number" name="products[{{ $productId }}][amount]" value="{{ $productAmount }}"
        class="form-control amount-input text-center col-3" id="hidden-amount-{{ $productId }}">
</div>
