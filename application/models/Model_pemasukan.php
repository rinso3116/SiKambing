<?php
class Model_pemasukan extends CI_Model
{
    public function list_pemasukan()
    {
        $this->db->order_by('id_pemasukan', 'desc');
        $query = $this->db->get('pemasukan');
        return $query->result();
    }

    public function single_pemasukan($id_pemasukan)
    {
        return $this->db->get_where('pemasukan', ['id_pemasukan' => $id_pemasukan])->row();
    }

    public function add_pemasukan($data)
    {
        $this->db->insert('pemasukan', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pemasukan($id_pemasukan, $data)
    {
        $this->db->where('id_pemasukan', $id_pemasukan);
        return $this->db->update('pemasukan', $data);
    }

    public function total_pemasukan()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pemasukan');

        return $query->row()->jumlah ?? 0; // Mengembalikan 0 jika tidak ada data
    }

    // Ambil pemasukan berdasarkan id_penjualan
    public function get_pemasukan_by_penjualan($id_penjualan)
    {
        return $this->db->get_where('pemasukan', ['id_penjualan' => $id_penjualan])->row();
    }

    public function update_pemasukan_by_penjualan($id_penjualan, $data)
    {
        $this->db->where('id_penjualan', $id_penjualan);
        return $this->db->update('pemasukan', $data);
    }
}
