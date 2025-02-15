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
                    <h3>Data Pencatatan Susu</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pencatatan View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg border-10">
                        <div class="card-header bg-primary text-white text-center">
                            <strong><p class="mb-0" style="font-size: 25px;">Stok Susu</p></strong>
                        </div>
                        <br>
                        <div class="card-body text-center">
                            <h5 class="text-muted mb-3">Ini adalah stok susu saat ini:</h5>
                            <h1 class="display-4 fw-bold text-success">
                                <?php echo number_format($total_susu, 0, ',', '.') . ' Liter'; ?>
                            </h1>
                            <div class="mt-4">
                                <a href="<?php echo site_url('pencatatan'); ?>" class="btn btn-primary btn-md">
                                    Lihat Pencatatan
                                </a>
                                <a href="<?php echo site_url('penjualan'); ?>" class="btn btn-success btn-md">
                                    Jual Susu
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-light text-muted text-center">
                            <small>Data diperbarui secara real-time</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="col-lg-12">Riwayat Pencatatan</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="javascript:;" class="btn btn-success btn-pencatatan-add me-md-2 justify-content-md-end">
                            Tambah Data
                        </a>                    
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_pencatatan" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Jumlah Susu/hari</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal pencatatan -->
    <div class="modal fade text-left" id="pencatatan_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-dinamis">
                    <div class="modal-body">
                        <!-- Isi modal akan dimuat dinamis -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Tombol footer modal -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pencatatan_detail_modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-dinamis">
                    <!-- Konten detail akan dimuat di sini -->
                </div>                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <?php $this->load->view('template/footer'); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable dengan jQuery
            var table_pencatatan = $("#table_pencatatan").DataTable({
                "ajax": "<?= site_url('pencatatan/pencatatan_daftar'); ?>"
            });

            let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

            // Konfigurasi tombol tambah pencatatan
            $(document).on("click", ".btn-pencatatan-add", function() {
                let frame = $("#pencatatan_modal");

                // Menampilkan pesan loading
                frame.find(".modal-body").html(pesan_loading);

                // Menampilkan modal
                frame.modal("show");

                // Mengambil form tambah pencatatan
                $.get("<?= site_url('pencatatan/pencatatan_add'); ?>", function(res) {
                    frame.find(".modal-body").html(res);
                });
            });

            // Konfigurasi tombol edit pencatatan
            $(document).on("click", ".btn-pencatatan-edit", function() {
                let frame = $("#pencatatan_modal");

                frame.find(".modal-title").html("Edit pencatatan");
                frame.find(".modal-dinamis").html(pesan_loading);
                frame.modal("show");
                let id_pencatatan = $(this).data("id");

                $.get("<?= site_url('pencatatan/pencatatan_edit'); ?>/"+id_pencatatan, function(res) {
                    frame.find(".modal-dinamis").html(res);
                });
            });

            // Konfigurasi tombol detail pencatatan
            $(document).on("click", ".btn-pencatatan-detail", function() {
            let id_pencatatan = $(this).data("id"); // Ambil ID pencatatan dari tombol
            let frame = $("#pencatatan_detail_modal"); // Referensi ke modal

            frame.find(".modal-title").html("Detail Pencatatan");
            frame.find(".modal-dinamis").html(pesan_loading);
            frame.modal("show");

            // AJAX untuk mendapatkan form detail
            $.get("<?= site_url('pencatatan/pencatatan_detail/') ?>" + encodeURIComponent(id_pencatatan), function(res) {
                    frame.find(".modal-dinamis").html(res); // Isi modal dengan konten dari pencatatan_detail.php
                }).fail(function() {
                    frame.find(".modal-dinamis").html('<p class="text-danger">Terjadi kesalahan saat memuat detail pencatatan.</p>');
                });
            });
            
        });
    </script>
</div>
