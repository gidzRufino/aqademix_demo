<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reports_model
 *
 * @author genesis
 */
class reports_model extends CI_Model{
    //put your code here
    
    function getCollegeCount($semester, $course, $year_level, $status, $school_year){
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id', 'INNER');
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id', 'INNER');
        $this->db->where('semester', $semester);
        ($course != 'NULL' && $course != NULL) ? $this->db->where('c_courses.course_id', $course) : '';
        ($year_level != 'NULL' && $year_level != NULL) ? $this->db->where('year_level', $year_level) : '';
        $this->db->wherE('status', $status);
        $this->db->order_by('date_admitted','ASC');
        $q = $this->db->get('profile_students_c_admission');
//        echo $this->db->last_query();
        return $q;
    }

    function getEnrollmentCount($grade_id, $type){
        $this->db->join('profile','profile_students_admission.user_id = profile.user_id');
        if($grade_id != NULL):
            $this->db->where('grade_level_id', $grade_id);
                        // ->where('date_admitted', Date('Y-m-d'));
        endif;
        if($type != NULL):
            $this->db->where('status', $type);
        endif;
        $count = $this->db->where('enrolled_online', 1)
                            ->get('profile_students_admission');
        return $count->num_rows();
    }
    
    
    function getSingleStudent($id, $year) {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students_admission.school_year as sy');
        $this->db->select('profile_students_admission.grade_level_id as gl_id');
        $this->db->select('profile_students_admission.str_id as strnd_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'inner');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        //$this->db->join('sh_strand','sh_strand.st_id = profile_students_admission.str_id','left');
        if ($year == NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $year);

        endif;
        $this->db->where('profile_students.st_id', $id);
        $this->db->or_where('profile_students.user_id', $id);
        $this->db->or_where('profile_students.lrn', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getStudentStat($id){
        $this->db->select('*');
        $this->db->from('admission_remarks');
        $this->db->join('deped_code_indicator','deped_code_indicator.id = admission_remarks.code_indicator_id','left');
        $this->db->where('remark_to',$id);
        return $this->db->get()->row();
    }
    
     function getSubBH($id){
        $this->db->where('bh_group',$id);
        return $this->db->get('gs_behavior_rate')->result();
    }
    
    function getBehaviorRate($bh, $dept_id = NULL)
    {
        ($dept_id != NULL ? $this->db->where('dept_id', $dept_id) : '');
        $this->db->where('bh_group', $bh);
        $q = $this->db->get('gs_behavior_rate');
        return $q->result();
    }
    
    function getBhGroup($school_year, $bh_id = NULL, $dept_id = NULL)
    {
        $this->db->where('gs_used', $school_year);
        ($bh_id != NULL ? $this->db->where('bh_group', $bh_id) : '');
        ($dept_id != NULL ? $this->db->where('dept_id', $dept_id) : '');
//        $this->db->group_by('bh_group');
        $q = $this->db->get('gs_behavior_rate');
        return $q->result();
    }

    function deleteINC($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('gs_incomplete_subjects');
        return;
    }
    
    function getINC($st_id, $sy)
    {
            $this->db->select('*');
            $this->db->from('gs_incomplete_subjects');
            $this->db->join('subjects','gs_incomplete_subjects.subject = subjects.subject_id');
            $this->db->join('grade_level','gs_incomplete_subjects.grade_id = grade_level.grade_id');
            $this->db->where('st_id', $st_id);
            $this->db->where('sy', $sy);
            $q = $this->db->get();
            return $q;
    }
    function saveINC($details, $st_id, $sub_id, $grade_id)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('subject', $sub_id);
        $this->db->where('grade_id', $grade_id);
        $q = $this->db->get('gs_incomplete_subjects');
        if($q->num_rows()> 0):
            $this->db->where('st_id', $st_id);
            $this->db->where('subject', $sub_id);
            $this->db->where('grade_id', $grade_id);
            $this->db->update('gs_incomplete_subjects', $details);
            return $q;
        else:
            $this->db->insert('gs_incomplete_subjects', $details);
            $this->db->select('*');
            $this->db->from('gs_incomplete_subjects');
            $this->db->where('id', $this->db->insert_id());
            $this->db->join('subjects','gs_incomplete_subjects.subject = subjects.subject_id');
            $this->db->join('grade_level','gs_incomplete_subjects.grade_id = grade_level.grade_id');
            $q = $this->db->get();
            return $q;
        endif;
    }
    function getSPRById($spr_id)
    {
        $this->db->where('spr_id', $spr_id);
        $query = $this->db->get('gs_spr');
        return $query->row();
    }
    
    function lock_unlock_SPR($spr_id, $option)
    {
        $array = array('go_to_next_level'=> $option);
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr', $array);
        return;
    }
    
    function updateBasicSPR($spr_id, $details)
    {
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr', $details);
        return;
    }
    
    function getSPRecords($user_id,$year_level, $subject_id)
    {
        $this->db->select('*');
        $this->db->select('gs_spr.spr_id as spr');
        $this->db->from('gs_spr');
        $this->db->join('gs_spr_ar', 'gs_spr.spr_id = gs_spr_ar.spr_id', 'left');
        $this->db->join('subjects', 'gs_spr_ar.subject_id = subjects.subject_id', 'left');
        $this->db->where('st_id', $user_id);
        $this->db->where('grade_level_id', $year_level);
        if($subject_id!=NULL):
            $this->db->where('gs_spr_ar.subject_id', $subject_id); 
        endif;
        $query = $this->db->get();
        return $query;
    }
    
    function getCurrentSPR_level($st_id, $next)
    {
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('grade_level', 'gs_spr.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('st_id', $st_id);
        if($next==1):
            $this->db->where('go_to_next_level', 1);
        endif;
        $this->db->order_by('grade_level_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }
    
    function updateSPRecords($spr_id, $subject_id, $ar)
    {
        $this->db->where('spr_id', $spr_id);
        $this->db->where('subject_id', $subject_id);
        
        if($this->db->update('gs_spr_ar', $ar)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteSPRecords($spr_id)
    {
        $this->db->where('spr_id', $spr_id);
        
        if($this->db->delete('gs_spr', $ar)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deleteSingleRecord($spr_id)
    {
        $this->db->where('ar_id', $spr_id);
        
        if($this->db->delete('gs_spr_ar', $ar)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    function checkAcad($user_id, $school_year)
    {
        $this->db->where('st_id', $user_id);
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_spr');
        if($query->num_rows()>0):
            return $query->row()->spr_id;
        else:
            return FALSE;
        endif;
    }
    
    function checkIfAcadExist($user_id, $levelCode)
    {
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('grade_level', 'gs_spr.grade_level_id = grade_level.grade_id','left');
        $this->db->where('st_id', $user_id);
        $this->db->where('levelCode', $levelCode);
        $query = $this->db->get();
        if($query->num_rows()>0):
            return $query;
        else:
            return FALSE;
        endif;
    }
    
    function checkSubject($subject_id, $spr_id)
    {
        $this->db->where('subject_id', $subject_id);
        $this->db->where('spr_id', $spr_id);
        $query = $this->db->get('gs_spr_ar');
        if($query->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveAR($ar, $spr_id = NULL, $subject_id = NULL)
    {
        ($spr_id!=NULL?$this->db->where('spr_id', $spr_id):'');
        ($subject_id!=NULL?$this->db->where('subject_id', $subject_id):'');
        $q = $this->db->get('gs_spr_ar');
        if($q->num_rows()>0):
            $this->db->where('spr_id', $spr_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->update('gs_spr_ar', $ar);
        else:
        $this->db->insert('gs_spr_ar', $ar);
        endif;
        return;
    }
    
    function saveSPR($spr)
    {
        $this->db->insert('gs_spr', $spr);
        return $this->db->insert_id();
    }
    
    function getAcadRecords($user_id, $school_year, $grade_level)
    {
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('gs_spr_ar', 'gs_spr.spr_id = gs_spr_ar.spr_id', 'left');
        $this->db->join('subjects', 'gs_spr_ar.subject_id = subjects.subject_id', 'left');
        $this->db->join('grade_level', 'gs_spr.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('st_id', $user_id);
        if($grade_level!=NULL):
            $this->db->where('grade_level_id', $grade_level);
        endif;
        if($school_year!=NULL):
            $this->db->where('school_year', $school_year);
        endif;
        
        $query = $this->db->get();
        return $query;
    }
    
    function getDaysPresent($spr_id)
    {
        $this->db->select('*');
        $this->db->select('gs_spr.spr_id as spr');
        $this->db->from('gs_spr_attendance');
        $this->db->join('gs_spr', 'gs_spr_attendance.spr_id=gs_spr.spr_id', 'left');
        $this->db->where('gs_spr_attendance.spr_id', $spr_id);
        $query = $this->db->get();
        if($query->num_rows()>0):
            return $query;
        else:
            return FALSE;
        endif;
    }
    
    function insertDaysPresent($values)
    {
        $this->db->insert('gs_spr_attendance', $values);
        return TRUE;
        
    }
    
    function updateDaysPresent($spr_id, $values)
    {
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr_attendance', $values);
        return TRUE;
    }

    function getSchoolDays($year, $dept_id)
    {
        $this->db->where('dept_id', $dept_id);
        $this->db->where('school_year', $year);
        $query = $this->db->get('gs_num_of_sdays_per_year');
        if($query->num_rows()>0):
            return $query->row();
        else:
            return FALSE;
        endif;
    }
    
    function insertSchoolDays($details)
    {
        if($this->db->insert('gs_num_of_sdays_per_year', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updateSchoolDays($year, $details, $dept = NULL)
    {
        $this->db->where('dept_id', $dept);
        $this->db->where('school_year', $year);
        $this->db->update('gs_num_of_sdays_per_year', $details);
        return TRUE;
    }

    function updateEdHistory($st_id, $details)
    {
        $this->db->where('st_id', $st_id);
        $this->db->update('gs_previous_record', $details);
        return;
    }
    function getEdHistory($st_id)
    {
        $this->db->where('st_id', $st_id);
        $query = $this->db->get('gs_previous_record');
        return $query->row();
    }
    function saveEdHistory($details)
    {
        if($this->db->insert('gs_previous_record', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    function add_data($datauser)
    {
    $this->db->insert('data',$datauser);
    return $this->db->insert_id();
    } 
    
    function getCSVData($grade_id, $section_id)
    {
        $this->db->select('profile.user_id as ID_Number');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('level');
        $this->db->select('section');
        $this->db->select('calendar.cal_date as birthday');
        $this->db->select('sex as sex');
        $this->db->select('street');
        $this->db->select('barangay');
        $this->db->select('city as city_municipality');
        $this->db->select('province');
        $this->db->select('m_name as in_case_contact_name');
        $this->db->select('cd_mobile as in_case_contact_number');
        $this->db->select('profile_info.grade_level_id as grade_id');
        $this->db->select('admitted');
        $this->db->from('profile');
        $this->db->join('address_info', 'profile.add_id  = address_info.address_id', 'left');
        $this->db->join('profile_parent', 'profile.parent_id = profile_parent.p_id', 'left');
        $this->db->join('contact_details', 'profile_parent.m_contact_id = contact_details.contact_id', 'left');
        $this->db->join('profile_info', 'profile.user_id = profile_info.u_id', 'left');
        $this->db->join('grade_level', 'profile_info.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('section', 'section.section_id = profile_info.st_section_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        if($grade_id!="Null"):
            $this->db->where('grade_id', $grade_id);
        endif;
        if($section_id!=""):
           $this->db->where('section_id', $section_id); 
        endif;
        $query = $this->db->get();
        return $query;
    }
    
    function getCSVDataForTeachers()
    {
        $this->db->select('profile_employee.employee_id as ID_Number');
        $this->db->select('UPPER(lastname)');
        $this->db->select('UPPER(firstname)');
        $this->db->select('UPPER(middlename)');
        $this->db->select('cal_date');
        $this->db->select('sex');
        $this->db->select('UPPER(street)');
        $this->db->select('UPPER(barangay)');
        $this->db->select('UPPER(mun_city)');
        $this->db->select('UPPER(province)');
        $this->db->select('zip_code');
        $this->db->select('cd_mobile');
        $this->db->select('cd_email');
        $this->db->select('sss');
        $this->db->select('phil_health');
        $this->db->select('pag_ibig');
        $this->db->select('tin');
        $this->db->select('prc_id');
        $this->db->select('date_hired');
        $this->db->select('UPPER(incase_name)');
        $this->db->select('incase_contact');
        $this->db->select('UPPER(incase_relation)');
        $this->db->select('UPPER(position)');
        $this->db->select('blood_type');
        $this->db->select('profile.user_id as uid');
        
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id = profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('profile_medical', 'profile.user_id= profile_medical.user_id', 'left');
        $this->db->join('department', 'profile_position.position_dept_id = department.dept_id', 'left');
        $this->db->join('user_accounts', 'profile.user_id = user_accounts.u_id', 'left');
        $this->db->where('account_type !=','1');
        $this->db->where('account_type !=','5');
        $this->db->where('account_type !=','4');
        $query = $this->db->get();
        return $query;
    }
    
    function getAllStudentsByGender($section_id, $gender, $status, $year = NULL, $strand = NULL) {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->where('profile_students_admission.section_id', $section_id);
        $this->db->where('sex', $gender);
        if ($status != NULL) {
            $this->db->where('profile_students_admission.status', $status);
        }
        if ($year != NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        if ($year != NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function getaconduct($st_id)
    {
        $this->db->select('*');
        $this->db->from('gs_conduct');
        $this->db->where('cd_st_id', $st_id);
        $query = $this->db->get();
        return $query;
    }
    
    function ifcdexist($st_id, $sy) {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->where('cd_st_id', $st_id);
        $this->db->where('cd_sy', $sy);
        $query = $this->db->get('gs_conduct');
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updateconduct($data, $st_id, $sy) {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->where('cd_st_id', $st_id);
        $this->db->where('cd_sy', $sy);
        $this->db->update('gs_conduct', $data);
    }
    
    function insertconduct($details) {
        $this->db->insert('gs_conduct', $details);
        return true;
    }
    
    function getCoreValues(){
        $this->db->select('*');
        return $this->db->get('gs_behavior_core_values')->result();
    }

}

?>
