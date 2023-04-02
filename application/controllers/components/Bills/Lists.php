<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
require_once APPPATH . 'controllers/api/v60/ABills.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Lists
{
    protected $CI;
    protected $appSrc;

    public function __construct($command = "", $params = null)
    {
        $this->Masters = new Masters();
        $this->ABills = new ABills();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_command = $command;
        $this->_params = $params;
    }

    public function action()
    {
        if ($this->_command == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseBills = $this->ABills->data($this->_params);
            $responseBills = json_decode($responseBills);

            if ($responseBills->result == 200) {
                $resBills = $responseBills->data->item->aaData;
                if (!empty($resBills)) {
                    foreach ($resBills as $key => $bills) {
                        $row = [
                            "no" => ($key  + 1),
                            "patient_name" => $bills->patient_name,
                            "kpj" => $bills->kpj,
                            "hospital_name" => $bills->hospital_name,
                            "diagnose" => $bills->diagnose,
                            "last_condition" => $bills->last_condition,
                            "subtotal" => "Rp " . number_format($bills->subtotal, 0, ",", "."),
                            "cob" => "Rp " . number_format($bills->cob, 0, ",", "."),
                            "total" => "Rp " . number_format($bills->total, 0, ",", "."),
                            "action" => "<a class='btn btn-sm btn-primary mr-2' href='javascript:void(0)' onclick='detail_bills(" . $bills->id . ")' aria-expanded='true'><i class='fas fa-search'></i></a>
                                         <a class='btn btn-sm btn-danger' href='javascript:void(0)' onclick='delete_bills(" . $bills->id . ")' aria-expanded='true'><i class='fas fa-trash-alt'></i></a>"
                        ];

                        $items[] = $row;

                    }
                }

                $draw = $responseBills->data->item->draw;
                $totalRecods = $responseBills->data->item->iTotalRecords;
                $totalDisplays = $responseBills->data->item->iTotalDisplayRecords;
            }
            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else {
            $hospitals = [];
            $responseHospital = $this->Masters->data("hospital", "", ["length" => 100]);
            $responseHospital = json_decode($responseHospital);

            if ($responseHospital->result == 200) {
                $hospitals = $responseHospital->data->item->aaData;
            }

            $data["hospitals"] = $hospitals;

            $this->CI->load->view("public/bills/lists.php", $data);
        }
    }
}