<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of nav_model
 *
 * @author genesis
 */
class nav_model extends CI_Model {
    
    function saveMenu($details, $id)
    {
        if($id!=''):
            $this->db->where('menu_id', $id);
            if($this->db->update('menu', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            if($this->db->insert('menu', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
            
    function getMenuById($id)
    {
        $this->db->where('menu_id', $id);
        $q = $this->db->get('menu');
        return $q;
    }
    function getMenu($position_id){
        $this->db->select('*');
        $this->db->from('user_groups');
        $this->db->where('position_id', $position_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getPersonalMenu($userId, $menu_id){
        $this->db->select('menu_access');
        $this->db->from('profile_info');
        $this->db->where('u_id', $userId); 
        $this->db->like('menu_access', $menu_id); 
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if($num_rows>0){
            return true;
        }else{
            return false;
        }
    }
    
    function getMenuAccess($id){
        
        $sub = 'submenu';
        $this->db->select('*');
        $this->db->from('menu');
       // $this->db->where('menu_parent', '0');
        $this->db->where('menu_id', $id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function getSubMenu($id, $menu_id){
        
        $this->db->select('*');
        $this->db->from('menu');
        $this->db->where('menu_parent', $id);
        $this->db->where('menu_id', $menu_id);
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if($num_rows>0){
            return $query->row();
        }else{
            return 0;
        }
        
    }
    
    //This is for dashboard icons
    
    function getIcons($position_id){
        $this->db->select('*');
        $this->db->from('user_groups');
        $this->db->where('position_id', $position_id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function getDashAccess($id){
        
        $this->db->select('*');
        $this->db->from('dashboard_access');
        $this->db->where('dash_id', $id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function getDashboardList(){
        $this->db->select('*');
        $this->db->from('dashboard_access');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getMenuList(){
        $this->db->select('*');
        $this->db->from('menu');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getMenuDashAccess($position_id, $menu_id, $type){
        $this->db->select($type.'_access');
        $this->db->from('user_groups');
        $this->db->where('position_id', $position_id); 
        $this->db->like($type.'_access', $menu_id, 'both'); 
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if($num_rows>0){
            return true;
        }else{
            return false;
        }
    }
    
    function getPositionAccess($position_id){
        $this->db->select('*');
        $this->db->from('user_groups');
        $this->db->where('position_id', $position_id);  
        $query = $this->db->get();
        return $query->row();
    }
    
    function getMenuLink($link) {
        $this->db->where('menu_link', $link);
        return $this->db->get('menu')->row();
    }
    
    
}

?>
