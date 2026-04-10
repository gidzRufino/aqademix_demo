<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of academic_model
 *
 * @author genesis
 */
class academic_model extends CI_Model {
    //put your code here

function getBHRate(){
        return $this->db->get('gs_behavior_rate')->result();
    }
    
    function getAssessment($id, $term, $subject_id)
    {
        $this->db->where('term', $term);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('faculty_id', $id);
        $q = $this->db->get('gs_assessment');
        return $q->result();
    }
    
    function getTotalRawScoreSubmitted($id, $term)
    {
        $this->db->select('raw_score');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment','gs_assessment.assess_id = gs_raw_score.assess_id', 'left');
        $this->db->where('gs_assessment.faculty_id', $id);
        ($term==NULL?"":$this->db->where('gs_assessment.term', $term));
        $q = $this->db->get();
        return $q;
    }
    function getEmployeeWithSubject()
    {
        $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->join('subjects', 'subjects.subject_id = faculty_assign.subject_id', 'left');
        $this->db->join('profile_employee', 'faculty_assign.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->group_by('faculty_id');
        $this->db->order_by('lastname','ASC');
        $q = $this->db->get();
        return $q;
    }
    
    function getSpecificSubjectAssignment($user_id, $section_id, $subject_id, $school_year)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->where('faculty_id', $user_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        if($school_year!=NULL):
          $this->db->where('faculty_assign.school_year', $school_year);
        endif;
        $query = $this->db->get();
        return $query->row();
    }
    
    function getStudentWspecializedSubject($specs_id, $school_year)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('gs_spec_students');
        $this->db->join('gs_specialization','gs_spec_students.spec_taken_id = gs_specialization.specialization_id', 'left');
        $this->db->join('profile', 'gs_spec_students.spec_user_id = profile.user_id','left');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id','left');
        $this->db->where('spec_taken_id', $specs_id);
        $q = $this->db->get();
        return $q;
    }
    
    function getAssignmentByLevel($gradelevel, $school_year, $section = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->join('subjects', 'subjects.subject_id = faculty_assign.subject_id', 'left');
        $this->db->join('grade_level', 'grade_level.grade_id = faculty_assign.grade_level_id', 'left');
        $this->db->join('section', 'section.section_id = faculty_assign.section_id', 'left');
        $this->db->join('profile_employee', 'faculty_assign.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        if($school_year!=NULL):
          $this->db->where('faculty_assign.school_year', $school_year);
        endif;
        $this->db->order_by('lastname', 'asc');
        if($gradelevel!=NULL)
        {
          $this->db->where('faculty_assign.grade_level_id', $gradelevel);
          //$this->db->group_by('grade_level.grade_id');
          
        }
        if($section!=NULL)
        {
          $this->db->where('faculty_assign.section_id', $section);
          
        }
        
          //$this->db->group_by('subjects.subject_id');
        $query = $this->db->get();
        return $query;
        
    }
    function getBasicInfo($id, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->where('profile_employee.employee_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function searchTeacher($value)
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'inner');
        $this->db->like('LOWER(lastname)', strtolower($value), 'both');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getCollegeSubjects($id)
    {
        $this->db->select('*');
        $this->db->from('c_subjects');
        if($id!=NULL):
            $this->db->where('s_id', $id);
        endif;
        $query = $this->db->get();
        if($id!=NULL):
            return $query->row();
        else:    
            return $query->result();
        endif;
    }
    
    function getSubjects()
    {
        $this->db->select('*');
        $this->db->from('subjects');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getSubjectId($subject)
    {
        $this->db->where('subject', $subject);
        $q = $this->db->get('subjects');
        if($q->num_rows()>0):
            $this->db->select('*');
            $this->db->from('subjects');
            $this->db->where('subject', $subject);
            $query = $this->db->get();
            return $query->row()->subject_id;
        else:
            $code = $this->eskwela->codeCheck('subjects', 'subject_id', $this->eskwela->code());
            $this->db->insert('subjects', array('subject_id'=>$code, 'subject'=>$subject));
            return $code;
        endif;
    }
    
    function mySubjects($user_id, $school_year, $opt = NULL)
    {
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
        ($opt != NULL ? $this->db->group_by('faculty_assign.subject_id') : '');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getAssignment($user_id, $school_year = NULL)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->join('profile_employee', 'faculty_assign.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('subjects', 'subjects.subject_id = faculty_assign.subject_id', 'left');
        $this->db->join('grade_level', 'grade_level.grade_id = faculty_assign.grade_level_id', 'left');
        $this->db->join('section', 'section.section_id = faculty_assign.section_id', 'left');
        $this->db->join('schedule', 'schedule.sched_id = faculty_assign.schedule_id', 'left');
        if($school_year!=NULL):
          $this->db->where('faculty_assign.school_year', $school_year);
        endif;
        $this->db->order_by('lastname', 'asc');
        if($user_id!=NULL)
        {
          $this->db->where('faculty_assign.faculty_id', $user_id);
          $this->db->order_by('grade_level.grade_id', 'asc');
        }
        $query = $this->db->get();
        return $query;
    }

    function deleteAssignment($ass_id)
    {
        $this->db->select('schedule_id');
        $this->db->from('faculty_assign');
        $this->db->where('ass_id', $ass_id); 
        $query = $this->db->get();
        $query1 = $query->result();
        foreach ($query1 as $q){
            $sched_id = $q->schedule_id;
        }
        
        $this->db->where('sched_id', $sched_id);    
        $this->db->delete('schedule');
        
        $this->db->where('ass_id', $ass_id);    
        $this->db->delete('faculty_assign'); 
        return;
    }
    
    function checkAssignment($subject, $gradelevel, $section, $school_year=NULL)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject);
        $this->db->where('grade_level_id', $gradelevel);
        $this->db->where('section_id', $section);
        if($school_year!=NULL):
            $this->db->where('school_year', $school_year);
        endif;
        
        $query = $this->db->get('faculty_assign');

        if($query->num_rows()== 1)
        {
                return 1;
        }
    }
    
    function setAssignment($data)
    {

        $this->db->insert('faculty_assign', $data);
        return;
        
    }

function getSubjectsPerGradeLvl($id){
        $this->db->select('*');
        $this->db->from('subjects_settings');
        $this->db->join('subjects','subjects.subject_id = subjects_settings.sub_id','left');
        $this->db->where('grade_level_id',$id);
        return $this->db->get()->result();
    }

    function getSpecificSubjects($subject_id)
    {
        $this->db->select('*');
        $this->db->from('subjects');
        $this->db->where('subject_id', $subject_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }
    
    function getSubjectTeacher($subject_id, $section_id, $school_year)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->join('profile_employee', 'faculty_assign.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('section_id', $section_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getSubjectPerLevel($grade_id)
    {
        $this->db->select('*');
        $this->db->from('subjects_settings');
        $this->db->where('grade_level_id', $grade_id);
        $this->db->order_by('order', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getSHSubjectID($gradeID, $term, $strand) {
        $this->db->where('grade_id', $gradeID);
        $this->db->where('semester', $term);
        $this->db->where('strand_id', $strand);
        return $this->db->get('sh_subjects')->result();
    }
    
    function saveAdvisory($advisory, $level, $section, $year)
    {
        $this->db->where('grade_id', $level);
        $this->db->where('section_id', $section);
        $this->db->where('school_year', $year);
        $q = $this->db->get('advisory');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('advisory', $advisory); 
            return TRUE;
        endif;     
    }
    
    function updateEmployeePosition($userid)
    {
        $data = array(
                'position_details' => 1
            ); 
        $this->db->where('employee_id', $userid); 
        $this->db->update('profile_employee', $data);
        return;
    }
    
    function getAdvisory($uid,$section, $year)
    {
        $this->db->select('*');
        $this->db->select('advisory.grade_id as grd_id');
        $this->db->from('advisory');
        $this->db->join('grade_level', 'advisory.grade_id = grade_level.grade_id', 'left');
        $this->db->join('section', 'advisory.section_id = section.section_id', 'left');
        $this->db->join('profile_employee', 'advisory.faculty_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        if($year!=NULL):
            $this->db->where('advisory.school_year', $year);
        endif;
        if($uid!=NULL){
           $this->db->where('advisory.faculty_id', $uid); 
        }
        if($section!=NULL)
        {
          $this->db->where('advisory.section_id', $section);
        }

        $query = $this->db->get();
        return $query;
            
    }
    
    function deleteAdvisory($uid, $adv_id)
    {
        $this->db->where('adv_id', $adv_id);  
        $this->db->where('faculty_id', $uid);    
        $this->db->delete('advisory');
        
        return TRUE;
    }

function getAdviser($sec,$grdID,$sy){
        $this->db->select('*');
        $this->db->from('advisory');
        $this->db->join('profile_employee','profile_employee.employee_id = advisory.faculty_id','left');
        $this->db->join('profile','profile.user_id = profile_employee.user_id','left');
        $this->db->where('section_id',$sec);
        $this->db->where('grade_id',$grdID);
        $this->db->where('school_year',$sy);
        return $this->db->get()->row();
    }
    
    function getSectionAssign($user_id, $school_year = NULL){
        $this->db->join('section','section.section_id = faculty_assign.section_id','left');
        $this->db->join('grade_level','grade_level.grade_id = section.grade_level_id','left');
        $this->db->where('faculty_assign.faculty_id',$user_id);
        $this->db->group_by('faculty_assign.section_id');
        $query = $this->db->get('faculty_assign');
        return $query->result();        
    }
    
    function getSubjectPerSection($faculty_id, $grade_id, $section_id){
        $this->db->select('*');
        $this->db->select('faculty_assign.subject_id as subj_id');
        $this->db->where('faculty_id', $faculty_id);
        $this->db->where('grade_level_id', $grade_id);
        $this->db->where('section_id', $section_id);
        $this->db->join('subjects','subjects.subject_id = faculty_assign.subject_id','left');
        return $this->db->get('faculty_assign')->result();
    }
   
}

