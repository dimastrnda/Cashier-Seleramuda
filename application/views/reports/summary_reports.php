<section class="content-header">
    <h1><?= $title ?></h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="form-inline">
                <div class="form-group">
                    <label>Periode:</label>
                    <select name="period" id="periodSelect" class="form-control">
                        <option value="daily" <?= $period == 'daily' ? 'selected' : '' ?>>Harian</option>
                        <option value="weekly" <?= $period == 'weekly' ? 'selected' : '' ?>>Mingguan</option>
                        <option value="yearly" <?= $period == 'yearly' ? 'selected' : '' ?>>Tahunan</option>
                    </select>
                </div>
            </div>
        </div>
        


        <div class="box-body table-responsive">
            <table class="table table-bordered table-striped">
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
                                <td class="text-center"><?= $row->total_transactions ?></td>
                                <td class="text-right"><?= number_format($row->total_sales, 3, ',', '.') ?></td>
                            </tr>
                            <?php
                                $total_sales += $row->total_sales;
                                $total_transactions += $row->total_transactions;
                            ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="<?= ($period == 'weekly') ? 4 : 3 ?>" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

                <?php if (!empty($reports)) : ?>
                    <tfoot>
                        <tr>
                            <?php if ($period == 'daily') : ?>
                                <th style="text-align:right">Total</th>
                            <?php elseif ($period == 'weekly') : ?>
                                <th colspan="2" style="text-align:right">Total</th>
                            <?php elseif ($period == 'yearly') : ?>
                                <th style="text-align:right">Total</th>
                            <?php endif; ?>
                            <th class="text-center"><?= $total_transactions ?></th>
                            <th class="text-right"><?= number_format($total_sales, 3, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <a href="<?= site_url('reports/summary_print/'.$period) ?>" class="btn btn-danger" target="_blank">
        <i class="fa fa-file-pdf-o"></i> Cetak PDF
    </a>
</section>

<script>
    document.getElementById('periodSelect').addEventListener('change', function() {
        var period = this.value;
        window.location.href = '<?= site_url("reports/summary_report/") ?>' + period;
    });
</script>
