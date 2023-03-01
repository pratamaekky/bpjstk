<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
require_once APPPATH . 'controllers/api/v60/ABills.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Lists
{
    protected $CI;
    protected $appSrc;

    public function __construct($command = "", $params = null)
    {
        $this->Masters = new Masters();
        $this->ABills = new ABills();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_command = $command;
        $this->_params = $params;
    }

    public function action()
    {
        if ($this->_command == "data") {
            $dataBills = $this->ABills->data($this->_params);
            $dataBills = json_decode($dataBills);

            $result = ($dataBills->result == 200) ? $dataBills->data->item : $dataBills->data;
            echo json_encode($result);
        } else {
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
}