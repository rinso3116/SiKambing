<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Filter Laporan</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Tanggal Akhir</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="jenis_laporan" class="form-label">Jenis Laporan</label>
                                <select id="jenis_laporan" name="jenis_laporan" class="form-control" required>
                                    <option value="">-- Pilih Laporan --</option>
                                    <option value="pencatatan">Pencatatan Susu</option>
                                    <option value="penjualan">Penjualan Susu</option>
                                    <option value="pengeluaran">Pengeluaran Kandang</option>
                                    <option value="pemasukan">Pemasukan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <button type="button" id="export-excel" class="btn btn-warning">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <div class="card mt-4" id="laporan-card" style="display: none;">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Hasil Laporan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="laporan-table" class="table table-striped">
                    <thead class="table-dark">
                        <tr id="laporan-header">
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="laporan-container">
                        <tr>
                            <td colspan="5" class="text-center">Silakan filter laporan terlebih dahulu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $this->load->view('template/footer'); ?>

    <script>
        $(document).ready(function() {
            let table = $('#laporan-table').DataTable();

            $('#filter-form').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: '<?= site_url('laporan/getLaporan') ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            table.clear().destroy();
                            let headerHtml = '<tr><th>#</th><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th></tr>';
                            $('#laporan-header').html(headerHtml);

                            let bodyHtml = '';
                            response.forEach((data, index) => {
                                bodyHtml += `<tr>
                            <td>${index + 1}</td>
                            <td>${data.tanggal}</td>
                            <td>${data.jenis}</td>
                            <td>${data.jumlah}</td>
                            <td>${data.keterangan}</td>
                        </tr>`;
                            });

                            $('#laporan-container').html(bodyHtml);
                            $('#laporan-card').show();
                            table = $('#laporan-table').DataTable();
                            toastr.success('Laporan berhasil ditampilkan.');
                        } else {
                            toastr.error('Tidak ada data yang ditemukan.');
                        }
                    }
                });
            });

            $('#export-excel').click(function() {
                window.location.href = '<?= site_url('laporan/exportExcel') ?>';
            });
        });
    </script>
</div>