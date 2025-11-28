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
class reports_model_f137 extends CI_Model {

    //put your code here

    function getAcadRecords($user_id, $school_year, $grade_level) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->select('*');
        $this->db->from('gs_spr');
        $this->db->join('gs_spr_ar', 'gs_spr.spr_id = gs_spr_ar.spr_id', 'left');
        $this->db->join('subjects', 'gs_spr_ar.subject_id = subjects.subject_id', 'left');
        $this->db->where('st_id', $user_id);

        $query = $this->db->get();
        return $query;
    }

    function checkAcadExist($user_id, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('st_id', $user_id);
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

    function saveAR($ar, $spr_id = NULL, $subject_id = NULL, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        ($spr_id != NULL ? $this->db->where('spr_id', $spr_id) : '');
        ($subject_id != NULL ? $this->db->where('subject_id', $subject_id) : '');
        $q = $this->db->get('gs_spr_ar');
        if ($q->num_rows() > 0):
            $this->db->where('spr_id', $spr_id);
            $this->db->where('subject_id', $subject_id);
            $this->db->update('gs_spr_ar', $ar);
        else:
            $this->db->insert('gs_spr_ar', $ar);
        endif;
        return;
    }

    function saveSPR($spr, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->insert('gs_spr', $spr);
        return $this->db->insert_id();
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

    function checkAcad($grade_id, $st_id) {
        $this->db->where('st_id', $st_id);
        $this->db->where('grade_level_id', $grade_id);
        $q = $this->db->get('gs_spr');
        return $q->row();
    }

    function getSingleStudent($id, $year) {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students.parent_id as pid');
        $this->db->select('profile_students_admission.school_year as sy');
        $this->db->select('calendar.cal_date as bdate');
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
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id', 'left');
        $this->db->join('gs_spr', 'profile_students.st_id = gs_spr.st_id', 'left');
        if ($year == NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $year);

        endif;
        $this->db->where('profile_students.st_id', $id);
        $query = $this->db->get();
        return $query->row();
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
        $this->db->join('gs_spr_profile_address_info', 'gs_spr_profile.sprp_add_id = gs_spr_profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'gs_spr_profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('religion', 'gs_spr_profile.sprp_rel_id = religion.rel_id', 'left');
        $this->db->join('gs_spr', 'gs_spr_profile.sprp_st_id = gs_spr.st_id', 'left');
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

    function saveNewInfo($details, $lastname, $firstname, $middlename, $school_year) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('sprp_lastname', $lastname);
        $this->db->where('sprp_firstname', $firstname);
        ($middlename != NULL ? $this->db->where('sprp_middlename', $middlename) : '');
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

    function getSPRrec($stID, $year) {
        $this->db = $this->eskwela->db(($year == NULL ? $this->session->school_year : $year));
        $this->db->where('st_id', $stID);
        return $this->db->get('gs_spr')->row();
    }

    function updateBasicInfo($details, $user_id, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('sprp_st_id', $user_id);
        $this->db->update('gs_spr_profile', $details);
    }

    function editInfo($newVal, $owner, $sy, $tbl_name, $field, $stid) {
        $details = array($field => $newVal);
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where($stid, $owner);
        $this->db->update($tbl_name, $details);
    }

}
