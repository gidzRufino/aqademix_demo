<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registerdbprocess
 *
 * @author genesis
 */
class registrardbprocess extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('registrar_model');
        $this->load->model('get_registrar_model');
    }
    
    
    function setBdate($date, $profile_id, $column)
    {
        $this->registrar_model->setDate($date, $profile_id, 'bdate_id');
        return;
    }
    
         
    function setReligion($religion)
    {
        $rel_id = $this->registrar_model->saveReligion($religion);
        return $rel_id;
    }
 
    function saveProfile($items, $userID=NULL, $school_year=NULL)
    {
        $profile_id = $this->registrar_model->saveProfile($items, $userID, $school_year);
        return $profile_id;
    }
    
    function setStudInfo($st_id, $profile_id, $section, $grade_level, $motherTongue, $en_date, $school_year, $school_last, $address_school_last, $lrn=NULL)
    {
        $this->registrar_model->setStudInfo($st_id, $profile_id, $section,  $grade_level, $motherTongue, $en_date, $school_year, $school_last, $address_school_last, $lrn);
    }
    
    function setCollegeInfo($st_id, $profile_id, $course, $year_level, $en_date, $school_year, $semester, $school_last, $address_school_last)
    {
          $this->registrar_model->setCollegeInfo($st_id, $profile_id, $course, $year_level, $en_date, $school_year, $semester, $school_last, $address_school_last);
    }
    
    function setBarangay($barangay, $school_year)
    {
        $barangay_id = $this->registrar_model->setBarangay($barangay, $school_year);
        return $barangay_id;
    }
    
    function setCity($city, $school_year)
    {
        $city_id = $this->registrar_model->setCity($city, $school_year);
        return $city_id;
    }
    
    function setAddress($add, $st_id, $school_year ) 
    {
        $st_add = $this->registrar_model->setAddress($add, $school_year);
        $this->registrar_model->setUpdateAddress($st_add, $st_id, $school_year);   
        
        return $st_add;
    }
    
    function setOfficeAddress($add, $school_year) 
    {
        $st_add = $this->registrar_model->setAddress($add, $school_year);  
        
        return $st_add;
    }
    
    function saveContacts()
    {
        $user_id = $this->input->post('user_id');
        $mobile = $this->input->post('mobile_no');
        $column = $this->input->post('column');
        $contact_id = $this->registrar_model->saveContacts($user_id, $mobile, $column);
        echo $contact_id;
    }
    
    function setContacts($phone, $email, $user_id, $school_year = NULL) {
//      $st_con = $this->registrar_model->setContacts($phone, $email, $school_year, $user_id);
        $this->registrar_model->setContacts($phone, $email, $school_year, $user_id);
        $this->registrar_model->setUpdateContact($user_id);

        return $user_id;
    }
    
    function updateContact($con_id, $user_id, $school_year=NULL){
        $this->registrar_model->setUpdateContact($con_id, $user_id, $school_year);
        return;
    }
    
    function saveParentsPro($profile_id, $school_year)
    {
        $array = array(
           'parent_id' => $profile_id,
           'father_id' => $profile_id+1,
           'mother_id' => $profile_id+2,
           'guardian' => 0,
           'relationship' => '',
           'f_office_name' => '',
           'f_office_address_id' => 0,
           'm_office_name' => '',
           'm_office_address_id' => 0,
           'ice_name' => '',
           'ice_contact' => '',
        );
        $parents = $this->registrar_model->setParentsPro($array, $school_year);
        //$this->registrar_model->updateParentPro($parents,$profile_id);
        return $profile_id;
    }
    
    function updateParentsPro($parent_id, $id, $office="", $address=0, $option)
    {
        if($option=='f'):
            $fm = 'father';
        else:
            $fm = 'mother';
        endif;
        $data = array(
             $fm.'_id' => $id,
             $option.'_office_name' => $office,
             $option.'_office_address_id' => $address
        );
        
        $this->registrar_model->updateParents($parent_id, $data);
    }
                          
    function setParentsPro($profile_id, $father_id = 0, $mother_id = 0, $f_office_name='', $f_office_address_id=0,$m_office_name='', $m_office_address_id=0, $guardian=0, $relationship = NULL, $person_ice = NULL, $person_contact_ice = NULL)
    {
       $array = array(
           'parent_id'  => $profile_id,
           'father_id' => $father_id,
           'mother_id' => $mother_id,
           'guardian' => $guardian,
           'relationship' => $relationship,
           'f_office_name' => $f_office_name,
           'f_office_address_id' => $f_office_address_id,
           'm_office_name' => $m_office_name,
           'm_office_address_id' => $m_office_address_id,
       ) ;
       $parents = $this->registrar_model->setParentsPro($array);
       //$this->registrar_model->updateParentPro($parents,$profile_id );
       return $parents;
       
    }
    
    function importParentsPro($profile_id, $father_id = 0, $mother_id = 0, $guardian = 0)
    {
        $array = array(
           'parent_id'  => $profile_id,
           'father_id' => $father_id,
           'mother_id' => $mother_id,
           'guardian' => ($guardian==0?0:$guardian),
           'relationship' => '',
           'f_office_name' => '',
           'f_office_address_id' => '',
           'm_office_name' => '',
           'm_office_address_id' => '',
       ) ;
        $parents = $this->registrar_model->setParentsPro($array);
        //$this->updateImportedParents($profile_id,$parents);
        return $parents;
    }
    
    function updateImportedParents($profile_id, $parent_id)
    {
        $this->db->where('user_id', $profile_id);
        $this->db->update('profile_students', array('parent_id' => $parent_id));
        return;
    }
    
    function updateOcc($occ_id, $st_id)
    {
        $this->registrar_model->setUpdateOccupation($occ_id, $st_id);
    }
    
    function chooseOcc($occ, $st_id,$sy)
    {
      $this->registrar_model->chooseOcc($occ, $st_id,$sy);
          
       
    }
    
    function chooseEduc($educ, $st_id)
    {

      $this->registrar_model->chooseEduc($educ, $st_id);

    }
    
    function getSectionById($id)
    {
        $section = $this->get_registrar_model->getSectionById($id);
        return $section->section;
        
    }
    
    function saveMed($btype, $al, $others, $phy, $h, $w, $user_id)
    {
        $this->registrar_model->saveMed($btype, $al, $others, $phy, $h, $w, $user_id);
    }
    
    function updateBdate($cal_id, $id, $type)
    {
        $this->registrar_model->setUpdateDate($cal_id, $id, $type);
    }
    
   
    
}

