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
