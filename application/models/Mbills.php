<?php

class Mbills extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function totalData()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_bills");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getData($query = null, $offset, $limit = 0, $order, $sort)
    {
        $this->db->select("a.*, b.name as patient_name, b.kpj, b.company, b.npp, c.name as hospital_name");
        $this->db->from("tbl_bills as a");
        $this->db->join("tbl_patient as b", "b.id=a.id_patient");
        $this->db->join("tbl_hospital as c", "c.id=a.rs_id");
        if (!is_null($query)) {
            $this->db->like("b.name", $query);
            $this->db->or_like("c.name", $query);
            $this->db->or_like("a.diagnose", $query);
        }

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result_array();
        }

        return null;
    }

    public function save($data)
    {
        $this->db->insert("tbl_bills", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    public function updateTotalBills($data)
    {
        $this->db->where("id", $data["id"]);
        $this->db->update("tbl_bills", $data);

        return $this->db->affected_rows();
    }

    public function saveBillsDetail($data)
    {
        $this->db->insert("tbl_bills_detail", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }
}