<?php

class General extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function getProvince()
    {
        $this->db->select("*");
        $this->db->from("lk_province");
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getCity($idProvince)
    {
        $this->db->select("*");
        $this->db->from("lk_city");
        $this->db->where("id_province", $idProvince);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getDistrict($idCity)
    {
        $this->db->select("*");
        $this->db->from("lk_district");
        $this->db->where("id_city", $idCity);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getPostalCode($idProvince, $idCity, $idDistrict)
    {
        $this->db->select("*");
        $this->db->from("lk_postal_code");
        $this->db->where("id_province", $idProvince);
        $this->db->where("id_city", $idCity);
        $this->db->where("id_district", $idDistrict);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }
}