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
            "ranap_date_start" => date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[0])),
            "ranap_date_last" => date("Y-m-d", strtotime(explode(" - ", $this->_params["ranap_date"])[1])),
            "last_rajal" => $this->_params["last_rajal"],
            "diagnose" => $this->_params["diagnose"],
            "dx_sekunder" => $this->_params["dx_sekunder"],
            "stmb" => json_encode($this->_params["stmb"]),
            "action" => $this->_params["action"],
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
                            "value_id" => $ro[0],
                            "fare" => $ro[1],
                            "qty" => $room_days[$key],
                            "total" => $room_subtotal[$key]
                        ];

                        $bill_detail[] = $bill_room;
                        $this->CI->mbills->saveBillsDetail($bill_room);
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
                            "value_id" => explode("-", $admin)[0],
                            "fare" => explode("-", $admin)[1],
                            "qty" => 0,
                            "total" => explode("-", $admin)[1]
                        ];

                        $bill_detail[] = $bill_admin;
                        $this->CI->mbills->saveBillsDetail($bill_admin);
                    }
                }
            }

            if (isset($this->_params["medicine_value"]) && !empty($this->_params["medicine_value"]) && isset($this->_params["medicine_fare"]) && !empty($this->_params["medicine_fare"])) {
                foreach ($this->_params["medicine_value"] as $key => $medicine) {
                    if (!empty($medicine)) {
                        $bill_medicine = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "medicine",
                            "value" => $medicine,
                            "value_id" => 0,
                            "fare" => $this->_params["medicine_fare"][$key],
                            "qty" => 0,
                            "total" => $this->_params["medicine_fare"][$key]
                        ];

                        $bill_detail[] = $bill_medicine;
                        $this->CI->mbills->saveBillsDetail($bill_medicine);
                    }
                }
            }

            if (isset($this->_params["docter"]) && !empty($this->_params["docter"])) {
                foreach ($this->_params["docter"] as $key => $docter) {
                    if (!empty($docter)) {
                        $bill_docter = [
                            "id_bills" => $idBills,
                            "yankes" => $yankes,
                            "type" => "docter",
                            "value" => "",
                            "value_id" => explode("-", $docter)[0],
                            "fare" => explode("-", $docter)[1],
                            "qty" => 0,
                            "total" => explode("-", $docter)[1]
                        ];

                        $bill_detail[] = $bill_docter;
                        $this->CI->mbills->saveBillsDetail($bill_docter);
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
                            "value_id" => explode("-", $lab)[0],
                            "fare" => explode("-", $lab)[1],
                            "qty" => 0,
                            "total" => explode("-", $lab)[1]
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
                            "value_id" => explode("-", $radiology)[0],
                            "fare" => explode("-", $radiology)[1],
                            "qty" => 0,
                            "total" => explode("-", $radiology)[1]
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
                            "value_id" => explode("-", $medic)[0],
                            "fare" => explode("-", $medic)[1],
                            "qty" => 0,
                            "total" => explode("-", $medic)[1]
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
                            "value_id" => explode("-", $rehab)[0],
                            "fare" => explode("-", $rehab)[1],
                            "qty" => 0,
                            "total" => explode("-", $rehab)[1]
                        ];

                        $bill_detail[] = $bill_rehab;
                        $this->CI->mbills->saveBillsDetail($bill_rehab);
                    }
                }
            }
        }

        $totalBills = 0;
        if (!empty($bill_detail)) {
            foreach ($bill_detail as $detail) {
                $totalBills += intval($detail["total"]);
            }
        }

        if ($totalBills > 0)
            $this->CI->mbills->updateTotalBills(["id" => $idBills, "total" => $totalBills]);

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