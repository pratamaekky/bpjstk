<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hospital
{
    protected $CI;
    protected $appSrc;

    public function __construct($command)
    {
        $this->CI = &get_instance();
        $this->CI->load->helper(array());
        $this->CI->load->model(array());
        $this->CI->load->library(array(
            'form_validation'
        ));

        $this->_command = $command;
    }

    private function _lists()
    {
        $this->CI->load->view("public/hospital.php");
    }

    public function action()
    {
        switch ($this->_command) {
            case 'lists':
                $this->_lists();
                break;
            default:
                # code...
                break;
        }
    }
}