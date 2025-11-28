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
class Opl_resourcelist extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        // $this->load->model('Opl_widgets_model');
    }
    

    function createResourceList($school_year=NULL){

        $data['title'] = 'e-sKwela Online Platform for Learning';
        $data['subjectDetails'] = [];
        $data['gradeDetails'] = [];
        $data['main_header'] = '';
        $data['isClass'] = FALSE;
        $data['getSubjects'] = Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year);
        $data['getGradeLevel'] = Modules::run('opl/opl_widgets/getGradeLevel', $this->session->username, $school_year);
        // $data['school_year'] = $school_year;
        $data['headerTitle'] = 'Resource Listt';
        $data['main_content'] = 'resourcelist/resourceList';
        $data['modules']    = 'opl';
        $data['task_type'] = Modules::run('opl/opl_variables/getTaskType');
        echo Modules::run('templates/opl_content', $data);

    }


}
