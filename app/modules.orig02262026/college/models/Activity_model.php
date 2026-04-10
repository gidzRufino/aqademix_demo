<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activity_model extends CI_Model {

    function saveAttendanceManual($st_id, $act_id, $time){
        $time = Date('H:i:s', strtotime($time));
        $st_id = base64_decode($st_id);
        $query = $this->db->where('act_id', $act_id)
                            ->where('st_id', $st_id)
                            ->get('activity_attendance');
        if($query->num_rows() != 0):
            $data = array(
                'act_in'    =>  $time
            );
            $this->db->where('act_id', $act_id)
                    ->where('st_id', $st_id)
                    ->update('activity_attendance', $data);
        else:
            $data = array(
                'st_id'     =>  $st_id,
                'act_id'    =>  $act_id,
                'act_in'    =>  $time
            );
            $this->db->insert('activity_attendance', $data);
        endif;
        $act = $this->db->where('act_id', $act_id)
                        ->get('activity_attendance')
                        ->result();
        $html = '';
        foreach($act AS $a):
            $prof = $this->activity_model->fetchProfile($a->st_id)->row();
            $html .= '<tr>';
            $html .= '<td>'.mb_strtoupper($prof->firstname." ".$prof->lastname, 'UTF-8').'</td>';
            $html .= '<td class="text-center">'.Date('h:i a', strtotime($a->act_in)).'</td>';
            $html .= '<td class="text-center">'.($a->act_out != '' ? Date('h:i a', strtotime($a->act_out)) : '-').'</td>';
            $html .= '</tr>';
        endforeach;
        return $html;
    }

    function search($value, $dept)
    {
        switch($dept):
            case 1:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('profile_students_admission.admission_id AS gID')
                                    ->select('profile_students_c_admission.admission_id AS cID')
                                    ->select('grade_level.level AS gLevel')
                                    ->select('section.section AS gSec')
                                    ->select('c_courses.course')
                                    ->select('profile_students_c_admission.year_level')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_admission', 'profile_students.st_id = profile_students_admission.st_id', 'LEFT')
                                    ->join('profile_students_c_admission', 'profile_students.st_id = profile_students_c_admission.st_id', 'LEFT')
                                    ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'LEFT')
                                    ->join('section', 'profile_students_admission.section_id = section.section_id', 'LEFT')
                                    ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id', 'LEFT')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")')
                                    ->where('((esk_profile_students_admission.st_id != "" OR esk_profile_students_c_admission.st_id != "") AND esk_profile_students.status = 1)')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    if($s->gID != NULL):
                        $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->gLevel.'`), loadElemDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->gLevel.'`, `'.$s->gSec.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->gLevel.'</li>';
                    else:
                        $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->course.'`), loadColDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->course.'`, `'.$s->year_level.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->course.'</li>';
                    endif;
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 2:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('c_courses.course')
                                    ->select('profile_students_c_admission.year_level')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_c_admission', 'profile_students.st_id = profile_students_c_admission.st_id', 'INNER')
                                    ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")')
                                    ->where('(esk_profile_students_c_admission.st_id != "" AND esk_profile_students.status = 1)')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->course.'`), loadColDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->course.'`, `'.$s->year_level.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->course.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 3:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('profile_students_admission.admission_id AS gID')
                                    ->select('grade_level.level AS gLevel')
                                    ->select('section.section AS gSec')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_admission', 'profile_students.st_id = profile_students_admission.st_id', 'INNER')
                                    ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'INNER')
                                    ->join('section', 'profile_students_admission.section_id = section.section_id', 'INNER')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")') 
                                    ->where('(esk_profile_students_admission.st_id != "" AND esk_profile_students.status = 1 AND (esk_grade_level.grade_id >= 2 AND esk_grade_level.grade_id <= 7))')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->gLevel.'`), loadElemDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->gLevel.'`, `'.$s->gSec.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->gLevel.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 4:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('profile_students_admission.admission_id AS gID')
                                    ->select('grade_level.level AS gLevel')
                                    ->select('section.section AS gSec')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_admission', 'profile_students.st_id = profile_students_admission.st_id', 'INNER')
                                    ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'INNER')
                                    ->join('section', 'profile_students_admission.section_id = section.section_id', 'INNER')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")') 
                                    ->where('(esk_profile_students_admission.st_id != "" AND esk_profile_students.status = 1 AND (esk_grade_level.grade_id >= 8 AND esk_grade_level.grade_id <= 13))')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->gLevel.'`), loadElemDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->gLevel.'`, `'.$s->gSec.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->gLevel.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 5:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('c_courses.course')
                                    ->select('profile_students_c_admission.year_level')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_c_admission', 'profile_students.st_id = profile_students_c_admission.st_id', 'INNER')
                                    ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")')
                                    ->where('(esk_profile_students_c_admission.st_id != "" AND esk_profile_students.status = 1 AND c_courses.dept_id = 1)')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->course.'`), loadColDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->course.'`, `'.$s->year_level.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->course.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 6:
                $student = $this->db->select('profile_students.st_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile.avatar')
                                    ->select('c_courses.course')
                                    ->select('profile_students_c_admission.year_level')
                                    ->join('profile_students', 'profile.user_id = profile_students.user_id', 'INNER')
                                    ->join('profile_students_c_admission', 'profile_students.st_id = profile_students_c_admission.st_id', 'INNER')
                                    ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")')
                                    ->where('(esk_profile_students_c_admission.st_id != "" AND esk_profile_students.status = 1 AND c_courses.dept_id = 3)')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->course.'`), loadColDetails(`'.base64_encode($s->st_id).'`, `'.$s->name.'`, `'.$s->course.'`, `'.$s->year_level.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->course.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
            case 7:
                $student = $this->db->select('profile_employee.employee_id')
                                    ->select('UPPER(CONCAT(esk_profile.lastname, ", ", esk_profile.firstname)) AS name')
                                    ->select('profile.firstname')
                                    ->select('profile.middlename')
                                    ->select('profile.lastname')
                                    ->select('profile_position.position')
                                    ->select('department.department')
                                    ->select('profile.avatar')
                                    ->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'INNER')
                                    ->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'INNER')
                                    ->join('department', 'profile_position.position_dept_id = department.dept_id')
                                    ->where('(esk_profile.lastname LIKE "%'.$value.'%" OR esk_profile.firstname LIKE "%'.$value.'%")')
                                    ->group_by('profile.user_id')
                                    ->order_by('profile.lastname', 'ASC')
                                    ->limit(10)
                                    ->get('profile')
                                    ->result();
                $html = '<ul>';
                foreach ($student as $s):
                    $html .= '<li style="font-size:18px;" onclick="$(`#searchName`).hide(), $(`#searchBox`).val(`'.$s->name.' - '.$s->position.'`), loadEmpDetails(`'.base64_encode($s->employee_id).'`, `'.$s->name.'`, `'.$s->position.'`, `'.$s->department.'`, `'.$s->avatar.'`)" >'.$s->name.' - '.$s->position.'</li>';
                endforeach;
                $html .= '</ul>';
                return $html;
            break;
        endswitch;
    }
    
    function fetchAttendeeAttendance($act_id, $type){
        if($type == 1):
            return $this->db->select('esk_profile.firstname, esk_profile.lastname, esk_grade_level.level, esk_section.section, esk_activity_attendance.act_in, esk_activity_attendance.act_out')
                    ->join('esk_profile_students_admission', 'esk_activity_attendance.st_id = esk_profile_students_admission.st_id')
                    ->join('esk_profile', 'esk_profile_students_admission.user_id = esk_profile.user_id')
                    ->join('esk_grade_level', 'esk_profile_students_admission.grade_level_id = esk_grade_level.grade_id')
                    ->join('esk_section', 'esk_profile_students_admission.section_id = esk_section.section_id')
                    ->where('esk_activity_attendance.act_id', $act_id)
                    ->order_by('esk_grade_level.grade_id', 'ASC')
                    ->get('esk_activity_attendance')->result();
        elseif($type == 2):
            return $this->db->select('esk_profile.firstname, esk_profile.lastname, esk_c_courses.short_code, esk_profile_students_c_admission.year_level, esk_activity_attendance.act_in, esk_activity_attendance.act_out')
                    ->join('esk_profile_students_c_admission', 'esk_activity_attendance.st_id = esk_profile_students_c_admission.st_id')
                    ->join('esk_profile', 'esk_profile_students_c_admission.user_id = esk_profile.user_id')
                    ->join('esk_c_courses', 'esk_profile_students_c_admission.course_id = esk_c_courses.course_id')
                    ->where('esk_activity_attendance.act_id', $act_id)
                    ->order_by('esk_profile_students_c_admission.year_level', 'ASC')
                    ->get('esk_activity_attendance')->result();
        elseif($type == 3):
            return $this->db->select('esk_profile.firstname, esk_profile.lastname, esk_activity_attendance.act_in, esk_activity_attendance.act_out, esk_profile_position.position')
                    ->join('esk_profile_employee', 'esk_activity_attendance.st_id = esk_profile_employee.employee_id')
                    ->join('esk_profile', 'esk_profile_employee.user_id = esk_profile.user_id')
                    ->join('esk_profile_position', 'esk_profile_employee.position_id = esk_profile_position.position_id')
                    ->where('esk_activity_attendance.act_id', $act_id)
                    ->get('esk_activity_attendance')->result();
        endif;
    }
    
    function updateActivity($act_id, $data){
        $this->db->where('act_id', $act_id)
                ->update('activity', $data);
        return TRUE;
    }
    
    function fetchActivity($act_id){
        return $this->db->where('act_id', $act_id)
                ->get('activity');
    }
    
    function removeActivity($act_id){
        $this->db->where('act_id', $act_id)
                ->delete('activity');
        return TRUE;
    }
    
    function removeAttendanceList($act_id){
        $this->db->where('act_id', $act_id)
                ->delete('activity_attendance');
        return TRUE;
    }
    
    function fetchAttendanceList($act){
        return $this->db->select('st_id, act_in, act_out')
                ->where('act_id', $act)
                ->order_by('att_id', 'DESC')
                ->get('activity_attendance');
    }
    
    function fetchAttendance($act){
        return $this->db->select('st_id, act_in, act_out')
                ->where('act_id', $act)
                ->order_by('att_id', 'DESC')
                ->limit(12)
                ->get('activity_attendance');
    }
    
    function insertActivityAttendance($data){
        $this->db->insert('activity_attendance', $data);
        return TRUE;
    }
    
    function updateActivityAttendance($prof, $act, $data){
        $this->db->where('st_id', $prof)
                ->where('act_id', $act)
                ->update('activity_attendance', $data);
        return TRUE;
    }
    
    function checkAttendance($profID, $act_id){
        return $this->db->where('st_id', $profID)
                ->where('act_id', $act_id)
                ->get('activity_attendance')->row();
    }
    
    function fetchStudentCredentials($st_id, $st_type = 0){
        if($st_type == 1):
            return $this->db->select('grade_level.level, section.section, grade_level.grade_id')
                ->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id')
                ->join('section', 'profile_students_admission.section_id = section.section_id')
                ->where('profile_students_admission.st_id', $st_id)
                ->get('profile_students_admission')->row();
        else:
            return $this->db->select('profile_students_c_admission.year_level, c_courses.short_code, c_courses.dept_id')
                ->join('c_courses', 'profile_students_c_admission.course_id = c_courses.course_id')
                ->where('profile_students_c_admission.st_id', $st_id)
                ->get('profile_students_c_admission')->row();
        endif;
    }
    
    function fetchEmployeeCredentials($emp_id){
        return $this->db->select('profile_position.position, department.department')
                ->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'LEFT')
                ->join('department', 'profile_position.position_dept_id = department.dept_id', 'LEFT')
                ->where('profile_employee.employee_id', $emp_id)
                ->get('profile_employee')->row();
    }
    
    function fetchProfileByRFID($rfid){
        return $this->db->select('profile.firstname, profile.lastname, profile.avatar, profile_employee.employee_id, profile_students.st_id, profile.user_id')
                ->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'LEFT')
                ->join('profile_students', 'profile.user_id = profile_students.user_id', 'LEFT')
                ->where('profile.rfid', $rfid)
                ->get('profile')->row_array();
    }
    
    function fetchProfile($id){
        return $this->db->select('firstname, lastname')
                ->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'LEFT')
                ->join('profile_students', 'profile.user_id = profile_students.user_id', 'LEFT')
                ->where('profile_employee.employee_id', $id)
                ->or_where('profile_students.st_id', $id)
                ->get('profile');
    }
    
    function fetchDeptID($act_id){
        return $this->db->select('act_department')
                ->where('act_id', $act_id)
                ->get('activity')->row();
    }
    
    function fetchActivities(){
        return $this->db->select('act_id, act_title, act_date, act_time')
                        ->get('activity');
    }
    
    function insertActivity($data) {
        $this->db->insert('activity', $data);
        return TRUE;
    }
}
