<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Appointments extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Appointment_Model', '', TRUE);
        $this->load->model('Doctors_Model', '', TRUE);
    }

    /**
     *  @desc open request appointment view
     */
    public function request() {
        $appointmentId = $this->input->get('id', TRUE);
        $data['event'] = $this->Appointment_Model->getAppointment($appointmentId);
        $this->load->view('appointment_request', $data);
    }

    /**
     * @desc get all free slots of appointments
     * @return json array of free appointment objects
     */
    public function getFree() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $freeAppointments = $this->Appointment_Model->getFreeAppointments($postData);
        $events = array();
        foreach ($freeAppointments as $appointment) {
            $appointment['tags'] = array('status' => $appointment['status']);
            $appointment['text'] = '';
            $events[] = (object) $appointment;
        }
        echo json_encode($events);
    }
    
    /**
     * @desc get all slots of appointments
     * @return json array of all appointment objects
     */
    
    public function getAll() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $freeAppointments = $this->Appointment_Model->getAllAppointments($postData);
        $events = array();
        foreach ($freeAppointments as $appointment) {
            $appointment['tags'] = array('status' => $appointment['status']);
            $events[] = (object) $appointment;
        }
        echo json_encode($events);
    }
    
    /**
     * @desc load edit appointment view
     *
     */
    public function edit() {
        $appointmentId = $this->input->get('id', TRUE);
        $data['event'] = $this->Appointment_Model->getAppointment($appointmentId);
        $data['doctors'] = $this->Doctors_Model->getAllDoctors();
        $this->load->view('appointment_edit', $data);
    }
    
    /**
     * @desc delete appointment
     * @return success array with message
     */
    public function delete() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $response['result'] = $this->Appointment_Model->deleteAppointment($postData);
        $response['message'] = 'Update successful';
        $responseObject = (object) $response;
        echo json_encode($responseObject);
    }
    
    /**
     * @desc save appointment request
     * @return success array with message
     */
    public function save() {
        $post = json_decode(file_get_contents('php://input'), true);;
        $postData = array('appointment_patient_name' => $post['name'], 'appointment_patient_session' => session_id(), 'appointment_status' => 'waiting', 'appointment_reason' => $post['reason']);
        $appointmentId = $post['id'];
        $response['result'] = $this->Appointment_Model->updateAppointment($postData, $appointmentId);
        $response['message'] = 'Update successful';
        $responseObject = (object) $response;
        echo json_encode($responseObject);
    }

}
