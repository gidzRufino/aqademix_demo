<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Attendance_api extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('attendance_model');
        $this->load->model('profile_model');
    }
    
    function getAttendanceDetails($st_id, $month, $school_year)
    {
        $data['st_id'] = base64_decode($st_id);
        if(abs($month) < 6):
            $year = date('Y');
        else:
            $year = date('Y')-1;
        endif;
        $data['month'] = date('Y-'.$month.'-01');
        $data['year'] = $year;
        $data['school_year'] = $school_year;
        $this->load->view('attendance/attendanceDetails', $data);
    }
    
    function getAttendance()
    {
        $numberOfStudents = Modules::run('registrar/getTotalStudents');
        $numberOfPresents = Modules::run('attendance/getNumberOfPresents', date('Y-m-d'));
        $studentPresent = ($numberOfPresents->num_rows()>$numberOfStudents->num_rows()?$numberOfStudents->num_rows():$numberOfPresents->num_rows());
        $numberOfEmployee= Modules::run('hr/getEmployees');
        $numberOfEPresents = Modules::run('attendance/getNumberOfEmployeePresents', date('Y-m-d'));
        
        echo json_encode(array(
            'students' => $numberOfStudents->num_rows(), 
            'presentStudents' => $studentPresent, 
            'employees'  => $numberOfEmployee->num_rows(),
            'presentEmployee' => $numberOfEPresents->num_rows()
        ));
    }
    
    function getStudentAttendance($st_ids, $year=NULL)
    {
        $data['st_ids'] = base64_decode($st_ids);
        $data['baseId'] = $st_ids;
        $data['modules'] = 'api';
        $data['school_year'] = $year;
        $data['main_content'] = 'attendance/attendance_sheet';
        echo Modules::run('templates/mobile_content', $data);
    }
    
    function getDailyAttendance($st_id, $date=NULL)
    {
        $attendance = $this->attendance_model->getDailyAttendance($st_id, $date);
        return $attendance;
    }
}
 
