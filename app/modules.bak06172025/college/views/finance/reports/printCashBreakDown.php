<?php
set_time_limit(120);
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

$from = segment_4;
$to = segment_5;

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'CASH COLLECTION REPORT', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, date('F d, Y', strtotime($from)), 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding
$pdf->SetFont('helvetica', 'B', 14);

$collection = Modules::run('finance/getCollectionReport', $from, $to); 
$chequePayments = Modules::run('college/finance/getChequePayments', $from, $to);
foreach ($chequePayments as $cp):
    $totalC += $cp->t_amount;
endforeach;
$onlinePayments = Modules::run('college/finance/getOnlinePayments', $from, $to);
foreach ($onlinePayments as $cp):
    $totalOp += $cp->t_amount;
endforeach;
$overAll = 0;
foreach($collection->result() as $c): 
    $overAll += $c->amount;
endforeach; 

//$pdf->Cell(0,0, 'Total Collection : '.number_format($overAll+$totalC,2,'.',','), 0, false, 'C', 0, '', 0, false, 'M', 'T');
//$pdf->Ln(15);

$pdf->SetFillColor(255,255,0);


$pdf->SetFont('helvetica', 'B', 10);

$pdf->MultiCell(35, 5, 'CASH DEPOSITS',0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(35, 3, 'Denomination',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, 'No. of Pieces',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, 'Total',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->ln();


$pdf->SetFont('helvetica', 'N', 9);
foreach ($cashbreakdown as $cb):
    if($cb->cd_id>5):
        $pdf->MultiCell(35, 3, number_format($cb->denomination),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, $cb->fdcb_total_count,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, number_format($cb->denomination*$cb->fdcb_total_count, 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
        $totalCash += ($cb->denomination*$cb->fdcb_total_count);
    endif;
endforeach;

$pdf->Ln(8);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(35, 5, 'COINS',0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$pdf->SetFont('helvetica', 'N', 9);
$totalCoins = 0;
foreach ($cashbreakdown as $cb):
    if($cb->cd_id<6):
        $pdf->MultiCell(35, 3, number_format($cb->denomination),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, $cb->fdcb_total_count,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, number_format($cb->denomination*$cb->fdcb_total_count, 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->ln();
        $totalCash += ($cb->denomination*$cb->fdcb_total_count);
    endif;
endforeach;


$pdf->SetFont('helvetica', 'B', 10);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(65, 3, 'TOTAL',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, number_format($totalCash, 2, ".", ','),'TB', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(9);
$pdf->MultiCell(65, 3, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, '','T', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 9);
//        $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'CHEQUE DEPOSITS',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(35, 5, 'Bank Name',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Cheque #',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'Amount',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$cpCount = 0;

foreach ($chequePayments as $cp):
    $cpCount++;
    $totalChequePayments += $cp->t_amount;
    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->MultiCell(35, 5, $cp->bank_short_name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, $cp->tr_cheque_num,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, number_format(($cp->t_amount), 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
endforeach;
        
            
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(65, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(65, 5, 'TOTAL CHEQUE','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, number_format(($totalChequePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$totalOnlinePayments = 0;
if($onlinePayments):
    $pdf->SetFont('helvetica', 'B', 9);
    //        $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(50, 5, 'ONLINE DEPOSITS',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(35, 5, 'Bank Name',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, 'Transaction #',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Amount',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $opCount = 0;

    foreach ($onlinePayments as $op):
        $opCount++;
        $totalOnlinePayments += $op->t_amount;
        $pdf->SetFont('helvetica', 'N', 9);
        $pdf->MultiCell(35, 5, $op->bank_short_name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $op->tr_cheque_num,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(45, 5, number_format(($op->t_amount), 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endforeach;


    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->MultiCell(65, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(65, 5, 'TOTAL ONLINE PAYMENTS','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, number_format(($totalOnlinePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
endif;    
    

$pdf->Ln(15);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(65, 5, 'TOTAL COLLECTION',0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, number_format(($totalChequePayments+$totalCash+$totalOnlinePayments), 2, ".", ','),0, 'R', 1, 0, '', '', true, 0, false, true, 5, 'M');




$pdf->SetXY(130,50);
$basicInfo = Modules::run('users/getBasicInfo', $this->session->username);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->MultiCell(30, 3, 'Prepared By:',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);

$pdf->SetX(130);
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, $basicInfo->firstname.' '.$basicInfo->lastname,'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(130);
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'Cashier',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);


$pdf->SetX(130);
$pdf->MultiCell(30, 3, 'Reviewed By:',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);


$pdf->SetX(130);
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'Marilou S. Sagario, CPA','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->SetX(130);
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'Finance Officer',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');



//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
