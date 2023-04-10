<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class BDelete
{
    protected $CI;
    protected $appSrc;

    public function __construct($params)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model([
            'mbills'
        ]);
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_params = $params;
    }

    public function action()
    {
        $res_code = 201;
        $res_message = "";
        $res_data = null;

        $bill = $this->CI->mbills->getRowById($this->_params["id"]);

        if (is_null($bill)) $res_message = "Data Tagihan tidak ditemukan. Silahkan coba kembali";

        if (empty($res_message)) {
            unset($bill["id"]);
            $res_date = $bill;
            $this->CI->mbills->delete($this->_params);

            $res_code = 200;
            $res_message = "Success";
            $res_data = [
                "name" => "Data Tagihan berhasil dihapus!"
            ];
        }
        
        echo json_encode([
            "result" => $res_code,
            "message" => $res_message,
            "data" => $res_data
        ]);
    }

}