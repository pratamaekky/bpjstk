<?php

class Api extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    // get row
    public function getRowByClientId($clientId)
    {
        $this->db->select('*');
        $this->db->from('tbl_api_access');
        $this->db->where("client_id", $clientId);
        $query = $this->db->get();

        if ($query != null) {
            return $query->row();
        }
        return null;
    }

    // get row
    public function getAccess($id, $url)
    {
        $this->db->select('*');
        $this->db->from('tbl_api_access_log');
        $this->db->where(array(
            "access_id" => $id,
            "url" => $url
        ));
        $query = $this->db->get();

        if ($query != null) {
            return $query->row();
        }
        return null;
    }

    // get row
    public function getRowByClientIdAndSecret($clientId, $clientSecret)
    {
        $this->db->select('*');
        $this->db->from('tbl_api_access');
        $this->db->where(array(
            "client_id" => $clientId,
            "client_secret" => $clientSecret
        ));
        $query = $this->db->get();

        if ($query != null) {
            return $query->row();
        }
        return null;
    }

    // add row
    public function logBCA($data)
    {
        $this->db->insert('tbl_bca_api_call', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

}
