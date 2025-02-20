<div id="sidebar" class="active">
	<div class="sidebar-wrapper active">
		<div class="sidebar-header">
			<div class="d-flex justify-content-between">
				<div class="logo">
					<a href="<?= site_url('dashboard'); ?>"><img src="<?= base_url('assets/assets/images/logo/sikambing.png') ?>"
							alt="SiKambing Logo"
							style="width: 230px; height: auto;">
					</a>
				</div>
				<div class="toggler">
					<a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
				</div>
			</div>
		</div>
		<div class="sidebar-menu">
			<?php $uri = $this->uri->segment(1);  // Mengambil segment pertama dari URL
			?>

			<<?php
				$user = $this->ion_auth->user()->row();
				$role = $this->ion_auth->get_users_groups()->row()->id; // Ambil ID role
				?>

				<ul class="menu">
				<li class="sidebar-title">Menu</li>

				<li class="sidebar-item <?= ($uri == 'dashboard') ? 'active' : ''; ?>">
					<a href="<?= site_url('dashboard') ?>" class='sidebar-link'>
						<i class="bi bi-grid-fill"></i>
						<span>Dashboard</span>
					</a>
				</li>

				<!-- Hanya tampil untuk Admin (1) dan Peternak (2) -->
				<?php if ($role == 1 || $role == 2) : ?>
					<li class="sidebar-item has-sub <?= ($uri == 'ternak' || $uri == 'kategori') ? 'active menu-open' : ''; ?>">
						<a href="#" class='sidebar-link'>
							<i class="bi bi-archive-fill"></i>
							<span>Manajemen Ternak</span>
						</a>
						<ul class="submenu" style="<?= ($uri == 'ternak' || $uri == 'kategori') ? 'display: block;' : ''; ?>">
							<li class="submenu-item <?= ($uri == 'ternak') ? 'active' : ''; ?>">
								<a href="<?= site_url('ternak') ?>">Data Ternak</a>
							</li>
							<li class="submenu-item <?= ($uri == 'kategori') ? 'active' : ''; ?>">
								<a href="<?= site_url('kategori') ?>">Data Jenis Ternak</a>
							</li>
						</ul>
					</li>
				<?php endif; ?>

				<?php if ($role == 1 || $role == 2) : ?>
					<li class="sidebar-title">Manajemen Susu</li>
					<li class="sidebar-item <?= ($uri == 'pencatatan') ? 'active' : ''; ?>">
						<a href="<?= site_url('pencatatan') ?>" class='sidebar-link'>
							<i class="bi bi-menu-button-fill"></i>
							<span>Pencatatan Susu</span>
						</a>
					</li>
					<li class="sidebar-item <?= ($uri == 'penjualan') ? 'active' : ''; ?>">
						<a href="<?= site_url('penjualan') ?>" class='sidebar-link'>
							<i class="bi bi-bar-chart-line-fill"></i>
							<span>Penjualan Susu</span>
						</a>
					</li>
				<?php endif; ?>

				<!-- Hanya Admin (1) yang bisa melihat Keuangan Kandang -->
				<?php if ($role == 1) : ?>
					<li class="sidebar-title">Keuangan Kandang</li>
					<li class="sidebar-item <?= ($uri == 'pemasukan') ? 'active' : ''; ?>">
						<a href="<?= site_url('pemasukan') ?>" class='sidebar-link'>
							<i class="bi bi-building-fill-add"></i>
							<span>Pemasukan Kandang</span>
						</a>
					</li>
					<li class="sidebar-item <?= ($uri == 'pengeluaran') ? 'active' : ''; ?>">
						<a href="<?= site_url('pengeluaran') ?>" class='sidebar-link'>
							<i class="bi bi-building-fill-dash"></i>
							<span>Pengeluaran Kandang</span>
						</a>
					</li>
				<?php endif; ?>

				<!-- Hanya Admin (1) yang bisa melihat Pengaturan User -->
				<?php if ($role == 1) : ?>
					<li class="sidebar-title">Manajemen User</li>
					<li class="sidebar-item <?= ($uri == 'pengaturan') ? 'active' : ''; ?>">
						<a href="<?= site_url('pengaturan') ?>" class='sidebar-link'>
							<i class="bi bi-person-fill-gear"></i>
							<span>Pengaturan User</span>
						</a>
					</li>
				<?php endif; ?>
				</ul>
				<br>
				<div class="d-flex justify-content-center">
					<a href="javascript:void(0);" id="logoutBtn" class="btn btn-danger">
						<i class="bi bi-box-arrow-right"></i> Logout
					</a>
				</div>
		</div>
		<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
	</div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootbox.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script>
	$(document).ready(function() {
		$('#logoutBtn').click(function(e) {
			e.preventDefault(); // Mencegah pengalihan langsung ke halaman logout

			bootbox.confirm({
				message: "Apakah Anda yakin ingin logout?",
				buttons: {
					confirm: {
						label: 'Ya, Logout',
						className: 'btn-success'
					},
					cancel: {
						label: 'Batal',
						className: 'btn-danger'
					}
				},
				callback: function(result) {
					if (result) {
						// Jika pengguna klik "Ya", arahkan ke halaman logout
						window.location.href = '<?= site_url('auth/logout') ?>';
					}
				}
			});
		});
	});
</script>