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
            $detail = $bill["detail"];

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
            $modal_detail = str_replace("[INFO_YANKES]", $bill["yankes"], $modal_detail);

            $yankesRoom = "-";
            $yankesRoomNurse = "-";
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

            if (isset($detail["room"]) && !is_null($detail["room"]) && !empty($detail["room"])) {
                $roomSubTotal = 0;
                $yankesRoom = "";
                foreach ($detail["room"] as $room) {
                    $yankesRoom .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesRoom .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $room["value"] . '</label>';
                    $yankesRoom .= '    <label class="form-control col-sm-1 col-1">' . $room["qty"] . '</label>';
                    $yankesRoom .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesRoom .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesRoom .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesRoom .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesRoom .= '    </label>';
                    $yankesRoom .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($room["fare"], 0, ",", ".") . '</label>';
                    $yankesRoom .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesRoom .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesRoom .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($room["total"], 0, ",", ".") . '</label>';
                    $yankesRoom .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesRoom .= '    </label>';
                    $yankesRoom .= '</div>';

                    $roomSubTotal += $room["total"];
                    $total += $room["total"];
                }
                $yankesRoom .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesRoom .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesRoom .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesRoom .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesRoom .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($roomSubTotal, 0, ",", ".") . '</label>';
                $yankesRoom .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesRoom .= '    </label>';
                $yankesRoom .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_ROOM]", $yankesRoom, $modal_detail);

            if (isset($detail["room_nurse"]) && !is_null($detail["room_nurse"]) && !empty($detail["room_nurse"])) {
                $room_nurseSubTotal = 0;
                $yankesRoomNurse = "";
                foreach ($detail["room_nurse"] as $room_nurse) {
                    $yankesRoomNurse .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesRoomNurse .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $room_nurse["value"] . '</label>';
                    $yankesRoomNurse .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesRoomNurse .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesRoomNurse .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($room_nurse["total"], 0, ",", ".") . '</label>';
                    $yankesRoomNurse .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesRoomNurse .= '    </label>';
                    $yankesRoomNurse .= '</div>';

                    $room_nurseSubTotal += $room_nurse["total"];
                    $total += $room_nurse["total"];
                }
                $yankesRoomNurse .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesRoomNurse .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesRoomNurse .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesRoomNurse .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesRoomNurse .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($room_nurseSubTotal, 0, ",", ".") . '</label>';
                $yankesRoomNurse .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesRoomNurse .= '    </label>';
                $yankesRoomNurse .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_ROOM_NURSE]", $yankesRoomNurse, $modal_detail);

            if (isset($detail["admin"]) && !is_null($detail["admin"]) && !empty($detail["admin"])) {
                $adminSubTotal = 0;
                $yankesAdmin = "";
                foreach ($detail["admin"] as $admin) {
                    $yankesAdmin .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesAdmin .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $admin["value"] . '</label>';
                    $yankesAdmin .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesAdmin .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesAdmin .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($admin["total"], 0, ",", ".") . '</label>';
                    $yankesAdmin .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesAdmin .= '    </label>';
                    $yankesAdmin .= '</div>';

                    $adminSubTotal += $admin["total"];
                    $total += $admin["total"];
                }
                $yankesAdmin .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesAdmin .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesAdmin .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesAdmin .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesAdmin .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($adminSubTotal, 0, ",", ".") . '</label>';
                $yankesAdmin .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesAdmin .= '    </label>';
                $yankesAdmin .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_ADMIN]", $yankesAdmin, $modal_detail);

            if (isset($detail["medicine"]) && !is_null($detail["medicine"]) && !empty($detail["medicine"])) {
                $medicineSubTotal = 0;
                $yankesMedicine = "";
                foreach ($detail["medicine"] as $medicine) {
                    $yankesMedicine .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesMedicine .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $medicine["value"] . '</label>';
                    $yankesMedicine .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesMedicine .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesMedicine .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($medicine["total"], 0, ",", ".") . '</label>';
                    $yankesMedicine .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesMedicine .= '    </label>';
                    $yankesMedicine .= '</div>';

                    $medicineSubTotal += $medicine["total"];
                    $total += $medicine["total"];
                }
                $yankesMedicine .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesMedicine .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesMedicine .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesMedicine .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesMedicine .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($medicineSubTotal, 0, ",", ".") . '</label>';
                $yankesMedicine .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesMedicine .= '    </label>';
                $yankesMedicine .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_MEDICINE]", $yankesMedicine, $modal_detail);

            if (isset($detail["docter"]) && !is_null($detail["docter"]) && !empty($detail["docter"])) {
                $docterSubTotal = 0;
                $yankesDocter = "";
                foreach ($detail["docter"] as $docter) {
                    $yankesDocter .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesDocter .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $docter["value"] . '</label>';
                    $yankesDocter .= '    <label class="form-control col-sm-1 col-1">' . $docter["qty"] . '</label>';
                    $yankesDocter .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesDocter .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesDocter .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesDocter .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesDocter .= '    </label>';
                    $yankesDocter .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($docter["fare"], 0, ",", ".") . '</label>';
                    $yankesDocter .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesDocter .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesDocter .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($docter["total"], 0, ",", ".") . '</label>';
                    $yankesDocter .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesDocter .= '    </label>';
                    $yankesDocter .= '</div>';

                    if (isset($docter["children"]) && !empty($docter["children"])) {
                        foreach ($docter["children"] as $children) {
                            $yankesDocter .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                            $yankesDocter .= '    <label class="row-flex col-sm-9 col-9 mr-2 pr-3">';
                            $yankesDocter .= '        <label class="form-control col-sm-12 col-12 ml-3">' . $children["value"] . '</label>';
                            $yankesDocter .= '    </label>';
                            $yankesDocter .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                            $yankesDocter .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                            $yankesDocter .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($children["total"], 0, ",", ".") . '</label>';
                            $yankesDocter .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                            $yankesDocter .= '    </label>';
                            $yankesDocter .= '</div>';

                            $docterSubTotal += $children["total"];
                            $total += $children["total"];
                        }
                    }

                    $docterSubTotal += $docter["total"];
                    $total += $docter["total"];
                }
                $yankesDocter .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesDocter .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesDocter .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesDocter .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesDocter .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($docterSubTotal, 0, ",", ".") . '</label>';
                $yankesDocter .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesDocter .= '    </label>';
                $yankesDocter .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_DOCTER]", $yankesDocter, $modal_detail);

            if (isset($detail["surgery"]) && !is_null($detail["surgery"]) && !empty($detail["surgery"])) {
                $surgerySubTotal = 0;
                $yankesSurgery = "";
                foreach ($detail["surgery"] as $surgery) {
                    $yankesSurgery .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesSurgery .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $surgery["value"] . '</label>';
                    $yankesSurgery .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesSurgery .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesSurgery .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($surgery["total"], 0, ",", ".") . '</label>';
                    $yankesSurgery .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesSurgery .= '    </label>';
                    $yankesSurgery .= '</div>';

                    if (isset($surgery["children"]) && !empty($surgery["children"])) {
                        foreach ($surgery["children"] as $children) {
                            $yankesSurgery .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                            $yankesSurgery .= '    <label class="row-flex col-sm-9 col-9 mr-2 pr-3">';
                            $yankesSurgery .= '        <label class="form-control col-sm-12 col-12 ml-3">' . $children["value"] . '</label>';
                            $yankesSurgery .= '    </label>';
                            $yankesSurgery .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                            $yankesSurgery .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                            $yankesSurgery .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($children["total"], 0, ",", ".") . '</label>';
                            $yankesSurgery .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                            $yankesSurgery .= '    </label>';
                            $yankesSurgery .= '</div>';

                            $surgerySubTotal += $children["total"];
                            $total += $children["total"];
                        }
                    }

                    $surgerySubTotal += $surgery["total"];
                    $total += $surgery["total"];
                }
                $yankesSurgery .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesSurgery .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesSurgery .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesSurgery .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesSurgery .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($surgerySubTotal, 0, ",", ".") . '</label>';
                $yankesSurgery .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesSurgery .= '    </label>';
                $yankesSurgery .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_SURGERY]", $yankesSurgery, $modal_detail);

            if (isset($detail["surgery_nurse"]) && !is_null($detail["surgery_nurse"]) && !empty($detail["surgery_nurse"])) {
                $surgery_nurseSubTotal = 0;
                $yankesSurgeryNurse = "";
                foreach ($detail["surgery_nurse"] as $surgery_nurse) {
                    $yankesSurgeryNurse .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesSurgeryNurse .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $surgery_nurse["value"] . '</label>';
                    $yankesSurgeryNurse .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesSurgeryNurse .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesSurgeryNurse .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($surgery_nurse["total"], 0, ",", ".") . '</label>';
                    $yankesSurgeryNurse .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesSurgeryNurse .= '    </label>';
                    $yankesSurgeryNurse .= '</div>';

                    $surgery_nurseSubTotal += $surgery_nurse["total"];
                    $total += $surgery_nurse["total"];
                }
                $yankesSurgeryNurse .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesSurgeryNurse .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesSurgeryNurse .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesSurgeryNurse .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesSurgeryNurse .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($surgery_nurseSubTotal, 0, ",", ".") . '</label>';
                $yankesSurgeryNurse .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesSurgeryNurse .= '    </label>';
                $yankesSurgeryNurse .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_SURGERY_NURSE]", $yankesSurgeryNurse, $modal_detail);

            if (isset($detail["anestesi"]) && !is_null($detail["anestesi"]) && !empty($detail["anestesi"])) {
                $anestesiSubTotal = 0;
                $yankesAnestesi = "";
                foreach ($detail["anestesi"] as $anestesi) {
                    $yankesAnestesi .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesAnestesi .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $anestesi["value"] . '</label>';
                    $yankesAnestesi .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesAnestesi .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesAnestesi .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($anestesi["total"], 0, ",", ".") . '</label>';
                    $yankesAnestesi .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesAnestesi .= '    </label>';
                    $yankesAnestesi .= '</div>';

                    if (isset($anestesi["children"]) && !empty($anestesi["children"])) {
                        foreach ($anestesi["children"] as $children) {
                            $yankesAnestesi .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                            $yankesAnestesi .= '    <label class="row-flex col-sm-9 col-9 mr-2 pr-3">';
                            $yankesAnestesi .= '        <label class="form-control col-sm-12 col-12 ml-3">' . $children["value"] . '</label>';
                            $yankesAnestesi .= '    </label>';
                            $yankesAnestesi .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                            $yankesAnestesi .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                            $yankesAnestesi .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($children["total"], 0, ",", ".") . '</label>';
                            $yankesAnestesi .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                            $yankesAnestesi .= '    </label>';
                            $yankesAnestesi .= '</div>';

                            $anestesiSubTotal += $children["total"];
                            $total += $children["total"];
                        }
                    }

                    $anestesiSubTotal += $anestesi["total"];
                    $total += $anestesi["total"];
                }
                $yankesAnestesi .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesAnestesi .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesAnestesi .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesAnestesi .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesAnestesi .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($anestesiSubTotal, 0, ",", ".") . '</label>';
                $yankesAnestesi .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesAnestesi .= '    </label>';
                $yankesAnestesi .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_ANESTESI]", $yankesAnestesi, $modal_detail);

            if (isset($detail["lab"]) && !is_null($detail["lab"]) && !empty($detail["lab"])) {
                $labSubTotal = 0;
                $yankesLab = "";
                foreach ($detail["lab"] as $lab) {
                    $yankesLab .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesLab .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $lab["value"] . '</label>';
                    $yankesLab .= '    <label class="form-control col-sm-1 col-1">' . $lab["qty"] . '</label>';
                    $yankesLab .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesLab .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesLab .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesLab .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesLab .= '    </label>';
                    $yankesLab .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($lab["fare"], 0, ",", ".") . '</label>';
                    $yankesLab .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesLab .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesLab .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($lab["total"], 0, ",", ".") . '</label>';
                    $yankesLab .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesLab .= '    </label>';
                    $yankesLab .= '</div>';

                    $labSubTotal += $lab["total"];
                    $total += $lab["total"];
                }
                $yankesLab .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesLab .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesLab .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesLab .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesLab .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($labSubTotal, 0, ",", ".") . '</label>';
                $yankesLab .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesLab .= '    </label>';
                $yankesLab .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_LAB]", $yankesLab, $modal_detail);

            if (isset($detail["radiology"]) && !is_null($detail["radiology"]) && !empty($detail["radiology"])) {
                $radiologySubTotal = 0;
                $yankesRadiology = "";
                foreach ($detail["radiology"] as $radiology) {
                    $yankesRadiology .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesRadiology .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $radiology["value"] . '</label>';
                    $yankesRadiology .= '    <label class="form-control col-sm-1 col-1">' . $radiology["qty"] . '</label>';
                    $yankesRadiology .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesRadiology .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesRadiology .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesRadiology .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesRadiology .= '    </label>';
                    $yankesRadiology .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($radiology["fare"], 0, ",", ".") . '</label>';
                    $yankesRadiology .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesRadiology .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesRadiology .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($radiology["total"], 0, ",", ".") . '</label>';
                    $yankesRadiology .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesRadiology .= '    </label>';
                    $yankesRadiology .= '</div>';

                    $radiologySubTotal += $radiology["total"];
                    $total += $radiology["total"];
                }
                $yankesRadiology .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesRadiology .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesRadiology .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesRadiology .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesRadiology .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($radiologySubTotal, 0, ",", ".") . '</label>';
                $yankesRadiology .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesRadiology .= '    </label>';
                $yankesRadiology .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_RADIOLOGY]", $yankesRadiology, $modal_detail);

            if (isset($detail["medic"]) && !is_null($detail["medic"]) && !empty($detail["medic"])) {
                $medicSubTotal = 0;
                $yankesMedic = "";
                foreach ($detail["medic"] as $medic) {
                    $yankesMedic .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesMedic .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $medic["value"] . '</label>';
                    $yankesMedic .= '    <label class="form-control col-sm-1 col-1">' . $medic["qty"] . '</label>';
                    $yankesMedic .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesMedic .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesMedic .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesMedic .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesMedic .= '    </label>';
                    $yankesMedic .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($medic["fare"], 0, ",", ".") . '</label>';
                    $yankesMedic .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesMedic .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesMedic .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($medic["total"], 0, ",", ".") . '</label>';
                    $yankesMedic .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesMedic .= '    </label>';
                    $yankesMedic .= '</div>';

                    $medicSubTotal += $medic["total"];
                    $total += $medic["total"];
                }
                $yankesMedic .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesMedic .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesMedic .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesMedic .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesMedic .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($medicSubTotal, 0, ",", ".") . '</label>';
                $yankesMedic .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesMedic .= '    </label>';
                $yankesMedic .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_MEDIC]", $yankesMedic, $modal_detail);

            if (isset($detail["rehab"]) && !is_null($detail["rehab"]) && !empty($detail["rehab"])) {
                $rehabSubTotal = 0;
                $yankesRehab = "";
                foreach ($detail["rehab"] as $rehab) {
                    $yankesRehab .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesRehab .= '    <label class="form-control col-sm-4 col-4 mr-2">' . $rehab["value"] . '</label>';
                    $yankesRehab .= '    <label class="form-control col-sm-1 col-1">' . $rehab["qty"] . '</label>';
                    $yankesRehab .= '    <label class="col-form-label col-sm-1 col-1 text-center">Hari</label>';
                    $yankesRehab .= '    <label class="row-flex col-form-label col-sm-1 col-1 text-right pl-0 pr-0">';
                    $yankesRehab .= '        <label class="col-sm-5 col-5 text-center no-padding">X</label>';
                    $yankesRehab .= '        <label class="col-sm-7 col-7 pl-0">IDR</label>';
                    $yankesRehab .= '    </label>';
                    $yankesRehab .= '    <label class="form-control col-sm-2 col-2 text-right">' . number_format($rehab["fare"], 0, ",", ".") . '</label>';
                    $yankesRehab .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesRehab .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesRehab .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($rehab["total"], 0, ",", ".") . '</label>';
                    $yankesRehab .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesRehab .= '    </label>';
                    $yankesRehab .= '</div>';

                    $rehabSubTotal += $rehab["total"];
                    $total += $rehab["total"];
                }
                $yankesRehab .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesRehab .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesRehab .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesRehab .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesRehab .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($rehabSubTotal, 0, ",", ".") . '</label>';
                $yankesRehab .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesRehab .= '    </label>';
                $yankesRehab .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_REHAB]", $yankesRehab, $modal_detail);
            
            if (isset($detail["ambulance"]) && !is_null($detail["ambulance"]) && !empty($detail["ambulance"])) {
                $ambulanceSubTotal = 0;
                $yankesAmbulance = "";
                foreach ($detail["ambulance"] as $ambulance) {
                    $yankesAmbulance .= '<div class="row-flex col-sm-12 col-12 pl-0">';
                    $yankesAmbulance .= '    <label class="form-control col-sm-9 col-9 mr-2">' . $ambulance["value"] . '</label>';
                    $yankesAmbulance .= '    <label class="col-form-label col-sm-1 col-1 text-right">= IDR</label>';
                    $yankesAmbulance .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                    $yankesAmbulance .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($ambulance["total"], 0, ",", ".") . '</label>';
                    $yankesAmbulance .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                    $yankesAmbulance .= '    </label>';
                    $yankesAmbulance .= '</div>';

                    $ambulanceSubTotal += $ambulance["total"];
                    $total += $ambulance["total"];
                }
                $yankesAmbulance .= '<div class="row-flex col-sm-12 col-12 pl-0 pr-0">';
                $yankesAmbulance .= '    <label class="col-form-label col-sm-9 col-9 pl-0">Sub Total</label>';
                $yankesAmbulance .= '    <label class="col-form-label col-sm-1 col-1 text-right">IDR</label>';
                $yankesAmbulance .= '    <label class="row-flex col-sm-2 col-2 no-padding">';
                $yankesAmbulance .= '        <label class="form-control col-sm-11 col-11 text-right">' . number_format($ambulanceSubTotal, 0, ",", ".") . '</label>';
                $yankesAmbulance .= '        <label class="col-sm-1 col-1">&nbsp;</label>';
                $yankesAmbulance .= '    </label>';
                $yankesAmbulance .= '</div>';
            }
            $modal_detail = str_replace("[INFO_YANKES_AMBULANCE]", $yankesAmbulance, $modal_detail);

            // $total = $total - $cob;
            $modal_detail = str_replace("[INFO_TOTAL_BAYAR]", number_format($bill["total_bayar"], 0, ",", "."), $modal_detail);
            $modal_detail = str_replace("[INFO_TOTAL]", number_format($total, 0, ",", "."), $modal_detail);
        }
        
        echo json_encode($modal_detail);
    }

}