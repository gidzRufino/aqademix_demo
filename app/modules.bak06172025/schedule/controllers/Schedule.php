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
    
    function getSchedulePerSubject($s_id)
    {
        $this->db->join('c_schedule','c_time.ctime_id = c_schedule.sched_time_id', 'left');
        $this->db->join('sched_rooms', 'c_schedule.room_id = sched_rooms.rm_id','left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('c_subjects_per_course.spc_sub_id', $s_id);
        $q = $this->db->get('c_time');
        return $q->result();
    }
    
    function checkSched($room_id, $from, $to, $day_id)
    {
        $this->db->where('day_id', $day_id);
        $this->db->where('time_from', $from);
        $time = $this->db->get('c_time');
        if($time->num_rows()>0):
            foreach($time->result() as $t):
                if($from==$t->time_from):
                    $time_id = $t->ctime_id;
                    $this->db->where('sched_time_id', $time_id);
                    $this->db->where('room_id', $room_id);
                    $sched = $this->db->get('c_schedule');
                    if($sched->num_rows()> 0):
                        return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                    else:
                        return json_encode(array('status'=>TRUE, 'time'=>'Room is available - less than input','time_id'=> $time_id));
                    endif;
                else:
                    if($from > $t->time_from && $from < $t->time_to):
                        $time_id = $t->ctime_id;
                        $this->db->where('sched_time_id', $time_id);
                        $this->db->where('room_id', $room_id);
                        $sched = $this->db->get('c_schedule');
                        if($sched->num_rows()> 0):
                            return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                        else:
                            return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is equal to input','time_id'=> $time_id));
                        endif;
                    else:
                        if($from < $t->time_from && $to >= $t->time_from):
                            $time_id = $t->ctime_id;
                            $this->db->where('sched_time_id', $time_id);
                            $this->db->where('room_id', $room_id);
                            $sched = $this->db->get('c_schedule');
                            if($sched->num_rows()> 0):
                                return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                            else:
                                return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is greater than input ','time_id'=> $time_id));
                            endif;
                        else:
                            $time_id = $t->ctime_id;
                            return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is greater than input','time_id'=> $time_id));
                        endif;
                    endif;
                endif;
            endforeach;
        else:    
            $this->db->where('day_id', $day_id);
            $this->db->where('time_from', $from);
            $time = $this->db->get('c_time');
            if($time->num_rows()>0):
                foreach($time->result() as $t):
                    if($from==$t->time_from):
                        $time_id = $t->ctime_id;
                        $this->db->where('sched_time_id', $time_id);
                        $this->db->where('room_id', $room_id);
                        $sched = $this->db->get('c_schedule');
                        if($sched->num_rows()> 0):
                            return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                        else:
                            return json_encode(array('status'=>TRUE, 'time'=>'Room is available - less than input','time_id'=> $time_id));
                        endif;
                    else:
                        if($from > $t->time_from && $from < $t->time_to):
                            $time_id = $t->ctime_id;
                            $this->db->where('sched_time_id', $time_id);
                            $this->db->where('room_id', $room_id);
                            $sched = $this->db->get('c_schedule');
                            if($sched->num_rows()> 0):
                                return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                            else:
                                return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is equal to input','time_id'=> $time_id));
                            endif;
                        else:
                            if($from < $t->time_from && $to >= $t->time_from):
                                $time_id = $t->ctime_id;
                                $this->db->where('sched_time_id', $time_id);
                                $this->db->where('room_id', $room_id);
                                $sched = $this->db->get('c_schedule');
                                if($sched->num_rows()> 0):
                                    return json_encode(array('status'=>FALSE, 'time'=>'Room is not available','time_id'=> $time_id));
                                else:
                                    return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is greater than input ','time_id'=> $time_id));
                                endif;
                            else:
                                $time_id = $t->ctime_id;
                                return json_encode(array('status'=>TRUE, 'time'=>'Room is available - db is greater than input','time_id'=> $time_id));
                            endif;
                        endif;
                    endif;
                endforeach;
            else:
                $time_id = $t->ctime_id;
                return json_encode(array('status'=>TRUE, 'time'=>'no schedule yet','time_id'=> $time_id));
            endif;
        endif;
        
        
    
//        if($time->num_rows()>0):
//            return json_encode(array('status'=>FALSE));
//        else:
//            return json_encode(array('status'=>TRUE));
//        endif;
        
    }
    function getSchedule($sched)
    {
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('sched_time_id', $sched);
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function saveSchedule($sched_time, $room_id, $spc_id,  $color_code, $section_id = NULL, $school_year=NULL)
    {
        
        if($section_id==NULL):
            $section_id = 0;
        endif;
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
            $insert = array(
                'sched_time_id' => $sched_time, 
                'room_id'       => $room_id, 
                'cs_spc_id'     => $spc_id, 
                'section_id'    => $section_id, 
                'school_year'   => $school_year,
                'color_code'   => '#'.$color_code,
                );
            $this->db->insert('c_schedule', $insert);
            //$result = array('status' => TRUE, 'id'=>  $this->db->insert_id());
            return;
//        if($school_year==NULL):
//            $school_year = $this->session->userdata('school_year');
//        endif;
//        if($section_id==NULL):
//            $section_id = 0;
//        endif;
//        $this->db->where('room_id', $room_id);
//        $this->db->where('cs_spc_id', $spc_id);
//        $this->db->where('section_id', $section_id);
//        $this->db->where('school_year', $school_year);
//        $q = $this->db->get('c_schedule');
//        if($q->num_rows()==0):
//            $insert = array(
//                'sched_time_id' => $sched_time, 
//                'room_id'       => $room_id, 
//                'cs_spc_id'     => $spc_id, 
//                'section_id'    => $section_id, 
//                'school_year'   => $school_year);
//            $this->db->insert('c_schedule', $insert);
//            $result = array('status' => TRUE, 'id'=>  $this->db->insert_id());
//        else:
//            $result = array('status'=>FALSE, 'id'=>  $q->row()->sched_id);
//        endif;
//        return json_encode($result); 
        
    }
    
    function saveTime($day_id, $time_from, $time_to)
    {
        $this->db->where('day_id', $day_id);
        $this->db->where('time_from', $time_from);
        $this->db->where('time_to', $time_to);
        $q = $this->db->get('c_time');
        if($q->num_rows()>0):
            $result = $q->row()->ctime_id;
        else:
            $array = array('time_from'=> $time_from, 'time_to'=>$time_to, 'day_id'=>$day_id);
            $this->db->insert('c_time', $array);
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
                            $response = array(
                                'status' => TRUE,
                                'msg' => 'Schedule Successfully Created time to',

                            );

                            return json_encode($response);
                        endif;
                    else:    
                        
                        $this->db->insert('schedule_college', $details);
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
            $result = array('msg' => 'Time Successfully Added', 'status' => TRUE);
        endif;
        return json_encode($result);
    }
    
    function deleteTime($id)
    {
        $this->db->where('time_id', $id);
        if($this->db->delete('sched_time')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteSched($id)
    {
        $this->db->where('sched_id', $id);
        if($this->db->delete('schedule')):
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
                $response = array(
                    'status' => TRUE,
                    'msg' => 'Schedule Successfully Created4',

                );

                return json_encode($response);
            endif;
        else:
            $this->db->insert('schedule', $details);
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
            return TRUE;
        endif;
    }
}

?>
