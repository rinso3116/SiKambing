<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ternak extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
		$this->load->model('Model_ternak');
		$this->load->model('Model_kategori');
	}

	private function set_output($data)
	{
		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data, JSON_PRETTY_PRINT))
			->_display();
		exit;
	}

	public function index()
	{
		$data['ternak'] = $this->Model_ternak->list_ternak();
		$data['navbar'] = 'ternak';
		$data['title'] = 'Data Ternak - SiKambing';
		$this->load->view('ternak/ternak_view', $data);
	}

	public function ternak_daftar()
	{
		$daftar_ternak = $this->Model_ternak->list_ternak();
		$total_jumlah = 0;
		$daftar_input = array();
		$nomor = 1;

		foreach ($daftar_ternak as $key) {
			$total_jumlah += $key->jumlah;

			// Ambil 1 kategori ternak berdasarkan id_ternak
			$kategori = $this->Model_ternak->single_ternak_kategori($key->id_ternak);

			// Jika ada kategori, ambil nama kategorinya
			$nama_kategori = $kategori ? $kategori->nama_kategori : '-';

			// Masukkan ke dalam tabel
			$bahan_input = array(
				$nomor++,
				$key->nama_ternak,
				$nama_kategori,
				$key->jenis_kelamin,
				$key->jumlah,
				'<a href="javascript:;" data-id="' . $key->id_ternak . '" class="btn btn-warning btn-ternak-edit btn-sm m-1">Edit</a>' .
					'<a href="javascript:;" class="btn btn-danger btn-sm btn-ternak-delete" data-id="' . $key->id_ternak . '">Delete</a>',
			);
			array_push($daftar_input, $bahan_input);
		}

		$response = array(
			'data' => $daftar_input,
			'total_jumlah' => $total_jumlah
		);

		$this->set_output($response);
	}
	public function ternak_add()
	{
		$data['kategori'] = $this->Model_kategori->get_all_kategori();
		$this->load->view('ternak/ternak_add', $data);
	}

	public function ternak_addsave()
	{
		$data = [
			'nama_ternak'   => $this->input->post('nama_ternak'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'jumlah'        => $this->input->post('jumlah')
		];

		// Insert ke tabel ternak
		$id_ternak = $this->Model_ternak->add_ternak($data);

		// Ambil id_kategori dari form
		$id_kategori = $this->input->post('id_kategori');

		// Jika kategori tidak kosong, langsung insert ke tabel ternak_kategori
		if (!empty($id_kategori)) {
			$data_kategori = [
				'id_ternak'   => $id_ternak,
				'id_kategori' => $id_kategori // Langsung insert tanpa foreach
			];
			$this->Model_ternak->add_ternak_kategori($data_kategori);
		}

		$response = array(
			'status'	=> 'sukses',
			'pesan'		=> 'Data Ternak berhasil ditambahkan!',
		);
		$this->set_output($response);
	}

	public function ternak_edit($id_ternak)
	{
		$data['ternak'] = $this->Model_ternak->single_ternak($id_ternak);
		$this->load->view('ternak/ternak_edit', $data);
	}

	public function ternak_editsave()
	{
		$id_ternak = $this->input->post('id_ternak');
		$check_ternak = $this->Model_ternak->single_ternak($id_ternak);

		if (!$check_ternak) {
			$response = [
				'status' => 'gagal',
				'pesan'  => 'Data ternak tidak ditemukan!',
			];
			return $this->set_output($response);
		}

		$data = [
			'nama_ternak'   => $this->input->post('nama_ternak'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'jumlah'        => $this->input->post('jumlah')
		];

		// Update data ternak
		$update = $this->Model_ternak->update_ternak($id_ternak, $data);

		// Update data kategori (hanya satu pilihan)
		$id_kategori = $this->input->post('id_kategori');
		$this->Model_ternak->delete_ternak_kategori($id_ternak);

		if (!empty($id_kategori)) {
			$data_kategori = [
				'id_ternak'   => $id_ternak,
				'id_kategori' => $id_kategori,
			];
			$this->Model_ternak->add_ternak_kategori($data_kategori);
		}

		if ($update) {
			$response = [
				'status' => 'sukses',
				'pesan'  => 'Data Ternak berhasil diedit!',
			];
		} else {
			$response = [
				'status' => 'gagal',
				'pesan'  => 'Data Ternak gagal diperbarui!',
			];
		}

		return $this->set_output($response);
	}


	public function ternak_delete_post()
	{
		$id_ternak = $this->input->post('id_ternak');

		// Ambil data ternak berdasarkan ID
		$check_ternak = $this->Model_ternak->single_ternak($id_ternak);
		if (!$check_ternak) {
			$response = array(
				'status'	=> 'gagal',
				'pesan'		=> 'Tidak ditemukan',
			);
			$this->set_output($response);
		}

		$this->Model_ternak->delete_ternak($id_ternak);
		$this->Model_ternak->delete_ternak_kategori($id_ternak);

		$response = array(
			'status'	=> 'sukses',
			'pesan'		=> 'Data Ternak berhasil dihapus',
		);
		$this->set_output($response);
	}
}
