<?php
//set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->SetTitle('Revenue Summary');
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


$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Accounts Receivable ', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[  As of '.date('F d, Y', strtotime($date)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 9);
$pdf->Cell(0, 0, 'School Year: '.$school_year.' - '.$next, 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(8);
// set cell padding

$totalStudents = 0;
$totalTuition = 0;
$totalRegistration = 0;
$totalCollection = 0;
$totalBalance;
$totalDiscount=0;
$discountAmount = 0;
$students = Modules::run('registrar/getAllStudentsForExternal', segment_7, NULL, NULL, 1);
$charges = Modules::run('finance/getFinanceCharges',segment_7, 0, ($school_year==NULL?$this->session->school_year:$school_year), 0);
$i=0;


foreach($students->result() as $st):
    $i++;
    $financeAccount = Modules::run('finance/getFinanceAccount', $student->user_id);
    
    foreach ($charges as $charge):
        switch ($charge->item_id):
            case 1:
                $tuitionAmount = $charge->amount;
            break;    
            case 2:
                $regAmount = $charge->amount;
            break;    
        endswitch;
                $chargeAmount = $tuitionAmount+$regAmount;
    endforeach;
    $tfPayment = Modules::run('finance/getTransactionByItemId', $st->st_id,NULL,$school_year,1);
    $tfDiscount = Modules::run('finance/getTransactionByItemId', $st->st_id,NULL,$school_year,1, 2);
    foreach ($tfDiscount->result() as $tfd):
        $totalTFDiscount += $tfd->t_amount;
    endforeach;
    $tfCheque = Modules::run('finance/getTransactionByItemId', $st->st_id,NULL,$this->session->userdata('school_year'),1, 1);
    foreach ($tfCheque->result() as $tfc):
        $totalTFCheque += $tfc->t_amount;
    endforeach;

    foreach ($tfPayment->result() as $p):
        $totalTFPayment += $p->t_amount;
    endforeach;
    
    $totalPayment = $totalTFPayment + $totalTFDiscount + $totalTFCheque;
    
    if($i==1):
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(100, 5, 'Registration and Tuition - '.strtoupper($st->level),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(8);
        $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(80, 5, 'Account Name','TB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(32, 5, 'Total Charges','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, 'Outstanding Balance','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
    endif;

    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(80, 5, strtoupper($st->firstname.' '.$st->lastname),'TB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($chargeAmount,2,'.',','),'TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, number_format($totalTFPayment,2,'.',','), 'TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    
    $chargeAmount = 0;
    $totalPayment = 0;
    $totalTFPayment = 0;
    $totalTFDiscount = 0;
    $totalTFCheque = 0;
endforeach;









//Close and output PDF document
$pdf->Output('Revenue Summary Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
