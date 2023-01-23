<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once(APPPATH . "controllers/base/Transformer.php");

class Login
{
    protected $CI;
    protected $appSrc;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));
    }

    public function action(&$responseObj, &$jsonInputObj, &$responsecode, &$responseMessage)
    {
        $timeTs = date("Y-m-d H:i:s");
        if ((!isset($jsonInputObj->username) || empty($jsonInputObj->username)) || (!isset($jsonInputObj->password) || empty($jsonInputObj->password)))
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);

        $userInfo = $this->CI->muser->getUserByUsername(strtolower($jsonInputObj->username));
        if (is_null($userInfo))
            throw new Exception("Username tidak ditemukan. Silahkan coba kembali!", 401);

        if (!password_verify($jsonInputObj->password, $userInfo->password))
            throw new Exception("Password tidak sama. Silahkan coba kembali!", 401);


        $dataUser = [
            "username" => $userInfo->username,
            "last_login" => $timeTs
        ];
        $this->CI->muser->updateUser($dataUser);

        unset($userInfo->id);
        unset($userInfo->updated);
        unset($userInfo->password);
        $userInfo->user_role = intval($userInfo->role);
        $userInfo->role = Transformer::convertUserRole($userInfo->role);
        $userInfo->rs_id = intval($userInfo->rs_id);
        $userInfo->last_login = $timeTs;
        $userInfo->avatar = (!is_null($userInfo->avatar) && !empty($userInfo->avatar)) ? "./files/thumbs/avatar/" . $userInfo->avatar : "";

        $responsecode = 200;
        $responseObj  = [
            "name"  => "User Login",
            "item"  => $userInfo
        ];
    }
}