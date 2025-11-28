<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class Profile_model extends CI_Model {

   function getChildLinks($parent_id)
   {
       $this->db->where('u_id', $parent_id);
       $q = $this->db->get('user_accounts');
        if($q->num_rows()>0):
            return $q->row()->child_links;
        endif;
   }
}
