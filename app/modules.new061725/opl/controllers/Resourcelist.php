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
class Resourcelist extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('resourceList_model');
    }
    

    function createResourceList($school_year=NULL){

        $data['title'] = 'e-sKwela Online Platform for Learning';
        $data['subjectDetails'] = [];
        $data['gradeDetails'] = [];
        $data['main_header'] = '';
        $data['isClass'] = FALSE;
        $data['getSubjects'] = Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year);
        $data['getGradeLevel'] = Modules::run('opl/opl_variables/getGradeLevel', null, $school_year);
        // $data['school_year'] = $school_year;
        $data['headerTitle'] = 'Resource List';
        $data['main_content'] = 'resourcelist/resourceList';
        $data['modules']    = 'opl';
        $data['task_type'] = Modules::run('opl/opl_variables/getTaskType');
        echo Modules::run('templates/opl_content', $data);

    }


    function resourcelist($subject = NULL, $school_year = NULL, $task = NULL){

        
        $data['headerTitle'] = 'Resource List';
        $data['subjectDetails'] = [];
        $data['gradeDetails'] = [];
        $data['title'] = '';
        $data['school_year'] = '';


        $data['main_header'] = '';
        $data['isClass'] = FALSE;
        $data['postDetails']   = null;
        $data['main_content']  = 'resourcelist/list';
        $data['modules']    = 'opl';
        echo Modules::run('templates/opl_content', $data);

    }


    function addResourceList(){
        
        $subGradSec = explode('-', $this->post(subGradeSec));
        $resourceDetails = array(
            'resource_id'         => $this->eskwela->code(),
            'resource_title'      => $this->post('title'),
            'resource_details'    => $this->post('details'),
            's_id'                => $this->post('subject'),
            'topic'               => $this->post('topic'),
            'grade_id'            => $this->post('topic'),
            'tags'                => $this->post('tags'),
        );
        
        if($this->Opl_resourceListModel->addTask($resourceDetails, $this->post('school_year'))):
            echo 'Successfully Posted';
        else:
            echo 'Sorry, Something went wrong';
        endif;
        
    }


}
