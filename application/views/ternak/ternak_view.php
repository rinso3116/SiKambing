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
                    <h3>Data Ternak</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ternak View</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="col-lg-12">Data Ternak</h4>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="javascript:;" class="btn btn-success btn-ternak-add me-md-2 justify-content-md-end">
                            Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_ternak" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Ternak</th>
                                <th scope="col">Jenis Ternak</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:center;">Total Ternak:</th>
                                <th id="total_jumlah_ternak">0 Ekor</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal ternak -->
    <div class="modal fade text-left" id="ternak_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
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
            var table_ternak = $("#table_ternak").DataTable({
                "ajax": {
                    "url": "<?= site_url('ternak/ternak_daftar'); ?>",
                    "dataSrc": function(json) {
                        // Tampilkan total jumlah ternak di footer
                        $("#total_jumlah_ternak").html(json.total_jumlah + " Ekor");
                        return json.data;
                    }
                },
                "processing": true,
                "serverSide": false
            });

            let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

            // Konfigurasi tombol hapus ternak
            $(document).on("click", ".btn-ternak-delete", function() {
                var id_ternak = $(this).data("id");
                var url = "<?= site_url('ternak/ternak_delete_post'); ?>";

                bootbox.confirm({
                    message: "Apakah Anda yakin ingin menghapus ternak ini?",
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
                                id_ternak: id_ternak
                            }, function(res) {
                                if (res.status == "sukses") {
                                    toastr.success(res.pesan);
                                    table_ternak.ajax.reload();
                                } else {
                                    toastr.warning(res.pesan);
                                }
                            });
                        }
                    }
                });
            });

            // Konfigurasi tombol tambah ternak
            $(document).on("click", ".btn-ternak-add", function() {
                let frame = $("#ternak_modal");

                frame.find(".modal-title").html("Tambah ternak");
                frame.find(".modal-body").html(pesan_loading);
                frame.find(".modal-footer").html(""); // Hapus tombol lama
                frame.modal("show");
                // Mengambil form tambah ternak
                $.get("<?= site_url('ternak/ternak_add'); ?>", function(res) {
                    frame.find(".modal-body").html(res);
                });
            });

            // Konfigurasi tombol edit ternak
            $(document).on("click", ".btn-ternak-edit", function() {
                let frame = $("#ternak_modal");

                frame.find(".modal-title").html("Edit ternak");
                frame.find(".modal-dinamis").html(pesan_loading);
                frame.modal("show");
                let id_ternak = $(this).data("id");
                $.get("<?= site_url('ternak/ternak_edit'); ?>/" + id_ternak, function(res) {
                    frame.find(".modal-dinamis").html(res);
                });
            });
        });
    </script>

</div>