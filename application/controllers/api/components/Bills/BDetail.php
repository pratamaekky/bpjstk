<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BDetail
{
    protected $CI;
    protected $appSrc;

    public function __construct($params)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model([
            'general',
            'mbills',
            'mhospital',
            'muser'
        ]);
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_params = $params;
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        if (!isset($this->_params["id"]) || $this->_params["id"] <= 0) throw new Exception("Data tidak lengkap!", 201);

        $id = $this->_params["id"];
        $bill = $this->CI->mbills->getRowById($id);

        if (is_null($bill)) throw new Exception("Data tidak ditemukan!", 201);

        $dataDetail = [];
        $patient = null;
        $hospital = null;
        $yankes = "";
        $details = $this->CI->mbills->detail($id);
        if (!is_null($details)) {
            $patient = $this->CI->muser->getPatientById($bill["id_patient"]);
            $hospital = $this->CI->mhospital->detail($bill["rs_id"]);

            foreach ($details as $detail) {
                $yankes = ($detail["yankes"] == "ranap") ? "Rawat Inap" : "Rawat Jalan";
                if (intval($detail["value_id"]) != 0) {
                    switch ($detail["type"]) {
                        case 'room':
                            $detail["value"] = $this->CI->general->getRoomNameById($detail["value_id"]);
                            break;
                        case 'room_nurse':
                            $detail["value"] = $this->CI->general->getDoctorNameById($detail["value_id"]);
                            break;
                        case 'admin':
                            $detail["value"] = $this->CI->general->getFeeNameById($detail["value_id"]);
                            break;
                        case 'docter':
                            $detail["value"] = $this->CI->general->getDoctorNameById($detail["value_id"]);
                            break;
                        case 'surgery':
                            $detail["value"] = $this->CI->general->getSurgeryNameById($detail["value_id"]);
                            break;
                        case 'lab':
                            $detail["value"] = $this->CI->general->getLaboratoryNameById($detail["value_id"]);
                            break;
                        case 'radiology':
                            $detail["value"] = $this->CI->general->getRadiologyNameById($detail["value_id"]);
                            break;
                        case 'medic':
                            $detail["value"] = $this->CI->general->getMedicNameById($detail["value_id"]);
                            break;
                        case 'rehab':
                            $detail["value"] = $this->CI->general->getRehabilitationNameById($detail["value_id"]);
                            break;
                    }
                }

                if ($detail["type"] == "docter")
                    $detail["children"] = $this->CI->mbills->detailDocter($id, $detail["id"]);

                $detail["qty"] = intval($detail["qty"]);

                if ($detail["type"] != 'docter_do') 
                    $dataDetail[] = $detail;
            }

            $detailGroup = array_reduce($dataDetail, function ($result, $item) {
                $result[$item['type']][] = $item;
                return $result;
            }, array());

            $responsecode = 200;
        }

        $bill["yankes"] = $yankes;
        $bill["hospital"] = $hospital;
        $bill["patient"] = $patient;
        $bill["detail"] = $detailGroup;

        $responseObj = [
            "name" => "Bills detail",
            "item" => $bill
        ];
    }
}