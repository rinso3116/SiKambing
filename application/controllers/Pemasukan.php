<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pemasukan');
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
        $data['total_pemasukan'] = $this->Model_pemasukan->total_pemasukan();
        $data['pemasukan'] = $this->Model_pemasukan->list_pemasukan();
        $data['navbar'] = 'pemasukan';
        $data['title'] = 'Pemasukan - SiKambing';
        $this->load->view('pemasukan/pemasukan_view', $data);
    }

    public function pemasukan_daftar()
    {
        $daftar_pemasukan = $this->Model_pemasukan->list_pemasukan();

        $daftar_input = array();
        $nomor = 1;
        foreach ($daftar_pemasukan as $key) {
            $bahan_input = array(
                $nomor++,
                "Rp. " . number_format($key->jumlah, 0, ',', '.'),
                $key->keterangan,
                $key->tanggal,
                '<a href="javascript:;" data-id="' . $key->id_pemasukan . '" class="btn btn-warning btn-pemasukan-edit btn-sm m-1">Edit</a>' .
                    '<a href="javascript:;" class="btn btn-info btn-sm btn-pemasukan-detail" data-id="' . $key->id_pemasukan . '">Detail</a>',
            );
            array_push($daftar_input, $bahan_input);
        };
        $response = array(
            'data' => $daftar_input
        );
        $this->set_output($response);
    }

    public function pemasukan_add()
    {
        $this->load->view('pemasukan/pemasukan_add');
    }

    public function pemasukan_addsave()
    {
        header('Content-Type: application/json');

        $jumlah = $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        if (empty($jumlah)) {
            echo json_encode(["status" => "gagal", "pesan" => "Jumlah pemasukan harus diisi!"]);
            return;
        }

        $data = [
            'jumlah'    => $jumlah,
            'keterangan' => $keterangan,
            'tanggal'   => date('Y-m-d H:i:s')
        ];

        $this->load->model('Model_pemasukan');
        $insert = $this->Model_pemasukan->add_pemasukan($data);

        if ($insert) {
            echo json_encode(["status" => "sukses", "pesan" => "Pemasukan berhasil ditambahkan!"]);
        } else {
            echo json_encode(["status" => "gagal", "pesan" => "Gagal menyimpan pemasukan!"]);
        }
        exit;
    }

    public function pemasukan_detail($id_pemasukan)
    {
        $data['pemasukan'] = $this->Model_pemasukan->single_pemasukan($id_pemasukan);
        $this->load->view('pemasukan/pemasukan_detail', $data);
    }
}
