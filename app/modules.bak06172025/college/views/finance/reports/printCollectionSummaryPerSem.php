<?php

//set_time_limit(120);
class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo

        if ($this->PageNo() == 1):
            $settings = Modules::run('main/getSet');
            $this->SetY(2);
            $this->SetX(10);
            $this->SetFont('helvetica', 'B', 11);
            $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
            $this->Image($image_file, 60, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $image_file = K_PATH_IMAGES . '/uccp.jpg';
            $this->Image($image_file, 140, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->SetX(10);
            $this->Ln(5);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $this->Ln();
            $this->SetFont('helvetica', 'N', 9);
            $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln();
            $this->SetFont('helvetica', 'n', 8);
            $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->SetTitle('Collection Summary');
        endif;
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom

        $this->SetY(-15);
//		// Set font
//		$this->SetFont('helvetica', 'I', 8);
//		// Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //if($this->getAliasNumPage()==$this->getAliasNbPages()):  
        if (strtotime(segment_4) == strtotime(segment_5)):
            if ($this->getPage() == 2):
                $this->SetFont('helvetica', 'B', 9);
                $this->setCellPaddings(1, 1, 1, 1);
                $this->MultiCell(5, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $this->MultiCell(55, 3, 'Prepared By', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $this->MultiCell(10, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $this->MultiCell(55, 3, 'Checked By', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $this->MultiCell(10, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $this->MultiCell(55, 3, 'Approved By', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(280, 216);
$pdf->AddPage('P', $resolution);

$semester = segment_4;
$school_year = segment_5;
$next_year = segment_5 + 1;

switch ($semester):
    case 1:
        $semName = 'First Semester';
        break;
    case 2:
        $semName = 'Second Semester';
        break;
    case 3:
        $semName = 'Summer';
        break;
endswitch;

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Collection Summary', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ ' . $school_year . ' - ' . $next_year . ' : ' . $semName . ' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');


$pdf->ln();
// set cell padding

$pdf->SetFont('helvetica', 'B', 9);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(5, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(70, 3, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

if (strtotime(segment_4) == strtotime(segment_5)):
    $pdf->MultiCell(70, 3, 'Date of Collection: ' . date('F d, Y', strtotime($from)), 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
else:
    $pdf->MultiCell(70, 3, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
endif;
$pdf->Ln(10);

$pdf->MultiCell(10, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Name of Student', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Total Assessment', 'B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Total Payments', 'B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Total Balance', 'B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(8.8);
$z = 0;
$total = 0;
$overAll = 0;
$totalCash = 0;
$totalChequePayments = 0;
$totalCheque = 0;
$overAllCollection = 0;
$stNo = 0;

foreach ($collegeStudents as $cS):
    $totalUnits = 0;
    $totalSubs = 0;
    $totalLab = 0;
    $totalCharges = 0;
    $totalBalance = 0;
    $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $cS->admission_id, $cS->semester, $cS->school_year);

    foreach ($loadedSubject as $sl):
        $totalSubs++;
        $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
        if ($sl->sub_lab_fee_id != 0):
            $itemCharge = Modules::run('college/finance/getFinanceItemById', $sl->sub_lab_fee_id, $cS->school_year);
            $totalLab += $itemCharge->default_value;
        endif;
    endforeach;

    $plan = Modules::run('college/finance/getPlanByCourse', $cS->course_id, $cS->year_level);
    $tuition = Modules::run('college/finance/getChargesByCategory', 1, $cS->semester, $cS->school_year, $plan->fin_plan_id);
    $specialClass = Modules::run('college/finance/getExtraChargesByCategory', 5, $cS->semester, $cS->school_year, $cS->u_id);
    $charges = Modules::run('college/finance/financeChargesByPlan', $cS->year_level, $cS->school_year, $cS->semester, $plan->fin_plan_id);

    foreach ($charges as $c):
        $next = $c->school_year + 1;
        if($c->item_id!=46):
            $totalCharges += ($c->item_id<=1 || $c->item_id<=2?0:$c->amount); 
        endif;
        $totalExamFee += ($c->item_id<=1 || $c->item_id<=2?0:($c->item_id==46?($c->amount):0)); 
    endforeach;
    $totalExtra = 0;
    $extraCharges = Modules::run('college/finance/getExtraFinanceCharges',$cS->u_id, $cS->semester, $cS->school_year);
    if($showPayment):
        if($extraCharges->num_rows()>0):
            foreach ($extraCharges->result() as $ec):
                $totalExtra += $ec->extra_amount;
            endforeach;
        endif;

    endif;    

    $over = Modules::run('college/finance/overPayment',$cS->st_id, $cS->semester, $cS->school_year);

    $totalFees =($tuition->row()->amount*$totalUnits)+$totalCharges+($totalExamFee*$totalSubs);

    $semester = ($cS->semester==1?3:($cS->semester-1));
    $prev_year = ($cS->semester==1?$cS->school_year-1:$cS->school_year);
    
    $payments = Modules::run('college/finance/getTransactionByRefNumber', $cS->st_id, $cS->semester, $cS->school_year);
    $paymentTotal = 0;
    if ($payments->num_rows() > 0):
        foreach ($payments->result() as $tr):
            $paymentTotal += $tr->subTotal;
        endforeach;
    endif;

    $online = Modules::run('college/finance/getTransactionByRefNumber', $cS->uid, $cS->semester, $cS->school_year, 4);
    $onlineTotal = 0;
    if ($online->num_rows() > 0):
        foreach ($online->result() as $tr):
            $onlineTotal += $tr->subTotal;
        endforeach;
    endif;

    $excess = Modules::run('college/finance/getTransactionByRefNumber', $cS->uid, $cS->semester, $cS->school_year, 5);
    $excessTotal = 0;
    if ($excess->num_rows() > 0):
        foreach ($excess->result() as $tr):
            $excessTotal += $tr->subTotal;
        endforeach;
    endif;

    $payrollDeduction = Modules::run('college/finance/getTransactionByRefNumber', $cS->uid, $cS->semester, $cS->school_year, 6);
    $payrollDeductionTotal = 0;
    if ($payrollDeduction->num_rows() > 0):
        foreach ($payrollDeduction->result() as $tr):
            $payrollDeductionTotal += $tr->subTotal;
        endforeach;
    endif;

    $forwardedBalance = Modules::run('college/finance/getTransactionByRefNumber', $cS->uid, $cS->semester, $cS->school_year, 7);
    $forwardedBalanceTotal = 0;
    if ($forwardedBalance->num_rows() > 0):
        foreach ($forwardedBalance->result() as $tr):
            $forwardedBalanceTotal += $tr->subTotal;
        endforeach;
    endif;
    $totalPayment = $paymentTotal + $onlineTotal + $excessTotal + $payrollDeductionTotal + $forwardedBalanceTotal;
    $totalBalance = $totalFees - $totalPayment;

    $stNo++;
    $z++;
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(10, 3, $stNo, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, strtoupper($cS->lastname . ', ' . $cS->firstname), 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, ($totalFees ? number_format($totalFees, 2, '.', ',') : 0), 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, ($totalPayment != 0 ? number_format($totalPayment, 2, '.', ',') : 0), 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, number_format(($totalBalance), 2, '.', ','), 0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $rowTotal = 0;
    if ($pdf->getPage() == 1):
        if ($z == 25):
            $pdf->AddPage();
            $pdf->SetY(5);
            $z = 0;
        endif;
    else:
        if ($z == 34):
            $pdf->AddPage();
            $pdf->SetY(5);
            $z = 0;
        endif;
    endif;
    $totalAssessment += $totalFees;
    $totalCollection += $totalPayment;
    $overAllBalance += $totalBalance;
endforeach;
$pdf->Ln(8);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(175, 5, '', 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(1);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Total', 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 3, '', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 5, number_format($totalAssessment, 2, ".", ','), 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 3, '', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 5, number_format($totalCollection, 2, ".", ','), 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, number_format($overAllBalance, 2, ".", ','), 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);




//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data
//Close and output PDF document
$pdf->Output('business_office_report [ ' . $school_year . ' - ' . $next_year . ' : ' . $semName . ' ].pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
