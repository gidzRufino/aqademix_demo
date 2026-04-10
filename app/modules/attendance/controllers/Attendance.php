<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of attendance
 *
 * @author genesis
 */
class attendance extends MX_Controller
{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->model('attendance_model');
        $this->load->library('Mobile_Detect');
        date_default_timezone_set("Asia/Manila");
    }

    // function checkIfLate($grade_level_id, $time)
    public function checkIfLate($section_id, $time)
    {
        // $result = Modules::run('registrar/getGradeLevelById', $grade_level_id);
        $result = Modules::run('registrar/getSection', $section_id);
        if ($result->time_in != '00:00:00') { // if am class
            if (strtotime($time) > strtotime($result->time_in)) {
                $ret = array(
                    'att_time' => $result->time_in,
                    'att_tardy' => true,
                );
                return $ret;
            } else {
                $ret = array(
                    'att_time' => $result->time_in,
                    'att_tardy' => false,
                );
                return $ret;
            }
        } elseif ($result->time_in_pm != '00:00:00') { // if pm class
            if (strtotime($time) > strtotime($result->time_in_pm) && $time != '13:00:00') {
                $ret = array(
                    'att_time' => $result->time_in_pm,
                    'att_tardy' => true,
                );
                return $ret;
            } else {
                $ret = array(
                    'att_time' => $result->time_in_pm,
                    'att_tardy' => false,
                );
                return $ret;
            }
        }
    }

    public function saveLateRemarks($st_id, $date, $year, $att_id, $grade_id, $att_time)
    {
        $updateArray = array(
            'remarks' => 1,
            'remarks_from' => 0,
        );
        $this->attendance_model->addAttendanceRemark($updateArray, $st_id, $date, $year);
        $updatetardy = array(
            'l_st_id' => $st_id,
            'l_grade_id' => $grade_id,
            'l_date' => date('Y-m-d'),
            'l_time_in' => $att_time,
            'l_actual_time_in' => date('H:i:s'),
            'l_att_id' => $att_id,
            'l_status' => 0,
        );
        $this->attendance_model->save_tardy($updatetardy);

        return;
    }

    public function sendNotification()
    {
        $textMsg = 'Sample Notification from your Server';
        echo Modules::run('notification_system/sendPushNotification', $textMsg);
    }

    public function updateManualToAuto()
    {
        $q = $this->db->get('attendance_sheet_manual');
        echo count($q->result()) . ' needs to be updated';
        foreach ($q->result() as $res):
            $this->db->select('rfid');
            $this->db->select('st_id');
            $this->db->from('profile_students');
            $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
            $this->db->where('st_id', $res->st_id);
            $q1 = $this->db->get();

            $details = array(
                'att_st_id' => $res->st_id,
                'u_rfid' => $q1->row()->rfid,
                'time_in' => '800',
                'date' => date("Y-m-d", strtotime($res->date)),
            );
            if ($this->db->insert('attendance_sheet', $details)):
                echo $res->st_id . ' is successfully transferred to auto. <br />';
            endif;
        endforeach;
    }

    public function attendanceUpdates()
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
            if ($this->db->update('attendance_sheet', $data)):
                echo $st->rfid . ' | ' . $st->lastname . ' | ' . $st->st_id . '<br />';
            endif;

        endforeach;
        //        $sql = 'ALTER TABLE `esk_attendance_summary` ADD `school_year` YEAR NOT NULL ';
        //        $this->db->query($sql);
    }

    public function getAttendanceSheets()
    {
        //$this->db->limit(10, 0);
        $q = $this->db->get('attendance_sheet');
        $total = count($q->result());
        $x = 0;
        foreach ($q->result() as $att):
            $x++;
            $this->db->where('att_id', $att->att_id);
            $update = array(
                'date' => date("Y-m-d", strtotime($att->date))
            );
            if ($this->db->update('attendance_sheet', $update)):
                if ($x == $total):
                    echo 'Attendance Sheet is successfully updated <br />';
                    $this->db->query("ALTER TABLE `esk_attendance_sheet` CHANGE `date` `date` DATE NOT NULL");
                    echo 'Column Date is change successfully';
                endif;
            endif;
        endforeach;
    }

    public function getAttendanceSheetsM()
    {
        //$this->db->limit(10, 0);
        $q = $this->db->get('attendance_sheet_manual');
        $total = count($q->result());
        $x = 0;
        foreach ($q->result() as $att):
            $x++;
            $this->db->where('att_id', $att->att_id);
            $update = array(
                'date' => date("Y-m-d", strtotime($att->date))
            );
            if ($this->db->update('attendance_sheet_manual', $update)):
                if ($x == $total):
                    echo 'Attendance Sheet is successfully updated Manually <br />';
                endif;
            endif;
        endforeach;
        $this->db->query("ALTER TABLE `esk_attendance_sheet_manual` CHANGE `date` `date` DATE NOT NULL");
        echo 'Column Date is change successfully';
    }

    public function checkAdviser($section)
    {
        $check = $this->getNumberOfPresents(date('Y-m-d'), $section);

        if ($check->num_rows == 0):
            Modules::run('notification_system/sendNotification', 3, 2, 'System', $this->session->userdata('username'), 'Please Don\'t forget to check your Attendance', date('Y-m-d'));
            echo json_encode(array('status' => true, 'msg' => 'Please Don\'t forget to check your Attendance'));
        endif;
    }

    public function getApGraph($section_id = null, $date = null)
    {
        if ($section_id == null):
            $section_id = $this->input->post('section_id');
            if ($section_id == 'admin'):
                $section_id = "";
            endif;
        endif;
        if ($date == null):
            $date = $this->input->post('date');
        endif;

        $d = explode('-', $date);
        $data['firstDay'] = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $d[0], 10)), $d[2], 'first');
        $data['lastDay'] = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $d[0], 10)), $d[2], 'last');
        $data['d'] = $d;
        $data['numberOfStudents'] = Modules::run('registrar/getAllStudentsForExternal', null, $section_id, null, null);
        $data['section_id'] = $section_id;

        $this->load->view('apGraph', $data);
    }

    public function getNumberOfEmployeePresents($date = null, $attend_auto = null)
    {
        $records = $this->attendance_model->getEmployeeAttendance($date);

        return $records;
    }

    public function getNumberOfCollegePresent($date = null)
    {

        if ($this->session->userdata('attend_auto')) {
            $records = $this->attendance_model->getCollegeAttendance($date);
        } else {
            $records = $this->attendance_model->getCollegeAttendance($date);
        }

        return $records;
    }

    public function getNumberOfPresents($date = null, $section = null)
    {
        if ($section == null):
            $records = $this->getAttendance($this->session->advisory, $date);
        else:
            $records = $this->getAttendance($section, $date);
        endif;

        return $records;
    }

    public function checkempLate($tg_id, $time)
    {
        if ($tg_id != 0) {
            $result = $this->attendance_model->timegroup($tg_id);
            if (strtotime($time) > strtotime($result->ps_from)) {
                $ret = array(
                    'att_time' => $result->ps_from,
                    'att_tardy' => true,
                );
            } else {
                $ret = array(
                    'att_time' => $result->ps_from,
                    'att_tardy' => false,
                );
            }
        } else {
            $daynow = date('l');
            $fetch = $this->attendance_model->default_time($daynow);
            if (strtotime($time) > strtotime($fetch->time_in)) {
                $ret = array(
                    'att_time' => $fetch->time_in,
                    'att_tardy' => true,
                );
            } else {
                $ret = array(
                    'att_time' => $fetch->time_in,
                    'att_tardy' => false,
                );
            }
        }
        return $ret;
    }

    public function saveempLateRemarks($emp_id, $date, $year, $att_id, $position_id, $att_time)
    {
        // $updateArray = array(
        //        'remarks' => 1,
        //        'remarks_from' => 0,
        // );
        // $this->attendance_model->addAttendanceRemark($updateArray, $st_id, $date, $year);
        $updatetardy = array(
            'l_st_id' => $emp_id,
            'l_grade_id' => $position_id,
            'l_date' => date('Y-m-d'),
            'l_time_in' => $att_time,
            'l_actual_time_in' => date('H:i:s'),
            'l_att_id' => $att_id,
            'l_status' => 0,
            'l_account_type' => 1,
        );
        $this->attendance_model->save_tardy($updatetardy);

        return;
    }

    public function saveDTR($rfid, $user_id, $time = null)
    {
        $settings = $this->eskwela->getSet();
        if ($time == null):
            $time = date('Gi');
        endif;

        $BasicInfo = Modules::run('registrar/getSingleStudentByRfid', $rfid);
        $getBasicInfo = $BasicInfo->row();

        if ($BasicInfo->num_rows() > 0):
            $status = true;
            $lastname = $getBasicInfo->lastname;
            $firstname = $getBasicInfo->firstname;
            if ($getBasicInfo->avatar != ""):
                $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
            else:
                $avatar = base_url() . 'uploads/noImage.png';
            endif;
            // this check if user scan for the first time in a day
            $result = $this->attendance_model->attendanceCheck($user_id, date("Y-m-d"), $settings->school_year);
            $row = $result->row();

            if ($result->num_rows() == 0): // if user's first scan
                if ($time > 1200): //time is PM
                    $att_id = $this->saveTimeAttendance($rfid, 1, 'time_in_pm', $time, date("Y-m-d"), $user_id);
                else: // time is AM
                    $att_id = $this->saveTimeAttendance($rfid, 1, 'time_in', $time, date("Y-m-d"), $user_id);
                endif;
                // check if user is late or not
                // save to tardy if late
                $isLate = $this->checkempLate($getBasicInfo->time_group_id, date('G:i:s'));
                // records tardy
                if ($isLate['att_tardy'] == 1):
                    $this->saveempLateRemarks($user_id, date("Y-m-d"), $settings->school_year, $att_id, $getBasicInfo->position_id, $isLate['att_time']);

                endif;

                //     $this->saveTimeLog(1, $id);
                $this->saveTimeLog(1, $rfid, $time);
                $check_in = true;
                $check_stamp = 'check_in_on.png';
                $print_status = 'IN';
            else: // if not user's first scan
                // check time delay
                $isAllowedToScanned = $this->timeDelayCheck($rfid);
                if ($isAllowedToScanned):
                    $status = true;
                    //check check in status
                    if ($row->status): //if time in, save it as time out
                        if ($time < 1300): // time is AM
                            if ($row->time_out == ""):
                                $this->saveTimeLog(0, $rfid, $time);
                                $this->updateTimeAttendance($user_id, 'time_out', $time, 0);
                            endif;
                        else: // time is PM
                            $this->saveTimeLog(0, $rfid, $time);
                            $this->updateTimeAttendance($user_id, 'time_out_pm', $time, 0);
                        endif;

                        $check_in = false;
                        $check_stamp = 'check_out_on.png';
                        $print_status = 'OUT';
                    else: // if time out, save as time in
                        if ($time < 1200):
                            $this->saveTimeLog(1, $rfid, $time);
                            $this->updateTimeAttendance($user_id, 'time_in_pm', "", 1);
                        else:
                            if ($row->time_in_pm != ""):
                                $this->saveTimeLog(1, $rfid, $time);
                                $this->updateTimeAttendance($user_id, 'time_in_pm', $row->time_in_pm, 1);
                                $this->updateTimeAttendance($user_id, 'time_out_pm', "", 1);
                            else:
                                $this->saveTimeLog(1, $rfid, $time);
                                $this->updateTimeAttendance($user_id, 'time_in_pm', $time, 1);
                            endif;

                        endif;

                        $check_in = true;
                        $check_stamp = 'check_in_on.png';
                        $print_status = 'IN';
                    endif;
                else:  // if last scan is <= to 5 mins
                    $status = false;
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
                    $check_stamp = "";
                    $print_status = "";
                endif;
            endif;
        else:
            $status = false;
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
            $check_stamp = "";
            $print_status = "";
        endif;

        echo json_encode(
            array(
                'check_stamp' => base_url() . 'images/' . $check_stamp,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'id' => $user_id,
                'rfid' => $rfid,
                'status' => $status,
                'msg' => $msg,
                'avatar' => $avatar,
                'textmsg' => $textMsg,
                'send' => $send,
                'contact' => $number,
                'print_status' => $print_status,
            )
        );
    }

    public function checkStudentAttendance($rfid, $user_id, $time = null)
    {
        $settings = $this->eskwela->getSet();
        if ($time == null):
            $time = date('Gi');
        endif;

        $BasicInfo = $this->attendance_model->getSingleStudentByRfid($rfid);
        $getBasicInfo = $BasicInfo->row();
        $msg = '';

        if ($BasicInfo->num_rows() > 0):
            $status = true;
            $lastname = $getBasicInfo->lastname;
            $firstname = $getBasicInfo->firstname;
            if ($getBasicInfo->avatar != ""):
                $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
            else:
                $avatar = base_url() . 'uploads/noImage.png';
            endif;
        else:
            $status = false;
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
            $check_stamp = "";
            $print_status = "";
        endif;
        echo json_encode(
            array(
                'check_stamp' => base_url() . 'images/' . $check_stamp,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'id' => $user_id,
                'rfid' => $rfid,
                'status' => $status,
                'msg' => $msg,
                'avatar' => $avatar,
                'textmsg' => $textMsg,
                'send' => $send,
                'contact' => $number,
                'print_status' => $print_status,
            )
        );
    }

    public function timeDelayCheck($rfid)
    {
        $timeDelay = $this->attendance_model->checkTimeLog($rfid);
        if ($timeDelay->num_rows() > 0) :
            $hour = substr($timeDelay->row()->time, 0, 2);
            $mins = $timeDelay->row()->time;
            if (date('G') > $hour):
                $min = date('Gi') - ($mins + 40);
            else:
                $min = date('Gi') - $mins;
            endif;

            if ($min <= 5):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public function scanrfid($id = null)
    {
        $id = ($id == null ? strtolower($this->input->post('id')) : strtolower($id));
        $settings = $this->eskwela->getSet();
        //echo $id;
        $BasicInfo = $this->attendance_model->getSingleStudentByRfid($id, $settings->school_year);
        // print_r($BasicInfo);
        $getBasicInfo = $BasicInfo->row();
        if ($getBasicInfo->account_type == 5): // if student
            $user_id = $getBasicInfo->st_id;
            if ($BasicInfo->num_rows() > 0) {
                $status = true;
                $msg = '';
                //this check if user scan for the first time in a day
                $result = $this->attendance_model->attendanceCheck($user_id, date("Y-m-d"), $settings->school_year);
                $row = $result->row();
                if ($result->num_rows() == 0) {
                    if (date('Gi') > 1200) { // time is PM
                        $this->saveTimeAttendance($id, 1, 'time_in_pm', date('Gi'), date("Y-m-d"), $user_id);
                    } else {
                        $this->saveTimeAttendance($id, 1, 'time_in', date('Gi'), date("Y-m-d"), $user_id);
                    }

                    $isLate = $this->checkIfLate($getBasicInfo->grade_level_id, date('G:i:s'));
                    if ($isLate):
                        $this->saveLateRemarks($user_id, date("Y-m-d"), $settings->school_year, null, null, null);
                    endif;

                    $this->saveTimeLog(1, $id);
                    $check_in = true;
                    $check_stamp = 'check_in_on.png';
                    $print_status = 'IN';
                    // if ($getBasicInfo->avatar != ""):
                    //     $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
                    // else:
                    //     $avatar = base_url() . 'uploads/noImage.png';
                    // endif;
                    if ($getBasicInfo->avatar != ""):
                        if (file_exists('uploads/' . $getBasicInfo->avatar)):
                            $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
                        else:
                            $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                        endif;
                    else:
                        $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                    endif;
                    $lastname = $getBasicInfo->lastname;
                    $firstname = $getBasicInfo->firstname;
                    $rfid = $id;
                    $send = true;
                } else {
                    //scan time delay
                    $timeDelay = $this->attendance_model->checkTimeLog($id);
                    if ($timeDelay->num_rows() > 0):
                        $hour = substr($timeDelay->row()->time, 0, 2);
                        $mins = $timeDelay->row()->time;
                        if (date('G') > $hour):
                            $min = date('Gi') - ($mins + 40);
                        else:
                            $min = date('Gi') - $mins;
                        endif;
                        if ($min <= 5):
                            $status = false;
                            $msg = 'SORRY: You are not allowed to scan yet!';
                            $check_in = '';
                            $check_out = '';
                            $lastname = '';
                            $firstname = '';
                            $rfid = '';
                            $user_id = "";
                            $textMsg = "";
                            $send = false;
                            $number = "";
                            $check_stamp = "";
                            $print_status = "";
                        else:
                            //check if status is time_in; save as  time Out
                            if ($row->status) {
                                if (date('Gi') >= 1200 && date('Gi') <= 1230) { // time is PM
                                    if ($row->time_out == ""):
                                        if ($getBasicInfo->account_type != 5) {
                                            $this->saveTimeLog(0, $id);
                                        }
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                    else:
                                        if ($row->time_out_pm != "") { //if already has time out in the database
                                            if ($getBasicInfo->account_type != 5) {
                                                $this->saveTimeLog(0, $id);
                                            }
                                            $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                        } else {
                                            $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                            $this->saveTimeLog(0, $id);
                                        }
                                    endif;
                                } else { // time is AM
                                    $this->saveTimeLog(0, $id);
                                    $this->updateTimeAttendance($user_id, 'time_out', date('Gi'), 0);
                                }
                                $check_in = false;
                                $check_stamp = 'check_out_on.png';
                                $print_status = 'OUT';
                            } else {  //check if AM or PM
                                if (date('Gi') >= 1200) { //this is PM=
                                    if ($row->time_in_pm != "") {
                                        if ($getBasicInfo->account_type != 5) {
                                            $this->saveTimeLog(1, $id);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_in_pm', $row->time_in_pm, 1);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out', "", 1);
                                            $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out_pm', "", 1);
                                        } else {
                                            $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                        }
                                    } else {
                                        $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                    }
                                } else {
                                    if ($getBasicInfo->account_type != 5) {
                                        $this->saveTimeLog(1, $id);
                                        $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_in', $row->time_in, 1);
                                        $this->updateTimeAttendance($getBasicInfo->employee_id, 'time_out', "", 1);
                                    } else {
                                        $this->updateTimeAttendance($user_id, 'time_in', date('Gi'), 1);
                                    }
                                }
                                $check_in = true;
                                $check_stamp = 'check_in_on.png';
                                $print_status = 'IN';
                            }
                            if ($getBasicInfo->avatar != ""):
                                if (file_exists('uploads/' . $getBasicInfo->avatar)):
                                    $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
                                else:
                                    $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                                endif;
                            else:
                                $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                            endif;
                            $lastname = $getBasicInfo->lastname;
                            $firstname = $getBasicInfo->firstname;
                            $rfid = $id;
                            $user_id = $user_id;
                            $send = true;
                        endif;
                    else: // l
                        //check if status is time_in; save as  time Out
                        if ($row->status) {
                            if (date('Gi') >= 1200 && date('Gi') <= 1230) { // time is PM
                                if ($row->time_out == ""):
                                    if ($getBasicInfo->account_type != 5) {
                                        $this->saveTimeLog(0, $id);
                                    }
                                    $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                else:
                                    if ($row->time_out_pm != "") { //if already has time out in the database
                                        if ($getBasicInfo->account_type != 5) {
                                            $this->saveTimeLog(0, $id);
                                        }
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                    } else {
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', date('Gi'), 0);
                                        $this->saveTimeLog(0, $id);
                                    }
                                endif;
                            } else { // time is AM
                                $this->saveTimeLog(0, $id);
                                $this->updateTimeAttendance($user_id, 'time_out', date('Gi'), 0);
                            }
                            $check_in = false;
                            $check_stamp = 'check_out_on.png';
                            $print_status = 'OUT';
                        } else {
                            //check if AM or PM
                            if (date('Gi') >= 1200) { //this is PM
                                if ($row->time_in_pm != "") {
                                    if ($getBasicInfo->account_type != 5) {
                                        $this->saveTimeLog(1, $id);
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', $row->time_in_pm, 1);
                                        $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                        $this->updateTimeAttendance($user_id, 'time_out_pm', "", 1);
                                    } else {
                                        $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                    }
                                } else {
                                    $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                    $this->updateTimeAttendance($user_id, 'time_in_pm', date('Gi'), 1);
                                }
                            } else {
                                if ($getBasicInfo->account_type != 5) {
                                    $this->saveTimeLog(1, $id);
                                    $this->updateTimeAttendance($user_id, 'time_in', $row->time_in, 1);
                                    $this->updateTimeAttendance($user_id, 'time_out', "", 1);
                                } else {
                                    $this->updateTimeAttendance($user_id, 'time_in', date('Gi'), 1);
                                }
                            }
                            $check_in = true;
                            $check_stamp = 'check_in_on.png';
                            $print_status = 'IN';
                        }
                        // $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
                        if ($getBasicInfo->avatar != ""):
                            if (file_exists('uploads/' . $getBasicInfo->avatar)):
                                $avatar = base_url() . 'uploads/' . $getBasicInfo->avatar;
                            else:
                                $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                            endif;
                        else:
                            $avatar = base_url() . 'images/avatar/' . ($getBasicInfo->sex == 'Female' ? 'female.png' : 'male.png');
                        endif;
                        $lastname = $getBasicInfo->lastname;
                        $firstname = $getBasicInfo->firstname;
                        $rfid = $id;
                        $user_id = $user_id;
                        $send = true;
                    endif;
                }

                if ($settings->apicode != ""):
                    if ($getBasicInfo->ice_contact != ""):
                        $hasNumber = true;
                        $number = $getBasicInfo->ice_contact;
                    else:
                        $send = false;
                        $hasNumber = false;
                    endif;


                    $allowedToScan = Modules::run('messaging/allowedToScan', $getBasicInfo->sec_id);

                    if ($check_in) {
                        //$stat = 'has already checked in';
                        $stat = 'is already in School Campus';
                    } else {
                        //$stat = 'has already checked out';
                        $stat = 'is already out of School Campus';
                        if ($send):
                            if ($allowedToScan):
                                $send = true;
                            else:
                                $send = false;
                            endif;
                        endif;
                    }

                    $textMsg = strtoupper($settings->short_name) . ' SMS: '
                        . 'Your Student ' . strtoupper($firstname . ' ' . $lastname) . ' ' . $stat . ' at ' . date('g:i:s a');

                    if ($hasNumber):
                        if ($send):
                            Modules::run('messaging/saveText', 1, $textMsg, $number, $user_id);
                        // $msgID = Modules::run('messaging/saveText', 1, $textMsg, $number, $user_id);
                        // if ($msgID != ''):
                        // Modules::run('messaging/scanToSend', $number, $textMsg, $msgID);
                        // endif;
                        endif;
                    endif;
                else:
                    if ($check_in) {
                        $stat = 'in School';
                    } else {
                        $stat = 'out of School';
                    }

                    $textMsg = 'Your Student ' . strtoupper($firstname . ' ' . $lastname) . ' is already ' . $stat . ' at ' . date('g:i:s a');
                endif;

                Modules::run('notification_system/attendance_notification', date('g:i:s a'), $getBasicInfo->uid, $firstname . ' ' . $lastname, $stat);
                $parent_id = $getBasicInfo->uid;
            } else {
                $status = false;
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
                $avatar = "";
                $check_stamp = "";
                $print_status = "";
                $parent_id = "";
            }

            echo json_encode(
                array(
                    'check_stamp' => base_url() . 'images/' . $check_stamp,
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'lastname' => $lastname,
                    'firstname' => $firstname,
                    'id' => $user_id,
                    'rfid' => $rfid,
                    'status' => $status,
                    'msg' => $msg,
                    'avatar' => $avatar,
                    'textmsg' => $textMsg,
                    'send' => $send,
                    'contact' => $number,
                    'print_status' => $print_status,
                    'parent_id' => $parent_id
                )
            );
        else:
            $user_id = $getBasicInfo->employee_id;
            $this->saveDTR($id, $user_id);
        endif;
    }

    public function getSnap()
    {
        $id = $this->input->post('id');
        $user_id = $this->input->post('user_id');
        //$binary_data = base64_decode($id);
        $img = str_replace('data:image/jpeg;base64,', '', $id);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $result = file_put_contents(APPPATH . 'hr/' . time() . '.jpg', $data);
        if (!$result) {
            die("Could not save image!  Check file permissions.");
        }
    }

    public function saveTimeLog($status, $rfid, $time = null)
    {
        if ($time == null):
            $time = date('Gi');
        endif;

        $data = array(
            'log_id' => $this->eskwela->code(),
            'rfid' => $rfid,
            'time' => $time,
            'in_out' => $status,
            'date' => date("Y-m-d")
        );

        $this->attendance_model->saveTimeLog($data);
        return;
    }

    public function updateTimeAttendance($rfid, $column, $value, $status, $date = null)
    {
        if ($date == null):
            $date = date("Y-m-d");
        endif;
        if ($value != ""):
            $details = array(
                $column => $value,
                'timestamp' => date("Y-m-d") . ' ' . date('H:i:s'),
                'status' => $status
            );
        else:
            $details = array(
                'timestamp' => date("Y-m-d") . ' ' . date('H:i:s'),
                'status' => $status
            );

        endif;

        $id = $this->attendance_model->updateTimeAttendance($details, $rfid, $date);

        //        Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $id->att_id, 'update', 3);
    }

    public function saveTimeAttendance($rfid, $status, $column, $c_value, $date, $st_id = null)
    {
        if ($st_id == null):
            $st_id = '';
        endif;
        $data = array(
            'att_id' => $this->eskwela->code(),
            'att_st_id' => $st_id,
            'u_rfid' => $rfid,
            $column => $c_value,
            'timestamp' => date("Y-m-d") . ' ' . date('H:i:s'),
            'date' => $date,
            'status' => $status
        );
        $id = $this->attendance_model->saveTimeAttendance($data, $rfid, $date);
        //        Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $id, 'create', 3);
        return $id;
    }

    public function saveAttendanceManually()
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        $date = $this->input->post('date');
        $grade_id = Modules::run('registrar/getSection', $section_id);
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        if ($st_id != 0):
            $result = $this->attendance_model->attendanceCheck($st_id, $date);

            if (date('Gi') > '1200'):
                $ampm = 'time_in_pm';
                $time = '1300';
            else:
                $ampm = 'time_in';
                $time = '800';
            endif;


            if ($result->num_rows() == 0) {

                $id = $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $st_id);
            } else {
                $this->updateTimeAttendance($rfid, $ampm, $time, 0);
            }

            $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
            $present = $this->getIndividualMonthlyAttendance($st_id, $month, $year, $this->session->school_year);
        // $sprDetails = Modules::run('sf10/getSPRrec', $st_id, $this->session->school_year, NULL, $grade_id);
        // Modules::run('sf10/autoSaveAttendance', $month, $present, $sprDetails->spr_id, $this->session->school_year);
        //print_r($id);
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel', null, $section_id, null, 1);
            foreach ($students->result() as $s):
                $rfid = $s->rfid;
                $result = $this->attendance_model->attendanceCheck($s->st_id, $date, $this->session->school_year);

                if (date('Gi') > '1200'):
                    $ampm = 'time_in_pm';
                    $time = '1300';
                else:
                    $ampm = 'time_in';
                    $time = '800';
                endif;


                if ($result->num_rows() == 0) {

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $s->st_id);
                } else {
                    $this->updateTimeAttendance($s->st_id, $ampm, $time, 0);
                }
                if ($rfid == ""):
                    $this->getAttendance($section_id, null, $rfid);
                else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
                endif;

                $present = $this->getIndividualMonthlyAttendance($s->st_id, $month, $year, $this->session->school_year);
            // $sprDetails = Modules::run('sf10/getSPRrec', $s->st_id, $this->session->school_year, NULL, $grade_id);
            // Modules::run('sf10/autoSaveAttendance', $month, $present, $sprDetails->spr_id, $this->session->school_year);
            endforeach;
        endif;
    }

    // function saveAttendanceManually() {
    //     $rfid = $this->input->post('id');
    //     $st_id = $this->input->post('st_id');
    //     $section_id = $this->input->post('section_id');
    //     $date = $this->input->post('date');

    //     if ($st_id != 0):
    //         $result = $this->attendance_model->attendanceCheck($st_id, $date);

    //         if (date('Gi') > '1200'):
    //             $ampm = 'time_in_pm';
    //             $time = '1300';
    //         else:
    //             $ampm = 'time_in';
    //             $time = '800';
    //         endif;


    //         if ($result->num_rows() == 0) {

    //             $id = $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $st_id);
    //         } else {
    //             $this->updateTimeAttendance($rfid, $ampm, $time, 0);
    //         }

    //         $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
    //     //print_r($id);
    //     else:
    //         $students = Modules::run('registrar/getStudentsByGradeLevel', NULL, $section_id, NULL, 1);
    //         foreach ($students->result() as $s):
    //             $rfid = $s->rfid;
    //             $result = $this->attendance_model->attendanceCheck($s->st_id, $date, $this->session->school_year);

    //             if (date('Gi') > '1200'):
    //                 $ampm = 'time_in_pm';
    //                 $time = '1300';
    //             else:
    //                 $ampm = 'time_in';
    //                 $time = '800';
    //             endif;


    //             if ($result->num_rows() == 0) {

    //                 $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $s->st_id);
    //             } else {
    //                 $this->updateTimeAttendance($s->st_id, $ampm, $time, 0);
    //             }
    //             if ($rfid == ""):
    //                 $this->getAttendance($section_id, NULL, $rfid);
    //             else:
    //                 $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
    //             endif;
    //         endforeach;
    //     endif;
    // }

    public function saveAttendance($date = null)
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        if ($st_id != 0):
            if ($date == null):
                $date = $this->input->post('date');
            endif;
            if ($this->session->userdata('attend_auto')):
                $result = $this->attendance_model->attendanceCheck($st_id, $date);

                if (date('Gi') > '1200'):
                    $ampm = 'time_in_pm';
                    $time = '1300';
                else:
                    $ampm = 'time_in';
                    $time = '800';
                endif;


                if ($result->num_rows() == 0) {

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $st_id);
                } else {
                    $this->updateTimeAttendance($rfid, $ampm, $time, 0);
                }

                if ($rfid == ""):
                    $this->getAttendance($section_id, null, $rfid);
                else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
                endif;
            else:
                $result = $this->attendance_model->manualAttendanceCheck($st_id, $date);

                if (date('Gi') > '1200') {
                    $ampm = 'pm';
                } else {
                    $ampm = 'am';
                }

                $attendance = array(
                    'st_id' => $st_id,
                    $ampm => 1,
                    'date' => $date
                );

                if ($result->num_rows() == 0) {

                    $this->attendance_model->saveManualAttendance($attendance);
                } else {
                    $this->attendance_model->updateManualAttendance($attendance, $st_id, $date);
                }
                $this->getPresent($section_id, $this->session->userdata('attend_auto'));
            endif;
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel', null, $section_id, null, 1);
            foreach ($students->result() as $s):
                if ($date == null):
                    $date = $this->input->post('date');
                endif;

                if ($this->session->userdata('attend_auto')):
                    $rfid = $s->rfid;
                    $result = $this->attendance_model->attendanceCheck($rfid, $date);

                    if (date('Gi') > '1200'):
                        $ampm = 'time_in_pm';
                        $time = '1300';
                    else:
                        $ampm = 'time_in';
                        $time = '800';
                    endif;


                    if ($result->num_rows() == 0) {

                        $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $s->uid);
                    } else {
                        $this->updateTimeAttendance($rfid, $ampm, $time, 0);
                    }
                else:
                    $result = $this->attendance_model->manualAttendanceCheck($s->uid, $date);

                    if (date('Gi') > '1200') {
                        $ampm = 'pm';
                    } else {
                        $ampm = 'am';
                    }

                    $attendance = array(
                        'st_id' => $s->uid,
                        $ampm => 1,
                        'date' => $date
                    );

                    if ($result->num_rows() == 0) {

                        $this->attendance_model->saveManualAttendance($attendance);
                    } else {
                        $this->attendance_model->updateManualAttendance($attendance, $st_id, $date);
                    }
                endif;
                if ($rfid == ""):
                    $this->getAttendance($section_id, null, $rfid);
                else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
                endif;
            endforeach;

        endif;
    }

    public function getPresent($section_id = null, $attend_auto = null, $date = null)
    {

        $data['records'] = $this->getAttendance($section_id, $date);
        if (Modules::run('main/isMobile')) {
            $this->load->view('mobile/presents', $data);
        } else {
            $this->load->view('presents', $data);
        }
    }

    public function parentsList()
    {
        $data['option'] = 'individual';
        $data['students'] = Modules::run('registrar/getAllStudentsInNormalView');
        $data['modules'] = 'attendance';
        $data['main_content'] = 'parentsList';
        echo Modules::run('templates/main_content', $data);
    }

    public function current($option = null, $st_id = null)
    {
        $data['option'] = $option;
        $data['st_id'] = $st_id;

        $this->load->view('default', $data);
    }

    public function getRawMonthlyAttendanceDetails($id, $month, $year)
    {
        $attendance = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year);
        return $attendance;
    }

    public function getMonthlyAttendanceDetails($st_id, $month, $year)
    {
        $attendance['dailyAttendance'] = $this->getRawMonthlyAttendanceDetails($st_id, $month, $year);
        $this->load->view('dailyAttendanceDetails' . $attendance);
    }

    public function monthly($option, $id = null, $month = null, $year = null, $sy = null)
    {
        $id = base64_decode($id);
        if ($month == null) {
            $month = date('m');
        }
        if ($month < 10):
            $month = $month;
        endif;
        //echo $month;

        if ($this->session->userdata('attend_auto')):
            $auto = true;
            switch ($option) {
                case 'individual':
                    $data['attendance'] = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year, $sy);
                    break;
            }
            $this->load->view('daily', $data);
        else:
            $auto = false;
            switch ($option) {
                case 'individual':
                    $data['attendance'] = $this->attendance_model->getIndividualMonthlyAttendance($id, $month, $year, $sy);
                    break;
            }
            $this->load->view('daily_manual', $data);
        endif;
    }

    public function dailyPerSubject($subject_id = null, $section_id = null, $date = null)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$this->session->userdata('is_admin')):
            if ($section_id == null):
                $section_id = $this->session->userdata('advisory');

            endif;
        endif;
        $data['section_id'] = $section_id;
        $data['getPosition'] = Modules::run('hr/getSpecificAdvisory', $user_id, '');
        $data['subject'] = Modules::run('main/getSpecificSubjects', $subject_id);
        $data['records'] = $this->getAttendance($section_id, $date);
        $data['remarksCategory'] = Modules::run('main/getRemarksCategory');
        $data['section_id'] = $section_id;
        $data['date'] = $date;

        if (Modules::run('main/isMobile')) {
            if (!$this->session->userdata('is_logged_in')) {
                echo Modules::run('mobile/index');
            } else {
                $data['modules'] = "attendance";
                $data['main_content'] = 'mobile/manualChecking';
                echo Modules::run('mobile/main_content', $data);
            }
        } else {
            $data['modules'] = 'attendance';
            if ($this->session->userdata('is_admin')):
                $data['section'] = Modules::run('registrar/getAllSection');
            endif;
            $data['main_content'] = 'manualChecking';
            echo Modules::run('templates/main_content', $data);
        }
    }

    public function getAttendance($section_id = null, $date = null)
    {
        $attendance = $this->attendance_model->getAttendanceAutoManual($section_id, $date);
        return $attendance;
    }

    public function getManualAttendance($section_id = null)
    {
        $attendance = $this->attendance_model->getManualAttendance($section_id);
        return $attendance;
    }

    public function getAbsents($section_id = null, $attend_auto = null, $date = null)
    {
        $data['absents'] = $this->attendance_model->getAbsents($section_id, $attend_auto, $date);

        if (Modules::run('main/isMobile')) {
            $this->load->view('mobile/absents', $data);
        } else {
            $this->load->view('absents', $data);
        }
    }

    public function getAbsentByDate($section_id, $date, $gender)
    {
        $date = str_replace('-', '/', $date);
        if ($this->session->userdata('attend_auto')):
            $absents = $this->attendance_model->getAbsentByDatePerGender($section_id, $date, true, $gender);
        else:
            $absents = $this->attendance_model->getAbsentByDatePerGender($section_id, $date, false, $gender);
        endif;

        return $absents->num_rows();
    }

    public function ifPresent($st_id, $day = null, $month = null, $year = null, $attend_auto = null, $sy = null)
    {
        $result = $this->attendance_model->ifPresent($st_id, $day, $month, $year, $sy);
        //echo $result;
        return $result;
    }

    public function getDailyTotalByGender($date, $section, $gender = null)
    {
        if ($this->session->userdata('attend_auto')):
            $attendance = $this->attendance_model->getDailyTotalByGender($date, $section, $gender);
        else:
            $attendance = $this->attendance_model->getDailyTotalByGender($date, $section, $gender);
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
        if (Modules::run('main/isMobile')):
            $this->mobileSearchAttendance(base64_encode($date), $section_id);
        else:
            if ($this->session->userdata('is_admin') && $this->session->userdata('position') != 'School Administrator'):
                $data['section'] = Modules::run('registrar/getAllSection');
                if ($section_id != ''):
                    $this->load->view('searchAttendance', $data);
                else:
                    $this->load->view('searchAttendanceForAdmin', $data);
                endif;
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

    public function saveSearchAttendance()
    {
        $rfid = $this->input->post('id');
        $st_id = $this->input->post('st_id');
        $section_id = $this->input->post('section_id');
        $date = $this->input->post('date');

        if ($st_id != 0):
            $result = $this->attendance_model->attendanceCheck($st_id, $date);

            if (date('Gi') > '1200'):
                $ampm = 'time_in_pm';
                $time = '1300';
            else:
                $ampm = 'time_in';
                $time = '800';
            endif;


            if ($result->num_rows() == 0) {

                $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $st_id);
            } else {
                $this->updateTimeAttendance($rfid, $ampm, $time, 0);
            }

            $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
        else:
            $students = Modules::run('registrar/getStudentsByGradeLevel', null, $section_id, null, 1);
            foreach ($students->result() as $s):
                $rfid = $s->rfid;
                $result = $this->attendance_model->attendanceCheck($s->uid, $date);

                if (date('Gi') > '1200'):
                    $ampm = 'time_in_pm';
                    $time = '1300';
                else:
                    $ampm = 'time_in';
                    $time = '800';
                endif;


                if ($result->num_rows() == 0) {

                    $this->saveTimeAttendance($rfid, 1, $ampm, $time, $date, $s->uid);
                } else {
                    $this->updateTimeAttendance($s->uid, $ampm, $time, 0);
                }
                if ($rfid == ""):
                    $this->getAttendance($section_id, null, $rfid);
                else:
                    $this->getPresent($section_id, $this->session->userdata('attend_auto'), $date);
                endif;
            endforeach;
        endif;
    }

    public function saveAttendanceRemark()
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

        $this->attendance_model->addAttendanceRemark($updateArray, $st_id, $date);
        $data['records'] = $this->getAttendance($section_id, $date);
        $this->load->view('presents', $data);

        // Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $attendanceCheck->row()->att_id, 'update');
    }

    public function getAttendanceRemark($st_id, $date)
    {

        $attendanceRemark = $this->attendance_model->getAttendanceRemark($st_id, $date, null . null);
        //echo $attendanceRemark->row()->remarks;
        return $attendanceRemark;
    }

    public function getTardy($st_id, $month, $year = null)
    {
        // if ($this->session->userdata('attend_auto')):
        $sy = $this->session->school_year;
        $attendanceRemark = $this->attendance_model->getTardy($st_id, $month, $year, $sy);
        // else:
        //     $attendanceRemark = $this->attendance_model->getTardyManual($st_id, $month, $year);
        // endif;

        return $attendanceRemark;
    }

    public function deleteAttendance()
    {
        $date = $this->input->post('date');
        $att_id = $this->input->post('att_id');
        $section_id = $this->input->post('section_id');
        $st_id = $this->input->post('st_id');
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));

        if ($this->session->userdata('attend_auto')):
            $this->attendance_model->deleteAttendance($att_id, $date);
        else:
            $this->attendance_model->deleteAttendance($att_id, $date);
        endif;

        // echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto')) ;
        $present = $this->getIndividualMonthlyAttendance($st_id, $month, $year, $this->session->school_year);
        $sprDetails = Modules::run('sf10/getSPRrec', $st_id, $this->session->school_year, null);
        Modules::run('sf10/autoSaveAttendance', $month, $present, $sprDetails->spr_id, $this->session->school_year);
        //        Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $att_id, 'delete', 3);
    }

    // function deleteAttendance() {
    //     $date = $this->input->post('date');
    //     $att_id = $this->input->post('att_id');
    //     $section_id = $this->input->post('section_id');
    //     if ($this->session->userdata('attend_auto')):
    //         $this->attendance_model->deleteAttendance($att_id, $date);
    //     else:
    //         $this->attendance_model->deleteAttendance($att_id, $date);
    //     endif;

    //     // echo Modules::run('attendance/getAbsents', $section_id, $this->session->userdata('attend_auto')) ;
    //     Modules::run('web_sync/updateSyncController', 'attendance_sheet', 'att_id', $att_id, 'delete', 3);
    // }

    public function saveMonthlyAttendanceSummary($month = null, $section_id = null, $maleTotal = null, $femaleTotal = null, $maleAve = null, $femaleAve = null, $percentMale = null, $percentFemale = null, $attend_auto = null)
    {
        $summaryExist = $this->attendance_model->checkMonthlyAttendanceSummary($month, $section_id);

        if ($summaryExist):
            $data = array(
                'male_total' => $maleTotal,
                'female_total' => $femaleTotal,
                'ave_male_total' => $maleAve,
                'ave_female_total' => $femaleAve,
                'percent_male' => $percentMale,
                'percent_female' => $percentFemale
            );

            $this->attendance_model->updateMonthlyAttendanceSummary($month, $section_id, $data, $attend_auto);
        else:
            $data = array(
                'sum_id' => $this->eskwela->code(),
                'section_id' => $section_id,
                'male_total' => $maleTotal,
                'female_total' => $femaleTotal,
                'ave_male_total' => $maleAve,
                'ave_female_total' => $femaleAve,
                'percent_male' => $percentMale,
                'percent_female' => $percentFemale,
                'month' => $month,
                'attend_auto' => $attend_auto
            );

            $this->attendance_model->saveMonthlyAttendanceSummary($data);
        endif;
    }

    public function getMonthlyAttendanceSummary($month = null, $section_id = null, $attend_auto = null, $school_year = null)
    {
        $summary = $this->attendance_model->getMonthlyAttendanceSummary($month, $section_id, $attend_auto, $school_year);
        return $summary;
        // print_r($summary);
        //echo 'hey';
    }

    public function getMonthlyAttendanceSummaryPerLevel($month = null, $grade_id = null, $attend_auto)
    {
        $summary = $this->attendance_model->getMonthlyAttendanceSummaryPerLevel($month, $grade_id, $attend_auto);
        return $summary;
    }

    public function getMonthlyStatus($month = null, $grade_id = null, $code_id)
    {
        $summary = $this->attendance_model->getMonthlyStatus($month, $grade_id, $code_id);
        return $summary->num_rows();
    }

    public function getIndividualMonthlyAttendance($st_id, $month, $year = null, $school_year = null)
    {
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'last');

        for ($x = $firstDay; $x <= $lastDay; $x++) {
            $day = date('D', strtotime($year . '-' . $month . '-' . $x));

            // if ($day == 'Sat' || $day == 'Sun') {

            // } else {
            if ($x < 10):
                $day = "0" . $x;
            else:
                $day = $x;
            endif;

            //echo $day.' ';
            $ifPresent = $this->ifPresent($st_id, $day, $month, $year, $this->session->userdata('attend_auto'), $school_year);

            if ($ifPresent):
                $present += 1;
            endif;
            // }
        }
        //echo '<br />'.$year;
        if ($present > 0):
            return $present;
        else:
            return 0;
        endif;
    }
}
