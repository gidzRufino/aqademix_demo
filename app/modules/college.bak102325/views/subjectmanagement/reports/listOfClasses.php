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
            $this->Image($image_file, 100, 8, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $image_file = K_PATH_IMAGES . '/uccp.jpg';
            $this->Image($image_file, 185, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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
            $this->Cell(0, 4.3, "List of " . (segment_6 ? 'Reqested Subject' : ' Regular Subject'), 0, 0, 'C');
            $this->Ln(5);
            $this->SetFont('helvetica', 'N', 12);
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
$pdf->AddPage('L', $resolution);


$pdf->SetY(35);


$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 10);

$pdf->SetX(5);
$pdf->MultiCell(8, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Subject', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(85, 5, 'Descriptive Title', 1, 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
$pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Days', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'Time', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Students', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Instructor', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$countSubject = 0;
$x = 0;
foreach ($subjects as $s):
    $count++;
    $x++;
    $scheds = Modules::run('college/schedule/getSchedulePerSection', $s->sec_id, $semester, $school_year);
    $sched = json_decode($scheds);
    $students = Modules::run('college/subjectmanagement/getStudentsPerSection', $s->sec_id, $semester, $school_year);
    $instructor = Modules::run('collegel/schedule/getInstructorPerSchedule', $sched->sched_code);

    $pdf->SetX(5);
    $pdf->MultiCell(8, 5, $count, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, $s->sub_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(30, 5, $s->section, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(85, 5, ucwords(strtolower($s->s_desc_title)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(12, 5, ($s->sub_code == "NSTP 11" || $s->sub_code == "NSTP 12" || $s->sub_code == "NSTP 1" || $s->sub_code == "NSTP 2" ? 3 : ($s->s_lect_unit + $s->s_lab_unit)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, ($sched->count > 0 ? $sched->day : 'TBA'), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(35, 5, ($sched->count > 0 ? $sched->time : 'TBA'), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, $students->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(40, 5, strtoupper($sched->instructor), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();


    switch ($pdf->PageNo()):
        case 1:
            if ($x == 23):
                $x = 0;
                $pdf->AddPage('L', $resolution);

                $pdf->Ln(5);
                $pdf->SetFont('helvetica', 'N', 10);

                $pdf->SetX(5);
                $pdf->MultiCell(8, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'Subject', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(85, 5, 'Descriptive Title', 1, 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
                $pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'Days', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(35, 5, 'Time', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, 'Students', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, 'Instructor', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();
            endif;
            break;
        default :
            if ($x == 28):
                $x = 0;
                $pdf->AddPage('L', $resolution);
                $pdf->SetFont('helvetica', 'N', 10);

                $pdf->SetX(5);
                $pdf->MultiCell(8, 5, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'Subject', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, 'Section', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(85, 5, 'Descriptive Title', 1, 'C', 0, 0, '', '', true, 0, true, true, 5, 'M');
                $pdf->MultiCell(12, 5, 'Unit/s', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, 'Days', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(35, 5, 'Time', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, 'Students', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(40, 5, 'Instructor', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->Ln();

            endif;
            break;
    endswitch;


endforeach;


$pdf->Output('List of Classes.pdf', 'I');
