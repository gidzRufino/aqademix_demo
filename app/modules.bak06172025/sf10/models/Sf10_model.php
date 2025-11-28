<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sf10_model extends CI_Model {
    
    function checkSpecialClass($st_id, $school_year, $subject_id, $sem)
    {
        
        $this->db->join('subjects', 'gs_final_card.subject_id = subjects.subject_id','left');
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $school_year);
        ($subject_id!=NULL?$this->db->where('gs_final_card.subject_id', $subject_id):'');
        ($subject_id==NULL?$this->db->group_by('gs_final_card.subject_id'):'');
        $this->db->where('is_special', 1);
        $this->db->where('grading != ', 0);
        ($sem==1?$this->db->where('grading <',3):$this->db->where('grading >',2));
        $q = $this->db->get('gs_final_card');
        return $q;
    }
            
    function saveFinalCard($details, $st_id, $grading, $school_year, $subject_id)
    {
        
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('st_id', $st_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('grading', $grading);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_final_card');
        if($q->num_rows()==0):
            $this->db->insert('gs_final_card', $details);
        else:
            $this->db->where('st_id', $st_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->where('grading', $grading);
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_final_card', $details);
        endif;
        
        return;
    }
    
    function getPreviousSchoolDays($school_name, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('school_name', trim($school_name));
        $this->db->join('gs_spr_school', 'gs_spr_school.sch_id = gs_num_of_sdays_per_year.spr_school_id','left');
        $q = $this->db->get('gs_num_of_sdays_per_year');
        return $q->row();
       
    }

    function saveSchoolDays($attendance_details, $school_id,$school_year)
    {
        
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('spr_school_id', $school_id);
        $q = $this->db->get('gs_num_of_sdays_per_year');
        if($q->num_rows() == 0):
            if($this->db->insert('gs_num_of_sdays_per_year', $attendance_details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('spr_school_id', $school_id);
            if($this->db->update('gs_num_of_sdays_per_year', $attendance_details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function saveSchoolDetails($schoolDetails, $school_name, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('school_name', $school_name);
        $q = $this->db->get('gs_spr_school');
        if($q->num_rows()==0):
            $this->db->insert('gs_spr_school', $schoolDetails);
            return $this->db->insert_id();
        else:
            return $q->row()->sch_id;
        endif;
    }
    
    function getAvatar($id) {
        
        $this->db->select('avatar');
        $this->db->where('st_id', $id);
        $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile');
        return $query->row()->avatar;
    }
    
    function getAcadAverage($spr_id, $semester)
    {
        $this->db->where('spr_id', $spr_id);
        $this->db->where('sem', $semester);
        $this->db->where('subject_id', 0);
        return $this->db->get('gs_spr_ar')->row();
    }
            
    function saveAttendanceOveride($attendance_details, $spr_id, $for_school, $school_year, $column, $numberOfDays)
    {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('spr_id', $spr_id);
        ($for_school==0?$this->db->where('is_school', $for_school):'');
        $q  = $this->db->get('gs_spr_attendance');
        if($q->num_rows() > 0 ):
            $this->db->where('spr_id', $spr_id);
            ($for_school==0?$this->db->where('is_school', $for_school):'');
            if($this->db->update('gs_spr_attendance', $attendance_details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $data = array(
                'spr_att' => $this->eskwela->code(),
                'spr_id' => $spr_id,
                $column => $numberOfDays,
                'is_school' => $for_school
            );
            if($this->db->insert('gs_spr_attendance', $data)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
        
        
    }
            
    function deleteRecord($ar_id, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('ar_id', $ar_id);
        if ($this->db->delete('gs_spr_ar')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function editAR($ar_id, $arDetails, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('ar_id', $ar_id);
        $this->db->update('gs_spr_ar', $arDetails);
        return;
    }

    function getSubjectArray($subject_id, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject_id);
        $q = $this->db->get('subjects');
        return $q->row();
    }

    function checkInSubject($subject_id, $school_year, $subjectArray) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));

        if ($this->checkTableExist('esk_subjects', $school_year)):
            $this->db->where('subject_id', $subject_id);
            $q = $this->db->get('subjects');
            if ($q->num_rows() == 0):
                $this->db->insert('subjects', $subjectArray);
            endif;
        else:
            $settings = $this->eskwela->getSet();
            $db_name = 'eskwela_' . strtolower($settings->short_name) . '_' . $school_year;

            $file = 'subject.sql';

            $this->createSPRTables($db_name, $file);
            sleep(2);
            $this->db->insert('subjects', $subjectArray);

        endif;
    }

    function checkTableExist($table, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));

        if ($this->db->table_exists($table)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function createSPRTables($database, $file) {
        // Connect to the database
        $mysqli = new mysqli('localhost', $this->db->username, $this->db->password, $database);

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents(APPPATH . 'modules/sf10/views/db/' . $file);

        // Execute a multi query
        $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        return true;
    }

    function getSHSubjects($gradeLevel, $sem, $strand_id, $core) {
        $this->db->where('semester', $sem);
        $this->db->where('grade_id', $gradeLevel);
        $this->db->where('strand_id', $strand_id);
        if ($core != NULL):
            $this->db->where('is_core', $core);
        endif;
        $this->db->join('subjects', 'sh_subjects.sh_sub_id = subjects.subject_id', 'left');
        $q = $this->db->get('sh_subjects');
        return $q->result();
    }

    function getSubjectById($sub_id) {
        return $this->db->where('subject_id', $sub_id)
                        ->db->get('subjects')
                        ->row();
    }
    
    function getAcadRecords($spr_id, $school_year, $grade_level, $semester = NULL) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->select('*');
        $this->db->from('gs_spr_ar');
        $this->db->join('subjects', 'gs_spr_ar.subject_id = subjects.subject_id', 'left');
        $this->db->where('spr_id', $spr_id);
        ($semester != NULL ? $this->db->where('sem', $semester) : '');
        $query = $this->db->get();
        return $query;
    }

    function checkAcadExist($user_id, $school_year, $semester = NULL) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('st_id', $user_id);
        ($semester != NULL ? $this->db->where('semester', $semester) : '');
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_spr');
        if ($query->num_rows() > 0):
            return $query->row()->spr_id;
        else:
            return FALSE;
        endif;
    }

    function updateBasicSPR($spr_id, $details, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr', $details);
        return;
    }

    function saveAR($ar, $spr_id = NULL, $subject_id = NULL, $school_year = NULL, $semester = NULL) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        ($spr_id != NULL ? $this->db->where('spr_id', $spr_id) : '');
        ($subject_id != NULL ? $this->db->where('subject_id', $subject_id) : '');
        ($semester != NULL ? $this->db->where('sem', $semester) : '');
        $q = $this->db->get('gs_spr_ar');
        if ($q->num_rows() > 0):
            $this->db->where('spr_id', $spr_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->where('sem', $semester);
            $this->db->update('gs_spr_ar', $ar);
        else:
            $this->db->insert('gs_spr_ar', $ar);
        endif;
        return;
    }

    function saveSPR($spr, $school_year, $st_id) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));

        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_spr');
        if ($q->num_rows() == 0):
            $this->db->insert('gs_spr', $spr);
            return $this->db->insert_id();
        else:
            return $q->row()->spr_id;
        endif;
    }

    function updateFinalGrade($st_id, $lrn) {
        $details = array('st_id' => $st_id);
        $this->db->where('st_id', $lrn);
        if ($this->db->update('gs_final_card', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function updateGSBySection($lrn, $st_id, $section_id) {
        $details = array('st_id' => $st_id);
        $i = 0;
        $this->db->where('gs_assessment.section_id', $section_id);
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $q = $this->db->get('gs_raw_score');
        foreach ($q->result() as $r):
            $this->db->where('assess_id', $r->assess_id);
            $this->db->where('st_id', $lrn);
            if ($this->db->update('gs_raw_score', $details)):
                $i++;
            endif;
        endforeach;

        return $i;
    }

    function getStudents($section_id) {
        $this->db->where('profile_students_admission.section_id', $section_id);
        $this->db->where('profile_students_admission.status', 1);
        $this->db->where('school_year', 2018);
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile_students_admission');
        return $query;
    }

    function getPersonalInfoByName($lastname, $firstname, $middlename = NULL) {
        $this->db->where('sprp_lastname', $lastname);
        $this->db->where('sprp_firstname', $firstname);
        //$this->db->where('sprp_middlename', $middlename);
        $this->db->join('gs_spr', 'gs_spr_profile.sprp_st_id = gs_spr.st_id', 'left');
        $q = $this->db->get('gs_spr_profile');
        if ($q->num_rows() > 0):
            return $q->row()->spr_id;
        endif;
    }

    function saveTardyDetails($att_details, $spr_id) {
        $this->db->where('spr_id', $spr_id);
        $q = $this->db->get('gs_spr_attendance_tardy');
        if ($q->num_rows() == 0):
            $this->db->insert('gs_spr_attendance_tardy', $att_details);
        else:
            $this->db->where('spr_id', $spr_id);
            $this->db->update('gs_spr_attendance_tardy', $att_details);
        endif;
        return;
    }

    function saveAttendanceDetails($att_details, $spr_id) {
        $this->db->where('spr_id', $spr_id);
        $q = $this->db->get('gs_spr_attendance');
        if ($q->num_rows() == 0):
            $this->db->insert('gs_spr_attendance', $att_details);
        else:
            $this->db->where('spr_id', $spr_id);
            $this->db->update('gs_spr_attendance', $att_details);
        endif;
        return;
    }

    function getLatestIDNum($year) {
        $this->db = $this->eskwela->db($year);
        $q = $this->db->get('gs_spr_profile');
        return $q->num_rows();
    }

    function getGradeLevelId($level) {
        $this->db->where('level', $level);
        $q = $this->db->get('grade_level');
        return $q->row()->grade_id;
    }

    function getSubjectId($subject) {
        $this->db = $this->eskwela->db($this->session->school_year);
        $this->db->where('subject', $subject);
        $q = $this->db->get('subjects');
        if ($q->num_rows() > 0):
            $this->db->select('*');
            $this->db->from('subjects');
            $this->db->where('subject', $subject);
            $query = $this->db->get();
            return $query->row()->subject_id;
        endif;
    }

    function getPreviousStudent($value, $year) {
        //$this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id as stid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('level');
        $this->db->select('section');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students_admission.school_year', $year);
        $this->db->where('profile_students_admission.section_id', $value);
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

//    function checkAcad($grade_id, $st_id) {
//        $this->db->where('st_id', $st_id);
//        $this->db->where('grade_level_id', $grade_id);
//        $q = $this->db->get('gs_spr');
//        return $q->row();
//    }

    function checkAcad($user_id, $school_year, $semester = NULL) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('st_id', $user_id);
        ($semester != NULL ? $this->db->where('semester', $semester) : '');
        $this->db->where('school_year', $school_year);
        $query = $this->db->get('gs_spr');
        if ($query->num_rows() > 0):
            return $query->row()->spr_id;
        else:
            return FALSE;
        endif;
    }

    function getSingleStudent($id, $year, $option, $levelCode = NULL) {
        $settings = Modules::run('main/getSet');
        $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students.parent_id as pid');
        $this->db->select('profile_students_admission.school_year as sy');
        $this->db->select('temp_bdate as bdate');
//        $this->db->select('profile_students_admission.str_id as strandID');
        $this->db->select('profile.bplace_id as bplace');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'inner');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id', 'left');
        if ($option == 1):
            if ($year == NULL):
                $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
            else:
                $this->db->where('profile_students_admission.school_year', $year);
            endif;
        else:
            $this->db->where('profile_students_admission.school_year', ($year == NULL ? $this->session->school_year : $year));
        endif;
        $this->db->where('profile_students.st_id', $id);
        //$this->db->where('profile_students.lrn', $id);
        $query = $this->db->get()->row();

        if ($query->str_id == 0):
            $this->db = $this->eskwela->db($this->session->school_year);
            $this->db->where('st_id', $id);
            $idStrand = $this->db->get('profile_students_admission')->row();
        endif;

        $this->db = $this->eskwela->db($year);
        $this->db->where('sprp_st_id', $id);
        $q = $this->db->get('gs_spr_profile');

        if ($q->num_rows() > 0):

            $data = array(
                'sprp_lrn' => $query->lrn,
                'sprp_gender' => $query->sex,
                'sprp_lastname' => $query->lastname,
                'sprp_firstname' => $query->firstname,
                'sprp_middlename' => $query->middlename,
                'sprp_bdate' => $query->bdate
            );
            $this->db->where('sprp_st_id', $id);
            $this->db->update('gs_spr_profile', $data);

        else:
            $data = array(
                'sprp_st_id' => $id,
                'sprp_lrn' => $query->lrn,
                'sprp_gender' => $query->sex,
                'sprp_lastname' => $query->lastname,
                'sprp_firstname' => $query->firstname,
                'sprp_middlename' => $query->middlename,
                'sprp_bdate' => $query->bdate
            );
            $this->db->insert('gs_spr_profile', $data);
        endif;

        $this->db->where('st_id', $id);
        $s = $this->db->get('gs_spr');

        $advisory = Modules::run('academic/getAdvisory', '', $year, $query->section_id);

        if ($s->num_rows() > 0):
            if($query->grade_id == 12 || $query->grade_id == 13):
                
                $info1 = array(
                    'st_id' => $id,
                    'school_id' => $settings->school_id,
                    'district' => $settings->district,
                    'division' => $settings->division,
                    'region' => $settings->region,
                    'school_name' => $settings->set_school_name,
                    'grade_level_id' => ($levelCode == NULL ? $query->grade_id : $levelCode),
                    'section' => $query->section,
                    'school_year' => $year,
                    'semester' => 1,
                    'time_added' => date('Y-m-d H:i:s')
                ); 
                
                $this->db->where('semester', 1);
                $this->db->where('st_id', $id);
                $q1 = $this->db->get('gs_spr');
                
                if($q1->num_rows() > 0):
                    $this->db->where('semester', 1);
                    $this->db->where('st_id', $id);
                    $this->db->update('gs_spr', $info1);
                else:
                    $this->db->insert('gs_spr', $info1);
                endif;    
                
                $info2 = array(
                    'st_id' => $id,
                    'school_id' => $settings->school_id,
                    'district' => $settings->district,
                    'division' => $settings->division,
                    'region' => $settings->region,
                    'school_name' => $settings->set_school_name,
                    'grade_level_id' => ($levelCode == NULL ? $query->grade_id : $levelCode),
                    'section' => $query->section,
                    'school_year' => $year,
                    'semester' => 2,
                    'time_added' => date('Y-m-d H:i:s')
                );
                
                $this->db->where('semester', 2);
                $this->db->where('st_id', $id);
                $q2 = $this->db->get('gs_spr');
                
                if($q2->num_rows() > 0):
                    $this->db->where('semester',2);
                    $this->db->where('st_id', $id);
                    $this->db->update('gs_spr', $info2);
                else:
                    $this->db->insert('gs_spr', $info2);
                endif; 
            else:
                $info = array(
                'school_id' => $settings->school_id,
                'district' => $settings->district,
                'division' => $settings->division,
                'region' => $settings->region,
                'school_name' => $settings->set_school_name,
                'grade_level_id' => ($levelCode == NULL ? $query->grade_id : $levelCode),
                'section' => $query->section,
                'spr_adviser' => $advisory->row()->firstname . ' ' . substr($advisory->row()->middlename . ' ' . $advisory->row()->lastname),
                'school_year' => $year,
                'time_added' => date('Y-m-d H:i:s'),
    //                'strandid' => $idStrand->str_id
                );
                $this->db->where('st_id', $id);
                $this->db->update('gs_spr', $info);
                
            endif;
        else:
            if($query->grade_id == 12 || $query->grade_id == 13):
                $info1 = array(
                    'st_id'         => $id,
                    'school_id'     => $settings->school_id,
                    'district'      => $settings->district,
                    'division'      => $settings->division,
                    'region'        => $settings->region,
                    'school_name'   => $settings->set_school_name,
                    'grade_level_id'=> ($levelCode == NULL ? $query->grade_id : $levelCode),
                    'section'       => $query->section,
                    'school_year'   => $year,
                    'semester'      => 1,
                    'time_added'    => date('Y-m-d H:i:s'),
                );
                $this->db->insert('gs_spr', $info1);
                
                $info2 = array(
                    'st_id'         => $id,
                    'school_id'     => $settings->school_id,
                    'district'      => $settings->district,
                    'division'      => $settings->division,
                    'region'        => $settings->region,
                    'school_name'   => $settings->set_school_name,
                    'grade_level_id'=> ($levelCode == NULL ? $query->grade_id : $levelCode),
                    'section'       => $query->section,
                    'school_year'   => $year,
                    'semester'      => 2,
                    'time_added'    => date('Y-m-d H:i:s'),
                );
                $this->db->insert('gs_spr', $info2);
                
            else:
                $info = array(
                    'st_id' => $id,
                    'school_id' => $settings->school_id,
                    'district' => $settings->district,
                    'division' => $settings->division,
                    'region' => $settings->region,
                    'school_name' => $settings->set_school_name,
                    'grade_level_id' => ($levelCode == NULL ? $query->grade_id : $levelCode),
                    'section' => $query->section,
                    'school_year' => $year,
                    'time_added' => date('Y-m-d H:i:s'),
    //                'strandid' => $idStrand->str_id
                );
                $this->db->insert('gs_spr', $info);
            endif;    
        endif;

        $this->db->select('*');
        $this->db->join('gs_spr', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->join('gs_spr_profile_address_info', 'gs_spr_profile_address_info.sprp_profile_id = gs_spr_profile.sprp_id', 'left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->where('gs_spr_profile.sprp_st_id', $id);
        return $this->db->get('gs_spr_profile')->row();
    }

    function getStudentInfo($st_id, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->select('*');
        $this->db->select('sprp_st_id as st_id');
        $this->db->select('sprp_firstname as firstname');
        $this->db->select('sprp_lastname as lastname');
        $this->db->select('sprp_middlename as middlename');
        $this->db->select('sprp_bdate as bdate');
        $this->db->select('sprp_bplace as bplace');
        $this->db->select('sprp_nationality as nationality');
        $this->db->join('gs_spr', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->join('gs_spr_profile_address_info', 'gs_spr_profile.sprp_id = gs_spr_profile_address_info.sprp_profile_id', 'left');
//        $this->db->join('barangay', 'gs_spr_profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('religion', 'gs_spr_profile.sprp_rel_id = religion.rel_id', 'left');
        //$this->db->join('gs_spr', 'gs_spr_profile.sprp_st_id = gs_spr.st_id', 'left');
        $this->db->where('sprp_st_id', $st_id);
        $q = $this->db->get('gs_spr_profile');
        return $q->row();
    }

    function getMother($id) {
        $this->db->select('*');
        $this->db->select('profile.user_id as mid');
        $this->db->select('profile.contact_id as con_id');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.mother_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_occupation', 'profile.occupation_id  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parents.parent_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getFather($id) {
        $this->db->select('*');
        $this->db->select('profile.user_id as fid');
        $this->db->select('profile.contact_id as con_id');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.father_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_occupation', 'profile.occupation_id  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parents.parent_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function saveNewInfo($details, $lastname, $firstname, $middlename, $school_year, $stid) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('sprp_st_id', $stid);
        $q = $this->db->get('gs_spr_profile');
        if ($q->num_rows() == 0):
            $this->db->insert('gs_spr_profile', $details);
            $profile_id = $this->db->insert_id();
        else:
            $profile_id = FALSE;
        endif;

        return $profile_id;
    }

    function setBarangay($barangay) {
        $this->db->where('barangay', $barangay);
        $query = $this->db->get('barangay');
        if ($query->num_rows() > 0):
            return $query->row()->barangay_id;
        else:
            $data = array('barangay' => $barangay);
            $this->db->insert('barangay', $data);

            return $this->db->insert_id();
        endif;
    }

    function setAddress($data, $profile_id) {
        $this->db->insert('gs_spr_profile_address_info', $data);

        $this->setUpdateAddress($this->db->insert_id(), $profile_id);
    }

    function setUpdateAddress($add_id, $id) {
        $data = array(
            'sprp_add_id' => $add_id
        );
        $this->db->where('sprp_id', $id);
        $this->db->update('gs_spr_profile', $data);
    }

    function searchStudent($value, $year = NULL) {
        if ($value != ""):
            $this->db = $this->eskwela->db($year);
            $this->db->select('profile_students.st_id as st_id');
            $this->db->select('profile.user_id as uid');
            $this->db->select('profile_students_admission.status as status');
            $this->db->select('lastname');
            $this->db->select('firstname');
            $this->db->select('middlename');
            $this->db->select('level');
            $this->db->select('account_type');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
            $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile.user_id', 'left');
            $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
            $this->db->order_by('lastname', 'ASC');
            $this->db->limit(10);
            $this->db->where('account_type', 5);
            $this->db->like('lastname', $value, 'both');
            $this->db->or_like('firstname', $value, 'both');

            $query = $this->db->get();
            if ($year < $this->session->school_year):
                $status = 1;
            else:
                $status = 0;
            endif;
            if (!$query && $year < $this->session->school_year):
                $this->db = $this->eskwela->db($year);
                $this->db->select('sprp_st_id as st_id');
                $this->db->select('sprp_firstname as firstname');
                $this->db->select('sprp_lastname as lastname');
                $this->db->like('sprp_lastname', $value, 'both');
                $this->db->or_like('sprp_firstname', $value, 'both');
                $query = $this->db->get('gs_spr_profile');
                $status = 1;
            endif;
        else:
            $this->db = $this->eskwela->db($year);
            $this->db->select('profile_students.st_id as st_id');
            $this->db->select('profile.user_id as uid');
            $this->db->select('profile_students_admission.status as status');
            $this->db->select('lastname');
            $this->db->select('firstname');
            $this->db->select('middlename');
            $this->db->select('level');
            $this->db->select('account_type');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
            $this->db->join('profile_students_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
            $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
            $this->db->order_by('lastname', 'ASC');
            $this->db->limit(10);

            $this->db->where('account_type', 5);

            $this->db = $this->eskwela->db($year);
            $query = $this->db->get();

        endif;
        return json_encode(array('status' => $status, 'result' => $query->result()));
    }

    function getSPRrec($stID, $year, $semester, $level) {
        $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));
        ($semester != NULL ? $this->db->where('semester', $semester) : '');
        $this->db->join('gs_spr_profile', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->where('gs_spr.st_id', $stID);
        $q = $this->db->get('gs_spr');

//        if($semester!=NULL):
        if ($q->num_rows() > 0):
            return $q->row();
        else:
            $info1 = array(
                'spr_id' => $this->eskwela->code(),
                'st_id' => $stID,
                'grade_level_id' => $level,
                'school_year' => $year,
                'semester' => ($semester != NULL ? $semester : 0),
                'time_added' => date('Y-m-d H:i:s'),
            );

            $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));
            $this->db->insert('gs_spr', $info1);

            $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));
            $this->db->join('gs_spr_profile', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
            $this->db->where('semester', ($semester != NULL ? $semester : 0));
            $this->db->where('st_id', $stID);
            $q2 = $this->db->get('gs_spr');
            return $q2->row();
        endif;
//        else:
//            return $q->row();
//        endif;    
    }

    function updateBasicInfo($details, $user_id, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('sprp_st_id', $user_id);
        $this->db->update('gs_spr_profile', $details);
    }

    function editInfo($newVal, $owner, $sy, $tbl_name, $field, $stid, $sem) {
        $details = array($field => $newVal);
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        ($sem=='null'?'':$this->db->where('semester', $sem));
        $this->db->where($stid, $owner);
        $this->db->update($tbl_name, $details);
        //return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }

    function getSPRid($stid, $sy, $levelCode) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        //$usd = $this->getSTidBySY($uid, $sy);
        //return $usd->st_id . ' ' . $sy;

        $this->db->where('st_id', $stid);
        $q = $this->db->get('gs_spr');

        if ($q->num_rows() > 0):
            return $q->row();
        else:
            $this->getSingleStudent($stid, $sy, 2, $levelCode);
            $this->db->where('st_id', $stid);
            return $this->db->get('gs_spr')->row();
        endif;
    }

    function getFinalGrade($stid, $subID, $term, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('st_id', $stid);
        $this->db->where('subject_id', $subID);
        $this->db->where('grading', $term);
        $this->db->where('school_year', $sy);
        $this->db->group_by('subject_id');
        return $this->db->get('gs_final_card')->row();
    }

    function updateSPRgrading($stid, $sub_id, $value, $sy, $field, $opt = NULL, $avg = 0) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('spr_id', $stid);
        $this->db->where('subject_id', $sub_id);
        $q = $this->db->get('gs_spr_ar');
        $option = ($opt != 0 ? $opt : 0);

        if ($q->num_rows() > 0):
            $data = array(
                $field => $value,
                'sem' => $option
            );
            $this->db->where('spr_id', $stid);
            $this->db->where('subject_id', $sub_id);
            $this->db->update('gs_spr_ar', $data);
        else:
            $data = array(
                'spr_id' => $stid,
                'subject_id' => $sub_id,
                $field => $value,
                'sem' => $option
            );
            $this->db->insert('gs_spr_ar', $data);
        endif;
    }

    function getSubjectDesc($subj_id) {
        $this->db->where('subject_id', $subj_id);
        return $this->db->get('subjects')->row();
    }

    function getSPRFinalGrade($sprid, $sy, $semester = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        ($semester!=NULL?$this->db->where('sem', $semester):'');
        $this->db->where('spr_id', $sprid);
        return $this->db->get('gs_spr_ar')->result();
    }

    function getFinalCardByLevel($level, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('grade_level_id', $level);
        return $this->db->get('subjects_settings');
    }

    function getFinalCardSH($level, $sy, $strand_id, $semester = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        ($semester!=NULL?$this->db->where('semester', $semester):'');
        $this->db->where('strand_id', $strand_id);
        $this->db->where('grade_id', $level);
        return $this->db->get('sh_subjects');
    }

    function updateSPRrecord($spr_id, $subj_id, $ar_id, $details, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('spr_id', $spr_id);
        $this->db->where('subject_id', $subj_id);
        $this->db->where('ar_id', $ar_id);
        $this->db->update('gs_spr_ar', $details);
    }

    function getSettings($sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $query = $this->db->get('settings');
        return $query->row();
    }

    function checkIFdbExist($sy) {
        $settings = Modules::run('main/getSet');
        $this->load->database();
        $this->load->dbutil();

        if (!$this->dbutil->database_exists('eskwela_' . strtolower($settings->short_name) . '_' . $sy)):
            return false;
        else:
            return TRUE;
        endif;
    }

    function getSPRrecord($id, $sy, $levelCode, $stid, $strand_id = NULL, $semester = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('spr_id', $id);
        $this->db->where('spr_id', $semester);
        $q = $this->db->get('gs_spr_ar');

        if ($q->num_rows() > 0):
            return $q->result();
        else:
            if ($this->db->table_exists('esk_gs_final_card')):
                if ($strand_id == 0):
                    $record = $this->getFinalCardByLevel($levelCode, $sy);

                    foreach ($record->result() as $r):
                        $firstGrading = $this->getFinalGrade($stid, $r->sub_id, 1, $sy);
                        $secondGrading = $this->getFinalGrade($stid, $r->sub_id, 2, $sy);
                        $thirdGrading = $this->getFinalGrade($stid, $r->sub_id, 3, $sy);
                        $fourthGrading = $this->getFinalGrade($stid, $r->sub_id, 4, $sy);

                        $this->updateSPRgrading($id, $r->sub_id, $firstGrading->final_rating, $sy, 'first');
                        $this->updateSPRgrading($id, $r->sub_id, $secondGrading->final_rating, $sy, 'second');
                        $this->updateSPRgrading($id, $r->sub_id, $thirdGrading->final_rating, $sy, 'third');
                        $this->updateSPRgrading($id, $r->sub_id, $fourthGrading->final_rating, $sy, 'fourth');
                    endforeach;
                else:
                    $record = $this->getFinalCardSH($levelCode, $sy, $strand_id, $semester);

                    foreach ($record->result() as $r):
                        $firstGrading = $this->getFinalGrade($stid, $r->sh_sub_id, 1, $sy);
                        $secondGrading = $this->getFinalGrade($stid, $r->sh_sub_id, 2, $sy);
                        $thirdGrading = $this->getFinalGrade($stid, $r->sh_sub_id, 3, $sy);
                        $fourthGrading = $this->getFinalGrade($stid, $r->sh_sub_id, 4, $sy);

                        $this->updateSPRgrading($id, $r->sh_sub_id, $firstGrading->final_rating, $sy, 'first', $r->semester);
                        $this->updateSPRgrading($id, $r->sh_sub_id, $secondGrading->final_rating, $sy, 'second', $r->semester);
                        $this->updateSPRgrading($id, $r->sh_sub_id, $thirdGrading->final_rating, $sy, 'third', $r->semester);
                        $this->updateSPRgrading($id, $r->sh_sub_id, $fourthGrading->final_rating, $sy, 'fourth', $r->semester);
                        if ($fourthGrading->final_rating != 0 || $fourthGrading->final_rating != ""):
                            $this->updateSPRgrading($id, $r->sh_sub_id, (($thirdGrading->final_rating + $fourthGrading->final_rating) / 2), $sy, 'avg', $r->semester);
                        else:
                            $this->updateSPRgrading($id, $r->sh_sub_id, (($firstGrading->final_rating + $secondGrading->final_rating) / 2), $sy, 'avg', $r->semester);
                        endif;
                    endforeach;
                endif;

                return $this->getSPRFinalGrade($id, $sy, $semester);
            else:
                return FALSE;
            endif;
        endif;
    }

    function checkUpdateAcad($id, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('sh_strand', 'sh_strand.st_id = gs_spr.strandid', 'left');
//        $this->db->join('gs_spr_ar', 'gs_spr.spr_id = gs_spr_ar.spr_id', 'left');
//        $this->db->join('subjects', 'gs_spr_ar.subject_id = subjects.subject_id', 'left');
        $this->db->where('gs_spr.st_id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function getStrand($id, $opt) {
        if ($opt == 1):
            $this->db->where('st_id', $id);
            return $this->db->get('profile_students_admission')->row();
        else:
            $this->db->where('st_id', $id);
            return $this->db->get('sh_strand')->row();
        endif;
    }

    function getStrand_id($id, $sy) {
        $this->db->where('st_id', $id);
        $q = $this->db->get('profile_students_admission')->row();

        $this->db = $this->eskwela->db($sy);
        $this->db->where('st_id', $id);
        $this->db->update('gs_spr', array('strandid' => $q->str_id));

        return $q->str_id;
    }

    function lock_unlock_SPR($spr_id, $option) {
        $array = array('go_to_next_level' => $option);
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr', $array);
        return;
    }

    function checkSubject($subject_id, $spr_id) {
        $this->db->where('subject_id', $subject_id);
        $this->db->where('spr_id', $spr_id);
        $query = $this->db->get('gs_spr_ar');
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkIfAcadExist($user_id, $levelCode) {
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('grade_level', 'gs_spr.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('st_id', $user_id);
        $this->db->where('levelCode', $levelCode);
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return $query;
        else:
            return FALSE;
        endif;
    }

    function getEdHistory($st_id, $sy = NULL, $history_type = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('st_id', $st_id);
        ($history_type != NULL ? $this->db->where('history_type', $history_type) : '');
        $query = $this->db->get('gs_previous_record');
        return ($history_type != NULL ? $query->row() : $query->result());
    }

    function getSectionById($id, $sy = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getStudentStat($id, $sy = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->select('*');
        $this->db->from('admission_remarks');
        $this->db->join('deped_code_indicator', 'deped_code_indicator.id = admission_remarks.code_indicator_id', 'left');
        $this->db->where('remark_to', $id);
        return $this->db->get()->row();
    }

    function getSingleStudentSPR($st_id, $sy) {
        $this->db = $this->eskwela->db($sy);
        $this->db->join('gs_spr', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->where('sprp_st_id', $st_id);
        return $this->db->get('gs_spr_profile')->row();
    }

    function updateEdHistory($st_id, $details) {
        $this->db->where('st_id', $st_id);
        $this->db->update('gs_previous_record', $details);
        return;
    }

    function saveEdHistory($details, $history_type, $st_id) {
        $this->db->where('history_type', $history_type);
        $this->db->where('st_id', $st_id);
        $q = $this->db->get('gs_previous_record');
        if ($q->num_rows() == 0):
            if ($this->db->insert('gs_previous_record', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('history_type', $history_type);
            $this->db->where('st_id', $st_id);
            if ($this->db->update('gs_previous_record', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;

        endif;
    }

    function getAllStudentsByLevel($grade_level, $section_id, $year = NULL) {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students_admission.section_id');
        $this->db->select('profile_students_admission.status');
        $this->db->select('profile_students_admission.school_year');
        $this->db->select('sex');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students_admission.status', 1);
        $this->db->order_by('lastname');
        if ($grade_level != NULL):
            $this->db->where('profile_students_admission.grade_level_id', $grade_level);
        endif;

        if ($section_id != NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        if ($year != NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        $query = $this->db->get();
        return $query;
    }

    function getStrandByID($id, $sy = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('st_id', $id);
        return $this->db->get('sh_strand')->row();
    }

    function getSHOfferedStrand() {
        $this->db->where('offered', 1);
        $q = $this->db->get('sh_strand');
        return $q->result();
    }

    function getGradeLevelByLevelCode($code) {
        $this->db->where('levelCode', $code);
        $query = $this->db->get('grade_level');
        return $query->row()->grade_id;
    }

    function deleteSPRecords($spr_id) {
        $this->db->where('spr_id', $spr_id);

        if ($this->db->delete('gs_spr', $ar)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function deleteSingleRecord($spr_id) {
        $this->db->where('ar_id', $spr_id);

        if ($this->db->delete('gs_spr_ar', $ar)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getGradeLevelById($id, $school_year = null) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('grade_id', $id);
        $query = $this->db->get('grade_level');
        return $query->row();
    }

    function getSPRById($spr_id) {
        $this->db->where('spr_id', $spr_id);
        $query = $this->db->get('gs_spr');
        return $query->row();
    }

    function getDaysPresent($spr_id, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->select('gs_spr.spr_id as spr');
        $this->db->from('gs_spr_attendance');
        $this->db->join('gs_spr', 'gs_spr_attendance.spr_id=gs_spr.spr_id', 'left');
        $this->db->where('gs_spr_attendance.spr_id', $spr_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return $query;
        else:
            return FALSE;
        endif;
    }

    function insertDaysPresent($values, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->insert('gs_spr_attendance', $values);
        return TRUE;
    }

    function updateDaysPresent($spr_id, $values, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('spr_id', $spr_id);
        $this->db->update('gs_spr_attendance', $values);
        return TRUE;
    }

    function getSchoolDays($year) {
        $this->db = $this->eskwela->db($year);
        $this->db->where('school_year', $year);
        $query = $this->db->get('gs_num_of_sdays_per_year');
        if ($query->num_rows() > 0):
            return $query;
        else:
            return FALSE;
        endif;
    }

//    function updateBasicSPR($spr_id, $details)
//    {
//        $this->db->where('spr_id', $spr_id);
//        $this->db->update('gs_spr', $details);
//        return;
//    }

    function insertSchoolDays($details) {
        if ($this->db->insert('gs_num_of_sdays_per_year', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function updateSchoolDays($year, $details) {
        $this->db->where('school_year', $year);
        $this->db->update('gs_num_of_sdays_per_year', $details);
        return TRUE;
    }

    function updateAddress($address_id, $school_year, $details, $is_home) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('sprp_profile_id', $address_id);
        $this->db->where('is_home', $is_home);
        $q = $this->db->get('gs_spr_profile_address_info');

        if ($q->num_rows() > 0):
            $this->db->where('sprp_profile_id', $address_id);
            $this->db->where('is_home', $is_home);
            $this->db->update('gs_spr_profile_address_info', $details);
        else:
            $this->db->insert('gs_spr_profile_address_info', $details);
        endif;
    }
    
    function getAddress($stid, $opt, $school_year = NULL){
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('gs_spr_profile_address_info');
        $this->db->join('gs_spr_profile','gs_spr_profile.sprp_id = gs_spr_profile_address_info.sprp_profile_id','left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('religion', 'gs_spr_profile.sprp_rel_id = religion.rel_id', 'left');
        $this->db->where('gs_spr_profile.sprp_st_id', $stid);
        $this->db->where('gs_spr_profile_address_info.is_home', $opt);
        return $this->db->get()->row();
    }
    
    function getTardy($sprid){

        $this->db->where('spr_id', $sprid);
        $spr_id = $this->db->get('gs_spr_attendance_tardy');
        if ($spr_id->num_rows() > 0):
            return $spr_id->row();
        else:
            $tardy = array(
                'spr_tardy_id' => $this->eskwela->codeCheck('gs_spr_attendance_tardy', 'spr_tardy_id', $this->eskwela->code()),
                'spr_id' => $sprid
            );
            $this->db->insert('gs_spr_attendance_tardy', $tardy);

            $this->db->where('spr_id', $id->spr_id);
            return $this->db->get('gs_spr_attendance_tardy')->row();
        endif;
    }
    
    function saveTardy($spr_id, $month, $value, $school_year = NULL){
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('spr_id', $spr_id);
        $q = $this->db->update('gs_spr_attendance_tardy', array($month => $value));
        if($q):
            return TRUE;
        else:
            return FALSE;
        endif;
    }


}
