<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/base/web_base.php';
require_once APPPATH . "controllers/components/Bills/Lists.php";
require_once APPPATH . "controllers/components/Bills/Save_bills.php";
require_once APPPATH . "controllers/components/Bills/Detail_bills.php";
require_once APPPATH . "controllers/components/Bills/BDelete.php";

class Bills extends web_base
{
    /**
     * Contructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'text',
            'url'
        ));

        $this->load->library(array(
            'myutils',
            'somplakapi',
            'user_agent'
        ));
    }

    public function lists($command = "")
    {
        try {
            $params = (!is_null($this->input->post()) && !empty($this->input->post())) ? $this->input->post() : null;
            $lists = new Lists($command, $params);
            $lists->action();
        } catch (Exception $e) {
            // return $this->sendResponseError($e);
        }
    }

    public function save_bills()
    {
        try {
            $params = (!is_null($this->input->post()) && !empty($this->input->post())) ? $this->input->post() : null;
            $save = new Save_bills($params);
            $save->action();
        } catch (Exception $e) {
        }
    }

    public function detail()
    {
        try {
            $params = (!is_null($this->input->post()) && !empty($this->input->post())) ? $this->input->post() : null;
            $detail = new Detail_bills($params);
            $detail->action();
        } catch (Exception $e) {
        }
    }

    public function delete()
    {
        try {
            $params = (!is_null($this->input->post()) && !empty($this->input->post())) ? $this->input->post() : null;
            $delete = new BDelete($params);
            $delete->action();
        } catch (Exception $e) {
        }
    }
}