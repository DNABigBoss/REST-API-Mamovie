<?php

class Movies_model extends CI_model
{

    public function getMovie($id = null, $s = null)
    {
        if ($id != null) {
            return $this->db->get_where('movies', ['id' => $id])->result_array();
        } else if ($s != null) {
            $this->db->like('name', $s);
            return $this->db->get('movies')->result_array();
        }
        return $this->db->get('movies')->result_array();
    }

    public function createMovie($data)
    {
        $this->db->insert('movies',$data);
        return $this->db->affected_rows();
    }

    public function updateMovie($data, $id)
    {
        $this->db->update('movies',$data,['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteMovie($id)
    {
        $this->db->delete('movies', ['id' => $id]);
        return $this->db->affected_rows();
    }
}
