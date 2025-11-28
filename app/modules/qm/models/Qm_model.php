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
class Qm_model extends CI_Model {
    //put your code here
    function getSkillsList()
    {
        $q = $this->db->get('qm_skills');
        return $q->result();
    }
    
    function getSkills($qq_id)
    {
        $this->db->where('qq_id', $qq_id);
        $q = $this->db->get('qm_qq');
        return $q->row();
    }
    
    function getTags($qq_id)
    {
        $this->db->where('qci_qq_id', $qq_id);
        $q = $this->db->get('qm_cat_items');
        return $q->row();
    }
    
    function saveSkills($q_id, $details)
    {
        $this->db->where('qq_id', $q_id);
        $this->db->update('qm_qq', $details);
    }
    
    function saveTags($q_id, $details)
    {
        $this->db->where('qci_qq_id', $q_id);
        $q = $this->db->get('qm_cat_items');
        if($q->num_rows()>0):
            $this->db->where('qci_qq_id', $q_id);
            $this->db->update('qm_cat_items', $details);
        else:
            $this->db->insert('qm_cat_items', $details);
        endif;
    }
    
    function getAccessLevel($user_id)
    {
        $this->db->where('qm_ua_user_id', $user_id);
        $q = $this->db->get('qm_user_access');
        if(!empty($q->row())):
            return $q->row()->qm_ua_access_id;
        else:
            return 4;
        endif;
    }
    
    function getAllQuestions($cat)
    {
        $q = $this->db->get('qm_qq');
        return $q->result();
    }
    
    function publishQuiz($data, $id)
    {
        $this->db->where('qi_id', $id);
        $this->db->update('qm_quiz_items', $data);
        return;
    }
    
    function checkAnswer($qq_id, $ans)
    {
        $this->db->where('qs_qq_id', $qq_id);
        $this->db->where('ans_flag', 1);
        $this->db->where('LOWER(qs_selection)', strtolower($ans));
        $q = $this->db->get('qm_quiz_selection');
        if($q->num_rows()>0):
            $result = array('result'=> TRUE, 'id'=> $qq_id);
        else:
            $result = array('result'=> FALSE, 'id'=> $qq_id);
        endif;
        return json_encode($result);
    }
    
    function getQuizAnswer($qq_id, $flag)
    {
        $this->db->where('qs_qq_id', $qq_id);
        $this->db->where('ans_flag', $flag);
        $q = $this->db->get('qm_quiz_selection');
        return $q;
    }
            
    function getQuizQuestions($item_id)
    {
        $this->db->where('qq_id', $item_id);
        $q = $this->db->get('qm_qq');
        return $q->row();
    }
    
    function saveAnswer($answer)
    {
        $this->db->insert('qm_quiz_selection',$answer);
        return;
    }
    
    function updateQuizItems($qi_id, $details)
    {
        $this->db->where('qi_id', $qi_id);
        $this->db->update('qm_quiz_items', $details);
        return;
    }
    function checkQI($id)
    {
        $this->db->select('qi_id');
        $this->db->select('qi_qq_ids');
        $this->db->from('qm_quiz_items');
        $this->db->where('qi_id', $id);
        $q = $this->db->get();
        if($q->num_rows()>0):
            $result = array('exist'=>TRUE, 'qq_ids'=>$q->row()->qi_qq_ids);
        else:
            $result = array('exist'=>FALSE);
        endif;
        return json_encode($result);
            
    }

    function addQuestions($array)
    {
        $this->db->insert('qm_qq', $array);
        return $this->db->insert_id();
    }
    function getSpecificQuiz($item_id)
    {
        $this->db->where('qi_id', $item_id);
        $q = $this->db->get('qm_quiz_items');
        return $q->row();
    }
    
    function getQuizList($id, $option)
    {
        
        if($option!=NULL):
            $this->db->where('qi_is_public', $option);
        else:
            $this->db->where('qi_created_by', $id);
        endif;
        $q = $this->db->get('qm_quiz_items');
        return $q;
    }
    function getQuizItem($id)
    {
        $this->db->where('qi_created_by', $id);
        $this->db->order_by('qi_date_created', 'ASC');
        $q = $this->db->get('qm_quiz_items');
        return $q->result();
    }
    
    function saveQuizItem($data)
    {
        if($this->db->insert('qm_quiz_items', $data)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function saveQCI($data)
    {
        $this->db->insert('qm_cat_items', $data);
        return $this->db->insert_id();
    }
    
    function saveCategory($cat, $data)
    {
        $this->db->where('qm_category', $cat);
        $q = $this->db->get('qm_cat');
        if($q->num_rows()==0):
            $this->db->insert('qm_cat', $data);
            return $this->db->insert_id();
        endif;
    }
    function getQuizCat($id = NULL)
    {
        if($id==NULL):
            $q = $this->db->get('qm_cat');
            return $q->result();
        else:
            $this->db->where('qm_cat_id', $id);
            $q = $this->db->get('qm_cat');
            return $q->row();
        endif;
        
    }
    
    function getQuizType()
    {
        $q = $this->db->get('qm_type');
        return $q->result();
    }
    
    
}
