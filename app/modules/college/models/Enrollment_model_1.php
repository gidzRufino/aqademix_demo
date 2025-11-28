<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Enrollment_model
 *
 * @author genesisrufino
 */
class Enrollment_model extends CI_Model {
    //put your code here

    function addReligion($code, $name)
    {
        $check = $this->db->like('religion', $name, 'both')
                            ->get('religion');
        if($check->num_rows() != 0)
        {
            $id = $check->row()->rel_id;
            $this->db->where('rel_id', $id)
                        ->update('religion', array(
                            'religion'   =>  $name
                        ));
            if($this->db->affected_rows() != 0)
            {
                $value = $this->db->get('religion')->result();
                $html = '';
                foreach($value AS $v):
                    $html .= "<option value='".$v->rel_id."'>".$v->religion."</option>";
                endforeach;
                return array("success"=>1,"message"=>"Religion successfully updated","details"=>$html);
            }
            else
            {
                return array("success"=>1000,"message"=>"Religion name has not been changed because it doesn't have any difference.");
            }
        }
        else
        {
            $this->db->insert('religion', array(
                'religion'  =>  $name,
                'rel_id'    =>  $code,
            ));
            if($this->db->affected_rows() != 0)
            {
                $value = $this->db->get('religion')->result();
                $html = '';
                foreach($value AS $v):
                    $html .= "<option value='".$v->rel_id."'>".$v->religion."</option>";
                endforeach;
                return array("success"=>"1","message"=>"Religion has been added successfully","details"=>$html);
            }
            else
            {
                return array("success"=>"0","message"=>"Something went wrong while adding religion","error"=>$this->db->error());
            }
        }
    }

    function isPreviouslyEnrolled($st_id, $school_year, $isCollege, $semester = NULL)
    {
        $num_rows = 0;
        $this->load->dbutil();
        $this->db = $this->eskwela->db($school_year);
        if($isCollege):
            while($num_rows==0):                    
                $db_name = DB_PREFIX.strtolower($this->eskwela->getSet()->short_name).'_'.$school_year; // local db
                if($this->dbutil->database_exists($db_name))
                {
                    $eskwelaDB = $this->eskwela->db($school_year);
                    if($eskwelaDB):
                        $this->db->where('st_id', $st_id);
                        ($semester!=NULL?$this->db->where('semester', $semester):'');
                        $this->db->where('school_year', $school_year);
                        $q = $this->db->get('profile_students_c_admission');
                        $num_rows = $q->num_rows();
                    else:
                        break;
                    endif;
                    if($semester!=1):
                        $semester--;
                    else:
                        $semester=3;
                        $school_year--;
                    endif;
                }else{
                    break;
                }    
            endwhile;
        else:
            while($num_rows==0):
                $db_name = DB_PREFIX.strtolower($this->eskwela->getSet()->short_name).'_'.$school_year; // local db

                $eskwelaDB = $this->eskwela->db($school_year);
                if($this->dbutil->database_exists($db_name))
                {
                    if($eskwelaDB):
                        $this->db->where('st_id', $st_id);
                        ($semester!=NULL?$this->db->where('semester', $semester):'');
                        $this->db->where('school_year', $school_year);
                        $q = $this->db->get('profile_students_admission');
                        $num_rows = $q->num_rows();
                    else:
                        break;
                    endif;
                    $school_year--;
                
                }else{
                    break;
                } 
            endwhile;
        endif;
        if($num_rows>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function deletePadala($id)
    {
        $check = $this->db->where('pc_id', $id)
                            ->get('padala_centers');
        if($check->num_rows() != 0)
        {
            $this->db->where('pc_id', $id)
                    ->delete('padala_centers');
            if($this->db->affected_rows() != 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    function updatePadala($id, $data)
    {
        $check = $this->db->where('pc_id', $id)
                            ->get('padala_centers');
        if($check->num_rows() != 0)
        {
            if(array_key_exists('pc_logo', $data)):
                $filename = $check->row()->pc_logo;
                if(!empty($filename)):
                    $this->load->helper('file');
                    unlink('./images/banks/'.$filename);
                endif;
            endif;
            $this->db->where('pc_id', $id)
                        ->update('padala_centers', $data);
            if($this->db->affected_rows() != 0)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    function addPadala($data)
    {
        $check = $this->db->like('pc_name', $data['pc_name'], 'both')
                    ->get('padala_centers');
        if($check->num_rows() == 0)
        {
            $this->db->insert('padala_centers', $data);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    function fetchPadala($__S, $__T)
    {
        if($__S == NULL):
            return $this->db->where('pc_status', 1)
                            ->where('pc_type', $__T)
                            ->get('padala_centers');
        else:
            return $this->db->get('padala_centers');
        endif;
    }
    
    
    function checkPerDeptList($dept) {
        $this->db->join('enrollment_requirments_list', 'enrollment_requirments_list.eReq_list_id = enrollment_req_per_dept.eReq_id', 'left');
        $this->db->where('dept_id', $dept);
        return $this->db->get('enrollment_req_per_dept')->result();
    }
    
    function updateEnrollmentReq($stid, $link, $req_id, $school_year) {
        
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('checklist_st_id', $stid);
        $this->db->where('item_checked', $req_id);
        $q = $this->db->get('enrollment_checklist');

        if ($q->num_rows() > 0):
            $data = array(
                'item_checked' => $req_id,
                'file_link' => $link
            );
            $this->db->update('enrollment_checklist', $data);
        else:
            $data = array(
                'e_checklist_id' => $this->eskwela->code(),
                'checklist_st_id' => $stid,
                'item_checked' => $req_id,
                'file_link' => $link
            );
            $this->db->insert('enrollment_checklist', $data);
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        endif;
    }
    
    function checkReq($stid, $req_id) {
        $this->db->where('checklist_st_id', $stid);
        $this->db->where('item_checked', $req_id);
        $q = $this->db->get('enrollment_checklist');
        return $q->row();
    }

    
    function getSummaryOfBasicEdStudents($semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('semester', $semester);
        $this->db->where('status', 1);
        $q = $this->db->get('profile_students_admission');
        return $q;
    }
    
    function getSummaryOfStudents($course_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('semester', $semester);
        $this->db->where('course_id', $course_id);
        $this->db->where('status', 1);
        $q = $this->db->get('profile_students_c_admission');
        return $q;
    }
    
    function getEnrollmentList($semester, $school_year, $groupBy = FALSE)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.course_id');
        $this->db->where('semester', $semester);
        ($groupBy?$this->db->group_by('profile_students_c_admission.course_id'):'');
        $this->db->where('status', 1);
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $q = $this->db->get('profile_students_c_admission');
        return $q;
    }
    
    function getSectionByLevel($level, $sy=NULL)
    {
        if($sy==NULL):
            $sy = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->select('section.section_id as s_id');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('schedule', 'section.schedule_id = schedule.sched_id', 'left');
        $this->db->where('grade_level_id', $level);
        $this->db->order_by('section.section_id','ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function getBasicEdStudentByUserId($st_id, $school_year, $semester)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->join('profile_students', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        $this->db->where('profile_students_admission.user_id', $st_id);
        $this->db->where('profile_students_admission.semester', $semester);
        $this->db->where('profile_students_admission.school_year', $school_year);
        
        $query = $this->db->get('profile_students_admission');
        return $query->row();
    }
    
    function approveBasicEdOnline($adm_id, $school_year = NULL, $status =NULL)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('admission_id', $adm_id);
        if($this->db->update('profile_students_admission', array('status' => $status))):
                
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getBasicStudPerStatus($status, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('semester', $semester);
        ($status==NULL?'':$this->db->where('profile_students_admission.status', $status));
        $this->db->join('grade_level','profile_students_admission.grade_level_id = grade_level.grade_id','left');
        $this->db->join('profile','profile_students_admission.user_id = profile.user_id','left');
        $this->db->order_by('date_admitted','ASC');
        $q = $this->db->get('profile_students_admission');
        return $q;
        
    }
    
    function saveBasicEnrollmentDetails($st_id, $level_id, $sub_id, $is_overload, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('level_id', $level_id);
        $this->db->where('sub_id', $sub_id);
        $this->db->where('is_overload', $is_overload);
        $q = $this->db->get('subject_overload');
        if($q->num_rows()==0):
            $details = array(
                'st_id'         => $st_id,
                'level_id'      => $level_id,
                'sub_id'        => $sub_id,
                'is_overload'   => $is_overload,
                'sem'           => $is_overload
                );
            $this->db->insert('subject_overload', $details);
        endif;
        
    }
    
    function saveBasicRO($details, $school_year)
    {
        $db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        if($db->insert('profile_students_admission', $details)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
           $return = array(
               'status'     => TRUE,
               'adm_id'     => $db->insert_id(),
           );
           return json_encode($return);
        else:
            return FALSE;
        endif;
    }
    
   function checkBasicRO($st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $query = $this->db->get('profile_students_admission');
        
        if($query->num_rows() > 0):
            return json_encode(array(
                'st_id'         => $query->row()->st_id,
                'school_year'  => $query->row()->school_year,
                'semester'     => $query->row()->semester
            ));
        else:
            return FALSE;
        endif;
    }
    
    function traceEnrollees($school_year, $sem = NULL, $status)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id','left');
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->where('enrolled_online', 1);
        ($status!=NULL?$this->db->where('profile_students_c_admission.status',$status):$this->db->where('profile_students_c_admission.status !=', 1));
        ($sem==NULL?$this->db->where('semester <', 3):$this->db->where('semester', $sem));
        $this->db->order_by('profile_students_c_admission.st_id','DESC');
        //$this->db->group_by('profile_students_c_admission.st_id');
        return $this->db->get('profile_students_c_admission')->result();
        
    }
    
    function getAdmissionRemarks($st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('rem_to', $st_id);
        $this->db->where('rem_semester', $semester);
        $q = $this->db->get('profile_students_c_load_remarks');
        return $q->row();
        
    }
    
    function sendAdmissionRemarks($remarkDetails, $st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('rem_to', $st_id);
        $this->db->where('rem_semester', $semester);
        $q = $this->db->get('profile_students_c_load_remarks');
        if($q->num_rows()==0):
            if($this->db->insert('profile_students_c_load_remarks', $remarkDetails)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            endif;
        else:
            $this->db->where('rem_to', $st_id);
            $this->db->where('rem_semester', $semester);
            if($this->db->update('c_finance_remarks', $remarkDetails)):
                
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            endif;
        endif;
        
        return FALSE;
        
    }
    
    
    function getStudPerStatus($status, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('semester', $semester);
        ($status==NULL?'':$this->db->where('profile_students_c_admission.status', $status));
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id','left');
        $this->db->order_by('date_admitted','ASC');
        $q = $this->db->get('profile_students_c_admission');
        return $q;
        
    }
    
    function approveLoad($adm_id, $school_year = NULL, $status =NULL)
    {
        $this->db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $this->db->where('cl_adm_id', $adm_id);
        if($this->db->update('profile_students_c_load', array('is_final' => 1))):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                
                $this->db->where('admission_id'. $adm_id);
                $this->db->update('profile_students_c_admission', array('status' => $status));
                
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
//admission    
    
    function checkName($lastname, $firstname, $middlename, $school_year)
    {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('lastname', $lastname);
        $this->db->where('firstname', $firstname);
        $q = $this->db->get('profile');
        if($q->num_rows() == 0):
            $this->db->where('lastname', $lastname);
            $this->db->where('firstname', $firstname);
            $this->db->where('middlename', $middlename);
            $q1 = $this->db->get('profile');
            if($q1->num_rows() == 0):
                return FALSE;
            else:
                return TRUE;
            endif;
        else:
            return TRUE;
        endif;
        
    }
    
    public function checkIdIfExist($st_id) {
        $this->db->where('st_id', $st_id);
        $q = $this->db->get('profile_students');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveMed($btype, $allergies, $others, $physician, $height, $weight, $userid, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $data = array(
            'user_id' => $userid,
            'physician_id' => $physician,
            'allergies' => $allergies,
            'other_important' => $others,
            'blood_type' => $btype,
            'height' => $height,
            'weight' => $weight
        );

        $this->db->insert('profile_medical', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        return;
    }
    
    public function saveParentDetails($parentDetails, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->insert('profile_parent', $parentDetails);
        return;
    }
    
    function saveOccupation($occupation, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('occupation', $occupation);
        $query = $this->db->get('profile_occupation');
        if ($query->num_rows() == 0):
            $this->db->insert('profile_occupation', array('occupation' => $occupation));
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            $occ_id = $this->db->insert_id();
        else:
            $occ_id = $query->row()->occ_id;
        endif;

        return $occ_id;
    }
    function setBasicEdInfo($uid, $profile_id, $gradeLevel, $section_id, $strand, $en_date, $school_year, $semester, $sla, $asla) {
        $this->db = $this->eskwela->db($school_year);
        
        $data1 = array(
            'st_id' => $uid,
            'user_id' => $profile_id,
        );

        $this->db->insert('profile_students', $data1);
        $runScript = $this->db->last_query();
        
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        $data = array(
            'admission_id'      => $this->eskwela->code(),
            'school_year'       => $school_year,
            'date_admitted'     => $en_date,
            'user_id'           => $profile_id,
            'grade_level_id'    => $gradeLevel,
            'section_id'        => $section_id,
            'school_last_attend'=> $sla,
            'sla_address'    => $asla,
            'semester'          => $semester==3?3:0,
            'st_id'             => $uid,
            'str_id'            => $strand,
            'st_type'           => $semester==3?6:0,
            'status'            => 0,
            'enrolled_online'   => 1
                );

        $this->db->insert('profile_students_admission', $data);
        
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
    }
    
    function setCollegeInfo($uid, $profile_id, $course, $year, $en_date, $school_year, $semester, $sla, $asla) {
        $this->db = $this->eskwela->db($school_year);
        
        $data1 = array(
            'st_id' => $uid,
            'user_id' => $profile_id,
            'parent_id' => 0,
                );

        $this->db->insert('profile_students', $data1);
        $runScript = $this->db->last_query();
        
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        $data = array(
            'admission_id'      => $this->eskwela->code(),
            'school_year' => $school_year,
            'semester' => $semester,
            'st_id' => $uid,
            'user_id' => $profile_id,
            'course_id' => $course,
            'year_level' => $year,
            'date_admitted' => $en_date,
            'status' => 0,
            'school_last_attend' => $sla,
            'sla_address_id' => $asla,
            'enrolled_online' => 1
                );

        $this->db->insert('profile_students_c_admission', $data);
        
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
    }
    
    function setParentsPro($data, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('profile_parents', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }

    function setBarangay($barangay, $barangay_id, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('barangay', $barangay);
        $query = $this->db->get('barangay');
        if ($query->num_rows() > 0):
            return $query->row()->barangay_id;
        else:
            $data = array('barangay_id'=>$barangay_id,'barangay' => $barangay);
            $this->db->insert('barangay', $data);
            
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);

            return $this->db->insert_id();
        endif;
    }
    
    function setContacts($mobile, $email, $profile_id, $school_year) {
        
        $this->db = $this->eskwela->db($school_year);
        $data1 = array(
            'contact_id'  => $profile_id,
            'cd_phone'    => 0,
            'cd_mobile'   => $mobile,
            'cd_email'    => $email
        );
        $this->db->insert('profile_contact_details', $data1, $school_year);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }

    function setUpdateContact($con_id, $id) {
        
        $data = array(
            'contact_id' => $con_id
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript);
    }
    function setAddress($data, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('profile_address_info', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }
    
    function saveProfile($data, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('profile', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        
        return $this->db->insert_id();
    }
    
    function getLatestBasicEdNum($school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('esk_profile_temp_id_code');
        $this->db->select('temp_id');
        $this->db->from('profile_temp_id');
        $this->db->order_by('esk_profile_temp_id_code', 'DESC');
        $query = $this->db->get();
        $generated_id = $query->row();

        return $generated_id;
    }
    
    function saveTempID($st_id, $generatedCode, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('profile_temp_id', array('temp_id' => $generatedCode, 'generated_id' => $st_id))):
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return;
        endif;
    }
    
    function getLatestCollegeNum($school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('admission_id');
        $this->db->select('st_id');
        $this->db->from('profile_students_c_admission');
        $this->db->order_by('admission_id', 'DESC');
        $query = $this->db->get();
        $generated_id = $query->row()->admission_id;

        return $generated_id;
    }
    
    function getEducAttain() {
        $query = $this->db->get('profile_educ_attain');
        return $query->result();
    }
    
    function confirmPayment($st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('opr_st_id', $st_id)
                 ->where('opr_sem', $semester);
        if($this->db->update('c_finance_online_receipts', array('opr_is_confirm' => 1, 'opr_confirm_by' => $this->session->employee_id))):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function getUploadedReceipt($st_id, $semester, $school_year, $trans_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('opr_st_id', $st_id)
                 ->where('opr_sem', $semester);
        $q = $this->db->get('c_finance_online_receipts');
        return $q;
    }
    
    function savePaymentReceipt($st_id,$filename, $school_year, $semester)
    {
        $this->db = $this->eskwela->db($school_year);
        $details = array(
            'opr_st_id'     => $st_id,
            'opr_img_link'  => $filename,
            'opr_date'      => date('Y-m-d'),
            'opr_sem'       => $semester,
            
        );
        
        if($this->db->insert('c_finance_online_receipts', $details)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getFinanceRemarks($st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('fr_to', $st_id);
        $this->db->where('fr_semester', $semester);
        $this->db->where('fr_year', $school_year);
        $q = $this->db->get('c_finance_remarks');
        return $q->row();
        
    }
    
    function saveFinanceRemarks($remarkDetails, $st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('fr_to', $st_id);
        $this->db->where('fr_semester', $semester);
        $this->db->where('fr_year', $school_year);
        $q = $this->db->get('c_finance_remarks');
        if($q->num_rows()==0):
            if($this->db->insert('c_finance_remarks', $remarkDetails)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            endif;
        else:
            $this->db->where('fr_to', $st_id);
            $this->db->where('fr_semester', $semester);
            $this->db->where('fr_year', $school_year);
            if($this->db->update('c_finance_remarks', $remarkDetails)):
                
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            endif;
        endif;
        
        return FALSE;
        
    }
    
    function updateEnrollmentStatus($st_id, $status,$semester, $school_year, $ifBasicEd)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $semester);
        $this->db->where('school_year', $school_year);
        
        if($ifBasicEd==NULL):
            if($this->db->update('profile_students_c_admission', array('status' => $status))):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            if($this->db->update('profile_students_admission', array('status' => $status))):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function removeSubject($subject_id, $st_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('cl_user_id', $st_id);
        $this->db->where('cl_sub_id', $subject_id);
        if($this->db->delete('profile_students_c_load')):
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function getStudentDetailsBasicEd($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as status');
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $school_year);
        $this->db->join('profile','profile_students_admission.user_id = profile.user_id','left');
        $this->db->join('grade_level','profile_students_admission.grade_level_id = grade_level.grade_id','left');
        $this->db->join('profile_parent','profile_students_admission.user_id = profile_parent.u_id','left');
        return $this->db->get('profile_students_admission')->row();
    }
    
    function getStudentDetails($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $school_year);
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id','left');
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->join('profile_contact_details','profile.contact_id = profile_contact_details.contact_id', 'left');
        return $this->db->get('profile_students_c_admission')->row();
    }
    
    function getOnlineBasicEdEnrollees($school_year, $sem = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as status');
        $this->db->join('profile','profile_students_admission.user_id = profile.user_id','left');
        $this->db->join('grade_level','profile_students_admission.grade_level_id = grade_level.grade_id','left');
        $this->db->where('enrolled_online', 1);
        $this->db->where('profile_students_admission.status !=', 1);
        ($sem==NULL?$this->db->where('semester <', 3):$this->db->where('semester', $sem));
        $this->db->order_by('profile_students_admission.status','DESC');
        $this->db->group_by('profile_students_admission.st_id');
        $this->db->limit(15);
        return $this->db->get('profile_students_admission')->result();
        
    }
    
    function getOnlineEnrollees($school_year, $sem = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->join('profile','profile_students_c_admission.user_id = profile.user_id','left');
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->where('enrolled_online', 1);
        $this->db->where('profile_students_c_admission.status !=', 1);
        ($sem==NULL?$this->db->where('semester <', 3):$this->db->where('semester', $sem));
        $this->db->order_by('profile_students_c_admission.status','DESC');
        $this->db->group_by('profile_students_c_admission.st_id');
        $this->db->limit(15);
        return $this->db->get('profile_students_c_admission')->result();
        
    }
    
    function hasLoadedSubjects($adm_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('cl_adm_id', $adm_id);
        $q = $this->db->get('profile_students_c_load');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function checkIfEnrolled($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $school_year);
        $this->db->join('profile_students_c_load', 'profile_students_c_admission.admission_id = profile_students_c_load.cl_adm_id', 'left');
        $this->db->join('c_subjects', 'profile_students_c_load.cl_sub_id = c_subjects.s_id', 'left');
        $q = $this->db->get('profile_students_c_admission');
        if($q->num_rows() > 0):
            $jsonArray = array(
                'isEnrolled'    => TRUE,
                'row'           => $q->row(),
                'results'       => $q->result()
            );
        else:
            $jsonArray = array(
                'isEnrolled'    => FALSE,
                'details'       => []
            );
        endif;
        
        return json_encode($jsonArray);
    }
    
    function saveEnrollmentDetails($details, $school_year, $user_id, $subject_id)
    {
        $db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        $db->where('cl_user_id', $user_id);
        $db->where('cl_sub_id', $subject_id);
        $q = $db->get('profile_students_c_load');
        if($q->num_rows()==0):
            $db->insert('profile_students_c_load', $details);
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
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
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
           $return = array(
               'status'     => TRUE,
               'adm_id'     => $db->insert_id(),
           );
           return json_encode($return);
        else:
            return FALSE;
        endif;
    }
    
    function insertData($details, $table, $column=NULL, $value=NULL, $school_year = NULL)
    {
        $db = $this->eskwela->db($school_year==NULL?$this->session->school_year:$school_year);
        if($column==NULL):
            if($db->insert($table, $details)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript,$school_year);
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
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                   return TRUE;
                else:
                    return FALSE;
                endif;
            else:
                if($db->insert($table, $details)):
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                   return TRUE;
                else:
                    return FALSE;
                endif;
                
            endif;    
        endif;
    }
    
    
    function checkCollegeRO($user_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('user_id', $user_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $query = $this->db->get('profile_students_c_admission');
        
        if($query->num_rows() > 0):
            return json_encode(array(
                'admission_id' => $query->row()->admission_id,
                'school_year'  => $query->row()->school_year,
                'semester'     => $query->row()->semester
            ));
        else:
            return FALSE;
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
    
    function searchBasicEdSubject($subject, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->like('LOWER(subject)', strtolower($subject));
        $q = $this->db->get('subjects');
        return $q->result();
    }
         
    function searchSubject($value, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->join('c_schedule', 'c_subjects_per_course.spc_course_id = c_schedule.cs_spc_id','left');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->like('LOWER(sub_code)', strtolower($value));
        $this->db->limit(20);
        $this->db->group_by('c_section.sec_id');
        $query = $this->db->get();
        return $query->result();
    }
         
    function getSubject($value, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('c_subjects');
        $this->db->join('c_subjects_per_course', 'c_subjects.s_id = c_subjects_per_course.spc_sub_id','left');
        $this->db->join('c_section', 'c_subjects.s_id = c_section.sec_sub_id', 'inner');
        $this->db->join('c_schedule', 'c_subjects_per_course.spc_course_id = c_schedule.cs_spc_id','left');
        $this->db->where('c_section.sec_sem', $semester);
        $this->db->where('LOWER(sub_code)', strtolower($value));
        $this->db->limit(20);
        $this->db->group_by('c_section.sec_id');
        $query = $this->db->get();
        return $query->result();
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
    
    function getBasicEducationDetails($id)
    {
        $settings = Modules::run('main/getSet');
        $school_year = $settings->school_year;
        
        $this->db->select('*', 'profile_students_admission.st_id as stid, profile_students_admission.section_id as section_id');
        $this->db->where('profile_students_admission.st_id', $id);
        $this->db->join('profile_students','profile_students.st_id = profile_students_admission.st_id','left');
        $this->db->join('profile','profile_students.user_id = profile.user_id','left');
        $this->db->join('grade_level','profile_students_admission.grade_level_id = grade_level.grade_id','left');
        $this->db->order_by('admission_id','DESC');
        $query = $this->db->get('profile_students_admission');
        $num_rows = $query->num_rows;
       
        while($num_rows==0):
            $eskwelaDB = $this->eskwela->db($school_year);
            if($eskwelaDB):
                $this->db = $this->eskwela->db($school_year);
                $this->db->select('*', 'profile_students.st_id as stid');
                $this->db->where('profile_students_admission.st_id', $id);
                $this->db->join('profile_students','profile_students.st_id = profile_students_admission.st_id','left');
                $this->db->join('profile','profile_students.user_id = profile.user_id','left');
                $this->db->join('grade_level','profile_students_admission.grade_level_id = grade_level.grade_id','left');
                $this->db->order_by('admission_id','DESC');
                $query = $this->db->get('profile_students_admission');
                $num_rows = $query->num_rows();
            else:
                break;
            endif;   
            $school_year--;
        endwhile;
        
        return $query->row();
        
    }
    
    function getDetails($id)
    {
        $settings = Modules::run('main/getSet');
        $school_year = $settings->school_year;
        
        $this->db->select('*', 'profile_students.st_id as stid');
        $this->db->where('profile_students.st_id', $id);
        $this->db->join('profile','profile_students.user_id = profile.user_id','left');
        $this->db->join('profile_students_c_admission','profile_students.st_id = profile_students_c_admission.st_id','left');
        $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id','left');
        $this->db->order_by('admission_id','DESC');
        $query = $this->db->get('profile_students');
        $num_rows = $query->num_rows();
        
        while($num_rows==0):
            $school_year--;
            $eskwelaDB = $this->eskwela->db($school_year);
            if($eskwelaDB):
                $this->db = $this->eskwela->db($school_year);
                $this->db->select('*', 'profile_students.st_id as stid');
                $this->db->where('profile_students.st_id', $id);
                $this->db->join('profile','profile_students.user_id = profile.user_id','left');
                $this->db->join('profile_students_c_admission','profile_students.st_id = profile_students_c_admission.st_id','left');
                $this->db->join('c_courses','profile_students_c_admission.course_id = c_courses.course_id','left');
                $this->db->order_by('admission_id','DESC');
                $query = $this->db->get('profile_students');
                $num_rows = $query->num_rows();
            else:
                break;
            endif;    
        endwhile;
        
        return $query->row();
        
    }
    function fetch_otp($id)
    {
        $this->db->where('otp_user', $id);
        $this->db->where('otp_trans_date', date('Y-m-d'));
        $q = $this->db->get('otp_access');
        return $q->row();
        
    }
    
    function saveOTP($id, $pword, $sys_code, $school_year = NULL)
    {
        $settings = Modules::run('main/getSet');
        $this->db = $this->eskwela->db(($school_year==NULL?$settings->school_year:$school_year));
        $otpDetails = array(
            'otp_id'        => $sys_code,
            'otp_user'      => $id,
            'otp_code'      => $pword,
            'otp_trans_date'=> date('Y-m-d')
        );
        
        $this->db->where('otp_user', $id);
        $this->db->where('otp_trans_date', date('Y-m-d'));
        
        $q = $this->db->get('otp_access');
        if($q->num_rows()>0):
            $this->db->where('otp_user', $id);
            $this->db->where('otp_trans_date',date('Y-m-d'));
            $this->db->update('otp_access', $otpDetails);
        else:
            $this->db->insert('otp_access', $otpDetails);
        endif;
        
        return TRUE;
    }
    
    function checkIfIDExist($id)
    {
        for($i=date('Y');$i>=2019;$i--):
            $eskwelaDB = $this->eskwela->db($i);
            if($eskwelaDB):
                $this->db = $this->eskwela->db($i);
                $this->db->join('profile','profile_students.user_id = profile.user_id','left');
                $this->db->join('profile_parent','profile.user_id = profile_parent.u_id','left');
                $this->db->join('profile_contact_details','profile.contact_id = profile_contact_details.contact_id','left');
                $this->db->where('profile_students.st_id', $id);
                $query = $this->db->get('profile_students');
                if($query->num_rows() > 0):
                    $jsonResponse = array('status'=>TRUE, 'details' => $query->row());
                    break;
                else:
                    $this->db->join('profile','profile_students.user_id = profile.user_id','left');
                    $this->db->join('profile_parent','profile.user_id = profile_parent.u_id','left');
                    $this->db->join('profile_contact_details','profile.contact_id = profile_contact_details.contact_id','left');
                    $this->db->where('profile_students.lrn', $id);
                    $query = $this->db->get('profile_students');
                    if($query->num_rows() > 0):
                        $jsonResponse = array('status'=>TRUE, 'details' => $query->row());
                        break;
                    else:
                        $jsonResponse = array('status'=>FALSE, 'details'=>[],'year' => $i.' - 1');
                        
                    continue;
                    endif;
                endif;
                return json_encode($jsonResponse);
            else:
                $jsonResponse = array('status'=>FALSE, 'details'=>[] ,'year' => $i.' - 2');
                continue;
            endif;
        endfor;
        
        return json_encode($jsonResponse);
    }
    
    function removeEnDetails($school_year, $admission_id)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('admission_id', $admission_id);
        if($this->db->delete('profile_students_c_admission')):
            $this->db->where('cl_adm_id', $admission_id);
            if($this->db->delete('profile_students_c_load')):
                return TRUE;
            endif;
        endif;
    }
    
    function getGradeLevelById($grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        return $this->db->where('grade_id', $grade_id)
                        ->get('grade_level')
                        ->row();
    }
    
    
}
