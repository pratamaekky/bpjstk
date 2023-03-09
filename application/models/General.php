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

    public function totalGeneral($field)
    {
        $this->db->select("count(id) as total");
        $this->db->where("field", $field);
        $this->db->from("tbl_general");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }


    public function getGeneral($field)
    {
        $this->db->select("*");
        $this->db->from("tbl_general");
        $this->db->where("field", $field);
        $this->db->order_by("value", "ASC");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getGenerals($field, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_general");
        $this->db->where("field", $field);
        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveGeneral($data)
    {
        $this->db->insert("tbl_general", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }


    public function totalRoom()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_room");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getRoom($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_room");
        $this->db->where("id_rs", $rsId);
        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveRoom($data)
    {
        $this->db->insert("tbl_room", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalRadiology()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_radiology");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getRadiology($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_radiology");
        $this->db->where("id_rs", $rsId);
        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveRadiology($data)
    {
        $this->db->insert("tbl_radiology", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalRehabilitation()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_rehabilitation");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getRehabilitation($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_rehabilitation");
        $this->db->where("id_rs", $rsId);
        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveRehabilitation($data)
    {
        $this->db->insert("tbl_rehabilitation", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalMedic()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_medic");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getMedic($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_medic");
        $this->db->where("id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveMedic($data)
    {
        $this->db->insert("tbl_medic", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalDoctor($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_doctor");
        $this->db->where("id_rs", $rsId);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getDoctor($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("a.*, b.value as doctor_specialist");
        $this->db->from("tbl_doctor as a");
        $this->db->join("tbl_general as b", "b.id=a.id_specialist", "LEFT");
        $this->db->where("a.id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("a.value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveDoctor($data)
    {
        $this->db->insert("tbl_doctor", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalSurgery($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_surgery");
        $this->db->where("id_rs", $rsId);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getSurgery($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("a.*, b.value as ot_category");
        $this->db->from("tbl_surgery as a");
        $this->db->join("tbl_general as b", "b.id=a.id_ot_category", "LEFT");
        $this->db->where("a.id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("a.value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveSurgery($data)
    {
        $this->db->insert("tbl_surgery", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalLaboratory()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_laboratory");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getLaboratory($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("a.*, b.value as lab_category");
        $this->db->from("tbl_laboratory as a");
        $this->db->join("tbl_general as b", "b.id=a.id_lab_category", "LEFT");
        $this->db->where("a.id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("a.value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveLaboratory($data)
    {
        $this->db->insert("tbl_laboratory", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalFee()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_fee");

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getFee($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("a.*, b.value as other_fee");
        $this->db->from("tbl_fee as a");
        $this->db->join("tbl_general as b", "b.id=a.other_fee_id", "LEFT");
        $this->db->where("a.id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("a.value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function saveFee($data)
    {
        $this->db->insert("tbl_fee", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
}