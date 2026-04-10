<?php

//require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        //Logo
        if ($this->page == 1):
            $this->MultiCell(210, 5, 'Republic of the Philippines', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->MultiCell(210, 5, 'Department of Education', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 12);
            $this->MultiCell(210, 5, 'Learners Permanent Record for Elementary School (SF10-ES)', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'I', 8);
            $this->MultiCell(210, 5, '(Formerly Form 137)', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $image_file = K_PATH_IMAGES . 'lpr.png';
            $this->Image($image_file, 20, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $image_file = K_PATH_IMAGES . 'lpr2.png';
            $this->Image($image_file, 200, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
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
$pdf = new MYPDF('P', 'mm', array('250', '400'), true, 'UTF-8', false);
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
$pdf->Ln(8);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, 'LEARNER`S PERSONAL INFORMATION', '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(15, 5, "LAST NAME:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_lastname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "FIRST NAME:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 2, strtoupper($student->sprp_firstname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28, 5, "NAME EXTN.(Jr,I,II)", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 2, strtoupper($student->sprp_extname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(23, 5, "MIDDLE NAME:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_middlename), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(37, 5, "Learner Reference Number (LRN):", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, $student->sprp_lrn, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, "Birthdate (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 2, date('m/d/Y', strtotime($student->sprp_bdate)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(19, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, "Sex:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 2, strtoupper($student->sprp_gender), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);
// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
// ------------------------------ ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLLMENT ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "ELIGIBILITY FOR ELEMENTARY SCHOOL ENROLMENT", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(1);

$pdf->MultiCell(230, 5, "", 'B', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(6, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(1, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(45, 5, "Credential Presented for Grade 1:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

//$pdf->CheckBox('newsletter', 3, '', '', array(), 'OK');
$pdf->Rect(64, 56, 2, 2);
$pdf->MultiCell(28, 5, "Kinder Progress Report", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Rect(117, 56, 2, 2);
$pdf->MultiCell(26, 5, "ECCD Checklist", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Rect(183, 56, 2, 2);
$pdf->MultiCell(49, 5, "Kindergarten Certificate of Completion", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(6, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(1, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(21, 5, "Name of School:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(14, 5, "School ID:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(23, 5, "Address of School:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(76, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->MultiCell(230, 2, "", 'LBR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();


// ------------------------------ OTHER CREDENTIAL PRESENTED ------------------------------
$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(200, 5, 'Other Credential Presented', '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);


$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(13, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Rect(20, 71, 2, 2);
$pdf->MultiCell(22, 5, "PEPT Passer", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(11, 5, "Rating:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(5, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, "Date of Examination/Assessment (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(33, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Rect(176, 71, 2, 2);
$pdf->MultiCell(25, 5, "Others(Pls. Specify):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(6, 5, "", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, "Name and Address of Testing Center:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(105, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "Remarks:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(58, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "SCHOLASTIC RECORD", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);
$nYear = $pYear - ($student->grade_level_id - 2);
for ($i = 0; $i < 8; $i++):
    switch ($i):
        case 0:
            $x = 10;
            $y = 90;
            break;
        case 1:
            $x = 128;
            $y = 90;
            break;
        case 2:
            $x = 10;
            $y = 220;
            break;
        case 3:
            $x = 128;
            $y = 220;
            break;
        case 4:
            $x = 10;
            $y = 10;
            break;
        case 5:
            $x = 128;
            $y = 10;
            break;
        case 6:
            $x = 10;
            $y = 160;
            break;
        case 7:
            $x = 128;
            $y = 160;
            break;
    endswitch;
    $data['i'] = $i;
    $data['x'] = $x;
    $data['y'] = $y;
    $data['pdf'] = $pdf;
    $data['student'] = $student;
    $data['year'] = $year;
    $data['nYear'] = $nYear + $i;

    $this->load->view('gs_main', $data);
endfor;
$pdf->Ln(10);
// ------------------------------ CERTIFICATION ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "CERTIFICATION", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'LR', 'C', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(55, 5, "I CERTIFY that this is a true record of", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(15, 5, "with LRN", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(71, 5, "and that he/she is eligible for admission to Grade", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(3, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 7);
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

$pdf->SetFont('helvetica', 'B', 7);
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

//
// ------------------------------ CERTIFICATION ------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page


function levelDesc($gradeID) {
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

//$data['pdf'] = $pdf;
//$data['student'] = $student;
//$data['year'] = $year;
//
//$this->load->view('gs_main', $data);
$pdf->Output('example_001.pdf', 'I');
