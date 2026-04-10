<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_6);
                $gradeLevel = Modules::run('registrar/getGradeLevelById', segment_3);
                $strand = Modules::run('registrar/getSeniorHighStrand', segment_5);
                $settings = Modules::run('main/getSet');
                $adviser = Modules::run('academic/getAdvisory', NULL, segment_4, segment_6);
                
                $subject = Modules::run('academic/getSpecificSubjects', segment_4);
                $nextYear = segment_4 + 1;
                
                $image_file = K_PATH_IMAGES. '/' . $settings->set_logo;
                $this->Image($image_file, 55, 5, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                //$image_file = K_PATH_IMAGES.'/uccp.jpg';
                //$this->Image($image_file, 145, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $this->SetX(10);
                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
            //    $this->SetFont('helvetica', 'N', 9);
            //    $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
            //    $this->Ln();
                $this->SetFont('helvetica', 'n', 8);
                $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln(8);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0,4.3,"List of Enrollees",0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,"SY  ".segment_4.' - '.$nextYear,0,0,'C');
                $this->Ln();
                $this->Cell(0,4.3,$gradeLevel->level.' - '.$section->section,0,0,'L');
                $this->Cell(0,4.3,'Adviser: '.$adviser->row()->firstname.' '.$adviser->row()->lastname,0,0,'R');
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

function addMalePage($pdf)
{
    $x=0;
    $pdf->AddPage();
    $pdf->SetY(45);
    $pdf->SetFont('helvetica', 'B', 8);
    // set cell padding
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->Ln();
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->Ln();
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$section = Modules::run('registrar/getSectionById', segment_6);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->Ln();
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->MultiCell(42, 3, 'Firstname', 1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
$pdf->Ln();


$pdf->SetFont('helvetica', 'N', 8);
$x = 0;
$xy = 0;
if(count($male->result())<32):
    foreach($male->result() as $s){
        $x++;
        $xy++;
        $pdf->MultiCell(8, 3, $xy,1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(30, 3, strtoupper($s->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(15, 3, strtoupper(substr($s->middlename, 0, 1)).'.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(42, 3, strtoupper($s->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->Ln();
    }
    
    $y = 0;
    $yx = 0;
    $pdf->SetY(56);
    foreach($female->result() as $f){
        $y++;
        $yx++;
        $pdf->SetX(110);
        $pdf->MultiCell(8, 3, $yx,1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(30, 3, strtoupper($f->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(15, 3, ($f->middlename!=''||$f->middlename!='.'||$f->middlename!='-'?strtoupper(substr($f->middlename, 0, 1)).'.':''),1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->MultiCell(42, 3, strtoupper($f->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
        $pdf->Ln();

        if($y==40):
            $y=0;
            $pdf->AddPage();
            $pdf->SetY(45);
            $pdf->SetFont('helvetica', 'B', 8);
            // set cell padding
            $pdf->setCellPaddings(1, 1, 1, 1);
            $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->Ln();
            $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->Ln();
        endif;

    }
else:
    foreach($male->result() as $s){
    $x++;
    $xy++;
    $pdf->MultiCell(8, 3, $xy,1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(30, 3, strtoupper($s->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(15, 3, strtoupper(substr($s->middlename, 0, 1)).'.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(42, 3, strtoupper($s->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
    $pdf->Ln();

    if($x==32):
        $x=0;
        $pdf->SetY(45.5);
        foreach($female->result() as $f){
            $y++;
            $yx++;
            $pdf->SetX(110);
            $pdf->MultiCell(8, 3, $yx,1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(30, 3, strtoupper($f->lastname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(15, 3, strtoupper(substr($f->middlename, 0, 1)).'.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->MultiCell(42, 3, strtoupper($f->firstname),1, 'L', 0, 0, '', '', true, 0, false, true, 5,'M');
            $pdf->Ln();

            if($y==32):
                $y=0;
                $pdf->AddPage();
                $pdf->SetY(30);
                $pdf->SetFont('helvetica', 'B', 8);
                // set cell padding
                $pdf->setCellPaddings(1, 1, 1, 1);
                $pdf->MultiCell(95, 3, 'MALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(95, 3, 'FEMALE',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->Ln();
                $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(5, 3, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(8, 3, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(30, 3, 'Lastname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(15, 3, 'M.I.',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->MultiCell(42, 3, 'Firstname',1, 'C', 0, 0, '', '', true, 0, false, true, 5,'M');
                $pdf->Ln();
            endif;

            }
            addMalePage($pdf);

        endif;

    }
endif;



$pdf->SetY(290);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $male->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $female->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(75);
$pdf->MultiCell(30, 7.3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 7.3, $male->num_rows()+$female->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


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
