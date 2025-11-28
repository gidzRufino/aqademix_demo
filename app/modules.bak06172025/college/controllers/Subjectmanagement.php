<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of main
 *
 * @author genesis
 */
class subjectmanagement extends MX_Controller {
    //put your code here
    
    private $get;
    //private $set;
    function __construct() {
        parent::__construct();
	$this->load->library('pagination');
	$this->load->library('pdf');
        $this->get = $this->load->model('subjectmanagement_model');
        $this->load->library('Mobile_Detect');
        //$device = new Mobile_Detect();
        if(!$this->session->is_logged_in):
            redirect('login');
        endif;
    }
    
    
    function teacherSearch() {
        $value = $this->getInput('value');
        $school_year = $this->getInput('school_year');
        $opt = $this->getInput('opt');
        $details = $this->subjectmanagement_model->searchTeacher($value, $school_year);

        if (!empty($details)) {
            if ($opt != NULL):
                ?>
                <ul>
                    <?php
                    foreach ($details as $d) {
                        ?>
                        <li onclick="facultySubjList('<?php echo $d->employee_id ?>')"><?php echo strtoupper($d->lastname . ', ' . $d->firstname) ?></li>
                        <?php
                    }
                    ?>
                </ul>

                <?php
            else:
                ?>
                <ul>
                    <?php
                    foreach ($details as $d) {
                        ?>
                                            <!--<li onclick="getInfo(this.id), $('#teacher_id').val(this.id),$('#searchTeacher').val(this.innerHTML), $('#teacherSearch').hide()" id="<?php echo $d->employee_id ?>"><?php echo strtoupper($d->lastname . ', ' . $d->firstname) ?></li>-->
                        <li onclick="document.location = '<?php echo base_url('college/facultyAssignment/' . base64_encode($d->employee_id) . '/') ?>' + $('#semInput').val() + '/' + '<?php echo $school_year ?>'" id="<?php echo $d->employee_id ?>"><?php echo strtoupper($d->lastname . ', ' . $d->firstname) ?></li>
                        <?php
                    }
                    ?>
                </ul>

            <?php
            endif;
        }
    }
    
    function deleteSubject()
    {
        if($this->subjectmanagement_model->isSubjectDeleted($this->getInput('sub_id'),$this->getInput('school_year'))):
            echo 'Successfully Deleted';
        else:
            echo 'Something went wrong, please try again later or contact CSSCore Inc. support';
        endif;
    }
            
    
    function changeSection($school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->userdata('school_year')):$this->eskwela->db($school_year));
        $q = $this->db->get('c_section');
        
        foreach ($q->result() as $row):
            $this->db->where('sec_id', $row->sec_id);
            $this->db->update('c_section', array('section_code' => $row->sec_id));
            
        endforeach;
        echo 'Success!';
    }
     
    private function getInput($name)
    {
        return $this->input->post($name);
    }
    
    function getAssignSubject($school_year, $semester, $instructor)
    {
        $subject = $this->subjectmanagement_model->getAssignSubject(base64_decode($instructor), $semester, $school_year);
        return $subject;
    }
       
    function teachingLoad($school_year, $semester)
    {
        $data['schedule'] = $this->subjectmanagement_model->getSchedule($school_year, $semester);
        $this->load->view('subjectmanagement/reports/teachingLoadSummary', $data);
        
    }
    
    function getSchedulePerTeacher($teacher_id, $sem = NULL, $school_year = NULL) {
        $subjects = $this->subjectmanagement_model->getSchedulePerTeacher($teacher_id, $sem, $school_year);
        $data['id'] = $teacher_id;
        $data['semester'] = $sem;
        $data['school_year'] = $school_year;
        $data['subjects'] = $subjects;
        $this->load->view('gradingsystem/facultyAssignment', $data);
    }
    
    function teachingLoadPerInstructor($school_year, $semester, $instructor)
    {
        $data['id'] = $instructor;
        $data['sem'] = $semester;
        $data['school_year'] = $school_year;
        $data['subjects'] = $this->subjectmanagement_model->getAssignSubject(base64_decode($instructor), $semester, $school_year);
        $this->load->view('subjectmanagement/reports/teachingLoad', $data);
    }
    
    function searchListOfClasses($value, $semester=NULL, $school_year=NULL)
    {
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['subjects'] = $this->subjectmanagement_model->searchClassList(urldecode($value), $semester, $school_year);
        $this->load->view('subjectmanagement/classListDetails', $data);
    }
    
    function getListOfClasses($school_year, $semester, $requested)
    {
        set_time_limit(300) ;
        if($semester==NULL):
            $semester = Modules::run('main/getSemester');
        endif;
        $data['semester'] = $semester;
        $data['requested'] = $requested;
        $data['school_year'] = ($school_year==NULL?$this->session->school_year:$school_year);
        $data['subjects'] = $this->subjectmanagement_model->getListOfClasses($semester, $school_year, $requested);
        $this->load->view('subjectmanagement/reports/listOfClasses', $data);
        
    }
    
    function classList($school_year=NULL, $semester = NULL)
    {
        if($semester==NULL):
            $semester = Modules::run('main/getSemester');
        endif;
        $data['semester'] = $semester;
        $data['ro_year'] = Modules::run('college/getROYear');
        $data['school_year'] = ($school_year==NULL?$this->session->school_year:$school_year);
        $data['next']= ($school_year==NULL?$this->session->school_year+1:$school_year+1);
        $data['sem'] = $semester;
        $data['subjects'] = $this->subjectmanagement_model->classList($semester, $data['school_year']);
        
        if ($this->session->userdata('position') == 'Faculty' || $this->session->userdata('position') == 'Part-Time Faculty'):
            $data['teacher_id'] = $this->session->userdata('employee_id');
            $data['main_content'] = 'subjectmanagement/faculty_listOfClasses';
        else:
            $data['main_content'] = 'subjectmanagement/listOfClasses';
        endif;
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    public function getClaimedData($result)
    {
        $data['result'] = $result;
        $this->load->view('subjectmanagement/claimDocData', $data);
    }
    
    function checkIfDocIsClaimed()
    {
        $st_id = $this->getInput('st_id');
        $sem = $this->getInput('semester');
        $school_year = $this->getInput('school_year');
        $doc_type = $this->getInput('doc_type');
        $status = json_decode($this->subjectmanagement_model->checkIfDocIsClaimed(base64_decode($st_id), $sem, $school_year, $doc_type));
        
       echo json_encode(array('isClaimed' => $status->isClaimed, 'details' => Modules::run('college/subjectmanagement/getClaimedData', $status->details)));
    }
       
    function printClassCard($st_id, $sem, $sy=NULL, $term = NULL, $is_claimed = NULL)
    {
        if($is_claimed!=NULL):
            $this->subjectmanagement_model->saveClaimCard(base64_decode($st_id), $sem, $sy);
        endif;
        $data['st_id']  = base64_decode($st_id);
        $data['sem']    = $sem;
        $data['sy']     = $sy;
        $data['term']   = $term;
        $this->load->view('subjectmanagement/reports/printClassCard', $data);
    }
    
    public function getStudyLoad($admission_id, $sem)
    {
        $data['subjects'] = $this->getLoadedSubject($admission_id, $sem);
        $this->load->view('subjectmanagement/viewStudyLoad', $data);
    }
    
    public function printStudentsPerSubject($subject_id, $section_id, $sem, $school_year)
    {
        $data['students'] = $this->getStudentsPerSectionPrint($section_id, $sem, $school_year);
//       / print_r($data);
        $this->load->view('enrollmentListPerSubject', $data);
    }
    
    public function getSubjectPerId($sub_id, $school_year = NULL)
    {
        $subjects = $this->subjectmanagement_model->getSubjectPerId($sub_id, $school_year);
        return $subjects;
    }

    public function getSubjectOfferedPerSem($sem)
    {
        $subjects = $this->subjectmanagement_model->getSubjectOfferedPerSem($sem);
        foreach($subjects as $s):
            ?>
            <option value="<?php echo $s->s_id ?>"><?php echo $s->sub_code.' [ '.$s->s_desc_title.' ]' ?></option>
            <?php
        endforeach;
    }
    
    public function getStudentsPerSectionRaw($sec_id, $sem=NULL, $school_year = NULL)
    {
        $students = $this->subjectmanagement_model->getStudentsPerSectionRaw($sec_id, $sem, $school_year);
        return $students;
        
    }
    
    public function getStudentsPerSectionPrint($sec_id, $sem=NULL, $school_year = NULL)
    {
        $students = $this->subjectmanagement_model->getStudentsPerSectionPrint($sec_id, $sem, $school_year);
        
       // echo count($students);
        return $students;
        
    }

        public function getStudentsPerSection($sec_id, $sem=NULL, $school_year = NULL)
    {
        $school_year==NULL?$this->session->school_year:$school_year;
        $students = $this->subjectmanagement_model->getStudentsPerSection($sec_id, $sem, $school_year);
        return $students;
    }
    
    public function editSection()
    {
        $sec_id = $this->getInput('sec_id');
        $section = $this->getInput('value');
        $isRequested = $this->getInput('isRequested');
        $school_year = $this->getInput('school_year');
        $details = array('section' => $section, 'is_requested' => $isRequested);
        if($this->subjectmanagement_model->editSection($sec_id, $details, $school_year)):
            return TRUE;
        endif;
    }
    
    public function deleteSection($sec_id, $school_year)
    {
        $deleted = $this->subjectmanagement_model->deleteSection($sec_id, $school_year);
        if($deleted):
            $json = array('msg' => 'Successfully Deleted');
        else:
            $json = array('msg' => 'Sorry Something went wrong in Deleting this section');
            
        endif;
        
        echo json_encode($json);
    }
    
    public function getSectionPerSubjectDrop($sub_id)
    {
        $section = $this->subjectmanagement_model->getSectionPerSubject($sub_id);
        foreach ($section as $sec):
            if(!empty($section)):
            ?>
            <option value="<?php echo $sec->sec_id ?>"><?php echo $sec->section ?></option>
            <?php
            else:
                echo '<option>Sorry No Section is Open for this subject </option>';
            endif;
        endforeach;
    }
    
    public function getSectionPerSubject($sub_id, $school_year = NULL)
    {
        $data['section'] = $this->subjectmanagement_model->getSectionPerSubject($sub_id, $school_year);
        $this->load->view('college/subjectmanagement/sectionPerSubject', $data);
    }
            
    function assignSubject()
    {
        $teacher_id = $this->getInput('t_id');
        $sched_code = $this->getInput('sched_code');
        $section_id = $this->getInput('section_id');
        $spc_id     = $this->getInput('spc_id');
        $school_year = $this->getInput('school_year');
        
        $array = array(
               'section_id' => $section_id,
               'faculty_id' => $teacher_id
            );
        $result = $this->subjectmanagement_model->saveAssignedSubject($array, $sched_code, $section_id, $teacher_id, $school_year);
        
        if($sched_code!=""):
        
            if($result):
                echo json_encode(array('status' => TRUE));
            else:

                $facultyDetails = Modules::run('hr/getEmployeeName', $teacher_id);
                echo json_encode(array('status' => FALSE, 'msg' => 'Sorry, This schedule is already assign to another faculty ( '. strtoupper($facultyDetails->lastname.', '.$facultyDetails->firstname).' )') );
            endif;
        else:
             echo json_encode(array('status' => FALSE,'msg' => 'Schedule is not set for this subject, Please set schedule first before assigning it.'));
        endif;    
    }
    
    function getAssignedSubjectRaw($id, $semester = NULL, $school_year = NULL)
    {
        $subjects = $this->subjectmanagement_model->getAssignSubject($id, $semester, $school_year);
        return $subjects;
    }
    
    function getAssignedSubjectCollege($id = NULL, $semester=NULL, $school_year=NULL)
    {
        if($id==NULL):
            $id = $this->getInput('id');
            $semester = $this->getInput('semester');
            $school_year = $this->getInput('school_year');
        endif;
        
        $data['id'] = $id;
        $data['semester'] = $semester;
        $data['school_year'] = $school_year;
        $data['subjects'] = $this->subjectmanagement_model->getAssignSubject($id, $semester, $school_year);
        echo Modules::run('college/schedule/getSchedulePerTeacher', $id, $semester, $school_year);
    }
    
    function searchSubject($value=NULL, $sem = NULL, $school_year = NULL)
    {
        
        $data['school_year'] = $school_year;
        $data['sem'] = $sem;
        $data['subjects'] = $this->subjectmanagement_model->searchSubject(urldecode($value), $sem,$school_year);
        $this->load->view('subjectmanagement/searchSubjectTable', $data);
        
    }
    
    function loadAddDropSubject($value=NULL, $course_id=NULL, $sem = NULL, $school_year = NULL)
    {
        $data['school_year'] = $school_year;
        $data['sem'] = $sem;
        $data['subjects'] = $this->subjectmanagement_model->searchSubject(urldecode($value), $sem,$school_year);
        $this->load->view('subjectmanagement/loadAddDropSubject', $data);
        
    }
    
    function loadSubject($value=NULL, $course_id=NULL, $sem = NULL, $school_year = NULL)
    {
        $data['school_year'] = $school_year;
        $data['sem'] = $sem;
        $data['subjects'] = $this->subjectmanagement_model->searchSubject(urldecode($value), $sem, $school_year);
        $this->load->view('subjectmanagement/loadSubjectTable', $data);
        
    }
    
    function getSectionById($sec_id, $semester=NULL, $school_year = NULL)
    {
        $section = $this->subjectmanagement_model->getSectionById($sec_id,$semester,$school_year);
        return $section;
    }
    
    function getSectionDropDown($sub_id, $school_year = NULL, $sem = NULL)
    {
        $section = $this->subjectmanagement_model->getSectionDropDown($sub_id, $school_year, $sem);
        foreach($section->result() as $s):
            ?>
                <option value="<?php echo $s->sec_id  ?>"><?php echo $s->section ?></option>
            <?php
        endforeach;
    }
            
    function getSubjectsOffered($sub_id, $school_year = NULL)
    {
        $subjects = $this->subjectmanagement_model->getSubjectsOffered($sub_id, $school_year);
        return $subjects;
    }
    
    function generateRandNum() {
        $length = '3';
        $characters = '0123456789';
        $string = '';    

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        return $string;
    }
    
    function addSection()
    {
        $lastSecId = $this->subjectmanagement_model->lastSecId();
        $sy = $this->getInput('school_year');
        $course_id = $this->getInput('course_id');
        $subject_id = $this->getInput('sub_id');
        $semester = $this->getInput('semester');
        $sCode = $this->getInput('subCode');
        $isRequested = $this->getInput('isRequested');
        $sub_code = substr($sCode, 0, 3);
        $secCode = $this->generateRandNum();
        
        
        $details = array(
            'section'           => $sub_code.$secCode.'0'.$course_id,
            'course_id'         => $course_id,
            'sec_sem'           => $semester,
            'sec_school_year'   => $sy,
            'sec_sub_id'        => $subject_id,
            'is_requested'      => $isRequested,
            'sec_id'            => str_replace(" ", '', $sub_code.$secCode.'0'.$course_id)
        );
        
        $success = $this->subjectmanagement_model->addSection($details, $sy);
        if($success):
            echo json_encode(array('msg' => 'Successfully Added'));
        else:
            echo json_encode(array('msg' => 'Sorry Section Can\'t be added.'));
        endif;
    }
    
    function academicInformation($details, $semester, $school_year = NULL)
    {
        $data['details'] = $details;
        $data['sem'] = $semester;
        $data['term'] = Modules::run('college/gradingsystem/getTerm');
        $data['category'] = Modules::run('college/gradingsystem/getAssessCategory');
        $this->load->view('subjectmanagement/academicInformation', $data);
        
    }
    
    function ifSubjectExist($student_id, $subject_id)
    {
        $exist = $this->subjectmanagement_model->checkIfSubjectExist($student_id, $subject_id);
        if($exist):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    /*
    function printStudyLoad($st_id, $sem, $option=NULL)
    {
        $data['st_id'] = base64_decode($st_id);
        $data['sem']   = $sem;
        if($option==NULL):
            Modules::run('college/finance/setFinanceAccount', $data['st_id'],$sem);
        endif;
        $this->load->view('subjectmanagement/reports/printStudyLoad', $data);
    }*/

    function printStudyLoad($st_id, $sem, $year = NULL, $option=NULL)
    {
        $data['st_id'] = base64_decode($st_id);
        $data['sem']   = $sem;
        $data['school_year'] = ($year==NULL?$this->session->school_year:$year);
        $settings = $this->eskwela->getSet();
//        if($option==NULL):
//            Modules::run('college/finance/setFinanceAccount', $data['st_id'],$sem);
//        endif;

        if(file_exists(APPPATH.'modules/college/views/subjectmanagement/reports/'. strtolower($settings->short_name).'_printStudyLoad.php')):
            $this->load->view('subjectmanagement/reports/'.strtolower($settings->short_name).'_printStudyLoad', $data);
        else :
            $this->load->view('subjectmanagement/reports/printStudyLoad', $data);
        endif;
    }
    
    function approveLoad($adm_id, $user_id, $school_year = NULL)
    {
        $approved = $this->subjectmanagement_model->approveLoad($adm_id, $school_year, 3);
        if($approved):
            
            // Activity Log
            $profile = Modules::run('college/getBasicInfo', base64_decode($user_id), $this->session->school_year);

            $remarks = $this->session->userdata('name').' has approved the Study Load of '.$profile->lastname.', '.$profile->firstname.'.';
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
            
            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            $statusArray = array(
                'status'    => true,    
                'remarks'   => $remarks,    
                'username'    => $registrar->employee_id,
                'msg'       => "Study Load Approved Successfully"
            );
            echo json_encode($statusArray);
        else:
            echo json_encode(array('msg' => 'Sorry, Something is wrong'));
        endif;
    }
    
    function approveLoadOnline($adm_id, $user_id, $school_year = NULL, $semester = NULL)
    {
        $approved = $this->subjectmanagement_model->approveLoad($adm_id, $school_year, 1);
        if($approved):
            
            // Activity Log
            $profile = Modules::run('college/getBasicInfo', base64_decode($user_id), ($school_year==NULL?$this->session->school_year:$school_year));

            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            
            $remarks = $this->session->userdata('name') . ' has approved the Study Load of ' . $profile->lastname . ', ' . $profile->firstname . ' who submit his/her application online.';
            $message = "Congratulations, Your application for enrollment is successfully approved by your Dean. You are now Officially Enrolled";
            $result = json_decode(Modules::run('college/enrollment/sendConfirmation', $profile->cd_mobile, $message));
            $try = 0;
            
            while($result->status!=1):
                $try++;
                Modules::run('college/enrollment/sendConfirmation', $profile->cd_mobile, $message);
                if($try==10):
                    $this->subjectmanagement_model->approveLoad($adm_id, $school_year, 0);
                    $statusArray = array(
                        'status'    => true,    
                        'remarks'   => $remarks,    
                        'username'  => $registrar->employee_id,
                        'msg'       => "Sorry, System failed to Approve the request, please try again later"
                    );
                    break;
                    
                endif;
            endwhile;
            
            if($result->status):
                Modules::run('college/enrollment/updateEnrollmentStatus', $profile->st_id, 1,$semester, $school_year);
                Modules::run('notification_system/systemNotification', 3, $remarks);
                Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
                $statusArray = array(
                    'status'    => true,    
                    'remarks'   => $remarks,    
                    'username'  => $registrar->employee_id,
                    'msg'       => "Successfully Approved"
                );
            endif;
            
            echo json_encode($statusArray);
        else:
            echo json_encode(array('msg' => 'Sorry, Something is wrong'));
        endif;
    }
            
    function getLoadedSubject($adm_id, $sem = NULL, $year = NULL)
    {
        $subjects = $this->subjectmanagement_model->getLoadedSubject($adm_id, $sem, $year);
        return $subjects;
    }
    
    function getLoadedSubjectTemplate($admission_id, $sem, $school_year)
    {
        $data['semester'] = $sem;
        $data['school_year'] = $school_year;
        $data['admission_id'] = $admission_id;
        $this->load->view('subjectmanagement/studyLoad', $data);
    }
    
    function removeLoadedSubject()
    {
        $subject_id     = $this->getInput('subject_id');
        $adm_id         = $this->getInput('admission_id');
        $isDropped      = $this->getInput('isDropped');
        $user_id        = $this->getInput('student_id');
        $school_year    = $this->getInput('school_year');
        
        $this->subjectmanagement_model->removeLoadedSubject($subject_id, $adm_id, $school_year);
        if($isDropped=='1'):
            $subject = $this->getSubjectPerId($subject_id);
            $student = $this->subjectmanagement_model->getBasicInfo($user_id);
            $name = strtoupper($student->lastname.', '.$student->firstname);
            Modules::run('main/logActivity','REGISTRAR', $name.' drop the subject '.$subject->sub_code.' [ '.$subject->s_desc_title.' ]', $this->session->userdata('user_id'));
        else:
            
        // Activity Log
        $profile = Modules::run('college/getBasicInfo', $user_id, $this->session->school_year);
        $subject = $this->getSubjectPerId($subject_id);
        
        $remarks = $this->session->userdata('name').' remove the subject '.$subject->sub_code.' [ '.$subject->s_desc_title.' ] from '.$profile->lastname.', '.$profile->firstname.'.';
        Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
        endif;
        return;
    }
    
    function saveLoadedSubject()
    {
        $subject_id = $this->getInput('subject_id');
        $st_id      = $this->getInput('student_id');
        $adm_id     = $this->getInput('admission_id');
        $section_id = $this->getInput('section_id');
        $school_year = $this->getInput('school_year');
        $overide =  $this->getInput('overide');
        $remarks = "";
        $overide_by = ($overide==0?"":$this->session->userdata('employee_id'));
        
        $load = array(
            'cl_adm_id'     => $adm_id,
            'cl_user_id'    => $st_id,
            'cl_sub_id'     => $subject_id,
            'cl_section'    => $section_id,
            'cl_overide'    => $overide,
            'cl_remarks'    => $remarks,
            'overide_by'    => $overide_by  
        );
        
        $this->subjectmanagement_model->saveLoadedSubject($subject_id, $adm_id, $load, $school_year);
        
        // Activity Log
        $profile = Modules::run('college/getBasicInfo', $st_id, $school_year);
        $subject = $this->getSubjectPerId($subject_id);
        
        $remarks = $this->session->userdata('name').' has loaded this student named '.$profile->lastname.', '.$profile->firstname.' with the subject '.$subject->sub_code.' [ '.$subject->s_desc_title.' ].';
        Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
        
        if($overide):
            $remarks = $this->session->userdata('name').' has overide the pre-requisite issue of the subject '.$subject->sub_code.' [ '.$subject->s_desc_title.' ] to '.$profile->lastname.', '.$profile->firstname.'.';
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $this->session->userdata('user_id'));
        endif;
        
        echo Modules::run('college/subjectmanagement/getLoadedSubjectTemplate', $adm_id, NULL, $school_year);
    }
    
    function prerequisteCheck()
    {
        $student_id = $this->getInput('student_id');
        $pre_req = $this->getInput('pre_req');
        $school_year = $this->getInput('school_year');
        
        if($pre_req!='None'):
            
            $pre_req_items = explode(',', $pre_req);
        
            foreach($pre_req_items as $prq):
                $isTaken = $this->subjectmanagement_model->prerequisteCheck($student_id, $prq , $school_year);
                if($isTaken):
                    continue;
                else:
                    echo json_encode(array('status' => FALSE));
                    exit();
                endif;
            endforeach;
            echo json_encode(array('status' => TRUE));
        else:
            echo json_encode(array('status' => TRUE));
        endif;
    }
            
    function addDrop($student_info, $course_id, $year_level, $sem_id=NULL, $school_year=NULL)
    {
        $data['student'] = $student_info;
        $data['course_id'] = $course_id;
        $data['sem'] = $sem_id;
        $data['subjects'] = $this->subjectmanagement_model->getAddSubjectDrop($student_info->u_id, $sem_id, $school_year);
        $this->load->view('subjectmanagement/add_drop', $data);
        
    }
            
    function addSubjectLoad($student_info, $course_id, $year_level, $sem_id=NULL, $school_year=NULL)
    {
        $data['school_year'] = $school_year;
        $data['student'] = $student_info;
        $data['course_id'] = $course_id;
        $data['sem'] = $sem_id;
        $data['subjects'] = $this->subjectmanagement_model->getSubjectPerCourse($course_id, $year_level, $sem_id, $school_year);
        $this->load->view('subjectmanagement/subjectLoad', $data);
        
    }
            
    function editSubject()
    {
        $sub_id = $this->getInput('sub_id');
        $subject = $this->getInput('subject');
        
        $data = array(
          'subject' => $subject  
        );
        
        $result = $this->subjectmanagement_model->editsubject($sub_id, $data);
        if($result):
            return TRUE;
        endif;
    }
    
    function listOfSubjects()
    {
        $result = $this->subjectmanagement_model->collegeSubjects();
        $config['base_url'] = base_url('college/subjectmanagement/listOfSubjects/');
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 100;
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
        $page = $this->subjectmanagement_model->collegeSubjects($config['per_page'], $this->uri->segment(4));
        $data['collegeSubjects'] = $page;
        
        $data['courses'] = Modules::run('coursemanagement/getCourses');
        $data['main_content'] = 'subjectmanagement/listOfSubjects';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    
    function getAllSubjects()
    {
        $subject = $this->subjectmanagement_model->getSubjects();
        return $subject;
    }
    
    function getCollegeSubjects($sem = NULL, $school_year = NULL)
    {
        $subject = $this->subjectmanagement_model->getCollegeSubjects($sem, $school_year);
        return $subject;
    }
    
    function editCollegeSubject()
    {
        $sCode = $this->getInput('editSubjectCode');
        $sDesc = $this->getInput('editDesc');
        $lecU = $this->getInput('editLectureUnits');
        $labU = $this->getInput('editLabUnits');
        $inputPreR = $this->getInput('editPreR');
        $s_id = $this->getInput('editSubId');
        $labFee = $this->getInput('labFee');
        $school_year = $this->getInput('school_year');
        
        
        $subjects = array(
            's_desc_title'  => $sDesc,
            'sub_code'      => $sCode,
            's_lect_unit'   => $lecU,
            's_lab_unit'    => $labU,
            'pre_req'       => ($inputPreR!=""?$inputPreR:"None"),
            'sub_lab_fee_id'=> $labFee
        );
        
        //print_r($subjects);
        
        if($this->subjectmanagement_model->editCollegeSubject($subjects, $sDesc, $sCode, $s_id, $school_year)):
            echo 'Succesfully Updated';
        else:
            echo 'Sorry Subject Already Exist';
        endif;
        
        
    }
    
    function addCollegeSubject()
    {
        $sCode = $this->getInput('inputSubjectCode');
        $sDesc = $this->getInput('inputDesc');
        $lecU = $this->getInput('inputLectureUnits');
        $labU = $this->getInput('inputLabUnits');
        $inputPreR = $this->getInput('inputPreR');
        $school_year = $this->getInput('school_year');
        
        
        $subjects = array(
            's_id'          => $this->eskwela->code(),
            's_desc_title'  => $sDesc,
            'sub_code'      => $sCode,
            's_lect_unit'   => $lecU,
            's_lab_unit'    => $labU,
            'pre_req'       => ($inputPreR!=""?$inputPreR:"None")
        );
        
        //print_r($subjects);
        if($this->subjectmanagement_model->addCollegeSubject($subjects, $sDesc, $sCode, $school_year)):
            echo 'Successfully Added';
        else:
            echo 'Sorry Subject Already Exist';
        endif;
        
        
    }
            
    function getSubjectsPerCourse($course_id=NULL)
    {
        $data['collegeSubjects'] = $this->subjectmanagement_model->getSubjectsPerCourse($course_id);
        $this->load->view('subjectmanagement/subjectsPerCourse', $data);
    }
    
    function index()
    {
        $result = $this->subjectmanagement_model->collegeSubjects();
        $config['base_url'] = base_url('college/subjectmanagement/index/');
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 15;
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
        $page = $this->subjectmanagement_model->collegeSubjects($config['per_page'], $this->uri->segment(4));
        $data['collegeSubjects'] = $page;
        
        $data['allSubjects'] = $result;
        $data['school_settings'] = Modules::run('main/getSet');
        $data['subject'] = Modules::run('academic/getSubjects');
        $data['courses'] = Modules::run('coursemanagement/getCourses');
        $data['main_content'] = 'subjectmanagement/default';
        $data['modules'] = 'college';
        echo Modules::run('templates/college_content', $data);
    }
    
    function searchSubjectResult($value, $school_year = NULL)
    {
        $value= $this->getInput('value');
        $data['school_year'] = $school_year;
        $data['collegeSubjects'] = $this->subjectmanagement_model->searchSubjectResult($value, $school_year);
        $this->load->view('subjectmanagement/searchResults', $data);
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
    
    
    
}

