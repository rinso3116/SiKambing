<?php
class Model_penjualan extends CI_Model
{
    public function list_penjualan()
    {
        $this->db->order_by('id_penjualan', 'desc');
        $query = $this->db->get('penjualan');
        return $query->result();
    }

    public function single_penjualan($id_penjualan)
    {
        return $this->db->get_where('penjualan', ['id_penjualan' => $id_penjualan])->row();
    }

    public function add_penjualan($data)
    {
        $this->db->insert('penjualan', $data);
        return $this->db->insert_id();
    }

    public function update_penjualan($id_penjualan, $data)
    {
        $this->db->where('id_penjualan', $id_penjualan);
        return $this->db->update('penjualan', $data);
    }

    public function total_penjualan()
    {
        $this->db->select_sum('jumlah_susu');
        $query = $this->db->get('penjualan');

        return $query->row()->jumlah_susu ?? 0; // Mengembalikan 0 jika tidak ada data
    }

    public function total_penghasilan()
    {
        $this->db->select_sum('total_harga');
        $query = $this->db->get('penjualan');

        return $query->row()->total_harga ?? 0; // Mengembalikan 0 jika tidak ada data
    }
}
