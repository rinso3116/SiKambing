<form id="form-pengeluaran-add" action="<?php echo site_url('pengeluaran/pengeluaran_addsave'); ?>" method="post" autocomplete="off">
  <div class="modal-body">
    <div class="mb-3">
      <label for="jumlah">Jumlah pengeluaran (Rp)</label>
      <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah pengeluaran" required>
    </div>
    <div class="mb-3">
      <label for="keterangan">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan" required></textarea>
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

<script>
  // Fungsi untuk memformat angka ke format Rupiah
  function formatRupiah(angka) {
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Tambahkan titik jika yang diinput sudah menjadi angka ribuan
    if (ribuan) {
      let separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah ? 'Rp ' + rupiah : '';
  }

  // Fungsi untuk mengembalikan format angka ke bentuk asli (tanpa "Rp" dan titik)
  function toNumber(rupiah) {
    return parseInt(rupiah.replace(/[^,\d]/g, ''), 10);
  }

  // Event listener untuk input harga
  document.getElementById('jumlah').addEventListener('input', function(e) {
    // Format nilai input ke Rupiah
    e.target.value = formatRupiah(e.target.value);
  });

  // Event listener untuk form submit
  document.getElementById('form-pengeluaran-add').addEventListener('submit', function(e) {
    // Konversi nilai Rupiah kembali ke angka sebelum submit
    let hargaInput = document.getElementById('jumlah');
    hargaInput.value = toNumber(hargaInput.value);
  });

  //konfigurasi pengeluaran addsave
  $(document).ready(function() {
    // Submit form via AJAX
    $('#form-pengeluaran-add').on('submit', function(e) {
      e.preventDefault(); // Prevent form from submitting normally

      // Serialize form data
      var formData = new FormData(this); // 'this' refers to the form element

      // AJAX request
      $.ajax({
        url: '<?= site_url("pengeluaran/pengeluaran_addsave") ?>', // Change to your form action URL
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,

        success: function(response) {
          // Jika berhasil
          toastr.success('pengeluaran berhasil ditambahkan!', 'Sukses');

          $('#pengeluaran_modal').modal('hide');
          $('#table_pengeluaran').DataTable().ajax.reload(); // Memperbarui DataTable
        },
        error: function(xhr, status, error) {
          // Jika terjadi error
          toastr.error('Terjadi kesalahan saat menambahkan pengeluaran.', 'Error');
        }
      });
    });
  });
</script>