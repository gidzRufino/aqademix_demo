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
class Student extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('opl_model');
        if(!$this->session->is_logged_in):
            redirect('entrance');
        endif;
    }

    private function post($name) {
        return $this->input->post($name);
    }
    
    function uploadResponse()
    {
        $school_year    = $this->post('school_year');
        $department_id  = $this->session->department;
        $grade_id       = $this->session->details->grade_id;
        $subject_id     = $this->post('subject_id');
        $quizType       = $this->post('task_type');
        $task_code      = $this->post('task_code');
        $task_id        = $this->post('task_id');
        $st_id          = $this->post('st_id');
        $submissionType = $this->post('submission_type');
        
        $file           = $this->post('userfile');
        $data['error']  = ''; //initialize image upload error array to empty

        $config['upload_path'] = 'uploads/'.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$st_id;
                
        if(!is_dir($config['upload_path'])) //create the folder if it's not already exists
        {
          mkdir($config['upload_path'],0777,TRUE);
        }
        
        $config['overwrite'] = TRUE;
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000';
        $config['file_name'] = $st_id.'-'.$quizType.$task_code; 

        $this->load->library('upload', $config);

         // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            //print_r($data);
            print_r($data);
            //$this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();
            $ext = $file_data['file_ext'];
            $link = $config['upload_path'].'/'.$config['file_name'].$ext;
            
            $responseDetails = array(
                'ts_code'               => $this->eskwela->code(),
                'ts_task_id'            => $task_id,
                'ts_submitted_by'       => $st_id,
                'ts_details'            => $link,
                'ts_submission_type'    => $submissionType,
                'ts_file_name'          => $config['file_name'],
                'ts_date_submitted'     => date('Y-m-d g:i:s')
            );
            
            if($this->student_model->saveResponse($responseDetails, $school_year)):
                echo 'Your response file was successfully submitted.';
            endif;
        }
    }
    
    function getAnswer($task_id, $st_id, $school_year)
    {
        $answer = $this->student_model->getAnswer($task_id, $st_id, $school_year);
        return $answer;
    }
    
    public function createResponse()
    {
        $responseDetails = array(
            'ts_code'       => $this->eskwela->code(),
            'ts_task_id'    => $this->post('task_id'),
            'ts_submitted_by' => $this->session->details->st_id,
            'ts_details'      => $this->post('task_details'),
            'ts_submission_type' => $this->post('task_submission_type'),
            'ts_date_submitted' => date('Y-m-d g:i:s')
        );
        
        if($this->student_model->createResponse($responseDetails, $this->session->school_year)):
             echo 'Response Successfully Submitted';
        else:
            echo 'Something went wrong, Please try again later';
        endif;
        
    }
    
    public function viewTaskDetails($task_id, $subject_id, $school_year = NULL)
    {
        $school_year = ($school_year == NULL?$this->session->school_year:$school_year);
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_level_id, $this->session->details->grade_level_id, $subject_id, $school_year));
        $taskDetails = array(
            
            'isClass'       => TRUE,
            'task'          =>  $this->opl_model->getTaskDetails($task_id, $school_year),
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'school_year'   => $school_year,
            'headerTitle'   => $classDetails->subjectDetails->subject.' - Task Details',
            'main_header'   => '',
            'title'         => 'e-sKwela Online Platform for Learning',
            'main_content'  => 'tasks/taskDetails',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $taskDetails);
    }
    
    public function index()
    {
        $data = array(
            'isClass'       => FALSE,
            'subjectDetails'=> NULL,
            'post'          => Modules::run('opl/getPost'),
            'headerTitle'   => 'Dashboard',
            'main_header'   => '<strong>Sneak Peek!</strong> Welcome to <strong>e-sKwela Online Platform for Learning </strong>.',
            'title'         => 'e-sKwela Online Platform for Learning',
            'main_content'  => 'students/default',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    
    public function classBulletin($subject = NULL, $school_year = NULL, $task = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_id, $this->session->details->section_id, $subject, $school_year));
        
        $data = array(
            'isClass'           => TRUE,
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'headerTitle'       => $classDetails->subjectDetails->subject.' - '.$classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section.' ] Class Bulletin',
            'main_header'       => 'Welcome to <strong>e-sKwela Online Platform for Learning </strong>.',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
        );
        switch ($task):
            default:
                $data['isStudent']     = TRUE;
                $data['postDetails']   = $this->opl_model->getTask($this->session->details->grade_id, $this->session->details->section_id, $subject, $school_year, $this->session->isStudent);
                $data['main_content']  = 'students/classBulletin';
            break;
        endswitch;

        echo Modules::run('templates/opl_content', $data);
    }
    
    public function student_menu($subjectDetails)
    {
        $data['gradeDetails'] = $this->session->details;
        $data['subjectDetails'] = $subjectDetails;
        $this->load->view('students/student_menu', $data);
    }
    
    public function myClasses($isClass, $subjectDetails = NULL)
    {
        if(!$isClass):
            $data['subjectsList'] = $this->student_model->getSubjectList($this->session->details->grade_id, $this->session->school_year);
            $this->load->view('students/widgets/myClasses', $data);
        else:
            $data['tasks']   = $this->opl_model->getTask($this->session->details->grade_id, $this->session->details->section_id, $subjectDetails->subject_id, $this->session->school_year, $this->session->isStudent);
            $this->load->view('students/widgets/taskList', $data);
        endif;    
    }
}
