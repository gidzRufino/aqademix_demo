<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class f137_model extends CI_Model {

    function searchStudent($value, $year = NULL) {
        if ($value != ""):
            $this->db = $this->eskwela->db($year);
            $this->db->select('*');
            $this->db->select('profile_students.st_id as st_id');
            $this->db->select('profile.user_id as uid');
            // $this->db->select('profile_students_admission.status as status');
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
            $this->db->where('status', 1);
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

    function checkIfDataExist($tblName, $field, $value, $school_year = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db = $this->eskwela->db($sy);
        $this->db->where($field, $value);
        return $this->db->get($tblName);
    }

    function getSprRec($st_id, $school_year = NULL, $lastSYen = NULL, $grade_level = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->select('gs_spr_school.school_id as sch_id');
        $this->db->join('gs_spr_profile', 'gs_spr_profile.sprp_st_id = gs_spr.st_id', 'left');
        $this->db->join('gs_spr_school', 'gs_spr_school.esk_gs_spr_school_code = gs_spr.school_id', 'left');
        $this->db->join('gs_spr_profile_address_info', 'gs_spr_profile_address_info.address_id = gs_spr_profile.sprp_add_id', 'left');
        $this->db->join('gs_spr_ov','gs_spr_ov.ov_st_id = gs_spr.st_id','left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->where('gs_spr.st_id', $st_id);
        $q = $this->db->get('gs_spr');

        if ($q->num_rows() > 0):
            if ($sy == $this->session->school_year):
                $this->updateSchoolRec($st_id, $q->row()->spr_id, $sy);
            endif;
            return $q->row();
        else:
            return $this->addSprRec($st_id, $sy, $lastSYen, $grade_level);
        endif;
    }

    function addSprRec($stid, $school_year = NULL, $lastSYen = NULL, $grade_level = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);

        $isTbl = $this->checkTableExist('profile_students_admission', $sy);

        if ($isTbl):
            $q = $this->getSingleStudent($stid, $sy);
//            print_r($q);

            if (count($q) > 0):
                $data = array(
                    'spr_id' => $this->eskwela->code(),
                    'st_id' => $q->uid,
                    'strandid' => $q->str_id,
                    'grade_level_id' => $grade_level,
                    'section' => $q->section,
                    'school_year' => $sy
                );

                $this->insertSprRec($data, 'gs_spr', $sy);

                $f_occ = $this->getOccupation($q->f_occ, $sy);
                $m_occ = $this->getOccupation($q->m_occ, $sy);

                $add_id = $this->eskwela->code();
                $profile = array(
                    'sprp_id' => $this->eskwela->code(),
                    'sprp_st_id' => $q->uid,
                    'sprp_lrn' => $q->lrn,
                    'sprp_lastname' => $q->lastname,
                    'sprp_firstname' => $q->firstname,
                    'sprp_middlename' => $q->middlename,
                    'sprp_gender' => $q->sex,
                    'sprp_father' => strtoupper($q->f_firstname . ' ' . $q->f_middelname . ' ' . $q->f_lastname),
                    'sprp_father_occ' => ($f_occ->occupation != '' ? $f_occ->occupation : ''),
                    'sprp_mother' => strtoupper($q->m_firstname . ' ' . $q->m_middelname . ' ' . $q->m_lastname),
                    'sprp_mother_occ' => ($m_occ->occupation != '' ? $m_occ->occupation : ''),
                    'sprp_bdate' => $q->temp_bdate,
                    'sprp_add_id' => $add_id
                );
                $this->insertSprRec($profile, 'gs_spr_profile', $sy);

                $address = array(
                    'address_id' => $add_id,
                    'street' => ($q->street != '' ? $q->street : ''),
                    'barangay_id' => ($q->barangay != '' ? $q->barangay : ''),
                    'city_id' => ($q->city_id != '' ? $q->city_id : ''),
                    'province_id' => ($q->province_id != '' ? $q->province_id : ''),
                    'country' => ($q->country != '' ? $q->country : ''),
                    'zip_code' => ($q->zip_code != '' ? $q->zip_code : ''),
                    'is_home' => 1
                );
                $this->insertSprRec($address, 'gs_spr_profile_address_info', $sy);

                return $this->getSprRec($stid, $sy, NULL, $grade_level);
            else:
                $q = $this->getSingleStudent($stid, $lastSYen);
                if (count($q) > 0):
                    $data = array(
                        'spr_id' => $this->eskwela->code(),
                        'st_id' => $q->uid,
                        'grade_level_id' => $grade_level,
                        'strandid' => $q->str_id,
                        'school_year' => $sy
                    );

                    $this->insertSprRec($data, 'gs_spr', $sy);

                    $f_occ = $this->getOccupation($q->f_occ, $lastSYen);
                    $m_occ = $this->getOccupation($q->m_occ, $lastSYen);

                    $add_id = $this->eskwela->code();
                    $profile = array(
                        'sprp_id' => $this->eskwela->code(),
                        'sprp_st_id' => $q->uid,
                        'sprp_lrn' => $q->lrn,
                        'sprp_lastname' => $q->lastname,
                        'sprp_firstname' => $q->firstname,
                        'sprp_middlename' => $q->middlename,
                        'sprp_gender' => $q->sex,
                        'sprp_father' => strtoupper($q->f_firstname . ' ' . $q->f_middelname . ' ' . $q->f_lastname),
                        'sprp_father_occ' => ($f_occ->occupation != '' ? $f_occ->occupation : ''),
                        'sprp_mother' => strtoupper($q->m_firstname . ' ' . $q->m_middelname . ' ' . $q->m_lastname),
                        'sprp_mother_occ' => ($m_occ->occupation != '' ? $m_occ->occupation : ''),
                        'sprp_bdate' => $q->temp_bdate,
                        'sprp_add_id' => $add_id
                    );
                    $this->insertSprRec($profile, 'gs_spr_profile', $sy);

                    $address = array(
                        'address_id' => $add_id,
                        'street' => ($q->street != '' ? $q->street : ''),
                        'barangay_id' => ($q->barangay != '' ? $q->barangay : ''),
                        'city_id' => ($q->city_id != '' ? $q->city_id : ''),
                        'province_id' => ($q->province_id != '' ? $q->province_id : ''),
                        'country' => ($q->country != '' ? $q->country : ''),
                        'zip_code' => ($q->zip_code != '' ? $q->zip_code : ''),
                        'is_home' => 1
                    );
                    $this->insertSprRec($address, 'gs_spr_profile_address_info', $sy);

                    return $this->getSprRec($stid, $sy, NULL, $grade_level);
                endif;
            endif;
        else:
            $q = $this->getSingleStudent($stid, $lastSYen);

            if (count($q) > 0):
                $data = array(
                    'spr_id' => $this->eskwela->code(),
                    'st_id' => $q->uid,
                    'grade_level_id' => $grade_level,
                    'strandid' => $q->str_id,
                    'school_year' => $sy
                );

                $this->insertSprRec($data, 'gs_spr', $sy);

                $f_occ = $this->getOccupation($q->f_occ, $lastSYen);
                $m_occ = $this->getOccupation($q->m_occ, $lastSYen);

                $add_id = $this->eskwela->code();
                $profile = array(
                    'sprp_id' => $this->eskwela->code(),
                    'sprp_st_id' => $q->uid,
                    'sprp_lrn' => $q->lrn,
                    'sprp_lastname' => $q->lastname,
                    'sprp_firstname' => $q->firstname,
                    'sprp_middlename' => $q->middlename,
                    'sprp_gender' => $q->sex,
                    'sprp_father' => strtoupper($q->f_firstname . ' ' . $q->f_middelname . ' ' . $q->f_lastname),
                    'sprp_father_occ' => ($f_occ->occupation != '' ? $f_occ->occupation : ''),
                    'sprp_mother' => strtoupper($q->m_firstname . ' ' . $q->m_middelname . ' ' . $q->m_lastname),
                    'sprp_mother_occ' => ($m_occ->occupation != '' ? $m_occ->occupation : ''),
                    'sprp_bdate' => $q->temp_bdate,
                    'sprp_add_id' => $add_id
                );
                $this->insertSprRec($profile, 'gs_spr_profile', $sy);

                $address = array(
                    'address_id' => $add_id,
                    'street' => ($q->street != '' ? $q->street : ''),
                    'barangay_id' => ($q->barangay != '' ? $q->barangay : ''),
                    'city_id' => ($q->city_id != '' ? $q->city_id : ''),
                    'province_id' => ($q->province_id != '' ? $q->province_id : ''),
                    'country' => ($q->country != '' ? $q->country : ''),
                    'zip_code' => ($q->zip_code != '' ? $q->zip_code : ''),
                    'is_home' => 1
                );
                $this->insertSprRec($address, 'gs_spr_profile_address_info', $sy);

                return $this->getSprRec($stid, $sy, NULL, $grade_level);
            endif;
        endif;
    }

    function insertSprRec($details, $tbl, $school_year = NULL) {
        $sy = ($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db = $this->eskwela->db($sy);
        $this->db->insert($tbl, $details);
    }

    function checkIFdbExist($sy) {
        $settings = Modules::run('main/getSet');
        $this->load->database();
        $this->load->dbutil();

        if (!$this->dbutil->database_exists('csscore_eskwela_' . strtolower($settings->short_name) . '_' . $sy)):
            return false;
        else:
            return TRUE;
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

    function getSingleStudent($id, $year, $semester) {
        $this->db = $this->eskwela->db($year == NULL ? $this->session->school_year : $year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students.parent_id as pid');
        $this->db->select('section.str_id as strand_id');
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
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        $this->db->where('profile_students.st_id', $id);
        return $this->db->get()->row();
    }

    function getAddress($stid, $opt, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->from('gs_spr_profile_address_info');
        $this->db->join('gs_spr_profile', 'gs_spr_profile.sprp_add_id = gs_spr_profile_address_info.address_id', 'left');
        $this->db->join('cities', 'gs_spr_profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'gs_spr_profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('religion', 'gs_spr_profile.sprp_rel_id = religion.rel_id', 'left');
        $this->db->where('gs_spr_profile.sprp_st_id', $stid);
        $this->db->where('gs_spr_profile_address_info.is_home', $opt);
        return $this->db->get()->row();
    }

    function getSPRFinalGrade($sprid, $sy, $semester = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        ($semester != NULL ? $this->db->where('sem', $semester) : '');
        $this->db->join('subjects', 'subjects.subject_id = gs_spr_ar.subject_id', 'left');
        $this->db->where('spr_id', $sprid);
        return $this->db->get('gs_spr_ar')->result();
    }

    function getOccupation($id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db->where('occ_id', $id);
        return $this->db->get('profile_occupation')->row();
    }

    function updateSchoolRec($stid, $sprid, $sy) {
        $this->db = $this->eskwela->db($sy);

        $this->db->select('*');
        $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile_students.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->where('profile_students.st_id', $stid);
        $q = $this->db->get('profile_students');

        if ($q->num_rows() > 0):
            $this->db = $this->eskwela->db($sy);
            $this->db->where('st_id', $stid);
            $this->db->update('gs_spr', array('section' => $q->row()->section));
        endif;

        $this->db = $this->eskwela->db($sy);
        $r = $this->db->get('settings');

        if ($r->num_rows() > 0):
            $this->db = $this->eskwela->db($sy);
            $this->db->where('school_id', $r->row()->school_id);
            $s = $this->db->get('gs_spr_school');

            if ($s->num_rows() > 0):
                $this->db = $this->eskwela->db($sy);
                $this->db->where('school_id', $r->row()->school_id);
                $this->db->update('gs_spr_school', array('school_name' => $r->row()->set_school_name));
                $sid = $s->row()->esk_gs_spr_school_code;
            else:
                $data = array(
                    'spr_school_id' => $this->eskwela->code(),
                    'school_name' => $r->row()->set_school_name,
                    'school_id' => $r->row()->school_id,
                    'division' => $r->row()->division,
                    'district' => $r->row()->district,
                    'region' => $r->row()->region
                );
                $this->db = $this->eskwela->db($sy);
                $this->db->insert('gs_spr_school', $data);
                $sid = $this->db->insert_id();
            endif;

            $this->db = $this->eskwela->db($sy);
            $this->db->where('st_id', $stid);
            $this->db->update('gs_spr', array('school_id' => $sid));
        endif;
    }

    function fetchAcadRecord($id, $stid, $levelCode, $strand_id, $sy) {
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
            $record = $this->getFinalCardSH($levelCode, $sy, $strand_id);

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

        if ($this->db->affected_rows()):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getFinalCardByLevel($level, $sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('grade_level_id', $level);
        return $this->db->get('subjects_settings');
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
                'ar_id' => $this->eskwela->code(),
                'spr_id' => $stid,
                'subject_id' => $sub_id,
                $field => $value,
                'sem' => $option
            );
            $this->db->insert('gs_spr_ar', $data);
        endif;
    }

    function getFinalCardSH($level, $sy, $strand_id, $semester = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        ($semester != NULL ? $this->db->where('semester', $semester) : '');
        $this->db->where('strand_id', $strand_id);
        $this->db->where('grade_id', $level);
        return $this->db->get('sh_subjects');
    }

    function createSPRTables($database, $file) {
        // Connect to the database
        $mysqli = new mysqli('localhost', $this->db->username, $this->db->password, $database);

        // Check for errors
        if (mysqli_connect_errno())
            return false;

        // Open the default SQL file
        $query = file_get_contents(APPPATH . 'modules/f137/views/db/' . $file);

        // Execute a multi query
        $mysqli->multi_query($query);

        // Close the connection
        $mysqli->close();

        return true;
    }

    function getSingleStudentSPR($st_id, $sy) {
        $this->db = $this->eskwela->db($sy);
        $this->db->join('gs_spr', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->where('sprp_st_id', $st_id);
        return $this->db->get('gs_spr_profile')->row();
    }

    function getSubID($desc, $school_year) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('subject', $desc);
        $q = $this->db->get('subjects');

        if ($q->num_rows() > 0):
            return $q->row()->subject_id;
        else:
            $sub_id = $this->eskwela->code();
            $sub = array(
                'subject_id' => $sub_id,
                'subject' => $desc
            );

            if ($this->db->insert('subjects', $sub)):
                return $sub_id;
            endif;
        endif;
    }

    function saveSPRSubject($sub_id, $spr_id, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));

        $this->db->where('spr_id', $spr_id);
        $this->db->where('subject_id', $sub_id);
        $q = $this->db->get('gs_spr_ar');

        if ($q->num_rows() <= 0):
            $newSub = array(
                'ar_id' => $this->eskwela->code(),
                'spr_id' => $spr_id,
                'subject_id' => $sub_id
            );
            $this->db->insert('gs_spr_ar', $newSub);
        endif;
        return TRUE;
    }

    function getSchoolAddress($add_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);

        $this->db->join('cities', 'cities.id = gs_spr_profile_address_info.city_id', 'left');
        $this->db->join('provinces', 'provinces.id = gs_spr_profile_address_info.province_id', 'left');
        $this->db->where('address_id', $add_id);
        return $this->db->get('gs_spr_profile_address_info')->row();
    }

    function editInfo($newVal, $owner, $sy, $tbl_name, $field, $stid) {
        $details = array($field => $newVal);

        $this->db = $this->eskwela->db($sy == NULL ? $this->session->school_year : $sy);
        $this->db->where($stid, $owner);
        $this->db->update($tbl_name, $details);
    }

    function editSchoolInfo($newVal, $owner, $sy, $tbl_name, $field, $id, $primary_key = NULL, $st_id = NULL, $sch_id = NULL) {
        $this->db = $this->eskwela->db($sy == NULL ? $this->session->school_year : $sy);

        $this->db->where($id, $owner);
        $q = $this->db->get($tbl_name);

        if ($q->num_rows() > 0):
            $this->db->where($id, $owner);
            $this->db->update($tbl_name, array($field => $newVal));
            $sid = $owner;
        else:
            if ($tbl_name == 'gs_spr_school'):
                $this->db->where('school_id', $sch_id);
                $this->db->or_where('school_id', $newVal);
                $p = $this->db->get('gs_spr_school');

                if ($p->num_rows() > 0):
                    $this->db->where('school_id', $sch_id);
                    $this->db->update($tbl_name, array($field => $newVal));
                    $sid = $p->row()->esk_gs_spr_school_code;
                else:
                    $data = array(
                        $primary_key => $this->eskwela->code(),
                        $field => $newVal
                    );
                    $this->db->insert($tbl_name, $data);
                    $sid = $this->db->insert_id();
                endif;
            elseif ($tbl_name == 'gs_spr_ov'):
                $data = array(
                    $primary_key => $this->eskwela->code(),
                    'ov_st_id' => $st_id,
                    $field => $newVal
                );
                $this->db->insert($tbl_name, $data);
            endif;
        endif;

        if ($tbl_name == 'gs_spr_school'):
            $this->db->where('st_id', $st_id);
            $this->db->update('gs_spr', array('school_id' => $sid));
        endif;
    }

    function exportSubjects($school_year = NULL) {
        $this->db = $this->eskwela->db($school_year);
        $q = $this->db->get('subjects');
        return $q->result();
    }

    function insertAllSubjects($school_year, $subjectArray) {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->insert('subjects', $subjectArray);
    }

    function updateAddress($address_id, $street, $barangay, $city, $province, $zip_code, $user_id, $school_year, $is_home, $schID = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('address_id', $address_id);
        $this->db->where('is_home', $is_home);
        $q = $this->db->get('gs_spr_profile_address_info');

        if ($q->num_rows() > 0):
            $details = array(
                'street' => $street,
                'barangay_id' => $barangay,
                'city_id' => $city,
                'province_id' => $province,
                'country' => 'Philippines',
                'zip_code' => $zip_code
            );

            $this->db->where('address_id', $address_id);
            $this->db->where('is_home', $is_home);
            $this->db->update('gs_spr_profile_address_info', $details);
        else:
            $add_id = $this->eskwela->code();
            $details = array(
                'address_id' => $add_id,
                'street' => $street,
                'barangay_id' => $barangay,
                'city_id' => $city,
                'province_id' => $province,
                'country' => 'Philippines',
                'zip_code' => $zip_code,
                'is_home' => $is_home
            );
            $this->db->insert('gs_spr_profile_address_info', $details);

            if ($this->db->affected_rows() > 0):
                if ($is_home == 1): // 1 =  student's home address ; 2 = school address
                    $this->db->where('sprp_st_id', $user_id);
                    $this->db->update('gs_spr_profile', array('sprp_add_id' => $add_id));
                else:
                    $this->db->where('school_id', $schID);
                    $this->db->update('gs_spr_school', array('school_add_id' => $add_id));
                endif;
            endif;
        endif;
    }

    function insertSubject($subject, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);

        $this->db->where('subject', $subject);
        $q = $this->db->get('subjects');

        if ($q->num_rows() > 0):
            return $q->row()->subject_id;
        else:
            $subj_id = $this->eskwela->code();
            $details = array(
                'subject_id' => $subj_id,
                'subject' => $subject
            );
            $this->db->insert('subjects', $details);

            if ($this->db->affected_rows()):
                return $subj_id;
            endif;
        endif;
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

    function getAvatar($id) {

        $this->db->select('avatar');
        $this->db->where('st_id', $id);
        $this->db->join('profile_students', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile');
        return $query->row()->avatar;
    }

    function checkAdmission($st_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db->join('profile_students', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students.st_id', $st_id);
        $q = $this->db->get('profile_students_admission');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getSettings($sy) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $query = $this->db->get('settings');
        return $query->row();
    }

    function getGradeLevelById($id, $school_year = null) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('grade_id', $id);
        $query = $this->db->get('grade_level');
        return $query->row();
    }

    function getEdHistory($st_id, $sy = NULL, $history_type = NULL) {
        $this->db = $this->eskwela->db(($sy == NULL ? $this->session->school_year : $sy));
        $this->db->where('st_id', $st_id);
        ($history_type != NULL ? $this->db->where('history_type', $history_type) : '');
        $query = $this->db->get('gs_previous_record');
        return ($history_type != NULL ? $query->row() : $query->result());
    }

    function deleteRec($sprid, $subj_id = NULL, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        ($subj_id != 0 ? $this->db->where('subject_id', $subj_id) : '');
        $this->db->where('spr_id', $sprid);
        if ($this->db->delete('gs_spr_ar')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getGenRecByID($id, $sy = NULL) {
        $this->db = $this->eskwela->db($sy != NULL ? $sy : $this->session->school_year);
        $this->db->where('stid', $id);
        return $this->db->get('gs_spr_gen_rec')->row();
    }

    function updateCheckBox($stid, $field, $opt, $school_year = null, $certp = null) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db->where('st_id', $stid);
        $q = $this->db->get('gs_spr_eligibility');

        if ($field == 'credential_presented'):
            switch ($certp):
                case 'kpr':
                    $new = 1;
                    break;
                case 'eccd':
                    $new = 2;
                    break;
                case 'kcoc':
                    $new = 3;
                    break;
            endswitch;

            if ($q->num_rows() > 0):
                if ($q->row()->credential_presented != ''):
                    $value = explode(',', $q->row()->credential_presented);
                    $cnt = 0;
                    foreach ($value as $v):
                        if ($opt == 1):
                            if ($v != $new):
                                $res[] = $v;
                                if ($cnt == count($value) - 1):
                                    array_push($res, $new);
                                endif;
                            endif;
                            $cnt++;
                        elseif ($opt == 0):
                            if ($v != $new):
                                $res[] = $v;
                            endif;
                        endif;
                    endforeach;
                    $final = implode(',', $res);
                else:
                    $final = $new;
                endif;
                $this->db->where('st_id', $stid);
                $this->db->update('gs_spr_eligibility', array('credential_presented' => $final));
            else:
                $data = array(
                    'elig_id' => $this->eskwela->code(),
                    'st_id' => $stid,
                    'credential_presented' => $new
                );
                $this->db->insert('gs_spr_eligibility', $data);
            endif;
        endif;
    }

    function getEligibility($stid, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db->select('*');
        $this->db->select('gs_spr_school.school_id as sch_id');
        $this->db->join('gs_spr_school', 'gs_spr_school.school_id = gs_spr_eligibility.school_id', 'left');
        $this->db->where('st_id', $stid);
        return $this->db->get('gs_spr_eligibility')->row();
    }

    function getSchoolList($school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
//        $this->db->join('gs_spr_profile_address_info','gs_spr_profile_address_info.address_id = gs_spr_school.school_add_id','left');
        return $this->db->get('gs_spr_school')->result();
    }

    function updateEligibility($stid, $field, $value, $tbl, $tbl_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db->where('st_id', $stid);
        $q = $this->db->get($tbl);

        if ($q->num_rows() > 0):
            $this->db->where('st_id', $stid);
            $this->db->update($tbl, array($field => $value));
        else:
            $data = array(
                $tbl_id => $this->eskwela->code(),
                'st_id' => $stid,
                $field => $value
            );
            $this->db->insert($tbl, $data);
        endif;
    }

    function getSchoolInfo($id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db->join('gs_spr_profile_address_info', 'gs_spr_profile_address_info.address_id = gs_spr_school.school_add_id', 'left');
        $this->db->join('cities', 'cities.id = gs_spr_profile_address_info.city_id', 'left');
        $this->db->join('provinces', 'provinces.id = gs_spr_profile_address_info.province_id', 'left');
        $this->db->where('school_id', $id);
        return $this->db->get('gs_spr_school')->row();
    }

    function addSchoolAddress($street, $brgy, $city, $province, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $add_id = $this->eskwela->code();

        $data = array(
            'address_id' => $add_id,
            'street' => $street,
            'barangay_id' => $brgy,
            'city_id' => $city,
            'province_id' => $province,
            'is_home' => 0
        );

        $this->db->insert('gs_spr_profile_address_info', $data);

        if ($this->db->affected_rows()):
            return $add_id;
        else:
            return false;
        endif;
    }

    function addSchool($school_name, $idSchool, $id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);

        $this->db->where('school_id', $idSchool);
        $q = $this->db->get('gs_spr_school');

        if ($q->num_rows() > 0):
            $data = array(
                'school_name' => $school_name,
                'school_add_id' => $id
            );

            $this->db->where('school_id', $idSchool);
            $this->db->update('gs_spr_school', $data);
        else:
            $data = array(
                'spr_school_id' => $this->eskwela->code(),
                'school_name' => $school_name,
                'school_id' => $idSchool,
                'school_add_id' => $id
            );

            $this->db->insert('gs_spr_school', $data);
        endif;
    }
    
    
    function getObserveValues($stid, $school_year = NULL){
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        
        $this->db->where('ov_st_id', $stid);
        return $this->db->get('gs_spr_ov')->row();
    }

}
