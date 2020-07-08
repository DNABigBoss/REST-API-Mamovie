<?php

class CountryId_model extends CI_model
{

    public function getCountryId($code = null, $name = null)
    {
        if ($code != null) {
            return $this->db->get_where('countryid', ['code' => $code])->result_array();
        } else if ($name != null) {
            $this->db->like('name', $name);
            return $this->db->get('countryid')->result_array();
        }
        return $this->db->get('countryid')->result_array();
    }
    public function createCountryId($data)
    {
        $this->db->insert('countryid',$data);
        return $this->db->affected_rows();
    }

    public function updateCountryId($data, $code)
    {
        $this->db->update('countryid',$data,['code' => $code]);
        return $this->db->affected_rows();
    }

    public function deleteCountryId($code)
    {
        $this->db->delete('countryid', ['code' => $code]);
        return $this->db->affected_rows();
    }
    
}
