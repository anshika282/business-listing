<!-- views/modals/business_modal.php -->
<div class="modal fade" id="businessModal" tabindex="-1" aria-labelledby="businessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal">

            <div class="modal-header">
                <h5 class="modal-title" id="businessModalLabel">
                    <i class="bi bi-building-add me-2"></i>
                    <span id="modalTitleText">Add Business</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Alert box -->
                <div id="businessAlert" class="alert d-none mb-3" role="alert"></div>

                <input type="hidden" id="businessId" value="">

                <div class="mb-3">
                    <label class="form-label">Business Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="bName" placeholder="e.g. Sunrise Cafe" maxlength="150" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="bAddress" rows="2" required>
                              placeholder="Full address" maxlength="255"></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="bPhone" placeholder="+91 98160 00000" maxlength="10" minlength="10" pattern="\d{10}" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="bEmail" placeholder="hello@business.com" maxlength="100" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" id="saveBusinessBtn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="businessSpinner"></span>
                    <span id="saveBtnText">Save Business</span>
                </button>
            </div>

        </div>
    </div>
</div>