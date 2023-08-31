@props(['returnItem', 'productAmount', 'productId', 'userId', 'userName'])
<div class="card mt-2 mb-2 return-card-{{ $userId }}" id="return-card-{{ $returnItem->id }}"
    data-return-id="{{ $returnItem->id }}">
    <div class="card-header">
        <div class="row justify-content-between text-center">
            <div class="col-10 col-md-10 d-flex align-items-center">
                <a href="{{ route('product_details', $returnItem->loans[0]->product->id) }}"
                    class="item-link fw-bold">{{ $returnItem->loans[0]->product->name }} ({{ $productAmount }})</a>
            </div>

            <div class="col-2 col-md-2 mt-2 mt-md-0">
                <div class="input-group">
                    <button type="button" class="btn btn-dark add-return-comment-btn show-body-btn ms-auto"
                        aria-label="Open commentaar veld" data-product="{{ $productId }}"
                        data-user="{{ $userId }}">
                        <i id="dropdown-icon" class="bi bi-chat-dots-fill"></i>
                        @if ($returnItem->comment != null || $returnItem->comment != '')
                            <span class="badge" id="badge-{{ $productId }}-{{ $userId }}">!</span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 comment-row comment-row-{{ $productId }}-{{ $userId }}"
            id="comment-row-{{ $productId }}-{{ $userId }}" style="display:none">
            @if (!empty($returnItem->comment))
                <div class="mt-3" id="loaner-comment">
                    <h6>Opmerking lener:</h6>
                    <p>{{ $returnItem->comment }}</p>
                </div>
            @endif
            <label for="comment-{{ $productId }}" class="text-left">Eigen Opmerking:</label>
            <textarea aria-label="Typ je commentaar hier in" class="form-control" id="comment-{{ $returnItem->id }}"
                name="comments[{{ $returnItem->id }}]"></textarea>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            <button class="btn btn-danger me-2 reject-return-btn" data-return-id="{{ $returnItem->id }}"
                    data-user-id="{{ $userId }}" data-user-name="{{ $userName }}">{{ __('admin.returns.reject') }}</button>
            <button class="btn btn-success accept-return-btn" data-return-id="{{ $returnItem->id }}"
                data-user-id="{{ $userId }}" data-user-name="{{ $userName }}">{{ __('admin.returns.approve') }}</button>
        </div>
    </div>
</div>
<style>
    .notification {
        background-color: #555;
        color: white;
        text-decoration: none;
        padding: 15px 26px;
        position: relative;
        display: inline-block;
        border-radius: 2px;
    }

    .show-body-btn .badge {
        position: absolute;
        top: -10px;
        right: -10px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }
</style>
