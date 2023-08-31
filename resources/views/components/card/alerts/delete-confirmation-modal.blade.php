@props(['id', 'lang_file', 'action', 'isProduct' => false])

<div class="modal fade" id="deleteConfirmationModal{{$id}}" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel{{$id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel{{$id}}">{{__($lang_file.'delete')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"></button>
            </div>
            <div class="modal-body">{{__($lang_file.'delete_confirm_message')}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">{{__($lang_file.'delete_cancel')}}</button>
                <form action="{{$action}}" method="POST">
                    @csrf
                    @if($isProduct)
                        @method('PATCH')
                        <input type="hidden" name="delete" value="delete">
                    @else
                        @method('DELETE')
                    @endif
                    <button type="submit" class="btn btn-dark">{{__($lang_file.'delete_confirm')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
