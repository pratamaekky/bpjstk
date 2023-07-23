<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
require_once APPPATH . 'controllers/api/v60/ABills.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Export
{
    protected $CI;
    protected $appSrc;

    public function __construct($id = 0)
    {
        $this->Masters = new Masters();
        $this->ABills = new ABills();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_id = $id;
    }

    public function action()
    {
        $this->_params["id"] = $this->_id;
        $res_message = "";
        $res_code = 201;
        $res_data = null;

        $responseBills = $this->ABills->detail($this->_params);
        $responseBills = json_decode($responseBills, JSON_OBJECT_AS_ARRAY);

        $res_message = $responseBills["message"];

        if ($responseBills["result"] == 200) {
            $this->_params["bills"] = $responseBills["data"]["item"];
            $responseExport = $this->ABills->export($this->_params);
            $responseExport = json_decode($responseExport, JSON_OBJECT_AS_ARRAY);

            $fname = $responseExport["data"]["item"];

            header('Content-Type: application/vnd.ms-excel'); // mime type
            
            redirect(base_url("files/" . $fname));
        }
    }

}