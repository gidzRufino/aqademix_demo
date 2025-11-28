<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance_lma extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('finance_model_lma');
        $this->load->model('finance_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
    }
    
    function getAccountDue($sy = NULL, $limit=NULL, $offset=NULL)
    {
        $this->load->library('pagination');
       
        if($sy==NULL):
            $year = $this->session->userdata('school_year');
        else:
            $year = $sy;
        endif;
         //echo $year;
        if($this->uri->segment(5)==NULL):
            $seg = $this->uri->segment(5);
            $base_url = base_url('finance/finance_lma/getAccountDue/'.$year.'/0');
        else:
            $seg = $this->uri->segment(5);
            $base_url = base_url('finance/finance_lma/getAccountDue/'.$year);
        endif;
        $totalBalance = 0;
        $result = $this->finance_model_lma->getStudents(NULL,NULL,$year);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $result->num_rows();
        $config['per_page'] = 30;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';


        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();

        $page = $this->finance_model_lma->getStudents($config['per_page'], $seg, $year);
        //print_r($page->result());
        $data['students'] = $page->result();
        $data['school_year'] = $year;
        $data['modules'] = 'finance';
        $data['main_content'] = 'lma_collectible';
        echo Modules::run('templates/canteen_content', $data);
    }
    
    public function saveTransaction()
    {
        $school_year = $this->post('school_year');
        $semester = $this->post('sem');
        $or_num = $this->post('or_num');
        $st_id = $this->post('st_id');
        $transaction = $this->post('items');
        $transDate = $this->post('transDate');
        $receipt = $this->post('receipt');
        $t_remarks = $this->post('t_remarks');
        $transType = $this->post('transType');
        $chequeNumber = $this->post('chequeNumber');
        $bank = $this->post('bank');
        $count = count(json_decode($transaction));
        $final = json_decode($transaction);
        $column = array();
        $success = 0;
        for ($x = 0; $x < $count; $x++) {
            
            $items = explode('_', $final[$x]);
            $amount = $items[1];
            $tCharge = $items[0];
            if($tCharge=="pen"):
                $amount = $items[3];
                $transType = 3;
                $tCharge = 60; 
                $t_remarks = $items[2];
            endif;
            
            $details = array(
                'ref_number'        => $or_num,
                't_st_id'           => $st_id,
                't_em_id'           => $this->session->userdata('employee_id'),
                't_amount'          => $amount,
                't_charge_id'       => $tCharge,
                't_type'            => $transType,
                'bank_id'           => $bank,
                'tr_cheque_num'     => $chequeNumber,
                't_date'            => $transDate,
                't_sem'             => $semester,
                't_school_year'     => $school_year, 
                't_receipt_type'    => $receipt,
                't_remarks'         => $t_remarks
            );
            
            //array_push($column, $details);
            $result = $this->finance_model->saveTransaction($details);
            if(!$result):
            else:
                $success++;
                if($items[0]=="pen"):
                    //$this->updatePenalty($items[1], array('pen_isPaid' => 1, 'pen_date' => date('Y-m-d')));
                endif;
                Modules::run('web_sync/updateSyncController', 'c_finance_transactions', 'trans_id', $result, 'create', 6);
            endif;
        }
            if($this->post('isEnrolled')==0):
                $this->finance_model->updateStudentStatus($this->post('admission_id'));
            endif;
            if($success==$count):
                echo 'Successfully Saved';
            endif;
//         if($this->finance_model->saveTransaction($column)):
//            if($this->post('isEnrolled')==0):
//                $this->finance_model->updateStudentStatus($this->post('admission_id'));
//            endif;
//            echo 'Successfully Saved';
//        else:
//            echo 'Sorry Something went wrong';
//        endif;
        
    }
    
    function getTFPayment($st_id, $month, $rangeFrom = NULL)
    {
        $tfPayment = $this->finance_model_lma->getTFPayment($st_id, $month, $rangeFrom);
        return $tfPayment;
    }
    
    function getSchoolBusPayment($st_id)
    {
        $schoolBusPayment = $this->finance_model_lma->getSchoolBusPayment($st_id);
        return $schoolBusPayment;
    }
    
    function inCharges($item_id, $plan_id)
    {
        $inCharges = $this->finance_model_pisd->inCharges($item_id, $plan_id);
        return $inCharges;
    }
    
    function inExtraCharges($user_id, $item_id)
    {
        $inCharges = $this->finance_model_pisd->inExtraCharges($user_id, $item_id);
        return $inCharges;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year, $item_id=NULL)
    {
        $charges = $this->finance_model_pisd->getExtraFinanceCharges($st_id, $sem, $school_year, $item_id);
        return $charges;
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    
    function printSOA($option, $secIn = NULL)
    {
        if($option==0):
            $data['student'] = $this->finance_model_lma->getBasicStudent( base64_decode($secIn), $this->session->school_year);
            $data['st_id'] = base64_decode($secIn);
        else:
            $data['students'] = $this->finance_model_lma->getStudentPerSection($secIn, $this->session->school_year);
        endif;
        $this->load->view($option==0?'reports/lma_printSOAIndividual':'reports/lma_printSOASection', $data);
    }
    
    public function deleteFinancePenalty()
    {
        $pen_id = $this->post('trans_id');
        $remarks = $this->post('delete_remarks');
        if($this->finance_model_lma->deleteFinancePenalty($pen_id)):
            Modules::run('finance/saveFinanceLog', $this->session->employee_id, $remarks);
           echo 'Successfully Deleted';
        endif;
    }
    
    public function getPenalty($st_id, $status, $school_year=NULL, $month = NULL)
    {
        $pen = $this->finance_model_lma->getPenalty($st_id, $school_year, $status, $month);
        return $pen;
    }
    
    public function savePenalty($st_id, $month, $amount, $school_year=NULL)
    {
        $this->finance_model_lma->savePenalty($st_id, $month, $amount, $school_year);
    }
    
    public function updatePenalty($pen_id, $details)
    {
        $this->finance_model_lma->updatePenalty($pen_id, $details);
        return;
    }
    
    function checkBilling($student, $btype)
    {
        if($student->u_id==""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;
        
        $data['user_id'] = $user_id;
        $data['plan'] = Modules::run('finance/getPlanByCourse',$student->grade_id, 0);
        $data['charges'] = Modules::run('finance/financeChargesByPlan',0, $this->session->userdata('school_year'), 0, $data['plan']->fin_plan_id );
        $data['student'] = $student;
        $data['btype'] = $btype;
        
        $this->load->view('lma_statementOfAccount', $data);
    }
    
    public function getAmountDue($student, $btype, $totalCharges)
    {
       $yearlyPayment = 38000;
        $totalExtra = 0;
        $isPriviledge = FALSE;
        $totalDiscount = 0;
        $totalPayment = 0;
        $penalty = 0;
        $remainingMoney = 0;
        $status = 'Unpaid';
        $mop = Modules::run('finance/getMOP', $btype);


        $extraCharges = Modules::run('finance/getExtraFinanceCharges',$student->user_id, 0, $student->school_year);
        if($extraCharges->num_rows()>0):
            foreach ($extraCharges->result() as $ec):
                if($ec->category_id!=6):
                    $totalExtra += $ec->extra_amount;
                endif;
            endforeach;
        endif;


        $overAllCharges = $totalCharges + $totalExtra;

        $discount = Modules::run('finance/getTransactionByItemId', $student->st_id,NULL,$student->school_year,NULL,2);
        foreach ($discount->result() as $d):
            $totalDiscount += $d->t_amount;
        endforeach;
        if($student->st_type==1):
            $totalDiscount += 5000;
        endif;  
        $totalDiscount!=0?$totalDiscount:0;

        $chargesLessDiscount = $overAllCharges - $totalDiscount;

        $downpayment = $overAllCharges - $yearlyPayment;

        $remainingFee = $overAllCharges - $downpayment;

        $paymentTransaction = Modules::run('finance/getTransaction', $student->st_id, 0, $student->school_year);

        $startMonth = 6;
        $totalMonth = 10;
        $currentMonth = abs(date('m'));

        switch ($btype):
            case 1:
                $monthPassed = $currentMonth - $startMonth;
                $monthlyFee = $remainingFee/10;
                $numMonth = 10;
                $addMonth = 0;
            break;    
            case 2:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed+3;
                $monthlyFee = $remainingFee/4;
                $numMonth = 4;
                $addMonth = 2;

            break;    
            case 3:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed+5;
                $monthlyFee = $remainingFee/2;
                $numMonth = 2;
                $addMonth = 5;
            break;    
        endswitch;

        if($paymentTransaction->num_rows()>0):
            $balance = 0;
            foreach ($paymentTransaction->result() as $tr):
                if($tr->t_type<2 && $tr->category_id!=6):
                    $totalPayment += $tr->t_amount;
                endif;
            endforeach;
            if($student->st_type==1): 
                $isPriviledge = TRUE;
            endif;

       endif;


       if($dpBalance>0):
           $dpDue = $dpBalance;
           $totalPayment = 0;
       else:
           $totalPayment = $totalPayment;
       endif; 
       
        if($totalDiscount>0):
           $dpBalance = $downpayment - $totalDiscount;
           $dpDue = $dpBalance;
        else:
            $dpBalance = $downpayment;
            $dpDue = $dpBalance;
        endif;
        $remainingMoney = $totalPayment - $dpBalance;

        $payment = Modules::run('finance/billing/getTransactionByCategory', $student->st_id, 0, $student->school_year, 1);
        $totalTFPayment = $payment->amount;
        $rm = $remainingMoney;
        $tfpayment = 0;
        $remainingBalance = 0;
        //$totalTFPayment = $totalTFPayment/$monthlyFee;
        for($i = 1; $i<=$totalMonth; $i++):

            $monthNums = (($i+5)+$addMonth);
            
            $rm = $rm - $monthlyFee; // remaining money

            if(($rm+$monthlyFee)>0): //has money remaining
                if(($rm+$monthlyFee) < $monthlyFee):    
                    $tfpayment = $rm+$monthlyFee;
                else:
                    $tfpayment = $monthlyFee;
                endif;
            else:
                $tfpayment = 0;
            endif;
            
            $partialBalance = $monthlyFee - $tfpayment;
            
            switch ($btype):
                case 1:
                    $addM = 0;
                break;    
                case 2:
                    $addM = 1;
                break;    
                case 3:
                   $addM = 3;
                break;    
            endswitch;
           $addMonth = $addMonth + $addM;
           if($monthNums <= $currentMonth):
                $tfBalance += $partialBalance;
           endif;
        endfor;

        $schoolBusCharges = Modules::run('finance/getExtraFinanceCharges',$student->user_id, 0, $student->school_year);

        $schoolBusPayment = Modules::run('finance/finance_lma/getSchoolBusPayment', $student->uid);
        foreach ($schoolBusPayment->result() as $sbp):
            $schoolBusTotal += $sbp->t_amount;
        endforeach;

        $sbusRM = $schoolBusTotal;

        if($schoolBusCharges->num_rows()>0):
            foreach ($schoolBusCharges->result() as $ec):
                if($ec->category_id==6):
                    $sbusPayment = 0;
                    if($sbusRM > 0):
                        $sbusPayment = $ec->extra_amount;
                    endif;
                    $sbusBalance = $ec->extra_amount-$sbusPayment;

                    $sbusRM = $sbusRM - $ec->extra_amount;
                endif;
                $sbusBalance = 0;
            endforeach;
        endif;
        $json = array(
            'currentMonth'  => $currentMonth,
            'expected'      => $monthlyFee,
            'collected'     => $totalTFPayment,
            'due'           => $tfBalance
        );
        return json_encode($json);
    }
    
    function saveNotes()
    {
        $st_id = $this->post('st_id');
        $notes = $this->post('notes');
        $school_year = $this->post('school_year');
        $em_id = $this->session->employee_id;
        
        $details = array(
            'note_st_id'    => $st_id,
            'notes'         => $notes,
            'note_em_id'    => $em_id,
            'note_sy'       => $school_year
        );
        
        $result = $this->finance_model_lma->saveNotes($details, $st_id, $school_year);
        if($result):
            echo 'Notes Successfully Updated';
        else:
            echo 'Something went Wrong';
        endif;
    }
    
    function getNotes($st_id, $school_year=NULL)
    {
        $notes = $this->finance_model_lma->getNotes($st_id, $school_year);
        return $notes;
    }
    
   
   
}
