<div class="mb-3">
    <b><label class="form-label">Jumlah Susu (liter)</label></b>
    <p class="form-control"><?php echo $pencatatan->jumlah_susu; ?> liter</p>
</div>
<div class="mb-3">
    <b><label class="form-label">Keterangan</label></b>
    <p class="form-control"><?php echo !empty($pencatatan->keterangan) ? $pencatatan->keterangan : 'Tidak ada keterangan'; ?></p>
</div>
<div class="mb-3">
    <b><label class="form-label">Tanggal Pencatatan</label></b>
    <p class="form-control"><?php echo !empty($pencatatan->tanggal) ? $pencatatan->tanggal : 'Tidak tersedia'; ?></p>
</div>
