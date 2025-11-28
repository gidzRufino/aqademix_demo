<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Parent_portal_widgets extends MX_Controller {
    
    function studentInfo()
    {
        $parent = Modules::run('users/getParentData', $this->session->userdata('user_id'));
        $data['child_links'] = $parent->child_links;
        $data['students'] = count(explode(',', $parent->child_links));
        $this->load->view('parent_portal/studentInfo', $data);
    }
    
    function subjectTeachers()
    {
        $parent = Modules::run('users/getParentData', $this->session->userdata('user_id'));
        $data['child_links'] = $parent->child_links;
        $this->load->view('parent_portal/subjectTeachers', $data);
    }
    
    function dailyReports()
    {
        $data['teachers'] = '';
        $this->load->view('parent_portal/dailyReports', $data);
    }
    
}

