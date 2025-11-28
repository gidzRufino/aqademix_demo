<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Pp extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('pp_model');
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function numberOfSchoolDays($month, $year, $sy=NUll)
    {
        $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'first');
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $month, 10)), $year, 'last');
        $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $month, $year);
        $holiday = Modules::run('calendar/holidayExist', $month, $year, $sy);
        $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
        return $totalDaysInAMonth;
    }
    
    function getStudentData()
    {
        $id = $this->post('user_id');
        $year = $this->post('year');
        $option = $this->post('option');
        
        $data['student'] = Modules::run('registrar/getBasicInfo', $id, $year);
        $data['user_id'] = $id;
        $data['year'] = $year;
        
        $data['grade_id'] = $this->post('grade_id');
        switch ($option):
            case 'acad':
                $this->load->view('academicPerformance', $data);
            break;
            case 'attend':
                $this->load->view('attendanceRecord', $data);
            break;
        endswitch;
    }
            
    function studentDetails()
    {
        $id = $this->post('id');
        $year = $this->post('year');
        $grade_id = $this->post('grade_id');
        
        $student = Modules::run('registrar/getBasicInfo', $id, $year);
        
        echo json_encode(array(
            'grade_id'   => $grade_id,
            'user_id'   => $id,
            'st_id'     => $student->st_id,
            'firstname' => $student->firstname,
            'lastname'  => $student->lastname,
        ));
        
    }
    
    function verifyChild($child, $mobile ,$sy)
    {
        $verified = $this->pp_model->verifyChild($child, $mobile ,$sy);
        return $verified;
    }
    
    function inbox()
    {
        $data['main_content'] = 'inbox';
        $data['modules'] = 'pp';
        echo Modules::run('templates/parent_content', $data);
    }
            
    function dashboard()
    {
        $data['settings'] = $this->eskwela->getSet();
        $data['modules'] = 'pp';
        $data['main_content'] = 'parent_dashboard';
        echo Modules::run('templates/parent_content', $data);
    }
    
    function subjectTeachers($child_links=NULL)
    {
        $data['child_links'] = base64_decode($child_links);
        $data['modules'] = 'pp';
        $data['main_content'] = 'subjectTeachers';
        echo Modules::run('templates/parent_content', $data);
    }
    
    function students($child_links=NULL)
    {
        $data['ro_years'] = Modules::run('registrar/getROYear');
        if(Modules::run('main/detect_column', 'esk_settings', 'use_canteen')):
            $data['settings'] = Modules::run('main/getSet');
        endif;
        $data['child_links'] = base64_decode($child_links);
        $data['main_content'] = 'parentRoster';
        $data['modules'] = 'pp';
        echo Modules::run('templates/parent_content', $data);
    }
    
    function getNumberOfStudents($parent_id=NULL)
    {
        $students = $this->pp_model->getNumberOfStudents($parent_id);
        return $students->num_rows();
    }
    
    function getFinanceAccounts($child_links = NULL)
    {
        $data['child_links'] = base64_decode($child_links);
        $data['main_content'] = 'financeRecords';
        $data['modules'] = 'pp';
        echo Modules::run('templates/parent_content', $data);
        
    }
}

