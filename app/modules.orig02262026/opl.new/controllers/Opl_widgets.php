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
class Opl_widgets extends MX_Controller
{
    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->model('Opl_widgets_model');
    }

    function post($name)
    {
        return $this->input->post($name);
    }

    function getAdminListOfClasses()
    {
        $this->load->view('admin/widgets/adminListOfClasses');
    }

    function getTasksByType()
    {
        $response = $this->Opl_widgets_model->getTasksByType($this->post('grade'), $this->post('section'), $this->post('subject'), $this->post('task_type'));
        echo json_encode(array("hasUpdate" => true, "total" => $response['total'], "submitted" => $response['submitted']));
    }

    function getStudentOnlinePresent()
    {
        $response = $this->Opl_widgets_model->getStudentOnlinePresent($this->post('section'), $this->post('grade'));
        if ($response->count != $this->post('count')):
            echo json_encode(array("hasUpdate" => true, "count" => $response->count));
        else:
            echo json_encode(array("hasUpdate" => false));
        endif;
    }

    function topWidget($subject_id, $section_id, $grade_level = NULL)
    {
        $data = array(
            'grade_id'      =>  $grade_level,
            'section_id'    =>  $section_id,
            'subject_id'    =>  $subject_id,
            'faculty_id'    =>  $this->session->username,
        );
        $this->load->view('widgets/topWidget', $data);
    }

    function getDiscussion()
    {
        $grade_id = $this->input->post('grade');
        $section_id = $this->input->post('section');
        $subject_id = $this->input->post('subject');
        $faculty_id = $this->input->post('teacher');
        $discussion = Modules::run('opl/opl_variables/getDiscussionList', $faculty_id, $grade_id, $section_id, $subject_id, $this->session->school_year);
        $discuss = [];

        if (count($discussion) > 0):
            foreach ($discussion as $d):
                $comm = Modules::run('opl/opl_variables/getCommentList', $d->dis_sys_code, 3, $this->session->school_year);

                $comment = [];
                if ($comm->num_rows() > 0):
                    foreach ($comm->result() as $cm):
                        $sender = Modules::run('opl/messages/getSender', base64_encode($cm->com_from));
                        $replies = Modules::run('opl/opl_variables/getReplies', $cm->com_sys_code, $this->session->school_year);

                        $reply = [];
                        if (count($replies) > 0):
                            foreach ($replies as $r):
                                $sent = Modules::run('opl/messages/getSender', base64_encode($r->com_from));

                                $reply[] = array(
                                    'sender' => $sent->firstname . ' ' . $sent->lastname,
                                    'msg' => $r->com_details,
                                    'date_sent' => date('F j, Y @ h:i:s a', strtotime($r->com_timestamp))
                                );
                            endforeach;
                        endif;

                        $comment[] = array(
                            'sender' => $sender->firstname . ' ' . $sender->lastname,
                            'msg' => $cm->com_details,
                            'date_sent' => date('F j, Y @ h:i:s a', strtotime($cm->com_timestamp)),
                            'reply' => $reply
                        );
                    endforeach;
                endif;

                $discuss[] = array(
                    'title' => $d->dis_title,
                    'start_date' => date('F j, Y @ h:i:s a', strtotime($d->dis_start_date)),
                    'com_count' => $d->com_count,
                    'sys_code' => $d->dis_sys_code,
                    'sy' => $this->session->school_year,
                    'comment' => $comment
                );
            endforeach;
            echo json_encode(
                array(
                    'hasDiscussion' => true,
                    'discussion' => $discuss
                )
            );
        else:
            echo json_encode(
                array(
                    'hastDiscussion' => false,
                    'discussion' => $discuss
                )
            );
        endif;
    }

    function getTaskSubmittedRatio()
    {
        $grade_id = $this->input->post('grade');
        $section_id = $this->input->post('section');
        $subject_id = $this->input->post('subject');
        $faculty_id = $this->input->post('teacher');
        $task = $this->Opl_widgets_model->getActiveTask($grade_id, $section_id, $subject_id, $faculty_id);
        $students = Modules::run('opl/getStudentsBySection', $grade_id, $section_id);
        $d = json_decode(Modules::run('opl/opl_variables/getClassDetails', $grade_id, $section_id, $subject_id, $this->session->school_year));

        $tt = 0;
        $tStud = 0;
        $sb = 0;
        $complete = 0;
        $submitted = 0;
        $perTask = [];
        if ($task->num_rows() > 0):
            foreach ($task->result() as $t):
                $tt++;
                $ts = 0; //===> Total Students per section
                $submittedPerTask = 0;
                foreach ($students as $st):
                    $tStud++;
                    $ts++;
                    $ss = Modules::run('opl/opl_variables/getSubmittedTask', $t->task_code, $this->session->school_year, $st->st_id);
                    if ($ss->num_rows() > 0):
                        $sb++;
                        $submitted++;
                        $submittedPerTask++;
                    endif;
                endforeach;
                $perTask[] = array(
                    'task_code' => $t->task_code,
                    'subj_id' => $subject_id,
                    'grade_id' => $grade_id,
                    'section_id' => $section_id,
                    'subject' => $d->subjectDetails->subject,
                    'level' => $d->basicInfo->level,
                    'section' => $d->basicInfo->section,
                    'task_title' => $t->task_title,
                    'deadline' => 'Deadline: ' . date('F j, Y h:i:s a', strtotime($t->task_end_time)),
                    'total_students' => $ts,
                    'total_submitted' => $submittedPerTask,
                    'sy' => $this->session->school_year
                );
                if ($submitted == $ts):
                    $complete++;
                endif;
            endforeach;
            echo json_encode(
                array(
                    'hasUpdate' => true,
                    'submitted' => $submitted,
                    'totalStudents' => $tStud,
                    'total_task' => $tt,
                    'completed' => $complete,
                    'pTask' => $perTask
                )
            );
        else:
            echo json_encode(
                array(
                    'hasUpdate' => false,
                    'submitted' => 0,
                    'totalStudents' => 0,
                    'total_tasks' => 0,
                    'completed' => $complete,
                    'pTask' => $perTask
                )
            );
        endif;
    }

    function myClasses($isClass, $subjectDetails = NULL)
    {
        if (!$this->session->isStudent):
            $data['getAssignment'] = $this->mySubject($this->session->username, $this->session->school_year);
            $this->load->view('widgets/myClasses', $data);
        else:
            if ($this->session->isCollege):
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

    function teachersWidget($subjectDetails)
    {
        $tt = 0; // total tasks
        $percentPerTask = [];
        $perTask = [];
        $sb = 0; //===> total submitted
        $tStud = 0;
        foreach ($subjectDetails as $s):
            $task = $this->Opl_widgets_model->getActiveTask($s->grade_id, $s->section_id, $s->subject_id, $s->faculty_id);
            $students = Modules::run('opl/getStudentsBySection', $s->grade_id, $s->section_id);
            $complete = 0;


            if ($task->num_rows() > 0):
                foreach ($task->result() as $t):
                    $tt++;
                    $submitted = 0;
                    $ts = 0; //===> Total Students per section
                    foreach ($students as $st):
                        $tStud++;
                        $ts++;
                        $ss = Modules::run('opl/opl_variables/getSubmittedTask', $t->task_code, $this->session->school_year, $st->st_id);
                        if ($ss->num_rows() > 0):
                            $sb++;
                            $submitted++;
                        endif;
                    endforeach;
                    $perTask[] = array(
                        'task_code' => $t->task_code,
                        'subj_id' => $s->subject_id,
                        'grade_id' => $s->grade_id,
                        'section_id' => $s->section_id,
                        'subject' => $s->subject,
                        'level' => $s->level,
                        'section' => $s->section,
                        'task_title' => $t->task_title,
                        'total_students' => $ts,
                        'total_submitted' => $submitted
                    );
                    if ($submitted == $ts):
                        $complete++;
                    endif;
                endforeach;
            endif;
        endforeach;

        $message = Modules::run('opl/messages/getUnreadMsg', base64_encode($this->session->employee_id), null);
        $msg = [];
        $mCount = 0;
        if ($message->num_rows() > 0):
            foreach ($message->result() as $m):
                $mCount++;
                $sender = Modules::run('opl/student/getSingleStudent', base64_encode($m->sender), $this->session->school_year, null);
                // $orig = Modules::run('opl/messages/getOrigMsg', $m->parent_id);
                $msg[] = array(
                    'msg_id' => base64_encode($m->replied_msg_id ?? ($m->opl_msg_id ?? 0)),
                    'subject_id' => $m->subject_id,
                    'grade_id' => $sender->grade_id,
                    'section_id' => $sender->section_id,
                    'sender' => $sender->firstname . ' ' . $sender->lastname,
                    'orig' => ($m->parent_id != 0 ? 'Re: ' . $m->subject_msg : $m->subject_msg),
                    'dateSent' => $m->date_sent
                );
            endforeach;
        endif;
        $data = array(
            'subjectDetails' => $subjectDetails,
            'totalTask' => $tt,
            'completed' => $complete,
            'pTask' => $percentPerTask,
            'totalStudents' => $tStud,
            'totalSubmit' => $sb,
            'perTask' => $perTask,
            'messages' => $msg,
            'msgCount' => $mCount
        );
        $this->load->view('widgets/teachersWidget', $data);
    }
}
