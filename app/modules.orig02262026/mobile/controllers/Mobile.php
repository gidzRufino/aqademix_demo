<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mobile
 *
 * @author genesis
 */
class mobile extends MX_Controller {
    function index()
    {
         if(!$this->session->userdata('is_logged_in')){
                $data['getDevice'] = Modules::run('main/getDevice');
                $data['settings'] = Modules::run('main/getSet');
                $this->load->view('login', $data); 
         }else{
                //$this->dashboard();
         } 
    }
    
    function headerPanel()
    {
        $this->load->view('headerPanel'); 
    }
    
    function teachersHeaderPanel()
    {
        $this->load->view('faculty/headerPanel'); 
    }
    
    function html_header()
    {
        $this->load->view('header', $data);
    }

    function main_content($data)
    {
        $data['settings'] = Modules::run('main/getSet');
        $this->load->view('main_content', $data);
    }

    function html_footer()
    {
        $this->load->view('footer');
    }
    
    function nav()
    {
       // $data['menus'] = $this->dashboard_model->getMenu($user_id);
        $this->load->view('nav', $data);
    }
    
    function verify()
    {
            $user = $_POST['uname'];
            $pass = md5($this->input->post('pass'));
            
            echo $user;
    }
    function checkCredentials($user, $pass)
    {
        $query = $this->login_model->getInside($user, $pass);
        if($query)
        {
            $this->setUserData($user);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function setUserData($user)
    {
        //get first the usertype which handle by hr module
        $term = Modules::run('main/getCurrentQuarter');
        $settings = Modules::run('main/getSet');
        $position_id = "";
        $position = "";
        $is_admin = FALSE;
        $is_superAdmin = FALSE;
        $is_adviser = FALSE;
        $section_id = "";
        $grade_id = "";
        $siblings = "";
        $is_parent = FALSE;
        $parent_id = "";
        $uType = Modules::run('users/getUserType', $user);
        $uType_id = $uType->utype;
        
        if($uType_id==4){
            $is_parent = TRUE;         
        }

        if($is_parent){
            $position = 'Parent';
            $position_id = 4;
            $parent = Modules::run('users/getParentData', $user);
            $name = $parent->f_name;
            $siblings = $parent->child_links;
            $parent_id = $parent->parent_id;
            $user_id = $uType->u_id;
        }else{
        if($uType_id!=4){ //if user type != to student
            $getPosition = Modules::run('users/getPositionInfo', $user);
            $position_id = $getPosition->p_id;
            $position = $getPosition->post;       
            $basicInfo = Modules::run('users/getBasicInfo', $user);
            $name = $basicInfo->firstname;
            $user_id = $basicInfo->user_id;
            
            if($getPosition->position_details):
                $is_adviser = TRUE;
            endif;
            
        }else{

        }

            if($uType_id==22){

            }
            
            $admin = Modules::run('hr/ifDepartmentHead', $user_id, $uType_id);
            if($uType_id == 1 || $admin){
                $is_admin = true;
            }

            if($uType_id==1){
                $is_superAdmin = true;
            }
        }
        
        if($settings->att_check==1){
            $attend_auto = TRUE;
        }else{
            $attend_auto = FALSE;
        }
        
        
            $data = array(
                'is_logged_in'  => TRUE,
                'username'      => $user,
                'user_id'       => $user_id,
                'usertype'      => $uType_id,
                'position'      => $position,
                'position_id'   => $position_id,
                'is_superAdmin' => $is_superAdmin,
                'is_admin'      => $is_admin,
                'dept_id'       => $uType_id,
                'is_adviser'    => $is_adviser,
                'name'          => $name,
                'siblings'      => $siblings,
                'parent_id'     => $parent_id,
                'term'          => $term,
                'attend_auto'   => $attend_auto,
                'school_year'   => $settings->school_year

            );
            $this->session->set_userdata($data);
    }
}

