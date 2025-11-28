<?php
set_time_limit(300);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		
                $this->SetTitle('Monthly Collectible Statement');
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
$x=3;
$y=5;
$a=0;

foreach($students->result() as $student):
//for($i=0;$i<=3;$i++):
    $a++;
//    
   // if($a <= 4):

        if($a==3):
           $y=170;
           $x=3;
        endif;
        $financeDetails = json_decode(Modules::run('finance/finance_reports/getFinanceDetails', $student, $month));
        $pdf->SetXY($x,$y);

        $image_file = K_PATH_IMAGES.$settings->set_logo;
        $pdf->Image($image_file, $x+20, $y-2, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $pdf->SetFont('helvetica', 'N', 20);
        $pdf->SetX($x+15);
        $pdf->MultiCell(88, 20, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 20, 'T');
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->Ln(-12);
        $pdf->SetX($x);
        $pdf->MultiCell(15, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->MultiCell(88, 5, 'MOLDING CHAMPIONS',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->Ln(15);
        $pdf->SetX($x);
        $pdf->MultiCell(15, 5, 'NAME :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(85, 5, $student->firstname.' '.substr($student->middlename, 0,1).'.  '.$student->lastname,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln(8);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(15, 5, 'LEVEL :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(85, 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        $pdf->Ln(10);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'B', 13);
        $pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->MultiCell(88, 5, 'BILLING STATEMENT',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->Ln();
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->MultiCell(88, 5, 'for the month of '.$monthName,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
        
        $pdf->Ln(12);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(100, 5, 'Kindly settle your past/current bill with the following details:',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        
        $pdf->Ln(8);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'TUITION :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(35, 5,number_format(round($financeDetails->tuition),2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'STUDENT DEV :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(35, 5, number_format(round($financeDetails->SD),2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'MISCELLANEOUS :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(35, 5, number_format(round($financeDetails->MISC),2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'BOOKS :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(35, 5,number_format(round($financeDetails->books),2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        $pdf->Ln();
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'TOTAL AMOUNT DUE :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(35, 5, number_format($financeDetails->totalAmountDue,2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        $pdf->Ln(8);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(45, 5, 'RUNNING BALANCE :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(35, 5, number_format($financeDetails->totalCharges - $financeDetails->totalPayment,2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        $pdf->Ln(12);
        $pdf->SetX($x);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(105, 5, 'Please bring this statement upon payment. We strictly implement a',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->SetXY($x+3, $y+109);
        $pdf->SetFont('helvetica', 'B', 11);
        $pdf->MultiCell(80, 5, 'NO PERMIT NO EXAM POLICY.',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        $pdf->Ln(8);
        $pdf->SetX($x+7);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(100, 5, 'Disregard this Statement if Payment has been made.',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->Ln(8);
        $pdf->SetX($x+7);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(100, 5, 'Thank you!',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
        
        
        $pdf->Ln(20);
        $pdf->SetX($x+7);
        $pdf->SetFont('helvetica', 'N', 10);
        $pdf->MultiCell(50, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
        $pdf->MultiCell(40, 5, 'Business Office','T', 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
        
  //  endif;    
    $x = $x+107;
endforeach;




//Close and output PDF document
$pdf->Output('Billing.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
