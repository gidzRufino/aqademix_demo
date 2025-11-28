<?php
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo


        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(15, 5, '', '', 'L', 0, 0, '', '', true);
        $this->MultiCell(150, 2, 'PHILIPPINE ELECTRONICS AND COMMUNICATION INSTITUTE OF TECHNOLOGY', '', 'C', 0, 0, '', '', true);
        $this->Ln();

        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(30, 5, '', '', 'L', 0, 0, '', '', true);
        $this->MultiCell(120, 5, 'Imadejas Subdivision, Butuan City', '', 'C', 0, 0, '', '', true);
        $this->Ln();
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
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(35, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(110, 2, 'FORM IX ', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(35, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(110, 2, 'COLLEGIATE/GRADUATE STUDIES RECORD', '', 'C', 0, 0, '', '', true);
$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(11, 2, 'Name:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(94, 2, 'Juan Dela Cruz Jr.', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(13, 2, 'Gender:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, 'Female', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 2, 'Date of Birth:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(85, 2, 'December 16, 1986', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(22, 2, 'Place of Birth:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, 'Jampang, Argao, Cebu', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(23, 2, 'Home Address:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(82, 2, 'Exemeria, Manyayay, Lianga SDS', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(25, 2, 'Parent/Guardian:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, 'Mr. & Mrs. Juan Dela Cruz Sr.', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(46, 2, 'Intermediate Course Completed:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(59, 2, 'Licuan Elementary School', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 2, 'School Year:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, '2007-2008', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(44, 2, 'Secondary Course Completed:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(61, 2, 'SCNHS-Licuan NHS', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(20, 2, 'School Year:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, '2011-2012', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(30, 2, 'Basis of Admission:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 2, 'TOR, NSO', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 2, 'ID No.:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, '015-016512', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(25, 2, 'Degree/Program:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(80, 2, 'BACHELOR OF ELEMENTARY EDUCATION', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(12, 2, 'Major:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 2, 'N/A', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(29, 2, 'Date of Graduation:', '', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(80, 2, 'March 28, 2018', '', 'L', 0, 0, '', '', true);
$pdf->Ln(5);


$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 7, 'SUBJECT CODE', '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(60, 7, 'DESCRIPTIVE TITLE', '1', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(15, 5, 'Final Grade', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, 'Total Units', '1', 'C', 0, 0, '', '', true);

$pdf->MultiCell(60, 2, 'CREDITS DISTRIBUTION', '1', 'C', 0, 0, '', '', true);
$pdf->MultiCell(25, 2, '', '', 'C', 0, 1, '', '', true);
$pdf->MultiCell(6, 2, '1', '1', 'C', 0, 0, '135', '', true);
$pdf->MultiCell(6, 2, '2', '1', 'C', 0, 0, '141', '', true);
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '147', '', true);
$pdf->MultiCell(6, 2, '4', '1', 'C', 0, 0, '153', '', true);
$pdf->MultiCell(6, 2, '5', '1', 'C', 0, 0, '159', '', true);
$pdf->MultiCell(6, 2, '6', '1', 'C', 0, 0, '165', '', true);
$pdf->MultiCell(6, 2, '7', '1', 'C', 0, 0, '171', '', true);
$pdf->MultiCell(6, 2, '8', '1', 'C', 0, 0, '177', '', true);
$pdf->MultiCell(6, 2, '9', '1', 'C', 0, 0, '183', '', true);
$pdf->MultiCell(6, 2, '10', '1', 'C', 0, 0, '189', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'BI', 8);
$pdf->MultiCell(180, 2, 'UP Diliman', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(180, 2, '1st Sem AY 2012-2013', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Engl 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Communication Arts 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.00', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Engl Plus 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'English Remedial', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.50', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Fil 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Komunikasyon sa Akademikong Filipino', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.30', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Math 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Fundamentals of Math/Integrative Course', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '1.60', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Science 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Biological Science', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '1.80', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'SocSc 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'General Psychology', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '1.60', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Pract Arts 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Home Economics/Livelihood Education 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '1.80', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'PE 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Physical Fitness', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.10', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '2', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'NSTP 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Civic Welfare Training Service', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.10', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 2, 'Hum 1', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'Art Education', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '2.30', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(30, 2, '', '1', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(60, 2, 'TOTAL', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 2, '26', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '15', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '5', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(6, 2, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 2, 'Summary of Units Earned', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(90, 2, 'Units Earned', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'Group of Credits/Units Distribution', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, 'Units Required', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, 'Units Earned', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'I - General Education Courses -------------------------------------------------', 'LRT', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '63', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '66', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'II - Theory/Concepts Courses --------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '12', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '12', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'III - Method/Strategies Courses ------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '27', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '30', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'IV - Field Study Courses ---------------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '12', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '12', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'V - Special Topics Courses -----------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '3', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '4', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'VI - Content Courses --------------------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '57', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '62', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'VII - NSTP -----------------------------------------------------------------------------', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '6', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'VIII - Research -----------------------------------------------------------------------', 'LRB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '6', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(90, 3, 'TOTAL', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(36, 3, '174', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 3, '198', '1', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(5, 3, '', '', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(44, 3, 'I certify that the forgoing Form IX of ', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(45, 3, 'KRISTINE M. PANGALAY', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(86, 3, 'is true and correct and has been verified by the undersigned as College', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(145, 3, 'Registrar, and that the original copies of the officeial records substantiating the same are kept in the files of our school.', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(125, 3, '', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 3, 'MARITA Z. CORRALES', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(125, 3, '', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(50, 3, 'Registrar Signature Over Printed Name', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);
$pdf->MultiCell(125, 3, '', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(50, 3, 'Dated Signed:', '', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->Ln(10);



// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// reset pointer to the last page
$pdf->lastPage();
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
