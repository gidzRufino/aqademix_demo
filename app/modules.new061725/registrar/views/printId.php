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


foreach ($students->result() as $s){ 
    $a++;
    
    if($a==5):
        $y = 110;
        $x = 7;
    endif;
    
    
    $pdf->SetXY($x-2,$y);
    $pdf->MultiCell(60, 95, '',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
    
    $pdf->SetXY($x, $y+2);
    $pdf->Cell(55.8, 15, '', 1, false, 'C', 0, '', 0, false, 'T', 'M');

    $pdf->SetAlpha(0.3);
    $image_file = K_PATH_IMAGES.'/school_logo.png';
    $pdf->Image($image_file, $x-2.5, $y+32, 60, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    $pdf->SetAlpha(1);
    
    $image_file = K_PATH_IMAGES.'/sign1.png';
    $pdf->Image($image_file, $x+15, $y+70, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    $pdf->SetXY(15+$x, $y+20);
    $pdf->Cell(25, 25, '', 1, false, 'C', 0, '', 0, false, 'T', 'M');
    $image_file = AVATAR.'/'.$s->avatar;
    $pdf->Image($image_file, $x+15, $y+20, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    
    $pdf->SetFont('Times', 'N', 7);
    $pdf->SetXY($x, $y+1.5);
    $pdf->Cell(55.8, 5, 'Department of Eduction', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->SetXY($x, $y+4);
    $pdf->Cell(55.8, 5, 'Division of Cagayan de Oro City', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetXY($x, $y+6.5);
    $pdf->Cell(55.8, 5, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->SetFont('Times', 'I', 7);
    $pdf->SetXY($x, $y+8.8);
    $pdf->Cell(55.8, 5, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->SetFont('Times', 'N', 7);
    $pdf->SetXY($x, $y+11.5);
    $pdf->Cell(55.8, 5, 'Telephone No. 850-1973', 0, false, 'C', 0, '', 0, false, 'T', 'M');

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetXY($x, $y+45);
    $pdf->Cell(55.8, 5, 'LRN: '.$s->st_id, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    $pdf->Ln(7);

    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, strtoupper($s->firstname.' '.$s->lastname), 0, false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->SetX($x);
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, 'NAME', 'T', false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, $section->level.' - '.$section->section, 0, false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, 'YEAR & SECTION', 'T', false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->Ln(8);

    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, $name, 0, false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->Cell(55.8, 5, 'SCHOOL PRINCIPAL', 'T', false, 'C', 0, '', 0, false, 'T', 'T');
    $pdf->Ln(6);

    $pdf->SetFont('helvetica', 'I', 7);
    $pdf->SetX($x);
    $pdf->Cell(55.8, 5, '"Making Brighter Future Today"', 0, false, 'C', 0, '', 0, false, 'T', 'T');
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
