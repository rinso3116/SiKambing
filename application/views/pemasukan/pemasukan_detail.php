<div class="mb-3">
    <b><label class="form-label">Jumlah Pemasukan</label></b>
    <p class="form-control">Rp. <?php echo number_format($pemasukan->jumlah, 0, ',', '.'); ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Keterangan</label></b>
    <p class="form-control"><?php echo !empty($pemasukan->keterangan) ? $pemasukan->keterangan : 'Tidak ada keterangan'; ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Tanggal pemasukan</label></b>
    <p class="form-control"><?php echo !empty($pemasukan->tanggal) ? $pemasukan->tanggal : 'Tidak tersedia'; ?></p>
</div>