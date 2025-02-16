<form id="form-pengeluaran-edit" action="<?php echo site_url('pengeluaran/pengeluaran_update'); ?>" method="post" autocomplete="off">
  <input type="hidden" id="id_pengeluaran" name="id_pengeluaran" value="<?php echo $pengeluaran->id_pengeluaran; ?>">
  <div class="modal-body">
    <div class="mb-3">
      <label for="jumlah" class="form-label">Jumlah pengeluaran</label>
      <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo number_format($pengeluaran->jumlah, 0, ',', '.'); ?>" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $pengeluaran->keterangan; ?></textarea>
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
  // Menambahkan format angka pada input Jumlah pengeluaran
  $(document).ready(function() {
    // Format nilai input sebagai format angka (misalnya 1.000,00)
    $('#jumlah').on('input', function() {
      var value = $(this).val().replace(/\D/g, ''); // Hapus karakter selain angka
      $(this).val(formatCurrency(value));
    });

    function formatCurrency(value) {
      var formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Format ribuan
      return formatted;
    }
  });

  $(document).ready(function() {
    // Submit form via AJAX
    $('#form-pengeluaran-edit').on('submit', function(e) {
      e.preventDefault(); // Prevent form from submitting normally

      // Serialize form data
      var formData = new FormData(this); // 'this' refers to the form element

      // AJAX request
      $.ajax({
        url: '<?= site_url("pengeluaran/pengeluaran_update") ?>', // Change to your form action URL
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(response) {
          // Jika berhasil
          toastr.success('pengeluaran berhasil diupdate!', 'Sukses');

          $('#pengeluaran_modal').modal('hide');
          $('#table_pengeluaran').DataTable().ajax.reload(); // Memperbarui DataTable
        },
        error: function(xhr, status, error) {
          // Jika terjadi error
          toastr.error('Terjadi kesalahan saat update data pengeluaran.', 'Error');
        }
      });
    });
  });
</script>