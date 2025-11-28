<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance_pilgrim extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('finance_model');
	$this->load->library('pagination');
        $this->load->library('Pdf');
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    
    public function getOtherFees($year_level, $school_year, $sem, $plan_id, $totalUnits, $totalSubs)
    {
        $chargeAmount = 0;
        $fusedCharges =0;
        $charges = Modules::run('college/finance/financeChargesByPlan',$year_level, $school_year, $sem, $plan_id );
        foreach ($charges as $c):
            if($c->is_fused):
                $chargeAmount = ($c->item_id<=2?$c->amount*$totalUnits:($c->item_id==46?($c->amount*$totalSubs):$c->amount));
                $fusedCharges += $chargeAmount;
            elseif($c->item_id==46):
                $chargeAmount = $c->amount*$totalSubs;
                $fusedCharges += $chargeAmount;
            endif;
        endforeach;
        
        return $fusedCharges;
    }
   
}
