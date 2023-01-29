<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';

class Datas
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $params)
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_params = $params;
        $this->_command = $command;
    }

    private function _city()
    {
        $params["idProvince"] = (isset($this->_params["id"]) && $this->_params["id"] != 0 ) ? $this->_params["id"] : 0;
        $responseCity = $this->Masters->data("city", $params);
        $responseCity = json_decode($responseCity);

        $result = ($responseCity->result == 200) ? $responseCity->data->item : $responseCity->data;
        
        echo json_encode($result);
    }

    private function _district()
    {
        $params["idCity"] = (isset($this->_params["id"]) && $this->_params["id"] != 0 ) ? $this->_params["id"] : 0;
        $responseDistrict = $this->Masters->data("district", $params);
        $responseDistrict = json_decode($responseDistrict);

        $result = ($responseDistrict->result == 200) ? $responseDistrict->data->item : $responseDistrict->data;
        
        echo json_encode($result);
    }

    private function _postalcode()
    {
        $params["idProvince"] = (isset($this->_params["idProvince"]) && $this->_params["idProvince"] != 0 ) ? $this->_params["idProvince"] : 0;
        $params["idCity"] = (isset($this->_params["idCity"]) && $this->_params["idCity"] != 0 ) ? $this->_params["idCity"] : 0;
        $params["idDistrict"] = (isset($this->_params["idDistrict"]) && $this->_params["idDistrict"] != 0 ) ? $this->_params["idDistrict"] : 0;
        $responsePostalcode = $this->Masters->data("postalcode", $params);
        $responsePostalcode = json_decode($responsePostalcode);

        $result = ($responsePostalcode->result == 200) ? $responsePostalcode->data->item : $responsePostalcode->data;
        
        echo json_encode($result);
    }

    public function action()
    {
        switch ($this->_command) {
            case 'city':
                $this->_city();
                break;
            case 'district':
                $this->_district();
                break;
            case 'postalcode':
                $this->_postalcode();
                break;
            default:
                # code...
                break;
        }
    }

}