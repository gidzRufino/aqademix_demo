<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Registrar
 *
 * @author genesis
 */
class Finance_reports extends MX_Controller {
    //put your code here
    
    
    function __construct() {
        parent::__construct();
        $this->load->model('finance_model');
        $this->load->model('finance_model_reports');
	$this->load->library('pagination');
        $this->load->library('Pdf');
        date_default_timezone_set("Asia/Manila");
        set_time_limit(300) ;
    }
    
    private function post($name)
    {
        return $this->input->post($name);
    }
    
    //Life College finance Details
    
    function searchFinanceStaff($value, $year=NULL)
    {
        $employee = $this->finance_model->searchFinanceStaff($value, $year);
        echo '<ul>';
        foreach ($employee as $s):
        ?>
            <li style="font-size:18px;" onclick="$('#searchName').hide(), $('#searchBox').val('<?php echo $s->firstname.' '.$s->lastname ?>'), $('#assign_employee_id').val('<?php echo base64_encode($s->employee_id) ?>')" ><?php echo strtoupper($s->firstname.' '.$s->lastname) ?></li>   
        <?php        
        endforeach;
        echo '</ul>';
        
    }
    
    function getLCFinanceDetails($student, $month)
    {
        //$plan = Modules::run('finance/getPlanByCourse',5, 0);
        $plan = Modules::run('finance/getPlanByCourse',$student->grade_id, 0);
        $charges = Modules::run('finance/financeChargesByPlan',0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id );
        
        $st_id =  $student->uid ;
        //$st_id = '431515150444' ;
        
        $tfCharge = 0;
        $monthlyTFCharge = 0;
        $totalTFCheque = 0;
        $totalTFPayment = 0;
        $isTFPaid = FALSE;
        
        $sdCharge = 0;
        $monthlySDCharge = 0;
        $isSDPaid = FALSE;
        
        $miscCharge = 0;
        $monthlyMISCharge = 0;
        $isMISCPaid = FALSE;
        
        $bookCharge = 0;
        $monthlyBookCharge = 0;
        $isBookPaid = FALSE;
        
        $startMonth = 6-1;
        $currentMonth = abs($month);
        if($currentMonth<6):
            $currentMonth= abs($month)+12;
        endif;
        
        $monthPassed = $currentMonth - $startMonth;
        
        
        foreach ($charges as $c):
            switch($c->item_id):
                case 1:
                    $tfPayment = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),1);
                    $tfDiscount = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),1, 2);
                    foreach ($tfDiscount->result() as $tfd):
                        $totalTFDiscount += $tfd->t_amount;
                    endforeach;
                    $tfCheque = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),1, 1);
                    foreach ($tfCheque->result() as $tfc):
                        $totalTFCheque += $tfc->t_amount;
                    endforeach;
                    
                    foreach ($tfPayment->result() as $p):
                        $totalTFPayment += $p->t_amount;
                    endforeach;
                    
                    $tfCharge = $c->amount - $totalTFDiscount;
                    if($totalTFPayment<$tfCharge):
                        $monthlyTFCharge = $tfCharge/10;
                        $expectedTFPayment = $monthlyTFCharge * $monthPassed;
                        $tfOverdue = $expectedTFPayment - ($totalTFPayment+$totalTFCheque);
                    endif;    
                    if($totalTFPayment >= $expectedTFPayment):
                        $isTFPaid = TRUE;
                    endif;
                    
                break;      
                case 3:
                    $miscPayment = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),3);
                    foreach ($miscPayment->result() as $mp):
                        $totalmiscPayment += $mp->t_amount;
                    endforeach;
                   
                    
                    $miscDiscount = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),3, 2);
                    foreach ($miscDiscount->result() as $miscd):
                        $totalMISCDiscount += $miscd->t_amount;
                    endforeach;
                    
                    $miscCheque = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),3, 1);
                    foreach ($miscCheque->result() as $miscc):
                        $totalMiscCheque += $miscc->t_amount;
                    endforeach;
                     $miscCharge = $c->amount - $totalMISCDiscount;
                    if($totalmiscPayment<$miscCharge):
                        $monthlyMISCharge = $miscCharge/5;
                        $expectedMISCPayment = $monthlyMISCharge * $monthPassed;
                        $miscOverdue = $expectedMISCPayment - ($totalmiscPayment+$totalMiscCheque);
                    endif; 
                        
                    if($totalmiscPayment >= $expectedMISCPayment):
                        $isMISCPaid = TRUE;
                    endif;
                    
                break; 
                case 4:
                    $SDPayment = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),4);
                    foreach ($SDPayment->result() as $sdp):
                        $totalSDPayment += $sdp->t_amount;
                    endforeach;
                    
                    $sdDiscount = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),4, 2);
                    foreach ($sdDiscount->result() as $sdd):
                        $totalSDDiscount += $sdd->t_amount;
                    endforeach;
                    $sdCheque = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),4, 1);
                    foreach ($sdCheque->result() as $sdc):
                        $totalSDCheque += $sdc->t_amount;
                    endforeach;
                    
                    $sdCharge = $c->amount-$totalSDDiscount;
                    
                    if($totalSDPayment<$sdCharge):
                        $monthlySDCharge = $sdCharge/5;
                        if($monthPassed<=5):
                            $expectedSDPayment = ($monthlySDCharge * $monthPassed);
                        else:
                            $expectedSDPayment = $sdCharge;
                        endif;
                        
                        $sdOverdue = $expectedSDPayment - ($totalSDPayment+$totalSDCheque);
                    endif;
                    
                    if($totalSDPayment >= $expectedSDPayment):
                        $isSDPaid = TRUE;
                    endif;
                break;     
                case 5: // Books
                    
                    $bookPayment = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),5);
                    foreach ($bookPayment->result() as $bp):
                        $totalBookPayment += $bp->t_amount;
                    endforeach;
                    
                    $bookDiscount = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),5, 2);
                    foreach ($bookDiscount->result() as $bd):
                        $totalBookDiscount += $bd->t_amount;
                    endforeach;
                    $bookCheque = Modules::run('finance/getTransactionByItemId', $st_id,NULL,$this->session->userdata('school_year'),5, 1);
                    foreach ($bookCheque->result() as $bc):
                        $totalBookCheque += $bc->t_amount;
                    endforeach;
                    
                    $bookCharge = $c->amount-$totalBookDiscount;
                    $booksCharge50 = $bookCharge/2;
                    if($totalBookPayment<$bookCharge):
                        $monthlyBookCharge = $booksCharge50/4;
                        $expectedBookPayment = ($monthlyBookCharge * ($monthPassed-1))+$booksCharge50;
                        $bookOverdue = $expectedBookPayment - ($totalBookPayment+$totalBookCheque);
                    endif;
                        
                    if(($totalBookPayment) >= $expectedBookPayment):
                        $isBookPaid = TRUE;
                    endif;
                break;     
                    
            endswitch;
        endforeach;
        
        
        $financeAccount = json_decode(Modules::run('api/finance_api/getRunningBalance', base64_encode($st_id),$this->session->userdata('school_year')));
        
        
        $details = array(
           'tuition'            => ($isTFPaid?0:($tfOverdue!=0?($tfOverdue>0?$tfOverdue:0):$monthlyTFCharge)),
           'totalTFPayment'     => $totalTFPayment,
           'expectedTFPayment'  => $expectedTFPayment,
           'monthPassed'        => $monthPassed,
           'SD'                 => ($isSDPaid?0:($sdOverdue!=0?($sdOverdue>0?$sdOverdue:0):$monthlySDCharge)),
           'totalSDPayment'     => $totalSDPayment,
           'expectedSDPayment'  => $expectedSDPayment,
           'MISC'               => ($isMISCPaid?0:($miscOverdue!=0?($miscOverdue>0?$miscOverdue:0):$monthlyMISCharge)),
           'totalMISCPayment'   => $totalmiscPayment,
           'expectedMISCPayment'=> $expectedMISCPayment,
           'books'              => ($isBookPaid?0:($bookOverdue!=0?($bookOverdue>0?$bookOverdue:0):$monthlyBookCharge)),
           'totalBooksPayment'  => $totalBookCheque,
           'expectedBooksPayment'=> $expectedBookPayment,
           'totalAmountDue'     => round(($isTFPaid?0:($tfOverdue!=0?($tfOverdue>0?$tfOverdue:0):$monthlyTFCharge))+($isSDPaid?0:($sdOverdue!=0?($sdOverdue>0?$sdOverdue:0):$monthlySDCharge))+($isMISCPaid?0:($miscOverdue!=0?($miscOverdue>0?$miscOverdue:0):$monthlyMISCharge))+($isBookPaid?0:($bookOverdue!=0?($bookOverdue>0?$bookOverdue:0):$monthlyBookCharge))),
           'totalCharges'       => $financeAccount->charges,
           'totalPayment'       => $financeAccount->payments
           
        );
        //print_r($details);
        echo json_encode($details);
    }
    
    function generateBilling($grade_level, $section, $month, $offset, $limit)
    {
        $settings = Modules::run('main/getSet');
        $data['month'] = $month;
        $data['monthName'] = date('F', strtotime(date('Y').'-'.$month.'-01'));
        $data['students'] =$this->finance_model_reports->getAllStudents($limit, $offset, $grade_level, $section);
        $data['settings'] = $settings;
        
        if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printBilling.php')):
            $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printBilling', $data);
        else:
            $this->load->view('finance/reports/printBilling', $data);
        endif;
    }
    
    function printCollectionReportPerItem($dateFrom, $dateTo, $item_id, $school_year = NULL)
    {
        
        $settings = Modules::run('main/getSet');
        $data['item_id'] = $item_id;
        $data['collection'] = $this->finance_model_reports->getCollectionOrder($dateFrom, $dateTo, $item_id, $school_year);
        
        if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printReportPerItem.php')):
            $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printReportPerItem', $data);
        else:
            $this->load->view('finance/reports/printReportPerItem', $data);
        endif;
    }
    
    function getChargesPerPlan($item_id)
    {
        $charges = $this->finance_model_reports->getChargesPerPlan($item_id);
        return $charges;
    }
    
    function getFinanceChargesPerItem($school_year = NULL)
    {
        $charges = $this->finance_model_reports->getFinanceChargesPerItem($school_year);
        return $charges;
    }
    
    function getFinanceItemDrop($school_year)
    {
        $charges = $this->getFinanceChargesPerItem($school_year);
        foreach ($charges->result() as $charge):
            ?>
            <option value="<?php echo $charge->item_id ?>"><?php echo strtoupper($charge->item_description) ?></option>
            <?php
        endforeach;
        echo '<option value="15">LOCKER</option>';
    }
            
    function getTotalCollectionPerGradeLevel($grade_id, $option, $item_id=NULL, $trans_type = NULL, $date = NULL, $school_year = NULL)
    {
        $totalCollection = $this->finance_model_reports->getTotalCollectionPerGradeLevel($grade_id, $option, $item_id, $trans_type, $date, $school_year);
        return $totalCollection;
    }
    
    function printRevenueCollection($option, $date, $school_year = NULL)
    {
        $settings = Modules::run('main/getSet');
        
        $data['school_year'] = ($school_year==NULL?$this->session->school_year:$school_year);
        $data['next'] = $data['school_year'] + 1;
        $data['gradeLevel'] = $this->finance_model_reports->getGradeLevel($option);
        $data['date'] = $date;
        
        switch($option):
            case 2:
            case 3:
                if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printRevenueReportTuition.php')):
                    $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printRevenueReportTuition', $data);
                else:
                    $this->load->view('finance/reports/printRevenueReportTuition', $data);
                endif;
            break;    
            case 4:
                if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printRevenueReportPerItem.php')):
                    $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printRevenueReportPerItem', $data);
                else:
                    $this->load->view('finance/reports/printRevenueReportPerItem', $data);
                endif;
            break; 
            case 7:
                if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printRevenueReportTuition.php')):
                    $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printRevenueReportTuition', $data);
                else:
                    $this->load->view('finance/reports/printRevenueReportTuition', $data);
                endif;
            break;    
            case 8:
                if(file_exists(APPPATH.'modules/finance/views/reports/'. strtolower($settings->short_name).'_printDetailedRevenueReport.php')):
                    $this->load->view('finance/reports/'. strtolower($settings->short_name).'_printDetailedRevenueReport', $data);
                else:
                    $this->load->view('finance/reports/printDetailedRevenueReportTuition', $data);
                endif;
            break;    
        endswitch;
        
    }
}
