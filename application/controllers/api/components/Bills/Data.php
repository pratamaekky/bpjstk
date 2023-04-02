<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_bills
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

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "patient_name";

        $totalBills = $this->CI->mbills->totalData();
        if ($totalBills > 0) {
            $result = $this->CI->mbills->getData($query, $start, $limit, $sortColumn, $order);

            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Bills",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalBills),
                "aaData" => $result
            ]
        ];
    }
}