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
                    <h3>Data kategori</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">kategori View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="col-lg-12">Data kategori</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="javascript:;" class="btn btn-success btn-kategori-add me-md-2 justify-content-md-end">
                            Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_kategori" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama kategori</th>
                                <th scope="col">Keterangan kategori</th>
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

    <!-- Modal kategori -->
    <div class="modal fade text-left" id="kategori_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Modal title</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
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

    <?php $this->load->view('template/footer'); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi DataTable dengan jQuery
            var table_kategori = $("#table_kategori").DataTable({
                "ajax": "<?= site_url('kategori/kategori_daftar'); ?>"
            });

            let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

            // Konfigurasi tombol hapus kategori
            $(document).on("click", ".btn-kategori-delete", function() {
                var id_kategori = $(this).data("id");
                var url = "<?= site_url('kategori/kategori_delete_post'); ?>";

                bootbox.confirm({
                    message: "Apakah Anda yakin ingin menghapus kategori ini?",
                    buttons: {
                        confirm: {
                            label: "Hapus",
                            className: "btn-danger"
                        },
                        cancel: {
                            label: "Batal",
                            className: "btn-secondary"
                        }
                    },
                    callback: function(result) {
                        if (result) {
                            $.post(url, {
                                id_kategori: id_kategori
                            }, function(res) {
                                if (res.status == "sukses") {
                                    toastr.success(res.pesan);
                                    table_kategori.ajax.reload();
                                } else {
                                    toastr.warning(res.pesan);
                                }
                            });
                        }
                    }
                });
            });

            /// Konfigurasi tombol tambah kategori
            $(document).on("click", ".btn-kategori-add", function() {
                let frame = $("#kategori_modal");
                frame.find(".modal-title").html("Tambah kategori");
                frame.find(".modal-body").html(pesan_loading);
                frame.find(".modal-footer").html(""); // Hapus tombol lama
                frame.modal("show");
                // Mengambil form tambah kategori
                $.get("<?= site_url('kategori/kategori_add'); ?>", function(res) {
                    frame.find(".modal-body").html(res);
                });
            });

            // Konfigurasi tombol edit kategori
            $(document).on("click", ".btn-kategori-edit", function() {
                let frame = $("#kategori_modal");

                frame.find(".modal-title").html("Edit kategori");
                frame.find(".modal-body").html(pesan_loading);
                frame.find(".modal-footer").html(""); // Hapus tombol lama
                frame.modal("show");
                let id_kategori = $(this).data("id");

                $.get("<?= site_url('kategori/kategori_edit'); ?>/" + id_kategori, function(res) {
                    frame.find(".modal-dinamis").html(res);
                });
            });
        });
    </script>

</div>