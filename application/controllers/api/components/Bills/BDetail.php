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
            'form_validation',
            'myutils'
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
        $details = $this->CI->myutils->group_by('yankes', $details);

        if (!is_null($details)) {
            $patient = $this->CI->muser->getPatientById($bill["id_patient"]);
            $hospital = $this->CI->mhospital->detail($bill["rs_id"]);

            foreach ($details as $yankes => $yankesData) {
                $yankesData = $this->CI->myutils->group_by('type', $yankesData);
                $dataByType = [];

                foreach ($yankesData as $type => $data) {
                    switch ($type) {
                        case "docter":
                        case "surgery":
                        case "anestesi":
                            if (isset($yankesData[$type . "_do"])) {
                                $typeDo = $this->CI->myutils->group_by('value_id', $yankesData[$type . "_do"]);
                                foreach ($data as $key => $da) {
                                    if (isset($typeDo[$da["id"]]))
                                        $data[$key]["do"] = $typeDo[$da["id"]];
                                }
                            }
                            break;
                    }

                    foreach ($data as $key => $da) {
                        switch ($type) {
                            case 'room':
                                $data[$key]["value"] = $this->CI->general->getRoomNameById($data[$key]["value_id"]);
                                break;
                            case 'admin':
                                $data[$key]["value"] = $this->CI->general->getFeeNameById($data[$key]["value_id"]);
                                break;
                            case 'docter':
                                $data[$key]["value"] = $this->CI->general->getDoctorNameById($data[$key]["value_id"]);
                                break;
                            case 'surgery':
                                $data[$key]["value"] = $this->CI->general->getSurgeryNameById($data[$key]["value_id"]);
                                break;
                            case 'anestesi':
                                $data[$key]["value"] = $this->CI->general->getAnestesiNameById($data[$key]["value_id"]);
                                break;
                            case 'laboratory':
                                $data[$key]["value"] = $this->CI->general->getLaboratoryNameById($data[$key]["value_id"]);
                                break;
                            case 'radiology':
                                $data[$key]["value"] = $this->CI->general->getRadiologyNameById($data[$key]["value_id"]);
                                break;
                            case 'medic':
                                $data[$key]["value"] = $this->CI->general->getMedicNameById($data[$key]["value_id"]);
                                break;
                            case 'rehab':
                                $data[$key]["value"] = $this->CI->general->getRehabilitationNameById($data[$key]["value_id"]);
                                break;
                            case 'ambulance':
                                $data[$key]["value"] = $this->CI->general->getAmbulanceNameById($data[$key]["value_id"]);
                                break;
                        }
                    }
                    if ($type != "docter_do" && $type != "surgery_do" && $type != "anestesi_do")
                        $dataByType[$type] = $data;
                }

                $detailGroup[$yankes] = $dataByType;
            }

            $responsecode = 200;
        }

        $bill["hospital"] = $hospital;
        $bill["patient"] = $patient;
        $bill["detail"] = $detailGroup;

        $responseObj = [
            "name" => "Bills detail",
            "item" => $bill
        ];
    }
}