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
							<hr>
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
				<div class="modal-header bg-info">
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

			// Konfigurasi tombol hapus pemasukan
			$(document).on("click", ".btn-pemasukan-delete", function() {
				var id_pemasukan = $(this).data("id");
				var url = "<?= site_url('pemasukan/pemasukan_delete_post'); ?>";

				bootbox.confirm({
					message: "Apakah Anda yakin ingin menghapus pemasukan ini?",
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
								id_pemasukan: id_pemasukan
							}, function(res) {
								if (res.status == "sukses") {
									toastr.success(res.pesan);
									table_pemasukan.ajax.reload();
								} else {
									toastr.warning(res.pesan);
								}
							});
						}
					}
				});
			});

			$(document).on("click", ".btn-pemasukan-add", function() {
				let frame = $("#pemasukan_modal");

				frame.find(".modal-title").html("Tambah pemasukan");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");

				$.get("<?= site_url('pemasukan/pemasukan_add'); ?>", function(res) {
					frame.find(".modal-dinamis").html(res);

					// Event submit form tambah pemasukan
					frame.find("#form-pemasukan-add").on("submit", function(e) {
						e.preventDefault();
						let form = $(this);
						let data = form.serialize();

						$.ajax({
							url: form.attr("action"),
							type: "POST",
							data: data,
							dataType: "json",
							success: function(res) {
								console.log("Response dari server:", res); // Debugging

								if (res.status === "sukses") {
									toastr.success(res.pesan, "Berhasil");

									// Tutup modal setelah sukses
									frame.modal("hide");

									// Tunggu 1.5 detik sebelum reload agar toastr terlihat
									setTimeout(function() {
										location.reload();
									}, 1000);
								} else {
									toastr.error(res.pesan, "Gagal");
								}
							},
							error: function(xhr, status, error) {
								console.error("AJAX Error:", error);
								toastr.error("Terjadi kesalahan pada server!", "Error");
							}
						});
					});
				});
			});

			// $(document).on("click", ".btn-pencatatan-detail", function() {
			// 	let frame = $("#pencatatan_detail_modal");

			// 	frame.find(".modal-title").html("Tambah pencatatan");
			// 	frame.find(".modal-dinamis").html(pesan_loading);
			// 	frame.modal("show");

			// 	$.get("<?= site_url('pencatatan/pencatatan_detail'); ?>", function(res) {
			// 		frame.find(".modal-dinamis").html(res);

			//         // Event submit form tambah
			// 		frame.find("#form-tambah-pencatatan").on("submit", function(e) {
			// 			e.preventDefault();
			// 			let data = $(this).serialize();
			// 			$.post($(this).attr("action"), data, function(res) {
			// 				if (res.status == "sukses") {
			// 					toastr.success("pencatatan berhasil ditambahkan!", "Berhasil");
			// 					frame.modal("hide");
			// 					table_pencatatan.ajax.reload();
			// 				} else {
			// 					toastr.error(res.pesan, "Gagal");
			// 				}
			// 			});
			// 		});
			// 	});
			// });

			$(document).on("click", ".btn-pemasukan-detail", function() {
				var id_pemasukan = $(this).data('id'); // Ambil ID pemasukan dari tombol yang diklik

				var frame = $("#pemasukan_detail_modal");
				frame.find(".modal-title").html("Detail pemasukan");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");

				$.get("<?php echo site_url('pemasukan/pemasukan_detail'); ?>/" + id_pemasukan, function(res) {
					frame.find(".modal-dinamis").html(res); // Isi modal dengan form detail
				});
			});


			// Konfigurasi tombol edit pemasukan
			$(document).on("click", ".btn-pemasukan-edit", function() {
				let frame = $("#pemasukan_modal");

				frame.find(".modal-title").html("Edit pemasukan");
				frame.find(".modal-dinamis").html(pesan_loading);
				frame.modal("show");
				let id_pemasukan = $(this).data("id");

				$.get("<?= site_url('pemasukan/pemasukan_edit'); ?>/" + id_pemasukan, function(res) {
					frame.find(".modal-dinamis").html(res);

					// Event submit form edit
					frame.find("#form-edit-pemasukan").on("submit", function(e) {
						e.preventDefault();
						let data = $(this).serialize();
						$.post($(this).attr("action"), data, function(res) {
							if (res.status == "sukses") {
								toastr.success("pemasukan berhasil diperbarui!", "Berhasil");
								frame.modal("hide");
								table_pencatatan.ajax.reload();
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