<form id="form-penjualan-add" action="<?php echo site_url('penjualan/penjualan_addsave'); ?>" method="post" autocomplete="off">
  <div class="modal-body">
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="jumlah_susu">Jumlah Susu (liter)</label>
        <input type="number" class="form-control" id="jumlah_susu" name="jumlah_susu" placeholder="Masukkan jumlah susu (liter)" required>
      </div>
      <div class="col-md-6">
        <label for="harga_per_liter">Harga per Liter</label>
        <input type="text" class="form-control" id="harga_per_liter" name="harga_per_liter" placeholder="Masukkan harga per liter" required>
      </div>
    </div>
    <div class="mb-3">
      <label for="menjual_ke">Menjual ke</label>
      <input type="text" class="form-control" id="menjual_ke" name="menjual_ke" placeholder="Masukkan nama pembeli" required>
    </div>
    <div class="mb-3">
      <label for="keterangan">Keterangan</label>
      <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
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
  document.getElementById('harga_per_liter').addEventListener('input', function(e) {
    // Format nilai input ke Rupiah
    e.target.value = formatRupiah(e.target.value);
  });

  // Event listener untuk form submit
  document.getElementById('form-penjualan-add').addEventListener('submit', function(e) {
    // Konversi nilai Rupiah kembali ke angka sebelum submit
    let hargaInput = document.getElementById('harga_per_liter');
    hargaInput.value = toNumber(hargaInput.value);
  });

//konfigurasi penjualan addsave
  $(document).ready(function() {
        // Submit form via AJAX
    $('#form-penjualan-add').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Serialize form data
            var formData = new FormData(this); // 'this' refers to the form element

            // AJAX request
            $.ajax({
                url: '<?= site_url("penjualan/penjualan_addsave") ?>', // Change to your form action URL
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    // Jika berhasil
                  toastr.success('penjualan berhasil ditambahkan!', 'Sukses');

                  $('#penjualan_modal').modal('hide');
                    $('#table_penjualan').DataTable().ajax.reload(); // Memperbarui DataTable
                  },
                  error: function(xhr, status, error) {
                    // Jika terjadi error
                    toastr.error('Terjadi kesalahan saat menambahkan penjualan.', 'Error');
                  }
                });
          });
  });
</script>