<?php

class Mhospital extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function save($data)
    {
        $this->db->insert("tbl_hospital", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getData()
    {
        $this->db->select("a.*, b.name as province, c.name as city, d.name as district, e.name as village");
        $this->db->from("tbl_hospital as a");
        $this->db->join("lk_province as b", "b.id=a.province_id", "left");
        $this->db->join("lk_city as c", "c.id=a.city_id", "left");
        $this->db->join("lk_district as d", "d.id=a.district_id", "left");
        $this->db->join("lk_village as e", "e.id=a.village_id", "left");

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }
}