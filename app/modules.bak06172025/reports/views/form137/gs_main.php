<?php

//require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        //Logo
        $this->MultiCell(210, 5, 'Republic of the Philippines', '', 'C', 0, 0, '', '', true);
        $this->Ln();
        $this->MultiCell(210, 5, 'Department of Education', '', 'C', 0, 0, '', '', true);
        $this->Ln();
        $this->SetFont('helvetica', 'B', 12);
        $this->MultiCell(210, 5, 'Learners Permanent Record for Elementary (SF10)', '', 'C', 0, 0, '', '', true);
        $this->Ln();
        $this->SetFont('helvetica', 'I', 8);
        $this->MultiCell(210, 5, '(Formerly Form 137)', '', 'C', 0, 0, '', '', true);
        $this->Ln();
        $image_file = K_PATH_IMAGES . 'lpr.png';
        $this->Image($image_file, 20, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES . 'pisd.png';
        $this->Image($image_file, 200, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF('P', 'mm', array('250', '300'), true, 'UTF-8', false);
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
// define style for border
// set font
$pdf->AddPage('P', '');
$pdf->Ln();

$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, 'LEARNER`S PERSONAL INFORMATION', '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(19, 5, "LAST NAME:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_lastname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "FIRST NAME:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 2, strtoupper($student->sprp_firstname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28, 5, "NAME EXTN.(Jr,I,II)", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 2, strtoupper($student->sprp_extname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(23, 5, "MIDDLE NAME:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_middlename), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(46, 5, "Learner Reference Number (LRN):", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, $student->sprp_lrn, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, "Birthdate (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 2, date('m/d/Y H:i:s', strtotime($student->sprp_bdate)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(19, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, "Sex:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 2, strtoupper($student->sprp_gender), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);
// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
// ------------------------------ ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLLMENT ------------------------------
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLLMENT", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);

$pdf->MultiCell(6, 5, "", 'T', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(1, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');

$pdf->CheckBox('newsletter', 5, '', '', array(), 'OK');
$pdf->MultiCell(45, 5, "Elementary School Completer", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(27, 5, "General Average:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, "", 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(26, 5, "Citation(IF ANY):", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(65, 5, "", 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, "", 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(6, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(43, 5, "Name of Elementary School:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(17, 5, "School ID:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(29, 5, "Address of School:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'LBR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();


// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(200, 5, 'Other Credential Presented', '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);


$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(1, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->CheckBox('newsletter', 5, '', '', array(), 'OK');
$pdf->MultiCell(22, 5, "PEPT Passer", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(13, 5, "Rating:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(5, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->CheckBox('newsletter', 5, '', '', array(), 'OK');
$pdf->MultiCell(28, 5, "ALS A & E Passer", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(13, 5, "Rating:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(5, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->CheckBox('newsletter', 5, '', '', array(), 'OK');
$pdf->MultiCell(32, 5, "Others(Pls. Specify):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(6, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, "Date of Examination/Assessment (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(56, 5, "Name and Address of Testing Center:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
// ------------------------------ SCHOLATIC RECORD ------------------------------
$stID = $student->sprp_st_id;
$sRec = Modules::run('reports/reports_f137/getSPRrec', $stID, $year);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "SCHOLASTIC RECORD", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 5, "School:", 'LT', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, strtoupper($sRec->school_name), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(18, 5, "School ID:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, $sRec->school_id, 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "District:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, strtoupper($sRec->district), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Division:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, strtoupper($sRec->division), 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Region:", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, strtoupper($sRec->region), 'BTR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(31, 5, "Classified as Grade:", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, strtoupper(levelDesc($sRec->grade_level_id)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Section:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(18, 5, strtoupper($sRec->section), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(21, 5, "School Year:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(9, 5, $year, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(36, 5, "Name of Adviser/Teacher:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, strtoupper($sRec->spr_adviser), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(18, 5, "Signature:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, "", 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'BLR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln(3);
// ------------------------------ SCHOLATIC RECORD ------------------------------
// ------------------------------ LEARNING AREAS ------------------------------

$aRec = Modules::run('reports/reports_f137/getAcademicRecords', $stID, $year, $sRec->grade_level_id);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(90, 13, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(80, 8, "Quarterly Meeting", '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(20, 13, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(40, 13, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(10, 8, "", '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->MultiCell(90, 5, '', 'BL', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "1", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "2", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "3", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "4", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
// ------------------------------ LEARNING AREAS ------------------------------
// ------------------------------ SUBJECT 1 ------------------------------
$t = 0;
$gAve = 0;
foreach ($aRec->result() as $ar):
    if ($ar->parent_subject == 11):
        $pdf->SetFont('helvetica', 'I', 9);
        $pdf->MultiCell(90, 5, '     ' . $ar->subject, 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(20, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 9);
        $mapehAve = ($ar->first + $ar->second + $ar->third + $ar->fourth) / 4;
        $pdf->MultiCell(20, 5, $mapehAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, ($mapehAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    else:
        $t++;
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->MultiCell(90, 5, $ar->subject, 'BL', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(20, 5, $ar->first, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->second, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->third, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $ar->fourth, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(20, 5, $ar->avg, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(40, 5, ($ar->avg < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $gAve += $ar->avg;
    endif;
    $pdf->Ln();
endforeach;

// ------------------------------ SUBJECT 12 ------------------------------
// ------------------------------ GENERAL AVERAGE ------------------------------
$genAve = round($gAve / $t, 2);
$pdf->SetFont('helvetica', 'BI', 9);
$pdf->MultiCell(90, 5, "", 'L', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, "GENERAL AVERAGE", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(20, 5, $genAve, '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, ($genAve < 75 ? 'FAILED' : 'PASSED'), '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
// ------------------------------ GENERAL AVERAGE ------------------------------


$pdf->MultiCell(230, 2, "", '1', 'C', 1, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();

// ------------------------------ GENERAL AVERAGE ------------------------------
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(80, 5, "Remedial Classes", 'L', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "Conducted From (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(30, 5, "To (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 1, "", 'LBR', 'C', 0, 0, '10', '', true, 0, false, true, 1, 'M');
$pdf->Ln();
// ------------------------------ GENERAL AVERAGE ------------------------------
// ------------------------------ REMEDIAL CLASSES ------------------------------
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(50, 5, "LEARNING AREAS", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, "FINAL RATING", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "REMEDIAL CLASS MARK", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "RECOMPUTED FINAL GRADE", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "REMARKS", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);
// ------------------------------ REMEDIAL CLASSES ------------------------------
// ------------------------------ CERTIFICATION ------------------------------
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "CERTIFICATION", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'LR', 'C', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(55, 5, "I CERTIFY that this is a true record of", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "with LRN", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(71, 5, "and that he/she is eligible for admission to Grade", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(3, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(26, 5, "Name of School:", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(17, 5, "School ID:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(41, 5, "Last School Year Attended:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(1, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 5, "", 'LR', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
// ------------------------------ Date ------------------------------
$pdf->MultiCell(60, 5, "", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
// ------------------------------ Date ------------------------------
// ------------------------------ Signature of Principal/School Head ------------------------------
$pdf->MultiCell(90, 5, "", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
// ------------------------------ Signature of Principal/School Head ------------------------------
// ------------------------------ Affix School Seal Here ------------------------------
$pdf->MultiCell(50, 5, "", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
// ------------------------------ Affix School Seal Here ------------------------------
$pdf->Ln();


$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(5, 5, "", 'LB', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(60, 5, "Date", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(90, 5, "Signature of Principal/School Head over Printed Name", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(50, 5, "(Affix School Seal Here)", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'BR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

function levelDesc($gradeID){
    switch ($gradeID):
        case 1:
            return 'Kinder';
        case 2:
            return 'Grade 1';
        case 3:
            return 'Grade 2';
        case 4:
            return 'Grade 3';
        case 5:
            return 'Grade 4';
        case 6:
            return 'Grade 5';
        case 7:
            return 'Grade 6';
        case 8:
            return 'Grade 7';
        case 9:
            return 'Grade 8';
        case 10:
            return 'Grade 9';
        case 11:
            return 'Grade 10';
        case 12:
            return 'Grade 11';
        case 13:
            return 'Grade 12';
    endswitch;
}


// ------------------------------ CERTIFICATION ------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page

$pdf->Output('example_001.pdf', 'I');

//============================================================+
    // END OF FILE
    //============================================================+
