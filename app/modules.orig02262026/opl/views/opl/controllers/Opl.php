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
class Opl extends MX_Controller
{
    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->model('opl_model');
        if (!$this->session->is_logged_in) :
            redirect('login');
        endif;
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    function resetStudentAnswers()
    {
        $st_id = $this->post('stid');
        $task_code = $this->post('code');
        echo $this->opl_model->resetStudentAnswers($st_id, $task_code);
    }

    public function discussionDetails($discuss_id, $school_year)
    {
        $taskDetails = array(
            'isClass'           => FALSE,
            'discussionDetails' => $this->opl_model->getDiscussionDetails($discuss_id, $school_year),
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'school_year'       => $school_year,
            'headerTitle'       => 'Discussion Details',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'main_content'      => 'discussionDetails',
            'modules'           => 'opl',
        );

        echo Modules::run('templates/opl_content', $taskDetails);
    }

    public function getPost()
    {
        $postDetails = $this->opl_model->getPost();
        return $postDetails;
    }

    public function submitQuickPost()
    {
        $owner_id = ($this->session->isStudent ? $this->session->details->st_id : $this->session->username);
        $postDetails = $this->post('postDetails');

        $postArray = array(
            'op_owner_id' => $owner_id,
            'op_post'   => $postDetails,
            'op_is_public' => 1
        );

        if ($this->opl_model->submitPost($postArray, $this->session->school_year)) :
            echo 'Successfully Submitted';
        else :
            echo 'Something went wrong, please try again later';
        endif;
    }

    public function sendComment()
    {
        $comType = $this->post('com_type');
        $comDetails = $this->post('com_details');
        $comFrom = $this->post('com_from');
        $comTo = $this->post('com_to');
        $com_syscode = $this->eskwela->code();
        $com_isStudent = $this->post('is_student');

        $commentDetails = array(
            'com_type'      => $comType,
            'com_details'   => $comDetails,
            'com_from'      => $comFrom,
            'com_to'        => $comTo,
            'com_sys_code'  => $com_syscode,
            'com_isStudent' => $com_isStudent
        );

        if ($this->opl_model->sendComment($commentDetails)) :
            echo Modules::run('opl/opl_variables/getComments', $comTo, $comType, $this->session->school_year);
        endif;
    }

    public function viewTaskDetails($task_id, $grade_level, $section, $subject, $school_year = NULL)
    {
        ($school_year == NULL ? $this->session->school_year : $school_year);
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section, $subject, $school_year));
        $taskDetails = array(
            'isClass'       => FALSE,
            'task'          =>  $this->opl_model->getTaskDetails($task_id, $school_year),
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'school_year'   => $school_year,
            'headerTitle'   => 'Task Details',
            'main_header'   => '',
            'title'         => 'e-sKwela Online Platform for Learning',
            'main_content'  => 'tasks/taskDetails',
            'modules'       => 'opl',
        );

        echo Modules::run('templates/opl_content', $taskDetails);
    }

    public function getTaskByCode($code, $school_year)
    {
        $task = Modules::run('opl/opl_variables/getTaskByCode', $code, $school_year);
        foreach ($task as $t) :
            echo '<li> <a href="' . base_url('opl/viewTaskDetails/') . $t->task_auto_id . '/' . $t->task_grade_id . '/' . $t->task_section_id . '/' . $t->task_subject_id . '">' . $t->task_title . '</a></li>';
        endforeach;
    }

    public function getUnits($grade_level, $subject, $school_year)
    {
        $unitLessons = $this->opl_model->getUnits($grade_level, $subject, $school_year);
        return $unitLessons;
    }

    function getUnitDetails($code, $school_year)
    {
        $unitDetails = $this->opl_model->getUnitDetails($code, $school_year);

        $array = array('unitDetails' => $unitDetails, 'tasks' => Modules::run('opl/getTaskByCode', $code, $school_year));

        echo json_encode($array);
    }

    public function saveUnit()
    {
        $unitDetails = array(
            'ou_unit_title'   =>  $this->post('unitTitle'),
            'ou_unit_objectives'   =>  $this->post('unitObjectives'),
            'ou_unit_overview'   =>  $this->post('unitOverview'),
            'ou_subject_id'     => $this->post('subject_id'),
            'ou_grade_level_id' => $this->post('grade_level_id'),
            'ou_owners_id'      => $this->session->username,
            'ou_opl_code'       => $this->eskwela->code()

        );
        $isSave = $this->opl_model->saveUnit($unitDetails, $this->post('unitTitle'), $this->post('school_year'));

        if ($isSave) :
            echo 'Lesson Successfully Added';
        elseif ($isSave == 2) :
            echo 'Lesson Title Already Exist';
        else :
            echo 'Sorry Something Went Wrong';

        endif;
    }

    public function addDiscussion($code = NULL)
    {
        $discussionDetails = array(
            'dis_title'         => $this->post('discussTitle'),
            'dis_details'       => $this->post('discussDetails'),
            'dis_unit_id'       => $this->post('unitID'),
            'dis_subject_id'    => $this->post('subject_id'),
            'dis_start_date'    => $this->post('startDate'),
            'dis_author_id'     => $this->session->username,
            'dis_sys_code'   => $this->eskwela->code()
        );

        if ($this->opl_model->addDiscussion($discussionDetails, $code, $this->post('school_year'))) :
            echo 'Successfully Saved';
        else :
            echo 'Sorry, Something went wrong. Please try again later';
        endif;
    }

    public function discussionBoard($school_year = NULL, $employee_id = NULL, $grade_level = NULL, $section = NULL, $subject = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section, $subject, $school_year));
        $data = array(
            'unitDetails'       => Modules::run('opl/opl_variables/getAllUnits', $this->session->username, $school_year, $grade_level),
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'discussionDetails' => Modules::run('opl/opl_variables/getDiscussionList', ($employee_id == NULL ? $this->session->username : $employee_id)),
            'headerTitle'       => 'Discussion Board',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'discussionBoard'
        );

        echo Modules::run('templates/opl_content', $data);
    }

    public function newDiscussion($school_year = NULL)
    {
        $data = array(
            'unitDetails'       => Modules::run('opl/opl_variables/getAllUnits', $this->session->username, $school_year),
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'gradeDetails'      => [],
            'subjectDetails'    => [],
            'headerTitle'       => 'Create A Discussion',
            'main_header'       => '',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
            'main_content'      => 'createDiscussion'
        );

        echo Modules::run('templates/opl_content', $data);
    }

    public function addTask()
    {
        $subGradSec = explode('-', $this->post(subGradeSec));
        $taskDetails = array(
            'task_code'         => $this->eskwela->code(),
            'task_type'         => $this->post('taskType'),
            'task_author_id'    => $this->session->username,
            'task_details'      => $this->post('postDetails'),
            'task_section_id'   => $subGradSec[2],
            'task_subject_id'   => $subGradSec[0],
            'task_grade_id'     => $subGradSec[1],
            'task_title'        => $this->post('postTitle'),
            'task_lesson_id'    => $this->post('unitLink'),
            'task_start_time'   => date('Y-m-d', strtotime($this->post('startDate'))) . ' ' . date('G:i:s', strtotime($this->post('timeStart'))),
            'task_end_time'     => date('Y-m-d', strtotime($this->post('deadlineDate'))) . ' ' . date('G:i:s', strtotime($this->post('timeDeadline')))
        );

        if ($this->opl_model->addTask($taskDetails, $this->post('school_year'))) :
            echo 'Successfully Posted';
        else :
            echo 'Sorry, Something went wrong';
        endif;
    }


    public function index()
    {
        $data = array(
            'isClass'       => FALSE,
            'post'          => $this->getPost(),
            'subjectDetails' => [],
            'headerTitle'   => 'Dashboard - School Bulletin',
            'main_header'   => '<strong>Sneak Peek!</strong> Welcome to <strong>e-sKwela Online Platform for Learning </strong>.',
            'title'         => 'e-sKwela Online Platform for Learning',
            'main_content'  => 'default',
            'modules'       => 'opl',
        );

        echo Modules::run('templates/opl_content', $data);
    }

    public function createTask($school_year = NULL)
    {
        $data['title'] = 'e-sKwela Online Platform for Learning';
        $data['subjectDetails'] = [];
        $data['gradeDetails'] = [];
        $data['main_header'] = '';
        $data['isClass'] = FALSE;
        $data['getSubjects'] = Modules::run('opl/opl_widgets/mySubject', $this->session->username, $school_year);
        $data['school_year'] = $school_year;
        $data['headerTitle'] = 'New Task';
        $data['main_content'] = 'tasks/addTask';
        $data['modules']    = 'opl';
        $data['task_type'] = Modules::run('opl/opl_variables/getTaskType');
        echo Modules::run('templates/opl_content', $data);
    }

    public function classBulletin($school_year = NULL, $task = NULL, $grade_level, $section, $subject)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section, $subject, $school_year));
        $data = array(
            'isClass'           => FALSE,
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            // 'unitDetails'       => $classDetails->unitDetails,
            'headerTitle'       => $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin',
            'main_header'       => '<strong>Sneak Peek!</strong> Welcome to <strong>e-sKwela Online Platform for Learning </strong>.',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
        );
        switch ($task):
            case 'Students':
                $data['main_header'] = '';
                $data['students'] = Modules::run('opl/opl_variables/getStudents', $grade_level, $section, $school_year);
                $data['unitDetails'] = Modules::run('opl/opl_variables/getAllUnits', $this->session->username, $school_year, $grade_level);
                $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Students';
                $data['main_content'] = 'classList';
                break;
            case 'List':
                if ($grade_level != NULL) :
                    $data['headerTitle'] = $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Task List';
                    $data['main_header'] = '';
                    $data['subject_id'] = $subject;
                    $data['grade_level'] = $grade_level;
                    $data['section_id'] = $section;
                    $data['tasks']   = $this->opl_model->getTask($grade_level, $section, $subject, $school_year);
                    $data['main_content'] = 'tasks/taskList';
                else :
                    $data['main_content'] = 'units/unitList';
?>
                    <script type="text/javascript">
                        alert('Please Select a Class');
                        history.back();
                    </script>
                <?php
                endif;
                break;
            default:
                $data['subject_id'] = $subject;
                $data['grade_level'] = $grade_level;
                $data['section_id'] = $section;
                $data['isStudent'] = FALSE;
                $data['postDetails']   = $this->opl_model->getTask($grade_level, $section, $subject, $school_year);
                $data['main_content']  = 'classBulletin';
                break;
        endswitch;

        echo Modules::run('templates/opl_content', $data);
    }

    function unitView($school_year = NULL, $task = NULL, $grade_level = NULL, $section = NULL, $subject = NULL)
    {
        if ($school_year == NULL) :
            $school_year = $this->session->school_year;
        endif;
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_level, $section, $subject, $school_year));
        $data = array(
            'isClass'           => FALSE,
            'gradeLevel'        => Modules::run('opl/opl_variables/getGradeLevel', NULL, $school_year),
            'main_header'       => '',
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'headerTitle'       => $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ]',
            'title'             => 'e-sKwela Online Platform for Learning',
            'modules'           => 'opl',
        );
        switch ($task):
            case 'Add':
                $data['subject_id'] = $subject;
                $data['grade_level'] = $grade_level;
                $data['getSubjects'] = Modules::run('opl/opl_variables/getSubjects');
                $data['main_content'] = 'units/addUnit';
                break;
            case 'List':
                if ($grade_level != NULL) :
                    $data['subject_id'] = $subject;
                    $data['grade_level'] = $grade_level;
                    $data['getUnits'] = $this->getUnits($grade_level, $subject, $school_year);
                    $data['main_content'] = 'units/unitList';
                else :
                    $data['main_content'] = 'units/unitList';
                ?>
                    <script type="text/javascript">
                        alert('Please Select a Class');
                        history.back();
                    </script>
<?php
                endif;
                break;
            default:
                $data['postDetails']   = $this->opl_model->getTask($section, $subject, $school_year);
                $data['main_content']  = 'unitView';
                break;
        endswitch;

        echo Modules::run('templates/opl_content', $data);
    }

    function task_menu()
    {
        $this->load->view('class_menu');
    }
}
