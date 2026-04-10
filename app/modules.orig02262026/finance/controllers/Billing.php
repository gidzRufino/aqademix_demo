<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Billing extends MX_Controller
{
    //put your code here


    function __construct()
    {
        parent::__construct();
        $this->load->model('finance_model');
        $this->load->model('finance_model_reports');
        $this->load->library('pagination');
        $this->load->library('Pdf');
    }

    private function post($name)
    {
        return $this->input->post($name);
    }

    public function deleteFinancePenalty()
    {
        $pen_id = $this->post('trans_id');
        $remarks = $this->post('delete_remarks');
        if ($this->finance_model_reports->deleteFinancePenalty($pen_id)):
            Modules::run('finance/saveFinanceLog', $this->session->employee_id, $remarks);
            echo 'Successfully Deleted';
        endif;
    }

    public function getPenalty($st_id, $status, $school_year = NULL, $month = NULL)
    {
        $pen = $this->finance_model_reports->getPenalty($st_id, $school_year, $status, $month);
        return $pen;
    }

    public function savePenalty($st_id, $month, $amount, $school_year = NULL)
    {
        $this->finance_model_reports->savePenalty($st_id, $month, $amount, $school_year);
    }

    public function getTransactionByMonth($st_id, $item_id, $month, $type = NULL)
    {
        $transaction = $this->finance_model->getTransactionByMonth($st_id, $item_id, $month, $type);
        return $transaction;
    }

    public function getTransactionByCategory($st_id, $sem, $school_year, $category_id = NULL, $type = NULL)
    {
        $transaction = $this->finance_model->getTransactionByCategory($st_id, $sem, $school_year, $category_id, $type, null);
        return $transaction;
    }

    function getBillingSched($type, $month)
    {
        $mode = $this->finance_model->getBillingSched($type, $month);
        return $mode;
    }

    public function generateMonthlyCollectible($grade_id, $month)
    {
        $data['month'] = $month;
        $data['students'] = Modules::run('registrar/getStudentsByGradeLevel', $grade_id);

        foreach ($data['students']->result() as $s):
            print_r($this->monthlyCollectible($s, $btype, $month));
        endforeach;
        // $this->load->view('reports/studentBillingAccount', $data);
    }

    public function monthlyCollectible($student, $btype, $month)
    {
        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;
        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0);
        $charges = Modules::run('finance/financeChargesByPlan', 0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id);
        $yearlyPayment = 38000;

        foreach ($charges as $c):
            $totalExtra = 0;
            $extraCharges = Modules::run('finance/getExtraFinanceCharges', $user_id, 0, $student->school_year);
            if ($extraCharges->num_rows() > 0):
                foreach ($extraCharges->result() as $ec):
                    $totalExtra += $ec->extra_amount;
                endforeach;
            endif;
            $totalCharges += $c->amount + $totalExtra;
        endforeach;

        $dp = $totalCharges - $yearlyPayment;
        $remainingFee = $totalCharges - $dp;

        $transaction = Modules::run('college/finance/getTransaction', $student->uid, 0, $student->school_year);
        $paymentTotal = 0;
        $i = 1;

        $startMonth = 5;
        $currentMonth = $month;
        switch ($btype):
            case 1:
                $monthPassed = $currentMonth - $startMonth;
                $monthlyFee = $remainingFee / 10;
                $numMonth = $monthPassed;
                $addMonth = 0;
                break;
            case 2:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed + 3;
                $monthlyFee = $remainingFee / 4;
                $numMonth = 4;
                $addMonth = 2;

                break;
            case 3:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed + 5;
                $monthlyFee = $remainingFee / 2;
                $numMonth = 2;
                $addMonth = 4;
                break;
        endswitch;


        if ($transaction->num_rows() > 0):
            $balance = 0;
            foreach ($transaction->result() as $tr):
                if ($tr->t_type < 2):
                    $totalPayment += $tr->t_amount;
                endif;
            endforeach;
            $isPriviledge = FALSE;
            if ($student->st_type == 1):
                $totalPayment = $totalPayment + 5000;
                $isPriviledge = TRUE;
            endif;
        endif;


        if ($totalPayment < $totalCharges):
            $totalPaymentlessDP = $totalPayment - $dp;
            $expectedPayment = $monthlyFee * $monthPassed;
        endif;

        $data['month'] = $monthPassed;
        $data['numMonth'] = $numMonth;
        $data['addMonth'] = $addMonth;
        $data['monthlyFee'] = $monthlyFee;
        $data['totalPaymentLessDP'] = $totalPaymentlessDP;
        $data['totalPayment'] = $totalPayment . ' | ' . $dp;
        $data['btype'] = $btype;
        $data['isPriviledge'] = $isPriviledge;
        $data['remainingFee'] = $remainingFee;

        return $data;
    }

    public function pisd_checkBilling($student, $btype)
    {
        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;

        $data['user_id'] = $user_id;
        $data['plan'] = Modules::run('finance/getPlanByCourse', $student->grade_id, 0);
        $data['charges'] = Modules::run('finance/financeChargesByPlan', 1, $this->session->userdata('school_year'), 0, $data['plan']->fin_plan_id);
        $data['student'] = $student;
        $data['btype'] = $btype;


        $this->load->view('pisd_statementOfAccount', $data);
    }

    public function lma_checkBilling($student, $btype)
    {
        if ($student->u_id == ""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;
        $plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0);
        $charges = Modules::run('finance/financeChargesByPlan', 0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id);
        $yearlyPayment = 38000;

        foreach ($charges as $c):
            $totalExtra = 0;
            $extraCharges = Modules::run('finance/getExtraFinanceCharges', $user_id, 0, $student->school_year);
            if ($extraCharges->num_rows() > 0):
                foreach ($extraCharges->result() as $ec):
                    $totalExtra += $ec->extra_amount;
                endforeach;
            endif;
            $totalCharges += $c->amount + $totalExtra;
        endforeach;

        $dp = $totalCharges - $yearlyPayment;
        $remainingFee = $totalCharges - $dp;
        $totalDiscount = 0;
        $transaction = Modules::run('finance/getTransaction', $student->uid, 0, $student->school_year);
        $discount = Modules::run('finance/getTransactionByItemId', $student->uid, NULL, $student->school_year, NULL, 2);
        foreach ($discount->result() as $d):
            $totalDiscount += $d->t_amount;
        endforeach;
        $paymentTotal = 0;
        $i = 1;

        $startMonth = 5;
        $currentMonth = 13;
        //        $currentMonth = abs(date('m'));
        switch ($btype):
            case 1:
                $monthPassed = $currentMonth - $startMonth;
                $monthlyFee = $remainingFee / 10;
                $numMonth = $monthPassed;
                $addMonth = 0;
                break;
            case 2:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed + 3;
                $monthlyFee = $remainingFee / 4;
                $numMonth = 4;
                $addMonth = 2;

                break;
            case 3:
                $monthPassed = $currentMonth - $startMonth;
                $monthPassed = $monthPassed + 5;
                $monthlyFee = $remainingFee / 2;
                $numMonth = 2;
                $addMonth = 4;
                break;
        endswitch;


        if ($transaction->num_rows() > 0):
            $balance = 0;
            foreach ($transaction->result() as $tr):
                if ($tr->t_type < 2):
                    $totalPayment += $tr->t_amount;
                endif;
            endforeach;
            $isPriviledge = FALSE;
            if ($student->st_type == 1):
                $totalPayment = $totalPayment + 5000;
                $isPriviledge = TRUE;
            endif;
        endif;
        $totalPayment = $totalPayment + $totalDiscount;


        if ($totalPayment < $totalCharges):
            $totalPaymentlessDP = $totalPayment - $dp;
            $expectedPayment = $monthlyFee * $monthPassed;
        endif;

        $data['st_id'] = $student->st_id;
        $data['month'] = $monthPassed;
        $data['discount'] = $totalDiscount;
        $data['numMonth'] = $numMonth;
        $data['addMonth'] = $addMonth;
        $data['monthlyFee'] = $monthlyFee;
        $data['totalPaymentLessDP'] = $totalPaymentlessDP;
        $data['totalPayment'] = $totalPayment . ' | ' . $totalCharges;
        $data['btype'] = $btype;
        $data['isPriviledge'] = $isPriviledge;
        $data['remainingFee'] = $remainingFee;

        $this->load->view('reports/studentBillingAccount', $data);
    }
}
