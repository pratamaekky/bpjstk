<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/base/Transformer.php");

class Data
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

    private function _data_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $getHospital = $this->CI->mhospital->getData();

        if (!is_null($getHospital)) {
            foreach ($getHospital as $key => $hospital) {
                $row = [
                    "no" => ($key  + 1),
                    "name" => $hospital->name,
                    "address" => $hospital->address . ", " . $hospital->village . ", " . $hospital->district . ", " . $hospital->city . ", " . $hospital->province . " - " . $hospital->postalcode,
                    "telp" => $hospital->telp,
                    "type" => ($hospital->type == 0) ? "Rumah Sakit Umum" : "Rumah Sakit Swasta",
                    "class" => $hospital->class,
                    "owner" => Transformer::convertHospitalOwner($hospital->owner),
                    "action" => "Aksi"
                ];

                $result[] = $row;
            }
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Hospital",
            "item" => [
                "draw" => 1,
                "iTotalRecords" => count($getHospital),
                "iTotalDisplayRecords" => count($getHospital),
                "aaData" => $result
            ]
        ];
    }

    private function _data_province(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $getProvince = $this->CI->general->getProvince();

        if (!is_null($getProvince)) {
            $responsecode = 200;
            $result = $getProvince;
        }

        $responseObj  = [
            "name"  => "Data Province",
            "item"  => $result
        ];
    }

    private function _data_city(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idProvince = isset($this->_params["idProvince"]) ? $this->_params["idProvince"] : 0;
        $getCity = $this->CI->general->getCity($idProvince);

        if (!is_null($getCity)) {
            $responsecode = 200;
            $result = $getCity;
        }

        $responseObj  = [
            "name"  => "Data City",
            "item"  => $result
        ];
    }

    private function _data_district(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idCity = isset($this->_params["idCity"]) ? $this->_params["idCity"] : 0;
        $getDistrict = $this->CI->general->getDistrict($idCity);

        if (!is_null($getDistrict)) {
            $responsecode = 200;
            $result = $getDistrict;
        }

        $responseObj  = [
            "name"  => "Data District",
            "item"  => $result
        ];
    }

    private function _data_postalcode(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idProvince = isset($this->_params["idProvince"]) ? $this->_params["idProvince"] : 0;
        $idCity = isset($this->_params["idCity"]) ? $this->_params["idCity"] : 0;
        $idDistrict = isset($this->_params["idDistrict"]) ? $this->_params["idDistrict"] : 0;
        $getPostalcode = $this->CI->general->getPostalCode($idProvince, $idCity, $idDistrict);

        if (!is_null($getPostalcode)) {
            $responsecode = 200;
            $result = $getPostalcode;
        }

        $responseObj  = [
            "name"  => "Data Postal Code",
            "item"  => $result
        ];
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_data_hospital($responseObj, $responsecode, $responseMessage);
                break;
            case "province":
                $this->_data_province($responseObj, $responsecode, $responseMessage);
                break;
            case "city":
                $this->_data_city($responseObj, $responsecode, $responseMessage);
                break;
            case "district":
                $this->_data_district($responseObj, $responsecode, $responseMessage);
                break;
            case "postalcode":
                $this->_data_postalcode($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}