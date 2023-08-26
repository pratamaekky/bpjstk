<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Save_bills
{
    protected $CI;
    protected $appSrc;

    public function __construct($params)
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model([
            'mbills'
        ]);
        $this->CI->load->library(array(
            'form_validation'
        ));

        // $this->_params = $params;
        $this->_params = json_decode(json_encode($params), JSON_OBJECT_AS_ARRAY);
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

        $dataBills = [
            "rs_id" => $this->_params["rs_id"],
            "id_patient" => $idPatient,
            "jenis_kelamin" => $this->_params["jenis_kelamin"],
            "lokasi" => $this->_params["lokasi"],
            "jkk_date" => date("Y-m-d H:i:00", strtotime($this->_params["jkk_date"])),
            "treatment_date" => date("Y-m-d", strtotime($this->_params["treatment_date"])),
            "last_condition" => $this->_params["last_condition"],
            "ranap_date_start" => !empty($this->_params["ranap_date"]) ? date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[0])) : "",
            "ranap_date_last" => !empty($this->_params["ranap_date"]) ? date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[1])) : "",
            "last_rajal" => date("Y-m-d", strtotime($this->_params["last_rajal"])),
            "diagnose" => $this->_params["diagnose"],
            "dx_sekunder" => $this->_params["dx_sekunder"],
            "action" => $this->_params["action"],
            "verification" => $this->_params["verification"],
            "cob" => $this->_params["cob_subtotal"][0],
            "stmb" => json_encode($this->_params["stmb"]),
            "total_bayar" => $this->_params["total_bayar"],
            "total" => 0
        ];

        $idBills = $this->CI->mbills->save($dataBills);
        $bills = [];
        if ($idBills > 0) {
            foreach ($this->_params['yankes'] as $yankesType => $yankesData) {
                foreach ($yankesData as $type => $datas) {
                    switch ($type) {
                        case "room":
                        case "docter":
                        case "laboratory":
                        case "radiology":
                        case "medic":
                        case "rehab":
                            foreach ($datas as $data) {
                                $valueId = explode("-", $data["value"])[0];
                                if ($valueId > 0) {
                                    $dataBillsDetail = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankesType,
                                        "type" => $type,
                                        "value" => "",
                                        "value_id" => intval($valueId),
                                        "fare" => intval($data["rate"]),
                                        "qty" => intval($data["qty"]),
                                        "total" => isset($data["subtotal"]) ? $data["subtotal"] : (intval($data["rate"]) * intval($data["qty"]))
                                    ];

                                    $bills[] = $dataBillsDetail;
                                    $idData = $this->CI->mbills->saveBillsDetail($dataBillsDetail);

                                    if (isset($data["do"])) {
                                        foreach ($data["do"] as $do) {
                                            $dataBillsDetail = [
                                                "id_bills" => $idBills,
                                                "yankes" => $yankesType,
                                                "type" => $type . "_do",
                                                "value" => $do["value"],
                                                "value_id" => $idData,
                                                "fare" => intval($do["subtotal"]),
                                                "qty" => 1,
                                                "total" => intval($do["subtotal"]),
                                            ];

                                            $bills[] = $dataBillsDetail;
                                            $this->CI->mbills->saveBillsDetail($dataBillsDetail);
                                        }
                                    }
                                }
                            }
                            break;
                        case "admin";
                        case "surgery";
                        case "anestesi":
                        case "ambulance":
                            foreach ($datas as $data) {
                                $valueId = explode("-", $data["value"])[0];
                                if ($valueId > 0) {
                                    $dataBillsDetail = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankesType,
                                        "type" => $type,
                                        "value" => "",
                                        "value_id" => intval($valueId),
                                        "fare" => intval($data["subtotal"]),
                                        "qty" => 1,
                                        "total" => intval($data["subtotal"])
                                    ];

                                    $bills[] = $dataBillsDetail;
                                    $idData = $this->CI->mbills->saveBillsDetail($dataBillsDetail);

                                    if (isset($data["do"])) {
                                        foreach ($data["do"] as $do) {
                                            $dataBillsDetail = [
                                                "id_bills" => $idBills,
                                                "yankes" => $yankesType,
                                                "type" => $type . "_do",
                                                "value" => $do["value"],
                                                "value_id" => $idData,
                                                "fare" => intval($do["subtotal"]),
                                                "qty" => 1,
                                                "total" => intval($do["subtotal"]),
                                            ];

                                            $bills[] = $dataBillsDetail;
                                            $this->CI->mbills->saveBillsDetail($dataBillsDetail);
                                        }
                                    }
                                }
                            }
                            break;
                        default:
                            foreach ($datas as $data) {
                                if (!empty($data["value"])) {
                                    $dataBillsDetail = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankesType,
                                        "type" => $type,
                                        "value" => $data["value"],
                                        "value_id" => 0,
                                        "fare" => intval($data["subtotal"]),
                                        "qty" => 1,
                                        "total" => intval($data["subtotal"])
                                    ];

                                    $bills[] = $dataBillsDetail;
                                    $this->CI->mbills->saveBillsDetail($dataBillsDetail);
                                }
                            }
                            break;
                    }
                }
            }
        }

        $subTotalBills = 0;
        if (!empty($bills)) {
            foreach ($bills as $bill) {
                $subTotalBills += intval($bill["total"]);
            }
        }

        $cob = intval($this->_params["cob_subtotal"][0]);
        $totalBills = $subTotalBills - $cob;

        if ($subTotalBills > 0 && $totalBills > 0)
            $this->CI->mbills->updateTotalBills(["id" => $idBills, "subtotal" => $subTotalBills, "total" => $totalBills]);

        if ($idBills > 0) {
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Save New Bills",
            "item" => []
        ];
        echo $savePatient;
    }

}