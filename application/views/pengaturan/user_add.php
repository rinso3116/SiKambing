<?php $this->load->view('template/header'); ?>
<style>
	/* Custom styling for the navbar */
	.navbar-custom {
		background: linear-gradient(45deg, #4b6cb7, #182848);
		/* Gradient background */
		font-family: 'Poppins', sans-serif;
		/* Stylish font */
	}

	.navbar-custom .navbar-brand {
		color: #ffffff;
		/* White text */
		font-weight: 600;
		font-size: 1.5rem;
		/* Larger brand font */
	}

	.navbar-custom .nav-link {
		color: #ffffff;
		/* White text */
		font-weight: 400;
		margin-right: 15px;
	}

	.navbar-custom .nav-link:hover {
		color: #ffdd57;
		/* Yellow text on hover */
	}

	.navbar-custom .dropdown-menu {
		background-color: #4b6cb7;
		/* Dropdown background */
	}

	.navbar-custom .dropdown-item {
		color: #ffffff;
		/* White dropdown items */
	}

	.navbar-custom .dropdown-item:hover {
		background-color: #ffdd57;
		/* Yellow on hover */
		color: #182848;
		/* Dark text on hover */
	}

	.btn-custom {
		color: #ffffff;
		/* White text */
		background-color: #ffdd57;
		/* Yellow button background */
		border-color: #ffdd57;
	}

	.btn-custom:hover {
		background-color: #e1c146;
		/* Darker yellow on hover */
		border-color: #e1c146;
	}

	/* BIAR AGAK BAGUS*/
	.file-upload-container {
		width: 300px;
		height: 50px;
		overflow: hidden;
		background: #3F51B5;
		user-select: none;
		transition: all 150ms cubic-bezier(0.23, 1, 0.32, 1) 0ms;
		text-align: center;
		color: white;
		line-height: 50px;
		font-weight: 300;
		font-size: 16px;
	}

	.file-upload-container:hover {
		cursor: pointer;
		background: #3949AB;
	}
</style>
<?php $this->load->view('template/sidebar'); ?>
<div id="main">
	<header class="mb-3">
		<a href="#" class="burger-btn d-block d-xl-none">
			<i class="bi bi-justify fs-3"></i>
		</a>
	</header>

	<div class="page-heading">
		<section class="section">
			<div class="card">
				<div class="card-header">
					<h3 class="col-lg-12">Tambah User</h3>
				</div>
				<div class="card-body">
					<form action="<?= base_url('pengaturan/user_addsave') ?>" method="post">
						<div class="row">
							<div class="col-md-6">
								<input type="hidden" id="img-source" name="image_thumb" class="form-control" value="https://img.salaf.online/stock/junk_image.jpg" readonly>
								<img id="img-preview" src="https://img.salaf.online/stock/junk_image.jpg" class="rounded mx-auto d-block" alt="preview">
								<div class="text-center">
									<label class="file-upload-container" for="file-upload">
										<input id="file-upload" type="file" style="display:none;">
										Select an Image
									</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" class="form-control" id="first_name" name="first_name" required>
								</div>
								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" id="username" name="username" required>
								</div>
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" id="email" name="email" required>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="password" required>
								</div>
								<div class="form-group">
									<label for="status_user">Status user</label>
									<select name="status_user" id="status_user" class="form-control">
										<option value="1">Administrator</option>
										<option value="2">Peternak</option>
									</select>
								</div>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
	<?php $this->load->view('template/footer') ?>
	<script type="text/javascript">
		$(document).ready(function() {
			/* START UPLOAD TO IMG-HOST */
			var IMGHOST_URL = "<?= base_url(); ?>pengaturan/user_upload";
			var imgPreview = $("#img-preview");
			var imgSource = $("#img-source");
			var fileUpload = $("#file-upload");
			var load = "https://img.salaf.online/stock/junk_loading.gif";
			var junk = "https://img.salaf.online/stock/junk_image.jpg";

			// Ketika file dipilih
			fileUpload.on("change", function(event) {
				imgPreview.attr("src", load); // Set gambar loading saat upload
				var file = event.target.files[0]; // Ambil file yang dipilih

				var formData = new FormData();
				formData.append("img_file", file); // Tambahkan file ke FormData

				// Gunakan jQuery AJAX untuk upload gambar
				$.ajax({
					url: IMGHOST_URL,
					type: "POST",
					data: formData,
					processData: false, // Jangan proses data
					contentType: false, // Jangan set konten tipe
					success: function(res) {
						// Jika sukses
						if (res.status == 'sukses') {
							var jadi = res.link_url;
							imgPreview.attr("src", jadi); // Set gambar yang diupload sebagai preview
							imgSource.val(jadi); // Simpan URL gambar ke hidden input
						} else {
							alert("Maaf, gambar gagal diupload. Silahkan ulang/pilih gambar yang lain.");
							imgPreview.attr("src", junk); // Kembalikan ke gambar default jika gagal
							console.log(res);
						}
					},
					error: function(err) {
						// Jika ada error saat upload
						alert("Terjadi kesalahan saat upload gambar.");
						imgPreview.attr("src", junk); // Kembalikan ke gambar default jika gagal
						console.log(err);
					}
				});
			});
			/* END OF UPLOAD TO IMG-HOST */
		});
	</script>
</div>