<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Lists
{
    protected $CI;
    protected $appSrc;

    public function __construct()
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));
    }

    public function action()
    {
        $hospitals = [];
        $responseHospital = $this->Masters->data("hospital", "", ["length" => 100]);
        $responseHospital = json_decode($responseHospital);

        if ($responseHospital->result == 200) {
            $hospitals = $responseHospital->data->item->aaData;
        }

        $data["hospitals"] = $hospitals;

        $this->CI->load->view("public/bills/lists.php", $data);
    }

}