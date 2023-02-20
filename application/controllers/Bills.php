<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/base/web_base.php';
require_once APPPATH . "controllers/components/Bills/Lists.php";
require_once APPPATH . "controllers/components/Bills/Save_patient.php";

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

    public function lists()
    {
        try {
            $lists = new Lists();
            $lists->action();
        } catch (Exception $e) {
            // return $this->sendResponseError($e);
        }
    }

    public function save_patient()
    {
        try {
            $params = (!is_null($this->input->post()) && !empty($this->input->post())) ? $this->input->post() : null;
            $save = new Save_patient($params);
            $save->action();
        } catch (Exception $e) {
        }
    }
}