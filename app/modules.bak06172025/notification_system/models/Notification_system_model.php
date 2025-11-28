<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification_system_model
 *
 * @author genesis
 */
class notification_system_model extends CI_Model {

    //put your code here

    function ifSubscriber($type, $id) {
        $q = $this->db->where('sub_type', $type)
                ->where('subscriber', $id)
                ->get('notify_subscriber');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getToken($user_id) {
        if ($user_id != NULL):
            $this->db->where('push_user_id', $user_id);
            $q = $this->db->get('push_tokens');
            return $q->row()->token;
        else:
            $q = $this->db->get('push_tokens');
            foreach ($q->result() as $t):
                $token[] = $t->token;
            endforeach;
            return $token;
        endif;
    }

    function checkToken($user_id) {
        $this->db->where('push_user_id', $user_id);
        $q = $this->db->get('push_tokens');
        if ($q->num_rows() > 0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function saveToken($user_id, $details) {
        $this->db->where('push_user_id', $user_id);
        $q = $this->db->get('push_tokens');
        if ($q->num_rows() == 0):
            $this->db->insert('push_tokens', $details);
        else:
            $this->db->where('push_user_id', $user_id);
            $this->db->update('push_tokens', $details);
        endif;
        return TRUE;
    }

    function createTable($table) {
        $query = "CREATE TABLE $table ( `push_id` INT NOT NULL AUTO_INCREMENT , `token` VARCHAR(300) NOT NULL , `push_user_id` INT NOT NULL , PRIMARY KEY (`push_id`)) ENGINE = InnoDB;";
        if ($this->db->query($query)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getNotification($to) {
        $this->db->where('noti_to', $to);
        $this->db->not_like('noti_read', $to);
        $this->db->order_by('noti_timestamp', 'ASC');
        $query = $this->db->get('notify');

        if ($query->num_rows() > 0):
            return $query;
        else:
            $this->db->join('notify_subscriber', 'notify.noti_type = notify_subscriber.sub_type', 'left');
            $this->db->where('subscriber', $to);
            $this->db->not_like('noti_read', $to);
            $this->db->order_by('noti_timestamp', 'ASC');
            $query2 = $this->db->get('notify');
            return $query2;
        endif;
    }

    function insert_notification($details, $to, $date, $msg) {
        $this->db->where('noti_to', $to);
        $this->db->where('noti_msg', $msg);
        $this->db->where('noti_date', $date);
        $query = $this->db->get('notify');
        if ($query->num_rows() == 0):
            $this->db->insert('notify', $details);
        endif;
        return $this->db->insert_id();
    }

    function attendance_notification($details) {
        $this->db->insert('notify', $details);
        return $this->db->insert_id();
    }

    function check_attendance_notification($parent_id) {
        $this->db->select('*');
        $this->db->from('notify');
        $this->db->where('noti_to', $parent_id);
        $this->db->order_by('noti_timestamp', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function check_notification($department) {
        $this->db->select('*');
        $this->db->from('notify');
        $this->db->where('noti_to', $department);
        $this->db->order_by('noti_timestamp', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function checkAdminNotification($user_id, $limit) {
        $this->db->where('noti_to', 'Admin');
        $this->db->not_like('noti_read', $user_id);
        $this->db->join('profile_employee', 'notify.noti_from = profile_employee.employee_id', 'left');
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->order_by('noti_timestamp', 'DESC');
        if ($limit != NULL):
            $this->db->limit($limit);
        endif;
        $query = $this->db->get('notify');
        if ($query->num_rows() > 0):
            return $query;
        else:
            return FALSE;
        endif;
    }

    function readNoti($noti_id, $user_id) {
        $this->db->where('id', $noti_id);
        $q = $this->db->get('notify');
        if ($q->row()->noti_read != ""):
            $array = array(
                'noti_read' => $q->row()->noti_read . ',' . $user_id
            );
            $this->db->where('id', $noti_id);
            $this->db->update('notify', $array);
        else:
            $array = array(
                'noti_read' => $user_id
            );
            $this->db->where('id', $noti_id);
            $this->db->update('notify', $array);
        endif;
    }

}

?>
