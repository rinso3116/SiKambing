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

			<ul class="menu">
				<li class="sidebar-title">Menu</li>

				<li class="sidebar-item <?= ($uri == 'dashboard') ? 'active' : ''; ?>">
					<a href="<?= site_url('dashboard') ?>" class='sidebar-link'>
						<i class="bi bi-grid-fill"></i>
						<span>Dashboard</span>
					</a>
				</li>

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
				<li class="sidebar-title">Filter Laporan</li>
				<li class="sidebar-item <?= ($uri == 'laporan') ? 'active' : ''; ?>">
					<a href="<?= site_url('laporan') ?>" class='sidebar-link'>
						<i class="bi bi-clipboard2-data-fill"></i>
						<span>Laporan Kandang</span>
					</a>
				</li>
			</ul>
		</div>
		<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
	</div>
</div>