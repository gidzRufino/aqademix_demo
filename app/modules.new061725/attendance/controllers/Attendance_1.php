<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance
 *
 * @author genesis
 */
class attendance extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('attendance_model');
    	$this->load->library('Mobile_Detect');
    }
    
    function updateManualToAuto()
    {
        $q = $this->db->get('attendance_sheet_manual');
        echo count($q->result()).' needs to be updated';
        foreach ($q->result() as $res):
            $this->db->select('rfid');
            $this->db->select('st_id');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
            $this->db->where('st_id', $res->st_id);
            $q1 = $this->db->get();
            
            $details = array(
                'att_st_id' => $res->st_id,
                'u_rfid'    => $q1->row()->rfid,
                'time_in'   => '800',
                'date'      => date("Y-m-d", strtotime($res->date)),
            );
            if($this->db->insert('attendance_sheet', $details)):
                echo $res->st_id.' is successfully transferred to auto. <br />';
            endif;
        endforeach;
        
    }
    
    function attendanceUpdates()
    {
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->select('*');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->where('account_type', 5);
        $this->db->order_by('lastname', 'ASC');
        $q = $this->db->get();
        
        foreach ($q->result() as $st):
            $data = array(
                'u_rfid' => $st->rfid
            );
            $this->db->where('att_st_id', $st->st_id);
            if($this->db->update('attendance_sheet', $data)):
                echo $st->rfid.' | '. $st->lastname.' | '.$st->st_id.'<br />';
            endif;
            
        endforeach;
//        $sql = 'ALTER TABLE `esk_attendance_summary` ADD `school_year` YEAR NOT NULL ';
//        $this->db->query($sql);
    }
    
    function getAttendanceSheets()
    {
        //$this->db->limit(10, 0);
        $q = $this->db->get('attendance_sheet');
        $total = count($q->result());
        $x = 0;
        foreach($q->result() as $att):
        $x++;
        $this->db->where('att_id', $att->att_id);
        $update = array(
            'date' => date("Y-m-d", strtotime($att->date))
        );
        if($this->db->update('attendance_sheet', $update)):
           if($x==$total):
               echo 'Attendance Sheet is successfully updated <br />';
               $this->db->query("ALTER TABLE `esk_attendance_sheet` CHANGE `date` `date` DATE NOT NULL");
               echo 'Column Date is change successfully';
           endif;
        endif;
        endforeach;
    }
    
    function getAttendanceSheetsM()
    {
        //$this->db->limit(10, 0);
        $q = $this->db->get('attendance_sheet_manual');
        $total = count($q->result());
        $x = 0;
        foreach($q->result() as $att):
        $x++;
        $this->db->where('att_id', $att->att_id);
        $update = array(
            'date' => date("Y-m-d", strtotime($att->date))
        );
        if($this->db->update('attendance_sheet_manual', $update)):
           if($x==$total):
               echo 'Attendance Sheet is successfully updated Manually <br />';
           endif;
        endif;
        endforeach;
         $this->db->query("ALTER TABLE `esk_attendance_sheet_manual` CHANGE `date` `date` DATE NOT NULL");
         echo 'Column Date is change successfully';
    }
    
    function checkAdviser($section)
    {
        $check = $this->getNumberOfPresents(date('Y-m-d'), $section);
        
        if($check->num_rows==0):
            Modules::run('notification_system/sendNotification',3, 2, 'System', $this->session->userdata('username'), 'Please Don\'t forget to check your Attendance', date('Y-m-d'));
            echo json_encode(array('status'=>TRUE, 'msg'=>'Please Don\'t forget to check your Attendance' ));
        endif;
    }
    
    function getApGraph($section_id=NULL, $date=NULL)
    {
        if($section_id==NULL):
            $section_id = $this->input->post('section_id');
            if($section_id=='admin'):
                $section_id = "";
            endif;
        endif;
        if($date==NULL):
            $date = $this->input->post('date');
        endif;
        
        $d = explode('/', $date);
        $data['firstDay'] = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $d[0], 10)), $d[2], 'first');
        $data['lastDay'] = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $d[0], 10)), $d[2], 'last');
        $data['d'] = $d;
        $data['numberOfStudents'] = Modules::run('registrar/getAllStudentsForExternal',NULL, $section_id, NULL, NULL);
        $data['section_id'] = $section_id;
        
        $this->load->view('apGraph', $data);
        
        
    }
    
    function getNumberOfEmployeePresents($date = NULL, $attend_auto = NULL)
    {
        $records = $this->attendance_model->getEmployeeAttendance($date);
        
        return $records;
    }
    
    function getNumberOfCollegePresent($date = NULL)
    {
        
        if($this->session->userdata('attend_auto')){
                $records = $this->attendance_model->getCollegeAttendance($date);
        }else{
                $records = $this->attendance_model->getCollegeAttendance($date);
        }
        
        return $records;
    }
    
    function getNumberOfPresents($date = NULL, $section=NULL)
    {
        if($section==NULL):
            $records = $this->getAttendance($this->session->userdata('advisory'), $date);
        else:
            $records = $this->getAttendance($section, $date);
        endif;
        
        return $records;
    }
    
    function saveDTR($rfid, $user_id, $time=NULL)
    {
        $settings = $this->eskwela->getSet();
        if($time==NULL):
            $time = date('Gi');
        endif;
        
        $BasicInfo = Modules::run('registrar/getSingleStudentByRfid', $rfid);
        $getBasicInfo = $BasicInfo->row();
        $lastname = $getBasicInfo->lastname;   
        $firstname = $getBasicInfo->firstname; 
        
        //this check if user scan for the first time in a day
        $result = $this->attendance_model->attendanceCheck($user_id, date("Y-m-d"), $settings->school_year);
        $row = $result->row();
        
        if($result->num_rows()==0): // if user's first scan
            if($time > 1200): //time is PM
                $this->saveTimeAttendance($rfid, 1, 'time_in_pm', $time, date("Y-m-d"), $user_id);
            else: // time is AM
                $this->saveTimeAttendance($rfid, 1, 'time_in', $time, date("Y-m-d"), $user_id);
            endif;
            $this->saveTimeLog(1, $rfid);    
            $check_in = TRUE;
            if($getBasicInfo->avatar!=""):
                $avatar = base_url().'uploads/'.$getBasicInfo->avatar;
            else:
                $avatar = base_url().'uploads/noImage.png';
            endif; 
        else: // if not user's first scan
            //check time delay
            $timeDelay = $this->attendance_model->checkTimeLog($rfid);
            if($timeDelay->num_rows()>0):
                $hour = substr($timeDelay->row()->time, 0, 2);
                $mins = $timeDelay->row()->time;
                if(date('G')>$hour):
                    $min = $time - ($mins+40);
                else:
                    $min = $time - $mins;
                endif;
                
                    if($min<=5): // if last scan is <= to 5 mins
                        $status = FALSE;
                        $msg = 'SORRY: You are not allowed to scan yet!';
                        $check_in = '';
                        $check_out = ''; 
                        $lastname = '';   
                        $firstname = '';   
                        $rfid = '';
                        $user_id = "";
                        $textMsg = "";
                        $send = "";
                        $number = "";
                    else:
                        //check check in status
                        if($row->status): //if time in, save it as time out
                            if($time<1300): // time is AM
                               if($row->time_out==""):
                                    $this->saveTimeLog(0, $rfid);
                                    $this->updateTimeAttendance($user_id, 'time_out', $time, 0);
                               endif;
                            else:// time is PM
                                $this->saveTimeLog(0, $rfid);
                                $this->updateTimeAttendance($user_id, 'time_out_pm', $time, 0);
                            endif;
                        
                        $check_in = FALSE;    
                        else: // if time out, save as time in
                            if($time<1300):
                                $this->saveTimeLog(1, $rfid);
                                $this->updateTimeAttendance($user_id, 'time_in_pm', "", 1);
                            else:    
                                $this->saveTimeLog(1, $rfid);
                                $this->updateTimeAttendance($user_id, 'time_in_pm', $time, 1);
                            endif;
                        
                        $check_in = TRUE;     
                        endif;
                    endif;
            endif;
        endif;
    }
    
    function scanrfid()
    {
        $id = $this->input->post('id');
        $settings = $this->eskwela->getSet();
        //echo $id;
        $BasicInfo = Modules::run('registrar/getSingleStudentByRfid', $id);
       // print_r($BasicInfo);
        $getBasicInfo = $BasicInfo->row();
        if($getBasicInfo->account_type==5):
            $user_id = $getBasicInfo->st_id; 
        else:
            $user_id = $getBasicInfo->employee_id; 
        endif;
        if($BasicInfo->num_rows()>0){
            $status = TRUE;
            $msg = '';
            
        //this check if user scan for the first time in a day
         $result = $this->attendance_model->attendanceCheck($user_id, date("Y-m-d"), $settings->school_year);
         $row = $result->row();
         
            if($result->num_rows()==0){
                //check
                if(date('Gi')>1200) // time is PM
                    {
                        $this->saveTimeAttendance($id, 1, 'time_in_pm', date('Gi'), date("Y-m-d"), $user_id);
                        
                    }else{
                        $this->saveTimeAttendance($id, 1, 'time_in', date('Gi'), date("Y-m-d"), $user_id);
                    }
                $this->saveTimeLog(1, $id);    
                $check_in = TRUE;
                if($getBasicInfo->avatar!=""):
                    $avatar = base_url().'uploads/'.$getBasicInfo->avatar;
                else:
                    $avatar = base_url().'uploads/noImage.png';
                endif;
                $lastname = $getBasicInfo->lastname;   
                $firstname = $getBasicInfo->firstname;   
                $rfid = $id;  
                if($getBasicInfo->account_type==5):
                   $user_id = $user_id; 
                else:
                    $user_id = $getBasicInfo->employee_id; 
                endif;
                
            }else{
                //scan time delay
                $timeDelay = $this->attendance_model->checkTimeLog($id);
                if($timeDelay->num_rows()>0) :
                    $hour = substr($timeDelay->row()->time, 0, 2);
                    $mins = $timeDelay->row()->time;
                    if(date('G')>$hour):
                        $min = date('Gi') - ($mins+40);
                    else:
                        $min = date('Gi') - $mins;
                    endif;
                    
                    
                    if($min<=5):
                        $status = FALSE;
                        $msg = 'SORRY: You are not allowed to scan yet!';
                        $check_in = '';
                        $check_out = ''; 
                        $lastname = '';   
                        $firstname = '';   
                        $rfid = '';
                        $user_id = "";
                        $textMsg = "";
                        $send = "";
                        $number = "";
                    else:
                        //check if status is time_in; save as  time Out
                        if($row->status)
                        {   
                           if(date('Gi')>=1200 && date('Gi')<=1230) // time is PM
                            {
                               if($row->time_out==""):
                                    if($getBasicInfo->account_type!=5){
                                        $this->saveTimeLog(0, $id);
                                    }
                                    $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                               else:
                                   if($row->time_out_pm!=""){ //if already has time out in the database
                                     if($getBasicInfo->account_type!=5){
                                              $this->saveTimeLog(0, $id);
                                        }
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                     }else{
                                         $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                         $this->saveTimeLog(0, $id);      
                                     }
                                   
                               endif;

                            }else{// time is AM

                                $this->saveTimeLog(0, $id);

                                $this->updateTimeAttendance($user_id, 'time_out', date('Gi'), 0);
                            }

                         $check_in = FALSE;
                        }else{
                                //check if AM or PM
                                if(date('Gi')>=1200) //this is PM
                                {
                                    if($row->time_in_pm!=""){
                                        if($getBasicInfo->account_type!=5){
                                            $this->saveTimeLog(1, $id);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_in_pm', $row->time_in_pm, 1);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out', "", 1);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out_pm', "", 1);
                                        }else{
                                            $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                        }
                                    }else{
                                        $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                    }
                                }else{
                                    if($getBasicInfo->account_type!=5){
                                       $this->saveTimeLog(1, $id); 
                                       $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_in', $row->time_in, 1);
                                       $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out', "", 1);
                                    }else{
                                         $this->updateTimeAttendance($user_id, 'time_in', date('Gi'), 1);
                                    }
                                }
                                $check_in = TRUE;
                        }
                            
                            if($getBasicInfo->avatar!=""):
                                $avatar = base_url().'uploads/'.$getBasicInfo->avatar;
                            else:
                                $avatar = base_url().'uploads/noImage.png';
                            endif;
                            $lastname = $getBasicInfo->lastname;   
                            $firstname = $getBasicInfo->firstname;   
                            $rfid = $id;  
                            if($getBasicInfo->account_type==4):
                                $user_id = $user_id; 
                             else:
                                 $user_id = $getBasicInfo->employee_id; 
                             endif;
                     endif;
                   
                else://l
                    
                    //check if status is time_in; save as  time Out
                    if($row->status)
                    {   
                        if(date('Gi')>=1200 && date('Gi')<=1230) // time is PM
                        {
                           if($row->time_out==""):
                                if($getBasicInfo->account_type!=5){
                                    $this->saveTimeLog(0, $id);
                                }
                                $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                           else:
                               if($row->time_out_pm!=""){ //if already has time out in the database
                                 if($getBasicInfo->account_type!=5){
                                          $this->saveTimeLog(0, $id);
                                    }
                                    $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                 }else{
                                     $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                     $this->saveTimeLog(0, $id);      
                                 }

                           endif;

                        }else{// time is AM

                            $this->saveTimeLog(0, $id);

                            $this->updateTimeAttendance($user_id, 'time_out', date('Gi'), 0);
                        }

                     $check_in = FALSE;   
                    }else{
                            //check if AM or PM
                            if(date('Gi')>=1200) //this is PM
                            {
                                if($row->time_in_pm!=""){
                                    if($getBasicInfo->account_type!=5){
                                        $this->saveTimeLog(1, $id);
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', $row->time_in_pm, 1);
                                        $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', "", 1);
                                    }else{
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                    }
                                }else{
                                    $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                    $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                }
                            }else{
                                if($getBasicInfo->account_type!=5){
                                   $this->saveTimeLog(1, $id); 
                                   $this->updateTimeAttendance($user_id, 'time_in', $row->time_in, 1);
                                   $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                }else{
                                     $this->updateTimeAttendance($user_id, 'time_in', date('Gi'), 1);
                                }
                            }
                            $check_in = TRUE;
                        }
                        
                        $avatar = base_url().'uploads/'.$getBasicInfo->avatar;
                        $lastname = $getBasicInfo->lastname;   
                        $firstname = $getBasicInfo->firstname;   
                        $rfid = $id;  
                        if($getBasicInfo->account_type==4):
                            $user_id = $user_id; 
                         else:
                             $user_id = $getBasicInfo->employee_id; 
                         endif;

                endif; 
                  
                  
                
            }
            
            
            if($getBasicInfo->account_type==5){
           
                if($check_in){
                    $stat = 'in School';
                }else{
                    $stat = 'out of School';
                }
                
                $father = Modules::run('registrar/getFather', $getBasicInfo->parent_id);
                $mother = Modules::run('registrar/getMother', $getBasicInfo->parent_id);
                
                if($father->cd_mobile!=""){
                    $subtract = substr($father->cd_mobile, 0,2);
                    if($subtract=='09' || $subtract=="+63"){
                        $number = $father->cd_mobile;
                        $send = TRUE;
                    }else{
                        $number = '';
                        $send = FALSE;
                    }
                }
                else if($mother->cd_mobile!=""){
                    $subtract = substr($mother->cd_mobile, 0,2);
                    if($subtract=='09' || $subtract=="+63"){
                        $number = $mother->cd_mobile;
                        $send = TRUE;
                    }else{
                        $number = '';
                        $send = FALSE;
                    }
                }
                else{
                    $number = '';
                    $send = FALSE;
                }
                
                $textMsg = 'Your Student '.$firstname.' '.$lastname.' is already '.$stat.' at '.date('H:i:s a');
                
                Modules::run('notification_system/attendance_notification', date('H:i:s a'), $getBasicInfo->parent_id, $firstname.' '.$lastname, $stat );
                
                
                
            }

            if($getBasicInfo->account_type!=5 || $getBasicInfo->account_type!=4){
                $check_out = $getBasicInfo->position;
                if($check_in){
                    $stat = 'in School';
                }else{
                    $stat = 'out of School';
                }
                if(date('Gi')>'800')
                {
                    Modules::run('notification_system/dtr_notification', date('H:i:s a'), $firstname.' '.$lastname, $stat, $getBasicInfo->account_type );
                }
            }else{
                $check_out='';
            }
            
        }else{
            $status = FALSE;
            $msg = 'WARNING: Sorry, Your Id is not Registered!';
            $check_in = '';
            $check_out = ''; 
            $lastname = '';   
            $firstname = '';   
            $rfid = '';
            $user_id = "";
            $textMsg = "";
            $send = "";
            $number = "";
        }
        
        //$this->attendance_model->logTime($id, $status);
        //$view = $this->load->view('scanResult', $data);
        
        echo json_encode(array(
                        'check_in'      => $check_in,
                        'check_out'     => $check_out,
                        'lastname'      => $lastname,
                        'firstname'     => $firstname,
                        'id'            => $user_id,
                        'rfid'          => $rfid,
                        'status'        => $status,
                        'msg'           => $msg,
                        'avatar'        => $avatar,
                        'textmsg'       => $textMsg,
                        'send'          => $send,
                        'contact'       => $number
                        )
                        );

    }
    
        
    function getSnap()
    {
        $id=  $this->input->post('id');
        $user_id = $this->input->post('user_id');
        //$binary_data = base64_decode($id);
        $img = str_replace('data:image/jpeg;base64,', '', $id);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $result = file_put_contents( APPPATH.'hr/'.time().'.jpg', $data );
        if (!$result) die("Could not save image!  Check file permissions.");
    }
    
    
    
    function saveTimeLog($status, $rfid)
    {
        $data = array(
            'rfid'      => $rfid,
            'time'      => date('Gi'),
            'in_out'    => $status,
            'date'      => date("Y-m-d")
        );
        
        $this->attendance_model->saveTimeLog($data);
        return;
    }
    
    function updateTimeAttendance($rfid, $column, $value, $status, $date = NULL)
    {
        if($date==NULL):
            $date = date("Y-m-d");
        endif;
        if($value!=""):
            $details = array(
                $column     => $value,
                'timestamp' => date("Y-m-d").' '.date('H:i:s'),
                'status'    => $status
            );
        else:
            $details = array(
                'timestamp' => date("Y-m-d").' '.date('H:i:s'),
                'status'    => $status
            );
            
        endif;
        
        $id = $this->attendance_model->updateTimeAttendance($details, $rfid, $date);
        
        Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $id->att_id, 'update', 3);
    }
    
    function saveTimeAttendance($id,$status, $column, $c_value, $date, $st_id=NULL)
    {
            if($st_id==NULL):
                $st_id = '';
            endif;
            $data = array(
                'att_st_id'     => $st_id,
                'u_rfid'        => $id,
                 $column        => $c_value,
                'timestamp'     => date("Y-m-d").' '.date('H:i:s'),
                'date'          => $date,
                'status'        => $status
            );
            $id = $this->attendance_model->saveTimeAttendance($data, $id, $date);
            Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $id, 'create', 3);
            return $id;
    }
    
    function saveAttendanceManually()
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        $date = $this->input->post('date');
        
        if($st_id!=0):
            $result = $this->attendance_model->attendanceCheck($st_id, $date);

            if(date('Gi')>'1200'):
               $ampm = 'time_in_pm';
               $time = '1300';
            else:
               $ampm = 'time_in';
               $time = '800';
            endif;


            if($result->num_rows()==0){

                $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $st_id);
            }else{
                $this->updateTimeAttendance($rfid, $ampm, $time, 0);

            }

            $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
            
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel',NULL, $section_id, NULL, 1);
            foreach ($students->result() as $s):
                $rfid = $s->rfid;
                $result = $this->attendance_model->attendanceCheck($s->uid, $date);

                if(date('Gi')>'1200'):
                   $ampm = 'time_in_pm';
                   $time = '1300';
                else:
                   $ampm = 'time_in';
                   $time = '800';
                endif;


                if($result->num_rows()==0){

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $s->uid);
                }else{
                    $this->updateTimeAttendance($s->uid, $ampm, $time, 0);

                }
               if($rfid==""):
                    $this->getAttendance($section_id, NULL, $rfid);
               else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
               endif;
            endforeach;
        endif;
    }
            
    function saveAttendance($date=NULL)
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        if($st_id!=0):
            if($date==NULL):
                $date = $this->input->post('date');
           endif;
           if($this->session->userdata('attend_auto')):
               $result = $this->attendance_model->attendanceCheck($st_id, $date);

               if(date('Gi')>'1200'):
                   $ampm = 'time_in_pm';
                   $time = '1300';
               else:
                   $ampm = 'time_in';
                   $time = '800';
               endif;


                if($result->num_rows()==0){

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $st_id);
                }else{
                    $this->updateTimeAttendance($rfid, $ampm, $time, 0);

                }
                
                if($rfid==""):
                   $this->getAttendance($section_id, NULL, $rfid);
                else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
                endif;
           else:
               $result = $this->attendance_model->manualAttendanceCheck($st_id, $date);   

               if(date('Gi')>'1200')
                    {
                        $ampm = 'pm';
                    }else{
                        $ampm = 'am';
                    }

                 $attendance = array(
                        'st_id' => $st_id,
                         $ampm => 1,
                        'date' => $date
                    );   

                if($result->num_rows()==0){

                   $this->attendance_model->saveManualAttendance($attendance);
                }else{
                   $this->attendance_model->updateManualAttendance($attendance, $st_id, $date);

                }
                $this->getPresent($section_id, $this->session->userdata('attend_auto'));
           endif;
           
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel',NULL, $section_id, NULL, 1);
            foreach ($students->result() as $s):
                if($date==NULL):
                    $date = $this->input->post('date');
               endif;
               
               if($this->session->userdata('attend_auto')):
                       $rfid = $s->rfid;
                   $result = $this->attendance_model->attendanceCheck($rfid, $date);

                   if(date('Gi')>'1200'):
                       $ampm = 'time_in_pm';
                       $time = '1300';
                   else:
                       $ampm = 'time_in';
                       $time = '800';
                   endif;


                    if($result->num_rows()==0){

                        $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $s->uid);
                    }else{
                        $this->updateTimeAttendance($rfid, $ampm, $time, 0);

                    }
               else:
                   $result = $this->attendance_model->manualAttendanceCheck($s->uid, $date);   

                   if(date('Gi')>'1200')
                        {
                            $ampm = 'pm';
                        }else{
                            $ampm = 'am';
                        }

                     $attendance = array(
                            'st_id' => $s->uid,
                             $ampm => 1,
                            'date' => $date
                        );   

                    if($result->num_rows()==0){

                       $this->attendance_model->saveManualAttendance($attendance);
                    }else{
                       $this->attendance_model->updateManualAttendance($attendance, $st_id, $date);

                    }
               endif;
               if($rfid==""):
                    $this->getAttendance($section_id, NULL, $rfid);
               else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
               endif;
            endforeach;
            
        endif;
        

    }
    
    function getPresent($section_id=Null, $attend_auto=NULL, $date=NULL)
    {   
        
        $data['records'] = $this->getAttendance($section_id, $date);
        if(Modules::run('main/isMobile'))
        {
           $this->load->view('mobile/presents', $data);
            
        }else{
            $this->load->view('presents', $data);
        }
    }
    
    function parentsList()
    {
        $data['option']='individual';
        $data['students'] = Modules::run('registrar/getAllStudentsInNormalView');
        $data['modules'] = 'attendance';
        $data['main_content'] = 'parentsList';
        echo Modules::run('templates/main_content', $data);
    }
    
    function current($option=NULL, $st_id=NULL)
    {  
        $data['option']=$option;
        $data['st_id']=$st_id;
        
        $this->load->view('default', $data);
    }
    
    function getRawMonthlyAttendanceDetails($id, $month, $year)
    {
        $attendance = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year);
        return $attendance;
    }
    
    function getMonthlyAttendanceDetails($st_id, $month, $year)
    {
        $attendance['dailyAttendance'] = $this->getRawMonthlyAttendanceDetails($st_id, $month, $year);
        $this->load->view('dailyAttendanceDetails'. $attendance);
    }
    function monthly($option, $id=null, $month=null, $year=NULL, $sy=NULL)
    {
        $id = base64_decode($id);
        if($month==NULL){
            $month = date('m');
        }
        if($month<10):
            $month = $month;
        endif;
        //echo $month;
        
        if($this->session->userdata('attend_auto')):
           $auto = TRUE;
           switch ($option)
            {
                case 'individual':
                    $data['attendance'] = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year,$sy);
                break;
            } 
           $this->load->view('daily', $data);
        else:
           $auto = FALSE;
           switch ($option)
            {
                case 'individual':
                    $data['attendance'] = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year, $sy);
                break;
            } 
           $this->load->view('daily_manual', $data); 
        endif;
        
    }
    
    public function dailyPerSubject($subject_id=null, $section_id=null)
    {
         $user_id = $this->session->userdata('user_id');
         if(!$this->session->userdata('is_admin')):
            if($section_id==NULL):
                  $section_id = $this->session->userdata('advisory');

            endif;
         endif;       
         $data['section_id'] = $section_id;
         $data['getPosition'] = Modules::run('hr/getSpecificAdvisory', $user_id, '');
         $data['subject'] = Modules::run('main/getSpecificSubjects', $subject_id);
         $data['records'] = $this->getAttendance($section_id);  
         $data['remarksCategory'] = Modules::run('main/getRemarksCategory');
         $data['section_id'] = $section_id;
         
         if(Modules::run('main/isMobile'))
        {
           if(!$this->session->userdata('is_logged_in')){
               echo Modules::run('mobile/index');
           }else{
                $data['modules'] = "attendance";
                $data['main_content'] = 'mobile/manualChecking';
                echo Modules::run('mobile/main_content', $data);
           }
            
        }else{
            $data['modules'] = 'attendance';
            if($this->session->userdata('is_admin')):
                $data['section'] = Modules::run('registrar/getAllSection');
            endif;
            $data['main_content'] = 'manualChecking';
            echo Modules::run('templates/main_content', $data);
        }
    }
    
    public function getAttendance($section_id=null, $date=NULL)
    {
        $attendance = $this->attendance_model->getAttendanceAutoManual($section_id, $date);
        return $attendance;
    }
    
    public function getManualAttendance($section_id=null)
    {
        $attendance = $this->attendance_model->getManualAttendance($section_id);
        return $attendance;
    }
    
    public function getAbsents($section_id=null, $attend_auto=null, $date=NULL )
    {
        $data['absents'] = $this->attendance_model->getAbsents($section_id, $attend_auto, $date);
        
        if(Modules::run('main/isMobile'))
        {
           $this->load->view('mobile/absents', $data);
            
        }else{
            $this->load->view('absents', $data);
        }
    }
    
    public function getAbsentByDate($section_id, $date, $gender)
    {
        $date = str_replace('-', '/', $date);
        if($this->session->userdata('attend_auto')):
            $absents = $this->attendance_model->getAbsentByDatePerGender($section_id, $date, TRUE, $gender);
        else:
            $absents = $this->attendance_model->getAbsentByDatePerGender($section_id, $date, FALSE, $gender);
        endif;
        
        return $absents->num_rows();
    }
    
    public function ifPresent($st_id, $day=NULL, $month=NULL, $year=NULL, $attend_auto = NULL, $sy = NULL)
    {
        if($attend_auto==NULL):
            $attend_auto = $this->session->userdata('attend_auto');
        endif;
        if($attend_auto):
            $result = $this->attendance_model->ifPresent($st_id, $day, $month, $year, $sy);
        else:
            $result = $this->attendance_model->ifPresentManual($st_id, $day, $month, $year, $sy);
        endif;
        //echo $result;
        return $result;
        
    }
    
    public function getDailyTotalByGender($date, $section, $gender=NULL)
    {
        if($this->session->userdata('attend_auto')):
            $attendance = $this->attendance_model->getDailyTotalByGender($date, $section, $gender);
        else:
            $attendance = $this->attendance_model->getDailyTotalByGenderManual($date, $section, $gender);
        endif;
        echo $attendance;
        //return $attendance;
    }
    
    public function searchAttendance()
    {
        $date = $this->input->post('date');
        $section_id = $this->input->post('section_id');
//        if($this->session->userdata('attend_auto')):
//            $data['present'] = $this->attendance_model->getPresentByDate($section_id, $date);
//            $data['absents'] = $this->attendance_model->getAbsentByDate($section_id, $date, TRUE);
//        else:
//            $data['present'] = $this->attendance_model->getPresentByDateManual($section_id, $date);
//            $data['absents'] = $this->attendance_model->getAbsentByDate($section_id, $date, FALSE);
//        endif;
        $data['section_id'] = $section_id;
        $data['date'] = $date;
        if(Modules::run('main/isMobile')):
            $this->mobileSearchAttendance(base64_encode($date), $section_id);
        else:
            if($this->session->userdata('is_admin')):
                $data['section'] = Modules::run('registrar/getAllSection');
                $this->load->view('searchAttendanceForAdmin', $data);
            else:
                $this->load->view('searchAttendance', $data);
            endif;
        endif;
    }
    
    public function mobileSearchAttendance($date, $section_id)
    {
       $data['date'] = base64_decode($date);
       $data['section_id'] = $section_id;
       $data['present'] = $this->attendance_model->getPresentByDate($section_id, base64_decode($date));
       
       $this->load->view('mobile/searchPresentAttendance', $data);
    }
    
    function saveSearchAttendance()
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        $date = $this->input->post('date');
        
        if($st_id!=0):
            $result = $this->attendance_model->attendanceCheck($st_id, $date);

            if(date('Gi')>'1200'):
               $ampm = 'time_in_pm';
               $time = '1300';
            else:
               $ampm = 'time_in';
               $time = '800';
            endif;


            if($result->num_rows()==0){

                $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $st_id);
            }else{
                $this->updateTimeAttendance($rfid, $ampm, $time, 0);

            }

            $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
            
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel',NULL, $section_id, NULL, 1);
            foreach ($students->result() as $s):
                $rfid = $s->rfid;
                $result = $this->attendance_model->attendanceCheck($s->uid, $date);

                if(date('Gi')>'1200'):
                   $ampm = 'time_in_pm';
                   $time = '1300';
                else:
                   $ampm = 'time_in';
                   $time = '800';
                endif;


                if($result->num_rows()==0){

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time,$date, $s->uid);
                }else{
                    $this->updateTimeAttendance($s->uid, $ampm, $time, 0);

                }
               if($rfid==""):
                    $this->getAttendance($section_id, NULL, $rfid);
               else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
               endif;
            endforeach;
        endif;
    }
    
    function saveAttendanceRemark()
    {
        $st_id = $this->input->post('st_id');
        $date = $this->input->post('date');
        $remarks = $this->input->post('remark');
        $remark_from = $this->input->post('remark_from');
        $section_id = $this->input->post('section_id');
        
        $updateArray = array(
               'remarks' => $remarks, 
               'remarks_from' => $remark_from, 
        );
        
        if($date!=""):
            if($this->session->userdata('attend_auto')):
                $this->attendance_model->addAttendanceRemark($updateArray, $st_id, $date);
                $data['records'] = $this->attendance_model->getPresentByDate($section_id, $date);
                $attendanceCheck = $this->attendance_model->attendanceCheck($st_id, $date);
                $this->load->view('presents', $data);
            else:
                $this->attendance_model->addAttendanceRemarkManual($updateArray, $st_id, $date);
                $data['records'] = $this->attendance_model->getPresentByDateManual($section_id, $date);
                $attendanceCheck = $this->attendance_model->manualAttendanceCheck($st_id, $date);
                $this->load->view('presents', $data);
            endif;
            
        else:
            if($this->session->userdata('attend_auto')):
                $this->attendance_model->addAttendanceRemark($updateArray, $st_id, date('Y-m-d'));
                $data['records'] = $this->attendance_model->getPresentByDate($section_id, date('Y-m-d'));
                $attendanceCheck = $this->attendance_model->attendanceCheck($st_id, date('Y-m-d'));
            $this->load->view('presents', $data);
            else:
                $this->attendance_model->addAttendanceRemarkManual($updateArray, $st_id, date('Y-m-d'));
                $data['records'] = $this->attendance_model->getPresentByDateManual($section_id, date('Y-m-d'));
                $attendanceCheck = $this->attendance_model->manualAttendanceCheck($st_id, date('Y-m-d'));
                $this->load->view('presents', $data);
            endif;
            
        endif;
        
       // Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $attendanceCheck->row()->att_id, 'update');
                
        
    }
    
    function getAttendanceRemark($st_id, $date)
    {
        if($this->session->userdata('attend_auto')):
            $attendanceRemark = $this->attendance_model->getAttendanceRemark($st_id, $date);
        else:
            $attendanceRemark = $this->attendance_model->getAttendanceRemarkManual($st_id, $date);
        endif;
        //echo $attendanceRemark->row()->remarks;
        return $attendanceRemark;
    }
    
    function getTardy($st_id, $month, $year=NULL)
    {
        if($this->session->userdata('attend_auto')):
            $attendanceRemark = $this->attendance_model->getTardy($st_id, $month, $year);
        else:
            $attendanceRemark = $this->attendance_model->getTardyManual($st_id, $month, $year);
        endif;
        
        return $attendanceRemark;
    }
    
    function deleteAttendance()
    {
        $att_id = $this->input->post('att_id');
        $section_id = $this->input->post('section_id');
        if($this->session->userdata('attend_auto')):
            $this->attendance_model->deleteAttendance($att_id);
        else:
            $this->attendance_model->deleteAttendanceManual($att_id);
        endif;
        
       // echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto')) ;
        Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $att_id, 'delete', 3);
        
    }
    
    function saveMonthlyAttendanceSummary($month=NULL, $section_id = NULL, $maleTotal=NULL, $femaleTotal=NULL, $maleAve=NULL, $femaleAve=NULL, $percentMale=NULL, $percentFemale=NULL, $attend_auto=NULL)
    {
        $summaryExist = $this->attendance_model->checkMonthlyAttendanceSummary($month, $section_id);
        
        if($summaryExist):
            $data = array(
                'male_total'    => $maleTotal,
                'female_total'  => $femaleTotal,
                'ave_male_total'    => $maleAve,
                'ave_female_total'  => $femaleAve,
                'percent_male'  => $percentMale,
                'percent_female'  => $percentFemale
            );
        
            $this->attendance_model->updateMonthlyAttendanceSummary($month, $section_id, $data, $attend_auto);
        else:
            $data = array(
                'section_id'    => $section_id,
                'male_total'    => $maleTotal,
                'female_total'  => $femaleTotal,
                'ave_male_total'    => $maleAve,
                'ave_female_total'  => $femaleAve,
                'percent_male'  => $percentMale,
                'percent_female'  => $percentFemale,
                'month'         => $month,
                'attend_auto'   => $attend_auto 
            ); 
            
            $this->attendance_model->saveMonthlyAttendanceSummary($data);
        endif;
    }
    
    function getMonthlyAttendanceSummary($month=Null, $section_id=Null, $attend_auto=NULL, $school_year = NULL)
    {
        $summary = $this->attendance_model->getMonthlyAttendanceSummary($month, $section_id, $attend_auto, $school_year);
        return $summary;
       // print_r($summary);
        //echo 'hey';
    }
    
    function getMonthlyAttendanceSummaryPerLevel($month=Null, $grade_id=Null, $attend_auto)
    {
        $summary = $this->attendance_model->getMonthlyAttendanceSummaryPerLevel($month, $grade_id, $attend_auto);
        return $summary;
    }
    
    function getMonthlyStatus($month=Null, $grade_id=Null,$code_id)
    {
        $summary = $this->attendance_model->getMonthlyStatus($month, $grade_id, $code_id);
        return $summary->num_rows();
    }
    
    function getIndividualMonthlyAttendance($st_id, $month, $year=NULL, $school_year = NULL)
    {
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'last');
        
        for($x=$firstDay;$x<=$lastDay;$x++){
        $day = date('D', strtotime($year.'-'.$month.'-'.$x));

        if($day=='Sat'||$day=='Sun')
        {

        }else{
            if($x<10):
                    $day = "0".$x;
                else:
                    $day = $x;
                endif;
                
            //echo $day.' ';
            $ifPresent = $this->ifPresent($st_id, $day, $month, $year, $this->session->userdata('attend_auto'), $school_year);
            
            if($ifPresent):
                $present += 1;
            endif;
            
        }
        
      }
      //echo '<br />'.$year;
      return $present;
    }
        
}

