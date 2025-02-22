<?php
class Model_ternak extends CI_Model
{
	public function list_ternak()
	{
		$this->db->order_by('id_ternak', 'desc');
		$query = $this->db->get('ternak');
		return $query->result();
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
		return $this->db->insert_id();
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

	public function list_kategori()
	{
		$this->db->order_by('id_kategori', 'desc');
		$query = $this->db->get('kategori');
		return $query->result();
	}

	public function single_ternak_kategori($id_ternak)
	{
		$this->db->join('kategori', 'kategori.id_kategori=ternak_kategori.id_kategori', 'left');
		$this->db->where('id_ternak', $id_ternak);
		$query = $this->db->get('ternak_kategori');
		return $query->row();
	}

	public function list_ternak_kategori($id_ternak)
	{
		$this->db->join('kategori', 'kategori.id_kategori = ternak_kategori.id_kategori', 'left');
		$this->db->where('id_ternak', $id_ternak);
		$query = $this->db->get('ternak_kategori');
		return $query->result();
	}

	public function add_ternak_kategori($data)
	{
		$this->db->insert('ternak_kategori', $data);
		return $this->db->insert_id();
	}

	public function update_ternak_kategori($id_ternak, $data)

	{
		$this->db->where('id_ternak', $id_ternak);
		$this->db->update('ternak_kategori', $data);
		$this->db->reset_query();
	}

	public function delete_ternak_kategori($id_ternak)
	{
		$this->db->where('id_ternak', $id_ternak);
		$this->db->delete('ternak_kategori');
		$this->db->reset_query();
	}
}
