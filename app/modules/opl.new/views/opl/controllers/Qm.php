<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Qm
 *
 * @author genesisrufino
 */
class Qm extends MX_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        $this->load->model('qm_model');
        if(!$this->session->is_logged_in):
            redirect('login');
        endif;
        
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    function index()
    {
        
    }
    
    function getQuestionItems($itemCode, $school_year)
    {
        $questionItems = $this->qm_model->getQuestionItems($itemCode, $school_year);
        return $questionItems;
    }
    
    function quizDetails($quizCode, $school_year)
    {
        $questionsDetails = array(
            'isClass'           => FALSE,
            'quizDetails'       => $this->qm_model->getQuizDetails($quizCode, $school_year),
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'getSubjects'       => Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year),
            'quiz_type'         => $this->qm_model->getQuizType(),
            'headerTitle'       => 'Assessment Details',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'qm/quizDetails'
        );
        
        echo Modules::run('templates/opl_content', $questionsDetails);
    }
    
    function deleteQuiz()
    {
        $quizCode = $this->post('quizCode');
        $school_year = $this->post('school_year');
        
        if($this->qm_model->deleteQuiz($quizCode, $school_year)):
            echo 'Successfully Deleted';
        else:
            echo 'Something went wrong, please try again later or contact support@thecsscore.com';
        endif;
    }
    
    function getAllQuizzes($teacher_id, $school_year)
    {
        $quizes = $this->qm_model->getAllQuizzes($teacher_id, $school_year);
        return $quizes;
    }
            
    function deleteQuestion()
    {
        $school_year = $this->post('school_year');
        if($this->qm_model->deleteQuestion($this->post('sys_code'), $school_year)):
            echo 'Successfully Deleted';
        else:
            echo 'Something went wrong, please try again later or contact support@thecsscore.com';
        endif;
    }
    
    function questionsList($teachers_id, $school_year = NULL)
    {
        $questionsDetails = array(
            'questions'         => $this->qm_model->questionsList(base64_decode($teachers_id), $school_year),
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Questions Bank',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'qm/questionsList'
        );
        
        echo Modules::run('templates/opl_content', $questionsDetails);
        
    }
    
    
    function create($school_year)
    {
        $data = array(
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'grade_level'       => [],
            'subject_id'        => [],
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Create a Quiz ',
            'quiz_type'         => $this->qm_model->getQuizType(),
            'getSubjects'       => Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year),
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'qm/create'
        );
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    function addQuestions()
    {
       $sysCode = $this->eskwela->code();
       $details = array(
           'question'      => $this->post('question'),
           'qq_answer'      => $this->post('answer'),
           'qq_qt_id'       => $this->post('qtype'),
           'created_by'     => $this->session->username,
           'sys_code'       => $sysCode
       );
       
       if($this->qm_model->addQuestions($details)):
            if($this->post('quizTitle')!=""):
                if($this->post('quiz_id')==0):
                    $quizSystemCode = $this->eskwela->code();
                    $quizItems = array(
                        'qi_grade_level_id'  => $this->post('grade_id'),
                        'qi_section_id'      => $this->post('section_id'),
                        'qi_qq_ids'          => $sysCode,
                        'qi_date_created'    => date('Y-m-d g:i:s'),
                        'qi_created_by'      => $this->session->username,
                        'qi_date_activation' => $this->post('startDate'),
                        'qi_date_expired'    => $this->post('endDate'),
                        'qi_title'           => $this->post('quizTitle'),
                        'qi_sys_code'        => $quizSystemCode
                    );
                    $this->qm_model->addQuiz($quizItems);
                else:
                    $quizSystemCode = $this->post('quiz_id');
                    $qq_id = $this->qm_model->getQQids($quizSystemCode);
                    $quizItems = array('qi_qq_ids' => $qq_id->qi_qq_ids.','.$sysCode);
                    $this->qm_model->updateQuiz($quizItems, $quizSystemCode);
                endif;
            endif;    
           echo json_encode(array('sysCode' => $sysCode, 'quizCode' => $quizSystemCode));
       else:
           echo 'Sorry Something went wrong';
       endif;
        
    }
    
    function loadCode()
    {
        echo $this->eskwela->code();
    }
}
