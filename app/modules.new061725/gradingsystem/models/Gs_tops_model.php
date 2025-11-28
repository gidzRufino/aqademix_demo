<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gs_tops_model
 *
 * @author genesis
 */
class gs_tops_model extends CI_Model {
    //put your code here
    
    function getTopTenByGradeLevel($grade_id, $term, $school_year, $section_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select("SUM($term) as total");
        $this->db->select('profile_students.st_id as s_id');
        $this->db->from('gs_final_assessment');
        $this->db->join('section', 'gs_final_assessment.section_id = section.section_id', 'left');
        $this->db->join('profile_students', 'gs_final_assessment.st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id=profile.user_id', 'left');
         if($grade_id!=NULL):
             $this->db->where('section.grade_level_id', $grade_id);
         endif;
        
        $this->db->where('school_year', $school_year);
//        $this->db->where('is_validated', $grading);
        if($section_id!=NULL || $section_id!=0):
            $this->db->where('gs_final_assessment.section_id', $section_id);
        endif;
        $this->db->where('gs_final_assessment.subject_id !=', 20);
        $this->db->group_by('profile_students.st_id');
        $this->db->order_by('total', 'DESC');
        //$this->db->limit('20');
        $query = $this->db->get();
        return $query;
        
    }
    
    function checkGrades($st_id, $subject_id, $term)
    {
        $this->db->select('*');
        $this->db->from('gs_final_card');
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('grading', $term);
        $query = $this->db->get();
        if($query->num_rows()>0):
            return $query->row();
        else:
            return FALSE;
        endif;
        
    }
    
    function getTopTenPerSubject($level, $subject, $grading, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('section.grade_level_id');
        $this->db->select("$grading as total");
        $this->db->select('gs_final_assessment.st_id');
        $this->db->select('gs_final_assessment.section_id');
        $this->db->select('gs_final_assessment.subject_id');
        $this->db->select('gs_final_assessment.school_year');
        $this->db->from('gs_final_assessment');
        $this->db->join('section', 'gs_final_assessment.section_id = section.section_id', 'left');
        $this->db->join('profile_students', 'gs_final_assessment.st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id=profile.user_id', 'left');
        if($level!=NULL):
             $this->db->where('section.grade_level_id', $level);
         endif;
        
        $this->db->where('school_year', $school_year);
        if($subject!=NULL):
            $this->db->where('subject_id', $subject);
        endif;
        $this->db->order_by('total', 'DESC');
        $this->db->limit('10');
        $query = $this->db->get();
        return $query;
    }
    
    function getFinalTopTen($grade_id, $school_year)
    {
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students.st_id as stid');
        $this->db->select('profile_students_admission.grade_level_id as grade_level_id');
        $this->db->select('final_rating');
        $this->db->from('gs_final_card');
        $this->db->join('profile_students', 'gs_final_card.st_id = profile_students.st_id','left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id','left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        $this->db->where('profile_students_admission.school_year', $school_year);
        $this->db->where('grading', 0);
        $this->db->order_by('gs_final_card.final_rating', 'DESC');
        $this->db->limit(10);
        $q = $this->db->get();
        return $q;
    }
    
    function saveFinalRank($st_id, $total, $grade_id, $school_year)
    {
        
        $array = array(
            'st_id' => $st_id,
            'final_total' => $total,
            'grade_id' => $grade_id,
            'school_year' => $school_year
        );
        
        $this->db->where('st_id', $st_id);
        $this->db->where('grade_id', $grade_id);
        $this->db->where('school_year',$school_year);
        $q = $this->db->get('gs_final_rank');
        if($q->num_rows()> 0):   
            $this->db->where('st_id', $st_id);
            $this->db->where('grade_id', $grade_id);
            $this->db->where('school_year',$school_year);
            $this->db->update('gs_final_rank', $array);
        else:
            $this->db->insert('gs_final_rank', $array);
        endif;

        $this->db->select('*');
        $this->db->from('gs_final_rank');
        $this->db->where('grade_id', $grade_id);
        $this->db->where('school_year',$school_year);
        $this->db->order_by('final_total', 'ASC');
        $query = $this->db->get();
        $i = 0;
        foreach($query->result() as $r):
            $i = $i+1;
            $s = array(
                'rank' => $i,
            );
            $this->db->where('rank_id', $r->rank_id);
            $this->db->update('gs_final_rank', $s);
            
        endforeach;
            $this->db->where('st_id', $st_id);
            $this->db->where('grade_id', $grade_id);
            $this->db->where('school_year',$school_year);
            $return = $this->db->get('gs_final_rank');
        return $return->row();
    }
}

?>
