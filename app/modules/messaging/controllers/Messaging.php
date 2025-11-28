<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class messaging extends MX_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('messaging_model');
        date_default_timezone_set("Asia/Manila");
    }
    public function index()
    {

        if (!$this->session->has_userdata('is_logged_in') || !$this->session->is_logged_in) {
            header('Location: ' . base_url());
            exit;
        }

        if ($this->session->is_admin):
            $data['text'] = $this->messaging_model->getSMSList(NULL, 2);
            $data['main_content'] = 'default';
            $data['modules'] = 'messaging';
            echo Modules::run('templates/main_content', $data);
        else:
            redirect(base_url());
        endif;
    }

    private function post($value)
    {
        return $this->input->post($value);
    }

    // ======= ads =============

    function ads()
    {
        $data['ads'] = $this->messaging_model->fetch_ads();
        $data['main_content'] = 'ad_dashboard';
        $data['modules'] = 'messaging';
        echo Modules::run('templates/main_content', $data);
    }

    function uploadfiles()
    {
        $data['error'] = ''; //initialize image upload error array to empty
        $pathname = 'images/ads';
        if (!is_dir($pathname)) {
            mkdir($pathname, 0777, TRUE);
        }

        $config['upload_path'] = $pathname;
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = 'mp4|mov|jpg|png|JPEG|gif';
        $config['max_size'] = '15000';
        $config['cookie_secure'] = true;

        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload('userfile')) {
            $data['error'] = $this->upload->display_errors();
            // print_r($data);
            $data['message'] = "<h4>Click <a href='" . base_url('messaging/ads') . "'> HERE </a> to return to ads page.</h4>";
            print_r('<b>ERROR:</b>' . $data['error'] . '' . $data['message']);
            //$this->load->view('csvindex', $data);
        } else {

            $file_data = $this->upload->data();
            if (preg_match('/^.*\.(mp4|mov)$/i', $file_data['file_name'])) {
                $aformat = '1';
            } elseif (preg_match('/^.*\.(jpg|png|gif)$/i', $file_data['file_name'])) {
                $aformat = '2';
            }
            $file_path = $pathname . '/' . $file_data['file_name'];
            $ads = array(
                'ad_id'         => $this->eskwela->code(),
                'ad_file'       => $file_data['file_name'],
                'ad_format'     => $aformat,
                'ad_duration'   => 10,
                'ad_active'     => 1,
                'ad_date'       => date('Y-m-d'),
            );
            $check = $this->messaging_model->save_ads($ads);
            if ($check) {
                $message = "Yey! Upload Successful!!!";
                echo "<script type='text/javascript'>
                alert('$message');
                document.location = '" . base_url() . "messaging/ads';
                </script>";
            }
        }
    }

    function ad_status()
    {
        $astatus = $this->input->post('astatus');
        $ad_id = $this->input->post('ad_id');
        $aid = substr($ad_id, 1);
        $ad = array('ad_active' => $astatus,);
        $this->messaging_model->update_ads($aid, $ad);
    }

    function delete_ads($id)
    {
        $q = $this->messaging_model->delete_ads($id);
        if ($q) {
            echo json_encode(array('status' => true, 'msg' => 'Ads Deleted Successfuly'));
        } else {
            echo json_encode(array('status' => false, 'msg' => 'Something went wrong!'));
        }
    }

    // ======= ads end =============

    // private function itexmo($number,$message,$apicode, $apipass)
    // {
    //     $url = 'https://www.itexmo.com/php_api/api.php';
    //     $itexmo = array('1' => $number, '2' => $message, '3' => $apicode , 'passwd' => $apipass);
    //     $param = array(
    //         'http' => array(
    //             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //             'method'  => 'POST',
    //             'content' => http_build_query($itexmo),
    //         ),
    //     );
    //     $context  = stream_context_create($param);
    //     return file_get_contents($url, false, $context);

    // }

    function itexmo($number, $message, $apicode, $apipass)
    {
        $settings = Modules::run('main/getSet');
        $endpoint = 'https://api.itexmo.com/api/broadcast';
        $email = $settings->api_email; // Client email
        $password = $settings->api_pass; // Client password
        $apicode = $settings->apicode;

        try {
            $ch = curl_init();
            $itexmo = array(
                'Email' => $email,
                'Password' => $password,
                'ApiCode' => $apicode,
                'Recipients' => $number,
                'Message' => $message
            );

            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            return $response;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function queText()
    {
        $settings = $this->eskwela->getSet();
        $option = $this->post('txtOption');
        $cat = $this->post('txtCat');
        $msg = strtoupper($settings->short_name) . ' SMS : ' . $this->post('txtMsg');
        switch ($option):
            case '0':
                $number = $this->post('number');
                if ($this->saveText($cat, $msg, $number)):
                    echo json_encode(array('status' => TRUE, 'msg' => 'Text Message sent to Message Que'));
                endif;
                break;
            case '1':
                $students = $this->messaging_model->getStudents();
                $i = 0;
                foreach ($students->result() as $st):
                    $number = $st->ice_contact;

                    if ($number != ""):
                        $subtract = substr($number, 0, 2);
                        if ($subtract == '09' || $subtract == "+63"):
                            if ($this->saveText($cat, $msg, $number)):
                                $i++;
                            endif;
                        endif;
                    endif;
                endforeach;

                //echo $i;
                echo json_encode(array('status' => TRUE, 'msg' => $number . ' Text Messages was sent to Message Que'));
                break;
        endswitch;
    }

    function allowedToScan($section_id)
    {
        $result = $this->messaging_model->checkScanTime($section_id);
        if ($result):
            if ((date('Gi') > 1200)):
                //this is pm
                if (strtotime(date('Y-m-d G:i:s')) > strtotime($result->time_out_pm) && date('Y-m-d G:i:s') != '0000-00-00 00:00:00'):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            else:
                if (strtotime(date('Y-m-d G:i:s')) > strtotime($result->time_out) && date('Y-m-d G:i:s') != '0000-00-00 00:00:00'):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            endif;
        endif;
    }

    private function hasTextCredit($st_id)
    {
        $result = $this->messaging_model->hasTextCredit($st_id);
        return $result;
    }

    public function saveText($sms_cat, $txtMsg, $number, $user_id = NULL)
    {
        if ($sms_cat == 1):
            $hasTextCredit = $this->hasTextCredit($user_id);
            if ($hasTextCredit):
                $save = TRUE;
            else:
                $save = FALSE;
            endif;
        else:
            $save = TRUE;
        endif;

        $smsDetails = array(
            'sms_id'        => $this->eskwela->code(),
            'sms_cat'       => $sms_cat,
            'sms_datetime'  => date('Y-m-d G:i:s'),
            'sms_message'   => $txtMsg,
            'sms_status'    => 0,
            'sms_number'    => $number,
            'sms_user_id'   => $user_id
        );
        if ($save):
            if ($this->messaging_model->saveText($smsDetails)):
                return TRUE;
            endif;
        endif;
    }

    public function sendText()
    {
        $number = [$this->post('number')];
        $message = $this->post('message');
        $smsID = $this->post('smsID');
        $smsUserID = $this->post('smsUserID');
        $smsCat = $this->post('smsCat');
        $api =  $this->messaging_model->apicode();
        $apicode = $api->apicode;
        $apipass = $api->api_pass;

        $result = $this->itexmo($number, $message, $apicode, $apipass);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $result = $msg;
            if ($smsCat == 1):
                $this->messaging_model->saveSMSCount($smsUserID);
            endif;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $result = $msg;
        }
        $this->logtext($smsID, $stat, $msg);
        echo json_encode(array('number' => $number, 'msg' => $msg));
    }

    function saveSMSCount($id)
    {
        $this->messaging->saveSMSCount($id);
    }

    function scanToSend($num, $msg, $id)
    {
        $api =  $this->messaging_model->apicode();
        $apicode = $api->apicode;
        $apipass = $api->api_pass;
        $sms = $this->messaging_model->getSMSByID($id);
        if ($sms->sms_status == 0):
            $result = $this->itexmo([$num], $msg, $apicode, $apipass);
            if ($result == 0) {
                $this->logtext($sms->sms_id, 1, 'Message sent');
            }
        endif;
    }

    function logtext($log_id, $stat, $msg)
    {
        $data = array(
            'sms_datetime'  => date('Y-m-d G:i:s'),
            'sms_status'    => $stat,
            'sms_remarks'   => $msg,
        );
        $result = $this->messaging_model->logtext($data, $log_id);
        return $data;
    }

    public function send_text($s_log_id, $s_name, $s_number, $s_status, $s_time, $datenow)
    {
        $dtime =  date("g:i a", strtotime("0" . $s_time));
        $message = "Hi! Your student, " . $s_name . ", " . $s_status . " the campus at " . $s_time . " " . $datenow;
        $code = $this->messaging_model->shortcode();
        $scode = strtoupper($code->short_name);
        $text = $scode . ": " . $message;
        // $apicode = "ST-CYRUS361616_M5YQD"; // May 19, 2018 - June 19, 2018
        $api = $this->message_model->apicode();
        $apicode = $api->apicode;

        $result = $this->itexmo($s_number, $text, $apicode);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $this->logtext($s_log_id, $msg, $stat, $s_number);
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $this->logtext($s_log_id, $msg, $stat, $s_number);
            $result = $msg;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $this->logtext($s_log_id, $msg, $stat, $s_number);
            $result = $msg;
        }
        return $result;
    }


    function testText()
    {
        $result = $this->itexmo("09989803926", "Welcome to BRIGHT ROCK SCHOOL Messaging system %0a. Do not reply to this number", "DE-CSSCO803926_E1K8C");
        if ($result == "") {
            echo "iTexMo: No response from server!!!
            Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
            Please CONTACT US for help. ";
        } else if ($result == 0) {
            echo "Message Sent!";
        } else {
            echo "Error Num " . $result . " was encountered!";
        }
    }

    public function sending()
    {
        $point = $this->uri->segment(3);
        $p_id = substr($point, 1);
        $lid = "p" . $p_id;
        $log_id = $this->input->post($lid);
        $trfid = $this->input->post($point);
        $profile = $this->messaging_model->lookup($trfid);
        $loginfo = $this->messaging_model->texttest($log_id);
        $s_name = $profile->firstname . ' ' . $profile->lastname;
        $s_number = $profile->ice_contact;
        $tstat = $loginfo->in_out;
        if ($tstat == 0) {
            $iostat = "has LOGGED OUT of";
        } elseif ($tstat == 1) {
            $iostat = "has LOGGED IN at";
        }
        $atimehr = substr($loginfo->time, 0, 2);
        if ($atimehr > 12) {
            $hr = $atimehr - 12;
            $ap = "pm";
        } else {
            $hr = $atimehr;
            if ($hr == 00) {
                $hr = 12;
            }
            $ap = "am";
        }

        $min = substr($loginfo->time, 2, 2);
        $s_time = $hr . ":" . $min . " " . $ap;
        $s_date = $loginfo->date;
        $tresult = $this->send_text($log_id, $s_name, $s_number, $iostat, $s_time, $s_date);
        echo json_encode(
            array(
                'rfid' => $trfid,
                'time' => date('H:i a'),
                'iostat' => $iostat,
                'rname' => $s_name,
                'time'  => $s_time,
                'rmsg'  => $tresult,
            )
        );
    }

    public function sendsms()
    {
        $api =  $this->messaging_model->apicode();
        $data['api'] = $api->apicode;
        $data['api_pass'] = $api->api_pass;
        $data['text'] = $this->getSMSList('0');
        $this->load->view('send_sms', $data);
    }

    function getSMSList($status = NULL, $cat = NULL)
    {
        return $this->messaging_model->getSMSList($status, $cat);
    }

    function toSendList()
    {
        echo json_encode($this->getSMSList('0'));
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
        if ($this->input->post('status') == 1):
            $no_publish = $this->getAnnouncement(1);
            if ($no_publish->num_rows() > 4):
                echo json_encode(array('status' => false, 'msg' => 'Sorry, You are only allowed to post 4 announcements per day, unpublish an old post before you can add a new one'));
            else:
                echo json_encode(array('status' => TRUE, 'msg' => ('Successfully Added')));
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
        foreach ($item as $i) {
            $sendResult = $this->messaging_model->saveMessage($i, $sendFrom, $message, $parentMsgId);
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

        foreach ($myMessages['result'] as $msg) {

            if ($msg->avatar == '' || $msg->avatar == NULL || $msg->avatar = 'noImage.jpg') {
                $avatar = 'noImage.png';
            } else {
                $avatar = $msg->avatar;
            }
?>

            <div style="padding:8px; cursor:pointer; border-bottom:1px #B2B2B2 solid; float:left; width:94%;">
                <img style="margin:0" class="span1" src="<?php echo base_url() . APPPATH; ?>uploads/<?php echo $avatar ?>" />
                <div style="margin-left:10px;" class="pull-left">
                    <h6 style="vertical-align:center;"><?php echo $msg->firstname . ' ' . $msg->lastname; ?></h6>
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


        foreach ($individualMessages['sent'] as $inMsg) {
            if ($inMsg->avatar == '' || $inMsg->avatar == NULL || $inMsg->avatar = 'noImage.jpg') {
                $avatar = 'noImage.png';
            } else {
                $avatar = $inMsg->avatar;
            }
            $msgSenderId = $individualMessages['reply'];
            $date = $inMsg->timestamp;
            $fDate = explode(' ', $date);
            if ($fDate[0] == $now) {
            ?>
                <div style="float:left; width:100%;">
                    <h6>TODAY <?php echo $fDate[1]; ?></h6>
                    <img class="pull-left" style="padding:2px; margin:0; width: 30px; height:30px;" src="<?php echo base_url() . APPPATH; ?>uploads/<?php echo $avatar ?>" />
                    <div style="margin-left:10px;" class="pull-left">
                        <h6 style="margin:0; vertical-align:center;"><?php echo $inMsg->firstname . ' ' . $inMsg->lastname; ?></h6>
                        <p><?php echo $inMsg->msg_content ?></p>
                    </div>
                </div>
            <?php
            } elseif ($fDate[0] < $now) {
            ?>
                <div style="float:left; width:100%;">
                    <h6><?php echo $date ?></h6>
                    <img class="pull-left" style="padding:2px; margin:0; width: 30px; height:30px;" src="<?php echo base_url() . APPPATH; ?>uploads/<?php echo $avatar ?>" />
                    <div style="margin-left:10px;" class="pull-left">
                        <h6 style="margin:0; vertical-align:center;"><?php echo $inMsg->firstname . ' ' . $inMsg->lastname; ?></h6>
                        <p><?php echo $inMsg->msg_content ?></p>
                    </div>
                </div>

            <?php

            }
        }
    }

    public function standalone()
    {
        $raw_att = $this->messaging_model->fetch_unrecorded_spr();
        $count = 0;
        print_r('<h3>Running SPR Bot... Please do not close the browser.</h3><br />');
        foreach ($raw_att as $ur) {
            $count++;
            $st_id = $ur->st_id;
            $att_id = $ur->att_id;
            $sdate = $ur->date;
            $sec_id = $ur->sect_id;
            $time_in = 0;
            $time_in_am = $ur->as_time_in;
            $time_in_pm = $ur->as_time_in_pm;
            if ($time_in_am != "") {
                $time_in = $time_in_am;
            } elseif ($time_in_pm != "") {
                $time_in = $time_in_pm;
            }
            $timehr = substr($time_in, 0, -2);
            $timemin = substr($time_in, -2);
            $time = $timehr . ":" . $timemin . ":00";
            $grade_id = $ur->grade_level_id;
            $feedback = $this->url_bot($st_id, $att_id, $sdate, $sec_id, $time, $grade_id);
            print_r('<span>' . $count . ' ' . $feedback['st_id'] . ' ' . $feedback['date'] . ' [' . $feedback['time'] . '-' . $feedback['etime'] . '] SPR:' . $feedback['spr'] . ' | ATT:' . $feedback['att'] . '</span><br />');
            if ($count == 200) {
                // $this->refresh_bot();
            ?>
                <script type="text/javascript">
                    location.reload();
                </script>
<?php
                header("Refresh:0");
            }
        }
        $this->load->view('bg_sa');
    }

    public function refresh_bot()
    {
        $this->standalone();
    }

    public function url_bot($st_id, $att_id, $sdate, $sec_id, $time_in, $grade_id)
    {
        $month = date("F", strtotime($sdate));
        $checkspr = $this->messaging_model->check_spr($st_id);
        $process_complete = false;
        $res = $checkspr->row();
        if ($checkspr->num_rows() > 0) {
            $new = false;
            $spr_id = $res->st_spr;
            switch ($month) {
                case 'June':
                    $sprmonth = $res->June;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('June' => $mvalue,);
                    break;
                case 'July':
                    $sprmonth = $res->July;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('July' => $mvalue,);
                    break;
                case 'August':
                    $sprmonth = $res->August;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('August' => $mvalue,);
                    break;
                case 'September':
                    $sprmonth = $res->September;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('September' => $mvalue,);
                    break;
                case 'October':
                    $sprmonth = $res->October;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('October' => $mvalue,);
                    break;
                case 'November':
                    $sprmonth = $res->November;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('November' => $mvalue,);
                    break;
                case 'December':
                    $sprmonth = $res->December;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('December' => $mvalue,);
                    break;
                case 'January':
                    $sprmonth = $res->January;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('January' => $mvalue,);
                    break;
                case 'February':
                    $sprmonth = $res->February;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('February' => $mvalue,);
                    break;
                case 'March':
                    $sprmonth = $res->March;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('March' => $mvalue,);
                    break;
                case 'April':
                    $sprmonth = $res->April;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('April' => $mvalue,);
                    break;
                default:
                    # code...
                    break;
            }
            $savespr = $this->messaging_model->update_spr($spr_id, $mdata);
            $process_complete = true;
            $new = false;
        } else {
            $settings = Modules::run('main/getSet');
            $sy = $settings->school_year;
            $spr_id = $this->messaging_model->save_spr_details($st_id, $sy, $grade_id);
            $sdetails = array(
                'spr_id' => $spr_id,
            );
            $gen_spr_att = $this->messaging_model->gen_spr_att($sdetails);
            $new = true;
        }
        // update sheet
        if ($process_complete == true) {
            $spr = $this->messaging_model->update_sheet($st_id, $att_id);
            $check_tardy = $this->messaging_model->check_tardy($st_id, $sdate);
            if ($check_tardy->num_rows() > 0) {
                // do nothing since the tardy has already been recorded.
                $etime_in = 'recorded';
            } else {
                // check if late
                $result = $this->messaging_model->getSection($sec_id);
                $tardy = FALSE;
                if ($result->time_in != '00:00:00') { // if am class   // record late
                    if (strtotime($time_in) > strtotime($result->time_in)) {
                        $updatetardy = array(
                            'l_st_id'       => $st_id,
                            'l_grade_id'    => $result->grade_level_id,
                            'l_date'        => $sdate,
                            'l_time_in'     => $result->time_in,
                            'l_actual_time_in' => $time_in,
                            'l_att_id'      => $att_id,
                            'l_status'      => 0,
                        );
                        $this->messaging_model->save_tardy($updatetardy);
                        $tardy = TRUE;
                    }
                    $spr_id = $res->st_spr;
                    $etime_in = $result->time_in;
                } elseif ($result->time_in_pm != '00:00:00') { // if pm class
                    if (strtotime($time_in) > strtotime($result->time_in_pm) && $time_in != '13:00:00') {
                        $updatetardy = array(
                            'l_st_id'       => $st_id,
                            'l_grade_id'    => $result->grade_level_id,
                            'l_date'        => $sdate,
                            'l_time_in'     => $result->time_in_pm,
                            'l_actual_time_in' => $time_in,
                            'l_att_id'      => $att_id,
                            'l_status'      => 0,
                        );
                        $this->messaging_model->save_tardy($updatetardy);
                        $tardy = TRUE;
                    }
                    $spr_id = $res->st_spr;
                    $etime_in = $result->time_in_pm;
                } else {
                    $spr_id = $res->st_spr;
                    $etime_in = 'No tardy time';
                }
            } // if ($check_tardy->num_rows()>0) {
        } else {  // if ($process_complete==true) {
            $etime_in = 'NEW';
        }

        $feedback = array(
            'st_id'     => $st_id,
            'time'      => $time_in,
            'etime'     => $etime_in,
            'date'      => $sdate,
            'spr'       => $spr_id,
            'att'       => $att_id,
        );
        return $feedback;

        // echo json_encode(array(
        //     'count' => $p_id, // 
        //     'st_id' => $st_id, // 
        //     'time' => $time_in, //
        //     'etime' => $etime_in,
        //     'date' => $sdate, //
        //     'tardy' => $tardy, 
        //     'spr' => $spr_id,
        //     'att' => $att_id,
        //     'new' => $new,
        //     )
        // );
    }

    public function process_bot()
    {
        $point = $this->uri->segment(3);
        $p_id = substr($point, 1);
        $pstid = "a" . $p_id; // st_id
        $pattid = "b" . $p_id; // att_id
        $pdate = "c" . $p_id; // date
        $psecid = "d" . $p_id; // section_id
        $ptimein = "e" . $p_id; // time_in
        $pgrade = "f" . $p_id; // grade_id
        $st_id = $this->input->post($pstid);
        $att_id = $this->input->post($pattid);
        $sdate = $this->input->post($pdate);
        $sec_id = $this->input->post($psecid);
        $time_in = $this->input->post($ptimein);
        $grade_id = $this->input->post($pgrade);
        $month = date("F", strtotime($sdate));
        $checkspr = $this->messaging_model->check_spr($st_id);
        $process_complete = false;
        $res = $checkspr->row();
        if ($checkspr->num_rows() > 0) {
            $new = false;
            $spr_id = $res->st_spr;
            switch ($month) {
                case 'June':
                    $sprmonth = $res->June;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('June' => $mvalue,);
                    break;
                case 'July':
                    $sprmonth = $res->July;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('July' => $mvalue,);
                    break;
                case 'August':
                    $sprmonth = $res->August;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('August' => $mvalue,);
                    break;
                case 'September':
                    $sprmonth = $res->September;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('September' => $mvalue,);
                    break;
                case 'October':
                    $sprmonth = $res->October;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('October' => $mvalue,);
                    break;
                case 'November':
                    $sprmonth = $res->November;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('November' => $mvalue,);
                    break;
                case 'December':
                    $sprmonth = $res->December;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('December' => $mvalue,);
                    break;
                case 'January':
                    $sprmonth = $res->January;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('January' => $mvalue,);
                    break;
                case 'February':
                    $sprmonth = $res->February;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('February' => $mvalue,);
                    break;
                case 'March':
                    $sprmonth = $res->March;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('March' => $mvalue,);
                    break;
                case 'April':
                    $sprmonth = $res->April;
                    $mvalue = $sprmonth + 1;
                    $mdata = array('April' => $mvalue,);
                    break;
                default:
                    # code...
                    break;
            }
            $savespr = $this->messaging_model->update_spr($spr_id, $mdata);
            $process_complete = true;
            $new = false;
        } else {
            $settings = Modules::run('main/getSet');
            $sy = $settings->school_year;
            $spr_id = $this->messaging_model->save_spr_details($st_id, $sy, $grade_id);
            $sdetails = array(
                'spr_id' => $spr_id,
            );
            $gen_spr_att = $this->messaging_model->gen_spr_att($sdetails);
            $new = true;
        }
        // update sheet
        if ($process_complete == true) {
            $spr = $this->messaging_model->update_sheet($st_id, $att_id);

            // check if late
            $result = $this->messaging_model->getSection($sec_id);
            $tardy = FALSE;
            $new = 'Existing';
            if ($result->time_in != '00:00:00') { // if am class   // record late
                if (strtotime($time_in) > strtotime($result->time_in)) {
                    $updatetardy = array(
                        'l_st_id'       => $st_id,
                        'l_grade_id'    => $result->grade_level_id,
                        'l_date'        => $sdate,
                        'l_time_in'     => $result->time_in,
                        'l_actual_time_in' => $time_in,
                        'l_att_id'      => $att_id,
                        'l_status'      => 0,
                    );
                    $this->messaging_model->save_tardy($updatetardy);
                    $tardy = TRUE;
                }
                $spr_id = $res->st_spr;
                $etime_in = $result->time_in;
            } elseif ($result->time_in_pm != '00:00:00') { // if pm class
                if (strtotime($time_in) > strtotime($result->time_in_pm) && $time_in != '13:00:00') {
                    $updatetardy = array(
                        'l_st_id'       => $st_id,
                        'l_grade_id'    => $result->grade_level_id,
                        'l_date'        => $sdate,
                        'l_time_in'     => $result->time_in_pm,
                        'l_actual_time_in' => $time_in,
                        'l_att_id'      => $att_id,
                        'l_status'      => 0,
                    );
                    $this->messaging_model->save_tardy($updatetardy);
                    $tardy = TRUE;
                }
                $spr_id = $res->st_spr;
                $etime_in = $result->time_in_pm;
            } else {
                $spr_id = $res->st_spr;
                $tardy = "Not Tardy ever!!! ";
                $etime_in = 'No tardy time';
            }
        } else {  // if ($process_complete==true) {
            $etime_in = 'NEW';
            $tardy = 'NEW NEW';
            $new = 'New Record';
        }
        echo json_encode(
            array(
                'count' => $p_id, // 
                'st_id' => $st_id, // 
                'time' => $time_in, //
                'etime' => $etime_in,
                'date' => $sdate, //
                'tardy' => $tardy,
                'spr' => $spr_id,
                'att' => $att_id,
                'new' => $new,
            )
        );
    }

    public function bg_bot()
    {
        // $data['fortext'] = $this->messaging_model->fortext();
        $data['unrecorded'] = $this->messaging_model->fetch_unrecorded_spr();
        $this->load->view('bg_bot', $data);
    }



    function getAllNumbers()
    {
        $model = $this->messaging_model->getAllNum();
        return $model;
    }
}
