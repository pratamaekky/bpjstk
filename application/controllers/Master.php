<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/base/web_base.php';
require_once APPPATH . "controllers/components/Hospital.php";

class Master extends web_base
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

    public function hospital($command = "lists")
    {
        try {
            $hospital = new Hospital($command);
            $hospital->action();
        } catch (Exception $e) {
            // return $this->sendResponseError($e);
        }

    }
}