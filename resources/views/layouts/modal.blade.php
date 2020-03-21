<div class="modal fade" id="confirm-action" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @yield("modal-title")
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @yield("modal-body")
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"onclick="@yield('modal-action-cancel')">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="@yield('modal-action-confirm')">Confirm</button>
            </div>
        </div>
    </div>
</div>
