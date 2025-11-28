<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of search_model
 *
 * @author genesis
 */
class search_model extends CI_Model {
    //put your code here
    
    function assignToATeam($user_id, $team_id)
    {
        $this->db->where('user_id', $user_id);
        if($this->db->update('profile_students_c_admission', array('team_id' => $team_id))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getRawProfile($year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->where('profile_students_admission.school_year', $year);
        $q = $this->db->get();
        return $q->result();
    }
    
    function searchStudentAccountsK12($value, $year, $semester)
    {
        if($value!=""):
           
        $this->db = $this->eskwela->db($year);
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('profile_students_admission.admission_id');
        $this->db->select('profile_students_admission.status');
        $this->db->select('sex');
        $this->db->select('school_year');
        $this->db->select('semester');
        $this->db->select('rfid');
        $this->db->select('grade_level.level AS lvl');

        $this->db->from('profile');
        $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile.user_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id');

        $this->db->where('profile_students_admission.school_year', $year);
        ($semester!=NULL?$this->db->where('profile_students_admission.semester', $semester):"");
        $this->db->where('account_type', 5); 
        $this->db->like('lastname', $value, 'both');
        $this->db->order_by('lastname', 'ASC');
        $this->db->limit(30);

        $query = $this->db->get();
            
            
//               if($year!=NULL):
//                  $sql = "select esk_profile_students_admission.school_year, esk_grade_level.level as lvl, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, sex, esk_profile_students_admission.status, admission_id
//                  from esk_profile 
//                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
//                  inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
//                  inner join esk_grade_level on esk_profile_students_admission.grade_level_id =  esk_grade_level.grade_id
//                  where lastname like '%".$this->db->escape_like_str($value)."%' or firstname like '%".$this->db->escape_like_str($value)."%'
//                  and esk_profile_students_admission.school_year = '$year' and esk_profile_students_admission.semester = '$semester' GROUP BY esk_profile_students_admission.st_id
//                  and account_type = 5
//                  order by lastname ASC  ";
//                else:
//                    $year = $this->session->userdata('school_year');
//                    $sql = "select esk_profile_students_admission.school_year, esk_grade_level.level as lvl, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, sex, esk_profile_students_admission.status, admission_id
//                  from esk_profile 
//                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
//                  inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
//                  inner join esk_grade_level on esk_profile_students_admission.grade_level_id =  esk_grade_level.grade_id
//                  where lastname like '%".$this->db->escape_like_str($value)."%' or firstname like '%".$this->db->escape_like_str($value)."%'
//                  and esk_profile_students_admission.school_year = '$year'
//                  and account_type = 5
//                  order by lastname ASC  ";
//                endif;      
//                $this->db = $this->eskwela->db($year);
//                $query = $this->db->query($sql, array($value));
          else:
                
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students_admission.status as status');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('account_type');
                $this->db->select('grade_level.level as lvl');
                $this->db->from('profile_students');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('profile_students_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                
                $this->db->where('account_type', 5);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
    
    function searchStudentAccounts($value, $year, $sem)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('profile_students_c_admission.admission_id');
        $this->db->select('profile_students_c_admission.status');
        $this->db->select('sex');
        $this->db->select('short_code');
        $this->db->select('school_year');
        $this->db->select('semester');
        $this->db->select('rfid');

        $this->db->from('profile');
        $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');

        $this->db->where('profile_students_c_admission.school_year', $year);
        ($sem!=NULL?$this->db->where('profile_students_c_admission.semester', $sem):"");
        $this->db->where('account_type', 5); 
        $this->db->like('lastname', $value, 'both');
        $this->db->order_by('lastname', 'ASC');
        $this->db->limit(30);

        $query = $this->db->get();
        return $query->result();
    }
    
//    function searchStudentAccounts($value, $year=NULL)
//    {
//        if($value!=""):
//                if($year!=NULL):
//                        
//                else:
//                    $year = $this->session->userdata('school_year');
//                    $sql = "select esk_profile_students_c_admission.school_year, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, short_code, sex, esk_profile_students_c_admission.status, esk_c_courses.course_id,esk_c_courses.course, year_level, semester, admission_id
//                  from esk_profile 
//                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
//                  inner join esk_profile_students_c_admission on esk_profile.user_id = esk_profile_students_c_admission.user_id
//                  inner join esk_c_courses on esk_profile_students_c_admission.course_id =  esk_c_courses.course_id
//                  where lastname like '%".$this->db->escape_like_str($value)."%' or firstname like '%".$this->db->escape_like_str($value)."%'
//                  and esk_profile_students_c_admission.school_year = '$year'
//                  and account_type = 5
//                  group by esk_profile_students.user_id
//                  order by lastname ASC  ";
//                endif;      
//                $this->db = $this->eskwela->db($year);
//                $query = $this->db->query($sql, array($value));
//          else:
//                
//                $this->db->select('profile_students.st_id as st_id');
//                $this->db->select('profile.user_id as uid');
//                $this->db->select('profile_students_c_admission.status as status');
//                $this->db->select('lastname');
//                $this->db->select('firstname');
//                $this->db->select('middlename');
//                $this->db->select('level');
//                $this->db->select('account_type');
//                $this->db->from('profile_students');
//                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
//                $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
//                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
//                $this->db->order_by('lastname', 'ASC');
//                $this->db->limit(10);
//                
//                $this->db->where('account_type', 5);
//                $this->db->group_by('st_id');
//
//                $query = $this->db->get();
//        
//          endif;
//        return $query->result();
//        
//        
//    }
    function getCollegeStudents($option, $value, $year, $sem)
    {
        $sem == NULL?Modules::run('main/getSemester'):$sem;
        if($value!=""):
                $this->db = $this->eskwela->db($year);
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('profile_students_c_admission.year_level');
                $this->db->select('profile_students_c_admission.course_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students.st_id');
                $this->db->select('profile_students_c_admission.admission_id');
                $this->db->select('profile_students_c_admission.status');
                $this->db->select('sex');
                $this->db->select('short_code');
                $this->db->select('school_year');
                $this->db->select('semester');
                $this->db->select('rfid');
                $this->db->select('avatar');
                $this->db->select('team_id');
                
                $this->db->from('profile');
                $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
                $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');
                
                $this->db->where('profile_students_c_admission.school_year', $year);
                $this->db->where('profile_students_c_admission.semester', $sem);
                $this->db->where('account_type', 5); 
                $this->db->like($option, $value, 'both');
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(30);
                
                $query = $this->db->get();
               /* if($year!=NULL):
                    $sql = "select esk_profile_students_c_admission.school_year, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, short_code, sex, esk_profile_students_c_admission.status, esk_c_courses.course_id, esk_c_courses.course, year_level, semester, admission_id
                  from esk_profile 
                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  inner join esk_profile_students_c_admission on esk_profile.user_id = esk_profile_students_c_admission.user_id
                  inner join esk_c_courses on esk_profile_students_c_admission.course_id =  esk_c_courses.course_id
                  where esk_profile_students_c_admission.school_year = '$year'
                  and esk_profile_students_c_admission.semester = '$semester'
                  and $option like '%".$this->db->escape_like_str($value)."%' 
                  and account_type = 5
                  group_by esk_profile_students.user_id
                  order by lastname ASC  ";
                else:
                    $year = $this->session->userdata('school_year');
                    $sql = "select esk_profile_students_c_admission.school_year, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, short_code, sex, esk_profile_students_c_admission.status, esk_c_courses.course_id,esk_c_courses.course, year_level, semester, admission_id
                  from esk_profile 
                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  inner join esk_profile_students_c_admission on esk_profile.user_id = esk_profile_students_c_admission.user_id
                  inner join esk_c_courses on esk_profile_students_c_admission.course_id =  esk_c_courses.course_id
                  where esk_profile_students_c_admission.school_year = '$year'
                  and esk_profile_students_c_admission.semester = '$semester'
                  and $option like '%".$this->db->escape_like_str($value)."%' 
                  and account_type = 5
                  order by lastname ASC  ";
                endif;      
                $query = $this->db->query($sql, array($value)); */
          else:
                
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students_c_admission.status as status');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('account_type');
                $this->db->from('profile_students');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('profile_students_c_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                
                $this->db->where('account_type', 5);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
     function getStudents($option, $value, $year=NULL)
    {
        if($value!=""):
                if($year!=NULL):
                    if($year<$this->session->userdata('school_year')):
                        
                    else:
                        $sql = "select esk_profile_students_admission.school_year, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, level, section, sex, esk_section.section_id, esk_profile_students_admission.status, esk_section.grade_level_id 
                        from esk_profile 
                        left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                        inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                        left join esk_section on esk_profile_students_admission.section_id =  esk_section.section_id
                        left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                        where $option like '%".$this->db->escape_like_str($value)."%' 
                        and esk_profile_students_admission.school_year = '$year'
                        and account_type = 5
                        group_by esk_profile_students.user_id
                        order by lastname ASC";
                    endif;
                    
                else:
                  $sql = "select esk_profile_students_admission.school_year, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, level, section, sex, esk_section.section_id, esk_profile_students_admission.status, esk_section.grade_level_id 
                  from esk_profile 
                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  left join esk_section on esk_profile_students_admission.section_id =  esk_section.section_id
                  left join esk_grade_level on esk_section.grade_level_id =  esk_grade_level.grade_id
                  where $option like '%".$this->db->escape_like_str($value)."%' 
                  and account_type = 5
                  group_by esk_profile_students.user_id
                  order by lastname ASC";
                endif;      
                $query = $this->db->query($sql, array($value));
          else:
                
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students_admission.status as status');
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
                $this->db->group_by('profile_students.user_id');
                $this->db->limit(10);
                
                $this->db->where('account_type', 5);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
    
    
    function getStudent($option, $value, $year=NULL, $settings)
    {       if($year<$this->session->userdata('school_year')):
                $result = $this->getPreviousStudent($option, $value, $year, $settings);
                return $result;
            else:
                $this->db->select('*');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students.parent_id as pid');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('section');
                $this->db->select('profile.sex as sex');
                $this->db->from('profile_students');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
                $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
                $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
                $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
                $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
                $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
                $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
                $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
                $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
                $this->db->like($option, $value, 'both'); 
                $query = $this->db->get();
                return $query->result();
            endif;
            
    }
    
    function getPreviousStudent($option, $value, $year, $settings)
    {
        $db_details = $this->eskwela->db($year);
        $db_details->select('*');
        $db_details->select('profile_students.st_id as uid');
        $db_details->select('profile_students.parent_id as pid');
        $db_details->select('profile.user_id as u_id');
        $db_details->select('lastname');
        $db_details->select('firstname');
        $db_details->select('middlename');
        $db_details->select('level');
        $db_details->select('section');
        $db_details->select('profile.sex as sex');
        $db_details->from('profile_students');
        $db_details->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $db_details->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $db_details->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $db_details->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $db_details->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $db_details->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $db_details->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $db_details->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $db_details->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $db_details->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $db_details->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        $db_details->where('profile_students_admission.school_year', $year);
        if ($option == 'profile_students_admission.section_id') {
            $db_details->where($option, $value);
        } else {
            $db_details->like($option, $value, 'both');
        } 
        $db_details->order_by('lastname', 'ASC');
        $db_details->group_by('profile_students_admission.user_id');
        $query = $db_details->get();
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
    
    function getStdByGradeLevel($gradeSection, $value, $year = NULL) {
        
            $this->db->select('*');
            $this->db->select('profile_students_admission.status as status');
            $this->db->select('profile_students.st_id as uid');
            $this->db->select('profile.user_id as u_id');
            $this->db->select('lastname');
            $this->db->select('firstname');
            $this->db->select('middlename');
            $this->db->select('level');
            $this->db->select('sex');
            $this->db->select('section');
            $this->db->select('section.section_id');
            $this->db->from('profile_students_admission');
            $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id','inner');
            $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
            $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
            $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
            $this->db->where('grade_id', $value);
            $this->db->group_by('profile.user_id');

            $query = $this->db->get();

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
