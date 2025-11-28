<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Templates extends MX_Controller {
 		
		
    function html_header()
    {
        $this->load->library('eskwela');
        $settings = $this->eskwela->getSet();
        
        $data['settings'] = $settings;
        $this->load->view('header', $data);
    }
    
    function opl_footer()
    {
        $this->load->view('opl_footer');
    }
    
    function opl_header($title)
    {
        $data['title'] = $title;
        $this->load->view('opl_header', $data);
    }
    
    function opl_content($data)
    {
        $data['settings'] = $this->eskwela->getSet();
        $this->load->view('opl_content', $data);
    }

    function main_content($data)
    {
        $this->load->view('main_content', $data);
    }

    function print_header()
    {
        $this->load->view('print_header');
    }

    function print_footer()
    {
        $this->load->view('print_footer');
    }

    function print_content($data)
    {
        $this->load->view('print_content', $data);
    }

    function parent_content($data)
    {
        $data['parent'] = Modules::run('users/getParentData', $this->session->userdata('user_id'));
        $this->load->view('parent_content', $data);
    }
    
    function mobile_content($data)
    {
        $this->load->view('mobile_content', $data);
    }
    
    function schedule_content($data)
    {
        $this->load->view('schedule_content', $data);
    }
    
    function canteen_content($data)
    {
        $this->load->view('canteen_content', $data);
    }
    
    function online_content($data)
    {
        $this->load->view('online_content', $data);
    }
    
    function college_content($data)
    {
        $this->load->view('college_content', $data);
    }

    function html_footer()
    {
        $data['settings'] = Modules::run('main/getSet');
        $this->load->view('footer', $data);
    }
    
    function nav()
    {
       // $data['menus'] = $this->dashboard_model->getMenu($user_id);
        $this->load->view('nav', $data);
    }
}
 
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */
