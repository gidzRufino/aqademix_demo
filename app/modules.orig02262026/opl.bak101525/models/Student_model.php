<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_models
 *
 * @author genesisrufino
 */
class Student_model extends MX_Controller
{
    //put your code here


    function getTask($grade_level, $section, $subject, $school_year, $isStudent = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('task_grade_id', $grade_level);
        $this->db->where('task_section_id', $section);
        $this->db->where('task_subject_id', $subject);
        if ($isStudent != NULL) $this->db->where('task_start_time <= NOW()');
        if ($isStudent != NULL) $this->db->where('task_end_time > NOW()');
        $this->db->join('profile_employee', 'opl_tasks.task_author_id = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('opl_task_type', 'opl_tasks.task_type = opl_task_type.tt_id', 'left');
        $this->db->order_by('task_start_time', 'DESC');
        $this->db->limit(20);
        $q = $this->db->get('opl_tasks');
        return $q->result();
    }

    function getLessons($subject_id, $grade_level, $section_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('dis_grade_id', $grade_level);
        $this->db->where('dis_subject_id', $subject_id);
        ($section_id != NULL ? $this->db->where('dis_section_id', $section_id) : '');
        $this->db->where('dis_start_date <=', date('Y-m-d G:i:s'));
        return $this->db->get('opl_discussion')->result();
    }

    function submitRawScore($rawScoreDetails, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->insert('gs_raw_score', $rawScoreDetails);
        $runScript = $this->db->last_query();
        //        Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        return;
    }

    function saveResponse($details, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if ($this->db->insert('opl_task_submitted', $details)):
            $runScript = $this->db->last_query();
            //            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function createResponse($details, $school_year, $task_code = NULL, $st_id = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('ts_task_id', $task_code);
        $this->db->where('ts_submitted_by', $st_id);
        $q = $this->db->get('opl_task_submitted');
        if ($q->num_rows() == 0):
            if ($this->db->insert('opl_task_submitted', $details)):
                $runScript = $this->db->last_query();
                //                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('ts_code', $q->row()->ts_code);
            if ($this->db->update('opl_task_submitted', $details)):
                $runScript = $this->db->last_query();
                //                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }

    function getSubjectList($grade_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('grade_level_id', $grade_id);
        $this->db->join('subjects', 'subjects_settings.sub_id = subjects.subject_id', 'left');
        return $this->db->get('subjects_settings')->result();
    }

    function getSingleStudent($id, $year, $semester)
    {
        $this->db = $this->eskwela->db($year == NULL ? $this->session->school_year : $year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
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
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parent', 'profile.user_id = profile_parent.u_id', 'left');
        $this->db->join('profile_medical', 'profile.user_id = profile_medical.user_id', 'left');
        $this->db->join('ua_students', 'ua_students.u_id = profile_students.st_id', 'left');
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

    function checkUserAcc($stid, $sy = NULL)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('u_id', $stid);
        $q = $this->db->get('ua_students');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function changePass($st_id, $password)
    {
        $sy = $this->session->school_year;
        $check = $this->checkUserAcc($st_id, $sy);

        $this->db = $this->eskwela->db($sy);
        if ($check):
            $data = array(
                'pword' => md5($password),
                'secret_key' => $password,
                'autoGen' => 0
            );
            $this->db->where('u_id', $st_id);
            $this->db->update('ua_students', $data);
        else:
            $data = array(
                'u_id' => $st_id,
                'uname' => $st_id,
                'pword' => md5($password),
                'utype' => 5,
                'secret_key' => $password
            );
            $this->db->insert('ua_students', $data);
        endif;

        if ($this->db->affected_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function logout($uname)
    {
        $item = array(
            'islogin' => 0,
        );
        $this->db->where('uname', $uname);
        $this->db->update('ua_students', $item);
    }
}
