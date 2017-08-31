<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    /**
     * @desc load public view page
     */
    public function index() {
        $data['publictab'] = "primary";
        $this->load->view('public', $data);
    }

}
