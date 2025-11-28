<?php
set_time_limit(300);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(8);
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln(3);
		$this->SetFont('helvetica', 'n', 6);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(3);
		$this->Cell(0, 0,'' , 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetTitle('Statement of Account');
        }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);


$pdf->SetY(18);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Cell(0, 0, 'Statement of Account', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->ln();
// set cell padding

//variables
$plan = Modules::run('finance/getPlanByCourse',$student->grade_id, 0);
$charges = Modules::run('finance/financeChargesByPlan',0, $this->session->school_year, 0, $plan->fin_plan_id );
$financeAccount = Modules::run('finance/getFinanceAccount', $student->uid);


$pdf->SetFont('helvetica', 'B', 7);

$pdf->MultiCell(10, 4, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(150, 4, strtoupper($student->firstname.' '.$student->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(4);
$pdf->MultiCell(30, 5, 'Grade Level / Section:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $student->level.' - '.$student->section,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);
$pdf->MultiCell(30, 5, 'Charge Description','TB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Amount','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Payments','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(20, 5, 'Particulars','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Balance','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Charges','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Amount Due','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22, 5, 'Status','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6.8);


$yearlyPayment = 38000;
$totalExtra = 0;
$isPriviledge = FALSE;
$totalCharges = 0;
$totalDiscount = 0;
$totalPayment = 0;
$penalty = 0;
$overAllDue = 0;
$status = 'Unpaid';
$mop = Modules::run('finance/getMOP', $financeAccount->billing_type);

foreach ($charges as $c):
    $totalCharges += $c->amount;
endforeach;

$extraCharges = Modules::run('finance/getExtraFinanceCharges',$student->uid, 0, $student->school_year);
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

$paymentTransaction = Modules::run('finance/getTransaction', $student->stid, 0, $student->school_year);

$startMonth = 6;
$totalMonth = 12;
$currentMonth = abs(date('m'));

switch ($financeAccount->billing_type):
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

    $totalPayment = $totalPayment+$totalDiscount;
endif;


if($totalPayment>$downpayment):
   $dpPayment = $downpayment;
else:
   $dpBalance = $downpayment - $totalPayment;
   $dpPayment = $downpayment - $dpBalance;
endif;

$dpBalance = $downpayment - $dpPayment;

if($dpBalance>0):
   $dpDue = $dpBalance;
   $status = 'Unpaid';
   $color = 'alert-info';
   if($monthPassed>0):
        $status = 'Overdue';
        $color = 'alert-danger';
   endif;
   $totalPayment = 0;
else:
   $dpDue = 0; 
   $color = 'alert-success';
   $status = 'Paid';
   $totalPayment = $totalPayment-$dpPayment;
endif;

    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(30, 4, strtoupper('DOWNPAYMENT'),'TB', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, number_format($downpayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, number_format($dpPayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, number_format($dpBalance,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, number_format(0,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, number_format($dpDue,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->MultiCell(22, 4, $status,'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
    $pdf->Ln();

    $tfpayment = 0;
    $atfpayment = 0;
    $ptfpayment = 0;
    $previousBalance = 0;
    $overAllTFCharges = 0;
    $overAllDue = 0;

    for($i = 1; $i<=$numMonth; $i++):
        if($btype==3):
            $monthNums = ($i+$addMonth);
        else:
            $monthNums = (($i+5)+$addMonth);
        endif;
        $monthNum = ($monthNums>12?$monthNums-12:$monthNums);
        $monthNum = ($monthNum < 10?'0'.$monthNum:$monthNum);

        $apayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums+1));
        $atfpayment = $apayment->amount;

        $ppayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, ($monthNums-1));
        $ptfpayment = $ppayment->amount;

        $tpayment = Modules::run('finance/billing/getTransactionByMonth',  $student->uid, $c->item_id, $monthNums);
        $tfpayment = $tpayment->amount;

        $expectedPayment = ($monthlyFee * $i);
        $totalBalance = $totalPayment;
        $totalBalance = $expectedPayment - $totalBalance;


        if($totalPayment>0):  
            if($tfpayment==0):
                if($totalPayment>$expectedPayment):
                    $tfpayment = $monthlyFee;
                else:
                    if($ptfpayment!=0):
                    if(($monthlyFee - $totalPayment)>0):
                            $tfpayment = $expectedPayment - $totalTFPayment;
                        else:
                            $tfpayment = $expectedPayment - $totalTFPayment; 
                        endif;
                    else:
                            $tfpayment = $monthlyFee-$totalBalance; 
                            if($tfpayment<=0):
                                $tfpayment = 0;
                            endif;
                    endif;

                endif;
            else:
                if($i==1):
                    echo $totalPayment;
                endif;
            endif;    
        endif;

        $totalDue = $monthNums<=$currentMonth?$monthlyFee-$tfpayment:0;

        $color = $monthNums<$currentMonth?$totalDue>0?'alert-danger':'alert-success':'alert-info';
        $color = ($totalPayment>=$expectedPayment?'alert-success':$monthNums<=$currentMonth?$totalDue==0?'alert-success':'alert-info':'alert-info');
        $status = ($totalPayment>=$expectedPayment?'Paid':'Unpaid');
        $m = Modules::run('finance/billing/getBillingSched',$btype, abs($monthNum));
        if(strtotime($m->row()->bill_date) < strtotime(date('Y-m-d'))):
            if($totalDue>0):
                $color = 'alert-danger';
                $status = 'Overdue';
                if($isPriviledge):
                    $penalty = $mop->special_penalty;
                else:
                    $penalty = $mop->regular_penalty;
                endif;
                Modules::run('finance/billing/savePenalty', $student->uid,$monthNum,$penalty, $this->session->school_year);

            endif;
        endif;
        if($monthNums>$currentMonth):
            $penalty = 0;
        endif;

    if($i < 11):
        $pdf->MultiCell(30, 4, strtoupper('TUITION - '.date('F', strtotime(date('Y-'.$monthNum.'-01')))),'TB', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($monthlyFee,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($tfpayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($monthlyFee-$tfpayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($penalty,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($totalDue+$penalty,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, $status,'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->Ln();
    endif;
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
        $overAllDue += ($totalDue+$penalty);
    endfor;
    
    $schoolBusCharges = Modules::run('finance/getExtraFinanceCharges',$student->uid, 0, $student->school_year);
                
    if($paymentTransaction->num_rows()>0):
        $balance = 0;
        foreach ($paymentTransaction->result() as $tr):
            if($tr->t_type<2 && $tr->category_id==6):
                $totalSBusPayment += $tr->t_amount;
            endif;
        endforeach;
   endif;


    if($schoolBusCharges->num_rows()>0):
        foreach ($schoolBusCharges->result() as $ec):
            if($ec->category_id==6):
                $totalSchoolbus += $ec->extra_amount;

                $monthName = explode('-', $ec->item_description);
                if($totalSBusPayment >= $totalSchoolbus):
                    $sbusPayment = $ec->extra_amount;
                    $balance = 0;
                endif;
                $color = ($totalSBusPayment>=$totalSchoolbus?'alert-success':$monthNums<=$currentMonth?$totalDue==0?'alert-success':'alert-info':'alert-info');
                $status = ($totalSBusPayment>=$totalSchoolbus?'Paid':'Unpaid');
                
                $pdf->MultiCell(30, 4, strtoupper($ec->item_description),'TB', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, number_format($ec->extra_amount,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, number_format($sbusPayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, number_format($balance,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, number_format(0,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, number_format(0,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->MultiCell(22, 4, $status,'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
                $pdf->Ln();

            endif;
        endforeach;
        $overAllCharges += $totalSchoolbus;
    endif;
        $overAllBalance = ($overAllCharges) - ($totalPayment+$dpPayment);
        
        $pdf->SetFont('helvetica', 'B', 6);
        $pdf->MultiCell(30, 4, strtoupper('TOTAL'),'TB', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($overAllCharges,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($totalPayment+$dpPayment,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($overAllBalance,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format(0,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, number_format($overAllDue,2,".",","),'TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(5, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->MultiCell(22, 4, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 4, 'M');
        $pdf->Ln(6);
                
$pdf->SetFont('helvetica', 'N', 8);                
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(150, 5, 'Account as of '.date('F d, Y'),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);

$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 8); 
$pdf->MultiCell(150, 5, 'The Amount of Php '.number_format($overAllDue,2,".",",").' is Due on '.date('F d, Y', strtotime($this->uri->segment(6))),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'N', 8);  
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(190, 10, 'This statement is as of the date shown above. If there are any discrepancies, please notify us immediately. Ignore this report if payment has been done already. Thank You and God bless!',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
                

//Close and output PDF document
$pdf->Output('Statement of Account '. date('Ymdgis').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
