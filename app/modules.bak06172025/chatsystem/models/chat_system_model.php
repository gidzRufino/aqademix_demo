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
    
    function getPreviousChat($from, $to)
    {
        $this->db->where('chat_from', $from);
        $this->db->where('chat_to', $to);
        $query = $this->db->get('chat');
        
        if($query->num_rows > 0):
            $this->db->where('relation', $query->row()->relation);
            $this->db->order_by('sent', 'ASC');
            $q = $this->db->get('chat');
        else:
           $this->db->where('chat_from', $to);
            $this->db->where('chat_to', $from);
            $query = $this->db->get('chat'); 
            if($query->num_rows > 0):
                $this->db->where('relation', $query->row()->relation);
                $this->db->order_by('sent', 'ASC');
                $q = $this->db->get('chat');
            else:
                $q = FALSE;
            endif;
        endif;
        
        return $q;
    }
    
    function readMessage($details, $id, $pChat_id)
    {
        $this->db->where('chat_to', $id);
        $this->db->where('relation', $pChat_id);
        $this->db->update('chat', $details);
        return;
        
    }
    function checkForNewMessage($user_id)
    {
        $this->db->where('chat_to', $user_id);
        $this->db->where('recd', 0);
        $query = $this->db->get('chat');
        
        if($query->num_rows > 0):
            $this->db->where('relation', $query->row()->relation);
            $this->db->order_by('sent', 'ASC');
            $q = $this->db->get('chat');
        endif;
        
        return $q;
    }
    function countNewMessage($user_id)
    {   
        $this->db->select('*');
        $this->db->from('chat');
        $this->db->join('profile', 'profile.user_id = chat.chat_from', 'left');
        $this->db->where('chat_to', $user_id);
        $this->db->where('recd', 0);
        $this->db->group_by('chat_from');
        $query = $this->db->get();
        return $query;
    }
    
    function saveChat($details, $from, $to, $pChat_id)
    {
        $this->db->insert('chat', $details); 
        $this->db->where('id', $this->db->insert_id());
        if($pChat_id==0):
            $this->db->update('chat', array('relation'=>$from.$to));
        else:
            $this->db->update('chat', array('relation'=>$pChat_id));
        endif;
        
        return;
    }
    
    function getChats($username=NULL)
    {
        if($username!=NULL):
            $this->db->where('chat_to', $username);
            //$this->db->where('recd', 0);
        endif;
        $this->db->order_by('sent', 'DESC');
        $query = $this->db->get('chat');
       
        
        return $query;
    }
    
    function updateChat($user_id, $details)
    {
        $this->db->where('chat_to', $user_id);
        $this->db->where('recd', 0);
        $this->db->update('chat', $details);
        return;
    }
}

?>
