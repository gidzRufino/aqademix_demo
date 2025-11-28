<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payroll_model
 *
 * @author genru
 */
class coopmanagement_model extends CI_Model{
    
    function notRegistered($notRegistered)
    {
        return $this->db->insert('profile_not_registered', $notRegistered);
    }
    
    function nameCheck($lastname, $firstname)
    {
        $this->db->join('coop_account_details','profile.user_id = coop_account_details.cad_profile_id','left');
        $this->db->where('LOWER(lastname)', strtolower($lastname));
        $this->db->like('LOWER(firstname)', strtolower($firstname));
        $q = $this->db->get('profile');
        if($q->num_rows() > 0):
            return $q->row();
        else:
            return FALSE;
        endif;
    }
    
    function getAccountInfoByUserId($user_id)
    {
        return $this->db->where('cad_profile_id', $user_id)
                    ->get('coop_account_details')
                    ->row();
    }
            
    function updateCoopTransaction($trans_id, $remainingBalance, $interest)
    {
        $this->db->where('cft_id', $trans_id);
        if($this->db->update('coop_transaction', array('cft_trans_amount' => ($remainingBalance>0?$remainingBalance:0)))):
            $this->db->where('cft_id', $trans_id);
            $q = $this->db->get('coop_transaction')->row();
            
            $interestDetails = array(
                'cft_profile_id'    => $q->cft_profile_id,
                'cft_account_no'    => $q->cft_account_no,
                'cft_trans_num'     => 'LPi-'.date('ymdgis'),
                'cft_or_number'     => $q->cft_or_number,
                'cft_trans_amount'  => $interest,
                'cft_lrn'           => $q->cft_lrn,
                'cft_trans_type'    => 8,
                'cft_gl_type'       => $q->cft_gl_type,
                'cft_trans_date'    => $q->cft_trans_date,
                'cft_remarks'       => $q->cft_remarks,
                'cft_payment_type'  => $q->cft_payment_type,
                'cft_bank_id'       => $q->cft_bank_id,
                'cft_cheque_num'    => $q->cft_cheque_num,
                'cft_teller_id'     => $this->session->employee_id
            );
            
            $this->db->insert('coop_transaction', $interestDetails);
            return;
            
        endif;
        
        
        
        
    }
    
    function getTotalMembers($shareCap, $option)
    {
        ($option!=NULL?$this->db->where("cad_share_capital $option", $shareCap):'');
        $q = $this->db->get('coop_account_details');
        return $q->num_rows();
    }
    
    function updateAccountInfo($column, $value, $profile_id)
    {
        $this->db->where('cad_account_no', $profile_id);
        $q = $this->db->get('coop_account_details');
        if($q->num_rows()>0):
            $details = array($column => $q->row()->$column+$value );
            
            $this->db->where('cad_account_no', $profile_id);
            if($this->db->update('coop_account_details', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    function updateLoanAmortization($details, $id)
    {
        $this->db->where('lad_id', $id);
        if($this->db->update('coop_loan_amortization', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveCoopTransaction($details)
    {
        if($this->db->insert('coop_transaction', $details)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;
    }
    
    function getTransactionType()
    {
        $q = $this->db->get('coop_transaction_type');
        return $q->result();
    }
            
    function addCreditCommittee($details, $user_id)
    {
        $this->db->where('cad_profile_id', $user_id);
        if($this->db->update('coop_account_details', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function searchMembers($value)
    {
        $this->db->select('*');
        $this->db->from('profile'); 
        $this->db->join('coop_account_details', 'coop_account_details.cad_profile_id = profile.user_id', 'left');     
        $this->db->where('profile.user_id !=', 1);
	$this->db->order_by('lastname', 'ASC');
	$this->db->order_by('firstname', 'ASC');
        $this->db->like('LOWER(lastname)', strtolower($value), 'after');
        $this->db->or_like('LOWER(firstname)', strtolower($value), 'after');
        $this->db->limit(30);
        $query = $this->db->get();
        return $query->result();
 
    }
    
    function personToReview()
    {
        $this->db->where('is_approver', 1);
        $this->db->join('profile','coop_account_details.cad_profile_id = profile.user_id', 'left');
        $this->db->join('profile_employee', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $q = $this->db->get('coop_account_details');
        return $q->result();
    }
    
    function getAccountInfoByAccountNumber($accountNumber)
    {
        $this->db->select('*');
        $this->db->from('profile'); 
        $this->db->join('profile_employee', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('payroll_salary_type', 'profile_employee.pg_id = payroll_salary_type.pst_id', 'left');
        $this->db->join('coop_account_details', 'coop_account_details.cad_profile_id = profile.user_id', 'left');     
        $this->db->where('coop_account_details.cad_account_no', $accountNumber);
        $query = $this->db->get();
        return $query->row();
        
        
    }
    
    function getBasicInfo($user_id)
    {
        $this->db->select('*');
        $this->db->select('profile.user_id as uid');
        $this->db->select('profile_employee.employee_id as em_id');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->where('profile.user_id', $user_id);
        $query = $this->db->get();
        return $query->row();
        
        
    }
    
    function addAccountDetails($details, $user_id)
    {
        $this->db->where('cad_profile_id', $user_id);
        $q = $this->db->get('coop_account_details');
        if($q->num_rows()==0):
            if($this->db->insert('coop_account_details', $details)):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
        
    }
    
    function ifAccountExist($user_id)
    {
        $this->db->where('cad_profile_id', $user_id);
        $q = $this->db->get('coop_account_details');
        if($q->num_rows()>0):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}
