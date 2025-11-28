<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Activity extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('activity_model');
        date_default_timezone_set("Asia/Manila");
    }

    public function index() {
        $data = array(
            'modules' => "college/activitymonitoring",
            'main_content' => "activity",
            'activities' => $this->activity_model->fetchActivities()->result()
        );
        echo Modules::run('templates/college_content', $data);
    }

    function post($name) {
        return $this->input->post($name);
    }

    function saveAttendanceManual(){
        echo json_encode($this->activity_model->saveAttendanceManual($this->post('st_id'), $this->post('act_id'), $this->post('time')));
    }

    function testSearch($val, $dep){
        print_r($this->activity_model->fetchAttendeeAttendance($val, $dep));
    }

    function searchAttendee()
    {
        $value = $this->post('id');
        $dept = $this->post('dept_id');
        echo $this->activity_model->search($value, $dept);
    }
    
    function getAttendeeAttendance($act_id, $type){
        return $this->activity_model->fetchAttendeeAttendance($act_id, $type);
    }
    
    function getActivities(){
        $data = array(
            'activities'    =>  $this->activity_model->fetchActivities()->result_array()
        );
        for($i = 0, $j = count($data['activities']); $i < $j; $i++):
            $data['att_count'][$i] = $this->activity_model->fetchAttendanceList($data['activities'][$i]['act_id'])->num_rows();
        endfor;
        echo json_encode($data);
    }
    
    function updateActivity(){
        $data = array(
            'act_title'         =>  $this->post('editActTitle'),
            'act_desc'          =>  $this->post('editActDesc'),
            'act_department'    =>  $this->post('editTargDept'),
            'act_date'          =>  $this->post('editActDate'),
            'act_time'          =>  $this->post('editActTime')
        );
        $this->activity_model->updateActivity($this->post('act_id'), $data);
        echo json_encode(array('message' => "success"));
    }
    
    function getActivity($act_id){
        echo json_encode($this->activity_model->fetchActivity($act_id)->row_array());
    }
    
    function deleteActivity($act_id){
        $this->activity_model->removeAttendanceList($act_id);
        $this->activity_model->removeActivity($act_id);
        echo json_encode(array('message' => 'success'));
    }
    
    function showAttendance($act_id, $type){
        $this->load->library('pdf');
        $att = $this->activity_model->fetchAttendanceList($act_id);
        $data = array(
            'act_id'        =>  $act_id,
            'activity'      =>  $this->activity_model->fetchActivity($act_id)->row(),
            'att_count'     =>  $att->num_rows(),
            'type'          =>  $type
        );
        $this->load->view('activitymonitoring/att_pdf', $data);
    }
    
    function updateActivityAttendance(){
        $profID = $this->post('prof_id');
        $act_id = $this->post('act_id');
        if(!empty($this->activity_model->checkAttendance($profID, $act_id))):
            $data = array(
                'act_out'   =>  Date('H:i:s')
            );
            $this->activity_model->updateActivityAttendance($profID, $act_id, $data);
        else:
            $data = array(
                'act_id'    =>  $act_id,
                'st_id'     =>  $profID,
                'act_in'    =>  Date('H:i:s')
            );
            $this->activity_model->insertActivityAttendance($data);
        endif;
        $att = $this->activity_model->fetchAttendance($act_id)->result();
        $data = array();
        foreach($att AS $a):
            $prof = $this->activity_model->fetchProfile($a->st_id)->row();
            array_push($data, array(
                'name'      => strtoupper($prof->firstname." ".$prof->lastname),
                'act_in'    =>  $a->act_in,
                'act_out'   =>  ($a->act_out != NULL) ? $a->act_out : '00:00:00"'
                )
            );
        endforeach;
        echo json_encode($data);
    }
    
    function getStudentCredentials($st_id){
        $check = $this->activity_model->fetchStudentCredentials($st_id, 1);
        if(empty($check)):
            $check = $this->activity_model->fetchStudentCredentials($st_id);
            $check->type = 2;
        else:
            $check->type = 1;
        endif;
        echo json_encode($check);
    }
    
    function getEmployeeCredentials($em_id){
        echo json_encode($this->activity_model->fetchEmployeeCredentials($em_id));
    }
    
    function getProfileByRFID($rfid){
        echo json_encode($this->activity_model->fetchProfileByRFID($rfid));
    }
    
    // fetch profile through php
    function getProfile($id){
        return $this->activity_model->fetchProfile($id)->row();;
    }
    
    // fetch attendance through php
    function getAttendanceList($act_id){
        $data = array(
            'act_id'    =>  $act_id,
            'dept_id'   =>  $this->activity_model->fetchDeptID($act_id)->act_department,
            'att_list'  =>  $this->activity_model->fetchAttendance($act_id)->result()
        );
        return $this->load->view('activitymonitoring/att_list', $data);
    }
    

    // createst the activity
    function createActivity() {
        $data = array(
            'act_title' => $this->post('actTitle'),
            'act_desc' => $this->post('actDesc'),
            'act_department' => $this->post('targDept'),
            'act_time' => $this->post('actTime'),
            'act_date' => $this->post('actDate')
        );
        $this->activity_model->insertActivity($data);
        echo json_encode(array('message' => 'success'));
    }

}
