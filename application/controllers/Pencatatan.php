<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencatatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pencatatan');
        $this->load->model('Model_susu');
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
        $data['stok'] = $this->Model_susu->get_stok_susu();
        $data['total_susu'] = $this->Model_susu->total_susu();
        $data['pencatatan'] = $this->Model_pencatatan->list_pencatatan();
        $data['navbar'] = 'pencatatan';
        $data['title'] = 'Pencatatan Susu - SiKambing';
        $this->load->view('pencatatan/pencatatan_view', $data);
    }

    public function pencatatan_daftar()
    {
        $daftar_pencatatan = $this->Model_pencatatan->list_pencatatan();

        $daftar_input = array();
        $nomor = 1; // Mulai dari 1

        foreach ($daftar_pencatatan as $key) {
            $bahan_input = array(
                $nomor++,
                $key->jumlah_susu . " liter",
                $key->keterangan,
                '<a href="javascript:;" data-id="' . $key->id_pencatatan . '" class="btn btn-warning btn-pencatatan-edit btn-sm m-1">Edit</a>' .
                '<a href="javascript:;" data-id="' . $key->id_pencatatan . '" class="btn btn-info btn-pencatatan-detail btn-sm m-1">Detail</a>',
            );
            array_push($daftar_input, $bahan_input);
        };
        $response = array(
            'data' => $daftar_input
        );
        $this->set_output($response);
    }

    public function pencatatan_add()
    {
        $this->load->view('pencatatan/pencatatan_add');
    }

    public function pencatatan_addsave()
    {
        $this->load->model('Model_pencatatan');
        $this->load->model('Model_susu');

        // Ambil data dari input form
        $jumlah_susu = $this->input->post('jumlah_susu');
        $keterangan = $this->input->post('keterangan');

        // Data untuk tabel pencatatan_susu
        $data_pencatatan = [
            'jumlah_susu' => $jumlah_susu,
            'keterangan' => $keterangan
        ];

        $this->Model_pencatatan->add_pencatatan($data_pencatatan);
        $this->Model_susu->update_stok_susu($jumlah_susu);

        // Redirect ke halaman pencatatan
        redirect('pencatatan');
    }

    public function pencatatan_edit($id_pencatatan)
    {
        $this->load->model('Model_pencatatan');
        $data['pencatatan'] = $this->Model_pencatatan->single_pencatatan($id_pencatatan);
        $this->load->view('pencatatan/pencatatan_edit', $data);
    }

    public function pencatatan_update()
    {
        // Ambil data dari form
        $id_pencatatan = $this->input->post('id_pencatatan');
        $jumlah_susu_baru = $this->input->post('jumlah_susu');

        // Ambil data pencatatan lama untuk menghitung selisih
        $pencatatan_lama = $this->Model_pencatatan->single_pencatatan($id_pencatatan);
        $jumlah_susu_lama = $pencatatan_lama->jumlah_susu;

        // Hitung selisih jumlah susu
        $selisih_susu = $jumlah_susu_baru - $jumlah_susu_lama;

        // Update data pencatatan
        $data = [
            'jumlah_susu' => $jumlah_susu_baru,
            'keterangan'  => $this->input->post('keterangan'),
        ];
        $this->Model_pencatatan->update_pencatatan($id_pencatatan, $data);

        // Update stok susu berdasarkan selisih
        $this->Model_susu->update_stok($selisih_susu);

        // Redirect kembali ke halaman pencatatan
        redirect('pencatatan');
    }

    public function pencatatan_detail($id_pencatatan)
    {
        $data['pencatatan'] = $this->Model_pencatatan->single_pencatatan($id_pencatatan);
        $this->load->view('pencatatan/pencatatan_detail', $data);
    }



    public function pencatatan_delete_post()
    {
        $id_pencatatan = $this->input->post('id_pencatatan');
        $check_pencatatan = $this->Model_pencatatan->single_pencatatan($id_pencatatan);

        if (!$check_pencatatan) {
            $response = array(
                'status' => 'gagal',
                'pesan' => 'Data pencatatan tidak ditemukan'
            );
            $this->set_output($response);
        }
        $check_digunakan = $this->Model_pencatatan->single_buku_pencatatan($id_pencatatan);
        if ($check_digunakan) {
            $response = array(
                'status' => 'gagal',
                'pesan' => 'pencatatan ini masih digunakan, tidak bisa dihapus!'
            );
            $this->set_output($response);
        }
        $this->Model_pencatatan->delete_pencatatan($id_pencatatan);
        $response = array(
            'status' => 'sukses',
            'pesan' => 'Data pencatatan berhasil dihapus'
        );

        $this->set_output($response);
    }
}
