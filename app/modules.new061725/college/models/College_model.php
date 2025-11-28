<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class College_model extends CI_Model {

    public function __construct() {
        parent::__construct();
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
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            $occ_id = $this->db->insert_id();
        else:
            $occ_id = $query->row()->occ_id;
        endif;

        return $occ_id;
    }

    function deleteFacultyAssignment($sched_code, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('sched_gcode', $sched_code);
        if ($this->db->update('c_schedule', array('faculty_id' => ''))):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function saveAdmissionRemarks($details, $user_id, $sem, $sy) {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('semester', $sem);
        $this->db->where('user_id', $user_id);
        if ($this->db->update('profile_students_c_admission', $details)):
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getCoursePerNumYear($num) {
        $this->db->where('num_years', $num);
        $q = $this->db->get('c_courses');
        return $q->result();
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

    function getRooms() {
        $q = $this->db->get('sched_rooms');
        return $q->result();
    }

    function addRooms($details, $room) {
        $this->db->where('room', $room);
        $q = $this->db->get('sched_rooms');
        if ($q->num_rows() > 0):
            return FALSE;
        else:
            $this->db->insert('sched_rooms', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        endif;
    }

    public function isEnrolled($id, $year) {
        $this->db = $this->eskwela->db($year);
        $this->db->where('st_id', $id);
        $this->db->where('school_year', $year);
        $q = $this->db->get('profile_students_c_admission');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getSingleCollegeStudent($id, $year, $sem) {
        
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_parents.parent_id as pid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        $this->db->where('profile_students.st_id', $id);
        if ($year == NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;

        $this->db->where('profile_students_c_admission.semester', $sem);
        $query = $this->db->get();
        return $query->row();
    }

    function saveStudentAdmission($details, $user_id, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('user_id', $user_id);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('profile_students_admission');
        if ($q->num_rows() > 0):
            return FALSE;
        else:
            $this->db->insert('profile_students_admission', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return TRUE;
        endif;
    }

    function saveBasicInformation($details, $lastname, $firstname, $middlename) {
        $this->db->where('lastname', $lastname);
        $this->db->where('firstname', $firstname);
        $this->db->where('middlename', $middlename);
        $q = $this->db->get('profile');
        if ($q->num_rows() > 0):
            $response = array(
                'status' => FALSE,
                'id' => 0,
            );
            return json_encode($response);
        else:
            $this->db->insert('profile', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            $response = array(
                'status' => TRUE,
                'id' => $this->db->insert_id()
            );
            return json_encode($response);
        endif;
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
        
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

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
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
    }

    function getLatestCollegeNum($level_id) {
        $q = $this->db->get('profile_temp_id');
        if ($q->num_rows() == 0):
            $this->db->select('admission_id');
            $this->db->select('st_id');
            $this->db->from('profile_students_c_admission');
            $this->db->order_by('admission_id', 'DESC');
            $query = $this->db->get();
            $generated_id = $query->row()->st_id;
        else:
            $this->db->select('*');
            $this->db->from('profile_temp_id');
            //$this->db->where('course_id', $level_id);
            $this->db->order_by('temp_id', 'DESC');
            $query = $this->db->get();
            $generated_id = $query->row()->generated_id;
        endif;

        return json_encode(array('num_rows' => $query->num_rows(), 'generated_id' => $generated_id));
    }

    function generateTempId($st_id, $lastThree) {
        $this->db->where('generated_id', $st_id);
        $g = $this->db->get('profile_temp_id');
        if ($g->num_rows() > 0):
            $gen_id = $st_id + 1;
            $lastThree = $lastThree + 1;
            $this->db->insert('profile_temp_id', array('generated_id' => $gen_id));
        else:
            $gen_id = $st_id;
            $this->db->insert('profile_temp_id', array('generated_id' => $gen_id));
        endif;

        return $lastThree;
    }

    function saveReligion($religion) {
        $this->db->where('religion', $religion);
        $query = $this->db->get('religion');
        if ($query->num_rows > 0):
            $rel_id = $query->row()->rel_id;
            return $rel_id;
        else:
            $details = array('religion' => $religion);
            $this->db->insert('religion', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return $this->db->insert_id();
        endif;
    }

    function saveMLM($details, $month, $year, $grade_id, $code) {
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('mlm_grade_id', $grade_id);
        $this->db->where('code_indicator', $code);
        $query = $this->db->get('profile_students_mlm');
        if ($query->num_rows > 0):
            $this->db->where('year', $year);
            $this->db->where('month', $month);
            $this->db->where('mlm_grade_id', $grade_id);
            $this->db->where('code_indicator', $code);
            $this->db->update('profile_students_mlm', $details);

            $return = array(
                'action' => 'update',
                'id' => $query->row()->id
            );
        else:
            $this->db->insert('profile_students_mlm', $details);
            $return = array(
                'action' => 'insert',
                'id' => $this->db->insert_id()
            );
        endif;
        return $return;
    }

    function checkID($id) {
        $this->db->where('user_id', $id);
        $query = $this->db->get('profile');
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getUserId($user_id) {
        $this->db->select('st_id');
        $this->db->select('user_id');
        $this->db->from('profile_students');
        $this->db->where('st_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateProfile($rowid, $details) {
        $this->db->where('rowid', $rowid);
        $this->db->update('profile', $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function updateProfileInfo($user_id, $details) {
        $this->db->where('user_id', $user_id);
        $this->db->update('profile_students', $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function editStudentInfo($user_id, $details) {
        $this->db->where('st_id', $user_id);
        $this->db->update('profile_students', $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function updateGradingAttendanceDetails($rowid, $details, $table) {
        $this->db->where('st_id', $rowid);
        $this->db->update($table, $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function updateFinanceDetails($rowid, $details, $table) {
        $this->db->where('stud_id', $rowid);
        $this->db->update($table, $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function updateProfileDetails($rowid, $details, $table) {
        $this->db->where('user_id', $rowid);
        $this->db->update($table, $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return TRUE;
    }

    function getDeptCode($level_id) {
        $this->db->select('*');
        $this->db->from('grade_level');
        $this->db->where('grade_id', $level_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getLatestIDs($level_id) {
//        $subString = 'SUBSTRING(u_id, -3)';
//        $this->db->select('*', FALSE);
//        $this->db->from('profile_info');
//        $this->db->join('profile', 'profile_info.u_id = profile.user_id', 'left');
//        $this->db->join('grade_level', 'profile_info.grade_level_id = grade_level.grade_id', 'left');
//        $this->db->where('account_type', 5);
//        $this->db->where('grade_level_id', $level_id);
//        $this->db->order_by($subString, 'DESC');
        // $query = $this->db->get();
        $sql = 'Select * from esk_profile_students
            left join esk_section on esk_profile_students.section_id = esk_section.section_id 
            left join esk_grade_level on esk_section.grade_level_id = esk_grade_level.grade_id 
            where esk_grade_level.deptCode = ? order by SUBSTRING(st_id,-3) DESC';
        $query = $this->db->query($sql, array($level_id));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getLatestID($level_id = NULL) {
        $this->db->select('user_id');
        $this->db->from('profile');
        $this->db->order_by('user_id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getGradeLevel($dept_id = NULL, $option = NULL) {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        if ($dept_id != NULL && $option == NULL):
            $this->db->where('dept_id <=', $dept_id);
        endif;
        if ($option != NULL):
            $this->db->where('dept_id', $dept_id);
        endif;
        $query = $this->db->get('grade_level');
        return $query->result();
    }

    function getGradeLevelByLevelCode($code) {
        $this->db->where('levelCode', $code);
        $query = $this->db->get('grade_level');
        return $query->row()->grade_id;
    }

    function getGradeLevelById($id) {
        $this->db->where('grade_id', $id);
        $query = $this->db->get('grade_level');
        return $query->row();
    }

    function getSection() {
        $query = $this->db->get('section');
        return $query->result();
    }

    function saveSection($details) {
        $this->db->insert('section', $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return;
    }

    function getAllSection($section_id, $option) {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        if ($section_id != NULL):
            $this->db->where('section_id', $section_id);
        endif;
        if ($option != NULL):
            $this->db->where('dept_id <=', $option);
        endif;
        //$this->db->order_by('grade_level.grade_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    function getSectionById($id) {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section.section_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getSectionByLevel($level) {
        $this->db->select('*');
        $this->db->select('section.section_id as s_id');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('schedule', 'section.schedule_id = schedule.sched_id', 'left');
        $this->db->where('grade_level_id', $level);
        $query = $this->db->get();
        return $query;
    }

    function getEducAttain() {
        $query = $this->db->get('profile_educ_attain');
        return $query->result();
    }

    function getPhysician() {
        $this->db->select('*');
        $this->db->from('profile_med_physician');
        $this->db->join('profile_contact_details', 'profile_med_physician.physician_contact_id = profile_contact_details.contact_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function savePhysician($name, $number) {
        $data = array(
            'physician' => $name
        );
        $this->db->insert('profile_med_physician', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);

        $this->setContacts($number, 'cd_mobile');
    }

    function updatePhysician($p_id, $con_id) {
        $data = array(
            'physician_contact_id' => $con_id
        );
        $this->db->where('physician_id', $p_id);
        $this->db->update('profile_med_physician', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    //Admission process  
    function saveProfile($data, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        
        return $this->db->insert_id();
    }

    function saveEdate($data) {
        $this->db->select('*');
        $this->db->from('calendar');
        $this->db->where('cal_date', $data);
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return $query->row()->cal_id;
        else:
            $date = array(
                'cal_date' => $data
            );

            $this->db->insert('calendar', $date);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
            return $this->db->insert_id();
        endif;
    }

    function setStudInfo($uid, $profile_id, $section, $grade_level, $motherTongue, $en_date, $school_year, $sla, $asla) {
        $data = array(
            'st_id' => $uid,
            'user_id' => $profile_id,
            'parent_id' => 0,
            'section_id' => $section,
            'mother_tongue_id' => $motherTongue,
            'status' => 1,
                );
        $this->db->insert('profile_students', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        $this->setAdmissionDate($en_date, $profile_id, $school_year, $grade_level, $section, $sla, $asla);
    }

    function setAdmissionDate($en_date, $profile_id, $school_year, $grade_level_id, $section_id, $sla, $asla) {
        $data = array(
            'school_year' => $school_year,
            'date_admitted' => $en_date,
            'user_id' => $profile_id,
            'grade_level_id' => $grade_level_id,
            'section_id' => $section_id,
            'status' => 1,
            'school_last_attend' => $sla,
            'sla_address' => $asla
        );

        $this->db->insert('profile_students_admission', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
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
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);

            return $this->db->insert_id();
        endif;
    }

    function setCity($city) {
        $this->db->where('mun_city', $city);
        $query = $this->db->get('cities');
        return $query->row();
    }

    function setAddress($data, $school_year) {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('profile_address_info', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }

    function setUpdateAddress($add_id, $id) {
        $data = array(
            'add_id' => $add_id
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    function setUpdateOfficeAddress($add_id, $id, $m_p) {
        $data = array(
            'add_id' => $add_id
        );
        $this->db->where($m_p . '_office_address_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
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
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }

    function setUpdateContact($con_id, $id) {
        $data = array(
            'contact_id' => $con_id
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    function saveDate($data, $id, $type) {
        $date = array(
            'cal_date' => $data
        );

        $this->db->insert('calendar', $date);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);

        $this->setDate($data, $id, $type);

        return;
    }

    function setDate($data, $id, $type) {
        $this->db->select('*');
        $this->db->from('calendar');
        $this->db->where('cal_date', $data);
        $this->db->order_by('cal_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            $this->saveDate($data, $id, $type);
        } else {

            $cal_id = $query->row()->cal_id;

            $this->setUpdateDate($cal_id, $id, $type);
        }
        return;
    }

    function setUpdateDate($cal_id, $id, $type) {
        $data = array(
            $type => $cal_id
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return;
    }

    function setParentsPro($data) {
        $this->db->insert('profile_parents', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);

        return $this->db->insert_id();
    }

    function updateParentPro($parent_id, $student_id) {
        $data = array(
            'parent_id' => $parent_id
        );
        $this->db->where('user_id', $student_id);
        $this->db->update('profile_students', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    function chooseOcc($data, $id) {
        $this->db->select('*');
        $this->db->from('profile_occupation');
        $this->db->where('occupation', $data);
        $this->db->order_by('occ_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            $occ_id = $query->row()->occ_id;
            $this->setUpdateOccupation($occ_id, $id);

        else:
            $this->setOccupation($data, $id);
        endif;
    }

    function setOccupation($data, $id) {
        $occupation = array(
            'occupation' => $data
        );

        $this->db->insert('profile_occupation', $occupation);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);

        $this->chooseOcc($data, $id);
    }

    function setUpdateOccupation($occ_id, $id) {
        $data = array(
            'occupation_id' => $occ_id
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    function chooseEduc($data, $id) {
        $data = array(
            'educ_attain_id' => $data
        );
        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
    }

    function saveMed($btype, $allergies, $others, $physician, $height, $weight, $userid) {
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
//        Modules::run('web_sync/saveRunScript', $runScript);
        return;
    }

    function saveNewValue($table, $details) {
        $this->db->insert($table, $details);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);
        return;
    }

    function editBasicInfo($details, $rowid, $table, $where) {
        $this->db->where($where, $rowid);

        if ($this->db->update($table, $details)):
            $this->db->select('*');
            $this->db->from($table);
            if ($table == 'profile_address_info'):
                $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
                $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
                $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
            endif;
            $this->db->where($where, $rowid);

            $query = $this->db->get();
            return $query->row();

        endif;
    }

    function deleteProfile($column, $id, $table, $school_year = NULL) {
        if ($school_year == NULL):
            $school_year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($school_year);
        $this->db->where($column, $id);
        $this->db->delete($table);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript);

        return;
    }

    function parentOveride() {
        $this->db->select('user_id');
        $this->db->select('parent_id');
        $this->db->from('profile');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result() as $row):
            $i++;
            $details = array('parent_id' => $row->parent_id);

            $this->db->where('user_id', $row->user_id);
            $this->db->update('profile_students', $details);

            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
        endforeach;
        return $i;
    }

    function assignOveride() {
        $this->db->select('faculty_id');
        $this->db->from('faculty_assign');
        $query = $this->db->get();

        foreach ($query->result() as $row):
            if (substr($row->faculty_id, 0, 1) != '0'):
                $details = array('faculty_id' => '0' . $row->faculty_id);

                $this->db->where('faculty_id', $row->faculty_id);
                $this->db->update('faculty_assign', $details);
                $runScript = $this->db->last_query();
//                Modules::run('web_sync/saveRunScript', $runScript);
            endif;
        endforeach;
    }

    function adviserOveride() {
        $this->db->select('faculty_id');
        $this->db->from('advisory');
        $query = $this->db->get();

        foreach ($query->result() as $row):
            $details = array('position_details' => 1);

            $this->db->where('employee_id', $row->faculty_id);
            $this->db->update('profile_employee', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);
        endforeach;
    }

    function editRemarks() {
        $this->db->select('remark_to');
        $this->db->select('code_indicator_id');
        $this->db->from('admission_remarks');
        $this->db->where('code_indicator_id', 1);
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result() as $row):
            $i++;
            $details = array('status' => 0);

            $this->db->where('st_id', $row->remark_to);
            $this->db->update('profile_students', $details);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript);

        endforeach;
        return $i;
    }
    
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
    
    function saveRemarks($info, $stid, $date, $code, $school_year = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db = $this->eskwela->db($sy);
        $this->db->where('remark_to', $stid);
        $q = $this->db->get('admission_remarks');

        if ($q->num_rows() > 0):
            $data = array(
                'remarks' => $info,
                'code_indicator_id' => $code,
                'remark_date' => $date
            );
            $this->db->where('remark_to', $stid);
            $this->db->update('admission_remarks', $data);
        else:
            $data = array(
                'remarks' => $info,
                'code_indicator_id' => $code,
                'remark_to' => $stid,
                'remark_date' => $date
            );
            $this->db->insert('admission_remarks', $data);
        endif;
    }

}
