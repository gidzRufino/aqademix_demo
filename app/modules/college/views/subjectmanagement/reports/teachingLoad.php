<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {

        if ($this->page == 1):
            $settings = Modules::run('main/getSet');
            $next = segment_4 + 1;

            switch (segment_5):
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
            $this->Cell(0, 4.3, "Instructor's Teaching Load", 0, 0, 'C');
            $this->Ln(5);
            $this->SetFont('helvetica', 'N', 10);
            $this->Cell(0, 4.3, $sem . ', ' . segment_4 . ' - ' . $next, 0, 0, 'C');

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

$employee = Modules::run('hr/getEmployee', $id);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(85, 5, 'Instructor : ' . strtoupper($employee->lastname . ', ' . $employee->firstname), 0, 'L', 0, 0, '', '', true, 0, true, true, 5, 'M');

$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 8);

$pdf->SetX(5);
$pdf->MultiCell(8, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Subject', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Section', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(85, 5, 'Descriptive Title', 1, 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
$pdf->MultiCell(47, 5, 'Schedule', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$totalUnits = 0;
$x = 0;
foreach ($subjects as $s):
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $sem, $school_year);
    $sched = json_decode($scheds);

    if($s->sec_sem == $sem):
        $x++;
        $totalUnits += ($s->sub_code == "NSTP 11" || $s->sub_code == "NSTP 12" || $s->sub_code == "NSTP 1" || $s->sub_code == "NSTP 2" ? 3 : ($s->s_lect_unit + $s->s_lab_unit));
        $pdf->SetX(5);
        $pdf->MultiCell(8, 5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, $s->sub_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(25, 5, $s->section, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(85, 5, ucwords(strtolower($s->s_desc_title)), 1, 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
        $pdf->MultiCell(47, 5, ($sched->count > 0 ? $sched->time . ' [ ' . $sched->day . ' ]' : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, ($s->sub_code == "NSTP 11" || $s->sub_code == "NSTP 12" || $s->sub_code == "NSTP 1" || $s->sub_code == "NSTP 2" ? 3 : ($s->s_lect_unit + $s->s_lab_unit)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endif;   

endforeach;

$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(140, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Total Load : '.$totalUnits.' units', 0, 'R', 0, 0, '', '', true, 0, true, true, 5, 'M');

$pdf->Output('Teaching Load.pdf', 'I');
