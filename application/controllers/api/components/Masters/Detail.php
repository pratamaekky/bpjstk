<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail
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

    private function _general(&$responseObj, &$responsecode, &$responseMessage)
    {
        $genId = isset($this->_params["id"]) ? intval($this->_params["id"]) : 0;

        if ($genId == 0) throw new Exception("Data tidak lengkap! Silahkan cek kembali", 201);

        $general = $this->CI->general->getGeneralById($genId);
        if (is_null($general)) throw new Exception("Data general tidak ditemukan. Silahkan coba kembali!", 201);
        
        $responsecode = 200;
        $responseObj  = [
            "name"  => "Detail General",
            "item"  => $general
        ];
    }

    private function _service(&$responseObj, &$responsecode, &$responseMessage)
    {
        $serviceId = isset($this->_params["id"]) ? intval($this->_params["id"]) : 0;

        if ($serviceId == 0) throw new Exception("Data tidak lengkap! Silahkan cek kembali", 201);

        $service = $this->CI->general->getServiceById($serviceId, $this->_command);
        if (is_null($service)) throw new Exception("Data " . ucwords($this->_command) . " tidak ditemukan. Silahkan coba kembali!", 201);
        
        $responsecode = 200;
        $responseObj  = [
            "name"  => "Detail " . ucwords($this->_command),
            "item"  => $service
        ];
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case 'general':
                $this->_general($responseObj, $responsecode, $responseMessage);
                break;
            case 'room':
            case "radiology":
            case "rehabilitation":
            case "medic":
            case "doctor":
            case "surgery":
            case "laboratory":
            case "fee":
                $this->_service($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}