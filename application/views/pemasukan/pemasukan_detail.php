<form id="form-penjualan-detail" action="#" method="post" autocomplete="off">
    <input type="hidden" id="id_penjualan" name="id_penjualan" value="<?php echo $penjualan->id_penjualan; ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="detail_jumlah_susu" class="form-label">Jumlah Susu (liter)</label>
            <input type="number" id="detail_jumlah_susu" name="detail_jumlah_susu" class="form-control" value="<?php echo $penjualan->jumlah_susu; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="detail_harga_per_liter" class="form-label">Harga per Liter</label>
            <input type="text" id="detail_harga_per_liter" name="detail_harga_per_liter" class="form-control" value="<?php echo number_format($penjualan->harga_per_liter, 0, ',', '.'); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="detail_total_harga" class="form-label">Total Harga</label>
            <input type="text" id="detail_total_harga" name="detail_total_harga" class="form-control" value="<?php echo number_format($penjualan->total_harga, 0, ',', '.'); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="detail_menjual_ke" class="form-label">Menjual ke</label>
            <input type="text" id="detail_menjual_ke" name="detail_menjual_ke" class="form-control" value="<?php echo $penjualan->menjual_ke; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="detail_keterangan" class="form-label">Keterangan</label>
            <textarea id="detail_keterangan" name="detail_keterangan" class="form-control" rows="3" readonly><?php echo $penjualan->keterangan; ?></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
        </button>
    </div>
</form>
