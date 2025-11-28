<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_variables
 *
 * @author genesisrufino
 */
class Opl_variables extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
        $this->load->model('opl_variables_model');
    }
    
    function fetchLesson($details, $school_year = NULL)
    {
        $detailItem = explode('-', $details);
        $units = $this->opl_variables_model->fetchLesson($detailItem[0],$detailItem[1], $school_year);
        foreach($units as $unit):
            echo "<option value='$unit->ou_opl_code'>$unit->ou_unit_title</option>";
        endforeach;
    }
            
    function getDiscussionList($em_id, $grade_id = NULL, $section_id = NULL, $subject_id, $school_year = NULL)
    {
        $discussions = $this->opl_variables_model->getDiscussionList($em_id, $grade_id, $section_id, $subject_id, $school_year);
        return $discussions;
    }
    
    function getStudents($grade_level, $section_id, $school_year)
    {
        $students = $this->opl_variables_model->getStudents($grade_level, $section_id, $school_year);
        return $students;
    }
    
    function getComments($com_to, $com_type, $school_year){
        $data['comments'] = $this->opl_variables_model->getComments($com_to, $com_type, $school_year);
        $this->load->view('comments', $data);
    }
    
    function getBasicEmployee($em_id, $school_year)
    {
        $employee = $this->opl_variables_model->getBasicEmployee($em_id, $school_year);
        return $employee;
    }
    
    function getStudentBasicEdInfoByStId($st_id, $school_year = NULL)
    {
        $student = $this->opl_variables_model->getStudentBasicEdInfoByStId($st_id, $school_year );
        return $student;
    }
    
    function getSubmittedTask($task_id=NULL, $school_year=NULL, $student_id = NULL)
    {
        $task = $this->opl_variables_model->getSubmittedTask($task_id, $school_year, $student_id);
        return $task;
    }
    
    function getTaskType()
    {
        $taskType = $this->opl_variables_model->getTaskType();
        return $taskType;
    }
    
    function getTaskByCode($code, $school_year)
    {
        $task = $this->opl_variables_model->getTaskByCode($code, $school_year);
        return $task;
    }
    
    function getAllUnits($employee_id, $school_year, $grade_id=NULL)
    {
        $unitLessons = $this->opl_variables_model->getAllUnits($employee_id, $school_year,$grade_id);
        return $unitLessons;
    }
    
    function getGradeLevel($grade_id=NULL, $school_year = NULL)
    {
        $gradeLevel = $this->opl_variables_model->getGradeLevel($grade_id, $school_year);
        return $gradeLevel;
    }
    
    function getSubjects()
    {
        $subject = $this->opl_variables_model->getSubjects();
        return $subject;
    }
    
    function getClassDetails($gradeLevel, $section, $subject, $school_year)
    {
        $details = array(
            'basicInfo'         => $this->opl_variables_model->getClassDetails($gradeLevel, $section, $school_year),
            'subjectDetails'    => $this->getSubjectById($subject),
            'unitDetails'       => $this->getAllUnits($this->session->username, $school_year, $gradeLevel)
        );
        
        return json_encode($details);
    }
    
    function getSubjectById($subject_id)
    {
        return $this->opl_variables_model->getSubjectById($subject_id);
    }
}
