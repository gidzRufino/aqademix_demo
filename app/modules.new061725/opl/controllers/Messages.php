<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl
 *
 * @author genesisrufino
 */
class Messages extends MX_Controller {

    //put your code here


    function __construct() {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('opl_model');
        $this->load->model('messages_model');
        $this->load->library('pagination');
        if (!$this->session->is_logged_in):
            redirect('entrance');
        endif;
    }

    public function index() {
        
    }
    
    function create_message($subject) {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_id, $this->session->details->section_id, $subject, $school_year));
        $subj_teacher = Modules::run('academic/getSubjectTeacher', $subject, $this->session->details->section_id);
        $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin';
        $data['teacher'] = $subj_teacher;
        $data['subjectDetails'] = $classDetails->subjectDetails;
        $data['subj_id'] = $subject;
        $data['grade_id'] = $this->session->details->grade_id;
        $data['section_id'] = $this->session->details->section_id;
        $data['students'] = Modules::run('opl/messages/getStudentsBySection', $grade_id, $section_id);
        $data['main_content'] = 'messages/compose';
        $data['modules'] = 'opl';

        echo Modules::run('templates/opl_content', $data);
    }
    
    function student_inbox($stid, $subject = NULL){
        $result = $this->messages_model->student_inbox(base64_decode($stid), NULL, NULL, $subject);
        
        $config['base_url'] = base_url('opl/messages/student_inbox/' . $stid . '/' . $subject);
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 10;
        $config["uri_segment"] = 6;
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
        
        $page = $this->messages_model->student_inbox(base64_decode($stid), $config['per_page'], $this->uri->segment(6), $subject);
        $data['links'] = $this->pagination->create_links();
        
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_id, $this->session->details->section_id, $subject, $this->session->school_year));
        $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin';
        $data['gradeDetails'] = $classDetails->basicInfo;
        $data['subjectDetails'] = $classDetails->subjectDetails;
        $data['messages'] = $page->result();
        $data['main_content'] = 'messages/inbox';
        $data['modules'] = 'opl';
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    function employee_inbox($emid, $subject = NULL, $grade_id = NULL, $section_id = NULL){
        $result = $this->messages_model->employee_inbox(base64_decode($emid));
        
        $config['base_url'] = base_url('opl/messages/employee_inbox/' . $emid . '/' . $subject . '/' . $grade_id . '/' . $section_id);
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 10;
        $config["uri_segment"] = 8;
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
        
        $page = $this->messages_model->employee_inbox(base64_decode($emid), $config['per_page'], $this->uri->segment(8));
        $data['links'] = $this->pagination->create_links();
        
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_id, $section_id, $subject, $this->session->school_year));
        $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin';
        $data['gradeDetails'] = $classDetails->basicInfo;
        $data['subjectDetails'] = $classDetails->subjectDetails;
        $data['messages'] = $page->result();
        $data['main_content'] = 'messages/inbox';
        $data['modules'] = 'opl';
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    function readMsge($id, $subject, $grade_id = NULL, $section_id = NULL, $isReply = NULL, $msg_id = NULL){
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_id, $section_id, $subject, $this->session->school_year));
        $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin';
        $data['mid'] = $id;
        $data['subj_id'] = $subject;
        $data['gradeDetails'] = $classDetails->basicInfo;
        $data['subjectDetails'] = $classDetails->subjectDetails;
        $data['msg'] = $this->messages_model->readMsge(base64_decode($id), $isReply, base64_decode($msg_id));
        $data['main_content']= 'messages/read';
        $data['modules'] = 'opl';
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    
    function sendMsg(){
        $subjMsg = $this->input->post('subjMsg');
        $content = $this->input->post('content');
        $recipient = $this->input->post('recipient');
        $sender = $this->input->post('sender');
        $subj_id = $this->input->post('subj_id');
        
        $q = $this->messages_model->sendMsg($subjMsg, $content, $recipient, base64_decode($sender), $subj_id);
        if($q):
            echo 'Message Sent!!!';
        else:
            echo 'An Error Occured';
        endif;
    }
    
    function getMsgReply($msg_id){
        return $this->messages_model->getMsgReply($msg_id);
    }
        
    function replyMsg(){
        $sender = $this->input->post('sender');
        $recipient = $this->input->post('recipient');
        $msg_id = $this->input->post('msg_id');
        $content = $this->input->post('content');
        $subjMsg = $this->input->post('subjMsg');
        $subj_id = $this->input->post('subj_id');
        
        $r = $this->messages_model->replyMsg(base64_decode($sender), $recipient, $msg_id, $content, $subjMsg, $subj_id);
        if($r):
            echo 'Message Sent!!!';
        else:
            echo 'Message Sending Failed';
        endif;
    }
    
    function getSender($id){
        return $this->messages_model->getSender(base64_decode($id));
    }
    
    function getRecipients($msg_id){
        return $this->messages_model->getRecipients($msg_id);
    }
    
    function getUnreadMsg($id, $subj_id){
        return $this->messages_model->getUnreadMsg(base64_decode($id), $subj_id);
    }
}
