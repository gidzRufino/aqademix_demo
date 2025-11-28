<?php
//set_time_limit(120);
class MYPDF extends Pdf {
    
    //Page header
    public function Header() {
        // Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(4);
                $this->Ln(5);
             //   $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
        $this->SetFont('helvetica', 'n', 8);
        $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->SetTitle('Daily Collection Report Per Teller');
        }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
                
        $this->SetY(-15);     
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

$from = segment_5;

$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Daily Collection Report Per Teller', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, 'S.Y. '.($this->session->school_year).' - '.($this->session->school_year+1), 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(8);
// set cell padding

$pdf->SetFont('helvetica', 'B', 9);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(15, 3, 'Teller :',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(70, 3, $this->session->name,0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, 'Date Collection: '. date('F d, Y', strtotime($from)),0, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetX(5);
$pdf->MultiCell(10, 3, '#','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(45, 3, 'Account Name','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Item','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, 'Payment Type','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'Bank | Cheque #','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, 'OR #','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, 'Payment','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$y=0;
$total = 0;
$overAll = 0;
$totalCash = 0;
$totalCollection = 0;
$totalCheque = 0;
$totalAdvanceCash = 0;
$totalAdvanceCheque = 0;
$encashTotalAmount = 0;
$totalAdvanceCollection = 0;
foreach($collection as $c):
    if($c->t_type!=5 && $c->t_type!=3):
        $z++;
        $y++;
        if($c->acnt_type==0):
            $student = Modules::run('college/getBasicStudent', $c->t_st_id, $school_year)->row();
            if($student->lastname!=""):
                $name = $student->lastname.', '.$student->firstname;
            else:
                $student = Modules::run('registrar/getRfidByStid', $c->t_st_id);
                $name = $student->lastname.', '.$student->firstname;
            endif;
        else:
            $student = Modules::run('college/finance/getOtherAccountDetails', $c->t_st_id);
            $name = $student->fo_lastname.', '.$student->fo_firstname;
        endif;
        if($c->fused_category == 0):
            $des = Modules::run('college/finance/getFinanceItemById',$c->t_charge_id);
            $description = $des->item_description;
        else:
            $des = Modules::run('college/finance/getFinCategory',$c->fused_category);
            $description = $des->fin_category;
        endif;

        $pdf->SetX(5);
        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->MultiCell(10, 3, $z,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(45, 3, strtoupper($name),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 3, strtoupper($description),0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 3, ($c->t_type==0?'Cash':($c->t_type==4?'Online Transaction':'Cheque')),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 3, ($c->t_type==1?$c->bank_short_name.' | '.$c->tr_cheque_num:''),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 3, $c->ref_number,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 3, number_format($c->t_amount,2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $rowTotal = 0;
        $totalCollection += $c->t_amount;
        if($y==37):
            $y=1;
            $pdf->AddPage();
            $pdf->Ln(15);
            $pdf->SetX(5);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(5, 3, '#',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(45, 3, 'Account Name','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Item','B', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(25, 3, 'Payment Type','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'Bank | Cheque #','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(20, 3, 'OR #','B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(25, 3, 'Payment','B', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
        endif;
    endif;    
endforeach;

        $pdf->SetX(5);
        $pdf->MultiCell(205, 1, '','T', 'R', 0, 0, '', '', true, 0, false, true, 1, 'M');
        $pdf->Ln(1);
        
        $pdf->SetX(5);
        $pdf->MultiCell(205, 1, '','T', 'R', 0, 0, '', '', true, 0, false, true, 1, 'M');
        $pdf->Ln();
        
        $pdf->SetX(5);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(5, 3, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 3, 'TOTAL',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(150, 3, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 3, number_format($totalCollection,2,'.',','),0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
      
        $pdf->Ln(30);
        
        
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(138, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, 'Cashier','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        
    

//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+