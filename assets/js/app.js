
$(function () {

    //constants
    const AJAX_BUSINESS = 'ajax/business_ajax.php';
    const AJAX_RATING = 'ajax/rating_ajax.php';
    const RATY_PATH = 'https://cdnjs.cloudflare.com/ajax/libs/raty/2.8.0/images/';
    const businessModal = new bootstrap.Modal($('#businessModal')[0]);
    const ratingModal = new bootstrap.Modal($('#ratingModal')[0]);
    const deleteModal = new bootstrap.Modal($('#deleteModal')[0]);

    //read only
    function initDisplayRaty() {
        $('.raty-display').each(function () {
            const score = parseFloat($(this).data('rating')) || 0;
            $(this).empty().raty({
                readOnly: true,
                score: score,
                half: true,
                path: RATY_PATH,
                starOff: 'star-off.png',
                starOn: 'star-on.png',
                starHalf: 'star-half.png',
            });
        });
    }
    initDisplayRaty();

    //interactive star input for add/update raty modal.
    function initInputRaty(currentScore) {
        $('#ratyInput').empty().raty({
            score: currentScore || 0,
            half: true,
            path: RATY_PATH,
            starOff: 'star-off.png',
            starOn: 'star-on.png',
            starHalf: 'star-half.png',
            click: function (score) {
                $('#ratingValue').val(score);
                $('#ratingValueDisplay').text(parseFloat(score).toFixed(1));
            },
        });
        $('#ratingValueDisplay').text(parseFloat(currentScore || 0).toFixed(1));
        $('#ratingValue').val(currentScore || 0);
    }

    //helpers
    function showToast(message, type) {
        const $toast = $('#appToast');
        $toast.removeClass('toast-success toast-error')
            .addClass(type === 'success' ? 'toast-success' : 'toast-error');
        $('#toastMessage').text(message);
        bootstrap.Toast.getOrCreateInstance($toast[0], { delay: 3000 }).show();
    }


    function showAlert(selector, message, type) {
        $(selector)
            .removeClass('d-none alert-success alert-danger')
            .addClass('alert-' + type)
            .html('<i class="bi bi-' + (type === 'success' ? 'check-circle' : 'exclamation-circle') + ' me-1"></i>' + message);
    }
    function clearAlert(selector) {
        $(selector).addClass('d-none').removeClass('alert-success alert-danger').text('');
    }

    function startSpinner(spinnerId, btnTextId, label) {
        $('#' + spinnerId).removeClass('d-none');
        $('#' + btnTextId).text(label);
    }
    function stopSpinner(spinnerId, btnTextId, label) {
        $('#' + spinnerId).addClass('d-none');
        $('#' + btnTextId).text(label);
    }

    //fn to add row when busines gets adedd
    function buildRow(b, avgRating) {
        const avg = parseFloat(avgRating) || 0;
        return `
        <tr id="row-${b.id}" class="row-new">
            <td class="fw-semibold text-muted serial-number"></td>
            <td class="fw-semibold">${escHtml(b.name)}</td>
            <td class="text-muted small">${escHtml(b.address)}</td>
            <td>${escHtml(b.phone)}</td>
            <td>${escHtml(b.email)}</td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="raty-display" data-rating="${avg}"></div>
                    <span class="rating-badge">${avg.toFixed(1)}</span>
                </div>
            </td>
            <td class="text-end">
                <div class="action-btns">
                    <button class="btn-action btn-rate"
                            data-id="${b.id}"
                            data-name="${escAttr(b.name)}"
                            title="Rate">
                        <i class="bi bi-star-fill"></i>
                    </button>
                    <button class="btn-action btn-edit"
                            data-id="${b.id}"
                            data-name="${escAttr(b.name)}"
                            data-address="${escAttr(b.address)}"
                            data-phone="${escAttr(b.phone)}"
                            data-email="${escAttr(b.email)}"
                            title="Edit">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button class="btn-action btn-del"
                            data-id="${b.id}"
                            data-name="${escAttr(b.name)}"
                            title="Delete">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    }

    //update serial numbers after add/delete
    function updateSerialNumbers() {
        $('#businessTbody tr').each(function (index) {
            $(this).find('.serial-number').text(index + 1);
        });
    }

    /* tiny HTML escapers */
    function escHtml(str) {
        return $('<div>').text(str).html();
    }
    function escAttr(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    //toatl counter of businesss
    function updateCount() {
        $('#totalCount').text($('#businessTbody tr[id^="row-"]').length);
    }

    // add new business
    $('#addBusinessBtn').on('click', function () {
        clearAlert('#businessAlert');
        $('#businessModalLabel').html('<i class="bi bi-building-add me-2"></i><span id="modalTitleText">Add Business</span>');
        $('#businessId').val('');
        $('#bName, #bAddress, #bPhone, #bEmail').val('');
        $('#saveBtnText').text('Save Business');
        businessModal.show();
    });

    //save up/add
    $('#saveBusinessBtn').on('click', function () {
        clearAlert('#businessAlert');

        const id = $('#businessId').val();
        const isEdit = id !== '';
        const action = isEdit ? 'update' : 'add';

        const payload = {
            action: action,
            id: id,
            name: $.trim($('#bName').val()),
            address: $.trim($('#bAddress').val()),
            phone: $.trim($('#bPhone').val()),
            email: $.trim($('#bEmail').val()),
        };

        startSpinner('businessSpinner', 'saveBtnText', isEdit ? 'Updating…' : 'Saving…');
        $('#saveBusinessBtn').prop('disabled', true);

        $.post(AJAX_BUSINESS, payload, function (res) {
            if (res.success) {
                if (isEdit) {
                    // u[pdtaes]
                    const $existing = $('#row-' + res.business.id);
                    $existing.replaceWith(buildRow(res.business, res.avg_rating));
                } else {
                    // add new row
                    $('#noDataRow').remove();
                    $('#businessTbody').prepend(buildRow(res.business, res.avg_rating));
                }
                // Re-init Raty on the new row
                $(`#row-${res.business.id} .raty-display`).each(function () {
                    const score = parseFloat($(this).data('rating')) || 0;
                    $(this).raty({
                        readOnly: true, score, half: true, path: RATY_PATH,
                        starOff: 'star-off.png', starOn: 'star-on.png', starHalf: 'star-half.png'
                    });
                });
                updateCount();
                updateSerialNumbers();
                businessModal.hide();
                showToast(res.message, 'success');
            } else {
                showAlert('#businessAlert', res.message, 'danger');
            }
        }, 'json').fail(function () {
            showAlert('#businessAlert', 'Server error. Please try again.', 'danger');
        }).always(function () {
            stopSpinner('businessSpinner', 'saveBtnText', isEdit ? 'Update Business' : 'Save Business');
            $('#saveBusinessBtn').prop('disabled', false);
        });
    });

    //edit business

    $(document).on('click', '.btn-edit', function () {
        clearAlert('#businessAlert');
        const $btn = $(this);

        $('#businessId').val($btn.data('id'));
        $('#bName').val($btn.data('name'));
        $('#bAddress').val($btn.data('address'));
        $('#bPhone').val($btn.data('phone'));
        $('#bEmail').val($btn.data('email'));
        $('#saveBtnText').text('Update Business');
        $('#businessModal .modal-title').html(
            '<i class="bi bi-pencil-fill me-2"></i>Edit Business'
        );
        businessModal.show();
    });

    /* Reset modal title when hidden */
    $('#businessModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-title').html(
            '<i class="bi bi-building-add me-2"></i>Add Business'
        );
        $('#businessId').val('');
    });

    //delete busines

    $(document).on('click', '.btn-del', function () {
        const $btn = $(this);
        $('#deleteBusinessId').val($btn.data('id'));
        $('#deleteBusinessName').text($btn.data('name'));
        deleteModal.show();
    });

    $('#confirmDeleteBtn').on('click', function () {
        const id = $('#deleteBusinessId').val();
        startSpinner('deleteSpinner', 'confirmDeleteBtn', 'Deleting…');
        $(this).prop('disabled', true);

        $.post(AJAX_BUSINESS, { action: 'delete', id }, function (res) {
            if (res.success) {
                const $row = $('#row-' + id);
                $row.css('transition', 'opacity .3s').css('opacity', 0);
                setTimeout(function () {
                    $row.remove();
                    updateCount();
                    // Show placeholder if table is now empty
                    if ($('#businessTbody tr[id^="row-"]').length === 0) {
                        $('#businessTbody').html(`
                            <tr id="noDataRow">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-building fs-1 d-block mb-2 opacity-25"></i>
                                    No businesses yet. Add your first one!
                                </td>
                            </tr>`);
                    }
                }, 300);
                updateSerialNumbers();
                deleteModal.hide();
                showToast(res.message, 'success');
            } else {
                showToast(res.message, 'error');
            }
        }, 'json').fail(function () {
            showToast('Server error. Please try again.', 'error');
        }).always(function () {
            stopSpinner('deleteSpinner', 'confirmDeleteBtn', 'Delete');
            $('#confirmDeleteBtn').prop('disabled', false);
        });
    });

    //rating modal

    $(document).on('click', '.btn-rate', function () {
        clearAlert('#ratingAlert');
        const $btn = $(this);

        $('#ratingBusinessId').val($btn.data('id'));
        $('#ratingBusinessName').text($btn.data('name'));
        $('#rName, #rEmail, #rPhone').val('');

        initInputRaty(0);

        ratingModal.show();
    });

    // reset raty on closing modal
    $('#ratingModal').on('hidden.bs.modal', function () {
        $('#ratyInput').empty();
        $('#ratingValue').val(0);
        $('#ratingValueDisplay').text('0.0');
        clearAlert('#ratingAlert');
    });

    //submit rating
    $('#submitRatingBtn').on('click', function () {
        clearAlert('#ratingAlert');

        const rating = parseFloat($('#ratingValue').val()) || 0;
        if (rating < 0.5) {
            showAlert('#ratingAlert', 'Please select a star rating.', 'danger');
            return;
        }

        const payload = {
            action: 'submit',
            business_id: $('#ratingBusinessId').val(),
            name: $.trim($('#rName').val()),
            email: $.trim($('#rEmail').val()),
            phone: $.trim($('#rPhone').val()),
            rating: rating,
        };

        startSpinner('ratingSpinner', 'ratingBtnText', 'Submitting…');
        $('#submitRatingBtn').prop('disabled', true);

        $.post(AJAX_RATING, payload, function (res) {
            if (res.success) {
                //upd avg in table w/o refresh
                const $row = $('#row-' + res.business_id);
                const avg = parseFloat(res.avg_rating) || 0;

                // Update badge text
                $row.find('.rating-badge').text(avg.toFixed(1));

                // Re-render Raty stars
                const $ratyDiv = $row.find('.raty-display');
                $ratyDiv.attr('data-rating', avg).empty().raty({
                    readOnly: true,
                    score: avg,
                    half: true,
                    path: RATY_PATH,
                    starOff: 'star-off.png',
                    starOn: 'star-on.png',
                    starHalf: 'star-half.png',
                });

                ratingModal.hide();
                const verb = res.action === 'updated' ? 'updated' : 'submitted';
                showToast('Rating ' + verb + ' successfully!', 'success');
            } else {
                showAlert('#ratingAlert', res.message, 'danger');
            }
        }, 'json').fail(function () {
            showAlert('#ratingAlert', 'Server error. Please try again.', 'danger');
        }).always(function () {
            stopSpinner('ratingSpinner', 'ratingBtnText', 'Submit Rating');
            $('#submitRatingBtn').prop('disabled', false);
        });
    });

    //allow enter key to also save
    $('#businessModal').on('keydown', 'input, textarea', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); $('#saveBusinessBtn').trigger('click'); }
    });
    $('#ratingModal').on('keydown', 'input', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); $('#submitRatingBtn').trigger('click'); }
    });

    // Initialize serial numbers on page load
    updateSerialNumbers();

}); 