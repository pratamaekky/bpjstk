<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/base/Transformer.php");

class Save
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

    private function _save_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveHospital = $this->CI->mhospital->save($this->_params);

        if ($saveHospital > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Hospitals",
            "item" => []
        ];
    }

    private function _save_room(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveRoom = $this->CI->general->saveRoom($this->_params);

        if ($saveRoom > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Room",
            "item" => []
        ];
    }

    private function _save_measure(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveMeasure = $this->CI->general->saveMeasure($this->_params);

        if ($saveMeasure > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Measure",
            "item" => []
        ];
    }

    private function _save_doctor(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveDoctor = $this->CI->general->saveDoctor($this->_params);

        if ($saveDoctor > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Doctor",
            "item" => []
        ];
    }

    private function _save_laboratory(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveLaboratory = $this->CI->general->saveLaboratory($this->_params);

        if ($saveLaboratory > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Laboratory",
            "item" => []
        ];
    }

    private function _save_fee(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveFee = $this->CI->general->saveFee($this->_params);

        if ($saveFee > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Fee",
            "item" => []
        ];
    }

    private function _save_general(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveGeneral = $this->CI->general->saveGeneral($this->_params);

        if ($saveGeneral > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New General",
            "item" => []
        ];
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_save_hospital($responseObj, $responsecode, $responseMessage);
                break;
            case "room":
                $this->_save_room($responseObj, $responsecode, $responseMessage);
                break;
            case "measure":
                $this->_save_measure($responseObj, $responsecode, $responseMessage);
                break;
            case "doctor":
                $this->_save_doctor($responseObj, $responsecode, $responseMessage);
                break;
            case "laboratory":
                $this->_save_laboratory($responseObj, $responsecode, $responseMessage);
                break;
            case "fee":
                $this->_save_fee($responseObj, $responsecode, $responseMessage);
                break;
            case "general":
                $this->_save_general($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}