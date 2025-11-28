<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Registrar extends MX_Controller {
    //put your code here
    
    protected $processAdmission ;
    
    function __construct() {
        parent::__construct();
        $this->load->model('registrar_model');
    	$this->load->model('get_registrar_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
        $this->processAdmission = Modules::load('registrar/registrardbprocess/');
	}
        
    function getBasicStudent($user_id)
    {
        $student = $this->get_registrar_model->getBasicStudent($user_id);
        return $student;
    }
    
    function printIdCard($section_id,$limit,$offset)
    {

        if($offset!=0):
            $offset= $offset+4;
        endif;
        $data['students'] = $this->get_registrar_model->getAllStudentsForID($limit, $offset, NULL, $section_id);
        $this->load->view('printId', $data);
    }
    
    function printIdCardBack($section_id,$limit,$offset)
    {
        $data['students'] = $this->get_registrar_model->getAllStudentsForID($limit, $offset, NULL, $section_id);
        $this->load->view('printId_back', $data);
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
        
        $this->registrar_model->saveNewValue($table, $nValue);
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
    
    function editIdNumber()
    {
        $origIdNumber = $this->input->post('origIdNumber');
        $editedIdNumber = $this->input->post('editedIdNumber'); 
        $row = $this->registrar_model->getUserId($origIdNumber);
        $updatedIDNumber = array(
            'user_id' => $editedIdNumber
        );
        if( $this->registrar_model->updateProfileInfo($row->user_id, array('st_id'=>$editedIdNumber))):
            $this->registrar_model->updateProfileDetails($origIdNumber, $updatedIDNumber, 'profile_medical');
            $this->registrar_model->updateGradingAttendanceDetails($origIdNumber, array('st_id'=>$editedIdNumber),'gs_raw_score' );
            if(!$this->session->userdata('attend_auto')):
                $this->registrar_model->updateGradingAttendanceDetails($origIdNumber, array('st_id'=>$editedIdNumber),'attendance_sheet_manual' );
            else:
//                  use to update finance details
            $this->registrar_model->updateFinanceDetails($origIdNumber, array('stud_id'=>$editedIdNumber),'fin_accounts' );
            $this->registrar_model->updateFinanceDetails($origIdNumber, array('stud_id'=>$editedIdNumber),'fin_transaction' );
            $this->registrar_model->updateFinanceDetails($origIdNumber, array('stud_id'=>$editedIdNumber),'fin_extra' );
            $this->registrar_model->updateFinanceDetails($origIdNumber, array('stud_id'=>$editedIdNumber),'fin_discount' );
            endif;
            $this->registrar_model->updateGradingAttendanceDetails($origIdNumber, array('st_id'=>$editedIdNumber),'gs_final_assessment');
            $this->registrar_model->updateGradingAttendanceDetails($origIdNumber, array('st_id'=>$editedIdNumber),'gs_final_card');
           
            
          echo $editedIdNumber;  
        endif;
        
        
    }
    
    function deleteID()
    {
        $user_id = $this->input->post('user_id');
        $st_id = $this->input->post('st_id');
        if($this->session->userdata('user_id')==$user_id):
            $this->registrar_model->deleteProfile('user_id', $st_id, 'profile');
            $this->registrar_model->deleteProfile('u_id', $st_id, 'profile_info');
            $this->registrar_model->deleteProfile('user_id', $st_id, 'profile_parent');
            $this->registrar_model->deleteProfile('user_id', $st_id, 'profile_medical');
            $this->registrar_model->deleteProfile('user_id', $st_id, 'profile_medical');
            $this->registrar_model->deleteProfile('stud_id', $st_id, 'fin_accounts');
            $this->registrar_model->deleteProfile('stud_id', $st_id, 'fin_transaction');
            $this->registrar_model->deleteProfile('stud_id', $st_id, 'fin_extra');
            $this->registrar_model->deleteProfile('st_id', $st_id, 'attendance_sheet_manual');
            
            Modules::run('notification_system/department_notification', 5, "This Teacher ( $user_id ) Deleted this student ( $st_id ) from the list ");
            
            echo json_encode(array('status' => TRUE, 'msg' => "You have Successfully Deleted this student ( $st_id ) from the List"));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => "It Seems that the ID you enter didn't match with your records"));
        endif;
        
    }
    
    function checkID()
    {
        $id = $this->input->post('id');
        $idExist=$this->registrar_model->checkID($id);
        if($idExist)
        {
            echo json_encode(array('status' => TRUE, 'msg' => 'Sorry, This ID Number Already Exist'));
        }else{
            echo json_encode(array('status' => FALSE, 'msg' => ''));
        }
    }
        
    function getSectionById($id)
    {
        $section = $this->get_registrar_model->getSectionById($id);
        return $section;
        
    }    
    
    function getMother($id)
    {
        $mother = $this->get_registrar_model->getMother($id);
        return $mother;
    }
    
    function getFather($id)
    {
        $mother = $this->get_registrar_model->getFather($id);
        return $mother;
        
    }
        
     
    function getSingleStudent($user_id)
    {
        $student = $this->get_registrar_model->getSingleStudent($user_id);
        return $student;
    }
    
    function getSingleStudentByRfid($user_id)
    {
        $student = $this->get_registrar_model->getSingleStudentByRfid($user_id);
        return $student;
    }
    
    function getAllStudents()
    {
        if($this->session->userdata('position_id')!=4):
            $result = $this->get_registrar_model->getAllStudents('','',Null, Null);
            $config['base_url'] = base_url('registrar/getAllStudents');
            $config['total_rows'] = $result->num_rows();
            $config['per_page'] = 10;
            
            
            $this->pagination->initialize($config);
            $data['links'] = $this->pagination->create_links();
            
            $page = $this->get_registrar_model->getAllStudents($config['per_page'], $this->uri->segment(3), Null, Null);
            $data['students'] = $page->result();
            $data['num_of_students'] = $result->num_rows();
            $data['grade'] = $this->getGradeLevel(); 
            $data['section'] = $this->getAllSection();
            
            if(Modules::run('main/isMobile')):
                 if($this->session->userdata('position_id')==39):
                    
                    redirect(base_url().'registrar/getAllStudentsBySection/'.$this->session->userdata('advisory'));
                 endif;
            else:
                if($this->session->userdata('position_id')==39):
                    
                    redirect(base_url().'registrar/getAllStudentsBySection/'.$this->session->userdata('advisory'));
                else:
                    $data['main_content'] = 'roster';
                    $data['modules'] = 'registrar'; 
                    echo Modules::run('templates/main_content', $data);
                 endif;
                	
            endif;
            
       else:
             $data['students'] = $this->get_registrar_model->getStudentListForParent($this->session->userdata('parent_id'));
             $data['main_content'] = 'parentRoster';
             $data['modules'] = 'registrar';
             echo Modules::run('templates/main_content', $data);

       endif;     
    }
	
    function getAllStudentsBySection($section_id=NULL)
    {
            
            if($this->session->userdata('position_id')!=4):
                $result = $this->get_registrar_model->getAllStudents('','',Null, $section_id);
                $config['base_url'] = base_url('registrar/getAllStudentsBySection/'.$section_id);
                $config['total_rows'] = $result->num_rows();
                $config['per_page'] = 10;
                $config["uri_segment"] = 4;
                $this->pagination->initialize($config);
                
                $page = $this->get_registrar_model->getAllStudents($config['per_page'], $this->uri->segment(4), Null, $section_id);
                
                $data['links'] = $this->pagination->create_links();
                $data['num_of_students'] = $result->num_rows();
                $data['students'] = $page->result();
                $data['grade'] = $this->getGradeLevel(); 
                $data['section_id'] = $section_id;
                $data['section'] = $this->getAllSection();
                
                
                if(Modules::run('main/isMobile')):
                          $data['modules'] = "registrar";
                          $data['main_content'] = 'mobile/studentListForAdvisers';
                          echo Modules::run('mobile/main_content', $data);
                else:
                    $data['main_content'] = 'roster';
                    $data['modules'] = 'registrar'; 
                    echo Modules::run('templates/main_content', $data);	
                endif;
                
            else:
                
                if(!Modules::run('main/isMobile')):
                     $data['students'] = $this->get_registrar_model->getStudentListForParent($this->session->userdata('parent_id'));
                     $data['main_content'] = 'parentRoster';
                     $data['modules'] = 'registrar';
                     echo Modules::run('templates/main_content', $data);
                     
                else:
                     $data['students'] = $this->get_registrar_model->getStudentListForParent($this->session->userdata('parent_id'));
                     $data['modules'] = "registrar";
                     $data['main_content'] = 'mobile/parentRoster';
                     echo Modules::run('mobile/main_content', $data);
                    
                endif;
               	
            endif;


    }
    
    function getStudentListForParent()
    {
        $students = $this->get_registrar_model->getStudentListForParent($this->session->userdata('parent_id'));
        return $students;
    }
    
    
    function getAllStudentsForExternal($grade_id=null, $section_id=null, $gender=null, $status=NULL)
    {
        $result = $this->get_registrar_model->getStudents($grade_id,$section_id, $gender, $status);
        return $result;
    }
    
    function getAllStudentsByGradeLevel($grade_id=null)
    {
            $result = $this->get_registrar_model->getAllStudents('','',$grade_id);
            $config['base_url'] = base_url('registrar/getAllStudentsByGradeLevel/'.$grade_id);
            $config['total_rows'] = $result->num_rows();
            $config['per_page'] = 10;
            $config["uri_segment"] = 4;
            $this->pagination->initialize($config);

            $page = $this->get_registrar_model->getAllStudents($config['per_page'], $this->uri->segment(4),$grade_id , Null);
            $data['links'] = $this->pagination->create_links();
            $data['students'] = $page->result();
            $data['num_of_students'] = $result->num_rows();
            $data['students'] = $page->result();
            $data['grade'] = $this->getGradeLevel(); 
            $data['section'] = $this->getAllSection();
            $data['main_content'] = 'roster';
            $data['modules'] = 'registrar';
            $data['grade_id'] = $grade_id;
            echo Modules::run('templates/main_content', $data);	
    }
    
    function getStudentsByGradeLevel($grade_id=null, $section_id=null, $gender=null, $status=NULL)
    {
        $students = $this->get_registrar_model->getStudents($grade_id,$section_id, $gender, $status);
        return $students;
    }
    
    function getAllStudentsByGender($section_id=null, $gender=null, $status)
    {
        $result = $this->get_registrar_model->getAllStudentsByGender($section_id, $gender, $status);
        return $result;
        //echo $result->num_rows();
    }
    
    function getAllStudentsInNormalView()
    {
         $students= $this->get_registrar_model->getStudentListForParent($this->session->userdata('parent_id'));
         return $students;
    }

    function viewDetails($id)
    {
        $id = base64_decode($id);
        $students = $this->get_registrar_model->getSingleStudent($id);  
        
       
        $data['students'] = $this->get_registrar_model->getSingleStudent($id);  
        $data['m'] = $this->get_registrar_model->getMother($students->pid); 
        $data['f'] = $this->get_registrar_model->getFather($students->pid); 
        $data['medical'] = $this->get_registrar_model->getMedical($id); 
        $data['date_admitted'] = $this->get_registrar_model->getDateEnrolled($id);
        $data['option'] = 'individual';
        $data['st_id']=$id;
        $data['educ_attain'] = $this->registrar_model->getEducAttain();
        $data['modules'] = 'registrar';
        $data['main_content'] = 'studentInfo';
        echo Modules::run('templates/main_content', $data);
    }
    
    function getLatestIdNum($level_id)
    {
        $deptCode = $this->registrar_model->getDeptCode($level_id);
        $id = $this->registrar_model->getLatestID($deptCode->deptCode);
        if(!$id):
          $last_three = '000';  
        else:
          $last_three = substr($id->st_id, -3);  
        endif;
        
        echo json_encode(array('status' => TRUE, 'id' => $last_three, 'deptCode'=> $deptCode->deptCode));
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
                $data['cities'] = Modules::run('main/getCities');
                $data['provinces'] = Modules::run('main/getProvinces');
                $data['religion'] = Modules::run('main/getReligion');
                $data['motherTongue'] = Modules::run('main/getMotherTongue');
                $data['ethnicGroup'] = Modules::run('main/getEthnicGroup');
                $data['grade'] = $this->registrar_model->getGradeLevel(); 
                $data['physician'] = $this->registrar_model->getPhysician(); 
                $data['settings'] = Modules::run('main/getSet');
                $data['educ_attain'] = $this->registrar_model->getEducAttain();
                $data['modules'] = "registrar";
                $data['main_content'] = 'admission';
                echo Modules::run('templates/main_content', $data);
             }
    }
    
    function getGradeLevel()
    {
        $gradeLevel = $this->registrar_model->getGradeLevel();
        return $gradeLevel;
    }
    
    function getGradeLevelByLevelCode($grade_id)
    {
        $grade_id = $this->registrar_model->getGradeLevelByLevelCode($grade_id);
        return $grade_id;
    }
    
    function getGradeLevelById($grade_id)
    {
        $grade_id = $this->registrar_model->getGradeLevelById($grade_id);
        return $grade_id;
    }
    
    function getSectionBySubject($grade_id)
    {
        $section = $this->registrar_model->getSectionByLevel($grade_id); 
        return $section->row();
    }
    
    public function saveAdmission()
    {
        if($this->input->post('inputLRN')==0){
            $st_id = $this->input->post('inputIdNum');
        }else{
            $st_id = $this->input->post('inputLRN');
        }
        $enDate = $this->input->post('inputEdate');
        //$grade_level = $this->input->post('inputGrade');
        $section = $this->input->post('inputSection');
             
        $motherTongue = $this->input->post('addMotherTongue');
        $processAdmission = Modules::load('registrar/registrardbprocess/');
        $items = array(
             'lastname'         => $this->input->post('inputLastName'),
             'firstname'        => $this->input->post('inputFirstName'),
             'middlename'       => $this->input->post('inputMiddleName'),
             'add_id'           => 0,
             'sex'              => $this->input->post('inputGender'),
             'rel_id'           => $this->input->post('inputReligion'),
             'bdate_id'         => 0,
             'contact_id'       => 0,
             'status'           => 0,
             'nationality'      => $this->input->post('inputNationality'),     
             'account_type'     => 5,
             'ethnic_group_id'  => $this->input->post('addEthnicGroup'),
             'occupation_id'    => 1

        );  
        
        //saves the basic info
        $profile_id = $processAdmission->saveProfile($items);
        
        $enroll_date = $this->registrar_model->saveEdate($enDate);
        
        //saves the detail info
        $processAdmission->setStudInfo($st_id, $profile_id, $section, $motherTongue, $enroll_date);

        //saves the address
        
        $barangay_id = $processAdmission->setBarangay($this->input->post('inputBarangay'));
        
        $add = array(
            'street'                => $this->input->post('inputStreet'),
            'barangay_id'              => $barangay_id,
            'city_id'                  => $this->input->post('inputMunCity'),
            'province_id'              => $this->input->post('inputPID'),
            'country'               => 'Philippines',
            'zip_code'              => $this->input->post('inputPostal'),
        );
        
        $address_id = $processAdmission->setAddress($add, $profile_id);

        
        //saves the basic contact
        $processAdmission->setContacts($this->input->post('inputPhone'), $this->input->post('inputEmail'), $profile_id);

        //saves the birthday
        $date = $this->input->post('inputBdate');
        $this->registrar_model->setDate($date, $profile_id, 'bdate_id');

        // Save Parents details
        $PExist = $this->input->post('inputFExist');

       if($PExist>0){ // If Parent Already Exist
           $this->registrar_model->updateParentPro($PExist, $st_id);
           echo 'parent exist';
       }else{
           
           $pgSelect = $this->input->post('pgSelect');     
            if($pgSelect==1){
                    $guardian = array(
                        'lastname'         => $this->input->post('inputGLName'),
                        'firstname'        => $this->input->post('inputGFName'),
                        'middlename'       => $this->input->post('inputGMName'),
                        'add_id'           => $address_id,
                        'sex'              => $this->input->post('inputGuardGender'),
                        'nationality'      => $this->input->post('inputNationality'),     
                        'account_type'     => 4,
                    );
                
                    $guardian_id = $processAdmission->saveProfile($guardian);        
        
                    $processAdmission->setParentsPro($profile_id, $guardian_id,0, 1, $this->input->post('relationship')); 

                    $processAdmission->setContacts($this->input->post('inputG_num'), $this->input->post('inputGEmail'), $guardian_id);

                    $processAdmission->chooseOcc($this->input->post('inputG_occ'), $guardian_id);

                    $processAdmission->chooseEduc($this->input->post('inputGeduc'), $guardian_id);
            
        }
        else
        {
             $father = array(
                        'lastname'         => $this->input->post('inputFLName'),
                        'firstname'        => $this->input->post('inputFName'),
                        'middlename'       => $this->input->post('inputFMName'),
                        'add_id'           => $address_id,
                        'sex'              => 'Male',
                        'nationality'      => $this->input->post('inputNationality'),     
                        'account_type'     => 4,
                    );
             
             $father_id = $processAdmission->saveProfile($father);
             
             $processAdmission->setContacts($this->input->post('inputF_num'), $this->input->post('inputPEmail'), $father_id);

            $processAdmission->chooseOcc($this->input->post('inputF_occ'), $father_id);

            $processAdmission->chooseEduc($this->input->post('inputFeduc'), $father_id);
             
             $mother = array(
                        'lastname'         => $this->input->post('inputMLName'),
                        'firstname'        => $this->input->post('inputMother'),
                        'middlename'       => $this->input->post('inputMMName'),
                        'add_id'           => $address_id,
                        'sex'              => 'Female',
                        'nationality'      => $this->input->post('inputNationality'),     
                        'account_type'     => 4,
                    );
             
             $mother_id = $processAdmission->saveProfile($mother);
             
             $processAdmission->setContacts($this->input->post('inputM_num'), $this->input->post('inputPEmail'), $mother_id);

            $processAdmission->chooseOcc($this->input->post('inputM_occ'), $mother_id);

            $processAdmission->chooseEduc($this->input->post('inputMeduc'), $mother_id);
             
             $processAdmission->setParentsPro($profile_id, $father_id, $mother_id);
             
            
            }
            
        }
       //Medical information
       $this->registrar_model->saveMed($this->input->post('inputBType'), 
       $this->input->post('inputAllergies'), 
       $this->input->post('inputOtherMedInfo'), 
       $this->input->post('inputFPhy'), 
       $this->input->post('height'), 
       $this->input->post('weight'), 
       $profile_id );
         ?>
            <script type="text/javascript">
                   alert("Student Information Saved")
                   var answer = confirm("do you want to admit more students?")

                   if(answer==true){

                       document.location="<?php echo base_url();?>registrar/admission"
                   }else{

                       document.location="<?php echo base_url();?>main/dashboard"
                   }
             </script>         
       <?php

    }
    
    public function setBirthdate($date, $id, $column)
    {
        $this->registrar_model->setDate($date, $id, $column);
    }
        
    function getSectionByGL($section)
    {
        $section = $this->registrar_model->getSectionByLevel($section);
        ?>
             <option value="0">Select Section</option>
        <?php     
        foreach($section->result() as $row)
             {
        ?>                                
            <option sec="<?php echo $row->section ?>" value="<?php echo $row->section_id ?>"><?php echo $row->section ?></option>
        <?php
             }
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
        
        $this->registrar_model->saveNewValue($table, $nValue);
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
        $section = $this->registrar_model->getSectionByLevel($grade_id);
        return $section;
        
    }
    
    function getAllSection()
    {
        $section = $this->registrar_model->getAllSection();
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
                $data['modules'] = 'registrar';
                echo Modules::run('templates/main_content', $data);	
             }
    }
        
   public function getLateEnrolleesByGender($sex)
   {
       $lateEnrollee = $this->get_registrar_model->getLateEnrolleesByGender($sex);
       return $lateEnrollee;
   }
   
   public function getStudentStatus($status, $sex, $month=Null, $section_id=NULL)
   {
       $studentStatus = $this->get_registrar_model->getStudentStatus($status, $sex, $month, $section_id);
       return $studentStatus;
   }
   
   public function editAddressInfo()
   {
       //$processAdmission = Modules::load('registrar/registrardbprocess/');
       $address_id = $this->input->post('address_id');
       $street = $this->input->post('street');
       $barangay = $this->input->post('barangay');
       $city = $this->input->post('city');
       $province = $this->input->post('province');
       $zip_code = $this->input->post('zip_code');
       
       $barangay_id = $this->processAdmission->setBarangay($barangay);
        
        $add = array(
            'street'                => $street,
            'barangay_id'              => $barangay_id,
            'city_id'                  => $city,
            'province_id'              => $province,
            'country'               => 'Philippines',
            'zip_code'              => $zip_code,
        );
       
       $updateBasicInfo = $this->registrar_model->editBasicInfo($add, $address_id, 'profile_address_info', 'address_id');
       
       echo $updateBasicInfo->street.', '.$updateBasicInfo->barangay.', '.$updateBasicInfo->mun_city.' '.$updateBasicInfo->province.', '.$updateBasicInfo->zip_code;
   }
   
   public function editBasicInfo()
   {
       $rowid = $this->input->post('rowid');
       $firstname = $this->input->post('firstname');
       $lastname = $this->input->post('lastname');
       $middlename = $this->input->post('middlename');
       
       $details = array(
         'firstname' => $firstname,  
         'middlename' => $middlename,  
         'lastname' => $lastname,  
       );
       
       $updateBasicInfo = $this->registrar_model->editBasicInfo($details, $rowid, 'profile', 'user_id');
       
       echo $updateBasicInfo->firstname.' '.$updateBasicInfo->lastname;
   }
   
   public function editStudentInfo($st_id, $data)
   {
       $update = $this->registrar_model->editStudentInfo($st_id, $data);
       return;
   }


   function parentOveride()
   {
//       $result = $this->registrar_model->parentOveride();
//       echo $result.' data has been updated. Parent Overide Successful';
       $remarks = $this->registrar_model->editRemarks();
       echo $remarks;
   }
   
   
   
}

?>
