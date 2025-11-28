<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gradingsystem_model
 *
 * @author genesis
 */
class new_gs_model extends CI_Model{
    //put your code here

    function getTotalScoreByStudent($student_id, $qcode, $term, $subject_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(equivalent) as total');
        $this->db->select('SUM(raw_score) as score');
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_component_sub', 'gs_assessment.quiz_cat = gs_component_sub.code', 'left');
        $this->db->where('gs_assessment.term', $term);
        if($subject_id!=NULL){
            $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        $this->db->where('st_id', $student_id);
        $this->db->where('gs_component_sub.code', $qcode);
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function getEachScoreByStudent($student_id, $qcode, $term, $subject_id, $option=NULL, $section_id)
    {
        $this->db->select('*');
        if($option!=NULL):
            $this->db->select('SUM(no_items) as TPS');
        endif;
        $this->db->from('gs_raw_score');
        $this->db->join('gs_assessment', 'gs_raw_score.assess_id = gs_assessment.assess_id', 'left');
        $this->db->join('gs_component_sub', 'gs_assessment.quiz_cat = gs_component_sub.code', 'left');
        $this->db->where('gs_assessment.term', $term);
        $this->db->where('st_id', $student_id);
        if($subject_id!=NULL){
            $this->db->where('gs_assessment.subject_id', $subject_id);
        }
        if($section_id!=NULL){
            $this->db->where('gs_assessment.section_id', $section_id);
        }
        $this->db->where('gs_assessment.quiz_cat', $qcode);
        $this->db->order_by('raw_score', 'desc');
        $query = $this->db->get();
        return $query;
    }
    
    function getCustomComponentList($sub_id)
    {
        $this->db->join('subjects','gs_component_sub.subject_id = subjects.subject_id','left');
        $this->db->join('gs_sub_component','gs_sub_component.sub_id = gs_component_sub.sub_com_id','left');
        $this->db->join('gs_component','gs_component_sub.component_id = gs_component.id','left');
        ($sub_id==NULL?"":$this->db->where('gs_component_sub.subject_id', $sub_id));
        $this->db->order_by('sub_com_id','ASC');
        $custom = $this->db->get('gs_component_sub');
        return $custom->result();
    }
    
    function getCustomComponent($sub_id, $sub_component_id)
    {
        $this->db->join('subjects','gs_component_sub.subject_id = subjects.subject_id','left');
        $this->db->join('gs_sub_component','gs_sub_component.sub_id = gs_component_sub.sub_com_id','left');
        $this->db->join('gs_component','gs_component_sub.component_id = gs_component.id','left');
        ($sub_id==NULL?"":$this->db->where('gs_component_sub.subject_id', $sub_id));
        ($sub_component_id==NULL?"":$this->db->where('gs_component_sub.sub_com_id', $sub_component_id));
        $custom = $this->db->get('gs_component_sub');
        return $custom->row();
    }
    
    function getSubComponent()
    {
        $subCom = $this->db->get('gs_sub_component');
        return $subCom->result();
    }
    
    function componentPerSubject($sub_id, $com_id, $sy)
    {
        if($sy==NULL):
            $sy = $this->session->userdata('school_year');
        endif;
        $this->db = $this->eskwela->db($sy);
        $this->db->where('subject_id', $sub_id);
        $this->db->where('component_id', $com_id);
        $q = $this->db->get('gs_asses_category');
        return $q->row();
    }
    
    function countBHGroup($bhg_id)
    {
        $this->db->where('bhs_group_id', $bhg_id);
        $q = $this->db->get('gs_behavior_rate_customized');
        return $q->num_rows();
    }
    
    function getBHRate($bh_id, $st_id, $grading,  $school_year)
    {
        $this->db->where('st_id', $st_id);
        $this->db->where('sy', $school_year);
        $this->db->where('grading', $grading);
        $this->db->where('bh_id', $bh_id);
        $this->db->join('gs_behavior_nnr', 'gs_final_bh_rate.rate = gs_behavior_nnr.id','left');
        $q = $this->db->get('gs_final_bh_rate');
        return $q->row();
    }
    
    function sumBHGroup($bhg_id, $st_id, $term, $sy)
    {
        $this->db->select('*');
        //$this->db->select('SUM(rate) as total');
        $this->db->from('gs_final_bh_rate_customized');
        $this->db->join('gs_behavior_rate_customized','gs_final_bh_rate_customized.indi_id = gs_behavior_rate_customized.bhs_id');
        $this->db->where('st_id', $st_id);
        $this->db->where('sy', $sy);
        $this->db->where('term', $term);
        $this->db->where('bhs_group_id', $bhg_id);
        $q = $this->db->get();
        return $q->row();
    }
    
    function getBHRating($st_id, $id, $term, $sy)
    {
        $this->db->where('indi_id', $id);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $term);
        $this->db->where('sy', $sy);
        $q = $this->db->get('gs_final_bh_rate_customized');
        return $q->row();
    }
    
    function getFBR($details, $indi_id, $st_id, $term, $sy)
    {
        $this->db->where('indi_id', $indi_id);
        $this->db->where('st_id', $st_id);
        $this->db->where('term', $term);
        $this->db->where('sy', $sy);
        $q = $this->db->get('gs_final_bh_rate_customized');
        if($q->num_rows()>0):
            $this->db->where('indi_id', $indi_id);
            $this->db->where('st_id', $st_id);
            $this->db->where('term', $term);
            $this->db->where('sy', $sy);
            if($this->db->update('gs_final_bh_rate_customized', $details)):
                return json_encode(array('status' => TRUE, 'details' => 2 ));
            endif;
        else:
            if($this->db->insert('gs_final_bh_rate_customized', $details)):
                return json_encode(array('status' => TRUE, 'details' => 1 ));
            endif;
            
        endif;
    }
    
    function editSubjectWeight($details, $subject_id, $assessment, $school_year, $weight)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('component_id', $assessment);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_asses_category');
        if($q->num_rows()>0):
            $this->db->where('subject_id', $subject_id);
            $this->db->where('component_id', $assessment);
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_asses_category', $details);
            return TRUE;
        else:
            $details = array('code' => $this->eskwela->codeCheck("gs_asses_category", "code", $this->eskwela->code()), 'component_id' => $assessment, 'weight' => $weight, 'subject_id' => $subject_id, 'school_year' => $school_year);
            $this->db->insert('gs_asses_category', $details);
            return TRUE;
        endif;
    }
    
    function editCustomSubjectWeight($details, $subject_id, $assessment, $subcom, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('component_id', $assessment);
        $this->db->where('sub_com_id', $subcom);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_component_sub');
        if($q->num_rows()>0):
            $this->db->where('subject_id', $subject_id);
            $this->db->where('component_id', $assessment);
            $this->db->where('sub_com_id', $subcom);
            $this->db->where('school_year', $school_year);
            $this->db->update('gs_component_sub', $details);
            return TRUE;
        else:
            $this->db->insert('gs_component_sub', $details);
            return TRUE;
        endif;
    }
    function addCustomSubjectWeight($details, $subject_id, $assessment, $subcom, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('component_id', $assessment);
        $this->db->where('sub_com_id', $subcom);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_component_sub');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('gs_component_sub', $details);
            return TRUE;
        endif;
    }
    
    function addSubjectWeight($details, $subject_id, $assessment, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('category_name', $assessment);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('gs_asses_category');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('gs_asses_category', $details);
            return TRUE;
        endif;
    }
    
    function getBHTRansmutation($bs_id)
    {
        $this->db->where('bs_id', $bs_id);
        $this->db->join('gs_behavior_nnr', 'gs_final_bh_rate_cust_trans.trans_info = gs_behavior_nnr.id','left');
        $q = $this->db->get('gs_final_bh_rate_cust_trans');
        return $q->result();
    }
    
    function getTransmutation()
    {
        $q = $this->db->get('gs_transmutation');
        return $q->result();
    }
    
    
    
}

