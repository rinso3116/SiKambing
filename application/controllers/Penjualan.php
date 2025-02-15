<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_penjualan');
        $this->load->model('Model_susu');
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
        $data['stok'] = $this->Model_susu->list_stok_susu();
        $data['total_penjualan'] = $this->Model_penjualan->total_penjualan();
        $data['total_penghasilan'] = $this->Model_penjualan->total_penghasilan();
        $data['penjualan'] = $this->Model_penjualan->list_penjualan();
        $data['navbar'] = 'penjualan';
        $data['title'] = 'Penjualan Susu - SiKambing';
        $this->load->view('penjualan/penjualan_view', $data);
    }

    public function penjualan_daftar()
    {
        $daftar_penjualan = $this->Model_penjualan->list_penjualan();

        $daftar_input = array();
        $nomor = 1; // Mulai dari 1

        foreach ($daftar_penjualan as $key) {
            $bahan_input = array(
                $nomor++, // Gunakan nomor urut, bukan ID Penjualan
                $key->jumlah_susu . " liter", // Tambahkan " liter" di belakang jumlah susu
                "Rp. " . number_format($key->harga_per_liter, 0, ',', '.'), // Format harga per liter
                "Rp. " . number_format($key->total_harga, 0, ',', '.'), // Format total harga
                $key->menjual_ke,
                '<a href="javascript:;" data-id="' . $key->id_penjualan . '" class="btn btn-warning btn-penjualan-edit btn-sm m-1">Edit</a>' .
                    '<a href="javascript:;" class="btn btn-info btn-sm btn-penjualan-detail" data-id="' . $key->id_penjualan . '">Detail</a>',
            );
            array_push($daftar_input, $bahan_input);
        };
        $response = array(
            'data' => $daftar_input
        );
        $this->set_output($response);
    }

    public function penjualan_add()
    {
        $this->load->view('penjualan/penjualan_add');
    }

    public function penjualan_addsave()
    {
        header('Content-Type: application/json');

        $jumlah_susu = $this->input->post('jumlah_susu');
        $harga_per_liter = $this->input->post('harga_per_liter');
        $menjual_ke = $this->input->post('menjual_ke');
        $keterangan = $this->input->post('keterangan');

        // Ambil stok susu saat ini
        $stok_susu = $this->Model_susu->get_stok_susu();

        if (empty($jumlah_susu) || empty($harga_per_liter) || empty($menjual_ke)) {
            echo json_encode(["status" => "gagal", "pesan" => "Semua field harus diisi!"]);
            return;
        }

        // Validasi stok susu mencukupi
        if ($jumlah_susu > $stok_susu) {
            echo json_encode(["status" => "gagal", "pesan" => "Stok susu tidak mencukupi! Stok saat ini: " . $stok_susu . " liter"]);
            return;
        }

        $total_harga = $jumlah_susu * $harga_per_liter;

        $data_penjualan = [
            'jumlah_susu'     => $jumlah_susu,
            'harga_per_liter' => $harga_per_liter,
            'total_harga'     => $total_harga,
            'menjual_ke'      => $menjual_ke,
            'keterangan'      => $keterangan,
            'tanggal'         => date('Y-m-d H:i:s'),
        ];

        $insert_id = $this->Model_penjualan->add_penjualan($data_penjualan); // Dapatkan ID terbaru

        if ($insert_id) {
            $this->Model_susu->update_jumlah_susu(-$jumlah_susu);

            $data_pemasukan = [
                'id_penjualan' => $insert_id, // Tambahkan id_penjualan
                'jumlah'       => $total_harga,
                'keterangan'   => "Penjualan susu ke " . $menjual_ke . ". " . $keterangan,
                'tanggal'      => date('Y-m-d H:i:s')
            ];
            $this->load->model('Model_pemasukan');
            $this->Model_pemasukan->add_pemasukan($data_pemasukan);

            echo json_encode(["status" => "sukses", "pesan" => "Penjualan berhasil ditambahkan!"]);
        } else {
            echo json_encode(["status" => "gagal", "pesan" => "Gagal menyimpan data!"]);
        }
    }

    public function penjualan_edit($id_penjualan)
    {
        $this->load->model('Model_penjualan');
        $data['penjualan'] = $this->Model_penjualan->single_penjualan($id_penjualan);
        $this->load->view('penjualan/penjualan_edit', $data);
    }

    public function penjualan_update()
    {
        header('Content-Type: application/json');

        $id_penjualan = $this->input->post('id_penjualan');
        $jumlah_susu_baru = $this->input->post('jumlah_susu');
        $harga_per_liter_baru = str_replace('.', '', $this->input->post('harga_per_liter'));
        $menjual_ke = $this->input->post('menjual_ke');
        $keterangan = $this->input->post('keterangan');

        // Ambil data penjualan lama
        $penjualan_lama = $this->Model_penjualan->single_penjualan($id_penjualan);
        $jumlah_susu_lama = $penjualan_lama->jumlah_susu;

        // Ambil stok susu saat ini
        $stok_susu = $this->Model_susu->get_stok_susu()->stok_susu;

        // Hitung perubahan stok
        $selisih_susu = $jumlah_susu_baru - $jumlah_susu_lama;

        // Jika stok bertambah (karena jumlah susu berkurang), kembalikan ke stok
        if ($selisih_susu < 0) {
            $this->Model_susu->update_jumlah_susu(abs($selisih_susu)); // Tambah stok
        }
        // Jika stok berkurang, pastikan stok cukup
        else if ($selisih_susu > 0) {
            if ($stok_susu < $selisih_susu) {
                echo json_encode(["status" => "gagal", "pesan" => "Stok susu tidak mencukupi!"]);
                return;
            }
            $this->Model_susu->update_jumlah_susu(-$selisih_susu); // Kurangi stok
        }

        // Hitung total harga baru jika ada perubahan jumlah susu atau harga per liter
        $total_harga_baru = $jumlah_susu_baru * $harga_per_liter_baru;

        // Data yang akan diupdate
        $data_update = [
            'jumlah_susu' => $jumlah_susu_baru,
            'harga_per_liter' => $harga_per_liter_baru,
            'total_harga' => $total_harga_baru,
            'menjual_ke' => $menjual_ke,
            'keterangan' => $keterangan,
            'tanggal' => date('Y-m-d H:i:s')
        ];

        // Update penjualan
        $update = $this->Model_penjualan->update_penjualan($id_penjualan, $data_update);

        if ($update) {
            // Update pemasukan jika harga berubah
            $data_pemasukan = [
                'jumlah' => $total_harga_baru,
                'keterangan' => "Update penjualan susu ke " . $menjual_ke . ". " . $keterangan,
                'tanggal' => date('Y-m-d H:i:s')
            ];
            $this->Model_pemasukan->update_pemasukan_by_penjualan($id_penjualan, $data_pemasukan);

            echo json_encode(["status" => "sukses", "pesan" => "Data penjualan berhasil diperbarui!"]);
        } else {
            echo json_encode(["status" => "gagal", "pesan" => "Gagal memperbarui data!"]);
        }
    }
    public function penjualan_detail($id_penjualan)
    {
        $data['penjualan'] = $this->Model_penjualan->single_penjualan($id_penjualan);
        $this->load->view('penjualan/penjualan_detail', $data);
    }
}
