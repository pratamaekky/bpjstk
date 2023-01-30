<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Hospital
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $params)
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_params = $params;
        $this->_command = $command;
    }

    private function _lists()
    {
        $responseProvince = $this->Masters->data("province");
        $responseProvince = json_decode($responseProvince);

        $responseHospitalType = $this->Masters->data("general", "hospital_type");
        $responseHospitalType = json_decode($responseHospitalType);

        $responseHospitalOwner = $this->Masters->data("general", "hospital_owner");
        $responseHospitalOwner = json_decode($responseHospitalOwner);

        $data["getProvince"] = ($responseProvince->result == 200) ? $responseProvince->data->item : $responseProvince->data;
        $data["getHospitalType"] = ($responseHospitalType->result == 200) ? $responseHospitalType->data->item : $responseHospitalType->data;
        $data["getHospitalOwner"] = ($responseHospitalOwner->result == 200) ? $responseHospitalOwner->data->item : $responseHospitalOwner->data;

        $this->CI->load->view("public/hospital.php", $data);
    }

    private function _save()
    {
        unset($this->_params["todo"]);
        unset($this->_params["btnTodo"]);
        $saveHospital = $this->Masters->save("hospital", $this->_params);

        echo $saveHospital;
    }

    private function _data()
    {
        // echo '<pre>';
        $items = [];
        $draw = 1;
        $totalRecods = 0;
        $totalDisplays = 0;
        $responseHospital = $this->Masters->data("hospital", null, $this->_params);
        $responseHospital = json_decode($responseHospital);

        if ($responseHospital->result == 200) {
            $resHospital = $responseHospital->data->item->aaData;

            if (!empty($resHospital)) {
                foreach ($resHospital as $key => $hospital) {
                    $row = [
                        "no" => ($key  + 1),
                        "name" => $hospital->name,
                        "address" => $hospital->address . ", " . $hospital->village . ", " . $hospital->district . ", " . $hospital->city . ", " . $hospital->province . " - " . $hospital->postalcode,
                        "telp" => $hospital->telp,
                        "type" => $hospital->hospital_type,
                        "class" => $hospital->class,
                        "owner" => $hospital->hospital_owner,
                        "action" => "<a class='nav-link' href='#' aria-expanded='true'><i class='far fa-edit'></i></a>"
                    ];

                    $items[] = $row;
                }

                $draw = $responseHospital->data->item->draw;
                $totalRecods = $responseHospital->data->item->iTotalRecords;
                $totalDisplays = $responseHospital->data->item->iTotalDisplayRecords;
            }
        }

        $result = [
            "draw" => $draw,
            "recordsTotal" => $totalRecods,
            "recordsFiltered" => $totalDisplays,
            "data" => $items
        ];
        // $result = ($responseHospital->result == 200) ? $responseHospital->data->item : $responseHospital->data;

        echo json_encode($result);
    }

    public function action()
    {
        switch ($this->_command) {
            case 'lists':
                $this->_lists();
                break;
            case 'save':
                $this->_save();
                break;
            case 'data':
                $this->_data();
                break;
            default:
                # code...
                break;
        }
    }
}