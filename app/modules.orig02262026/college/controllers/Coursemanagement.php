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
        set_time_limit(300);
    }
    
    function post($name)
    {
        return $this->input->post($name);
    }
         
    function studentsForInsurance($course_id, $sem, $year)
    {
        $this->load->library('pdf');
        $settings = $this->eskwela->getSet();
        $data['students'] = Modules::run('college/getStudentPerCourse', $course_id, $sem, $year,NULL,NULL,NULL,1);
        $data['course'] = $data['students']->row()->course;
        if(file_exists(APPPATH.'modules/college/views/'.strtolower($settings->short_name).'_enrollmentList.php')):
            $this->load->view(strtolower($settings->short_name).'_insuranceList', $data);
        else :
            $this->load->view('insuranceList', $data);
        endif;
    }
    
    public function getNstpStudents($sem, $school_year, $s_id = NULL)
    {
        $result = $this->coursemanagement_model->getnstpstudents($sem, $school_year, $s_id); 
        return $result;
       // print_r($result->result());
    }
    
    function getCoursePerId($course_id)
    {
        $course = $this->coursemanagement_model->getCoursePerId($course_id);
        return $course;
    }
    
    function getCourseInAdmission($sem, $school_year)
    {
        $course = $this->coursemanagement_model->getCourseInAdmission($sem, $school_year);
        return $course;
    }
            
    function printPromotionalReport($sem, $year, $course_id)
    {
        $this->load->library('pdf');
        if($course_id==0):
            $data['course'] = Modules::run('college/coursemanagement/getCourseInAdmission', $sem, $year);
            $this->load->view('promotionalReport_all', $data);
        else:
            $data['students'] = Modules::run('college/getStudentPerCourse', $course_id, $sem, $year, NULL,NULL,NULL,1);
            $this->load->view('promotionalReport', $data);
        endif;    
    }
            
    function printStudentsPerCourse($course_id, $sem, $year, $opt)
    {
        $this->load->library('pdf');
        $settings = $this->eskwela->getSet();
        $data['students'] = Modules::run('college/getStudentPerCourse', $course_id, $sem, $year, NULL,NULL,NULL,1);
        $data['opt'] = $opt; //-------------- temporary lng ang $opt nga variable --------------------//
        if(file_exists(APPPATH.'modules/college/views/'.strtolower($settings->short_name).'_enrollmentList.php')):
            $this->load->view(strtolower($settings->short_name).'_enrollmentList', $data);
        else :
            $this->load->view('enrollmentList', $data);
        endif;
    }
    
    function removeSubjectFromCourse($value)
    {
        $removed = $this->coursemanagement_model->removeSubjectFromCourse($value);
        if($removed):
            echo 'Successfully Removed from List';
        else:
            echo 'Sorry something went wrong';
        endif;
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
    
            
    function loadSubject($course_id, $school_year = NULL)
    {
         $fyfs = Modules::run('college/coursemanagement/getSPCView', $course_id, 1, 1,$school_year);
         $fyss = Modules::run('college/coursemanagement/getSPCView', $course_id, 1, 2,$school_year);
         $fys = Modules::run('college/coursemanagement/getSPCView', $course_id, 1, 3,$school_year);
         
         $syfs = Modules::run('college/coursemanagement/getSPCView', $course_id, 2, 1,$school_year);
         $syss = Modules::run('college/coursemanagement/getSPCView', $course_id, 2, 2,$school_year);
         $sys = Modules::run('college/coursemanagement/getSPCView', $course_id, 2, 3,$school_year);
         
         $tyfs = Modules::run('college/coursemanagement/getSPCView', $course_id, 3, 1,$school_year);
         $tyss = Modules::run('college/coursemanagement/getSPCView', $course_id, 3, 2,$school_year);
         $tys = Modules::run('college/coursemanagement/getSPCView', $course_id, 3, 3,$school_year);
         
         $fryfs = Modules::run('college/coursemanagement/getSPCView', $course_id, 4, 1,$school_year);
         $fryss = Modules::run('college/coursemanagement/getSPCView', $course_id, 4, 2,$school_year);
         $frys = Modules::run('college/coursemanagement/getSPCView', $course_id, 4, 3,$school_year);
         
         echo json_encode(array(
             'fyfs'=> $fyfs, 
             'fyss'=>$fyss, 
             'fys'=> $fys,
             'syfs'=> $syfs, 
             'syss'=>$syss, 
             'sys'=> $sys,
             'tyfs'=> $tyfs, 
             'tyss'=>$tyss, 
             'tys'=> $tys,
             'fryfs'=> $fryfs, 
             'fryss'=>$fryss, 
             'frys'=> $frys,
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
        $this->load->view('coursemanagement/subjectsPerCourse', $data);
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
        $course = $this->input->post('course');
        $year_level = $this->input->post('year_level');
        $school_year = $this->input->post('school_year');
        $admission_id = $this->input->post('admission_id');
        
        $college = array(
            'school_year' => $school_year,
            'semester'    => $semester,
            'course_id'    => $course,
            'year_level'  => $year_level,
        );
        
        if($this->coursemanagement_model->editCollegeLevel($college, $st_id, $admission_id, $school_year)):
            //update final grades as well
            $levelInGrades = array('gsa_course_id' => $course);
            if($this->coursemanagement_model->editLevelInGrades($levelInGrades, $st_id, $school_year, $semester)):
                echo json_encode(array('msg' => 'Successfully Updated'));
            else:
                echo json_encode(array('msg' => 'Sorry, Data was not updated in Grades')); 
            endif;
        else:
            echo json_encode(array('msg' => 'Sorry, Data was not updated'));
            
        endif;
    }
    
    function index()
    {
        $data['school_settings'] = Modules::run('main/getSet');
        $data['department'] = $this->getDepartment();
        $data['courses']        = $this->getCourses();
        $data['main_content']   = 'coursemanagement/default';
        $data['modules']        = 'college';
        
        echo Modules::run('templates/college_content', $data);
    }
    
    function getCourses()
    {
        $course = $this->coursemanagement_model->getCourse();
        return $course;
    }
    
    function addCourse()
    {
        $course = $this->post('course');
        $course_id = $this->post('course_id');
        $short_code = $this->post('short_code');
        $department = $this->post('department');
        $numYears = $this->post('numYears');
        
        $details = array(
            'course'            => $course,
            'short_code'        => $short_code,
            'dept_id'           => $department,
            'num_years'         => $numYears,
        );  
        
        if($course_id==0):
            if($this->coursemanagement_model->addCourse($details, $course)):
                echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
            else:
                echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Course Already Exist'));
            endif;
        else:    
            if($this->coursemanagement_model->editCourse($details, $course_id)):
                echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Updated'));
            endif;
        endif;
        
        
    }
    
    function addSection($section, $grade_id)
    {
        $details = array(
            'section'           => urldecode($section),
            'grade_level_id'    => $grade_id
        );  
        
        if($this->coursemanagement_model->addSection($details, $section, $grade_id)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Department Already Exist'));
        endif;
        
    }
    
    function deleteSection($section_id)
    {
        $this->coursemanagement_model->deleteSection($section_id);
        return;
    }

    function addDepartment($dept){
        $data = array('college_department' => urldecode($dept));

        if($this->coursemanagement_model->addDepartment($data, $dept)):
            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Added'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Sorry Section Already Exist'));
        endif;
    }
    
    function getDepartment()
    {
        $dept = $this->coursemanagement_model->getDepartment();
        return $dept;
    }

    function getCourseDept()
    {
        $cDept = $this->coursemanagement_model->getCourseDept();
        return $cDept;
    }

    function updateCourseDept($courseId,$ccID)
    {
        $data = array('dept_id' => $ccID);
        $result = $this->coursemanagement_model->updateCourseDept($data, $courseId);
        echo json_encode($result);
    }
    
}
