<!DOCTYPE html>
<html>
<head>
    <title>Print Nota</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .no-border { border: none; }
    </style>
</head>
<body onload="window.print()">

<h2>Nota Penjualan</h2>

<table class="no-border">
    <tr>
        <td>Invoice</td>
        <td><?= $sale->invoice ?></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td><?= indo_date($sale->date) ?></td>
    </tr>
    <tr>
        <td>Customer ID</td>
        <td><?= $sale->customer_id ?></td>
    </tr>
</table>

<hr>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
        foreach($detail as $item): 
            $total += $item->total;
        ?>
        <tr>
            <td><?= $item->product_name ?></td>
            <td><?= number_format($item->price, 0, ',', '.') ?></td>
            <td><?= $item->qty ?></td>
            <td><?= number_format($item->total, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" style="text-align:right">Total</th>
            <th><?= number_format($total, 0, ',', '.') ?></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right">Discount</th>
            <th><?= number_format($sale->discount, 0, ',', '.') ?></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right">Final Price</th>
            <th><?= number_format($sale->final_price, 3, ',', '.') ?></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right">Cash</th>
            <th><?= number_format($sale->cash, 0, ',', '.') ?></th>
        </tr>
        <tr>
            <th colspan="3" style="text-align:right">Remaining</th>
            <th><?= number_format($sale->remaining, 0, ',', '.') ?></th>
        </tr>
    </tfoot>
</table>

<p>Note: <?= $sale->note ?></p>

</body>
</html>
