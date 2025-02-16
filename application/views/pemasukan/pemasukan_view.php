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
					<h3>Data pemasukan susu</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">pemasukan View</li>
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
								<p class="mb-0" style="font-size: 25px;">Pemasukan Kandang</p>
							</strong>
						</div>
						<div class="card-body text-center">
							<br>
							<h5 class="text-muted mb-3">Total Pemasukan Kandang:</h5>
							<h1 class="display-5 fw-bold text-primary">
								Rp <?php echo number_format($total_pemasukan, 0, ',', '.'); ?>
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
					<h4 class="col-lg-12">Riwayat pemasukan</h4>
					<div class="d-grid gap-2 d-md-flex justify-content-md-end">
						<a href="javascript:;" class="btn btn-success btn-pemasukan-add me-md-2 justify-content-md-end">
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body">
					<table id="table_pemasukan" class="table table-striped">
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

	<!-- Modal pemasukan -->
	<div class="modal fade text-left" id="pemasukan_modal" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true">
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

	<div class="modal fade" id="pemasukan_detail_modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
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
			var table_pemasukan = $("#table_pemasukan").DataTable({
				"ajax": "<?= site_url('pemasukan/pemasukan_daftar'); ?>"
			});

			let pesan_loading = "<p class='text-center'><em>Loading....</em></p>";

			// Konfigurasi tombol tambah pemasukan
			$(document).on("click", ".btn-pemasukan-add", function() {
				let frame = $("#pemasukan_modal");

				frame.find(".modal-title").html("Tambah Pemasukan");
				frame.find(".modal-body").html(pesan_loading);
				frame.find(".modal-footer").html(""); // Hapus tombol lama
				frame.modal("show");

				// Mengambil form tambah pemasukan
				$.get("<?= site_url('pemasukan/pemasukan_add'); ?>", function(res) {
					frame.find(".modal-body").html(res);
				});
			});

			// Konfigurasi tombol detail pemasukan
			$(document).on("click", ".btn-pemasukan-detail", function() {
				let id_pemasukan = $(this).data("id"); // Ambil ID pemasukan dari tombol
				let frame = $("#pemasukan_detail_modal"); // Referensi ke modal

				frame.find(".modal-title").html("Detail pemasukan Susu");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");

				// AJAX untuk mendapatkan form detail
				$.get("<?= site_url('pemasukan/pemasukan_detail/') ?>" + encodeURIComponent(id_pemasukan), function(res) {
					frame.find(".modal-dinamis").html(res); // Isi modal dengan konten dari pemasukan_detail.php
				}).fail(function() {
					frame.find(".modal-dinamis").html('<p class="text-danger">Terjadi kesalahan saat memuat detail pemasukan.</p>');
				});
			});

			// Konfigurasi tombol edit pemasukan
			$(document).on("click", ".btn-pemasukan-edit", function() {
				let frame = $("#pemasukan_modal");
				frame.find(".modal-title").html("Edit Pemasukan");
				frame.find(".modal-body").html(pesan_loading);
				frame.find(".modal-footer").html(""); // Hapus tombol lama
				frame.modal("show");

				let id_pemasukan = $(this).data("id");

				$.get("<?= site_url('pemasukan/pemasukan_edit'); ?>/" + id_pemasukan, function(res) {
					frame.find(".modal-dinamis").html(res);
				});
			});

			// Toastr alert jika pemasukan berasal dari transaksi penjualan
			$(document).on("click", ".btn-alert-edit", function() {
				toastr.warning("Pemasukan ini berasal dari penjualan. Silakan edit di menu penjualan.");
			});
		});
	</script>

</div>