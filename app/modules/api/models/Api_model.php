<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class api_model extends CI_Model {
    
    
    function getSingleStudent($id, $year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->select('profile.user_id as u_id');
        $this->db->select('profile_students.user_id as us_id');
        $this->db->select('profile_students.parent_id as pid');
        $this->db->select('profile_students_admission.school_year as sy');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_address_info', 'profile.add_id  = profile_address_info.address_id', 'left');
        $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'inner');
        $this->db->join('barangay', 'profile_address_info.barangay_id  = barangay.barangay_id', 'left');
        $this->db->join('cities', 'profile_address_info.city_id  = cities.id', 'left');
        $this->db->join('provinces', 'profile_address_info.province_id  = provinces.id', 'left'); 
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->join('calendar', 'profile.bdate_id = calendar.cal_id', 'left');
        $this->db->join('mother_tongue', 'profile_students.mother_tongue_id = mother_tongue.mt_id', 'left');
        $this->db->join('ethnic_group', 'profile.ethnic_group_id = ethnic_group.eg_id', 'left');
        $this->db->join('religion', 'profile.rel_id = religion.rel_id', 'left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id', 'left');
        $this->db->join('profile_medical', 'profile.user_id = profile_medical.user_id', 'left');
        if($year==NULL):
            $this->db->where('profile_students_admission.school_year', $this->session->userdata('school_year'));
        else:
            $this->db->where('profile_students_admission.school_year', $year);

        endif;
        $this->db->where('profile_students.st_id', $id);
        $this->db->or_where('profile_students.user_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getOut($key)
    {
        $this->db->where('id', $key);
        $q = $this->db->get('session');
        if($q->num_rows()>0):
            $this->db->where('id', $key);
            if($this->db->delete('session')):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;
    }
    function verifyKey($key)
    {
        $this->db->where('id', $key);
        $q = $this->db->get('session');
        if($q->num_rows()>0):
            $this->db->where('id', $key);
            $q1 = $this->db->get('session');
            $json = array(
                'status' => TRUE
            );
        else:
            $json = array(
                'status' => FALSE
            );
        endif;
        
            return json_encode($json);
    }
    
    function getVerified($data, $sy=NULL)
    {
        //$this->db = $this->eskwela->db(($sy==NULL?$this->session->userdata('school_year'):$sy));
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
                    $this->db->where('account_type', 4);
                    $p = $this->db->get('profile');
                    $parent_id = $this->getParent($p->row()->user_id, $sy);
                    if(!$parent_id):
                        $this->db->where('contact_id', $q_rows->contact_id);
                        $this->db->delete('profile_contact_details');
                        continue;
                    else:
                        return json_encode(array('status'=>TRUE, 'parent_id' =>  $p->row()->user_id));
                        break;
                    endif;
                }
            else:
                $this->db->where('contact_id', $con_rows->contact_id);
                $this->db->where('account_type', 4);
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
        //$this->db = $this->eskwela->db($sy);
        if($this->db):
            $this->db->where('father_id', $user_id);
            $this->db->or_where('mother_id', $user_id);
            $query = $this->db->get('profile_parents');
            if($query->num_rows()>0):
                return $query->row()->parent_id;
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;    
        
    }

        
    function getRegister($uid,$data)
    {
        $this->db->select('u_id');
        $this->db->from('user_accounts');
        $this->db->where('u_id', $uid);
        
        $query = $this->db->get();
        $num_rows= $query->num_rows();
        
        if($num_rows > 0)
        { 
            return json_encode(array('status'=>FALSE));
        }else { 
            $this->db->insert('user_accounts', $data);  
            return json_encode(array('status'=>TRUE, 'id'=> $this->db->insert_id()));
        }
        
    }
    
    function getInside($uname, $pass, $token)
    {
        $this->db->where('uname', $uname);
        $this->db->where('pword', $pass);
        $query = $this->db->get('user_accounts');
        $item = array(
                       'islogin' => 1
                    );
        $this->db->where('uname', $uname);
        $this->db->update('user_accounts', $item); 

        if($query->num_rows()> 0)
        {
           return json_encode(array('status' => TRUE, 'parent_id' => $query->row()->u_id, 'row' => $query->row()));
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
}
