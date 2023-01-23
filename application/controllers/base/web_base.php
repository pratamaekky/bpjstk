<?php
require_once 'constant.php';

class web_base extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $session_userdata = $this->session->userdata("plkk.pm");
        $this->plkk_session = $session_userdata;
        // if (!is_null($this->smile_session))
        //     $this->access_level = $session_userdata["access_level"];
        
        $contr = strtolower($this->uri->segment(1));
        $module = strtolower($this->uri->segment(2));

        if ($module != "login" && ($module != "dologin" && $module != "dologout") && is_null($session_userdata)) {
            redirect(BASE_URL . "user/login");
        }
    }

    protected function build_api_url($url)
    {
    }

    protected function getApiResData($response)
    {
        // $data = json_decode($response);
        // if ($data->result == 200) {
        //     if ($data->result == 200) {
        //         return json_encode($data);
        //     } else if ($data->result == 401) {
        //         return json_encode($data);
        //     } else {
        //         return json_encode($data);
        //     }
        // } else {
        //     return json_encode(array("result" => 201, "message" => "Gagal! Lakukan beberapa saat lagi"));
        // }
    }
}