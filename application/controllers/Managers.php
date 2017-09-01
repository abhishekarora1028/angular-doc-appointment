<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Managers Controller Class
 *
 * Used to deal with Appointment Model and Views for creating/deleting all appointments
 *
 * @project	AngularJs Doctors Appointment
 * @package 	Controllers
 * @author	Abhishek Arora
 */
class Managers extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Appointment_Model', '', TRUE);
    }

    
    /*
     *  loads manager view page
     */
    public function index() {
        $data['managerstab'] = "primary";
        $this->load->view('managers', $data);
    }
    
    /**
     *  @desc manager create appointment slots
     */
    public function createSlots() {
        $postData = json_decode(file_get_contents('php://input'), true);
        $start = new DateTime($postData['start']);
        $start_day = clone $start;
        $start_day->setTime(0, 0, 0);
        $end = new DateTime($postData['end']);
        $end_day = clone $end;
        $end_day->setTime(0, 0, 0);
        $days = $end_day->diff($start_day)->days;
        if ($end > $end_day) {
            $days += 1;
        }
        $scale = $postData['scale'];
        $timeline = $this->load_timeline($scale, $days, $start_day);
        $slot_duration = 60;
        $doctor_id = $postData['resource'];
        foreach ($timeline as $cell) {
            if ($start <= $cell->start && $cell->end <= $end) {
                for ($shift_start = clone $cell->start; $shift_start < $cell->end; $shift_start->add(new DateInterval("PT" . $slot_duration . "M"))) {
                    $shift_end = clone $shift_start;
                    $shift_end->add(new DateInterval("PT" . $slot_duration . "M"));
                    $this->Appointment_Model->createAppointmentSlot($shift_start->format("Y-m-d\\TH:i:s"), $shift_end->format("Y-m-d\\TH:i:s"), $doctor_id);
                }
            }
        }
        $response['result'] = 'OK';
        $response['message'] = 'Shifts created';
        $responseObject = (object) $response;
        echo json_encode($responseObject);
    }
    /**
     * @desc create timeline for the shifts selected by manager
     * @param string $scale - hours, shifts 
     * @param string $days - number of days to create time line 
     * @param string $start_day - beginning date
     * @return array of objects $timeline - start & endtime of the slots
     */
    private function load_timeline($scale, $days, $start_day) {
        $morning_shift_starts = 9;
        $morning_shift_ends = 13;
        $afternoon_shift_starts = 14;
        $afternoon_shift_ends = 18;

        switch ($scale) {
            case "hours":
                $increment_morning = 1;
                $increment_afternoon = 1;
                break;
            case "shifts":
                $increment_morning = $morning_shift_ends - $morning_shift_starts;
                $increment_afternoon = $afternoon_shift_ends - $afternoon_shift_starts;
                break;
            default:
                die("Invalid scale");
        }

        $timeline = array();

        for ($i = 0; $i < $days; $i++) {
            $day = clone $start_day;
            $day->add(new DateInterval("P" . $i . "D"));

            for ($x = $morning_shift_starts; $x < $morning_shift_ends; $x += $increment_morning) {
                $cell = array();

                $from = clone $day;
                $from->add(new DateInterval("PT" . $x . "H"));

                $to = clone $day;
                $to->add(new DateInterval("PT" . ($x + $increment_morning) . "H"));

                $cell['start'] = $from;
                $cell['end'] = $to;
                $timeline[] = (object) $cell;
            }

            for ($x = $afternoon_shift_starts; $x < $afternoon_shift_ends; $x += $increment_afternoon) {
                $cell = array();

                $from = clone $day;
                $from->add(new DateInterval("PT" . $x . "H"));

                $to = clone $day;
                $to->add(new DateInterval("PT" . ($x + $increment_afternoon) . "H"));

                $cell['start'] = $from;
                $cell['end'] = $to;
                $timeline[] = (object) $cell;
            }
        }

        return $timeline;
    }

}
