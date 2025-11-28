<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class College extends MX_Controller {
    //put your codeupdateEnrollmentStatus here
    function __construct() {
        parent::__construct();
        $this->load->model('college_model');
    	$this->load->model('get_college_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
        $this->load->library('router');
        if($this->uri->segment(2)!='enrollment'):
            if(!$this->session->is_logged_in):
                redirect('login');
            endif;
        endif;
    }
    
    
    function generateTES($semester, $school_year)
    {
        set_time_limit(300) ;
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();
        
        $data['settings']= $settings;
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        
        $this->load->view('tesApplication', $data);
        
        $students = $this->get_college_model->getStudentsForTES(NULL,$school_year, $semester,NULL,NULL,1);
        $y = 7;
        $seq = 1;
        foreach ($students as $s):
            $data['seq'] = $seq++;
            $data['y'] = $y++;
            $data['s'] = $s;
            $data['assessment'] = json_decode(Modules::run('college/finance/getAssessmentPerStudent', $s));
            $this->load->view('tesApplicationDetails', $data);
        endforeach;
        
        $filename=$settings->short_name.'_TES_Application.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    function deleteFacultyAssignment($sched_code, $school_year)
    {
        if($this->college_model->deleteFacultyAssignment($sched_code, $school_year)):
            echo json_encode(array('msg'  => 'Deleted Successfully', 'status' => TRUE));
        endif;
    }
    
    public function getAdmission()
    {
        $this->db->where('school_year', 2019);
        $q = $this->db->get('profile_students_c_admission');
        foreach ($q->result() as $student):
            
            $this->db->where('user_id', $student->user_id);
            $q1 = $this->db->get('profile_students');
            
            $sDetails = array(
                'st_id'     => $student->st_id,
                'user_id'   => $student->user_id,
                'parent_id' => $student->user_id
            );
            
            if($q1->num_rows() > 0):
                $this->db->where('user_id', $q1->user_id);
                $this->db->update('profile_students', $sDetails);
                echo $student->user_id.' updated<br / >';
            else:
                $this->db->insert('profile_students', $sDetails);
                echo $student->user_id.' inserted<br / >';
            endif;
            
            
        endforeach;
    }
    
    public function getTeams($school_year, $sem, $team_id)
    {
        $data['students'] = $this->get_college_model->getTeams($school_year, $sem, $team_id);
        $this->load->view('teamMembers', $data);
    }
    
    public function printStudentsPerCourse($course_id, $year_level, $sem, $school_year)
    {
        $this->load->helper('file');
        $settings = Modules::run('main/getSet');
        $data['students'] = $this->get_college_model->getStudentPerCourse($school_year, $sem, $year_level, $course_id);
        
        if(file_exists(APPPATH.'modules/college/views/'. strtolower($settings->short_name).'_studentListPerCourse.php')):
            $this->load->view(strtolower($settings->short_name).'_studentListPerCourse', $data);
        else:
            $this->load->view('studentListPerCourse', $data);
        endif;
    }
    
    public function getStudentPerCourse($course_id, $sem, $year, $limit=NULL, $offset=NULL, $level=NULL, $status=NULL)
    {
        
        $students = $this->get_college_model->getAllCollegeStudents($limit, $offset,  $year, $sem, $course_id, $level, $status);
        return $students;
    }
    
    public function index()
    {
        
        $menu = $this->get_college_model->getMenuAccess($this->session->userdata('user_id'));
        $data['pmenu'] = $menu;
        $data['modules'] = 'college';
        switch ($this->session->userdata('position')):
            default:
                $data['menus'] = ($menu!=""?explode(',', $menu->cma_personal_access):"");
                $data['main_content'] = 'default';
            break;
            case 'Dean':
                $data['menus'] = explode(',', '2,5,7,9,11,12,13,18');
                $data['main_content'] = 'faculty/dean_dashboard';
            break;    
            case 'DSA':
            case 'Faculty':
                if(count(explode(',', $menu->cma_personal_access))==0):
                    $data['menus'] = explode(',', '9');
                else:
                    $data['menus'] = explode(',', $menu->cma_personal_access);
                endif;
                $data['totalStudents'] = $this->getStudentsPerTeacher($this->session->userdata('employee_id'));
                $data['main_content'] = 'faculty/teachers_dashboard';
            break;    
            case 'High School Faculty':
            case 'Part-Time Faculty':
                if(count(explode(',', $menu->cma_personal_access))==0):
                    $data['menus'] = explode(',', '9');
                else:
                    $data['menus'] = explode(',', $menu->cma_personal_access);
                endif;
                $data['totalStudents'] = $this->getStudentsPerTeacher($this->session->userdata('employee_id'));
                $data['main_content'] = 'faculty/teachers_dashboard';
            break;    
        endswitch;
        echo Modules::run('templates/college_content', $data);
    }
    
    function enrollmentReport($school_year=NULL, $sem=NULL)
    {
        if($sem==NULL):
            $sem = Modules::run('main/getSemester');
        endif;
        $data['school_year'] = ($school_year==NULL?$this->session->userdata('school_year'):$school_year);
 
        $data['ro_year'] = $this->getROYear();
        $data['sem'] = $sem;
        $data['modules'] = 'college';
        $data['main_content'] = 'enrollmentReport';
        
        echo Modules::run('templates/college_content', $data);
    }
    
    function saveAdmissionRemarks()
    {
        $user_id = $this->input->post('user_id');
        $sem = $this->input->post('semester');
        $code = $this->input->post('code');
        $sy = $this->input->post('sy');
        $info = $this->input->post('info');
        $stid = $this->input->post('stid');
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $array = array(
           'status' => $code 
        );
        
        $status = $this->college_model->saveAdmissionRemarks($array, $user_id, $sem, $sy);
        if($status):
            $this->college_model->saveRemarks($info, $stid, $date, $code, $sy);
            echo 'Status Successfully Updated';
        else:
            echo 'Sorry Something went wrong';
        endif;
    }
            
    function getCoursePerNumYear($num)
    {
        $courses = $this->college_model->getCoursePerNumYear($num);
        return $courses;
    }
    
        
    function checkEnrollees()
    {
//        $q = $this->db->query('Select esk_profile.user_id as uid, lastname, esk_profile_students.st_id from esk_profile 
//                                left join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
//                                left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
//                                where account_type = 5 and not exists(Select * from esk_profile_students_admission where esk_profile.user_id = esk_profile_students_admission.user_id order by lastname)
//                            ');
        $q = $this->db->query('Select esk_profile_students.st_id, esk_profile.user_id, lastname, firstname from esk_profile_students 
                                left join esk_profile on esk_profile_students.user_id = esk_profile.user_id
                                left join esk_profile_students_c_admission on esk_profile_students.user_id = esk_profile_students_c_admission.user_id
                                where account_type = 5 and not exists(Select * from esk_profile_students_c_admission where esk_profile_students.user_id = esk_profile_students_c_admission.user_id order by lastname)
                            ');
       // print_r($q->result());
        echo '<br />';
        echo '<br />';
        $i=1;
        foreach ($q->result() as $qr):
            $i++;
            echo $qr->user_id.' - '.$qr->lastname.' - '.$qr->firstname.' - '.$qr->st_id.'<br />';
//            $this->db->where('user_id', $qr->user_id);
//            if($this->db->delete('profile')):
//                echo $qr->user_id.' successfully deleted <br />';
//            endif;
//            $this->db->where('user_id', $qr->user_id);
//            if($this->db->delete('profile_students')):
//                echo $qr->user_id.' successfully deleted <br />';
//            endif;
        endforeach;
//        echo 'Deleted '. $i.' accounts';
    }
    
    
    function cleanEnrollees()
    {
        $q = $this->db->query('Select esk_profile_students.st_id, esk_profile.user_id as uid, lastname from esk_profile 
                                left join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                                where account_type = 5 and not exists(Select * from esk_profile_students where esk_profile.user_id = esk_profile_students.user_id order by lastname)
                            ');
        foreach ($q->result() as $qr):
            echo $qr->uid.' - '.$qr->lastname.' - '.$qr->firstname.' - '.$qr->st_id.'<br />';
//            $this->db->where('user_id', $qr->uid);
//            if($this->db->delete('profile')):
//                echo $qr->uid.' successfully deleted <br />';
//            endif;
        endforeach;
    }
    
    function scanStudent($rfid)
    {
        $students = $this->getSingleStudentByRfid($rfid);
        echo json_encode(array('st_id' => base64_encode($students->row()->st_id)));
    }
    
    
    function getStudentsPerTeacher($teacher_id, $school_year=NULL, $semester=NULL, $status=NULL)
    {
        $sem = Modules::run('main/getSemester');
        $courses = Modules::run('college/schedule/getCourseAssignPerTeacher', $teacher_id);
        $students = 0;
        foreach ($courses as $c):
            $students += $this->getTotalCollegeStudents(($school_year==NULL?$this->session->userdata('school_year'):$school_year), ($semester==NULL?$sem:$semester), ($status==NULL?1:$status), $c->spc_course_id, $c->year_level);
        endforeach;
        return $students;
    }
    
    function updateEnrollmentStatus($st_id, $sy, $sem, $status)
    {
        $stat = $this->get_college_model->updateEnrollmentStatus($st_id, $sy, $sem,array('status' => $status));
        return $stat;
    }
    
    function getAdmissionDetails($st_id, $sem, $sy)
    {
        $admission = $this->get_college_model->getAdmissionDetails($st_id, $sem, $sy);
        return $admission;
    }
    
    
    function facultyAssignment($faculty_id = NULL, $semester = NULL, $school_year =NULL)
    {
           $user_id = $this->session->userdata('user_id');
           
           $sem = Modules::run('main/getSemester');
           $data['ro_year'] = Modules::run('registrar/getROYear');
           $data['faculty_id'] = base64_decode($faculty_id);
           $data['semester'] = $semester==NULL?$sem:$semester;
           $data['school_year'] = $school_year==NULL?$this->session->school_year:$school_year;
           $data['getEmployee'] = Modules::run('hr/getEmployee', base64_encode($user_id)); 
           $data['employeeList'] = Modules::run('hr/getEmployees'); 
           $data['subjects'] = Modules::run('subjectmanagement/getCollegeSubjects');
           $data['grade'] = Modules::run('registrar/getGradeLevel');
           $data['section'] = Modules::run('registrar/getAllSection');
           //$data['getAssignment'] = $this->mySubject($user_id);
           //$data['getAllAssignment'] = $this->getAssignment(NULL, $school_year);
           
         if(!$this->session->userdata('is_logged_in')){
                Modules::run('login');
            }else{
               $data['main_content'] = 'faculty/subject_assignment';
               $data['modules'] = 'college';
               echo Modules::run('templates/college_content', $data);	
            }
        
    }
    
    
    function getAssignedSubjectCollege()
    {
        $id = $this->post('id');
        $data['id'] = $id;
        $data['assignment'] = $this->getAssignment($id, $this->session->userdata('school_year'));
        $this->load->view('college/subjectAssigned', $data);
    }
    
    public function getMenuByPosition($position)
    {
        $menu = $this->get_college_model->getMenuByPosition($position);
        return $menu;
    }
    
    public function getMenu($menu_id)
    {
        $menu = $this->get_college_model->getMenu($menu_id);
        return $menu;
    }
    
    function rooms()
    {
        $data['rooms'] = $this->college_model->getRooms();
        $data['modules'] = 'college';
        $data['main_content'] = 'rooms/default';
        echo Modules::run('templates/college_content', $data);
    }
    
    function getRooms()
    {
        $rooms = $this->college_model->getRooms();
        return $rooms;
    }
    
    public function settings()
    {
        
    }
    
    public function deleteROStudent()
    {
        $user_id = $this->input->post('st_id');
        $adm_id = $this->input->post('adm_id');
        $sy = $this->input->post('sy');
        if($sy==''):
            $sy = $this->session->userdata('school_year');
        endif;
        
        if($this->get_college_model->deleteROStudent($user_id, $sy, $adm_id)):
            $profile = $this->getBasicInfo($user_id, $this->session->school_year);
            $remarks = $this->session->userdata('name')." has deleted this student named ".strtoupper($profile->firstname.' '.$profile->lastname).' from the list of Enrollees';
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
            
            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            $statusArray = array(
                'status'    => true,    
                'remarks'   => $remarks,    
                'username'    => $registrar->employee_id,
                'msg'       => "Successfully Deleted"
            );
            echo json_encode($statusArray);
        else:
            echo 'Error has occured';
        endif;
        
    }
    
    function isEnrolled($id, $year)
    {
        $result = $this->college_model->isEnrolled($id, $year);
        return $result;
    }
     
    function viewCollegeDetails($id, $sem=NULL, $year=NULL)
    {
        if($sem==NULL):
            $sem = Modules::run('main/getSemester');
        endif;
        $id = base64_decode($id);
        $year = ($year==NULL?$this->session->school_year:$year);
        
        $students = $this->get_college_model->getSingleCollegeStudent($id, $year, $sem);  
        if($this->session->userdata('position')=='Parent'):
            $data['editable'] = 'hide';
        elseif($this->session->userdata('position_id')==65):
            $data['editable'] = 'hide';
        else:
            $data['editable'] = '';
        endif;
       
        $menu = $this->get_college_model->getMenuAccess($this->session->user_id);
        $data['menus'] = ($menu!=""?explode(',', $menu->cma_personal_access):"");
        $data['students'] = $this->get_college_model->getSingleCollegeStudent($id, $year, $sem);  
        $data['m'] = $this->get_college_model->getMother($students->user_id); 
        $data['f'] = $this->get_college_model->getFather($students->user_id); 
        $data['date_admitted'] = $this->get_college_model->getDateEnrolled($students->u_id);
        $data['option'] = 'individual';
        $data['religion'] = Modules::run('main/getReligion');
        $data['st_id']=$id;
        $data['educ_attain'] = $this->college_model->getEducAttain();
        $data['modules'] = 'college';
        
        if($this->session->position=='Registrar Staff'):
            $data['main_content'] = 'collegeInfoAcademe';
        else:   
            $data['main_content'] = 'collegeInfo';
        endif;
        echo Modules::run('templates/college_content', $data);
    }
    
    function getTotalCollegeStudents($school_year, $semester, $status, $course=NULL, $level=NULL, $gender = NULL)
    {
        $total = $this->get_college_model->getTotalCollegeStudents($course, $level, $school_year, $semester, $status, $gender);
        //echo $total;
       return $total;
    }

    function getCollegeStudentsByYear($school_year, $sem){
        $result = $this->get_college_model->getCollegeStudentsByYear($school_year, $sem);
        return $result;
    }
    
    function getCollegeStudentsBySemester($school_year, $semester)
    {
            $result = $this->get_college_model->getAllCollegeStudents('','', urldecode($school_year), $semester);
            //print_r($result->result());
            $config['base_url'] = base_url('college/getStudents/'.$semester);
            $config['total_rows'] = $result->num_rows();
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<ul class="pagination">';
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
            $data['links'] = $this->pagination->create_links();
                    
            $page = $this->get_college_model->getAllCollegeStudents($config['per_page'], $this->uri->segment(5),$school_year, $semester );
            $data['students'] = $page->result();
            $data['num_of_students'] = $page->num_rows();
            $data['school_year'] = $school_year;
            $data['settings'] = $this->eskwela->getSet();
            
            $this->load->view('collegeStudentTable', $data);
    }
    
    function getStudents($sem=NULL)
    {
        if($sem==NULL):
            $sem = Modules::run('main/getSemester');
            
        endif;
        $seg = $this->uri->segment(4);
        $base_url = base_url('college/getStudents/'.$sem);
        
//        if($this->uri->segment(4)):
//            
//        else:
//            $seg = $this->uri->segment(3);
//            $base_url = base_url('college/getStudents/');
//        endif;
        if($this->session->userdata('position_id')!=4):
            //$result = $this->get_college_model->getAllCollegeStudents('','',Null, Null, $this->session->userdata('school_year'), $sem);
            $result = $this->get_college_model->getAllCollegeStudents('', '', $this->session->userdata('school_year'), $sem);
            $config['base_url'] = $base_url;
            $config['total_rows'] = $result->num_rows();
            $config['per_page'] = 10;
            $config['full_tag_open'] = '<ul class="pagination">';
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
            $data['links'] = $this->pagination->create_links();
            
            $page = $this->get_college_model->getAllCollegeStudents($config['per_page'], $seg, $this->session->userdata('school_year'), $sem );
            $data['students'] = $page->result();
            $data['course']  = Modules::run('coursemanagement/getCourses');
            $data['num_of_students'] = $page->num_rows();
            $data['ro_year'] = $this->getROYear();
            $data['main_content'] = 'collegeStudents';
            $data['modules'] = 'college'; 
            echo Modules::run('templates/college_content', $data);
            
       else:
            $data['students'] = $this->get_college_model->getStudentListForParent($this->session->userdata('parent_id'));
            $data['main_content'] = 'parentRoster';
            $data['modules'] = 'college';
            echo Modules::run('templates/main_content', $data);

       endif; 
    }
    
    public function getROYear()
    {
        $year = $this->get_college_model->getROYear();
        return $year;
    }
        
    
    function getStudentListForParents($parent_id=NULL)
    {
        $students = $this->get_college_model->getStudentListForParent($parent_id);
        return $students;
    }
    
    function getLatestCollegeNum($level_id)
    {
        $id = $this->college_model->getLatestCollegeNum($level_id);
        $ids = json_decode($id);
        if($ids->num_rows==0):
          $last_three = '000';  
        else:
          $last_three = substr($ids->generated_id, -4);  
        endif;
        
        $temp_id = $this->college_model->generateTempId($ids->generated_id, abs($last_three));
        
        echo json_encode(array('status' => TRUE, 'id' => $temp_id));
    }
    

    public function saveCollegeRO()
    {
        $settings = Modules::run('main/getSet');
        $course = $this->input->post('course_id');
        $semester = $this->input->post('semester');
        $school_year = $this->input->post('school_year');
        $year_level = $this->input->post('year_level');
        if($semester==1):
            $year_level=$year_level+1;
            $sy=$school_year+1;
        else:
            $sy = $school_year;
        endif;
        
        $st_id = $this->input->post('st_id');
        $user_id = $this->input->post('user_id');
        $profile = $this->get_college_model->getPreviousRecord('profile', 'user_id', $user_id,  $school_year, $settings );
        
        
        if(!$this->get_college_model->checkCollegeRO($user_id, $semester, $school_year)):
            
        if($semester==1):    
            $profile = $this->get_college_model->getPreviousRecord('profile', 'user_id', $user_id,  $school_year, $settings );
            $profile_students = $this->get_college_model->getPreviousRecord('profile_students','user_id',$profile->user_id, $school_year, $settings);
            $profile_address = $this->get_college_model->getPreviousRecord('profile_address_info','address_id',$profile->add_id, $school_year, $settings);
            $profile_contact = $this->get_college_model->getPreviousRecord('profile_contact_details','contact_id',$profile->contact_id, $school_year, $settings);
            $profile_parents = $this->get_college_model->getPreviousRecord('profile_parents','parent_id',$profile->user_id, $school_year, $settings);
            $bdate = $this->get_college_model->getPreviousRecord('calendar','cal_id',$profile->bdate_id, $school_year, $settings);

            //print_r($profile_parents);
            if($profile_parents->guardian==0):
                $f_profile = $this->get_college_model->getPreviousRecord('profile','user_id', $profile_parents->father_id, $school_year, $settings);
                $m_profile = $this->get_college_model->getPreviousRecord('profile','user_id', $profile_parents->mother_id, $school_year, $settings);
            else:
                $g_profile = $this->get_college_model->getPreviousRecord('profile','user_id',$profile_parents->guardian, $school_year, $settings);
            endif;

            $date = strtr($bdate->cal_date, '-', '/');
            $date = date('Y-m-d', strtotime($date));
            
                $this->get_college_model->insertData($profile, 'profile','user_id', $profile->user_id, $sy);
                $this->get_college_model->insertData($profile_students, 'profile_students','user_id', $profile->user_id, $sy);
                //$this->get_college_model->insertData($profile_parents, 'profile_parents');
                $parent_details = array(
                    'parent_id'             => $profile->user_id,
                    'father_id'             => $profile_parents->father_id,
                    'mother_id'             => $profile_parents->mother_id,
                    'f_office_name'         => $profile_parents->f_office_name,
                    'f_office_address_id'   => $profile_parents->f_office_address_id,
                    'm_office_name'         => $profile_parents->m_office_name,
                    'm_office_address_id'   => $profile_parents->m_office_address_id

                );

                $this->get_college_model->insertData($parent_details, 'profile_parents', 'parent_id', $profile->user_id, $sy);

                $this->get_college_model->insertData($m_profile, 'profile','user_id', $profile_parents->mother_id, $sy);
                $this->get_college_model->insertData($f_profile, 'profile','user_id', $profile_parents->father_id, $sy);
                //$dateItems = explode('-', $bdate->cal_date);
                $bCal = array(
                    'temp_bdate'  => $date
                );

                Modules::run('calendar/saveCalendar', $bCal, $profile->user_id);

                //$date_id = Modules::run('calendar/saveDate', date('Y-m-d'));


                $this->get_college_model->insertData($profile_address, 'profile_address_info','address_id',$profile->add_id, $sy);
                $this->get_college_model->insertData($profile_contact, 'profile_contact_details','contact_id',$profile->contact_id, $sy);
                    
            endif;
            
            $details = array(
                'school_year'   => $sy,
                'semester'      => $semester,
                'date_admitted' => date('Y-m-d'),
                'user_id'       => $user_id,
                'course_id'     => $course,
                'year_level'    => $year_level,
                'status'        => 1,
                'st_id'         => $st_id,
                'is_old'        => 1
            );
           
            $ro_id = $this->get_college_model->saveCollegeRO($details, $sy);
            if(!$ro_id):
                echo 'Sorry, something went wrong, Please Try Again';
            else:    
                switch ($semester):
                    case 1:
                        $semName = '1st Semester';
                    break;    
                    case 2:
                        $semName = '2nd Semester';
                    break;    
                    case 3:
                        $semName = 'Summer';
                    break;    
                endswitch;
                $remarks = $this->session->userdata('name').' has ROLL OVER a student named '.$profile->lastname.', '.$profile->firstname.' for '.$semName.'.';
                Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
                
                $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
                
                $json_array = array(
                    'remarks'   => $remarks,
                    'username'    => $registrar->employee_id,
                    'msg'       => 'Successfully Rolled Over'
                );
                
//                Modules::run('web_sync/updateSyncController', 'profile_students_c_admission', 'admission_id', $ro_id['data'], 'create', 2);
                echo json_encode($json_array);
            endif;
               
        
        else:
            echo json_encode(array('msg' => 'Student Already Exist!'));
        endif;
    }
        
    function getRfidByStid($st_id)
    {
        $rfid = $this->get_college_model->getRfidByStid($st_id);
        return $rfid;
    }
    
    function getBasicInfo($user_id, $school_year)
    {
        $student = $this->get_college_model->getBasicInfo($user_id, $school_year);
        return $student;
    }
    
        
    function getBasicStudent($user_id, $school_year = NULL)
    {
        $student = $this->get_college_model->getBasicStudent($user_id, $school_year);
        return $student;
    }
    
    function saveNewValue()
    {
        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $value  = $this->input->post('value');
        $id  = $this->input->post('pk');
        $retrieve  = $this->input->post('retrieve');
        
        $nValue = array(
            $column => $value
        );
        
        $this->college_model->saveNewValue($table, $nValue);
        $module = 'main/'.$retrieve;
        $newValue = Modules::run($module);
        //echo $module;
        //print_r($newValue);
        foreach($newValue as $row)
             {
        ?>                                
            <option value="<?php echo $row->$id ?>"><?php echo $row->$column ?></option>
        <?php
             }
    }
        
    function deleteAllStudent($school_year)
    {
        $students = $this->get_college_model->getStudents(NULL,NULL,NULL,1,$school_year);
        //print_r($students);
        foreach ($students->result() as $sts):
            $lrn = $this->get_college_model->getLrnByID($sts->uid, $school_year);
            echo $sts->uid.' '.$sts->psid.'<br/>';
            $this->college_model->deleteProfile('user_id', $sts->psid, 'esk_profile', $school_year);
            $this->college_model->deleteProfile('address_id', $sts->add_id, 'esk_profile_address_info', $school_year);
            $this->college_model->deleteProfile('contact_id', $sts->con_id, 'esk_profile_contact_details', $school_year);
            $this->college_model->deleteProfile('user_id', $sts->psid, 'esk_profile_students', $school_year);
            $this->college_model->deleteProfile('user_id', $sts->psid, 'esk_profile_students_c_admission', $school_year);
        endforeach;
        echo 'Students Records successfully Deleted';
    }
    
    
    function deleteID()
    {
        $user_id = $this->input->post('user_id');
        $st_id = $this->input->post('st_id');
        if($this->session->userdata('username')==$user_id):
            $this->college_model->deleteProfile('user_id', $st_id, 'esk_profile');
            $this->college_model->deleteProfile('user_id', $st_id, 'esk_profile_students');
            $this->college_model->deleteProfile('user_id', $st_id, 'esk_profile_students_c_admission)');
            
            $profile = $this->getBasicInfo($user_id, $this->session->school_year);
            $remarks = $this->session->userdata('name')." has deleted all the records of this student ".strtoupper($profile->firstname.' '.$profile->lastname);
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));

            
            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            $statusArray = array(
                'status'    => true,    
                'remarks'   => $remarks,    
                'username'    => $registrar->employee_id,
                'msg'       => "You have Successfully Deleted this student ( $st_id ) from the List"
            );
            
            Modules::run('notification_system/department_notification', 5, "This Teacher ( $user_id ) Deleted this student ( $st_id ) from the list ");
            
            echo json_encode($statusArray);
        else:
            echo json_encode(array('status' => FALSE, 'msg' => "It Seems that the ID you enter didn't match with your records"));
        endif;
        
    }
    
    function checkID()
    {
        $id = $this->input->post('id');
        $idExist=$this->college_model->checkID($id);
        if($idExist)
        {
            echo json_encode(array('status' => TRUE, 'msg' => 'Sorry, This ID Number Already Exist'));
        }else{
            echo json_encode(array('status' => FALSE, 'msg' => ''));
        }
    }
        
    function getMother($id)
    {
        $mother = $this->get_college_model->getMother($id);
        return $mother;
    }
    
    function getFather($id)
    {
        $mother = $this->get_college_model->getFather($id);
        return $mother;
        
    }
     
    function getSingleStudent($user_id, $year = NULL, $sem = NULL, $opt = NULL) {
        $student = $this->get_college_model->getSingleCollegeStudent($user_id, $year, $sem, $opt);
        return $student;
    }
    
    function getSingleStudentByRfid($user_id, $year=NULL)
    {
        $student = $this->get_college_model->getSingleStudentByRfid($user_id,$year);
        return $student;
    }

    function viewDetails($id, $year=NULL)
    {
        $id = base64_decode($id);
        $students = $this->get_college_model->getSingleStudent($id, $year);  
        if($this->session->userdata('position')=='Parent'):
            $data['editable'] = 'hide';
        else:
            $data['editable'] = '';
        endif;
        
        
        $data['ro_year'] = $this->getROYear();
        $data['students'] = $this->get_college_model->getSingleStudent($id, $year);  
        $data['m'] = $this->get_college_model->getMother($students->pid); 
        $data['f'] = $this->get_college_model->getFather($students->pid); 
        $data['medical'] = $this->get_college_model->getMedical($id); 
        $data['date_admitted'] = $this->get_college_model->getDateEnrolled($students->u_id);
        $data['option'] = 'individual';
        $data['religion'] = Modules::run('main/getReligion');
        $data['st_id']=$id;
        $data['educ_attain'] = $this->college_model->getEducAttain();
        
        if(Modules::run('main/isMobile')):
            $this->load->view('mobile/individualRecords', $data);
        else:
            $data['modules'] = 'college';
            if($this->session->position=='Registrar Staff'):
                $data['main_content'] = 'studentInfo';
            else:   
                $data['main_content'] = 'studentInfo';
            endif;
            echo Modules::run('templates/main_content', $data);
        endif;
        
    }
    
    function admission()
    {   
        if(!$this->session->userdata('is_logged_in')){
                ?>
                     <script type="text/javascript">
                        document.location = "<?php echo base_url()?>"
                     </script>
                <?php
             }else{
                $data['settings'] = Modules::run('main/getSet');
                $data['course']  = Modules::run('coursemanagement/getCourses');
                $data['ro_year'] = $this->getROYear(); 
                $data['cities'] = Modules::run('main/getCities');
                $data['provinces'] = Modules::run('main/getProvinces');
                $data['religion'] = Modules::run('main/getReligion');
                $data['physician'] = $this->college_model->getPhysician(); 
                $data['educ_attain'] = $this->college_model->getEducAttain();
                $data['modules'] = "college";
                $data['main_content'] = 'admission';
                echo Modules::run('templates/college_content', $data);
             }
    }

    
    function saveBasicInformation($details, $lastname, $firstname, $middlename)
    {
        $result = $this->college_model->saveBasicInformation($details, $lastname, $firstname, $middlename);
        $response = json_decode($result);
        
        return $response;
    }
    
    public function generateID($school_year)
    {
        $generatedID  = $this->college_model->getLatestBasicEdNum($school_year);
        
        if($generatedID):
                $idNumber = abs(substr($generatedID->esk_profile_students_admission_code,-4));
                $idNumber += 1;
                switch (TRUE):
                    case $idNumber < 10:
                        $idNumber = '000'.($idNumber); 
                    break;    
                    case $idNumber >= 10 && $idNumber < 100:
                        $idNumber = '00'.($idNumber); 
                    break;    
                    case $idNumber >= 100 && $idNumber < 1000:
                        
                        $idNumber = '0'.($idNumber); 
                    break;
                    case $idNumber > 1000:
                        
                        $idNumber = ($idNumber); 
                    break;
                endswitch;
            else:
                $idNumber ='0000';
            endif;
         return $idNumber;
    }
    
    public function saveAdmission()
    {
        $school_year    = $this->input->post('inputCSY');
        $semester       = $this->input->post('inputSemester');
        
        $userExist = $this->college_model->checkName($this->input->post('inputCLastName'),$this->input->post('inputCFirstName'),$this->input->post('inputCMiddleName'), $school_year);
        
        if(!$userExist){
            $idNumber  = $this->generateID($school_year);
            
            $st_id = $school_year.$semester.'2'.$idNumber;

            $generatedCode = $this->eskwela->generateRandNum();

            $this->college_model->setBarangay($this->input->post('inputBarangay'), $generatedCode, $school_year);

            $add = array(
                'street'                        => $this->input->post('inputStreet'),
                'barangay_id'                   => $generatedCode,
                'city_id'                       => $this->input->post('inputMunCity'),
                'province_id'                   => $this->input->post('inputPID'),
                'country'                       => 'Philippines',
                'zip_code'                      => $this->input->post('inputPostal'),
                'address_id'                    => $generatedCode
            );

            $this->college_model->setAddress($add, $school_year);

            $items = array(
                'lastname'              => $this->input->post('inputCLastName'),
                'firstname'             => $this->input->post('inputCFirstName'),
                'middlename'            => $this->input->post('inputCMiddleName'),
                'add_id'                => $generatedCode,
                'sex'                   => $this->input->post('inputCGender'),
                'rel_id'                => $this->input->post('inputCReligion'),
                'temp_bdate'            => date('Y-m-d', strtotime($this->input->post('inputBdate'))),
                'contact_id'            => $generatedCode,
                'nationality'           => $this->input->post('inputCNationality'),     
                'account_type'          => 5,
                'occupation_id'         => 1,
                'user_id'               => $generatedCode

           ); 

            $this->college_model->saveProfile($items, $school_year);

            //saves the basic contact
            $this->college_model->setContacts($this->input->post('inputPhone'), $this->input->post('inputEmail'), $generatedCode, $school_year);

            $enDate = $this->input->post('inputCEdate');

            //saves the basic info

            $idExist = $this->college_model->checkIdIfExist($st_id);
            if($idExist):
                $st_id = $st_id+1;
            endif;

            $this->college_model->setCollegeInfo($st_id, $generatedCode, $this->input->post('getCourse'),  $this->input->post('inputYear'), $enDate, $school_year, $this->input->post('inputSemester'), ($this->input->post('inputSLA')==""?"(No Entry)":$this->input->post('inputSLA')), ($this->input->post('inputAddressSLA')==""?"":$this->input->post('inputAddressSLA')));


            $f_occupation_id = $this->college_model->saveOccupation($this->input->post('inputF_occ'), $school_year);
            $m_occupation_id = $this->college_model->saveOccupation($this->input->post('inputM_occ'), $school_year);

                $parentDetails = array(
                    'p_id'              => $generatedCode,
                    'u_id'              => $generatedCode,
                    'f_lastname'        => $this->input->post('inputFLName'),
                    'f_firstname'       => $this->input->post('inputFName'),
                    'f_middlename'      => $this->input->post('inputFMName'),
                    'f_mobile'          => $this->input->post('inputF_num'),
                    'f_occ'             => $f_occupation_id,
                    'f_office_name'     => $this->input->post('f_officeName'),
                    'm_lastname'        => $this->input->post('inputMLName'),
                    'm_firstname'       => $this->input->post('inputMother'),
                    'm_middlename'      => $this->input->post('inputMMName'),
                    'm_mobile'          => $this->input->post('inputM_num'),
                    'm_occ'             => $m_occupation_id,
                    'ice_name'          => $this->input->post('inputInCaseName'),
                    'ice_contact'       => $this->input->post('inputInCaseContact'),
                );

                $this->college_model->saveParentDetails($parentDetails, $school_year);

                 //Medical information
    //            $this->enrollment_model->saveMed(
    //                $this->input->post('inputBType'), 
    //                $this->input->post('inputAllergies'), 
    //                $this->input->post('inputOtherMedInfo'), 
    //                $this->input->post('inputFPhy'), 
    //                $this->input->post('height'), 
    //                $this->input->post('weight'), 
    //                $generatedCode, $school_year );
            $year = '';
            switch($this->input->post('inputYear')):
                case 1:
                    $year = 'First';
                    break;
                case 2:
                    $year = 'Second';
                    break;
                case 3:
                    $year = 'Third';
                    break;
                case 4:
                    $year = 'Fourth';
                    break;
                case 5:
                    $year = 'Fifth';
                    break;
            endswitch;

            switch ($semester):
                case 1:
                    $semName = '1st Semester';
                    break;
                case 2:
                    $semName = '2nd Semester';
                    break;
                case 3:
                    $semName = 'Summer';
                    break;
            endswitch;
        
        return;
        }
    }

    function getCollegeCourse($course_id){
        return $this->college_model->fetchCollegeCourse($course_id);
    }
    
    public function setBirthdate($date, $id, $column)
    {
        $this->college_model->setDate($date, $id, $column);
    }
    
    function saveSectionValue()
    {
        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $value  = $this->input->post('value');
        $grade_id  = $this->input->post('pk');
        
        
        $nValue = array(
            $column => $value,
            'grade_level_id' => $grade_id
        );
        
        $this->college_model->saveNewValue($table, $nValue);
        $newValue = $this->getSectionByGradeId($grade_id);
        //echo $module;
        //print_r($newValue);
        foreach ($newValue->result() as $row)
        {
            ?>
            <li><?php echo $row->section  ?></li>
            <?php
        }
    }
    
    
    function getSectionByGradeId($grade_id)
    {
        $section = $this->college_model->getSectionByLevel($grade_id);
        return $section;
        
    }
    
    function getAllSection($section_id=NULL, $option=NULL)
    {
        $section = $this->college_model->getAllSection($section_id, $option);
        return $section;
    }
    
    public function enrollmentListing()
    {
        if(!$this->session->userdata('is_logged_in')){
                ?>
                     <script type="text/javascript">
                        document.location = "<?php echo base_url()?>"
                     </script>
                <?php

             }else{
                $data['main_content'] = 'enrollmentList';                   
                $data['grade'] = $this->getGradeLevel(); 
                $data['modules'] = 'college';
                echo Modules::run('templates/main_content', $data);	
             }
    }
    
    function nstpEL($semester, $school_year)
    {
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $settings = $this->eskwela->getSet();
        
        switch($semester):
            case 1:
                $sem = '1st Semester';
                $data['lts']     = 10;
                $data['cwts']    = 16;
            break;
            case 2:
                $sem = '2nd Semester';
                $data['lts']     = 185;
                $data['cwts']    = 151;
            break;
            case 3:
                $sem = 'Summer';
                $data['lts']     = 0;
                $data['cwts']    = 0;
            break;
        endswitch;
        $data['settings']= $settings;
        $data['semester'] = $semester;
        $data['sem'] = $sem;
        $data['school_year'] = $school_year;
        $data['subject'] = Modules::run('college/coursemanagement/getNstpStudents', $semester, $school_year, $data['lts']);
        $data['subject_cwts'] = Modules::run('college/coursemanagement/getNstpStudents', $semester, $school_year, $data['cwts'] );
        
        $this->load->view('nstpEL_lts', $data);
        $this->load->view('nstpEL_cwts', $data);
        
        $filename=$settings->short_name.'_NSTP Enrollment List_'.$sem.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
     function exportForId($course_id = NULL)
    {
        $this->load->library('eskwela');
        $this->load->library('excel');
        $this->load->helper('download');
        $sy = $this->session->userdata('school_year');
        $settings = $this->eskwela->getSet();
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Students');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Student ID');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Name');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Course');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Birthday');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Parents / Guardians');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Contact Number');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Address');
        $this->excel->getActiveSheet()->setCellValue('I1', 'Student Contact');
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        
        $students = $this->get_college_model->getAllCollegeStudents(600, 0, $sy, 1, $course_id);
        $column = 1;
        foreach ($students->result() as $s):
            $column++;
            $father = Modules::run('registrar/getFather', $s->parent_id);
            $mother = Modules::run('registrar/getMother', $s->parent_id);
            if($father->user_id!=""):
                $parentName = $father->firstname.' '.substr($father->middlename, 0,1).' '.$father->lastname;
            else:
                $parentName = $mother->firstname.' '.substr($mother->middlename, 0,1).' '.$mother->lastname;
            endif;
            if($father->cd_mobile!=""):
                $contact = $father->cd_mobile;
            else:
                $contact = $mother->cd_mobile;
            endif;
            if($s->street!=""):
                $address = $s->street.', '.$s->barangay.', '.$s->mun_city.', '.$s->province. ' '. $s->zip_code;
            else:
                $address = $s->barangay.', '.$s->mun_city.', '.$s->province. ' '. $s->zip_code;
            endif;
            $date = date("F d, Y", strtotime((!empty($s->cal_date)) ? $s->cal_date : $s->temp_bdate));
            $this->excel->getActiveSheet()->setCellValue('A'.$column,$s->st_id);
            $this->excel->getActiveSheet()->setCellValue('B'.$column,  strtoupper($s->firstname.' '.substr($s->middlename, 0,1).'. '.$s->lastname));
            $this->excel->getActiveSheet()->setCellValue('C'.$column,  $s->short_code.' - '.$s->year_level);
            $this->excel->getActiveSheet()->setCellValue('D'.$column, $date);
            $this->excel->getActiveSheet()->setCellValue('E'.$column, strtoupper($s->ice_name));
            $this->excel->getActiveSheet()->setCellValue('F'.$column,  $s->ice_contact);
            $this->excel->getActiveSheet()->setCellValue('G'.$column,  $address);
            $this->excel->getActiveSheet()->setCellValue('H'.$column,  $s->user_id);
            $this->excel->getActiveSheet()->setCellValue('I'.$column,  $s->cd_mobile);
        endforeach;
        
        $filename=$settings->short_name.'_'.$sy.'_'.$s->short_code.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
        
    
    function clearSem($sem)
    {
        $this->db->join('c_section','profile_students_c_load.cl_section = c_section.sec_id', 'left');
        $this->db->where('sec_sem', $sem);
        $q = $this->db->get('profile_students_c_load')->result();
        foreach($q as $row):
            $this->db->where('profile_students_c_load.cl_section', $row->sec_id);
            $this->db->delete('profile_students_c_load');
        endforeach;
    }
   
   function getAdmissionID($id, $sem, $school_year){
       return $this->get_college_model->getAdmissionID($id, $sem, $school_year);
   }
   
    function getWithdrawStudentList($value, $sem, $sy) {
        $data['list'] = $this->get_college_model->getWithdrawStudentList($value, $sem, $sy);
        switch ($value):
            case 7:
                $this->load->view('withdrawnStudentList', $data);
                break;
            case 8:
                $this->load->view('transferredOutList', $data);
                break;
            case 9:
                $this->load->view('transferredInList', $data);
                break;
        endswitch;
    }
}
