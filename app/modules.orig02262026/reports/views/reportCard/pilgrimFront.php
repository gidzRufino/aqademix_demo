<?php
class MYPDF extends Pdf {
    public function Header() {
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(279.4,215.9);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$students = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$sy = $this->session->userdata('school_year');

$x=3;
$y=3;
$a=0;
$pdf->SetXY(3, 2);
$pdf->MultiCell(270, 0.1, "",'T', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(3);
$pdf->SetX(140);
$pdf->MultiCell(0, 205, "",'L', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');


for($i = 0, $j = 2; $i < $j; $i++){

    $x += 2;
    if($i == 1):
        $x += 135;
    endif;
    
    $pdf->SetXY($x,$y);

    $pdf->SetFont('Times', 'B', 6);
    $image_file = K_PATH_IMAGES."/cardBanner.png";
    $pdf->MultiCell(130, 0.1, "Form 138-E",'', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln(4);
    $pdf->setX($x);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->MultiCell(139.7, 7, "REPUBLIC OF THE PHILIPPINES",0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln(4);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 8);
    $pdf->MultiCell(139.7, 7, "DEPARTMENT OF EDUCATION",0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln(3);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->MultiCell(139.7, 7, "BUREAU OF PRINVATE SCHOOLS",0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln(6);
    $pdf->SetTextColor(0, 73, 9);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->MultiCell(139.7, 7, strtoupper($settings->set_school_name),0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln(6);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 6);
    $pdf->MultiCell(139.7, 7, strtoupper('United Church of Christ in the Philippines'),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->Ln(3);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'N', 5);
    $pdf->MultiCell(139.7, 7, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(6);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->MultiCell(139.7, 7, "GRADE SCHOOL REPORT CARD",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->MultiCell(139.7, 7, "School Year ".($sy-1)."-".$sy,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'I', 7);
    $pdf->MultiCell(139.7, 7, "\"Train up a child in the way he should go, and when he is old he will not depart from it.\"",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(3);
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'I', 6);
    $pdf->MultiCell(139.7, 7, "Proverbs 22:6",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(6.5);    
    
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'N', 8);
    $pdf->MultiCell(10, 7, "Name:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(63, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(24, 7, "Grade and Section:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(37, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(8, 7, "Age:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(30, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(5, '', '', 0, 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(8, 7, "Sex:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(30, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(5, '', '', 0, 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(9, 7, "LRN:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(39, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(13, 7, "Address:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(121, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    if($i == 1):
        $x -= 2;
    endif;
    $pdf->SetX($x);
    $pdf->MultiCell(($i == 1) ? 136 : 135, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    if($i == 1):
        $x += 3;
    endif;
    $pdf->SetX($x);
    $pdf->MultiCell(13, 7, "Teacher:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(76, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(5, '', '', '', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(13, 7, "Principal:",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->SetFont('Times', 'U', 8);
    $pdf->MultiCell(30, 7, "Mrs. Mila D. Cinco",'', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(1);
    if($i == 1):
        $x -= 3;
    endif;
    $pdf->SetX($x);
    $pdf->MultiCell(($i == 1) ? 136 : 135, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    if($i == 1):
        $x += 3;
    endif;
    $pdf->SetFont('Times', 'N', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(134, 7, "TO THE PARENT OR GUARDIAN",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(4);
    $pdf->SetFont('Times', 'N', 8);
    $pdf->SetX($x);
    $pdf->MultiCell(134, 7, "School ratings do not give a complete picture of your child's progress in school. It takes more than just figures to tell you how he/she is faring in his/her studies.",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(9);
    $pdf->SetX($x);
    $pdf->MultiCell(134, 7, "We therefore request you to read and consider seriously the suggestions and comments written by the teacher periodically and feel free to confer with us any time in matters affecting your child's work in school.",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(10);
    $pdf->SetFont('Times', 'N', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(134, 7, "TEACHER'S SUGGESTIONS/COMMENTS",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(23, 7, "First Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(111, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(4);
    $pdf->SetX($x);
    $pdf->MultiCell(23, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(111, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(25, 7, "Second Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(109, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(4);
    $pdf->SetX($x);
    $pdf->MultiCell(24, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(110, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(23, 7, "Third Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(111, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(4);
    $pdf->SetX($x);
    $pdf->MultiCell(23, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(111, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(25, 7, "Fourth Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(109, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(4);
    $pdf->SetX($x);
    $pdf->MultiCell(24, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(110, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(7);
    $pdf->SetFont('Times', 'N', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(134, 7, "SIGNATURE OF THE PARENT OR GUARDIAN",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(22, 7, "First Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(41, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(4, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(25, 7, "Second Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(41, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    $pdf->SetX($x);
    $pdf->MultiCell(23, 7, "Third Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(41, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(4, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(24, 7, "Fourth Grading",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(41, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(1);
    if($i == 1):
        $x -= 3;
    endif;
    $pdf->SetX($x);
    $pdf->MultiCell(($i == 1) ? 136 : 135, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    if($i == 1):
        $x += 3;
    endif;;
    $pdf->Ln(1);
    $pdf->SetX($x);
    $pdf->MultiCell(57, 7, "Eligible for Transfer and Admission to",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(27, '', '', 'B', 'R', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(4, 7, "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(9, 7, "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(14, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(6, 7, "20",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(14, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(13);
    $pdf->SetX($x+101);
    $pdf->MultiCell(30, 7, "Principal/Registrar",'T', 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(1);
    if($i == 1):
        $x -= 3;
    endif;
    $pdf->SetX($x);
    $pdf->MultiCell(($i == 1) ? 136 : 135, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(5);
    if($i == 1):
        $x += 3;
    endif;
    $pdf->Ln(1);
    $pdf->SetX($x);
    $pdf->MultiCell(134, '', "CANCELLATION OF TRANSFER AND ELIGIBILITY",0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(6);
    $pdf->SetX($x);
    $pdf->MultiCell(57, '', "Eligible for Transfer and Admission to",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(27, '', '', 'B', 'R', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(4, '', "",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(9, '', "Date",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(14, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(6, '', "20",0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(14, '', '', 'B', 'L', 0, 0, '','', true, 0, false, true, 30, 'T');
    $pdf->Ln(13);
    $pdf->SetX($x+101);
    $pdf->MultiCell(30, '', "Principal/Registrar",'T', 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
}

$pdf->Output('ReportCard.pdf', 'I');