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

    public function getGeneralById($id)
    {
        $this->db->select("*");
        $this->db->from("tbl_general");
        $this->db->where("id", $id);
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() >0)
            return $query->row();

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

    public function update($data)
    {
        $this->db->where("id", $data["id"]);
        $this->db->update("tbl_general", $data);

        return $this->db->affected_rows();
    }

    public function delete($data)
    {
        $this->db->delete('tbl_general', array(
            'id' => $data["id"]
        ));

        return $this->db->affected_rows();
    }

    public function totalRoom($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_room");
        $this->db->where("id_rs", $rsId);

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

    public function getRoomNameById($id)
    {
        $this->db->select("value");
        $this->db->from("tbl_room");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->value;

        return "";
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

    public function totalRadiology($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_radiology");
        $this->db->where("id_rs", $rsId);

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

    public function getRadiologyNameById($id)
    {
        $this->db->select("value");
        $this->db->from("tbl_radiology");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->value;

        return "";
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

    public function totalRehabilitation($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_rehabilitation");
        $this->db->where("id_rs", $rsId);

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

    public function getRehabilitationNameById($id)
    {
        $this->db->select("value");
        $this->db->from("tbl_rehabilitation");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->value;

        return "";
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

    public function totalMedic($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_medic");
        $this->db->where("id_rs", $rsId);

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

    public function getMedicNameById($id)
    {
        $this->db->select("value");
        $this->db->from("tbl_medic");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->value;

        return "";
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
        $this->db->select("*");
        $this->db->from("tbl_doctor");
        $this->db->where("id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getDoctorNameById($id)
    {
        $this->db->select("name");
        $this->db->from("tbl_doctor");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->name;

        return "";
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
        $this->db->select("a.*, b.value as specialist_docter");
        $this->db->from("tbl_surgery as a");
        $this->db->join("tbl_general as b", "b.id=a.id_specialist", "LEFT");
        $this->db->where("a.id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("a.name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getSurgeryNameById($id)
    {
        $this->db->select("name");
        $this->db->from("tbl_surgery");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->name;

        return "";
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

    public function totalAnestesi($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_anestesi");
        $this->db->where("id_rs", $rsId);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getAnestesi($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_anestesi");
        $this->db->where("id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getAnestesiNameById($id)
    {
        $this->db->select("name");
        $this->db->from("tbl_anestesi");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->name;

        return "";
    }

    public function saveAnestesi($data)
    {
        $this->db->insert("tbl_anestesi", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function totalLaboratory($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_laboratory");
        $this->db->where("id_rs", $rsId);

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
            $this->db->like("a.name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getLaboratoryNameById($id)
    {
        $this->db->select("name");
        $this->db->from("tbl_laboratory");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->name;

        return "";
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

    public function totalFee($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_fee");
        $this->db->where("id_rs", $rsId);

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
            $this->db->like("a.name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getFeeNameById($id)
    {
        $this->db->select("name");
        $this->db->from("tbl_fee");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->name;

        return "";
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

    public function totalAmbulance($rsId)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_ambulance");
        $this->db->where("id_rs", $rsId);

        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            $row = $query->row();
            return $row->total;
        }

        return 0;
    }

    public function getAmbulance($rsId, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_ambulance");
        $this->db->where("id_rs", $rsId);

        if (!is_null($query))
            $this->db->like("name", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->result();
        }

        return null;
    }

    public function getAmbulanceNameById($id)
    {
        $this->db->select("value");
        $this->db->from("tbl_ambulance");
        $this->db->where("id", $id);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->value;

        return "";
    }

    public function saveAmbulance($data)
    {
        $this->db->insert("tbl_ambulance", $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getServiceById($id, $command)
    {
        $this->db->select("*");
        switch ($command) {
            case 'room':
                $this->db->from("tbl_room");
                break;
            case 'radiology':
                $this->db->from("tbl_radiology");
                break;
            case 'rehabilitation':
                $this->db->from("tbl_rehabilitation");
                break;
            case 'medic':
                $this->db->from("tbl_medic");
                break;
            case 'doctor':
                $this->db->from("tbl_doctor");
                break;
            case 'surgery':
                $this->db->from("tbl_surgery");
                break;
            case 'anestesi':
                $this->db->from("tbl_anestesi");
                break;
            case 'laboratory':
                $this->db->from("tbl_laboratory");
                break;
            case 'fee':
                $this->db->from("tbl_fee");
                break;
            case 'ambulance':
                $this->db->from("tbl_ambulance");
                break;
        }
        $this->db->where("id", $id);
        $this->db->limit(1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row();

        return "";
    }

    public function updateByType($data, $command)
    {
        $this->db->where("id", $data["id"]);

        switch ($command) {
            case 'room':
                $this->db->update("tbl_room", $data);
                break;
            case 'radiology':
                $this->db->update("tbl_radiology", $data);
                break;
            case 'rehabilitation':
                $this->db->update("tbl_rehabilitation", $data);
                break;
            case 'medic':
                $this->db->update("tbl_medic", $data);
                break;
            case 'doctor':
                $this->db->update("tbl_doctor", $data);
                break;
            case 'surgery':
                $this->db->update("tbl_surgery", $data);
                break;
            case 'anestesi':
                $this->db->update("tbl_anestesi", $data);
                break;
            case 'laboratory':
                $this->db->update("tbl_laboratory", $data);
                break;
            case 'fee':
                $this->db->update("tbl_fee", $data);
                break;
            case 'ambulance':
                $this->db->update("tbl_ambulance", $data);
                break;
        }

        return $this->db->affected_rows();
    }

    public function deleteByType($data, $command)
    {
        switch ($command) {
            case 'room':
                $this->db->delete('tbl_room', ['id' => $data["id"]]);
                break;
            case 'radiology':
                $this->db->delete('tbl_radiology', ['id' => $data["id"]]);
                break;
            case 'rehabilitation':
                $this->db->delete('tbl_rehabilitation', ['id' => $data["id"]]);
                break;
            case 'medic':
                $this->db->delete('tbl_medic', ['id' => $data["id"]]);
                break;
            case 'doctor':
                $this->db->delete('tbl_doctor', ['id' => $data["id"]]);
                break;
            case 'surgery':
                $this->db->delete('tbl_surgery', ['id' => $data["id"]]);
                break;
            case 'anestesi':
                $this->db->delete('tbl_anestesi', ['id' => $data["id"]]);
                break;
            case 'laboratory':
                $this->db->delete('tbl_laboratory', ['id' => $data["id"]]);
                break;
            case 'fee':
                $this->db->delete('tbl_fee', ['id' => $data["id"]]);
                break;
            case 'ambulance':
                $this->db->delete('tbl_ambulance', ['id' => $data["id"]]);
                break;
        }

        return $this->db->affected_rows();

    }
}