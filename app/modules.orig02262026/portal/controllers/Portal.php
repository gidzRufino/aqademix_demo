<?php

class Portal extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("portal_model");
    }

    function teachersList($st_id){
        $data = array(
            'modules'           =>  "portal",
            'mobile_content'    =>  "teacher_roster",
            'schedules'         =>  "nothing"
        );
        echo $this->load->view('teachers_list', $data);
    }

    function getStudentDetails($st_id){
        return $this->portal_model->fetchStudentDetails($st_id);
    }

    function teachers($user_id){
        $user_id = base64_decode($user_id);
        $students = explode(',', $this->portal_model->fetchChildren($user_id)->child_links);
        $data = array(
            'modules'           =>  "portal",
            'mobile_content'    =>  "teacher_roster",
            'students'          =>  $students
        );
        echo Modules::run('templates/portal_content', $data);
    }

    function finances($user_id){
        $user_id = base64_decode($user_id);
        $students = explode(',', $this->portal_model->fetchChildren($user_id)->child_links);
        $data = array(
            'modules'           =>  "portal",
            'mobile_content'    =>  "finances",
            'students'          =>  $students
        );
        echo Modules::run('templates/portal_content', $data);
    }

    public function dashboard($user_id) {
        $user_id = base64_decode($user_id);
        $data = array(
            'modules'           => "portal",
            'mobile_content'    => "dashboard",
            'student_count'     =>  $this->portal_model->fetchStudents($user_id)->num_rows()
        );
        echo Modules::run('templates/portal_content', $data);
    }

    function getSubjectGrades($st_id, $sub_id){
        return $this->portal_model->fetchSubjectGrades($st_id, $sub_id);
    }

    function getCollegeSubjects($st_id){
        return $this->portal_model->fetchCollegeSubjects($st_id);
    }

    function fetchStudentLevel($st_id){
        $check = $this->portal_model->fetchGradeSchoolLevel($st_id);
        if(!empty($check)):
            $data = array(
                'check' => $check,
                'level' =>  $check->level." - ".$check->section
            );
            return $data; 
        else:
            $check = $this->portal_model->fetchCollegeLevel($st_id);
            $data = array(
                'check' => $check,
                'level' =>  $check->short_code." - ".$check->year_level
            );
            return $data;
        endif;
    }

    function getSubjectTotalAverage($st_id, $sub_id){
        $ass_cat = $this->portal_model->fetchAssessmentCat($st_id, $sub_id);
        $gs = 0; $grades = 0;
        foreach($ass_cat->result() AS $cat):
            $tmpGrade = 0; $tmpTotal = 0;
            $quiz = $this->portal_model->fetchAssessment($st_id, $sub_id, $cat->code);
            foreach($quiz AS $q):
                $tmpGrade += $q->raw_score;
                $tmpTotal += $q->no_items;
                $gs = $tmpGrade/$tmpTotal;
            endforeach;
            $grades += $gs;
        endforeach;
        $total = ($grades/$ass_cat->num_rows()*50)+45;
        return ($total>45) ? number_format($total, 0) : 0.;
    }

    function getGradeSchoolSubjects($st_id){
        return ($this->portal_model->fetchGradeSchoolSubjects($st_id));
    }

    function students($user_id) {
        $user_id = base64_decode($user_id);
        $students = explode(',', $this->portal_model->fetchChildren($user_id)->child_links);
        $data = array(
            'modules'           =>  "portal",
            'mobile_content'    =>  "student_roster",
            'students'          =>  $students
        );
        echo Modules::run('templates/portal_content', $data);
    }

    function student($st_id) {
        $st_id = base64_decode($st_id);
        $data = array(
            'modules'           =>  "portal",
            'mobile_content'    =>  "student_details",
            'details'           =>  $this->portal_model->fetchStudentDetails($st_id),
            'student_id'        =>  $st_id
        );
        echo Modules::run('templates/portal_content', $data);
    }

}
