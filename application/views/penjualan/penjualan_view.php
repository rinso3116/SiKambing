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
					<h3>Data penjualan susu</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">penjualan View</li>
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
							<strong>
								<p class="mb-0" style="font-size: 25px;">Penjualan Susu</p>
							</strong>
						</div>
						<div class="card-body text-center">
							<hr>
							<h5 class="text-muted mb-3">Total Penjualan Susu:</h5>
							<h1 class="display-5 fw-bold text-danger">
								<?php echo number_format($total_penjualan, 0, ',', '.') . ' Liter'; ?>
							</h1>
							<hr>
							<h5 class="text-muted mb-3">Total Penghasilan dari Penjualan Susu:</h5>
							<h1 class="display-5 fw-bold text-primary">
								Rp <?php echo number_format($total_penghasilan, 0, ',', '.'); ?>
							</h1>
						</div>
						<div class="card-footer bg-light text-muted text-center">
							<small>Data diperbarui secara real-time</small>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h4 class="col-lg-12">Riwayat penjualan</h4>
					<div class="d-grid gap-2 d-md-flex justify-content-md-end">
						<a href="javascript:;" class="btn btn-success btn-penjualan-add me-md-2 justify-content-md-end">
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body">
					<table id="table_penjualan" class="table table-striped">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Jumlah Susu</th>
								<th scope="col">Harga/ltr</th>
								<th scope="col">Total Harga</th>
								<th scope="col">Jual Ke</th>
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

	<!-- Modal penjualan -->
	<div class="modal fade text-left" id="penjualan_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
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

	<div class="modal fade" id="penjualan_detail_modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle"></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body modal-dinamis">
					<!-- Konten detail akan dimuat di sini -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('template/footer'); ?>

	<script type="text/javascript">
		$(document).ready(function() {
			var table_penjualan = $("#table_penjualan").DataTable({
				"ajax": "<?= site_url('penjualan/penjualan_daftar'); ?>"
			});

			let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

			// Konfigurasi tombol tambah penjualan
			$(document).on("click", ".btn-penjualan-add", function() {
				let frame = $("#penjualan_modal");

				// Menampilkan pesan loading
				frame.find(".modal-body").html(pesan_loading);

				// Menampilkan modal
				frame.modal("show");

				// Mengambil form tambah penjualan
				$.get("<?= site_url('penjualan/penjualan_add'); ?>", function(res) {
					frame.find(".modal-body").html(res);
				});
			});

			// Konfigurasi tombol detail penjualan
			$(document).on("click", ".btn-penjualan-detail", function() {
				let id_penjualan = $(this).data("id"); // Ambil ID penjualan dari tombol
				let frame = $("#penjualan_detail_modal"); // Referensi ke modal

				frame.find(".modal-title").html("Detail penjualan Susu");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");

				// AJAX untuk mendapatkan form detail
				$.get("<?= site_url('penjualan/penjualan_detail/') ?>" + encodeURIComponent(id_penjualan), function(res) {
					frame.find(".modal-dinamis").html(res); // Isi modal dengan konten dari penjualan_detail.php
				}).fail(function() {
					frame.find(".modal-dinamis").html('<p class="text-danger">Terjadi kesalahan saat memuat detail penjualan.</p>');
				});
			});

			// Konfigurasi tombol edit penjualan
			$(document).on("click", ".btn-penjualan-edit", function() {
				let frame = $("#penjualan_modal");

				frame.find(".modal-title").html("Edit penjualan");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");
				let id_penjualan = $(this).data("id");

				$.get("<?= site_url('penjualan/penjualan_edit'); ?>/" + id_penjualan, function(res) {
					frame.find(".modal-dinamis").html(res);

					// Event submit form edit
					frame.find("#form-edit-penjualan").on("submit", function(e) {
						e.preventDefault();
						let data = $(this).serialize();
						$.post($(this).attr("action"), data, function(res) {
							if (res.status == "sukses") {
								toastr.success("penjualan berhasil diperbarui!", "Berhasil");
								frame.modal("hide");
								table_penjualan.ajax.reload();
							} else {
								toastr.error(res.pesan, "Gagal");
							}
						});
					});
				});
			});
		});
	</script>

</div>