<div class="mb-3">
    <b><label class="form-label">Jumlah Pengeluaran</label></b>
    <p class="form-control">Rp. <?php echo number_format($pengeluaran->jumlah, 0, ',', '.'); ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Keterangan</label></b>
    <p class="form-control"><?php echo !empty($pengeluaran->keterangan) ? $pengeluaran->keterangan : 'Tidak ada keterangan'; ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Tanggal pengeluaran</label></b>
    <p class="form-control"><?php echo !empty($pengeluaran->tanggal) ? $pengeluaran->tanggal : 'Tidak tersedia'; ?></p>
</div>