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
			// Ambil daftar ternak
			$daftar_ternak = $this->Model_ternak->list_ternak();

			// Hitung total jumlah ternak
			$total_jumlah = 0;
			$daftar_input = array();

			foreach ($daftar_ternak as $key) {
				$total_jumlah += $key->jumlah; // Akumulasi jumlah ternak

				$bahan_input = array(
					$key->id_ternak,
					$key->nama_ternak,
					$key->nama_kategori,
					$key->jenis_kelamin,
					$key->jumlah,
					'<a href="javascript:;" data-id="' . $key->id_ternak . '" class="btn btn-outline-warning btn-ternak-edit btn-sm m-1">Edit</a>' .
						'<a href="javascript:;" class="btn btn-outline-danger btn-sm btn-ternak-delete" data-id="' . $key->id_ternak . '">Delete</a>',
				);
				array_push($daftar_input, $bahan_input);
			}

			// Kirim data tabel + total jumlah ternak
			$response = array(
				'data' => $daftar_input,
				'total_jumlah' => $total_jumlah // Tambahkan total jumlah
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
				'jumlah'        => $this->input->post('jumlah'),
				'id_kategori'   => $this->input->post('id_kategori')
			];

			$this->Model_ternak->add_ternak($data);
			redirect('ternak');
		}

		public function ternak_edit($id_ternak)
		{
			$this->load->model('Model_kategori');
			$data['ternak'] = $this->Model_ternak->single_ternak($id_ternak);
			$data['kategori'] = $this->Model_kategori->get_all_kategori();
			$this->load->view('ternak/ternak_edit', $data);
		}

		public function ternak_editsave()
		{
			$id_ternak = $this->input->post('id_ternak');
			$data = [
				'nama_ternak'   => $this->input->post('nama_ternak'),
				'id_kategori'   => $this->input->post('id_kategori'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin'),
				'jumlah'        => $this->input->post('jumlah')
			];

			$this->Model_ternak->update_ternak($id_ternak, $data);
			redirect('ternak');
		}

		public function ternak_delete_post()
		{
			$id_ternak = $this->input->post('id_ternak');

			// Cek apakah ID ternak valid
			$check_ternak = $this->Model_ternak->single_ternak($id_ternak);
			if (!$check_ternak) {
				$response = [
					'status' => 'gagal',
					'pesan'  => 'Data ternak tidak ditemukan.',
				];
				return $this->set_output($response); // Tambahkan return agar proses berhenti
			}
			if ($this->Model_ternak->delete_ternak($id_ternak)) {
				$response = [
					'status' => 'sukses',
					'pesan'  => 'Data ternak berhasil dihapus.',
				];
			} else {
				$response = [
					'status' => 'gagal',
					'pesan'  => 'Data ternak gagal dihapus. Periksa log database.',
				];
			}

			return $this->set_output($response);
		}
	}
