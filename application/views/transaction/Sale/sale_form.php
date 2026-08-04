<section class="content-header">
    <h1>Sale
        <small>Penjualan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li>Transaction</li>
        <li class="active">Sale</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- Form to input date, cashier, and customer -->
        <div class="col-lg-4">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="date">Date</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="date" id="date" value="<?=date('Y-m-d')?>" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width:30%">
                                <label for="user">Kasir</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" id="user" value="<?=$this->fungsi->user_login()->name?>" class="form-control" readonly>
                                    <input type="hidden" id="user_id" value="<?=$this->fungsi->user_login()->user_id?>">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <label for="customer">Customer</label>
                            </td>
                            <td>
                               <div>
                                    <select id="customer" class="form-control">
                                        <option value="">Umum</option>
                                        <?php foreach($customer as $cust => $value){ ?>
                                            <option value="<?=$value->customer_id?>"><?=$value->name?></option>
                                        <?php } ?>
                                    </select>
                               </div> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form to input barcode, quantity, and add to cart -->
        <div class="col-lg-4">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td style="vertical-align: top;  width:30%">
                                <label for="barcode">Barcode</label>
                            </td>
                            <td>
                                <div class="form-group input-group">
                                    <input type="hidden" id="item_id">
                                    <input type="hidden" id="price">
                                    <input type="hidden" id="stock">
                                    <input type="text" id="barcode" class="form-control" autofocus>
                                    <span class="input-group-btn">
                                        <button type="button"  class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-item">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="qty">Qty</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="qty" value="1" min="1" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div>
                                    <button type="button" id="add_cart" class="btn btn-primary">
                                        <i class="fa fa-cart-plus"></i> Add
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Invoice summary and grand total -->
        <div class="col-lg-4">
            <div class="box box-widget">
                <div class="box-body">
                    <div align="right">
                        <h4>Invoice <b><span id="invoice"><?=$invoice?></span></b></h4>
                        <h1><b><span id="grand-total" style="font-size: 50pt;">0</span></b></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart table to show added items -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-widget">
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th>Product Item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th width="10%">Discount Item</th>
                                <th width="15%">Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="cart-table">
                            <?php if (!empty($cart)) {
                                foreach ($cart as $i => $data) { ?>
                                    <tr data-item-id="<?= $data->item_id ?>">
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $data->barcode ?></td>
                                        <td><?= $data->product_name ?></td>
                                        <td class="text-right"><?= indo_currency($data->price) ?></td>
                                        <td class="text-right"><?= $data->qty ?></td>
                                        <td class="text-right"><?= $data->discount ?></td>
                                        <td class="text-right"><?= indo_currency($data->total) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-xs remove-item"
                                                data-id="<?= $data->cart_id ?>"
                                                data-id-item="<?= $data->item_id ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                            <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada item</td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment details and total calculation -->
    <div class="row">
        <div class="col-lg-3">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td style="vertical-align: top; width: 30%">
                                <label for="sub_total">Sub Total</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="sub_total" value="" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <label for="discount">Discount</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="discount" value="0" min="0" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <label for="grand_total">Grand Total</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="grand_total" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cash input and change calculation -->
        <div class="col-lg-3">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td style="vertical-align: top; width:30%">
                                <label for="cash">Cash</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" id="cash" value="0" min="0" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="change">Change</label>
                            </td>
                            <td>
                                <div>
                                    <input type="number" id="change" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Notes and buttons for canceling or processing payment -->
        <div class="col-lg-3">
            <div class="box box-widget">
                <div class="box-body">
                    <table width="100%">
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="note">Note</label>
                            </td>
                            <td>
                                <div>
                                    <textarea id="note" rows="3" class="form-control"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <tr>
            <td style="vertical-align: top">
                <label for="payment_type">Payment Method</label>
            </td>
            <div class="col-lg-3">
                <div>
                    <button id="cancel-payment" class="btn btn-flat btn-warning">
                        <i class="fa fa-refresh"></i> Cancel
                    </button><br><br>
                    <button id="process_payment" class="btn btn-flat btn-lg btn-success">
                        <i class="fa fa-paper-plane-o"></i> Process Payment (Tunai)
                    </button><br><br>
                    <button id="process_payment_midtrans" class="btn btn-flat btn-lg btn-primary">
                        <i class="fa fa-credit-card"></i> Process Payment (Cashless)
                    </button>
                </div>
            </div>



        <!-- <div class="col-lg-3">
            <div>
                <button id="cancel-payment" class="btn btn-flat btn-warning">
                    <i class="fa fa-refresh"></i> Cancel
                </button><br><br>
                <button id="process_payment" class="btn btn-flat btn-lg btn-success">
                    <i class="fa fa-paper-plane-o"></i> Process Payment
                </button>
            </div>
        </div>
    </div> -->
</section>

<!-- Modal to select product item -->
<div class="modal fade" id="modal-item" tabindex="-1" role="dialog" aria-labelledby="modalItemLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalItemLabel">Select Product Item</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($item as $i => $data) { ?>
                        <tr>
                            <td><?= htmlspecialchars($data->barcode) ?></td>
                            <td><?= htmlspecialchars($data->name) ?></td>
                            <td><?= htmlspecialchars($data->unit_name) ?></td>
                            <td class="text-right"><?= indo_currency($data->price) ?></td>
                            <td class="text-right"><?= htmlspecialchars($data->stock) ?></td>
                            <td class="text-right">
                                <button class="btn btn-xs btn-info select-item"
                                    data-id="<?= htmlspecialchars($data->item_id) ?>"
                                    data-barcode="<?= htmlspecialchars($data->barcode) ?>"
                                    data-name="<?= htmlspecialchars($data->name) ?>"
                                    data-unit="<?= htmlspecialchars($data->unit_name) ?>"
                                    data-price="<?= htmlspecialchars($data->price) ?>"
                                    data-stock="<?= htmlspecialchars($data->stock) ?>">
                                    <i class="fa fa-check"></i> Select
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Payment Method -->
<div class="modal fade" id="modal-payment-type" tabindex="-1" role="dialog" aria-labelledby="paymentTypeLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="paymentTypeLabel">Pilih Metode Pembayaran</h4>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-success btn-block" id="btn-payment-cash">
          <i class="fa fa-money"></i> Tunai
        </button>
        <button type="button" class="btn btn-primary btn-block" id="btn-payment-midtrans">
          <i class="fa fa-credit-card"></i> Midtrans / Cashless
        </button>
      </div>
    </div>
  </div>
</div>


<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="SB-Mid-client-X_dwp_rIucUe-s_a"></script>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script>
$(document).ready(function () {

    // =================== FUNGSI UTAMA ===================

    function load_cart() {
        $.ajax({
            url: '<?= site_url('sale/load_cart') ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Data cart:", data);
                var html = '';
                var grandTotal = 0;

                if (data.length === 0) {
                    html = '<tr><td colspan="9" class="text-center">Tidak ada item</td></tr>';
                } else {
                    data.forEach(function (item, index) {
                        html += `<tr>
                                <td>
                                    <input type="hidden" class="item-id-hidden" value="${item.item_id}">
                                    ${index + 1}
                                </td>
                                <td>${item.barcode}</td>
                                <td>${item.product_name}</td>
                                <td class="text-right">${item.price}</td>
                                <td class="text-right">${item.qty}</td>
                                <td class="text-right">${item.discount}</td>
                                <td class="text-right">${item.total}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-danger remove-item" 
                                        data-id="${item.cart_id}" 
                                        data-id-item="${item.item_id}">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </td>
                            </tr>`;



                        grandTotal += parseFloat(item.total) || 0;
                    });
                }

                $('#cart-table').html(html);
                $('#grand-total').text(grandTotal.toLocaleString('id-ID', { maximumFractionDigits: 0 }));
                $('#sub_total').val(grandTotal);
                $('#grand_total').val(grandTotal);
                update_grand_total();
            }
        });
    }

    $('#add_cart').click(function () {
    let item_id = $('#item_id').val();
    let price = $('#price').val();
    let qty = $('#qty').val();
    let stock = $('#stock').val();

    if (item_id === '' || price === '') {
        alert('Produk belum dipilih!');
        return;
    }

    if (parseInt(qty) > parseInt(stock)) {
        alert('Stock tidak mencukupi!');
        return;
    }

    $.ajax({
        url: '<?= site_url('sale/add_to_cart') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            item_id: item_id,
            price: price,
            qty: qty,
            user_id: $('#user_id').val()
        },
        success: function (response) {
            if (response.status === 'success') {
                $('#item_id').val('');
                $('#barcode').val('');
                $('#price').val('');
                $('#stock').val('');
                $('#qty').val(1);
                load_cart(); // reload tabel
            } else {
                alert(response.message || 'Gagal menambahkan item ke cart.');
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
});


   

    function update_grand_total() {
        var subTotal = parseFloat($('#sub_total').val()) || 0;
        var discount = parseFloat($('#discount').val()) || 0;
        var grandTotal = subTotal - discount;

        $('#grand_total').val(grandTotal.toLocaleString('id-ID'));

        var cash = parseFloat($('#cash').val()) || 0;
        var change = cash - grandTotal;

        $('#change').val(change > 0 ? change.toLocaleString('id-ID') : '0');
    }

    function reset_form() {
        $('#sub_total').val('');
        $('#discount').val('0');
        $('#grand_total').val('');
        $('#cash').val('0');
        $('#change').val('0');
        $('#note').val('');
    }

    




    function print_invoice() {
        var htmlItems = '';
        $('#cart-table tr').each(function () {
            var name = $(this).find('td').eq(2).text();
            var qty = $(this).find('td').eq(4).text();
            var price = $(this).find('td').eq(3).text();

            htmlItems += `
                <tr>
                    <td>${name}</td>
                    <td class="text-right">${qty}</td>
                    <td class="text-right">${price}</td>
                </tr>`;
        });

        var invoiceContent = `
            <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; font-size: 14px; }
                        .invoice-header { text-align: center; margin-bottom: 20px; }
                        .invoice-header h1 { margin: 0; }
                        .invoice-details, .invoice-items { width: 100%; margin-top: 20px; border-collapse: collapse; }
                        .invoice-details td, .invoice-items td, .invoice-items th { border: 1px solid #ddd; padding: 8px; }
                        .invoice-details th, .invoice-items th { text-align: left; }
                        .invoice-items th { background-color: #f2f2f2; }
                        .text-right { text-align: right; }
                        .text-center { text-align: center; }
                    </style>
                </head>
                <body>
                    <div class="invoice-header">
                        <h1>Invoice</h1>
                        <p><strong>Invoice No:</strong> ${$('#invoice').text()}</p>
                        <p><strong>Date:</strong> ${$('#date').val()}</p>
                        <p><strong>Cashier:</strong> ${$('#user').val()}</p>
                        <p><strong>Customer:</strong> ${$('#customer option:selected').text()}</p>
                    </div>
                    <table class="invoice-items">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>${htmlItems}</tbody>
                    </table>
                    <table class="invoice-details">
                        <tr><td><strong>Sub Total:</strong></td><td class="text-right">${$('#sub_total').val()}</td></tr>
                        <tr><td><strong>Discount:</strong></td><td class="text-right">${$('#discount').val()}</td></tr>
                        <tr><td><strong>Grand Total:</strong></td><td class="text-right">${$('#grand_total').val()}</td></tr>
                        <tr><td><strong>Cash:</strong></td><td class="text-right">${$('#cash').val()}</td></tr>
                        <tr><td><strong>Change:</strong></td><td class="text-right">${$('#change').val()}</td></tr>
                    </table>
                    <p><strong>Note:</strong> ${$('#note').val()}</p>
                </body>
            </html>`;

        var printWindow = window.open('', '', 'height=800,width=600');
        printWindow.document.write(invoiceContent);
        printWindow.document.close();
        printWindow.print();
    }

    // =================== EVENT HANDLER ===================

    $(document).on('click', '.remove-item', function () {
        var cart_id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            $.ajax({
                url: '<?= site_url('sale/remove_cart') ?>',
                type: 'POST',
                data: { cart_id: cart_id },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        load_cart();
                    }
                }
            });
        }
    });

    $(document).on('click', '.select-item', function () {
        let itemId = $(this).data('id');
        let barcode = $(this).data('barcode');
        let name = $(this).data('name');
        let unit = $(this).data('unit');
        let price = $(this).data('price');
        let stock = $(this).data('stock');

        $('#item_id').val(itemId);
        $('#barcode').val(barcode);
        $('#price').val(price);
        $('#stock').val(stock);
        $('#modal-item').modal('hide');
    });

   $('#process_payment').click(function () {
    var items = get_cart_items();
    if (items.length === 0) {
        alert('Cart kosong. Silakan tambahkan item terlebih dahulu.');
        return;
    }

    // 🧹 Hapus titik sebelum parse supaya 8.500 jadi 8500
    var cash = parseFloat($('#cash').val().replace(/\./g, '').replace(/,/g, '.'));
    var total = parseFloat($('#grand_total').val().replace(/\./g, '').replace(/,/g, '.'));

    console.log("DEBUG >> Cash:", cash);
    console.log("DEBUG >> Total:", total);

    if (isNaN(cash) || cash <= 0) {
        alert('Masukkan nominal uang customer terlebih dahulu!');
        $('#cash').focus();
        return;
    }

    if (cash < total) {
        alert('Uang customer tidak mencukupi untuk melakukan pembayaran!');
        $('#cash').focus();
        return;
    }

    // ✅ Kalau sudah valid, lanjut proses
    print_invoice();

    $.ajax({
        url: '<?= site_url('sale/save_sale') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            invoice: $('#invoice').text(),
            date: $('#date').val(),
            cashier: $('#user').val(),
            customer: $('#customer').val(),
            sub_total: $('#sub_total').val(),
            discount: $('#discount').val(),
            grand_total: $('#grand_total').val(),
            cash: $('#cash').val(),
            change: $('#change').val(),
            note: $('#note').val(),
            items: JSON.stringify(items),
            payment_type: 'cash'
        },
        success: function (res) {
            let data = res;
            if (typeof res === 'string') {
                try {
                    data = JSON.parse(res);
                } catch (e) {
                    alert("Response bukan format JSON. Cek konsol dan server!");
                    console.error(res);
                    return;
                }
            }

            if (data.status == 'success') {
                alert('Transaksi berhasil!');
                clear_cart();
                location.reload();
            } else {
                alert('Gagal menyimpan transaksi: ' + data.message);
            }
        },
        error: function (xhr, status, error) {
            alert(
                "AJAX Error:\n" +
                "Status: " + xhr.status + "\n" +
                "Error: " + error + "\n" +
                "Response: " + xhr.responseText
            );
            console.error("AJAX Error Response:", xhr.responseText);
        }
    });
});



    $('#process_payment_midtrans').click(function() {
    processMidtransPayment();

    });

    $('#discount, #cash').on('input keyup', function () {
        update_grand_total();
    });
    

    load_cart();
});


function get_cart_items() {
    var items = [];
    $('#cart-table tr').each(function () {
        var item = {
            item_id: $(this).find('.item-id-hidden').val(),
            product_name: $(this).find('td').eq(2).text(),
            price: parseFloat($(this).find('td').eq(3).text().replace(/[^0-9.-]+/g, "")),
            qty: parseInt($(this).find('td').eq(4).text(), 10),
            discount: parseFloat($(this).find('td').eq(5).text().replace(/[^0-9.-]+/g, "")),
            total: parseFloat($(this).find('td').eq(6).text().replace(/[^0-9.-]+/g, ""))
        };

        if (item.item_id && !isNaN(item.price) && !isNaN(item.qty)) {
            items.push(item);
        }
    });

    console.log("Items:", items);
    console.log(JSON.stringify(items));
    return items;
}



 function clear_cart() {
        $.ajax({
            url: '<?= site_url('sale/clear_cart') ?>',
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Cart cleared successfully.');
                } else {
                    alert('Gagal menghapus data cart.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data cart.');
            }
        });
    }


function processCashPayment() {
        var items = get_cart_items();
        if (items.length === 0) {
            alert('Cart kosong. Silakan tambahkan item terlebih dahulu.');
            return;
        }

        print_invoice();

        $.ajax({
            url: '<?= site_url('sale/save_sale') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                invoice: $('#invoice').text(),
                date: $('#date').val(),
                cashier: $('#user').val(),
                customer: $('#customer').val(),
                sub_total: $('#sub_total').val(),
                discount: $('#discount').val(),
                grand_total: $('#grand_total').val(),
                cash: $('#cash').val(),
                change: $('#change').val(),
                note: $('#note').val(),
                items: JSON.stringify(items),
                payment_type: 'cash'
            },
            success: function (res) {
                let data = res;
                if (typeof res === 'string') {
                    try {
                        data = JSON.parse(res);
                    } catch (e) {
                        alert("Response bukan format JSON. Cek konsol dan server!");
                        console.error(res);
                        return;
                    }
                }

                if (data.status == 'success') {
                    alert('Transaksi berhasil!');
                    clear_cart();
                    location.reload();
                } else {
                    alert('Gagal menyimpan transaksi: ' + data.message);
                }
            },
            error: function (xhr, status, error) {
                alert(
                    "AJAX Error:\n" +
                    "Status: " + xhr.status + "\n" +
                    "Error: " + error + "\n" +
                    "Response: " + xhr.responseText
                );
                console.error("AJAX Error Response:", xhr.responseText);
            }
        });
    }


var snapPopupOpen = false;
var lastCartItems = [];

function processMidtransPayment() {
    var items = get_cart_items();
    if (items.length === 0) {
        alert('Cart kosong. Silakan tambahkan item terlebih dahulu.');
        console.log("DEBUG: Cart kosong, items:", items);
        return;
    }

    lastCartItems = items; // Simpan data cart sementara

    var invoiceBase = $('#invoice').text();
    var uniqueInvoice = invoiceBase + '-' + new Date().getTime();

    // Ambil nilai sub_total, discount, grand_total dari input
    var sub_total = parseFloat($('#sub_total').val().replace(/[^\d.-]/g, "")) || 0;
    var discount = parseFloat($('#discount').val().replace(/[^\d.-]/g, "")) || 0;
    var grand_total = sub_total - discount;

    // 🔹 Tambahkan item diskon negatif agar terlihat di Midtrans
    var midtransItems = [...items.map(item => ({
        id: item.item_id,
        price: Math.round(item.price),
        quantity: item.qty,
        name: item.product_name
    }))];

    if (discount > 0) {
        midtransItems.push({
            id: 'DISCOUNT',
            price: -Math.round(discount),
            quantity: 1,
            name: 'Diskon'
        });
    }

    console.log("DEBUG: Items dikirim ke Midtrans:", midtransItems);

    $.ajax({
        url: '<?= site_url('sale/create_midtrans_transaction') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            invoice: uniqueInvoice,
            date: $('#date').val(),
            cashier: $('#user').val(),
            cashier_name: $('#user option:selected').text(),
            customer: $('#customer').val(),
            sub_total: sub_total,
            discount: discount,
            grand_total: grand_total,
            note: $('#note').val(),
            items: JSON.stringify(midtransItems)
        },
        success: function (res) {
            console.log("Respon Midtrans:", res);

            // ✅ Pastikan respon adalah JSON valid
            if (typeof res === 'string') {
                try {
                    res = JSON.parse(res);
                } catch (e) {
                    console.error("Respon bukan JSON valid:", res);
                    alert("Gagal parsing response dari Midtrans.");
                    return;
                }
            }

            if (res.snapToken) {
                if (!snapPopupOpen) {
                    snapPopupOpen = true;
                    $('#process_payment_midtrans').prop('disabled', true);

                    snap.pay(res.snapToken, {
                        onSuccess: function (result) {
                            alert("Pembayaran sukses!");
                            saveMidtransTransaction(result, uniqueInvoice);
                            snapPopupOpen = false;
                            $('#process_payment_midtrans').prop('disabled', false);
                        },
                        onPending: function (result) {
                            alert("Pembayaran pending.");
                            saveMidtransTransaction(result, uniqueInvoice);
                            snapPopupOpen = false;
                            $('#process_payment_midtrans').prop('disabled', false);
                        },
                        onError: function (result) {
                            alert("Pembayaran gagal!");
                            console.error(result);
                            snapPopupOpen = false;
                            $('#process_payment_midtrans').prop('disabled', false);
                        },
                        onClose: function () {
                            console.log('Snap closed.');
                            snapPopupOpen = false;
                            $('#process_payment_midtrans').prop('disabled', false);
                        }
                    });
                }
            } else {
                alert("Gagal membuat Snap token.");
                console.log("Response tanpa snapToken:", res);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error Midtrans:", xhr.responseText);
            alert("AJAX error Midtrans: " + error);
        }
    });
}


function saveMidtransTransaction(result, invoice) {
    var items = lastCartItems; // Gunakan cart sebelum popup

    $.ajax({
        url: '<?= site_url('sale/save_sale_midtrans') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            transaction_result: JSON.stringify(result),
            items: JSON.stringify(items),
            user_id: $('#user').val(),
            customer: $('#customer').val(),
            invoice: invoice,
            date: $('#date').val(),
            sub_total: $('#sub_total').val(),
            discount: $('#discount').val(),
            grand_total: $('#grand_total').val(),
            note: $('#note').val(),
            payment_type: 'midtrans'
        },
        success: function (data) {
            console.log("Save Sale Midtrans Response:", data);

            // ✅ Cegah parsing error dari HTML
            if (typeof data === 'string') {
                try {
                    data = JSON.parse(data);
                } catch (e) {
                    console.error("Response bukan JSON:", data);
                    alert("Server tidak mengirim JSON valid.");
                    return;
                }
            }

            if (data.status === 'success') {
                alert('Transaksi berhasil disimpan.');
                clear_cart();
                location.reload();
            } else {
                alert('Gagal simpan transaksi Midtrans: ' + (data.message || 'Unknown error'));
                console.error(data);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error Save Midtrans:", xhr.responseText);
            alert("AJAX Error saat simpan Midtrans: " + error);
        }
    });
}








</script>




