<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class messaging extends MX_Controller {
        

        function __construct()
        {
            parent::__construct();
            $this->load->model('messaging_model');
        }
        public function index()
	{
            if(!$this->session->userdata('is_logged_in')){
                    $data['settings'] = $this->studentgate_model->getSet(); 
                    $data['accounts'] = $this->studentgate_model->getAccountType(); 
                    $data['holidays'] = $this->studentgate_model->getHolidays();
                    $this->load->view('login' , $data);
            }else{
            $this->load->model('messaging_model');    
            $dept_id = $this->session->userdata('dept_id');
            $user_id = $this->session->userdata('user_id');
            $is_admin = $this->session->userdata('is_admin');
            
            $data['user_id'] = $user_id;
            $data['individualMessages'] = $this->messaging_model->getIndividualMessages($user_id);
            $data['employeeList'] = $this->employee_model->employeeList(); 
            $data['myMessages'] = $this->messaging_model->getMessages($user_id);
            $data['main_content'] = 'messaging/default';    
            $this->load->view('includes/template' , $data);

            }
        }
        
       
        function inbox()
        {
            $data['main_content'] = 'inbox';
            $data['modules'] = 'messaging';
            echo Modules::run('templates/main_content', $data);
        }
        
        function announcement()
        {
            $data['main_content'] = 'announcement';
            $data['modules'] = 'messaging';
            echo Modules::run('templates/main_content', $data);
        }
        
        function saveAnnouncement()
        {
            $details = array(
                'ticker_title'   => $this->input->post('newsTitle'),
                'ticker_msg'   => $this->input->post('txtMsg'),
                'active'   => $this->input->post('activate')
            );
            
            $this->messaging_model->saveAnnouncement($details);
            return;
        }
        
        function getAnnouncement($status)
        {
            $announcments = $this->messaging_model->getAnnouncement($status);
            return $announcments;
        }
        
        function getAnnouncementTicker($status)
        {
            $data['news'] = $this->messaging_model->getAnnouncement($status);
            $this->load->view('newsTicker', $data);
            
        }
        
        function updateAnnouncement()
        {
            if($this->input->post('status')==1):
                $no_publish = $this->getAnnouncement(1);
                if($no_publish->num_rows()>4):
                    echo json_encode(array('status' => false, 'msg' =>'Sorry, You are only allowed to post 4 announcements per day, unpublish an old post before you can add a new one'));
                else:
                    echo json_encode(array('status' => TRUE, 'msg' =>('Successfully Added')));
                    $details = array('active' => $this->input->post('status'));
                    $this->messaging_model->updateAnnouncement($this->input->post('id'), $details); 
                endif;
            else:
                $details = array('active' => $this->input->post('status'));
                $this->messaging_model->updateAnnouncement($this->input->post('id'), $details);
            endif;
            
            
            
        }
        
        function deleteAnnouncement()
        {
            $this->messaging_model->deleteAnnouncement($this->input->post('id'));
        }
        
        function send()
        {
            
            $sendTo = $this->input->post('inputSendTo');
            $message = $this->input->post('message');
            $sendFrom = $this->session->userdata('user_id');
            $parentMsgId = $this->input->post('parentMsgId');
            $item = explode(",", $sendTo);
            $this->load->model('messaging_model');
            foreach($item as $i)
            {
               $sendResult = $this->messaging_model->saveMessage($i, $sendFrom, $message,$parentMsgId);
            }

            //$readMessage = $this->messaging_model->getMessage($sendFrom);
           // echo $parentMsgId;
            //$jsonString = json_encode($sendResult);
            //echo $jsonString;
            //echo $sendTo;
        }
        
        function load()
        {
            $this->load->model('messaging_model');    
            $dept_id = $this->session->userdata('dept_id');
            $user_id = $this->session->userdata('user_id');
            $is_admin = $this->session->userdata('is_admin');  
            $myMessages = $this->messaging_model->getMessages($user_id);

            foreach($myMessages['result'] as $msg){
                
                if($msg->avatar==''||$msg->avatar==NULL || $msg->avatar = 'noImage.jpg')
                {
                    $avatar = 'noImage.png';
                }else{
                    $avatar = $msg->avatar;
                }
                ?>
                
                <div style="padding:8px; cursor:pointer; border-bottom:1px #B2B2B2 solid; float:left; width:94%;">
                    <img style="margin:0" class="span1" src="<?php echo base_url().APPPATH;?>uploads/<?php echo $avatar ?>" />
                    <div style="margin-left:10px;" class="pull-left">
                        <h6 style="vertical-align:center;"><?php echo $msg->firstname.' '.$msg->lastname; ?></h6>
                        <p><?php ?></p>
                    </div>
                </div>    
               
                <?php
                }

        }
        
        function loadMessages()
        {
            $now = date("Y-m-d");
            $this->load->model('messaging_model');    
            $dept_id = $this->session->userdata('dept_id');
            $user_id = $this->session->userdata('user_id');
            $is_admin = $this->session->userdata('is_admin');  
            $individualMessages = $this->messaging_model->getIndividualMessages($user_id);

            
                foreach($individualMessages['sent'] as $inMsg){
                            if($inMsg->avatar==''||$inMsg->avatar==NULL || $inMsg->avatar = 'noImage.jpg')
                            {
                                $avatar = 'noImage.png';
                            }else{
                                $avatar = $inMsg->avatar;
                            }
                            $msgSenderId = $individualMessages['reply'];
                    $date = $inMsg->timestamp;
                    $fDate = explode(' ', $date);
                    if($fDate[0]==$now){
                    ?>
                    <div style="float:left; width:100%;">
                        <h6>TODAY <?php echo $fDate[1]; ?></h6>
                        <img class="pull-left" style="padding:2px; margin:0; width: 30px; height:30px;" src="<?php echo base_url().APPPATH;?>uploads/<?php echo $avatar ?>" />
                        <div style="margin-left:10px;" class="pull-left">
                            <h6 style="margin:0; vertical-align:center;"><?php echo $inMsg->firstname.' '.$inMsg->lastname; ?></h6>
                            <p><?php echo $inMsg->msg_content ?></p>
                        </div>
                    </div> 
                    <?php
                    }elseif($fDate[0]<$now){
                     ?>
                    <div style="float:left; width:100%;">
                        <h6><?php echo $date ?></h6>
                        <img class="pull-left" style="padding:2px; margin:0; width: 30px; height:30px;" src="<?php echo base_url().APPPATH;?>uploads/<?php echo $avatar ?>" />
                        <div style="margin-left:10px;" class="pull-left">
                            <h6 style="margin:0; vertical-align:center;"><?php echo $inMsg->firstname.' '.$inMsg->lastname; ?></h6>
                            <p><?php echo $inMsg->msg_content ?></p>
                        </div>
                    </div> 
                    
                    <?php      
                        
                    }  
                    }
        }
        
       
        
        function sendSMS()
        {
           $sms = $this->input->post('txtMsg');
           $dept = $this->input->post('dept');
           
           $result = Modules::run('hr/getIndividualNumbers', $dept);
           foreach ($result as $r)
           {
               $subtract = substr($r->cd_mobile, 0,2);
                    if($subtract=='09' || $subtract=="+63"){
                         ?>
                        <script type="text/javascript">
                           var sms = '<?php echo $sms; ?>';
                           var num = '<?php echo $r->cd_mobile; ?>';
                           sendMessage(sms, num,'send'); 
                        </script>
                        <script src="<?php echo base_url(); ?>assets/js/smsRequest.js"></script>
           <?php    
                    }
           }
           
               // echo ;
          
        }
        
        function getAllNumbers()
        {
           $model = $this->messaging_model->getAllNum();
           return $model;
        }
       
        
}