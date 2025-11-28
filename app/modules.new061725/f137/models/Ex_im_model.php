<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ex_im_model
 *
 * @author genesis
 */
class ex_im_model extends CI_Model {
    //put your code here
    
    function getExpColumns($section_id)
    {
        $this->db->select('profile_students.st_id as ID_Number');
        $this->db->select('profile_students.section_id as sec_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('section_id');
        $this->db->from('profile');
        $this->db->join('profile_students', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where('profile_students.section_id', $section_id);
        $query = $this->db->get();
        return $query;
    }
}

?>
