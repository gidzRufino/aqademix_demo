<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of schedule_model
 *
 * @author genesis
 */
class Finance_model_lma extends CI_Model {
    //put your code here
    
    function getStudents($limit, $offset, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile_students.st_id');
        $this->db->select('profile.user_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile.user_id ','left');
        $this->db->join('profile_parents', 'profile.user_id = profile_parents.parent_id ','left');
        $this->db->where('account_type', 5);
        $this->db->where('profile_students_admission.status', 1);
        $this->db->where('profile_students_admission.school_year', $school_year);
	$this->db->order_by('lastname', 'ASC');
        if($limit!=NULL||$offset!=NULL){
            $this->db->limit($limit, $offset);	
        }
        $query = $this->db->get();
        return $query;
    }
    
    function getTFPayment($st_id, $month, $rangeFrom)
    {
        if($month > 12):
            $year = date('Y')+1;
            $month = $month - 12;
        else:
            $year = date('Y');
        endif;
        if($month < 10):
            $month = '0'.$month;
        endif;
        $this->db->where('t_st_id', $st_id);
        $this->db->where('category_id', 1);
        if($month!=NULL):
            if($rangeFrom!=NULL):
                $this->db->where("t_date between'".date($year.'-'.($rangeFrom<10?'0'.$rangeFrom:'0'.$rangeFrom).'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
            else:
                if($month == 6 ):
                    $this->db->where("t_date between'".date($year.'-'.'04'.'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
                else:
                    $this->db->where("t_date between'".date($year.'-'.$month.'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
                endif;    
            endif;
        endif;    
        
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q;
        
    }
    
    function getSchoolBusPayment($st_id)
    {
        $this->db->where('t_st_id', $st_id);
        $this->db->where('category_id', 6);
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q;
        
    }
    
    function inCharges($item_id, $plan_id)
    {
        $this->db->where('plan_id', $plan_id);
        $this->db->where('item_id', $item_id);
        $q = $this->db->get('c_finance_charges');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function inExtraCharges($user_id, $item_id)
    {
        $this->db->where('extra_st_id', $user_id);
        $this->db->where('extra_item_id', $item_id);
        $q = $this->db->get('c_finance_extra');
        if($q->num_rows()>0):
            return $q->result();
        else:
            return FALSE;
        endif;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year, $item_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(extra_amount) as amount');
        $this->db->where('extra_st_id', $st_id);
        $this->db->where('extra_school_year', $school_year);
        $item_id==NULL?'':$this->db->where('extra_item_id', $item_id);
        $this->db->join('c_finance_items', 'c_finance_extra.extra_item_id = c_finance_items.item_id', 'left');
        $this->db->group_by('extra_item_id', 'ASC');
        $this->db->order_by('order', 'ASC');
        $q = $this->db->get('c_finance_extra');
        return $q;
        
    }
    
    function getBasicStudent($st_id, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.st_id as stid');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('profile_students.st_id', $st_id);
        if($school_year!=NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get('profile_students');
        return $query->row();
    }
    
    function getStudentPerSection($section, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students.st_id as stid');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id');
        $this->db->join('profile_students_admission', 'profile_students.user_id = profile_students_admission.user_id','left');
        $this->db->join('section', 'section.section_id = profile_students_admission.section_id', 'left');
        $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
        $this->db->where('section.section_id', $section);
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->order_by('middlename','ASC');
        if($school_year!=NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get('profile_students');
        return $query->result();
    }
    
    function deleteFinancePenalty($pen_id)
    {
        $this->db->where('pen_id', $pen_id);
        if($this->db->delete('c_finance_penalty')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    function getPenalty($st_id, $school_year, $status, $month)
    {
        $this->db->where('pen_st_id', $st_id);
        $this->db->where('pen_isPaid', $status);
        ($month!=NULL?$this->db->where('pen_month', $month):'');
        $this->db->where('pen_school_year', $school_year);
        $this->db->order_by('pen_month','ASC');
        $q = $this->db->get('c_finance_penalty');
        return $q;
    }
    
    function savePenalty($st_id, $month, $amount, $school_year)
    {
        $details = array(
            'pen_st_id'         => $st_id,
            'pen_month'         => $month,
            'pen_amount'        => $amount,
            'pen_school_year'   => ($school_year==NULL?$this->session->school_year:$school_year)
        );
        
        $this->db->where('pen_st_id', $st_id);
        $this->db->where('pen_month', $month);
        $this->db->where('pen_school_year', $school_year);
        $q = $this->db->get('c_finance_penalty');
        if($q->num_rows()==0):
            $this->db->insert('c_finance_penalty', $details);
        endif;
        
        return;
    }
    
    function updatePenalty($pen_id, $details)
    {
        $this->db->where('pen_id', $pen_id);
        $this->db->update('c_finance_penalty', $details);
        return;
    }
    
    function saveNotes($details, $st_id, $school_year)
    {
        $this->db->where('note_st_id', $st_id);
        $this->db->where('note_sy', $school_year);
        $q = $this->db->get('c_finance_notes');
        if($q->num_rows()==0):
            if($this->db->insert('c_finance_notes', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where('note_st_id', $st_id);
            $this->db->where('note_sy', $school_year);
            if($this->db->update('c_finance_notes', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function getNotes($st_id, $school_year)
    {
        $this->db->where('note_st_id', $st_id);
        $this->db->where('note_sy', $school_year);
        $q = $this->db->get('c_finance_notes');
        return $q->row();
    }
}
