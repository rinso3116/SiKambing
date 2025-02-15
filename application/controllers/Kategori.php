<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
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
        $data['kategori'] = $this->Model_kategori->list_kategori();
        $data['navbar'] = 'kategori';
        $data['title'] = 'Data Jenis - SiKambing';
        $this->load->view('kategori/kategori_view', $data);
    }

    public function kategori_daftar()
    {
        $daftar_kategori = $this->Model_kategori->list_kategori();

        $daftar_input = array();
        foreach ($daftar_kategori as $key) {
            $bahan_input = array(
                $key->id_kategori, 
                $key->nama_kategori,
                $key->keterangan_kategori,
                '<a href="javascript:;" data-id="' . $key->id_kategori . '" class="btn btn-outline-warning btn-kategori-edit btn-sm m-1">Edit</a>' .
                '<a href="javascript:;" class="btn btn-outline-danger btn-sm btn-kategori-delete" data-id="' . $key->id_kategori . '">Delete</a>',
            );
            array_push($daftar_input, $bahan_input);
        };
        $response = array(
            'data' => $daftar_input
        );
        $this->set_output($response);
    }

    public function kategori_add()
    {
        $this->load->view('kategori/kategori_add');
    }

    public function kategori_addsave()
    {
        $data = [
            'id_kategori' => $this->input->post('id_kategori'),
            'nama_kategori' => $this->input->post('nama_kategori'),
            'keterangan_kategori' => $this->input->post('keterangan_kategori')
        ];

        $this->Model_kategori->add_kategori($data);
        redirect('kategori');
    }


    public function kategori_edit($id_kategori)
    {
        $this->load->model('Model_kategori');
        $data['kategori'] = $this->Model_kategori->single_kategori($id_kategori);
        $this->load->view('kategori/kategori_edit', $data);
    }

    public function kategori_update()
    {
        $id_kategori = $this->input->post('id_kategori');
        $data = [
            'nama_kategori'   => $this->input->post('nama_kategori'),
            'keterangan_kategori'   => $this->input->post('keterangan_kategori'),
        ];

        $this->Model_kategori->update_kategori($id_kategori, $data);
        redirect('kategori');
    }

    public function kategori_delete_post()
    {
        $id_kategori = $this->input->post('id_kategori');
        $check_kategori = $this->Model_kategori->single_kategori($id_kategori);

        if(!$check_kategori) {
            $response = array(
                'status' => 'gagal',
                'pesan' => 'Data kategori tidak ditemukan'
            );
            $this->set_output($response);
        }
        $check_digunakan = $this->Model_kategori->single_buku_kategori($id_kategori);
        if ($check_digunakan) {
            $response = array(
                'status' => 'gagal',
                'pesan' => 'kategori ini masih digunakan, tidak bisa dihapus!'
            );
            $this->set_output($response);
        }
        $this->Model_kategori->delete_kategori($id_kategori);
        $response = array(
            'status' => 'sukses',
            'pesan' => 'Data kategori berhasil dihapus'
        );

        $this->set_output($response);
    }
}

