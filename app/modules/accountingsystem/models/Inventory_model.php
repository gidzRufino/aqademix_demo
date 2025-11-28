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
class inventory_model extends CI_Model {
    //put your code here
    
    
    function addItem($details)
    {
        if($this->db->insert('as_inv_items', $details)):
            $json = json_encode(array('status'=> TRUE));
        else:
            $json = json_encode(array('status'=> FALSE));
        endif;
        
        return json_decode($json);
    }
    
    function addCategory($details)
    {
        if($this->db->insert('as_inv_category', $details)):
            $json = json_encode(array('status'=> TRUE));
        else:
            $json = json_encode(array('status'=> FALSE));
        endif;
        
        return json_decode($json);
    }
    
    function getInventoryItems($item_id)
    {
        ($item_id!=NULL?$this->db->where('inv_id', $item_id):'');
        $this->db->join('as_inv_category', 'as_inv_items.inv_cat_id = as_inv_category.cat_id','left');
        $q = $this->db->get('as_inv_items');
        $details = ($item_id!=NULL?$q->row():$q->result());
        return $details;
    }
    
    function getInventoryCategory($cat_id)
    {
        ($cat_id!=NULL?$this->db->where('cat_id', $cat_id):'');
        $q = $this->db->get('as_inv_category');
        $details = ($cat_id!=NULL?$q->row():$q->result());
        return $details;
    }
    
}
