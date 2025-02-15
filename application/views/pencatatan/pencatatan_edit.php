<form id="form-pencatatan-edit" action="<?php echo site_url('pencatatan/pencatatan_update'); ?>" method="post" autocomplete="off">
    <input type="hidden" id="id_pencatatan" name="id_pencatatan" value="<?php echo $pencatatan->id_pencatatan; ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="jumlah_susu" class="form-label">Jumlah Susu (liter)</label>
            <input type="number" id="jumlah_susu" name="jumlah_susu" class="form-control" value="<?php echo $pencatatan->jumlah_susu; ?>" required>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control"><?php echo $pencatatan->keterangan; ?></textarea>
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

<script type="text/javascript">
    $(document).ready(function() {
        function updateTotalSusu() {
            $.ajax({
                url: "<?= site_url('pencatatan') ?>", // Panggil fungsi index yang sudah support AJAX
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $("#total_susu").html(response.total_susu + ' Liter'); // Update langsung
                },
                error: function(xhr, status, error) {
                    console.error("Gagal memperbarui total susu:", error);
                }
            });
        }

        $('#form-pencatatan-edit').on('submit', function(e) {
            e.preventDefault(); // Mencegah reload

            var formData = new FormData(this);

            $.ajax({
                url: '<?= site_url("pencatatan/pencatatan_update") ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    toastr.success('Pencatatan berhasil diupdate!', 'Sukses');

                    $('#pencatatan_modal').modal('hide');
                    $('#table_pencatatan').DataTable().ajax.reload(); // Refresh DataTable

                    updateTotalSusu(); // Update total susu setelah edit berhasil
                },
                error: function(xhr, status, error) {
                    toastr.error('Terjadi kesalahan saat update data Pencatatan.', 'Error');
                }
            });
        });
    });
</script>