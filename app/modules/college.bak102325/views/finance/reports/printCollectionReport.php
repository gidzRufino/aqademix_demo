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
                $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->Image($image_file, 60, 5, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $this->SetX(10);
                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
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
$pdf->Cell(0, 0, 'Business Office Collection Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(15);
// set cell padding

$pdf->SetFont('helvetica', 'B', 7);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Particulars',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$total = 0;
$overAll = 0;
foreach($collection->result() as $c): 
    if($c->t_type!=5 && $c->t_type!=3):
        $overAll += $c->t_amount;
        $z++;

        if($c->acnt_type==0):
            $student = Modules::run('college/getBasicStudent', $c->t_st_id, $school_year)->row();
            if($student->lastname!=""):
                $name = $student->lastname.', '.$student->firstname;
            else:
                $student = Modules::run('registrar/getRfidByStid', $c->t_st_id);
                $name = $student->lastname.', '.$student->firstname;
            endif;
        else:
            $student = Modules::run('college/finance/getOtherAccountDetails', $c->t_st_id, $school_year);
            $name = $student->fo_lastname.', '.$student->fo_firstname;
        endif;

        if($overAll!=0):
            $pdf->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, date('F d, Y', strtotime($c->t_date)),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(20, 3, $c->ref_number,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, strtoupper($name),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, strtoupper(($c->fused_category==2?'Other Fees':$c->item_description)),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, number_format($c->t_amount, 2, ".", ','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->ln();
             if($z==30):
                 $z=0;
                $pdf->AddPage();
                $pdf->setCellPaddings(1, 1, 1, 1);

                $pdf->SetY(30);
                $pdf->SetFont('helvetica', 'B', 15);
                $pdf->Cell(0, 0, 'Business Office Collection Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $pdf->Ln();
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 0, '[ '.date('F d, Y', strtotime($from)).' - '.date('F d, Y', strtotime($to)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');

                $pdf->Ln(15);

                $pdf->SetFont('helvetica', 'B', 7);
                $pdf->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(20, 3, 'OR Number',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(50, 3, 'Account Name',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(50, 3, 'Particulars',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(30, 3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->Ln();
            endif;   
        endif;
    endif;    
endforeach;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(10, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(120, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, number_format($overAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
