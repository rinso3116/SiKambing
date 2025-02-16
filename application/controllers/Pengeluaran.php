<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pengeluaran');
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
        $data['total_pengeluaran'] = $this->Model_pengeluaran->total_pengeluaran();
        $data['pengeluaran'] = $this->Model_pengeluaran->list_pengeluaran();
        $data['navbar'] = 'pengeluaran';
        $data['title'] = 'pengeluaran - SiKambing';
        $this->load->view('pengeluaran/pengeluaran_view', $data);
    }
    public function pengeluaran_daftar()
    {
        $daftar_pengeluaran = $this->Model_pengeluaran->list_pengeluaran();

        $daftar_input = array();
        $nomor = 1;
        foreach ($daftar_pengeluaran as $key) {
            $bahan_input = array(
                $nomor++,
                "Rp. " . number_format($key->jumlah, 0, ',', '.'),
                $key->keterangan,
                $key->tanggal,
                '<a href="javascript:;" data-id="' . $key->id_pengeluaran . '" class="btn btn-warning btn-pengeluaran-edit btn-sm m-1">Edit</a>' .
                    '<a href="javascript:;" data-id="' . $key->id_pengeluaran . '" class="btn btn-info btn-pengeluaran-detail btn-sm m-1">Detail</a>',
            );
            array_push($daftar_input, $bahan_input);
        };

        $response = array(
            'data' => $daftar_input
        );
        $this->set_output($response);
    }

    public function pengeluaran_add()
    {
        $this->load->view('pengeluaran/pengeluaran_add');
    }

    public function pengeluaran_addsave()
    {
        header('Content-Type: application/json');

        $jumlah = $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        if (empty($jumlah)) {
            echo json_encode(["status" => "gagal", "pesan" => "Jumlah pengeluaran harus diisi!"]);
            return;
        }

        $data = [
            'jumlah'    => $jumlah,
            'keterangan' => $keterangan,
            'tanggal'   => date('Y-m-d H:i:s')
        ];

        $this->load->model('Model_pengeluaran');
        $insert = $this->Model_pengeluaran->add_pengeluaran($data);

        if ($insert) {
            echo json_encode(["status" => "sukses", "pesan" => "pengeluaran berhasil ditambahkan!"]);
        } else {
            echo json_encode(["status" => "gagal", "pesan" => "Gagal menyimpan pengeluaran!"]);
        }
        exit;
    }

    public function pengeluaran_edit($id_pengeluaran)
    {
        $this->load->model('Model_pengeluaran');
        $data['pengeluaran'] = $this->Model_pengeluaran->single_pengeluaran($id_pengeluaran);
        $this->load->view('pengeluaran/pengeluaran_edit', $data);
    }

    public function pengeluaran_update()
    {
        $id_pengeluaran = $this->input->post('id_pengeluaran');

        // Ambil data pengeluaran berdasarkan ID
        $pengeluaran = $this->Model_pengeluaran->single_pengeluaran($id_pengeluaran);

        // Cek apakah pengeluaran berasal dari penjualan
        if ($pengeluaran->id_penjualan != NULL) {
            $response = array(
                'status'  => 'error',
                'message' => 'pengeluaran dari penjualan tidak dapat diedit di sini. Silakan edit di menu penjualan.'
            );
            echo json_encode($response);
            return;
        }

        // Ambil data input dari form
        $jumlah = str_replace('.', '', $this->input->post('jumlah')); // Hapus titik format angka
        $keterangan = $this->input->post('keterangan');

        // Data yang akan diupdate
        $data_update = array(
            'jumlah' => $jumlah,
            'keterangan' => $keterangan,
            'tanggal' => date('Y-m-d H:i:s')
        );

        // Proses update di database
        $update = $this->Model_pengeluaran->update_pengeluaran($id_pengeluaran, $data_update);

        if ($update) {
            $response = array(
                'status'  => 'success',
                'message' => 'pengeluaran berhasil diperbarui.'
            );
        } else {
            $response = array(
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui pengeluaran.'
            );
        }

        echo json_encode($response);
    }


    public function pengeluaran_detail($id_pengeluaran)
    {
        $data['pengeluaran'] = $this->Model_pengeluaran->single_pengeluaran($id_pengeluaran);
        $this->load->view('pengeluaran/pengeluaran_detail', $data);
    }
}
