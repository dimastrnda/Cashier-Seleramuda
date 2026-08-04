<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        h3 { text-align: center; }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h3><?= $title ?></h3>

    <table>
        <thead>
            <tr>
                <?php if ($period == 'daily') : ?>
                    <th>Tanggal</th>
                <?php elseif ($period == 'weekly') : ?>
                    <th>Tahun</th>
                    <th>Minggu ke-</th>
                <?php elseif ($period == 'yearly') : ?>
                    <th>Tahun</th>
                <?php endif; ?>
                <th>Jumlah Transaksi</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_sales = 0;
            $total_transactions = 0;
            ?>
            <?php if (!empty($reports)) : ?>
                <?php foreach ($reports as $row) : ?>
                    <tr>
                        <?php if ($period == 'daily') : ?>
                            <td><?= indo_date($row->period_date) ?></td>
                        <?php elseif ($period == 'weekly') : ?>
                            <td><?= $row->year ?></td>
                            <td><?= $row->week ?></td>
                        <?php elseif ($period == 'yearly') : ?>
                            <td><?= $row->year ?></td>
                        <?php endif; ?>
                        <td><?= $row->total_transactions ?></td>
                        <td>Rp <?= number_format($row->total_sales, 3, ',', '.') ?></td>
                    </tr>
                    <?php
                        $total_sales += $row->total_sales;
                        $total_transactions += $row->total_transactions;
                    ?>
                <?php endforeach; ?>
                <tr>
                    <?php if ($period == 'daily') : ?>
                        <th style="text-align:right">Total</th>
                    <?php elseif ($period == 'weekly') : ?>
                        <th colspan="2" style="text-align:right">Total</th>
                    <?php elseif ($period == 'yearly') : ?>
                        <th style="text-align:right">Total</th>
                    <?php endif; ?>
                    <th><?= $total_transactions ?></th>
                    <th>Rp <?= number_format($total_sales, 3, ',', '.') ?></th>
                </tr>
            <?php else : ?>
                <tr>
                    <td colspan="<?= ($period == 'weekly') ? 4 : 3 ?>">Data tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <button onclick="window.print()" class="no-print">Cetak</button>
</body>
</html>
