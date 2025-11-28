<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
               
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$section = Modules::run('registrar/getSectionById', segment_3);
$settings = Modules::run('main/getSet');
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.$principal->lastname);
$first_row = $this->get_registrar_model->getAllStudentsForID(segment_4, segment_5, NULL, segment_3);
$second_row = $this->get_registrar_model->getAllStudentsForID(segment_4, segment_5+4, NULL, segment_3);


$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(215, 280);
$pdf->AddPage('L', $resolution);

$pdf->SetY(3);
$pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

 //loop
$x=7;
$y=3;
$a=0;


foreach (array_reverse($first_row->result()) as $s){ 
    $a++;
    
    $mother = Modules::run('registrar/getMother', $s->pid);
    $father = Modules::run('registrar/getFather', $s->pid);
    
    if($a==5):
        $y = 110;
        $x = 7;
    endif;
    
    $pdf->SetAlpha(0.3);
    $pdf->Ln();
    $pdf->SetXY($x, $y+50);
    $pdf->SetFillColor(252, 72, 255);
    $pdf->SetDrawColor(252, 72, 255);
    $pdf->Rect($x, $y+50, 55, 43, 'DF');
    $pdf->SetDrawColor(0, 0, 0);
    
    $pdf->SetAlpha(1);
    $pdf->SetXY($x-2,$y);
    $pdf->MultiCell(60, 95, '',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
    $pdf->SetDrawColor(252, 72, 255);
    $pdf->SetXY($x, $y+2);
    $pdf->Cell(55.8, 20, '', 1, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->SetFont('helvetica', 'I   ', 9);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(55.8, 20, 'This is to certify that the bearer of this identification card is a bonafide student of '.$settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');
    
    $pdf->SetFont('helvetica', 'N   ', 9);
    $pdf->Ln();
    $pdf->SetXY($x, $y+25);
    $pdf->MultiCell($x+50.8, 5, 'Birthday:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->ln();
    $pdf->SetXY($x+15, $y+25);
    $pdf->MultiCell(40, 5, $s->cal_date,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x, $y+33);
    $pdf->MultiCell($x+50.8, 5, 'Blood Type:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->ln();
    $pdf->SetXY($x+20, $y+33);
    $pdf->MultiCell(35, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x, $y+43);
    $pdf->MultiCell($x+50.8, 5, 'Present Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    if($s->street!=""):
        $address = $s->street.', '.$s->barangay.', '.$s->city.', '.$s->province;
    else:
        $address = $s->barangay.', '.$s->city.', '.$s->province;
    endif;
    
    if($father->cd_mobile!=""&&$mother->cd_mobile!=""){
       $separator = ' / ';
    }else{
        $separator = " ";
    }
    if($father->firstname!=""){
        $fatherName = $father->firstname.' '.$father->lastname;
    }else{
        $fatherName = "";
    }
    if($mother->firstname!="")
    {
        $motherName = $s->firstname.' '.$mother->lastname;
    }else{
        $motherName = "";
    }
    
    if($fatherName!=""):
        $fatherName = $fatherName;
    else:
        $fatherName = $motherName;
    endif;
    
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln();
    $pdf->SetXY($x, $y+50);
    $pdf->MultiCell(55.8, 5, 'In case of emergency please contact:',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+57);
    $pdf->MultiCell(50, 5, strtoupper($fatherName),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+62);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'NAME','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');    
    
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+67);
    $pdf->MultiCell(50, 15, $address,0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T'); 
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+75);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'ADDRESS','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');  
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+82);
    $pdf->MultiCell(50, 15, $father->cd_mobile.$separator. $mother->cd_mobile,0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+87);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'CONTACT','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
    
    $x = $x+70;

}
$y = 110;
$x = 7;

foreach (array_reverse($second_row->result()) as $s){ 
    $a++;
    
    $mother = Modules::run('registrar/getMother', $s->pid);
    $father = Modules::run('registrar/getFather', $s->pid);
    

    
    $pdf->SetAlpha(0.3);
    $pdf->Ln();
    $pdf->SetXY($x, $y+50);
    $pdf->SetFillColor(252, 72, 255);
    $pdf->SetDrawColor(252, 72, 255);
    $pdf->Rect($x, $y+50, 55, 43, 'DF');
    $pdf->SetDrawColor(0, 0, 0);
    
    $pdf->SetAlpha(1);
    $pdf->SetXY($x-2,$y);
    $pdf->MultiCell(60, 95, '',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
    $pdf->SetDrawColor(252, 72, 255);
    $pdf->SetXY($x, $y+2);
    $pdf->Cell(55.8, 20, '', 1, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->SetFont('helvetica', 'I   ', 9);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetXY($x, $y);
    $pdf->MultiCell(55.8, 20, 'This is to certify that the bearer of this identification card is a bonafide student of '.$settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');
    
    $pdf->SetFont('helvetica', 'N   ', 9);
    $pdf->Ln();
    $pdf->SetXY($x, $y+25);
    $pdf->MultiCell($x+50.8, 5, 'Birthday:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->ln();
    $pdf->SetXY($x+15, $y+25);
    $pdf->MultiCell(40, 5, $s->cal_date,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x, $y+33);
    $pdf->MultiCell($x+50.8, 5, 'Blood Type:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->ln();
    $pdf->SetXY($x+20, $y+33);
    $pdf->MultiCell(35, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x, $y+43);
    $pdf->MultiCell($x+50.8, 5, 'Present Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

    if($s->street!=""):
        $address = $s->street.', '.$s->barangay.', '.$s->city.', '.$s->province;
    else:
        $address = $s->barangay.', '.$s->city.', '.$s->province;
    endif;
    
    if($father->cd_mobile!=""&&$mother->cd_mobile!=""){
       $separator = ' / ';
    }else{
        $separator = " ";
    }
    if($father->firstname!=""){
        $fatherName = $father->firstname.' '.$father->lastname;
    }else{
        $fatherName = "";
    }
    if($mother->firstname!="")
    {
        $motherName = $s->firstname.' '.$mother->lastname;
    }else{
        $motherName = "";
    }
    
    if($fatherName!=""):
        $fatherName = $fatherName;
    else:
        $fatherName = $motherName;
    endif;
    
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Ln();
    $pdf->SetXY($x, $y+50);
    $pdf->MultiCell(55.8, 5, 'In case of emergency please contact:',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+57);
    $pdf->MultiCell(50, 5, strtoupper($fatherName),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+62);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'NAME','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');    
    
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+67);
    $pdf->MultiCell(50, 15, $address,0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T'); 
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+75);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'ADDRESS','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');  
    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+82);
    $pdf->MultiCell(50, 15, $father->cd_mobile.$separator. $mother->cd_mobile,0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');    
    $pdf->Ln();
    $pdf->SetXY($x+2, $y+87);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->MultiCell(50, 15, 'CONTACT','T', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
    
    $x = $x+70;

}

//    $pdf->SetXY(3,110);
//    $pdf->MultiCell(60, 95, '',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');



//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);


//Close and output PDF document
$pdf->Output('ID -'.$section->level.'-'.$section->section.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
