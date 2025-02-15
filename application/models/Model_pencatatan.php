<?php
class Model_pencatatan extends CI_Model
{
    public function list_pencatatan()
    {
        $this->db->order_by('id_pencatatan', 'desc');
        $query = $this->db->get('pencatatan_susu');
        return $query->result();
    }

    public function single_pencatatan($id_pencatatan)
    {
        return $this->db->get_where('pencatatan_susu', ['id_pencatatan' => $id_pencatatan])->row();
    }

    public function add_pencatatan($data)
    {
        $this->db->insert('pencatatan_susu', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_pencatatan($id_pencatatan, $data){
        $this->db->where('id_pencatatan', $id_pencatatan);  
        return $this->db->update('pencatatan_susu', $data);
    }

    public function delete_pencatatan($id_pencatatan)
    {
        $this->db->where('id_pencatatan', $id_pencatatan);
        $this->db->delete('pencatatan_susu');
        $this->db->reset_query();
    }
}