<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opl_models
 *
 * @author genesisrufino
 */
class Opl_widgets_model extends CI_Model {
    //put your code here
    function mySubjects($user_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        $this->db->select('subjects.subject_id as sub_id');
        $this->db->from('faculty_assign');
        $this->db->join('subjects', 'subjects.subject_id = faculty_assign.subject_id', 'left');
        $this->db->join('grade_level', 'grade_level.grade_id = faculty_assign.grade_level_id', 'left');
        $this->db->join('section', 'section.section_id = faculty_assign.section_id', 'left');
        if($user_id!=NULL):
            $this->db->where('faculty_assign.faculty_id', $user_id);
        else:
        //$this->db->group_by('sub_id');
        endif;
        if($school_year!=NULL):
          $this->db->where('faculty_assign.school_year', $school_year);
        endif;
        $query = $this->db->get();
        return $query->result();
    }
}
