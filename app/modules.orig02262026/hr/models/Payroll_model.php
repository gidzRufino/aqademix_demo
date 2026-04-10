<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


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
class Payroll_model extends CI_Model
{

    function getAdditionalIncome($pc_code)
    {
        $this->db->where('pc_code', $pc_code);
        $this->db->where('pi_item_type', 1);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id', 'left');
        $this->db->group_by('payroll_charges.pc_item_id');
        $q = $this->db->get('payroll_charges');
        return $q->result();
    }

    function recalculatePayrollCharges($pc_code, $profile_id)
    {
        $this->db->where('pc_profile_id', $profile_id);
        $this->db->where('pc_code', $pc_code);
        if ($this->db->delete('payroll_charges')):
            $this->db->where('ptrans_profile_id', $profile_id);
            $this->db->where('ptrans_pay_code', $pc_code);
            $this->db->delete('payroll_transaction');
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    function getAmortValue($profile_id, $item_id)
    {
        $this->db->where('pa_status', 0);
        $this->db->where('pa_em_id', $profile_id);
        $this->db->where('pa_item_id', $item_id);
        $q = $this->db->get('payroll_amort_charges');
        return $q->row();
    }

    function updateAmortizationStatus($profile_id, $item_id, $amount, $pc_code)
    {
        $this->db->where('pa_status', 0);
        $this->db->where('pa_em_id', $profile_id);
        $this->db->where('pa_item_id', $item_id);
        $this->db->where('pa_pp_last_update !=', $pc_code);

        $q = $this->db->get('payroll_amort_charges');
        if ($q->num_rows() > 0):
            $paymentMade = $q->row()->pa_payment_made;
            if ($q->row()->pa_payment_made == $q->row()->pa_total_amount):
                $amortDetails = array('pa_status' => 1);
                $this->db->where('pa_id', $q->row()->pa_id);
                $this->db->update('payroll_amort_charges', $amortDetails);
                return FALSE;
            else:
                $amortDetails = array('pa_payment_made' => $paymentMade + $amount, 'pa_pp_last_update' => $pc_code);
                $this->db->where('pa_id', $q->row()->pa_id);
                $this->db->update('payroll_amort_charges', $amortDetails);
                return TRUE;
            endif;
        else:
            $this->db->where('pa_status', 0);
            $this->db->where('pa_em_id', $profile_id);
            $this->db->where('pa_item_id', $item_id);
            $this->db->where('pa_pp_last_update', $pc_code);
            $q2 = $this->db->get('payroll_amort_charges');

            $paymentMade = $q2->row()->pa_payment_made - $q2->row()->pa_amort_amount;

            $amortDetails = array('pa_payment_made' => $paymentMade + $amount);
            $this->db->where('pa_id', $q2->row()->pa_id);
            $this->db->update('payroll_amort_charges', $amortDetails);
        endif;
    }

    function saveAmortization($details)
    {
        $this->db->insert('payroll_amort_charges', $details);
        if ($this->db->affected_rows() > 0) {
            $status = TRUE;
            $id = $this->db->insert_id();
        } else {
            $status = FALSE;
            $id = 0;
        }
        return json_encode(array('status' => $status, 'id' => $id));
    }

    function getAmortizedDeduction($pc_code)
    {
        $this->db->where('pa_status', 0);
        $this->db->group_by('pa_item_id');
        $this->db->join('payroll_items', 'payroll_amort_charges.pa_item_id = payroll_items.pi_item_id', 'left');
        $q = $this->db->get('payroll_amort_charges');
        if ($q->num_rows() > 0):
            return $q->result();
        else:
            $this->db->where('pc_code', $pc_code);
            $this->db->where('pi_item_type', 2);
            $this->db->group_by('pi_item_id');
            $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id', 'left');
            $q1 = $this->db->get('payroll_charges');
            if ($q1->num_rows() > 0):
                return $q1->result();
            endif;
        endif;
    }


    function getPCode($dateFrom, $dateTo)
    {
        $this->db->where('per_from', $dateFrom);
        $this->db->where('per_to', $dateTo);
        $q = $this->db->get('payroll_period');
        return $q->row()->per_id;
    }

    function getPaymentByAmortID($pc_amort_id)
    {
        $this->db->select('*');
        $this->db->select('SUM(pc_amount) as totalAmount');
        $this->db->where('pc_amort_id', $pc_amort_id);
        $q = $this->db->get('payroll_charges');
        return $q->row();
    }


    function getPaymentTerms()
    {
        return $this->db->get('payroll_od_payment_terms')->result();
    }

    function getOtherDeductions()
    {
        $this->db->where('pi_item_cat', 2);
        $q = $this->db->get('payroll_items');
        return $q->result();
    }

    function loanAmortization($em_id, $status, $isgroup)
    {
        ($em_id != NULL ? $this->db->where('pa_em_id', $em_id) : '');
        ($status != NULL ? $this->db->where('pa_status', $status) : '');
        ($isgroup != 0 ? $this->db->group_by('pa_item_id') : '');
        $this->db->join('profile_employee', 'payroll_amort_charges.pa_em_id = profile_employee.employee_id', 'left');
        $this->db->join('payroll_items', 'payroll_amort_charges.pa_item_id = payroll_items.pi_item_id', 'left');
        $q = $this->db->get('payroll_amort_charges');
        return $q->result();
    }

    public function setAdditionalIncome($details, $profile_id, $item_id, $pc_code, $amount = NULL)
    {

        if ($amount == 0):
            $this->db->where('pc_item_id', $item_id);
            $this->db->where('pc_profile_id', $profile_id);
            $this->db->where('pc_code', $pc_code);
            $this->db->delete('payroll_charges');
        else:
            $this->db->where('pc_item_id', $item_id);
            $this->db->where('pc_profile_id', $profile_id);
            $this->db->where('pc_code', $pc_code);
            $q = $this->db->get('payroll_charges');
            if ($q->num_rows() == 0):
                $this->db->insert('payroll_charges', $details);
            else:
                $this->db->where('pc_item_id', $item_id);
                $this->db->where('pc_profile_id', $profile_id);
                $this->db->where('pc_code', $pc_code);
                $this->db->update('payroll_charges', $details);
            endif;
        endif;
    }

    function getCurrentListOfCharges($pc_code, $profile_id)
    {
        $this->db->where('pc_code', $pc_code);
        $this->db->where('pi_item_type !=', 1);
        ($profile_id != NULL ? $this->db->where('pc_profile_id', $profile_id) : "");
        $this->db->group_by('pc_item_id');
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id', 'left');
        $q = $this->db->get('payroll_charges');
        return $q->result();
    }

    function getTotalLeaveSpent($em_id, $type_id, $l_pp_id)
    {
        if ($l_pp_id == NULL):
            $this->db->select('SUM(l_num_hours) as totalLeaveSpent');
        endif;
        $this->db->where('l_em_id', $em_id);
        ($type_id != NULL ? $this->db->where('l_type_id', $type_id) : '');
        ($l_pp_id != NULL ? $this->db->where('l_pp_id', $l_pp_id) : '');
        $q = $this->db->get('payroll_leave_credits');
        return $q->row();
    }

    function updateLCBalance($em_id, $lc_available)
    {
        $this->db->where('employee_id', $em_id);
        $this->db->update('profile_employee', array('leave_credits' => $lc_available));
        return;
    }

    function updateLeaveCredit($lcAppDetails, $em_id, $pp_id, $type)
    {
        $this->db->where('l_em_id', $em_id);
        $this->db->where('l_type_id', $type);
        $this->db->where('l_pp_id', $pp_id);
        $q = $this->db->get('payroll_leave_credits');
        if ($q->num_rows() == 0):
            $data = array(
                'l_id'          => $this->eskwela->codeCheck('payroll_leave_credits', 'l_id', $this->eskwela->code()),
                'l_em_id'       => $lcAppDetails['l_em_id'],
                'l_type_id'     => $lcAppDetails['l_type_id'],
                'l_num_hours'   => $lcAppDetails['l_num_hours'],
                'l_pp_id'       => $lcAppDetails['l_pp_id'],
                'l_aprv_hr'     => $lcAppDetails['l_aprv_hr'],
                'l_aprv_date_hr' => $lcAppDetails['l_aprv_date_hr'],
                'l_aprv_fin'    => $lcAppDetails['l_aprv_fin']
            );
            $this->db->insert('payroll_leave_credits', $data);
            return TRUE;
        else:
            $this->db->where('l_em_id', $em_id);
            $this->db->where('l_type_id', $type);
            $this->db->where('l_pp_id', $pp_id);
            $this->db->update('payroll_leave_credits', $lcAppDetails);
            return TRUE;
        endif;
    }

    function checkPP($from, $to)
    {
        $this->db->where('per_from', $from);
        $this->db->where('per_to', $to);
        $p = $this->db->get('payroll_period');
        return $p->row();
    }

    function getSSSTableEquivalent()
    {
        return $this->db->get('payroll_sss_table')->result();
    }

    function fetchSSSTable($limit = null, $offset = null)
    {
        ($limit != '' || $offset != '' ? $this->db->limit($limit, $offset) : '');
        return $this->db->get('payroll_sss_table');
    }

    function getManHours($employee_id, $pp_id, $pmt_id)
    {
        $this->db->where('pmh_st_id', $employee_id);
        $this->db->where('pmh_pp_id', $pp_id);
        $this->db->where('pmh_pmt_id', $pmt_id);
        $q = $this->db->get('payroll_manhours');
        return $q->row();
    }

    function saveManHours($manHourDetails, $st_id, $pp_id, $pmt_id)
    {
        $this->db->where('pmh_em_id', $st_id);
        $this->db->where('pmh_pp_id', $pp_id);
        $this->db->where('pmh_pmt_id', $pmt_id);
        $q = $this->db->get('payroll_manhours');
        if ($q->num_rows() > 0):
            $this->db->where('pmh_em_id', $st_id);
            $this->db->where('pmh_pp_id', $pp_id);
            $this->db->where('pmh_pmt_id', $pmt_id);
            $this->db->update('payroll_manhours', $manHourDetails);
        else:
            $this->db->insert('payroll_manhours', $manHourDetails);
        endif;

        return TRUE;
    }

    function getManHourTypeByCat($cat_id)
    {
        $this->db->where('pmt_cat_id', $cat_id);
        $q = $this->db->get('payroll_manhours_type');
        return $q->result();
    }

    function getManHoursCat()
    {
        $this->db->where('pmc_id !=', 1);
        $q = $this->db->get('payroll_manhours_category');
        return $q->result();
    }

    function saveShifts($saveShiftDetails, $group_id, $shift_id = NULL)
    {
        $this->db->where('grp_id', $group_id);
        $this->db->update('payroll_shift_group', $saveShiftDetails);

        if ($shift_id != NULL):
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
        $this->db->join('payroll_shift', 'payroll_shift.ps_id = profile_employee.time_group_id', 'left');
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

    function getPayrollProfile($em_id)
    {
        $this->db->where('pp_em_id', $em_id);
        $q = $this->db->get('payroll_profile');
        return $q->row();
    }

    function deletePayrollCharges($profile_id, $item_id = null, $pc_code = null)
    {
        $this->db->where('pc_profile_id', $profile_id);
        $this->db->where('pc_code', $pc_code);
        ($item_id != null ? $this->db->where('pc_item_id', $item_id) : '');
        $this->db->delete('payroll_charges');
    }

    function releasePayroll($details, $profile_id, $pc_code)
    {
        $this->db->where('ptrans_profile_id', $profile_id);
        $this->db->where('ptrans_pay_code', $pc_code);
        if ($this->db->update('payroll_transaction', $details)):
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
        if ($q->num_rows() == 0):
            $data = array(
                'ptrans_id' => $this->eskwela->codeCheck('payroll_transaction', 'ptrans_id', $this->eskwela->code()),
                'ptrans_profile_id'    => $details['ptrans_profile_id'],
                'ptrans_pay_code'      => $details['ptrans_pay_code'],
                'ptrans_amount'        => $details['ptrans_amount'],
                'ptrans_timestamp'     => $details['ptrans_timestamp'],
                'ptrans_status'        => $details['ptrans_status']
            );
            $this->db->insert('payroll_transaction', $data);
            return TRUE;
        else:
            $this->db->where('ptrans_profile_id', $em_id);
            $this->db->where('ptrans_pay_code', $pc_code);
            $this->db->update('payroll_transaction', $details);
            return FALSE;
        endif;
    }

    function generatePayrollProfile()
    {
        $p_em = $this->db->get('profile_employee');
        foreach ($p_em->result() as $p):
            $array = array(
                'pp_id' => $this->eskwela->code(),
                'pp_em_id' => $p->employee_id,
                'pp_sg_id' => $p->pg_id
            );
            $this->db->where('pp_em_id', $p->employee_id);
            $q = $this->db->get('payroll_profile');
            if ($q->num_rows() == 0):
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
        ($profile_id != Null ? $this->db->where('pc_profile_id', $profile_id) : '');
        $this->db->where('pc_code', $pc_code);
        $this->db->where('pc_item_id', $item_id);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id', 'left');
        $q = $this->db->get('payroll_charges');
        return $q;
    }

    public function getPayrollDefaults($paySched)
    {
        ($paySched != NULL ? $this->db->where('pay_schedule', $paySched) : '');
        $this->db->where('pi_is_default !=', 0);
        $q = $this->db->get('payroll_items');
        return $q->result();
    }

    function getPayrollCharges($pc_code, $profile_id)
    {
        //		 $this->db->where('pi_default !=', 0);
        //		 $this->db->where('pi_is_default', 0);
        ($profile_id == NULL ? "" : $this->db->where('pc_profile_id', $profile_id));
        $this->db->where('pc_code', $pc_code);
        $this->db->join('payroll_items', 'payroll_charges.pc_item_id = payroll_items.pi_item_id', 'left');
        ($profile_id == NULL ? $this->db->group_by('payroll_charges.pc_item_id') : '');
        $q = $this->db->get('payroll_charges');
        return $q->result();
    }

    public function setPayrollCharges($details, $profile_id, $item_id, $pc_code, $amount = NULL, $pc_amort_id)
    {

        if ($amount == 0):
            $this->db->where('pc_item_id', $item_id);
            $this->db->where('pc_profile_id', $profile_id);
            $this->db->where('pc_code', $pc_code);
            $this->db->where('pc_amort_id', $pc_amort_id);
            $this->db->delete('payroll_charges');
        else:
            $this->db->where('pc_profile_id', $profile_id);
            $this->db->where('pc_item_id', $item_id);
            $this->db->where('pc_code', $pc_code);
            $this->db->where('pc_amort_id', $pc_amort_id);
            $q = $this->db->get('payroll_charges');
            if ($q->num_rows() == 0):
                $this->db->insert('payroll_charges', $details);
            else:
                $this->db->where('pc_item_id', $item_id);
                $this->db->where('pc_profile_id', $profile_id);
                $this->db->where('pc_code', $pc_code);
                $this->db->update('payroll_charges', $details);
            endif;
        endif;
    }

    public function getDeductions()
    {
        $this->db->where('pi_item_cat', 0);
        $this->db->join('payroll_stat_ben', 'payroll_items.pi_item_id = payroll_stat_ben.stat_item_id', 'left');
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
        if ($q->num_rows() == 0):
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
        $q = $this->db->get('payroll_items');
        return $q->result();
    }

    public function addPayrollItems($details, $itemName)
    {
        $this->db->where('pi_item_name', $itemName);
        $q = $this->db->get('payroll_items');
        if ($q->num_rows() == 0):
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

    public function getPayrollReport($pp_id, $group = NULL)
    {
        $this->db->select('*');
        $this->db->where('pmh_pp_id', $pp_id);
        ($group == NULL ? $this->db->group_by('pmh_em_id') : $this->db->where('pmh_em_id', $group));
        $query = $this->db->get('payroll_manhours');
        return $query->result();
    }
    //	 public function getPayrollReport() {
    //		 $this->db->select('*');
    //		 $this->db->from('profile');
    //		 $this->db->join('profile_employee', 'profile.user_id = profile_employee.user_id', 'left');
    //		 $this->db->join('profile_position', 'profile_employee.position_id = profile_position.position_id', 'left');
    //		 $this->db->join('payroll_salary_type', 'profile_employee.pg_id = payroll_salary_type.pst_id', 'left');
    //		 $this->db->order_by('profile.lastname', 'asc');
    //		 $this->db->where('account_type !=', 1);
    //		 $this->db->where('account_type !=', 4);
    //		 $this->db->where('account_type !=', 5);
    //		 $query = $this->db->get();
    //		 return $query->result();
    //	 }

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
        if ($p->num_rows() > 0):
            return FALSE;
        else:
            $this->db->insert('payroll_period', $details);
            return TRUE;
        endif;
    }

    public function checkDeduction($pcCode, $profileID, $itemID)
    {
        return $this->db->select('*')
            ->from('payroll_charges')
            ->where('pc_profile_id', $profileID)
            ->where('pc_code', $pcCode)
            ->where('pc_item_id', $itemID)
            ->get()->result();
    }

    public function updateDeduction($pcCode, $profileID, $data)
    {
        $this->db->where('pc_code', $pcCode)
            ->where('pc_profile_id', $profileID)
            ->where('pc_item_id', $data['pc_item_id'])
            ->update('payroll_charges', $data);
        return TRUE;
    }

    public function insertDeduction($pcCode, $profileID, $data)
    {
        $this->db->set('pc_profile_id', $profileID)
            ->set('pc_code', $pcCode)
            ->insert('payroll_charges', $data);
        return TRUE;
    }

    public function getPayrollChargesById($userProfile, $itemID, $pcCode)
    {
        return $this->db->where('pc_item_id', $itemID)
            ->where('pc_profile_id', $userProfile)
            ->where('pc_code', $pcCode)
            ->get('payroll_charges');
    }

    function deletePayrollByEmployee($employee_id, $pc_code)
    {
        $this->db->where('pmh_em_id', $employee_id);
        $this->db->where('pmh_pp_id', $pc_code);
        $this->db->delete('payroll_manhours');

        return ($this->db->affected_rows() > 0 ? TRUE : FALSE);
    }

    function deleteLeaveCreditsByEmployee($employee_id, $pc_code)
    {
        $this->db->where('l_em_id', $employee_id);
        $this->db->where('l_pp_id', $pc_code);
        $this->db->delete('payroll_leave_credits');
    }

    function attendanceCheck($id, $date, $year = NULL)
    {
        if ($date == ''):
            $month = strtolower(date('M', strtotime(date("Y-m-d"))));
        else:
            $month = strtolower(date('M', strtotime($date)));
        endif;
        $this->db = $this->eskwela->db($year);
        $this->db->select('*');
        $this->db->from('attendance_sheet_' . $month);
        if ($date == ""):
            $this->db->where('date', date("Y-m-d"));
        else:
            $this->db->where('date', $date);
        endif;
        $this->db->where('att_st_id', $id);
        $query = $this->db->get();

        return $query;
    }

    function saveOverTime($emp_id, $date_id, $hours, $is_approve = 0, $approve_by)
    {
        $this->db->where('otd_emp_id', $emp_id);
        $this->db->where('otd_date_id', $date_id);
        if ($this->db->get('payroll_overtime')->num_rows() > 0) {
            $data = array(
                'otd_num_hours' => $hours,
                'is_approve' => $is_approve,
                'approved_by' => $approve_by,
                'approved_date_time' => ($is_approve == 0 ? '' : date("Y-m-d h:i:sa"))
            );
            $this->db->where('otd_emp_id', $emp_id);
            $this->db->where('otd_date_id', $date_id);
            $this->db->update('payroll_overtime', $data);
        } else {
            $data = array(
                'otd_emp_id' => $emp_id,
                'otd_date_id' => $date_id,
                'otd_num_hours' => $hours
            );
            $this->db->insert('payroll_overtime', $data);
        }
    }

    function getOverTimeByDate($emp_id, $date_id)
    {
        $this->db->where('otd_emp_id', $emp_id);
        $this->db->where('otd_date_id', $date_id);
        $this->db->join('profile_employee', 'profile_employee.employee_id = payroll_overtime.otd_emp_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        return $this->db->get('payroll_overtime');
    }

    function getAttDate($start, $end)
    {
        $m = strtolower(date('M', strtotime($start)));
        $this->db->select('*');
        $this->db->where("date between '" . $start . "' and'" . $end . "'");
        $this->db->order_by('att_st_id', 'ASC');
        return $this->db->get('attendance_sheet_' . $m);
    }

    function updateOverTime($emp_id, $date_id, $is_approve, $opt)
    {
        $this->db->where('otd_emp_id', $emp_id);
        $this->db->where('otd_date_id', $date_id);
        if ($this->db->get('payroll_overtime')->num_rows() > 0) {
            $data = array(
                'is_approve' => $is_approve,
                'approved_by' => ($opt != 0 ? $this->session->employee_id : ''),
                'approved_date_time' => ($opt != 0 ? date('Y-m-d H:i:s') : '')
            );
            $this->db->where('otd_emp_id', $emp_id);
            $this->db->where('otd_date_id', $date_id);
            $this->db->update('payroll_overtime', $data);
        };

        return ($this->db->affected_rows() > 0 ? TRUE : FALSE);
    }

    function saveLeaveReq($emp_id, $date, $reason, $duration)
    {
        $this->db->where('pld_emp_id', $emp_id);
        $this->db->where('pld_date', $date);
        if ($this->db->get('payroll_leave_dates')->num_rows() > 0):
            $data = array(
                'pld_reason_of_leave' => $reason,
                'pld_num_hours' => $duration
            );
            $this->db->where('pld_emp_id', $emp_id);
            $this->db->where('pld_date', $date);
            $this->db->update('payroll_leave_dates', $data);
        else:
            $data = array(
                'pld_emp_id' => $emp_id,
                'pld_date' => $date,
                'pld_num_hours' => $duration,
                'pld_reason_of_leave' => $reason,
                'pld_date_filed' => date('Y-m-d H:i:s')
            );
            $this->db->insert('payroll_leave_dates', $data);
        endif;
        return true;
    }

    function getSumLeaveCredited($emp_id)
    {
        $this->db->select('SUM(pld_num_hours) as leaveCredited');
        $this->db->where('pld_emp_id', $emp_id);
        $this->db->where('pld_is_approved', 1);
        return $this->db->get('payroll_leave_dates')->row();
    }

    function fetchLeaveList($emp_id = null)
    {
        $this->db->select('*');
        ($emp_id != null ? $this->db->where('pld_emp_id', $emp_id) : '');
        $this->db->join('profile_employee', 'profile_employee.employee_id = payroll_leave_dates.pld_emp_id', 'left');
        $this->db->join('profile', 'profile.user_id = profile_employee.user_id', 'left');
        $this->db->order_by('pld_date', 'ASC');
        return $this->db->get('payroll_leave_dates')->result();
    }

    function getLeaveByDates($from, $to, $emp_id)
    {
        $this->db->select('*');
        $this->db->where('pld_emp_id', $emp_id);
        $this->db->where("pld_date between '" . $from . "' and'" . $to . "'");
        return $this->db->get('payroll_leave_dates')->result();
    }

    function updateLeave($id, $value, $user, $opt)
    {
        $data = array(
            'pld_is_approved' => $value,
            'pld_approve_by' => ($opt != 3 ? $user : ''),
            'pld_approved_date' => ($opt != 3 ? date('Y-m-d H:i:s') : '')
        );

        $this->db->where('pld_id', $id);
        $this->db->update('payroll_leave_dates', $data);
        if ($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }

    function updateSSContTable($id, $value)
    {
        $this->db->where('esk_payroll_sss_table_code', $id);
        $this->db->update('payroll_sss_table', array('ssst_ee' => $value));
        if ($this->db->affected_rows() > 0):
            return true;
        else:
            return false;
        endif;
    }
}
