<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of academic
 *
 * @author genesis
 */
class academic extends MX_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('academic_model');
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }

function getBHRate() {
        $result = $this->academic_model->getBHRate();
        return $result;
    }
    
    function updateAvatar()
    {
        $profile = $this->db->get('profile');
        foreach($profile->result() as $p):
            $this->db->where('user_id', $p->user_id);
            if($this->db->update('profile', array('avatar' => $p->user_id.'.png'))):
                echo $p->user_id.' is updated <br />';
            endif;
        endforeach;
    }
    
    function getContacts()
    {
        $profile = $this->db->get('profile');
        foreach ($profile->result() as $p):
            echo $p->user_id.'<br />';
            $this->db->where('user_id', $p->user_id);
            if($this->db->update('profile', array('contact_id' => $p->user_id))):
                echo $p->user_id.' is updated <br />';
            endif;
        endforeach;
    }
    
    function collegeFacultyAssignment($school_year = NULL)
    {
           $user_id = $this->session->userdata('user_id');
           $data['getEmployee'] = Modules::run('hr/getEmployee', base64_encode($user_id)); 
           $data['employeeList'] = Modules::run('hr/getEmployees'); 
           $data['subjects'] = $this->getSubjects();
           $data['grade'] = Modules::run('registrar/getGradeLevel');
           $data['section'] = Modules::run('registrar/getAllSection');
           $data['getAssignment'] = $this->mySubject($user_id);
           $data['getAllAssignment'] = $this->getAssignment(NULL, $school_year);
           
        if(Modules::run('main/isMobile'))
        {
           if(!$this->session->userdata('is_logged_in')){
               echo Modules::run('mobile/index');
           }else{
                $data['modules'] = "academic";
                $data['main_content'] = 'mobile/mySubjects';
                echo Modules::run('mobile/main_content', $data);
           }
            
        }else
        {
            if(!$this->session->userdata('is_logged_in')){
                Modules::run('login');
            }else{
               $data['main_content'] = 'college/subject_assignment';
               $data['modules'] = 'academic';
               echo Modules::run('templates/main_content', $data);	
            }
        }
        
    }
    
    function getAssignedSubjectCollege()
    {
        $id = $this->post('id');
        $data['id'] = $id;
        $data['assignment'] = $this->getAssignment($id, $this->session->userdata('school_year'));
        $this->load->view('college/subjectAssigned', $data);
    }
    
    function getAssignedSubject()
    {
        $id = $this->post('id');
        $data['id'] = $id;
        $data['assignment'] = $this->getAssignment($id, $this->session->userdata('school_year'));
        $this->load->view('subjectAssigned', $data);
    }
    
    function viewCollegeTeacherInfo($id, $school_year)
    {
        
        $data['basicInfo'] =  $this->academic_model->getBasicInfo($id, $school_year);
        $this->load->view('college/teacherInfo', $data);
        
    }
    
    function viewTeacherInfo($id, $school_year)
    {
        
        $data['getAdvisory'] = $this->getAdvisory($id, $this->session->userdata('school_year'));
        $data['basicInfo'] =  $this->academic_model->getBasicInfo($id, $school_year);
        $this->load->view('teacherInfo', $data);
        
    }
            
    function searchFA($user_id, $school_year = NULL)
    {
        $data['getEmployee'] = Modules::run('hr/getEmployee', $user_id);
        $data['getAssignment'] = $this->mySubject($user_id, $school_year);
        $this->load->view('subjectAssignmentTable', $data);
    }
    
    function teacherSearch()
    {
        $value = $this->post('value');
        $details = $this->academic_model->searchTeacher($value);
        if(!empty($details)){
        ?>
          <ul>
              <?php
              foreach($details as $d)
              {
              ?>
              <li onclick="getInfo(this.id), $('#teacher_id').val(this.id),$('#searchTeacher').val(this.innerHTML), $('#teacherSearch').hide()" id="<?php echo $d->employee_id ?>"><?php echo strtoupper($d->lastname.', '.$d->firstname) ?></li>
              <?php  
              }
              ?>
          </ul>
          
       <?php
        }
    }
    
    function facultyAssignment($school_year = NULL)
    {
           $user_id = $this->session->userdata('user_id');
           $data['getEmployee'] = Modules::run('hr/getEmployee', base64_encode($user_id)); 
           $data['employeeList'] = Modules::run('hr/getEmployees'); 
           $data['subjects'] = $this->getSubjects();
           $data['settings'] = $this->eskwela->getSet();
           $data['grade'] = Modules::run('registrar/getGradeLevel');
           $data['section'] = Modules::run('registrar/getAllSection');
           $data['getAssignment'] = $this->mySubject($user_id);
           $data['getAllAssignment'] = $this->getAssignment(NULL, $school_year);
           
        if(Modules::run('main/isMobile'))
        {
           if(!$this->session->userdata('is_logged_in')){
               echo Modules::run('mobile/index');
           }else{
                $data['modules'] = "academic";
                $data['main_content'] = 'mobile/mySubjects';
                echo Modules::run('mobile/main_content', $data);
           }
            
        }else
        {
            if(!$this->session->userdata('is_logged_in')){
                Modules::run('login');
            }else{
               $data['main_content'] = 'subject_assignment';
               $data['modules'] = 'academic';
               echo Modules::run('templates/main_content', $data);	
            }
        }
        
    }
    
    function mySubjects()
    {
           $user_id = $this->session->userdata('username');
           $data['getEmployee'] = Modules::run('hr/getEmployee', base64_encode($user_id)); 
           $data['employeeList'] = Modules::run('hr/getEmployees'); 
           $data['subjects'] = $this->getSubjects();
           $data['GradeLevel'] = Modules::run('registrar/getGradeLevel');
           $data['getAssignment'] = $this->mySubject($user_id, $this->session->userdata('school_year'));
           $data['getAllAssignment'] = $this->getAssignment();
           $data['modules'] = "academic";

        if(Modules::run('main/isMobile'))
        {
           if(!$this->session->userdata('is_logged_in')){
               echo Modules::run('mobile/index');
           }else{
                $data['main_content'] = 'mobile/mySubjects';
                echo Modules::run('mobile/main_content', $data);
           }
            
        }else
        {
            if(!$this->session->userdata('is_logged_in')){
                Modules::run('login');
            }else{
               $data['main_content'] = 'mySubjects';
               echo Modules::run('templates/main_content', $data);	
            }
            
        }
    }
    
    function getCollegeSubjects($id=NULL)
    {
        $subject = $this->academic_model->getCollegeSubjects($id);
        return $subject;
    }
    
    function getSubjects()
    {
        $subject = $this->academic_model->getSubjects();
        return $subject;
    }
    
    function getSubjectId($subject)
    {
        $id = $this->academic_model->getSubjectId($subject);
        return $id;
    }
    
    function getAssignmentByLevel($section=NULL, $gradeLevel=NULL, $school_year=NULL)
    {
        $assignment = $this->academic_model->getAssignmentByLevel($gradeLevel, $school_year, $section);
        return $assignment;
    }
            
    function getAssignmentByGradeLevel($gradeLevel=NULL)
    {
        if($gradeLevel==NULL):
            $gradeLevel = $this->post('id');
        endif;
        $data['assignment'] = $this->academic_model->getAssignmentByLevel($gradeLevel, $this->session->userdata('school_year'));
        $this->load->view('subjectAssignedByLevel', $data);
    }
    
    function teachersSubjectAssignment($id)
    {
        $assignment = $this->getAssignment($id, $this->session->userdata('school_year'));
        $i = 1;
        //print_r($assignment);
        foreach ($assignment as $as): ?>
        <tr id="as_<?php echo $as->ass_id ?>">
            <td><?php echo $i++ ?></td>
            <td><?php echo $as->subject ?></td>
            <td><?php echo $as->level ?></td>
            <td><?php echo $as->section ?></td>
            <td>COMING SOON</td>
            <td><button title="Delete Subject Assigned" onclick="removeSubject('<?php echo $as->ass_id ?>')" class="btn btn-xs btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-trash"></i></button></td>
        </tr>
        <?php endforeach;
    }
    
    function setAssignment()
    {
        $subject = $this->input->post('subject');
        $gradelevel = $this->input->post('gradeLevel');
        $section = $this->input->post('section');
        $specs = $this->input->post('specs');
        $user_id = $this->input->post('teacher'); 
        $checkAssignment = $this->academic_model->checkAssignment($subject, $gradelevel, $section, $this->session->userdata('school_year'));
        if($checkAssignment==1){ // if subject assignment already exist

           $data['getAssignment'] = $this->getAssignment($user_id);
           $data['result'] = TRUE;
           echo json_encode(array('status' => FALSE, 
               'msg' => '<h4>Subject is already Assigned!</h4>',
               ));
           
        }else{
            
            $items = array(
                'faculty_id'    => $this->input->post('teacher'),
                'subject_id'    => $subject,
                'grade_level_id'=> $gradelevel,
                'section_id'    => $section,  
                'school_year'   => $this->session->userdata('school_year'),
                'specs_id'      => $specs,
                'ass_id'        => $this->eskwela->codeCheck('faculty_assign', 'ass_id', $this->eskwela->code())
            );
            
           $this->academic_model->setAssignment($items);
           $data['getAssignment'] = $this->academic_model->getAssignment($user_id);
           $data['result'] = FALSE;
           echo json_encode(array('status' => TRUE, 
            'msg' => '<h4>Successfully Assigned!</h4>',
            'data' => Modules::run('academic/teachersSubjectAssignment', $this->input->post('teacher'))    
           ));
        }
        
    }
    
    function mySubject($user_id = NULL, $school_year = NULL, $opt = NULL)
    {
        $assignment = $this->academic_model->mySubjects($user_id, $school_year, $opt);
        return $assignment;
    }
    function getAssignment($user_id = NULL, $school_year = NULL)
    {
        $assignment = $this->academic_model->getAssignment($user_id, $school_year);
        return $assignment->result();
    }
    
    function getSpecificSubjectAssignment($user_id, $section_id, $subject_id, $school_year=NULL)
    {
        $assignment = $this->academic_model->getSpecificSubjectAssignment($user_id, $section_id, $subject_id, $school_year);
        return $assignment;
    }
    
    function getStudentWspecializedSubject($specs_id, $school_year = NULL)
    {
        $students = $this->academic_model->getStudentWspecializedSubject($specs_id, $school_year);
        return $students;
    }
    
    function getStudentBySubject($grade_id = null, $section_id = null, $subject_id = null, $specs_id = NULL)
    {
        $user_id = $this->session->userdata('user_id');
        $gs_settings = Modules::run('gradingsystem/getSet');
        $data['getEmployee'] = Modules::run('hr/getEmployee', base64_encode($user_id)); 
        $data['getSpecificSubjects'] = $this->getSpecificSubjects($subject_id);
	    $data['getSection'] = Modules::run('registrar/getSectionById', $section_id);
        $data['selectSection'] = Modules::run('registrar/getSectionBySubject', $grade_id);
        
        if($gs_settings->used_specialization):
            switch ($grade_id):
                case 10:
                case 11:
                    $data['students'] = $this->getStudentWspecializedSubject($specs_id);
                break;
                default:
                    $data['students'] = Modules::run('registrar/getAllStudentsForExternal', $grade_id, $section_id);
                break;    
            endswitch;
        else:
            $data['students'] = Modules::run('registrar/getAllStudentsForExternal', $grade_id, $section_id);
        endif;
        $data['main_content'] = 'studentListPerSubject';
        $data['modules'] = 'academic';
        echo Modules::run('templates/main_content', $data);
    }

function getSubjectsPerGradeLvl($gid) {
        $query = $this->academic_model->getSubjectsPerGradeLvl($gid);
        ?><option>Select Subject</option><?php
        foreach ($query as $s):
            ?>
        <option value="<?php echo $s->subject_id ?>" onclick="$('#subject_id').val('<?php echo $s->subject_id ?>')"><?php echo $s->subject ?></option>
            <?php
        endforeach;
    }    

    function getSpecificSubjects($subject_id)
    {
        $subject = $this->academic_model->getSpecificSubjects($subject_id);
        return $subject;
    }
    
    function getSubjectTeacher($subject_id, $section_id, $school_year=NULL)
    {
        $teacher = $this->academic_model->getSubjectTeacher($subject_id, $section_id, $school_year);
        return $teacher;
    }


    function getSpecificSubjectPerlevel($grade_id = NULL, $sy = NULL, $opt = NULL, $term = NULL, $strand = NULL) {
        if ($grade_id == 12 || $grade_id == 13):
            $subject = $this->academic_model->getSHSubjectID($grade_id, $term, $strand);
        else:
            $subject = $this->academic_model->getSubjectPerLevel($grade_id, $sy);
        endif;
        if ($opt == NULL):
            return $subject;
        else:
            if ($grade_id == 12 || $grade_id == 13):
                foreach ($subject as $s):
                    $sDesc = $this->academic_model->getSpecificSubjects($s->sh_sub_id);
                    ?>
                    <option value="<?php echo $s->sh_sub_id ?>"><?php echo $sDesc->subject ?></option>
                    <?php
                endforeach;
            else:
                foreach ($subject as $s):
                    $sDesc = $this->academic_model->getSpecificSubjects($s->sub_id);
                    ?>
                    <option value="<?php echo $s->sub_id ?>"><?php echo $sDesc->subject ?></option>
                    <?php
                endforeach;
            endif;
        endif;
    }
    
    function getSHSubjectID($gradeID, $term, $strand) {
        $subject = $this->academic_model->getSHSubjectID($gradeID, $term, $strand);
        return $subject;
    }
    
    function getSubjectsPerLevel($grade_id = NULL)
    {
        if($grade_id==NULL):
            $grade_id = $this->input->post('gradeLevel');
        endif;
        $subject_ids = $this->getSpecificSubjectPerlevel($grade_id);
        $singleSubject="";
        if(!empty($subject_ids)):
              $subject = explode(',', $subject_ids->subject_id);
          foreach($subject as $s){  
              $singleSub = Modules::run('academic/getSpecificSubjects', $s);
              if($singleSubject!=""):
                  $singleSubject = $singleSubject.','.$singleSub->subject;
              else:
                   $singleSubject = $singleSub->subject;
              endif;
              
              } 
              echo $singleSubject;
          endif;  

    }

    function getSubjectsPerLevelDropDown($grade_id)
    {
        
        $subject_ids = $this->getSpecificSubjectPerlevel($grade_id);
        $singleSubject="";
        if(!empty($subject_ids)):
              $subject = explode(',', $subject_ids->subject_id);
          ?>
            <option value="0">Select Subject</option> 
          <?php
          foreach($subject as $s){  
              $singleSub = Modules::run('academic/getSpecificSubjects', $s);
                ?>                        
                      <option value="<?php echo $singleSub->subject_id; ?>"><?php echo $singleSub->subject; ?></option>
              <?php

              } 
              
          endif;  
    }

    function deleteAssignment($data, $teacher){
            $this->academic_model->deleteAssignment($data);
            
            echo json_encode(array('status' => TRUE, 
                'msg' => '<h4>Successfully deleted!</h4>',
                'data' => Modules::run('academic/teachersSubjectAssignment', $teacher)    
            ));
        }
   

    function setAdviser()
        {
            $advisory = array(
                   'adv_id' => $this->eskwela->codeCheck('advisory', 'adv_id', $this->eskwela->code()),
                   'faculty_id'=> $this->input->post('inputFacultyID'),
                   'grade_id'=> $this->input->post('inputGradeModal'),
                   'section_id'=> $this->input->post('inputSectionModal'),
                   'school_year'=> $this->session->userdata('school_year'),
                   
           );
            //echo $this->input->post('inputFacultyID');
                    $result = $this->academic_model->saveAdvisory($advisory,$this->post('inputGradeModal'), $this->post('inputSectionModal'),$this->session->userdata('school_year') );
                   if($result):
                        $this->academic_model->updateEmployeePosition($this->input->post('inputFacultyID'));
                        echo 'Successfully Assigned';
                   else:
                       echo "Advisory Already Assigned";
                   endif;
                    
        }
        
    function getAdvisory($faculty_id = NULL, $year = NULL, $section = NULL)
    {
        $advisory = $this->academic_model->getAdvisory($faculty_id, $section, $year);
        return $advisory;
    }
        
    function deleteAdvisory($adv_id=NULL,$uid=NULL)
    {
        
        $this->academic_model->deleteAdvisory($uid, $adv_id);
        echo json_encode(array('status' => TRUE, 
                'msg' => '<h4>Successfully deleted!</h4>',
                'data' => 'NONE'  
            ));
        

    }

function getAdviser($sec,$grdID,$sy){
        $adviser = $this->academic_model->getAdviser($sec,$grdID,$sy);
        return $adviser;
    }
    
    
    function getSectionAssign($user_id, $school_year = NULL){
        return $this->academic_model->getSectionAssign($user_id, $school_year);
    }
    
    function getSubjectPerSection() {
        $faculty_id = $this->input->post('faculty_id');
        $grade_id = $this->input->post('grade_id');
        $section_id = $this->input->post('section_id');
        $subj = $this->academic_model->getSubjectPerSection($faculty_id, $grade_id, $section_id);
        foreach ($subj as $s):
            ?>
                <option value="<?php echo $s->subj_id ?>"><?php echo $s->subject ?></option>
            <?php
        endforeach;
    }
}
