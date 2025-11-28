<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Hr_model
 *
 * @author genesis
 */
class Hr_model extends CI_Model {

    function getPositionByID($pos_id) {
        return $this->db->select('position')
                        ->where('position_id', $pos_id)
                        ->get('profile_position')->row();
    }

    function getDepartmentByID($dept_id) {
        return $this->db->select('department')
                        ->where('dept_id', $dept_id)
                        ->get('department')->row();
    }

    function fetchPersonName($user_id) {
        return $this->db->select('firstname, middlename, lastname')
                        ->where('user_id', $user_id)
                        ->get('profile')->row();
    }

    function fetchDepartmentAssociates($dept) {
        return $this->db->where('dept_id', $dept)
                        ->get('department_heads')->result();
    }

    function editPositionName($pid, $newPosition) {
        $this->db->where('position_id', $pid);
        if ($this->db->update('profile_position', array('position' => $newPosition))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function deletePosition($pid) {
        $this->db->where('position_id', $pid);
        if ($this->db->delete('profile_position')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function editBasicInfo($data, $rowid) {
        $this->db->where('user_id', $rowid);
        if ($this->db->update('profile', $data)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function setDate($data, $id, $type, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('user_id', $id);
        $this->db->update('profile', array($type => $data));
    }

    function setContacts($mobile, $email, $user_id = NULL, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));

        $this->db->where('contact_id', $user_id);
        $c = $this->db->get('profile_contact_details');
        if ($c->num_rows == 0):
            $data1 = array(
                'contact_id' => $user_id,
                'cd_phone' => 0,
                'cd_mobile' => $mobile,
                'cd_email' => $email
            );

            $this->db->insert('profile_contact_details', $data1);
        else:
            $data1 = array(
                'cd_phone' => 0,
                'cd_mobile' => $mobile,
                'cd_email' => $email
            );
            $this->db->where('contact_id', $user_id);
            $this->db->update('profile_contact_details', $data1);
        endif;

//        $data1 = array(
//            'cd_phone' => 0,
//            'cd_mobile' => $mobile,
//            'cd_email' => $email
//        );
//        $this->db->insert('profile_contact_details', $data1);
//
//        return $this->db->insert_id();
    }

    function setAddress($data, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->insert('profile_address_info', $data);
        $runScript = $this->db->last_query();
        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        return $this->db->insert_id();
    }

    function setBarangay($barangay, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        $this->db->where('barangay', $barangay);
        $query = $this->db->get('barangay');
        if ($query->num_rows() > 0):
            return $query->row()->barangay_id;
        else:
            $data = array('barangay' => $barangay, 'barangay_id'=>$this->eskwela->codeCheck('barangay', 'barangay_id', $this->eskwela->code()));
            $this->db->insert('barangay', $data);

            return $this->db->insert_id();
        endif;
    }

    //Admission process  
    function saveProfile($data, $user_id = NULL, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        if ($user_id != NULL):
            $this->db->where('user_id', $user_id);
            $q = $this->db->get('profile');
            if ($q->num_rows() > 0):
                return $q->row()->user_id;
            else:
                $this->db->insert('profile', $data);
                $runScript = $this->db->last_query();
                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return $this->db->insert_id();
            endif;
        else:
            $this->db->insert('profile', $data);
            $runScript = $this->db->last_query();
            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return $this->db->insert_id();
        endif;
    }

    function getLatestId() {
        $q = $this->db->join('profile', 'profile_employee.user_id = profile.user_id')
                ->order_by('profile.esk_profile_code', 'DESC')
                ->limit(1)
                ->get('profile_employee');
        return substr(($q->row()->employee_id + 1), -3);
    }

    function getTimeShift($time_group_id) {
        $this->db->where('ps_id', $time_group_id);
        $q = $this->db->get('payroll_shift');
        return $q->row();
    }

    function editHrTime($column, $att_id, $time, $mon) {
        $this->db->where('att_id', $att_id);
        if ($this->db->update(strtolower('attendance_sheet_' . $mon), array($column => $time))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getTime($time_id) {
        $this->db->where('ps_id', $time_id);
        $q = $this->db->get('payroll_shift');
        return $q->row();
    }

    function getTimeSettings() {
        $q = $this->db->get('profile_employee_time_settings');
        return $q->result();
    }

    public function saveContacts($user_id, $mobile, $column = NULL, $school_year = NULL) {
        $this->db = ($school_year == NULL ? $this->eskwela->db($this->session->school_year) : $this->eskwela->db($school_year));
        if ($column == NULL):
            $details = array('cd_mobile' => $mobile);
        else:
            $details = array($column => $mobile);
        endif;

        $this->db->where('contact_id', $user_id);
        $q = $this->db->get('profile_contact_details');
        if ($q->num_rows() > 0):
            $this->db->where('contact_id', $user_id);
            $this->db->update('profile_contact_details', $details);
            $this->db->where('user_id', $user_id);
            $this->db->update('profile', array('contact_id' => $user_id));
            return $user_id;
        else:
            $this->db->insert('profile_contact_details', array('contact_id' => $user_id, $column => $mobile));
            $this->db->where('user_id', $user_id);
            $this->db->update('profile', array('contact_id' => $user_id));
            return $this->db->insert_id();
        endif;
    }

    function deleteEducBak($id) {
        $this->db->where('eb_id', $id);
        if ($this->db->delete('profile_employee_education')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkIfIDExist($id) {
        $this->db->where('employee_id', $id);
        $q = $this->db->get('profile_employee');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function deleteEmployee($user_id, $em_id) {
        $this->db->where('user_id', $user_id);
        $this->db->delete('profile_employee');
    }

    function deleteProfile($column, $id, $table) {
        $this->db->where($column, $id);
        $this->db->delete($table);

        return True;
    }

    function getEmployeeName($id) {
        $this->db->select('avatar');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('employee_id');
        $this->db->select('pay_type');
        $this->db->select('position');
        $this->db->select('salary');
        $this->db->select('profile.user_id');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->where('employee_id', $id);
        $q = $this->db->get();
        return $q->row();
    }

    function updateODTrans($od_trans_id, $column, $c_value) {
        $this->db->where('od_trans_id', $od_trans_id);
        $array = array(
            $column => $c_value
        );
        $this->db->update('profile_employee_od_transaction', $array);
        return;
    }

    function approvedLoanApp($data, $user_id, $od_id) {
        $this->db->where('od_acnt_id', $user_id);
        $this->db->where('od_id', $od_id);
        if ($this->db->update('profile_employee_od', $data)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getPayrollTrans($em_id, $start_date, $endDate) {
        $this->db->where('p_acct_id', $em_id);
        $this->db->where('p_date_fr', $start_date);
        $this->db->where('p_date_to', $endDate);
        $q = $this->db->get('profile_employee_payroll_trans');
        return $q->row();
    }

    function savePR_transaction($details) {
        if ($this->db->insert('profile_employee_payroll_trans', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getSingleLoanApp($user_id, $od_id) {
        $this->db->select('odi_items');
        $this->db->select('od_id');
        $this->db->select('odp_terms');
        $this->db->select('od_acnt_id');
        $this->db->select('charge');
        $this->db->select('no_terms');
        $this->db->select('od_timestamp');
        $this->db->from('profile_employee_od');
        $this->db->join('profile_employee_od_items', 'profile_employee_od.od_item_id = profile_employee_od_items.odi_id', 'left');
        $this->db->join('profile_employee_od_payment_terms', 'profile_employee_od.od_terms_id = profile_employee_od_payment_terms.odp_id', 'left');
        $this->db->join('profile_employee_od_transaction', 'profile_employee_od.od_id = profile_employee_od_transaction.od_deduct_id', 'left');
        if ($user_id != NULL):
            $this->db->where('od_acnt_id', $user_id);
        endif;
        if ($od_id != NULL):
            $this->db->where('od_id', $od_id);
        endif;
        $q = $this->db->get();
        return json_encode(array('status' => TRUE, 'data' => $q->row()));
    }

    function saveOdTrans($data, $od_id = NULL) {
        if ($od_id != NULL):
            $this->db->where('od_trans_id', $od_id);
            if ($this->db->update('profile_employee_od_transaction', $data)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            if ($this->db->insert('profile_employee_od_transaction', $data)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }

    function getPersonalLoanRequest($user_id, $item_id = NULL) {
        $this->db->select('*');
        $this->db->from('profile_employee_od');
        $this->db->join('profile_employee_od_items', 'profile_employee_od.od_item_id = profile_employee_od_items.odi_id', 'left');
        $this->db->join('profile_employee_od_payment_terms', 'profile_employee_od.od_terms_id = profile_employee_od_payment_terms.odp_id', 'left');
        $this->db->join('profile_employee_od_transaction', 'profile_employee_od.od_id = profile_employee_od_transaction.od_deduct_id', 'left');
        $this->db->where('paid_off', 0);
        $this->db->order_by('od_trans_id', 'DESC');
        if ($user_id != NULL):
            $this->db->where('od_acnt_id', $user_id);
        endif;
        if ($item_id != NULL):
            $this->db->where('od_item_id', $item_id);
        endif;
        $q = $this->db->get();
        if ($q->num_rows() > 0):
            return $q;
        else:
            return FALSE;
        endif;
    }

    function getLoanRequest($item_id, $user_id, $status = NULL) {
        $this->db->select('*');
        $this->db->from('profile_employee_od');
        $this->db->join('profile_employee_od_items', 'profile_employee_od.od_item_id = profile_employee_od_items.odi_id', 'left');
        $this->db->join('profile_employee_od_payment_terms', 'profile_employee_od.od_terms_id = profile_employee_od_payment_terms.odp_id', 'left');
        $this->db->join('profile_employee_od_transaction', 'profile_employee_od.od_id = profile_employee_od_transaction.od_deduct_id', 'left');
        $this->db->join('profile_employee', 'profile_employee_od.od_acnt_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        if ($user_id != NULL):
            $this->db->where('od_acnt_id', $user_id);
        endif;
        if ($item_id != NULL):
            $this->db->where('od_item_id', $item_id);
        endif;
        if ($status != NULL):
            $this->db->where('paid_off', $status);
        endif;
        $q = $this->db->get();
        if ($q->num_rows() > 0):
            return json_encode(array('status' => TRUE, 'data' => $q->result()));
        else:
            return json_encode(array('status' => FALSE, 'data' => ''));
        endif;
    }

    function saveLoan($details) {
        $this->db->insert('profile_employee_od', $details);
        return json_encode(array('status' => TRUE, 'id' => $this->db->insert_id()));
    }

    function saveDeduction($details, $items) {
        $this->db->like('odi_items', $items, 'both');
        $q = $this->db->get('profile_employee_od_items');
        if ($q->num_rows() > 0):
            $this->db->where('odi_items', $items);
            $this->db->update('profile_employee_od_items', $details);
            return json_encode(array('status' => FALSE, 'id' => ''));
            ;
        else:
            $this->db->insert('profile_employee_od_items', $details);
            return json_encode(array('status' => TRUE, 'id' => $this->db->insert_id()));
        endif;
    }

    function getOdTerms() {
        $q = $this->db->get('profile_employee_od_payment_terms');
        return $q->result();
    }

    function getOtherDeductions() {
        $q = $this->db->get('profile_employee_od_items');
        return $q->result();
    }

    function addSG($details, $value) {
        $this->db->like('salary', $value, 'both');
        $q = $this->db->get('profile_employee_salary_grade');
        if ($q->num_rows() > 0):
            return json_encode(array('status' => FALSE, 'id' => ''));
            ;
        else:
            $this->db->insert('profile_employee_salary_grade', $details);
            return json_encode(array('status' => TRUE, 'id' => $this->db->insert_id()));
        endif;
    }

    function saveSG($details, $em_id) {
        $this->db->where('employee_id', $em_id);
        if ($this->db->update('profile_employee', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getListOfSalary() {
        $q = $this->db->get('payroll_salary_type');
        return $q->result();
    }

    function editEducHis($details, $eb_id) {
        $this->db->where('eb_id', $eb_id);
        if ($this->db->update('profile_employee_education', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function addEducHis($details, $employee_id, $level_id, $course_id) {
        if ($level_id == 1 || $level_id == 2):
            $this->db->where('eb_employee_id', $employee_id);
            $this->db->where('eb_level_id', 1);
            $q1 = $this->db->get('profile_employee_education');
            if ($q1->num_rows() > 0):
                $this->db->where('eb_employee_id', $employee_id);
                $this->db->where('eb_level_id', 2);
                $q2 = $this->db->get('profile_employee_education');
                if ($q2->num_rows() > 0):
                    return FALSE;
                else:
                    $this->db->insert('profile_employee_education', $details);
                    return TRUE;
                endif;
            else:
                $this->db->insert('profile_employee_education', $details);
                return TRUE;
            endif;
        else:
            $this->db->where('eb_employee_id', $employee_id);
            $this->db->where('eb_level_id', $level_id);
            $this->db->where('eb_course_id', $course_id);
            $q1 = $this->db->get('profile_employee_education');
            if ($q1->num_rows() > 0):
                return FALSE;
            else:
                $this->db->insert('profile_employee_education', $details);
                return TRUE;
            endif;
        endif;
    }

    function getEducationHistory($employee_id, $eb_id = NULL) {

        $this->db->select('*');
        $this->db->from('profile_employee_education');
        $this->db->join('profile_employee_edbak_school', 'profile_employee_education.eb_school_id = profile_employee_edbak_school.s_id', 'left');
        $this->db->join('profile_employee_course', 'profile_employee_education.eb_course_id = profile_employee_course.course_id', 'left');
        $this->db->join('profile_employee_educ_level', 'profile_employee_education.eb_level_id = profile_employee_educ_level.el_id', 'left');
        if ($employee_id != NULL):
            $this->db->where('eb_employee_id', $employee_id);
        endif;
        if ($eb_id != NULL):
            $this->db->where('profile_employee_education.eb_id', $eb_id);
        endif;

        $this->db->order_by('profile_employee_education.eb_level_id', 'ASC');
        $q = $this->db->get();
        return $q;
    }

    function checkMinMaj($value) {
        $this->db->where('maj_min', $value);
        $query = $this->db->get('profile_employee_major_minor');
        if ($query->num_rows() > 0):

            return $query->row()->maj_min_id;
        else:
            $values = array(
                'maj_min' => $value
            );

            $this->db->insert('profile_employee_major_minor', $values);

            return $this->db->insert_id();
        endif;
    }

    function saveMinMaj($id, $details) {
        $this->db->where('eb_employee_id', $id);
        $q = $this->db->get('profile_employee_education');
        if ($q->num_rows() > 0):
            $this->db->where('eb_employee_id', $id);
            if ($this->db->update('profile_employee_education', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->insert('profile_employee_education', $details);
        endif;
    }

    function minMajSub() {
        $query = $this->db->get('profile_employee_major_minor');
        return $query->result();
    }

    function getMinorSubjects($id) {
        $this->db->select('*');
        $this->db->from('profile_employee_education');
        $this->db->join('profile_employee_major_minor', 'profile_employee_education.eb_minor_id = profile_employee_major_minor.maj_min_id', 'left');
        $this->db->where('profile_employee_education.eb_employee_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getMajorSubjects($id) {
        $this->db->select('*');
        $this->db->from('profile_employee_education');
        $this->db->join('profile_employee_major_minor', 'profile_employee_education.eb_major_id = profile_employee_major_minor.maj_min_id', 'left');
        $this->db->where('profile_employee_education.eb_employee_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getBasicInfoOld($teacher_id) {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_employee_edbak.id as edbak_id');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_employee_edbak', 'profile_employee.employee_id = profile_employee_edbak.user_id', 'left');
        $this->db->join('profile_employee_edbak_school', 'profile_employee_edbak.c_school_id = profile_employee_edbak_school.s_id', 'left');
        $this->db->join('profile_employee_course', 'profile_employee_edbak.course_id = profile_employee_course.course_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id = profile_address_info.address_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('department', 'profile_position.position_dept_id = department.dept_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->where('profile_employee.employee_id', $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getBasicInfo($teacher_id) {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_employee.employee_id as em_id');
        $this->db->select('profile_employee_education.eb_id as edbak_id');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_employee_education', 'profile_employee.employee_id = profile_employee_education.eb_employee_id', 'left');
        $this->db->join('profile_employee_edbak_school', 'profile_employee_education.eb_school_id = profile_employee_edbak_school.esk_profile_employee_edbak_school_code', 'left');
        $this->db->join('profile_employee_course', 'profile_employee_education.eb_course_id = profile_employee_course.esk_profile_employee_course_code', 'left');
        $this->db->join('payroll_salary_type', 'profile_employee.pg_id = payroll_salary_type.pst_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id = profile_address_info.address_id', 'left');
        $this->db->join('profile_medical', 'profile.user_id = profile_medical.user_id', 'left');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('department', 'profile_position.position_dept_id = department.dept_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('user_accounts', 'user_accounts.u_id = profile_employee.employee_id', 'left');
        $this->db->where('profile_employee.employee_id', $teacher_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getIndividualNumbers($dept_id) {
        $this->db->select('profile.account_type as dept_id');
        $this->db->select('cd_mobile');
        $this->db->from('profile');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->where('profile.account_type', $dept_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserId($user_id) {
        $this->db->select('user_id');
        $this->db->from('profile');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateProfile($rowid, $details) {
        $this->db->where('rowid', $rowid);
        $this->db->update('profile', $details);
        return TRUE;
    }

    function updateProfileEmployee($rowid, $details, $table) {
        $this->db->where('user_id', $rowid);
        $this->db->update($table, $details);
        return TRUE;
    }
    
    function updateProfileInfo($user_id, $details) {
        $this->db->where('u_id', $user_id);
        $this->db->update('profile_info', $details);
        return TRUE;
    }

    function editAccount($user_id, $details) {
        $this->db->where('u_id', $user_id);
        $this->db->update('user_accounts', $details);
        return TRUE;
    }

    function updateAccount($user_id, $details) {
        $this->db->where('uname', $user_id);
        $this->db->update('user_accounts', $details);
        return TRUE;
    }

    function getUserType($user_id) {
        $this->db->select('*');
        $this->db->from('user_accounts');
        //$this->db->join('user_groups', 'user_accounts.u_type = user_groups.group_id', 'left');
        $this->db->where('u_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getPositionInfo($user_id) {
        $this->db->select('*');
        $this->db->select('profile_employee.position_id = p_id');
        $this->db->from('profile_employee');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_employee.position_id', 'left');
        //$this->db->join('user_groups', 'profile_position.position_dept_id = user_groups.group_id', 'left');
        $this->db->where('u_id', $user_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getDepartment() {
        $this->db->select('*');
        $this->db->from('department');
        $query = $this->db->get();
        return $query->result();
    }

    function getReligion() {
        $this->db->select('*');
        $this->db->from('religion');
        $this->db->order_by('religion', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getPosition($dept_id) {
        $this->db->select('*');
        $this->db->from('profile_position');
        if ($dept_id != NULL) {
            $this->db->where('position_dept_id', $dept_id);
        }
        $this->db->where('position_id !=', 1);
        $this->db->order_by('p_rank ', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function saveAcademeInfo($details) {
        $this->db->insert('profile_employee_edbak', $details);

        return $this->db->insert_id();
    }

    function saveCourse($details) {
        if ($details['course'] != NULL):
            $this->db->like('course', $details['course'], 'both');
            $q = $this->db->get('profile_employee_course');
            if ($q->num_rows() > 0):
                return $q->row()->course_id;
            endif;
        else:
            $details['course_id'] = $this->eskwela->codeCheck('profile_employee_course', 'course_id', $this->eskwela->code());
            $this->db->insert('profile_employee_course', $details);

            return $this->db->insert_id();
        endif;
    }

    function searchCourse($details) {
        $this->db->select('*');
        $this->db->from('profile_employee_course');
        $this->db->like('LOWER(course)', strtolower($details), 'both');
        $query = $this->db->get();
        return $query->result();
    }

    function saveCollege($details) {
        if ($details['school_name'] != NULL):
            $this->db->where('school_name', $details['school_name']);
            $q = $this->db->get('profile_employee_edbak_school');
            if ($q->num_rows() > 0):
                return $q->row()->s_id;
            endif;
        else:
            $details['s_id'] = $this->eskwela->codeCheck('profile_employee_edbak_school', 's_id', $this->eskwela->code());
            $this->db->insert('profile_employee_edbak_school', $details);

            return $this->db->insert_id();
        endif;
    }

    function searchCollege($details) {
        $this->db->select('*');
        $this->db->from('profile_employee_edbak_school');
        $this->db->like('LOWER(school_name)', strtolower($details), 'both');
        $query = $this->db->get();
        return $query->result();
    }

    function saveEmploymentDetails($details) {
        $this->db->insert('profile_employee', $details);
        return;
    }

    function saveMoreInfo($details) {
        $this->db->insert('profile_address_info', $details);
        return;
    }

    function saveAccounts($details) {
        $this->db->insert('user_accounts', $details);
        return;
    }

    function getEmployeeByPosition($position, $position_id) {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        if ($position_id != NULL):
            $this->db->where('profile_position.position_id', $position_id);
        else:
            $this->db->where('profile_position.position', $position);
        endif;
        $query = $this->db->get();
        return $query->row();
    }

    function getEmployeePerDepartment($dept_id, $limit = NULL, $offset = NULL) {
        $this->db->select('*');
        $this->db->select('profile_employee.employee_id as uid');
        $this->db->from('profile_employee');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->where('profile_position.position_id !=', 1);
        $this->db->where('profile_position.position_dept_id', $dept_id);
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');

        if ($limit != NULL || $offset = NULL) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function searchEmployees($value) {
        $this->db->select('*');
        $this->db->select('profile_employee.employee_id as uid');
        $this->db->from('profile_employee');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('user_accounts', 'profile_employee.employee_id = user_accounts.u_id', 'left');
        $this->db->where('profile_position.position_id !=', 1);
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
        $this->db->order_by('profile_position.p_rank', 'DESC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $this->db->like('LOWER(lastname)', strtolower($value), 'both');
        $this->db->or_like('LOWER(position)', strtolower($value), 'both');
        $query = $this->db->get();
        return $query->result();
    }

    function getAllEmployee($limit, $offset, $option = null) {
        $this->db->select('*');
        $this->db->select('profile_employee.employee_id as uid');
        $this->db->from('profile_employee');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('user_accounts', 'profile_employee.employee_id = user_accounts.u_id', 'left');
        $this->db->where('profile_position.position_id !=', 1);
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
        if ($option != NULL):
            $this->db->where('isActive', $option);
        endif;
        $this->db->order_by('profile_position.p_rank', 'DESC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('firstname', 'ASC');

        if ($limit != "" || $offset = "") {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        return $query;
    }

    function getPaymentSchedule() {
        $query = $this->db->get('profile_employee_paymentschedule');
        return $query->row();
    }

    function getSalaryGrade() {
        $this->db->select('*');
        $this->db->select('profile_employee_salary_grade.salary_grade as sg');
        $this->db->from('profile_employee_salary_grade');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPayrollInfo($id) {
        $this->db->select('*');
        $this->db->from('profile_employee');
        $this->db->join('profile_employee_salary_grade', 'profile_employee.pg_id = profile_employee_salary_grade.salary_grade', 'left');
        $this->db->join('profile_employee_deductions', 'profile_employee_salary_grade.salary_grade = profile_employee_deductions.salary_grade', 'left');
        $this->db->where('profile_employee.user_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPayrollReport() {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('profile_employee_salary_grade', 'profile_employee.pg_id = profile_employee_salary_grade.salary_grade', 'left');
        $this->db->join('profile_employee_deductions', 'profile_employee_salary_grade.salary_grade = profile_employee_deductions.salary_grade', 'left');
        $this->db->order_by('profile.lastname', 'asc');
        $this->db->where('account_type !=', 1);
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
        $query = $this->db->get();
        return $query->result();
    }

    public function editPayrollInfo($pk, $table, $id, $column, $value) {
        $sql = "UPDATE $table 
                SET $column = ?
                WHERE $pk = ?";
        if ($this->db->query($sql, array($value, $id))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function editSGList_Deductions($table, $column, $id, $value) {
        $this->db->select('salary_grade');
        $this->db->from($table);
        $this->db->where('salary_grade', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $sql = "UPDATE $table 
                SET $column = ?
                WHERE salary_grade = ?";
            if ($this->db->query($sql, array($value, $id))):
                return TRUE;
            endif;
        }else {
            $details = array(
                'salary_grade' => $id,
                $column => $value
            );
            $this->db->insert($table, $details);
            return TRUE;
        }
    }

    function getDTRRecords($user_id, $start, $end) {

        $month = strtolower(date('M', strtotime($start)));
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->from('attendance_sheet_' . $month);
        $this->db->join('profile', 'attendance_sheet_' . $month . '.u_rfid = profile.rfid', 'left');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->where('profile.user_id', $user_id);
        $this->db->where("date between '" . $start . "' and'" . $end . "'");
        $this->db->order_by('date', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() == 0):
            $this->db->select('*');
            $this->db->from('attendance_sheet_' . $month);
            $this->db->join('profile_employee', 'attendance_sheet_' . $month . '.u_rfid = profile_employee.employee_id', 'left');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
            $this->db->where('profile.user_id', $user_id);
            $this->db->where("date between '" . $start . "' and'" . $end . "'");
            $this->db->order_by('date', 'ASC');
            $query = $this->db->get();
        endif;

        return $query->result();
    }

    function getSpecificAdvisory($uid, $section) {
        $this->db->select('*');
        $this->db->from('advisory');
        $this->db->join('grade_level', 'advisory.grade_id = grade_level.grade_id', 'left');
        $this->db->join('section', 'advisory.section_id = section.section_id', 'left');
        if ($uid != "") {
            $this->db->where('faculty_id', $uid);
        }
        if ($section != "") {
            $this->db->where('advisory.section_id', $section);
        }


        $query = $this->db->get();
        return $query->row();
    }

    function whereYouBelongHead() {
        $this->db->select('*');
        $this->db->from('department_heads');
        $this->db->join('profile_employee', 'profile_employee.employee_id = department_heads.dh_head', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->group_by('dh_head');
        $query = $this->db->get();

        return $query->result();
    }

    function saveDepartmentHeadsAssociates($dept_id, $dhHead, $associates) {
        $data = array(
            'dh_head' => $dhHead,
            'dh_assoc' => $associates,
            'dept_id' => $dept_id,
        );

        $this->db->insert('department_heads', $data);

        return;
    }

    function checkDepartmentHead($empID) {
        $this->db->select('*');
        $this->db->from('department_heads');
        $this->db->where('dh_assoc', $empID);
        $query = $this->db->get();

        return $query->result();
    }

    function getDepartmentHeadInfo($deptHeadID) {
        $this->db->select('*');
        $this->db->from('department_heads');
        $this->db->join('profile_employee', 'profile_employee.employee_id = department_heads.dh_head', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_contact_details', 'profile_contact_details.contact_id = profile.contact_id', 'left');
        $this->db->where('dh_head', $deptHeadID);
        $query = $this->db->get();

        return $query->result();
    }

    function ifDepartmentHead($em_id, $dept_id) {
        $this->db->where('dh_head', $em_id);
        $this->db->where('dept_id', $dept_id);
        $query = $this->db->get('department_heads');

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteAssociates($empID) {
        $this->db->where('dh_id', $empID);
        $this->db->delete('department_heads');

        return;
    }

    function whereYouBelong($dHead) {
        $this->db->select('*');
        $this->db->from('department_heads');
        $this->db->join('profile_employee', 'profile_employee.employee_id = department_heads.dh_assoc', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->where('dh_head', $dHead);
        $this->db->order_by('lastname', 'asc');

        $query = $this->db->get();

        return $query->result();
    }

    function saveNewValue($table, $details) {
        $this->db->insert($table, $details);
        return $this->db->insert_id();
    }

    function getDTR($data) {
        $payDay = date('d');
        if ($payDay > 15) {
            $from = date('m') . '/16/' . date('Y');
            $to = date('m') . '/30/' . date('Y');
        } else {
            $from = date('m') . '/01/' . date('Y');
            $to = date('m') . '/15/' . date('Y');
        }
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->from('attendance_sheet');
        $this->db->join('profile', 'attendance_sheet.u_rfid = profile.rfid', 'left');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->where('profile_employee.employee_id', $data);
        $this->db->where("attendance_sheet.date between '" . $from . "' and'" . $to . "'");
        $this->db->order_by('attendance_sheet.date', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function searchDtrbyDate($from, $to, $user_id) {
        $month = strtolower(date('M', strtotime($from)));
        $this->db->select('user_id');
        $this->db->select('rfid');
        $this->db->from('profile');
        $this->db->where('user_id', $user_id);
        $q = $this->db->get();
        if ($q->row()->rfid == ''):
            $this->db->select('*');
            $this->db->from('attendance_sheet_' . $month);
            $this->db->join('profile_employee', 'attendance_sheet_' . $month . '.att_st_id = profile_employee.employee_id', 'left');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
            $this->db->where('profile.user_id', $user_id);
            $this->db->where("date between '" . $from . "' and'" . $to . "'");
            $this->db->order_by('date', 'ASC');
            $query = $this->db->get();
        else:
            $this->db->select('*');
            $this->db->select('profile.user_id as uid');
            $this->db->from('attendance_sheet_' . $month);
            $this->db->join('profile', 'attendance_sheet_' . $month . '.u_rfid = profile.rfid', 'left');
            $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
            $this->db->where('attendance_sheet_' . $month . '.u_rfid', $q->row()->rfid);
            $this->db->where("date between '" . $from . "' and'" . $to . "'");
            $this->db->order_by('date', 'ASC');
            $query = $this->db->get();
        endif;

        return $query->result();
    }

    function checkIfPresent($date, $t_id) {
        $this->db->select('*');
        $this->db->from('attendance_sheet');
        $this->db->where('date', $date);
        $this->db->where('u_rfid', $t_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }

    function updateEmployeeInfo($details, $st_id) {
        $this->db->where('user_id', $st_id);
        $this->db->update('profile_employee', $details);
        return;
    }

    function updateAcademicInfo($details, $st_id) {
        $this->db->where('user_id', $st_id);
        $this->db->update('profile_employee_edbak', $details);
        return;
    }

    function savePassSlip($data, $id, $date) {

        $this->db->where('employee_id', $id);
        $this->db->where('date_issue', $date);
        $q = $this->db->get('pass_slip');
        if ($q->num_rows() > 0):
            $this->db->where('employee_id', $id);
            $this->db->where('date_issue', $date);
            $this->db->update('pass_slip', $data);
            $return = $q->row()->pass_slip_id;
        else:
            $this->db->insert('pass_slip', $data);
            $return = $this->db->insert_id();
        endif;
        return $return;
    }

    function getPassSlip($employee_id = NULL) {
        $this->db->select('*');
        $this->db->from('pass_slip');
        if ($this->session->userdata('rfid') == ""):
            $this->db->join('profile_employee', 'pass_slip.employee_id = profile_employee.employee_id', 'left');
            $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        else:
            $this->db->join('profile', 'pass_slip.employee_id = profile.rfid', 'left');
        endif;
        if ($employee_id != NULL):
            $this->db->where('profile_employee.employee_id', $employee_id);
        endif;
        $this->db->order_by('date_issue', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function updateEmStatus($eid, $status) {
        $this->db->where('u_id', $eid);
        $this->db->update('user_accounts', array('isActive' => $status));
    }
    
    function getGSAccess($id){
        $this->db->where('employee_id', $id);
        $q = $this->db->get('profile_employee')->row();
        return $q->gs_access;
    }
    
    function changePass($emp_id, $password){
        $data = array(
            'pword' => md5($password),
            'secret_key' => $password
        );
        $this->db->where('u_id', $emp_id);
        $this->db->update('user_accounts', $data);
        if($this->db->affected_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

}

?>
