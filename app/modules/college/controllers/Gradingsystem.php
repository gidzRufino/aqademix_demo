<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Gradingsystem extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('gradingsystem_model');
        $this->load->library('pdf');
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function getForm9()
    {
        $this->load->view('gradingsystem/pecit_form9');
    } 
    
    function printGradeSheet($fac_id, $sec_id, $sub_id, $sem =NULL, $term = NULL, $school_year = NULL)
    {
        if($this->session->is_logged_in):
            $data['term'] = $term;
            $data['assessCategory'] = $this->gradingsystem_model->getAssessCategory();
            $data['section_id'] = $sec_id;
            $data['faculty_id'] = base64_decode($fac_id);
            $data['subject_id'] = $sub_id;
            $sem == NULL?Modules::run('main/getSemester'):$sem;
            $data['sem'] = $sem;
            $data['school_year'] = $school_year == NULL ?$this->session->userdata('school_year'):$school_year;
            $data['subjects'] = $this->gradingsystem_model->getTeacherAssignment($this->session->userdata('employee_id'), $sem);
            $data['students'] = Modules::run('college/subjectmanagement/getStudentsPerSectionRaw', $sec_id, $sem, $school_year);
            $this->load->view('gradingsystem/grading_sheet', $data);
        else:
            redirect(base_url());
        endif;    
    }
    
    function approveGrade()
    {
        if($this->session->is_logged_in):
            $arrayDetails = array(
                'is_approved'   => 1,
                'approved_by'   => $this->session->employee_id,
                'date_approved' => date('Y-m-d g:i:s')
            );
                if($this->post('term')==4):
                    $this->gradingsystem_model->approvedGrade($arrayDetails, $this->post('st_id'), $this->post('sub_id'), $this->post('sem'), 2);
                endif;

            if($this->gradingsystem_model->approvedGrade($arrayDetails, $this->post('st_id'), $this->post('sub_id'), $this->post('sem'), $this->post('term'))):
                echo json_encode(array('success' => TRUE));
            else:
                echo json_encode(array('success' => FALSE));
            endif;
        endif;
    }
    
    function getAssignedSubjectCollege($id, $semester, $school_year)
    {
        $data['id'] = $id;
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['subjects'] = Modules::run('college/subjectmanagement/getAssignedSubjectRaw', $id, $semester, $school_year);
        $this->load->view('faculty/subjectAssignedForGradeView', $data);
    }
    
    function getDeansListOfStudentPerSubject($fac_id, $sec_id, $sub_id, $sem =NULL, $term = NULL, $school_year = NULL)
    {
        if($this->session->is_logged_in):
            $data['term'] = $term;
            $data['assessCategory'] = $this->gradingsystem_model->getAssessCategory();
            $data['section_id'] = $sec_id;
            $data['faculty_id'] = $fac_id;
            $data['subject_id'] = $sub_id;
            $sem == NULL?Modules::run('main/getSemester'):$sem;
            $data['sem'] = $sem;
            $data['school_year'] = $school_year==NULL?$this->session->userdata('school_year'):$school_year;
            $data['subjects'] = $this->gradingsystem_model->getTeacherAssignment($this->session->userdata('employee_id'), $sem, $school_year);
            $data['students'] = Modules::run('college/subjectmanagement/getStudentsPerSectionRaw', $sec_id, $sem, $school_year);
            $this->load->view('faculty/studentsPerSubject', $data);
        else:
            redirect(base_url());
        endif;    
    }
    
    function listOfFacultyWGrades($term=1, $sem=1, $school_year = NULL)
    {
        $data['term']   = $term;
        $data['sem']    = $sem;
        $data['school_year'] = $school_year;
        $data['facultyList'] = $this->gradingsystem_model->getFacultyInGS($term, $sem, $school_year);
        $data['modules'] = 'college'; 
        $data['main_content'] = 'faculty/listOfFacultyWGrades';
        echo Modules::run('templates/college_content', $data);
    }
    
    function getFinalGrade($st_id, $course_id, $subject_id, $semester, $school_year, $term_id)
    {
        $grade = $this->gradingsystem_model->getFinalGrade($st_id, $course_id, $subject_id, $semester, $school_year, $term_id);
        return $grade;
    }
    
    function generateFinalGrade($course_id, $year_level, $semester, $school_year)
    {
        $category = Modules::run('college/gradingsystem/getAssessCategory');
        $term = Modules::run('college/gradingsystem/getTerm');
        $students = Modules::run('college/getStudentPerCourse', $course_id, $semester, $school_year, NULL, NULL, $year_level,1);
        
        $i=1;
        foreach ($students->result() as $st):
            $i++;
            //if($i<5):
                $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $st->admission_id, $semester, $school_year);
                foreach ($loadedSubject as $subject):
                    $finalGrade = 0;
                    $teacher_id = $this->getTeacherPerSubject($subject->cl_section, $school_year)->faculty_id;
                    if($teacher_id!=NULL):
                        foreach ($term->result() as $t):
                            $partialGrade = 0;
                            foreach($category->result() as $ac): 
                                $grade = Modules::run('college/gradingsystem/getRecordedGrade', $st->st_id, $ac->gsc_id, $t->gst_id, $semester, $school_year,  $subject->s_id, 1);
                                $partialGrade += $grade->row()->grade * $grade->row()->subject_weight;
                            endforeach;
                                $finalGrade += $partialGrade * $grade->row()->term_weight;
                                $partialGradeFinal = array(
                                    'gsa_st_id'          => $st->st_id,
                                    'gsa_course_id'      => $course_id,
                                    'gsa_year_level'     => $year_level,
                                    'gsa_sem'            => $semester,
                                    'gsa_sub_id'         => $subject->s_id,
                                    'gsa_term_id'        => $t->gst_id,
                                    'gsa_grade'          => Modules::run('college/gradingsystem/getTransmutation', number_format($partialGrade,2,'.',',')),
                                    'gsa_school_year'    => $school_year,
                                    'gsa_is_final'       => 1,
                                    'teacher_id'         => $teacher_id
    
                                );
                               //$this->gradingsystem_model->saveFinalGrade($partialGradeFinal, $st->st_id, $t->gst_id,$subject->s_id,$teacher_id, $school_year, $semester);
                                //if($this->gradingsystem_model->saveFinalGrade($partialGradeFinal, $st->st_id, $t->gst_id,$subject->s_id,$teacher_id, $school_year, $semester)):
                                   // echo $st->lastname.' | '.$subject->sub_code.' | '. Modules::run('college/gradingsystem/getTransmutation', number_format($partialGrade,2,'.',',')).'<br />';
                                //endif;
                            unset($partialGrade);
                        endforeach;
                                $finalGradeDetails= array(
                                    'gsa_st_id'          => $st->st_id,
                                    'gsa_course_id'      => $course_id,
                                    'gsa_year_level'     => $year_level,
                                    'gsa_sem'            => $semester,
                                    'gsa_sub_id'         => $subject->s_id,
                                    'gsa_term_id'        => 0,
                                    'gsa_grade'          => Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',',')),
                                    'gsa_school_year'    => $school_year,
                                    'gsa_is_final'       => 1,
                                    'teacher_id'         => $teacher_id

                                );

                                if($this->gradingsystem_model->saveFinalGrade($finalGradeDetails, $st->st_id, $t->gst_id,$subject->s_id, $teacher_id, $school_year, $semester)):
                                    echo $st->lastname.' | '.$subject->sub_code.' | '. Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',',')).'<br />';
                               endif;
                               unset($finalGrade);
                                
                        endif; 
                endforeach;   
           // endif;
        endforeach;
    }
    
    function getTeacherPerSubject($section_id, $school_year = NULL)
    {
        $teacher = $this->gradingsystem_model->getTeacherPerSubject($section_id, $school_year);
        return $teacher;
    }
    
    public function getTermGrade($st_id, $course_id, $sub_id, $semester, $school_year, $term_id)
    {
        $grade = Modules::run('college/gradingsystem/getFinalGrade', $st_id, $course_id, $sub_id, $semester, $school_year, $term_id);
        return $grade->gsa_grade;
    }
    
    public function getFinalGradePerSubject($st_id, $sub_id, $semester, $school_year, $course_id = NULL, $year_level = NULL, $teacher_id = NULL)
    {
        $term = Modules::run('college/gradingsystem/getTerm');
        foreach($term->result() as $t):
           $grade = Modules::run('college/gradingsystem/getFinalGrade', $st_id, $course_id, $sub_id, $semester, $school_year, $t->gst_id);
           $finalGrade += $grade->gsa_grade * $t->term_weight;
        endforeach;
        
        $finalGrade = ($finalGrade==0?0:$finalGrade);
        $final = array(
            'finalGrade'        => $finalGrade
        );
        
        echo json_encode($final);
    }
    
    public function inValidateGrade($st_id=NULL, $term_id=NULL, $subject_id=NULL)
    {
        $st_id == NULL?$this->post('st_id'):$st_id ;
        $term_id == NULL?$this->post('term_id'):$term_id;
        $subject_id == NULL?$this->post('subject_id'):$subject_id;
        if($this->gradingsystem_model->inValidateGrade($st_id, $term_id, $subject_id)):
            echo 'Successfully Updated';
        endif;
    }
    
    public function postGrade()
    {
        $st_id = $this->post('st_id');
        $term_id = $this->post('term_id');
        $subject_id = $this->post('subject_id');
        $course_id = $this->post('course_id');
        $year_level = $this->post('year_level');
        $faculty_id = $this->post('faculty_id');
        $semester = $this->post('semester');
        $grade = $this->post('grade');
        $school_year = $this->post('school_year');
        $finalGradeDetails = array(
           'gsa_st_id'          => $st_id,
           'gsa_course_id'      => $course_id,
           'gsa_year_level'     => $year_level,
           'gsa_sem'            => $semester,
           'gsa_sub_id'         => $subject_id,
           'gsa_term_id'        => $term_id,
           'gsa_grade'          => $grade,
           'gsa_school_year'    => $school_year,
           'gsa_is_final'       => 1,
           'teacher_id'         => $faculty_id

        );

        if($this->gradingsystem_model->saveFinalGrade($finalGradeDetails, $st_id, $term_id,$subject_id,$faculty_id, $school_year, $semester)):
            echo 'Successfully Saved';
          //  print_r($finalGradeDetails);
        endif;
    }
    
    public function validateGrade()
    {
        $st_id = $this->post('st_id');
        $term_id = $this->post('term_id');
        $subject_id = $this->post('subject_id');
        $course_id = $this->post('course_id');
        $year_level = $this->post('year_level');
        $faculty_id = $this->post('faculty_id');
        $semester = $this->post('semester');
        $grade = $this->post('grade');
        $school_year = $this->post('school_year');
        $finalGradeDetails = array(
           'gsa_st_id'          => $st_id,
           'gsa_course_id'      => $course_id,
           'gsa_year_level'     => $year_level,
           'gsa_sem'            => $semester,
           'gsa_sub_id'         => $subject_id,
           'gsa_term_id'        => $term_id,
           'gsa_grade'          => $grade,
           'gsa_school_year'    => $school_year,
           'gsa_is_final'       => 0,
           'teacher_id'         => $faculty_id

        );

        if($this->gradingsystem_model->saveFinalGrade($finalGradeDetails, $st_id, $term_id,$subject_id,$faculty_id, $school_year, $semester)):
           // echo 'Successfully Saved';
            print_r($finalGradeDetails);
        endif;
    }
    
    
    public function getTransmutation($numberGrade)
    {
        $plg = $this->gradingsystem_model->getTransmutation();
        foreach($plg as $plg){
            if( $numberGrade >= $plg->gstr_from && $numberGrade <= $plg->gstr_to){
                return number_format($plg->gstr_transmutation,2);
            }
        }
    }
    
    function getRecordedGrade($st_id, $category=NULL, $term=NULL, $semester=NULL, $school_year=NULL, $subject_id=NULL, $final=NULL)
    {
        $grades = $this->gradingsystem_model->getRecordedGrade($st_id, $category, $term, $semester, $school_year, $subject_id, $final);
        return $grades;
    }
    
    function updateGrade()
    {
        
        $exam           = $this->post('exam');
        $st_id          = $this->post('st_id');
        $term           = $this->post('term');
        $semester       = $this->post('semester');
        $subject_id     = $this->post('subject');
        $year_level     = $this->post('year_level');
        $school_year    = $this->post('school_year');
        $course_id      = $this->post('course_id');
        
       $finalDetails= array(
            'gsa_st_id'          => $st_id,
            'gsa_year_level'     => $year_level,
            'gsa_course_id'      => $course_id,
            'gsa_sem'            => $semester,
            'gsa_sub_id'         => $subject_id,
            'gsa_term_id'        => $term,
            'gsa_grade'          => $exam,
            'gsa_school_year'    => $school_year,
            'gsa_is_final'       => 1,

        );
        $this->gradingsystem_model->saveFinalGrade($finalDetails, $st_id, $term, $subject_id, NULL, $school_year, $semester);
        
        
        if($this->gradingsystem_model->updateFinalGrade(array('gsa_grade'=> $exam,'is_edited'=> 1, 'edited_by' => $this->session->employee_id), $st_id, $subject_id, $semester, $school_year, $term, $course_id)):
            $term = Modules::run('college/gradingsystem/getTerm');
            foreach($term->result() as $t):
                     $grade = Modules::run('college/gradingsystem/getFinalGrade', $st_id, $course_id, $subject_id, $semester, $school_year, $t->gst_id);
                    $finalGrade += $grade->gsa_grade * $t->term_weight;
                    
            endforeach;
                    //echo json_encode(array('msg'=> 'Successfully Updated '.Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',','))  ));
            
            $finalDetails= array(
                'gsa_st_id'          => $st_id,
                'gsa_course_id'      => $course_id,
                'gsa_sem'            => $semester,
                'gsa_sub_id'         => $subject_id,
                'gsa_term_id'        => 0,
                'gsa_grade'          => $finalGrade,
                'gsa_school_year'    => $school_year,
                'gsa_is_final'       => 1,

            );
            $result = $this->gradingsystem_model->saveFinalGrade($finalDetails, $st_id, 0,$subject_id, NULL, $school_year, $semester);
            //echo json_encode(array('msg'=> 'Successfully Updated '.$result  ));
            if($result):
                echo json_encode(array('msg'=> 'Successfully Updated '  ));
            else:
                echo json_encode(array('msg'=> 'Sorry Something went Wrong'));
            endif;
            
        else:
            echo json_encode(array('msg'=> 'Sorry Something went Wrong'));
        endif;
        
        
    }
    
    function recordGrade()
    {
        $st_id = $this->post('student_id');
        $category = $this->post('category_id');
        $term = $this->post('term');
        $grade = $this->post('grade');
        $semester = $this->post('semester');
        $subject_id = $this->post('subject');
        
        $grade_details = array(
            'student_id'    => $st_id,
            'subject_id'    => $subject_id,
            'assess_cat_id' => 0,
            'grade'         => $grade,
            'term_id'       => $term,
            'school_year'   => $this->session->userdata('school_year'),
            'semester'      => $semester
        );
        $result = $this->gradingsystem_model->recordGrade($grade_details, $st_id, $subject_id, $category, $term, $semester);
        echo $result;
//        if($result):
//            echo json_encode(array('msg'=> 'Successfully Saved'));
//        else:
//            echo json_encode(array('msg'=> 'Something went wrong'));
//        endif;
    }
    
    function index()
    {
        //$data['course'] = $this->gradingsystem_model->getTeachersSchedule($this->session->userdata('employee_id'));
        $data['ro_year'] = Modules::run('registrar/getROYear');
        $data['teacher_id'] = $this->session->userdata('employee_id');
        $data['subjects'] = $this->gradingsystem_model->searchSubjectAssign($this->session->userdata('employee_id'));
        $data['modules'] = 'college/gradingsystem'; 
        $data['main_content'] = 'default';
        echo Modules::run('templates/college_content', $data);
    }
    
    function getTerm()
    {
        $term = $this->gradingsystem_model->getTerm();
        return $term;
    }
    
    function getAssessCategory()
    {
        $category = $this->gradingsystem_model->getAssessCategory();
        return $category;
    }
    
    function getIndividualAcademicRecord($details)
    {
        $data['details'] = $details;
        $data['term'] = $this->getTerm();
        $data['category'] = $this->getAssessCategory();
        $this->load->view('gradingsystem/individualRecords', $data);
    }
    
    function getStudentsPerSubject($fac_id, $sched_code, $sec_id, $sub_id, $sem = NULL, $school_year = NULL) {
        $data['term'] = $this->gradingsystem_model->getTerm();
        $data['assessCategory'] = $this->gradingsystem_model->getAssessCategory();
        $data['section_id'] = $sec_id;
        $data['faculty_id'] = $fac_id;
        $data['subject_id'] = $sub_id;
        $sem == NULL ? Modules::run('main/getSemester') : $sem;
        $data['sem'] = $sem;
        $data['school_year'] = $school_year == NULL ? $this->session->userdata('school_year') : $school_year;
        $data['subjects'] = $this->gradingsystem_model->getTeacherAssignment($this->session->userdata('employee_id'), $sem, $school_year);
        $data['students'] = Modules::run('college/subjectmanagement/getStudentsPerSectionRaw', $sec_id, $sem, $school_year);
        $data['deadline'] = $this->getDeadlineDates($school_year);

//        $data['modules'] = 'college/gradingsystem'; 
//        $data['main_content'] = 'studentsPerSubject';
//        echo Modules::run('templates/college_content', $data);

        $this->load->view('gradingsystem/studentsPerSubject', $data);
    }
    
    function getTeacherAssignmentDrop($teacher_id, $semester, $school_year, $opt = NULL)
    {
        $result = $this->gradingsystem_model->getTeacherAssignment($teacher_id, $semester, $school_year);
        if ($opt != NULL):
            $data['teacher_id'] = $teacher_id;
            $data['sem'] = $semester;
            $data['school_year'] = $school_year;
            $data['result'] = $result;
            echo $this->load->view('college/subjectmanagement/classList', $data);
        else:
            echo '<option>Select Subject</option>' . $teacher_id;
            foreach ($result as $r):
                ?>
                <option 
                    id="<?php echo $r->section_id ?>"
                    sched_code='<?php echo $r->sched_gcode; ?>'
                    sub_code='<?php echo $r->sec_sub_id; ?>'
                    value="<?php echo $r->section_id ?>"><?php echo $r->sub_code . ' - ' . $r->section ?></option>

                <?php
            endforeach;
        endif;
    }
    
    function getTeacherAssignment($teacher_id, $semester)
    {
        $result = $this->gradingsystem_model->getTeacherAssignment($teacher_id, $semester);
            foreach ($result as $r):
                ?>
                            <div onclick="loadAssignment('<?php echo $teacher_id; ?>','<?php echo $r->sched_gcode; ?>','<?php echo $r->section_id; ?>','<?php echo $r->s_id; ?>')" 
                                  class='sub_btn btn btn-info alert alert-info no-margin' style="border-radius: 0; padding-top:5px; padding-bottom: 5px; width: 100%;"
                                  id="<?php echo $r->s_id ?>_btn"
                                  >

                                <div class="notify"><?php echo $r->sub_code.' - '.$r->section ?></div>  
                            </div>
                    
                <?php
            endforeach;
        
    }
    
    function searchSubjectAssign($teacher_id, $value)
    {
         $result = $this->gradingsystem_model->searchSubjectAssign($teacher_id, $value);
         echo '<ul>';
            foreach ($result as $r):
                ?>
                    <li onclick="loadAssignment('<?php echo $teacher_id; ?>','<?php echo $r->sched_gcode; ?>','<?php echo $r->section_id; ?>'), $('#searchSubject').val('<?php echo $r->sub_code.' ( '.$r->section.' )' ?>'), $('#searchName').hide()"><?php echo $r->sub_code.' ( '.$r->section.' )' ?></li>
                <?php
            endforeach;
         echo '</ul>';
    }
    
    
    function saveDeadlineDate() {
        $emp_id = $this->input->post('emp_id');
        $dd = date('Y-m-d', strtotime($this->input->post('dd')));
        $dd_id = $this->input->post('dd_id');
        $field = $this->input->post('field');
        $grading = $this->input->post('grading');
        $sem = $this->input->post('sem');
        $sy = $this->input->post('sy');
        switch ($sem):
            case 1:
                $semester = 'First Sem';
                break;
            case 2:
                $semester = 'Second Sem';
                break;
            case 3:
                $semester = 'Summer';
        endswitch;

        $q = $this->gradingsystem_model->saveDeadlinDate($dd, $field, $dd_id, $sy);
        if ($q):
            if ($dd_id != NULL):
                $remarks = $this->session->userdata('name') . ' Has Updated The Deadline for Submission of Grades for ' . $grading . ' ' . $semester . ' to ' . $dd;
            else:
                $remarks = $this->session->userdata('name') . ' Has Set The Deadline for Submission of Grades for ' . $grading . ' ' . $semester . ' to ' . $dd;
            endif;
            Modules::run('main/logActivity', 'REGISTRAR', $remarks, $emp_id);
        endif;
    }

    function getDeadlineDates($school_year) {
        return $this->gradingsystem_model->getDD($school_year);
    }

    function postDeadlineDate() {
        $emp_id = $this->input->post('emp_id');
        $value = $this->input->post('value');
        $field = $this->input->post('field');
        $id = $this->input->post('id');
        $sy = $this->input->post('sy');
        $sem = $this->input->post('sem');
        $nxt = $sy + 1;

        switch ($sem):
            case 1:
                $semester = 'First Sem';
                break;
            case 2:
                $semester = 'Second Sem';
                break;
            case 3:
                $semester = 'Summer';
        endswitch;

        $q = $this->gradingsystem_model->postDeadlineDate($value, $field, $id, $sy);
        if ($q):
            $remarks = $this->session->userdata('name') . ' Has Posted The Deadline for Submission of Grades for ' . $semester . ' School Year ' . $sy . ' - ' . $nxt;
            Modules::run('main/logActivity', 'REGISTRAR', $remarks, $emp_id);
            return true;
        endif;
    }

    function checkGSDeadline() {
        $dd = $this->getDeadlineDates();
        $latest = date('Y-m-d');
        $t = 0;

        if ($dd->is_first_posted):
            if ($latest >= date('Y-m-d', strtotime($dd->finFirst . ' + 1 day'))):
                $lFirst = $this->gradingsystem_model->getListPerSem(1);
                foreach ($lFirst as $l):
                    if ($l->gs_auto_lock == 0):
                        $this->gradingsystem_model->gsLock($l->admission_id);
                        $t = 1;
                    endif;
                endforeach;
                if ($t == 1):
                    $this->gradingsystem_model->gsAutoLock('c_section', 'is_gs_lock', 'sec_sem', 1);
                endif;
                $this->gradingsystem_model->gsAutoLock('profile_students_c_admission', 'gs_auto_lock', 'semester', 1);
            endif;
        endif;

        $t = 0;
        if ($dd->is_second_posted):
            if ($latest >= date('Y-m-d', strtotime($dd->finSecond . ' + 1 day'))):
                $lSecond = $this->gradingsystem_model->getListPerSem(2);
                foreach ($lSecond as $l):
                    if ($l->gs_auto_lock == 0):
                        $this->gradingsystem_model->gsLock($l->admission_id);
                        $t = 1;
                    endif;
                endforeach;
                if ($t == 1):
                    $this->gradingsystem_model->gsAutoLock('c_section', 'is_gs_lock', 'sec_sem', 2);
                endif;
                $this->gradingsystem_model->gsAutoLock('profile_students_c_admission', 'gs_auto_lock', 'semester', 2);
            endif;
        endif;

        $t = 0;
        if ($dd->is_summer_posted):
            if ($latest >= date('Y-m-d', strtotime($dd->finSummer . ' + 1 day'))):
                $lSummer = $this->gradingsystem_model->getListPerSem(3);
                foreach ($lSummer as $l):
                    if ($l->gs_auto_lock == 0):
                        $this->gradingsystem_model->gsLock($l->admission_id);
                        $t = 1;
                    endif;
                endforeach;
                if ($t == 1):
                    $this->gradingsystem_model->gsAutoLock('c_section', 'is_gs_lock', 'sec_sem', 3);
                endif;
                $this->gradingsystem_model->gsAutoLock('profile_students_c_admission', 'gs_auto_lock', 'semester', 3);
            endif;
        endif;
    }

    function isGSlock($adm_id, $subject_id, $school_year) {
        return $this->gradingsystem_model->isGSlock($adm_id, $subject_id, $school_year);
    }

    function searchStudent($option, $value, $sem, $school_year) {
        $student = $this->gradingsystem_model->searchStudent($option, $value, $sem, $school_year);
        $data['students'] = $student;
        echo $this->load->view('college/gradingsystem/gsStudentsList', $data);
    }

    function gsUnlock($adm_id, $sub_id, $name, $value, $sem, $school_year) {
        $q = $this->gradingsystem_model->gsUnlock($adm_id, $sub_id, $value, $school_year);
        $isLock = ($value ? 'Locked' : 'Unlock');

        if ($q):
            $remarks = $this->session->userdata('name') . ' Has ' . $isLock . ' ' . base64_decode($name) . ' Grading System for ' . $sem . 'S.Y. ' . $school_year . ' - ' . ($school_year + 1);
            Modules::run('main/logActivity', 'REGISTRAR', $remarks, $this->session->userdata('employee_id'));
            echo json_encode(array('status'=> TRUE));
        else:
            echo json_encode(array('status'=> FALSE));
        endif;
    }

    function subjUnlock($value, $sub_id, $sec_id, $section, $sy) {
        $r = $this->gradingsystem_model->subjUnlock($value, $sub_id, $sec_id, $sy);
        $isLock = ($value ? 'Locked' : 'Unlock');

        if ($r):
            $this->gradingsystem_model->lockUnlocSection($sec_id, $value, $sy);
            $remarks = $this->session->userdata('name') . ' Has ' . $isLock . ' the ' . base64_decode($section) . ' Section Inputting of Grades';
            Modules::run('main/logActivity', 'REGISTRAR', $remarks, $this->session->userdata('employee_id'));
            echo json_encode(array('status'=> TRUE));
        else:
            echo json_encode(array('status'=> FALSE));
        endif;
    }
}

