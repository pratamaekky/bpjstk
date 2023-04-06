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

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case 'general':
                $this->_general($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}