<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of search_model
 *
 * @author genesis
 */
class search_model extends CI_Model {
    //put your code here
    
    function getStudent($value, $year=NULL)
    {
        if($value!=""):
                if($year!=NULL):
                    $sql = "select esk_profile_students_admission.school_year, account_type, esk_profile.rfid, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, level, section, sex, esk_section.section_id, esk_profile_students.status, esk_section.grade_level_id 
                  from esk_profile 
                  left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  left join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  left join esk_section on esk_profile_students_admission.section_id =  esk_section.section_id
                  left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' 
                  and esk_profile_students_admission.school_year = '$year'
                  and account_type = 5 
                  or firstname like '%".$this->db->escape_like_str($value)."%'
                  and account_type = 5
                  order by lastname ASC  ";
                else:
                    $sql = "select esk_profile_students_admission.school_year, account_type, esk_profile.rfid, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, level, section, sex, esk_section.section_id, esk_profile_students.status, esk_section.grade_level_id 
                  from esk_profile 
                  left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  left join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  left join esk_section on esk_profile_students_admission.section_id =  esk_section.section_id
                  left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' 
                  and account_type = 5 
                  or firstname like '%".$this->db->escape_like_str($value)."%'
                  and account_type = 5
                  order by lastname ASC  ";
                endif;
                $query = $this->db->query($sql, array($value));
          else:
                
                $this->db->select('rfid');
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students.status as status');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('section');
                $this->db->select('section.section_id'); 
                $this->db->select('account_type');
                $this->db->from('profile_students');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('section', 'section.section_id = profile_students.section_id', 'left');
                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                
                $this->db->where('account_type', 5);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
    function getStudentBySection($value, $gradeSection, $year=NULL)
    {
          if($value!=""):
              $sql = "select esk_profile_students_admission.school_year, esk_profile.user_id as uid, esk_profile.rfid, esk_profile_students.st_id as st_id, lastname, firstname, middlename, level, section, sex, esk_section.section_id, esk_profile_students.status 
                  from esk_profile 
                  left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  left join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  left join esk_section on esk_profile_students.section_id =  esk_section.section_id
                  left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' 
                  and esk_profile_students_admission.school_year = '$year'
                  and esk_section.section_id = ?  
                  or firstname like '%".$this->db->escape_like_str($value)."%'
                  and  esk_section.section_id = ? 
                  order by lastname ASC  ";
                $query = $this->db->query($sql, array($gradeSection, $value));
          else:
                $this->db->select('*');
                $this->db->select('esk_profile_students.status as status');
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('esk_profile.user_id as uid');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('sex');
                $this->db->select('section');
                $this->db->select('section.section_id'); 
                $this->db->from('profile');
                $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
                $this->db->join('grade_level', 'profile_info.grade_level_id = grade_level.grade_id', 'left');
                $this->db->join('section', 'section.section_id = profile_info.st_section_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                
                $this->db->where('section_id', $gradeSection);

                $query = $this->db->get();
        
          endif;
          
        return $query->result();
        
        
    }
    function getStudentByGradeLevel($value, $gradeSection, $year=NULL)
    {
         if($value!=""):
              $sql = "select esk_profile_students_admission.school_year, esk_profile.user_id as uid,esk_profile.rfid, esk_profile_students.st_id as st_id, lastname, firstname, middlename, level, section, grade_id, sex, esk_profile_students.status 
                   from esk_profile 
                  left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  left join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  left join esk_section on esk_profile_students.section_id =  esk_section.section_id
                  left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' 
                  and esk_profile_students_admission.school_year = '$year'
                  and grade_id = ?      
                  or firstname like '%".$this->db->escape_like_str($value)."%'
                  and grade_id = ? 
                  order by lastname ASC  ";
                $query = $this->db->query($sql, array($gradeSection, $value));
          else:
                $this->db->select('*');
                $this->db->select('esk_profile_students.status as status');
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('esk_profile.user_id as uid');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('sex');
                $this->db->select('section');
                $this->db->select('section.section_id'); 
                $this->db->from('profile');
                $this->db->join('profile_info', 'profile.user_id = profile_info.u_id', 'left');
                $this->db->join('grade_level', 'profile_info.grade_level_id = grade_level.grade_id', 'left');
                $this->db->join('section', 'section.section_id = profile_info.st_section_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                
                $this->db->where('grade_id', $gradeSection);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
    
}

?>
