<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        //$this->form_validation->CI =& $this;
        $this->load->model('login_model');
	date_default_timezone_set('Asia/Manila');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
    
    public function index()
    {
        $data['settings'] = Modules::run('main/getSet');
        $data['getAccountType'] = Modules::run('main/getAccountType');
        if($data['settings']->short_name == 'firstlove' || $data['settings']->short_name == 'wiserkidz'):
            $this->load->view('deactivated');
        else:
            if(!$this->session->userdata('is_logged_in')):
               $this->load->view('login_view', $data);
            else:
                redirect('main/dashboard');
            endif;
        endif;
        
    }


    // public function index()
    // {
    //     $data['settings'] = Modules::run('main/getSet');
    //     $data['getAccountType'] = Modules::run('main/getAccountType');
    //     if(!$this->session->userdata('is_logged_in')):
    //       $this->load->view('login_view', $data);
    //     else:
    //         redirect('main/dashboard');
    //     endif;
        
    // }
    

    function verify()
    {
        $this->form_validation->set_rules('uname', 'Username',  'trim|required');
        $this->form_validation->set_rules('pass', 'Password',  'trim|required');
        if($this->form_validation->run() == FALSE)
            {
                $this->index();
        }else{
            $user = $this->input->post('uname');
            $pass = md5($this->input->post('pass'));
            
            $query = $this->login_model->getInside($user, $pass);
            //echo $user;
            //print_r($query);
            $isValidated = $this->checkCredentials($user, $pass);
            
            if($query->isActive):
                if($isValidated){
                    if(Modules::run('main/isMobile'))
                    {
                        Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged In using a mobile app.', $this->session->userdata('user_id'));
                        echo json_encode(array('status'=>TRUE));
                    }else{
                        Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged In.', $this->session->userdata('user_id'));
                        $this->load->library('user_agent');
                        if($this->agent->is_referral()):
                            redirect($this->agent->referrer());
                        else:
                            if($this->session->userdata('dept_id')==10):
                                redirect(base_url().'college');
                            else:
                                redirect(base_url().'main/dashboard');
                            endif;
                        endif;
                    }
                }else{
                   if(Modules::run('main/isMobile'))
                    {
                       echo json_encode(array('status'=>FALSE));
                   }else{ 
                   ?>
                   <script type="text/javascript">
                        alert('Access Denied');
                        document.location='<?php echo base_url() ?>';
                   </script>
                   <?php
                   }
                }  
            else:
                   ?>
                   <script type="text/javascript">
                        alert('Sorry Your account needs to be Activated');
                        document.location='<?php echo base_url('login/logout') ?>';
                   </script>
                   <?php
                
            endif;    
            
        }
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
        $employee_id = '';
        $rfid = '';
        $advisory = 0;
        $section_id = "";
        $grade_id = "";
        $siblings = "";
        $is_parent = FALSE;
        $parent_id = "";
        $uType = Modules::run('users/getUserType', $user);
        $uType_id = $uType->utype;
        $parent = $uType->if_p;
        
        if($parent){
            $is_parent = TRUE;         
        }

        if($is_parent){
            $position = 'Parent';
            $position_id = 4;
            $parent = Modules::run('users/getParentData', $user);
            if($parent->firstname!=""):
                    $name = $parent->firstname;
            else:
                $name = $parent->m_name;
            endif;
            $siblings = $parent->child_links;
            $parent_id = $parent->pid;
            $user_id = $uType->u_id;
        }else{
            
        if($uType_id!=4){ //if user type != to student
            $getPosition = Modules::run('users/getPositionInfo', $user);
            $position_id = $getPosition->p_id;
            $m_access = Modules::run('nav/getMenuByPosition', $position_id);
            $position = $getPosition->post;       
            $basicInfo = Modules::run('users/getBasicInfo', $user);
            $name = $basicInfo->firstname.' '. substr($basicInfo->middlename,0,1).'. '.$basicInfo->lastname;
            $user_id = $basicInfo->user_id;
            $employee_id = $basicInfo->employee_id;
            $rfid = $basicInfo->rfid;
            $getAdvisory = Modules::run('academic/getAdvisory', $user, $settings->school_year);
            if($getAdvisory->num_rows()>0):
                $is_adviser = TRUE;
                $advisory = $getAdvisory->row()->section_id;
            endif;
            
            }else{

            }
            $admin = Modules::run('hr/ifDepartmentHead', $user, $uType_id);
            if($admin){
                $is_admin = true;
            }
            
            if($position_id>=38 || $position_id <= 44):
                $is_admin = TRUE;
            endif;

            if($uType_id==1){
                $is_superAdmin = true;
                $is_admin = true;
            }
            if($position=='Faculty' || $position=='Part-Time Faculty'):
                $is_admin = FALSE;
            endif;
        }
        
        
        
        if($settings->att_check==1){
            $attend_auto = TRUE;
        }else{
            $attend_auto = FALSE;
        }
        
        
            $data = array(
                'is_logged_in'  => TRUE,
                'username'      => $user,
                'rfid'          => $rfid,
                'user_id'       => $user_id,
                'employee_id'   => $employee_id,
                'basicInfo'     => $basicInfo,
                'usertype'      => $uType_id,
                'position'      => $position,
                'position_id'   => $position_id,
                'is_superAdmin' => $is_superAdmin,
                'is_admin'      => $is_admin,
                'dept_id'       => $uType_id,
                'is_adviser'    => $is_adviser,
                'advisory'      => $advisory,
                'name'          => $name,
                'siblings'      => $siblings,
                'parent_id'     => $parent_id,
                'term'          => $term,
                'attend_auto'   => $attend_auto,
                'school_year'   => $settings->school_year,
                'menu_access'   => $m_access->menu_access

            );
            $this->session->set_userdata($data);
    }
    
    function logout()
    {
            $user_id=$this->session->userdata('user_id');
            $this->login_model->logout($user_id);
            $this->session->sess_destroy();
            $session_id = $this->session->userdata('session_id');
            if($session_id == "" || $session_id==null){
                $this->login_model->logout($user_id);
            }
            Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged Out.', $user_id);
            redirect(base_url());
 

    }
    
    function scan()
    {
        $data['ads'] = $this->login_model->fetch_ads(); 
        $data['news'] = Modules::run('messaging/getAnnouncement', 1);
        $data['settings'] = Modules::run('main/getSet');
        $this->load->view('scan', $data);
    }
    
    function getVerified($data, $sy=NULL)
    {
            //$data = $this->uri->segment(3);
            $ifVerified = $this->login_model->getVerified($data, $sy);
            $ifVerified = json_decode($ifVerified);

            if($ifVerified->status)
            { 
                $status = TRUE;
                $msg = 'Information Verified, You can now proceed';
            }else{
                $status = FALSE;
                $msg = 'Sorry, The information you entered is not registered. Please contact your school registrar.';
              
            }
            echo json_encode(array(
                'status'        => $status,
                'msg'           => $msg,
                'p_id'        => $ifVerified->parent_id,
                
                )
                        );
    }
    
    function getRegister($sy=NULL)
        {
            $childLinks = $this->input->post('child_links');
            $mobile = $this->input->post('mobile');
            $eachChild = explode(',', $childLinks);
            $numberOfChildren = count($eachChild);
            $i=1;
            $children = '';
            foreach($eachChild as $child)
            {
                $i++;
                $isEnrolled = Modules::run('registrar/isEnrolled', $child, $sy);
                if($isEnrolled):
                    $school_year = $sy;
                else:
                    $school_year = $sy-1;
                endif;
                
                $verifyChild = Modules::run('pp/verifyChild', $child, $mobile ,$sy);
                if($verifyChild):
                    $children .= $child;
                    $children .=',';
                endif;
                $data = array(
                    'parent_id' => $this->input->post('parent_id'),
                );
                
                Modules::run('registrar/editStudentInfo', $child, $data);
                
            }
            
            $students = trim($children, ',');
            if($students!=""):
                $reg = array(
                    'u_id'          => $this->input->post('parent_id'),
                    'uname'         => $this->input->post('u_id'),
                    'pword'         => md5($this->input->post('pass')), 
                    'utype'         => 4,
                    'secret_key'    => $this->input->post('pass'),    
                    'if_p'          => 1,
                    'child_links'   => $students,    
                    'parent_id'     => $this->input->post('parent_id')
                );
                $result = json_decode($this->login_model->getRegister($this->input->post('uname'),$reg));
                if($result->status)
                {
                    $status = TRUE;
                    $msg = 'Successfully Registered';
//                    Modules::run('web_sync/updateSyncController', 'user_accounts', 'uname', $this->input->post('uname'), 'create', 2);
                }else{
                    $status = FALSE;
                    $msg = 'Sorry, This user is already registered.';

                }
            else:
                $status = FALSE;
                $msg = 'Sorry, Please see the registrar for information verification'. $students;
            endif;
            
            echo json_encode(array(
                    'status'  => $status,
                    'msg'     => $msg,
                
                )
            );
        }
        
        function clientCheckIn($status = NULL)
        {

            $result = $this->login_model->checkIn($status);
            if($result):
                echo json_encode(array('status' => TRUE, 'timestamp' => date('Y-m-d H:i:s')));
            else:
                echo json_encode(array('status'=>FALSE, 'timestamp' => date('Y-m-d H:i:s')));
            endif;
        }
    

}
 
