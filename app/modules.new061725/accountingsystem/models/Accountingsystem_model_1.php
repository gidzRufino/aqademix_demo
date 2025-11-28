<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of scanController
 *
 * @author genesis
 */
class accountingsystem_model extends CI_Model {
    //put your code here
    
    function saveExpense($details)
    {
        if($this->db->insert('as_expense_transaction', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getAccountTitlesByID($id)
    {
        $this->db->where('coa_cat_id', $id);
        $q = $this->db->get('as_chart_of_accounts');
        return $q->result();
    }
    
    function savePRTransactions($column)
    {
        $result = $this->db->insert_batch('as_pr_transactions', $column);
        if($result):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveItems($details, $item)
    {
        $this->db->where('as_item', $item);
        $q = $this->db->get('as_items');
        if($q->num_rows()==0):
            $this->db->insert('as_items', $details);
            $id = $this->db->insert_id();
        else:
            $id = $q->row()->as_item_id;
        endif;
            return $id;
    }
    
    function fetchExpense($coa_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(exp_amount) as subTotal');
        $this->db->from('as_expense_transaction');
        $this->db->where('exp_account_title', $coa_id);
        $q = $this->db->get();
        return $q;
    }
    
    function createJournalEntry($details)
    {
        if($this->db->insert('as_transactions',$details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getEmployees()
    {
        $this->db->where('pp_sg_id !=', 0);
        $this->db->join('profile_employee', 'payroll_profile.pp_em_id = profile_employee.employee_id','left');
        $this->db->join('profile','profile_employee.user_id = profile.user_id','left');
        $q = $this->db->get('payroll_profile');
        return $q->result();
    }
    
    function showCatInReport($id, $array)
    {
        $this->db->where('cat_id', $id);
        if($this->db->update('as_coa_category', $array)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function showInReport($id, $array)
    {
        $this->db->where('coa_id', $id);
        if($this->db->update('as_chart_of_accounts', $array)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function fetchRevenue($account_id, $school_year)
    {
        ($school_year!=NULL?$this->db = $this->eskwela->db($school_year):'');
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as subTotal');
        $this->db->from('c_finance_transactions');
        $this->db->join('c_finance_items','c_finance_transactions.t_charge_id = c_finance_items.item_id','left');
        $this->db->where('c_finance_items.as_account_id', $account_id);
        $this->db->where('t_type !=', 2);
        $q = $this->db->get();
        return $q;
    }
    
    function getCategoryByParent($parent_id)
    {
        $this->db->where('cat_parent_id', $parent_id);
        $q = $this->db->get('as_coa_category');
        return $q->result();
    }
    
    function getAccountTitleById($id)
    {
        $this->db->where('coa_id', $id);
        $q = $this->db->get('as_chart_of_accounts');
        return $q->row();
    }
    
    function editPayrollItems($item_id, $details)
    {
        $this->db->where('pp_id', $item_id);
        if($this->db->update('payroll_profile', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function editFinanceItems($item_id, $details)
    {
        $this->db->where('item_id', $item_id);
        if($this->db->update('c_finance_items', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getAccountTitles($cat_id, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from('as_chart_of_accounts');
        $this->db->join('as_coa_category', 'as_chart_of_accounts.coa_cat_id = as_coa_category.cat_id','left');
        if($cat_id!=NULL):
            $this->db->where('coa_cat_id', $cat_id);
        endif;
        
        if($limit!=NULL||$offset!=NULL){
            $this->db->limit($limit, $offset);	
        }
        $q = $this->db->get();
        return $q;
    }
    
    function getCategory($cat_id)
    {
        if($cat_id!=NULL && $cat_id!=0):
            $this->db->where('cat_id', $cat_id);
        endif;
        $this->db->order_by('coa_order','ASC');
        $q = $this->db->get('as_coa_category');
        if($cat_id!=NULL && $cat_id!=0):
            return $q->row();
        else:
            return $q->result();
        endif;
    }
    
    function addAccount($details)
    {
        if($this->db->insert('as_chart_of_accounts', $details)):
            $json = json_encode(array('status' => TRUE, 'id' => $this->db->insert_id()));
        else:
            $json = json_encode(array('status' => TRUE));
        endif;
        
        return json_decode($json);
    }
    
    function addCategory($details)
    {
        if($this->db->insert('as_coa_category', $details)):
            $json = json_encode(array('status'=> TRUE, 'id' => $this->db->insert_id()));
        else:
            $json = json_encode(array('status'=> FALSE));
        endif;
        
        return json_decode($json);
    }
    
    
}
