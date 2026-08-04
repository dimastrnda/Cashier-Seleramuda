<section class="content-header">
    <h1>Sales Reports
        <small>Data Penjualan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
        <li>Reports</li>
        <li class="active">Sales Reports</li>
    </ol>
</section>


<section class="content">
    <?php $this->view('messages') ?> <!-- Menampilkan pesan flash success atau error -->
    
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Penjualan</h3>
            <form method="get" action="<?= site_url('reports') ?>" class="form-inline" style="margin-bottom: 20px;">
    <br>
    <div class="pull-right">
    <a href="<?= site_url('reports/print?' . http_build_query($_GET)) ?>" target="_blank" class="btn btn-default">
        <i class="fa fa-print"></i> Cetak Laporan
    </a>
    </div>

    <div class="form-group">
        <label for="start_date">Dari:</label>
        <input type="date" class="form-control" name="start_date" value="<?= $start_date ?>">
    </div>
    <div class="form-group" style="margin-left: 10px;">
        <label for="end_date">Sampai:</label>
        <input type="date" class="form-control" name="end_date" value="<?= $end_date ?>">
    </div>
    <div class="form-group" style="margin-left: 10px;">
        <label for="order">Urutan:</label>
        <select name="order" class="form-control">
            <option value="desc" <?= $order == 'desc' ? 'selected' : '' ?>>Terbaru</option>
            <option value="asc" <?= $order == 'asc' ? 'selected' : '' ?>>Terlama</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Filter</button>
    <a href="<?= site_url('reports') ?>" class="btn btn-default">Reset</a>
</form>

<form method="get" action="<?= site_url('reports/summary') ?>" class="form-inline">
    <div class="form-group" style="margin-left: 10px;">
        <label for="period">Laporan:</label>
        <select name="period" class="form-control" id="periodSelect">
         <option value="none">Semua Data</option>
         <option value="daily">Harian</option>
         <option value="weekly">Mingguan</option>
         <option value="yearly">Tahunan</option>
        </select>
    </div>
</form>



        </div>
        
        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="table1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer ID</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Final Price</th>
                        <th>Cash</th>
                        <th>Remaining</th>
                        <th>Date</th>
                        <th>Actions</th> <!-- Tombol untuk aksi (Hapus) -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; 
                    foreach($sales as $sale) { ?>
                    <tr>
                        <td style="width: 5%;"><?=$no++?>.</td>
                        <td><?=$sale['invoice']?></td>
                        <td><?=$sale['customer_id']?></td>
                        <td class="text-right"><?=number_format($sale['total_price'], 0, ',', '.')?></td>
                        <td class="text-right"><?=number_format($sale['discount'], 0, ',', '.')?></td>
                        <td class="text-right"><?=number_format($sale['final_price'], 0, ',', '.')?></td>
                        <td class="text-right"><?=number_format($sale['cash'], 0, ',', '.')?></td>
                        <td class="text-right"><?=number_format($sale['remaining'], 0, ',', '.')?></td>
                        <td class="text-center"><?=indo_date($sale['date'])?></td>
                        <td class="text-center" width="200px">
                            <a href="#"
                                class="btn btn-info btn-xs btn-detail" 
                                data-id="<?= $sale['sale_id'] ?>">
                                <i class="fa fa-eye"></i> Detail
                            </a>

                            <a href="<?= site_url('reports/print_nota/' . $sale['sale_id']) ?>" 
                            class="btn btn-default btn-xs" target="_blank">
                                <i class="fa fa-print"></i> Cetak
                            </a>

                            <a href="<?= site_url('reports/delete_sale/' . $sale['sale_id']) ?>" 
                            class="btn btn-danger btn-xs" 
                            onclick="return confirm('Are you sure you want to delete this sale?')">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        </td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Optional: Modal for viewing sales details -->
<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Sales Detail</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th style="width:35%">Invoice</th>
                            <td><span id="invoice"></span></td>
                        </tr>
                        <tr>
                            <th>Customer ID</th>
                            <td><span id="customer_id"></span></td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td><span id="total_price"></span></td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td><span id="discount"></span></td>
                        </tr>
                        <tr>
                            <th>Final Price</th>
                            <td><span id="final_price"></span></td>
                        </tr>
                        <tr>
                            <th>Cash</th>
                            <td><span id="cash"></span></td>
                        </tr>
                        <tr>
                            <th>Remaining</th>
                            <td><span id="remaining"></span></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><span id="date"></span></td>
                        </tr>
                        <tr>
                            <th>Note</th>
                            <td><span id="note"></span></td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <h4>Product Details</h4>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                        
                    </thead>
                    <tbody id="table-detail">
                        <!-- Data via AJAX -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width:35%">Final Price</th>
                            <td><span id="final_price_footer" style="font-weight:bold;"></span></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>


<script>
$(document).on('click', '.btn-detail', function(e) {
    e.preventDefault();
    var sale_id = $(this).data('id');

    $.ajax({
        url: '<?= site_url("Reports/sale_detail_ajax/") ?>' + sale_id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Isi header detail
            $('#invoice').text(response.sale.invoice);
            $('#customer_id').text(response.sale.customer_id);
            $('#total_price').text('Rp ' + formatRupiah(response.sale.total_price));
            $('#discount').text('Rp ' + formatRupiah(response.sale.discount));
            $('#final_price').text('Rp ' + formatRupiah(response.sale.final_price));
            $('#final_price_footer').text('Rp ' + formatRupiah(response.sale.final_price));

            $('#cash').text('Rp ' + formatRupiah(response.sale.cash));
            $('#remaining').text('Rp ' + formatRupiah(response.sale.remaining));
            $('#date').text(response.sale.date);
            $('#note').text(response.sale.note);

            // Isi tabel detail produk
            var rows = '';
            var total_profit = 0;
            $.each(response.detail, function(i, item) {
                var profit = (parseFloat(item.price) - parseFloat(item.purchase_price)) * parseInt(item.qty);
                total_profit += profit;

                rows += '<tr>'+
                    '<td>'+item.product_name+'</td>'+
                    //'<td>'+formatRupiah(item.purchase_price)+'</td>'+
                    '<td>'+formatRupiah(item.price)+'</td>'+
                    '<td>'+item.qty+'</td>'+
                    '<td>'+formatRupiah(item.total)+'</td>'+
                    //'<td>'+formatRupiah(profit)+'</td>'+
                    '</tr>';
            });
            $('#table-detail').html(rows);
            //$('#total_profit').text(formatRupiah(total_profit));

            $('#modal-detail').modal('show');
        },
        error: function() {
            alert('Tidak dapat mengambil data detail.');
        }
    });
});

// Fungsi format rupiah
function formatRupiah(angka) {
    if (angka == null || angka === '') return '0';
    return parseFloat(angka).toLocaleString('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}


$(document).ready(function() {
    $('#periodSelect').on('change', function() {
        var period = $(this).val();

        if (period === 'none') {
            window.location.href = '<?= site_url("reports") ?>';
        } else {
            window.location.href = '<?= site_url("reports/summary/") ?>' + period;
        }
    });
});
</script>
