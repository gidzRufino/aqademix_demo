<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cc_model
 *
 * @author genesis
 */
class cc_model extends CI_Model {
    //put your code here
    
    function saveCoCurricular($details, $st_id, $grading, $school_year)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('grading', $grading);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_final_cc_involvement');
        if($q->num_rows()> 0):
            $this->db->where('st_id', $st_id);
            $this->db->where('grading', $grading);
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_final_cc_involvement', $details);
        else:
            $this->db->insert('gs_final_cc_involvement', $details);
        endif;
    }
    function saveTotalCC($st_id, $total, $grade_id)
    {
        $array = array(
            'to_st_id' => $st_id,
            'total' => $total,
            'grade_id' => $grade_id,
            'school_year' => $this->session->userdata('school_year')
        );
        
        $this->db->where('to_st_id', $st_id);
        $this->db->where('grade_id', $grade_id);
        $this->db->where('school_year',$this->session->userdata('school_year'));
        $q = $this->db->get('gs_cc_total');
        if($q->num_rows()> 0):   
            $this->db->where('to_st_id', $st_id);
            $this->db->where('grade_id', $grade_id);
            $this->db->where('school_year',$this->session->userdata('school_year'));
            $this->db->update('gs_cc_total', $array);
        else:
            $this->db->insert('gs_cc_total', $array);
        endif;
        $this->db->select('*');
        $this->db->from('gs_cc_total');
        $this->db->where('grade_id', $grade_id);
        $this->db->where('school_year',$this->session->userdata('school_year'));
        $this->db->order_by('total', 'desc');
        $query = $this->db->get();
        $i = 0;
        $c = 0;
        $finTotal = 0;
        foreach ($query->result() as $r):
            $i++;

            if($i>1):
                if($s1==$r->total):
                    $i = $i-1;
                endif;
            endif;
            
            $s = array(
                'rank' => $i,
                'weighted_rank' => $i*3
            );
            $this->db->where('tot_id', $r->tot_id);
            $this->db->update('gs_cc_total', $s);
            $s1 = $r->total;
        endforeach;
            $this->db->where('to_st_id', $st_id);
            $this->db->where('grade_id', $grade_id);
            $this->db->where('school_year',$this->session->userdata('school_year'));
            $return = $this->db->get('gs_cc_total');
        return $return->row();
    }
    
    function groupNames($section_id)
    {
        $this->db->select('gs_cc_involvement.st_id as stid');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('middlename');
        $this->db->select('grade_level_id');
        $this->db->from('gs_cc_involvement');
        $this->db->join('profile_students', 'gs_cc_involvement.st_id = profile_students.st_id','left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id','left');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->group_by('gs_cc_involvement.st_id');
        $this->db->where('profile_students_admission.section_id', $section_id);
        $q = $this->db->get();
        return $q->result();
    }
    function getCCRaw($st_id, $cat_id)
    {
        $this->db->select('gs_cc_involvement.st_id as stid');
        $this->db->select('gs_cc_level_part.points');
        $this->db->from('gs_cc_involvement');
        $this->db->join('profile_students', 'gs_cc_involvement.st_id = profile_students.st_id','left');
        $this->db->join('gs_cc_level_part', 'gs_cc_involvement.cc_level_part_id = gs_cc_level_part.part_id', 'left');
        $this->db->where('profile_students.st_id', $st_id);
        $this->db->where('cc_cat_id', $cat_id);
        $q = $this->db->get();
        return $q->result();
    }
    
    function getCC_cat()
    {
       $query = $this->db->get('gs_cc_cat');
       return $query->result();
    }
    
    function getCoCurricular($st_id, $term)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('grading', $term);
        $q = $this->db->get('gs_final_cc_involvement');
        return $q->row();
    }
    
    function checkCCInvolvement($st_id, $part_id)
    {
        $this->db->where('cc_level_part_id', $part_id);
        $this->db->where('st_id', $st_id);
        $query = $this->db->get('gs_cc_involvement');
        if($query->num_rows()>0):
            return $query;
        else:
            return FALSE;
        endif;
        
    }
    
    function getIndividualRank($st_id, $school_year)
    {
        $this->db->where('to_st_id', $st_id);
        $this->db->where('school_year',$school_year);
        $return = $this->db->get('gs_cc_total');
        return $return->row();
    }
    
    function getCC_involvement($st_id, $cat_id)
    {
        $this->db->select('*');
        $this->db->from('gs_cc_involvement');
        $this->db->join('gs_cc_level_part', 'gs_cc_involvement.cc_level_part_id = gs_cc_level_part.part_id','left');
        $this->db->where('st_id', $st_id);
        $this->db->where('cc_cat_id', $cat_id);
        $this->db->order_by('part_id');
        $query = $this->db->get();
        return $query->result();
        
    }
    
    function getCCInvolvementById($id)
    {
        $this->db->select('*');
        $this->db->from('gs_cc_involvement');
        $this->db->join('gs_cc_level_part', 'gs_cc_involvement.cc_level_part_id = gs_cc_level_part.part_id','left');
        $this->db->where('cc_involvement_id', $id);
        $query = $this->db->get();
        return $query->row();
        
    }
    
    function updateCCParticipation($id, $details)
    {
        $this->db->where('cc_involvement_id', $id);
        $this->db->update('gs_cc_involvement', $details);
        return;
    }
    
    function deleteCCParticipation($id)
    {
        $this->db->where('cc_involvement_id', $id);
        $this->db->delete('gs_cc_involvement');
        return;
    }
    
    function saveCCParticipation($details)
    {
        $this->db->insert('gs_cc_involvement', $details);
        return;
    }
    
    function getCC_level($id)
    {
        $this->db->select('*');
        $this->db->from('gs_cc_level_part');
        $this->db->where('cc_cat_id', $id);
        $this->db->group_by('part_pos');
        $this->db->order_by('part_id', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    function getRank($cat_id, $part_pos)
    {
        $this->db->select('*');
        $this->db->from('gs_cc_level_part');
        $this->db->where('cc_cat_id', $cat_id);
        $this->db->where('part_pos', $part_pos);
        $this->db->order_by('part_id', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    
}

?>
