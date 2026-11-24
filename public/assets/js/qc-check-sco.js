
function gantiQty(identifier){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var po          = $(identifier).data('po');
    var qty_lpb     = $(identifier).data('qty-lpb');
    var ps          = $(identifier).data('ps');
    var item        = $(identifier).data('item');
    var index       = $(identifier).data('index');
    var line        = $(identifier).data('line');
    var qty         = $(identifier).data('qty');
    var newqty      = $(identifier).val();

    var lpb_code    = $('#lpb_code').val();

    let qty_baru = parseFloat(newqty);
    let qty_open = parseFloat(qty_lpb);

    if(qty_baru > qty_open){
        Swal.fire({
            icon: 'warning',
            title: 'Maaf',
            text: 'Qty NG tidak boleh lebih besar dari Qty SJ',
        });

        $(identifier).val(0);

        return true;
    }

    let afterQc = parseFloat(qty_open) - parseFloat(qty_baru);
    $('#afterQc'+index).html(afterQc);

    getLoader();
    $.ajax({
        url: "/qc-check/change-qty",
        type: "POST",
        data: {
            _token: CSRF_TOKEN,
            po:po,
            ps:ps,
            item:item,
            qty_lpb:qty_lpb,
            line:line,
            qty:qty,
            lpb_code:lpb_code,
            newqty:newqty,
        },
        async: true,
        success: function(response) {
            if(response.status == 200){
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: response.message,
                });
                var qtyto = Number(qty_baru);
                if(qtyto === 0){
                    setTimeout(() => {
                        location.reload();
                    }, 100);
                }
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon Maaf',
                    text: response.message,
                }).then(function(){
                    $(identifier).val(qty);
                });
            }
        },error:function(){
            Swal.fire({
                icon: 'error',
                title: 'Mohon maaf',
                text: 'Server Error',
            });
        }
    });
}

function cekPoAdditional(identifier){

    var open_qty    = $(identifier).data('open_qty');
    var newqty      = $(identifier).val();

    let qty_baru = parseFloat(newqty);
    let qty_open = parseFloat(open_qty);

    if(qty_baru > qty_open){
        Swal.fire({
            icon: 'warning',
            title: 'Maaf',
            text: 'Qty LPB tidak boleh lebih besar dari Qty Open',
        });

        $(identifier).val('');

        return true;
    }
}

$('#inputForm').on('keydown', 'input', function (event) {
    if (event.which == 13) {
        event.preventDefault();
        var $this = $(event.target);
        var index = parseFloat($this.attr('data-index'));
        let jumlahData = Number($('#jumlahData').val());
        console.log(index);
        console.log(jumlahData);

        if(index === jumlahData){
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah kamu yakin ingin approve tabcode ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Approve'
            }).then((result) => {
                if (result.isConfirmed) {
                    verification();
                }
            })
        }

        $('[data-index="' + (index + 1).toString() + '"]').focus();
    }
});

$(document).on('click', '#selectItem', function() {
    var loc         = $(this).data('loc');
    var part        = $(this).data('part');
    var qty_open    = $(this).data('qty_open');
    var open_po_qad = $(this).data('open_po_qad');
    var ps          = $(this).data('ps');
    var po          = $(this).data('po');
    var qty_po      = $(this).data('qty_po');
    var qc          = $(this).data('qc');
    var memo        = $(this).data('memo');
    var line        = $(this).data('line');
    var pm_code     = $(this).data('pm_code');
    var desc        = $(this).data('desc');
    var um          = $(this).data('um');
    var pp          = $(this).data('pp');
    var pp_desc     = $(this).data('pp_desc');
    var part_type   = $(this).data('part_type');

    var indexing   = $('#jumlahData').val();

    let jadiin = Number(indexing) + Number(1);

    $('#detailTabCode').append('<tr style="">'+
    '<td align="left">'+part+'<br>'+
        '<span class="view-message dont-show font-weight-semibold">'+desc+'</span>'+
    '</td>'+
    '<td class="view-message dont-show font-weight-semibold">'+um+'</td>'+
    '<td class="view-message dont-show font-weight-semibold">'+line+''+
        '<input type="hidden" name="new_line[]" id="new_line[]" value="'+line+'">'+
        '<input type="hidden" name="new_part[]" id="new_part[]" value="'+part+'">'+
        '<input type="hidden" name="new_desc[]" id="new_desc[]" value="'+desc+'">'+
        '<input type="hidden" name="new_um[]" id="new_um[]" value="'+um+'">'+
        '<input type="hidden" name="new_pm_code[]" id="new_pm_code[]" value="'+pm_code+'">'+
        '<input type="hidden" name="new_loc[]" id="new_loc[]" value="'+loc+'">'+
        '<input type="hidden" name="new_type[]" id="new_type[]" value="'+part_type+'">'+
        '<input type="hidden" name="new_pp[]" id="new_pp[]" value="'+pp+'">'+
        '<input type="hidden" name="new_pp_desc[]" id="new_pp_desc[]" value="'+pp_desc+'">'+
        '<input type="hidden" name="new_memo[]" id="new_memo[]" value="'+memo+'">'+
        '<input type="hidden" name="new_qty_rc[]" id="new_qty_rc[]" value="'+qty_po+'">'+
        '<input type="hidden" name="new_qty_open[]" id="new_qty_open[]" value="'+open_po_qad+'">'+
    '</td>'+
    '<td class="view-message dont-show font-weight-semibold">'+ps+'</td>'+
    '<td class="view-message dont-show font-weight-semibold">'+open_po_qad+'</td>'+
    '<td class="okei">'+
        '<input type="text" data-index="'+jadiin+'" data-po="'+po+'" data-open_qty="'+open_po_qad+'"  data-ps="'+ps+'" data-item="'+part+'" data-line="'+line+'"  data-qty="'+qc+'" class="txtQty"name="new_qty[]" id="new_qty[]" value="" onchange="cekPoAdditional(this)" style="font-size:15px;background-color:transparent;width:70px;margin:0px;text-align:right;height:30px;border:thin white solid;padding:0px 3px;">'+
    '</td>'+
    '</tr>');

    $('#jumlahData').val(jadiin);
    $('#additionalPo').click();

});
