<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                
                $settings = Modules::run('main/getSet');
                $this->SetY(2);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 11);
                $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                $this->Image($image_file, 60, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $image_file = K_PATH_IMAGES.'/uccp.jpg';
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
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('finance/getBasicStudent', $st_id, $school_year, $semester);
$next = $settings->school_year + 1;


$pdf->SetXY(5,5);
$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);


$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 0, 'STATEMENT OF ACCOUNT', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->Cell(0, 0, 'SY: '.$settings->school_year.' - '.$next.($student->semester==3?'( SUMMER )':''), 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(100, 0,'Name: '. strtoupper($student->firstname.' '.($student->middlename!=""?substr($student->middlename, 1).'. ':""). $student->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0,'',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->MultiCell(160, 0,'Grade / Section : '. strtoupper($student->level.' '.$student->section),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');


$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0,$student->st_type, $student->school_year);
$charges = Modules::run('finance/financeChargesByPlan',0, $student->school_year, 0, $plan->fin_plan_id, $student->semester );

$tuition = 0;
$fusedCharges = 0;
foreach ($charges as $c):
    
    if($c->is_fused):
        $chargeAmount = $c->amount;
        $fusedCharges += $chargeAmount;
    else:
        if($c->item_id==3):
            $tuition = $c->amount;
        else:
            $fusedCharges +=  $c->amount;
        endif;
    endif;
endforeach;


$totalExtra = 0;
$extraCharges = Modules::run('finance/getExtraFinanceCharges',$student->user_id, $student->semester, $student->school_year);
$books = 0;
$totalPayments = 0;
if($showPayment):
    if($extraCharges->num_rows()>0):
        foreach ($extraCharges->result() as $ec):   

            if($ec->extra_item_id==78):
                    $books += $ec->extra_amount;
            else: 
                $totalExtra += $ec->extra_amount;
            endif;
        endforeach;
    endif;
else:
    $books = 0;
    $totalExtra = 0;
endif;    


$discounts = Modules::run('finance/getDiscountsByItemId', $student->st_id, $student->semester, $student->school_year);

$pdf->Ln(8);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 13);
$pdf->MultiCell(40, 0,'CHARGES:',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);


$pdf->SetX(10);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(65, 0,'TUITION',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0,'----------------------------------------------------------',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0,(number_format($tuition,2,'.',',')),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(5);
$pdf->SetX(10);
$pdf->MultiCell(65, 0,'OTHER FEES',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0,'----------------------------------------------------------',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0,(number_format($fusedCharges+$totalExtra,2,'.',',')),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

if($showPayment):
    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->MultiCell(65, 0,'TEXTBOOK',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(85, 0,'----------------------------------------------------------',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(40, 0,(number_format($books,2,'.',',')),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(8);
else:
    $pdf->Ln(8);
endif;    

$totalFees = $fusedCharges+$totalExtra+$tuition+$books;
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->MultiCell(65, 0,'TOTAL',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0,'',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0,(number_format($totalFees,2,'.',',')),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

if(segment_6!=1):
    $transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);
    $paymentTotal = 0;
    $i = 1;
    if($transaction):
        $pdf->Ln(15);
        $pdf->SetX(5);
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->MultiCell(65, 0,'DISCOUNTS:',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

    
        $totalDiscount = 0;
        foreach ($transaction->result() as $tr):
            $i++;
        if($tr->t_type==2):
            $totalDiscount = $totalDiscount + $tr->t_amount ;
            $pdf->MultiCell(50, 0,'',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(50, 0,'('.(number_format($totalDiscount,2,'.',',')).')',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
        endif;
        endforeach;
        
    else:

    endif;
    $pdf->Ln(10);
    $pdf->SetX(5);
    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->MultiCell(40, 0,'PAYMENTS:',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

    if($showPayment):
        $pdf->Ln();
        $pdf->SetX(20);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->MultiCell(50, 0,'DATE',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(50, 0,'RECEIPT NO.',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(50, 0,'AMOUNT',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');


        $transaction = Modules::run('finance/getTransaction', $student->st_id, $student->semester, $student->school_year);
        $paymentTotal = 0;
        $i = 1;
        if($transaction):
            $balance = 0;
            foreach ($transaction->result() as $tr):
                $i++;
            if($tr->t_type!=2 && $tr->t_type!=3):
                $totalPayments = $totalPayments + $tr->t_amount ;

                $pdf->Ln(5);
                $pdf->SetX(20);
                $pdf->SetFont('helvetica', 'N', 12);
                $pdf->MultiCell(50, 0,date('F d, Y', strtotime($tr->t_date)),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
                $pdf->MultiCell(50, 0,$tr->ref_number,0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
                $pdf->MultiCell(50, 0,(number_format($tr->t_amount,2,'.',',')),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            endforeach;
        else:

        endif;

        if($totalPayments!=0):
            $pdf->Ln(8);
            $pdf->SetX(30);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->MultiCell(50, 0,'Total:',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(130, 0,(number_format($totalPayments,2,'.',',')),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
        endif;   
    else:
        $totalPayments = 0;
    endif;    

    $outstandingBalance = (($totalFees) - $totalPayments)-$totalDiscount;
   

    $pdf->Ln(15);
    $pdf->SetX(10);
    $pdf->MultiCell(65, 0,'OUTSTANDING BALANCE',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(85, 0,'------------------------------------------------------',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(40, 0,(number_format($outstandingBalance,2,'.',',')),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
endif;

$pdf->Ln(15);
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(40, 0,'',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(120, 0,'------------------- NOTHING FOLLOWS -------------------',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0,'',0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$cashier = Modules::run('hr/getEmployeeByPosition', 'Cashier');

$pdf->Ln(20);
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'N', 11);
$pdf->MultiCell(140, 0,'',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(50, 0, strtoupper($this->session->name),0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->SetFont('helvetica', 'N', 11);
$pdf->MultiCell(140, 0,'',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(50, 0, 'Cashier','T', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 65, 20, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 65, 20, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

//Close and output PDF document
$pdf->Output('Statement of Account.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
