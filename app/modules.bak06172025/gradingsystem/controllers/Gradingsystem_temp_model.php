<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gradingsystem_model
 *
 * @author genesis
 */
class gradingsystem_temp_model extends CI_Model{
    //put your code here
    
    
    function subjectWComponents()
    {
        $this->db->where('school_year', $this->session->userdata('school_year'));
        $this->db->where('component_id !=', 0);
        $this->db->join('subjects', 'gs_asses_category.subject_id = subjects.subject_id','inner');
        $this->db->group_by('subjects.subject_id');
        $q = $this->db->get('gs_asses_category');
        return $q->result();
    }
    
    function getComponents()
    {
        $q = $this->db->get('gs_component');
        return $q->result();
    }
    
    function addComponent($component)
    {
        $this->db->where('component', $component);
        $q = $this->db->get('gs_component');
        if($q->num_rows()==0):
            $this->db->insert('gs_component', array('component'=>$component));
            return json_encode(array('status'=>TRUE, 'id' => $this->db->insert_id()));
        else:
            return json_encode(array('status' => FALSE));
        endif;
    }
    function addBHSettings($details, $table)
    {
        if($this->db->insert($table, $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getCustomizedList($gid)
    {
        if($gid!=NULL):
            $this->db->where('bhs_group_id', $gid);
        endif;
            $this->db->order_by('bhs_group_id','ASC');
            $this->db->order_by('bhs_id','ASC');
        $q = $this->db->get('gs_behavior_rate_customized');
        return $q;
    }
    
    function getListOfValues($gid, $id)
    {
        if($gid!=NULL):
            $this->db->where('bh_group', $gid);
        endif;
        if($id!=NULL):
            $this->db->where('bh_id', $id);
        endif;
        $q = $this->db->get('gs_behavior_rate');
        return $q;
    }
    
    function getCoreValues()
    {
        $q = $this->db->get('gs_behavior_core_values');
        return $q->result();
    }
    
    function saveSpecialization($details, $user_id, $spec_id, $school_year)
    {
        $this->db->where('spec_user_id', $user_id);
        $this->db->where('spec_taken_id', $spec_id);
        $this->db->where('spec_school_year', $school_year);
        $exist = $this->db->get('gs_spec_students');
        if($exist->num_rows()>0):
            return json_encode(array('status'=>FALSE,'msg'=>'Student is already enrolled into a specialization'));
        else:
            $this->db->insert('gs_spec_students', $details);
            return json_encode(array('status'=>TRUE, 'msg'=>'Successfully enrolled in a specialization'));
        endif;
    }
            
    function editSettings($column, $value)
    {
        $updates = array($column=>$value);
        $this->db->where('school_year', $this->session->userdata('school_year'));
        if($this->db->update('gs_settings', $updates)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getBGBEquivalent()
    {
        $query = $this->db->get('gs_bgb_letter_grade');
        return $query;
    }
    
    function recordInGr($details, $in_gr_id, $term, $year, $st_id, $sub_id)
    {
        
        $this->db->where('subject_id', $sub_id);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $term);
        $this->db->where('school_year', $year);
        $this->db->where('in_gr_id', $in_gr_id);
        $check = $this->db->get('gs_in_gr_rating');
        
        if($check->num_rows()>0){
            $this->db->where('subject_id', $sub_id);
            $this->db->where('st_id', $st_id);
            $this->db->where('term', $term);
            $this->db->where('school_year', $year);
            $this->db->where('in_gr_id', $in_gr_id);
            $this->db->update('gs_in_gr_rating', $details);
            
            return FALSE;
        }else{
            
            if($this->db->insert('gs_in_gr_rating', $details))
            {
               return TRUE; 
            }else{
                return FALSE;
            } 
        }
    }
    function getInGr_details($sub_id)
    {
        $this->db->where('in_gr_sub_id', $sub_id);
        $q = $this->db->get('gs_in_gr');
        return $q->result();
    }
    function getInGr($sub_id, $st_id, $term, $year, $in_gr_id)
    {
        $this->db->where('subject_id', $sub_id);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $term);
        $this->db->where('school_year', $year);
        if($in_gr_id!=NULL):
            $this->db->where('in_gr_id', $in_gr_id);
        endif;
        $q = $this->db->get('gs_in_gr_rating');
        
        if($in_gr_id!=NULL):
          return $q->row();
        else:
          return $q->result(); 
        endif;
    }
    function getAssessResult($assess_id)
    {
        $this->db->select('raw_score');
        $this->db->select('no_items');
        $this->db->select('gs_raw_score.assess_id as as_id');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment','gs_assessment.assess_id = gs_raw_score.assess_id', 'left');
        $this->db->where('gs_raw_score.assess_id', $assess_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function checkIfCardLock($st_id, $sy)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $sy);
        $this->db->where('is_final', 1);
        $this->db->where('subject_id', 0);
        $q = $this->db->get('gs_final_card');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function lockFinalCard($st_id, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $array = array('is_final'=> 1);
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $sy);
        $this->db->where('subject_id', 0);
        if($this->db->update('gs_final_card', $array)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function getPromotionalReport($grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('grade_id', $grade_id);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_summary_rplp');
          
        return $query;
    }
    
    function saveGeneralAverage($final, $section_id, $subject_id, $st_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $this->db->update('gs_final_assessment', $final);
    }
        
    function saveFinalAverage($final, $st_id, $subject_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_final_card');
        if($query->num_rows()>0):
            $this->db->where('st_id', $st_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->where('school_year', $school_year); 
            $this->db->update('gs_final_card', $final); 
        else:
            $this->db->insert('gs_final_card', $final);
        endif;
        
    }
        
    
    function savePromotion($section_id, $grade_id, $column, $value, $school_year)
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
         $details = array(
             'grade_id' => $grade_id,
             'section_id' => $section_id,
             $column => $value,
             'school_year' => $school_year
         );
         
         $this->db->where('section_id', $section_id);
         $this->db->where('school_year', $school_year);
         $query = $this->db->get('gs_summary_rplp');
         
         if($query->num_rows()>0):
            $this->db->where('section_id', $section_id);
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_summary_rplp', $details);
         else:
            $this->db->insert('gs_summary_rplp', $details);
         endif;
    }
    
    function saveGS($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_settings');
        if($q->num_rows()>0):
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_settings', $details);
        else:
            $this->db->insert('gs_settings', $details);
        endif;
        return;
    }
    
    function getDO_settings($subject_id=NULL, $school_year = NULL)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        
        $sql = "Select * from esk_gs_asses_category left join esk_subjects on esk_gs_asses_category.subject_id = esk_subjects.subject_id"
                . "where gs_asses_category.school_year = $school_year group by ";
        $this->db->select_max('gs_asses_category.subject_id');
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('subjects', 'gs_asses_category.subject_id = subjects.subject_id', 'inner');
        $this->db->where('gs_asses_category.school_year', $school_year);
        if($subject_id!=NULL):
            $this->db->where('subjects.subject_id', $subject_id);
        else:
            $this->db->group_by('gs_asses_category.subject_id');
        endif;
        $q = $this->db->get('gs_asses_category');
        return $q->result();
        
    }
    function getSettings($school_year = NULL)
    {
        if($school_year==NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_settings');
        return $query->row();   
    }
    
    function deleteKPUPS($name)
    {
        $this->db->where('code', $name);    
        if($this->db->delete('gs_asses_category')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function modifyKPUPS($name, $value, $sub_id = NULL)
    {
        $this->db->where('category_name', $name);
        $this->db->where('subject_id', $sub_id);
        $query = $this->db->get('gs_asses_category');
        $details = array(
                'category_name' => $name,
                'weight'        => round($value/100, 2),
                'department'    => 1,
        );
        if($query->num_rows()>0):
            
            $this->db->where('subject_id', $sub_id);
            $this->db->where('category_name', $name);
            $this->db->update('gs_asses_category', $details);
        else:
            $detail = array(
                'category_name' => $name,
                'weight'        => round($value/100, 2),
                'department'    => 1,
                'subject_id'    => $sub_id
            );
            $this->db->insert('gs_asses_category', $detail);
        endif;
          
          
          
    }
    function saveTransmutation($details)
    {
        $this->db->where('id', 1);
        if($this->db->update('gs_settings', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getClassRecord($subject_id, $section_id, $term)
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('section', 'profile_students.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'grade_level.grade_id = section.grade_level_id', 'left');
        $this->db->join('gs_assessment', 'profile.user_id = gs_assessment.faculty_id');
        $this->db->join('subjects', 'subjects.subject_id = gs_assessment.subject_id', 'left');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        
        
        //$this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        if($section_id!=""){
           $this->db->where('gs_assessment.section_id', $section_id); 
        }
        if($subject_id!="")
        {
           $this->db->where('gs_assessment.subject_id', $subject_id);
        }
           $this->db->where('gs_asses_category.code !=', 9 );
        $this->db->where('profile.account_type', 5);
        $this->db->where('term', $term);
        $query = $this->db->get();
        return $query;
    }
    function saveAssessment($details)
    {
        //$this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->insert('gs_assessment', $details);
        
        $return = array(
            'status' => true,
            'id'     => $this->db->insert_id(),
        );
        return $return;
    }
    
    function getAssessment($section_id, $subject_id, $qcode, $term, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('gs_assessment');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->join('section', 'section.section_id = gs_assessment.section_id', 'left');
       // $this->db->join('grade_level', 'grade_level.grade_id = section.grade_level_id', 'left');
        $this->db->join('subjects', 'subjects.subject_id = gs_assessment.subject_id', 'left');
        if($section_id!=""){
           $this->db->where('gs_assessment.section_id', $section_id); 
        }
        if($subject_id!="")
        {
           $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        if($qcode!=""){
           
           $this->db->where('assess_id', $qcode);
        }
        if($term!=""){
           
           $this->db->where('term', $term);
        }
        if($school_year!=NULL):
            $this->db->where('gs_assessment.school_year', $school_year);
        endif;
        $this->db->order_by('assess_date', 'DESC'); 
        //$this->db->where('gs_asses_category.code !=', 9 );
        $query = $this->db->get();
        return $query;
    }
    
    function getIndividualAssessment($st_id, $subject_id, $qcode, $term)
    {
        $this->db->select('*');
        $this->db->from('gs_assessment');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->join('gs_raw_score', 'gs_assessment.assess_id = gs_raw_score.assess_id', 'left');
        $this->db->join('profile_students', 'gs_raw_score.st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('subjects', 'subjects.subject_id = gs_assessment.subject_id', 'left');
        if($st_id!=""){
           $this->db->where('gs_raw_score.st_id', $st_id); 
        }
        if($subject_id!="")
        {
           $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        if($qcode!=""){
           
           $this->db->where('gs_assessment.quiz_cat', $qcode);
        }
        if($term!=""){
           
           $this->db->where('term', $term);
        }
        
        $this->db->order_by('assess_date', 'DESC');
       // $this->db->where('gs_asses_category.code !=', 9 );
        $query = $this->db->get();
        return $query;
    }
    
    function getIndividualAssessmentForPrint($student_id, $subject_id, $qcode, $term)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment','gs_assessment.assess_id = gs_raw_score.assess_id', 'left');
        $this->db->where('st_id', $student_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('quiz_cat', $qcode);
        $this->db->where('term', $term);
        $query = $this->db->get();
        return $query;
    }
    
    function getAssessmentBySectionForPrint($section_id, $subject_id, $qcode, $term)
    {
        $this->db->select('*');
        $this->db->from('gs_assessment');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->join('subjects', 'subjects.subject_id = gs_assessment.subject_id', 'left');
       
        if($section_id!="")
        {
           $this->db->where('gs_assessment.section_id', $section_id);
        }
        if($subject_id!="")
        {
           $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        if($qcode!=""){
           
           $this->db->where('gs_assessment.quiz_cat', $qcode);
        }
        if($term!=""){
           
           $this->db->where('term', $term);
        }
        
        $this->db->order_by('assess_date', 'DESC');
       // $this->db->where('gs_asses_category.code !=', 9 );
        $query = $this->db->get();
        return $query;
    }
    
    function recordScore($student, $score, $quizCode, $transResult)
    {
        //$this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $check = $this->getRecordScore($student,$quizCode);
        $data = array(
            'st_id' => $student,
            'raw_score' => $score,
            'assess_id' => $quizCode,
            'equivalent' => $transResult,

        );
        if($check){
            $this->db->where('st_id', $student);
            $this->db->where('assess_id', $quizCode);
            $this->db->update('gs_raw_score', $data);
            
            return FALSE;
        }else{
            
            if($this->db->insert('gs_raw_score', $data))
            {
               return TRUE; 
            }else{
                return FALSE;
            } 
        }
    }
    
        
    function getAssessmentPerTeacher($faculty_id, $section_id, $subject_id, $qcode, $term, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('gs_assessment');
        $this->db->where('faculty_id', $faculty_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        if($qcode!=""):
            $this->db->where('quiz_cat', $qcode);
        endif;
        $this->db->where('term', $term);
        $this->db->where('school_year', $school_year);
        $this->db->order_by('assess_date', 'ASC');
        $query = $this->db->get();
        
        return $query;
    }
    
    
    function getRecordScore($student,$quizCode)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
        $this->db->where('st_id', $student);
        $this->db->where('assess_id', $quizCode);
        $this->db->order_by('raw_score', 'desc');
        
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    function getNumItems($assess_id)
    {
        $this->db->where('assess_id', $assess_id);
        $q = $this->db->get('gs_assessment');
        return $q->row();
    }
    
    function getRawScore($student_id, $qcode)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
       // $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        if($student_id!=''):
            $this->db->where('st_id', $student_id);
        endif;
        $this->db->where('assess_id', $qcode);
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function getTotalScoreByStudent($student_id, $qcode, $term, $subject_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(equivalent) as total');
        $this->db->select('SUM(raw_score) as score');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->where('gs_assessment.term', $term);
        if($subject_id!=NULL){
            $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        $this->db->where('st_id', $student_id);
        $this->db->where('gs_asses_category.code', $qcode);
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function getEachScoreByStudent($student_id, $qcode, $term, $subject_id, $option=NULL, $section_id)
    {
        $this->db->select('*');
        if($option!=NULL):
            $this->db->select('SUM(no_items) as TPS');
        endif;
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->where('gs_assessment.term', $term);
        $this->db->where('st_id', $student_id);
        if($subject_id!=NULL){
            $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        if($section_id!=NULL){
            $this->db->where('gs_assessment.section_id', $section_id);
        }
        $this->db->where('gs_assessment.quiz_cat', $qcode);
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function saveRawScore($details)
    {
        $this->db->insert('gs_raw_score', $details);
        return true;
    }
    
    function getRawScoreSort($sortBy, $qcode, $control)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
        $this->db->join('profile', 'gs_raw_score.st_id = profile.user_id', 'left');
        $this->db->where('assess_id', $qcode);
        $this->db->order_by($sortBy, $control);
        $query = $this->db->get();
        return $query;
    }
    
    function getAssessCategoryWithoutPreTest($dept=NULL)
    {
        $this->db->select('*');
        $this->db->from('gs_asses_category');
        if($dept!=NULL):
            $this->db->where('department', $dept);
        endif;
        $query = $this->db->get();
        return $query->result();
    }
    
    function getAssessCatBySubject($subject, $school_year=NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('gs_asses_category');
        $this->db->where('subject_id', $subject); 
        if($school_year!=NULL):
          $this->db->where('school_year', $school_year);  
        endif;
        $query = $this->db->get();
        return $query;
    }
    
    function getAssessCategory($subject_id, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('gs_asses_category');
        if($subject_id!=NULL):
          $this->db->where('subject_id', $subject_id);  
        endif;
        if($school_year!=NULL):
          $this->db->where('school_year', $school_year);  
        endif;
        
        $query = $this->db->get();
        return $query->result();
    }
    
   function getQuarterSettings()
    {
        $query = $this->db->get('settings_quarter');
        return $query->result();
    }
    
    function getWeightSettings()
    {
//        $query = $this->db->get('settings_passing_rate');
//        return $query->row();
    }
    
    function getSectionBySubject($subject_id)
    {
         $this->db->select('*');
        $this->db->from('faculty_assign');
        $this->db->where('department', $subject_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getBGBLetterGrade($numberGrade)
    {
        $query = $this->db->get('gs_bgb_letter_grade');
        return $query;
    }
    
    function getLetterGrade($numberGrade)
    {
        $query = $this->db->get('gs_letter_grade');
        return $query;
    }


    function checkPartialAssessment($st_id, $section_id, $subject_id, $school_year)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $result = $this->db->get('gs_final_assessment');
        
        if($result->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updatePartialAssessment($st_id, $section_id, $subject_id, $school_year, $data)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $this->db->update('gs_final_assessment', $data);
        return TRUE;
    }
    
    function savePartialAssessment($details)
    {
        $this->db->insert('gs_final_assessment', $details);
        return true;
    }
    
    function getPartialAssessment($st_id, $section_id, $subject_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('gs_final_assessment');
        $this->db->where('st_id', $st_id);
        if($section_id!=NULL):
            $this->db->where('section_id', $section_id);
        endif;
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    function getPreTestResult($student_id, $term, $section_id, $subject_id)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        if($student_id!=''):
            $this->db->where('st_id', $student_id);
        endif;
        $this->db->where('gs_assessment.subject_id', $subject_id);
        $this->db->where('gs_assessment.section_id', $section_id);
        $this->db->where('gs_assessment.term', $term);
        $this->db->where('gs_asses_category.code', 9 );
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function getHighLowScore($orderBy, $term, $section_id, $subject_id)
    {
        $this->db->select('*');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_asses_category', 'gs_assessment.quiz_cat = gs_asses_category.code', 'left');
        $this->db->where('gs_assessment.subject_id', $subject_id);
        $this->db->where('gs_assessment.section_id', $section_id);
        $this->db->where('gs_assessment.term', $term);
        $this->db->where('gs_asses_category.code', 9 );
        $this->db->order_by('raw_score', $orderBy);
        $query = $this->db->get();
        return $query->row();
    }
    
    function deleteAssessment($qcode)
    {
        $this->db->where('assess_id', $qcode);    
        $this->db->delete('gs_assessment');
        
        $this->db->where('assess_id', $qcode);    
        $this->db->delete('gs_raw_score');
        return;
    }
    
    function editAssessment($qcode, $data)
    {
        $this->db->where('assess_id', $qcode);
        $this->db->update('gs_assessment', $data);
        return TRUE;
    }
    
    function lockAssessment($qcode, $data)
    {
        $this->db->where('assess_id', $qcode);
        $this->db->update('gs_assessment', $data);
    }
    
    function validateGrade($data, $st_id, $subject_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->update('gs_final_assessment', $data);
        return TRUE;
    }
    
    function isGradeValidated($st_id, $subject_id, $term, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('grading', $term);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_final_card');
        
        if($query->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteFinalGrade($st_id, $subject_id, $term, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('st_id', $st_id);    
        $this->db->where('subject_id', $subject_id);    
        $this->db->where('grading', $term);    
        $this->db->where('school_year', $sy);    
        $this->db->delete('gs_final_card');
        return true;
    }
    
    function saveFinalGrade($details, $st_id, $subject_id, $term, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);    
        $this->db->where('subject_id', $subject_id);    
        $this->db->where('grading', $term);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_final_card');
        if($query->num_rows()>0):
            $this->db->where('st_id', $st_id);    
            $this->db->where('subject_id', $subject_id);    
            $this->db->where('grading', $term);
            $this->db->where('school_year', $school_year);
            $this->db->delete('gs_final_card');
        endif;
        $this->db->insert('gs_final_card', $details);
        return true;
    }
    
    function isFinalAssessmentValidated($st_id, $sub_id,$school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $sub_id);
        $q = $this->db->get('gs_final_assessment');
        return $q->row();
    }
    
        
    function getFinalAverage($st_id, $subject_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_final_card');
        if($q->num_rows()> 0):
            if($q->row()->final_rating!=0):
                return $q->row()->final_rating;
            endif;
        else:
            return 0;
        endif;
    }
    function getAllFinalGrade($grade_id, $section_id, $term, $subject)
    {
        $this->db->select('gs_final_assessment.school_year as sy');
        $this->db->select('profile_students_admission.grade_level_id as gid');
        $this->db->select($term);
        $this->db->select('final');
        $this->db->from('gs_final_assessment');
        $this->db->join('profile_students_admission', 'profile_students_admission.section_id = gs_final_assessment.section_id','left');
        $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        $this->db->where('profile_students_admission.status', 1);
        if($section_id!=NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        if($subject!=NULL):
            $this->db->where('gs_final_assessment.subject_id', $subject);
        endif;
        $q = $this->db->get();
        return $q;
    }
    
    function getFinalGrade($st_id, $sub_id, $term, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        if($sub_id!=""):
           $this->db->where('subject_id', $sub_id); 
        endif;
        $this->db->where('grading', $term);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_final_card');
        return $query;
        
    }
    
    function getGradeForCard($st_id, $sub_id,$school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $sub_id); 
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_final_card');
        return $query;
        
    }
    
    function getBH($gs_used)
    {
        //$this->db = $this->eskwela->db($gs_used);
        if($gs_used!=NULL):
            $this->db->where('gs_used', $gs_used);
        else:
            $this->db->where('gs_used', 1);
        endif;
        $query = $this->db->get('gs_behavior_rate');
        return $query->result();
        
    }
    
    function ifBhExist($st_id,$term, $school_year, $bh_id )
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('bh_id', $bh_id);
        $this->db->where('grading', $term);
        $this->db->where('school_year', $school_year);
        
        $query = $this->db->get('gs_final_bh_rate');
        if($query->num_rows()>0):
            return TRUE;
        else: 
            return FALSE;
        endif;
        
    }
    
    function updateBH($behavior,$st_id,$term, $school_year, $bh_id )
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->where('st_id', $st_id);
        $this->db->where('bh_id', $bh_id);
        $this->db->where('grading', $term);
        $this->db->where('school_year', $school_year);
       $this->db->update('gs_final_bh_rate', $behavior);
    }
    
    function insertBH($details)
    {
        $this->db->insert('gs_final_bh_rate', $details);
        return true;
    }
    
    function getBHRating($st_id,$term, $school_year, $bh_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        if($bh_id!=NULL):
            $this->db->where('bh_id', $bh_id);
        endif;
        $this->db->where('grading', $term);
        $this->db->where('school_year', $school_year);
        
        $query = $this->db->get('gs_final_bh_rate');
        
        return $query;
    }
    
    function ifRemarkExist($st_id,$grading, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $grading);
        $this->db->where('school_year', $school_year);
        
        $query = $this->db->get('gs_card_remarks');
        if($query->num_rows()>0):
            return TRUE;
        else: 
            return FALSE;
        endif;
    }
    
    function updateRemarks($remarks, $st_id, $grading, $school_year )
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $grading);
        $this->db->where('school_year', $school_year);
       $this->db->update('gs_card_remarks', $remarks);
    }
    
    function insertRemarks($details)
    {
        $this->db->insert('gs_card_remarks', $details);
        return true;
    }
    
    function getCardRemarks($st_id,$term, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $term);
        $this->db->where('school_year', $school_year);
        
        $query = $this->db->get('gs_card_remarks');
        
        return $query;
    }
    
    function getAssessmentById($assess_id)
    {
        $this->db->select('code');
        $this->db->select('category_name');
        $this->db->from('gs_asses_category');
        $this->db->where('code', $assess_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getFinalCardByLevel($st_id, $level)
    {
        $this->db->select('*');
        $this->db->select('subjects.subject_id as s_id');
        $this->db->from('gs_final_assessment');
        $this->db->join('section','gs_final_assessment.section_id = section.section_id', 'left');
        $this->db->join('grade_level','section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('subjects','gs_final_assessment.subject_id = subjects.subject_id', 'left');
        $this->db->where('st_id', $st_id);
        $this->db->where('levelCode', $level);
        $this->db->order_by('subjects.subject_id','ASC');
        $query = $this->db->get();
        
        if($query->num_rows()>0):
            return $query;
        else:
            return FALSE;
        endif;
    }
    
}
