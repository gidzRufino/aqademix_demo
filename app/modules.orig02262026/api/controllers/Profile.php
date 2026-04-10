<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Profile extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('profile_model');
    }
    
    
    private function post()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }
    
    public function getDetails($user_id, $year)
    {
        $student = Modules::run('registrar/getSingleStudent', $user_id, $year);
        $father = Modules::run('registrar/getFather', $user_id);
        echo json_encode(array(
                   's' => $student,
                   'father' => 'hello'
                )
             );
    }
    
    public function gets($token=NULL, $profile_id=NULL)
    {
        $childLinks = $this->profile_model->getChildLinks($profile_id);
        //$numberOfStudents = Modules::run('pp/getNumberOfStudents', $profile_id);
        
        $data['child_links'] = $childLinks;
        $this->load->view('studentRoster', $data);
        
    }
    
    public function get($token=NULL, $profile_id=NULL)
    {
        $data = $this->post();
        $profile_id==NULL?$data['profile_id']:$profile_id;
        $childLinks = $this->profile_model->getChildLinks($profile_id);
        $children = explode(',', $childLinks);
        $school_year = date('Y');
        foreach($children as $child):
                    $isEnrolled = Modules::run('registrar/isEnrolled', $child, date('Y'));
                    if(!$isEnrolled):
                        $school_year = $school_year -1;
                    endif;
                    $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                    
                    $data = array(
                        'Name' => strtoupper($student->firstname.' '. $student->lastname),
                        'img' => base_url('uploads/'.$student->avatar),
                        'grade_level' => $student->level,
                        'section' => $student->section
                    );
                   
        endforeach;            
        
        echo json_encode($data);
    }
    
    public function getAttendance($token=NULL, $profile_id=NULL)
    {
        $childLinks = $this->profile_model->getChildLinks($profile_id);
        //$numberOfStudents = Modules::run('pp/getNumberOfStudents', $profile_id);
        $x = 5;
        $sy = $this->session->userdata('school_year');
        for($d=1;$d<=11;$d++){
            $m = $d+$x;
            if($m<10):
                $m = '0'.$m;
            endif;
            if($m>12):
                $m = $m - 12;
                if($m<10):
                    $m = '0'.$m;
                endif;
            endif;
            $next = $sy+1;
            if(date('Y')>$sy):
                if($m<abs(06)):
                    $year = $next;
                else:
                    $year = $sy;
                endif;
            else:
                if($m<abs(06) && date('Y')>$sy):
                    $year = date('Y');
                else:
                    $year = $sy;
                endif;
            endif;
            $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), date('Y'), 'first');
            $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m'), 10)), date('Y'), 'last');
            $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, date('m'), date('Y'));
            $holiday = Modules::run('calendar/holidayExist', date('m'), date('Y'));
            $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
            $totalDays += $totalDaysInAMonth;
        }
        
        
        $data['totalDays'] = $totalDaysInAMonth;
        $data['child_links'] = $childLinks;
        $this->load->view('attendanceRoster', $data);
  
    }
    
    
    
   
    
    

}
 
