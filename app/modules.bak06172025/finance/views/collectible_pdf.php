<?php
set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(10);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 18);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->SetTitle('Collectibles 2020');
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
$settings = Modules::run('main/getSet');
$next = $settings->school_year + 1;

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(297,210);
$pdf->AddPage('P', $resolution);

$from = segment_3;
$to = segment_4;


$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Collectibles', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln(3);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(100, 7, 'SY: '.$settings->school_year.' - '.$next,0, 'C', 0, 0, 58, '', true, 0, false, true, 10, 'T');

$pdf->ln(15);
// set cell padding
$pdf->setX(0);
$pdf->SetFont('helvetica', 'B', 10);
// $pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetFillColor(50, 50, 150);
$pdf->SetTextColor(255, 255, 255);

$pdf->MultiCell(10, 12, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 12, 'Grade Level',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 12, 'Last Name',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 12, 'First Name',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 12, 'Total Charge',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 12, 'Total Payment',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 12, 'Total Balance',1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');



$fill=0;
$z=0;
$total = 0;
$overAll = 0;
$sub_total = 0;
$grand_balance = 0;
$pdf->SetFont('helvetica', '', 10);

foreach($students as $key=>$s):
    $total = 0;
    // $sub_total += $c->amount;
    $total_transaction =0;
    $balance = 0;

    $grade_level = $s->level;
    $previous_grade_level;

    
    if($s->lastname!=" "):
        
        $accountDetails = json_decode(Modules::run('finance/getRunningBalance', base64_encode($s->user_id), $s->school_year));
        $plan = Modules::run('finance/getPlanByCourse', $s->grade_id, 0,$s->st_type, $s->school_year);
        $charges = Modules::run('finance/financeChargesByPlan',0, $s->school_year, 0, $plan->fin_plan_id, $s->semester );
        foreach ($charges as $key => $c) {
            $total += $c->amount;
        }
        $transactions = Modules::run('finance/getTransaction', $s->st_id, $s->semester, $s->school_year);
        foreach ($transactions->result() as $key => $transaction) {
            $total_transaction += $transaction->t_amount;
        }
    
    $balance = $total - $total_transaction;
    $grand_balance += $balance;
    if ($balance == 0) {
            continue;
        }
    $fill++;
    $z++;
    endif;
        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(202, 247, 227);

        if($grade_level != $previous_grade_level && $previous_grade_level != null ){
            $grand_total +=$sub_total;
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->MultiCell(130, 3, 'Total for '.$previous_grade_level,1, 'L', 0, 0, 10, '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, number_format($sub_total, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, number_format($sub_balance, 2, ".", ','),1, 'R', 0, 1, '', '', true, 0, false, true, 10, 'M');
            $sub_total =0;
            $sub_balance = 0;
            $pdf->SetFont('helvetica', '', 9);
        }

        $sub_total += $total_transaction;
        $sub_balance += $balance;

        $pdf->MultiCell(20, 9, ucfirst($s->level),1, 'C',  $fill%2 != 0 ? 0:1, 0, 10, '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(35, 9, strtoupper($s->lastname),1, 'C', $fill%2 != 0 ? 0:1, 0, 30, '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(35, 9, ucfirst($s->firstname),1, 'C',  $fill%2 != 0 ? 0:1, 0, 65, '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(40, 9, number_format($total,2,'.',','),1, 'C',  $fill%2 != 0 ? 0:1, 0, 100, '', true, 0, false, true, 9, 'M');
        // $pdf->MultiCell(30, 9, number_format($total_transaction,2,'.',','),1, 'C',  $fill%2 != 0 ? 0:1, 0, 140, '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(30, 9,number_format($total_transaction,2,'.',','),1, 'C',  $fill%2 != 0 ? 0:1, 0, 140, '', true, 0, false, true, 9, 'M');
        // $pdf->MultiCell(30, 9, 'ST:'.number_format($sub_total,2,'.',','),1, 'C',  $fill%2 != 0 ? 0:1, 1, 170, '', true, 0, false, true, 9, 'M');
        $pdf->MultiCell(30, 9, number_format($balance,2,'.',','),1, 'C',  $fill%2 != 0 ? 0:1, 1, 170, '', true, 0, false, true, 9, 'M');
          
    if($z>=24):
        $z=0;
        $pdf->AddPage();
        $pdf->SetFillColor(50, 50, 150);
        
        $pdf->SetY(30);
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 0, 'Collectibles', 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $pdf->Ln(3);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(100, 7, 'SY: '.$settings->school_year.' - '.$next,0, 'C', 0, 0, 58, '', true, 0, false, true, 10, 'T');
        $pdf->ln(15);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->setX(0);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(10, 10, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'Grade Level',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 10, 'Last Name',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 10, 'First Name',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 10, 'Total Charge',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 10, 'Total Payment',1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 10, 'Total Balance',1, 'C', 1, 1, '', '', true, 0, false, true, 10, 'M');
    endif; 
        $previous_grade_level = $grade_level; 
         
endforeach;
        $grand_total +=$sub_total;
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(130, 3, 'Total for '.$previous_grade_level,1, 'L', 0, 0, 10, '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($sub_total, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($sub_balance, 2, ".", ','),1, 'R', 0, 1, '', '', true, 0, false, true, 10, 'M');
        $pdf->SetFont('helvetica', '', 9);


        $pdf->SetFillColor(50, 50, 150);
        $pdf->SetTextColor(255, 255, 255);
        
        $pdf->setX(0);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(130, 3, 'GRAND TOTAL',1, 'L', 1, 0, 10, '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($grand_total, 2, ".", ','),1, 'R', 1, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($grand_balance, 2, ".", ','),1, 'R', 1, 0, '', '', true, 0, false, true, 10, 'M');

        
        


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
