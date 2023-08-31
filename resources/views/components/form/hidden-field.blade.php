@props(['productId', 'arrayType', 'value'])
<input type="hidden" id="hiddenInput" name="products[{{ $productId }}][{{ $arrayType }}]" value="{{ $value }}">
