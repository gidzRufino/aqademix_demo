<?php

class MYPDF extends Pdf {
    //Page header
    public function Header() {
        $section = Modules::run('registrar/getSectionById', segment_3);
        $settings = Modules::run('main/getSet');
        $adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);
    // Logo$this->SetTopMargin(4);
        
        switch (segment_4){
            case 1:
                $term = 'FIRST QUARTER';
            break;
            case 2:
                $term = 'SECOND QUARTER';
            break;
            case 3:
                $term = 'THIRD QUARTER';
            break;
            case 4:
                $term = 'FOURTH QUARTER';
            break;
        }
        
        switch (TRUE):
            case ($section->grade_id <= 13 && $section->grade_id >= 12):
                $department = 'Senior High School';
            break;
            case ($section->grade_id <= 10 && $section->grade_id >= 8):
                $department = 'Junior High School';
            break;
            case ($section->grade_id < 8 && $section->grade_id >= 1 ):
                $department = 'Elementary';
            break;
        
        endswitch;
        
        $nextYear = segment_5 + 1;
        $this->SetX(5);
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'n', 8);
        $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(5);
        
        $this->SetFont('helvetica', 'B', 10);
        $this->MultiCell(180, 5, 'Ad Form 2. CLASS RANKING', '', 'C', 0, 0, '', '', true);
        $this->Ln(8);

        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 0, $term.', S.Y. '.segment_5.' - '.$nextYear, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();

        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 0, $department.' Department', 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        
        $this->Cell(0, 0, $section->level.' - '.$section->section, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();


// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->SetXY(15, 40);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(66, 5, '', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 5, 'Average', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(12, 5, 'Rank', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 5, 'Descriptor', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Remarks', 0, 'C', 0, 0, '', '', true);
$pdf->Ln();

$i = 1;
$r = 1;

$section = Modules::run('registrar/getSectionById', segment_3);
$student = Modules::run('gradingsystem/gradingsystem_reports/generateTop',segment_3, segment_4, $students);
$sameRank = Modules::run('gradingsystem/gradingsystem_reports/getSameRank', $student);
$previousRank = 0;
$it = 1;

foreach ($student as $key => $s):
    
    $descriptor = json_decode(Modules::run('gradingsystem/gradingsystem_reports/getGSLegend', $s['grade']));
    $remarks = json_decode(Modules::run('gradingsystem/gradingsystem_reports/getGSHonorsLegend', $s['grade']));
    $rank = $it++;
    $previousRank = $rank;
    foreach ($sameRank as $sk => $sr):
        if($s['grade']==$sr['grade']):
            $rank = $sr['rank'];
        endif;
    endforeach;
    
    $pdf->SetFont('times', '', 10);
    $pdf->MultiCell(10, 5, $i++, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(66, 5, $s['student'], 1, 'L', 0, 0, '', '', true);
    $pdf->MultiCell(17, 5, $s['grade'], 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(12, 5, $rank, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(25, 5, $descriptor->abr, 1, 'C', 0, 0, '', '', true);
    $pdf->MultiCell(55, 5, $remarks->legend, 1, 'C', 0, 0, '', '', true);
    $pdf->Ln(); 
endforeach;

$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(60, 2, 'LEGEND:', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'O', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Outstanding - - - - - - - - - - - - - -  90 - 100%', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'VS', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Very Satisfactory - - - - - - - - - -   85 - 89%', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'S', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Satisfactory - - - - - - - - - - - - - -   80 - 84%', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'FS', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Fairly Satisfactory  - - - - - - - - -   75 - 79%', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'D', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Did Not Meet Expectations - - -   Below 75%', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(13, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'TO', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Transferred Out', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(13, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, 'DO', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(65, 2, 'Dropped Out', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

switch (TRUE):
    case ($section->grade_id <= 13 && $section->grade_id >= 12):
        $principal = 'PRINCESS NEL-ANN B. OLO, LPT';
        $position = 'Senior High School Focal Person';
    break;
    case ($section->grade_id <= 10 && $section->grade_id >= 8):
        $principal = 'REGINO T. PANES, EdD';
        $position = 'High School Principal';
    break;
    case ($section->grade_id < 8 && $section->grade_id >= 1 ):
        $principal = 'MYRNA R. REDOBLE, MAT-Math';
        $position = 'Grade School Principal';
    break;

endswitch;


$adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(19, 2, 'Prepared By:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname), 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 2, ', Adviser', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(28, 2, 'Certified Correct By:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, $principal, 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 2, 'Approved By:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, '', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(28, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, $position, '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(60, 2, 'Director, SBE', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
