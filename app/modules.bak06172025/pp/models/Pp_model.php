<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Pp_model extends CI_Model {
    
    function verifyChild($child, $mobile ,$sy, $parent_options = NULL)
    {
        if($parent_options==NULL):
            $parent = 'father_id';
        else:
            $parent = 'mother_id';
        endif;
       // $this->db = $this->eskwela->db($sy);
        if($this->db):
            $this->db->where('st_id', $child);
            $this->db->or_where('lrn', $child);
            $this->db->like('cd_mobile', $mobile, 'both');
            $this->db->join('profile_parents','profile_students.parent_id = profile_parents.parent_id', 'left');
            $this->db->join('profile', "profile_parents.father_id = profile.user_id", 'left');
            $this->db->join('profile_contact_details', 'profile.contact_id = profile_contact_details.contact_id', 'left');
            $f = $this->db->get('profile_students');
            if($f->num_rows()>0):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:    
            return FALSE;
        endif;
    }
    
    function getNumberOfStudents($child)
    {
        $childlinks = array($child);
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->where('profile_students.st_id', $childlinks);
        $this->db->where('profile_students_admission.school_year',  $this->session->userdata('school_year'));
        $this->db->order_by('profile_students_admission.grade_level_id', 'ASC');
        $query = $this->db->get();
        return $query;
    }
            
    function getStudent($pid)
    {
        $this->db->select('*');
        $this->db->select('profile_students.st_id as uid');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'profile_students_admission.section_id = section.section_id', 'left');
        $this->db->join('grade_level', 'profile_students_admission.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.parent_id', $pid);
        $this->db->where('profile_students_admission.school_year',  $this->session->userdata('school_year'));
        $this->db->order_by('profile_students_admission.grade_level_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
}

