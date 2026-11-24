(function ($) {
    'use strict';
    $(function () {
        var root = $('#item-mapping-page');
        if (!root.length) return;
        var modal = $('#mapping-modal');
        var form = $('#mapping-form');
        var page = 1;
        var lastPage = 1;
        var query = $('#mapping-query').val();
        var listRequest;
        var editRequest;
        var editingId = null;
        var saving = false;
        var ready = true;
        var fields = ['item_yamaha_label', 'item_supplier', 'item_qad'];

        function notice(target, message, danger) {
            $(target).text(message).toggleClass('d-none', !message)
                .toggleClass('alert-danger', !!danger).toggleClass('alert-success', !danger);
        }
        function errorMessage(xhr, fallback) {
            if (xhr.status === 401 || xhr.status === 419) return 'Sesi berakhir. Muat ulang halaman lalu login kembali.';
            if (xhr.status === 403) return 'Anda tidak memiliki akses untuk operasi ini.';
            return fallback;
        }
        function buttons() {
            $('#mapping-prev').prop('disabled', !!listRequest || page <= 1);
            $('#mapping-next').prop('disabled', !!listRequest || page >= lastPage);
        }
        function load(targetPage) {
            if (listRequest) listRequest.abort();
            $('#mapping-results').attr('aria-busy', 'true');
            listRequest = $.ajax({url: root.data('list-url'), data: {q: query, page: targetPage}, dataType: 'json', timeout: 30000})
                .done(function (result) {
                    if (!Array.isArray(result.data)) {
                        notice('#mapping-notice', 'Respons mapping tidak valid. Muat ulang halaman.', true);
                        return;
                    }
                    page = result.current_page;
                    lastPage = result.last_page;
                    var body = $('#mapping-rows').empty();
                    result.data.forEach(function (item) {
                        var row = $('<tr>');
                        fields.forEach(function (field) { $('<td>').text(item[field]).appendTo(row); });
                        $('<td>').append($('<button>', {type: 'button', class: 'btn btn-sm btn-outline-primary mapping-edit', text: 'Ubah'})
                            .attr('data-id', item.id).attr('aria-label', 'Ubah mapping ' + item.item_yamaha_label)).appendTo(row);
                        body.append(row);
                    });
                    if (!result.data.length) body.append($('<tr>').append($('<td>', {colspan: 4, class: 'text-center text-muted', text: 'Belum ada mapping yang sesuai.'})));
                    $('#mapping-summary').text((result.from || 0) + '–' + (result.to || 0) + ' dari ' + result.total + ' mapping');
                    $('#mapping-page-number').text(page + ' / ' + lastPage);
                }).fail(function (xhr, status) {
                    if (status !== 'abort') notice('#mapping-notice', errorMessage(xhr, 'Mapping gagal dimuat. Klik Cari untuk mencoba kembali.'), true);
                }).always(function () {
                    listRequest = null;
                    $('#mapping-results').attr('aria-busy', 'false');
                    buttons();
                });
            buttons();
        }
        function clearErrors() {
            notice('#mapping-form-notice', '', true);
            form.find('.is-invalid').removeClass('is-invalid').removeAttr('aria-invalid');
            form.find('.invalid-feedback').text('').removeClass('d-block');
        }
        function resetForm() {
            clearErrors();
            editingId = null;
            ready = true;
            form[0].reset();
            $('#item_supplier').empty().append(new Option('', '', true, true)).trigger('change');
            $('#mapping-modal-title').text('Tambah Mapping Item Number');
            $('#mapping-save').prop('disabled', false).text('Simpan Mapping');
        }
        $('#item_supplier').select2({
            width: '100%', dropdownParent: modal, placeholder: 'Cari nomor item...', allowClear: true,
            ajax: {
                url: root.data('supplier-url'), dataType: 'json', delay: 250, timeout: 30000,
                data: function (params) { return {q: params.term || '', page: params.page || 1}; },
                processResults: function (result) { return result; },
                transport: function (params, success, failure) {
                    var request = $.ajax(params);
                    request.done(success).fail(function (xhr, status) {
                        if (status !== 'abort') notice('#mapping-form-notice', errorMessage(xhr, 'Daftar item gagal dimuat. Coba cari kembali.'), true);
                        failure(xhr);
                    });
                    return request;
                }
            }
        });
        $('#mapping-add').on('click', function () { resetForm(); modal.modal('show'); });
        $('#mapping-search').on('submit', function (event) {
            event.preventDefault(); query = $('#mapping-query').val(); notice('#mapping-notice', '', false); load(1);
        });
        $('#mapping-reset').on('click', function () { $('#mapping-query').val(''); query = ''; notice('#mapping-notice', '', false); load(1); });
        $('#mapping-prev').on('click', function () { if (page > 1) load(page - 1); });
        $('#mapping-next').on('click', function () { if (page < lastPage) load(page + 1); });
        function openEdit(id) {
            if (editRequest || saving) return;
            resetForm();
            ready = false;
            $('#mapping-modal-title').text('Memuat Mapping...');
            $('#mapping-save').prop('disabled', true);
            modal.modal('show');
            editRequest = $.ajax({url: root.data('edit-url').replace('__id__', encodeURIComponent(id)), dataType: 'json', timeout: 30000})
                .done(function (item) {
                    if (!item.id) {
                        notice('#mapping-form-notice', 'Respons mapping tidak valid. Tutup modal dan coba kembali.', true);
                        return;
                    }
                    editingId = item.id;
                    $('#item_yamaha_label').val(item.item_yamaha_label);
                    $('#item_supplier').append(new Option(item.item_supplier, item.item_supplier, true, true)).trigger('change');
                    $('#item_qad').val(item.item_qad);
                    $('#mapping-modal-title').text('Ubah Mapping Item Number');
                    ready = true;
                    $('#mapping-save').prop('disabled', false);
                }).fail(function (xhr, status) {
                    if (status !== 'abort') notice('#mapping-form-notice', errorMessage(xhr, 'Mapping gagal dimuat. Tutup modal dan coba kembali.'), true);
                }).always(function () { editRequest = null; });
        }
        $('#mapping-rows').on('click', '.mapping-edit', function () { openEdit($(this).data('id')); });
        modal.on('hide.bs.modal', function (event) {
            if (saving) { event.preventDefault(); return; }
            if (editRequest) editRequest.abort();
        });
        form.on('submit', function (event) {
            event.preventDefault();
            if (saving || !ready) return;
            clearErrors();
            saving = true;
            $('#mapping-save').prop('disabled', true).text('Menyimpan...');
            $.ajax({
                url: editingId === null ? root.data('create-url') : root.data('update-url').replace('__id__', encodeURIComponent(editingId)),
                method: editingId === null ? 'POST' : 'PUT', data: form.serialize(), dataType: 'json', timeout: 30000
            }).done(function (result) {
                saving = false;
                modal.modal('hide');
                notice('#mapping-notice', result.message, false);
                load(page);
            }).fail(function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    fields.forEach(function (field) {
                        var errors = xhr.responseJSON.errors[field];
                        if (!errors) return;
                        $('#' + field).addClass('is-invalid').attr('aria-invalid', 'true');
                        $('#' + field + '-error').text(errors[0]).addClass('d-block');
                    });
                    notice('#mapping-form-notice', 'Periksa kembali kolom yang ditandai.', true);
                } else notice('#mapping-form-notice', errorMessage(xhr, 'Mapping belum dapat disimpan. Periksa daftar sebelum mencoba kembali.'), true);
            }).always(function () { saving = false; $('#mapping-save').prop('disabled', false).text('Simpan Mapping'); });
        });
        load(1);
        var params = new URLSearchParams(window.location.search);
        if (/^\d+$/.test(params.get('edit') || '')) openEdit(params.get('edit'));
        else if (params.get('create') === '1') $('#mapping-add').trigger('click');
    });
})(jQuery);
