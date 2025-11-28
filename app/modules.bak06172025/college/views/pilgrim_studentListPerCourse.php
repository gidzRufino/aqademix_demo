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
                    case 0:
                        $year = 'All Year Level';
                    break;
                endswitch;
                
                
                $this->SetTitle(strtoupper($settings->short_name));
                
                if($this->page==1):
                
                    $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                    $this->Image($image_file, 55, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                    $image_file = K_PATH_IMAGES.'/uccp.jpg';
                    $this->Image($image_file, 145, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                    $this->SetX(10);
                    $this->Ln(5);
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                    $this->Ln();
                    $this->SetFont('helvetica', 'N', 9);
                    $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    $this->Ln();
                    $this->SetFont('helvetica', 'n', 8);
                    $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    $this->Ln(8);
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell(0,4.3,"List of Students",0,0,'C');
                    $this->Ln(8);
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell(0, 15, strtoupper($course->course).' - '.$year, 0, false, 'C', 0, '', 1, false, 'M', 'M');
                    $this->Ln(5);
                    $this->SetFont('helvetica', 'B', 10);
                    $this->Cell(0, 15,$sem.' '.segment_6.' - '.$next, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    $this->Ln(10);
                endif;    
                
                
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

$pdf->SetY(50);

$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
$pdf->SetX(8);
$pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Middle Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Gender',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Year Level',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

foreach($students->result() as $st):
    
    $x++;
    $xy++;
    
    switch($st->year_level):
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
    
    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->SetX(8);
    $pdf->MultiCell(10, 5, $xy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, strtoupper($st->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, ucwords(strtolower($st->firstname)),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, ucwords(strtolower($st->middlename)),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, ucfirst($st->sex),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, ucfirst($year),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    
    if($pdf->getPage()==1):
        if($x==52):
            $x=0;
            $pdf->AddPage('P', $resolution);

            $pdf->SetY(10);
            $pdf->SetFont('helvetica', 'B', 10);
            // set cell padding
            $pdf->SetX(8);
            $pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, 'Middle Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, 'Gender',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, 'Year Level',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
    else:
        if($x==60):
            $x=0;
            $pdf->AddPage('P', $resolution);

            $pdf->SetY(10);
            $pdf->SetFont('helvetica', 'B', 10);
            // set cell padding
            $pdf->SetX(8);
            $pdf->MultiCell(10, 5, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, 'Last Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, 'First Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(40, 5, 'Middle Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, 'Gender',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, 'Year Level',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;

        
    endif;    
    
endforeach;



//Close and output PDF document
$pdf->Output('List of Enrollees.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
