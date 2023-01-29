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

    private function _save_province(&$responseObj, &$responsecode, &$responseMessage)
    {
        var_dump($this->_params);
        $saveHospital = $this->CI->mhospital->save($this->_params);
        var_dump($saveHospital);
    }

    public function action(&$responseObj, &$params, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_save_province($responseObj, $params, $responsecode, $responseMessage);
                break;
            // case "city":
            //     $this->_data_city($responseObj, $params, $responsecode, $responseMessage);
            //     break;
            // case "district":
            //     $this->_data_district($responseObj, $params, $responsecode, $responseMessage);
            //     break;
            // case "postalcode":
            //     $this->_data_postalcode($responseObj, $params, $responsecode, $responseMessage);
            //     break;
        }
    }
}