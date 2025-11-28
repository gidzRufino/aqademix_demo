<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author genesis
 */
class subjectmanagement extends MX_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
	$this->load->library('pagination');
        $this->get = $this->load->model('subjectmanagement_model');
       // $this->set = $this->load->model('subjectmanagement_model');
        $this->load->library('Mobile_Detect');
        //$device = new Mobile_Detect();
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function addSubject()
    {
        $subject = $this->post('subject');
        $subjectCode = $this->post('subjectCode');
        
        $subjectArray = array(
            'subject_id'    => $this->eskwela->code(),
            'subject'       => $subject,
            'short_code'    => $subjectCode
        );
        
        $status = $this->subjectmanagement_model->addSubject($subject, $subjectArray);
        
        if($status==1):
            echo 'Successfully Added';
        elseif($status==2):
            echo 'This subject already exist';
        else:    
            echo 'Sorry Something Went Wrong';
        endif;
    }

    function getSHSubjectDetails($subject_id, $grading, $school_year=NULL)
    {
        $subject = $this->subjectmanagement_model->getSHSubjectDetails($subject_id, $grading, $school_year);
        return $subject;
    }
    function getStrandCode($id){
        $strand = $this->subjectmanagement_model->getStrandByID($id);
        return $strand;
    }
    
    function getInput($name)
    {
        return $this->input->post($name);
    }
    
    function getSHOfferedStrand()
    {
        $strands = $this->subjectmanagement_model->getSHOfferedStrand();
        return $strands;
    }
    
    function saveSHStrand()
    {
        $strands = $this->getInput('strands');
        $subs = explode(',', $strands);
        foreach ($subs as $s)
        {
            $strand = $this->subjectmanagement_model->getSHStrandsByName($s);
            $details = array('offered' => 1);
            $this->subjectmanagement_model->updateSHstrand($strand->st_id, $details);
        }
    }
    
    function seniorHighModal()
    {
        $data['strands'] = $this->subjectmanagement_model->getSHStrands();
        $this->load->view('seniorHigh_modal', $data);
    }
    
    function makeCore()
    {
        $subject_id = $this->getInput('sub_id');
        $this->subjectmanagement_model->makeCore($subject_id);
    }
    
    function getSHSubjects($gradeLevel, $sem, $strand_id, $core=NULL)
    {
        $result = $this->subjectmanagement_model->getSHSubjects($gradeLevel, $sem, $strand_id, $core);
        return $result;
    }
    
    function getAllSHSubjects($gradeLevel, $sem, $strand_id)
    {
        $result = $this->subjectmanagement_model->getAllSHSubjects($gradeLevel, $sem, $strand_id);
        return $result;
    }
    
    function saveSeniorHighSubjects()
    {
        $strand_id = $this->getInput('strand_id');
        $sem = $this->input->post('sem');
        $gradeLevel = $this->input->post('gradeLevel');
        $addedSubjects = $this->input->post('addSubjects');
        $subjects = $this->input->post('subjects');
        $subs = explode(',', $addedSubjects);
        foreach ($subs as $s)
        {
            $subject_id = Modules::run('academic/getSubjectId', $s);
            $details = array(
                'id'            => $this->eskwela->code(),
                'sh_sub_id'     => $subject_id,
                'strand_id'     => $strand_id,
                'grade_id'      => $gradeLevel,
                'semester'      => $sem,
                'school_year'   => $this->session->userdata('school_year')
            );
            
            $this->subjectmanagement_model->saveSeniorHighSubjects($details, $strand_id, $sem, $gradeLevel, $subject_id);
        }
        
        $subjectsAdded = $this->getSHSubjects($gradeLevel, $sem, $strand_id);
        foreach ($subjectsAdded as $s):
            ?>
            <li><?php echo $s->subject ?></li>
        <?php
        endforeach;
    }
    
    function removeSHSubject()
    {
        $strand_id = $this->getInput('strand_id');
        $sem = $this->getInput('sem');
        $gradeLevel = $this->getInput('gradeLevel');
        $subject_id = $this->getInput('subject_id');
        
        $success = $this->subjectmanagement_model->removeSHSubject($sem, $strand_id, $gradeLevel, $subject_id);
        if($success):
            echo 'Successfully Removed';
        else:
            echo 'Sorry something went wrong';
        endif;
    }
    
    function deleteSubject()
    {
        $sub_id = $this->getInput('sub_id');
        $result = $this->subjectmanagement_model->deleteSubject($sub_id);
        if($result):
            return TRUE;
        endif;
    }
           
    function editSubject() {
        $sub_id = $this->getInput('sub_id');
        $subject = $this->getInput('subject');
        $sCode = $this->getInput('subCode');

        $data = array(
            'subject' => $subject,
            'short_code' => $sCode
        );

        $result = $this->subjectmanagement_model->editsubject($sub_id, $data);
        if ($result):
            return TRUE;
        endif;
    }
    
    function searchSubject()
    {
        $subject = $this->getInput('subject');
        
        $data['subjects'] = $this->subjectmanagement_model->searchSubject($subject);
        $this->load->view('subjectTable', $data);
    }
    
    function listOfSubjects()
    {
        $result = $this->subjectmanagement_model->getSubjects();
        $config['base_url'] = base_url('subjectmanagement/listOfSubjects');
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 10;
        $config['full_tag_open'] = '<ul class="pagination" style="margin:0;">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        
        $this->pagination->initialize($config);
        
        $page = $this->subjectmanagement_model->getSubjects($config['per_page'], $this->uri->segment(3));
        $data['links'] = $this->pagination->create_links();
        $data['subjects'] = $page->result();
        $data['main_content']   = 'listOfSubjects';
        $data['modules']        = 'subjectmanagement';
        
        echo Modules::run('templates/main_content', $data);
    }
    
    
    function getAllSubjects()
    {
        $subject = $this->subjectmanagement_model->getSubjects();
        return $subject;
    }
    
    function getCollegeSubjects()
    {
        $subject = $this->subjectmanagement_model->collegeSubjects();
        return $subject;
    }
    
    function addCollegeSubject()
    {
        $sCode = $this->getInput('inputSubjectCode');
        $sDesc = $this->getInput('inputDesc');
        $lecU = $this->getInput('inputLectureUnits');
        $labU = $this->getInput('inputLabUnits');
        $inputPreR = $this->getInput('inputPreR');
        
        $subjects = array(
            's_desc_title'  => $sDesc,
            'sub_code'      => $sCode,
            's_lect_unit'   => $lecU,
            's_lab_unit'    => $labU,
            'pre_req'       => $inputPreR
        );
        
        //print_r($subjects);
        
        if($this->subjectmanagement_model->addCollegeSubject($subjects, $sCode)):
            echo 'Succesfully Added';
        else:
            echo 'Sorry Subject Already Exist';
        endif;
        
        
    }
            
    function getSubjects($course_id=NULL)
    {
        $this->load->view('subjectsPerCourse');
    }
    
    function index()
    {
        $data['school_settings'] = Modules::run('main/getSet');
        $data['GradeLevel'] = Modules::run('registrar/getGradeLevel');
        $data['department'] = Modules::run('coursemanagement/getDepartment');
        $data['subject'] = Modules::run('academic/getSubjects');
        $data['collegeSubjects'] = $this->subjectmanagement_model->collegeSubjects();
        $this->load->view('default', $data);
    }
    
    function getCourses()
    {
        $course = $this->subjectmanagement_model->getCourse();
        return $course;
    }
    
    function addCourse($course, $short_code)
    {
        $details = array(
            'course'        => urldecode($course),
            'short_code'    => urldecode($short_code)
        );  
        
        if($this->subjectmanagement_model->addCourse($details, $course)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Course Already Exist'));
        endif;
        
    }
    
    function addSection($section, $grade_id)
    {
        $details = array(
            'section'           => $section,
            'grade_level_id'    => $grade_id
        );  
        
        if($this->subjectmanagement_model->addSection($details, $section)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Section Already Exist'));
        endif;
        
    }
    
    function deleteSection($section_id)
    {
        $this->subjectmanagement_model->deleteSection($section_id);
        return;
    }
    
    function getDepartment()
    {
        $dept = $this->subjectmanagement_model->getDepartment();
        return $dept;
    }

    function checkSubjectSettings($id) {
        return $this->subjectmanagement_model->checkSubjectSettings($id);
    }
    
    
}

