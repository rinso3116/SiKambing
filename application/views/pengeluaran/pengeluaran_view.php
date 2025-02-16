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
					<h3>Data pengeluaran susu</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">pengeluaran View</li>
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
								<p class="mb-0" style="font-size: 25px;">pengeluaran Kandang</p>
							</strong>
						</div>
						<div class="card-body text-center">
							<br>
							<h5 class="text-muted mb-3">Total pengeluaran Kandang:</h5>
							<h1 class="display-5 fw-bold text-primary">
								Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?>
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
					<h4 class="col-lg-12">Riwayat pengeluaran</h4>
					<div class="d-grid gap-2 d-md-flex justify-content-md-end">
						<a href="javascript:;" class="btn btn-success btn-pengeluaran-add me-md-2 justify-content-md-end">
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body">
					<table id="table_pengeluaran" class="table table-striped">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Jumlah</th>
								<th scope="col">Keterangan</th>
								<th scope="col">Tanggal</th>
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

	<!-- Modal pengeluaran -->
	<div class="modal fade text-left" id="pengeluaran_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
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

	<div class="modal fade" id="pengeluaran_detail_modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
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
			var table_pengeluaran = $("#table_pengeluaran").DataTable({
				"ajax": "<?= site_url('pengeluaran/pengeluaran_daftar'); ?>"
			});

			let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

			// Konfigurasi tombol tambah pengeluaran
			$(document).on("click", ".btn-pengeluaran-add", function() {
				let frame = $("#pengeluaran_modal");

				frame.find(".modal-title").html("Tambah Pengeluaran");
				frame.find(".modal-body").html(pesan_loading);
				frame.find(".modal-footer").html(""); // Hapus tombol lama
				frame.modal("show");
				// Mengambil form tambah pengeluaran
				$.get("<?= site_url('pengeluaran/pengeluaran_add'); ?>", function(res) {
					frame.find(".modal-body").html(res);
				});
			});

			// Konfigurasi tombol detail pengeluaran
			$(document).on("click", ".btn-pengeluaran-detail", function() {
				let id_pengeluaran = $(this).data("id"); // Ambil ID pengeluaran dari tombol
				let frame = $("#pengeluaran_detail_modal"); // Referensi ke modal

				frame.find(".modal-title").html("Detail pengeluaran Susu");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");

				// AJAX untuk mendapatkan form detail
				$.get("<?= site_url('pengeluaran/pengeluaran_detail/') ?>" + encodeURIComponent(id_pengeluaran), function(res) {
					frame.find(".modal-dinamis").html(res); // Isi modal dengan konten dari pengeluaran_detail.php
				}).fail(function() {
					frame.find(".modal-dinamis").html('<p class="text-danger">Terjadi kesalahan saat memuat detail pengeluaran.</p>');
				});
			});

			// Konfigurasi tombol edit pengeluaran
			$(document).on("click", ".btn-pengeluaran-edit", function() {
				let frame = $("#pengeluaran_modal");
				frame.find(".modal-title").html("Edit Pengeluaran");
				frame.find(".modal-body").html(pesan_loading);
				frame.find(".modal-footer").html(""); // Hapus tombol lama
				frame.modal("show");

				let id_pengeluaran = $(this).data("id");

				$.get("<?= site_url('pengeluaran/pengeluaran_edit'); ?>/" + id_pengeluaran, function(res) {
					frame.find(".modal-dinamis").html(res);
				});
			});

			// Toastr alert jika pengeluaran berasal dari transaksi penjualan
			$(document).on("click", ".btn-alert-edit", function() {
				toastr.warning("pengeluaran ini berasal dari penjualan. Silakan edit di menu penjualan.");
			});
		});
	</script>

</div>