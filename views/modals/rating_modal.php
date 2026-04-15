<!-- views/modals/rating_modal.php -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content glass-modal">

            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">
                    <i class="bi bi-star-fill me-2 text-warning"></i>
                    Rate: <span id="ratingBusinessName" class="ms-1 text-accent"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Alert box -->
                <div id="ratingAlert" class="alert d-none mb-3" role="alert"></div>

                <input type="hidden" id="ratingBusinessId" value="">

                <!-- Star Rating Input -->
                <div class="rating-input-wrap mb-4">
                    <label class="form-label mb-2">Your Rating <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                        <div id="ratyInput"></div>
                        <span class="rating-value-display" id="ratingValueDisplay">0.0</span>
                    </div>
                    <input type="hidden" id="ratingValue" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Your Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="rName" placeholder="Full name" maxlength="100">
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="rEmail" placeholder="your@email.com" maxlength="100">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="rPhone" placeholder="+91 98160 00000" maxlength="15">
                    </div>
                </div>

                <div class="mt-3 p-3 rounded info-note">
                    <i class="bi bi-info-circle me-1"></i>
                    Submitting with your email or phone will update your previous rating for this business.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning px-4 fw-semibold" id="submitRatingBtn">
                    <span class="spinner-border spinner-border-sm d-none me-1" id="ratingSpinner"></span>
                    <span id="ratingBtnText">Submit Rating</span>
                </button>
            </div>

        </div>
    </div>
</div>