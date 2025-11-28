<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cueingsystem_model
 *
 * @author genesis
 */
class cueingsystem_model extends CI_Model {
    //put your code here
    
    public function checkStatus($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('cue_station');
        if($query->num_rows()>0):
            return $query;
        else:
            return FALSE;
        
        endif;
    }
    
    public function getStation()
    {
        $this->db->select('*');
        $this->db->from('cue_station');
        $this->db->where('online', '0');
        $query = $this->db->get();
        return $query;
    }
    
    public function checkInStation($station, $data, $column)
    {
        $this->db->where($column, $station);
        $this->db->update('cue_station', $data);
        return;
    }
    
    public function checkOnlineStation()
    {
        $this->db->select('*');
        $this->db->from('cue_station');
        $this->db->where('online', '1');
        $query = $this->db->get();
        return $query;
    }
    
    function checkCue($dept_id, $station_id)
    {
        $this->db->select('*');
        $this->db->from('cue_count');
        $this->db->where('dept_id', $dept_id);
        $this->db->where('cue_status', 0);
        if($station_id!=NULL):
           $this->db->where('station_id', $station_id); 
        endif;
        $this->db->order_by('cue_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function serve($cue_number, $details, $status, $dept_id)
    {
        $this->db->where('cue_number', $cue_number);
        $this->db->update('cue_count', $details);
        
        if($status):
            return TRUE; 
        else:
            $next = $this->checkCue($dept_id, NULL);
            return $next->row();
        endif;
    }
    
    function checkCueNumber($cue_number, $station_id)
    {
        $this->db->where('station_id', $station_id);
        $this->db->where('cue_number', $cue_number);
        $query = $this->db->get('cue_count');
        if($query->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }


    function checkWhosNext($dept_id, $station_id = NULL)
    {
        $this->db->select('*');
        $this->db->from('cue_count');
        $this->db->where('cue_status', 0);
        if($station_id!=NULL):
           $this->db->where('station_id', $station_id); 
        else:
           $this->db->where('station_id', 0); 
        endif;
        $this->db->where('dept_id', $dept_id);
        $this->db->order_by('cue_id', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }
}

?>
