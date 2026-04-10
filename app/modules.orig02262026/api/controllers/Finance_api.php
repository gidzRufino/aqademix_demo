<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Finance_api extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('finance_model');
    }
    
    

    public function getDiscountsByItemId($st_id, $sem, $school_year, $item_id=NULL)
    {
        $disc = $this->finance_model->getDiscountsByItemId($st_id, $sem, $school_year, $item_id);
        return $disc;
    }
    
    public function getStudentFinanceAccountsRaw($st_ids = NULL, $school_year =NULL)
    {
        
        $students = explode(',', base64_decode($st_ids));
        $totalBalance = 0;
        $overAll = 0;
        foreach ($students as $s):
            $student = Modules::run('registrar/getSingleStudent', $s, $school_year);
            if($student->u_id==""):
                $user_id = $student->us_id;
            else:
                $user_id = $student->u_id;
            endif;
            
            $AD = json_decode(Modules::run('api/finance_api/getRunningBalance', base64_encode($s), $school_year));
            $balance = $AD->charges - $AD->payments;
            $totalBalance += $balance;
        endforeach;    
        
        return $totalBalance;
    }
    
    public function getStudentFinanceAccounts($st_ids = NULL, $year =NULL)
    {
        
        $data['st_ids'] = $st_ids;
        $data['baseId'] = $st_ids;
        $data['modules'] = 'api';
        $data['school_year'] = $year;
        
        $data['main_content'] = 'finance/accountDetails';
        echo Modules::run('templates/mobile_content', $data);
        //echo $st_ids;
        
    }
    
    function getPlanByCourse($course_id, $year_level)
    {
        $plan_id = $this->finance_model->getPlanByCourse($course_id, $year_level);
        return $plan_id;
    }
    
    
    public function financeChargesByPlan($year_level=NULL, $school_year, $sem, $plan=NULL)
    {
        $charges = $this->finance_model->financeChargesByPlan($school_year, $sem, $plan, $year_level);
        return $charges;
    }
    
    function getFinanceAccount($user_id)
    {
        $result = $this->finance_model->getFinanceAccount($user_id);
        return $result;
    }
    
    function getExtraFinanceCharges($st_id, $sem, $school_year)
    {
        $charges = $this->finance_model->getExtraFinanceCharges($st_id, $sem, $school_year);
        return $charges;
    }
    
    public function getRunningBalance($st_id, $school_year, $sem=NULL)
    {
        $student = Modules::run('registrar/getSingleStudent', base64_decode($st_id), $school_year);

        $plan = Modules::run('api/finance_api/getPlanByCourse', $student->grade_id, 0);
        $charges = Modules::run('api/finance_api/financeChargesByPlan',0, $school_year, 0, $plan->fin_plan_id );
                
        $i=1;
        $total=0;
        $amount=0;
        if($student->u_id==""):
            $user_id = $student->us_id;
        else:
            $user_id = $student->u_id;
        endif;

        foreach ($charges as $c):
             $next = $c->school_year + 1;
            if($student->grade_id==12 || $student->grade_id==13):
                if($student->status !=2):
                    $total += $c->amount;
                else:
                    if($c->item_description!='Tuition Fee' && $c->item_description!='Misc Fee'): 
                        $total += $c->amount;
                    endif;
                endif;
            else:
                $total += $c->amount;
            endif;
        endforeach;
        $totalExtra = 0;
        $extraCharges = Modules::run('api/finance_api/getExtraFinanceCharges',$user_id, 0, $student->school_year);
        if($extraCharges->num_rows()>0):
            foreach ($extraCharges->result() as $ec):
            
                $totalExtra += $ec->extra_amount;
            endforeach;
            $total = $total + $totalExtra;
        endif;
        
        //transaction
        $transaction = Modules::run('api/finance_api/getTransaction', $student->uid, 0, $student->school_year);
        $paymentTotal = 0;
        if($transaction->num_rows()>0):
            foreach ($transaction->result() as $tr):
                $paymentTotal += $tr->t_amount ;
            endforeach;
        endif;
        
        $details = array(
           'charges' => $total,
           'payments' => $paymentTotal
        );
        
        return json_encode($details);
            
    }
    
    
    public function getTransaction($st_id, $sem, $school_year)
    {
        $transaction = $this->finance_model->getTransaction($st_id, $sem, $school_year);
        return $transaction;
    }
    
    
}
 
