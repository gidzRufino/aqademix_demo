<?php
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo

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
$pdf = new MYPDF('P', 'mm', array('120', '250'), true, 'UTF-8', false);
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


$pdf->AddPage('P', '');
$pdf->Ln(20);

// START STUDENT INFO



$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(50, 2, 'Republic of the Philippines', '', 'C', 0, 0, '35', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(50, 2, 'DEPARTMENT OF EDUCATION', '', 'C', 0, 0, '35', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(50, 2, 'Region V - B MIMAROPA', '', 'C', 0, 0, '35', '', true);
$pdf->Ln();

$pdf->MultiCell(50, 2, 'Division of Puerto Princesa City', '', 'C', 0, 0, '35', '', true);
$pdf->Ln();



$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 110, 75, 7, '', 'PNG', '', 'T', false, 0, '', false, false, 0, false, false, false);

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(12, 2, 'Name:', 'LT', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(85, 2, 'GALECIO, VIRAH EUNICE', 'TR', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(9, 2, 'Age:', 'L', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(10, 2, '12', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(10, 2, '', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(14, 2, 'Gender:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(54, 2, 'Female', 'R', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(21, 2, 'Grade Level:', 'L', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(76, 2, 'Grade 8', 'R', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(14, 2, 'Section:', 'L', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(83, 2, 'Collaborators', 'R', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(21, 2, 'School Year:', 'L', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(76, 2, '2018-2019', 'R', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(10, 2, 'LRN:', 'BL', 'L', 0, 0, '10', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(87, 2, '111501140351', 'BR', 'L', 0, 0, '', '', true);
$pdf->Ln();
// END STUDENT INFO

// START SCHOLASTIC ACHIEVMENT 
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(97, 2, 'SCHOLASTIC ACHIEVMENT', '', 'C', 0, 0, '10', '', true);;
$pdf->Ln();

$pdf->MultiCell(35, 6, 'SUBJECT AREAS', '1', 'C', 0, 0, '10', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(30, 6, 'FIRST QUARTER', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(32, 6, 'REMARKS', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'FILIPINO', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '82', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'ENGLISH', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '81', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'SCIENCE', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '80', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'MATH', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '80', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(35, 5, 'ARALING PANLIPUNAN', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(30, 5, '85', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'TLE / COMPUTER', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'MAPEH', '1', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'Music', '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'Arts', '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '85', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'P.E.', '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '83', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(35, 5, 'Health', '1', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(35, 6, 'EDUKASYON PAGPAPAKATAO(ESP)', '1', 'L', 0, 0, '10', '', true, 0, false, true, 6, 'M');
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(30, 6, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(32, 6, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(35, 6, 'FOREIGN LANGUAGE (BAHASA MELAYO)', '1', 'L', 0, 0, '10', '', true, 0, false, true, 6, 'M');
$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(30, 6, '84', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->MultiCell(32, 6, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(35, 5, 'AVERAGE', '', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '83', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'passed', '1', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
// END SCHOLASTIC ACHIEVMENT 

// START REPORT ATTENDANCE 
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(97, 2, 'REPORT ATTENDANCE', '', 'C', 0, 0, '10', '', true);;
$pdf->Ln();

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(53, 10 , 'ATTENDANCE', '1', 'C', 0, 0, '10', '', true, 0, false, true, 10, 'M');

$pdf->SetFont('helvetica', '', 8);
$pdf->StartTransform();
$pdf->Rotate(90); 
$pdf->MultiCell(10, 11, 'JUN', '1', 'C', 0, 0, '53', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(10, 11, 'JUL', '1', 'C', 0, 0, '53', '171', true, 0, false, true, 11, 'M');
$pdf->MultiCell(10, 11, 'AUG', '1', 'C', 0, 0, '53', '182', true, 0, false, true, 11, 'M');

$pdf->SetFont('helvetica', 'B', 6.5);
$pdf->MultiCell(10, 11, 'TOTAL', '1', 'C', 0, 0, '53', '193', true, 0, false, true, 11, 'M');
$pdf->StopTransform();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(53, 5, 'SCHOOL DAYS', '1', 'L', 0, 0, '10', '170', true, 0, false, true, 5, 'M');
$pdf->SetFillColor(200, 218, 247);
$pdf->MultiCell(11, 5, '14', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '22', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '23', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '59', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(53, 5, 'DAYS PRESENT', '1', 'L', 0, 0, '10', '175', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '14', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '22', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '23', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '59', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 9);
$pdf->MultiCell(53, 5, 'DAYS TARDY', '1', 'L', 0, 0, '10', '180', true, 0, false, true, 5, 'M');
$pdf->SetFillColor(200, 218, 247);
$pdf->MultiCell(11, 5, '0', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '0', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '0', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(11, 5, '0', '1', 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->Ln();


$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(97, 5, 'CHRISTINE JEAN T. UMANITO', '', 'C', 0, 0, '10', '200', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(60, 5, '', 'B', 'C', 0, 0, '28', '200', true, 0, false, true, 5, 'M');
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(97, 5, 'CLASS ADVISER', '', 'C', 0, 0, '10', '205', true, 0, false, true, 5, 'M');
$pdf->Ln();
// END REPORT ATTENDANCE










// Close and output PDF document
// This method has several options, check the source code documentation for more information.

$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
