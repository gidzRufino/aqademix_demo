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
class Payroll_model extends CI_Model{
    
    function getAllEmployee($limit, $offset)
    {
        $this->db->select('*');
        $this->db->select('profile_employee.employee_id as uid');
        $this->db->from('profile_employee'); 
        $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');       
        $this->db->join('user_accounts', 'profile_employee.employee_id = user_accounts.u_id', 'left');       
        $this->db->where('profile_position.position_id !=', 1);
        $this->db->where('profile_position.position !=', 'Part-Time Faculty');
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
        $this->db->where('isActive !=', 0);
	$this->db->order_by('profile_position.p_rank', 'DESC');
	$this->db->order_by('lastname', 'ASC');
	$this->db->order_by('firstname', 'ASC');

		if($limit!=""||$offset=""){
			$this->db->limit($limit, $offset);	
		}
		
        $query = $this->db->get();
        return $query;
 
    }
    
    function getEmployeeDailyAttendance($em_id, $date)
    {
        if($date==NULL):
            $date = date("Y-m-d");
        endif;
        
        $this->db = $this->eskwela->db($this->session->userdata('school_year'));
        
            $this->db->select('*');
            $this->db->from('attendance_sheet');
            $this->db->join('profile_employee', 'attendance_sheet.att_st_id = profile_employee.employee_id', 'inner');
            $this->db->join('profile', 'profile_employee.user_id = profile.user_id', 'inner');
            $this->db->where('attendance_sheet.date', $date);
            $this->db->where('attendance_sheet.att_st_id', $em_id);
            $query = $this->db->get();
            return $query->row();       
   }
   
    function saveShifts($saveShiftDetails, $group_id, $shift_id = NULL)
    {
        $this->db->where('grp_id', $group_id);
        $this->db->update('payroll_shift_group', $saveShiftDetails);
        
        if($shift_id!=NULL):
            $this->db->where('ps_id', $shift_id);
            $q = $this->db->get('payroll_shift');
             return $q->row();
        endif;
    }
    
    function getGroupId($shift_id)
    {
        $this->db->where('shift_id', $shift_id);
        $q = $this->db->get('payroll_shift_group');
        return $q->row()->grp_id;
    }
    
    function getShiftId($group_id)
    {
        $this->db->where('grp_id', $group_id);
        $q = $this->db->get('payroll_shift_group');
        return $q->row()->shift_id;
    }
    
    function getPayrollShift()
    {
        $q = $this->db->get('payroll_shift');
        return $q->result();
    }
    
    function getRawTimeShifting()
    {
        $q = $this->db->get('payroll_shift');
        return $q->result();
    }
    
    function getTimeShifting($user_id)
    {
        $this->db->join('payroll_shift','payroll_shift.ps_id = profile_employee.time_group_id','left');
        $this->db->where('user_id', $user_id);
        $q = $this->db->get('profile_employee');
        return $q->row();
    }
    
    function saveShiftGroup($details, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('profile_employee', $details);
        return;
    }
            
    function getShiftGroupings()
    {
        $q = $this->db->get('payroll_shift');
        return $q->result();
    }
    
    function deletePayrollCharges($profile_id, $item_id, $pc_code)
    {
        $this->db->where('pc_profile_id', $profile_id);
        $this->db->where('pc_code', $pc_code);
        $this->db->where('pc_item_id', $item_id);
        $this->db->delete('payroll_charges');
        return;
    }
    
    function getPayrollProfile($em_id)
    {
        $this->db->where('pp_em_id', $em_id);
        $q = $this->db->get('payroll_profile');
        return $q->row();
    }
    
    function releasePayroll($details, $profile_id, $pc_code)
    {
        $this->db->where('ptrans_profile_id', $profile_id);
        $this->db->where('ptrans_pay_code', $pc_code);
        if($this->db->update('payroll_transaction', $details)):
            return TRUE;
        else:
            return FALSE;
        endif;
        
    }
    
    function checkTransaction($profile_id, $pc_code)
    {
        $this->db->where('ptrans_profile_id', $profile_id);
        $this->db->where('ptrans_pay_code', $pc_code);
        $q = $this->db->get('payroll_transaction');
        return $q->row();
    }
    
    function approvePayroll($details, $em_id, $pc_code)
    {
        $this->db->where('ptrans_profile_id', $em_id);
        $this->db->where('ptrans_pay_code', $pc_code);
        $q = $this->db->get('payroll_transaction');
        if($q->num_rows()==0):
            $this->db->insert('payroll_transaction', $details);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    function generatePayrollProfile()
    {
        $p_em = $this->db->get('profile_employee');
        foreach ($p_em->result() as $p):
            $array = array(
                'pp_em_id'  => $p->employee_id,
                'pp_sg_id'  => $p->pg_id
            );
            $this->db->where('pp_em_id', $p->employee_id);
            $q = $this->db->get('payroll_profile');
            if($q->num_rows()==0):
                $this->db->insert('payroll_profile', $array);
            else:
                $this->db->where('pp_em_id', $p->employee_id);
                $this->db->update('payroll_profile', $array);
            endif;
        endforeach;
        return TRUE;
    }
    
    function getPayrollChargesByItem($item_id, $pc_code, $profile_id)
    {
        ($profile_id!=Null?$this->db->where('pc_profile_id',$profile_id):'');
        $this->db->where('pc_code',$pc_code);
        $this->db->where('pc_item_id',$item_id);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id','left');
        $q = $this->db->get('payroll_charges');
        return $q->row();
    }
    
    function getTotalPayrollChargesByItem($item_id, $pc_code)
    {
        
        $this->db->select('*');
        $this->db->select('SUM(pc_amount) as total');
        $this->db->where('pc_code',$pc_code);
        $this->db->where('pc_item_id',$item_id);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id','left');
        $q = $this->db->get('payroll_charges');
        return $q->row();
    }
    
    function getPayrollCharges($pc_code, $profile_id)
    {
        ($profile_id==NULL?"":$this->db->where('pc_profile_id',$profile_id));
        $this->db->where('pc_code',$pc_code);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id','left');
        ($profile_id==NULL?$this->db->group_by('pc_item_id'):'');
        $q = $this->db->get('payroll_charges');
        return $q->result();
    }
    
    public function setPayrollCharges($details, $profile_id, $item_id, $pc_code)
    {
        $this->db->where('pc_item_id', $item_id);
        $this->db->where('pc_profile_id', $profile_id);
        $this->db->where('pc_code', $pc_code);
        $q = $this->db->get('payroll_charges');
        if($q->num_rows()==0):
            $this->db->insert('payroll_charges', $details);
        else:
            $this->db->where('pc_item_id', $item_id);
            $this->db->where('pc_profile_id', $profile_id);
            $this->db->where('pc_code', $pc_code);
            $this->db->update('payroll_charges', $details);
        endif;
    }
    
    public function getDeductions()
    {
        $this->db->where('pi_item_cat', 0);
        $this->db->join('payroll_stat_ben','payroll_items.pi_item_id = payroll_stat_ben.stat_item_id','left');
        $q = $this->db->get('payroll_items');
        return $q->result();
    }
    
    
    public function getStatBen($sg_id, $statBen_id)
    {
        $this->db->where('stat_item_id', $statBen_id);
        $this->db->where('stat_sg_id', $sg_id);
        $q = $this->db->get('payroll_stat_ben');
        return $q->row();
    }
    
    public function setStatBen($details, $statBen, $salary)
    {
        $this->db->where('stat_item_id', $statBen);
        $this->db->where('stat_sg_id', $salary);
        $q = $this->db->get('payroll_stat_ben');
        if($q->num_rows()==0):
            $this->db->insert('payroll_stat_ben', $details);
            return TRUE;
        else:
            $this->db->where('stat_item_id', $statBen);
            $this->db->where('stat_sg_id', $salary);
            $this->db->update('payroll_stat_ben', $details);
            return TRUE;
        endif;
    }
    public function getPayrollItems($cat)
    {
        $this->db->where('pi_item_cat', $cat);
        $q = $this->db->get('payroll_items');
        return $q->result();
        
    }
    
    public function addPayrollItems($details, $itemName)
    {
        $this->db->where('pi_item_name', $itemName);
        $q = $this->db->get('payroll_items');
        if($q->num_rows()==0):
            $this->db->insert('payroll_items', $details);
            return TRUE;
        else:
            return FALSE;
        endif;
    }
    
    public function getDefaultDeductions()
    {
        $this->db->where('pi_item_cat', 0);
        $q = $this->db->get('payroll_items');
        return $q->result();
    }
    
    public function getPayrollReport()
    {
        $this->db->select('*');
        $this->db->from('profile');
        $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
        $this->db->join('profile_employee_salary_grade', 'profile_employee.pg_id = profile_employee_salary_grade.salary_grade', 'left');
        $this->db->order_by('profile.lastname', 'asc');
        $this->db->where('account_type !=', 1);
        $this->db->where('account_type !=', 4);
        $this->db->where('account_type !=', 5);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getPayrollPeriodByCode($code)
    {
        $this->db->where('per_id', $code);
        $q = $this->db->get('payroll_period');
        return $q->row();
    }
    
    public function getPayrollPeriod()
    {
        $q = $this->db->get('payroll_period');
        return $q->result();
    }
    
    public function setPayrollPeriod($fromDate, $toDate, $details)
    {
        $this->db->where('per_from', $fromDate);
        $this->db->where('per_to', $toDate);
        $p = $this->db->get('payroll_period');
        if($p->num_rows()>0):
            return FALSE;
        else:
            $this->db->insert('payroll_period', $details);
            return TRUE;
        endif;
    }
}
