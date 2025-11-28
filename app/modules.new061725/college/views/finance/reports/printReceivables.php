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
switch ($semester):
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

if($dept_id==4):
    $courseName = Modules::run('college/coursemanagement/getCoursePerId', $course_id)->course;
    $sy = $school_year.' - '.($school_year+1).' ( '.$sem.' )';
else:
    $courseName = Modules::run('registrar/getGradeLevelById', $course_id)->level;
    $sy = $school_year.' - '.($school_year+1).($semester==3?' ( '.$sem.' )':'');
endif;

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'List of Receivables', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, $courseName, 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, 'S.Y.'.$school_year.' - '.($school_year+1), 0, false, 'C', 0, '', 0, false, 'M', 'T');


$pdf->ln(15);
// set cell padding

$pdf->SetFont('helvetica', 'B', 9);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'Course / Grade Level',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'Balance',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$z=0;
$y=0;
$total = 0;
$overAll = 0;
foreach($students as $student): 
    if($dept_id==4):
        
        $hasBalance = json_decode(Modules::run('college/finance/getBalance', base64_encode($student->st_id), $semester, $school_year));
        switch ($student->year_level):
                case 1:
                    $year_level = 'First Year';
                break;    
                case 2:
                    $year_level = 'Second Year';
                break;    
                case 3:
                    $year_level = 'Third Year';
                break;    
                case 4:
                    $year_level = 'Fourth Year';
                break;    
            endswitch;
    else:
        $hasBalance = json_decode(Modules::run('college/finance/getBasicFinanceBalance', base64_encode($student->st_id), $school_year, $semester));
        
    endif;
    
    if($hasBalance->status):
        $z++;
        $y++;
        $pdf->SetFont('helvetica', 'N', 9);
        $pdf->MultiCell(10, 3, $y ,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, strtoupper($student->lastname),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, strtoupper($student->firstname),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, ($dept_id==4?$student->short_code.' - '.$year_level:$student->level),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, number_format($hasBalance->rawBalance,2,'.',','),1, 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        
        
         if($z==32):
             $z=0;
            $pdf->AddPage();
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->SetY(30);
            $pdf->SetFont('helvetica', 'B', 15);
            $pdf->Cell(0, 0, 'List of Receivables', 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $pdf->Ln();
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 0, 'School Year ', 0, false, 'C', 0, '', 0, false, 'M', 'T');

            $pdf->ln(15);
            
            $pdf->MultiCell(10, 3, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(50, 3, 'Course / Grade Level',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(30, 3, 'Amount',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->Ln();
         endif;   
            $overAll += $hasBalance->rawBalance;
    endif;
endforeach;
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(140, 3, 'TOTAL','BL', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(50, 3, number_format($overAll, 2, ".", ','),'BR', 'R', 0, 0, '', '', true, 0, false, true, 10, 'M');
        


//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
