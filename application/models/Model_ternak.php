<?php
class Model_ternak extends CI_Model
{
	public function list_ternak()
	{
		$this->db->select('ternak.*, kategori.nama_kategori');
		$this->db->from('ternak');
		$this->db->join('kategori', 'kategori.id_kategori = ternak.id_kategori', 'left');
		return $this->db->get()->result();
	}

	public function sum_ternak()
	{
		$this->db->select_sum('jumlah');
		$query = $this->db->get('ternak');
		return $query->row()->jumlah;
	}

	public function single_ternak($id_ternak)
	{
		$this->db->where('id_ternak', $id_ternak);
		$query = $this->db->get('ternak');
		return $query->row();
	}

	public function add_ternak($data)
	{
		$this->db->insert('ternak', $data);
	}

	public function update_ternak($id_ternak, $data)
	{
		$this->db->where('id_ternak', $id_ternak);
		$this->db->update('ternak', $data);
		$this->db->reset_query();
	}

	public function delete_ternak($id_ternak)
	{
		$this->db->where('id_ternak', $id_ternak);
		$this->db->delete('ternak');
		$this->db->reset_query();
	}
}