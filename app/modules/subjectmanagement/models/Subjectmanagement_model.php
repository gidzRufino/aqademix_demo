<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author genesis
 */
class subjectmanagement_model extends MX_Controller {
    //put your code here
    
    function addSubject($subject, $subjectArray)
    {
        $this->db->where('subject', $subject);
        $q = $this->db->get('subjects');
        if($q->num_rows() > 0):
            return 2;
        else:
            if($this->db->insert('subjects', $subjectArray)):
                return 1;
            else:
                return 0;
            endif;
        endif;
    }
    
    function getSHSubjectDetails($subject_id, $grading, $school_year)
    {
        $semester = ($grading>2?2:1);
        $this->db->where('sh_sub_id', $subject_id);
        $this->db->where('semester', $semester);
        $this->db->where('school_year', $school_year);
        $this->db->join('subjects','sh_subjects.sh_sub_id = subjects.subject_id','left');
        $q = $this->db->get('sh_subjects');
        return $q->row();
    }
    
    function deleteSubject($sub_id)
    {
        $this->db->where('subject_id', $sub_id);
        if($this->db->delete('subjects')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getStrandByID($id){
        $this->db->where('st_id',$id);
        return $this->db->get('sh_strand')->row();
    }
            
    function makeCore($subject_id)
    {
        $this->db->where('subject_id', $subject_id);
        $q = $this->db->get('subjects');
        if($q->row()->is_core):
            $details = array('is_core' => 0);
        else:
            $details = array('is_core' => 1);
        endif;
            $this->db->where('subject_id', $subject_id);
            $this->db->update('subjects', $details);
    }
    
    function removeSHSubject($sem, $strand_id, $gradeLevel, $subject_id)
    {
        $this->db->where('semester', $sem);
        $this->db->where('grade_id', $gradeLevel);
        $this->db->where('strand_id', $strand_id);
        $this->db->where('sh_sub_id', $subject_id);
        
        if($this->db->delete('sh_subjects')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getAllSHSubjects($gradeLevel, $sem, $strand_id)
    {
        $this->db->where('semester', $sem);
        $this->db->where('grade_id', $gradeLevel);
        $this->db->where('strand_id', $strand_id);
        $this->db->join('subjects','sh_subjects.sh_sub_id = subjects.subject_id','left');
        $q = $this->db->get('sh_subjects');
        return $q->result();
    }
    
    function getSHSubjects($gradeLevel, $sem, $strand_id, $core)
    {
        $this->db->where('semester', $sem);
        $this->db->where('grade_id', $gradeLevel);
        $this->db->where('strand_id', $strand_id);
        if($core!=NULL):
            $this->db->where('is_core', 1);
        else:
            $this->db->where('is_core', 0);
        endif;
        $this->db->join('subjects','sh_subjects.sh_sub_id = subjects.subject_id','left');
        $q = $this->db->get('sh_subjects');
        return $q->result();
    }
            
    function saveSeniorHighSubjects($details, $strand_id, $sem, $gradeLevel, $subject_id)
    {
        $this->db->where('semester', $sem);
        $this->db->where('grade_id', $gradeLevel);
        $this->db->where('strand_id', $strand_id);
        $this->db->where('sh_sub_id', $subject_id);
        $q = $this->db->get('sh_subjects');
        if($q->num_rows()==0):
            $this->db->insert('sh_subjects', $details);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function updateSHstrand($id, $details)
    {
        $this->db->where('st_id', $id);
        $this->db->update('sh_strand', $details);
        return;
    }
    
    function getSHStrandsByName($strand)
    {
        $this->db->where('short_code', $strand);
        $q = $this->db->get('sh_strand');
        return $q->row();
    }
            
    function getSHOfferedStrand()
    {
        $this->db->where('offered', 1);
        $q = $this->db->get('sh_strand');
        return $q->result();
    }
            
    function getSHStrands()
    {
        $q = $this->db->get('sh_strand');
        return $q->result();
    }
    
    function checkSHSSubjectPerLevel($grade_level, $sub_id)
    {
        $this->db->where('sub_id', $sub_id);
        $this->db->where('grade_level_id', $grade_level);
        $query = $this->db->get('subjects_settings');
        if($query->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function editSubject($sub_id, $details)
    {
        $this->db->where('subject_id', $sub_id);
        if($this->db->update('subjects', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function searchSubject($subject)
    {
        $this->db->like('subject', $subject);
        $this->db->limit(10);
        $q = $this->db->get('subjects');
        return $q->result();
    }
    
    function getSubjects($limit=NULL, $offset=NULL)
    {
        $this->db->select('*');
        $this->db->from('subjects');
        if($limit!=NULL||$offset=NULL){
           $this->db->limit($limit, $offset);	
        }
        $query = $this->db->get();
        return $query;
    }
    
    function collegeSubjects()
    {
        $q = $this->db->get('c_subjects');
        return $q->result();
    }
    
    function addCollegeSubject($subjects, $scode)
    {
        $this->db->where('sub_code', $scode);
        $q = $this->db->get('c_subjects');
        if($q->num_rows()>0):
            return FALSE;
        else:
            if($this->db->insert('c_subjects', $subjects)):
                return TRUE;
            else:
                return FALSE;
            endif;
            
        endif;
    }
    
    function getCourse()
    {
        $q = $this->db->get('c_courses');
        return $q->result();
    }
    function addCourse($details, $section)
    {
        $this->db->where('course', $section);
        $q = $this->db->get('c_courses');
        if($q->num_rows()> 0):
            return FALSE;
        else:
            $this->db->insert('c_courses', $details);
            return TRUE;
        endif;
    }
    
    function addSection($details, $section)
    {
        $this->db->where('section', $section);
        $q = $this->db->get('section');
        if($q->num_rows()> 0):
            return FALSE;
        else:
            $this->db->insert('section', $details);
            return TRUE;
        endif;
    }


    function getDepartment()
    {
        $q = $this->db->get('level_department');
        return $q->result();
    }
    
    function deleteSection($section_id)
    {
        $this->db->where('section_id', $section_id);
        $this->db->delete('section');
        return;
    }

    function checkSubjectSettings($subj_id) {
        $this->db->where('sub_id', $subj_id);
        return $this->db->get('subjects_settings');
    }
}

?>
