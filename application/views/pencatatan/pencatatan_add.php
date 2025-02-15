<form id="form-pencatatan-add" action="<?php echo site_url('pencatatan/pencatatan_addsave'); ?>" method="post" autocomplete="off">
  <div class="modal-body">
    <div class="mb-3">
      <label for="jumlah_susu" class="form-label">Jumlah Susu (liter)</label>
      <input type="number" id="jumlah_susu" name="jumlah_susu" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Tambah</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
      <i class="bx bx-x d-block d-sm-none"></i>
      <span class="d-none d-sm-block">Close</span>
    </button>
  </div>
</form>

<script type="text/javascript">
  $(document).ready(function() {
        // Submit form via AJAX
    $('#form-pencatatan-add').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Serialize form data
            var formData = new FormData(this); // 'this' refers to the form element

            // AJAX request
            $.ajax({
                url: '<?= site_url("pencatatan/pencatatan_addsave") ?>', // Change to your form action URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    // Jika berhasil
                  toastr.success('Pencatatan berhasil ditambahkan!', 'Sukses');

                  $('#pencatatan_modal').modal('hide');
                    $('#table_pencatatan').DataTable().ajax.reload(); // Memperbarui DataTable
                  },
                  error: function(xhr, status, error) {
                    // Jika terjadi error
                    toastr.error('Terjadi kesalahan saat menambahkan Pencatatan.', 'Error');
                  }
                });
          });
  });
</script>
