<form action="<?php echo site_url('ternak/ternak_editsave'); ?>" method="post">
    <input type="hidden" name="id_ternak" value="<?php echo $ternak->id_ternak; ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="nama_ternak" class="form-label">Nama Ternak</label>
            <input type="text" class="form-control" id="nama_ternak" name="nama_ternak" 
            value="<?php echo $ternak->nama_ternak; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Jenis Ternak</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategori as $k) : ?>
                    <option value="<?php echo $k->id_kategori; ?>" 
                        <?php echo ($k->id_kategori == $ternak->id_kategori) ? 'selected' : ''; ?>>
                        <?php echo $k->nama_kategori; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="Jantan" <?php echo ($ternak->jenis_kelamin == 'Jantan') ? 'selected' : ''; ?>>Jantan</option>
                <option value="Betina" <?php echo ($ternak->jenis_kelamin == 'Betina') ? 'selected' : ''; ?>>Betina</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" 
            value="<?php echo $ternak->jumlah; ?>" required>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</form>

