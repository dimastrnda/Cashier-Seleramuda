<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #eee; }
        h2 { text-align: center; }
        .info { margin-top: 20px; }
    </style>
</head>
<body onload="window.print()">

<h2>Laporan Penjualan</h2>

<div class="info">
    <?php if ($start_date && $end_date): ?>
        <p>Periode: <?= indo_date($start_date) ?> s/d <?= indo_date($end_date) ?></p>
    <?php else: ?>
        <p>Periode: Semua</p>
    <?php endif; ?>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Customer ID</th>
            <th>Total</th>
            <th>Discount</th>
            <th>Final</th>
            <th>Cash</th>
            <th>Remaining</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($sales as $s): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $s['invoice'] ?></td>
            <td><?= $s['customer_id'] ?></td>
            <td style="text-align:right"><?= number_format($s['total_price'], 0, ',', '.') ?></td>
            <td style="text-align:right"><?= number_format($s['discount'], 0, ',', '.') ?></td>
            <td style="text-align:right"><?= number_format($s['final_price'], 3, ',', '.') ?></td>
            <td style="text-align:right"><?= number_format($s['cash'], 0, ',', '.') ?></td>
            <td style="text-align:right"><?= number_format($s['remaining'], 0, ',', '.') ?></td>
            <td><?= indo_date($s['date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
