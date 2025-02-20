<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar1'); ?>
<!-- Main Dashboard Content -->
<div id="main">
	<header class="mb-3">
		<a href="#" class="burger-btn d-block d-xl-none">
			<i class="bi bi-justify fs-3"></i>
		</a>
	</header>

	<div class="page-heading">
		<h3>Dashboard Overview</h3>
	</div>

	<div class="page-content">
		<section class="row">
			<!-- Example Cards -->
			<div class="col-12 col-lg-12">
				<div class="row">
					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-3 py-4-5">
								<div class="row">
									<div class="col-md-4">
										<div class="stats-icon purple">
											<i class="iconly-boldShow"></i>
										</div>
									</div>
									<div class="col-md-8">
										<h6 class="text-muted font-semibold">Pemasukan/bulan</h6>
										<h4 class="font-extrabold mb-0">
											<?php
											if ($total_pemasukan->total_pemasukan > 0) {
												echo "Rp " . number_format($total_pemasukan->total_pemasukan, 0, ',', '.');
											} else {
												echo "Tidak Ada Pemasukan";
											}
											?>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-3 py-4-5">
								<div class="row">
									<div class="col-md-4">
										<div class="stats-icon blue">
											<i class="iconly-boldProfile"></i>
										</div>
									</div>
									<div class="col-md-8">
										<h6 class="text-muted font-semibold">Pengeluaran/bulan</h6>
										<h4 class="font-extrabold mb-0">
											<?php
											if ($total_pengeluaran->total_pengeluaran > 0) {
												echo "Rp " . number_format($total_pengeluaran->total_pengeluaran, 0, ',', '.');
											} else {
												echo "Tidak Ada Pengeluaran";
											}
											?>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-3 py-4-5">
								<div class="row">
									<div class="col-md-4">
										<div class="stats-icon green">
											<i class="iconly-boldAdd-User"></i>
										</div>
									</div>
									<div class="col-md-8">
										<h6 class="text-muted font-semibold">Keuntungan/bulan</h6>
										<h4 class="font-extrabold mb-0">
											<?php
											if ($keuntungan_bulan_ini > 0) {
												echo "Rp " . number_format($keuntungan_bulan_ini, 0, ',', '.');
											} elseif ($keuntungan_bulan_ini < 0) {
												echo "Kerugian: Rp " . number_format(abs($keuntungan_bulan_ini), 0, ',', '.');
											} else {
												echo "Tidak Ada Keuntungan";
											}
											?>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-6 col-lg-3 col-md-6">
						<div class="card">
							<div class="card-body px-3 py-4-5">
								<div class="row">
									<div class="col-md-4">
										<div class="stats-icon red">
											<i class="iconly-boldBookmark"></i>
										</div>
									</div>
									<div class="col-md-8">
										<h6 class="text-muted font-semibold">Pencatatan Susu/bulan</h6>
										<h4 class="font-extrabold mb-0">
											<?php echo number_format($total_pencatatan, 0, ',', '.') . ' Liter'; ?>
										</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				$user = $this->ion_auth->user()->row();
				$role = $this->ion_auth->get_users_groups()->row()->name;
				?>

				<div class="row">
					<!-- Card Ucapan Selamat Datang + Quick Buttons -->
					<div class="col-12">
						<div class="card bg-white text-primary">
							<div class="card-body">
								<h4>👋 Selamat Datang, <?= ucfirst($user->first_name) ?>!</h4>
								<p>Anda login sebagai <strong><?= ucfirst($role) ?></strong></p>

								<!-- Akses Cepat -->
								<hr>
								<h5 class="text-secondary">⚡ Akses Cepat</h5>

								<div class="row mt-3">
									<div class="col-md-3 mb-2">
										<a href="<?= site_url('pencatatan') ?>" class="btn btn-outline-primary w-100">
											<i class="bi bi-pencil-square"></i> Pencatatan Susu
										</a>
									</div>
									<div class="col-md-3 mb-2">
										<a href="<?= site_url('penjualan') ?>" class="btn btn-outline-success w-100">
											<i class="bi bi-cart-check-fill"></i> Penjualan Susu
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<?php $this->load->view('template/footer'); ?>
</div>