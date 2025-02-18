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
					<h3>Pengaturan User</h3>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
							<li class="breadcrumb-item active" aria-current="page">Pengaturan View</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<section class="section">
			<div class="card">
				<div class="card-header">
					<h4 class="col-lg-12">Data User</h4>
					<div class="d-grid gap-2 d-md-flex justify-content-md-end">
						<a href="<?php echo base_url('pengaturan/user_add/'); ?>" class="btn btn-success btn-pencatatan-add me-md-2 justify-content-md-end">
							Tambah Data
						</a>
					</div>
				</div>
				<div class="card-body">
					<?php $list_user = $this->Model_pengaturan->list_user(); ?>
					<table id="userTable" class="table table-striped">
						<thead>
							<tr>
								<th>Nama User</th>
								<th>Status User</th>
								<th>Email User</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($list_user as $key): ?>
								<tr>
									<td><?= $key->first_name; ?></td>
									<td><?= $key->description; ?></td>
									<td><?= $key->email; ?></td>
									<!-- Tombol Edit & Delete -->
									<td width="200px">
										<a href="<?= base_url('pengaturan/user_edit/' . $key->id); ?>" class="btn btn-warning btn-sm">Edit</a>
										<a href="javascript:void(0);" class="btn btn-danger btn-user-delete btn-sm" data-id="<?= $key->id; ?>">Delete</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>

	<?php $this->load->view('template/footer') ?>

	<script type="text/javascript">
		$(document).ready(function() {
			// Inisialisasi DataTables
			$('#userTable').DataTable({
				"paging": true,
				"ordering": true,
				"searching": true
			});

			// Konfigurasi tombol hapus user
			$(document).on("click", ".btn-user-delete", function() {
				var id_user = $(this).data("id");
				var url = "<?= site_url('pengaturan/user_delete_post'); ?>";

				bootbox.confirm({
					message: "Apakah Anda yakin ingin menghapus user ini?",
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
								id_user: id_user
							}, function(res) {
								if (res.status === "sukses") {
									toastr.success(res.pesan);
									// Hapus baris tabel secara manual
									$('#userTable')
										.DataTable()
										.row($(`a[data-id="${id_user}"]`).parents('tr'))
										.remove()
										.draw();
								} else {
									toastr.warning(res.pesan);
								}
							}, 'json').fail(function() {
								toastr.error('Terjadi kesalahan pada server.');
							});
						}
					}
				});
			});
		});
	</script>
</div>