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
class Gradingsystem_model extends CI_Model {
    //put your code here
    
    function getFinalGrade($st_id, $course_id, $subject_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('gsa_st_id', $st_id);
        $this->db->where('gsa_sub_id', $subject_id);
        $this->db->where('gsa_course_id', $course_id);
        $this->db->where('gsa_sem', $semester);
        $this->db->where('gsa_term_id', 0);
        $this->db->where('gsa_school_year', $school_year);
        $q = $this->db->get('c_gs_final_grade');
        return $q->row();
    }
    
    function getTeacherPerSubject($section_id, $school_year)
    {
        if($school_year!=NULL):
            $this->db = $this->eskwela->db($school_year);
        endif;
        $this->db->where('section_id', $section_id);
        $q = $this->db->get('c_schedule');
        return $q->row();
    }
    
    function updateFinalGrade($details, $st_id, $subject_id, $semester, $sy, $term, $course_id)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('gsa_st_id', $st_id);
        $this->db->where('gsa_sub_id', $subject_id);
        $this->db->where('gsa_course_id', $course_id);
        $this->db->where('gsa_sem', $semester);
        $this->db->where('gsa_term_id', $term);
        $this->db->where('gsa_school_year', $sy);
        if($this->db->update('c_gs_final_grade', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveFinalGrade($finalGradeDetails, $st_id, $term_id, $subject_id, $faculty_id, $school_year, $semester)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('gsa_term_id', $term_id);
        $this->db->where('gsa_st_id', $st_id);
        $this->db->where('gsa_school_year', $school_year);
        $this->db->where('gsa_sem', $semester);
        $this->db->where('gsa_sub_id', $subject_id);
        if($faculty_id!=NULL):
            $this->db->where('teacher_id', $faculty_id);
        endif;
        $q = $this->db->get('c_gs_final_grade');
        if($q->num_rows()==0):
            if($this->db->insert('c_gs_final_grade', $finalGradeDetails)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('gsa_term_id', $term_id);
            $this->db->where('gsa_st_id', $st_id);
            $this->db->where('gsa_school_year', $school_year);
            $this->db->where('gsa_sem', $semester);
            $this->db->where('gsa_sub_id', $subject_id);
            if($faculty_id!=NULL):
                $this->db->where('teacher_id', $faculty_id);
            endif;
            if($this->db->update('c_gs_final_grade', $finalGradeDetails)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function inValidateGrade($st_id, $term_id, $subject_id)
    {
        $this->db->where('student_id', $st_id);
        $this->db->where('term_id', $term_id);
        $this->db->where('subject_id', $subject_id);
        $q = $this->db->get('c_gs_raw_grades');
        if($q->num_rows()>0):
            $this->db->where('student_id', $st_id);
            $this->db->where('term_id', $term_id);
            $this->db->where('subject_id', $subject_id);
            if($this->db->update('c_gs_raw_grades', array('is_final' => 0))):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function validateGrade($st_id, $term_id, $subject_id)
    {
        $this->db->where('student_id', $st_id);
        $this->db->where('term_id', $term_id);
        $this->db->where('subject_id', $subject_id);
        $q = $this->db->get('c_gs_raw_grades');
        if($q->num_rows()>0):
            $this->db->where('student_id', $st_id);
            $this->db->where('term_id', $term_id);
            $this->db->where('subject_id', $subject_id);
            if($this->db->update('c_gs_raw_grades', array('is_final' => 1))):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function getTransmutation()
    {
        $q = $this->db->get('c_gs_transmutation');
        return $q->result();
    }
    
    function getRecordedGrade($st_id, $category, $term, $semester, $school_year, $subject_id, $final)
    {
        if($school_year!=NULL):
            $this->db = $this->eskwela->db($school_year);
        endif;
        $this->db->select('*');
        $this->db->select('c_gs_raw_grades.subject_id as sub_id');
        ($school_year!=NULL?$this->db->where('school_year', $school_year):"");
        ($semester!=NULL?$this->db->where('semester', $semester):"");
        ($subject_id!=NULL?$this->db->where('c_gs_raw_grades.subject_id', $subject_id):"");
        ($term!=NULL?$this->db->where('term_id', $term):$this->db->group_by('sub_id'));
        ($category!=NULL?$this->db->where('assess_cat_id', $category):"");
        $this->db->where('student_id', $st_id);
        ($final!=NULL?$this->db->where('c_gs_raw_grades.is_final', $final):"");
        $this->db->join('c_gs_term','c_gs_raw_grades.term_id = c_gs_term.gst_id','left');
        $this->db->join('c_gs_category','c_gs_raw_grades.assess_cat_id = c_gs_category.gsc_id','left');
        $q = $this->db->get('c_gs_raw_grades');
        return $q;
    }
    
    function updateGrade($grade_details, $st_id, $subject_id, $category, $term, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('term_id', $term);
        $this->db->where('assess_cat_id', $category);
        $this->db->where('student_id', $st_id);
        if($this->db->update('c_gs_raw_grades', $grade_details)):
            return TRUE;
        endif; 
        
    }
    
    function recordGrade($grade_details, $st_id, $subject_id, $category, $term, $semester)
    {
        $this->db->where('school_year', $this->session->userdata('school_year'));
        $this->db->where('semester', $semester);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('term_id', $term);
        $this->db->where('assess_cat_id', $category);
        $this->db->where('student_id', $st_id);
        $q = $this->db->get('c_gs_raw_grades');
        
        if($q->num_rows()==0):
            if($this->db->insert('c_gs_raw_grades', $grade_details)):
                return 3;
            endif;
        else:
            if($q->row()->is_final==0):
                $this->db->where('school_year', $this->session->userdata('school_year'));
                $this->db->where('semester', $semester);
                $this->db->where('subject_id', $subject_id);
                $this->db->where('term_id', $term);
                $this->db->where('assess_cat_id', $category);
                $this->db->where('student_id', $st_id);
                if($this->db->update('c_gs_raw_grades', $grade_details)):
                    return 2;
                endif;
            else:
                return 1;
            endif;
        endif;
        
    }
    
    function getTerm()
    {
        $this->db->where('is_used', 1);
        $q = $this->db->get('c_gs_term');
        return $q;
    }
    
    function getAssessCategory($subject_id=0)
    {
        $this->db->where('subject_id', $subject_id);
        $q = $this->db->get('c_gs_category');
        return $q;
        
    }        
            
    function getSubjectAssigned($teacher_id)
    {
        $this->db->where('faculty_id', $teacher_id);
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id','left');
        $this->db->join('c_subjects','c_section.sec_sub_id = c_subjects.s_id','left');
        $this->db->group_by('sched_gcode');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function getTeacherAssignment($teacher_id, $semester)
    {
        $this->db->where('semester', $semester);
        $this->db->where('faculty_id', $teacher_id);
        $this->db->join('c_subjects_per_course','c_subjects_per_course.spc_id = c_schedule.cs_spc_id','left');
        $this->db->join('c_subjects','c_subjects_per_course.spc_sub_id = c_subjects.s_id','left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id','left');
        $this->db->group_by('sched_gcode');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
   
    function searchSubjectAssign($teacher_id, $value=NULL)
    {
        $this->db->where('faculty_id', $teacher_id);
        //$this->db->like('sub_code', $value, 'both');
        $this->db->where('spc_sem_id', $this->session->userdata('semester'));
        $this->db->join('c_subjects_per_course','c_subjects_per_course.spc_id = c_schedule.cs_spc_id','left');
        $this->db->join('c_section','c_schedule.section_id = c_section.sec_id','left');
        $this->db->join('c_subjects','c_section.sec_sub_id = c_subjects.s_id','left');
        $this->db->group_by('sched_gcode');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
            
   function getStudentsPerSubject($teacher_id, $sched_code, $sem)
   {
        $this->db->where('sched_gcode', $sched_code);
        $this->db->where('faculty_id', $teacher_id);
        $this->db->group_by('sched_gcode');
        $q = $this->db->get('c_schedule');
        
        $this->db->where('spc_sem_id', $sem);
        $this->db->where('spc_id', $q->row()->cs_spc_id);
        $this->db->join('c_subjects_per_course', 'profile_students_c_load.cl_sub_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->join('profile', 'profile_students_c_load.cl_user_id = profile.user_id','left');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id','left');
        $query = $this->db->get('profile_students_c_load');
        
        return $query;
        
        
   }
}
