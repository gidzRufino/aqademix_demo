<?php

class MYPDF extends Pdf
{
    public function Header()
    {
    }
}

$CI = & get_instance();
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(true, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(330,216);
$pdf->AddPage('P', $resolution);

$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', $CI->uri->segment(4));
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
$students = Modules::run('registrar/getStudentForCard', $CI->uri->segment(7), $CI->uri->segment(6), $CI->uri->segment(4));
$sy = $this->session->userdata('school_year');

switch ($CI->uri->segment(5)) {
    case 1:
        $term = 'first';
        break;
    case 2:
        $term = 'second';
        break;
    case 3:
        $term = 'third';
        break;
    case 4:
        $term = 'fourth';
        break;
}
$x = 3;
$y = 5;
$a = 0;

//print_r($students->result());
foreach ($students->result() as $mStudent):
    $a++;

    if ($a == 3):
        $y = 165;
        $x = 3;
    endif;


    $pdf->SetXY($x, $y);
    $pdf->SetFont('Times', 'B', 15);

    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if ($settings->set_logo != 'noImage.png'):
        $pdf->Image($image_file, $x, $y, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    else:
        $image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
        $pdf->Image($image_file, $x, $y, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    endif;
    $pdf->MultiCell(105, 10, $settings->set_school_name, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(105, 5, $settings->set_school_address, 0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(105, 5, 'CLASS CARD', 0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 8);
    $pdf->SetX($x);
    $pdf->MultiCell(28, 5, 'Grading Period :', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, ucfirst($term), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 5, 'Grade Level :', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(30, 5, $mStudent->level.' - '.$section->section, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x);
    $mn = ($mStudent->middlename == "" ? "" : substr($mStudent->middlename, 0, 1).'.');
    $pdf->MultiCell(15, 5, 'Name :', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(85, 5, strtoupper($mStudent->firstname.' '.$mn.' '.$mStudent->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x + 2);
    $pdf->MultiCell(33, 5, 'SUBJECTS', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(33, 5, 'GRADE', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(33, 5, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $CI->uri->segment(5), $sy);
        $finalG = $finalGrade && $finalGrade->row() ? $finalGrade->row()->final_rating : null;
        $pdf->Ln();
        $pdf->SetX($x + 2);


        $pdf->MultiCell(33, 5, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        if ($finalG != null):
            $pdf->MultiCell(33, 5, $finalGrade->row()->final_rating, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        else:
            $pdf->MultiCell(33, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        endif;
        if ($finalG >= 75):
            $pdf->MultiCell(33, 5, 'PASSED', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        else:
            $pdf->MultiCell(33, 5, 'FAILED', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        ;

    endforeach;

    $x = $x + 107;
endforeach;





$pdf->Output('class_card.pdf', 'I');
