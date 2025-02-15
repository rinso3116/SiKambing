<?php
class Model_susu extends CI_Model
{
    public function get_stok_susu()
    {
        $query = $this->db->select('stok_susu')->from('stok_susu')->order_by('id_stok', 'DESC')->limit(1)->get();
        return $query->row() ?? (object) ['stok_susu' => 0]; // Jika null, return object default
    }

    public function list_stok_susu()
    {
        $query = $this->db->select('stok_susu')->from('stok_susu')->where('id_stok', 1)->get();
        return $query->row() ? $query->row()->stok_susu : 0; // Jika tidak ada data, return 0
    }

    public function update_stok_susu($jumlah)
    {
        // Ambil stok saat ini, pastikan selalu valid
        $stok_saat_ini = $this->get_stok_susu()->stok_susu;

        // Hitung stok baru
        $stok_baru = $stok_saat_ini + $jumlah;

        // Pastikan stok baru tidak negatif
        if ($stok_baru < 0) {
            return false; // Stok tidak mencukupi
        }

        // Periksa apakah data stok sudah ada di database
        $cek_stok = $this->db->get_where('stok_susu', ['id_stok' => 1])->num_rows();

        if ($cek_stok > 0) {
        // Jika data sudah ada, lakukan UPDATE
            $this->db->where('id_stok', 1);
            $this->db->update('stok_susu', ['stok_susu' => $stok_baru]);
        } else {
        // Jika belum ada, lakukan INSERT
            $this->db->insert('stok_susu', ['id_stok' => 1, 'stok_susu' => $stok_baru]);
        }

        return $this->db->affected_rows() > 0;
    }


    public function update_jumlah_susu($jumlah)
    {
    // Ambil stok terbaru
        $query = $this->db->select('id_stok, stok_susu')
        ->from('stok_susu')
        ->order_by('id_stok', 'DESC')
        ->limit(1)
        ->get();

        $result = $query->row();
        if (!$result) return false; // Jika stok kosong, batalin update

        $id_stok = $result->id_stok;
        $stok_baru = (int) $result->stok_susu + $jumlah;

    // Update stok susu berdasarkan ID terbaru
        $this->db->where('id_stok', $id_stok);
        $this->db->update('stok_susu', ['stok_susu' => $stok_baru]);
    }

    public function update_stok($selisih)
    {
        // Ambil stok saat ini
        $stok = $this->list_stok_susu(); // Ini langsung angka, bukan object

        // Hitung stok baru
        $stok_baru = $stok + $selisih;

        // Pastikan stok tidak negatif
        if ($stok_baru < 0) {
            return false; // Stok tidak cukup
        }

        // Update stok di database
        $this->db->where('id_stok', 1);
        $this->db->update('stok_susu', ['stok_susu' => $stok_baru]);

        return $this->db->affected_rows() > 0;
    }

    public function total_susu()
    {
        $this->db->select_sum('stok_susu');
        $query = $this->db->get('stok_susu');

        return $query->row()->stok_susu ?? 0; // Mengembalikan 0 jika tidak ada data
    }
}
