<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ws
 *
 * @author genesis
 */
class schedule extends MX_Controller {
    //put your code here
    

    function __construct() {
        parent::__construct();
        $this->load->model('schedule_model');
    }
    
    function getValue($name)
    {
        return $this->input->post($name);
    }
    
    function getInstructorPerSchedule($sched_code, $school_year = NULL)
    {
        $instructor = $this->schedule_model->getInstructorPerSchedule($sched_code, $school_year);
        return $instructor;
    }
    
        
    function loadSubject($value=NULL, $semester = NULL, $course_id=NULL, $school_year=NULL)
    {
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['subjects'] = $this->schedule_model->searchSubject(urldecode($value), $course_id, $semester, $school_year);
        $this->load->view('schedule/loadSubjectTable', $data);
        
    }
    
    function getCourseAssignPerTeacher($teacher_id)
    {
        $courses = $this->schedule_model->getCourseAssignPerTeacher($teacher_id);
        return $courses;
    }
    
    function getSchedulePerTeacher($teacher_id, $sem = NULL, $school_year = NULL, $opt = NULL) {
        $subjects = $this->schedule_model->getSchedulePerTeacher($teacher_id, $sem, $school_year);
        $data['id'] = $teacher_id;
        $data['semester'] = $sem;
        $data['school_year'] = $school_year;
        $data['subjects'] = $subjects;
        if ($opt != null):
            return $subjects;
        else:
            $this->load->view('faculty/facultyAssignTable', $data);
        endif;
    }

    function getDay($dow_numeric){
        $dowMap = array('S', 'M', 'T', 'W', 'TH', 'F', 'Sat', 'Sun');
        //$dow_numeric = date('w');
        return $dowMap[$dow_numeric];
    }

    
    function getSchedulePerSection($section_id, $sem=NULL, $school_year = NULL)
    {
        $schedule = $this->schedule_model->getSchedulePerSection($section_id, $sem, $school_year);
        
       
        $i = 0;
        $count = count($schedule);
        foreach ($schedule as $sched):
           $day_id[] = $sched->day_id;
           $time = date('g:ia', strtotime($sched->t_from)).' - '.date('g:ia', strtotime($sched->t_to));
           $s_code = $sched->sched_gcode;
           $day .= $this->getDay($day_id[$i++]);
           $room = $sched->room;
           $tfrom = $sched->t_from;
           $tto = $sched->t_to;
           //$day .= ($i<$count?" - ":'');
        endforeach;
        
        $result = json_encode(array(
            'day' => $day, 
            'time' => $time,
            'room' => $room, 
            'sched_code' => $s_code,
            'count'=> $count, 
            'sem' => $sched->semester, 
            'time_from' => $tfrom,
            'time_to'   => $tto,
            'instructor' => $sched->lastname!=''?$sched->lastname.', '.$sched->firstname:'')
        );
        return $result;
        
    }
    
    function time_range30($lower = 7, $upper = 21, $step = .5, $format = NULL) {

        if ($format === NULL) {
            $format = 'g:i a'; // 9:30pm
        }
        $times = array();
        $i = 1;
        foreach(range($lower, $upper, $step) as $increment) {
            $increment = number_format($increment, 2);
            list($hour, $minutes) = explode('.', $increment);
            $date = new DateTime($hour . ':' . $minutes * .6);
            $times[(string) $i++] = $date->format($format);
        }
        return $times;
    }
    
    function time_range($lower = 7, $upper = 22, $step = .5, $format = NULL) {

        if ($format === NULL) {
            $format = 'H:i:s'; // 9:30pm
        }
        $times = array();
        $i = 1;
        foreach(range($lower, $upper, $step) as $increment) {
            $increment = number_format($increment, 2);
            list($hour, $minutes) = explode('.', $increment);
            $date = new DateTime($hour . ':' . $minutes * .6);
            $times[(string) $i++] = $date->format($format);
        }
        return $times;
    }
    
    function getSingleTimeSchedule($day_id, $time, $sub_id, $sem=NULL, $school_year = NULL)
    {
        $schedule = $this->schedule_model->getSingleTimeSchedule($day_id, $time, $sub_id, $sem, $school_year);
        //return json_decode($schedule);
        return $schedule;
    }
    
            
    function getSingleTimeSchedulePerCourse($day_id, $course_id, $year, $time, $sem, $presentSY)
    {
        $schedule = $this->schedule_model->getTimeSchedPerCourse($course_id, $year, $day_id, $time, $sem, $presentSY);
        //print_r($schedule);
        return $schedule;
    }
            
    function getSingleTimeSchedulePerRoom($day_id, $room, $sem,$school_year =NULL )
    {
        $schedule = $this->schedule_model->getTimeSchedPerRoom($day_id, $room, $sem,$school_year);
        //print_r($schedule);
        return $schedule;
    }
    
    function getSchedulePerSubject($s_id=NULL, $sem=NULL, $school_year = NULL)
    {
        $data['course'] = Modules::run('coursemanagement/getCourses');
        $data['collegeSubjects'] = Modules::run('college/subjectmanagement/getCollegeSubjects', $sem, $school_year);
        $data['rooms'] = $this->getRoomsRaw();
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['sub_id'] = $s_id;
        $data['school_year'] = $school_year;
        $data['semester']   = $sem;
        $data['time_range'] = $this->time_range();
        $data['main_content'] = 'schedule/collegeSchedule';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    function perRoom($room=NULL, $sem=NULL, $school_year=NULL)
    {
        $data['course'] = Modules::run('coursemanagement/getCourses');
        $data['collegeSubjects'] = Modules::run('college/subjectmanagement/getCollegeSubjects');
        $data['rooms'] = $this->getRoomsRaw();
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['room']      = $room;
        $data['sem']       = $sem;
        $data['school_year'] = $school_year;
        $data['time_range'] = $this->time_range();
        $data['main_content'] = 'schedule/schedulePerRoom';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    function perCourse($course_id=NULL, $year=NULL, $sem=NULL, $sySked = NULL)
    {
        $data['course'] = Modules::run('coursemanagement/getCourses');
        $data['collegeSubjects'] = Modules::run('college/subjectmanagement/getCollegeSubjects', $sem, $sySked);
        $data['rooms'] = $this->getRoomsRaw();
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['course_id'] = $course_id;
        $data['year']      = $year;
        $data['ro_year'] = Modules::run('registrar/getROYear');
        if($sySked == NULL){
            $data['presentSY'] = $this->session->userdata('school_year');
        } else {
            $data['presentSY'] = $sySked;
        }
        $data['sem']       = $sem;
        $data['time_range'] = $this->time_range();
        $data['main_content'] = 'schedule/collegeSchedulePerCourse';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    
    
    function getCollegeSched($day_id, $time_id=NULL)
    {
        $sched = $this->schedule_model->getCollegeSched($time_id, $day_id);
        return $sched;
    }
    
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function colorChange() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
    
    function getSchedPerDay($day_id)
    {
        $sched= $this->getCollegeSched($day_id);
        foreach ($sched->result() as $m):
            for($i=$m->time_from; $i<=$m->time_to; $i++):
                $subjects[$i] .= $m->s_id.',';
            endfor;
                
        endforeach;
        return json_encode(array('subjects'=>$subjects, 'color'=> $this->colorChange()));
    }
    
    function getSched($sched_time)
    {
        $sched = $this->schedule_model->getSchedule($sched_time);
        return $sched;
    }
    
    function addCollegeSched($option)
    {
        $mon = $this->getValue('mon');
        $tue = $this->getValue('tue');
        $wed = $this->getValue('wed');
        $thu = $this->getValue('thu');
        $fri = $this->getValue('fri');
        $sat = $this->getValue('sat');
        $sun = $this->getValue('sun');
        $room_id = $this->getValue('inputRoom');
        $course_id = $this->getValue('inputCollegeCourse');
        $yearLevel = $this->getValue('yearLevel');
        $sec_id = $this->getValue('inputSection');
        $sub_id = $this->getValue('inputCollegeSubject');
        $fac_id = $this->getValue('inputTeacher');
        $color_code = $this->getValue('colorCode');
        $school_year = $this->getValue('school_year');
        $year = substr($school_year, 2,2);
        $length = '4';
        $characters = '0123456789';
        $string = '';    
        
        $section = Modules::run('college/subjectmanagement/getSectionById', $sec_id);
        $sem_id = $section->sec_sem;
        $sem = $this->getValue('sem');

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }
        
        $gcode = $year.$string;
        
        $spc_id = Modules::run('college/coursemanagement/getSpecificSubjectPerCourse', $course_id, $yearLevel, $sub_id, $sem_id);   
        
        if($option!=0):
            if($mon!=""):
                $item = explode(',', $mon);
                $result = $this->saveSchedule($gcode,1, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($tue!=""):
                $item = explode(',', $tue);
                $result = $this->saveSchedule($gcode,2, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($wed!=""):
                $item = explode(',', $wed);
                $result = $this->saveSchedule($gcode,3, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($thu!=""):
                $item = explode(',', $thu);
                $result = $this->saveSchedule($gcode,4, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($fri!=""):
                $item = explode(',', $fri);
                $result = $this->saveSchedule($gcode,5, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($sat!=""):
                $item = explode(',', $sat);
                $result = $this->saveSchedule($gcode,6, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;    
            if($sun!=""):
                $item = explode(',', $sun);
                $result = $this->saveSchedule($gcode,7, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
            endif;  
            
            echo json_encode(array('status'=> TRUE, 'msg'=>'Successfully Saved '.$spc_id));
        else:    
            if($mon!=""):
                $item = explode(',', $mon);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 1, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                   $result = $this->saveSchedule($gcode,1, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;

            if($tue!=""):
                $item = explode(',', $tue);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 2, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 2,  $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            if($wed!=""):
                $item = explode(',', $wed);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 3, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 3,  $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            if($thu!=""):
                $item = explode(',', $thu);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 4, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 4, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            if($fri!=""):
                $item = explode(',', $fri);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 5, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 5, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            if($sat!=""):
                $item = explode(',', $sat);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 6, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 6, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            if($sun!=""):
                $item = explode(',', $sun);
                $conflict = $this->schedule_model->checkSched($room_id, $item[0], $item[1], 7, $spc_id, $fac_id, $sem, $school_year);
                $ret = json_decode($conflict);
                if($ret->status):
                    $result = $this->saveSchedule($gcode, 7, $room_id, $fac_id, $item[0], $item[1], $sub_id, $spc_id, $sem, $school_year,$color_code, $sec_id);
                endif;
            endif;
            
            if($ret->status):
                echo json_encode(array('status'=> TRUE,'msg'=>'Successfully Saved '.$spc_id));
            else:
                echo json_encode(array('status'=> FALSE, 'msg'=>'Sorry, This schedule cannot be included in the system. There is a possible conflict of the schedule. '. $ret->time));
            endif;
        endif;    
        
    }
    
    function saveSchedule($gcode, $day_id, $room_id, $fac_id, $from, $to, $sub_id, $spc_id, $sem_id, $school_year, $color_code, $section_id = NULL)
    {
        
        $sched = $this->schedule_model->saveSchedule($gcode, $from, $to, $day_id, $room_id, $spc_id, $color_code, $section_id, $fac_id,$school_year, $sem_id);
        $result = json_decode($sched);
           
        return $result;
    }
    
    function deleteSchedule($gcode, $school_year = NULL)
    {
        $result = $this->schedule_model->deleteSchedule($gcode, $school_year);
        if($result):
            echo 'Successfully Deleted';
        else:
            echo 'Sorry, Something went wrong';
        endif;
    }
    
    function saveTime($day_id, $time_from, $time_to)
    {
        $result = $this->schedule_model->saveTime($day_id, $time_from, $time_to);
        return $result;
    }
    
    function index()
    {
        $data['sub_id'] = '';
        $data['course'] = Modules::run('coursemanagement/getCourses');
        $data['collegeSubjects'] = Modules::run('college/subjectmanagement/getCollegeSubjects');
        $data['rooms'] = $this->getRoomsRaw();
        $data['sy'] = $this->session->userdata('school_year');
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['time_range'] = $this->time_range();
        $data['main_content'] = 'schedule/default';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
       
    }
    
    function getSchedCollege($from=NULL, $to=NULL, $day=NULL)
    {
        $sched = $this->schedule_model->getSchedCollege($from, $to, $day);
        return $sched;
    }
            
    function loadSchedule($option)
    {
        
        $data['rooms'] = $this->getRoomsRaw();
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['subjects'] = Modules::run('academic/getSubjects');
        switch ($option):
            case 1:
                $data['time'] = $this->getTime($option);
                $data['schedules'] = $this->getAllSchedule();
                $data['grade'] = Modules::run('registrar/getGradeLevel');
                $this->load->view('schedules', $data);  
            break;    
        
            case 2:
                $data['time'] = $this->getTime($option);
                $data['schedules'] = $this->getCollegeSched();
                $data['course'] = Modules::run('coursemanagement/getCourses');
                $data['collegeSubjects'] = Modules::run('academic/getCollegeSubjects');
                $this->load->view('collegeSchedule', $data);
            break;    
        endswitch;
    }
    
    
    function createCollegeSched()
    {
        $details = array(
            'day'           => $this->getValue('day'),
            'sched_time_id' => $this->getValue('time'),
            'subject_id'    => $this->getValue('inputCollegeSubject'),
            'course_id'      => $this->getValue('inputCollegeCourse'),
            'room_id'       => $this->getValue('inputRoom'),
            't_id'          => $this->getValue('inputTeacher'),
        );
        
        $result = $this->schedule_model->createCollegeSched($details, $this->getValue('time'), $this->getValue('day'), $this->getValue('timeFrom'), $this->getValue('timeTo'), $this->getValue('inputCollegeCourse'), $this->getValue('inputRoom'), $this->getValue('inputTeacher'),$this->getValue('inputCollegeSubject'));
        
        echo $result;
    }
    
    function getTime()
    {
        $time = $this->schedule_model->getTime();
        return $time;
    }
    
    function addTime($option=NULL)
    {
       
        $timeDetails = array(
             'time_fr'  => $this->getValue('from'),
             'time_to'  => $this->getValue('to'),
            'department_id' => $option
        );
        
        $time = $this->schedule_model->addTime($timeDetails, $this->getValue('from'), $this->getValue('to'), $option);
        
        echo $time;
    }


    function deleteTime($id)
    {
        $result = $this->schedule_model->deleteTime($id);
        if($result):
            echo json_encode(array('status' => True, 'msg' => 'Successfuly Deleted'));
        else:
            echo json_encode(array('status' => False, 'msg' => 'Sorry Deleting Error Occured'));
        endif;
    }

    function deleteSched($id)
    {
        $result = $this->schedule_model->deleteSched($id);
        if($result):
            echo json_encode(array('status' => True, 'msg' => 'Successfuly Deleted'));
        else:
            echo json_encode(array('status' => False, 'msg' => 'Sorry Deleting Error Occured'));
        endif;
    }
    
    function teacherSched($t_id=NULL)
    {
        $data['time'] = $this->getTime();
        $data['teacher_id'] = $t_id;
        $this->load->view('searchSched', $data);
    }
    function sectionSched($section_id=NULL)
    {
        $data['section_id'] = $section_id;
        $data['time'] = $this->getTime();
        $data['schedules'] = $this->getAllSchedule();
        $data['rooms'] = $this->getRoomsRaw();
        $data['employees'] = Modules::run('hr/getEmployees');
        $data['subjects'] = Modules::run('academic/getSubjects');
        $data['grade'] = Modules::run('registrar/getGradeLevel');
        $data['main_content'] = 'default';
        $data['modules'] = 'schedule';
        echo Modules::run('templates/main_content', $data);
        

    }
    
    function maxSched()
    {
        $data['time'] = $this->getTime();
        $data['schedules'] = $this->getAllSchedule();
        $this->load->view('maxSched', $data);
    }


    function getAllSchedule($from=NULL, $to=NULL, $day=NULL, $t_id = NULL, $section_id = NULL)
    {
        $sched = $this->schedule_model->getAllSchedule($from, $to, $day, $t_id, $section_id);
        return $sched;
    }
   
    
    function createSched()
    {
        $details = array(
            'day'           => $this->getValue('day'),
            'sched_time_id' => $this->getValue('time'),
            'subject_id'    => $this->getValue('inputSubject'),
            'grade_id'      => $this->getValue('inputGrade'),
            'section_id'    => $this->getValue('inputSection'),
            'room_id'       => $this->getValue('inputRoom'),
            't_id'          => $this->getValue('inputTeacher'),
        );
        
        $result = $this->schedule_model->createSched($details, $this->getValue('time'), $this->getValue('day'), $this->getValue('timeFrom'), $this->getValue('timeTo'), $this->getValue('inputSection'), $this->getValue('inputRoom'), $this->getValue('inputTeacher'),$this->getValue('inputSubject'));
        
        
        echo $result;
    }
    
    function getRoomsRaw()
    {
       $room = $this->schedule_model->getRooms();
       return $room;
       
    }
    
    function getRooms()
    {
       $room['rooms'] = $this->schedule_model->getRooms();
       $this->load->view('listOfRooms', $room);
       
    }


    function addRooms()
    {
        $rm_details = array(
            'room'  => $this->input->post('room'),
            'rm_desc'  => $this->getValue('room_desc'),
        );
        
        if($this->schedule_model->addRooms($rm_details, $this->getValue('room'))):
            echo 'Room Successfully Added';
        else:
            echo 'Sorry, Room already Exist';
        endif;
        
    }
    
    
    
}

