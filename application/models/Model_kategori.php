<?php
class Model_kategori extends CI_Model
{
	public function list_kategori()
	{
		$this->db->order_by('id_kategori', 'desc');
		$query = $this->db->get('kategori');
		return $query->result();
	}

	public function get_all_kategori()
	{
		return $this->db->get('kategori')->result();
	}

	public function single_kategori($id_kategori)
	{
		return $this->db->get_where('kategori', ['id_kategori' => $id_kategori])->row();
	}

	public function add_kategori($data){
		$this->db->insert('kategori',$data);
	}

	public function update_kategori($id_kategori, $data){
		$this->db->where('id_kategori', $id_kategori);  
		return $this->db->update('kategori', $data);
	}

	public function delete_kategori($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		$this->db->delete('kategori');
		$this->db->reset_query();
	}
}