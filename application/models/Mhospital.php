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

    public function totalData()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_hospital");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getData($query = null, $offset, $limit = 0, $order, $sort)
    {
        $this->db->select("a.*, b.name as province, c.name as city, d.name as district, e.name as village, f.value as hospital_type, g.value as hospital_owner");
        $this->db->from("tbl_hospital as a");
        $this->db->join("lk_province as b", "b.id=a.province_id", "LEFT");
        $this->db->join("lk_city as c", "c.id=a.city_id", "LEFT");
        $this->db->join("lk_district as d", "d.id=a.district_id", "LEFT");
        $this->db->join("lk_village as e", "e.id=a.village_id", "LEFT");
        $this->db->join("tbl_general as f", "f.id=a.type AND f.field='hospital_type'", "LEFT");
        $this->db->join("tbl_general as g", "g.id=a.owner AND g.field='hospital_owner'", "LEFT");
        if (!is_null($query))
            $this->db->like("a.name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function detail($id)
    {
        $this->db->select("a.*, b.name as province, c.name as city, d.name as district, e.name as village, f.value as hospital_type, g.value as hospital_owner");
        $this->db->from("tbl_hospital as a");
        $this->db->join("lk_province as b", "b.id=a.province_id", "LEFT");
        $this->db->join("lk_city as c", "c.id=a.city_id", "LEFT");
        $this->db->join("lk_district as d", "d.id=a.district_id", "LEFT");
        $this->db->join("lk_village as e", "e.id=a.village_id", "LEFT");
        $this->db->join("tbl_general as f", "f.id=a.type AND f.field='hospital_type'", "LEFT");
        $this->db->join("tbl_general as g", "g.id=a.owner AND g.field='hospital_owner'", "LEFT");
        $this->db->where("a.id", $id);
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }
}