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
class College extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('college_model');
        $this->load->model('opl_model');
        if(!$this->session->is_logged_in):
            redirect('entrance');
        endif;
    }

    private function post($name) {
        return $this->input->post($name);
    }
    
    
    function myTask($school_year, $subject_id, $section_id = NULL, $semester = NULL)
    {
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        
        
        $data = array(
            'isClass' => TRUE,
            'subject_id'        => $subject_id,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'section_id'        => $section_id,
            'headerTitle' => 'My Task List - '.$subject->s_desc_title.' [ '.$subject->sub_code.' ]',
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'college/students/taskList'
        );
        $data['tasks'] = $this->college_model->getTask($section_id, $subject_id, $school_year, 1);
        echo Modules::run('templates/opl_content', $data);
    }
    
    function myLessons($school_year, $subject_id, $section_id = NULL, $semester = NULL)
    {
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section_id, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        
        
        $data = array(
            'isClass' => TRUE,
            'subjectDetails'    => [],
            'subject_id'        => $subject_id,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'section_id'        => $section_id,
            'discussionDetails' => $this->college_model->getLessons($subject_id, $section_id, $school_year),
            'headerTitle' => 'Discussion Board',
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'college/students/myLessons'
        );
        echo Modules::run('templates/opl_content', $data);
    }
    
    function getUnitDetails($code, $school_year) {
        $unitDetails = $this->opl_model->getUnitDetails($code, $school_year);
            $unitDetails->hasFile = 0;
        if($unitDetails->ou_unit_attachments != ''):
            $unitDetails->hasFile = 1;
            $unitDetails->file = site_url('UPLOADPATH'.$school_year).DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$unitDetails->ou_owners_id.DIRECTORY_SEPARATOR.$unitDetails->ou_subject_id.DIRECTORY_SEPARATOR.'unit'.DIRECTORY_SEPARATOR.$unitDetails->ou_unit_attachments;
        endif;
        $array = array('unitDetails' => $unitDetails, 'tasks' => Modules::run('opl/getTaskByCode', $code, $school_year));

        echo json_encode($array);
    }

    function deleteUnit() {
        $id = $this->post('lessonid');
        $response = $this->opl_model->deleteUnit($id);
        if ($response == TRUE):
            echo json_encode(array("message" => "Successfully removed unit"));
        else:
            echo json_encode(array("message" => "Something went wrong with deleting the unit"));
        endif;
    }

    function editUnit() {
        $id = $this->post('unitID');
        $data = array(
            'ou_unit_title' => $this->post('unitTitle'),
            'ou_unit_objectives' => $this->post('unitObjectives'),
            'ou_unit_overview' => $this->post('unitOverview'),
            'ou_subject_id' => $this->post('subjects'),
            'ou_grade_level_id' => $this->post('gradeLevel')
        );
        $response = $this->opl_model->editUnit($id, $data);
        if ($response == TRUE):
            echo json_encode(array("message" => "Successfully edited unit"));
        else:
            echo json_encode(array("message" => "Something went wrong with editing the unit"));
        endif;
    }
    
    function searchTasks(){
        $search = $this->post('value');
        $grade = $this->post('grade');
        $section = $this->post('semester');
        $subject = $this->post('subject');
        $tasks = $this->college_model->searchTasks($search, $grade, $semester, $subject);
        $discData = array('tasks'=>$tasks);
        echo $this->load->view('tasks/tr', $discData);
    }
    
    public function searchBar($link, $grade, $semester, $subject){
        $data = array(
            'grade_id'      =>  $grade,
            'semester'      =>  $semester,
            'subject_id'    =>  $subject
        );
        switch(strtolower($link)):
            case 'discussionboard':
                return $this->load->view('discussionSearch', $data);
            break;
            case 'classbulletin':
                if(strtolower($this->uri->segment(5)) == 'list'):
                    return $this->load->view('tasks/taskSearch', $data);
                endif;
            break;
        endswitch;
    }
    
    public function discussionBoard($school_year = NULL, $employee_id = NULL, $section = NULL, $subject_id = NULL, $semester = NULL) {
        
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        
        $data = array(
            'isClass' => FALSE,
            'subjectDetails'    => [],
            'subject_id'        => $subject_id,
            'section_id'        => $section,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'discussionDetails' => Modules::run('opl/opl_variables/getDiscussionList', ($employee_id == NULL ? $this->session->username : $employee_id)),
            'headerTitle' => 'Discussion Board',
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'college/discussionBoard'
        );
        echo Modules::run('templates/opl_content', $data);
    }
    
    public function discussionDetails($discuss_id, $school_year) {
        $taskDetails = array(
            'isClass' => FALSE,
            'subjectDetails'    => [],
            'discussionDetails' => $this->college_model->getDiscussionDetails($discuss_id, $school_year),
            'school_year'       => $school_year,
            'main_header' => '',
            'headerTitle' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'main_content' => 'college/discussionDetails',
            'modules' => 'opl',
        );

        echo Modules::run('templates/opl_content', $taskDetails);
    }

    public function addDiscussion($code = NULL) {
        $discussionDetails = array(
            'dis_title'         =>  $this->post('discussTitle'),
            'dis_details'       =>  $this->post('discussDetails'),
            'dis_unit_id'       =>  $this->post('unitID'),
            'dis_subject_id'    =>  $this->post('subject_id'),
            'dis_grade_id'      =>  0,
            'dis_section_id'    =>  $this->post('section_id'),
            'dis_start_date'    =>  $this->post('startDate'),
            'dis_author_id'     =>  $this->session->username,
            'dis_sys_code'      =>  $this->eskwela->codeCheck('opl_discussion', 'dis_sys_code', $this->eskwela->code())
        );

        if ($this->college_model->addDiscussion($discussionDetails, $code, $this->post('school_year'))):
            $remarks = $this->session->name.' has added a lesson for Discussion ';
            Modules::run('notification_system/sendNotification',8,3,'system',$this->post('section_id'), $remarks);
            echo 'Successfully Saved';
        else:
            echo 'Sorry, Something went wrong. Please try again later';
        endif;
    }
    
    public function newDiscussion($school_year = NULL, $semester) {
        $data = array(
            'isClass' => FALSE,
            'school_year' => $school_year,
            'semester'  =>  $semester,
            'gradeDetails' => [],
            'subjectDetails' => [],
            'getSubjects' => $this->getTeacherAssignment($this->session->username, $semester, $school_year),
            'headerTitle' => 'Create A Discussion',
            'main_header' => '',
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
            'main_content' => 'college/createDiscussion'
        );

        echo Modules::run('templates/opl_content', $data);
    }
    
    public function createTask($school_year = NULL, $semester = NULL) {
        $data['title'] = 'e-sKwela Learn Manager';
        $data['subjectDetails'] = [];
        $data['gradeDetails'] = [];
        $data['semester'] = ($semester==NULL?$this->session->semester:$semester);
        $data['main_header'] = '';
        $data['isClass'] = FALSE;
        $data['getSubjects'] = $this->getTeacherAssignment($this->session->username, $data['semester'], $school_year);
        $data['school_year'] = $school_year;
        $data['headerTitle'] = 'New Task';
        $data['main_content'] = 'college/tasks/addTask';
        $data['modules'] = 'opl';
        $data['task_type'] = Modules::run('opl/opl_variables/getTaskType');
        echo Modules::run('templates/opl_content', $data);
        
    }
    
    public function addTask() {
        $subGradSec = explode('-', $this->post('subGradeSec'));
        $sys_code = $this->eskwela->codeCheck('opl_tasks', 'task_code', $this->eskwela->code());
        $school_year = $this->session->school_year;

        $hasUpload = $this->post('hasUpload');
        if($hasUpload==1):
            $file = $this->post('userfile');
            $data['error'] = ''; //initialize image upload error array to empty

            $config['upload_path'] = UPLOADPATH.$school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$this->session->username.DIRECTORY_SEPARATOR.$subGradSec[0].DIRECTORY_SEPARATOR.'task';
            if(!is_dir($config['upload_path'].'/')):
                mkdir($config['upload_path'],0777,TRUE);
            endif;

            $config['overwrite'] = TRUE;
            $config['allowed_types'] = '*';
            $config['max_size'] = '3072';
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '50%';
            $config['width'] = 200;
            $this->load->library('upload', $config);

             // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                print_r($data);
                echo $config['upload_path'].'/';
                //$this->load->view('csvindex', $data);
            } else {
                $file_data = $this->upload->data();
                $ext = $file_data['file_ext'];
                $filename = $file_data['file_name'];
                $uploaded_file = $filename;
            }
        else:
            $uploaded_file = '';
        endif;

        $taskDetails = array(
            'task_code' => $sys_code,
            'task_type' => $this->post('taskType'),
            'task_submission_type'  => $this->post('task_submission'),
            'task_author_id' => $this->session->username,
            'task_details' => $this->post('postDetails'),
            'task_section_id' => $subGradSec[2],
            'task_subject_id' => $subGradSec[1],
            'task_grade_id' => $subGradSec[1],
            'task_title' => $this->post('postTitle'),
            'task_lesson_id' => $this->post('unitLink'),
            'task_start_time' => date('Y-m-d', strtotime($this->post('startDate'))) . ' ' . date('G:i:s', strtotime($this->post('timeStart'))),
            'task_end_time' => date('Y-m-d', strtotime($this->post('deadlineDate'))) . ' ' . date('G:i:s', strtotime($this->post('timeDeadline'))),
            'task_is_online'    => $this->post('task_is_online'),
            'task_online_link'  => $this->post('task_online_link'),
            'task_total_score'  => $this->post('numItems'),
            'task_attachments' => $uploaded_file,
            'marking_type'  => $this->post('markingType'),
            'marking_link'  => $this->post('ruid')
        );
        
        // print_r(json_encode($taskDetails));

        if ($this->college_model->addTask($taskDetails, $this->post('school_year'))):
        // Must add assessment for college or something just like how gs_assessment is made
        // But I have no idea yet, looking for possible redirects
        // Although adding tasks is already possible

        //     $details = array(
        //         'assess_id'     => $sys_code,
        //         'assess_title' => $this->input->post('postTitle'),
        //         'assess_date' => $this->post('startDate'),
        //         'section_id' => $subGradSec[2],
        //         'subject_id' => $subGradSec[0],
        //         'faculty_id' => $this->session->employee_id,
        //         'no_items' => $this->input->post('numItems'),
        //         'quiz_cat' => 0,
        //         'term' => $this->input->post('inputTerm'),
        //         'school_year' => $this->post('school_year'),
        //         'gs_strnd_id' => 0
        //     );
            
        //     $this->college_model->saveAssessment($details, $this->post('school_year'));
            
            echo json_encode(array('msg' => 'Successfully Posted', 'semester'=> $subGradSec[1],'section_id' => $subGradSec[2],'subject_id' => $subGradSec[0]));
            
            $remarks = $this->session->name.' has add a task for you to work on. Deadline would be on '.date('F d, Y g:i a', strtotime($this->post('deadlineDate').' '.$this->post('timeDeadline')));
            Modules::run('notification_system/sendNotification',8,3,'system',$subGradSec[2], $remarks);
        else:
            echo json_encode(array('msg' => 'Sorry, Something went wrong, Please try again later', 'grade_id'=> $subGradSec[1],'section_id' => $subGradSec[2],'subject_id' => $subGradSec[0]));
        endif;
    }

    function deleteTasks() {
        $code = $this->post('code');
        $response = $this->College_model->deleteTasks($code);
        if ($response == TRUE):
            echo json_encode(array("message" => "Successfully removed tasks"));
        else:
            echo json_encode(array("message" => "Something went wrong with deleting the tasks"));
        endif;
    }

    public function taskPDF($code) {
        $this->load->library('Pdf');
        $this->load->view("tasks/pdftask.php", array("task" => $this->college_model->fetchTaskByCode($code)->row()));
    }

    function task_menu() {
        $this->load->view('class_menu');
    }


    function fetchLesson($details, $school_year = NULL)
    {
        $detailItem = explode('-', $details);
        echo json_encode($detailItem);
        $units = $this->college_model->fetchLesson($detailItem[1],$detailItem[2], $school_year);
        foreach($units as $unit):
            echo "<option value='$unit->ou_opl_code'>$unit->ou_unit_title</option>";
        endforeach;
    }
    
    public function saveUnit() {
        $school_year = $this->post('school_year');
        $hasUpload = $this->post('hasUpload');
        $uploaded_file = '';
        $details = explode('-', $this->post('unitSubject'));
        if($hasUpload==1):
            $file = $this->post('userfile');
            $data['error'] = ''; //initialize image upload error array to empty
    
            $config['upload_path'] = UPLOADPATH.$school_year.DIRECTORY_SEPARATOR.'faculty'.DIRECTORY_SEPARATOR.$this->session->username.DIRECTORY_SEPARATOR.$this->post('subject_id').DIRECTORY_SEPARATOR.'unit';
            if(!is_dir($config['upload_path'].'/')):
                mkdir($config['upload_path'],0777,TRUE);
            endif;
            
            $config['overwrite'] = TRUE;
            $config['allowed_types'] = '*';
            $config['max_size'] = '3072';
            $config['maintain_ratio'] = TRUE;  
            $config['quality'] = '50%';  
            $config['width'] = 200;  
            $this->load->library('upload', $config);

             // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                print_r($data);
                echo $config['upload_path'].'/';
                //$this->load->view('csvindex', $data);
            } else {
                $file_data = $this->upload->data();
                $ext = $file_data['file_ext'];
                $filename = $file_data['file_name'];
                $uploaded_file = $filename;
            }
        endif;
        
        $unitDetails = array(
            'ou_unit_title'         => $this->post('unitTitle'),
            'ou_unit_objectives'    => $this->post('unitObjectives'),
            'ou_unit_overview'      => $this->post('unitOverview'),
            'ou_subject_id'         => $details[1],
            'ou_grade_level_id'     => $details[2],
            'ou_owners_id'          => $this->session->username,
            'ou_unit_attachments'   =>  $uploaded_file,
            'ou_opl_code'           => $this->eskwela->codeCheck('opl_units', 'ou_opl_code', $this->eskwela->code())
        );
        $isSave = $this->college_model->saveUnit($unitDetails, $this->post('unitTitle'), $school_year);

        if ($isSave):
            echo 'Lesson Successfully Added';
        elseif ($isSave == 2):
            echo 'Lesson Title Already Exist';
        else:
            echo 'Sorry Something Went Wrong';
        endif;
    }
    
    public function getUnits($grade_level, $subject, $school_year) {
        $unitLessons = $this->opl_model->getUnits($grade_level, $subject, $school_year);
        return $unitLessons;
    }
    
    function unitView($school_year = NULL, $task = NULL, $semester = NULL, $section = NULL, $subject_id = NULL) {
        if ($school_year == NULL):
            $school_year = $this->session->school_year;
        endif;
        
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        $data = array(
            'isClass' => FALSE,
            'subjectDetails'    => [],
            'subject_id'        => $subject_id,
            'main_header'       => '',
            'section_id'        => $section,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'headerTitle'       => 'Class Bulletin - '.$subject->sub_code.' [ '.($sched->count > 0 ? $sched->time . ' ( ' . $sched->day . ' ) ]' : 'TBA'),
            'title' => 'e-sKwela Online Platform for Learning',
            'modules' => 'opl',
        );
        switch ($task):
            case 'Add':
                $data['getSubjects'] = $this->getTeacherAssignment($this->session->username, $semester, $school_year);
                $data['main_content'] = 'college/units/addUnit';
                break;
            case 'List':
               if ($section != NULL):
                    $data['subject_id'] = $subject_id;
                    $data['section'] = $section;
                    $data['semeseter'] = $semester;
                    $data['getUnits'] = $this->college_model->fetchLesson($subject_id, $section, $school_year);
                    $data['main_content'] = 'college/units/unitList';
                else:
                    $data['main_content'] = 'college/units/unitList';
                    ?>
                    <script type="text/javascript">
                        alert('Please Select a Class');
                        history.back();
                    </script>    
                <?php

                endif;
                break;
            default:
                $data['postDetails'] = $this->opl_model->getTask($section, $subject, $school_year);
                $data['main_content'] = 'unitView';
                break;
        endswitch;

        echo Modules::run('templates/opl_content', $data);
    }
    
    function getStudentsPerSubject($school_year, $sec_id, $sem =NULL)
    {   
        $data = array(
            'isClass'       => FALSE,
            'subjectDetails'=> NULL,
            'students'      => $this->college_model->getStudentsPerSectionRaw($sec_id, $sem, $school_year),
            'headerTitle'   => 'List of Students',
            'main_header'   => '',
            'title'         => 'e-sKwela Online',
            'main_content'  => 'college/classList',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    function getTeacherAssignment($teacher_id, $semester, $school_year)
    {
        $assignment = $this->college_model->getTeacherAssignment($teacher_id, $semester, $school_year);
        return $assignment;    
        
    }
    
    function subjectsAndSchedules($school_year = NULL)
    {
        $data = array(
            'isClass'       => FALSE,
            'subjectDetails'=> NULL,
            'school_year'   => ($school_year==NULL?$this->session->school_year:$school_year),
            'post'          => Modules::run('opl/getPost'),
            'headerTitle'   => 'Subjects and Schedules',
            'main_header'   => '',
            'title'         => strtoupper($this->eskwela->getSet()->short_name).' Online',
            'main_content'  => 'college/subjects_schedules',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $data);
        
    }
    
    function financeAccounts()
    {
        $data = array(
            'isClass'       => FALSE,
            'subjectDetails'=> NULL,
            'post'          => Modules::run('opl/getPost'),
            'headerTitle'   => 'My Finance Accounts',
            'main_header'   => '<strong>Sneak Peek!</strong> Welcome to <strong>e-sKwela Online Platform for Learning </strong>.',
            'title'         => 'e-sKwela Online',
            'main_content'  => 'college/financeAccounts',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $data);
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
                'ts_code'               => $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code()),
                'ts_task_id'            => $task_id,
                'ts_submitted_by'       => $st_id,
                'ts_details'            => $link,
                'ts_submission_type'    => $submissionType,
                'ts_file_name'          => $config['file_name']
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
            'ts_code'       => $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code()),
            'ts_task_id'    => $this->post('task_id'),
            'ts_submitted_by' => $this->session->details->st_id,
            'ts_details'      => $this->post('task_details'),
            'ts_submission_type' => $this->post('task_submission_type')
        );
        
        if($this->student_model->createResponse($responseDetails, $this->session->school_year)):
             echo 'Response Successfully Submitted';
        else:
            echo 'Something went wrong, Please try again later';
        endif;
        
    }
    
    public function viewTaskDetails($task_id,$semester,$section, $subject_id, $school_year = NULL)
    {
        $school_year = ($school_year == NULL?$this->session->school_year:$school_year);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        $taskDetails = array(
            
            'isClass'       => TRUE,
            'task'          =>  $this->opl_model->getTaskDetails($task_id, $school_year),
            'subject_id'        => $subject_id,
            'section_id'        => $section,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'headerTitle'   => $subject->s_desc_title.' [ '.$subject->sub_code.' ] - Task Details',
            'main_header'   => '',
            'title'         => strtoupper($this->eskwela->getSet()->short_name).' Online',
            'main_content'  => 'college/tasks/taskDetails',
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
            'main_content'  => 'college/default',
            'modules'       => 'opl',
        );
        
        echo Modules::run('templates/opl_content', $data);
    }
    
    private function classDetails($subject_id, $section_id, $semester, $school_year)
    {
        $classDetails = $this->college_model->classDetails($subject_id, $semester, $school_year);
    }
    
    public function taskList($subject_id, $section, $semester, $school_year = NULL)
    {
        $school_year = ($school_year==NULL?$this->session->school_year: $school_year);
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        Modules::run('opl/setOplSessions', $subject_id, $section, $semester, $school_year, 1);
       
        $data = array(
            'subjectDetails'    => $subject,
            'isClass'           => TRUE,
            'subject_id'        => $subject_id,
            'section_id'        => $section,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'headerTitle'       => 'List of Task - '.$subject->sub_code.' [ '.($sched->count > 0 ? $sched->time . ' ( ' . $sched->day . ' ) ]' : 'TBA'),
            'main_header'       => '',
            'title'             => strtoupper($this->eskwela->getSet()->short_name).' Online',
            'modules'           => 'opl',
        );
        
        $data['isStudent']     = ($this->session->has_userdata('isStudent')?NULL:FALSE);
        $data['tasks']   = $this->college_model->getTask($section, $subject_id, $school_year, $data['isStudent']);
        $data['main_content'] = 'college/tasks/taskList';

        echo Modules::run('templates/opl_content', $data);
    }
    
    public function classBulletin($subject_id, $section, $semester, $school_year)
    {
        $scheds = Modules::run('college/schedule/getSchedulePerSection', $section, $semester, $school_year); 
        $sched = json_decode($scheds);
        $subject = Modules::run('college/subjectmanagement/getSubjectPerId', $subject_id, $school_year);
        Modules::run('opl/setOplSessions', $subject_id, $section, $semester, $school_year, 1);
        
        $data = array(
            'subjectDetails'    => $subject,
            'isClass'           => TRUE,
            'subject_id'        => $subject_id,
            'section_id'        => $section,
            'school_year'       => $school_year,
            'semester'          => $semester,
            'headerTitle'       => 'Class Bulletin - '.$subject->sub_code.' [ '.($sched->count > 0 ? $sched->time . ' ( ' . $sched->day . ' ) ]' : 'TBA'),
            'main_header'       => '',
            'title'             => strtoupper($this->eskwela->getSet()->short_name).' Online',
            'modules'           => 'opl',
        );
        
        $data['isStudent']     = ($this->session->has_userdata('isStudent')?NULL:FALSE);
        $data['postDetails']   = $this->college_model->getTask($section, $subject_id, $school_year, $data['isStudent']);
        $data['main_content']  = 'college/classBulletin';

        echo Modules::run('templates/opl_content', $data);
    }
    
    public function student_menu($subject_id)
    {
        $data['subject_id'] = $subject_id;
        $this->load->view('college/student_menu', $data);
    }
    
    public function myClasses($isClass, $subjectDetails = NULL)
    {
//        if(!$isClass):
//            $data['subjectsList'] = $this->student_model->getSubjectList($this->session->details->grade_id, $this->session->school_year);
//            $this->load->view('students/widgets/myClasses', $data);
//        else:
//            $data['tasks']   = $this->opl_model->getTask($this->session->details->grade_id, $this->session->details->section_id, $subjectDetails->subject_id, $this->session->school_year, $this->session->isStudent);
//            $this->load->view('students/widgets/taskList', $data);
//        endif;    
    }

    function test(){
        print_r($this->session);
    }
}
