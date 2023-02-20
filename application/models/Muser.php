<?php

class Muser extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function addUser($data)
    {
        $result = null;
        $resId = 0;
        $resMessage = "";

        $this->db->insert("tbl_users", $data);
        if ($this->db->affected_rows() > 0) {
            $resId = $this->db->insert_id();
        } else {
            $db_error = $this->db->error(); // Has keys 'code' and 'message'
            if (!empty($db_error) && isset($db_error['message'])) {
                $resMessage = $db_error['message'];
            }
        }

        $result = array(
            "result" => $resId,
            "message" => $resMessage
        );
        return (object) $result;
    }

    public function updateUser($data)
    {
        $this->db->where("username", $data["username"]);
        $this->db->update("tbl_users", $data);

        return $this->db->affected_rows();
    }

    public function getUserByEmail($email)
    {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function getUserByUsername($username)
    {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("username", $username);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function totalUserByRsId($id, $isTotal = false)
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_users");
        $this->db->where("rs_id", $id);
        $this->db->where("role", 1);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row()->total;

        return 0;
    }

    public function getUserByRsId($id, $query, $offset, $limit, $order, $sort)
    {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("rs_id", $id);
        $this->db->where("role", 1);
        if (!is_null($query))
            $this->db->like("value", $query);

        $this->db->order_by($order, $sort);

        if ($limit > 0)
            $this->db->limit($limit, $offset);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->result();

        return null;
    }

    public function getPatientByKPJ($kpj)
    {
        $this->db->select("*");
        $this->db->from("tbl_patient");
        $this->db->where("kpj", $kpj);

        $query = $this->db->get();

        if (!is_null($query) && $query->num_rows() > 0)
            return $query->row();

        return null;
    }

    public function addPatient($data)
    {
        $result = null;
        $resId = 0;
        $resMessage = "";

        $this->db->insert("tbl_patient", $data);
        if ($this->db->affected_rows() > 0) {
            $resId = $this->db->insert_id();
        } else {
            $db_error = $this->db->error(); // Has keys 'code' and 'message'
            if (!empty($db_error) && isset($db_error['message'])) {
                $resMessage = $db_error['message'];
            }
        }

        $result = array(
            "result" => $resId,
            "message" => $resMessage
        );
        return (object) $result;

    }
}