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
    
<div class="box-body table-responsive">
    <table class="table table-bordered table-striped" id="table1">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Product</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Laba Kotor</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_profit = 0;
            foreach($detail->result() as $d) : 
                $profit = (($d->price ?? 0) - ($d->purchase_price ?? 0)) * ($d->qty ?? 0);
                $total_profit += $profit;
            ?>
            <tr>
                <td><?= $d->invoice ?></td>
                <td><?= $d->product_name ?></td>
                <td><?= number_format($d->purchase_price ?? 0) ?></td>
                <td><?= number_format($d->price ?? 0) ?></td>
                <td><?= $d->qty ?? 0 ?></td>
                <td><?= number_format($d->total ?? 0) ?></td>
                <td><?= number_format($profit) ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-align:right">Total Laba Kotor</th>
                <th><?= number_format($total_profit) ?></th>
            </tr>
        </tfoot>
    </table>
</div>
</section>
