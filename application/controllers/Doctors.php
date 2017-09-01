<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Doctors Controller Class
 *
 * Used to deal with Doctors Model and Views for getting/updating all doctors appointments
 *
 * @project	AngularJs Doctors Appointment
 * @package 	Controllers
 * @author	Abhishek Arora
 */
class Doctors extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Doctors_Model', '', TRUE);
        $this->load->model('Appointment_Model', '', TRUE);
    }
    
    /**
     *  loads doctors view page
     */
    public function index() {
        $data['doctorstab'] = "primary";
        $data['doctors'] = $this->Doctors_Model->getAllDoctors();
        $this->load->view('doctors', $data);
    }
    
    /**
     *  @desc get all doctors
     *  @return json array of doctors objects
     */
    public function getAll() {
        $doctors = $this->Doctors_Model->getAllDoctors();
        $result = array();
        foreach ($doctors as $doctor) {
            $result[] = (object) $doctor;
        }
        echo json_encode($result);
    }
    
    /**
     * @desc get all free slots of appointments
     * @return json array of free appointment objects
     */
    
    public function getDoctorAppointments() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $freeAppointments = $this->Doctors_Model->getDoctorAppointments($postData);
        $events = array();
        foreach ($freeAppointments as $appointment) {
            $appointment['tags'] = array('status' => $appointment['status']);
            $events[] = (object) $appointment;
        }
        echo json_encode($events);
    }
    
    /**
     *  @desc doctors can change appointment time
     *  @return array success with message
     */
    public function moveAppointment() {
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $postData['appointment_start'] = $params->newStart;
        $postData['appointment_end'] = $params->newEnd;
        $appointmentId = $params->e->id;
        $response['result'] = $this->Appointment_Model->updateAppointment($postData, $appointmentId);
        $response['message'] = 'Update successful';
        $responseObject = (object) $response;
        echo json_encode($responseObject);
    }
    
    /**
     *  @desc doctors can confirm/free appointment
     *  @return array success with message
     */
    
    public function editAppointment() {
        $json = file_get_contents('php://input');
        $params = json_decode($json);
        $postData['appointment_status'] = $params->status;
        $appointmentId = $params->id;
        $response['result'] = $this->Appointment_Model->updateAppointment($postData, $appointmentId);
        $response['message'] = 'Update successful';
        $responseObject = (object) $response;
        echo json_encode($responseObject);
    }

}
