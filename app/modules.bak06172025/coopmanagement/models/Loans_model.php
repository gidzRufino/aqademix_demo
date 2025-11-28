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
class Loans_model extends CI_Model {
    
    function deleteLoanApplication($ref_number)
    {
        $this->db->where('ld_ref_number', $ref_number);
        $q = $this->db->delete('coop_loan_details');
        if($q):
            $this->db->where('lad_ref_num', $ref_number);
            if($this->db->delete('coop_loan_amortization')):
                $this->db->where('cla_ref_number', $ref_number);
                if($this->db->delete('coop_loan_approver')):
                    return json_encode(array('msg' => 'Successfully Deleted', 'status' => TRUE));
                else:
                    return json_encode(array('msg' => 'Something went wrong in Deleting loan approver', 'status' => TRUE));
                endif;
            else:
                return json_encode(array('msg' => 'Something went wrong in Deleting loan amortization', 'status' => TRUE));    
            endif;
        
        else:
            return json_encode(array('msg' => 'Something went wrong in Deleting loan amortization', 'status' => TRUE));        
        endif;
    }
    
    function getIndividualLoanList($account_number, $endDate, $loanType)
    {
        $this->db->join('coop_loan_amortization','coop_loan_details.ld_ref_number = coop_loan_amortization.lad_ref_num','left');
        $this->db->order_by('lad_date', 'ASC');
        $this->db->group_by('lad_ref_num');
        ($loanType!=NULL?$this->db->where('ld_loan_type', $loanType):"");
        $this->db->where('lad_status !=', 1);
        $this->db->where('lad_date <=', $endDate);
        $this->db->where('ld_account_num', $account_number);
        $q = $this->db->get('coop_loan_details');
        return ($loanType!=NULL?$q->row():$q->result());
    }
    
    function editLoanSettings($details, $clt_id)
    {
        $this->db->where('clt_id', $clt_id);
        if($this->db->update('coop_loan_type', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function getOutstandingBalance($account_number, $lrn)
    {
        $this->db->join('coop_loan_details', 'coop_loan_amortization.lad_ref_num = coop_loan_details.ld_ref_number', 'left');
        $this->db->where('ld_account_num', $account_number);
        $this->db->where('lad_status', 0);
        ($lrn!=NULL?$this->db->where('ld_ref_number', $lrn):'');
        $this->db->order_by('lad_date', 'ASC');
        $this->db->group_by('lad_ref_num');
        $q = $this->db->get('coop_loan_amortization');
        return $q;
    }
    
    function getTotalLoanPayment($lrn, $account_number)
    {
        $this->db->where('cft_lrn', $lrn);
        $this->db->where('cft_trans_type', 3);
        ($account_number!=NULL?$this->db->where('cft_account_no', $account_number):'');
        $q = $this->db->get('coop_transaction');
        return $q;
    }
    
    function getLoanAmortStatus($lad_id)
    {
        $this->db->where('lad_id', $lad_id);
        $q = $this->db->get('coop_loan_amortization');
        return $q->row();
    }
//    
    
    function getLoanIndividualList($account_num, $dateFrom, $dateTo, $loan_id, $status)
    {
        $this->db->where('ld_status',2);
        ($status!=NULL?$this->db->where('lad_status', $status):"");
        ($account_num!=NULL?$this->db->where('cad_profile_id', $account_num):'');
        ($loan_id!=NULL?$this->db->where('ld_loan_type', $loan_id):'');
       // $this->db->where("lad_date between '" . $dateFrom . "' and'" . $dateTo . "'");
        if($dateFrom!=NULL):
            $this->db->where("ld_loan_date <=", $dateTo);
        endif;    
        $this->db->group_by('ld_loan_date');
        $this->db->order_by('ld_loan_date', 'DESC');
        $this->db->join('coop_loan_details','coop_loan_details.ld_ref_number = coop_loan_amortization.lad_ref_num', 'left');
        $this->db->join('coop_account_details','coop_account_details.cad_account_no = coop_loan_details.ld_account_num','left');
        $q = $this->db->get('coop_loan_amortization');
        return $q;
    }
    
    function getLoanList($dateFrom, $dateTo)
    {
        $this->db->select('ld_loan_type');
        $this->db->select('ld_loan_date');
        $this->db->distinct('ld_loan_type');
        $this->db->where('ld_status', 2);
        //$this->db->where('ld_loan_date >=', $dateFrom);
        $this->db->where('ld_loan_date <=', $dateTo);
        $this->db->group_by('ld_loan_type');
        $q = $this->db->get('coop_loan_details');
        return $q;
    }
    
//    function getLoanList($account_num, $dateFrom, $dateTo, $loan_id, $status)
//    {
//        $this->db->select('ld_loan_date');
//        $this->db->where('ld_status',2);
//        ($status!=NULL?$this->db->where('lad_status', $status):"");
//        ($account_num!=NULL?$this->db->where('cad_profile_id', $account_num):'');
//        ($loan_id!=NULL?$this->db->where('ld_loan_type', $loan_id):'');
//       // $this->db->where("lad_date between '" . $dateFrom . "' and'" . $dateTo . "'");
//        if($dateFrom!=NULL):
//            $this->db->where("ld_loan_date >=", $dateFrom);
//        endif;    
//        $this->db->group_by('ld_loan_date');
//        $this->db->order_by('ld_loan_date', 'DESC');
//        $this->db->join('coop_loan_details','coop_loan_details.ld_ref_number = coop_loan_amortization.lad_ref_num', 'left');
//        $this->db->join('coop_account_details','coop_account_details.cad_account_no = coop_loan_details.ld_account_num','left');
//        $q = $this->db->get('coop_loan_amortization');
//        return $q;
//    }
    
    function getBasicLoanDetails($lrn)
    {
        $this->db->where('ld_ref_number', $lrn);
        $this->db->where('ld_status',2);
        $q = $this->db->get('coop_loan_details');
        return $q;
    }
    
    function getPersonalLoanBalance($lrn, $endDate, $status = NULL)
    {
        ($lrn!=NULL?$this->db->where('lad_ref_num', $lrn):'');
        if($endDate!=NULL):
            $this->db->where("lad_date <=", $endDate);
        endif;  
        ($status!=NULL?$this->db->where('lad_status', $status):"");  
        //$this->db->order_by('lad_date', 'DESC');
        $q = $this->db->get('coop_loan_amortization');
        return $q;
    }
    
//    function getPersonalLoanBalance($lrn, $endDate, $status = NULL)
//    {
//        ($lrn!=NULL?$this->db->where('lad_ref_num', $lrn):'');
//        if($endDate!=NULL):
//            $this->db->where("lad_date <=", $endDate);
//        endif;  
//        ($status!=NULL?$this->db->where('lad_status', $status):"");  
//        $this->db->order_by('lad_date', 'DESC');
//        $q = $this->db->get('coop_loan_amortization');
//        return $q;
//    }
    
    function getPersonalLoan($account_num, $lrn, $startDate, $endDate, $loan_type, $status)
    {
        $this->db->where('ld_status',2);
        ($status!=NULL?$this->db->where('lad_status', $status):"");
        ($loan_type!=NULL?$this->db->where('ld_loan_type', $loan_type):'');
        $this->db->where('ld_account_num', $account_num);
        ($lrn!=NULL?$this->db->where('lad_ref_num', $lrn):'');
        if($startDate!=NULL):
            $this->db->where("lad_date >=", $startDate);
        endif;    
        $this->db->group_by('lad_ref_num');
        $this->db->order_by('lad_date', 'DESC');
        $this->db->join('coop_loan_details','coop_loan_details.ld_ref_number = coop_loan_amortization.lad_ref_num', 'left');
        $this->db->join('coop_account_details','coop_account_details.cad_account_no = coop_loan_details.ld_account_num','left');
        $q = $this->db->get('coop_loan_amortization');
        return $q;
    }
    
    function loanReleased($id)
    {
        $this->db->join('coop_loan_type','coop_loan_details.ld_loan_type = coop_loan_type.clt_id', 'left');
        $this->db->join('coop_account_details','coop_loan_details.ld_account_num = coop_account_details.cad_account_no', 'left');
        $this->db->join('profile','coop_account_details.cad_profile_id = profile.user_id', 'left');
        ($id!=NULL?$this->db->where('ld_account_num', $id):"");
        $this->db->where('ld_status', 2);
        $q = $this->db->get('coop_loan_details');
        return $q->result();
    }
    
    function saveCoopTransaction($details)
    {
        if($this->db->insert('coop_transaction', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function updateLoanDetails($ldDetails, $ref_number)
    {
        $this->db->where('ld_ref_number', $ref_number);
        $this->db->update('coop_loan_details', $ldDetails);
        return;
    }
    
    function approvedLoan($details, $user_id, $ref_number)
    {
        $this->db->where('cla_ref_number', $ref_number);
        if($this->db->update('coop_loan_approver', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveApprover($details)
    {
        $this->db->insert('coop_loan_approver', $details);
        return;
    }
            
    function getAmortizationTable($refNumber)
    {
        $this->db->where('lad_ref_num', $refNumber);
        $this->db->order_by('lad_date', 'ASC');
        $q = $this->db->get('coop_loan_amortization');
        return $q->result();
    }
    
    function getLoanDetails($referenceNumber)
    {
        $this->db->where('ld_ref_number', $referenceNumber);
        $this->db->join('coop_loan_approver','coop_loan_details.ld_ref_number = coop_loan_approver.cla_ref_number', 'left');
        $this->db->join('coop_loan_type','coop_loan_details.ld_loan_type = coop_loan_type.clt_id', 'left');
        $q = $this->db->get('coop_loan_details');
        return $q->row();
    }
    
    function loansForDisbursement()
    {
        $this->db->join('coop_loan_type','coop_loan_details.ld_loan_type = coop_loan_type.clt_id', 'left');
        $this->db->join('coop_account_details','coop_loan_details.ld_account_num = coop_account_details.cad_account_no', 'left');
        $this->db->join('profile','coop_account_details.cad_profile_id = profile.user_id', 'left');
        $this->db->where('ld_status', 1);
        $q = $this->db->get('coop_loan_details');
        return $q->result();
    }
    
    function getPendingLoans()
    {
        $this->db->join('coop_loan_type','coop_loan_details.ld_loan_type = coop_loan_type.clt_id', 'left');
        $this->db->join('coop_account_details','coop_loan_details.ld_account_num = coop_account_details.cad_account_no', 'left');
        $this->db->join('profile','coop_account_details.cad_profile_id = profile.user_id', 'left');
        $this->db->where('ld_status', 0);
        $q = $this->db->get('coop_loan_details');
        return $q->result();
    }
    
    function getLoanStatus($status)
    {
        $this->db->join('coop_loan_type','coop_loan_details.ld_loan_type = coop_loan_type.clt_id', 'left');
        $this->db->join('coop_account_details','coop_loan_details.ld_account_num = coop_account_details.cad_account_no', 'left');
        $this->db->join('profile','coop_account_details.cad_profile_id = profile.user_id', 'left');
        $this->db->where('ld_status', $status);
        $q = $this->db->get('coop_loan_details');
        return $q;
    }
    
    function saveAmortization($details)
    {
        if($this->db->insert('coop_loan_amortization', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function saveLoanTransaction($details)
    {
        if($this->db->insert('coop_loan_details', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
            
    function getLoanTypeById($id)
    {
        $this->db->where('clt_id', $id);
        $q = $this->db->get('coop_loan_type');
        return $q->row();
    }
    
    function getLoanTypes()
    {
        $q = $this->db->get('coop_loan_type');
        return $q->result();
    }
    
    function overidePayment($lad_id, $details)
    {
        $this->db->where('lad_id', $lad_id);
        if($this->db->update('coop_loan_amortization', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }
}
