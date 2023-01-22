<?php

class Mgrouping extends CI_Model
{

    /**
     * Constructor model
     */
    public function __construct()
    {
        $this->load->database();
    }

    public function countLogs()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_logs");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    // add row
    public function getAllLogs($x = 0, $y = 0, $limit = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_logs");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    public function getAllLogsLarge($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_logs");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateLog($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_logs', $data);

        return true;
    }

    public function countMove()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_move");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    // add row
    public function getAllMove($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_move");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateMove($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_move', $data);

        return true;
    }

    public function countExit()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_exit");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    // add row
    public function getAllExit($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_exit");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateExit($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_exit', $data);

        return true;
    }

    public function countSku()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_sku");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllSku($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_sku");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateSku($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_sku', $data);

        return true;
    }

    public function countGallery()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_warehouse_gallery");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllGallery($x = 0, $y = 1000)
    {
        $this->db->select("a.*, b.created");
        $this->db->from("tbl_warehouse_gallery as a");
        $this->db->join("tbl_user as b", "b.email=a.warehouse");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateGallery($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_warehouse_gallery', $data);

        return true;
    }

    public function countChat()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_chat");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllChat($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_chat");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;

    }

    // update row
    public function updateChat($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_chat', $data);

        return true;
    }

    public function countTicket()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_ticket");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllTicket($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_ticket");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateTicket($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_ticket', $data);

        return true;
    }

    public function countTicketDetail()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_ticket_detail");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllTicketDetail($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_ticket_detail");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateTicketDetail($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_ticket_detail', $data);

        return true;
    }

    public function countUser()
    {
        $this->db->select("count(id) as total");
        $this->db->from("tbl_user");
        $query = $this->db->get();

        if ($query != null) {
            $row = $query->row();
            return ($row == null || $row->total == null ? 0 : $row->total);
        } else {
            return 0;
        }
    }

    public function getAllUser($x = 0, $y = 1000)
    {
        $this->db->select("*");
        $this->db->from("tbl_user");
        $this->db->limit($y, $x);
        $this->db->order_by("id", "asc");

        $query = $this->db->get();
        if ($query != null) {
            return $query->result_array();
        }
        return null;
    }

    // update row
    public function updateUser($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('tbl_user', $data);

        return true;
    }
}