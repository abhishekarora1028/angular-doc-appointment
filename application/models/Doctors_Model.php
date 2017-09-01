<?php
/**
 * Doctors_Model Class
 *
 * Used to deal with doctor table in database.
 *
 * @project	AngularJs Doctors Appointment
 * @package 	Models
 * @author	Abhishek Arora
 */
Class Doctors_Model extends CI_Model {

    
    /**
     *  @desc get all doctors
     *  @return array of all available doctors from database
     */
    
    public function getAllDoctors() {
        $this->db->select('doctor_id as id, doctor_name as name');
        return $this->db->get('doctor')->result_array();
    }
    
    /**
     *  @desc get all appointments of a doctor in between start and end times
     *  @param postData - appointment_start_time, appointment_start_time, doctor_id
     *  @return array of all appointment slots of doctor from database
     */
    
    public function getDoctorAppointments($postData) {
        $this->db->select("appointment_id as id, appointment_start as start, appointment_end as end, appointment_status as status, doctor_id as resource, appointment_patient_name || ' - ' || appointment_reason as text");
        $this->db->where("NOT ((appointment_end <= '" . $postData['start'] . "') OR (appointment_start >= '" . $postData['end'] . "')) AND doctor_id = '" . $postData['doctor'] . "'");
        return $this->db->get('appointment')->result_array();
    }
}

?>
