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
        $responseCity = $this->Masters->data("city", null, $params);
        $responseCity = json_decode($responseCity);

        $result = ($responseCity->result == 200) ? $responseCity->data->item : $responseCity->data;
        
        echo json_encode($result);
    }

    private function _district()
    {
        $params["idCity"] = (isset($this->_params["id"]) && $this->_params["id"] != 0 ) ? $this->_params["id"] : 0;
        $responseDistrict = $this->Masters->data("district", null, $params);
        $responseDistrict = json_decode($responseDistrict);

        $result = ($responseDistrict->result == 200) ? $responseDistrict->data->item : $responseDistrict->data;
        
        echo json_encode($result);
    }

    private function _postalcode()
    {
        $params["idProvince"] = (isset($this->_params["idProvince"]) && $this->_params["idProvince"] != 0 ) ? $this->_params["idProvince"] : 0;
        $params["idCity"] = (isset($this->_params["idCity"]) && $this->_params["idCity"] != 0 ) ? $this->_params["idCity"] : 0;
        $params["idDistrict"] = (isset($this->_params["idDistrict"]) && $this->_params["idDistrict"] != 0 ) ? $this->_params["idDistrict"] : 0;
        $responsePostalcode = $this->Masters->data("postalcode", null, $params);
        $responsePostalcode = json_decode($responsePostalcode);

        $result = ($responsePostalcode->result == 200) ? $responsePostalcode->data->item : $responsePostalcode->data;
        
        echo json_encode($result);
    }

    private function _layanan()
    {
        $rs_id = $this->_params["rs_id"];
        $result = [];
        $responseRoom = $this->Masters->data("room", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseRoom = json_decode($responseRoom);
        if ($responseRoom->result == 200) {
            $result["room"] = $responseRoom->data->item->aaData;
        }

        $responseFee = $this->Masters->data("fee", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseFee = json_decode($responseFee);
        if ($responseFee->result == 200) {
            $result["fee"] = $responseFee->data->item->aaData;
        }

        $responseDocter = $this->Masters->data("doctor", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseDocter = json_decode($responseDocter);
        if ($responseDocter->result == 200) {
            $result["docter"] = $responseDocter->data->item->aaData;
        }

        $responseSurgery = $this->Masters->data("surgery", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseSurgery = json_decode($responseSurgery);
        if ($responseDocter->result == 200) {
            $result["surgery"] = $responseSurgery->data->item->aaData;
        }

        $responseAnestesi = $this->Masters->data("anestesi", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseAnestesi = json_decode($responseAnestesi);
        if ($responseDocter->result == 200) {
            $result["anestesi"] = $responseAnestesi->data->item->aaData;
        }

        $responseLaboratory = $this->Masters->data("laboratory", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseLaboratory = json_decode($responseLaboratory);
        if ($responseLaboratory->result == 200) {
            $result["laboratory"] = $responseLaboratory->data->item->aaData;
        }

        $responseRadiology = $this->Masters->data("radiology", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseRadiology = json_decode($responseRadiology);
        if ($responseRadiology->result == 200) {
            $result["radiology"] = $responseRadiology->data->item->aaData;
        }

        $responseMedic = $this->Masters->data("medic", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseMedic = json_decode($responseMedic);
        if ($responseMedic->result == 200) {
            $result["medic"] = $responseMedic->data->item->aaData;
        }

        $responseRehab = $this->Masters->data("rehabilitation", null, ["rsid" => $rs_id, "length" => 1000]);
        $responseRehab = json_decode($responseRehab);
        if ($responseRehab->result == 200) {
            $result["rehab"] = $responseRehab->data->item->aaData;
        }

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
            case 'layanan':
                $this->_layanan();
                break;
            default:
                # code...
                break;
        }
    }

}