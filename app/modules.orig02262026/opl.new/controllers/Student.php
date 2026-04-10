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
class Student extends MX_Controller
{
    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('opl_model');
        if (!$this->session->is_logged_in):
            redirect('entrance');
        endif;
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    function myTasks() {}

    public function discussionDetails($discuss_id, $school_year, $gradeLevel, $subject_id, $section_id = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $gradeLevel, $section_id, $subject_id, $school_year));
        $taskDetails = array(
            'isClass' => TRUE,
            'discussionDetails' => $this->opl_model->getDiscussionDetails($discuss_id, $school_year),
            'gradeDetails' => [],
            'subjectDetails' => $classDetails->subjectDetails,
            'school_year' => $school_year,
            'headerTitle' => 'Discussion Details',
            'main_header' => '',
            'title' => 'Aqademix Online Platform for Learning',
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
            'headerTitle' => 'My Lessons in ' . $classDetails->subjectDetails->subject,
            'main_header' => '',
            'title' => 'Aqademix Online Platform for Learning',
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
            $finalAns .= $ansDetails[1] . '_' . $ansDetails[2];
            if ($cnt != $count):
                $finalAns .= ',';
            endif;
            if (Modules::run('opl/qm/checkAnswer', $ansDetails[2], $ansDetails[1], $this->session->school_year)):
                if ($ansDetails[2] != ""):
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
        if ($remaining->format("%R") == "-" && $started->format("%R") == "+"):
            if ($this->student_model->createResponse($responseDetails, $this->session->school_year, $task_code, $this->session->details->st_id)):
                $this->student_model->submitRawScore($rawScoreDetails, $this->session->school_year);
                $remarks = $this->session->name . ' has submitted a response to a task';
                Modules::run('notification_system/sendNotification', 1, 3, $this->session->details->st_id, $this->post('teacher'), $remarks);

                echo 'Response Successfully Submitted';
            else:
                echo 'Something went wrong, Please try again later';
            endif;
        else:
            if ($started->format("%R") == "-"):
                echo "This task has not yet started.";
            elseif ($remaining->format("%R") == "+"):
                echo "This task has already ended.";
            endif;
        endif;
    }

    public function uploadResponse()
    {
        // Force JSON output
        $this->output->set_content_type('application/json');

        // Get POST data
        $school_year    = $this->input->post('school_year');
        $subject_id     = $this->input->post('subject_id');
        $task_type      = $this->input->post('task_type');
        $task_code      = $this->input->post('task_code');
        $task_id        = $this->input->post('task_id');
        $st_id          = $this->input->post('st_id');
        $submissionType = $this->input->post('submission_type');

        // Debug check: if no file is sent
        if (empty($_FILES['userfile']['name'])) {
            echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
            return;
        }

        // Create upload directory
        $dir = "./uploads" . DIRECTORY_SEPARATOR . $school_year . DIRECTORY_SEPARATOR . 'students' . DIRECTORY_SEPARATOR . $subject_id . DIRECTORY_SEPARATOR . $st_id;
        if (!$this->eskwela->createPath($dir)) {
            echo json_encode(['status' => 'error', 'message' => 'Unable to create upload directory.']);
            return;
        }

        // Upload config
        $config['upload_path']   = $dir;
        $config['overwrite']     = TRUE;
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size']      = 10000; // 10MB
        $config['file_name']     = $st_id . '-' . $task_code;

        $this->load->library('upload', $config);

        // Attempt upload
        if (!$this->upload->do_upload('userfile')) {
            echo json_encode([
                'status'  => 'error',
                'message' => strip_tags($this->upload->display_errors())
            ]);
            return;
        }

        // Upload successful
        $file_data = $this->upload->data();
        $ext  = $file_data['file_ext'];
        $link = $config['upload_path'] . '/' . $config['file_name'] . $ext;

        // Save to DB
        $responseDetails = array(
            'ts_code'            => $this->eskwela->codeCheck('opl_task_submitted', 'ts_code', $this->eskwela->code()),
            'ts_task_id'         => $task_code,
            'ts_submitted_by'    => $st_id,
            'ts_details'         => $link,
            'ts_submission_type' => $submissionType,
            'ts_file_name'       => $config['file_name'] . $ext
        );

        if ($this->student_model->saveResponse($responseDetails, $school_year)) {
            $remarks = $this->session->name . ' has submitted a response to a task';
            Modules::run('notification_system/sendNotification', 1, 3, $this->session->details->st_id, $this->input->post('teacher'), $remarks);

            echo json_encode([
                'status'  => 'success',
                'message' => 'Your response file was successfully submitted.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to save submission record.'
            ]);
        }
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
        if ($remaining->format("%R") == "-" && $started->format("%R") == "+"):
            if ($this->student_model->createResponse($responseDetails, $this->session->school_year)):

                $remarks = $this->session->name . ' has submitted a response to a task';
                $link = "opl/viewTaskDetails/" . $code . "/" . $this->session->details->grade_level_id . "/" . $this->session->details->section_id . "/" . $this->session->school_year;
                Modules::run('notification_system/sendNotification', 1, 3, $this->session->details->st_id, $this->post('teacher'), $remarks, date('Y-m-d'), $link);
                echo 'Response Successfully Submitted';
            else:
                echo 'Something went wrong, Please try again later';
            endif;
        else:
            if ($started->format("%R") == "-"):
                echo "This task has not yet started.";
            elseif ($remaining->format("%R") == "+"):
                echo "This task has already ended.";
            endif;
        endif;
    }

    public function viewTaskDetails($task_id, $subject_id, $school_year = NULL)
    {
        $school_year = ($school_year == NULL ? $this->session->school_year : $school_year);
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_level_id, $this->session->details->grade_level_id, $subject_id, $school_year));
        $taskDetails = array(

            'isClass'       => TRUE,
            'task'          =>  $this->opl_model->getTaskDetails($task_id, $school_year),
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'school_year'   => $school_year,
            'headerTitle'   => $classDetails->subjectDetails->subject . ' - Task Details',
            'main_header'   => '',
            'title'         => 'Aqademix Online Platform for Learning',
            'main_content'  => 'tasks/taskDetails',
            'modules'       => 'opl',
        );

        echo Modules::run('templates/opl_content', $taskDetails);
    }

    public function index()
    {
        // $this->session->isEnrollment
        // $main_content = ($this->session->isEnrollment != 1 ? 'students/default' : 'college/enrollment/en_dashboard');
        // if ($this->session->isEnrollment != 1):
        $settings = Modules::run('main/getSet');
        $start = new DateTime($settings->bosy);
        $end = new DateTime();
        $end->setTime(0, 0, 0);
        $interval = new DateInterval('P1D');

        $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

        $weekdays = 0;
        $pdays = 0;

        foreach ($period as $date):
            if ($date->format('N') < 6) {
                $tday = 1;
                $m = $date->format('m');
                $y = $date->format('Y');
                $d = $date->format('d');
                $isHoliday = Modules::run('calendar/dateExist', $date->format('Y-m-d'));
                $t = Modules::run('attendance/ifPresent', $this->session->details->st_id, $d, $m, $y, $this->session->details->school_year);
                if ($t):
                    $pdays++;
                endif;
                // $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $this->session->details->st_id, $m, $y, $this->session->details->school_year);
                $weekdays += ($tday - ($isHoliday ? 1 : 0));
            }
        endforeach;

        $att_percent = round(($pdays / $weekdays) * 100);

        $subList = [];
        $q1 = [];
        $q2 = [];
        $q3 = [];
        $q4 = [];
        $subjTeacher = [];
        $tasks = [];
        $activities = [];
        $subjects = $this->student_model->getSubjectList($this->session->details->grade_level_id, $this->session->details->school_year);
        foreach ($subjects as $s):
            $tlist = [];
            $st = $this->student_model->getSubjectTeacher($this->session->details->grade_level_id, $s->subject_id);
            if ($st):
                $first = Modules::run('gradingsystem/getFinalGrade', $this->session->details->st_id, $s->subject_id, 1, $this->session->details->school_year);
                $second = Modules::run('gradingsystem/getFinalGrade', $this->session->details->st_id, $s->subject_id, 2, $this->session->details->school_year);
                $third = Modules::run('gradingsystem/getFinalGrade', $this->session->details->st_id, $s->subject_id, 3, $this->session->details->school_year);
                $fourth = Modules::run('gradingsystem/getFinalGrade', $this->session->details->st_id, $s->subject_id, 4, $this->session->details->school_year);
                $task_list = $this->opl_model->getTask($this->session->details->grade_level_id, $this->session->details->section_id, $s->subject_id, $this->session->details->school_year, 1);
                $first = ($first->num_rows() > 0 ? $first->row->final_rating : 0);
                $second = ($second->num_rows() > 0 ? $second->row->final_rating : 0);
                $third = ($third->num_rows() > 0 ? $third->row->final_rating : 0);
                $fourth = ($fourth->num_rows() > 0 ? $fourth->row->final_rating : 0);

                foreach ($task_list as $tl):
                    $isSubmitted = Modules::run('opl/opl_variables/getSubmittedTask', $tl->task_code, $this->session->details->school_year, $this->session->details->st_id);
                    $tlist[] = [
                        'task_code' => $tl->task_code,
                        'task_title' => $tl->task_title,
                        'due_date'  => $tl->task_end_time,
                        'link'      => base_url() . 'opl/viewTaskDetails/' . $tl->task_code . '/' . $this->session->details->grade_level_id . '/' . $this->session->details->section_id . '/' . $s->subject_id . '/' . $this->session->details->school_year,
                        'status' => ($isSubmitted->row() ? 'Completed' : 'Pending')
                    ];

                    if ($isSubmitted->row()):
                        $activities[] = [
                            'dateTime'  => $isSubmitted->row()->ts_date_submitted,
                            'taskTitle' => $isSubmitted->row()->task_title,
                            'description' => 'You submitted ' . $isSubmitted->row()->task_title . ' ' . $isSubmitted->row()->tt_type . ' on ' . $s->subject
                        ];
                    endif;
                endforeach;

                if (!empty($task_list)):
                    $tasks[] = array(
                        't_subject' => $s->subject,
                        'listTask'  => $tlist,
                    );
                endif;

                $faDetails = array(
                    'is_assigned'   => ($st ? 1 : 0),
                    'f_subject' => $s->subject,
                    'f_name'    => ucwords(strtolower($st->firstname . ' ' . $st->lastname)),
                    'f_gender'  => $st->sex,
                    'f_avatar'  => $st->avatar
                );
                array_push($subjTeacher, $faDetails);
                $subList[] = "'" . $s->subject . "'";

                $q1[] = ($first != '' || $first != 0 ? $first : 0);
                $q2[] = ($second != '' || $second != 0 ? $second : 0);
                $q3[] = ($third != '' || $third != 0 ? $third : 0);
                $q4[] = ($fourth != '' || $fourth != 0 ? $fourth : 0);
            endif;
        endforeach;
        $userAcc = $this->checkUserAcc(base64_encode($this->session->details->st_id), $this->session->details->school_year, 'dd');
        $msg = Modules::run('opl/messages/getUnreadMsg', base64_encode($this->session->details->st_id), null);
        $messages = [];
        foreach ($msg->result() as $m):
            $sender = Modules::run('opl/messages/getSender', base64_encode($m->sender));
            $subject = $this->student_model->getSubjectByID($m->subject_id);
            $messages[] = [
                'sender' => $sender->firstname . ' ' . $sender->lastname,
                's_gender' => $sender->sex,
                's_avatar' => $sender->avatar,
                'content' => $m->content,
                'date_sent' => $m->date_sent,
                'subject_msg' => $m->subject_msg,
                'subject_id' => $m->subject_id,
                'subject' => $subject->subject,
                'msg_recpt_id' => $m->msg_recpt_id,
                'opl_msg_id' => $m->opl_msg_id,
                'grade_id' => $this->session->details->grade_level_id,
                'section_id' => $this->session->details->section_id
            ];
        endforeach;
        $data = array(
            'isClass'       => FALSE,
            'subjectDetails' => NULL,
            'ua_student'    => $userAcc,
            'subjectTeacher' => $subjTeacher,
            'attPercentage'  => $att_percent,
            'activities'    => $activities,
            'totalDays'     => $weekdays,
            'totalPresent'  => $pdays,
            'taskList'      => $tasks,
            'unread'        => $msg->num_rows(),
            'messages'      => $messages,
            'subjectList'   => implode(',', $subList),
            'first'         => implode(',', $q1),
            'second'        => implode(',', $q2),
            'third'         => implode(',', $q3),
            'fourth'        => implode(',', $q4),
            'section'       => Modules::run('opl/opl_variables/getSectionDetails', $this->session->details->grade_level_id, $this->session->details->section_id, $this->session->details->school_year),
            'post'          => $this->opl_model->getPost($this->session->st_id, $this->session->details->grade_level_id, $this->session->details->section_id),
            'headerTitle'   => 'Dashboard',
            'main_header'   => '<strong>Sneak Peek!</strong> Welcome to <strong>Aqademix Online Platform for Learning </strong>.',
            'title'         => 'Aqademix Online Platform for Learning',
            'main_content'  => 'students/default',
            'login_page' => 'studentsEntrance',
            'modules'       => 'opl',
        );

        echo Modules::run('templates/opl_content', $data);
        // else:
        //     echo Modules::run('college/enrollment/en_dashboard');
        // endif;
    }

    function isHoliday($date, $school_year)
    {
        return $this->student_model->isHoliday($date, $school_year);
    }

    public function classBulletin($subject = NULL, $school_year = NULL, $task = NULL)
    {
        $classDetails = json_decode(Modules::run('opl/opl_variables/getClassDetails', $this->session->details->grade_id, $this->session->details->section_id, $subject, $school_year));
        Modules::run('opl/setBasicOplSessions', $subject, $this->session->details->grade_id, $this->session->details->section_id, $school_year);

        $data = array(
            'isClass'           => TRUE,
            'school_year'       => $school_year,
            'gradeDetails'      => $classDetails->basicInfo,
            'subjectDetails'    => $classDetails->subjectDetails,
            'headerTitle'       => $classDetails->subjectDetails->subject . ' - ' . $classDetails->basicInfo->level . ' [ ' . $classDetails->basicInfo->section . ' ] Class Bulletin',
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
        if (!$isClass):
            $data['subjectsList'] = $this->student_model->getSubjectList($this->session->details->grade_id, $this->session->school_year);
            $this->load->view('students/widgets/myClasses', $data);
        else:
            $data['tasks']   = $this->opl_model->getTask($this->session->details->grade_id, $this->session->details->section_id, $subjectDetails->subject_id, $this->session->school_year, $this->session->isStudent);
            $this->load->view('students/widgets/taskList', $data);
        endif;
    }

    function getSingleStudent($id, $school_year, $sem = null)
    {
        return $this->student_model->getSingleStudent(base64_decode($id), $school_year, $sem);
    }

    function viewDetails($id, $year = NULL, $semester = NULL)
    {
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

    public function getROYear()
    {
        $year = Modules::run('registrar/getROYear');
        return $year;
    }

    function checkUserAcc($stid, $sy, $opt)
    {
        return $this->student_model->checkUserAcc(base64_decode($stid), $sy, $opt);
    }

    function changePass()
    {
        $st_id = $this->input->post('st_id');
        $newpass = $this->input->post('newpass');

        return $this->student_model->changePass(base64_decode($st_id), $newpass);
    }

    function logout()
    {
        $st_id = $this->session->userdata('st_id');
        $this->student_model->logout($st_id);
        $this->session->sess_destroy();
        $session_id = $this->session->userdata('session_id');
        if ($session_id == "" || $session_id == null) {
            $this->student_model->logout($st_id);
        }
        Modules::run('main/logActivity', 'INFO',  $this->session->userdata('name') . ' has logged Out.', $st_id);
        redirect(base_url() . 'entrance');
    }
}
