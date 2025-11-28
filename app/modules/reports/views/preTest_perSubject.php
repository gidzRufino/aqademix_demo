<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $settings = Modules::run('main/getSet');
                $adviser = Modules::run('academic/getAdvisory', '', segment_3);
                $male = Modules::run('registrar/getAllStudentsByGender', segment_3, 'Male', 1);
                $female = Modules::run('registrar/getAllStudentsByGender', segment_3, 'Female', 1);
                $total = $male->num_rows()+$female->num_rows();
                
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $nextYear = $settings->school_year + 1;
                
                $this->SetTitle('Pre Test');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, 'Republic of the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 15, 'Department of Education', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/fsLogo.png';
		$this->Image($image_file, 190, 8, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 10, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"Region X",0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"DIVISION OF CAGAYAN DE ORO CITY",0,0,'C');
                $this->Ln(5);
                $this->Cell(0,4.3,'Division Unified Test',0,0,'C');
                $this->Ln();
                $this->SetFont('helvetica', 'B', 8);
                $this->Cell(0,4.3,'First Grading Period',0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".$settings->school_year.' - '.$nextYear,0,0,'C');
                $this->Ln(5);
                $this->Cell(0,4.3,"District: ".$settings->district,0,0,'L');
                $this->Cell(0,4.3,"Grade / Year & Section : ".$section->level .' - '. $section->section,0,0,'R');
                $this->Ln();
                $this->Cell(0,4.3,"School: ".$settings->set_school_name,0,0,'L');
                $this->Cell(0,4.3,"Enrollment: ".$total,0,0,'R');
                
                
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
$section = Modules::run('registrar/getSectionById', segment_3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);

$pdf->SetY(50);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(23, 3, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'NAME',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(15, 5, 'RAW SCORE',1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(8, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(23, 3, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 3, 'NAME',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(15, 5, 'RAW SCORE',1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->Ln();

$term = Modules::run('main/getCurrentQuarter');

$pdf->SetFont('helvetica', 'B', 8);
$x = 0;
$maleTakers = 0;
foreach($male->result() as $s){
    
    $preTest = Modules::run('gradingsystem/getPreTestResult', $s->user_id, $term, segment_3, segment_4);
    if($preTest->row()->raw_score!=""):
        $maleSummation += $preTest->row()->raw_score;
        $maleTakers++;
    endif;
    $x++;
    $pdf->MultiCell(8, 3, $x,1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(23, 3, $s->user_id,1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(50, 3, strtoupper($s->lastname.', '.$s->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(15, 5, $preTest->row()->raw_score,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
    $pdf->Ln();
}
    

$y = 0;
$femaletakers = 0;
$pdf->SetY(65.5);
foreach($female->result() as $f){
    $preTest = Modules::run('gradingsystem/getPreTestResult', $f->user_id, $term, segment_3, segment_4);
    if($preTest->row()->raw_score!=""):
        $femaletakers++;
        $femaleSummation += $preTest->row()->raw_score;
    endif;  
$y++;
$pdf->SetX(114);
$pdf->MultiCell(8, 5, $y,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(23, 5, $f->user_id,1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(50, 5, strtoupper($f->lastname.', '.$f->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(15, 5, $preTest->row()->raw_score,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();

if($y==32):
    $y=0;
    $pdf->AddPage();
    $pdf->SetY(30);
    $pdf->SetFont('helvetica', 'B', 8);
    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'NAME',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, 'RAW SCORE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 3, 'NAME',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, 'RAW SCORE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
endif;
}
$preTest = Modules::run('gradingsystem/getPreTestResult', '', $term, segment_3, segment_4);
$highScore = Modules::run('gradingsystem/getHighLowScore', 'DESC', $term, segment_3,segment_4);
$lowScore = Modules::run('gradingsystem/getHighLowScore', 'ASC', $term, segment_3,segment_4);

$mean = ($maleSummation+$femaleSummation)/($maleTakers+$femaletakers);
$PL = ($mean/$preTest->row()->no_items)*100;

$pdf->SetFont('helvetica', 'B', 6);
$pdf->SetY(250);
$pdf->MultiCell(30, 3, 'No. of Items',1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 3, $preTest->row()->no_items,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(30, 3, 'No. of Classes (N)',1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 3, $maleTakers+$femaletakers,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(30, 3, "Total Score",1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 3, $maleSummation+$femaleSummation,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(30, 3, "Mean",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 3, round($mean, 2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(30, 3, "Proficiency Level",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 3, round($PL,2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(30, 3, "Highest Score",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 3, $highScore->raw_score,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln();
$pdf->MultiCell(30, 3, "Lowest Score",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 3, $lowScore->raw_score,1, 'C', 0, 0, '', '', true, 0, false, true, 5, '');


//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);

//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output($section->level.' - '.$section->section.'_Enrollees.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
