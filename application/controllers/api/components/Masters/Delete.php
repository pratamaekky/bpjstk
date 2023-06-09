<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/base/Transformer.php");

class Delete
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

    private function _delete_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        $deleteHospital = $this->CI->mhospital->delete($this->_params);

        if ($deleteHospital > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Delete Hospitals Success",
            "item" => []
        ];
    }

    private function _delete_general(&$responseObj, &$responsecode, &$responseMessage)
    {
        $deleteGeneral = $this->CI->general->delete($this->_params);

        if ($deleteGeneral > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Delete Master Data Success",
            "item" => []
        ];

    }

    private function _delete_service(&$responseObj, &$responsecode, &$responseMessage)
    {
        $deleteService = $this->CI->general->deleteByType($this->_params, $this->_command);

        if ($deleteService > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Delete " . ucwords($this->_command) . " Success",
            "item" => []
        ];

    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_delete_hospital($responseObj, $responsecode, $responseMessage);
                break;
            case "general":
                $this->_delete_general($responseObj, $responsecode, $responseMessage);
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
            case "ambulance":
                $this->_delete_service($responseObj, $responsecode, $responseMessage);
                break;
        }
    }

}