<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Settings extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('get_college_model');
        $this->load->model('settings_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
    }
    
    public function index()
    {
        $data['modules'] = 'college';
        $data['main_content'] = 'settings/default';
        echo Modules::run('templates/college_content', $data);
    }
    
    public function registrarLogs($offset = NULL)
    {
        $result = $this->get_college_model->registrarLogs();
            //print_r($result->result());
        $config['base_url'] = base_url('college/settings/registrarLogs/');
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $page = $this->get_college_model->registrarLogs($config['per_page'], $offset );
        $data['offset'] = $offset;
        $data['systemLogs'] = $page->result();
        $data['main_content'] = 'systemLogs';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
   
   public function getEmployeeAccess($user_id = NULL)
   {
       $data['user_id'] = $user_id;
       //$data['dashboardAccess'] = Modules::run('nav/getDashboardList'); 
       $data['positionAccess'] = $this->get_college_model->getMenuAccess($user_id);
       $data['menuAccess'] = $this->settings_model->getMenu();
       $this->load->view('settings/accessList', $data);
   } 
       
   public function saveAccess()
   {
       $position_id = $this->input->post('user_id');
       $column = $this->input->post('column');
       $value = $this->input->post('id');
       $accessValue = $this->input->post('accessValue');
       $accessName = $this->input->post('accessName');
       
       $exist = $this->settings_model->checkAccess($position_id);
       if(!$exist):
            $array = array(
                'cma_user_id'   => $position_id,
                 $column        => $value, 
            );
       else:
            $currentValue = $accessValue.','.$value;
            $sorValue = explode(',', $currentValue);
            $arrayUnique = array_unique($sorValue);
            sort($arrayUnique);
            $arval = implode(',', $arrayUnique);
            $array = array(
                $column => $arval, 
            );
       endif;
       
       $this->settings_model->saveAccess($position_id, $array);
       ?>
         <div id="<?php echo $value ?>" column="<?php echo $column ?>" accessValue="<?php echo $accessValue ?>" onclick="unAssignAccess('<?php echo $value ?>', '<?php echo $accessValue ?>'), $(this).fadeOut(500)"  style='cursor:pointer; margin-bottom:5px;' class='alert alert-success alert-dismissable span11'>
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <div id="un_<?php echo $value ?>_name" class="notify">
                   <?php echo $accessName ; ?>
                </div>    

           </div>            
       <?php              
   }
   
     
   public function unlinkAccess()
   {
       $position_id = $this->input->post('user_id');
       $column = $this->input->post('column');
       $value = $this->input->post('id');
       $accessValue = $this->input->post('accessValue');
       $accessName = $this->input->post('accessName');
       
       $array = array(
           $column => $value, 
       );
       $this->settings_model->saveAccess($position_id, $array);
       
       
       ?>
       <div val="<?php echo $value ?>" column="<?php echo $column ?>" accessValue="<?php echo $accessValue ?>" onclick="assignAccess(this.value)" style='cursor:pointer; margin-bottom:5px;' class='alert alert-danger alert-dismissable span11'>
           <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&DoubleLeftArrow;</button>
           <div id="<?php echo $value ?>_name" class="notify">
              <?php echo $accessName ?>
           </div>    

      </div>              
                     
       <?php
   }
    
    public function accessControl()
    {
        if(!$this->session->userdata('is_logged_in')){
                ?>
                     <script type="text/javascript">
                        document.location = "<?php echo base_url()?>"
                     </script>
                <?php

             }else{ 
                $data['main_content'] = 'settings/accessControl';
                //$data['dashboardAccess'] = Modules::run('nav/getDashboardList'); 
                $data['menuAccess'] = Modules::run('nav/getMenuList'); 
                $data['employees'] = Modules::run('hr/getEmployees'); 
                $data['modules'] = "college";
                echo Modules::run('templates/college_content', $data);

             }
    }


    
    
    public function enrollmentListing()
    {
        if(!$this->session->userdata('is_logged_in')){
                ?>
                     <script type="text/javascript">
                        document.location = "<?php echo base_url()?>"
                     </script>
                <?php

             }else{
                $data['main_content'] = 'enrollmentList';                   
                $data['grade'] = $this->getGradeLevel(); 
                $data['modules'] = 'college';
                echo Modules::run('templates/main_content', $data);	
             }
    }
        
   
   
   
   
}
