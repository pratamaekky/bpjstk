<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Admin extends CI_Controller
{

    /**
     * Contructor
     */
    public function __construct()
    {
    }

    public function index()
    {
        echo "meong admin";
    }

    public function login()
    {
        header('Content-Type: application/json');
        $result = "";
        $jsonInputStr = file_get_contents('php://input');
        $jsonInputObj = json_decode(trim($jsonInputStr));

        var_dump($jsonInputObj);
        
    }
}
