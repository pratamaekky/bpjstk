<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Page extends CI_Controller
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
        $this->load->view("public/profil.php");
    }

    public function profil()
    {
        $this->load->view("public/profil.php");
    }

    public function berita($title = "")
    {
        if (empty($title)) {
            $this->load->view("public/berita/lists");
        } else {
            $this->load->view("public/berita/detail");
        }
    }
}
