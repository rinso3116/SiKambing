<form id="form-ternak-add" action="<?php echo site_url('ternak/ternak_addsave'); ?>" method="post" autocomplete="off">
  <div class="modal-body">
    <div class="col-md-12">
      <?php
      $list_kategori = $this->Model_ternak->list_kategori();
      ?>
    </div>
    <div class="mb-3">
      <label for="nama_ternak">Nama Ternak</label>
      <input type="text" class="form-control" id="nama_ternak" name="nama_ternak" placeholder="Masukkan Nama Ternak" required>
    </div>

    <div class="mb-3">
      <label for="id_kategori">Jenis Ternak</label>
      <select class="form-control" id="id_kategori" name="id_kategori" required>
        <option value="">-- Pilih Jenis Ternak --</option>
        <?php foreach ($list_kategori as $key): ?>
          <option value="<?php echo $key->id_kategori; ?>"><?php echo $key->nama_kategori; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="jenis_kelamin">Jenis Kelamin</label>
      <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Jantan">Jantan</option>
        <option value="Betina">Betina</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="jumlah">Jumlah</label>
      <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah" required>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Tambah</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    // Submit form via AJAX
    $('#form-ternak-add').on('submit', function(e) {
      e.preventDefault(); // Prevent form from submitting normally

      // Serialize form data
      var formData = new FormData(this); // 'this' refers to the form element

      // AJAX request
      $.ajax({
        url: '<?= site_url("ternak/ternak_addsave") ?>', // Change to your form action URL
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(response) {
          // Jika berhasil
          toastr.success('Data ternak berhasil ditambahkan!', 'Sukses');

          $('#ternak_modal').modal('hide');
          $('#table_ternak').DataTable().ajax.reload(); // Memperbarui DataTable
        },
        error: function(xhr, status, error) {
          // Jika terjadi error
          toastr.error('Terjadi kesalahan saat tambah data ternak.', 'Error');
        }
      });
    });
  });
</script>