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
class Qm_settings_model extends CI_Model {
    //put your code here
    public function updateModuleToAccess($id_mod,$id_user)
    {
        $this->db->where('qm_ua_user_id',$id_user);
        $this->db->set('qm_ua_id',$id_mod);
        $this->db->update('esk_qm_user_access');
    }
    public function selectSkills()
    {
        $data=$this->db->get('esk_qm_skills');
        return $data->result();
    }
    public function selectusers()
    {
        $data=$this->db->get('esk_qm_user_access');
        return $data->result();
    }
    public function selectQuiztype()
    {
        $data=$this->db->get('esk_qm_type');
        return $data->result();
    }
     public function selectAccesslevel()
    {
        $data=$this->db->get('esk_qm_access_level');
        return $data->result();
    }
     public function addSkill($skills)
    {
       $this->db->insert('esk_qm_skills',$skills);
    }  
    public function addQuiztype($quiztp)
    {
       $this->db->insert('esk_qm_type',$quiztp);
    }  
    public function deleteQuizType($idquiz)
    {
        $this->db->where('qm_type_id',$idquiz);
        $this->db->delete('esk_qm_type');
    }
    public function deleteskills($idskills)
    {
        $this->db->where('qm_skills_id',$idskills);
        $this->db->delete('esk_qm_skills');
    }
}
