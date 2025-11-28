<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class main_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function updateSchoolDates($id, $data)
    {
        $this->db->where('school_id', $id)
            ->update('settings', $data);
        if ($this->db->affected_rows() != 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function updateEnrollmentDate($id, $data)
    {
        $this->db->where('school_id', $id)
            ->update('settings', $data);
        if ($this->db->affected_rows() != 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    // ================================ //

    function fetch_opl_tasks()
    {
        $this->db->select('*');
        $this->db->from('opl_tasks');
        $this->db->order_by('task_auto_id', 'ASC');
        // $this->db->limit(500,0); // change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_tasks($id, $file)
    {
        $data = array(
            'task_path' => $file,
        );
        $this->db->where('task_code', $id);
        $this->db->update('opl_tasks', $data);
        return;
    }


    function fetch_opl_task_submitted()
    {
        $this->db->select('*');
        $this->db->from('opl_task_submitted');
        $this->db->order_by('ts_id', 'ASC');
        $this->db->limit(700, 2000); // manually change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_task_submitted($id, $file)
    {
        $data = array(
            'ts_path' => $file,
        );
        $this->db->where('ts_id', $id);
        $this->db->update('opl_task_submitted', $data);
        return;
    }

    function fetch_opl_discussion()
    {
        $this->db->select('*');
        $this->db->from('opl_discussion');
        $this->db->order_by('dis_id', 'ASC');
        // $this->db->limit(500,0); // manually change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_discussion($id, $file)
    {
        $data = array(
            'dis_path' => $file,
        );
        $this->db->where('dis_id', $id);
        $this->db->update('opl_discussion', $data);
        return;
    }

    function fetch_opl_comments()
    {
        $this->db->select('*');
        $this->db->from('opl_comments');
        $this->db->order_by('com_id', 'ASC');
        // $this->db->limit(500,0); // manually change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_comments($id, $file)
    {
        $data = array(
            'com_path' => $file,
        );
        $this->db->where('com_id', $id);
        $this->db->update('opl_comments', $data);
        return;
    }

    function fetch_opl_posts()
    {
        $this->db->select('*');
        $this->db->from('opl_posts');
        $this->db->order_by('op_id', 'ASC');
        $this->db->limit(500, 0); // manually change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_posts($id, $file)
    {
        $data = array(
            'op_path' => $file,
        );
        $this->db->where('op_id', $id);
        $this->db->update('opl_posts', $data);
        return;
    }

    function fetch_opl_qm_qq()
    {
        $this->db->select('*');
        $this->db->from('opl_qm_qq');
        $this->db->order_by('qq_id', 'ASC');
        // $this->db->limit(500,0); // manually change this from time to time
        $q = $this->db->get();
        return $q;
    }

    function update_opl_qm_qq($id, $file)
    {
        $data = array(
            'qq_path' => $file,
        );
        $this->db->where('qq_id', $id);
        $this->db->update('opl_qm_qq', $data);
        return;
    }

    // ================================ //

    function editTimeSettings($inAM, $outAM, $inPM, $outPM, $id, $option)
    {
        if ($option == 'a'):
            $details = array(
                'ps_from' => $inAM,
                'ps_to' => $outAM,
                'ps_from_pm' => $inPM,
                'ps_to_pm' => $outPM
            );
            $this->db->where('ps_id', $id);

            return $this->db->update('payroll_shift', $details);
        else:
            $details = array(
                'time_in' => $inAM,
                'time_out' => $outAM,
                'time_in_pm' => $inPM,
                'time_out_pm' => $outPM
            );
            $this->db->where('section_id', $id);

            return $this->db->update('section', $details);
        endif;
    }

    function getTimeSettingsPerSection()
    {
        return $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left')
            ->get('section')->result();
    }

    function refreshIdGeneration()
    {
        $q = $this->db->get('profile_temp_id');
        return $q;
    }

    function saveSystemUpdate($details)
    {
        $this->db->insert('system_settings', $details);
        return TRUE;
    }

    function system_version()
    {
        $this->db->order_by('sys_id', 'DESC');
        $this->db->limit(1);
        $q = $this->db->get('system_settings');
        return $q->row()->system_version;
    }
    function logActivity($title, $msg, $user_id)
    {
        $details = array('log_id' => $this->eskwela->codeCheck('system_logs', 'log_id', $this->eskwela->code()), 'log_title' => $title, 'account_id' => $user_id, 'remarks' => $msg, 'log_date' => date('Y-m-d'));
        $this->db->insert('system_logs', $details);
        return;
    }

    function editProfile($pk, $pk_id, $details)
    {
        $this->db->where($pk, $pk_id);
        $q = $this->db->get('profile_students');
        if ($q->num_rows() > 0):
            $this->db->where('user_id', $q->row()->user_id);
            $this->db->update('profile', $details);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function removeSubject($sub_id)
    {
        $this->db->where('id', $sub_id);
        if ($this->db->delete('subjects_settings')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }


    function writeLog($details)
    {
        $this->db->insert('system_logs', $details);
        return;
    }

    public function getSet($year = NULL)
    {
        $query = $this->db->get('settings');
        return $query->row();
    }

    function getMotherTongue()
    {
        $query = $this->db->get('mother_tongue');
        return $query->result();
    }

    function getEthnicGroup()
    {
        $query = $this->db->get('ethnic_group');
        return $query->result();
    }

    function getMenu($userId)
    {
        $this->db->select('menu_access');
        $this->db->from('profile_info');
        $this->db->where('u_id', $userId);
        $query = $this->db->get();
        return $query->row();
    }

    function getReligion()
    {
        $this->db->select('*');
        $this->db->from('religion');
        $this->db->order_by('religion', 'ASC');
        $this->db->group_by('religion');
        $query = $this->db->get();
        return $query->result();
    }

    function getCities($city)
    {
        $this->db->select('*');
        $this->db->select('cities.id as cid');
        $this->db->from('cities');
        $this->db->join('provinces', 'cities.province_id = provinces.id', 'left');
        if ($city != NULL):
            $this->db->where('mun_city', $city);
            $query = $this->db->get();
            return $query->row();
        else:
            $query = $this->db->get();
            return $query->result();
        endif;
    }

    function getProvince($id)
    {
        $this->db->select('*');
        $this->db->select('cities.id as cid');
        $this->db->select('provinces.id as pid');
        $this->db->from('cities');
        $this->db->join('provinces', 'cities.province_id = provinces.id', 'left');
        $this->db->where('cities.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getProvinces()
    {
        $query = $this->db->get('provinces');
        return $query->result();
    }

    function editInLineInfo($column, $value, $school_year)
    {
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0):
            $details = array(
                $column => $value
            );
            $this->db->where('school_year', $school_year);

            if ($this->db->update('settings', $details)):
                return TRUE;
            endif;
        else:
            $details = array(
                'set_logo'              => $q->row()->short_name . '.jpg',
                'school_id'             => $q->row()->school_id,
                'set_school_name'       => $q->row()->set_school_name,
                'set_school_address'    => $q->row()->set_school_address,
                'region'                => $q->row()->region,
                'district'              => $q->row()->district,
                'division'              => $q->row()->division,
                'division_address'      => $q->row()->division_address,
                'school_year'           => $school_year,
                'web_address'           => $q->row()->web_address,
                'att_check'             => $q->row()->att_check,
                'bosy'                  => $q->row()->bosy,
                'eosy'                  => $q->row()->eosy,
                'short_name'            => $q->row()->short_name,
                'time_in'               => $q->row()->time_in,
                'time_out'              => $q->row()->time_out,
                'level_catered'         => $q->row()->level_catered,
            );
            if ($this->db->insert('settings', $details)):
                return TRUE;
            endif;
        endif;
    }

    function singleColumnEdit($table, $column, $value, $pk, $pk_value)
    {
        $sql = "UPDATE $table 
                SET $column = ?
                WHERE $pk = ?";
        if ($this->db->query($sql, array($value, $pk_value))):
            return TRUE;
        endif;
    }

    function getRemarksCategory()
    {
        $query = $this->db->get('remarks_category');
        return $query->result();
    }

    function getCodeIndicators()
    {
        $query = $this->db->get('deped_code_indicator');
        return $query->result();
    }

    function saveAdmissionRemarks($data)
    {
        $this->db->insert('admission_remarks', $data);
        return $this->db->insert_id();
    }

    function getAdmissionRemarks($st_id, $month)
    {
        if ($month != ""):
            $num_of_days = date("t", mktime(0, 0, 0, $month, 1, date('Y')));
            $from = $month . '/' . '01' . '/' . date('Y');
            $to = $month . '/' . $num_of_days . '/' . date('Y');
        endif;
        $this->db->select('*');
        $this->db->from('admission_remarks');
        $this->db->join('deped_code_indicator', 'admission_remarks.code_indicator_id = deped_code_indicator.id', 'left');
        $this->db->where('remark_to', $st_id);
        if ($month != ""):
            $this->db->where("remark_date between '" . $from . "' and'" . $to . "'");
        endif;

        $query = $this->db->get();
        return $query;
    }

    function deleteAdmissionRemark($st_id)
    {
        $this->db->where('remark_to', $st_id);
        $this->db->delete('admission_remarks');
    }


    function updateAdmissionRemarks($details, $st_id)
    {
        $this->db->where('remark_to', $st_id);
        $this->db->update('admission_remarks', $details);
    }

    function checkAccess($position_id)
    {
        $this->db->where('position_id', $position_id);
        $q = $this->db->get('user_groups');
        if ($q->num_rows() > 0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }

    function saveAccess($position_id, $details)
    {
        $this->db->where('position_id', $position_id);
        $q = $this->db->get('user_groups');
        if ($q->num_rows() > 0):
            $this->db->where('position_id', $position_id);
            $this->db->update('user_groups', $details);
        else:
            $this->db->insert('user_groups', $details);
        endif;

        return TRUE;
    }

    function getQuarterSettings()
    {
        $query = $this->db->get('settings_quarter');
        return $query->result();
    }

    function getTerm($date)
    {
        $this->db->select('*');
        $this->db->from('settings_quarter');
        $this->db->where("from_date >", $date);
        $this->db->where("to_date <", $date);
        $query = $this->db->get();
        return $query->row();
    }

    function checkSubjectPerLevel($grade_level, $sub_id)
    {
        $this->db->where('sub_id', $sub_id);
        $this->db->where('grade_level_id', $grade_level);
        $query = $this->db->get('subjects_settings');
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function checkSubjectSettings($grade_level)
    {
        $this->db->where('grade_level_id', $grade_level);
        $query = $this->db->get('subject_settings');
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function searchSubjectIfExist($grade_level, $subject_id)
    {
        $this->db->select('*');
        $this->db->from('subject_settings');
        $this->db->where('grade_level_id', $grade_level);
        $this->db->like('subject_id', $subject_id, 'both');
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getSubjectsFromSettings($grade_level)
    {
        $this->db->select('*');
        $this->db->from('subject_settings');
        $this->db->where('grade_level_id', $grade_level);
        $query = $this->db->get();
        return $query->row();
    }

    function saveSubjectPerLevel($details)
    {
        $this->db->insert('subjects_settings', $details);
        return;
    }

    function saveSubjectSettings($details)
    {
        $this->db->insert('subject_settings', $details);
        return;
    }

    function updateSubjectSettings($details, $grade_level)
    {
        $this->db->where('grade_level_id', $grade_level);
        $this->db->update('subject_settings', $details);

        return;
    }

    function deleteSubjectSettings($grade_level)
    {
        $this->db->where('grade_level_id', $grade_level);
        $this->db->delete('subject_settings');

        return;
    }


    function setImage($id, $image)
    {

        $data = array(
            'avatar' => $image
        );

        $this->db->where('user_id', $id);
        $this->db->update('profile', $data);
    }

    function searchEmployees($value)
    {
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

    function addSubNotif($nSelect, $emp_id, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->school_year);
        $this->db->where('sub_type', $nSelect);
        $this->db->where('subscriber', $emp_id);
        $q = $this->db->get('notify_subscriber');

        if ($q->num_rows() > 0):
            return FALSE;
        else:
            $data = array(
                'sub_type' => $nSelect,
                'subscriber' => $emp_id
            );
            $this->db->insert('notify_subscriber', $data);
            if ($this->db->affected_rows() > 0):
                return TRUE;
            endif;
        endif;
    }

    function getTypeList($school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->userdata('school_year'));
        return $this->db->get('notify_type')->result();
    }

    function getSubListByType($id, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year != NULL ? $school_year : $this->session->userdata('school_year'));
        $this->db->join('profile_employee', 'profile_employee.employee_id = notify_subscriber.subscriber', 'left');
        $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->where('sub_type', $id);
        $this->db->where('notify_subscriber.subscriber != 0310062');
        return $this->db->get('notify_subscriber')->result();
    }

    function delSubByID($emp_id, $notif_id, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('sub_type', $notif_id);
        $this->db->where('subscriber', $emp_id);
        $this->db->delete('notify_subscriber');
        $runScript = $this->db->last_query();
        //        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
    }

    //--------------------------- Enreollment Requirements functions ---------------------------------------------------------------------- ///

    function addEnrollmentReq($req)
    {
        $this->db->insert('enrollment_requirments_list', array('eReq_desc' => $req));
    }

    function getAllEnrollmentReq()
    {
        return $this->db->get('enrollment_requirments_list')->result();
    }

    function editDelReqList($id, $opt, $value = NULL)
    {
        $this->db->where('eReq_list_id', $id);
        if ($opt == 1):
            $this->db->update('enrollment_requirments_list', array('eReq_desc' => $value));
        elseif ($opt == 2):
            $this->db->delete('enrollment_requirments_list');
        endif;
    }

    function checkForDuplicate($id, $dept)
    {
        $this->db->where('eReq_id', $id);
        $this->db->where('dept_id', $dept);
        return $this->db->get('enrollment_req_per_dept');
    }

    function insertListPerDept($id, $dept)
    {
        $this->db->insert('enrollment_req_per_dept', array('college_req_id' => $this->eskwela->code(), 'eReq_id' => $id, 'dept_id' => $dept));
    }

    function checkPerDeptList($dept)
    {
        $this->db->join('enrollment_requirments_list', 'enrollment_requirments_list.eReq_list_id = enrollment_req_per_dept.eReq_id', 'left');
        $this->db->where('dept_id', $dept);
        return $this->db->get('enrollment_req_per_dept')->result();
    }

    function deleteItem($id, $dept)
    {
        $this->db->where('dept_id', $dept);
        $this->db->where('eReq_id', $id);
        $this->db->delete('enrollment_req_per_dept');
    }

    //---------------------------------- End of Enrollment requirements functions ------------------------------------//
}
