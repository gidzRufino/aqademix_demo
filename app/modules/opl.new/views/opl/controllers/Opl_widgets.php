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
    
    function topWidget()
    {
        $this->load->view('widgets/topWidget');
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
