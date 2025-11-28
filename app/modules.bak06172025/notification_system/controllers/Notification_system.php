<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification_system
 *
 * @author genesis
 */
class notification_system extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('notification_system_model');
        $this->load->library('pagination');
    }

    function pullNotification($to) {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        
        $hasUpdate = $this->getNotification($to);
        $numUpdates = $hasUpdate->num_rows();
        if($numUpdates > 0):
            $details = json_encode(array(
                        'hasUpdate' => TRUE,
                        'title' => $hasUpdate->row()->noti_from,
                        'msg' => $hasUpdate->row()->noti_msg,
                        'numUpdates' => $numUpdates)
                    );
            $this->readNoti($hasUpdate->row()->id, $to);
        else:
            $details = json_encode(array('hasUpdate' => FALSE));
        endif;
        echo "data: $details \n\n";
        ob_end_flush();
        flush();
        sleep(1);            //Flush the result to the browser
    }

    function systemNotification($type, $msg=NULL, $link = NULL) {
        $details = array(
            'id'        => $this->eskwela->codeCheck('notify', 'id', $this->eskwela->code()),
            'noti_type' => $type,
            'noti_urgency' => 3,
            'noti_from' => 'System',
            'noti_to' => '',
            'noti_msg' => $msg,
            'noti_link' => $link,
            'noti_date' => date('Y-m-d')
        );

        $this->notification_system_model->insert_notification($details, $to, $date, $msg);
    }

    function sendNotification($type, $urgency=3, $from, $to="", $msg=NULL, $date=NULL, $link = NULL) {
        $details = array(
            'id'        => $this->eskwela->codeCheck('notify', 'id', $this->eskwela->code()),
            'noti_type' => $type,
            'noti_urgency' => $urgency,
            'noti_from' => $from,
            'noti_to' => $to,
            'noti_msg' => $msg,
            'noti_link' => $link,
            'noti_date' => $date
        );

        $this->notification_system_model->insert_notification($details, $to, $date, $msg);
    }

    function checkUserAssocHead($employee_id) {
        return $this->notification_system_model->checkUserAssocHead($employee_id);
    }

    function getAssocNotifications($limited = NULL) {
        return $this->notification_system_model->fetchAssocNotification($limited);
    }

    function sendPushNotification($message) {
        Modules::run('api/send_notification', NULL, array('message' => $message));
    }

    function createTable() {
        if ($this->notification_system_model->createTable('esk_push_tokens')):
            echo 'done';
        else:
            echo 'sorry';
        endif;
    }

    function checkToken($user_id) {
        if (!$this->db->table_exists('esk_push_tokens')) {
            $this->notification_system_model->createTable('esk_push_tokens');
        } else {
            if ($this->notification_system_model->checkToken($user_id)):
                return TRUE;
            else:
                return FALSE;
            endif;
        }
    }

    function getToken($user_id = NULL) {
        if ($user_id != NULL):
            if ($this->checkToken($user_id)):
                $token[] = $this->notification_system_model->getToken($user_id);
                return $token;
            else:
                return FALSE;
            endif;
        else:
            $token = $this->notification_system_model->getToken();
            return $token;
        endif;
    }

    function registerPushToken($details, $user_id) {
        if ($this->notification_system_model->saveToken($user_id, $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function readNoti($noti_id, $user_id) {
        $this->notification_system_model->readNoti($noti_id, $user_id);
        return;
    }

    function getAdminNotification($user_id, $limit = NULL) {
        $notify = $this->notification_system_model->checkAdminNotification($user_id, $limit);
        return $notify;
    }

    function getNotification($to, $read = NULL) {
        $notify = $this->notification_system_model->getNotification($to, $read);
        //print_r($notify->result());
        return $notify;
    }

    function getDepartmentNotification($head_id, $dept_id) {
        $assoc = Modules::run('hr/getDepartmentAssociates', $dept_id);
    }

    function index() {
        if ($this->session->userdata('is_admin')):
            $data['adminNotification'] = $this->getAdminNotification($this->session->userdata('employee_id'));
        else:
            $data['adminNotification'] = NULL;
        endif;
        $data['notification'] = $this->getNotification($this->session->userdata('employee_id'));
        //$data['assocHead'] = $this->notification_system_model->checkUserAssocHead($this->session->employee_id);
        $data['main_content'] = 'default';
        $data['modules'] = 'notification_system';
        echo Modules::run('templates/main_content', $data);
    }

    function attendance_notification($time = NULL, $parent_id = NULL, $student = Null, $status = NULL) {
        $msg = 'Your Student ' . $student . ' is already ' . $status . ' at ' . $time;

        $notify_array = array(
            'id'        => $this->eskwela->codeCheck('notify', 'id', $this->eskwela->code()),
            'noti_type' => 4,
            'noti_urgency' => 3,
            'noti_from' => 'system',
            'noti_to' => $parent_id,
            'noti_msg' => $msg,
            'noti_date' => date('Y-m-d')
        );

        $id = $this->notification_system_model->attendance_notification($notify_array);

//        Modules::run('web_sync/updateSyncController', 'notify', 'id', $id, 'create', 4);
    }

    function check_attendance_notification($parent_id) {
        $data['notification'] = $this->notification_system_model->check_attendance_notification($parent_id);
        $this->load->view('attendance_notification', $data);
    }

    function check_dh_notification($department, $employee_id) {
        $dhHead = Modules::run('hr/ifDepartmentHead', $employee_id, $department);
        if ($dhHead):
            $data['notification'] = $this->notification_system_model->check_attendance_notification($department);
            $this->load->view('attendance_notification', $data);
        endif;
    }

    function dtr_notification($time = NULL, $employee = Null, $status = NULL, $dept_id = NULL) {
        $msg = $employee . ' is already ' . $status . ' at ' . $time . 'and is late';

        $notify_array = array(
            'id'        => $this->eskwela->codeCheck('notify', 'id', $this->eskwela->code()),
            'noti_type' => 4,
            'noti_urgency' => 3,
            'noti_from' => 'system',
            'noti_to' => $dept_id,
            'noti_msg' => $msg,
            'noti_date' => date('Y-m-d')
        );

        $this->notification_system_model->attendance_notification($notify_array);
    }

    function department_notification($dept_id = NULL, $msg = NULL, $link = NULL, $noti_type = 3) {
        //$msg = $employee.' is already '.$status.' at '.$time.'and is late';

        $notify_array = array(
            'id'        => $this->eskwela->codeCheck('notify', 'id', $this->eskwela->code()),
            'noti_type' => $noti_type,
            'noti_urgency' => 3,
            'noti_from' => 'system',
            'noti_to' => $dept_id,
            'noti_msg' => $msg,
            'noti_link' => $link,
            'noti_date' => date('Y-m-d')
        );

        $this->notification_system_model->insert_notification($notify_array, null, null, null);
    }

}
