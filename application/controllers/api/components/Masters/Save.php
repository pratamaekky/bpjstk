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

    private function _save_radiology(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveRadiology = $this->CI->general->saveRadiology($this->_params);

        if ($saveRadiology > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Radiology",
            "item" => []
        ];
    }

    private function _save_rehabilitation(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveRehabilitation = $this->CI->general->saveRehabilitation($this->_params);

        if ($saveRehabilitation > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Rehabilitation",
            "item" => []
        ];
    }

    private function _save_medic(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveMedic = $this->CI->general->saveMedic($this->_params);

        if ($saveMedic > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Medic",
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

    private function _save_surgery(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveSurgery = $this->CI->general->saveSurgery($this->_params);

        if ($saveSurgery > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Surgery",
            "item" => []
        ];
    }

    private function _save_anestesi(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveAnestesi = $this->CI->general->saveAnestesi($this->_params);

        if ($saveAnestesi > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Docter Anestesi",
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

    private function _save_users(&$responseObj, &$responsecode, &$responseMessage)
    {
        if (!isset($this->_params['username']) || !isset($this->_params['name']) || !isset($this->_params['rs_id']))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali!", 201);
            
        $userInfo = $this->CI->muser->getUserByUsername(strtolower($this->_params["username"]));
        if (!is_null($userInfo))
            throw new Exception("Username sudah ada. Silahkan coba kembali dengan username yang berbeda!", 401);

        $password = isset($this->_params["password"]) ? $this->_params["password"] : "!Plkkrates123";
        $generatePassword = $this->CI->myutils->generatePassword($password);
        $this->_params["password"] = $generatePassword;
        $this->_params["role"] = isset($this->_params["role"]) ? intval($this->_params["role"]) : 1;

        $saveUsers = $this->CI->muser->addUser($this->_params);

        if ($saveUsers->result > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Users",
            "item" => []
        ];
    }

    private function _save_patient(&$responseObj, &$responsecode, &$responseMessage)
    {
        if (!isset($this->_params['kpj']) || !isset($this->_params['name']) || !isset($this->_params['company']))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali!", 201);
            
        $patientInfo = $this->CI->muser->getPatientByKPJ(strtolower($this->_params["kpj"]));
        $patientId = (!is_null($patientInfo) ? $patientInfo->id : 0);

        if (is_null($patientInfo)) {
            $savePatient = $this->CI->muser->addPatient($this->_params);
            $patientId = $savePatient->result;
        }

        $responsecode = 200;
        $responseObj = [
            "name" => "Save New Patient",
            "item" => (!is_null($patientInfo) ? $patientInfo : array_merge(["id" => $patientId], $this->_params))
        ];
    }

    private function _save_bills(&$responseObj, &$responsecode, &$responseMessage)
    {
        $saveBills = $this->CI->mhospital->saveBills($this->_params);

        if ($saveBills > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Bills",
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
            case "radiology":
                $this->_save_radiology($responseObj, $responsecode, $responseMessage);
                break;
            case "rehabilitation":
                $this->_save_rehabilitation($responseObj, $responsecode, $responseMessage);
                break;
            case "medic":
                $this->_save_medic($responseObj, $responsecode, $responseMessage);
                break;
            case "doctor":
                $this->_save_doctor($responseObj, $responsecode, $responseMessage);
                break;
            case "surgery":
                $this->_save_surgery($responseObj, $responsecode, $responseMessage);
                break;
            case "anestesi":
                $this->_save_anestesi($responseObj, $responsecode, $responseMessage);
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
            case "users":
                $this->_save_users($responseObj, $responsecode, $responseMessage);
                break;
            case "patient":
                $this->_save_patient($responseObj, $responsecode, $responseMessage);
                break;
            case "bills":
                $this->_save_bills($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}