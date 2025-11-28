<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author genesis
 */
class subjectmanagement_model extends MX_Controller {
    //put your code here
    
    
    function searchTeacher($value, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'inner');
        $this->db->like('LOWER(lastname)', strtolower($value), 'both');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getAddSubjectDrop($st_id, $semester, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->join('profile_students_c_load','profile_students_c_admission.admission_id = profile_students_c_load.cl_adm_id','left');
        $this->db->join('c_subjects','profile_students_c_load.cl_sub_id = c_subjects.s_id','left');
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $semester);
        $q = $this->db->get('profile_students_c_admission');
        return $q->result();
    }
    
    function isSubjectDeleted($sub_id, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->where('s_id', $sub_id);
        if($this->db->delete('c_subjects')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getSchedule($school_year, $semester)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        //$this->db->limit(20);
        $this->db->order_by('sched_id', 'ASC');
        $this->db->where('faculty_id !=', '');
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $this->db->group_by('faculty_id');
        $q = $this->db->get('c_schedule')->result();
        return $q;
    }
            
    function getListOfClasses($semester, $school_year, $requested)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('c_section');
        $this->db->join('c_subjects', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->where('sec_school_year', $school_year);
        $this->db->where('sec_sem', $semester);
        $this->db->where('is_requested', $requested);
        $this->db->group_by('sec_id');
        $this->db->order_by('sub_code');
        //$this->db->limit(60);
        $query = $this->db->get();
        return $query->result();
    }
    
          
    function searchClassList($value, $semester, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->like('LOWER(s_desc_title)', strtolower($value), 'both');
        $this->db->or_like('LOWER(sub_code)', strtolower($value), 'after');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->where('c_section.sec_school_year', $school_year);
        $this->db->group_by('c_section.sec_id');
        $this->db->order_by('sub_code');
        $this->db->limit(20);
        $query = $this->db->get();
        return $query->result();
    }
    
          
    function classList($semester, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->limit(30);
        $this->db->group_by('c_section.sec_id');
        $this->db->order_by('sub_code');
        $query = $this->db->get();
        return $query->result();
    }
    
    function checkIfDocIsClaimed($st_id, $sem, $school_year, $doc_type)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->where('claim_st_id', $st_id);
        $this->db->where('claim_sem', $sem);
        $this->db->where('claim_sy', $school_year);
        $this->db->where('claim_type', $doc_type);
        $q = $this->db->get('c_claimed_docs');
        if($q->num_rows()>0):
            return json_encode(array('isClaimed' => TRUE, 'details' => $q->result()));
        else:
            return json_encode(array('isClaimed'=> FALSE));
        endif;
    }
            
    function saveClaimCard($st_id, $sem, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        if($this->db->insert('c_claimed_docs', array('claim_st_id'=>$st_id, 'claim_sem'=> $sem, 'claim_sy'=>$school_year, 'claim_type' => 'Class Card'))):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return ;
        endif;
    }
    
    function getSubjectPerId($sub_id, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->where('s_id', $sub_id);
        $q = $this->db->get('c_subjects');
        return $q->row();
    }
    
    function getSubjectOfferedPerSem($sem, $school_year = NULL)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->join('c_subjects', 'c_section.sec_sub_id = c_subjects.s_id','left');
        $this->db->where('sec_sem', $sem);
        $q = $this->db->get('c_section');
        return $q->result();
    }
            
    function getStudentsPerSectionRaw($sec_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.school_year as sy');
        $this->db->select('profile_students_c_admission.course_id as c_id');
        $this->db->join('profile','profile_students_c_load.cl_user_id = profile.user_id','left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->join('c_section', 'profile_students_c_load.cl_section = c_section.sec_id', 'left');
        $this->db->where('sec_sem', $sem);
        $this->db->where('cl_section', $sec_id);
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->group_by('profile.user_id');
        $q = $this->db->get('profile_students_c_load');
        return $q;
    }
            
    function getStudentsPerSectionPrint($sec_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->join('profile','profile_students_c_load.cl_user_id = profile.user_id','left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id','left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->join('c_section', 'profile_students_c_load.cl_section = c_section.sec_id', 'left');
        $this->db->where('sec_sem', $sem);
        $this->db->where('semester', $sem);
        $this->db->where('cl_section', $sec_id);
        ($school_year!=NULL?$this->db->where('profile_students_c_admission.school_year', $school_year):'');
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->group_by('profile.user_id');
        $q = $this->db->get('profile_students_c_load');
        return $q->result();
    }
            
    function getStudentsPerSection($sec_id, $sem, $school_year)
    {
        
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        //$this->db->join('profile','profile_students_c_load.cl_user_id = profile.user_id','left');
        $this->db->join('profile_students_c_admission', 'profile_students_c_admission.admission_id = profile_students_c_load.cl_adm_id','left');
        $this->db->join('c_section', 'profile_students_c_load.cl_section = c_section.sec_id', 'left');
        ($sem!=NULL?$this->db->where('sec_sem', $sem):'');
        ($sem!=NULL?$this->db->where('semester', $sem):'');
        $this->db->where('cl_section', $sec_id);
        $this->db->where('sec_school_year', $school_year);
        $q = $this->db->get('profile_students_c_load', $sec_id);
        return $q;
    }
    function searchSubjectResult($value, $school_year = NULL)
    {
        
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->like('LOWER(s_desc_title)', strtolower($value), 'both');
        $this->db->or_like('LOWER(sub_code)', strtolower($value), 'both');
        $this->db->limit(20);
        $query = $this->db->get();
        return $query;
    }
    
    function editSection($sec_id, $details, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->where('sec_id', $sec_id);
        $this->db->update('c_section', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        return TRUE;
    }
            
    function deleteSection($sec_id,$school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->where('sec_id', $sec_id);
        if($this->db->delete('c_section')):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getSectionPerSubject($sub_id, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->join('c_courses', 'c_section.course_id = c_courses.course_id','right');
        $this->db->join('c_subjects', 'c_section.sec_sub_id = c_subjects.s_id','left');
        $this->db->where('sec_sub_id', $sub_id);
        $q = $this->db->get('c_section');
        return $q->result();
    }
    
    function getAssignSubject($teacher_id, $semester, $school_year = NULL)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        
        $this->db->join('c_section', 'c_schedule.section_id = c_section.sec_id', 'left');
        $this->db->join('c_subjects', 'c_subjects.s_id = c_section.sec_sub_id', 'left');
        if($semester!=NULL):
            $this->db->where('semester',$semester);
        endif;
        $this->db->where('school_year', $school_year);
        $this->db->where('faculty_id',$teacher_id);
        $this->db->group_by('c_schedule.section_id');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function getSchedulePerTeacher($teacher_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->join('c_faculty_assignment','c_schedule.sched_gcode = c_faculty_assignment.schedule_id','left');
        $this->db->join('c_section', 'c_schedule.section_id = c_section.sec_id', 'inner');
        $this->db->join('c_subjects', 'c_subjects.s_id = c_section.sec_sub_id', 'left');
        $this->db->join('c_subjects_per_course', 'c_schedule.cs_spc_id = c_subjects_per_course.spc_id','left');
        $this->db->join('c_courses', 'c_subjects_per_course.spc_course_id = c_courses.course_id','left');
        $this->db->where('c_schedule.faculty_id', $teacher_id);
        ($semester!=NULL?$this->db->where('sec_sem', $semester):'');
        $this->db->order_by('t_from','ASC');
        $this->db->group_by('c_schedule.section_id');
        $q = $this->db->get('c_schedule');
        return $q->result();
    }
    
    function saveAssignedSubject($array, $sched_code, $section_id, $teacher_id, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        
        $this->db->where('sched_gcode', $sched_code);
        $q = $this->db->get('c_schedule');
        if($q->num_rows()>0):
            if($q->row()->faculty_id==""):
                $this->db->where('sched_gcode', $sched_code);
                if($this->db->update('c_schedule', $array)):
                    return TRUE;
                endif;
                
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function assignSubject($teacher_id, $sched_code, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('sched_gcode', $sched_code);
        $this->db->where('faculty_id','');
        $q = $this->db->get('c_schedule');
        if($q->num_rows()>0):
            $this->db->where('sched_gcode', $sched_code);
            $this->db->update('c_schedule', array('faculty_id' => $teacher_id));
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return FALSE;
        else:
            $this->db->where('sched_gcode', $sched_code);
            $q = $this->db->get('c_schedule');
            return $q->row()->faculty_id;
        endif;
    }
            
    function searchSubject($value, $semester, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->like('LOWER(s_desc_title)', strtolower($value), 'both');
        $this->db->or_like('LOWER(sub_code)', strtolower($value), 'after');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->limit(20);
        $this->db->group_by('c_section.sec_id');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getSectionById($id=NULL, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('sec_id', $id);
        $q = $this->db->get('c_section');
        return $q->row();
    }
    
    function getSectionDropDown($g=NULL, $school_year = NULL, $sem = NULL)
    {
        $semester = ($sem==NULL?$this->session->semester:$sem);
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('sec_sub_id', $g);
        $this->db->where('sec_sem', $semester);
        $q = $this->db->get('c_section');
        return $q;
    }
    
    function getSubjectsOffered($g=NULL, $school_year = NULL)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('sec_sub_id', $g);
        $q = $this->db->get('c_section');
        return $q;
    }
    
    
    function addSection($details, $school_year = NULL)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        if($this->db->insert('c_section', $details)):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
         else:
             return FALSE;
         endif;
    }
    
    function lastSecId()
    {
        $this->db->order_by('esk_c_section_code', 'DESC');
        $q = $this->db->get('c_section');
        return $q->row();
    }
    
    function approveLoad($adm_id, $school_year = NULL, $status =NULL)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('cl_adm_id', $adm_id);
        if($this->db->update('profile_students_c_load', array('is_final' => 1))):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                
                $this->db->where('admission_id'. $adm_id);
                $this->db->update('profile_students_c_admission', array('status' => $status));
                
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function getLoadedSubject($adm, $sem = NULL, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('cl_adm_id', $adm);
        $this->db->where('sec_school_year', $school_year);
        $this->db->join('c_subjects','c_subjects.s_id = profile_students_c_load.cl_sub_id', 'inner');
        $this->db->join('c_section', 'profile_students_c_load.cl_section = c_section.sec_id', 'inner');
        ($sem != NULL ? $this->db->where('c_section.sec_sem', $sem) : '');
        $this->db->order_by('sub_code', 'ASC');
        $q = $this->db->get('profile_students_c_load');
        return $q->result();
    }
    
    
    function checkIfSubjectExist($student_id, $subject_id)
    {
        $this->db->where('cl_user_id', $student_id);
        $this->db->where('cl_sub_id', $subject_id);
        $q = $this->db->get('profile_students_c_load');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function removeLoadedSubject($subject_id, $adm_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('cl_sub_id', $subject_id);
        $this->db->where('cl_adm_id', $adm_id);
        $q = $this->db->get('profile_students_c_load');
        if($q->num_rows()>0):
            $this->db->where('cl_sub_id', $subject_id);
            $this->db->where('cl_adm_id', $adm_id);
            if($this->db->delete('profile_students_c_load')):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
                return true;
            endif;
        else:
            return FALSE;
        endif;    
    }
    
    function saveLoadedSubject($subject_id, $adm_id, $load, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('cl_sub_id', $subject_id);
        $this->db->where('cl_adm_id', $adm_id);
        $q = $this->db->get('profile_students_c_load');
        if($q->num_rows()==0):
            if($this->db->insert('profile_students_c_load', $load)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return true;
            endif;
        else:
            $this->db->where('cl_sub_id', $subject_id);
            $this->db->where('cl_adm_id', $adm_id);
            if($this->db->update('profile_students_c_load', $load)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            endif;
        endif;    
    }
    
    function prerequisteCheck($st_id, $subject, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('cl_user_id', $st_id);
        $this->db->where('sub_code', $subject);
        $this->db->join('c_subjects','c_subjects.s_id = profile_students_c_load.cl_sub_id', 'left');
        $q = $this->db->get('profile_students_c_load');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getSubjectPerCourse($course, $year_level, $sem, $year)
    {
        if($year==NULL):
            $year = $this->session->userdata('school_year');
        endif;
        
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('c_subjects_per_course');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('spc_course_id', $course);
        $this->db->where('spc_sem_id', $sem);
        $this->db->where('year_level', $year_level);
        $this->db->where('school_year', $year);
        $q = $this->db->get();
        if($q->num_rows()>0):
            return $q->result();
        else:
            return FALSE;
        endif;
    }
    
    function getSubjectsPerCourse($course)
    {
       
        $year = $this->session->userdata('school_year');
       
        
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('c_subjects_per_course');
        $this->db->join('c_subjects','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $this->db->where('spc_course_id', $course);
        $q = $this->db->get();
        if($q->num_rows()>0):
            return $q->result();
        else:
            return FALSE;
        endif;
    }
    
    function getCollegeSubjects($sem, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        ($sem==NULL?"":$this->db->where('spc_sem_id', $sem));
        $this->db->where('school_year', $school_year);
        $this->db->join('c_subjects_per_course','c_subjects.s_id = c_subjects_per_course.spc_sub_id', 'left');
        $q = $this->db->get('c_subjects');
        return $q;
    }
    
    function collegeSubjects($limit=NULL, $offset=NULL)
    {
        if($limit!=NULL||$offset=NULL){
                $this->db->limit($limit, $offset);	
        }
        $q = $this->db->get('c_subjects');
        return $q;
    }
    
    function addCollegeSubject($subjects, $sDesc, $sCode, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('s_desc_title', $sDesc);
        $this->db->where('sub_code', $sCode);
        $q = $this->db->get('c_subjects');
        if($q->num_rows()>0):
            return FALSE;
        else:
            if($this->db->insert('c_subjects', $subjects)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
            
        endif;
    }
    
    function editCollegeSubject($subjects, $sDesc, $sCode,$s_id, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year==NULL?$this->session->school_year:$school_year));
        $this->db->where('s_id', $s_id);
        $query = $this->db->get('c_subjects');
        if($query->num_rows()>0):
                $this->db->where('s_id', $s_id);
                if($this->db->update('c_subjects', $subjects)):
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                    return TRUE;
                else:
                    return FALSE;
                endif;
        else:
            return FALSE;
        endif;
    }
    
    
    function getBasicInfo($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('profile');
        return $query->row();
    }
    
}
