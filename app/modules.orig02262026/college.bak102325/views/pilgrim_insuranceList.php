<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $next = segment_6 + 1;

                switch(segment_5):
                    case 1:
                        $sem = 'First Semester';
                    break;
                    case 2:
                        $sem = 'Second Semester';
                    break;
                    case 3:
                        $sem = 'Summer';
                    break;
                endswitch;
                
                if($this->page==1):
                    //$this->SetTitle('Grading Sheet in '.$subject->subject);
                    $course  = Modules::run('coursemanagement/getCoursePerId', segment_4);
                    $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                    $this->Image($image_file, 115, 3, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    
                    $image_file = K_PATH_IMAGES.'/uccp.jpg';
                    $this->Image($image_file, 200, 3, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    
                    $this->SetTopMargin(4);
                    $this->Ln(5);
                    $this->SetX(10);
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                    $this->Ln();
                    $this->SetFont('helvetica', 'N', 9);
                    $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    $this->Ln();
                    $this->SetFont('helvetica', 'n', 8);
                    $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

                    $this->SetTitle(strtoupper($settings->short_name));

                    $this->Ln(10);
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0,4.3,"Insurance List",0,0,'C');
                    $this->Ln(5);
                    $this->SetFont('helvetica', 'N', 12);
                    $this->Cell(0,4.3,$sem.', '.segment_6.' - '.$next,0,0,'C');
                    $this->Ln(8);
                    $this->SetFont('helvetica', 'N', 12);
                    $this->Cell(0, 0, ucwords(strtolower($course->course)), 0, false, 'C', 0, '', 0, false, 'M', 'M');
                    
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
$resolution= array(216,330.2);
$pdf->AddPage('L', $resolution);

$pdf->SetY(40);


$pdf->setCellPaddings(1, 1, 1, 1);


$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 9);
// set cell padding
$pdf->SetX(35);
$pdf->MultiCell(33, 5, 'ID Number',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, 'Full Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Gender',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Birthday',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(120, 5, 'Address',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Year',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$x = 1;
$y = 0;
$z = 0;
foreach ($students->result() as $st):
    if($st->status):
        $z++;
        $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $st->admission_id, segment_5 );

        $address = ($st->street!=""?$st->street.', '.$st->barangay.', '.$st->mun_city.' '.$st->province:$st->barangay.', '.$st->mun_city.' '.$st->province);

        $middlename = ($st->middlename!=""||$st->middlename!=NULL?$st->middlename.' ':'');
        $x++;
        $y++;
        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->SetX(35);
        $pdf->MultiCell(8, 5, ($z),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, ($y==1?$st->uid:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, strtoupper($st->lastname).', '.ucwords(strtolower($st->firstname)).' '.ucwords(strtolower($middlename)),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, substr($st->sex, 0,1),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, date('m/d/Y', strtotime($st->temp_bdate)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(120, 5,ucwords(strtolower($address)),1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, $st->year_level,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        switch ($pdf->PageNo()):    
            case 1:
                if($x==26):
                $pdf->AddPage('L', $resolution);
                $pdf->Ln(10);

                $x = 1;
                endif;
            break;
            default :
                if($x==35):
                    $pdf->AddPage('L', $resolution);
                    $pdf->Ln(10);
                $x=1;

                endif;
            break;    
        endswitch;
    endif;
    
    $y=0;    
endforeach;





//Close and output PDF document
$pdf->Output('Enrollment List.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
