<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Service extends web_base
{
    protected $CI;
    protected $appSrc;

    public function __construct($command, $flag, $params)
    {
        $this->Masters = new Masters();
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $session_userdata = $this->CI->session->userdata("plkk.pm");
        $this->plkk_session = $session_userdata;

        $this->rsId = intval($this->CI->uri->segment(5));
        $this->_command = $command;
        $this->_flag = $flag;
        $this->_params = $params;
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

        $this->CI->load->view("public/service/lists.php", $data);
    }

    private function _data()
    {
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
                        "room" => "<a class='btn btn-sm btn-primary' href='" . base_url("master/service/room/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-bed mr-2 ml-2'></i></a>",
                        "radiology" => "<a class='btn btn-sm btn-secondary' href='" . base_url("master/service/radiology/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-radiation-alt mr-2 ml-2'></i></a>",
                        "medic" => "<a class='btn btn-sm btn-danger' href='" . base_url("master/service/medic/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-notes-medical mr-2 ml-2'></i></a>",
                        "laboratory" => "<a class='btn btn-sm btn-info' href='" . base_url("master/service/laboratory/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-vials mr-2 ml-2'></i></a>",
                        "doctor" => "<a class='btn btn-sm btn-success' href='" . base_url("master/service/doctor/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-user-md mr-2 ml-2'></i></a>",
                        "surgery" => "<a class='btn btn-sm btn-success' href='" . base_url("master/service/surgery/lists/$hospital->id") . "' aria-expanded='true' style='background-color: #451e9b;'><i class='fas fa-stethoscope mr-2 ml-2'></i></a>",
                        "rehabilitation" => "<a class='btn btn-sm btn-success' href='" . base_url("master/service/rehabilitation/lists/$hospital->id") . "' aria-expanded='true' style='background-color: #a52a2a;'><i class='fas fa-hand-holding-medical mr-2 ml-2'></i></a>",
                        "fee" => "<a class='btn btn-sm btn-warning' href='" . base_url("master/service/fee/lists/$hospital->id") . "' aria-expanded='true'><i class='fas fa-file-invoice-dollar mr-2 ml-2'></i></a>",
                        "users" => "<a class='btn btn-sm btn-success' href='" . base_url("master/service/users/lists/$hospital->id") . "' aria-expanded='true' style='background-color: #6610f2;'><i class='fas fa-user-shield mr-2 ml-2'></i></a>"
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

        echo json_encode($result);
    }

    private function _room()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/room.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseRoom = $this->Masters->data("room", null, $this->_params);
            $responseRoom = json_decode($responseRoom);

            if ($responseRoom->result == 200) {
                $resRoom = $responseRoom->data->item->aaData;

                if (!empty($resRoom)) {
                    foreach ($resRoom as $key => $room) {
                        $row = [
                            "no" => ($key  + 1),
                            "value" => $room->value,
                            "fare" => "Rp " . number_format($room->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseRoom->data->item->draw;
                    $totalRecods = $responseRoom->data->item->iTotalRecords;
                    $totalDisplays = $responseRoom->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveHospital = $this->Masters->save("room", $this->_params);

            echo $saveHospital;
        }
    }

    private function _radiology()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/radiology.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseRoom = $this->Masters->data("radiology", null, $this->_params);
            $responseRoom = json_decode($responseRoom);

            if ($responseRoom->result == 200) {
                $resRoom = $responseRoom->data->item->aaData;

                if (!empty($resRoom)) {
                    foreach ($resRoom as $key => $room) {
                        $row = [
                            "no" => ($key  + 1),
                            "value" => $room->value,
                            "fare" => "Rp " . number_format($room->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseRoom->data->item->draw;
                    $totalRecods = $responseRoom->data->item->iTotalRecords;
                    $totalDisplays = $responseRoom->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveHospital = $this->Masters->save("radiology", $this->_params);

            echo $saveHospital;
        }
    }

    private function _rehabilitation()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/rehabilitation.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseRehabilitation = $this->Masters->data("rehabilitation", null, $this->_params);
            $responseRehabilitation = json_decode($responseRehabilitation);

            if ($responseRehabilitation->result == 200) {
                $resRehabilitation = $responseRehabilitation->data->item->aaData;

                if (!empty($resRehabilitation)) {
                    foreach ($resRehabilitation as $key => $rehab) {
                        $row = [
                            "no" => ($key  + 1),
                            "value" => $rehab->value,
                            "fare" => "Rp " . number_format($rehab->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseRehabilitation->data->item->draw;
                    $totalRecods = $responseRehabilitation->data->item->iTotalRecords;
                    $totalDisplays = $responseRehabilitation->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveHospital = $this->Masters->save("rehabilitation", $this->_params);

            echo $saveHospital;
        }
    }

    private function _medic()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/medic.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseMedic = $this->Masters->data("medic", null, $this->_params);
            $responseMedic = json_decode($responseMedic);

            if ($responseMedic->result == 200) {
                $resMedic = $responseMedic->data->item->aaData;

                if (!empty($resMedic)) {
                    foreach ($resMedic as $key => $medic) {
                        $row = [
                            "no" => ($key  + 1),
                            "value" => $medic->value,
                            "fare" => "Rp " . number_format($medic->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseMedic->data->item->draw;
                    $totalRecods = $responseMedic->data->item->iTotalRecords;
                    $totalDisplays = $responseMedic->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveHospital = $this->Masters->save("medic", $this->_params);

            echo $saveHospital;
        }
    }

    private function _doctor()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);

                $responseDoctorSpecialist = $this->Masters->data("general", "doctor_specialist");
                $responseDoctorSpecialist = json_decode($responseDoctorSpecialist);

                $data["doctorSpecialist"] = ($responseDoctorSpecialist->result == 200) ? $responseDoctorSpecialist->data->item : $responseDoctorSpecialist->data;
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/doctor.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseDoctor = $this->Masters->data("doctor", null, $this->_params);
            $responseDoctor = json_decode($responseDoctor);

            if ($responseDoctor->result == 200) {
                $resDoctor = $responseDoctor->data->item->aaData;

                if (!empty($resDoctor)) {
                    foreach ($resDoctor as $key => $doctor) {
                        $row = [
                            "no" => ($key  + 1),
                            "name" => $doctor->name,
                            "doctor_specialist" => $doctor->doctor_specialist,
                            "fare" => "Rp " . number_format($doctor->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseDoctor->data->item->draw;
                    $totalRecods = $responseDoctor->data->item->iTotalRecords;
                    $totalDisplays = $responseDoctor->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveDoctor = $this->Masters->save("doctor", $this->_params);

            echo $saveDoctor;
        }
    }

    private function _surgery()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);

                $responseSurgery = $this->Masters->data("general", "ot_category");
                $responseSurgery = json_decode($responseSurgery);

                $data["surgery"] = ($responseSurgery->result == 200) ? $responseSurgery->data->item : $responseSurgery->data;
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/surgery.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseSurgery = $this->Masters->data("surgery", null, $this->_params);
            $responseSurgery = json_decode($responseSurgery);

            if ($responseSurgery->result == 200) {
                $resDoctor = $responseSurgery->data->item->aaData;

                if (!empty($resDoctor)) {
                    foreach ($resDoctor as $key => $doctor) {
                        $row = [
                            "no" => ($key  + 1),
                            "name" => $doctor->name,
                            "surgery" => $doctor->ot_category,
                            "fare" => "Rp " . number_format($doctor->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseSurgery->data->item->draw;
                    $totalRecods = $responseSurgery->data->item->iTotalRecords;
                    $totalDisplays = $responseSurgery->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveSurgery = $this->Masters->save("surgery", $this->_params);

            echo $saveSurgery;
        }
    }

    private function _laboratory()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);

                $responseLabCategory = $this->Masters->data("general", "lab_category");
                $responseLabCategory = json_decode($responseLabCategory);

                $data["labCategory"] = ($responseLabCategory->result == 200) ? $responseLabCategory->data->item : $responseLabCategory->data;
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/laboratory.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseLaboratory = $this->Masters->data("laboratory", null, $this->_params);
            $responseLaboratory = json_decode($responseLaboratory);

            if ($responseLaboratory->result == 200) {
                $resLaboratory = $responseLaboratory->data->item->aaData;

                if (!empty($resLaboratory)) {
                    foreach ($resLaboratory as $key => $lab) {
                        $row = [
                            "no" => ($key  + 1),
                            "name" => $lab->name,
                            "lab_category" => $lab->lab_category,
                            "fare" => "Rp " . number_format($lab->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseLaboratory->data->item->draw;
                    $totalRecods = $responseLaboratory->data->item->iTotalRecords;
                    $totalDisplays = $responseLaboratory->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveLaboratory = $this->Masters->save("laboratory", $this->_params);

            echo $saveLaboratory;
        }
    }

    private function _fee()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);

                $responseFee = $this->Masters->data("general", "other_fee");
                $responseFee = json_decode($responseFee);

                $data["otherFee"] = ($responseFee->result == 200) ? $responseFee->data->item : $responseFee->data;
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/fee.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseFee = $this->Masters->data("fee", null, $this->_params);
            $responseFee = json_decode($responseFee);

            if ($responseFee->result == 200) {
                $resFee = $responseFee->data->item->aaData;

                if (!empty($resFee)) {
                    foreach ($resFee as $key => $lab) {
                        $row = [
                            "no" => ($key  + 1),
                            "name" => $lab->name,
                            "other_fee" => $lab->other_fee,
                            "fare" => "Rp " . number_format($lab->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseFee->data->item->draw;
                    $totalRecods = $responseFee->data->item->iTotalRecords;
                    $totalDisplays = $responseFee->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveFee = $this->Masters->save("fee", $this->_params);

            echo $saveFee;
        }
    }

    private function _users()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            if (!is_null($this->rsId)) {
                $data["rsId"] = $this->rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $this->rsId]);
                $hospital = json_decode($hospital);
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/users.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseUsers = $this->Masters->data("users", null, $this->_params);
            $responseUsers = json_decode($responseUsers);

            if ($responseUsers->result == 200) {
                $resUser = $responseUsers->data->item->aaData;

                if (!empty($resUser)) {
                    foreach ($resUser as $key => $user) {
                        $row = [
                            "no" => ($key  + 1),
                            "name" => $user->name,
                            "username" => $user->username,
                            "last_login" => (!is_null($user->last_login)) ? date("d F Y H:i:s", strtotime($user->last_login)) : "-"
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseUsers->data->item->draw;
                    $totalRecods = $responseUsers->data->item->iTotalRecords;
                    $totalDisplays = $responseUsers->data->item->iTotalDisplayRecords;
                }
            }

            $result = [
                "draw" => $draw,
                "recordsTotal" => $totalRecods,
                "recordsFiltered" => $totalDisplays,
                "data" => $items
            ];

            echo json_encode($result);
        } else if (!is_null($this->_flag) && $this->_flag == "save") {
            unset($this->_params["todo"]);
            unset($this->_params["btnTodo"]);
            $saveHospital = $this->Masters->save("users", $this->_params);

            echo $saveHospital;
        }
    }

    public function action()
    {
        if ($this->plkk_session->user_role == 1 && $this->plkk_session->rs_id != $this->rsId)
            $this->rsId = $this->plkk_session->rs_id;

        switch ($this->_command) {
            case 'lists':
                $this->_lists();
                break;
            case 'data':
                $this->_data();
                break;
            case 'room':
                $this->_room();
                break;
            case 'radiology':
                $this->_radiology();
                break;
            case 'rehabilitation':
                $this->_rehabilitation();
                break;
            case 'medic':
                $this->_medic();
                break;
            case 'doctor':
                $this->_doctor();
                break;
            case 'surgery':
                $this->_surgery();
                break;
            case 'laboratory':
                $this->_laboratory();
                break;
            case 'fee':
                $this->_fee();
                break;
            case 'users':
                $this->_users();
                break;
        }
    }
}