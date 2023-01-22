<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Main extends CI_Controller
{

    /**
     * Contructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url'
        ));
    }

    public function index()
    {
        $this->load->view("lanang/main");
    }
}