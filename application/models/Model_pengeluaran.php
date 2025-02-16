<?php
class Model_pengeluaran extends CI_Model
{
    public function list_pengeluaran()
    {
        $this->db->order_by('id_pengeluaran', 'desc');
        $query = $this->db->get('pengeluaran');
        return $query->result();
    }

    public function single_pengeluaran($id_pengeluaran)
    {
        return $this->db->get_where('pengeluaran', ['id_pengeluaran' => $id_pengeluaran])->row();
    }

    public function add_pengeluaran($data)
    {
        $this->db->insert('pengeluaran', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pengeluaran($id_pengeluaran, $data)
    {
        $this->db->where('id_pengeluaran', $id_pengeluaran);
        return $this->db->update('pengeluaran', $data);
    }

    public function total_pengeluaran()
    {
        $this->db->select_sum('jumlah');
        $query = $this->db->get('pengeluaran');

        return $query->row()->jumlah ?? 0; // Mengembalikan 0 jika tidak ada data
    }

    // Ambil pengeluaran berdasarkan id_penjualan
    public function get_pengeluaran_by_penjualan($id_penjualan)
    {
        return $this->db->get_where('pengeluaran', ['id_penjualan' => $id_penjualan])->row();
    }

    public function update_pengeluaran_by_penjualan($id_penjualan, $data)
    {
        $this->db->where('id_penjualan', $id_penjualan);
        return $this->db->update('pengeluaran', $data);
    }
}
