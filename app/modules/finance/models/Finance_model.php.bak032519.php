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
class Finance_model extends CI_Model {
    //put your code here
             
    function saveRefundTransaction($details, $trans_id, $school_year, $origAmount, $refundAmount)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('trans_id', $trans_id);
        if($refundAmount==$origAmount):
            
            if($this->db->update('c_finance_transactions', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            if($this->db->update('c_finance_transactions', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
            
        endif;    
    }
    
    function searchFinanceStaff($value, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->select('*');
        $this->db->select('profile_employee.employee_id as uid');
        $this->db->from('profile_employee'); 
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');       
        $this->db->join('user_accounts', 'profile_employee.employee_id = user_accounts.u_id', 'left');       
        $this->db->where('profile_position.position_dept_id', 7);
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
	$this->db->order_by('profile_position.p_rank', 'DESC');
	$this->db->order_by('lastname', 'ASC');
	$this->db->order_by('firstname', 'ASC');
        $this->db->like('LOWER(lastname)', strtolower($value), 'both');
        $query = $this->db->get();
        return $query->result();
    }
    
    function getIndividualTransactionByItemId($st_id, $sem, $school_year, $item_id, $type)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_school_year', $school_year);
        ($type==NULL?$this->db->where('t_type <=', 1):$this->db->where('t_type',$type));
        ($item_id!=NULL?$this->db->where('c_finance_items.item_id', $item_id):'');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function loadORDetails($ref_number, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id','left');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->where('ref_number', $ref_number);
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function searchReceipt($value, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->like('ref_number', $value, 'both');
        $this->db->group_by('ref_number');
        $q = $this->db->get('c_finance_transactions');
        return $q->result();
    }
    
    function getTransactionByMonth($st_id, $item_id, $month, $type)
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
        
        
        $this->db->select('SUM(t_amount) as amount');
        $this->db->select('t_date');
        $this->db->where('t_st_id', $st_id);
        $this->db->where('c_finance_items.item_id', $item_id);
        $this->db->where('t_type', ($type==NULL?0:$type));
        if($month == 7 ):
            $this->db->where("t_date between'".date($year.'-'.'04'.'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
        else:
            $this->db->where("t_date between'".date($year.'-'.$month.'-01') . "' and'" . date($year.'-'.$month.'-31') . "'");
        endif;
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q->row();
    }
    
    function getTransactionByCategory($st_id, $sem, $school_year, $cat_id, $type)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->select('t_type');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_school_year', $school_year);
        if($type==NULL):
            $this->db->where('t_type <', 2);
        else:
            $this->db->where('t_type', $type);
        endif;
        ($cat_id!=NULL?$this->db->where('c_finance_items.category_id', $cat_id):'');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q->row();
    }
    
    function getBillingSched($type, $month)
    {
        $this->db->where('bill_type', $type);
        $this->db->where('bill_month', $month);
        $q = $this->db->get('c_finance_billing_sched');
        return $q;
    }
    
    function getMOP($mop)
    {
        $this->db->where('bt_id', $mop);
        $q = $this->db->get('c_finance_billing_type');
        return $q->row();
    }
    
    function saveMOP($user_id, $mop)
    {
        $this->db->where('accounts_id', $user_id);
        if($this->db->update('c_finance_accounts', array('billing_type' => $mop))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function saveEditTransaction($details, $trans_id, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('trans_id', $trans_id);
        if($this->db->update('c_finance_transactions', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function loadFinanceTransaction($trans_id, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('trans_id', $trans_id);
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_transactions');
        return $q->row();
    }
            
    function getBank($id)
    {
        ($id!=NULL?$this->db->where('fbank_id', $id):'');
        $q = $this->db->get('c_finance_bank');
        return ($id!=NULL?$q->row():$q->result());
    }
    
    function getCashbreakdown($date)
    {
        $this->db->where('fdcb_date', $date);
        $this->db->join('c_finance_cash_denomination', 'c_finance_daily_cash_breakdown.fdcb_denom_id = c_finance_cash_denomination.cd_id');
        $this->db->order_by('cd_id','DESC');
        $q = $this->db->get('c_finance_daily_cash_breakdown');
        return $q->result();
    }
    
    function saveCashBreakDown($details)
    {
        $result = $this->db->insert_batch('c_finance_daily_cash_breakdown', $details);
        if($result):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
     function getCashDenomination()
    {
        $this->db->order_by('cd_id','DESC');
        $q = $this->db->get('c_finance_cash_denomination');
        return $q->result();
    }
    
    function getChequePaymentsByRange($from, $to)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->from('c_finance_transactions');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('t_type', 1);
        $this->db->group_by('tr_cheque_num');
        $this->db->order_by('t_date', 'ASC');
        $this->db->join('c_finance_bank','c_finance_transactions.bank_id = c_finance_bank.fbank_id','left');
        $q = $this->db->get();
        return $q->result();
    }
    
    function getChequePayments($teller_id=NULL, $date)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as t_amount');
        $this->db->from('c_finance_transactions');
        ($teller_id!=NULL?$this->db->where('t_em_id', $teller_id):'');
        $this->db->where('t_date', $date);
        $this->db->where('t_type', 1);
        $this->db->group_by('tr_cheque_num');
        $this->db->order_by('t_date', 'ASC');
        $this->db->join('c_finance_bank','c_finance_transactions.bank_id = c_finance_bank.fbank_id','left');
        $q = $this->db->get();
        return $q->result();
    }
    
    function getEncashments($teller_id, $date)
    {
        $this->db->where('encash_teller_id', $teller_id);
        $this->db->where('encash_date', $date);
        $this->db->join('c_finance_bank','c_finance_encashments.encash_bank_id = c_finance_bank.fbank_id','left');
        $q = $this->db->get('c_finance_encashments');
        return $q->result();
    }
    
    function saveEncashments($details)
    {
        if($this->db->insert('c_finance_encashments', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getBanks()
    {
        $this->db->order_by('bank_name', 'ASC');
        $q = $this->db->get('c_finance_bank');
        return $q->result();
    }
    
    function addBank($data, $bank_name)
    {
        $this->db->where('bank_name', $bank_name);
        $q = $this->db->get('c_finance_bank');
        if($q->num_rows()==0):
            $this->db->insert('c_finance_bank', $data);
            $result = json_encode(array('id'=>$this->db->insert_id(), 'value' => $bank_name, 'status' => TRUE));
        else:
            $result = json_encode(array('id'=>$q->row()->fbank_id, 'value' => $q->row()->bank_name, 'status' => FALSE));
        endif;
        return $result;
    }
    
    function getOtherAccountDetails($st_id)
    {
        $this->db->where('fo_account_id', $st_id);
        $q = $this->db->get('c_finance_others');
        return $q->row();
    }
    
    function saveAccount($lastname, $firstname, $sel_sy, $grade_level)
    {
        // $this->db->where('fo_lastname', $lastname);
        // $this->db->where('fo_firstname', $firstname);
        // $q = $this->db->get('c_finance_others');
        // if($q->num_rows()>0):
        //     return json_encode(array('isRegistered'=> TRUE, 'account_number' => $q->row()->fo_account_id));
        // else:
        $account_number = date('dmyHis');
            $this->db->insert('c_finance_others', array('fo_account_id' => $account_number, 'fo_lastname' => $lastname, 'fo_firstname'  => $firstname, 'fo_grade_level' => $grade_level, 'fo_school_year' => $sel_sy,'fo_dateCreated' => date('Y-m-d g:i:s')));
        return $account_number;
        // endif;
    }
    
    function updateStudentStatus($admission_id, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('admission_id', $admission_id);
        $this->db->update('profile_students_admission', array('status'=>1 ));
        return TRUE;
    }
    function setPrintSettings($v)
    {
        $this->db->update('c_finance_settings', array('print_receipts' => $v));
        return;
    }

    function getTransactionByOR($or_num, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('t_date', date('Y-m-d'));
        $this->db->where('ref_number', $or_num);
        $this->db->join('c_finance_bank', 'c_finance_transactions.bank_id = c_finance_bank.fbank_id', 'left');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'inner');
        $q = $this->db->get('c_finance_transactions');
        return $q->result();
    }
            
    /*function getTransactionByOR($or_num)
    {
        $this->db->where('ref_number', $or_num);
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'inner');
        $q = $this->db->get('c_finance_transactions');
        return $q->result();
    }*/
    
    function updateORSeries($or_num)
    {
        $this->db->where('or_current', ($or_num-1));
        $this->db->update('c_finance_or_series', array('or_current'=> ($or_num), 'or_last_printing' => date('Y-m-d g:i:s')));
        return;
    }
    
    function getSettings()
    {
        $this->db = $this->eskwela->db($this->session->school_year);
        $q = $this->db->get('c_finance_settings');
        return $q->row();
    }
    
    function getSingleSeries($employee_id)
    {
        $this->db = $this->eskwela->db($this->session->school_year);
        $this->db->where('or_cashier_id', $employee_id);
        $this->db->where('or_status', 0);
        $q = $this->db->get('c_finance_or_series');
        return $q->row();
    }
    
    function useSeries($id, $employee_id)
    {
        $this->db->where('or_cashier_id', $employee_id);
        $q = $this->db->get('c_finance_or_series');
        if($q->num_rows()>0):
            $this->db->where('or_cashier_id', $employee_id);
            $this->db->update('c_finance_or_series', array('or_cashier_id' => 0));
        endif;
        
        $this->db->where('or_id', $id);
        if($this->db->update('c_finance_or_series', array('or_cashier_id' => $employee_id))):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function getAllSeries()
    {
        $q = $this->db->get('c_finance_or_series');
        return $q->result();
    }
    
    function updateSeries($details, $series_id)
    {
        $this->db->where('or_id', $series_id);
        $this->db->update('c_finance_or_series', $details);
        return 'Series Successfully Updated';
    }
    
    function addSeries($details, $begin, $end)
    {
        $this->db->where('or_begin >=', $begin);
        $this->db->where('or_end <=', $end);
        $q = $this->db->get('c_finance_or_series');
        if($q->num_rows()>0):
            $msg = 'Sorry this series is already loaded in the system';
        else:
            $this->db->insert('c_finance_or_series', $details);
            $msg = 'Series Successfully Added';
        endif;
        return $msg;
    }
            
    function getCollectibles($limit, $offset, $school_year, $st_id=NULL, $semester=NULL)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->select('profile_students.st_id');
        $this->db->select('balance');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_students_admission.status');
        $this->db->from('c_finance_collectible');
        $this->db->join('profile_students', 'c_finance_collectible.fc_st_id = profile_students.st_id', 'right');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        
        $this->db->where('profile_students_admission.status !=', 0);
        ($st_id!=NULL?$this->db->where('fc_st_id', $st_id):'');
        $this->db->where('fc_school_year', $school_year);
        $this->db->where('balance !=', 0);
        //$this->db->where('balance <', 200000);
        ($semester!=NULL?$this->db->where('fc_semester', $semester):'');
        $this->db->order_by('lastname', 'ASC');
        
        if($limit!=NULL||$offset=NULL){
            $this->db->limit($limit, $offset);	
        }
        
        $q = $this->db->get();
        return $q;
    }
    
    function updateCollectibles($details, $st_id, $sy, $semester)
    {
        $this->db->where('fc_st_id', $st_id);
        $this->db->where('fc_school_year', $sy);
        ($semester!=0?$this->db->where('fc_semester', $semester):'');
        $q = $this->db->get('c_finance_collectible');
        if($q->num_rows()>0):
            $this->db->where('fc_st_id', $st_id);
            $this->db->where('fc_school_year', $sy);
            ($semester!=0?$this->db->where('fc_semester', $semester):'');
            $this->db->update('c_finance_collectible', $details);
        else:
            $this->db->insert('c_finance_collectible', $details);
        endif;
    }
    
    function getStudents($limit, $offset, $year)
    {
        $this->db = $this->eskwela->db($year);
        $this->db->select('profile_students.st_id');
        $this->db->select('lastname');
        $this->db->select('firstname');
        $this->db->select('profile.user_id as uid');
        $this->db->select('grade_level_id');
        $this->db->from('profile_students');
        $this->db->join('profile', 'profile_students.user_id = profile.user_id', 'left');
        $this->db->join('profile_students_admission', 'profile.user_id = profile_students_admission.user_id', 'left');
        $this->db->where('account_type', 5);
        $this->db->where('profile_students_admission.status !=', 0);
        $this->db->order_by('lastname', 'ASC');

        if($limit!=""||$offset=""){
            $this->db->limit($limit, $offset);	
        }
        
        $q = $this->db->get();
        return $q;
    }
    
    function deleteFinanceExtraCharge($trans_id, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('extra_id', $trans_id);
        if($this->db->delete('c_finance_extra')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveFinanceLog($logDetails)
    {
        $this->db->insert('c_finance_logs', $logDetails);
        return;
    }
    
    function getFinanceAccount($user_id)
    {
        $this->db->where('fin_st_id', $user_id);
        $q = $this->db->get('c_finance_accounts');
        return $q->row();
    }
    
    function updateAccount($user_id, $details)
    {
        $this->db->where('fin_st_id', $user_id);
        if($this->db->update('c_finance_accounts', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function getFinSet($school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $q = $this->db->get('c_finance_settings');
        return $q->row();
    }
    
    function getChargesByCategory($cat_id,$sem, $school_year, $plan_id)
    {
        
        $this->db->where('plan_id', $plan_id);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $sem);
        $this->db->where('category_id', $cat_id);
        $this->db->select('SUM(amount) as amount');
        $this->db->join('c_finance_items', 'c_finance_charges.item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_charges');
        return $q;
    }
    
    function getTotalCollectionPerItem($teller_id, $item_id, $date, $t_type)
    {
        $this->db->select('*');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->where('t_em_id', $teller_id);
        $this->db->where("t_date", $date);
        $this->db->where('t_type', $t_type);
        $this->db->where('t_charge_id', $item_id);
        $q = $this->db->get('c_finance_transactions');
        return $q->result();
    }
    
    function getTotalGroupCollection($from, $to, $receipt_type)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('c_finance_category', 'c_finance_items.dept_id = c_finance_category.fin_cat_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('t_receipt_type', $receipt_type);
        $this->db->group_by('c_finance_items.dept_id');
        $q = $this->db->get('c_finance_transactions');
        return $q->result();
    }
            
    function printCollectionReportPerTeller($from, $to, $teller_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where('t_em_id', $teller_id);
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('t_type <', 2);
        $this->db->group_by('c_finance_transactions.t_charge_id');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function printCollectionReportPerItem($from, $to)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('t_type', 0);
        $this->db->group_by('c_finance_transactions.t_charge_id');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getRSDM()// lifeCollege
    {
        $this->db->where('item_id between 2 and 4 ');
        $q = $this->db->get('c_finance_items');
        return $q->result();
    }
    
    function getRSDMCollection($item_id, $st_id,$from, $to) // lifeCollege
    {
        $this->db->select('*');
        $this->db->select('t_amount as amount');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        $this->db->where('item_id', $item_id);
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_type <=', 1);
        $q = $this->db->get('c_finance_transactions');
        return $q->row();
        
    }
    
    function getCollection($from, $to, $report_type=NULL)
    {
        $this->db->select('*');
        $this->db->select('SUM(t_amount) as amount');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->join('profile_students', 'c_finance_transactions.t_st_id = profile_students.st_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_students.user_id', 'left');
        $this->db->where("t_date between'".($from==NULL?date('Y-m-d'):$from) . "' and'" . ($to==NULL?date('Y-m-d'):$to)  . "'");
        if($report_type!=NULL):
            switch ($report_type):
                case 1:
                    $this->db->where('item_id', 1);
                break;
                case 2:
                    $this->db->where('item_id between 2 and 4 ');
                break;
                case 3:
                    $this->db->where('t_receipt_type', 1);
                break; 
            endswitch;
        endif;    
        $this->db->where('t_type <=', 1);
        $this->db->group_by('ref_number');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function deleteDiscount($school_year, $st_id, $item_id)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('disc_st_id', $st_id);
        $this->db->where('disc_school_year', $school_year);
        $this->db->where('disc_item_id', $item_id);
        if($this->db->delete('c_finance_discounts')):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function deleteTransaction($trans_id, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('trans_id', $trans_id);
        if($this->db->delete('c_finance_transactions')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function saveTransaction($column, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        if($this->db->insert('c_finance_transactions', $column)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
//        $result = $this->db->insert_batch('c_finance_transactions', $column);
//        if($result):
//            return TRUE;
//        else:
//            return FALSE;
//        endif;
    }
    
    function getTotalDiscount($st_id, $type)
    {
        $this->db->select('SUM(t_amount) as total');
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_type', $type);
        $q = $this->db->get('c_finance_transactions');
        if($q->num_rows()>0):
            return $q->row()->total;
        else:
            return 0;
        endif;
        
    }
    
    function getTransactionByItemId($st_id, $sem, $school_year, $item_id, $type)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_school_year', $school_year);
        ($type==NULL?$this->db->where('t_type <=', 1):$this->db->where('t_type',$type));
        ($item_id!=NULL?$this->db->where('c_finance_items.item_id', $item_id):'');
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->group_by('item_id');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getTransaction($st_id, $sem, $school_year)
    {
        $this->db = $this->eskwela->db($school_year);
        $this->db->where('t_st_id', $st_id);
        $this->db->where('t_sem', $sem);
        $this->db->where('t_school_year', $school_year);
        $this->db->join('c_finance_items', 'c_finance_transactions.t_charge_id = c_finance_items.item_id', 'left');
        $this->db->order_by('t_date', 'DESC');
        $q = $this->db->get('c_finance_transactions');
        return $q;
    }
    
    function getDiscountsByItemId($st_id, $sem, $school_year, $item_id)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('disc_st_id', $st_id);
        $this->db->where('disc_sem', $sem);
        $this->db->where('disc_school_year', $school_year);
        ($item_id==NULL?"":$this->db->where('disc_id', $item_id));
        $q = $this->db->get('c_finance_discounts');
        return $q->row();
    }
    
    function getChargesByItemId($item_id,$sem, $school_year, $plan_id)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $sem);
        $this->db->where('c_finance_charges.item_id', $item_id);
        $this->db->where('plan_id', $plan_id);
        $this->db->join('c_finance_items', 'c_finance_charges.item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_charges');
        return $q;
    }
            
    function addFinanceTransaction($transaction, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        if($this->db->insert('c_finance_transactions', $transaction)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function applyDiscounts($discount, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        if($this->db->insert('c_finance_discounts', $discount)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year, $item_id)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('extra_st_id', $st_id);
        $this->db->where('extra_sem', $sem);
        $this->db->where('extra_school_year', $school_year);
        $item_id==NULL?'':$this->db->where('extra_item_id', $item_id);
        $this->db->join('c_finance_items', 'c_finance_extra.extra_item_id = c_finance_items.item_id', 'left');
        $this->db->order_by('order', 'ASC');
        $q = $this->db->get('c_finance_extra');
        return $q;
        
    }
    
    function addExtraFinanceCharges($charge, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        if($this->db->insert('c_finance_extra', $charge)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function setFinanceAccount($finDetails, $st_id, $plan, $school_year, $sem)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
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
    
    function getPlanByCourse($course_id, $level)
    {
        $this->db->where('fin_course_id', $course_id);
        $this->db->where('fin_year_level', $level);
        $q = $this->db->get('c_finance_plan');
        return $q->row();
    }
    function deleteFinanceCharges($charge_id, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('charge_id', $charge_id);
        if($this->db->delete('c_finance_charges')):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function editFinanceCharges($charge_id, $amount, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('charge_id', $charge_id);
        if($this->db->update('c_finance_charges', array('amount'=> $amount))):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function financeChargesByPlan($school_year, $sem, $plan,$isGroup)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
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
    
    function financeCharges($course_id, $year_level, $school_year, $sem)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('fin_course_id', $course_id);
        $this->db->where('fin_year_level', $year_level);
        $this->db->where('school_year', $school_year);
        $this->db->where('semester', $sem);
        $this->db->join('c_finance_charges', 'c_finance_plan.fin_plan_id = c_finance_charges.plan_id','left');
        $this->db->join('c_finance_items', 'c_finance_charges.item_id = c_finance_items.item_id', 'left');
        $q = $this->db->get('c_finance_plan');
        return $q->result();
        
    }
    
    function addPlan($plan, $course_id, $grade_level, $school_year = NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('fin_course_id', $course_id);
        $this->db->where('fin_year_level', $grade_level);
        $q = $this->db->get('c_finance_plan');
        if($q->num_rows()>0):
            $this->db->where('fin_course_id', $course_id);
            $this->db->where('fin_year_level', $grade_level);
            $q1 = $this->db->get('c_finance_plan');
            return $q1->row()->fin_plan_id;
        else:
            $this->db->insert('c_finance_plan', $plan);
            return $this->db->insert_id();
        endif;
    }
    
    function addFinanceItem($item, $school_year=NULL)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('item_description', $item);
        $q = $this->db->get('c_finance_items');
        if($q->num_rows()==0):
            $this->db->insert('c_finance_items', array('item_description'=>$item, 'dept_id' => 3));
            $result = json_encode(array('id'=>$this->db->insert_id(), 'value' => $item, 'status' => TRUE));
        else:
            $result = json_encode(array('id'=>$q->row()->item_id, 'value' => $q->row()->item_description, 'status' => FALSE));
        endif;
        return $result;
    }
    function getFinanceCharges($school_year, $sem)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->where('school_year', $sy);
        $this->db->where('semester', $sem);
        $this->db->join('c_finance_items','c_finance_charges.item_id = c_finance_items.item_id','left');
        $q = $this->db->get('c_finance_charges');
        return $q;
    }
    
    function addFinanceCharges($charge, $plan_id, $item, $sem, $school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
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
            
    function getFinItems($school_year)
    {
        $this->db = ($school_year==NULL?$this->eskwela->db($this->session->school_year):$this->eskwela->db($school_year));
        $this->db->order_by('order', 'DESC');
        $q = $this->db->get('c_finance_items');
        return $q->result();
    }
}
