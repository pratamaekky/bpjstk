<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/base/Transformer.php");

class Update
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $params)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array(
            'general',
            'mhospital'
        ));
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_command = $command;
        $this->_params = $params;
    }

    private function _update_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        $updateHospital = $this->CI->mhospital->update($this->_params);

        if ($updateHospital > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Update Hospitals",
            "item" => []
        ];

    }

    private function _update_general(&$responseObj, &$responsecode, &$responseMessage)
    {
        $updateHospital = $this->CI->general->update($this->_params);

        if ($updateHospital > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Update General",
            "item" => []
        ];

    }

    private function _update_service(&$responseObj, &$responsecode, &$responseMessage)
    {
        $updateService = $this->CI->general->updateByType($this->_params, $this->_command);

        if ($updateService > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Update " . ucwords($this->_command) . ' Berhasil',
            "item" => []
        ];

    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_update_hospital($responseObj, $responsecode, $responseMessage);
                break;
            case "general":
                $this->_update_general($responseObj, $responsecode, $responseMessage);
                break;
            case "room":
            case "radiology":
            case "rehabilitation":
            case "medic":
            case "doctor":
            case "surgery":
            case "anestesi":
            case "laboratory":
            case "fee":
                $this->_update_service($responseObj, $responsecode, $responseMessage);
                break;
        }
    }

}