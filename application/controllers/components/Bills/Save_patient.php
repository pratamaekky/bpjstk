<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Save_patient
{
    protected $CI;
    protected $appSrc;

    public function __construct($params)
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_params = $params;
    }

    public function action()
    {
        $patient = [
            "name" => $this->_params["name"],
            "kpj" => $this->_params["kpj"],
            "company" => $this->_params["company"],
            "npp" => $this->_params["npp"],
        ];

        $savePatient = $this->Masters->save("patient", $patient);
        $idPatient = intval(json_decode($savePatient)->data->item->id);

        $bill[$this->_params["yankes"]] = [
            "room" => $this->_params["yankes_room"],
            "admin" => $this->_params["yankes_administration"],
            "docter" => $this->_params["yankes_docter"],
            "lab" => $this->_params["yankes_lab"],
            "radiology" => $this->_params["yankes_radiology"],
            "medic" => $this->_params["yankes_medic"],
            "rehab" => $this->_params["yankes_rehab"],
        ];

        $dataBills = [
            "rs_id" => $this->_params["rs_id"],
            "id_patient" => $idPatient,
            "jkk_date" => date("Y-m-d H:i:00", strtotime($this->_params["jkk_date"])),
            "treatment_date" => date("Y-m-d", strtotime($this->_params["treatment_date"])),
            "last_condition" => $this->_params["last_condition"],
            "ranap_date_start" => date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[0])),
            "ranap_date_last" => date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[1])),
            "last_rajal" => $this->_params["last_rajal"],
            "diagnose" => $this->_params["diagnose"],
            "dx_sekunder" => $this->_params["dx_sekunder"],
            "stmb" => $this->_params["stmb"],
            "action" => $this->_params["action"],
            "bills" => json_encode($bill)
        ];

        $savePatient = $this->Masters->save("bills", $dataBills);
        
        echo $savePatient;
    }

}