<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {

            $settings = Modules::run('main/getSet');
            $next = segment_5 + 1;

            switch (segment_4):
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

            $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
            $this->Image($image_file, 55, 8, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $image_file = K_PATH_IMAGES . '/uccp.jpg';
            $this->Image($image_file, 140, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $this->SetTopMargin(5);
            $this->SetXY(10, 10);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $this->Ln();
            $this->SetFont('helvetica', 'N', 9);
            $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln();
            $this->SetFont('helvetica', 'n', 8);
            $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetTitle(strtoupper($settings->short_name));

            $this->Ln(8);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 4.3, 'Enrollment Summary', 0, 0, 'C');
            $this->Ln(5);
            $this->SetFont('helvetica', 'N', 12);
            $this->Cell(0, 4.3, $sem . ', ' . segment_5 . ' - ' . $next, 0, 0, 'C');

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom

        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(300, 210);
$pdf->AddPage('P', $resolution);


$pdf->SetY(35);


$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 10);

$pdf->MultiCell(15, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(125, 5, 'Courses', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Total Enrollee', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$c=1;
$totalStudents = 0;
foreach($details->result() as $group):
    
    $students = Modules::run('college/enrollment/getSummaryOfStudents', $group->course_id, segment_4, segment_5);
    $totalStudents += $students->num_rows();
    $pdf->MultiCell(15, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(10, 5, $c++, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(125, 5, $group->course, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, $students->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
endforeach;

    // $basicEd = Modules::run('college/enrollment/getSummaryOfBasicEdStudents', segment_4, segment_5);
    // $totalStudents += $basicEd->num_rows();
    // $pdf->MultiCell(15, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    // $pdf->MultiCell(10, 5, $c++, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    // $pdf->MultiCell(125, 5, 'Basic Education Department', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    // $pdf->MultiCell(30, 5, $basicEd->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    // $pdf->Ln();

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(15, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, 'TOTAL ENROLLEES', 'LTB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, $totalStudents, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(20);

$pdf->SetX(120);
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(30, 5, 'Prepared By:', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->SetX(145);
$pdf->MultiCell(40, 5, 'JOY M. CASIÑO', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(145);
$pdf->MultiCell(40, 5, 'Registrar', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$pdf->Output('Enrollment Summary.pdf', 'I');