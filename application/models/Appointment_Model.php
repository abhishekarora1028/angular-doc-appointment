<?php
/**
 * Appointment Model Class
 *
 * Used to deal with appointment table in database.
 *
 * @project	AngularJs Doctors Appointment
 * @package 	Models
 * @author	Abhishek Arora
 */
Class Appointment_Model extends CI_Model {
    
    /**
     *  @desc get appointment
     *  @param int appointmentId - where condition
     *  @return array of appointment data from database
     */
    public function getAppointment($appointmentId) {
        return $this->db->get_where('appointment', array('appointment_id' => $appointmentId))->row_array();
    }
    
    /**
     *  @desc update appointment
     *  @param array $postData - data to be updated
     *  @param int $appointmentId - where condition
     *  @return success with OK;
     */
    public function updateAppointment($postData, $appointmentId) {
        $this->db->update('appointment', $postData, array('appointment_id' => $appointmentId));
        if ($this->db->affected_rows() > 0) {
            return 'OK';
        }
    }
    /**
     *  @desc create new appointment slot - used by managers for each doctor
     *  @param datetime $appointment_start - appointment start time
     *  @param datetime $appointment_end - appointment end time
     *  @param int doctor_id - doctor id
     *  @return success with OK;
     */
    public function createAppointmentSlot($appointment_start, $appointment_end, $doctor_id) {
        $this->db->insert('appointment', array('appointment_start' => $appointment_start, 'appointment_end' => $appointment_end, 'doctor_id' => $doctor_id));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
    }
    
    /**
     *  @desc delete appointment slot - used by managers for each doctor
     *  @param array $postData - appointmentID
     *  @return success with OK;
     */
    public function deleteAppointment($postData) {
        $this->db->delete('appointment', array('appointment_id' => $postData['id']));
        if ($this->db->affected_rows() > 0) {
            return 'OK';
        }
    }
    
    /**
     *  @desc get all free and waiting appointment slots 
     *  @param array $postData - appointment_start, appointment_end_time ranges, user_session_id
     *  @return array of appointments from database;
     */
    public function getFreeAppointments($postData) {
        $this->db->select('appointment_id as id, appointment_start as start, appointment_end as end, appointment_status as status, doctor.doctor_name');
        $this->db->where("(appointment_status = 'free' OR (appointment_status <> 'free' AND appointment_patient_session = '" . session_id() . "')) AND NOT ((appointment_end <= '" . $postData['start'] . "') OR (appointment_start >= '" . $postData['end'] . "'))");
        $this->db->join('doctor', 'doctor.doctor_id=appointment.doctor_id');
        return $this->db->get('appointment')->result_array();
    }
    
    /**
     *  @desc get all appointment slots 
     *  @param array $postData - appointment_start, appointment_end_time ranges
     *  @return array of appointments from database;
     */
    public function getAllAppointments($postData) {
        $this->db->select('appointment_id as id, appointment_start as start, appointment_end as end, appointment_status as status, doctor_id as resource, appointment_patient_name as text');
        $this->db->where("NOT ((appointment_end <= '" . $postData['start'] . "') OR (appointment_start >= '" . $postData['end'] . "'))");
        return $this->db->get('appointment')->result_array();
    }

}

?>
