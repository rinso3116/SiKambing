<div class="row mb-3">
    <div class="col-md-6">
        <b><label class="form-label">Jumlah Susu (liter)</label></b>
        <p class="form-control"><?php echo $penjualan->jumlah_susu; ?> liter</p>
    </div>
    <div class="col-md-6">
        <b><label class="form-label">Menjual ke</label></b>
        <p class="form-control"><?php echo $penjualan->menjual_ke; ?></p>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-6">
        <b><label class="form-label">Harga per Liter</label></b>
        <p class="form-control">Rp. <?php echo number_format($penjualan->harga_per_liter, 0, ',', '.'); ?></p>
    </div>
    <div class="col-md-6">
        <b><label class="form-label">Total Harga</label></b>
        <p class="form-control">Rp. <?php echo number_format($penjualan->total_harga, 0, ',', '.'); ?></p>
    </div>
</div>

<div class="mb-3">
    <b><label class="form-label">Keterangan</label></b>
    <p class="form-control"><?php echo !empty($penjualan->keterangan) ? $penjualan->keterangan : 'Tidak ada keterangan'; ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Tanggal Penjualan</label></b>
    <p class="form-control"><?php echo !empty($penjualan->tanggal) ? $penjualan->tanggal : 'Tidak tersedia'; ?></p>
</div>