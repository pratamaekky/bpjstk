<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';

class Hospital
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

    private function _lists()
    {
        $responseProvince = $this->Masters->data("province");
        $responseProvince = json_decode($responseProvince);
        $data["getProvince"] = ($responseProvince->result == 200) ? $responseProvince->data->item : $responseProvince->data;

        $this->CI->load->view("public/hospital.php", $data);
    }

    private function _save()
    {
        unset($this->_params["project_id"]);
        unset($this->_params["todo"]);
        unset($this->_params["btnTodo"]);
        $getProvinsi = $this->Masters->save("hospital", $this->_params);
    }

    private function _data()
    {
        $responseHospital = $this->Masters->data("hospital");
        $responseHospital = json_decode($responseHospital);

        $result = ($responseHospital->result == 200) ? $responseHospital->data->item : $responseHospital->data;

        echo json_encode($result);
    }

    public function action()
    {
        switch ($this->_command) {
            case 'lists':
                $this->_lists();
                break;
            case 'save':
                $this->_save();
                break;
            case 'data':
                $this->_data();
                break;
            default:
                # code...
                break;
        }
    }
}