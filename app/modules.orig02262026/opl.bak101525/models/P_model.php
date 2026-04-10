<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

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
class P_model extends MX_Controller
{
    //put your code here

    function getDiscussionBoard($school_year, $grade_level, $section, $subject)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('dis_grade_id', $grade_level);
        $this->db->where('dis_subject_id', $subject);
        $q = $this->db->get('opl_discussion')->result();
        return $q;
    }

    function savePaymentReceipt($st_id, $link, $filename, $paymentCenter, $paymentRemarks, $school_year, $semester, $is_or, $isEnrollment)
    {
        $this->db = $this->eskwela->db($school_year);
        $details = array(
            'opr_st_id'     => $st_id,
            'opr_img_link'  => $link,
            'opr_paycenter' => $paymentCenter,
            'opr_date'      => date('Y-m-d'),
            'opr_sem'       => $semester,
            'opr_remarks'   => $paymentRemarks,
            'opr_file_name' => $filename,
            'is_or'         => $is_or,
            'is_enrollment' => $isEnrollment
        );

        if ($this->db->insert('c_finance_online_receipts', $details)):
            $runScript = $this->db->last_query();
            //                Modules::run('web_sync/saveRunScript', $runScript, $school_year);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    // function savePaymentReceipt($st_id,$link, $filename, $paymentCenter, $paymentRemarks, $school_year, $semester)
    // {
    //     $this->db = $this->eskwela->db($school_year);
    //     $details = array(
    //         'opr_st_id'     => $st_id,
    //         'opr_img_link'  => $link,
    //         'opr_paycenter' => $paymentCenter,
    //         'opr_date'      => date('Y-m-d'),
    //         'opr_sem'       => $semester,
    //         'opr_remarks'   => $paymentRemarks,
    //         'opr_file_name' => $filename

    //     );

    //     if($this->db->insert('c_finance_online_receipts', $details)):
    //             $runScript = $this->db->last_query();
    //             Modules::run('web_sync/saveRunScript', $runScript, $school_year);
    //         return TRUE;
    //     else:
    //         return FALSE;
    //     endif;
    // }

    function getStudentDetailsBasicEd($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('profile_students_admission.status as status');
        $this->db->where('st_id', $st_id);
        $this->db->where('semester', $sem);
        $this->db->where('school_year', $school_year);
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('profile_parent', 'profile_students_admission.user_id = profile_parent.u_id', 'left');
        return $this->db->get('profile_students_admission')->row();
    }

    function getPadalaCenters($school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        return $this->db->get('padala_centers')
            ->result();
    }

    function getBasicStudent($st_id, $school_year, $semester)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->join('profile_students', 'profile_students.user_id = profile_students_admission.user_id', 'left');
        $this->db->join('profile', 'profile_students_admission.user_id = profile.user_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->where('profile_students_admission.st_id', $st_id);
        // $this->db->where('profile_students_admission.semester', $semester);
        $this->db->group_by('profile_students_admission.user_id');

        $query = $this->db->get('profile_students_admission');
        return $query->row();
    }

    function requestEntry($uname)
    {
        $this->db->where('uname', $uname);
        $q = $this->db->get('user_accounts');

        if ($q->num_rows() > 0):
            return $q->row();
        else:
            return false;
        endif;
    }

    function getInside($uname, $pass)
    {
        $this->db->where('uname', $uname);
        $this->db->where('secret_key', $pass);
        $query = $this->db->get('user_accounts');
        $item = array(
            'islogin' => 1,
        );
        $this->db->where('uname', $uname);
        $this->db->update('user_accounts', $item);

        if ($query->num_rows() > 0) {
            return $query->row();
        }
    }

    function parentDetails($parent_id)
    {
        $this->db->join('profile_parent', 'user_accounts.parent_id = profile_parent.p_id', 'left');
        $this->db->where('user_accounts.u_id', $parent_id);
        $q = $this->db->get('user_accounts');

        if ($q->num_rows() > 0):
            return $q->row();
        else:
            return false;
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
                    return json_encode(array('status' => true, 'msg' => 'You have successfully registered as Parent', 'codeError' => 0));
                endif;
            else:
                return json_encode(array('status' => false, 'msg' => 'You are already registered', 'codeError' => 2));
            endif;
        else:
            return json_encode(array('status' => false, 'msg' => 'This username is already Taken', 'codeError' => 1));
        endif;
    }

    function getVerified($data, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->select('ice_contact');
        $this->db->select('st_id');
        $this->db->select('p_id');
        $this->db->join('profile_students', 'profile_parent.u_id = profile_students.user_id', 'left');
        $this->db->where('ice_contact', $data);
        $q = $this->db->get('profile_parent');

        if ($q->num_rows() > 0):
            echo json_encode(array('status' => TRUE, 'details' => $q->result()));
        else:
            echo json_encode(array('status' => false, 'details' => null));
        endif;
    }

    function checkUserAcc($pid)
    {
        $this->db->where('u_id', $pid);
        $q = $this->db->get('user_accounts');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function changePass($pid, $password)
    {
        $check = $this->checkUserAcc($pid);

        if ($check):
            $data = array(
                'pword' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 8]),
                'secret_key' => $password,
                'is_agp' => 0
            );
            $this->db->where('u_id', $pid);
            $this->db->update('user_accounts', $data);
            $r = 1;
        else:
            $data = array(
                'u_id' => $pid,
                'uname' => $pid,
                'pword' => password_hash($password, PASSWORD_DEFAULT, ['cost' => 8]),
                'utype' => 4,
                'secret_key' => $password,
                'is_agp' => 0
            );
            $this->db->insert('user_accounts', $data);
            $r = 2;
        endif;

        if ($this->db->affected_rows() > 0):
            if ($r == 1):
                $msg = 'updated the password of a parent with account id: ' . $pid;
                $title = 'Password Update';
            else:
                $msg = 'added a password of a parent with account id: ' . $pid;
                $title = 'Setting Password';
            endif;
            $this->logParentActivity($msg, $title);
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function logParentActivity($msg, $title)
    {
        $uid = $this->session->user_id;
        Modules::run('main/logActivity', $title, $msg, $uid);
    }
}
