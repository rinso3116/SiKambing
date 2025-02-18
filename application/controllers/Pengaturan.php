<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		$this->load->model('Model_pengaturan');
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
		$data['navbar']='pengaturan';
		$data['groups'] = $this->Model_pengaturan->list_group();
		$this->load->view('pengaturan/pengaturan_view', $data);
	}

	public function user_add()
	{
		// first name, username, password, email
		$data['navbar']='pengaturan';
		$this->load->view('pengaturan/user_add', $data);
	}

	public function user_addsave()
	{
		if(!$this->input->post()) exit;

		$status_user = $this->input->post('status_user');
		$image_thumb = $this->input->post('image_thumb');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$email = $this->input->post('email');
		$additional_data = array(
			'first_name' => $this->input->post('first_name'),
			'image_thumb' => $image_thumb,
		);
		$group = array($status_user); // Sets user to admin.

		$this->ion_auth->register($username, $password, $email, $additional_data, $group);
		redirect('pengaturan');
	}

	public function user_edit($id='')
	{
		// VERIFIKASI 1 = ID BUKU KOSONG
		if($id=='') redirect('pengaturan');

		// Ambil data buku berdasarkan ID
		$check_user = $this->Model_pengaturan->single_user($id);

		// VERIFIKASI 2 = DATABASE TIDAK ADA
		if(!$check_user)
		{
			redirect('pengaturan');
		}

		// Load view dan teruskan data buku
		$data['user'] = $check_user;
		$data['navbar'] = 'pengaturan';
		$this->load->view('pengaturan/user_edit', $data);
	}

	public function user_editsave()
	{
		if(!$this->input->post()) exit;

		$data = array(
			'first_name' => $this->input->post('first_name'),
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'image_thumb' => $this->input->post('image_thumb'),
		);
		// cek apakah password baru direset
		$status_user = $this->input->post('status_user');
		$id = $this->input->post('user_id');
		$password = $this->input->post('password');

		if ($password != '')
		{
			$data['password'] = $password;
		}
		// hapus group lama
		$this->ion_auth->remove_from_group(NULL, $id);
		// tambah group baru
		$this->ion_auth->add_to_group($status_user, $id);
		// update data user
		$this->ion_auth->update($id, $data);
		redirect('pengaturan');
	}

	public function user_upload()
	{
		if( !isset($_FILES['img_file']['name']) || !isset($_FILES['img_file']['tmp_name']) )
		{
			$response = array(
				'status'    => 'gagal',
				'pesan'     => 'Maaf, tidak ada file yang dilampirkan.',
			);
			$this->set_output($response);
		}

		$config['upload_path'] = './image_users/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size'] = 3072;
		$config['encrypt_name'] = true;
		$config['file_ext_tolower'] = true;
		$this->upload->initialize($config);//tambahkan ini untuk perizinan
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('img_file'))
		{
			$response = array(
				'status'    => 'gagal',
				'pesan'     => 'Maaf, file tidak bisa diupload, mungkin melebihi batas yang ditentukan (3mb) atau file tersebut bukan file yang diperbolehkan.'
			);
			$this->set_output($response);
		}
		$data_upload        = $this->upload->data();
		$nama_file          = $data_upload['raw_name'];
		$ext_file           = $data_upload['file_ext'];

		$link = base_url().'image_users/'.$nama_file.$ext_file;

		// JIKA BERHASIL DISIMPAN
		$response = array(
			'status'    => 'sukses',
			'pesan'     => 'Data lampiran berhasil diupload.',
			'link_url'  => $link,
		);
		$this->set_output($response);
	}

	public function user_delete_post()
	{
		$id_user = $this->input->post('id_user');

	// Ambil data user berdasarkan ID
		$check_user = $this->Model_pengaturan->single_user($id_user);
		if (!$check_user) {
			$response = array(
				'status'    => 'gagal',
				'pesan'     => 'Pengguna tidak ditemukan.',
			);
			$this->set_output($response);
		}

	// Hapus data user menggunakan Ion Auth
		if ($this->ion_auth->delete_user($id_user)) {
			$response = array(
				'status'    => 'sukses',
				'pesan'     => 'Pengguna berhasil dihapus.',
			);
		} else {
			$response = array(
				'status'    => 'gagal',
				'pesan'     => 'Pengguna gagal dihapus: ' . $this->ion_auth->errors(),
			);
		}

	// Set output JSON untuk toastr
		$this->set_output($response);
	}
}