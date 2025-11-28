<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Payroll
 *
 * @author genru
 */
class Loans extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('loans_model');
        $this->load->library('pdf');

        date_default_timezone_set("Asia/Manila");
    }

    private function post($name) {
        return $this->input->post($name);
    }

    public function deleteLoanApplication() {
        $ref_number = $this->post('ref_number');

        if (json_decode($this->loans_model->deleteLoanApplication($ref_number))->status):
            echo json_decode($this->loans_model->deleteLoanApplication($ref_number))->msg;
        endif;
    }

    public function editLoanSettings() {
        $details = array(
            'clt_interest' => $this->post('interest'),
            'clt_service_charge' => $this->post('serviceCharge'),
            'clt_overdue_penalty' => $this->post('penalty')
        );

        if ($this->loans_model->editLoanSettings($details, $this->post('clt_id'))):
            echo 'Edit Successfully Done';
        else:
            echo 'Something went wrong';
        endif;
    }

    public function getOutstandingBalance($account_number, $lrn = NULL) {
        $balance = $this->loans_model->getOutstandingBalance($account_number, $lrn);
        return $balance;
    }

    public function getTotalLoanPayment($lrn, $account_number = NULL) {
        $payments = $this->loans_model->getTotalLoanPayment($lrn, $account_number);
        return $payments;
    }

    public function getLoanAmortStatus($lad_id) {
        $status = $this->loans_model->getLoanAmortStatus($lad_id);
        return $status;
    }

    public function getPersonalLoanDue($account_number, $lrn = NULL, $startDate = NULL, $endDate = NULL, $loan_type = NULL, $status = NULL) {

        $totalLoanPayment = 0;
        $totalBalance = 0;
        $loanList = $this->loans_model->getPersonalLoanBalance($lrn, $endDate, $status);
        $personalLoan = $this->loans_model->getPersonalLoanBalance($lrn, $endDate);

        $basicLoanDetails = $this->loans_model->getLoanDetails($lrn);

        $loanPayment = $this->getTotalLoanPayment($lrn, $account_number);
        foreach ($loanPayment->result() as $lp):
            $totalLoanPayment += $lp->cft_trans_amount;
        endforeach;

        $totalLoanBalance = trim($basicLoanDetails->ld_total_amortization);
        $expectedPayment = trim($basicLoanDetails->ld_weekly_amortization * $personalLoan->num_rows());

        switch (TRUE):
            case $totalLoanPayment == 0:
                $totalBalance = $expectedPayment;
                break;
            case $totalLoanPayment == $expectedPayment:
                $totalBalance = $basicLoanDetails->ld_weekly_amortization;
                break;
            case $totalLoanPayment > $expectedPayment:
                $totalBalance = 0;
                break;
            case $totalLoanPayment < $expectedPayment:
                $totalBalance = $expectedPayment - $totalLoanPayment;
                break;
            default:
                $totalBalance = $basicLoanDetails->ld_weekly_amortization;
                break;
        endswitch;

        return $totalBalance;
    }

    public function getPersonalLoanBalance($account_number, $lrn = NULL, $startDate = NULL, $endDate = NULL, $loan_type = NULL, $status = NULL) {
        $loanList = $this->loans_model->getPersonalLoan($account_number, $lrn, $startDate, $endDate, $loan_type, $status);
        $totalPayment = 0;
        $totalBalance = 0;
        $loanBalance = 0;

        if ($loanList->result()):
            foreach ($loanList->result() as $ll):
                $totalBalance += $ll->lad_balance;
                $loanPayment = $this->getTotalLoanPayment($ll->ld_ref_number, $account_number);

                foreach ($loanPayment->result() as $lp):
                    $totalPayment += $lp->cft_trans_amount;
                endforeach;
            endforeach;

            $loanBalance = $totalBalance - $totalPayment;
        endif;

        //echo $totalPayment;
        return $loanBalance;
    }

    public function getLoanIndividualList($startDate, $endDate, $user_id = NULL, $loan_type = NULL, $status = NULL) {
        $loanList = $this->loans_model->getLoanIndividualList($user_id, $startDate, $endDate, $loan_type, $status);
        //$this->getIndividualLoanList($loanList->result());
        return $loanList;
    }

    public function getIndividualLoanList($account_number, $endDate, $loan_type = NULL) {
        $loanList = $this->loans_model->getIndividualLoanList($account_number, $endDate, $loan_type);
        $totalPayment = 0;
        $totalBalance = 0;

        $loanPayment = $this->getTotalLoanPayment($loanList->ld_ref_number, $account_number);
        $personalLoan = $this->loans_model->getPersonalLoanBalance($loanList->ld_ref_number, $endDate);

        $expectedPayment = trim($loanList->ld_weekly_amortization * $personalLoan->num_rows());

        foreach ($loanPayment->result() as $lp):
            $totalPayment += $lp->cft_trans_amount;
        endforeach;

        echo $loanList->ld_account_num . ' | ' . $loanList->ld_ref_number . ' | ' . $expectedPayment . ' | ' . $loanList->lad_date . ' | --  ' . $totalPayment . '<br />';

        if ($totalPayment == $expectedPayment):
            $totalBalance = $loanList->ld_weekly_amortization;
        elseif ($totalPayment < $totalPayment):
            $totalBalance = $expectedPayment - $totalPayment;
        elseif ($totalPayment > $totalPayment):
            $totalBalance = 0;
        elseif ($totalPayment == 0):
            $totalBalance = $expectedPayment;
        endif;

        echo $totalBalance;
    }

    public function getLoanList($startDate, $endDate) {
        $loanList = $this->loans_model->getLoanList($startDate, $endDate);
        return $loanList;
    }

    public function getPersonalLoan($account_number) {
        $loanList = $this->loans_model->getPersonalLoan($account_number);
        return $loanList;
    }

    public function getLoanReleasedDropDown($id = NULL) {
        $loans = $this->loans_model->loanReleased($id);
        echo '<option>Select Loan Type</option>';
        foreach ($loans as $l):
            ?>
            <option value="<?php echo $l->ld_ref_number; ?>"><?php echo $l->clt_type; ?></option>
            <?php
        endforeach;
    }

    public function getLoanReleased($id = NULL) {
        $loans = $this->loans_model->loanReleased($id);
        return $loans;
    }

    public function releaseLoan() {
        $name = $this->post('name');
        $refNumber = $this->post('refNumber');
        $payType = $this->post('releaseIn');
        $profile_id = $this->post('profile_id');
        $accountNumber = $this->post('accountNumber');
        $amount = $this->post('netProceed');
        $bank = ($payType == 1 ? $this->post('bank') : 0);
        $cheque = ($payType == 1 ? $this->post('chequeNumber') : '');
        $trans = 'LD-' . date('ymdgis');
        $transType = 5;
        $gl_type = 0;

        $success = $this->saveCoopTransaction($profile_id, $accountNumber, $trans, $transType, $amount, $refNumber, $gl_type, $payType, $bank, $cheque);
        if ($success):
            $ldDetails = array('ld_status' => 2, 'ld_date_released' => date('Y-m-d g:i:s'), 'ld_released_trans_num' => $trans);
            $this->loans_model->updateLoanDetails($ldDetails, $refNumber);

            $msg = 'Release Loan to ' . $name . ' amounting to ' . number_format($amount, 2, '.' . ',') . ' with reference number ' . $refNumber . ' and is released by ' . $this->session->name;
            Modules::run('notification_system/sendNotification', 3, 3, 'System', 2, $msg, date('Y-m-d g:i:s'));

            echo 'Loan Details Successfully Updated. Loan successfully released';
        endif;
    }

    public function saveCoopTransaction($profile_id, $accountNumber, $trans, $transType, $amount, $refNumber, $gl_type, $payType, $bank = 0, $cheque = NULL, $remarks = NULL, $or_number = NULL) {
        $details = array(
            'cft_profile_id' => $profile_id,
            'cft_account_no' => $accountNumber,
            'cft_trans_num' => $trans,
            'cft_or_number' => $or_number,
            'cft_trans_amount' => $amount,
            'cft_lrn' => $refNumber,
            'cft_trans_type' => $transType,
            'cft_gl_type' => $gl_type,
            'cft_trans_date' => date('Y-m-d g:i:s'),
            'cft_remarks' => $remarks,
            'cft_payment_type' => $payType,
            'cft_bank_id' => $bank,
            'cft_cheque_num' => $cheque,
            'cft_teller_id' => $this->session->employee_id
        );

        if ($this->loans_model->saveCoopTransaction($details)):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    public function disApprovedLoan() {
        $user_id = $this->post('user_id');
        $ref_number = $this->post('ref_number');

        $details = array(
            'cla_aprv_by_1' => $user_id,
            'cla_date_aprv_1' => date('Y-m-d g:i:s')
        );

        if ($this->loans_model->approvedLoan($details, $user_id, $ref_number)):
            $ldDetails = array('ld_status' => 0, 'ld_date_approved' => date('Y-m-d g:i:s'));
            $this->loans_model->updateLoanDetails($ldDetails, $ref_number);

            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Declined'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Something Went Wrong'));
        endif;
    }

    public function approvedLoan() {
        $cad_id = $this->post('cad_id');
        $ref_number = $this->post('ref_number');
        $loanType = $this->post('loanType');
        $accountNumber = $this->post('accountNumber');

        if ($loanType == 1):
            if ($this->saveCoopTransaction($cad_id, $accountNumber, 'CBU-' . date('ymdgis'), 6, 50, $ref_number, 1, 0, 0, 0)):
                $column = 'cad_share_capital';
                $value = 50;
                Modules::run('coopmanagement/updateAccountInfo', $column, $value, $accountNumber);
            endif;
        endif;

        $details = array(
            'cla_aprv_by_1' => $user_id,
            'cla_date_aprv_1' => date('Y-m-d g:i:s')
        );

        if ($this->loans_model->approvedLoan($details, $user_id, $ref_number)):
            $ldDetails = array('ld_status' => 1, 'ld_date_approved' => date('Y-m-d g:i:s'));
            $this->loans_model->updateLoanDetails($ldDetails, $ref_number);

            echo json_encode(array('status' => TRUE, 'msg' => 'Successfully Approved'));
        else:
            echo json_encode(array('status' => FALSE, 'msg' => 'Something Went Wrong'));
        endif;
    }

    public function index() {
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/default';
        echo Modules::run('templates/main_content', $data);
    }

    public function settings() {
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/settings';
        echo Modules::run('templates/main_content', $data);
    }

    public function getAmortizationTable($refNumber) {
        $amort = $this->loans_model->getAmortizationTable($refNumber);
        return $amort;
    }

    public function getLoanDetails($referenceNumber) {
        $details = $this->loans_model->getLoanDetails($referenceNumber);
        return $details;
    }

    public function loanDetails($id, $referenceNumber) {
        $data['id'] = base64_decode($id);
        $data['loanDetails'] = $this->getLoanDetails(base64_decode($referenceNumber));
        $data['amortTable'] = $this->getAmortizationTable(base64_decode($referenceNumber));
        $data['modules'] = 'coopmanagement';
        $data['lrn'] = base64_decode($referenceNumber);
        $data['main_content'] = 'loanmanagement/loanDetails';
        echo Modules::run('templates/canteen_content', $data);
    }

    public function forDisbursement() {
        $data['forDisbursement'] = $this->loans_model->loansForDisbursement();
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/loansForDisbursment';
        echo Modules::run('templates/main_content', $data);
    }

    public function pending() {
        $data['pendingLoans'] = $this->loans_model->getPendingLoans();
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/pendingLoan';
        echo Modules::run('templates/main_content', $data);
    }

    public function loanReleased() {
        $data['loanReleased'] = $this->loans_model->loanReleased();
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/loanList';
        echo Modules::run('templates/main_content', $data);
    }

    public function getLoanStatus($status) {
        $loans = $this->loans_model->getLoanStatus($status);
        return $loans;
    }

    public function saveLoan() {
        $items = $this->post('items');
        $refNumber = $this->post('refNumber');
        $serviceCharge = $this->post('serviceCharge');
        $loanType = $this->post('loanType');
        $clpp = $this->post('clpp');
        $principalAmount = $this->post('principalAmount');
        $accountNumber = $this->post('accountNumber');
        $maturityDate = $this->post('maturityDate');
        $interestPerWeek = $this->post('interestPerWeek');
        $weeklyAmortization = $this->post('weeklyAmortization');
        $comaker1 = $this->post('comaker1');
        $comaker2 = $this->post('comaker2');

        $count = count(json_decode($items));
        $final = json_decode($items);

        $loanDetails = array(
            'ld_ref_number' => $refNumber,
            'ld_account_num' => $accountNumber,
            'ld_loan_date' => $this->post('dateApplied'),
            'ld_loan_type' => $loanType,
            'ld_weekly_amortization' => $weeklyAmortization,
            'ld_total_amortization' => $weeklyAmortization * $count,
            'ld_principal_amount' => $principalAmount,
            'ld_terms' => $count / 4,
            'ld_mop' => 1,
            'ld_interest' => $interestPerWeek,
            'ld_clpp' => $clpp,
            'ld_service_fee' => $serviceCharge,
            'ld_maturity_date' => $maturityDate,
            'ld_comaker_account' => $comaker1,
            'ld_comaker_account_2' => $comaker2,
        );

        $transactionSuccess = $this->loans_model->saveLoanTransaction($loanDetails);

        if ($transactionSuccess):

            $approverDetails = array(
                'cla_ref_number' => $refNumber
            );

            $this->loans_model->saveApprover($approverDetails);

            $success = 0;
            for ($x = 0; $x < $count; $x++) {
                $items = explode(';', $final[$x]);

                $details = array(
                    'lad_ref_num' => $refNumber,
                    'lad_date' => $items[0],
                    'lad_balance' => $items[1] + $weeklyAmortization,
                    'lad_status' => 0,
                    'lad_payment' => 0
                );

                $result = $this->loans_model->saveAmortization($details);
                if (!$result):
                else:
                    $success++;
                //Modules::run('web_sync/updateSyncController', 'c_finance_transactions', 'trans_id', $result, 'create', 6);
                endif;
            }

            if ($success == $count):
                $msg = $accountNumber . ' apply for loan with reference #: ' . $refNumber;
                Modules::run('main/logActivity', 'LOAN Application', $msg, $this->session->employee_id);
                echo json_encode(array('msg' => 'Successfully Added'));
            endif;
        endif;
    }

    public function loadAmortizationSample() {
        $data['dateApplied'] = $this->post('dateApplied');
        $data['referenceNumber'] = date('ymdgis');
        $data['principal'] = $this->post('principal');
        $data['interest'] = $this->post('interest');
        $data['terms'] = $this->post('terms');
        $data['lpp'] = $this->post('clpp');
        $data['loanType'] = $this->post('loanType');
        $data['serviceCharge'] = $this->post('serviceCharge');
        $this->load->view('loanmanagement/loanAmortizationSample', $data);
    }

    public function calculateAmortization($profile_id, $accountNumber, $principal, $terms, $loanType, $dateApplied, $maturityDate, $comaker1 = NULL, $comaker2 = NULL) {
        $lT = $this->getLoanTypeById($loanType);
        $interest = $lT->clt_interest;
        $serviceCharge = $lT->clt_service_charge;
        $lpp = $lT->clt_clpp;
        $cbu = ($loanType == 1 ? 50 : 0);
        $numPayments = $terms * 4;
        
        $randHour = rand(0, 23);
        $randMin = rand(1, 60);
        $randSec = rand(1, 60);
        
        $randTime = $randHour.($randMin<10?'0'.$randMin:$randMin).($randSec<10?'0'.$randSec:$randSec);
        
        $refNumber = date('ymd', strtotime($dateApplied)).$randTime;
        $amortization = $principal + (($principal * $interest) * $terms) + ($loanType == 2 ? ($principal * $serviceCharge) : 0);

        $netProceed = (($principal - ($principal * $serviceCharge)) - $lpp) - $cbu;

        $balance_due = $amortization;


        $principalPerWeek = $principal / $numPayments;
        $interestPerWeek = ($principal * $interest) * $terms / $numPayments;
        $serviceChargePerWeek = ($loanType == 2 ? ($principal * $serviceCharge) / $numPayments : 0);
        $weeklyAmortization = $principalPerWeek + $interestPerWeek + $serviceChargePerWeek;


        $loanDetails = array(
            'ld_ref_number' => $refNumber,
            'ld_account_num' => $accountNumber,
            'ld_loan_date' => $dateApplied,
            'ld_loan_type' => $loanType,
            'ld_weekly_amortization' => $weeklyAmortization,
            'ld_total_amortization' => $weeklyAmortization * $numPayments,
            'ld_principal_amount' => $principal,
            'ld_terms' => $numPayments / 4,
            'ld_mop' => 1,
            'ld_interest' => $interestPerWeek,
            'ld_clpp' => $lpp,
            'ld_service_fee' => $serviceCharge,
            'ld_maturity_date' => $maturityDate,
            'ld_comaker_account' => $comaker1,
            'ld_comaker_account_2' => $comaker2,
        );

        $transactionSuccess = $this->loans_model->saveLoanTransaction($loanDetails);

        if ($transactionSuccess):

            $approverDetails = array(
                'cla_ref_number' => $refNumber
            );

            $this->loans_model->saveApprover($approverDetails);
            $trans = 'LD-' .$refNumber;
            $transType = 5;
            $gl_type = 0;

            $success = $this->saveCoopTransaction($profile_id, $accountNumber, $trans, $transType, $netProceed, $refNumber, $gl_type, 0, 0, '');
            if ($success):
                $ldDetails = array('ld_status' => 2, 'ld_date_released' => date('Y-m-d g:i:s'), 'ld_released_trans_num' => $trans);
                $this->loans_model->updateLoanDetails($ldDetails, $refNumber);
            endif;
        endif;

        for ($amort = 1; $amort <= $numPayments; $amort++):
            $a = $amort;
            $date = Modules::run('coopmanagement/getImportedAmortizationDate', $dateApplied, $a);

            $balance_due = $balance_due - $weeklyAmortization;
            
            $details = array(
                'lad_ref_num' => $refNumber,
                'lad_date' => $date->format('Y-m-d'),
                'lad_balance' => $balance_due + $weeklyAmortization,
                'lad_status' => 0,
                'lad_payment' => 0
            );

            $this->loans_model->saveAmortization($details);




        endfor;
    }

    public function loadLoanForm($clt_id, $date) {
        $data['dateApplied'] = $date;
        $data['clt_id'] = $clt_id;
        $data['loanType'] = $this->loans_model->getLoanTypeById($clt_id);
        $this->load->view('loanmanagement/loanDetailsForm', $data);
    }

    public function getLoanTypeById($clt_id) {
        $type = $this->loans_model->getLoanTypeById($clt_id);
        return $type;
    }

    public function getLoanTypes() {
        $type = $this->loans_model->getLoanTypes();
        return $type;
    }

    public function overidePayment() {
        $lad_id = $this->post('lad_id');
        $details = array('lad_status' => 3, 'lad_remarks' => base64_decode($this->session->employee_id) . '_' . date('Y-m-d g:i:s'));
        if ($this->loans_model->overidePayment($lad_id, $details)):
            echo 'Successfully Overwritten';
        else:
            echo 'Something went wrong';
        endif;
    }

    public function application($id = NULL) {

        $data['id'] = base64_decode($id);
        $data['loanTypes'] = $this->getLoanTypes();
        $data['modules'] = 'coopmanagement';
        $data['main_content'] = 'loanmanagement/loanApplication';
        echo Modules::run('templates/main_content', $data);
    }
    
    public function deleteLoanType($type, $passCode)
    {
        if($passCode==2134):
            $this->db->where('ld_loan_type', $type);
            $loans = $this->db->get('coop_loan_details');
            $x = 0;
            foreach($loans->result() as $l):
                $x++;
                $this->db->where('lad_ref_num', $l->ld_ref_number);
                $this->db->delete('coop_loan_amortization');
                
                $this->db->where('cla_ref_number', $l->ld_ref_number);
                $this->db->delete('coop_loan_approver');
                
                $this->db->where('cft_lrn', $l->ld_ref_number);
                $this->db->delete('coop_transaction');
                
                $this->db->where('ld_ref_number', $l->ld_ref_number);
                $this->db->delete('coop_loan_details');
                
            endforeach;
            
            echo "Deleted $x number of Loans and Loan Transactions";
        else:
            die('Sorry, Access code Incorrect');
        endif;
    }

}
