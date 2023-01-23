<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
require_once APPPATH . 'controllers/api/v60/Users.php';
date_default_timezone_set("Asia/Jakarta");

class User extends CI_Controller
{

    /**
     * Contructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'text',
            'url'
        ));

        $this->load->library(array(
            'myutils',
            'somplakapi',
            'user_agent'
        ));
    }

    public function index()
    {
        
    }

    public function login()
    {
        $this->load->view("public/login.php");
    }

    public function dologin()
    {        
        header('Content-Type: application/json');
        $AUsers = new Users();
        $data = (object) [
            "username" => !is_null($this->input->post("username_login")) ? $this->input->post("username_login", true) : "adminplkk",
            "password" => !is_null($this->input->post("password_login")) ? md5($this->input->post("password_login", true)) : "59d51b5cb69c829ea5bfe77e38a1522e"
        ];

        $response = $AUsers->login($data);
        $response = json_decode($response);

        if ($response->result == 200) {
            $data = $response->data->item;
            $this->session->set_userdata("plkk.pm", $data);
        }

        echo json_encode($response);
    }

    public function dologout()
    {
        $this->session->unset_userdata("plkk.pm");
        $this->session->sess_destroy();

        redirect(BASE_URL . "user/login");
    }
}