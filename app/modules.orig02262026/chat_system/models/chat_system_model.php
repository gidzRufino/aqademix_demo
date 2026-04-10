<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat_system_model
 *
 * @author genesis
 */
class Chat_system_model extends CI_Model {
    //put your code here
    
    
    function saveChat($details)
    {
        $this->db->insert('esk_chat', $details); 
        return;
    }
    
    function getChats($username)
    {
        $this->db->select('*');
        $this->db->from('esk_chat');
        $this->db->join('stg_profile', 'stg_profile.user_id = esk_chat.from', 'left');
        $this->db->where('to', $username);
        $this->db->where('recd', 0);
        
        $query = $this->db->get();
        return $query;
    }
    
    function updateChat($user_id, $details)
    {
        $this->db->where('to', $user_id);
        $this->db->where('recd', 0);
        $this->db->update('esk_chat', $details);
        return;
    }
}

?>
