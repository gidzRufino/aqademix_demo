<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Statistics {
    public function log_activity() {
        // We need an instance of CI as we will be using some CI classes
        
        
        $CI =& get_instance();
        $CI->load->library('audit_trail');
        // Start off with the session stuff we know
        $data = array();
        $data['user_id'] = $CI->session->userdata('user_id');
 
        // Next up, we want to know what page we're on, use the router class
        $data['section'] = $CI->router->class;
        $data['action'] = $CI->router->method;
 
        // Lastly, we need to know when this is happening
        $data['when'] = date('Y-m-d G:i:s');
 
        // We don't need it, but we'll log the URI just in case
        $data['uri'] = uri_string();
        $path = realpath(APPPATH);
        // And write it to the database
        if($CI->router->method!='checkPortal' && $CI->router->method!='getAttendanceUpdates' && $CI->router->method!='getAverageDailyAttendance'):
            $CI->audit_trail->lfile($path.'/modules/logs/'.$CI->session->userdata('user_id').'.txt');
            $CI->audit_trail->lwrite($CI->session->userdata('name').' access '.$CI->router->method.' through '.  uri_string().'.' , 'TRACE');
        endif;
    }
}

