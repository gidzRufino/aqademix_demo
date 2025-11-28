<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class attendance_reports extends MX_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('attendance_reports_model');
        set_time_limit(300);
    }
    
    function updateTimeAttendance($inam, $outam, $inpm, $outpm, $tid) {
        $newTime = array(
            'time_in' => $inam,
            'time_out' => $outam,
            'time_in_pm' => $inpm,
            'time_out_pm' => $outpm
        );

        $this->attendance_reports_model->updateTimeAttendace($newTime, $tid);
    }

    function updateSPR() {
        $eJun = $this->input->post('eJun');
        $eJul = $this->input->post('eJul');
        $eAug = $this->input->post('eAug');
        $eSept = $this->input->post('eSept');
        $eOct = $this->input->post('eOct');
        $eNov = $this->input->post('eNov');
        $eDec = $this->input->post('eDec');
        $eJan = $this->input->post('eJan');
        $eFeb = $this->input->post('eFeb');
        $eMar = $this->input->post('eMar');
        $eApr = $this->input->post('eApr');
        $sprid = $this->input->post('sprid');
        $tbleName = $this->input->post('tbleName');
        $details = array(
            'June' => $eJun,
            'July' => $eJul,
            'August' => $eAug,
            'September' => $eSept,
            'October' => $eOct,
            'November' => $eNov,
            'December' => $eDec,
            'January' => $eJan,
            'February' => $eFeb,
            'March' => $eMar,
            'April' => $eApr
        );

        $this->attendance_reports_model->updateSPR($details, $sprid, $tbleName);
    }

    function post($name) {
        return $this->input->post($name);
    }

    function mergedb() {
        $db = $this->eskwela->db(2017);
        $db->where('att_id >=', '60471');
        $q = $db->get('attendance_sheet');
        $i = 0;
        foreach ($q->result() as $attedance):
            $details = array(
                'att_st_id' => $attedance->att_st_id,
                'u_rfid' => $attedance->u_rfid,
                'time_in' => $attedance->time_in,
                'time_out' => $attedance->time_out,
                'timestamp' => $attedance->timestamp,
                'date' => $attedance->date,
                'time_in_pm' => $attedance->time_in_pm,
                'time_out_pm' => $attedance->time_out_pm,
                'status' => $attedance->status,
                'remarks' => $attedance->remarks,
                'remarks_from' => $attedance->remarks_from
            );
//            if($this->db->insert('attendance_sheet', $details)):
//                $i++;
//            endif;

        endforeach;

        echo 'Successfully Inserted ' . $i;
    }
    
    function getStudentsTardy($grade_level_id){
        $settings = Modules::run('main/getSet');
        $data['school_year'] = $settings->school_year;
        $data['students'] = $this->attendance_reports_model->getStudentsTardy($grade_level_id);
        $this->load->view('studentsAttendanceTardy', $data);
    }

    function getStudentsByLevel($grade_level_id) {
        $settings = Modules::run('main/getSet');
        $data['school_year'] = $settings->school_year;
        $data['students'] = $this->attendance_reports_model->getStudentsByLevel($grade_level_id);
        $this->load->view('studentsAttendanceTable', $data);
    }
    
    function getGeneratedTardy($grade_level_id) {
        $settings = Modules::run('main/getSet');
        $data['school_year'] = $settings->school_year;
        $data['students'] = $this->attendance_reports_model->getStudents($grade_level_id);
        $this->load->view('studentsAttendanceGenTardy', $data);
    }

    function getStudents($grade_level_id) {
        $settings = Modules::run('main/getSet');
        $data['school_year'] = $settings->school_year;
        $data['students'] = $this->attendance_reports_model->getStudents($grade_level_id);
        $this->load->view('studentsAttendanceSPR', $data);
    }

    function getIndividualMonthlyAttedance($st_id, $month, $year, $school_year, $spr_id) {
//        $attendance = Modules::run('attendance/getIndividualMonthlyAttendance', $st_id, $month, $year, $school_year);
        $attendance = $this->attendance_reports_model->getIndividualMonthlyAttendance($st_id, $month, $year, $school_year);
        $monthName = date('F', strtotime(date('Y-' . $month . '-01')));
        $attDetails = array(
            'spr_id' => $spr_id,
            $monthName => $attendance,
        );

        if ($this->attendance_reports_model->saveAttSPR($spr_id, $attDetails)):
            echo $attendance;
        endif;
    }
    
    function getIndivualTardy($st_id, $month, $year, $school_year, $spr_id){
        $tardy = $this->getTotalTardyPerStudent($st_id, $month, $year);
        $monthName = date('F', strtotime(date('Y-' . $month . '-01')));
        $attDetails = array(
            'spr_id' => $spr_id,
            $monthName => count($tardy->result()),
        );
        
        if ($this->attendance_reports_model->saveAttTardy($spr_id, $attDetails)):
            echo count($tardy->result());
        endif;
    }

    function getTotalTardyPerStudent($st_id, $month, $year) {
        $tardy = $this->attendance_reports_model->getTardy($st_id, $month, $year);
        return $tardy;
    }

    function getAttendancePerStudent($st_id, $grade_level, $year) {
        $attendance = $this->attendance_reports_model->getAttendancePerStudent($st_id, $grade_level, $year);
        return $attendance;
    }

    function saveSPR($level) {
        $students = Modules::run('registrar/getAllStudentsByLevel', $level);

        foreach ($students->result() as $s):
            $this->attendance_reports_model->saveSPRDetails($s->st_id, $this->session->school_year, $level);
        endforeach;

        echo 'Successfully Generates ' . $students->num_rows() . ' sp records';
    }

    function saveSPRAttendance($level, $year = NULL) {
        $year = ($year == NULL ? $this->session->school_year : $year);

        $sprDetails = $this->attendance_reports_model->getSPRDetails($level, $year);
        foreach ($sprDetails->result() as $spd):
            $aOctober = $this->attendance_reports_model->getIndividualMonthlyAttendance($spd->st_id, 10, $year, $this->session->school_year);
            $aNovember = $this->attendance_reports_model->getIndividualMonthlyAttendance($spd->st_id, 11, $year, $this->session->school_year);
            $aDecember = $this->attendance_reports_model->getIndividualMonthlyAttendance($spd->st_id, 12, $year, $this->session->school_year);

            $attDetails = array(
                'spr_id' => $spd->spr_id,
                'October' => $aOctober,
                'November' => $aNovember,
                'December' => $aDecember
            );

            if ($this->attendance_reports_model->saveAttSPR($spd->spr_id, $attDetails)):
                echo 'Successfully Generated';
            endif;
        endforeach;
    }

    function monitorAttendanceUpdates($level, $rows) {
        $sprDetails = $this->attendance_reports_model->getSPRAttPerLevel($level);
        $sprRows = $sprDetails->num_rows();
        $pasttime = time();

        echo json_encode(array('row' => $sprRows, 'msg' => 'Number of Generated Attendance Summary ' . $sprRows));
    }

    function saveAttendancePerStudentPerMonth($st_id, $grade_level, $m, $attendance, $year) {
        $month = date('F', strtotime(date('Y-' . $m . '-d')));
        if ($this->attendance_reports_model->saveAttendancePerStudentPerMonth($st_id, $grade_level, $month, $attendance, $year)):
            return;
        endif;
    }

    function attendancePerSection($section = NULL, $month = NULL) {
        $settings = Modules::run('main/getSet');
        $data['month'] = $month;
//        $data['sections'] = $this->attendance_reports_model->getAllSection($settings->school_year);
        $data['grade'] = $this->attendance_reports_model->getGradeLevel($settings->school_year);
        $data['section_id'] = $section;
//        $data['male'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section, 'Male', "1", $settings->school_year);
//        $data['female'] = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section, 'Female', "1", $settings->school_year);
        $data['modules'] = 'attendance';
        $data['main_content'] = 'attendancePerSection';
        echo Modules::run('templates/main_content', $data);
    }

    function attendanceReportPerMonth($section, $month) {
        $data['month'] = $month;
        $data['sections'] = Modules::run('registrar/getAllSection');
        $data['section_id'] = $section;
        $data['modules'] = 'attendance';
        $data['main_content'] = 'attendancePerSection';
        echo Modules::run('templates/main_content', $data);
    }

    function insertMergedb($details) {
        //$this->db->insert('attendance_sheet', $details);
    }

    function dailyEmployeeAttendance() {
        
    }

    function removeFromLate() {
        $att_id = $this->post('att_id');

        $details = array(
            'remarks' => 0
        );
        if ($this->attendance_reports_model->removeFromLate($att_id, $details)):
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => TRUE));
        endif;
    }

    function dailyTardy($date = NULL, $school_year = NULL) {
        if (!$this->session->userdata('is_logged_in')):
            redirect('login');
        else:
            $data['date'] = ($date == NULL ? date('Y-m-d') : $date);
            if ($this->session->is_admin):
                $data['grade'] = Modules::run('registrar/getGradeLevel');
            elseif ($this->session->is_adviser):
                $data['grade'] = Modules::run('registrar/getSectionById', $this->session->advisory);
            endif;
            $data['modules'] = 'attendance';
            $data['main_content'] = 'reports/dailyTardy';
            echo Modules::run('templates/main_content', $data);
        endif;
    }

    function lateStudentsPerSection($date, $section) {
        $data['date'] = ($date == NULL ? date('Y-m-d') : $date);
        $data['tardy'] = Modules::run('attendance/attendance_reports/tardyPerSection', $date, $section);
        $this->load->view('reports/lateStudentsPerSection', $data);
    }

    function dailyTardyPerSection($date, $grade_level) {
        $data['date'] = ($date == NULL ? date('Y-m-d') : $date);
        $data['gradeLevel'] = $grade_level;
        if ($this->session->is_admin):
            $data['section'] = Modules::run('registrar/getSectionByGradeId', $grade_level);
        elseif ($this->session->is_adviser):
            $data['section'] = Modules::run('registrar/getSectionById', $this->session->advisory);
        endif;
        $this->load->view('reports/dailyTardyPerSection', $data);
    }

    function getTotalAttendance($grade_id, $date) {
        $attendance = $this->attendance_reports_model->getAttendance($grade_id, $date);
        return $attendance;
    }

    function getAttendancePerSection($grade_id, $date) {
        $attendance = $this->attendance_reports_model->getAttendancePerSection($grade_id, $date);
        return $attendance;
    }

    function dailyTardyPerLevel($date, $grade_level, $section = NULL, $school_year = NULL) {
        $tardy = $this->attendance_reports_model->dailyTardyPerLevel($date, $grade_level, $section, $school_year);
        return $tardy;
    }

    function tardyPerSection($date, $section, $school_year = NULL) {
        $tardy = $this->attendance_reports_model->dailyTardyPerSection($date, $section, $school_year);
        return $tardy;
    }

}
