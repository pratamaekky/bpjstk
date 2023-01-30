<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/api/v60/Masters.php';
include_once(APPPATH . "controllers/base/Transformer.php");

class Generals
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
        $data["type"] = $this->_flag;
        $this->CI->load->view("public/general.php", $data);
    }
    
    private function _data()
    {
        $items = [];
        $draw = 1;
        $totalRecods = 0;
        $totalDisplays = 0;
        $response = $this->Masters->data("generals", $this->_flag, $this->_params);
        $response = json_decode($response);

        if ($response->result == 200) {
            $res = $response->data->item->aaData;

            if (!empty($res)) {
                foreach ($res as $key => $val) {
                    $row = [
                        "no" => ($key  + 1),
                        "value" => $val->value
                    ];

                    $items[] = $row;
                }

                $draw = $response->data->item->draw;
                $totalRecods = $response->data->item->iTotalRecords;
                $totalDisplays = $response->data->item->iTotalDisplayRecords;
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

    private function _save()
    {
        unset($this->_params["todo"]);
        unset($this->_params["btnTodo"]);
        $saveHospital = $this->Masters->save("general", $this->_params);

        echo $saveHospital;
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
            case 'save':
                $this->_save();
                break;
            default:
                # code...
                break;
        }
    }

}