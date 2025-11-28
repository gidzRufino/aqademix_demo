<?php
class messaging_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        
    }
    
    function saveAnnouncement($details)
    {
        $this->db->insert('ticker', $details);
        return;
    }
    
    function getAnnouncement($status)
    {
        $this->db->where('active', $status);
        $this->db->order_by('timestamp', 'ASC');
        $query = $this->db->get('ticker');
        return $query;
    }
    
    function updateAnnouncement($id, $details)
    {
        $this->db->where('id', $id);
        $this->db->update('ticker', $details);
        return;
    }
    
    function deleteAnnouncement($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('ticker');
    }
    function saveMessage($sendto, $sendFrom, $Message, $parentMsgId)
    {
        
        $data = array(
            'msg_from' => $sendFrom,
            'msg_to' => $sendto,
            'msg_content' => $Message,
            'msg_read' => 0,
            'parent_msg_id' => $parentMsgId,
        );
        $this->db->insert('messaging', $data);
        if($parentMsgId==0)
        {
            $pMId = array(
                'parent_msg_id' => $this->db->insert_id()
            );
            
        $this->db->where('msg_id', $this->db->insert_id()); 
        $this->db->update('messaging', $pMId);
            return;
        }else{
            return;
        }
    }
    
    function getMessages($from) //this will display in my Messages
    {
        $this->db->select('msg_from, msg_to');
        $this->db->from('messaging');
        $this->db->where('msg_from', $from);
        $this->db->order_by('msg_id', 'desc');
        $this->db->limit('1');
        
        $query = $this->db->get();
        if($query->num_rows()>0){
            $msgFrom = $query->row();
            
            $this->db->select('*');
            $this->db->from('messaging');
            $this->db->join('profile', 'profile.user_id = messaging.msg_to', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('msg_from', $from);
            //$this->db->where('msg_to', $from);
            $this->db->group_by('msg_to');
            $this->db->order_by('msg_id', 'desc');
        }else{
            $this->db->select('*');
            $this->db->from('messaging');
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            //$this->db->where('msg_from', $from);
            $this->db->where('msg_to', $from);
           // $this->db->group_by('msg_to');
        }
        
        $query = $this->db->get();
        $data = array(
            'num_rows' => $query->num_rows(),
            'result' => $query->result(),
        );
        
        return $data;
    }
    
    function getIndividualMessages($from)
    {
        $this->db->select('msg_from, msg_to, parent_msg_id');
        $this->db->from('messaging');
        $this->db->where('msg_from', $from);
        $this->db->order_by('msg_id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $msgFrom = $query->row();
            $this->db->select('*');
            $this->db->from('messaging');        
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('parent_msg_id', $msgFrom->parent_msg_id);  
            $this->db->order_by('msg_id', 'asc');
        }else{   
            $this->db->select('*');
            $this->db->from('messaging');        
            $this->db->join('profile', 'profile.user_id = messaging.msg_from', 'left');
            $this->db->join('profile_info', 'profile_info.u_id = profile.user_id', 'left');
            $this->db->where('parent_msg_id', $msgFrom->parent_msg_id); 
        //$this->db->or_where('msg_from', $msgFrom->msg_to);
        }
//            
        

        $query2 = $this->db->get();
        
        $data = array(
            'reply' => $msgFrom->msg_from,
            'sent' => $query2->result(),
            'parent_msg_id'=>$msgFrom->parent_msg_id
        );
        
        return $data;

    }
    
    function getAllNum()
    {
        $this->db->group_by('cd_mobile');
        $query = $this->db->get('contact_details');
        
        return $query->result();
        
    }

}