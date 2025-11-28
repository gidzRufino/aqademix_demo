<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Api extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('api_model');
        $this->load->model('profile_model');
    }
    
    
    private function post()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        return $data;
    }
    
    
    public function getOnlineData()
    {
        
    }
    
    public function sampleFetch()
    {
        echo json_encode(array(
            'name'  => 'GenRu',
            'img'   => 'https://i.ytimg.com/vi/8tirF8_BdqY/maxresdefault.jpg'
        )); 
    }
    
    
    public function getToken($user_id)
    {
        $status = Modules::run('notification_system/checkToken', $user_id);
        echo json_encode(array(
            'status'        => $status
        ));
    }
    
    public function setToken()
    {
        $data = $this->post();
        $token = $data['token'];
        $user_id = $data['user_id'];
        $details = array('token' => $token, 'push_user_id' => $user_id);
        $status = Modules::run('notification_system/registerPushToken',$details, $user_id);
        
        echo json_encode(array(
            'status'        => $status,
            'token'     => $details
        ));
    }
    
    public function send_notification($user_id=NULL, $message=NULL)
    {
        $token = Modules::run('notification_system/getToken', $user_id);
        if(!$token):
        else:
                $url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $token,
			 'data' => $message
			);
		$headers = array(
			'Authorization:key = AAAABv3kdbc:APA91bFB84ZspWTlj0sCeHgaT89JWqLRtCO761SS0i8r-AZTFGiPI4wZ_GREKp-byE8WP22d9ipXHWVtmpsGd9x8SygOlsmCk0OMKPcO0KuMHL3bkr25cQYRkKE_9cf-6YBXW0rGfXuV',
			'Content-Type: application/json'
			);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                $result = curl_exec($ch);           
                if ($result === FALSE) {
                    die('Curl failed: ' . curl_error($ch));
                }
                curl_close($ch);
                echo $result;
        endif;
//        if($token==NULL):
//            $message = array("message" => " Sample Eskwela Notification");
//            $token[] = "eLKXCrJ87ts:APA91bHf8BKo4sNBSi_3bKEJsl7LzRQGAY6MTLVGMrx53vQYGlASeNo-STPPrJa7j8SRMa6h7aB6-N5mbQId8EHhobCTlZ5zeQAmLQg4WwOREHZFpphK17291zsPZGhSILLRsqaYWvyz";
//        endif;
        
        
    }
    
    public function getDetails($id)
    {
        $settings = Modules::run('main/getSet');
        $details = $this->api_model->getSingleStudent($id, $settings->school_year);
        
        echo json_encode(array(
            'student'=>$details,
            'father' => Modules::run('registrar/getFather', $details->u_id),
            'mother' => Modules::run('registrar/getMother', $details->u_id)
        ));
    }
    
    function checkPortal()
    {   
        $settings = Modules::run('main/getSet');
        echo json_encode(array(
            'status'        => TRUE, 
            'session'       => session_id(),
            'img_url'       => base_url().'images/forms/'.$settings->set_logo,
            'portal_url'    => base_url(),
            'school_year'   => $settings->school_year,
            'school_name'   => $settings->set_school_name
        ));
        
    }
    
    public function checkNotification($user_id)
    {
        $settings = Modules::run('main/getSet');
        $parent = Modules::run('users/getParentData', $user_id);
        $details = array();
        foreach(explode(',', $parent->child_links) as $child):
            $student = Modules::run('registrar/getSingleStudent', $child, $settings->school_year);
            $notification = Modules::run('notification_system/getNotification', $student->user_id);
            if(!empty($notification)):
                array_push($details, $notification->result());
            endif;
        endforeach;
        echo json_encode($details);
        
    }
    
    
    public function get($profile_id=NULL)
    {
        $d = $this->post();
        $settings = Modules::run('main/getSet');
        $childLinks = $this->profile_model->getChildLinks($profile_id);
        $children = explode(',', $childLinks);
        $school_year = $settings->school_year;
        foreach($children as $child):
            $isEnrolled = Modules::run('registrar/isEnrolled', $child, $settings->school_year);
            if(!$isEnrolled):
                $isCollegeEnrolled = Modules::run('college/isEnrolled', $child, $settings->school_year);
                if($isCollegeEnrolled):
                    $student = Modules::run('college/getSingleStudent', $child, $school_year);
                endif;

                    $data[] = array(
                        'Name'          => strtoupper($student->firstname.' '. $student->lastname),
                        'img'           => base_url('uploads/'.$student->avatar),
                        'grade_level'   => $student->course,
                        'section'       => $student->year_level,
                        'st_id'         => $student->uid
                    );
            else:
                 $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
                $data[] = array(
                    'Name'          => strtoupper($student->firstname.' '. $student->lastname),
                    'img'           => base_url('uploads/'.$student->avatar),
                    'grade_level'   => $student->level,
                    'section'       => $student->section,
                    'st_id'         => $student->st_id
                );
            endif;
        endforeach;  
        
        echo json_encode(array('data'=> $data));
    }
    

    function getOut()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $key = $data['token'];
        if($this->api_model->getOut($key)):
            echo json_encode(array('token'=> '', 'status' => TRUE));
        else:
            echo json_encode(array('token'=> '', 'status' => FALSE));
            
        endif;
    }

    function getInside()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'];
        $password = $data['password'];
        $token = $this->security->get_csrf_hash();

        $isValidated = $this->checkCredentials(strtolower($username), md5($password), $token);
        $isValidated = json_decode($isValidated);
        if($isValidated->status):
            Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged in using mobile phone.', $this->session->userdata('employee_id'));
            echo json_encode(array(
                'status' => TRUE, 
                'token' => $this->session->userdata('session_id'),
                'profile_id' => $isValidated->parent_id,
                'if_parent'  => $isValidated->row->if_p,
                'st_ids'     => base64_encode($isValidated ->row->child_links)
                ));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Username and Password doesn\'t exist!'));
        endif;

    }
    
    public function verifyToken($key=NULL)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        ($key==NULL?$data['token']:$key);
        $verified = $this->api_model->verifyKey($data['token']);
        //print_r($verified);
        $verify = json_decode($verified);
        if($verify->status):    
            $result = array(
                'status'        => TRUE,
                'profile_id'    => $this->session->userdata('user_id')
            );
        else:
            $result = array(
                'msg'   => 'Invalid Token',
                'status' => FALSE
            );
        endif;    

        echo json_encode($result);
    }
    
    public function getTeacherInfo($id)
    {
        echo Modules::run('hr/loadView', $id);
    }

    public function verify($name, $pass, $key)
    {
        header('Content-Type: application/json');
        if($this->verifyKey($key)):
            $isValidated = $this->checkCredentials($name, md5($pass));
            if($isValidated):
                Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged in using mobile phone.', $this->session->userdata('employee_id'));
                echo json_encode(array(
                    'status' => TRUE, 
                    'name' => $this->session->userdata('name'), 
                    'user_id' => $this->session->userdata('employee_id')
                    ));
            else:
                echo json_encode(array('status' => FALSE));
            endif;
        else:    
            echo json_encode(array('status' => FALSE)); 
        endif;
     
    }
    
    function checkCredentials($user, $pass, $token)
    {
        $query = $this->api_model->getInside($user, $pass, $token);
        if($query)
        {
            $this->setUserData($user);
            return $query;
        }else{
            return $query;
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
            $position = $getPosition->post;       
            $basicInfo = Modules::run('users/getBasicInfo', $user);
            $name = $basicInfo->firstname;
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
            if($position=='Faculty'):
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
                'session_id'    => session_id()

            );
            $this->session->set_userdata($data);
    }
    
    function logout()
    {
            $user_id=$this->session->userdata('user_id');
            $this->api_model->logout($user_id);
            $this->session->sess_destroy();
            $session_id = $this->session->userdata('session_id');
            if($session_id == "" || $session_id==null){
                $this->api_model->logout($user_id);
            }
            Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged Out using mobile phone.', $user_id);
            
            echo json_encode(array('status' => TRUE));

    }

    function sample()
    {

        $token = $this->security->get_csrf_hash();
        echo json_encode(array(
            'key'           => $token,
            'status'        => true,
            
        ));
    }

    function getVerified($data=NULL)
    {
            //$data = $this->uri->segment(3);
            $json = json_decode(file_get_contents('php://input'), true);
            $data = $json['user'];
            $ifVerified = $this->api_model->getVerified($data);
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
                'p_id'          => $ifVerified->parent_id
                
                )
                        ); 
    }

    function getRegister($sy=NULL)
    {
        $json = json_decode(file_get_contents('php://input'), true);
        $sy=$json['school_year'];
        $childLinks = $json['studentIDs'];
        $mobile = $json['number'];;
        $eachChild = explode(',', $childLinks);
        $numberOfChildren = count($eachChild);
        $i=1;
        $children = '';
        $school_year = date('Y');
        //echo json_encode(array('msg'=> $childLinks));
        foreach($eachChild as $child)
        {
            $i++;
            $isEnrolled = Modules::run('registrar/isEnrolled', $child, date('Y'));
            if(!$isEnrolled):
                $isCollegeEnrolled = Modules::run('college/isEnrolled', $child, date('Y'));
                if($isCollegeEnrolled):
                    $student = Modules::run('college/getSingleStudent', $child, $school_year);
                endif;
            else:
                 $student = Modules::run('registrar/getSingleStudent', $child, $school_year);
            endif;
            
            $verifyChild = Modules::run('pp/verifyChild', $child, $mobile ,$school_year);
            if($verifyChild):
                $children .= $child;
                $children .=',';
            endif;
            $data = array(
                'parent_id' => $json['parent_id'],
            );
            
            Modules::run('registrar/editStudentInfo', $child, $data);
            
        }
       // echo json_encode(array('msg'=> $data));

        $students = trim($children, ',');
        if($students!=""):
            $reg = array(
                'u_id'          => $json['parent_id'],
                'uname'         => $json['username'],
                'pword'         => md5($json['password']), 
                'utype'         => 4,
                'secret_key'    => $json['password'],    
                'if_p'          => 1,
                'child_links'   => $students,    
                'parent_id'     => $json['parent_id']
            );
            $result = json_decode($this->api_model->getRegister($json['username'],$reg));
            if($result->status)
            {
                $status = TRUE;
                $msg = 'Successfully Registered';
//                Modules::run('web_sync/updateSyncController', 'user_accounts', 'uname', $json['username'], 'create', 2);
            }else{
                $status = FALSE;
                $msg = 'Sorry, This user is already registered.';

            }
        else:
            $status = FALSE;
            $msg = 'Sorry, Please see the registrar for information verification';
        endif;
        
        echo json_encode(array(
                'status'  => $status,
                'msg'     => $msg,
            
            )
        );
    }
    
    
    

}
 
