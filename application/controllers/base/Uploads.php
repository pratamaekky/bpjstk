<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers/base/web_base.php';
date_default_timezone_set("Asia/Jakarta");

class Uploads extends CI_Controller
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

        $this->load->library(array(
            'myutils'
        ));
    }

    public function newsImages()
    {
        $images = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($_FILES["image"]["tmp_name"]));
        $newsImages = $this->myutils->saveFile($images, 'berita', 'berita');

        echo base_url("files/images/berita/" . $newsImages);
    }

}