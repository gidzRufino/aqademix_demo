<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Enrollment
 * This is use for online enrollment
 *
 * @author genesis
 */
class Enrollment extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('enrollment_model');
        $this->load->library('pdf');
    }

    private function post($name) {
        return $this->input->post($name);
    }

    public function saveReligion(){
        $response = $this->enrollment_model->addReligion($this->eskwela->code(), $this->post('religionName'));
        if($response['success'] == 1)
        {
            echo json_encode(array("type"=>1,"message"=>$response['message'], 'details' => $response['details']));
        }
        else if($response['success'] == 1000)
        {
            echo json_encode((array("type"=>1000,"message"=>$response['message'])));
        }
        else
        {
            echo json_encode(array("type"=>2,"message"=>$response['message'],'error'=>$response['error']));
        }
    }

    public function deletePadala()
    {
        $response = $this->enrollment_model->deletePadala($this->post('id'));
        if($response == TRUE)
        {
            echo json_encode(array('type' => 1, 'message' => 'Successfully Deleted'));
        }
        else
        {
            echo json_encode(array('type' => 2, 'message' => 'Something went wrong. Please try again or contact an administrator'));
        }
    }

    public function editPadala()
    {
        $data = array
        (
            'pc_name'           =>  $this->post('pcName'),
            'pc_short_name'     =>  $this->post('pcShortName'),
            'pc_type'           =>  $this->post('pcType'),
            'pc_account_name'   =>  $this->post('pcAccountName'),
            'pc_account_number' =>  $this->post('pcAccountNumber'),
            'pc_branch'         =>  $this->post('pcBranch'),
            'pc_contact_no'     =>  $this->post('pcContact'),
            'pc_status'         =>  $this->post('pcStatus')
        );
        $response = $this->enrollment_model->updatePadala($this->post('pcID'), $data);
        if($response == TRUE)
        {
            echo json_encode(array('type' => 1, 'message' => 'Successfully Updated'));
        }
        else
        {
            echo json_encode(array('type' => 2, 'message' => 'Something went wrong. Please try again or contact an administrator'));
        }
    }

    public function addPadala()
    {
        $data = array
        (
            'pc_name'           =>  $this->post('pcName'),
            'pc_short_name'     =>  $this->post('pcShortName'),
            'pc_type'           =>  $this->post('pcType'),
            'pc_account_name'   =>  $this->post('pcAccountName'),
            'pc_account_number' =>  $this->post('pcAccountNumber'),
            'pc_branch'         =>  $this->post('pcBranch'),
            'pc_contact_no'     =>  $this->post('pcContact')
        );
        $response = $this->enrollment_model->addPadala($data);
        if($response == 0)
        {
            echo json_encode(array('type' => 1, 'message' => 'Successfully Added'));
        }
        else if($response == 1)
        {
            echo json_encode(array('type' => 2, 'message' => 'Bank Branch already exists'));
        }
    }

    public function getPadala($__S = NULL)
    {
        return $this->enrollment_model->fetchPadala($__S)->result();
    }
    
//    function movefiles($school_year, $semester, $isBasic = NULL)
//    {
//        $directory = 'uploads/online_payments_'.$school_year;
//        
//        if($isBasic==NULL):
//            $enrollmentList = $this->enrollment_model->getEnrollmentList($semester, $school_year);
//        else:
//            $enrollmentList = $this->getSummaryOfBasicEdStudents($semester, $school_year);
//        endif;
//        
//        foreach($enrollmentList->result() as $eL):
//        
//            $filename = $eL->st_id;
//            $newDirectory = 'uploads/'.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR.$eL->st_id.DIRECTORY_SEPARATOR.'online_payments';
//            $scanFiles = scandir($directory);
//            foreach ($scanFiles as $file):
//                
//                if (strstr($file, $filename)):
//                    
//                        //echo $file.' | '.$filename.'<br />';
//                    if(!is_dir($newDirectory)):
//                        mkdir($newDirectory.'/', 0777, true);
//                    endif;
//                    if(copy($directory.DIRECTORY_SEPARATOR.$file, $newDirectory.DIRECTORY_SEPARATOR.$file)):
//                        echo $file.' | '.$filename.'<br />';
//                        //unlink($directory.DIRECTORY_SEPARATOR.$file);
//                    endif;
//                    
//                endif;
//            endforeach;
//        
//        endforeach;
//        
//
//        
//    }
    function deleteEnrollmentFile()
    {
        $file = $this->post('link');
        if(unlink($file)):
             $remarks = $this->session->name.' has deleted an enrolment requirement file with the filename '.$file.'. ';
             Modules::run('main/logActivity','REGISTRAR',  $remarks, $generatedCode);
             Modules::run('notification_system/systemNotification', 3, $remarks);
             
            echo 'Successfully Deleted';
        else:
            echo 'Sorry Something went wrong';
        endif;
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
    
    function getSummaryOfBasicEdStudents($semester, $school_year)
    {
        $students = $this->enrollment_model->getSummaryOfBasicEdStudents($semester, $school_year);
        return $students;
    }
    
    function getSummaryOfStudents($course_id, $semester, $school_year)
    {
        $students = $this->enrollment_model->getSummaryOfStudents($course_id, $semester, $school_year);
        return $students;
    }
    
    function getEnrollmentList($semester, $school_year)
    {
        $data['details'] = $this->enrollment_model->getEnrollmentList($semester, $school_year, TRUE);
        
        $this->load->view('online/listOfEnrollees', $data);
    }
    
    function sendSMS($mobileNo)
    {
        $msg = $this->post('msg');
        $result = json_decode(Modules::run('college/enrollment/sendConfirmation', base64_decode($mobileNo), $msg));
            $try = 0;
            $resultStatus = $result->status;
            
            while($resultStatus!=1):
                $try++;
                $result = json_decode(Modules::run('college/enrollment/sendConfirmation', base64_decode($mobileNo), $msg));
                if($try==10):
                        echo 'Sorry Something went wrong, Please try again later';
                    break;
                    
                endif;
                $resultStatus = $result->status;
            endwhile;
            
            if($resultStatus):
                echo 'SMS Successfully sent';
            endif;
        
        
    }
    
    function sendPaymentReminder($mobileNo)
    {
        $msg = "Please be inform that your application for enrollment has been approved. Please proceed to the next step of the enrollment procedure to avoid cancellation of your enrolled subjects";
        
        $result = json_decode(Modules::run('college/enrollment/sendConfirmation', base64_decode($mobileNo), $msg));
            $try = 0;
            $resultStatus = $result->status;
            
            while($resultStatus!=1):
                $try++;
                $result = json_decode(Modules::run('college/enrollment/sendConfirmation', base64_decode($mobileNo), $msg));
                if($try==10):
                        echo 'Sorry Something went wrong, Please try again later';
                    break;
                    
                endif;
                $resultStatus = $result->status;
            endwhile;
            
            if($resultStatus):
                echo 'Reminder Successfully sent';
            endif;
        
        
    }
    
    function approveBasicEdOnline($adm_id, $user_id, $school_year = NULL, $semester = NULL)
    {
        $approved = $this->enrollment_model->approveBasicEdOnline($adm_id, $school_year, 3);
        if($approved):
            
            // Activity Log
            $profile = $this->enrollment_model->getBasicEdStudentByUserId(base64_decode($user_id), ($school_year==NULL?$this->session->school_year:$school_year), $semester);

            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            
            
            $remarks = $this->session->userdata('name').' has approved the Enrollment of '.$profile->lastname.', '.$profile->firstname.' a Basic Education Student.';
            $message = "Your application for enrollment is successfully approved by the Enrollment Officer. Login now to complete the enrollment";
            $result = json_decode(Modules::run('college/enrollment/sendConfirmation', $profile->ice_contact, $message));
            $try = 0;
            $resultStatus = $result->status;
            
            while($resultStatus!=1):
                $try++;
                $result = json_decode(Modules::run('college/enrollment/sendConfirmation', $profile->ice_contact, $message));
                if($try==10):
                    $statusArray = array(
                        'status'    => true,    
                        'remarks'   => $remarks,    
                        'username'  => $registrar->employee_id,
                        'msg'       => "Sorry, System failed to Approve the request, please try again later"
                    );
                    break;
                    
                endif;
                
                $resultStatus = $result->status;
            endwhile;
            
            if($result->status):
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
    
    public function traceEnrollees($semester, $school_year, $status = NULL)
    {
        
        $traceDetails = array(
            'semester'      => $semester,
            'school_year'   => $school_year,
            'enrollees'     => $this->enrollment_model->traceEnrollees($school_year, $semester, $status),
            'main_content' => 'online/enrollmentTracing',
            'modules'      => 'college'
        );
        
        echo Modules::run('templates/online_content', $traceDetails);
    }
    
    public function getAdmissionRemarks($st_id, $semester, $school_year)
    {
        $remarks = $this->enrollment_model->getAdmissionRemarks($st_id, $semester, $school_year);
        return $remarks;
    }
    
    public function sendAdmissionRemarks($isBasicEd = NULL)
    {
        $st_id = base64_decode($this->post('st_id'));
        $remarks = $this->post('remarks');
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        
        $remarkDetails = array(
            'remarks'       => $remarks,
            'rem_to'        => $st_id,
            'rem_by'        => $this->session->employee_id,
            'rem_semester'  => $semester
        );
        
        if($this->enrollment_model->sendAdmissionRemarks($remarkDetails, $st_id, $semester, $school_year)):
            echo "Successfully Sent";
        else:
            echo "Something went wrong, Please try again later";
        endif;
    }
    
    function listOfStudentsEnrolled($semester, $school_year, $status)
    {
        if($semester!=0):
            $data['students'] = $this->enrollment_model->getStudPerStatus($status,$semester,$school_year);
        else:
            $data['students'] = [];
        endif;
        $data['semester'] = $semester;
        $data['basicStudents'] = $this->enrollment_model->getBasicStudPerStatus($status,$semester,$school_year);
        $this->load->view('online/studentList',$data);
    }
    
    function getNumStudentsPerStatus($semester=NULL, $school_year=NULL, $status = NULL)
    {
        $students = $this->enrollment_model->getStudPerStatus($status,$semester,$school_year);
        $basicStudents = $this->enrollment_model->getBasicStudPerStatus($status,$semester,$school_year);
        $totalStudents = 0;
        foreach($students->result() as $s):
            if($this->hasLoadedSubject($s->admission_id, $school_year)):
                $totalStudents++;
            endif;
        endforeach;
        foreach($basicStudents->result() as $s):
                $totalStudents++;
        endforeach;
        
        return $totalStudents;
    }
    
    public function generateID($school_year)
    {
        $generatedID  = $this->enrollment_model->getLatestBasicEdNum($school_year);
        
        if($generatedID):
                $idNumber = abs(substr($generatedID->esk_profile_temp_id_code,-4));
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
    
    public function saveBasicEdAdmission()
    {
        
        $school_year    = $this->input->post('inputCSY');
        $semester       = $this->input->post('inputSemester');
        
        $userExist = $this->enrollment_model->checkName($this->input->post('inputCLastName'),$this->input->post('inputCFirstName'),$this->input->post('inputCMiddleName'), $school_year);
        
        if(!$userExist){
            $idNumber  = $this->generateID($school_year);
            
            $st_id = $school_year.$semester.'1'.$idNumber;

            $generatedCode = $this->eskwela->code();
            $this->enrollment_model->saveTempID($st_id, $generatedCode,$school_year);

            $barangay_id = $this->enrollment_model->setBarangay($this->input->post('inputBarangay'), $generatedCode, $school_year);

            $add = array(
                'street'                        => $this->input->post('inputStreet'),
                'barangay_id'                   => $barangay_id,
                'city_id'                       => $this->input->post('inputMunCity'),
                'province_id'                   => $this->input->post('inputPID'),
                'country'                       => 'Philippines',
                'zip_code'                      => $this->input->post('inputPostal'),
                'address_id'                    => $generatedCode
            );

            $this->enrollment_model->setAddress($add, $school_year);

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

            $this->enrollment_model->saveProfile($items, $school_year);

            //saves the basic contact
            $this->enrollment_model->setContacts($this->input->post('inputPhone'), $this->input->post('inputEmail'), $generatedCode, $school_year);

            $enDate = $this->input->post('inputCEdate');

            //saves the basic info

            $idExist = $this->enrollment_model->checkIdIfExist($st_id);
            if($idExist):
                $st_id = $st_id+1;
            endif;
            
            $section = $this->enrollment_model->getSectionByLevel($this->input->post('getLevel'), $school_year);

            $this->enrollment_model->setBasicEdInfo($st_id, $generatedCode, $this->input->post('getLevel'), ($section->row()?$section->row()->s_id:0), $this->input->post('strand'), $enDate, $school_year,  $this->input->post('inputSemester'), ($this->input->post('inputSLA')==""?"(No Entry)":$this->input->post('inputSLA')), ($this->input->post('inputAddressSLA')==""?"":$this->input->post('inputAddressSLA')));
            

            $f_occupation_id = $this->enrollment_model->saveOccupation($this->input->post('inputF_occ'), $school_year);
            $m_occupation_id = $this->enrollment_model->saveOccupation($this->input->post('inputM_occ'), $school_year);

                $parentDetails = array(
                    'p_id'              => $this->eskwela->code(),
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

                $this->enrollment_model->saveParentDetails($parentDetails, $school_year);

                 //Medical information
    //            $this->enrollment_model->saveMed(
    //                $this->input->post('inputBType'), 
    //                $this->input->post('inputAllergies'), 
    //                $this->input->post('inputOtherMedInfo'), 
    //                $this->input->post('inputFPhy'), 
    //                $this->input->post('height'), 
    //                $this->input->post('weight'), 
    //                $generatedCode, $school_year );
           
            $gradeName = $this->enrollment_model->getGradeLevelById($this->input->post('getLevel'), $school_year);


            $remarks = 'A new '.$gradeName->level.' student name '.strtoupper($this->input->post('inputCFirstName').' '.$this->input->post('inputCMiddleName').". ".$this->input->post('inputCLastName')).' has enrolled online for the school year '.$school_year.' - '.($school_year+1).'.';
            $name = $this->input->post('inputCFirstName');
            Modules::run('notification_system/systemNotification', 5, $remarks);
            
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $generatedCode);

            $msg = 'Your Information is successfully submitted. We will notify you in the next 24-48 hours once your application is approved. You can use this ID #: '.$st_id.' for '.strtoupper($name).' to access the system';

            $result = json_decode($this->sendConfirmation($this->post('inputInCaseContact'), $msg));
            $resultStatus = $result->status;
            $try = 0;
            while($resultStatus!=1):
                $try++;
                $result = json_decode($this->sendConfirmation($this->post('inputInCaseContact'), $msg));
                if($try==10):
                   
                    break;
                    exit();
                endif;
                $resultStatus = $result->status;
            endwhile;
            
            if($resultStatus==1):
                echo 'Information Successfully Submitted';
            else:
                echo $msg;
            endif;
            
        }else{
            echo 'Sorry failed to submit application, Name already Exist. Please contact the registrar for more information';
        }
            
        
    }

    public function saveAdmission()
    {
        
        $school_year    = $this->input->post('inputCSY');
        $semester       = $this->input->post('inputSemester');
        
        $userExist = $this->enrollment_model->checkName($this->input->post('inputCLastName'),$this->input->post('inputCFirstName'),$this->input->post('inputCMiddleName'), $school_year);
        
        if(!$userExist){
            $idNumber  = $this->generateID($school_year);
            
            $st_id = $school_year.$semester.'2'.$idNumber;

            $generatedCode = $this->eskwela->generateRandNum();
            $this->enrollment_model->saveTempID($st_id, $generatedCode,$school_year);

            $this->enrollment_model->setBarangay($this->input->post('inputBarangay'), $generatedCode, $school_year);

            $add = array(
                'street'                        => $this->input->post('inputStreet'),
                'barangay_id'                   => $generatedCode,
                'city_id'                       => $this->input->post('inputMunCity'),
                'province_id'                   => $this->input->post('inputPID'),
                'country'                       => 'Philippines',
                'zip_code'                      => $this->input->post('inputPostal'),
                'address_id'                    => $generatedCode
            );

            $this->enrollment_model->setAddress($add, $school_year);

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

            $this->enrollment_model->saveProfile($items, $school_year);

            //saves the basic contact
            $this->enrollment_model->setContacts($this->input->post('inputPhone'), $this->input->post('inputEmail'), $generatedCode, $school_year);

            $enDate = $this->input->post('inputCEdate');

            //saves the basic info

            $idExist = $this->enrollment_model->checkIdIfExist($st_id);
            if($idExist):
                $st_id = $st_id+1;
            endif;

            $this->enrollment_model->setCollegeInfo($st_id, $generatedCode, $this->input->post('getCourse'),  $this->input->post('inputYear'), $enDate, $school_year, $this->input->post('inputSemester'), ($this->input->post('inputSLA')==""?"(No Entry)":$this->input->post('inputSLA')), ($this->input->post('inputAddressSLA')==""?"":$this->input->post('inputAddressSLA')));


            $f_occupation_id = $this->enrollment_model->saveOccupation($this->input->post('inputF_occ'), $school_year);
            $m_occupation_id = $this->enrollment_model->saveOccupation($this->input->post('inputM_occ'), $school_year);

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

                $this->enrollment_model->saveParentDetails($parentDetails, $school_year);

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

            $remarks = 'A new student name '.strtoupper($this->input->post('inputCFirstName').' '.$this->input->post('inputCMiddleName').". ".$this->input->post('inputCLastName')).' has enrolled online for the '.$semName.' of school year '.$school_year.' - '.($school_year+1).'.';
            Modules::run('notification_system/systemNotification', 5, $remarks);
            
            Modules::run('main/logActivity','REGISTRAR',  $remarks, $generatedCode);



            $msg = 'Your Information is successfully submitted. You can use this ID #: '.$st_id.' to access the system';

            $result = json_decode($this->sendConfirmation($this->post('inputPhone'), $msg));
            $resultStatus = $result->status;
            $try = 0;
            while($resultStatus!=1):
                $try++;
                $result = json_decode($this->sendConfirmation($this->post('inputPhone'), $msg));
                if($try==10):
                   // $this->enrollment_model->approveLoad(base64_decode($st_id), $school_year, 0);
//                    $statusArray = array(
//                        'status'    => true,    
//                        'msgs'      => $msg
//                    );
                    break;
                    exit();
                endif;
                $resultStatus = $result->status;
            endwhile;
            
            if($resultStatus==1):
                echo 'Information Successfully Submitted';
            else:
                echo $msg;
            endif;
            
        }else{
            echo 'Sorry failed to submit application, Name already Exist. Please contact the registrar for more information';
        }
            
        
    }


    public function basicEdAdmission($dept=NULL)
    {
        $data = array(
            'educ_attain'   => $this->enrollment_model->getEducAttain(),
            'provinces'     => Modules::run('main/getProvinces'),
            'cities'        => Modules::run('main/getCities'),
            'religion'      => Modules::run('main/getReligion'),
            'course'        => Modules::run('coursemanagement/getCourses'),
            'modules'       => 'college',
            'main_content'  => 'online/basicEdAdmission',
            'dept'          => $dept,
            'settings'      =>  Modules::run('main/getSet')
        );
        
        echo Modules::run('templates/online_content', $data);
    }

    public function collegeAdmission()
    {
        $data = array(
            'educ_attain'   => $this->enrollment_model->getEducAttain(),
            'provinces'     => Modules::run('main/getProvinces'),
            'cities'        => Modules::run('main/getCities'),
            'religion'      => Modules::run('main/getReligion'),
            'course'        => Modules::run('coursemanagement/getCourses'),
            'modules'       => 'college',
            'main_content'  => 'online/collegeAdmissionForm',
            'settings'      =>  Modules::run('main/getSet')
        );
        
        echo Modules::run('templates/online_content', $data);
    }
    
    public function confirmPayment($basicEd=NULL)
    {
        $st_id = $this->post('st_id');
        $user_id = $this->post('user_id');
        $semester = $this->post('semester');
        $school_year = $this->post('school_year');
        
        if($basicEd==NULL):
            $profile = Modules::run('college/getBasicInfo', base64_decode($user_id), $school_year);
        else:
            $profile = $this->enrollment_model->getBasicEdStudentByUserId(base64_decode($user_id), $school_year, $semester);
        endif;
        
        if($this->enrollment_model->confirmPayment(base64_decode($st_id), $semester, $school_year)):
            $message = "Congratulations your payment has been confirmed, you are now officially enrolled.";
            $result = json_decode(Modules::run('college/enrollment/sendConfirmation', ($basicEd==NULL?$profile->cd_mobile:$profile->ice_contact), $message));
            $try = 0;
            
            while($result->status!=1):
                $try++;
                Modules::run('college/enrollment/sendConfirmation',($basicEd==NULL?$profile->cd_mobile:$profile->ice_contact), $message);
                if($try==10):
                    $this->enrollment_model->approveLoad(base64_decode($st_id), $school_year, 0);
                    $statusArray = array(
                        'status'    => true,    
                        'msg'       => "Sorry something went wrong, please try again later"
                    );
                    break;
                    
                endif;
            endwhile;
            
            if($result->status):
                $this->updateEnrollmentStatus(base64_decode($st_id), 1, $semester, $school_year, ($basicEd==NULL?NULL:1));
                $statusArray = array(
                    'status'    => true,    
                    'msg'       => "Payment Successfully Confirmed!"
                );
                
                
                $remarks = $this->session->userdata('name').' has confirmed the payment receipt of '.$profile->firstname.' '.$profile->lastname;
                Modules::run('notification_system/systemNotification', 5, $remarks);
                
                $remark2 = $profile->firstname.' '.$profile->lastname.' is now officially enrolled.';
                Modules::run('notification_system/systemNotification', 3, $remark2);
            
            endif;
            
        else:
            $statusArray(array('status' => FALSE,'Sorry something went wrong'));
        endif;
        
        echo json_encode($statusArray);
    }
    
    public function getUploadedReceipt($st_id, $semester, $school_year, $trans_id = NULL)
    {
        $receipt = $this->enrollment_model->getUploadedReceipt($st_id, $semester, $school_year, $trans_id);
        return $receipt;
    }
    
    public function uploadAnotherPaymentReceipt()
    {       
            
            $school_year = $this->post('school_year');
            $semester = $this->post('semester');
            $st_id = $this->post('st_id');
            $file = $this->post('userfile');
            $data['error'] = ''; //initialize image upload error array to empty

            $config['upload_path'] = 'uploads/'.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR. base64_decode($st_id).DIRECTORY_SEPARATOR.'online_payments';
            if(!is_dir($config['upload_path'].'/')):
                mkdir($config['upload_path'],0777,TRUE);
            endif;
            $config['overwrite'] = FALSE;
            $config['allowed_types'] = '*';
            $config['max_size'] = '3072';
            $config['maintain_ratio'] = TRUE;  
            $config['quality'] = '50%';  
            $config['width'] = 200;  
            $this->load->library('upload', $config);

             // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                //print_r($data);
               echo $config['upload_path'].'/';
                //$this->load->view('csvindex', $data);
            } else {
                $file_data = $this->upload->data();
                $ext = $file_data['file_ext'];
                $link = $config['upload_path'].'/'.$file;
                if($this->enrollment_model->savePaymentReceipt(base64_decode($st_id),$link, $school_year, $semester)):
                    echo 'Thank you for uploading. We will just notify you once your payment is confirm.';
                    if($this->session->department==4):
                        $student = $this->enrollment_model->getStudentDetails(base64_decode($st_id), $semester, $school_year);
                    else:
                        $student = $this->enrollment_model->getStudentDetailsBasicEd(base64_decode($st_id), $semester, $school_year);
                    endif;
                    
                    $remarks = $student->firstname.' '.$student->lastname.' has uploaded a payment receipt to the system';
                    Modules::run('notification_system/systemNotification', 5, $remarks);
                endif;
            }
        
    }
    
    public function uploadPaymentReceipt()
    {       
            
            $school_year = $this->post('school_year');
            $semester = $this->post('semester');
            $st_id = $this->post('st_id');
            $department = $this->post('department');
            $file = $this->post('userfile');
            $data['error'] = ''; //initialize image upload error array to empty

            $config['upload_path'] = UPLOADPATH.$school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR. base64_decode($st_id).DIRECTORY_SEPARATOR.'online_payments';
            if(!is_dir($config['upload_path'].'/')):
                mkdir($config['upload_path'],0777,TRUE);
            endif;
            
            $config['overwrite'] = FALSE;
            $config['allowed_types'] = '*';
            $config['max_size'] = '3072';
            $config['maintain_ratio'] = TRUE;  
            $config['quality'] = '50%';  
            $config['width'] = 200;  
            $this->load->library('upload', $config);

             // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                print_r($data);
                echo $config['upload_path'].'/';
                //$this->load->view('csvindex', $data);
            } else {
                $file_data = $this->upload->data();
                $ext = $file_data['file_ext'];
                $link = $config['upload_path'].'/'.$file;
                if($this->enrollment_model->savePaymentReceipt(base64_decode($st_id),$link, $school_year, $semester)):
                    echo 'Thank you for uploading. We will just notify you once your payment is confirm.';
                    if($this->session->department==4):
                        $student = $this->enrollment_model->getStudentDetails(base64_decode($st_id), $semester, $school_year);
                        Modules::run('college/enrollment/updateEnrollmentStatus', base64_decode($st_id), 5, $semester, $school_year);
                    else:
                        $student = $this->enrollment_model->getStudentDetailsBasicEd(base64_decode($st_id), $semester, $school_year);
                        Modules::run('college/enrollment/updateEnrollmentStatus', base64_decode($st_id), 5, $semester, $school_year,1);
                        
                    endif;
                    
                    $remarks = $student->firstname.' '.$student->lastname.' has uploaded a payment receipt to the system';
                    Modules::run('notification_system/systemNotification', 5, $remarks);
                endif;
            }
        
    }
    
    public function getFinanceRemarks($st_id, $semester, $school_year)
    {
        $remarks = $this->enrollment_model->getFinanceRemarks($st_id, $semester, $school_year);
        return $remarks;
    }
    
    public function sendFinanceRemarks($isBasicEd = NULL)
    {
        $st_id = base64_decode($this->post('st_id'));
        $remarks = $this->post('remarks');
        $school_year = $this->post('school_year');
        $semester = $this->post('semester');
        
        $remarkDetails = array(
            'fr_id'         => $this->eskwela->code(),
            'fr_to'         => $st_id,
            'fr_remarks'    => $remarks,
            'fr_given_by'   => $this->session->employee_id,
            'fr_semester'   => $semester,
            'fr_year'       => $school_year
        );
        
        if($this->enrollment_model->saveFinanceRemarks($remarkDetails, $st_id, $semester, $school_year)):
            Modules::run('college/enrollment/updateEnrollmentStatus', $st_id, 3,$semester, $school_year,($isBasicEd!=NULL?1:''));
            echo "Successfully Sent";
        else:
            echo "Something went wrong, Please try again later";
        endif;
    }
    
    public function updateEnrollmentStatus($st_id, $status, $semester,$school_year, $ifBasicEd = NULL)
    {
        $result = $this->enrollment_model->updateEnrollmentStatus($st_id, $status,$semester, $school_year, $ifBasicEd);
        return $result;
    }
    
    public function removeSubject()
    {
        $subject_id = $this->post('subject_id');
        $user_id     = base64_decode($this->post('user_id'));
        $school_year= $this->post('school_year');
        
        if($this->enrollment_model->removeSubject($subject_id, $user_id, $school_year)):
            
            $profile = Modules::run('college/getBasicInfo', base64_decode($user_id), $school_year);
            $remarks = $this->session->userdata('name').' has remove a subject from the load of '.$profile->firstname.' '.$profile->lastname;
            Modules::run('notification_system/systemNotification', 6, $remarks);
            
            $jsonArray = array('status'=>TRUE, 'msg' => 'Successfully Removed');
        else:
            $jsonArray = array('status'=>FALSE, 'msg' => 'Sorry Something went wrong');
        endif;
        
        echo json_encode($jsonArray);
    }
    
    function getStudentDetailsBasicEd($st_id, $sem=NULL, $school_year = NULL)
    {
        if(file_exists(APPPATH.'modules/college/views/online/'. strtolower($this->eskwela->getSet()->short_name).'/studentDetailsBasicEd.php')):
            $content = 'online/'.strtolower($this->eskwela->getSet()->short_name).'/studentDetailsBasicEd';
        else:
            $content = 'online/studentDetailsBasicEd';
        endif;
        $data['student'] = $this->enrollment_model->getStudentDetailsBasicEd(base64_decode($st_id), $sem, $school_year);
        $this->load->view($content, $data);
    }
    
    function getStudentDetails($st_id, $sem=NULL, $school_year = NULL)
    {
        if(file_exists(APPPATH.'modules/college/views/online/'. strtolower($this->eskwela->getSet()->short_name).'/studentDetails.php')):
            $content = 'online/'.strtolower($this->eskwela->getSet()->short_name).'/studentDetails';
        else:
            $content = 'online/studentDetails';
        endif;
        $data['student'] = $this->enrollment_model->getStudentDetails(base64_decode($st_id), $sem, $school_year);
        $this->load->view($content, $data);
    }
    
    function monitor($sem=NULL, $school_year = NULL,$st_id = NULL,  $department = NULL)
    {
        if($this->session->is_logged_in):
                if($sem==NULL):
                    $sem = Modules::run('main/getSemester');
                endif;
                if($sem==3):
                    $school_year = $this->session->school_year-1;
                endif;
                $adm1 = $this->enrollment_model->getOnlineBasicEdEnrollees($school_year, $sem);
                $adm2 = $this->enrollment_model->getOnlineEnrollees($school_year, $sem);
                $students = (object) array_merge((array) $adm1, (array) $adm2);
                
                
                //$students = $this->enrollment_model->getOnlineEnrollees($school_year, $sem);
                
                if(file_exists(APPPATH.'modules/college/views/online/'. strtolower($this->eskwela->getSet()->short_name).'/enrollmentMonitor.php')):
                    $content = 'online/'.strtolower($this->eskwela->getSet()->short_name).'/enrollmentMonitor';
                else:
                    $content = 'online/enrollmentMonitor';
                endif;
            if($st_id==NULL):
                $i=0;
                
                
                $data = array(
                    'modules'       => 'college',
                    'main_content'  => $content,
                    'settings'      =>  Modules::run('main/getSet'),
                    'students'      =>  $students,
                    'st_id'         =>  $st_id,
                    'semester'      =>  $sem,
                    'school_year'   =>  $school_year
                );
            else:    
                if($department==NULL):
                    $data = array(
                        'modules'       => 'college',
                        'main_content'  =>  $content,
                        'settings'      =>  Modules::run('main/getSet'),
                        'students'      =>  $students,
                        'student'       =>  Modules::run('college/enrollment/getStudentDetails', $st_id, $sem, $school_year),
                        'st_id'         =>  $st_id,
                        'semester'      =>  $sem,
                        'school_year'   =>  $school_year
                    );
                else:
                    $data = array(
                        'main_content'  =>  $content,
                        'modules'       => 'college',
                        'settings'      =>  Modules::run('main/getSet'),
                        'students'      =>  $students,
                        'student'       =>  Modules::run('college/enrollment/getStudentDetailsBasicEd', $st_id, $sem, $school_year),
                        'st_id'         =>  $st_id,
                        'semester'      =>  $sem,
                        'school_year'   =>  $school_year
                    );
                endif;
                
            endif;
                
                echo Modules::run('templates/online_content', $data);
        else:
            redirect('login');
        endif;
    }
            
    function financeDetails($isBasicEd=NULL)
    {
        if(file_exists(APPPATH.'modules/college/views/online/'. strtolower($this->eskwela->getSet()->short_name).'/financeDetails.php')):
            $content = 'online/'.strtolower($this->eskwela->getSet()->short_name).'/financeDetails';
        else:
            $content = 'online/financeDetails';
        endif;
        
        if($this->session->is_logged_in):
            $data = array(
                'modules'       => 'college',
                'main_content'  => $content,
                'settings'      =>  Modules::run('main/getSet')
            );

            echo Modules::run('templates/online_content', $data);
        else:
            redirect('college/enrollment/entrance');
        endif;
    }

    function searchBasicEdSubject($subject_id, $school_year) {
        $data['school_year'] = $school_year;
        $data['subjects'] = $this->enrollment_model->searchBasicEdSubject(urldecode($subject_id), $school_year);
        $this->load->view('online/searchSubjectTable_basicEd', $data);
    }

    function searchSubject($subject_id, $semester, $school_year) {
        $data['school_year'] = $school_year;
        $data['semester'] = $semester;
        $data['subjects'] = $this->enrollment_model->searchSubject(urldecode($subject_id), $semester, $school_year);
        $this->load->view('online/searchSubjectTable', $data);
    }

    function loadSchedule($subject_id, $semester, $school_year) {
        $data['school_year'] = $school_year;
        $data['semester'] = $semester;
        $data['subjects'] = $this->enrollment_model->getSubject(urldecode($subject_id), $semester, $school_year);
        $this->load->view('online/loadSubjectTable', $data);
    }

    function getSubjectLoad($st_id, $course_id, $year_level, $sem = NULL, $school_year = NULL) {
        
        $data['school_year'] = ($sem==3?$school_year-1:($school_year));
        $data['st_id'] = $st_id;
        $data['course_id'] = $course_id;
        $data['semester'] = $sem;
        $data['admissionRemarks'] = $this->getAdmissionRemarks(base64_decode($st_id), $sem, $data['school_year']);
        $status = json_decode($this->enrollment_model->checkIfEnrolled(base64_decode($st_id), $sem, $data['school_year'])); 
        if(!$status->isEnrolled):
            $data['subjects'] = $this->enrollment_model->getSubjectPerCourse($course_id, $year_level, $sem, ($school_year==NULL?$data['school_year']:$school_year));
            $this->load->view('online/subjectLoad', $data);
        
        else:
            if($status->row->is_final):
                if($status->row->status!=4):
                    $data['status'] = TRUE;
                    $data['msg'] = "You can now proceed to the final steps of the enrollment procedure please click <a class='btn btn-xs btn-info' onclick='getFinDetails()' href='#'>Next</a> to proceed";
                else:
                    $data['status'] = FALSE;
                    $data['msg'] = "Your application for enrollment undergoes an evaluation from the finance department because of past dues, but this will be quick so visit us often; <a class='btn btn-xs btn-info' href='". base_url('entrance')."'>Close</a>";
                endif;
                $data['subjects'] = $status->results;
                $this->load->view('online/subjectLoadWValue', $data);
            else:
                $hasLoadedSubjects = $this->enrollment_model->hasLoadedSubjects($status->row->admission_id, $data['school_year']);
                if($hasLoadedSubjects):
                    $data['status'] = FALSE;
                    $data['subjects'] = $status->results;
                    $data['msg'] = "Your application for enrollment with the subjects listed above is pending for approval, we will notify you once it is approved.";

                    $this->load->view('online/subjectLoadWValue', $data);
                else:
                    $data['subjects'] = $this->enrollment_model->getSubjectPerCourse($course_id, $year_level, $sem, $data['school_year']);
                    $this->load->view('online/subjectLoad', $data);
                endif;    
                
            endif;
        endif;    
        //echo $data['school_year'];
    }
    
    function hasLoadedSubject($admission_id, $school_year)
    {
        $hasLoadedSubjects = $this->enrollment_model->hasLoadedSubjects($admission_id, $school_year);
        return $hasLoadedSubjects;
    }

    public function en_dashboard() {
        if ($this->session->is_logged_in):
            if($this->session->department==4):
                
                if($this->session->details->status==1 && $this->session->details->semester==$this->session->semester && $this->session->details->school_year == $this->session->school_year):
                    redirect('opl/college');
                else:
                    $data = array(
                        'modules' => 'college',
                        'main_content' => 'online/student_dashboard'
                    );
                endif;
            else:
                
                if($this->session->details->status==1 && $this->session->details->semester==$this->session->semester && $this->session->details->school_year == $this->session->school_year):
                    redirect('opl/student');
                else:
                    $data = array(
                        'modules' => 'college',
                        'main_content' => 'online/student_dashboard_basicEd'
                    );
                endif;
            endif;

            echo Modules::run('templates/online_content', $data);
        else:
            redirect('college/enrollment/entrance');
        endif;
    }

    public function verifyOTP() {

        $settings = Modules::run('main/getSet');

        $otp = $this->post('otp');
        $id = base64_decode($this->post('id'));
        $department = $this->post('department');
        $semester = base64_decode($this->post('semester'));


        $fetched_user = $this->enrollment_model->fetch_otp($id);
        $db_code = $fetched_user->otp_code;
        $password_matched = password_verify($otp, $db_code);
        if ($password_matched) {
            if ($department == 4): //college
                $details = $this->enrollment_model->getDetails($id);
                $course_id = $details->course_id;
                $school_year = ($semester == 3 ? ($settings->school_year - 1) : $settings->school_year);
                $isCollege = TRUE;
                
                $isOld = $this->enrollment_model->isPreviouslyEnrolled($id, ($semester==1?($school_year-1):$school_year), $isCollege, ($semester>1?($semester-1):3)); 
                
            else:
                $details = $this->enrollment_model->getBasicEducationDetails($id);
                $course_id = 0;
                $school_year = ($semester == 3 ? ($settings->school_year - 1) : $settings->school_year);
                $isCollege = FALSE;
                $isOld = $this->enrollment_model->isPreviouslyEnrolled($id, $school_year,$isCollege); 
               
            endif;

            $userData = array(
                'is_logged_in'  => TRUE,
                'isStudent'     => TRUE,
                'isOld'         => $isOld,
                'isCollege'     => $isCollege,
                'name'          => $details->firstname,
                'fullname'      => $details->firstname . ' ' . $details->lastname,
                'st_id'         => $id,
                'course_id'     => $course_id,
                'details'       => $details,
                'school_year'   => $school_year,
                'department'    => $department,
                'semester'      => $semester
            );


            $this->session->set_userdata($userData);

            echo json_encode(array('status' => TRUE, 'url' => base_url('student/dashboard/')));
        } else {
            echo json_encode(array('status' => FALSE, 'url' => ''));
        }
    }

    private function checkIfIDExist($id) {
        $details = json_decode($this->enrollment_model->checkIfIDExist($id));
        if ($details->status):
            return $details;
        else:
            return $details;
        endif;
    }

    private function requestOTP($id) {
        $otp = $this->passGenerator();
        $pword = password_hash($otp, PASSWORD_DEFAULT, ['cost' => 8]);

        if ($this->enrollment_model->saveOTP($id, $pword, $this->eskwela->generateRandNum())):
            // email or text the One Time Password
            return $otp;
        endif;
    }

    public function requestEntry() {
        $idNumber = $this->post('id');
        $department = $this->post('department');
        $result = $this->checkIfIDExist($idNumber);
        if ($result->status):
            $otp = $this->requestOTP($idNumber);
            if($department==4):
                $firstNum = substr($result->details->cd_mobile, 0, 4);
                $secondNum = substr($result->details->cd_mobile, -3);
                $contactNo = $result->details->cd_mobile;
            else:
                $firstNum = substr($result->details->ice_contact, 0, 4);
                $secondNum = substr($result->details->ice_contact, -3);
                $contactNo = $result->details->ice_contact;
            endif;
            $jsonResponse = array('status' => TRUE,
                'otp' => $otp,
                'contact_num' => $contactNo,
                'encrypt_num' => $firstNum . '****' . $secondNum,
                'contact_email' => $result->details->cd_email,
                'department' =>$department,
                'semester'   => base64_encode($this->post('semester')),
                'url' => base_url('college/enrollment/entrance/' . base64_encode($idNumber).'/'.$department.'/'.base64_encode($this->post('semester'))));

            echo json_encode($jsonResponse);
        else:
            echo json_encode(array('status' => FALSE, 'otp' => '', 'url' => '', 'year' => $result->year));
        endif;
    }

    public function entrance($st_id = NULL, $department = NULL, $semester = NULL) {
        if ($this->session->is_logged_in):
               $this->session->sess_destroy();
        endif;
        $data = array(
            'st_id' => $st_id,
            'department' => $department,
            'semester'  => $semester,
            'modules' => 'college',
            'main_content' => 'online/entrance'
        );

        echo Modules::run('templates/online_content', $data);
    }

    private function passGenerator() {
        $length = '6';
        $characters = '0123456789';
        $string = '';

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public function sendConfirmation($number=NULL, $msg=NULL) {
        $api = Modules::run('main/getSet');
        
        $message = strtoupper($api->short_name) . ' SMS: ' . urldecode($msg);
        $apicode = $api->apicode;
        $apipass = $api->api_pass;

        $result = $this->itexmo($number, $message, $apicode, $apipass);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $result = $msg;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $result = $msg;
        }
        return json_encode(array('number' => $number, 'msg' => $msg, 'status' => $stat));
    }

    public function sendText() {
        $api = Modules::run('main/getSet');
        
        $number = $this->post('num');
        $message = strtoupper($api->short_name) . ' SMS: ' . $this->post('msg');
        $apicode = $api->apicode;
        $apipass = $api->api_pass;

        $result = $this->itexmo($number, $message, $apicode, $apipass);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $result = $msg;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $result = $msg;
        }
        echo json_encode(array('number' => $number, 'msg' => $msg, 'status' => $stat));
    }
    
    public function sampleText($number, $message)
    {
        $api = Modules::run('main/getSet');
        $apicode = $api->apicode;
        $apipass = $api->api_pass;
        $result = $this->itexmo($number, $message, $apicode, $apipass);
        if ($result == "") {
            $msg = "No server response";
            $stat = 0;
            $result = $msg;
        } else if ($result == 0) {
            $msg = "Message sent";
            $stat = 1;
            $result = $msg;
        } else {
            $msg = "error encountered";
            $stat = 2;
            $result = $msg;
        }
        echo json_encode(array('number' => $number, 'msg' => $msg, 'status' => $stat));
    }
    
    private function itexmo($number,$message,$apicode,$passwd){
        $ch = curl_init();
        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
        curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS, 
                  http_build_query($itexmo));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return curl_exec ($ch);
        curl_close ($ch);
    }   

//    private function itexmos($number, $message, $apicode, $apipass) {
//        $url = 'https://www.itexmo.com/php_api/api.php';
//        $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $apipass);
//        $param = array(
//            'http' => array(
//                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
//                'method' => 'POST',
//                'content' => http_build_query($itexmo),
//            ),
//        );
//        $context = stream_context_create($param);
//        return file_get_contents($url, false, $context);
//    }
//    
    public function saveBasicLoad()
    {
        $semester = $this->post('semester');
        $st_id = $this->post('st_id');
        $school_year = ($semester==3?$this->post('school_year'):($this->post('school_year')+1));
        $data = json_decode($this->post('enData'));
        foreach ($data as $d):
            $this->enrollment_model->saveBasicEnrollmentDetails($st_id, $d->level_id, $d->sub_id, $d->is_overload, $school_year);
           // print_r($d);
        endforeach;
    }
    
    public function saveLoadedSubjects()
    {
        $semester = $this->post('semester');
        $st_id = $this->post('st_id');
        $user_id = $this->post('user_id');
        $school_year = $this->post('school_year');
        $data = json_decode($this->post('enData'));
        foreach ($data as $d):
            
            $details = array(
                'cl_id'         => $this->eskwela->code(),
                'cl_adm_id'     => $d->cl_adm_id,
                'cl_user_id'    => $d->cl_user_id,
                'cl_sub_id'     => $d->cl_sub_id,
                'cl_section'     => $d->cl_section,
                
            );
            
            $this->enrollment_model->saveEnrollmentDetails($details, $school_year, $user_id, $d->cl_sub_id);
           // print_r($d);
        endforeach;
    }

    public function saveBasicRO() {
        $settings = Modules::run('main/getSet');
        $semester = $this->input->post('semester');
        $school_year = $this->input->post('school_year');
        $year_level = $this->input->post('year_level');
        if ($semester == 3):
            $sy = $school_year - 1;
        else:
            $year_level = $year_level + 1;
            $sy = $school_year;
        endif;
        
        
        $st_id = base64_decode($this->input->post('st_id'));
        $user_id = $this->input->post('user_id');
        $isEnrolled = $this->enrollment_model->checkBasicRO($user_id, $semester, $school_year);
        if (!$isEnrolled):

            if ($semester == 0):
                $profile = $this->enrollment_model->getPreviousRecord('profile', 'user_id', $user_id, ($school_year-1), $settings);
            
                $profile_students = $this->enrollment_model->getPreviousRecord('profile_students', 'user_id', $profile->user_id, ($school_year-1), $settings);
                $profile_address = $this->enrollment_model->getPreviousRecord('profile_address_info', 'address_id', $profile->add_id, ($school_year-1), $settings);
                $profile_contact = $this->enrollment_model->getPreviousRecord('profile_contact_details', 'contact_id', $profile->contact_id, ($school_year-1), $settings);
                $profile_parents = $this->enrollment_model->getPreviousRecord('profile_parent', 'u_id', $profile->user_id, ($school_year-1), $settings);


                $this->enrollment_model->insertData($profile, 'profile', 'user_id', $profile->user_id, $sy);
                $this->enrollment_model->insertData($profile_students, 'profile_students', 'user_id', $profile->user_id, $sy);
                //$this->enrollment_model->insertData($profile_parents, 'profile_parents');
              
                $this->enrollment_model->insertData($profile_parents, 'profile_parent', 'u_id', $profile->user_id, $sy);


                $this->enrollment_model->insertData($profile_address, 'profile_address_info', 'address_id', $profile_address->address_id, $sy);
                $this->enrollment_model->insertData($profile_contact, 'profile_contact_details', 'contact_id', $profile_contact->contact_id, $sy);

            endif; // if summer == 1 closing
            
            $section = $this->enrollment_model->getSectionByLevel($year_level, $sy);
            
            $details = array(
                'admission_id'      => $this->eskwela->code(),
                'school_year'       => $sy,
                'semester'          => $semester,
                'date_admitted'     => date('Y-m-d'),
                'user_id'           => $user_id,
                'grade_level_id'    => $year_level,
                'section_id'        => ($section->row()?$section->row()->s_id:0),
                'status'            => 0,
                'st_id'             => $st_id,
                'is_old'            => 1,
                'enrolled_online'   => 1,
                'st_type'           => ($semester==3?6:0)
            );

            $ro_id = $this->enrollment_model->saveBasicRO($details, $sy);
            if (!$ro_id):
                echo 'Sorry, something went wrong, Please Try Again';
            else:
                switch ($semester):
                    case 0:
                        $semName = 'for the';
                        break;
                    case 3:
                        $semName = 'for the Summer of';
                        break;
                    
                endswitch;
                $remarks = $this->session->userdata('name') . ' a Basic Education Student has enrolled online '. $semName .' school year '.$sy.' - '.($sy+1).'.';
                Modules::run('notification_system/systemNotification', 3, $remarks);
                
                //Modules::run('main/logActivity', 'REGISTRAR', $remarks, $this->session->userdata('user_id'));

                $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');

                $json_array = array(
                    'status'=>TRUE,
                    'remarks' => $remarks,
                    'username' => $registrar->employee_id,
                    'msg' => 'Successfully Submitted',
                    'st_id' => $st_id,
                    'user_id' => $user_id
                );
                echo json_encode($json_array);
            endif;


        else:
            echo json_encode(array('status'=>FALSE,'msg' => 'Sorry you already submitted your enrollment application and/or you are already enrolled', 'st_id' => json_decode($isEnrolled)->st_id));
        endif;
    }
    
    public function saveCollegeRO() {
        $settings = Modules::run('main/getSet');
        $course = $this->input->post('course_id');
        $semester = $this->input->post('semester');
        $school_year = $this->input->post('school_year');
        $year_level = $this->input->post('year_level');
        if ($semester == 1):
            $year_level = $year_level + 1;
            if($this->post('is_old')):
                $previous_year = $school_year - 1;
            endif;
            $sy = $school_year + 1;
        else:
            $sy = $school_year;
        endif;
        
        
        $st_id = base64_decode($this->input->post('st_id'));
        $user_id = $this->input->post('user_id');
        $profile = $this->enrollment_model->getPreviousRecord('profile', 'user_id', $user_id, $previous_year, $settings);
        
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
        
        $isEnrolled = $this->enrollment_model->checkCollegeRO($user_id, $semester, $school_year);
        if($this->post('is_old')):
            if (!$isEnrolled):

                if ($semester == 1):
                    $profile = $this->enrollment_model->getPreviousRecord('profile', 'user_id', $user_id, $previous_year, $settings);
                    $profile_students = $this->enrollment_model->getPreviousRecord('profile_students', 'user_id', $profile->user_id, $previous_year, $settings);
                    $profile_address = $this->enrollment_model->getPreviousRecord('profile_address_info', 'address_id', $profile->add_id, $previous_year, $settings);
                    $profile_contact = $this->enrollment_model->getPreviousRecord('profile_contact_details', 'contact_id', $profile->contact_id, $previous_year, $settings);
                    $profile_parents = $this->enrollment_model->getPreviousRecord('profile_parent', 'u_id', $profile->user_id, $previous_year, $settings);
                    $bdate = $this->enrollment_model->getPreviousRecord('calendar', 'cal_id', $profile->bdate_id, $previous_year, $settings);


                    $this->enrollment_model->insertData($profile, 'profile', 'user_id', $profile->user_id, $school_year);
                    $this->enrollment_model->insertData($profile_students, 'profile_students', 'user_id', $profile->user_id, $school_year);
                    //$this->enrollment_model->insertData($profile_parents, 'profile_parents');

                    $this->enrollment_model->insertData($profile_parents, 'profile_parent', 'u_id', $profile->user_id, $school_year);


                    $this->enrollment_model->insertData($profile_address, 'profile_address_info', 'address_id', $profile_address->address_id, $school_year);
                    $this->enrollment_model->insertData($profile_contact, 'profile_contact_details', 'contact_id', $profile_contact->contact_id, $school_year);


                endif; // if summer == 1 closing
                $admission_id = $this->eskwela->code();
                $details = array(
                    'admission_id' => $admission_id,
                    'school_year' => $school_year,
                    'semester' => $semester,
                    'date_admitted' => date('Y-m-d'),
                    'user_id' => $user_id,
                    'course_id' => $course,
                    'year_level' => $year_level,
                    'status' => 0,
                    'st_id' => $st_id,
                    'is_old' => 1,
                    'enrolled_online' => 1
                );

                $ro_id = $this->enrollment_model->saveCollegeRO($details, $school_year);
                if (!$ro_id):
                    echo 'Sorry, something went wrong, Please Try Again';
                else:
                    $remarks = $this->session->userdata('name') . ' has enrolled online for the '.$semName.' of school year '.$school_year.' - '.($school_year+1).'.';
                    Modules::run('notification_system/systemNotification', 3, $remarks);

                    $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
                    Modules::run('main/logActivity', 'REGISTRAR', $remarks, $registrar->user_id);


                    $json_array = array(
                        'status' => TRUE,
                        'remarks' => $remarks,
                        'username' => $registrar->employee_id,
                        'msg' => 'Successfully Submitted',
                        'admission_id' => $admission_id
                    );
                    echo json_encode($json_array);
                endif;


            else:
    //            $remarks = $this->session->userdata('name') . ' has submitted a study load for the '.$semName.' of school year '.$sy.' - '.($sy+1).'.';
    //        
    //             Modules::run('notification_system/systemNotification', 3, $remarks);
                echo json_encode(array('status' => FALSE,'msg' => 'Sorry you already submitted your enrollment application and/or you are already enrolled', 'admission_id' => json_decode($isEnrolled)->admission_id));
            endif;
        else:
            $isEnrolled = json_decode($this->enrollment_model->checkCollegeRO($user_id, $semester, $sy));
            //echo $user_id.' '. $semester.' '. $sy;
                    $remarks = $this->session->userdata('name') . ' has enrolled online for the '.$semName.' of school year '.$sy.' - '.($sy+1).'.';
                    Modules::run('notification_system/systemNotification', 3, $remarks);

                    $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
                    Modules::run('main/logActivity', 'REGISTRAR', $remarks, $registrar->user_id);
                    
                    $json_array = array(
                        'status' => TRUE,
                        'remarks' => $remarks,
                        'username' => $registrar->employee_id,
                        'msg' => 'Successfully Submitted',
                        'admission_id' => $isEnrolled->admission_id
                    );
                    echo json_encode($json_array);
            
        endif;    
    }
    
    function approveLoadOnline($adm_id, $user_id, $school_year = NULL, $semester = NULL)
    {
        $approved = $this->enrollment_model->approveLoad($adm_id, $school_year, 3);
        if($approved):
            
            // Activity Log
            $profile = Modules::run('college/getBasicInfo', base64_decode($user_id), ($school_year==NULL?$this->session->school_year:$school_year));

            $registrar = Modules::run('hr/getEmployeeByPosition', 'Registrar');
            
            
            $remarks = $this->session->userdata('name').' has approved the Study Load of '.$profile->lastname.', '.$profile->firstname.' who submit his/her application online.';
            $message = "Your application for enrollment is successfully approved by your Dean. Login now to complete your enrollment";
            $result = json_decode(Modules::run('college/enrollment/sendConfirmation', $profile->cd_mobile, $message));
            $try = 0;
            $resultStatus = $result->status;
            
            while($resultStatus!=1):
                $try++;
                $result = json_decode(Modules::run('college/enrollment/sendConfirmation', $profile->cd_mobile, $message));
                if($try==10):
                    $this->enrollment_model->approveLoad($adm_id, $school_year, 0);
                    $statusArray = array(
                        'status'    => true,    
                        'remarks'   => $remarks,    
                        'username'  => $registrar->employee_id,
                        'msg'       => "Sorry, System failed to Approve the request, please try again later"
                    );
                    break;
                    
                endif;
                
                $resultStatus = $result->status;
            endwhile;
            
            if($result->status):
                Modules::run('college/enrollment/updateEnrollmentStatus', $profile->st_id, 3,$semester, $school_year);
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

    function removeEnrollmentDetails()
    {
        $admission_id = base64_decode($this->post('adm_id'));
        $school_year = $this->post('school_year');
        
        if($this->enrollment_model->removeEnDetails($school_year, $admission_id)):
            echo 'Successfully Removed';
        else:
            echo 'Something went wrong';
        endif;
    }
    
    

    function do_upload() {
        $fType = $this->input->post('fileType');
        $stid = $this->input->post('stid');
        $req_id = $this->input->post('req_id');
        $file = $this->input->post('userfile');

        
        $config['upload_path'] = UPLOADPATH.$this->session->school_year.DIRECTORY_SEPARATOR.'students'.DIRECTORY_SEPARATOR. base64_decode($stid).DIRECTORY_SEPARATOR.'files';
//        $config['upload_path'] = 'uploads/students/' . base64_decode($stid) . '/';
        if (!is_dir($config['upload_path'])):
          mkdir($config['upload_path'],0777,TRUE);
        endif;
        $config['file_name'] = $fType . '-' . base64_decode($stid) . '-' . $req_id;
        $config['overwrite'] = FALSE;
        $config['allowed_types'] = '*';
        $config['max_size'] = '3072';
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '50%';
        $config['width'] = 400;
        $this->load->library('upload', $config);

        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
            print_r($data);
            //echo $config['upload_path'] . '/';
            //$this->load->view('csvindex', $data);
        } else {
//            print_r($fType . '-' . $stid .'-'. $_FILES['userfile']['name']);
            $file_data = $this->upload->data();
            $ext = $file_data['file_ext'];
            $link = $config['upload_path'] . $config['file_name'] . $ext;
            $this->enrollment_model->updateEnrollmentReq(base64_decode($stid), $link, $req_id, $this->session->school_year);
            ?>
            <script>
                alert('upload successfully');
                document.location = "<?php echo base_url() . 'student/dashboard/' ?>";
            </script>    
            <?php
        }
    }

    function checkReq($stid, $req_id) {
        return $this->enrollment_model->checkReq(base64_decode($stid), $req_id);
    }
    
    function checkPerDeptList($id){
        $data['dept'] = $id;
        $data['list'] = $this->enrollment_model->checkPerDeptList($id);
        echo $this->load->view('reqListPerDept', $data);
    }
    
    function displayCheckListPerDept($dept, $opt){
        
        $deptNum = ($opt != 1 ? $this->department($dept) : $dept);
        return $this->enrollment_model->checkPerDeptList($deptNum);
    }
}
