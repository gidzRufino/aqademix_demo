<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class Login_model extends CI_Model {
    
    function fetch_ads()
    {
        $this->db->select('*');
        $this->db->from('ads');
        $this->db->where('ad_active', 1);
        $query = $this->db->get();
        return $query;
    }
    
    function checkIn($status)
    {
        if($status==NULL):
            $status = 1;
        endif;
        $this->db->update('settings' , array('cu_status'=>1, 'last_ping'=>  date('Y-m-d G:i:s')));
        return true;
    }
    
    function getInside($uname, $pass)
    {
        $this->db->where('uname', $uname);
        $this->db->where('pword', $pass);
        $query = $this->db->get('user_accounts');
        $item = array(
                       'islogin' => 1,
                    );
        $this->db->where('uname', $uname);
        $this->db->update('user_accounts', $item); 

        if($query->num_rows()> 0)
        {
            return $query->row();
        }
		
    }
    
    function logout($uname)
    {
        $item = array(
                       'islogin' => 0,
                    );
        $this->db->where('uname', $uname);
        $this->db->update('user_accounts', $item); 
    }
    
    function reVerify($number)
    {
        $this->db->where('cd_mobile', $number);
        $this->db->order_by('contact_id','ASC');
        $this->db->limit(1);
        $q=$this->db->get('profile_contact_details');
        $num_rows = $q->num_rows();
        $con_rows = $q->row();
        return json_encode(array('rows'=>$con_rows, 'num_rows'=>$num_rows));
    }
    
    function getVerified($data, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('cd_mobile', $data);
        $this->db->order_by('contact_id','ASC');
        $q=$this->db->get('profile_contact_details');
        $num_rows = $q->num_rows();
        $con_rows = $q->row();
        if($num_rows > 0):
            if($num_rows>1):
                foreach($q->result() as $q_rows)
                {
                    $this->db->where('contact_id', $q_rows->contact_id);
                    $this->db->where('account_type', 5);
                    $p = $this->db->get('profile');
                    $parent_id = $this->getParent($p->row()->user_id, $sy);
                    if(!$parent_id):
                        $this->db->where('contact_id', $q_rows->contact_id);
                        $this->db->delete('profile_contact_details');
                        continue;
                    else:
                        return json_encode(array('status'=>TRUE, 'parent_id' =>  $parent_id));
                        break;
                    endif;
                }
            else:
                $this->db->where('contact_id', $con_rows->contact_id);
                $this->db->where('account_type', 5);
                $p = $this->db->get('profile');
                $parent_id = $this->getParent($p->row()->user_id, $sy);
                if(!$parent_id):
                    $school_year = $sy - 1;
                    $p_id = $this->getParent($p->row()->user_id, $school_year);
                    if(!$p_id):
                        return json_encode(array('status'=>FALSE, 'parent_id'=>  'n'));
                    else:
                        return json_encode(array('status'=>TRUE, 'parent_id'=>  $p_id));
                    endif;
                    return json_encode(array('status'=>FALSE, 'parent_id'=>  'in'));
                else:    
                    return json_encode(array('status'=>TRUE, 'parent_id'=>  $parent_id));
                endif;
            endif;
        else:
            return json_encode(array('status'=>FALSE, 'parent_id'=>  'n'));
        endif;
    }
    
    function getParent($user_id, $sy=NULL)
    {
        $this->db = $this->eskwela->db($sy);
        if($this->db) {
            $this->db->where('u_id', $user_id);
            $query = $this->db->get('profile_parent');

            if($query->num_rows() > 0) {
                return $query->row()->p_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
        // if($this->db):
        //     $this->db->where('father_id', $user_id);
        //     $this->db->or_where('mother_id', $user_id);
        //     $query = $this->db->get('profile_parents');
        //     if($query->num_rows()>0):
        //         return $query->row()->parent_id;
        //     else:
        //         return FALSE;
        //     endif;
        // else:
        //     return FALSE;
        // endif;    
        
    }
    
    function getRegister($uid,$data)
    {
        $this->db->select('u_id');
        $this->db->from('user_accounts');
        $this->db->where('u_id', $uid);
        
        $query = $this->db->get();
        $num_rows= $query->num_rows();
        
        if($num_rows> 0)
        { 
            return json_encode(array('status'=>FALSE));
        }else { 
            $this->db->insert('user_accounts', $data);  
            return json_encode(array('status'=>TRUE, 'id'=> $this->db->insert_id()));
        }
        
    }
}
