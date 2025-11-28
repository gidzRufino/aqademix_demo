<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $next = segment_6 + 1;
                $course = Modules::run('college/coursemanagement/getCoursePerId', segment_3);
                switch(segment_5):
                    case 1:
                        $sem = '1st Semester';
                    break;
                    case 2:
                        $sem = '2nd Semester';
                    break;
                    case 3:
                        $sem = 'Summer';
                    break;
                endswitch;
                switch(segment_4):
                    case 1:
                        $year = '1st Year';
                    break;
                    case 2:
                        $year = '2nd Year';
                    break;
                    case 3:
                        $year = '3rd Year';
                    break;
                    case 4:
                        $year = '4th Year';
                    break;
                    case 3:
                        $year = '5th Year';
                    break;
                endswitch;
                
                //$this->SetTitle('Grading Sheet in '.$subject->subject);
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $this->SetTitle(strtoupper($settings->short_name));
                
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
		$this->Image($image_file, 23, 6, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(15);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"List of Students",0,0,'C');
                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 15, strtoupper($course->course).' - '.$year, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 15,$sem.' '.segment_6.' - '.$next, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(10);
                
                
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

//variables




$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);

$pdf->SetY(40);

$pdf->SetFont('helvetica', 'B', 10);
// set cell padding
$pdf->SetX(8);
$pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Id Number',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(65, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Middle Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

foreach($students->result() as $st):
    
    $x++;
    $xy++;
    
    
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->SetX(8);
    $pdf->MultiCell(10, 5, $xy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, ucfirst($st->st_id),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, ucfirst($st->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(65, 5, ucfirst($st->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, ucfirst($st->middlename),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    
    if($x==50):
        $x=0;
        $pdf->AddPage('P', $resolution);

        $pdf->SetY(40);
        $pdf->SetFont('helvetica', 'B', 10);
        // set cell padding
        $pdf->SetX(8);
        $pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, 'Id Number',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(60, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(65, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, 'Middle Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;
    
endforeach;



//Close and output PDF document
$pdf->Output('List of Enrollees.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
