<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('Model_dashboard');
	}
	public function index()
	{
		$bulan = date('m'); // Bulan saat ini
		$tahun = date('Y'); // Tahun saat ini

		// Mendapatkan total per bulan
		$data['total_pemasukan'] = $this->Model_dashboard->get_total_pemasukan_per_bulan($bulan, $tahun);
		$data['total_pengeluaran'] = $this->Model_dashboard->get_total_pengeluaran_per_bulan($bulan, $tahun);
		$data['total_pencatatan'] = $this->Model_dashboard->get_total_pencatatan_per_bulan($bulan, $tahun);

		// Menghitung keuntungan bulan ini
		$total_pemasukan = $data['total_pemasukan']->total_pemasukan;
		$total_pengeluaran = $data['total_pengeluaran']->total_pengeluaran;
		$data['keuntungan_bulan_ini'] = $total_pemasukan - $total_pengeluaran;

		// Menambahkan informasi lainnya
		$data['navbar'] = 'dashboard';
		$data['title'] = 'Dashboard - SiKambing';

		// Menampilkan view dengan data
		$this->load->view('dashboard', $data);
	}
}
