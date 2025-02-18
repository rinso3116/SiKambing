<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_pengaturan extends CI_Model {

	public function list_user()
	{
		// JOIN TABEL USER DENGAN USER GROUP
		$this->db->select('*, users.id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
		// JOIN TABEL GROUP DENGAN USER GROUP
		$this->db->join('groups', 'groups.id = users_groups.group_id', 'left');
		$query = $this->db->get('users');
		return $query->result();
	}

	public function single_user($id)
	{
		// Logika untuk mendapatkan buku berdasarkan ID
		$this->db->select('*, users.id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id', 'left');
		// JOIN TABEL GROUP DENGAN USER GROUP
		$this->db->join('groups', 'groups.id = users_groups.group_id', 'left');
		$this->db->where('users.id', $id);
		$query = $this->db->get('users');
		return $query->row();
	}
	
	public function list_group()
	{
		$query = $this->db->get('groups');
		return $query->result();
	}
}