<?php
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo

        $image_file = K_PATH_IMAGES . 'pilgrim.jpg';
        $this->Image($image_file, 10, 10, 160, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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

$pdf->AddPage();
// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));



$pdf->MultiCell(10, 10, ' ', '', 'L', 0, 0, '', '', true);
$pdf->Ln(30);


$pdf->SetFont('times', 'BI', 15);
$pdf->SetFillColor(146, 255, 130);
$pdf->MultiCell(190, 8, 'Offical Transcript of Records', '1', 'C', 1, 0, '', '', true);
$pdf->Ln();


$pdf->SetFont('times', 'BI', 10);
$pdf->MultiCell(30, 5, 'Accredited:', '', 'R', 0, 0, '', '', true);
$pdf->SetFont('times', 'I', 10);
$pdf->MultiCell(145, 7, 'Association of Christian Schools, Colleges and Universities - Accrediting Agency Inc. (ACSCU-AAI)', '', 'L', 0, 0, '', '', true);
$pdf->Ln();


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(1, 145, 56)));
$pdf->MultiCell(190, 5, '', 'T', 'R', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

// Name
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(12, 2, "Name:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, "A.", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'C', 0, 0, '', '', true);
// Name
// Date of Admission
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(31, 2, "Date of Admission:", '', 'R', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(50, 2, "March 04, 2019", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();
// Date of Admission

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 2, "", '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '(Last)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(40, 2, '(First)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '(M.I)', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
// Admission Credential
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(36, 2, 'Admission Credential:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(45, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();
// Admission Credential

// Date of Birth
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(23, 2, "Date of Birth:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Date of Birth
$pdf->MultiCell(3, 2, "", '', 'R', 0, 0, '', '', true);
// Sex
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(9, 2, 'Sex:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(20, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Sex
$pdf->MultiCell(13, 2, "", '', 'R', 0, 0, '', '', true);
// Home Address
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(26, 2, "Home Address:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(55, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();
// Home Address

// Place of Birth
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(24, 2, "Place of Birth:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Place of Birth
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
// Civil Status
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(21, 2, "Civil Status:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(20, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Civil Status
$pdf->MultiCell(1, 2, "", '', 'R', 0, 0, '', '', true);
// City Address
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(23, 2, "City Address:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(58, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();
// City Address

// Citizenship
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(20, 2, "Citizenship:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Citizenship
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
// Religion
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(16, 2, "Religion:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Religion
$pdf->MultiCell(1, 2, "", '', 'R', 0, 0, '', '', true);
// Degree
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(14, 2, "Degree:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(61, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();
// Degree

// Mother
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(14, 2, "Mother:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(38, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Mother
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
// Father
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(14, 2, "Father:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(38, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Father
$pdf->MultiCell(2, 2, "", '', 'R', 0, 0, '', '', true);
// Major
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(12, 2, "Major:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(25, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
// Major
$pdf->MultiCell(1, 2, "", '', 'R', 0, 0, '', '', true);
// Date Conferred
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(26, 2, "Date Conferred:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(17, 2, "Input Here", 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(10);
// Date Conferred

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(190, 3, "RECORD OF PRELIMINARY EDUCATION", '', 'C', 0, 0, '', '', true);
$pdf->Ln(7);


$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(25, 5, "Primary:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(63, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(68, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(4, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(8, 5, "SY:", '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(19, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(25, 5, "Intermediate:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(63, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(68, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(4, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(8, 5, "SY:", '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(19, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(25, 5, "High School:", '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(63, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(2, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(68, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(4, 2, "", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(8, 5, "SY:", '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(19, 2, "Input Here", 'B', 'C', 0, 0, '', '', true);
$pdf->Ln(7);


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(40, 3, "COURSE & NUMBER", 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(90, 3, "DESCRIPTIVE TITLE", 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "FINAL RATING", 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "CREDITS", 1, 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();
// LOOP HERE SIR :D 

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(40, 3, "WEBPROG / 92012", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(90, 3, "WEBSITE PROGRAMMING", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "90%", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "3", '', 'C', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(40, 3, "ITPROJ / 2245", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(90, 3, "INFORMATION TECHNOLOGY THESIS", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "83%", '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, "4", '', 'C', 0, 0, '', '', true);
$pdf->Ln(30);
// ---END---


$pdf->SetFont('helvetica', '', 8);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(190, 3, '-more entries next page-', 'B', 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln(10);


$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50, 3, '1.0 - 95 -100 ', 'R', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.4 - 91', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.8 - 87', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.2 - 83', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.6 - 79', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 3, ' 3.0 - 75', '', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(50, 3, '1.1 - 94 ', 'R', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.5 - 90', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.9 - 86', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.3 - 82', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.7 - 78', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 3, ' 5.0 - Failure', '', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(50, 3, '1.2 - 93 ', 'R', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.6 - 89', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.0 - 85', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.5 - 81', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.8 - 77', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(50, 3, '1.3 - 92 ', 'R', 'R', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 1.7 - 88', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.1 - 84', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.5 - 80', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(13, 3, ' 2.9 - 76', 'R', 'L', 0, 0, '', '', true);
$pdf->MultiCell(25, 3, '', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 3, 'REMARKS:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(170, 3, 'Please refer to page 2 for more entries..', 'B', 'L', 0, 0, '', '', true);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(190, 3, 'CERTIFICATION', '', 'C', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(15, 3, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(57, 3, 'I hereby certify that the foregoing records of', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(40, 3, '', 'B', 'C', 0, 0, '', '', true);
$pdf->MultiCell(40, 3, 'has been verified and that the', '', 'C', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(10, 3, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(155, 3, 'true copies of the official transcript of records substantiating the same are kept in the files of our school.', '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->MultiCell(40, 3, 'NOT VALID ', '', 'C', 0, 0, '', '', true);
$pdf->Ln();
$pdf->MultiCell(40, 3, 'WITHOUT SEAL ', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(20, 5, 'Prepared by:', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 3, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Checked & Verified by:', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->MultiCell(40, 3, ' ', '', 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(40, 3, '     ANA LYN R. CABRERA', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->MultiCell(30, 3, '', '', 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(35, 3, '       JOY M. CASIÑO', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

$pdf->MultiCell(40, 3, ' ', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(40, 3, '           Credit Evaluator', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(30, 3, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 3, '         OIC - Registar', '', 'L', 0, 0, '', '', true);
$pdf->Ln(40);


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(190, 3, '', 'B', 'C', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));


$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
