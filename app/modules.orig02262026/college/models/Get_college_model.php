<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Registrar
 *
 * @author genesis
 */
class get_college_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    function registrarLogs($limit, $offset)
    {
        $this->db->join('profile', 'profile.user_id = system_logs.account_id', 'left');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.employee_id', 'left');
        $this->db->where('account_id !=', 1);
        $this->db->where('log_title', 'REGISTRAR');
        $this->db->order_by('log_date','DESC');
        
        if($limit!=NULL||$offset=NULL){
                $this->db->limit($limit, $offset);	
        }
        $q = $this->db->get('system_logs');
        return $q;
    }
    
    function getStudentsForTES($limit, $year, $sem, $course=NULL, $level=NULL, $status =NULL )
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->select('profile_students.st_id as stid');
        $this->db->select('profile_students_c_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        if($year==NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;
        if($course!=NULL):
            $this->db->where('profile_students_c_admission.course_id', $course);
        endif;
        if($sem!=NULL):
            $this->db->where('semester', $sem);
        endif;
        if($level!=NULL):
            $this->db->where('year_level', $level);
        endif;
        
        $this->db->where('account_type', 5);
        $this->db->where('num_years >', 1);
        ($status!=NULL?$this->db->where('profile_students_c_admission.status', $status):"");
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $this->db->group_by('profile.user_id');

        if($limit!=NULL){
                $this->db->limit($limit);	
        }
		
        $query = $this->db->get();
        return $query->result();
    }
    
    
    function getStudentPerCourse($school_year, $sem, $year_level, $course_id)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->select('profile_students_c_admission.year_level');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('sex'); 
        $this->db->select('temp_bdate');
        $this->db->join('profile', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        if($course_id!=NULL):
            $this->db->where('profile_students_c_admission.course_id', $course_id);
        endif;
        if($sem!=NULL):
            $this->db->where('semester', $sem);
        endif;
        if($year_level!=0):
            $this->db->where('year_level', $year_level);
        endif;
        
        $this->db->where('account_type', 5);
        $this->db->where('profile_students_c_admission.status', 1);
        $this->db->order_by('year_level', 'ASC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
		
        $query = $this->db->get('profile_students_c_admission');
        return $query;
    }
    
    function getTeams($school_year, $sem, $team_id)
    {
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id','left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $school_year);
        $this->db->where('profile_students_c_admission.team_id', $team_id);
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->group_by('profile.user_id');
        $q = $this->db->get('profile_students_c_admission');
        return $q->result();
    }
    
    function updateEnrollmentStatus($st_id, $sy, $sem, $status)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $sy);
        $this->db->where('semester', $sem);
        if($this->db->update('profile_students_c_admission', $status)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getAdmissionDetails($st_id, $sem, $sy)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $sy);
        $q = $this->db->get('profile_students_c_admission');
        return $q->row();
    }
    
    
    
    function getMenuByPosition($menu_id = NULL)
    {
        if($menu_id!=NULL):
            $this->db->where('cma_department_access', $menu_id);
        endif;
        $q = $this->db->get('c_menu_access');
        return $q->result();
    }
    
    function getMenu($menu_id = NULL)
    {
        if($menu_id!=NULL):
            $this->db->where('cmenu_id', $menu_id);
        endif;
        $q = $this->db->get('c_menu');
        return $q->row();
    }
    
    function getMenuAccess($user_id=NULL)
    {
        if($user_id!=NULL):
            $this->db->where('cma_user_id', $user_id);
        endif;
        $q = $this->db->get('c_menu_access');
        return $q->row();
    }
    
    function deleteROStudent($user_id, $sy, $adm_id)
    {
        if($adm_id==NULL):
            $this->db->where('user_id', $user_id);
            $this->db->where('school_year', $sy);
        else:
            $this->db->where('admission_id', $adm_id);
            $this->db->where('school_year', $sy);
        endif;
        if($this->db->delete('profile_students_c_admission')):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getBasicInfo($user_id, $year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->where('profile_students.user_id', $user_id);
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $query = $this->db->get('profile_students');
        return $query->row();
    }
    
    function getBasicInfoBySTID($user_id, $year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->where('profile_students.st_id', $user_id);
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile_students');
        return $query->row();
    }
    
    function insertData($details, $table, $column=NULL, $value=NULL, $school_year = NULL)
    {
        $db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        if($column==NULL):
            if($db->insert($table, $details)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
               return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $db->where($column, $value);
            $q = $db->get($table);
            if($q->num_rows()>0):
                $db->where($column, $value);
                if($db->update($table, $details)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                   return TRUE;
                else:
                    return FALSE;
                endif;
            else:
                if($db->insert($table, $details)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                   return TRUE;
                else:
                    return FALSE;
                endif;
                
            endif;    
        endif;
    }
    
    
    function getPreviousRecord($table, $columns, $value,  $school_year, $settings)
    {
        $db_details = $this->eskwela->db($school_year);
        $db_details->from($table);
        $db_details->where($columns, $value);
        $query = $db_details->get();
        return $query->row();
    }
    
    function getRfidByStid($st_id)
    {
        $this->db->where('profile_students.st_id', $st_id);
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile_students');
        return $query->row();
    }
            
     
    function getSingleCollegeStudent($id, $year, $sem, $opt = NULL) {
        if ($opt != NULL): //-------------- basic ED ---------------//
            $this->db = $this->eskwela->db($year);
            $this->db->select('*');
            $this->db->select('profile_students.st_id as uid');
            $this->db->select('profile.user_id as u_id');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');            
            $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
            $this->db->where('profile_students.st_id', $id);
            $query = $this->db->get();
        else:
            $this->db = $this->eskwela->db($year);
            $this->db->select('*');
            $this->db->select('profile_students.st_id as uid');
            $this->db->select('profile.user_id as u_id');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
            $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
            $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
            $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left');
            $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');
            $this->db->join('c_departments', 'c_departments.cc_id = c_courses.dept_id', 'left');
            $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
            $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
            $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
            $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
            $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
            $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
            $this->db->join('profile_medical', 'profile.user_id = profile_medical.user_id', 'left');
            $this->db->where('profile_students_c_admission.school_year', $year);

            $this->db->where('profile_students_c_admission.semester', $sem);

            $this->db->where('profile_students.st_id', $id);
            $query = $this->db->get();
        endif;
        return $query->row();
    }
    
    function getTotalCollegeStudents($course, $level, $school_year, $semester, $status, $gender)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->join('profile_students', 'profile_students_c_admission.user_id = profile_students.user_id', 'left');
        if($gender!=NULL):
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'inner');
            $this->db->where('sex', $gender);
        endif;
      //  
        if($course!=NULL):
            $this->db->where('course_id', $course);
        endif;
        if($level!=NULL):
            $this->db->where('year_level', $level);
        endif;
        $this->db->where('semester', $semester);
        $this->db->where('school_year', $school_year);
        $this->db->where('profile_students_c_admission.status', $status);
        $q = $this->db->get('profile_students_c_admission');
        return $q->num_rows();
    }
    
    function getStudents($year, $sem, $course=NULL, $level=NULL, $limit=NULL, $offset=NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('profile_students_c_admission');
        $this->db->where('school_year', $year);
        $q = $this->db->get();
        return $q;
    }
    
    function getCollegeStudentsByYear($school_year, $sem)
    {
        $this->db->where('profile_students_c_admission.school_year', $school_year);
        $this->db->where('semester', $sem);
        $this->db->join('profile', 'profile_students_c_admission.user_id = profile.user_id', 'left');
        $q = $this->db->get('profile_students_c_admission');
        return $q->result();
    }
    function getAllCollegeStudents($limit, $offset,  $year, $sem, $course=NULL, $level=NULL, $status =NULL )
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_c_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('temp_bdate');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if($year==NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;
        if($course!=NULL):
            $this->db->where('profile_students_c_admission.course_id', $course);
        endif;
        if($sem!=NULL):
            $this->db->where('semester', $sem);
        endif;
        if($level!=NULL):
            $this->db->where('year_level', $level);
        endif;
        
        $this->db->where('account_type', 5);
        ($status!=NULL?$this->db->where('profile_students_c_admission.status', $status):"");
        $this->db->order_by('year_level', 'ASC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        $this->db->group_by('profile.user_id');

        if($limit!=NULL||$offset=NULL){
                $this->db->limit($limit, $offset);	
        }
		
        $query = $this->db->get();
        return $query;
    }


    function checkCollegeRO($user_id, $semester, $school_year)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $query = $this->db->get('profile_students_c_admission');
        
        if($query->num_rows>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkRO($st_id, $school_year, $grade_id)
    {
        $this->db->where('user_id', $st_id);
        $this->db->where('school_year', $school_year);
        //$this->db->where('grade_level_id', $grade_id);
        $query = $this->db->get('profile_students_admission');
        
        if($query->num_rows>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveCollegeRO($details, $school_year)
    {
        $db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        if($db->insert('profile_students_c_admission', $details)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
           $return = array(
               'status' => TRUE,
               'data'   => $db->insert_id(),
           );
           return $return;
        else:
            return FALSE;
        endif;
    }
    
    function saveRO($details)
    {
        if($this->db->insert('profile_students_admission', $details)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
           $return = array(
               'status' => TRUE,
               'data'   => $this->db->insert_id(),
           );
           return $return;
        else:
            return FALSE;
        endif;
    }
    
    function getStudentBySY($year,$limit=NULL, $offset=NULL, $status=NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile_students.status as status');
        $this->db->select('st_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('grade_id');
        $this->db->select('section');
        $this->db->select('level');
        $this->db->select('sex');
        $this->db->select('ro_years');
        $this->db->select('rfid');
        
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id','left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->join('profile_students_ro_years', 'profile_students_admission.school_year = profile_students_ro_years.ro_years','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students_ro_years.ro_years', $year);
        if($status!=NULL):
            $this->db->where('profile_students_admission.status', $status);
        endif;
        if($limit!=NULL||$offset=NULL){
           $this->db->limit($limit, $offset);	
        }
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    
    function getROYear()
    {
        $ro = $this->db->get('profile_students_ro_years');
        return $ro->result();
    }
    
    function getLrnByID($st_id, $sy=NULL)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->select('st_id');
        $this->db->select('profile.user_id as uid');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id','left');
        $this->db->where('profile.user_id', $st_id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function getBasicStudent($st_id, $school_year=NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('profile_students_c_admission');
        $this->db->join('profile', 'profile_students_c_admission.user_id = profile.user_id', 'left');
       // $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->where('st_id', $st_id);
        if($school_year!=NULL):
            $this->db->where('profile_students_c_admission.school_year', $school_year);
        endif;
        $query = $this->db->get();
        if($query->num_rows()==0):
            $this->db->select('lastname');
            $this->db->select('firstname');
            $this->db->from('profile_students_admission');
            $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
           // $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
            $this->db->where('st_id', $st_id);
            if($school_year!=NULL):
                $this->db->where('profile_students_admission.school_year', $school_year);
            endif;
            $query = $this->db->get();
            
        endif;
        
        return $query;
    }
    
    function getStudentListForParent($pid)
    {
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.parent_id', $pid);
        $this->db->where('profile_students_admission.school_year',  $this->session->userdata('school_year'));
        $this->db->order_by('profile_students_admission.grade_level_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
    
    function getAllStudentsForCard($limit, $offset, $section_id)
    {
        $this->db->select('st_id');
        $this->db->select('profile.user_id as uid');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('lastname');
        $this->db->select('level');
        $this->db->select('profile_students.section_id');
        $this->db->select('account_type');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        if($section_id!=Null){
            $this->db->where('profile_students.section_id', $section_id);
        }
        
        $this->db->where('account_type', 5);
        
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if($limit!=""||$offset=""){
                $this->db->limit($limit, $offset);	
        }
		
        $query = $this->db->get();
        return $query;
    }
	
    function getAllStudentsForID($limit, $offset, $grade_id, $section)
    {
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
        
        if($grade_id!=Null){
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }
        if($section!=Null){
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('avatar !=', 'noImage.png');
        
        $this->db->where('account_type', 5);
        
        $this->db->where('profile_students_admission.status', 1);
        
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if($limit!=""||$offset=""){
                $this->db->limit($limit, $offset);	
        }
		
        $query = $this->db->get();
        return $query;
    }
	
    function getAllStudents($limit, $offset, $grade_id, $section, $year=NULL)
    {
        //$this->db->cache_on();
        if($year==NULL):
            $year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as stats');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','inner');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if($year==NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $year);
        endif;
        
        if($grade_id!=Null){
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }
        if($section!=Null){
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('account_type', 5);
        if(!$this->session->userdata('is_admin')){
            $this->db->where('profile_students_admission.status', 1);
        }
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if($limit!=""||$offset=""){
                $this->db->limit($limit, $offset);	
        }
		
        $query = $this->db->get();
        return $query;
    }
    
    function getNumberOfStudentsPerMonth($month, $gender)
    {
        $this->db->select('st_id');
        $this->db->select('profile_students_admission.status as stat');
        $this->db->select('sex');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $query = $this->db->get();
        return $query;
    }
    
    //function getStudentToDelete($school_year)
    
   
    function getAllStudentsBasicInfoByGender($section_id, $gender, $status, $year=NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('rfid');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students_admission.section_id');
        $this->db->select('profile_students_admission.status');
        $this->db->select('profile_students_admission.school_year');
        $this->db->select('sex');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left'); 
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        if($section_id!=NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        if($gender!=NULL):
            $this->db->where('sex', $gender);
        endif;
        if($status!=NULL){
            $this->db->where('profile_students_admission.status', $status);
        }
        if($year!=NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        $this->db->order_by('sex', 'DESC');
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function getAllStudentsByGender($section_id, $gender, $status, $year=NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left'); 
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->where('profile_students_admission.section_id', $section_id);
        $this->db->where('sex', $gender);
        if($status!=NULL){
            $this->db->where('profile_students_admission.status', $status);
        }
        if($year!=NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function getAllStudentsByGenderForAttendance($section_id, $gender, $status)
    {
        //$this->db->select('*');
        $this->db->select('st_id');
        $this->db->select('rfid');
        $this->db->select('profile.user_id');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('lastname');
        $this->db->select('section_id');
        $this->db->select('sex');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        $this->db->where('profile_students_admission.section_id', $section_id);
        $this->db->where('sex', $gender);
        if($status!=""){
        $this->db->where('profile_students_admission.status', $status);
        }
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    
    function getSingleStudentByRfid($rfid, $year=NULL)
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        //$this->db->join('profile_info', 'profile.user_id = profile_info.u_id', 'left');
        
        $this->db->where('rfid', $rfid);
        $query = $this->db->get();
        return $query;
    }
    

    
    function getMother($id){
        $this->db->select('*');
        $this->db->from('profile_parent');
        $this->db->join('profile_address_info', 'profile_parent.m_add_id  = profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('profile_educ_attain', 'profile_parent.m_educ  = profile_educ_attain.ea_id', 'left');
        $this->db->join('profile_occupation', 'profile_parent.m_occ  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parent.u_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getFather($id){
        $this->db->select('*');
        $this->db->from('profile_parent');
        $this->db->join('profile_address_info', 'profile_parent.f_add_id  = profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('profile_educ_attain', 'profile_parent.f_educ  = profile_educ_attain.ea_id', 'left');
        $this->db->join('profile_occupation', 'profile_parent.f_occ  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parent.u_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getMedical($id)
    {
        $this->db->select('*');
        $this->db->from('profile_medical');
        $this->db->join('profile_med_physician', 'profile_medical.physician_id = profile_med_physician.physician_id', 'left');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getSectionById($id)
    {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getDateEnrolled($id)
    {
        $this->db->select('*');
        $this->db->from('profile_students_c_admission');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row()->date_admitted;
    }
    
    function getLateEnrolleesByGender($sex)
    {
        $this->db->select('*');
        $this->db->from('admission_remarks');
        $this->db->join('deped_code_indicator', 'admission_remarks.code_indicator_id = deped_code_indicator.id', 'left');
        $this->db->join('profile', 'admission_remarks.remark_to = profile.user_id', 'left');
        $this->db->where('code_indicator_id', 4);
        $this->db->where('profile.sex', $sex);
        $query = $this->db->get();
        return $query;
    }
    
    function getStudentStatus($status, $sex, $month, $section_id, $year, $option, $grade_id)
    {
        if($year==NULL):
            $year = date('Y');
        endif;
        
        $this->db->select('*');
        $this->db->from('admission_remarks');
        $this->db->join('deped_code_indicator', 'admission_remarks.code_indicator_id = deped_code_indicator.id', 'left');
        $this->db->join('profile_students', 'admission_remarks.remark_to = profile_students.st_id', 'right');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        $this->db->where('profile_students_admission.school_year', $year);
        $this->db->where('admission_remarks.rem_month', abs($month));
        $this->db->where('code_indicator_id', $status);
        $this->db->where('profile.sex', $sex);
        if($section_id!=NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        $query = $this->db->get();
        return $query;
    }
    
    function getAdmissionID($id, $sem, $school_year){
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db = $this->eskwela->db($sy);
        
        $this->db->where('user_id', $id);
        $this->db->where('semester', $sem);
        return $this->db->get('profile_students_c_admission')->row();
    }
    
    function getWithdrawStudentList($value, $sem, $school_year = NULL){
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db = $this->eskwela->db($sy);
        
        $this->db->select('*');
        $this->db->from('profile_students_c_admission');
        $this->db->join('c_courses','c_courses.course_id = profile_students_c_admission.course_id','left');
        $this->db->join('profile','profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->join('admission_remarks','admission_remarks.remark_to = profile_students_c_admission.st_id','left');
        $this->db->where('profile_students_c_admission.status', $value);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $sy);
        $this->db->where('st_id != ""');
        return $this->db->get()->result();
    }
}
