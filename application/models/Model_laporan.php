<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_laporan extends CI_Model
{
    public function getFilteredLaporan($start_date, $end_date, $jenis_laporan)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);

        switch ($jenis_laporan) {
            case 'pencatatan':
                $this->db->select('id, tanggal, jenis, jumlah_susu AS jumlah, keterangan');
                $this->db->from('pencatatan_susu');
                break;
            case 'penjualan':
                $this->db->select('id, tanggal, pembeli AS jenis, jumlah_susu AS jumlah, total_harga AS keterangan');
                $this->db->from('penjualan_susu');
                break;
            case 'pengeluaran':
                $this->db->select('id, tanggal, jenis_pengeluaran AS jenis, jumlah, keterangan');
                $this->db->from('pengeluaran_kandang');
                break;
            case 'pemasukan':
                $this->db->select('id, tanggal, sumber_pemasukan AS jenis, jumlah, keterangan');
                $this->db->from('pemasukan');
                break;
        }

        return $this->db->get()->result();
    }
}
