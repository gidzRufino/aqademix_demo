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
    
    function myTasks()
    {
        
    }
    
    public function discussionDetails($discuss_id, $school_year, $gradeLevel, $subject_id, $section_id = NULL) {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $gradeLevel, $section_id, $subject_id, $school_year));
        $taskDetails = array(
            'isClass' => TRUE,
            'discussionDetails' => $this->opl_model->getDiscussionDetails($discuss_id, $school_year),
            'gradeDetails' => [],
            'subjectDetails' => $classDetails->subjectDetails,
            'school_year' => $school_year,
            'headerTitle' => 'Discussion Details',
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'main_content' => 'discussionDetails',
            'modules' => 'opl',
        );

        echo Modules::run('templates/opl_content', $taskDetails);
    }
    
    function myLessons($school_year, $subject_id, $grade_level, $section_id = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section_id, $subject_id, $school_year));
        $data = array(
            'isClass' => TRUE,
            'school_year' => $school_year,
            'gradeLevel' => $grade_level,
            'subject_id' => $subject_id,
            'subjectDetails' => $classDetails->subjectDetails,
            'discussionDetails' => $this->student_model->getLessons($subject_id, $grade_level, $section_id, $school_year),
            'headerTitle' => 'My Lessons in '.$classDetails->subjectDetails->subject,
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'students/myLessons'
        );

        echo Modules::run('templates/opl_content', $data);
    }
    
    function submitAnswer()
    {
        $sysCode = $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code());
        $finalAns = '';
        $answers = $this->post('answers');
        $task_code = $this->post('task_code');
        $answerDetails = explode(',', $answers);
        $cnt = 0;
        $score = 0;
        $count = count($answerDetails);
        foreach ($answerDetails as $ans):
            $cnt++;
            $ansDetails = explode('_', $ans);
            $finalAns .= $ansDetails[1].'_'.$ansDetails[2];
            if($cnt!=$count):
                $finalAns .= ',';
            endif;
            if(Modules::run('opl/qm/checkAnswer', $ansDetails[2], $ansDetails[1], $this->session->school_year)):
                if($ansDetails[2]!=""):
                    $score++;
                endif;
            endif;
        
        endforeach;
        
        $rawScoreDetails = array(
            'raw_id'    => $sysCode,
            'st_id'     => $this->session->details->st_id,
            'raw_score' => $score,
            'assess_id' => $task_code,
        );
        
         $responseDetails = array(
            'ts_code'               => $sysCode,
            'ts_task_id'            => $task_code,
            'ts_submitted_by'       => $this->session->details->st_id,
            'ts_details'            => $finalAns,
            'ts_submission_type'    => 3
        );
        $task = $this->opl_model->getTaskDetails($task_code, $this->session->school_year);

        $now = new DateTime();
        $start = new DateTime($task->task_end_time);
        $end = new DateTime($task->task_end_time);
        $started = $now->diff($start);
        $remaining = $end->diff($now);
        if($remaining->format("%R") == "-" && $started->format("%R") == "+"):
            if($this->student_model->createResponse($responseDetails, $this->session->school_year, $task_code,$this->session->details->st_id )):
                $this->student_model->submitRawScore($rawScoreDetails, $this->session->school_year);
                $remarks = $this->session->name.' has submitted a response to a task';
                Modules::run('notification_system/sendNotification',1,3,$this->session->details->st_id,$this->post('teacher'), $remarks);
                
                echo 'Response Successfully Submitted';
            else:
                echo 'Something went wrong, Please try again later';
            endif;
        else:
            if($started->format("%R") == "-"):
                echo "This task has not yet started.";
            elseif($remaining->format("%R") == "+"):
                echo "This task has already ended.";
            endif;
        endif;
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
        $dir = "./uploads".DIRECTORY_SEPARATOR.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$st_id;
        if($this->eskwela->createPath($dir)):
        
            $config['upload_path'] = $dir;
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = '*';
            $config['max_size'] = '10000';
            $config['file_name'] = $st_id.'-'.$task_code; 

            $this->load->library('upload', $config);

            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                //print_r($data);
                print_r(strip_tags($this->upload->display_errors()));
                // print_r('uploads'.DIRECTORY_SEPARATOR.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$subject_id.DIRECTORY_SEPARATOR.$st_id);
                //$this->load->view('csvindex', $data);
            } else {
                $file_data = $this->upload->data();
                $ext = $file_data['file_ext'];
                $link = $config['upload_path'].'/'.$config['file_name'].$ext;
                
                $responseDetails = array(
                    'ts_code'               => $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code()),
                    'ts_task_id'            => $task_code,
                    'ts_submitted_by'       => $st_id,
                    'ts_details'            => $link,
                    'ts_submission_type'    => $submissionType,
                    'ts_file_name'          => $config['file_name']
                );
                
                if($this->student_model->saveResponse($responseDetails, $school_year)):
                    
                    $remarks = $this->session->name.' has submitted a response to a task';
                    Modules::run('notification_system/sendNotification',1,3,$this->session->details->st_id,$this->post('teacher'), $remarks);
                    echo 'Your response file was successfully submitted.';
                endif;
            }
        else:
            echo "Something went wrong while uploading";
        endif;
    }
    
    function getAnswer($task_id, $st_id, $school_year)
    {
        $answer = $this->student_model->getAnswer($task_id, $st_id, $school_year);
        return $answer;
    }
    
    public function createResponse()
    {
        $code = $this->post('task_id');
        $responseDetails = array(
            'ts_code'       => $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code()),
            'ts_task_id'    => $this->post('task_id'),
            'ts_submitted_by' => $this->session->details->st_id,
            'ts_details'      => $this->post('task_details'),
            'ts_submission_type' => $this->post('task_submission_type')
        );
        $task = $this->opl_model->getTaskDetails($this->post('task_id'), $this->session->school_year);
        
        $now = new DateTime();
        $start = new DateTime($task->task_end_time);
        $end = new DateTime($task->task_end_time);
        $started = $now->diff($start);
        $remaining = $end->diff($now);
        if($remaining->format("%R") == "-" && $started->format("%R") == "+"):
            if($this->student_model->createResponse($responseDetails, $this->session->school_year)):
                
                    $remarks = $this->session->name.' has submitted a response to a task';
                    $link = "opl/viewTaskDetails/".$code."/".$this->session->details->grade_level_id."/".$this->session->details->section_id."/".$this->session->school_year;
                    Modules::run('notification_system/sendNotification',1,3,$this->session->details->st_id,$this->post('teacher'), $remarks, $link);
                    echo 'Response Successfully Submitted';
            else:
                echo 'Something went wrong, Please try again later';
            endif;
        else:
            if($started->format("%R") == "-"):
                echo "This task has not yet started.";
            elseif($remaining->format("%R") == "+"):
                echo "This task has already ended.";
            endif;
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
            'post'          => $this->opl_model->getPost($this->session->st_id, $this->session->details->grade_level_id, $this->session->details->section_id),
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
        Modules::run('opl/setBasicOplSessions',$subject, $this->session->details->grade_id, $this->session->details->section_id, $school_year);
        
        $data = array(
            'isClass'           => TRUE,
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'headerTitle'       => $classDetails->subjectDetails->subject.' - '.$classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section.' ] Class Bulletin',
            'main_header'       => 'Welcome to <strong> Learn Manager </strong>.',
            'title'             => 'Learn Manager',
            'modules'           => 'opl',
        );
        
        switch ($task):
            
            case 'List':
                    $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Task List';
                    $data['main_header'] = '';
                    $data['subject_id'] = $subject;
                    $data['grade_level'] = $this->session->details->grade_id;
                    $data['section_id'] = $this->session->details->section_id;
                    $data['tasks'] = $this->opl_model->getTask($this->session->details->grade_id, $this->session->details->section_id, $subject, $school_year, $this->session->isStudent);
                    $data['main_content'] = 'students/taskList';
                break;
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
    
    function viewDetails($id, $year = NULL, $semester = NULL) {
        $id = base64_decode($id);
        $students = $this->student_model->getSingleStudent($id, $year, $semester);
        if ($students->u_id == ""):
            $user_id = $students->us_id;
        else:
            $user_id = $students->u_id;
        endif;
        if ($this->session->userdata('position') == 'Parent'):
            $data['editable'] = 'hide';
        else:
            $data['editable'] = '';
        endif;

        $data['ro_year'] = $this->getROYear();
        $data['students'] = $students;
        $data['option'] = 'individual';
        $data['religion'] = Modules::run('main/getReligion');
        $data['motherTongue'] = Modules::run('main/getMotherTongue');
        $data['ethnicGroup'] = Modules::run('main/getEthnicGroup');
        $data['st_id'] = $id;
        $data['educ_attain'] = $this->registrar_model->getEducAttain();

        $data['modules'] = 'opl';
        $data['main_content'] = 'students/studentInfo';
        echo Modules::run('templates/opl_content', $data);
    }
    
    public function getROYear() {
        $year = Modules::run('registrar/getROYear');
        return $year;
    }

    function checkUserAcc($stid) {
        return $this->student_model->checkUserAcc(base64_decode($stid));
    }

    function changePass() {
        $st_id = $this->input->post('st_id');
        $newpass = $this->input->post('newpass');

        return $this->student_model->changePass(base64_decode($st_id), $newpass);
    }
    
    function logout()
    {
            $st_id=$this->session->userdata('st_id');
            $this->student_model->logout($st_id);
            $this->session->sess_destroy();
            $session_id = $this->session->userdata('session_id');
            if($session_id == "" || $session_id==null){
                $this->student_model->logout($st_id);
            }
            Modules::run('main/logActivity','INFO',  $this->session->userdata('name').' has logged Out.', $st_id);
            redirect(base_url() . 'entrance');
 

    }
}
