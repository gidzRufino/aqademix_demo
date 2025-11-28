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
class Finance_model_ccsa extends CI_Model {
    //put your code here
    
    function cancelReceipt($receiptNumber)
    {
        $this->db->where('ref_number', $receiptNumber);
        if($this->db->update('c_finance_transactions', array('t_type' => 3, 't_remarks' => 'Cancelled Receipt' ))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getDiscountPerLevelDetails($level_id, $item_id, $date, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('*');
        //$this->db->select('SUM(t_amount) as amount');
        $this->db->where('grade_level_id', $level_id);
        $this->db->where('t_type', 2);
        $this->db->where('t_date <=', $date);
        //$this->db->where('acnt_type', 0);
        $this->db->where('t_charge_id', $item_id);
        $this->db->where('profile_students_admission.status', 1);
        $this->db->join('profile_students_admission','c_finance_transactions.t_st_id = profile_students_admission.st_id','left'); 
        $this->db->join('profile','profile_students_admission.user_id = profile.user_id','left'); 
        $this->db->order_by('lastname', 'ASC');
        $q = $this->db->get('c_finance_transactions');
        return $q;
        
    }
    
    function getIndividualDiscountPerLevel($level_id,$item_id)
    {
       $this->db->select('*');
        $this->db->join('profile_students_admission','c_finance_transactions.t_st_id = profile_students_admission.st_id','left'); 
        $this->db->join('profile','profile.user_id = profile_students_admission.user_id','left'); 
        $this->db->join('c_finance_items','c_finance_transactions.t_charge_id = c_finance_items.item_id','left'); 
        $this->db->where('grade_level_id', $level_id);
        $this->db->where('t_type', 2);
        //$this->db->where('t_date <=', $date);
        $this->db->where('acnt_type', 0);
        ($item_id==NULL?$this->db->where('t_charge_id <=', 2):$this->db->where('t_charge_id', $item_id));
        $this->db->where('profile_students_admission.status', 1);
        $q = $this->db->get('c_finance_transactions');
        return $q;
        
    }
    
    function saveTransferFunds($transferDetails, $transferSchoolYear)
    {
        $this->db = $this->eskwela->db($transferSchoolYear);
        if($this->db->insert('c_finance_fund_transfer', $transferDetails)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
            
    function updateFundTransfer($remainingFundUpdate, $transfer_trans_id, $transferSchoolYear)
    {   
        $this->db = $this->eskwela->db($transferSchoolYear);
        $this->db->where('trans_id', $transfer_trans_id);
        if($this->db->update('c_finance_transactions', $remainingFundUpdate)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
            
    function saveStudentAdmission($details, $user_id, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('user_id', $user_id);
        $this->db->where('school_year', $school_year);
        $q = $this->db->get('profile_students_admission');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('profile_students_admission', $details);
            return TRUE;
        endif;
    }
    
    function insertData($details, $table, $column=NULL, $value=NULL, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($column==NULL):
            if($this->db->insert($table, $details)):
               return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $this->db->where($column, $value);
            if($this->db->update($table, $details)):
               return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function getPreviousRecord($table, $columns, $value,  $school_year, $settings)
    {
       
        $db_details = $this->eskwela->db($school_year);
        $db_details->from($table);
        $db_details->where($columns, $value);
        $query = $db_details->get();
        return $query->row();
    }
    
    function setFinanceAccount($finDetails, $st_id, $plan, $school_year, $sem)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('fin_st_id', $st_id);
        $this->db->where('fin_term_id', $sem);
        $this->db->where('fin_plan_id', $plan);
        $this->db->where('fin_school_year', $school_year);
        $q = $this->db->get('c_finance_accounts');
        if($q->num_rows()==0):
            $this->db->insert('c_finance_accounts', $finDetails);
        endif;
        
        return;
    }
    
    function addExtraFinanceCharges($charge, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        if($this->db->insert('c_finance_extra', $charge)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function addFinanceCharges($charge, $plan_id, $item, $sem, $sy)
    {
        $this->db = $this->eskwela->db($sy);
        $this->db->where('item_id', $item);
        $this->db->where('plan_id', $plan_id);
        //$this->db->where('semester', $sem);
        $this->db->where('school_year', $sy);
        $q = $this->db->get('c_finance_charges');
        if($q->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('c_finance_charges', $charge);
        endif;
        
        
    }
         
    function saveTransaction($column, $year)
    {
        $this->db = $this->eskwela->db($year);
        if($this->db->insert('c_finance_transactions', $column)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function getStudents($grade_id, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->select('profile_students.st_id');
        $this->db->select('profile.user_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile_students_admission.user_id = profile.user_id ','left');
        $this->db->where('account_type', 5);
        $this->db->where('profile_students_admission.grade_level_id', $grade_id);
        $this->db->where('profile_students_admission.status', 1);
	$this->db->order_by('lastname', 'ASC');
        $query = $this->db->get();
        return $query;
    }
    
    function getDiscountPerLevel($level_id, $item_id, $date, $school_year = NULL)
    {
        $this->db = $this->eskwela->db($school_year);
       // $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->join('profile_students_admission','c_finance_transactions.t_st_id = profile_students_admission.st_id','left'); 
        $this->db->where('grade_level_id', $level_id);
        $this->db->where('t_type', 2);
        $this->db->where('t_date <=', $date);
        $this->db->where('acnt_type', 0);
        $this->db->where('t_charge_id', $item_id);
        $this->db->where('profile_students_admission.status', 1);
        $q = $this->db->get('c_finance_transactions');
        return $q;
        
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
    
    function financeChargesByPlan($school_year, $sem, $plan,$isGroup)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $sem);
        ($plan==NULL?"":$this->db->where('c_finance_charges.plan_id', $plan));
        $this->db->join('c_finance_charges', 'c_finance_plan.fin_plan_id = c_finance_charges.plan_id','left');
        $this->db->join('c_finance_items', 'c_finance_charges.item_id = c_finance_items.item_id', 'left');
        ($isGroup==0?"":$this->db->group_by('c_finance_items.category_id'));
        if($isGroup==0):
            $this->db->order_by('c_finance_items.item_id', 'ASC');
        else:    
            $this->db->order_by('c_finance_items.order', 'ASC');
        endif;
        $q = $this->db->get('c_finance_plan');
        return $q->result();
        
    }
    
    function getTransactionByItemId($st_id, $sem, $school_year, $item_id, $type, $isGroup)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_school_year', $school_year);
        ($type==NULL?$this->db->where('t_type <=', 1):$this->db->where('t_type',$type));
        ($item_id!=NULL?$this->db->where('c_finance_items.item_id', $item_id):'');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        if($isGroup!=NULL):
            $this->db->group_by('item_id');
        endif;
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getBasicStudent($st_id, $school_year)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
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
        $this->db->where('profile_students_admission.status', 1);
        $this->db->order_by('lastname','ASC');
        $this->db->order_by('firstname','ASC');
        $this->db->order_by('middlename','ASC');
        if($school_year!=NULL):
            $this->db->where('profile_students_admission.school_year', $school_year);
        endif;
        $query = $this->db->get('profile_students');
        return $query->result();
    }
    
    function searchFundTransferAccount($value, $year)
    {
        if($value!=""):
                if($year!=NULL):
                    $sql = "select esk_profile_students_admission.school_year, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, sex, esk_profile_students_admission.status, admission_id
                  from esk_profile 
                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' or firstname like '%".$this->db->escape_like_str($value)."%'
                  and esk_profile_students_admission.school_year = '$year'
                  and account_type = 5
                  order by lastname ASC  ";
                else:
                    $year = $this->session->userdata('school_year');
                    $sql = "select esk_profile_students_admission.school_year, rfid, account_type, esk_profile_students.st_id as st_id, esk_profile.user_id as uid, lastname, firstname, middlename, sex, esk_profile_students_admission.status, admission_id
                  from esk_profile 
                  inner join esk_profile_students on esk_profile.user_id = esk_profile_students.user_id
                  inner join esk_profile_students_admission on esk_profile.user_id = esk_profile_students_admission.user_id
                  where lastname like '%".$this->db->escape_like_str($value)."%' or firstname like '%".$this->db->escape_like_str($value)."%'
                  and esk_profile_students_admission.school_year = '$year'
                  and account_type = 5
                  order by lastname ASC  ";
                endif;      
                $this->db = $this->eskwela->db($year);
                $query = $this->db->query($sql, array($value));
          else:
                
                $this->db->select('profile_students.st_id as st_id');
                $this->db->select('profile.user_id as uid');
                $this->db->select('profile_students_admission.status as status');
                $this->db->select('lastname');
                $this->db->select('firstname');
                $this->db->select('middlename');
                $this->db->select('level');
                $this->db->select('account_type');
                $this->db->from('profile_students');
                $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
                $this->db->join('profile_students_admission', 'profile_students_c_admission.user_id = profile.user_id', 'left');
                $this->db->join('grade_level', 'section.grade_level_id = grade_level.grade_id', 'left');
                $this->db->order_by('lastname', 'ASC');
                $this->db->limit(10);
                
                $this->db->where('account_type', 5);

                $query = $this->db->get();
        
          endif;
        return $query->result();
        
        
    }
}
