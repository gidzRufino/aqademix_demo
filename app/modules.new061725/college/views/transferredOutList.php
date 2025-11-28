<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
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

        if ($this->page == 1):
            //$this->SetTitle('Grading Sheet in '.$subject->subject);

            $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
            $this->Image($image_file, 145, 12, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $image_file = K_PATH_IMAGES . '/uccp.jpg';
            $this->Image($image_file, 238, 12, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $this->SetTopMargin(12);
            $this->Ln(5);
            $this->SetX(10);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $this->Ln();
            $this->SetFont('helvetica', 'N', 9);
            $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln();
            $this->SetFont('helvetica', 'n', 8);
            $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetTitle(strtoupper($settings->short_name));

            $this->Ln(3);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 4.3, "List of Students Transferred Out", 0, 0, 'C');
            $this->Ln(5);
            $this->SetFont('helvetica', 'N', 12);
            $this->Cell(0, 4.3, $sem . ', ' . segment_5 . ' - ' . $next, 0, 0, 'C');

        endif;
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

//variables




$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(400, 216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(30);


$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->Ln(15);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->SetX(10);
$pdf->MultiCell(95, 11, 'Name of Student', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(15, 11, 'Gender', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(100, 11, 'Course', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(30, 11, 'Year Level', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(30, 11, 'Date Withdrawn', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(100, 11, 'Reason', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->Ln();

foreach ($list as $l):
    $pdf->SetX(10);
    $pdf->MultiCell(95, 11, strtoupper($l->lastname) . ', ' . ucwords(strtolower($l->firstname)) . ($l->middlename != '' ? ' ' . ucwords(substr($l->middlename,0,1)) . '.' : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->MultiCell(15, 11, $l->sex, 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->MultiCell(100, 11, $l->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->MultiCell(30, 11, level($l->year_level), 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->MultiCell(30, 11, $l->remark_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->MultiCell(100, 11, $l->remarks, 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
    $pdf->Ln();
endforeach;

//Close and output PDF document
$pdf->Output('Promotional Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
function level($level){
    switch ($level):
        case 1:
            return 'First';
        case 2:
            return 'Second';
        case 3:
            return 'Third';
        case 4:
            return 'Fourth';
    endswitch;
}