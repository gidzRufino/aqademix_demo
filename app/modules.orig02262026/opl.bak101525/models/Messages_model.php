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
class Messages_model extends MX_Controller {

    //put your code here

    function getStudentsBySection($grade_id, $section_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('grade_level_id', $grade_id);
        $this->db->where('section_id', $section_id);
        return $this->db->get('profile_students_admission')->result();
    }

    function student_inbox($stid, $limit = NULL, $offset = NULL, $subject_id = NULL, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        $this->db->join('opl_messaging', 'opl_messaging.opl_msg_id = opl_messaging_recipient.messaging_id', 'left');
        $this->db->join('profile_employee', 'profile_employee.employee_id = opl_messaging.sender', 'left');
        $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->where('opl_messaging.subject_id', $subject_id);
        $this->db->where('recipient_id', $stid);
        if ($limit != NULL || $offset = NULL) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('date_sent', 'DESC');
        return $this->db->get('opl_messaging_recipient');
    }

    function employee_inbox($stid, $limit = NULL, $offset = NULL, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        $this->db->join('opl_messaging', 'opl_messaging.opl_msg_id = opl_messaging_recipient.messaging_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students_admission.st_id = opl_messaging.sender', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('opl_messaging.sender !=', $stid);
        $this->db->where('recipient_id', $stid);
        if ($limit != NULL || $offset = NULL) {
            $this->db->limit($limit, $offset);
        }
//        $this->db->group_by('replied_msg_id');
        $this->db->order_by('date_sent', 'DESC');
        return $this->db->get('opl_messaging_recipient');
    }

    function readMsge($id, $isReply, $msg_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        if ($isReply == 1):
            $this->db->where('msg_recpt_id', $id);
            $this->db->update('opl_messaging_recipient', array('is_read' => 1));

            $this->db->join('profile_employee', 'profile_employee.employee_id = opl_messaging.sender', 'left');
            $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
            $this->db->where('opl_msg_id', $msg_id);
            return $this->db->get('opl_messaging')->row();
        else:
            $this->db->where('msg_recpt_id', $id);
            $this->db->update('opl_messaging_recipient', array('is_read' => 1));

            $this->db->join('opl_messaging', 'opl_messaging.opl_msg_id = opl_messaging_recipient.messaging_id', 'left');
            $this->db->join('profile_employee', 'profile_employee.employee_id = opl_messaging.sender', 'left');
            $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
            $this->db->where('msg_recpt_id', $id);
            return $this->db->get('opl_messaging_recipient')->row();
        endif;
    }

    function sendMsg($subjMsg, $content, $recipient, $sender, $subj_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        $opl_msg_id = $this->eskwela->code();
        $data = array(
            'opl_msg_id' => $opl_msg_id,
            'sender' => $sender,
            'content' => $content,
            'subject_msg' => $subjMsg,
            'subject_id' => $subj_id
        );

        $this->db->insert('opl_messaging', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        $r = explode(",", $recipient);

        foreach ($r as $s):
            $recpt_id = $this->eskwela->code();
            $data = array(
                'msg_recpt_id' => $recpt_id,
                'recipient_id' => base64_decode($s),
                'messaging_id' => $opl_msg_id,
                'replied_msg_id' => $recpt_id
            );

            $this->db->insert('opl_messaging_recipient', $data);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        endforeach;

        return TRUE;
    }

    function getMsgReply($msg_id) {
        $this->db->join('opl_messaging', 'opl_messaging.opl_msg_id = opl_messaging_recipient.messaging_id', 'left');
        $this->db->where('replied_msg_id', $msg_id);
        $this->db->group_by('messaging_id');
        $this->db->order_by('date_sent', 'ASC');
        return $this->db->get('opl_messaging_recipient')->result();
    }

    function replyMsg($sender, $recipient, $msg_id, $content, $subjMsg, $subj_id, $school_year = NULL) {
        $this->db = $this->eskwela->db($school_year == NULL ? $this->session->school_year : $school_year);
        $opl_msg_id = $this->eskwela->code();

        $data = array(
            'opl_msg_id' => $opl_msg_id,
            'sender' => $sender,
            'content' => $content,
            'subject_msg' => $subjMsg,
            'subject_id' => $subj_id,
            'is_reply' => 1
        );

        $this->db->insert('opl_messaging', $data);
        $runScript = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript, $school_year);

        $r = explode(',', $recipient);
        if (count($r > 1)):
            foreach ($r as $s):
                if ($sender != base64_decode($s)):
                    $recpt_id = $this->eskwela->code();
                    $data = array(
                        'msg_recpt_id' => $recpt_id,
                        'recipient_id' => base64_decode($s),
                        'messaging_id' => $opl_msg_id,
                        'replied_msg_id' => $msg_id
                    );

                    $this->db->insert('opl_messaging_recipient', $data);
                    $runScript = $this->db->last_query();
//                    Modules::run('web_sync/saveRunScript', $runScript, $school_year);
                endif;
            endforeach;
        else:
            $data = array(
                'msg_recpt_id' => $this->eskwela->code(),
                'recipient_id' => base64_decode($s),
                'messaging_id' => $opl_msg_id,
                'replied_msg_id' => $msg_id
            );

            $this->db->insert('opl_messaging_recipient', $data);
            $runScript = $this->db->last_query();
//            Modules::run('web_sync/saveRunScript', $runScript, $school_year);
        endif;


//        $data2 = array(
//            'msg_recpt_id' => $this->eskwela->code(),
//            'recipient_id' => $recipient,
//            'replied_msg_id' => $msg_id,
//            'messaging_id' => $opl_msg_id
//        );
//
//        $this->db->insert('opl_messaging_recipient', $data2);
//        $runScript2 = $this->db->last_query();
//        Modules::run('web_sync/saveRunScript', $runScript2, $school_year);

        return TRUE;
    }

    function getSender($id) {
        $this->db->select('*');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('st_id', $id);
        $q = $this->db->get('profile_students_admission');
        if ($q->num_rows() > 0):
            return $q->row();
        else:
            $this->db->select('*');
            $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
            $this->db->where('employee_id', $id);
            $p = $this->db->get('profile_employee');

            if ($p->num_rows() > 0):
                return $p->row();
            else:
                return FALSE;
            endif;
        endif;
    }

    function getRecipients($msg_id) {
        $this->db->join('profile_students_admission', 'profile_students_admission.st_id = opl_messaging_recipient.recipient_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('messaging_id', $msg_id);
        return $this->db->get('opl_messaging_recipient')->result();
    }

    function getUnreadMsg($recpt_id, $subj_id) {
        $this->db->join('opl_messaging', 'opl_messaging.opl_msg_id = opl_messaging_recipient.messaging_id', 'left');
        $this->db->where('opl_messaging_recipient.recipient_id', $recpt_id);
        $this->db->where('opl_messaging.subject_id', $subj_id);
        $this->db->where('is_read', 0);
        return $this->db->get('opl_messaging_recipient')->num_rows();
    }

}
