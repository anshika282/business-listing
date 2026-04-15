<!-- views/modals/delete_modal.php -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass-modal text-center">

            <div class="modal-body py-4">
                <div class="delete-icon-wrap mb-3">
                    <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                </div>
                <h5 class="fw-bold mb-1">Delete Business?</h5>
                <p class="text-secondary  small mb-0">
                    "<strong id="deleteBusinessName"></strong>" and all its ratings will be permanently removed.
                </p>
                <input type="hidden" id="deleteBusinessId" value="">
            </div>

            <div class="modal-footer justify-content-center border-0 pt-0 pb-4 gap-2">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger px-4" id="confirmDeleteBtn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="deleteSpinner"></span>
                    Delete
                </button>
            </div>

        </div>
    </div>
</div>