<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedule_model
 *
 * @author genesis
 */
class schedule_model extends CI_Model {
    //put your code here
    
    function getInstructorPerSchedule($sched_code, $school_year)
    {
        ($school_year!=NULL?$this->db = $this->eskwela->db($school_year):"");
        $this->db->join('profile_employee', 'c_schedule.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile','profile.user_id = profile_employee.user_id','left');
        $this->db->where('sched_gcode', $sched_code);
        $q = $this->db->get('c_schedule');
        return $q->row();
    }
         
    function searchSubject($value, $course_id, $semester, $school_year = NULL)
    {
       ($school_year!=NULL?$this->db = $this->eskwela->db($school_year):"");
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->join('c_schedule', 'c_subjects_per_course.spc_course_id = c_schedule.cs_spc_id','left');
        ($course_id!=NULL?$this->db->where('c_subjects_per_course.spc_course_id', $course_id):'');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->like('LOWER(s_desc_title)', strtolower($value), 'both');
        $this->db->or_like('LOWER(sub_code)', strtolower($value), 'both');
        $this->db->group_by('c_section.sec_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getCourseAssignPerTeacher($teacher_id)
    {
        $this->db->where('faculty_id', $teacher_id);
        $this->db->join('c_subjects_per_course', 'c_faculty_assignment.spc_id = c_subjects_per_course.spc_id','left');
        $this->db->group_by('c_subjects_per_course.spc_course_id');
        $q = $this->db->get('c_faculty_assignment');
        return $q->result();
    }
    
    function getTimeSchedPerRoom($day_id, $room, $sem, $school_year )
    {
        
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->select('*');
        $this->db->from('c_schedule');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id', 'left');
        $this->db->join('c_subjects','c_subjects.s_id = c_section.sec_sub_id', 'left');
        $this->db->join('c_courses', 'c_section.course_id = c_courses.course_id','left');
        $this->db->where('c_schedule.room_id', $room);
        $this->db->where('c_schedule.semester', $sem);
        $this->db->where('day_id', $day_id);
        $this->db->order_by('c_schedule.t_from', 'ASC');
        $q = $this->db->get();
                
        return $q->result();
    }
    
    function getTimeSchedPerCourse($course_id, $year, $day_id, $time, $sem, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->select('*');
        $this->db->from('c_schedule');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id', 'left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->where('c_subjects_per_course.spc_course_id', $course_id);
        $this->db->where('c_subjects_per_course.year_level', $year);
        $this->db->where('c_subjects_per_course.spc_sem_id', $sem);
        $this->db->order_by('c_schedule.t_from', 'ASC');
        $this->db->where('day_id', $day_id);
        $this->db->order_by('t_from', 'ASC');
        $q = $this->db->get();
                
        return $q->result();
    }
    
    function getSingleTimeSchedulePerCourse($day_id, $time=NULL, $course_id=NULL, $sem=NULL, $school_year)
    {
        
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $time_given = strtotime($time);
        $this->db->select('*');
        $this->db->from('c_schedule');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id', 'left');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('c_section.course_id', $course_id);
        $this->db->where('day_id', $day_id);
        $q = $this->db->get();
        if($q->num_rows()>0):
            foreach ($q->result() as $t):
                $db_from = strtotime($t->t_from);
                $db_to = new DateTime($t->t_to);
                if($time_given==$db_from):
                    $result =  json_encode(array(
                        'status'    =>  TRUE, 
                        'color'     =>  $t->color_code, 
                        'data'      =>  $t, 
                        'from'      => $db_from,
                        'to'        => $db_to,
                        'position'  => 'from', 
                        'border'    => 'border-top: 1px solid #ddd; border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:none;'));
                elseif($time_given < $db_to && $time_given > $db_from):
                    $result =  json_encode(array(
                        'status'    =>  TRUE, 
                        'color'     =>  $t->color_code, 
                        'data'      =>  $t, 
                        'from'      => $db_from,
                        'to'        => $db_to,
                        'position'  => 'mid',  
                        'border'    => 'border-top: none; border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:none;'));
                elseif($time_given==$db_to):
                    $result =  json_encode(array(
                        'status'    =>  TRUE, 
                        'color'     =>  $t->color_code, 
                        'data'      =>  $t, 
                        'from'      => $db_from,
                        'to'        => $db_to,
                        'position'  => 'to', 
                        'border'    => 'border-top: none; border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd;'));
                else:
                    $result =  json_encode(array('status'=>FALSE,  'color'=>'', 'data'=>'', 'position' =>'', 'border' =>''));
                endif;
                
            endforeach;
        else:
            $result =  json_encode(array('status'=>FALSE, 'color'=>'', 'data'=>'', 'position' =>'', 'border' =>''));
        endif;
        return $result;
    }
    
    function getSingleTimeSchedule($day_id, $time, $sub_id, $sem=NULL, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('sec_sub_id', $sub_id);
        $this->db->where('day_id', $day_id);
        ($sem!=NULL?$this->db->where('sec_sem', $sem):'');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        //$this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        //$this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id', 'left');
        $this->db->join('c_subjects','c_subjects.s_id = c_section.sec_sub_id', 'left');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
            
    function getSchedulePerSubject($s_id)
    {
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('c_subjects_per_course.spc_sub_id', $s_id);
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function getSchedulePerTeacher($teacher_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->join('c_faculty_assignment','c_schedule.sched_gcode = c_faculty_assignment.schedule_id','left');
        $this->db->join('c_section', 'c_schedule.section_id = c_section.sec_id', 'inner');
        $this->db->join('c_subjects', 'c_subjects.s_id = c_section.sec_sub_id', 'left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->where('c_schedule.faculty_id', $teacher_id);
        ($semester!=NULL?$this->db->where('sec_sem', $semester):'');
        $this->db->order_by('t_from','ASC');
        $this->db->group_by('c_schedule.section_id');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function getSchedulePerSection($section_id, $sem, $school_year)
    {
        ($school_year!=NULL?$this->db = $this->eskwela->db($school_year):"");
        $this->db->join('profile_employee', 'c_schedule.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile','profile.user_id = profile_employee.user_id','left');
        $this->db->join('c_section', 'c_schedule.section_id = c_section.sec_id', 'inner');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        // $this->db->where('sec_sem', $sem);
        $this->db->where('semester', $sem);
        $this->db->where('c_schedule.section_id', $section_id);
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
//    function checkSched($room_id, $from, $to, $day_id, $spc_id, $fac_id, $sem_id)
//    {
//        $t_from = strtotime($from);
//        $t_to = strtotime($to);
//        
//        $this->db->where('day_id', $day_id);
//        $q = $this->db->get('c_schedule');
//        if($q->num_rows()>0):
//            $this->db->where('day_id', $day_id);
//            $this->db->where('room_id', $room_id);
//            $sched = $this->db->get('c_schedule');
//            if($sched->num_rows()> 0):
//                foreach($sched->result() as $sch):
//                    $db_from = strtotime($sch->t_from);
//                    $db_to = strtotime($sch->t_to);
//                    if($t_from >= $db_from  && $t_from < $db_to):
//                        $conflictData = $this->getSubjectFromConflict($sch->section_id);
//                        if($sem_id == $conflictData->sec_sem):
//                            $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 1' ));
//                        else:
//                        //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
//                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
//                        endif;
//                    endif;
//                    
//                endforeach;
//                
//            endif;
//            
//        endif;
//        
//         return $result;
//    }
            
    function checkSched($room_id, $from, $to, $day_id, $spc_id, $fac_id, $sem_id, $school_year = NULL)
    {
        $t_from = strtotime($from);
        $t_to = strtotime($to);
        
        ($school_year == NULL ? $this->session->school_year: $school_year);
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('day_id', $day_id);
        $q = $this->db->get('c_schedule');
        if($q->num_rows()>0):
            $this->db->where('day_id', $day_id);
            $this->db->where('room_id', $room_id);
            $sched = $this->db->get('c_schedule');
            if($sched->num_rows()> 0):
                foreach($sched->result() as $sch):
                    $db_from = strtotime($sch->t_from);
                    $db_to = strtotime($sch->t_to);
                    if($t_from >= $db_from  && $t_from < $db_to):
                        $conflictData = $this->getSubjectFromConflict($sch->section_id, $school_year);
                        if($sem_id == $conflictData->sec_sem):
                            $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 1' ));
                        else:
                        //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                        endif;
                    elseif($t_to < $db_to && $db_from < $t_to):
                        $conflictData = $this->getSubjectFromConflict($sch->section_id, $school_year);
                        if($sem_id == $conflictData->sec_sem):
                            $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 2' ));
                        else:
                        //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                        endif;
                    elseif($t_from == $db_from):
                        $conflictData = $this->getSubjectFromConflict($sch->section_id, $school_year);
                        if($sem_id == $conflictData->sec_sem):
                            $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 3' ));
                        else:
                        //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                        endif;
                    else:
                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available 1'));
                    endif;
                endforeach;
            else:
                
                ($school_year == NULL ? $this->session->school_year: $school_year);
                $this->db = $this->eskwela->db($school_year);
                $this->db->where('day_id', $day_id);
                $this->db->where('room_id', $room_id);
                $sched1 = $this->db->get('c_schedule');
                if($sched1->num_rows()> 0):
                    foreach($sched1->result() as $sch1):
                        $db_from = strtotime($sch1->t_from);
                        $db_to = strtotime($sch1->t_to);
                        if($t_from >= $db_from  && $t_from < $db_to):
                            $conflictData = $this->getSubjectFromConflict($sch1->section_id, $school_year);
                            if($sem_id == $conflictData->sec_sem):
                                $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 4' ));
                            else:
                            //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                            $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                            endif;
                        elseif($t_to < $db_to && $t_to > $db_from):
                            $conflictData = $this->getSubjectFromConflict($sch1->section_id, $school_year);
                            if($sem_id == $conflictData->sec_sem):
                                $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 5' ));
                            else:
                            //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                            $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                            endif;
                        elseif($t_from == $db_from):
                            $conflictData = $this->getSubjectFromConflict($sch1->section_id, $school_year);
                            if($sem_id == $conflictData->sec_sem):
                                $result =  json_encode(array('status'=>FALSE, 'time'=>'Please Check schedule of '.$conflictData->short_code.' - '.$conflictData->year_level.' | '.$conflictData->sub_code.' subject for a possible Room Conflict. |  Code Error: 6' ));
                            else:
                            //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                            $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                            endif;
                        else:
                            //$isfacultyAvailable = $this->getTeacherAvailabilty($day_id, $from, $to, $fac_id);
                            $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                        endif;
                    endforeach;
                else:
                        $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
                endif;   
            endif;
        else:
            $result = json_encode(array('status'=>TRUE, 'time'=>'Room is available'));
        endif;
            
        return $result;
    }
    
    function getSubjectFromConflict($section_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('c_courses', 'c_section.course_id = c_courses.course_id');
        $this->db->join('c_subjects','c_section.sec_sub_id = c_subjects.s_id','left');
        $this->db->where('sec_id',$section_id);
        $q = $this->db->get('c_section');
        return $q->row();
    }
    
    function getTeacherAvailabilty($day_id, $from, $to, $fac_id)
    {
        $this->db->where('day_id', $day_id);
        $this->db->where('room_id', $room_id);
        $sched1 = $this->db->get('c_schedule');
    }
    
    function getSchedule($sched, $school_year = NULL)
    {
        ($school_year == NULL ? $this->session->school_year: $school_year);
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('sched_time_id', $sched);
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function saveSchedule($gcode, $from, $to, $day_id, $room_id, $spc_id,  $color_code, $section_id = NULL, $fac_id = NULL, $school_year=NULL, $sem=NULL)
    {
        
        if($section_id==NULL):
            $section_id = 0;
        endif;
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        
        
            $insert = array(
                'room_id'       => $room_id, 
                'sched_gcode'   => $gcode,
                'cs_spc_id'     => $spc_id, 
                'section_id'    => $section_id, 
                'school_year'   => $school_year,
                'semester'      => $sem,
                'color_code'    => '#'.$color_code,
                't_from'        => $from,
                't_to'          => $to,
                'day_id'        => $day_id,
                'faculty_id'    => $fac_id
                );
            
            $this->db = $this->eskwela->db($school_year);
            if($this->db->insert('c_schedule', $insert)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                $result = json_encode(array('status'=>TRUE));
            else:
                $result = json_encode(array('status'=>FALSE));
            endif;
            //$result = array('status' => TRUE, 'id'=>  $this->db->insert_id());
            return $result;
        
    }
    
    function deleteSchedule($gcode,$school_year = NULL)
    {
        ($school_year == NULL ? $this->session->school_year: $school_year);
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('sched_gcode', $gcode);
        if($this->db->delete('c_schedule')):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveTime($day_id, $time_from, $time_to, $school_year = NULL)
    {
        ($school_year == NULL ? $this->session->school_year: $school_year);
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('day_id', $day_id);
        $this->db->where('time_from', $time_from);
        $this->db->where('time_to', $time_to);
        $q = $this->db->get('c_time');
        if($q->num_rows()>0):
            $result = $q->row()->ctime_id;
        else:
            $array = array('time_from'=> $time_from, 'time_to'=>$time_to, 'day_id'=>$day_id);
            $this->db->insert('c_time', $array);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            $result = $this->db->insert_id();
        endif;
        return $result;
    }
    
    function getSchedCollege($from, $to, $day)
    {
        $this->db->select('*');
        $this->db->from('schedule_college');
        if($from!=NULL):
            $this->db->where('time_fr', $from);
            $this->db->where('time_to', $to);
            $this->db->where('day', $day);
        endif;
        $this->db->join('sched_rooms', 'schedule_college.room_id = sched_rooms.rm_id');
        $this->db->join('c_subjects', 'schedule_college.subject_id = c_subjects.s_id');
        $this->db->join('c_courses', 'schedule_college.course_id = c_courses.course_id');
        $this->db->join('sched_time', 'schedule_college.sched_time_id = sched_time.time_id');
        $q = $this->db->get();
        return $q;
    }
    
    function getCollegeSched($time_id, $day_id)
    {   
        
        $this->db->join('c_schedule','c_time.ctime_id = c_schedule.sched_time_id', 'left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        if($time_id!=NULL):
             $this->db->where('time_from', $time_id);
        endif;
        $this->db->where('day_id', $day_id);
        $q = $this->db->get('c_time');
        return $q;
    }
    
    function createCollegeSched($details, $time_id, $day, $from, $to, $course, $room, $teacher, $subject)
    {
        if($subject!=0):
            $this->db->where('day', $day);
            $this->db->where('room_id', $room); 
            $this->db->join('sched_time', 'schedule_college.sched_time_id = sched_time.time_id');
            $q = $this->db->get('schedule_college');
            if($q->num_rows()> 0):
                foreach ($q->result() as $r1):
                    if(strtotime($r1->time_fr) >= strtotime($from) && strtotime($from) < strtotime($r1->time_to)):
                        if(strtotime($to) > strtotime($r1->time_fr) && strtotime($to) <= strtotime($r1->time_to)):
                            $response = array(
                                'status' => FALSE,
                                'msg' => 'Sorry Room is Already in Use',
                            );
                            return json_encode($response);
                        else:
                            
                            $this->db->insert('schedule_college', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                            $response = array(
                                'status' => TRUE,
                                'msg' => 'Schedule Successfully Created time to',

                            );

                            return json_encode($response);
                        endif;
                    else:    
                        
                        $this->db->insert('schedule_college', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                        $response = array(
                            'status' => TRUE,
                            'msg' => 'Schedule Successfully Created time from',

                        );

                        return json_encode($response);
                    endif;    
                endforeach;
                
            else:
                $this->db->join('sched_time', 'schedule_college.sched_time_id = sched_time.time_id');   
                $this->db->where('day', $day);
                $this->db->where('subject_id', $subject);
                $qsub = $this->db->get('schedule_college');

                //check if Subject Exist
                if($qsub->num_rows() > 0):
                    $this->db->join('sched_time', 'schedule_college.sched_time_id = sched_time.time_id');   
                    $this->db->where('day', $day);
                    $this->db->where('subject_id', $subject);
                    $this->db->where('course_id', $course);
                    $qsub = $this->db->get('schedule_college');
                    if($qsub->num_rows() > 0):
                        $response = array(
                            'status' => FALSE,
                            'msg' => 'Sorry This Schedule Already Exist',
                        );
                        return json_encode($response);
                    else:
                        $this->db->insert('schedule_college', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                        $response = array(
                            'status' => TRUE,
                            'msg' => 'Schedule Successfully Created subject',

                        );

                        return json_encode($response);
                    endif;
                else:
                //if subject doesn't exist check if course exist
                    $this->db->join('sched_time', 'schedule_college.sched_time_id = sched_time.time_id');   
                    $this->db->where('day', $day);
                    $this->db->where('course_id', $course);
                    $qsub = $this->db->get('schedule_college');
                     if($qsub->num_rows() > 0):
                        $response = array(
                            'status' => FALSE,
                            'msg' => 'Sorry Course Already Exist',
                        );
                    else:
                        $this->db->insert('schedule_college', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                        $response = array(
                            'status' => TRUE,
                            'msg' => 'Schedule Successfully Created Course Add',

                        );
                    endif;
                    return json_encode($response);
                endif;
                       
                  
            endif;
        else:
            $this->db->insert('schedule_college', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                $response = array(
                    'status' => TRUE,
                    'msg' => 'Schedule Successfully Created 1',

                );

            return json_encode($response);
        endif;
        
    }
    
    function getTime($dept_id=NULL)
    {
        if($dept_id!=NULL):
            $this->db->where('department_id', $dept_id);
        endif;
        $q = $this->db->get('sched_time');
        return $q->result();
    }
    
    function addTime($details, $from, $to, $option)
    {
        $this->db->where('time_fr', $from);
        $this->db->where('time_to', $to);
        $this->db->where('department_id', $option);
        $q = $this->db->get('sched_time');
        if($q->num_rows()> 0):
            $result = array('msg' => 'Time Already Exist', 'status' => FALSE);
        else:
            $this->db->insert('sched_time', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            $result = array('msg' => 'Time Successfully Added', 'status' => TRUE);
        endif;
        return json_encode($result);
    }
    
    function deleteTime($id)
    {
        $this->db->where('time_id', $id);
        if($this->db->delete('sched_time')):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteSched($id)
    {
        $this->db->where('sched_id', $id);
        if($this->db->delete('schedule')):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getAllSchedule($from, $to, $day, $t_id, $section_id)
    {
        if($from!=NULL):
            $this->db->where('time_fr', $from);
            $this->db->where('time_to', $to);
            $this->db->where('day', $day);
        endif;
        if($t_id!=NULL):
            $this->db->where('t_id', $t_id);
        endif;
        if($section_id!=NULL):
            $this->db->where('schedule.section_id', $section_id);
        endif;
        $this->db->join('subjects', 'schedule.subject_id = subjects.subject_id');
        $this->db->join('section', 'schedule.section_id = section.section_id');
        $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
        $this->db->order_by('time_fr', 'ASC');
        $q = $this->db->get('schedule');
        return $q->result();
    }
   
    
    function createSched($details, $time_id, $day, $from, $to, $section, $room, $teacher, $subject)
    {
        if($subject!=0):
            $this->db->where('day', $day);
            if($room!=0):
               $this->db->where('room_id', $room); 
            endif;
            $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
            $q = $this->db->get('schedule');

            if($q->num_rows()> 0):
                foreach ($q->result() as $r1):
                    if(strtotime($r1->time_fr) >= strtotime($from) && strtotime($from) < strtotime($r1->time_to) ):
                        if(strtotime($to) > strtotime($r1->time_fr) && strtotime($to) <= strtotime($r1->time_to) ):
                            //check if same teacher
                            $this->db->where('day', $r1->day);
                            $this->db->where('sched_time_id', $time_id);
                            $this->db->where('section_id', $section);
                            if($room!=0):
                               $this->db->where('room_id', $room); 
                            endif;
                            $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
                            $qS = $this->db->get('schedule');

                            if($qS->num_rows() == 0):
                                $this->db->where('day', $r1->day);
                                $this->db->where('sched_time_id', $time_id);
                                if($room!=0):
                                   $this->db->where('room_id', $room); 
                                endif;
                                $this->db->where('t_id', $teacher);
                                $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
                                $qT = $this->db->get('schedule');

                                if($qT->num_rows() == 0):
                                    $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                                    $response = array(
                                        'status' => TRUE,
                                        'msg' => 'Schedule Successfully Created1',
                                    );
                                else:
                                    $response = array(
                                        'status' => FALSE,
                                        'msg' => 'Sorry, Teacher not Available.',
                                    );
                                endif;
                            else:
                                $response = array(
                                    'status' => FALSE,
                                     'msg' => 'Sorry, Section is already assign in this schedule.',
                                );
                            endif;

                            return json_encode($response);
                        else:
                                $this->db->where('day', $r1->day);
                                $this->db->where('sched_time_id', $time_id);
                                if($room!=0):
                                   $this->db->where('room_id', $room); 
                                endif;
                                $this->db->where('section_id', $section);
                                $this->db->where('t_id', $teacher);
                                $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
                                $qT = $this->db->get('schedule');

                                if($qT->num_rows() == 0):
                                    $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                                    $response = array(
                                        'status' => TRUE,
                                        'msg' => 'Schedule Successfully Created2',
                                    );
                                else:
                                    $response = array(
                                        'status' => FALSE,
                                        'msg' => 'Sorry, Teacher not Available.',
                                    );
                                endif;
                        endif;
                        return json_encode($response);
                    else:
                        $this->db->select('*');
                        $this->db->from('schedule');
                        $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');   
                        $this->db->where('day', $r1->day);
                        $this->db->where('section_id', $section);
                        $this->db->where('subject_id', $subject);
                        if($room!=0):
                           $this->db->where('room_id', $room); 
                        endif;
                        $qSub = $this->db->get();
                        if($qSub->num_rows() == 0):
                            $this->db->where('day', $r1->day);
                            $this->db->where('sched_time_id', $time_id);
                                if($room!=0):
                                   $this->db->where('room_id', $room); 
                                endif;
                                $this->db->where('t_id', $teacher);
                                $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
                                $qT = $this->db->get('schedule');

                                if($qT->num_rows() == 0):
                                   $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                                    $response = array(
                                        'status' => TRUE,
                                        'msg' => 'Schedule Successfully Created 3',
                                    );
                                else:
                                    $response = array(
                                        'status' => FALSE,
                                        'msg' => 'Sorry, Teacher not Available. 3',
                                    );
                                endif;
                        else:
                            $response = array(
                                'status' => FALSE,
                                'msg' => 'Sorry, Subject and Section already assigned',
                            );
                        endif;

                        return json_encode($response);
                    endif;
                endforeach;
            else:
                $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                $response = array(
                    'status' => TRUE,
                    'msg' => 'Schedule Successfully Created4',

                );

                return json_encode($response);
            endif;
        else:
            $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                $response = array(
                    'status' => TRUE,
                    'msg' => 'Schedule Successfully Created',

                );

                return json_encode($response);
        endif;
        
    }
    
    function createScheds($details, $day, $from, $to, $section, $room, $teacher)
    {
        $this->db->where('day', $day);
        if($room!=0):
           $this->db->where('room_id', $room); 
        endif;
       // $this->db->where('time_to <', $to);
        $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
        $q = $this->db->get('schedule');
        if($q->num_rows()> 0):
            foreach ($q->result() as $r1):
                if(strtotime($r1->time_fr) >= strtotime($from) && strtotime($from) < strtotime($r1->time_to) ):
                    if(strtotime($to) > strtotime($r1->time_fr) && strtotime($to) <= strtotime($r1->time_to) ):
                        //check if same teacher
                        $this->db->where('day', $r1->day);
                        $this->db->where('t_id', $teacher);
                        $this->db->where('section_id', $section);
                        if($room!=0):
                           $this->db->where('room_id', $room); 
                        endif;
                        $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');
                        $qT = $this->db->get('schedule');
                        if($qT->num_rows() == 0):
                            //$this->db->insert('schedule', $details);
                            $response = array(
                                'status' => FALSE,
                                'msg' => 'Schedule Successfully Created',
                            );
                        else:
                            $response = array(
                                'status' => FALSE,
                                'msg' => 'Sorry, Teacher Duplication Error',
                            );
                        endif;
                    else:
                        //$this->db->insert('schedule', $details);
                        $response = array(
                            'status' => TRUE,
                            'msg' => 'Schedule Successfully Created',
                        );
                    endif;
                else:
                    
                    $this->db->where('time_fr', $r1->time_fr);
                    $this->db->where('time_to', $r1->time_to);
                    $this->db->where('day', $r1->day);
                    $this->db->where('t_id', $teacher);
                    $this->db->where('section_id', $section);
                    if($room!=0):
                       $this->db->where('room_id', $room); 
                    endif;
                    $this->db->join('sched_time', 'schedule.sched_time_id = sched_time.time_id');   
                    $qT = $this->db->get('schedule');
                    if($qT->num_rows() == 0):
                        //$this->db->insert('schedule', $details);
                        $response = array(
                            'status' => FALSE,
                            'msg' => 'Schedule Successfully Created',
                        );
                    else:
                        $response = array(
                            'status' => FALSE,
                            'msg' => 'Sorry, Teacher Duplication Error',
                        );
                    endif;
                endif;
            endforeach;
        else:
            $this->db->insert('schedule', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            $response = array(
                'status' => TRUE,
                'msg' => 'Schedule Successfully Created',
                
            );
        endif;
        
        return json_encode($response);
    }
    
    function checkDateTime()
    {
        
    }
    
    function getRooms()
    {
        $q = $this->db->get('sched_rooms');
        return $q->result();
        
    }
    function addRooms($details, $room)
    {
        $this->db->where('room', $room);
        $q = $this->db->get('sched_rooms');
        if($q->num_rows()> 0):
            return FALSE;
        else:
            $this->db->insert('sched_rooms', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                
            return TRUE;
        endif;
    }
}

?>
