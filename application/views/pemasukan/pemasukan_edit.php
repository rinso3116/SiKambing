<form id="form-penjualan-edit" action="<?php echo site_url('penjualan/penjualan_update'); ?>" method="post" autocomplete="off">
  <input type="hidden" id="id_penjualan" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
  <div class="modal-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="edit_jumlah_susu" class="form-label">Jumlah Susu (liter)</label>
        <input type="number" class="form-control" id="edit_jumlah_susu" name="edit_jumlah_susu" value="<?php echo $penjualan->jumlah_susu; ?>" required>
      </div>
      <div class="col-md-6">
        <label for="edit_harga_per_liter" class="form-label">Harga per Liter</label>
        <input type="text" class="form-control" id="edit_harga_per_liter" name="edit_harga_per_liter" value="<?php echo number_format($penjualan->harga_per_liter, 0, ',', '.'); ?>" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="edit_menjual_ke" class="form-label">Menjual ke</label>
      <input type="text" class="form-control" id="edit_menjual_ke" name="edit_menjual_ke" value="<?php echo $penjualan->menjual_ke; ?>" required>
    </div>
    <div class="mb-3">
      <label for="edit_keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" rows="3"><?php echo $penjualan->keterangan; ?></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
      <i class="bx bx-x d-block d-sm-none"></i>
      <span class="d-none d-sm-block">Close</span>
    </button>
  </div>
</form>

<script>
    // Menambahkan format angka pada input harga per liter
  $(document).ready(function() {
        // Format nilai input sebagai format angka (misalnya 1.000,00)
    $('#edit_harga_per_liter').on('input', function() {
            var value = $(this).val().replace(/\D/g, ''); // Hapus karakter selain angka
            $(this).val(formatCurrency(value));
          });

    function formatCurrency(value) {
            var formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format ribuan
            return formatted;
          }
        });
      </script>
