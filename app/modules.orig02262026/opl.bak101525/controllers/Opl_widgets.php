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
class Opl_widgets extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('Opl_widgets_model');
    }

    function post($name){
        return $this->input->post($name);
    }
    
    function getAdminListOfClasses()
    {
        $this->load->view('admin/widgets/adminListOfClasses');
    }

    function getTasksByType(){
        $response = $this->Opl_widgets_model->getTasksByType($this->post('grade'), $this->post('section'), $this->post('subject'), $this->post('task_type'));
        echo json_encode(array("hasUpdate"=>true,"total"=>$response['total'],"submitted"=>$response['submitted']));
    }

    function getStudentOnlinePresent(){
        $response = $this->Opl_widgets_model->getStudentOnlinePresent($this->post('section'), $this->post('grade'));
        if($response->count != $this->post('count')):
            echo json_encode(array("hasUpdate"=>true,"count"=>$response->count));
        else:
            echo json_encode(array("hasUpdate"=>false));
        endif;
    }
    
    function topWidget($subject_id, $section_id, $grade_level = NULL)
    {
        $data = array(
            'grade_id'      =>  $grade_level,
            'section_id'    =>  $section_id,
            'subject_id'    =>  $subject_id
        );
        $this->load->view('widgets/topWidget', $data);
    }
    
    function myClasses($isClass, $subjectDetails = NULL)
    {
        if(!$this->session->isStudent):
            $data['getAssignment'] = $this->mySubject($this->session->username, $this->session->school_year);
            $this->load->view('widgets/myClasses', $data);
        else:
            if($this->session->isCollege):
                echo Modules::run('opl/college/myClasses', $isClass, $subjectDetails);
            else:
                echo Modules::run('opl/student/myClasses', $isClass, $subjectDetails);
            endif;
        endif;
    }
    
    function mySubject($user_id = NULL, $school_year = NULL)
    {
        $assignment = $this->Opl_widgets_model->mySubjects($user_id, $school_year);
        return $assignment;
    }

}
