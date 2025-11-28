<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author genesis
 */
class coursemanagement extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('coursemanagement_model');
        $this->load->library('Mobile_Detect');
        //$device = new Mobile_Detect();
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
    
    function getSpecificSubjectPerCourse($course, $year_level, $sub_id, $sem, $year=NULL)
    {
        $spc_id = $this->coursemanagement_model->getSpecificSubjectPerCourse($course, $year_level, $sub_id, $sem, $year);
        return $spc_id;
    }
    
    function selectSpecificSubjectPerCourse($course, $year_level, $sem, $year=NULL)
    {
        $spc_sub = $this->coursemanagement_model->selectSubjectsPerCourse($course, $year_level, $sem, $year);
        foreach ($spc_sub as $cs):
            ?>
             <option value="<?php echo $cs->s_id; ?>"><?php echo $cs->sub_code ?></option>  
            <?php
        endforeach;
    }
    
            
    function loadSubject($course_id)
    {
         $fyfs = Modules::run('coursemanagement/getSPCView', $course_id, 1, 1);
         $fyss = Modules::run('coursemanagement/getSPCView', $course_id, 1, 2);
         $fys = Modules::run('coursemanagement/getSPCView', $course_id, 1, 3);
         
         $syfs = Modules::run('coursemanagement/getSPCView', $course_id, 2, 1);
         $syss = Modules::run('coursemanagement/getSPCView', $course_id, 2, 2);
         $sys = Modules::run('coursemanagement/getSPCView', $course_id, 2, 3);
         
         echo json_encode(array(
             'fyfs'=> $fyfs, 
             'fyss'=>$fyss, 
             'fys'=> $fys,
             'syfs'=> $syfs, 
             'syss'=>$syss, 
             'sys'=> $sys,
            ));
    }
    
    function getSubjectPerCourse($course, $year_level, $sem, $year=NULL)
    {
        $subject = $this->coursemanagement_model->getSubjectPerCourse($course, $year_level, $sem, $year);
        return $subject;
    }
    
    function getSPCView($course_id, $year_level, $sem_id=NULL, $school_year=NULL)
    {
        $data['subjects'] = $this->coursemanagement_model->getSubjectPerCourse($course_id, $year_level, $sem_id, $school_year);
        $this->load->view('subjectsPerCourse', $data);
    }
    
    function addSubjectPerCourse()
    {
        $sub_id = $this->post('subject');
        $course_id = $this->post('course_id');
        $sem_id = $this->post('semester');
        $school_year = $this->post('school_year');
        $year_level = $this->post('yearLevel');
        
        $spc = array(
            'spc_sub_id' => $sub_id,
            'spc_course_id' => $course_id,
            'spc_sem_id' => $sem_id,
            'year_level' => $year_level,
            'school_year' => $school_year,
        );
        if($this->coursemanagement_model->addSubjectPerCourse($spc, $sub_id, $course_id, $sem_id, $year_level, $school_year)):
            echo Modules::run('coursemanagement/getSPCView', $course_id, $year_level, $sem_id, $school_year);
        endif;
    }
    
    function editCollegeLevel()
    {
        $st_id = $this->input->post('st_id');
        $semester = $this->input->post('semester');
        $year_level = $this->input->post('year_level');
        $school_year = $this->input->post('school_year');
        
        $college = array(
            'school_year' => $school_year,
            'semester'    => $semester,
            'year_level'  => $year_level,
        );
        $this->coursemanagement_model->editCollegeLevel($college, $st_id);
        
    }
    
    function index()
    {
        $data['school_settings'] = Modules::run('main/getSet');
        $data['department'] = $this->getDepartment();
        $data['courses']        = $this->getCourses();
        $data['main_content']   = 'default';
        $data['modules']        = 'coursemanagement';
        
        echo Modules::run('templates/main_content', $data);
    }
    
    function getCourses()
    {
        $course = $this->coursemanagement_model->getCourse();
        return $course;
    }
    
    function addCourse($course, $short_code)
    {
        $details = array(
            'course'        => urldecode($course),
            'short_code'    => urldecode($short_code)
        );  
        
        if($this->coursemanagement_model->addCourse($details, $course)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Course Already Exist'));
        endif;
        
    }
    
    function addSection($section, $grade_id)
    {
        $details = array(
            'section_id'        => $this->eskwela->code(),
            'section'           => urldecode($section),
            'grade_level_id'    => $grade_id
        );  
        
        if($this->coursemanagement_model->addSection($details, $section, $grade_id)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Section Already Exist'));
        endif;
        
    }
    
    function deleteSection($section_id)
    {
        $this->coursemanagement_model->deleteSection($section_id);
        return;
    }
    
    function editSection($section,$id){
        $result = $this->coursemanagement_model->editSection(urldecode(trim($section)),$id);
        return $result;
    }
            
    function getDepartment()
    {
        $dept = $this->coursemanagement_model->getDepartment();
        return $dept;
    }

    function getLevelCatered($dept_id) {
        return $this->coursemanagement_model->getLevelCatered($dept_id);
    }
    
}

?>
