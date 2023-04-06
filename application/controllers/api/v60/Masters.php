<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/api/components/API_Controller.php");
include_once(APPPATH . "controllers/api/components/Masters/Data.php");
include_once(APPPATH . "controllers/api/components/Masters/Save.php");
include_once(APPPATH . "controllers/api/components/Masters/Update.php");
include_once(APPPATH . "controllers/api/components/Masters/Delete.php");

class Masters extends API_Controller
{
    private $res_code = 201;
    private $res_message = "";

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array(
            'url',
            'url_helper',
            'file'
        ));

        $this->CI->load->model(array(
            'muser'
        ));

        $this->CI->load->library(array(
            'myutils'
        ));
    }

    public function data($command, $flag = null, $params = null)
    {
        try {
            $data = new Data($command, $flag, $params);
            $data->action($this->responseObj, $this->res_code, $this->res_message);

            return $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            return $this->sendResponseError($e);
        }
    }

    public function save($command, $params = null)
    {
        try {
            $save = new Save($command, $params);
            $save->action($this->responseObj, $this->res_code, $this->res_message);

            return $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            return $this->sendResponseError($e);
        }
    }

    public function update($command, $params = null)
    {
        try {
            $update = new Update($command, $params);
            $update->action($this->responseObj, $this->res_code, $this->res_message);

            return $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            return $this->sendResponseError($e);
        }
    }

    public function delete($command, $params = null)
    {
        try {
            $delete = new Delete($command, $params);
            $delete->action($this->responseObj, $this->res_code, $this->res_message);

            return $this->sendResponse($this->res_code, $this->res_message);
        } catch (Exception $e) {
            return $this->sendResponseError($e);
        }
    }
}