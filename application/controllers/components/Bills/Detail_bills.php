<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");
require_once APPPATH . 'controllers/api/v60/ABills.php';

class Detail_bills
{
    protected $CI;
    protected $appSrc;

    public function __construct($params)
    {
        $this->ABills = new ABills();
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
        $modal_detail = @file_get_contents(APPPATH . "views/public/bills/modal_view.php");

        $responseBills = $this->ABills->detail($this->_params);
        $responseBills = json_decode($responseBills, JSON_OBJECT_AS_ARRAY);

        if ($responseBills["result"] == 200) {
            $bill = $responseBills["data"]["item"];
            $details = $bill["detail"];

            $modal_detail = str_replace("[INFO_HOSPITAL_NAME]", $bill["hospital"]["name"], $modal_detail);

            $modal_detail = str_replace("[INFO_PATIENT_KPJ]", $bill["patient"]["kpj"], $modal_detail);
            $modal_detail = str_replace("[INFO_PATIENT_NPP]", $bill["patient"]["npp"], $modal_detail);
            $modal_detail = str_replace("[INFO_PATIENT_NAME]", $bill["patient"]["name"], $modal_detail);
            $modal_detail = str_replace("[INFO_PATIENT_JENIS_KELAMIN]", $bill["jenis_kelamin"], $modal_detail);
            $modal_detail = str_replace("[INFO_PATIENT_COMPANY]", $bill["patient"]["company"], $modal_detail);
            $modal_detail = str_replace("[INFO_PATIENT_LOKASI]", $bill["lokasi"], $modal_detail);
            
            $modal_detail = str_replace("[INFO_JKK]", $bill["jkk_date"], $modal_detail);
            $modal_detail = str_replace("[INFO_LAST_CONDITION]", $bill["last_condition"], $modal_detail);
            $modal_detail = str_replace("[INFO_TREATMENT_DATE]", $bill["treatment_date"], $modal_detail);

            $billStmb = json_decode($bill["stmb"]);
            $stmbLabel = "";
            if (!empty($billStmb)) {
                foreach ($billStmb as $stmb) {
                    $stmbLabel .= '<label class="form-control col-sm-12 col-12">' . $stmb . '</label>';
                }
            }
            $modal_detail = str_replace("[INFO_STMB]", $stmbLabel, $modal_detail);
            
            $modal_detail = str_replace("[INFO_RANAP]", $bill["ranap_date_start"] . " - " . $bill["ranap_date_last"], $modal_detail);
            $modal_detail = str_replace("[INFO_RAJAL]", $bill["last_rajal"], $modal_detail);
            $modal_detail = str_replace("[INFO_DX_SEKUNDER]", $bill["dx_sekunder"], $modal_detail);

            $modal_detail = str_replace("[INFO_DIAGNOSE]", $bill["diagnose"], $modal_detail);
            $modal_detail = str_replace("[INFO_ACTION]", $bill["action"], $modal_detail);
            $modal_detail = str_replace("[INFO_VERIFICATION]", $bill["verification"], $modal_detail);

            $modal_detail = str_replace("[INFO_COB]", number_format($bill["cob"], 0, ",", "."), $modal_detail);
            // $modal_detail = str_replace("[INFO_YANKES]", $bill["yankes"], $modal_detail);

            $elementsBillDetail = "-";
            $elementsBillDetail = "-";
            $yankesAdmin = "-";
            $yankesMedicine = "-";
            $yankesDocter = "-";
            $yankesDocterDo = "-";
            $yankesSurgery = "-";
            $yankesSurgeryNurse = "-";
            $yankesAnestesi = "-";
            $yankesLab = "-";
            $yankesRadiology = "-";
            $yankesMedic = "-";
            $yankesRehab = "-";
            $yankesAmbulance = "-";
            $total = 0;
            $cob = $bill["cob"];

            $itemsLabel = [
                "room" => "Kamar",
                "room_nurse" => "Jasa Perawat Kamar",
                "admin" => "Administrasi",
                "medicine" => "Obat-obatan",
                "docter" => "Docter Umum / IGD",
                "surgery" => "Dokter Spesialis",
                "surgery_nurse" => "Jasa Perawat Operasi",
                "anestesi" => "Dokter Anestesi",
                "laboratory" => "Laboratorium",
                "lab" => "Laboratorium",
                "radiology" => "Radiologi",
                "medic" => "Medikal",
                "rehab" => "Rehabilitasi",
                "ambulance" => "Ambulance",
            ];

            foreach ($details as $yankes => $yankesDatas) {
                $elementsBillDetail = '';
                foreach ($yankesDatas as $type => $datas) {
                    $subTotalByType = 0;
                    $elementsBillDetail .= '<div class="form-group col-12 separate-div-bottom">';
                    $elementsBillDetail .= '    <div class="row">';
                    $elementsBillDetail .= '        <label for="yankes" class="col-form-label col-sm-3 col-3">' . $itemsLabel[$type] . '</label>';
                    $elementsBillDetail .= '        <div class="input-group col-sm-9 col-9">';

                    switch($type) {
                        case "room_nurse":
                        case "admin":
                        case "medicine":
                        case "surgery":
                        case "surgery_nurse":
                        case "anestesi":
                        case "ambulance":
                            foreach ($datas as $data) {
                                $elementsBillDetail .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                                $elementsBillDetail .= '    <p class="form-control col-sm-9 col-9 mr-2 text-bold" style="height: auto;">' . $data["value"] . '</p>';
                                $elementsBillDetail .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                                $elementsBillDetail .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                                $elementsBillDetail .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($data["total"], 0, ",", ".") . '</label>';
                                $elementsBillDetail .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                                $elementsBillDetail .= '    </label>';
                                $elementsBillDetail .= '</div>';

                                $subTotalByType += intval($data["total"]);
                            }

                            break;
                        case "room":
                        case "docter":
                        case "laboratory":
                        case "lab":
                        case "radiology":
                        case "medic":
                        case "rehab":
                            foreach ($datas as $data) {
                                $elementsBillDetail .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                                $elementsBillDetail .= '    <p class="form-control col-sm-4 col-4 mr-2 text-bold" style="height: auto;">' . $data["value"] . '</p>';
                                $elementsBillDetail .= '    <label class="form-control col-sm-1 col-1">' . $data["qty"] . '</label>';
                                $elementsBillDetail .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                                $elementsBillDetail .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                                $elementsBillDetail .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                                $elementsBillDetail .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                                $elementsBillDetail .= '    </label>';
                                $elementsBillDetail .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($data["fare"], 0, ",", ".") . '</label>';
                                $elementsBillDetail .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                                $elementsBillDetail .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                                $elementsBillDetail .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($data ["total"], 0, ",", ".") . '</label>';
                                $elementsBillDetail .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                                $elementsBillDetail .= '    </label>';
                                $elementsBillDetail .= '</div>';
                                
                                $subTotalByType += intval($data["total"]);
                            }
                            break;
                    }

                    $elementsBillDetail .= '            <div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                    $elementsBillDetail .= '                <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                    $elementsBillDetail .= '                <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                    $elementsBillDetail .= '                <label class="row-flex col-sm-2 col-2 no-padding">';
                    $elementsBillDetail .= '                    <label class="form-control col-sm-11 col-11 text-right">' . number_format($subTotalByType, 0, ",", ".") . '</label>';
                    $elementsBillDetail .= '                    <label class="col-sm-1 col-1">&nbsp;</label>';
                    $elementsBillDetail .= '                </label>';
                    $elementsBillDetail .= '            </div>';
                    $elementsBillDetail .= '        </div>';
                    $elementsBillDetail .= '    </div>';
                    $elementsBillDetail .= '</div>';
                }

                $modal_detail = str_replace("[DETAIL_BILLS_" . strtoupper($yankes) . "]", $elementsBillDetail, $modal_detail);
            }
             
            $modal_detail = str_replace("[DETAIL_BILLS_RANAP]", "-", $modal_detail);
            $modal_detail = str_replace("[DETAIL_BILLS_RAJAL]", "-", $modal_detail);
            // $total = $total - $cob;
            $modal_detail = str_replace("[INFO_TOTAL_BAYAR]", number_format($bill["total_bayar"], 0, ",", "."), $modal_detail);
            $modal_detail = str_replace("[INFO_TOTAL]", number_format($bill["total"], 0, ",", "."), $modal_detail);
        }
        
        echo json_encode($modal_detail);
    }

}