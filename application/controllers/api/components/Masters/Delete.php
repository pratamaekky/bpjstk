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

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                $this->_delete_hospital($responseObj, $responsecode, $responseMessage);
                break;
        }
    }

}