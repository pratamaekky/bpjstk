<?php

class User extends CI_Model
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
}