<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of login_model
 *
 * @author genesis
 */
class Finance_model extends CI_Model {
    
    
    function getDiscountsByItemId($st_id, $sem, $school_year, $item_id)
    {
        $this->db->where('disc_st_id', $st_id);
        $this->db->where('disc_sem', $sem);
        $this->db->where('disc_school_year', $school_year);
        ($item_id==NULL?"":$this->db->where('disc_id', $item_id));
        $q = $this->db->get('c_finance_discounts');
        return $q->row();
    }
    
    function getTransaction($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_sem', $sem);
        $this->db->where('t_school_year', $school_year);
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year)
    {
        $this->db->where('extra_st_id', $st_id);
        $this->db->where('extra_sem', $sem);
        $this->db->where('extra_school_year', $school_year);
        $this->db->join('c_finance_items', 'c_finance_extra.extra_item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_extra');
        return $q;
        
    }
    
    function getPlanByCourse($course_id, $level)
    {
        $this->db->where('fin_course_id', $course_id);
        $this->db->where('fin_year_level', $level);
        $q = $this->db->get('c_finance_plan');
        return $q->row();
    }
    
    
    function financeChargesByPlan($school_year, $sem, $plan,$year_level)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $sem);
        ($plan==NULL?"":$this->db->where('c_finance_charges.plan_id', $plan));
        $this->db->join('c_finance_charges', 'c_finance_plan.fin_plan_id = c_finance_charges.plan_id','left');
        $this->db->join('c_finance_items', 'c_finance_charges.item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_plan');
        return $q->result();
        
    }
    
    function getFinanceAccount($user_id)
    {
        $this->db->where('fin_st_id', $user_id);
        $q = $this->db->get('c_finance_accounts');
        return $q->row();
    }
}
