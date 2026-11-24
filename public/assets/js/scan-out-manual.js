(function ($) {
    'use strict';

    $(function () {
        const $form = $('#manualTreatmentForm');
        if (!$form.length) return;

        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('manualTreatmentModal'));
        const $item = $('#manualTreatmentItem');
        const $error = $('#manualTreatmentError');
        const $submit = $('#manualTreatmentSubmit');
        let submissionId = null;
        let pendingPayload = null;
        let saving = false;

        function showError(message) {
            $error.text(message).removeClass('d-none');
        }

        function newSubmissionId() {
            const bytes = new Uint8Array(16);
            window.crypto.getRandomValues(bytes);
            bytes[6] = (bytes[6] & 15) | 64;
            bytes[8] = (bytes[8] & 63) | 128;
            const hex = Array.from(bytes, b => b.toString(16).padStart(2, '0')).join('');
            return `${hex.slice(0, 8)}-${hex.slice(8, 12)}-${hex.slice(12, 16)}-${hex.slice(16, 20)}-${hex.slice(20)}`;
        }

        function selectOptions() {
            return {
                dropdownParent: $('#manualTreatmentModal'),
                placeholder: 'Pilih item',
                allowClear: true,
                ajax: {
                    url: $form.data('options-url'), dataType: 'json', delay: 300, timeout: 15000,
                    data: params => ({kind: 'items', q: params.term || '', page: params.page || 1}),
                    processResults: data => data,
                    transport: function (params, success, failure) {
                        const request = $.ajax(params);
                        request.done(success).fail(function (xhr) {
                            if (xhr.statusText !== 'abort') showError('Pilihan gagal dimuat. Silakan coba kembali.');
                            failure(xhr);
                        });
                        return request;
                    }
                }
            };
        }

        $item.select2(selectOptions());

        $('#openManualTreatment').on('click', function () {
            if (!submissionId) submissionId = newSubmissionId();
            modal.show();
        });
        $('#manualTreatmentModal').on('hide.bs.modal', function (event) {
            if (saving) event.preventDefault();
        });

        function lockFields(locked) {
            $item.prop('disabled', locked);
            $('.manual-qty-input, #manualTreatmentReason').prop('disabled', locked);
        }

        $form.on('submit', function (event) {
            event.preventDefault();
            if (saving) return;
            $error.addClass('d-none').text('');
            if (!pendingPayload) {
                const qty = $form.find('input[name="manual_treatment_qty"]:checked').val();
                if (!$item.val() || !qty || !$('#manualTreatmentReason').val().trim()) {
                    showError('Item, qty, dan alasan wajib diisi.');
                    return;
                }
                if (!['40', '48', '120'].includes(String(qty))) {
                    showError('Pilih qty 40, 48, atau 120 PCS.');
                    return;
                }
                if (!$form[0].reportValidity()) return;
                pendingPayload = {
                    _token: $form.find('input[name="_token"]').val(), location: 'aaik', submission_id: submissionId,
                    item_number: $item.val(),
                    qty: qty, reason: $('#manualTreatmentReason').val().trim()
                };
            }
            saving = true;
            lockFields(true);
            $submit.prop('disabled', true).attr('aria-busy', 'true').toggleClass('is-saving', true);
            $submit.find('.js-manual-submit-label').text('Menyimpan...');
            $.ajax({
                type: 'POST', url: $form.data('store-url'), data: pendingPayload, dataType: 'json', timeout: 30000,
                headers: {'Accept': 'application/json'},
                success: function (response) {
                    if (!response || !response.success) {
                        showError('Penyimpanan belum terkonfirmasi. Coba simpan kembali dengan form yang sama.');
                        return;
                    }
                    saving = false;
                    pendingPayload = null;
                    submissionId = null;
                    lockFields(false);
                    $form[0].reset();
                    $item.val(null).trigger('change');
                    modal.hide();
                    $(document).trigger('treatment:manual-saved', [response.data]);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        pendingPayload = null;
                        lockFields(false);
                        const errors = xhr.responseJSON && xhr.responseJSON.errors;
                        showError(errors ? Object.values(errors).flat().join(' ') : 'Periksa kembali data input.');
                    } else if (xhr.status === 419) {
                        showError('Sesi form kedaluwarsa. Muat ulang halaman sebelum input kembali.');
                    } else {
                        showError((xhr.responseJSON && xhr.responseJSON.message) || 'Penyimpanan belum terkonfirmasi. Coba simpan kembali dengan form yang sama.');
                    }
                },
                complete: function () {
                    saving = false;
                    $submit.prop('disabled', false).attr('aria-busy', 'false').toggleClass('is-saving', false);
                    $submit.find('.js-manual-submit-label').text(pendingPayload ? 'Coba Lagi' : 'Simpan');
                }
            });
        });
    });
})(jQuery);
