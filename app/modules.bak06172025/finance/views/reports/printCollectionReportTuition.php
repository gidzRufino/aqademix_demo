<?php
set_time_limit(120);
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
                $this->SetTitle('Business Office Tuition Collections');
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

$from = segment_3;
$to = segment_4;

$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Tuition Collection Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding

$pdf->SetFont('helvetica', 'N', 8);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(12, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(70, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$total = 0;
$overAll = 0;
$cashAll = 0;
$chequeAll = 0;
$hasCheque = FALSE;
foreach($collection->result() as $c): 
    $z++;
    if($c->t_type==0):
        $cashAll += $c->amount;
        if($cashAll!=0):
            $pdf->MultiCell(12, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(25, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(70, 3, $c->lastname.', '.$c->firstname,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(40, 3, number_format($c->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->ln();
             if($z==33):
                 $z=0;
                $pdf->AddPage();
                $pdf->SetY(25);
                $pdf->SetFont('helvetica', 'N', 8);
                $pdf->setCellPaddings(1, 1, 1, 1);
                $pdf->MultiCell(12, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(25, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(70, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(40, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->Ln();
            endif;   
        endif;
    elseif($c->t_type==1):
        $hasCheque = TRUE;
    endif;    
endforeach;

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(12, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(125, 3, 'CASH TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(40, 3, number_format($cashAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
if($hasCheque):
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(50, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'Bank',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'Cheque #',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    foreach($collection->result() as $c): 
        $z++;
        if($c->t_type==1):
                $pdf->SetFont('helvetica', 'N', 8);
                $chequeAll += $c->amount;
            if($chequeAll!=0):
                $bank = Modules::run('finance/getBank', $c->bank_id);
                $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(20, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(50, 3, $c->lastname.', '.$c->firstname,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, $bank->bank_short_name,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, $c->tr_cheque_num,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, number_format($c->amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->ln();
                 if($z==33):
                     $z=0;
                    $pdf->AddPage();
                    $pdf->SetY(25);
                    $pdf->SetFont('helvetica', 'N', 8);
                    $pdf->setCellPaddings(1, 1, 1, 1);
                    $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(20, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(50, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->Ln();
                endif;   
            endif;
        endif;    
    endforeach;
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(100, 3, 'CHEQUE TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '','BT', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format($chequeAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');$pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(100, 3, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, '',0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(100, 3, 'TOTAL Collection','TBL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, number_format(($cashAll+$chequeAll), 2, ".", ','),'TBR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
endif;    

        
        $pdf->Ln(30);
        $basicInfo = Modules::run('users/getBasicInfo', $this->session->username);
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, $basicInfo->firstname.' '.$basicInfo->lastname,'', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'Remitted By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln(40);
        
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'Received By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
