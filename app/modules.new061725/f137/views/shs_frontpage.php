<?php

//require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $settings = Modules::run('main/getSet');

        //Logo
        if ($this->page == 1):
            $this->SetFont('helvetica', 'B', 12);
            $this->MultiCell(210, 5, $settings->set_school_name, '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'R', 8);
            $this->MultiCell(40, 5, '', '', 'C', 0, 0, '', '', true);
            $this->MultiCell(130, 5, $settings->set_school_address, '', 'C', 0, 0, '', '', true);
            $this->MultiCell(60, 5, 'Recognition No. (RXI) No. 10 s. 2005', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 12);
            $this->MultiCell(210, 5, 'PERMANENT RECORD', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'R', 8);
            $this->MultiCell(210, 5, 'Basic Education Curriculum', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
            $this->Image($image_file, 20, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
$pdf = new MYPDF('P', 'mm', array('250', '450'), true, 'UTF-8', false);
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
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, 'LEARNER`S PERSONAL INFORMATION', '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(19, 5, "LAST NAME:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_lastname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "FIRST NAME:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 2, strtoupper($student->sprp_firstname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28, 5, "NAME EXTN.(Jr,I,II)", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 2, strtoupper($student->sprp_extname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(23, 5, "MIDDLE NAME:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 2, strtoupper($student->sprp_middlename), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(7, 5, "LRN:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 2, $student->sprp_lrn, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(5, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(28, 5, "Date of Birth (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 2, date('m/d/Y', strtotime($student->sprp_bdate)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->MultiCell(19, 2, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8, 5, "Sex:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 2, strtoupper($student->sprp_gender), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(38, 5, "Date of SHS Admission (mm/dd/yyyy):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 2, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);
// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
// ------------------------------ ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLLMENT ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "ELIGIBILITY FOR SENIOR HIGH SCHOOL ENROLLMENT", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7);

$pdf->MultiCell(6, 5, "", 'T', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(1, 5, "", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');

//$pdf->CheckBox('newsletter', 5, '', '', array(), 'OK');

$genRec = Modules::run('sf10/getGenRecByID', $student->sprp_st_id, $pYear);
$skulSet = Modules::run('sf10/getSkulInfoByID', $genRec->shs_add_id, $this->session->school_year, 1);
$pdf->Rect(13, 66, 2.5, 2.5);
$pdf->MultiCell(6, 5, "", 'T', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "High School Completer*", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(13, 5, "Gen. Ave:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '', 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->Rect(96, 66, 2.5, 2.5);
$pdf->MultiCell(10, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, "Junior High School Completer", 'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(13, 5, "Gen. Ave:", 'T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, $genRec->jhs_ave, 'BT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(63, 5, "", 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(45, 5, "Date of SHS Admission (mm/dd/yyyy):", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 2, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(21, 5, "Name of School:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $skulSet->school_name, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->MultiCell(20, 5, "School Address:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, strtoupper($skulSet->street . ', ' . $skulSet->barangay_id . ', ' . $skulSet->mun_city . ', ' . $skulSet->province), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->Rect(13, 76, 2.5, 2.5);
$pdf->MultiCell(25, 5, "PEPT Passer**", 'L', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", '', '', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "Rating:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Rect(76, 76, 2.5, 2.5);
$pdf->MultiCell(25, 5, "ALS A&E Passer", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", '', '', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, "Rating:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Rect(143, 76, 2.5, 2.5);
$pdf->MultiCell(25, 5, "Others(Pls. Specify):", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(63, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(55, 5, "Date of Examination/Assessment (mm/dd/yyyy):", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "Name and Address of Community Learning Center:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, "", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(120, 5, "*High School Completers are student who graduated from secondary school under the old curriculum", 'L', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110, 5, "***ALS A&E - Alternative Learning System Accreditation and Equivalency Test For JHS", 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 6);
$pdf->MultiCell(230, 3, "**PEPT - Philippine Education Placement Test for JHS", 'LR', 'L', 0, 0, '10', '', true, 0, false, true, 3, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", 'LBR', 'L', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 5, "SCHOLASTIC RECORD", '1', 'C', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);

$nYear = ($student->grade_level_id == 12 ? $pYear : ($pYear - 1));

for ($i = 0; $i < 4; $i++):
    switch ($i):
        case 0:
            $x = 10;
            $y = '';
            break;
        case 1:
            $x = 10;
            $y = 255;
            break;
        case 2:
            $x = 10;
            $y = 10;
            break;
        case 3:
            $x = 10;
            $y = 170;
            break;
        case 4:
            $x = 10;
            $y = 5;
            break;
    endswitch;
//    $data['subjectList'] = Modules::run('subjectmanagement/getAllSHSubjects', $student->grade_level_id, (($i == 0 || $i == 1) ? '1' : '2'), $strand_id);
    $data['strand'] = $strand_id;
    $data['i'] = $i;
    $data['x'] = $x;
    $data['y'] = $y;
    $data['pdf'] = $pdf;
    $data['student'] = $student;
    $data['year'] = $year;
    $data['sYear'] = ($i == 0 || $i == 1 ? $nYear : ($nYear + 1));

//    $this->load->view('shs_main', $data);
endfor;
$pdf->Ln(5);
// ------------------------------ CERTIFICATION ------------------------------
$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetFillColor(191, 191, 191);
$pdf->MultiCell(230, 3, "", '', 'C', 1, 0, '10', '', true, 0, false, true, 3, 'M');
$pdf->Ln();

$pdf->MultiCell(230, 2, "", '', 'C', 0, 0, '10', '', true, 0, false, true, 2, 'M');
$pdf->Ln();

$str_id = Modules::run('sf10/getStrand', $strand_id, 2);
$pdf->SetFont('helvetica', '', 7);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(35, 4, "Track/Strand Accomplished: ", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(130, 4, $str_id->strand, 'B', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(30, 4, "SHS General Average: ", '', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(35, 4, $student->shs_ave, 'B', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(5);

$pdf->MultiCell(35, 4, "Awards/Honors Received: : ", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(120, 3, "", 'B', 'L', 1, 0, '', '', true, 0, false, true, 3, 'M');
$pdf->MultiCell(50, 4, "Date of SHS Graduation (MM/DD/YYYY): ", '', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(25, 3, "", 'B', 'L', 1, 0, '', '', true, 0, false, true, 3, 'M');
$pdf->Ln(5);

$pdf->MultiCell(35, 4, "Certified by: ", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(70, 3, "", '', 'L', 1, 0, '', '', true, 0, false, true, 3, 'M');
$pdf->MultiCell(50, 4, "Place School Seal Here: ", '', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(25, 3, "", '', 'L', 1, 0, '', '', true, 0, false, true, 3, 'M');
$pdf->Ln(15);

$pdf->MultiCell(75, 4, "High School Registrar", 'T', 'C', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(10, 4, "", '0', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(30, 4, "Date", 'T', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(120, 4, "NOTE:", 'TRL', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->Ln();
$pdf->MultiCell(120, 15, "This permanent record or a photocopy of this permanent record that bears the seal of the school and the "
        . "original signature in ink of the School Head shall be considered valid for all legal purpose. Any erasure or alteraton "
        . "made on this copy should be validated by the School Head.", 'RL', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(5, 4, "", 'L', 'R', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(100, 25, "not valid w/o dry seal or if altered", '', 'C', 1, 0, '', '', true, 0, false, true, 25, 'M');
$pdf->Ln(11);
$pdf->MultiCell(120, 15, "If the student transfers to other school, the originating school should produce one (1) certified true "
        . "copy of this permanent record for safekeeping. The receiving school shall continue filling up the original form. Upon "
        . "graduation, the school from which the student graduated should keep the original form and produce one (1) certified "
        . "true copy for the Division Office.", 'BRL', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');
$pdf->Ln(16);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(16, 4, "REMARKS: ", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('helvetica', 'R', 7);
$pdf->MultiCell(90, 4, "(Please indicate the purpose for which this permanent record will be used)", '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(16);

$pdf->MultiCell(35, 4, "Date issued (MM/DD/YYYY): ", '', 'L', 1, 0, '10', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(25, 3, "", 'B', 'L', 1, 0, '', '', true, 0, false, true, 3, 'M');

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
