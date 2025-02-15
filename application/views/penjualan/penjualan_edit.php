<form id="form-edit-penjualan" action="<?php echo site_url('penjualan/penjualan_update'); ?>" method="post">
  <input type="hidden" id="id_penjualan" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">

  <div class="modal-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="jumlah_susu" class="form-label">Jumlah Susu (liter)</label>
        <input type="number" class="form-control" id="jumlah_susu" name="jumlah_susu" value="<?php echo $penjualan->jumlah_susu; ?>" required>
      </div>
      <div class="col-md-6">
        <label for="harga_per_liter" class="form-label">Harga per Liter</label>
        <input type="text" class="form-control" id="harga_per_liter" name="harga_per_liter" value="<?php echo number_format($penjualan->harga_per_liter, 0, ',', '.'); ?>" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="menjual_ke" class="form-label">Menjual ke</label>
      <input type="text" class="form-control" id="menjual_ke" name="menjual_ke" value="<?php echo $penjualan->menjual_ke; ?>" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $penjualan->keterangan; ?></textarea>
    </div>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  </div>
</form>

<!-- 
<script>
  // Menambahkan format angka pada input harga per liter
  $(document).ready(function() {
    // Format nilai input sebagai format angka (misalnya 1.000,00)
    $('#harga_per_liter').on('input', function() {
      var value = $(this).val().replace(/\D/g, ''); // Hapus karakter selain angka
      $(this).val(formatCurrency(value));
    });

    function formatCurrency(value) {
      var formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format ribuan
      return formatted;
    }
  });
</script> -->