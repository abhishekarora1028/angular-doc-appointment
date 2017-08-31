<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unittest extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->model('Appointment_Model');
        $this->load->model('Doctors_Model');
    }
    
    private function createAppointment($appointmentData){
        return $this->Appointment_Model->createAppointmentSlot($appointmentData['appointment_start'],$appointmentData['appointment_end'],$appointmentData['doctor_id']);
    }
    
    private function getAppointment($appointmentId){
        return $this->Appointment_Model->getAppointment($appointmentId);
    }
    
    private function updateAppointment($appointmentData, $appointmentId){
        return $this->Appointment_Model->updateAppointment($appointmentData, $appointmentId);
    }
    
    private function deleteAppointment($appointmentId){
        return $this->Appointment_Model->deleteAppointment(array('id'=>$appointmentId));
    }

    private function getAllAppointment($dateRange){
        return $this->Appointment_Model->getAllAppointments($dateRange);
    }
    
    public function index(){
        echo '<h3>Using codeigniter unit test library</h3>';
        $appointments = $this->getAllAppointment(array('start'=> '2017-01-31T15:00:00', 'end' => '2017-12-31T15:00:00'));
        //create Appointment
        $testAppointment = array('appointment_start'=> '2017-08-31T15:00:00', 'appointment_end' => '2017-08-31T16:00:00', 'doctor_id' => '3');
        $lastAppointmentCreated = $this->createAppointment($testAppointment);
        echo $this->unit->run($lastAppointmentCreated, $lastAppointmentCreated, 'Create Appointment');
        
        // get appointment test
        $expectedTestAppointment = array('appointment_id'=> $lastAppointmentCreated,'appointment_start'=> '2017-08-31T15:00:00', 'appointment_end' => '2017-08-31T16:00:00', 'appointment_patient_name' => '', 'appointment_status' => 'free', 'appointment_patient_session' => '', 'doctor_id' => '3', 'appointment_reason' => '');
        $testGetAppointment = $this->getAppointment($lastAppointmentCreated);
        echo $this->unit->run($testGetAppointment, $expectedTestAppointment, 'Get Appointment');
        
        // get appointment test
        $updatedTestAppointment = array('appointment_id'=> $lastAppointmentCreated,'appointment_start'=> '2017-08-31T15:00:00', 'appointment_end' => '2017-08-31T16:00:00', 'appointment_patient_name' => 'Abhi', 'appointment_status' => 'free', 'appointment_patient_session' => '', 'doctor_id' => '3', 'appointment_reason' => 'General Body Test');
        $testUpdateAppointment = $this->updateAppointment($updatedTestAppointment, $lastAppointmentCreated);
        $expectedUpdateResult = 'OK';
        echo $this->unit->run($testUpdateAppointment, $expectedUpdateResult, 'Update Appointment');
        // get appointment test
        $testUpdatedGetAppointment = $this->getAppointment($lastAppointmentCreated);
        echo $this->unit->run($testUpdatedGetAppointment, $updatedTestAppointment, 'Get Updated Appointment');
        
        //delete test appointment
        $testDeleteAppointment = $this->deleteAppointment($lastAppointmentCreated);
        $expectedDeleteResult = 'OK';
        echo $this->unit->run($testDeleteAppointment, $expectedDeleteResult, 'Delete Appointment');
        
        //get all appointments
        $testgetAllAppointments = $this->getAllAppointment(array('start'=> '2017-01-31T15:00:00', 'end' => '2017-12-31T15:00:00'));
        $expectedgetAllResult = $appointments;
        echo $this->unit->run($testgetAllAppointments, $expectedgetAllResult, 'Get All Appointments');
      
    }
    
}