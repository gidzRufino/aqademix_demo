<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of academic_model
 *
 * @author genesis
 */
class customize_model extends CI_Model {
    //put your code here

    function getPreSkulInfo($stid){
        $this->db->where('st_id', $stid);
        return $this->db->get('gs_spr_preschool')->row();
    }
    
    function getPreSchoolSubj() {
        return $this->db->get('gs_preschool_subjs')->result();
    }

    function getSubjDetails($id) {
        $this->db->where('subjs_id', $id);
        return $this->db->get('gs_preschool_subjs_details')->result();
    }

    function updateLLCrate($stid, $rate, $d_id, $grading, $school_year = NULL) {
        $sy = ($school_year == NULL ? $this->session->school_year : $school_year);
        $this->db = $this->eskwela->db($sy);

        $this->db->where('st_id', $stid);
        $this->db->where('s_detail_id', $d_id);
        $this->db->where('grading', $grading);
        $this->db->where('sy', $sy);
        $q = $this->db->get('gs_preschool_llc_rating');

        if ($q->num_rows() > 0):
            $this->db->where('st_id', $stid);
            $this->db->where('s_detail_id', $d_id);
            $this->db->where('grading', $grading);
            $this->db->where('sy', $sy);
            $this->db->update('gs_preschool_llc_rating', array('rate' => $rate));
        else:
            $data = array(
                's_detail_id' => $d_id,
                'st_id' => $stid,
                'rate' => $rate,
                'grading' => $grading,
                'sy' => $sy
            );

            $this->db->insert('gs_preschool_llc_rating', $data);
        endif;
    }
    
    function getLLCrate($stid, $d_id, $grading, $school_year = NULL){
        $sy = ($school_year == NULL ? $this->session->school_year : $school_year);
        $this->db = $this->eskwela->db($sy);
        
        $this->db->where('st_id', $stid);
        $this->db->where('s_detail_id', $d_id);
        $this->db->where('grading', $grading);
        $this->db->where('sy', $sy);
        return $this->db->get('gs_preschool_llc_rating')->row();
    }

}

