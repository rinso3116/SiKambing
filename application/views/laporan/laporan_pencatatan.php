<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Susu (Liter)</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $row): ?>
            <tr>
                <td><?= $row->tanggal; ?></td>
                <td><?= $row->jumlah_susu; ?></td>
                <td><?= $row->keterangan; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>