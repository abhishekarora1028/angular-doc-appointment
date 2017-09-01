<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Public Controller Class
 *
 * Used to load view for patients
 *
 * @project	AngularJs Doctors Appointment
 * @package 	Controllers
 * @author	Abhishek Arora
 */
class Welcome extends CI_Controller {
    
    /**
     * @desc load public view page
     */
    public function index() {
        $data['publictab'] = "primary";
        $this->load->view('public', $data);
    }

}
