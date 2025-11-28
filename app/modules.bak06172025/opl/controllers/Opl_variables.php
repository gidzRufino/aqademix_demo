<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_variables
 *
 * @author genesisrufino
 */
class Opl_variables extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('opl_variables_model');
    }

    function post($name)
    {
        return $this->input->post($name);
    }
    
    function getSectionDetails($gradeLevel, $section, $school_year)
    {
       $sectionDetails = $this->opl_variables_model->getClassDetails($gradeLevel, $section, $school_year);
       return $sectionDetails;
    }

    function sendReply()
    {
        $replyCode = $this->eskwela->code();
        $data = array(
            'com_sys_code'      =>  $replyCode,
            'com_details'       =>  $this->post('reply'),
            'com_from'          =>  ($this->session->isStudent) ? $this->session->st_id : $this->session->employee_id,
            'com_to'            =>  $this->post('to'),
            'com_isStudent'     =>  ($this->session->isStudent) ? 1 : 0,
            'com_type'          =>  3,
            'com_isReply'       =>  1,
            'com_replyto_id'    =>  $this->post('code')
        );
        $response = $this->opl_variables_model->sendReply($data, $this->session->school_year);
        if($response == TRUE):
            $html = '';
            $replies = $this->opl_variables_model->getReplies($this->post('code'), $this->session->school_year)->result();
            if(count($replies) != 0):
                foreach($replies AS $reply):
                    if($reply->com_isStudent==1):
                        $rprofile = $this->getStudentBasicEdInfoByStId($reply->com_from, $this->session->school_year);
                    else:
                        $rprofile = $this->getBasicEmployee($reply->com_from, $this->session->school_year);
                    endif;
                    $assets = $this->eskwela->getSet();
                    $avatar = site_url("/uploads/").$rprofile->avatar;
                    $avloc = FCPATH."uploads/".($rprofile->avatar ? $rprofile->avatar : "none.png");
                    if(file_exists($avloc) == FALSE):
                        $avatar = site_url("images/forms/").$assets->set_logo;
                    endif;
                    $html .= '<div id="individualReply_'.$reply->com_sys_code.'" class="mb-3">'.
                                '<img class="img-circle img-sm" src="'.$avatar.'" alt="User Image" />'.
                                '<div class="comment-text">'.
                                    '<small>'.
                                    '<span class="username">'.ucwords(strtolower($rprofile->firstname.' '.$rprofile->lastname)).
                                        '<span class="text-muted float-right timeago" datetime="'.$reply->com_timestamp.'"></span>'.
                                    '</span>'.$reply->com_details.
                                    '</small>'.
                                '</div>'.
                            '</div>';
                endforeach;
                
                $remarks = $this->session->name.' has sent a reply on a discussion';
                Modules::run('notification_system/sendNotification',8,3,'system',$this->session->oplSessions['section'], $remarks);
            endif;
            echo $html;
        else:
            echo NULL;
        endif;
    }

    function getReplies($com_to, $school_year){
        return $this->opl_variables_model->getReplies($com_to, $school_year)->result();
    }
    
    function fetchLesson($details, $school_year = NULL)
    {
        $detailItem = explode('-', $details);
        $units = $this->opl_variables_model->fetchLesson($detailItem[0],$detailItem[1], $school_year);
        foreach($units as $unit):
            echo "<option value='$unit->ou_opl_code'>$unit->ou_unit_title</option>";
        endforeach;
    }
            
    function getDiscussionList($em_id, $grade_id = NULL, $section_id = NULL, $subject_id = NULL, $school_year = NULL)
    {
        $discussions = $this->opl_variables_model->getDiscussionList($em_id, $grade_id, $section_id, $subject_id, $school_year);
        return $discussions;
    }
    
    function getStudents($grade_level, $section_id, $school_year)
    {
        $students = $this->opl_variables_model->getStudents($grade_level, $section_id, $school_year);
        return $students;
    }
    
    function getDiscussComments($com_to, $com_type, $school_year){
        $data['comments']   = $this->opl_variables_model->getComments($com_to, $com_type, $school_year);
        $data['com_type']   = $com_type;
        $data['com_to']     = $com_to;
        $this->load->view('discussComments', $data);
    }
    
    function getComments($com_to, $com_type, $school_year){
        $data['comments']   = $this->opl_variables_model->getComments($com_to, $com_type, $school_year);
        $data['com_type']   = $com_type;
        $data['com_to']     = $com_to;
        $this->load->view('comments', $data);
    }
    
    function getBasicEmployee($em_id, $school_year)
    {
        $employee = $this->opl_variables_model->getBasicEmployee($em_id, $school_year);
        return $employee;
    }
    
    function getStudentBasicEdInfoByStId($st_id, $school_year = NULL)
    {
        $student = $this->opl_variables_model->getStudentBasicEdInfoByStId($st_id, $school_year );
        return $student;
    }
    
    function getSubmittedTask($task_id=NULL, $school_year=NULL, $student_id = NULL)
    {
        $task = $this->opl_variables_model->getSubmittedTask($task_id, $school_year, $student_id);
        return $task;
    }
    
    function getTaskType()
    {
        $taskType = $this->opl_variables_model->getTaskType();
        return $taskType;
    }
    
    function getTaskByCode($code, $school_year)
    {
        $task = $this->opl_variables_model->getTaskByCode($code, $school_year);
        return $task;
    }
    
    function getAllUnits($employee_id, $school_year, $grade_id=NULL)
    {
        $unitLessons = $this->opl_variables_model->getAllUnits($employee_id, $school_year,$grade_id);
        return $unitLessons;
    }
    
    function getGradeLevel($grade_id=NULL, $school_year = NULL)
    {
        $gradeLevel = $this->opl_variables_model->getGradeLevel($grade_id, $school_year);
        return $gradeLevel;
    }
    
    function getSubjects()
    {
        $subject = $this->opl_variables_model->getSubjects();
        return $subject;
    }
    
    function getClassDetails($gradeLevel, $section, $subject, $school_year)
    {
        $details = array(
            'basicInfo'         => $this->opl_variables_model->getClassDetails($gradeLevel, $section, $school_year),
            'subjectDetails'    => $this->getSubjectById($subject),
            'unitDetails'       => $this->getAllUnits($this->session->username, $school_year, $gradeLevel)
        );
        
        return json_encode($details);
    }
    
    function getSubjectById($subject_id)
    {
        return $this->opl_variables_model->getSubjectById($subject_id);
    }

    function searchTask($task, $school_year){

        $task = $this->opl_variables_model->searchTask($task, $school);

        return $task;

    }
}
