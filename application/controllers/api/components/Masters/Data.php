<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $flag, $params)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array(
            'general',
            'mhospital'
        ));
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_command = $command;
        $this->_flag = $flag;
        $this->_params = $params;
    }

    private function _data_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "name";
        if (!is_null($column)) {
            switch ($column) {
                case 1:
                    $sortColumn = "name";
                    break;
                case 4:
                    $sortColumn = "hospital_type";
                    break;
                case 5:
                    $sortColumn = "class";
                    break;
                case 6:
                    $sortColumn = "hospital_owner";
                    break;
                default:
                    $sortColumn = "id";
                    break;
            }
        }

        $totalHospital = $this->CI->mhospital->totalData();

        if ($totalHospital > 0) {
            $result = $this->CI->mhospital->getData($query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Hospital",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalHospital),
                "aaData" => $result
            ]
        ];
    }

    private function _detail_hospital(&$responseObj, &$responsecode, &$responseMessage)
    {
        if (!isset($this->_params["rsId"]) && $this->_params["rsId"] <= 0) throw new Exception("Data tidak lengkap!", 201);

        $hospital = $this->CI->mhospital->detail($this->_params["rsId"]);
        
        if (is_null($hospital)) throw new Exception("Data hospital tidak ditemukan!", 201);
        $responsecode = 200;
        $responseObj  = [
            "name"  => "Detail Hospital",
            "item"  => $hospital
        ];
    }

    private function _data_province(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $getProvince = $this->CI->general->getProvince();

        if (!is_null($getProvince)) {
            $responsecode = 200;
            $result = $getProvince;
        }

        $responseObj  = [
            "name"  => "Data Province",
            "item"  => $result
        ];
    }

    private function _data_city(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idProvince = isset($this->_params["idProvince"]) ? $this->_params["idProvince"] : 0;
        $getCity = $this->CI->general->getCity($idProvince);

        if (!is_null($getCity)) {
            $responsecode = 200;
            $result = $getCity;
        }

        $responseObj  = [
            "name"  => "Data City",
            "item"  => $result
        ];
    }

    private function _data_district(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idCity = isset($this->_params["idCity"]) ? $this->_params["idCity"] : 0;
        $getDistrict = $this->CI->general->getDistrict($idCity);

        if (!is_null($getDistrict)) {
            $responsecode = 200;
            $result = $getDistrict;
        }

        $responseObj  = [
            "name"  => "Data District",
            "item"  => $result
        ];
    }

    private function _data_postalcode(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = null;
        $idProvince = isset($this->_params["idProvince"]) ? $this->_params["idProvince"] : 0;
        $idCity = isset($this->_params["idCity"]) ? $this->_params["idCity"] : 0;
        $idDistrict = isset($this->_params["idDistrict"]) ? $this->_params["idDistrict"] : 0;
        $getPostalcode = $this->CI->general->getPostalCode($idProvince, $idCity, $idDistrict);

        if (!is_null($getPostalcode)) {
            $responsecode = 200;
            $result = $getPostalcode;
        }

        $responseObj  = [
            "name"  => "Data Postal Code",
            "item"  => $result
        ];
    }


    private function _data_general(&$responseObj, &$responsecode, &$responseMessage)
    {
        $generalField = [
            "hospital_type",
            "hospital_owner",
            "ot_category",
            "ot_specialist",
            "doctor_specialist",
            "lab_category",
            "other_fee"
        ];
        if (is_null($this->_flag)) throw new Exception("Flag Tidak Lengkap!", 201);
        if (!in_array($this->_flag, $generalField)) throw new Exception("Flag tidak tersedia!", 201);
        
        $general = $this->CI->general->getGeneral($this->_flag);
        if (is_null($general)) throw new Exception("Data tidak ada!", 201);

        $responsecode = 200;
        $responseObj = [
            "name" => "Data General " . ucwords(str_replace("_", " ", $this->_flag)),
            "item" => $general
        ];
    }

    private function _data_generals(&$responseObj, &$responsecode, &$responseMessage)
    {
        $generalField = [
            "hospital_type",
            "hospital_owner",
            "ot_category",
            "ot_specialist",
            "doctor_specialist",
            "lab_category",
            "other_fee"
        ];
        if (is_null($this->_flag)) throw new Exception("Flag Tidak Lengkap!", 201);
        if (!in_array($this->_flag, $generalField)) throw new Exception("Flag tidak tersedia!", 201);
        
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";
        $totalGeneral = $this->CI->general->totalGeneral($this->_flag);

        if ($totalGeneral > 0) {
            $result = $this->CI->general->getGenerals($this->_flag, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data General " . ucwords(str_replace("_", " ", $this->_flag)),
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalGeneral),
                "aaData" => $result
            ]
        ];
    }

    private function _data_room(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";
        if (!is_null($column)) {
            switch ($column) {
                case 1:
                    $sortColumn = "name";
                    break;
                case 4:
                    $sortColumn = "hospital_type";
                    break;
                case 5:
                    $sortColumn = "class";
                    break;
                case 6:
                    $sortColumn = "hospital_owner";
                    break;
                default:
                    $sortColumn = "id";
                    break;
            }
        }

        $totalRoom = $this->CI->general->totalRoom();

        if ($totalRoom > 0) {
            $result = $this->CI->general->getRoom($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Room",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalRoom),
                "aaData" => $result
            ]
        ];
    }

    private function _data_radiology(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";

        $totalRadiology = $this->CI->general->totalRadiology();

        if ($totalRadiology > 0) {
            $result = $this->CI->general->getRadiology($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Radiology",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalRadiology),
                "aaData" => $result
            ]
        ];
    }

    private function _data_rehabilitation(&$responseObj, &$responsecode, &$responseMessage)
    {
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";

        $totalRehabilitation = $this->CI->general->totalRehabilitation();

        if ($totalRehabilitation > 0) {
            $result = $this->CI->general->getRehabilitation($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Rehabilitation",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalRehabilitation),
                "aaData" => $result
            ]
        ];
    }

    private function _data_medic(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";

        $totalMedic = $this->CI->general->totalMedic();

        if ($totalMedic > 0) {
            $result = $this->CI->general->getMedic($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Medic",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalMedic),
                "aaData" => $result
            ]
        ];
    }

    private function _data_doctor(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";
        if (!is_null($column)) {
            switch ($column) {
                case 1:
                    $sortColumn = "name";
                    break;
                case 4:
                    $sortColumn = "hospital_type";
                    break;
                case 5:
                    $sortColumn = "class";
                    break;
                case 6:
                    $sortColumn = "hospital_owner";
                    break;
                default:
                    $sortColumn = "id";
                    break;
            }
        }

        $totalDoctor = $this->CI->general->totalDoctor();

        if ($totalDoctor > 0) {
            $result = $this->CI->general->getDoctor($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Doctor",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalDoctor),
                "aaData" => $result
            ]
        ];
    }

    private function _data_laboratory(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";
        if (!is_null($column)) {
            switch ($column) {
                case 1:
                    $sortColumn = "name";
                    break;
                case 4:
                    $sortColumn = "hospital_type";
                    break;
                case 5:
                    $sortColumn = "class";
                    break;
                case 6:
                    $sortColumn = "hospital_owner";
                    break;
                default:
                    $sortColumn = "id";
                    break;
            }
        }

        $totalLaboratory = $this->CI->general->totalLaboratory();

        if ($totalLaboratory > 0) {
            $result = $this->CI->general->getLaboratory($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Laboratory",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalLaboratory),
                "aaData" => $result
            ]
        ];
    }

    private function _data_fee(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";
        if (!is_null($column)) {
            switch ($column) {
                case 1:
                    $sortColumn = "name";
                    break;
                case 4:
                    $sortColumn = "hospital_type";
                    break;
                case 5:
                    $sortColumn = "class";
                    break;
                case 6:
                    $sortColumn = "hospital_owner";
                    break;
                default:
                    $sortColumn = "id";
                    break;
            }
        }

        $totalFee = $this->CI->general->totalFee();

        if ($totalFee > 0) {
            $result = $this->CI->general->getFee($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Fee",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalFee),
                "aaData" => $result
            ]
        ];
    }

    private function _data_users(&$responseObj, &$responsecode, &$responseMessage)
    {
        $totalPage = 1;
        $result = [];
        $idRs = isset($this->_params["rsid"]) ? $this->_params["rsid"] : 0;
        $draw = isset($this->_params["draw"]) ? intval($this->_params["draw"]) : 1;
        $start = isset($this->_params["start"]) ? intval($this->_params["start"]) : 0;
        $limit = isset($this->_params["length"]) ? intval($this->_params["length"]) : 10;
        $query = (isset($this->_params["search"]["value"]) && !empty($this->_params["search"]["value"])) ? $this->_params["search"]["value"] : null;
        $column = isset($this->_params["order"][0]["column"]) ? $this->_params["order"][0]["column"] : null;
        $order = isset($this->_params["order"][0]["dir"]) ? $this->_params["order"][0]["dir"] : "asc";
        $sortColumn = "id";

        $totalUsers = $this->CI->muser->totalUserByRsId($idRs);

        if ($totalUsers > 0) {
            $result = $this->CI->muser->getUserByRsId($idRs, $query, $start, $limit, $sortColumn, $order);
            $responsecode = 200;
        }

        $responseObj = [
            "name" => "Data Fee",
            "item" => [
                "draw" => $draw,
                "iTotalRecords" => intval($limit),
                "iTotalDisplayRecords" => intval($totalUsers),
                "aaData" => $result
            ]
        ];
    }

    public function action(&$responseObj, &$responsecode, &$responseMessage)
    {
        switch ($this->_command) {
            case "hospital":
                if ($this->_flag == "detail")
                    $this->_detail_hospital($responseObj, $responsecode, $responseMessage);
                else
                    $this->_data_hospital($responseObj, $responsecode, $responseMessage);
                break;
            case "province":
                $this->_data_province($responseObj, $responsecode, $responseMessage);
                break;
            case "city":
                $this->_data_city($responseObj, $responsecode, $responseMessage);
                break;
            case "district":
                $this->_data_district($responseObj, $responsecode, $responseMessage);
                break;
            case "postalcode":
                $this->_data_postalcode($responseObj, $responsecode, $responseMessage);
                break;
            case "general":
                $this->_data_general($responseObj, $responsecode, $responseMessage);
                break;
            case "generals":
                $this->_data_generals($responseObj, $responsecode, $responseMessage);
                break;
            case "room":
                $this->_data_room($responseObj, $responsecode, $responseMessage);
                break;
            case "radiology":
                $this->_data_radiology($responseObj, $responsecode, $responseMessage);
                break;
            case "rehabilitation":
                $this->_data_rehabilitation($responseObj, $responsecode, $responseMessage);
                break;
            case "medic":
                $this->_data_medic($responseObj, $responsecode, $responseMessage);
                break;
            case "doctor":
                $this->_data_doctor($responseObj, $responsecode, $responseMessage);
                break;
            case "laboratory":
                $this->_data_laboratory($responseObj, $responsecode, $responseMessage);
                break;
            case "fee":
                $this->_data_fee($responseObj, $responsecode, $responseMessage);
                break;
            case "users":
                $this->_data_users($responseObj, $responsecode, $responseMessage);
                break;
        }
    }
}