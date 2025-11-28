<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class get_registrar_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function admissionDetailsForStudent($st_id)
    {
        return $this->db->select('*')
            ->select('profile.firstname')
            ->select('profile.middlename')
            ->select('profile.avatar')
            ->select('profile.lastname')
            ->select('profile.temp_bdate')
            ->select('profile.bplace_id')
            ->select('profile.add_id')
            ->select('profile.sex')
            ->select('religion.religion')
            ->select('grade_level.level')
            ->select('profile_students_admission.str_id')
            ->select('profile_students_admission.date_admitted')
            ->select('profile_students_admission.school_year')
            ->select('prof_add.street')
            ->select('barangay.barangay')
            ->select('cities.mun_city')
            ->select('provinces.province')
            ->select('prof_add.country')
            ->select('prof_add.zip_code')
            ->select('profile_contact_details.cd_mobile')
            ->select('profile_contact_details.cd_email')
            ->select('profile_parent.f_firstname')
            ->select('profile_parent.f_middlename')
            ->select('profile_parent.f_lastname')
            ->select('profile_parent.f_mobile')
            ->select('profile_parent.f_occ')
            ->select('f_occ.occupation f_occup')
            ->select('profile_parent.f_educ')
            ->select('f_educ.attainment f_att')
            ->select('profile_parent.f_office_name')
            ->select('f_add.street f_street')
            ->select('f_barangay.barangay f_barangay')
            ->select('f_cities.mun_city f_city')
            ->select('f_provinces.province f_prov')
            ->select('f_add.country f_country')
            ->select('f_add.zip_code f_zip')
            ->select('profile_parent.m_firstname')
            ->select('profile_parent.m_middlename')
            ->select('profile_parent.m_lastname')
            ->select('profile_parent.m_mobile')
            ->select('profile_parent.m_occ')
            ->select('profile_parent.m_educ')
            ->select('m_educ.attainment m_att')
            ->select('m_occ.occupation m_occup')
            ->select('profile_parent.m_office_name')
            ->select('m_add.street m_street')
            ->select('m_barangay.barangay m_barangay')
            ->select('m_cities.mun_city m_city')
            ->select('m_provinces.province m_prov')
            ->select('m_add.country m_country')
            ->select('m_add.zip_code m_zip')
            ->select('profile_parent.ice_name')
            ->select('profile_parent.ice_contact')
            ->select('section.section')
            ->select('profile_students.lrn')
            ->join('religion', 'profile.rel_id = religion.rel_id', 'INNER')
            ->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'INNER')
            ->join('section', 'section.section_id = profile_students_admission.section_id', 'INNER')
            // ->join('profile_students','profile.user_id = profile_students.user_id','INNER')
            ->join('profile_students', 'profile_students_admission.st_id = profile_students.st_id')
            ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'INNER')
            ->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'INNER')
            ->join('profile_address_info prof_add', 'profile.add_id = prof_add.address_id', 'INNER')
            ->join('barangay', 'prof_add.barangay_id = barangay.barangay_id', 'LEFT')
            ->join('cities', 'prof_add.city_id = cities.id', 'LEFT')
            ->join('provinces', 'prof_add.province_id = provinces.id', 'LEFT')
            ->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'INNER')
            ->join('profile_address_info f_add', 'profile_parent.f_office_address_id = f_add.address_id', 'LEFT')
            ->join('barangay f_barangay', 'f_add.barangay_id = f_barangay.barangay_id', 'LEFT')
            ->join('cities f_cities', 'f_add.city_id = f_cities.id', 'LEFT')
            ->join('provinces f_provinces', 'f_add.province_id = f_provinces.id', 'LEFT')
            ->join('profile_occupation f_occ', 'profile_parent.f_occ = f_occ.occ_id', 'LEFT')
            ->join('profile_educ_attain f_educ', 'profile_parent.f_educ = f_educ.ea_id', 'LEFT')
            ->join('profile_address_info m_add', 'profile_parent.m_office_address_id = m_add.address_id', 'LEFT')
            ->join('barangay m_barangay', 'm_add.barangay_id = m_barangay.barangay_id', 'LEFT')
            ->join('cities m_cities', 'm_add.city_id = m_cities.id', 'LEFT')
            ->join('provinces m_provinces', 'm_add.province_id = m_provinces.id', 'LEFT')
            ->join('profile_occupation m_occ', 'profile_parent.m_occ = m_occ.occ_id', 'LEFT')
            ->join('profile_educ_attain m_educ', 'profile_parent.m_educ = m_educ.ea_id', 'LEFT')
            ->where('profile_students_admission.st_id', $st_id)
            ->get('profile');
    }

    function getBasicStudentsByLevel()
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->select('profile_students.user_id as uid');
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students_admission.school_year');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students_admission.status', 1);
        $this->db->order_by('lastname');
        $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        //        if($year!=NULL):
        //            $this->db->where('profile_students_c_admission.school_year', $year);
        //        else:
        //        endif;
        $query = $this->db->get();
        return $query;
    }

    function getAllCollegeStudentsByLevel()
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->select('profile_students.user_id as uid');
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students_c_admission.school_year');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left');
        $this->db->where('profile_students_c_admission.status', 1);
        $this->db->order_by('lastname');
        $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        //        if($year!=NULL):
        //            $this->db->where('profile_students_c_admission.school_year', $year);
        //        else:
        //        endif;
        $query = $this->db->get();
        return $query;
    }

    function getSHStrand($strand_id)
    {
        ($strand_id != NULL ? $this->db->where('st_id', $strand_id) : '');
        $this->db->where('offered', 1);
        $q = $this->db->get('sh_strand');
        return ($strand_id != NULL ? $q->row() : $q->result());
    }

    function updateStudentStatus($admission_id)
    {
        $this->db->where('admission_id', $admission_id);
        if ($this->db->update('profile_students_admission', array('status' => 1))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkParentsID($lastname, $add_id)
    {
        $this->db->where('lastname', $lastname);
        $this->db->where('add_id', $add_id);
        $this->db->where('account_type', 4);
        $this->db->where('sex', 'Male');
        $f = $this->db->get('profile');
        if ($f->num_rows() > 0):
            $fdata = $f->row();
            $fname = $fdata->firstname;
            $flname = $fdata->lastname;
            $fuser_id = $fdata->user_id;
        else:
            $fname = "";
            $flname = "";
            $fuser_id = 0;
        endif;
        $this->db->where('lastname', $lastname);
        $this->db->where('add_id', $add_id);
        $this->db->where('account_type', 4);
        $this->db->where('sex', 'Female');
        $m = $this->db->get('profile');
        if ($m->num_rows() > 0):
            $mdata = $m->row();
            $mname = $mdata->firstname;
            $mlname = $mdata->lastname;
            $muser_id = $mdata->user_id;
        else:
            $mname = "";
            $mlname = "";
            $muser_id = 0;
        endif;

        $details = array(
            'fname' => $fname,
            'flname' => $flname,
            'fuser_id' => $fuser_id,
            'mname' => $mname,
            'mlname' => $mlname,
            'muser_id' => $muser_id
        );

        return json_encode($details);
    }

    function getSpecialization($specs_id)
    {
        if ($specs_id != NULL):
            $this->db->where('specialization_id', $specs_id);
            $q = $this->db->get('gs_specialization');
            return $q->row();
        else:
            $q = $this->db->get('gs_specialization');
            return $q->result();
        endif;
    }

    function getBasicInfo($user_id, $year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->where('profile_students.user_id', $user_id);
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $query = $this->db->get('profile_students');
        return $query->row();
    }

    //    function insertData($details, $table, $column=NULL, $value=NULL)
    //    {
    //        if($column==NULL):
    //            if($this->db->insert($table, $details)):
    //               return TRUE;
    //            else:
    //                return FALSE;
    //            endif;
    //        else:
    //            $this->db->where($column, $value);
    //            if($this->db->update($table, $details)):
    //               return TRUE;
    //            else:
    //                return FALSE;
    //            endif;
    //        endif;
    //    }

    function insertData($details, $table, $column = NULL, $value = NULL, $school_year = NULL)
    {
        $db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        if ($column == NULL):
            if ($db->insert($table, $details)):
                // $runScript = $this->db->last_query();
                // Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $db->where($column, $value);
            $q = $db->get($table);
            if ($q->num_rows() > 0):
                $db->where($column, $value);
                if ($db->update($table, $details)):
                    // $runScript = $this->db->last_query();
                    // Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                    return TRUE;
                else:
                    return FALSE;
                endif;
            else:
                if ($db->insert($table, $details)):
                    // $runScript = $this->db->last_query();
                    // Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                    return TRUE;
                else:
                    return FALSE;
                endif;

            endif;
        endif;
    }

    function getPreviousRecord($table, $columns, $value, $school_year, $settings)
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

    function getSingleCollegeStudent($id, $year)
    {
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
        if ($year == NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;

        $this->db->where('profile_students.st_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getTotalCollegeStudents($course, $level, $school_year, $semester, $status)
    {

        $this->db->join('profile_students', 'profile_students_c_admission.user_id = profile_students.user_id', 'inner');
        //  $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'inner');
        if ($course != NULL):
            $this->db->where('course_id', $course);
        endif;
        if ($level != NULL):
            $this->db->where('year_level', $level);
        endif;
        $this->db->where('semester', $semester);
        $this->db->where('school_year', $school_year);
        $this->db->where('profile_students_c_admission.status', $status);
        $q = $this->db->get('profile_students_c_admission');
        return $q->num_rows();
    }

    function getAllCollegeStudents($limit, $offset, $course, $level, $year = NULL, $sem = NULL)
    {
        //$this->db->cache_on();

        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_c_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if ($year == NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;
        if ($sem != NULL):
            $this->db->where('semester', $sem);
        endif;

        $this->db->where('account_type', 5);
        if (!$this->session->userdata('is_admin')) {
            $this->db->where('profile_students_c_admission.status', 1);
        }
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if ($limit != "" || $offset = "") {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function getAllStudentsByLevel($grade_level, $section_id, $year = NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.user_id as uid');
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

    function getNumberOfStudentPerSection($section_id, $year, $status)
    {
        $this->db->select('profile_students.st_id');
        $this->db->select('profile_students_admission.section_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        if ($section_id != Null) {
            $this->db->where('profile_students_admission.section_id', $section_id);
        }
        $this->db->where('profile_students_admission.school_year', $year);
        $this->db->where('profile_students_admission.status', $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getMLM($year, $month, $grade_id, $code)
    {
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('mlm_grade_id', $grade_id);
        $this->db->where('code_indicator', $code);
        $query = $this->db->get('profile_students_mlm');
        return $query;
    }

    function getStudentPerRO($ro, $section_id, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('school_year', $ro);
        $this->db->where('section_id', $section_id);
        $query = $this->db->get('profile_students_admission');
        return $query->num_rows();
    }

    function deleteROStudent($user_id, $sy, $adm_id = NULL)
    {
        if ($adm_id == NULL):
            $this->db->where('user_id', $user_id);
            $this->db->where('school_year', $sy);
        else:
            $this->db->where('admission_id', $adm_id);
        endif;
        if ($this->db->delete('profile_students_admission')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkCollegeRO($user_id, $semester, $school_year)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $query = $this->db->get('profile_students_c_admission');

        if ($query->num_rows > 0):
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

        if ($query->num_rows > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function saveCollegeRO($details)
    {
        if ($this->db->insert('profile_students_c_admission', $details)):
            $return = array(
                'status' => TRUE,
                'data' => $this->db->insert_id(),
            );
            return $return;
        else:
            return FALSE;
        endif;
    }

    function saveRO($details)
    {
        if ($this->db->insert('profile_students_admission', $details)):
            $return = array(
                'status' => TRUE,
                'data' => $this->db->insert_id(),
            );
            return $return;
        else:
            return FALSE;
        endif;
    }

    function getStudentBySY($year, $limit = NULL, $offset = NULL, $status = NULL, $semester = NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile_students_admission.status as status');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('grade_id');
        $this->db->select('section');
        $this->db->select('level');
        $this->db->select('sex');
        $this->db->select('ro_years');
        $this->db->select('rfid');
        $this->db->select('avatar');
        $this->db->select('semester');
        //$this->db->select('*');

        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('profile_students_ro_years', 'profile_students_admission.school_year = profile_students_ro_years.ro_years', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students_ro_years.ro_years', $year);
        $this->db->where('profile_students_admission.semester', $semester);
        if ($status != NULL):
            $this->db->where('profile_students_admission.status', $status);
        endif;
        if ($limit != NULL || $offset = NULL) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    function getCollegeStudentBySY($limit, $offset, $year, $sem, $course = NULL, $level = NULL, $status)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_c_admission.status as status');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_c_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'left');
        $this->db->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if ($year == NULL):
            $this->db->where('profile_students_c_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_c_admission.school_year', $year);
        endif;
        if ($course != NULL):
            $this->db->where('profile_students_c_admission.course_id', $course);
        endif;
        if ($sem != NULL):
            $this->db->where('semester', $sem);
        endif;
        if ($level != NULL):
            $this->db->where('year_level', $level);
        endif;

        $this->db->where('account_type', 5);
        ($status != NULL ? $this->db->where('profile_students_c_admission.status', $status) : "");
        $this->db->order_by('year_level', 'ASC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        $this->db->group_by('profile.user_id');

        if ($limit != NULL || $offset = NULL) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function getROYear()
    {
        $this->db->select('*');
        $this->db->from('profile_students_ro_years');
        $this->db->order_by('ro_years', 'ASC');

        $ro = $this->db->get();

        return $ro->result();
        // $ro = $this->db->get('profile_students_ro_years');
        // return $ro->result();
    }

    function getLrnByID($st_id, $sy = NULL)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->select('st_id');
        $this->db->select('profile.user_id as uid');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where('profile.user_id', $st_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getBasicStudent($st_id, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.st_id', $st_id);
        if ($school_year != NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get();
        return $query;
    }

    function getStudentListForParent($pid)
    {
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.parent_id', $pid);
        $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        $this->db->order_by('profile_students_admission.grade_level_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getAllStudentsForCard($limit, $offset, $section_id, $school_year = NULL)
    {
        $this->db->select('*');
        $this->db->select('profile_students_admission.school_year');
        $this->db->select('profile_students.st_id');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.lrn');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('lastname');
        $this->db->select('level');
        $this->db->select('bdate_id');
        $this->db->select('temp_bdate');
        $this->db->select('profile_students_admission.section_id');
        $this->db->select('account_type');
        $this->db->select('profile_students_admission.str_id as strnd_id');

        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        if ($section_id != Null) {
            $this->db->where('profile_students_admission.section_id', $section_id);
        }

        $this->db->where('account_type', 5);
        $this->db->where('profile_students_admission.school_year', ($school_year == NULL ? $this->session->userdata('school_year') : $school_year));

        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if ($limit != "" || $offset = "") {
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
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');

        if ($grade_id != Null) {
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }
        if ($section != Null) {
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('avatar !=', 'noImage.png');

        $this->db->where('account_type', 5);

        $this->db->where('profile_students_admission.status', 1);

        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        //

        if ($limit != "" || $offset = "") {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function displayAllStudents($limit, $offset, $grade_id, $section, $year = NULL)
    {
        $sy = ($year != NULL ? $year : $this->session->school_year);
        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as stats');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile.user_id as u_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students_admission.school_year', $sy);
        //        ($grade_id != NULL && $grade_id != 0 ? $this->db->where('profile_students_admission.grade_level_id', $grade_id) : '');
        //        ($section != NULL ? $this->db->where('profile_students_admission.section_id', $section) : '');
        $this->db->where('account_type', 5);
        if (!$this->session->userdata('is_admin')) {
            $this->db->where('profile_students_admission.status', 1);
        }
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('sex', 'DESC');
        $this->db->group_by('profile_students_admission.user_id');
        //

        if ($limit != "" || $offset = "") {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function getAllStudents($limit, $offset, $grade_id, $section, $year = NULL, $opt = NULL)
    {
        //$this->db->cache_on();
        if ($year == NULL):
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
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'inner');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        //$this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        if ($year == NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $year);
        endif;

        if ($grade_id != Null && $grade_id != 0) {
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }
        if ($section != Null) {
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('account_type', 5);
        //        if(!$this->session->userdata('is_admin')){
        //            $this->db->where('profile_students_admission.status', 1);
        //        }
        ($opt != NULL ? $this->db->where('profile_students_admission.status', 1) : '');
        $this->db->order_by('lastname', 'ASC');
        // $this->db->order_by('sex', 'DESC');
        // $this->db->group_by('profile_students.st_id');
        //

        if ($limit != "" || $offset = "") {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function getTotalStudents($year = NULL)
    {
        if ($year == NULL):
            $year = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($year);

        $this->db->select('*');
        $this->db->from('profile_students_admission');
        $this->db->where('status', 1);
        return $this->db->get();
    }

    function getNumberOfStudentsPerMonth($month, $gender)
    {
        $this->db->select('st_id');
        $this->db->select('profile_students_admission.status as stat');
        $this->db->select('sex');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $query = $this->db->get();
        return $query;
    }

    //function getStudentToDelete($school_year)

    function getStudentsForGS($grade_id, $section, $gender, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        if ($school_year == NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;

        if ($gender != Null) {
            $this->db->where('sex', $gender);
        }
        if ($grade_id != Null) {
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }

        if ($section != Null) {
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('account_type', 5);
        $this->db->order_by('sex', 'DESC');
        $this->db->order_by('lastname', 'ASC');

        $query = $this->db->get();
        return $query;
    }

    function getStudents($grade_id, $section, $gender, $status, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as st_id');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->select('profile.contact_id as con_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parent', 'profile_parent.u_id = profile.user_id', 'left');
        //        $this->db->join('profile_parents', 'profile_students.parent_id = profile_parents.parent_id', 'left');
        if ($school_year == NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        if ($status != NULL) {
            $this->db->where('profile_students_admission.status', $status);
        }

        if ($gender != Null) {
            $this->db->where('sex', $gender);
        }
        if ($grade_id != Null) {
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        }

        if ($section != Null) {
            $this->db->where('profile_students_admission.section_id', $section);
        }
        $this->db->where('account_type', 5);
        $this->db->order_by('sex', 'DESC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $this->db->group_by('profile_students_admission.user_id');

        $query = $this->db->get();
        return $query;
    }

    function getAllStudentsBasicInfoByGender($grade_id, $gender, $status, $year = NULL, $strand = NULL, $section_id = NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('rfid');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('profile_students_admission.section_id');
        $this->db->select('profile_students_admission.status');
        $this->db->select('profile_students_admission.school_year');
        $this->db->select('sex');
        $this->db->from('profile_students_admission');
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');

        ($strand != NULL && $strand != 0 ? $this->db->where('profile_students_admission.str_id', $strand) : '');
        if ($section_id != NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        if ($grade_id != NULL):
            $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        endif;
        //        if ($strand == NULL):
        //            $this->db->where('profile_students_admission.section_id', $section_id);
        //        else:
        //            $this->db->where('profile_students_admission.grade_level_id', $section_id);
        //            $this->db->where('profile_students_admission.str_id', $strand);
        //        endif;
        if ($gender != NULL):
        // $this->db->where('sex', $gender);
        endif;
        if ($status != NULL) {
            $this->db->where('profile_students_admission.status', $status);
        }
        if ($year != NULL):
            $this->db->where('profile_students_admission.school_year', $year);
        else:
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        endif;
        $this->db->order_by('sex', 'DESC');
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    //    function getAllStudentsBasicInfoByGender($section_id, $gender, $status, $year = NULL, $strand) {
    //        $this->db = $this->eskwela->db($year);
    //        $this->db->select('*');
    //        $this->db->select('profile_students.st_id as st_id');
    //        $this->db->select('profile.user_id as u_id');
    //        $this->db->select('rfid');
    //        $this->db->select('lastname');
    //        $this->db->select('firstname');
    //        $this->db->select('middlename');
    //        $this->db->select('profile_students_admission.section_id');
    //        $this->db->select('profile_students_admission.status');
    //        $this->db->select('profile_students_admission.school_year');
    //        $this->db->select('sex');
    //        $this->db->from('profile_students');
    //        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
    //        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
    //        if ($strand == NULL):
    //            $this->db->where('profile_students_admission.section_id', $section_id);
    //        else:
    //            $this->db->where('profile_students_admission.grade_level_id', $section_id);
    //            $this->db->where('profile_students_admission.str_id', $strand);
    //        endif;
    //        if ($gender != NULL):
    //            $this->db->where('sex', $gender);
    //        endif;
    //        if ($status != NULL) {
    //            $this->db->where('profile_students_admission.status', $status);
    //        }
    //        if ($year != NULL):
    //            $this->db->where('profile_students_admission.school_year', $year);
    //        else:
    //            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
    //        endif;
    //        $this->db->order_by('sex', 'DESC');
    //        $this->db->order_by('lastname', 'ASC');
    //        $query = $this->db->get();
    //        return $query;
    //    }

    function getAllStudentsByGender($section_id, $gender, $status, $year = NULL, $strand = NULL, $grade_id = NULL)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.user_id as psid');
        $this->db->from('profile_students_admission');
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        ($strand != NULL ? $this->db->where('str_id', $strand) : '');
        $this->db->where('section_id', $section_id);
        ($grade_id != NULL ? $this->db->where('grade_level_id', $grade_id) : '');
        //        if ($strand == NULL):
        //            $this->db->where('profile_students_admission.section_id', $section_id);
        //        else:
        //            $this->db->where('profile_students_admission.grade_level_id', $section_id);
        //            $this->db->where('profile_students_admission.str_id', $strand);
        //        endif;
        // $this->db->where('sex', $gender);
        if ($status != NULL) {
            $this->db->where('profile_students_admission.status', $status);
        }
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
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        $this->db->where('profile_students_admission.section_id', $section_id);
        $this->db->where('sex', $gender);
        if ($status != "") {
            $this->db->where('profile_students_admission.status', $status);
        }
        $this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    function getSingleStudentSPR($st_id, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->join('gs_spr', 'gs_spr.st_id = gs_spr_profile.sprp_st_id', 'left');
        $this->db->where('sprp_st_id', $st_id);
        return $this->db->get('gs_spr_profile')->row();
    }

    function getSingleStudent($id, $year, $semester)
    {
        $this->db = $this->eskwela->db($year == NULL ? $this->session->school_year : $year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('lrn');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students_admission.school_year as sy');
        $this->db->select('profile_students_admission.grade_level_id as gl_id');
        $this->db->select('profile_students_admission.str_id as strnd_id');
        $this->db->from('profile_students_admission');
        $this->db->join('profile_students', 'profile_students.st_id = profile_students_admission.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id', 'left');
        // $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        // $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        $this->db->join('profile_medical', 'profile.user_id = profile_medical.user_id', 'left');
        ($semester != NULL ? $this->db->where('semester', $semester) : '');
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

    function getSingleStudentByRfid($rfid, $year = NULL)
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->where('rfid', $rfid);
        $query = $this->db->get();
        if ($query->row()->account_type == 5):
            $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
            $this->db->where('rfid', $rfid);
            $q2 = $this->db->get('profile');
        else:
            $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
            $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
            $this->db->where('rfid', $rfid);
            $q2 = $this->db->get('profile');
        endif;
        return $q2;
    }

    /*
      function getSingleStudentByRfid($rfid, $year=NULL)
      {
      $this->db->select('*');
      $this->db->from('profile');
      $this->db->where('rfid', $rfid);
      $query = $this->db->get();
      if($query->row()->account_type==5):
      $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'inner');
      //$this->db->join('profile_students_c_admission', 'profile.user_id = profile_students_c_admission.user_id', 'inner');
      $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
      $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
      $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
      $this->db->where('rfid', $rfid);
      $q2 = $this->db->get('profile');
      else:
      $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
      $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
      $this->db->where('rfid', $rfid);
      $q2 = $this->db->get('profile');
      endif;
      return $q2;
      }
     */

    function getMother($id)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as mid');
        $this->db->select('profile.contact_id as con_id');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.mother_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('profile_educ_attain', 'profile.educ_attain_id  = profile_educ_attain.ea_id', 'left');
        $this->db->join('profile_occupation', 'profile.occupation_id  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parents.parent_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getFather($id)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as fid');
        $this->db->select('profile.contact_id as con_id');
        $this->db->from('profile_parents');
        $this->db->join('profile', 'profile_parents.father_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('profile_educ_attain', 'profile.educ_attain_id  = profile_educ_attain.ea_id', 'left');
        $this->db->join('profile_occupation', 'profile.occupation_id  = profile_occupation.occ_id', 'left');
        $this->db->where('profile_parents.parent_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getParentInfo($id, $opt)
    {
        $this->db->join('profile_occupation', 'profile_occupation.occ_id = profile_parent.' . $opt . '_occ', 'left');
        $this->db->join('profile_educ_attain', 'profile_educ_attain.ea_id = profile_parent.' . $opt . '_educ', 'left');
        $this->db->where('u_id', $id);
        return $this->db->get('profile_parent')->row();
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

    function getSectionById($id, $strand = NULL, $opt = NULL)
    {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        ($opt != NULL ? $this->db->order_by('grade_level_id', 'ASC') : '');
        ($id != NULL ? $this->db->where('section_id', $id) : '');
        ($strand != NULL ? $this->db->where('str_id', $strand) : '');
        $query = $this->db->get();
        return ($opt == NULL ? $query->row() : $query->result());
    }

    function getSection($id)
    {
        $this->db->select('*');
        $this->db->from('section');
        $this->db->where('section_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getDateEnrolled($id)
    {
        $this->db->select('*');
        $this->db->from('profile_students_admission');
        $this->db->join('calendar', 'profile_students_admission.date_admitted = calendar.cal_id', 'left');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row()->cal_date;
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
        if ($year == NULL):
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
        if ($section_id != NULL):
            $this->db->where('profile_students_admission.section_id', $section_id);
        endif;
        $query = $this->db->get();
        return $query;
    }

    function update_student_stType($type, $uid, $schoolyear)
    {
        $details = array('st_type' => $type);
        $this->db->where('user_id', $uid);
        $this->db->where('school_year', $schoolyear);
        return ($this->db->update('profile_students_admission', $details)) ? TRUE : FALSE;
    }

    function matchType($id = Null)
    {
        $this->details = $this->eskwela->db(2017);
        $this->details->select('*');
        $this->details->from('profile_students');
        $this->details->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        if ($id != Null):
            $this->details->where('profile_students.st_id', $id);
        endif;
        $result = $this->details->get();
        return $result->result();
    }

    function getMatch($id, $lastname)
    {
        $this->db->select('*');
        $this->db->from('profile_students_admission');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('profile_students_admission.st_id', $id);
        $this->db->where('profile.lastname!=', $lastname);
        $query = $this->db->get();
        return $query->result_array();
    }

    function updateContact($id)
    {
        $this->db->where('user_id', $id);
        $this->db->update('profile', array('contact_id' => $id));
    }

    function transferDate()
    {
        $this->db = $this->eskwela->db(2019);
        $this->db->like('date', '2019-08');
        $query = $this->db->get('attendance_sheet')->result();

        foreach ($query as $q):
            $data = array(
                'att_st_id' => $q->att_st_id,
                'u_rfid' => $q->u_rfid,
                'time_in' => $q->time_in,
                'time_out' => $q->time_out,
                'timestamp' => $q->timestamp,
                'date' => $q->date,
                'time_in_pm' => $q->time_in_pm,
                'time_out_pm' => $q->time_out_pm,
                'status' => $q->status,
                'remarks' => $q->remarks,
                'remarks_from' => $q->remarks_from,
                'scan_count' => $q->scan_count
            );

            $this->db->insert('attendance_sheet_aug', $data);
        endforeach;
    }

    function checkItem($id, $stid, $opt)
    {
        $this->db->where('checklist_st_id', $stid);
        $q = $this->db->get('enrollment_checklist');

        if ($q->num_rows() > 0):
            if ($q->row()->item_checked != ''):
                $value = explode(',', $q->row()->item_checked);
                $cnt = 0;
                foreach ($value as $v):
                    if ($opt == 1):
                        if ($v != $id):
                            $res[] = $v;
                            if ($cnt == count($value) - 1):
                                array_push($res, $id);
                            endif;
                        endif;
                        $cnt++;
                    elseif ($opt == 0):
                        if ($v != $id):
                            $res[] = $v;
                        endif;
                    endif;
                endforeach;
                $final = implode(',', $res);
            else:
                $final = $id;
            endif;

            $this->db->where('checklist_st_id', $stid);
            $this->db->update('enrollment_checklist', array('item_checked' => $final));
        else:
            $info = array(
                'e_checklist_id' => $this->eskwela->code(),
                'checklist_st_id' => $stid,
                'item_checked' => $id
            );
            $this->db->insert('enrollment_checklist', $info);
        endif;
    }

    function getCheckList($stid)
    {
        $this->db->where('checklist_st_id', $stid);
        return $this->db->get('enrollment_checklist')->row();
    }

    function updateIfRegular($value, $uid)
    {
        $this->db->where('user_id', $uid);
        $this->db->update('profile_students_admission', array('is_esc' => $value));
    }

    function getOvrLoadSub($stid, $term, $school_year)
    {
        $this->db = $this->eskwela->db(($school_year == NULL ? $this->session->school_year : $school_year));
        $this->db->where('st_id', $stid);
        if ($term != NULL):
            $this->db->where('sem', $term);
        endif;
        $this->db->join('subjects', 'subject_overload.sub_id = subjects.subject_id', 'left');
        return $this->db->get('subject_overload')->result();
    }

    function getOvrLoadSubBySection($sec, $sub = NULL, $grade_id = NULL, $term = NULL)
    {
        $this->db->select('*');
        $this->db->select('subject_overload.st_id as std_id');
        $this->db->from('subject_overload');
        $this->db->join('profile_students_admission', 'profile_students_admission.st_id = subject_overload.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('subject_overload.sec_id', $sec);
        if ($grade_id == 12 || $grade_id == 13):
            switch ($term):
                case 1:
                case 2:
                    $sem = 1;
                    break;
                case 3:
                case 4:
                    $sem = 2;
                    break;
            endswitch;
            $this->db->where('subject_overload.sem', $sem);
        endif;
        if ($sub != NULL):
            $this->db->where('subject_overload.sub_id', $sub);
        endif;
        $this->db->group_by('subject_overload.st_id');
        return $this->db->get()->result();
    }

    function getBasicEducationDetails($id)
    {
        $settings = Modules::run('main/getSet');
        $school_year = $settings->school_year;

        $this->db->select('*', 'profile_students_admission.st_id as stid, profile_students_admission.section_id as section_id');
        $this->db->where('profile_students_admission.st_id', $id);
        $this->db->join('profile_students', 'profile_students.st_id = profile_students_admission.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->order_by('admission_id', 'DESC');
        $query = $this->db->get('profile_students_admission');
        $num_rows = $query->num_rows;

        while ($num_rows == 0):
            $eskwelaDB = $this->eskwela->db($school_year);
            if ($eskwelaDB):
                $this->db = $this->eskwela->db($school_year);
                $this->db->select('*', 'profile_students.st_id as stid');
                $this->db->where('profile_students_admission.st_id', $id);
                $this->db->join('profile_students', 'profile_students.st_id = profile_students_admission.st_id', 'left');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
                $this->db->order_by('admission_id', 'DESC');
                $query = $this->db->get('profile_students_admission');
                $num_rows = $query->num_rows();
            else:
                break;
            endif;
            $school_year--;
        endwhile;

        return $query->row();
    }

    function checkBasicRO($st_id, $semester, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('st_id', $st_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $semester);
        $query = $this->db->get('profile_students_admission');

        if ($query->num_rows() > 0):
            return json_encode(array(
                'st_id' => $query->row()->st_id,
                'school_year' => $query->row()->school_year,
                'semester' => $query->row()->semester
            ));
        else:
            return FALSE;
        endif;
    }

    function getSectionByLevel($level, $sy = NULL)
    {
        if ($sy == NULL):
            $sy = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($sy);
        $this->db->select('*');
        $this->db->select('section.section_id as s_id');
        $this->db->from('section');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('schedule', 'section.schedule_id = schedule.sched_id', 'left');
        $this->db->where('grade_level_id', $level);
        $this->db->order_by('section.section_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }

    function saveBasicRO($details, $school_year)
    {
        $db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        if ($db->insert('profile_students_admission', $details)):
            $runScript = $this->db->last_query();
            // Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            $return = array(
                'status' => TRUE,
                'adm_id' => $db->insert_id(),
            );
            return json_encode($return);
        else:
            return FALSE;
        endif;
    }

    function checkStAccStat($id, $tbl, $field, $school_year = NULL)
    {
        $settings = Modules::run('main/getSet');
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $settings->school_year);
        $this->db->where($field, $id);
        return $this->db->get($tbl);
    }

    function getSHOfferedStrand()
    {
        $this->db->where('offered', 1);
        $q = $this->db->get('sh_strand');
        return $q->result();
    }

    function getStrandByID($id)
    {
        $this->db->where('st_id', $id);
        return $this->db->get('sh_strand')->row();
    }

    function getTotalNumOfSt($status, $section)
    {
        $this->db->where('section_id', $section);
        $this->db->where('status', $status);
        return $this->db->get('profile_students_admission');
    }

    function getlevelByOrder($order)
    {
        $this->db->where('order', $order);
        return $this->db->get('grade_level')->row();
    }

    function registerParent($uaDetails, $u, $parent_id, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('uname', $u);
        $checkU = $this->db->get('user_accounts');
        if ($checkU->num_rows() == 0):
            $this->db->where('parent_id', $parent_id);
            $checkP = $this->db->get('user_accounts');
            if ($checkP->num_rows() == 0):
                if ($this->db->insert('user_accounts', $uaDetails)):
                    return json_encode(array('status' => true, 'msg' => 'You have successfully registered a Parent', 'codeError' => 0));
                endif;
            else:
                return json_encode(array('status' => false, 'msg' => 'You are already registered', 'codeError' => 2));
            endif;
        else:
            return json_encode(array('status' => false, 'msg' => 'This username is already Taken', 'codeError' => 1));
        endif;
    }

    function updateParentId($number, $parent_id, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('ice_contact', $number);
        if ($this->db->update('profile_parent', array('p_id' => $parent_id))):
            return true;
        else:
            return false;
        endif;
    }

    function checkUserAcc($val)
    {
        $this->db->select('user_accounts.u_id as uid');
        $this->db->join('profile_parent', 'profile_parent.p_id = user_accounts.u_id', 'left');
        $this->db->where('contact_num', $val);
        $this->db->or_where('ice_contact', $val);
        // $this->db->or_where('uname', $val);
        return $this->db->get('user_accounts');
    }

    function fetch_otp($id, $sy = null)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('otp_user', $id);
        $this->db->where('otp_trans_date', date('Y-m-d'));
        $q = $this->db->get('otp_access');
        return $q->row();
    }

    function resetPassword($pid, $update)
    {
        $this->db->where('u_id', $pid);
        $this->db->update('user_accounts', $update);

        return ($this->db->affected_rows() > 0 ? true : false);
    }
}
