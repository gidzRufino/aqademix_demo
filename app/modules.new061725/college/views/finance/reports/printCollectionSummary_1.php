<?php
//set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
            
            if($this->PageNo()==1):
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
                    if(strtotime(segment_4) == strtotime(segment_5)):
                        if($this->getPage()==2):
                            $this->SetFont('helvetica', 'B', 9);
                            $this->setCellPaddings(1, 1, 1, 1);
                            $this->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                            $this->MultiCell(55, 3, 'Prepared By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                            $this->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                            $this->MultiCell(55, 3, 'Checked By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                            $this->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                            $this->MultiCell(55, 3, 'Approved By','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
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
$resolution= array(280,216);
$pdf->AddPage('P', $resolution);

$from = segment_4;
$to = segment_5;

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Business Office Collection Summary', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
if(strtotime(segment_4) == strtotime(segment_5)):
    $pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');
else:
    $pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime(segment_5)).']', 0, false, 'C', 0, '', 0, false, 'M', 'T');
    
endif;

$pdf->ln();
// set cell padding

$pdf->SetFont('helvetica', 'B', 9);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(70, 3,'',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

if(strtotime(segment_4) == strtotime(segment_5)):
    $pdf->MultiCell(70, 3, 'Date of Collection: '. date('F d, Y', strtotime($from)),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
else:
    $pdf->MultiCell(70, 3,'',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
endif;
$pdf->Ln(10);

$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Charges Type','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Cash','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, 'Cheques','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, 'Total','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(8.8);
$z=0;
$total = 0;
$overAll = 0;
$totalCash = 0;
$totalChequePayments = 0;
$totalCheque = 0;
$overAllCollection = 0;


foreach($collection->result() as $c):
            
        $cash = Modules::run('college/finance/getCashPayments', $from, $to, ($c->fused_category==0?$c->item_id:NULL), $c->fused_category);
        $totalCash += $cash->amount;

        $cheque = Modules::run('college/finance/getChequePayments', $from, $to, ($c->fused_category==0?$c->item_id:NULL), $c->fused_category);
        foreach($cheque as $chk):
            $totalCheque += $chk->t_amount;
            $totalChequePayments += $chk->t_amount;
        endforeach;   
        $totalCollection += $c->t_amount;
        
        $z++;
        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, strtoupper(($c->fused_category==0?$c->item_description:'Other Fees')),0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 3, ($cash?number_format($cash->amount,2,'.',','):0),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 3, ($totalCheque!=0?number_format($totalCheque,2,'.',','):0),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, number_format(($totalCollection),2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $rowTotal = 0;
        if($pdf->getPage()==1):
            if($z==25):
                $pdf->AddPage();
                $pdf->SetY(5);
                $z=0;
            endif;
        else:
            if($z==30):
                $pdf->AddPage();
                $pdf->SetY(5);
                $z=0;
            endif;
        endif; 
        $overAllCollection = ($totalCash+$totalChequePayments);
        $totalCheque = 0;
endforeach;
        $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(195, 5, '','T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(1);
        $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(70, 5, 'Total','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, number_format($totalCash, 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 3, '','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(40, 5, number_format($totalChequePayments, 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(35, 5, number_format($overAllCollection, 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '','T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(10);
        
        
        if(strtotime(segment_4) == strtotime(segment_5)):
            if($z==22):
                $pdf->AddPage();
                $pdf->SetY(30);

            endif;   
        else:
            $z=$z+2;
        
            if($z>=30):
                $pdf->AddPage();
                $pdf->SetY(5);
                $z=0;
            endif;
        endif;  
        
        if($z==24):
            $pdf->AddPage();
            $pdf->SetY(5);
            $z=0;
        endif;
                
        
        $pdf->SetX(25);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(35, 5,'',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 5, 'Cheque Payments',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $chequePayments = Modules::run('college/finance/getChequePayments', $from, $to);
        $cpCount = 0;
        foreach ($chequePayments as $cp):
            $cpCount++;
            $z++;   
            //$totalChequePayments += $cp->t_amount;
            $pdf->SetX(20);
            $pdf->SetFont('helvetica', 'N', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(35, 5, $cp->bank_short_name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, $cp->tr_cheque_num,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, number_format(($cp->t_amount), 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            
            if($z==25):
                $pdf->AddPage();
                $pdf->SetY(5);
                $z=0;
            endif;
        endforeach;

            $z++;
            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'N', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(5);
            
            $z++;
            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, number_format(($totalChequePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(10);
            
            
            if($z==24):
                $pdf->AddPage();
                $pdf->SetY(5);
                $z=0;
            endif;
            
            
            $onlinePayments = Modules::run('college/finance/getOnlinePayments', $from, $to);
            $totalOnlinePayments = 0;
            if($onlinePayments):
                $pdf->SetX(25);
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->MultiCell(35, 5,'',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(50, 5, 'Online Payments',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();

                $opCount = 0;
                foreach ($onlinePayments as $op):
                    $opCount++;
                    $totalOnlinePayments += $op->t_amount;
                    $pdf->SetX(20);
                    $pdf->SetFont('helvetica', 'N', 9);
                    $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(35, 5, $op->bank_short_name.'-'.$op->t_remarks,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, $op->tr_cheque_num,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, number_format(($op->t_amount), 2, ".", ','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();
                endforeach;


                $pdf->SetX(25);
                $pdf->SetFont('helvetica', 'N', 9);
                $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(55, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln(5);

                $pdf->SetX(25);
                $pdf->SetFont('helvetica', 'B', 9);
                $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(55, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, number_format(($totalOnlinePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln(10);
            endif;
            
            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'N', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(5);

            $pdf->SetX(25);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->MultiCell(35, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(55, 5, 'TOTAL COLLECTION','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, number_format(($totalChequePayments+$totalCash+$totalOnlinePayments), 2, ".", ','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln(20);
        
            
            
        
      

//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
