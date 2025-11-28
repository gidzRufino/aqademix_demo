<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification_widgets
 *
 * @author genesis
 */
class notification_widgets extends MX_Controller  {
    
    public function dashboard()
    {
        if($this->session->userdata('is_admin')):
            $data['adminNotification'] = $this->getAdminNotification($this->session->userdata('employee_id'));
        else:    
            $data['adminNotification'] = NULL;
        endif;
        $data['getNotification'] = Modules::run('notification_system/getNotification', $this->session->userdata('username'));
        $result = $this->load->view('notification_system/noti_dashboard', $data);
        return $result;
    }
    
    public function getAdminNotification($user_id)
    {
        $data = Modules::run('notification_system/getAdminNotification', $user_id, 10);
        return $data;
    }
    
    public function getSchoolHeadNotification($position)
    {
        $data = Modules::run('notification_system/getSchoolHeadNotification', $position);
        return $data;
    }
}

?>
