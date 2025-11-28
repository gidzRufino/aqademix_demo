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
    
    function getFinalGrade($st_id, $course_id, $subject_id, $semester, $school_year)
    {
        $grade = $this->gradingsystem_model->getFinalGrade($st_id, $course_id, $subject_id, $semester, $school_year);
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
    
    public function getFinalGradePerSubject($st_id, $sub_id, $semester, $school_year, $course_id = NULL, $year_level = NULL, $teacher_id = NULL)
    {
        $term = Modules::run('college/gradingsystem/getTerm');
        $category = Modules::run('college/gradingsystem/getAssessCategory');
        foreach($term->result() as $t):
            foreach($category->result() as $ac): 
                $grade = Modules::run('college/gradingsystem/getRecordedGrade', $st_id, $ac->gsc_id, $t->gst_id, $semester, $school_year, $sub_id, 1);
                $partialGrade += $grade->row()->grade * $grade->row()->subject_weight;
                
            endforeach;
            
                $finalGradeDetails= array(
                    'gsa_st_id'          => $st_id,
                    'gsa_course_id'      => $course_id,
                    'gsa_year_level'     => $year_level,
                    'gsa_sem'            => $semester,
                    'gsa_sub_id'         => $sub_id,
                    'gsa_term_id'        => $t->gst_id,
                    'gsa_grade'          => Modules::run('college/gradingsystem/getTransmutation', number_format($partialGrade,2,'.',',')),
                    'gsa_school_year'    => $school_year,
                    'gsa_is_final'       => 1,
                    'teacher_id'         => $teacher_id

                );
                
                $this->gradingsystem_model->saveFinalGrade($finalGradeDetails, $st_id, $t->gst_id, $sub_id, $teacher_id, $school_year, $semester);
            $finalGrade += $partialGrade * $grade->row()->term_weight;
            if($t->gst_id==4):
                $grade_value = $grade->row()->grade;
            endif;
            unset($partialGrade);
        endforeach;
        
        $finalGrade = ($finalGrade==0?0:$finalGrade);
        $final = array(
            'finalGrade'        => $finalGrade,
            'finalEquivalent'   => Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',','))
        );
        
        $finalDetails= array(
            'gsa_st_id'          => $st_id,
            'gsa_course_id'      => $course_id,
            'gsa_year_level'     => $year_level,
            'gsa_sem'            => $semester,
            'gsa_sub_id'         => $sub_id,
            'gsa_term_id'        => 0,
            'gsa_grade'          => Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',',')),
            'gsa_school_year'    => $school_year,
            'gsa_is_final'       => 1,
            'teacher_id'         => $teacher_id

        );

        $this->gradingsystem_model->saveFinalGrade($finalDetails, $st_id, 0,$sub_id, $teacher_id, $school_year, $semester);
        
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
        if($this->gradingsystem_model->validateGrade($st_id, $term_id, $subject_id)):
            
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
                   // echo 'Successfully Saved';
                    print_r($finalGradeDetails);
                endif;
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
        $category = Modules::run('college/gradingsystem/getAssessCategory');
        
        $cs             = $this->post('cs');
        $exam           = $this->post('exam');
        $st_id          = $this->post('st_id');
        $term           = $this->post('term');
        $semester       = $this->post('semester');
        $subject_id     = $this->post('subject');
        $school_year    = $this->post('school_year');
        $course_id      = $this->post('course_id');
        
        foreach($category->result() as $ac): 
            
            $partialGrade += ($ac->gsc_id==1?$cs * $ac->subject_weight:$exam * $ac->subject_weight);
            
            $grade_details = array(
                'student_id'    => $st_id,
                'subject_id'    => $subject_id,
                'assess_cat_id' => $ac->gsc_id,
                'grade'         => ($ac->gsc_id==1?$cs:$exam),
                'term_id'       => $term,
                'semester'      => $semester
            );
            $this->gradingsystem_model->updateGrade($grade_details, $st_id, $subject_id, $ac->gsc_id, $term, $semester, $school_year);
        endforeach;
        
        $finalTermGrade = Modules::run('college/gradingsystem/getTransmutation', number_format($partialGrade,2,'.',','));
        
        if($this->gradingsystem_model->updateFinalGrade(array('gsa_grade'=> $finalTermGrade,'is_edited'=> 1, 'edited_by' => $this->session->employee_id), $st_id, $subject_id, $semester, $school_year, $term, $course_id)):
            $term = Modules::run('college/gradingsystem/getTerm');
            foreach($term->result() as $t):
                foreach($category->result() as $ac): 
                    $grade = Modules::run('college/gradingsystem/getRecordedGrade', $st_id, $ac->gsc_id, $t->gst_id, NULL, $school_year, $subject_id, 1);
                    $partialFGrade += $grade->row()->grade * $grade->row()->subject_weight;
                    //$partialFGrade .= $grade->row()->grade.' | '.$grade->row()->subject_weight.' | ';
                endforeach;
                    $finalGrade += $partialFGrade * $grade->row()->term_weight;
                    //$partial .= $partialFGrade.' | '.$grade->row()->term_weight.' | ';
                    
                unset($partialFGrade);
            endforeach;
                    //echo json_encode(array('msg'=> 'Successfully Updated '.Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',','))  ));
            
            $finalDetails= array(
                'gsa_st_id'          => $st_id,
                'gsa_course_id'      => $course_id,
                'gsa_sem'            => $semester,
                'gsa_term_id'        => 0,
                'gsa_grade'          => Modules::run('college/gradingsystem/getTransmutation', number_format($finalGrade,2,'.',',')),
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
    
    function getStudentsPerSubject($fac_id, $sched_code, $sec_id, $sub_id, $sem =NULL)
    {
        $data['term'] = $this->gradingsystem_model->getTerm();
        $data['assessCategory'] = $this->gradingsystem_model->getAssessCategory();
        $data['section_id'] = $sec_id;
        $data['faculty_id'] = $fac_id;
        $data['subject_id'] = $sub_id;
        $sem == NULL?Modules::run('main/getSemester'):$sem;
        $data['sem'] = $sem;
        $data['school_year'] = $this->session->userdata('school_year');
        $data['subjects'] = $this->gradingsystem_model->getTeacherAssignment($this->session->userdata('employee_id'), $sem);
        $data['students'] = Modules::run('college/subjectmanagement/getStudentsPerSectionRaw', $sec_id, $sem);
        
//        $data['modules'] = 'college/gradingsystem'; 
//        $data['main_content'] = 'studentsPerSubject';
//        echo Modules::run('templates/college_content', $data);
        
        $this->load->view('gradingsystem/studentsPerSubject', $data);
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
}

