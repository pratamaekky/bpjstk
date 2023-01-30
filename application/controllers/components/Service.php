<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Service
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
                        "room" => "<a class='btn btn-block btn-primary' href='" . base_url("master/service/room/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Kamar</a>",
                        "service" => "<a class='btn btn-block btn-secondary' href='" . base_url("master/service/service/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Layanan</a>",
                        "measure" => "<a class='btn btn-block btn-danger' href='" . base_url("master/service/measure/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Tindakan</a>",
                        "laboratory" => "<a class='btn btn-block btn-info' href='" . base_url("master/service/laboratory/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Laboratorium</a>",
                        "doctor" => "<a class='btn btn-block btn-success' href='" . base_url("master/service/doctor/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Dokter</a>",
                        "fee" => "<a class='btn btn-block btn-warning' href='" . base_url("master/service/fee/lists/$hospital->id") . "' aria-expanded='true'><i class='far fa-eye mr-2'></i> Biaya</a>"
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
            $rsId = $this->CI->uri->segment(5);
            if (!is_null($rsId)) {
                $data["rsId"] = $rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $rsId]);
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

    private function _measure()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            $rsId = $this->CI->uri->segment(5);
            if (!is_null($rsId)) {
                $data["rsId"] = $rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $rsId]);
                $hospital = json_decode($hospital);

                $responseOtCategory = $this->Masters->data("general", "ot_category");
                $responseOtCategory = json_decode($responseOtCategory);

                $responseOtSpecialist = $this->Masters->data("general", "ot_specialist");
                $responseOtSpecialist = json_decode($responseOtSpecialist);

                $data["otCategory"] = ($responseOtCategory->result == 200) ? $responseOtCategory->data->item : $responseOtCategory->data;
                $data["otSpecialist"] = ($responseOtSpecialist->result == 200) ? $responseOtSpecialist->data->item : $responseOtSpecialist->data;
                $data["hospital"] = ($hospital->result == 200) ? $hospital->data->item : null;
                $this->CI->load->view("public/service/measure.php", $data);
            } else {
                $this->CI->load->view("public/service/lists.php", []);
            }
        } else if (!is_null($this->_flag) && $this->_flag == "data") {
            $items = [];
            $draw = 1;
            $totalRecods = 0;
            $totalDisplays = 0;
            $responseMeasure = $this->Masters->data("measure", null, $this->_params);
            $responseMeasure = json_decode($responseMeasure);

            if ($responseMeasure->result == 200) {
                $resMeasure = $responseMeasure->data->item->aaData;

                if (!empty($resMeasure)) {
                    foreach ($resMeasure as $key => $measure) {
                        $row = [
                            "no" => ($key  + 1),
                            "ot_category" => $measure->ot_category,
                            "ot_specialist" => $measure->ot_specialist,
                            "value" => $measure->value,
                            "fare" => "Rp " . number_format($measure->fare, 0, ",",".")
                        ];

                        $items[] = $row;
                    }

                    $draw = $responseMeasure->data->item->draw;
                    $totalRecods = $responseMeasure->data->item->iTotalRecords;
                    $totalDisplays = $responseMeasure->data->item->iTotalDisplayRecords;
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
            $saveHospital = $this->Masters->save("measure", $this->_params);

            echo $saveHospital;
        }
    }

    private function _doctor()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            $rsId = $this->CI->uri->segment(5);
            if (!is_null($rsId)) {
                $data["rsId"] = $rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $rsId]);
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

    private function _service()
    {
        var_dump("Halaman Service");
    }

    private function _laboratory()
    {
        if (!is_null($this->_flag) && $this->_flag == "lists") {
            $rsId = $this->CI->uri->segment(5);
            if (!is_null($rsId)) {
                $data["rsId"] = $rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $rsId]);
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
            $rsId = $this->CI->uri->segment(5);
            if (!is_null($rsId)) {
                $data["rsId"] = $rsId;
                $hospital = $this->Masters->data("hospital", "detail", ["rsId" => $rsId]);
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

    public function action()
    {
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
            case 'service':
                $this->_service();
                break;
            case 'measure':
                $this->_measure();
                break;
            case 'doctor':
                $this->_doctor();
                break;
            case 'laboratory':
                $this->_laboratory();
                break;
            case 'fee':
                $this->_fee();
                break;
        }
    }
}