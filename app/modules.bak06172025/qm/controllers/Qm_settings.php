<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class Qm_settings extends MX_Controller {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('qm_settings_model');
    	
    }
    function updateModuleToAccessdata()
    {
     $id_user=$this->input->post('id_user');   
     $id_mod =$this->input->post('id_mod'); 
     echo $this->qm_settings_model->updateModuleToAccess($id_mod,$id_user);
    }
    function post($name)
    {
        return $this->input->post($name);
    }
    function deleteskillsdata()
    {
        $skill_id= $this->input->post('skill_id');
        echo $this->qm_settings_model->deleteskills($skill_id);
    }
    function deleteQuizTypedata()
    {
    $id= $this->input->post('qt_id');
    echo $this->qm_settings_model->deleteQuiztype($id);
    }
    function addQuiztypedata()
    {
      $qtype=array('qm_type' =>   $this->input->post('qtname'));
      echo $this->qm_settings_model->addQuiztype($qtype);
    }
     function addSkilldata()
    {
      $skills=array('qm_skills' =>   $this->input->post('skills'));
     // echo $this->qm_settings_model->addSkill($skills);
    alert($skills);
    }
    function index()
    {  
         $data['select_Access']=$this->qm_settings_model->selectAccesslevel();    
        $data['disp_user']=$this->qm_settings_model->selectusers();
        $data['skills']=$this->qm_settings_model->selectSkills();
        $data['QuizType']=$this->qm_settings_model->selectQuiztype();
        $data['modules'] = 'qm';
        $data['main_content'] = 'settings/default';
        echo Modules::run('templates/main_content', $data);
    }
    
   
    
}
