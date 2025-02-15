<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
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
										<h6 class="text-muted font-semibold">Profile Views</h6>
										<h6 class="font-extrabold mb-0">112,000</h6>
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
										<h6 class="text-muted font-semibold">Followers</h6>
										<h6 class="font-extrabold mb-0">183,000</h6>
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
										<h6 class="text-muted font-semibold">Following</h6>
										<h6 class="font-extrabold mb-0">80,000</h6>
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
										<h6 class="text-muted font-semibold">Saved Post</h6>
										<h6 class="font-extrabold mb-0">112</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Additional Content Area -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h4>Recent Activities</h4>
							</div>
							<div class="card-body">
								<p>Here you can add dynamic content or charts for a comprehensive dashboard experience.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<?php $this->load->view('template/footer'); ?>
