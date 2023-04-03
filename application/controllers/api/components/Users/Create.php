<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Create
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
        if (!isset($jsonInputObj->username) || !isset($jsonInputObj->name) || !isset($jsonInputObj->email) || !isset($jsonInputObj->npp)) {
            throw new Exception("Data tidak lengkap. Silahkan cek kembali data anda!", 422);
        }

        $password = "!Plkkrates123";
        $generatePassword = $this->CI->myutils->generatePassword($password);
        if (!$generatePassword) {
            throw new Exception("Password harus terdiri dari mininal 8 karakter, terdiri dari gabungan huruf kapital, huruf kecil, angka,dan simbol!", 422);
        }

        $this->CI->form_validation->set_data((array) $jsonInputObj);
        $this->CI->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        if ($this->CI->form_validation->run() == FALSE) {
            throw new Exception("Format email anda salah.", 422);
        }

        $checkEmailExist = $this->CI->user->getUserByEmail($jsonInputObj->email);
        if (!is_null($checkEmailExist)) throw new Exception("Email telah terdaftar", 422);
        
        $checkUsernameExist = $this->CI->user->getUserByUsername($jsonInputObj->username);
        if (!is_null($checkUsernameExist) && ($checkUsernameExist->username == $jsonInputObj->username)) throw new Exception("Username telah terdaftar. Silahkan pilih username yang lain!", 422);


        $timeTs = date("Y-m-d H:i:s");
        $dataUser = [
            "name" => $jsonInputObj->name,
            "username" => $jsonInputObj->username,
            "email" => $jsonInputObj->email,
            "password" => $generatePassword,
            "created" => $timeTs,
            "updated" => $timeTs,
        ];
        $user = $this->CI->user->addUser($dataUser);
        if (!is_null($user) && $user->result > 0) {
            unset($dataUser["password"]);
            $responsecode = 200;
            $responseObj  = [
                "name"  => "User Created",
                "item"  => $dataUser
            ];
        }
    }

}