<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
include_once(APPPATH . "controllers/base/constant.php");

class API_Controller extends CI_Controller
{
    public $jsonInputStr;
    public $jsonHeader;
    public $jsonInputObj;
    public $urlRouter = null;

    public $apiIO = null;
    public $responseObj = NULL;
    public $responseErrorObj = NULL;
    public $responseSuccessObj = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array(
            'myutils'
        ));
        $this->load->model(array(
            'api'
        ));

        header('Content-Type: application/json');
        $this->jsonInputStr = file_get_contents('php://input', true);
        $this->jsonInputObj = (object) json_decode(trim($this->jsonInputStr));
        $this->urlRouter = $this->router->fetch_class() . "/" . $this->router->fetch_method();
    }

    protected function sendResponse($responseCode = 200, $responsMessage, $responseData = null)
    {
        $response = array(
            "result" => $responseCode,
            "message" => $responsMessage ?: 'Success',
            "data" => $responseData
        );

        if (!$this->responseErrorObj) {
            $response = array_merge($response, [
                "data" => $this->responseObj
            ]);
            $this->responseSuccessObj = $response;
        }

        return json_encode($response);
    }

    protected function sendResponseError(&$responsMessage, $responseCode = 500)
    {
        $this->responseObj = NULL;
        $this->responseErrorObj = [
            "result" => $responsMessage->getCode() == 0 ? $responseCode : $responsMessage->getCode(),
            "message" => $responsMessage->getMessage()
        ];
        return $this->sendResponse($responsMessage->getCode() == 0 ? $responseCode : $responsMessage->getCode(), $responsMessage->getMessage());
    }
}