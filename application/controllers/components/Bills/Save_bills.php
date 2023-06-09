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

        $dataBills = [
            "rs_id" => $this->_params["rs_id"],
            "id_patient" => $idPatient,
            "jkk_date" => date("Y-m-d H:i:00", strtotime($this->_params["jkk_date"])),
            "treatment_date" => date("Y-m-d", strtotime($this->_params["treatment_date"])),
            "last_condition" => $this->_params["last_condition"],
            "ranap_date_start" => !empty($this->_params["ranap_date"]) ? date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[0])) : "",
            "ranap_date_last" => !empty($this->_params["ranap_date"]) ? date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[1])) : "",
            "last_rajal" => $this->_params["last_rajal"],
            "diagnose" => $this->_params["diagnose"],
            "dx_sekunder" => $this->_params["dx_sekunder"],
            "action" => $this->_params["action"],
            "verification" => $this->_params["verification"],
            "cob" => $this->_params["cob_subtotal"][0],
            "stmb" => json_encode($this->_params["stmb"]),
            "total" => 0
        ];

        $idBills = $this->CI->mbills->save($dataBills);
        $bill_detail = [];

        if ($idBills > 0) {
            $yankes = $this->_params["yankes"];
            if (isset($this->_params["room"]) && !empty($this->_params["room"]) && isset($this->_params["room_days"]) && !empty($this->_params["room_days"]) && isset($this->_params["room_rate"]) && !empty($this->_params["room_rate"]) && isset($this->_params["room_subtotal"]) && !empty($this->_params["room_subtotal"])) {
                foreach ($this->_params["room"] as $key => $room) {
                    if (!empty($room)) {
                        $ro = explode("-", $room);
                        $room_days = $this->_params["room_days"];
                        $room_subtotal = $this->_params["room_subtotal"];

                        $bill_room = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "room",
                            "value" => "",
                            "value_id" => intval($ro[0]),
                            "fare" => intval($ro[1]),
                            "qty" => intval($room_days[$key]),
                            "total" => intval($room_subtotal[$key])
                        ];

                        $bill_detail[] = $bill_room;
                        $this->CI->mbills->saveBillsDetail($bill_room);
                    }
                }
            }

            if (isset($this->_params["room_nurse"]) && !empty($this->_params["room_nurse"]) && isset($this->_params["room_nurse_subtotal"]) && !empty($this->_params["room_nurse_subtotal"])) {
                foreach ($this->_params["room_nurse"] as $key => $roomNurse) {
                    if (!empty($roomNurse)) {
                        $roomNurse_subtotal = $this->_params["room_nurse_subtotal"];

                        $bill_room_nurse = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "room_nurse",
                            "value" => $roomNurse,
                            "value_id" => 0,
                            "fare" => intval($roomNurse_subtotal[$key]),
                            "qty" => 1,
                            "total" => intval($roomNurse_subtotal[$key])
                        ];

                        $bill_detail[] = $bill_room_nurse;
                        $this->CI->mbills->saveBillsDetail($bill_room_nurse);
                    }
                }
            }

            if (isset($this->_params["admin"]) && !empty($this->_params["admin"])) {
                foreach ($this->_params["admin"] as $key => $admin) {
                    if (!empty($admin)) {
                        $bill_admin = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "admin",
                            "value" => "",
                            "value_id" => intval(explode("-", $admin)[0]),
                            "fare" => intval(explode("-", $admin)[1]),
                            "qty" => 1,
                            "total" => intval(explode("-", $admin)[1])
                        ];

                        $bill_detail[] = $bill_admin;
                        $this->CI->mbills->saveBillsDetail($bill_admin);
                    }
                }
            }

            if (isset($this->_params["medicine_value"]) && !empty($this->_params["medicine_value"]) && isset($this->_params["medicine_subtotal"]) && !empty($this->_params["medicine_subtotal"])) {
                foreach ($this->_params["medicine_value"] as $key => $medicine) {
                    if (!empty($medicine)) {
                        $bill_medicine = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "medicine",
                            "value" => $medicine,
                            "value_id" => 0,
                            "fare" => intval($this->_params["medicine_subtotal"][$key]),
                            "qty" => 1,
                            "total" => intval($this->_params["medicine_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_medicine;
                        $this->CI->mbills->saveBillsDetail($bill_medicine);
                    }
                }
            }

            if (isset($this->_params["docter"]) && !empty($this->_params["docter"])) {
                foreach ($this->_params["docter"] as $key => $docter) {
                    if (!empty($docter)) {
                        $docter_qty = $this->_params["docter_qty"];

                        $bill_docter = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "docter",
                            "value" => "",
                            "value_id" => intval(explode("-", $docter)[0]),
                            "fare" => intval(explode("-", $docter)[1]),
                            "qty" => intval($docter_qty[$key]),
                            "total" => intval($this->_params["docter_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_docter;
                        $idBillsDocter = $this->CI->mbills->saveBillsDetail($bill_docter);

                        $xDo = 0;
                        if ($idBillsDocter > 0) {
                            if (isset($this->_params["docter_do_value"]) && !empty($this->_params["docter_do_value"]) && isset($this->_params["docter_do_subtotal"]) && !empty($this->_params["docter_do_subtotal"])) {
                                $arrDocterDoValue = array_values($this->_params["docter_do_value"]);
                                $arrDocterDoST = array_values($this->_params["docter_do_subtotal"]);
                                foreach ($arrDocterDoValue[$key] as $keyDocterDo => $docterDo) {
                                    $bill_docter_do = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankes,
                                        "type" => "docter_do",
                                        "value" => $docterDo,
                                        "value_id" => intval($idBillsDocter),
                                        "fare" => intval($arrDocterDoST[$key][$keyDocterDo]),
                                        "qty" => 1,
                                        "total" => intval($arrDocterDoST[$key][$keyDocterDo])
                                    ];

                                    $bill_detail[] = $bill_docter_do;
                                    $this->CI->mbills->saveBillsDetail($bill_docter_do);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($this->_params["surgery"]) && !empty($this->_params["surgery"])) {
                foreach ($this->_params["surgery"] as $key => $surgery) {
                    if (!empty($surgery)) {
                        $bill_surgery = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "surgery",
                            "value" => "",
                            "value_id" => intval(explode("-", $surgery)[0]),
                            "fare" => intval(explode("-", $surgery)[1]),
                            "qty" => 0,
                            "total" => intval(explode("-", $surgery)[1])
                        ];

                        $bill_detail[] = $bill_surgery;
                        $idBillsSurgery = $this->CI->mbills->saveBillsDetail($bill_surgery);

                        $xDo = 0;
                        if ($idBillsSurgery > 0) {
                            if (isset($this->_params["surgery_do_value"]) && !empty($this->_params["surgery_do_value"]) && isset($this->_params["surgery_do_subtotal"]) && !empty($this->_params["surgery_do_subtotal"])) {
                                $arrSurgeryDoValue = array_values($this->_params["surgery_do_value"]);
                                $arrSurgeryDoST = array_values($this->_params["surgery_do_subtotal"]);
                                foreach ($arrSurgeryDoValue[$key] as $keySurgeryDo => $surgeryDo) {
                                    $bill_surgery_do = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankes,
                                        "type" => "surgery_do",
                                        "value" => $surgeryDo,
                                        "value_id" => intval($idBillsSurgery),
                                        "fare" => intval($arrSurgeryDoST[$key][$keySurgeryDo]),
                                        "qty" => 1,
                                        "total" => intval($arrSurgeryDoST[$key][$keySurgeryDo])
                                    ];

                                    $bill_detail[] = $bill_surgery_do;
                                    $this->CI->mbills->saveBillsDetail($bill_surgery_do);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($this->_params["surgery_nurse"]) && !empty($this->_params["surgery_nurse"]) && isset($this->_params["surgery_nurse_subtotal"]) && !empty($this->_params["surgery_nurse_subtotal"])) {
                foreach ($this->_params["surgery_nurse"] as $key => $surgery_nurse) {
                    if (!empty($surgery_nurse)) {
                        $bill_surgery_nurse = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "surgery_nurse",
                            "value" => $surgery_nurse,
                            "value_id" => 0,
                            "fare" => intval($this->_params["surgery_nurse_subtotal"][$key]),
                            "qty" => 1,
                            "total" => intval($this->_params["surgery_nurse_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_surgery_nurse;
                        $this->CI->mbills->saveBillsDetail($bill_surgery_nurse);
                    }
                }
            }

            if (isset($this->_params["anestesi"]) && !empty($this->_params["anestesi"])) {
                foreach ($this->_params["anestesi"] as $key => $anestesi) {
                    if (!empty($anestesi)) {
                        $bill_anestesi = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "anestesi",
                            "value" => "",
                            "value_id" => intval(explode("-", $anestesi)[0]),
                            "fare" => intval(explode("-", $anestesi)[1]),
                            "qty" => 0,
                            "total" => intval($this->_params["anestesi_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_anestesi;
                        $idBillsAnestesi = $this->CI->mbills->saveBillsDetail($bill_anestesi);

                        $xDo = 0;
                        if ($idBillsAnestesi > 0) {
                            if (isset($this->_params["anestesi_do_value"]) && !empty($this->_params["anestesi_do_value"]) && isset($this->_params["anestesi_do_subtotal"]) && !empty($this->_params["anestesi_do_subtotal"])) {
                                $arrAnestesiDoValue = array_values($this->_params["anestesi_do_value"]);
                                $arrAnestesiDoST = array_values($this->_params["anestesi_do_subtotal"]);
                                foreach ($arrAnestesiDoValue[$key] as $keyAnestesiDo => $anestesiDo) {
                                    $bill_anestesi_do = [
                                        "id_bills" => $idBills,
                                        "yankes" => $yankes,
                                        "type" => "anestesi_do",
                                        "value" => $anestesiDo,
                                        "value_id" => intval($idBillsAnestesi),
                                        "fare" => intval($arrAnestesiDoST[$key][$keyAnestesiDo]),
                                        "qty" => 1,
                                        "total" => intval($arrAnestesiDoST[$key][$keyAnestesiDo])
                                    ];

                                    $bill_detail[] = $bill_anestesi_do;
                                    $this->CI->mbills->saveBillsDetail($bill_anestesi_do);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($this->_params["lab"]) && !empty($this->_params["lab"])) {
                foreach ($this->_params["lab"] as $key => $lab) {
                    if (!empty($lab)) {
                        $bill_lab = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "lab",
                            "value" => "",
                            "value_id" => intval(explode("-", $lab)[0]),
                            "fare" => intval(explode("-", $lab)[1]),
                            "qty" => intval($this->_params["lab_qty"][$key]),
                            "total" => intval($this->_params["lab_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_lab;
                        $this->CI->mbills->saveBillsDetail($bill_lab);
                    }
                }
            }

            if (isset($this->_params["radiology"]) && !empty($this->_params["radiology"])) {
                foreach ($this->_params["radiology"] as $key => $radiology) {
                    if (!empty($radiology)) {
                        $bill_radiology = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "radiology",
                            "value" => "",
                            "value_id" => intval(explode("-", $radiology)[0]),
                            "fare" => intval(explode("-", $radiology)[1]),
                            "qty" => intval($this->_params["radiology_qty"][$key]),
                            "total" => intval($this->_params["radiology_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_radiology;
                        $this->CI->mbills->saveBillsDetail($bill_radiology);
                    }
                }
            }

            if (isset($this->_params["medic"]) && !empty($this->_params["medic"])) {
                foreach ($this->_params["medic"] as $key => $medic) {
                    if (!empty($medic)) {
                        $bill_medic = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "medic",
                            "value" => "",
                            "value_id" => intval(explode("-", $medic)[0]),
                            "fare" => intval(explode("-", $medic)[1]),
                            "qty" => intval($this->_params["medic_qty"][$key]),
                            "total" => intval($this->_params["medic_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_medic;
                        $this->CI->mbills->saveBillsDetail($bill_medic);
                    }
                }
            }

            if (isset($this->_params["rehab"]) && !empty($this->_params["rehab"])) {
                foreach ($this->_params["rehab"] as $key => $rehab) {
                    if (!empty($rehab)) {
                        $bill_rehab = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "rehab",
                            "value" => "",
                            "value_id" => intval(explode("-", $rehab)[0]),
                            "fare" => intval(explode("-", $rehab)[1]),
                            "qty" => intval($this->_params["rehab_qty"][$key]),
                            "total" => intval($this->_params["rehab_subtotal"][$key])
                        ];

                        $bill_detail[] = $bill_rehab;
                        $this->CI->mbills->saveBillsDetail($bill_rehab);
                    }
                }
            }

            if (isset($this->_params["ambulance"]) && !empty($this->_params["ambulance"])) {
                foreach ($this->_params["ambulance"] as $key => $ambulance) {
                    if (!empty($ambulance)) {
                        $bill_ambulance = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "ambulance",
                            "value" => "",
                            "value_id" => intval(explode("-", $ambulance)[0]),
                            "fare" => intval(explode("-", $ambulance)[1]),
                            "qty" => 1,
                            "total" => intval(explode("-", $ambulance)[1])
                        ];

                        $bill_detail[] = $bill_ambulance;
                        $this->CI->mbills->saveBillsDetail($bill_ambulance);
                    }
                }
            }

        }

        $subTotalBills = 0;
        if (!empty($bill_detail)) {
            foreach ($bill_detail as $detail) {
                $subTotalBills += intval($detail["total"]);
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