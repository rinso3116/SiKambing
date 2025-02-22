<form id="form-kategori-add" action="<?php echo site_url('kategori/kategori_addsave'); ?>" method="post" autocomplete="off">
  <div class="modal-body">
    <div class="mb-3">
      <label for="nama_kategori">Nama kategori</label>
      <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama kategori" required>
    </div>
    <div class="mb-3">
      <label for="keterangan_kategori">Keterangan kategori</label>
      <textarea class="form-control" id="keterangan_kategori" name="keterangan_kategori" rows="3" placeholder="Masukkan Keterangan"></textarea>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Tambah</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <i class="bx bx-x d-block d-sm-none"></i>
        <span class="d-none d-sm-block">Close</span>
      </button>
    </div>
  </div>
</form>

<script type="text/javascript">
  $(document).ready(function() {
    // Submit form via AJAX
    $('#form-kategori-add').on('submit', function(e) {
      e.preventDefault(); // Prevent form from submitting normally

      // Serialize form data
      var formData = new FormData(this); // 'this' refers to the form element

      // AJAX request
      $.ajax({
        url: '<?= site_url("kategori/kategori_addsave") ?>', // Change to your form action URL
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(response) {
          // Jika berhasil
          toastr.success('kategori berhasil ditambahkan!', 'Sukses');

          $('#kategori_modal').modal('hide');
          $('#table_kategori').DataTable().ajax.reload(); // Memperbarui DataTable
        },
        error: function(xhr, status, error) {
          // Jika terjadi error
          toastr.error('Terjadi kesalahan saat menambahkan kategori.', 'Error');
        }
      });
    });
  });
</script>