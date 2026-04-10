<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
        $settings = Modules::run('main/getSet');
        $next = segment_6 + 1;

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

        if ($this->page == 1):
            //$this->SetTitle('Grading Sheet in '.$subject->subject);

            $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
            $this->Image($image_file, 155, 12, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            $image_file = K_PATH_IMAGES . '/uccp.jpg';
            $this->Image($image_file, 258, 12, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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

            $this->Ln(4);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 4.3, "Enrollment List", 0, 0, 'C');
            $this->Ln(5);
            $this->SetFont('helvetica', 'N', 12);
            $this->Cell(0, 4.3, $sem . ', ' . segment_6 . ' - ' . $next, 0, 0, 'C');

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
$resolution = array(430, 216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(30);


$pdf->setCellPaddings(1, 1, 1, 1);


$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->SetX(5);
$pdf->MultiCell(35, 5, '', 'TBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, 'Program Name: ', 'TBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(245, 5, $students->row()->course, 'TB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(110, 5, '', 'TRB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(120, 5, '', 'TBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(300, 5, '', 'TRB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
// set cell padding
$pdf->SetX(5);
$pdf->MultiCell(35, 5, 'ID Number', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Last Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'First Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'Middle Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'Sex', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, 'Home Address', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Year Level', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Course Code', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(105, 5, 'Course Description', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'Units', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$x = 1;
$y = 0;
$cnt = 0;
foreach ($students->result() as $st):
    if ($st->status == 1):
        if ($opt != NULL):
            if ($st->uid == 2020120487 || $st->uid == 20191502582 || $st->uid == 2020120161 || $st->uid == 20191502960 || $st->uid == 20191501433 || $st->uid == 20191502126):
                $cnt++;
                $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $st->admission_id, segment_5, segment_6);
                $address = ($st->street != "" ? $st->street . ', ' . $st->barangay . ', ' . $st->mun_city . ' ' . ($st->zip_code == 0 ? '' : $st->zip_code) : $st->barangay . ', ' . $st->mun_city . ' ' . ($st->zip_code == 0 ? '' : $st->zip_code));
                if (count($loadedSubject) > 0):
                    foreach ($loadedSubject as $subject):

                        $totalUnits = ($subject->sub_code == "NSTP 11" || $subject->sub_code == "NSTP 12" || $subject->sub_code == "NSTP 1" || $subject->sub_code == "NSTP 2" ? 3 : ($subject->s_lect_unit + $subject->s_lab_unit));
                        $count = count($loadedSubject);
                        $x++;
                        $y++;
                        $pdf->SetFont('helvetica', 'N', 9);
                        $pdf->SetX(5);
                        $pdf->MultiCell(10, 5, ($y == 1 ? $cnt : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, ($y == 1 ? $st->uid : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(40, 5, ($y == 1 ? strtoupper($st->lastname) : ""), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(40, 5, ($y == 1 ? ucwords(strtolower($st->firstname)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(35, 5, ($y == 1 ? ucwords(strtolower($st->middlename)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(10, 5, ($y == 1 ? substr($st->sex, 0, 1) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(100, 5, ($y == 1 ? ucwords(strtolower($address)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, ($y == 1 ? $st->year_level : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, $subject->sub_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(105, 5, $subject->s_desc_title, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(10, 5, $totalUnits, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->Ln();

                        switch ($pdf->PageNo()):
                            case 1:
                                if ($x == 23):
                                    $pdf->AddPage('L', $resolution);
                                    $pdf->Ln(10);

                                    $x = 1;
                                endif;
                                break;
                            default :
                                if ($x == 27):
                                    $pdf->AddPage('L', $resolution);
                                    $pdf->Ln(10);
                                    $x = 1;

                                endif;
                                break;
                        endswitch;
                    endforeach;
                else:
                    $pdf->SetFont('helvetica', 'N', 9);
                    $pdf->SetX(5);
                    $pdf->MultiCell(10, 5, $cnt, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, $st->uid, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, ucwords(strtolower($st->lastname)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, ucwords(strtolower($st->firstname)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(35, 5, ucwords(strtolower($st->middlename)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10, 5, substr($st->sex, 0, 1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(100, 5, $address, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $st->year_level, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(105, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();

                    switch ($pdf->PageNo()):
                        case 1:
                            if ($x == 23):
                                $pdf->AddPage('L', $resolution);
                                $pdf->Ln(10);

                                $x = 1;
                            endif;
                            break;
                        default :
                            if ($x == 27):
                                $pdf->AddPage('L', $resolution);
                                $pdf->Ln(10);
                                $x = 1;

                            endif;
                            break;
                    endswitch;
                endif;
            endif;
        else:
            if ($st->uid != 2020120487 && $st->uid != 20191502582 && $st->uid != 2020120161 && $st->uid != 20191502960 && $st->uid != 20191501433 && $st->uid != 20191502126):
                $cnt++;
                $loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $st->admission_id, segment_5, segment_6);
                $address = ($st->street != "" ? $st->street . ', ' . $st->barangay . ', ' . $st->mun_city . ' ' . ($st->zip_code == 0 ? '' : $st->zip_code) : $st->barangay . ', ' . $st->mun_city . ' ' . ($st->zip_code == 0 ? '' : $st->zip_code));
                if (count($loadedSubject) > 0):
                    foreach ($loadedSubject as $subject):

                        $totalUnits = ($subject->sub_code == "NSTP 11" || $subject->sub_code == "NSTP 12" || $subject->sub_code == "NSTP 1" || $subject->sub_code == "NSTP 2" ? 3 : ($subject->s_lect_unit + $subject->s_lab_unit));
                        $count = count($loadedSubject);
                        $x++;
                        $y++;
                        $pdf->SetFont('helvetica', 'N', 9);
                        $pdf->SetX(5);
                        $pdf->MultiCell(10, 5, ($y == 1 ? $cnt : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, ($y == 1 ? $st->uid : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(40, 5, ($y == 1 ? strtoupper($st->lastname) : ""), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(40, 5, ($y == 1 ? ucwords(strtolower($st->firstname)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(35, 5, ($y == 1 ? ucwords(strtolower($st->middlename)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(10, 5, ($y == 1 ? substr($st->sex, 0, 1) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(100, 5, ($y == 1 ? ucwords(strtolower($address)) : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(20, 5, ($y == 1 ? $st->year_level : ''), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(25, 5, $subject->sub_code, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(105, 5, $subject->s_desc_title, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->MultiCell(10, 5, $totalUnits, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                        $pdf->Ln();

                        switch ($pdf->PageNo()):
                            case 1:
                                if ($x == 23):
                                    $pdf->AddPage('L', $resolution);
                                    $pdf->Ln(10);

                                    $x = 1;
                                endif;
                                break;
                            default :
                                if ($x == 27):
                                    $pdf->AddPage('L', $resolution);
                                    $pdf->Ln(10);
                                    $x = 1;

                                endif;
                                break;
                        endswitch;
                    endforeach;
                else:
                    $pdf->SetFont('helvetica', 'N', 9);
                    $pdf->SetX(5);
                    $pdf->MultiCell(10, 5, $cnt, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, $st->uid, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, ucwords(strtolower($st->lastname)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(40, 5, ucwords(strtolower($st->firstname)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(35, 5, ucwords(strtolower($st->middlename)), 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10, 5, substr($st->sex, 0, 1), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(100, 5, $address, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(20, 5, $st->year_level, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(105, 5, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(10, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->Ln();

                    switch ($pdf->PageNo()):
                        case 1:
                            if ($x == 23):
                                $pdf->AddPage('L', $resolution);
                                $pdf->Ln(10);

                                $x = 1;
                            endif;
                            break;
                        default :
                            if ($x == 27):
                                $pdf->AddPage('L', $resolution);
                                $pdf->Ln(10);
                                $x = 1;

                            endif;
                            break;
                    endswitch;
                endif;
            endif;
        endif;

    endif;

    $y = 0;
endforeach;





//Close and output PDF document
$pdf->Output('Enrollment List.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
