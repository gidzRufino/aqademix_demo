<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_models
 *
 * @author genesisrufino
 */
class Opl_variables_model extends MX_Controller {
    //put your code here

    function sendReply($data, $school_year){
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('opl_comments', $data);
        if($this->db->affected_rows() != 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getReplies($com_to, $school_year){
        $this->db = $this->eskwela->db($school_year);
        return $this->db->where('com_isReply', 1)
                        ->where('com_replyto_id', $com_to)
                        ->order_by('com_timestamp', 'ASC')
                        ->limit(10)
                        ->get('opl_comments');
    }

    function fetchLesson($subject_id,$grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('ou_subject_id', $subject_id);
        $this->db->where('ou_grade_level_id', $grade_id);
        return $this->db->get('opl_units')->result();
    }
    
    function getDiscussionList($em_id, $grade_id, $section_id, $subject_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select("opl_discussion.*");
        $this->db->select("COUNT(esk_opl_comments.com_id) AS com_count");
        $this->db->select("(CHAR_LENGTH(esk_opl_discussion.dis_read_by) - CHAR_LENGTH(REPLACE(esk_opl_discussion.dis_read_by, ',', '')) + 1) AS reader_count");
        $this->db->join('opl_comments', 'opl_discussion.dis_sys_code = opl_comments.com_to', 'LEFT');
        if($em_id!=NULL):
            $this->db->where('dis_author_id', $em_id);
            if($grade_id!=NULL):
                $this->db->where('dis_grade_id', $grade_id);
            endif;
        else:
            $this->db->where('dis_grade_id', $grade_id);
            if($section_id!=NULL):
                $this->db->where('dis_section_id', $section_id);
            endif;
            $this->db->where('dis_subject_id', $subject_id);
        endif;
        $this->db->group_by("opl_discussion.dis_id");
        $q = $this->db->get('opl_discussion');
        return $q->result();
    }
            
    function getStudents($grade_level, $section_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id','left');
        $this->db->join('profile_address_info','profile.add_id = profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        $this->db->where('section_id', $section_id);
        $this->db->where('grade_level_id', $grade_level);
        $this->db->where('profile_students_admission.status', 1);
        $q = $this->db->get('profile_students_admission');
        return $q->result();
    }
    
    function getComments($com_to, $com_type, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('com_to', $com_to);
        $this->db->where('com_type', $com_type);
        $this->db->where('com_isReply', 0);
        $this->db->order_by('com_timestamp', 'DESC');
        $this->db->limit(20);
        return $this->db->get('opl_comments')->result();
    }
    
    function getBasicEmployee($em_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('lastname, firstname, avatar, employee_id');
        $this->db->where('employee_id', $em_id);
        $this->db->join('profile','profile_employee.user_id = profile.user_id','left');
        return $this->db->get('profile_employee')->row();
        
    }
    
    function getStudentBasicEdInfoByStId($st_id, $school_year )
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('lastname, firstname, avatar, profile_students.st_id, profile.user_id, grade_level_id, profile_students_admission.section_id, school_year, semester, str_id');
        $this->db->where('profile_students.st_id', $st_id);
        $this->db->join('profile','profile_students.user_id = profile.user_id','left');
        $this->db->join('profile_students_admission','profile_students.st_id = profile_students_admission.st_id','left');
        return $this->db->get('profile_students')->row();
        
    }
    
    function getSubmittedTask($task_id, $school_year, $student_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('opl_tasks','opl_task_submitted.ts_task_id = opl_tasks.task_code', 'left');
        ($task_id==NULL?'':$this->db->where('ts_task_id', $task_id));
        ($student_id==NULL?'':$this->db->where('ts_submitted_by', $student_id));
        return $this->db->get('opl_task_submitted');
        
    }
    
    function getTaskType()
    {
        return $this->db->get('opl_task_type')->result();
    }
    
    function getTaskByCode($code, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('task_lesson_id', $code);
        return $this->db->get('opl_tasks')->result();
    }
    
    function getAllUnits($employee_id, $school_year,$grade_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('ou_owners_id', $employee_id);
        ($grade_id!=NULL?$this->db->where('ou_grade_level_id', $grade_id):"");
        $q = $this->db->get('opl_units');
        return $q->result();
    }
    
    function getGradeLevel($grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        ($grade_id==NULL?"":$this->db->where('grade_id', $grade_id));
        $q = $this->db->get('grade_level');
        return ($grade_id==NULL?$q->result():$q->row());
    }
    
    function getClassDetails($gradeLevel, $section, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('grade_level_id', $gradeLevel);
        $this->db->where('section_id', $section);
        $this->db->join('grade_level','section.grade_level_id = grade_level.grade_id', 'left');
        $q = $this->db->get('section');
        return $q->row();
    }
    
    function getSubjectById($subject_id)
    {
        return $this->db->where('subject_id', $subject_id )
                        ->get('subjects')->row();
    }
    
    function getSubjects()
    {
        $this->db->select('*');
        $this->db->from('subjects');
        $query = $this->db->get();
        return $query->result();
    }

    function searchTask($task, $school_year){
        
        $this->db = $this->eskwela->db($school_year);
        $this->db->like("task_title", $task, "both");

        $query = $this->db->get('opl_tasks');
        return $query->result();

    }
}
