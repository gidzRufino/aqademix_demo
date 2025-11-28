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
class Opl_widgets_model extends CI_Model {
    //put your code here

    function getTasksByType($grade, $section, $subject, $type){
        $this->db->where('task_type', $type)
                            ->where('task_subject_id', $subject);
        if($grade != NULL):
            $this->db->where('task_grade_id', $grade);
        endif;
        $quizzes = $this->db->where('task_section_id', $section)
                            ->get('opl_tasks');
        $quizcount = $quizzes->num_rows();
        $submittedcount = 0;
        if($quizcount != 0):
            foreach($quizzes->result() AS $quiz):
                $submittedcount += $this->db->select('COUNT(ts_code) AS count')
                                            ->where('ts_task_id', $quiz->task_code)
                                            ->get('opl_task_submitted')->row()->count;
            endforeach;
        endif;
        return (array('total'=>$quizcount,'submitted'=>$submittedcount));
    }
    
    function getStudentOnlinePresent($section, $grade){
        return $this->db->select('COUNT(st_id) AS count')
                            ->join('otp_access', 'profile_students_admission.st_id = otp_access.otp_user', 'INNER')
                            ->where('profile_students_admission.grade_level_id', $grade)
                            ->where('profile_students_admission.section_id', $section)
                            ->where('otp_access.otp_code !=', '')
                            ->get('profile_students_admission')->row();
    }

    function mySubjects($user_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('subjects.subject_id as sub_id');
        $this->db->from('faculty_assign');
        $this->db->join('subjects', 'subjects.subject_id = faculty_assign.subject_id', 'left');
        $this->db->join('grade_level', 'grade_level.grade_id = faculty_assign.grade_level_id', 'left');
        $this->db->join('section', 'section.section_id = faculty_assign.section_id', 'left');
        if($user_id!=NULL):
            $this->db->where('faculty_assign.faculty_id', $user_id);
        else:
        //$this->db->group_by('sub_id');
        endif;
        if($school_year!=NULL):
          $this->db->where('faculty_assign.school_year', $school_year);
        endif;
        $query = $this->db->get();
        return $query->result();
    }
}
