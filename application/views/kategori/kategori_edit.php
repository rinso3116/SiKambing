<form action="<?php echo site_url('kategori/kategori_update'); ?>" method="post">
    <input type="hidden" name="id_kategori" value="<?php echo $kategori->id_kategori; ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" 
            value="<?php echo $kategori->nama_kategori; ?>" required>
        </div>

        <div class="mb-3">
            <label for="keterangan_kategori">Keterangan</label>
            <textarea class="form-control" id="keterangan_kategori" name="keterangan_kategori" rows="3"><?php echo $kategori->keterangan_kategori; ?></textarea>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</form>

