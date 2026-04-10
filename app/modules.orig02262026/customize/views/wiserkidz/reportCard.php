<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {

        $this->SetTitle('DepED Form 138-A');
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$resolution = array(57.15, 127);
$pdf->AddPage('P', 'mm', $resolution);

$totalDays = 0;
$total_pdays = 0;
$total_adays = 0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
$division_logo = K_PATH_IMAGES . '/deped.png';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname . ' ' . substr($principal->middlename, 0, 1) . '. ' . $principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL, $sy, $student->section_id);
$adv = strtoupper($adviser->row()->firstname . ' ' . substr($adviser->row()->middlename, 0, 1) . '. ' . $adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid, 1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid, 2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid, 3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid, 4, $sy);
//
//
//get the birthday and the age before first friday of june
$firstFridayOfJune = date('mdY', strtotime('first Friday of ' . 'June' . ' ' . $settings->school_year));
$bdate = $student->temp_bdate;
$bdateItems = explode('-', $bdate);
$m = $bdateItems[1];
$d = $bdateItems[2];
$y = $bdateItems[0];
$thisYearBdate = $m . $d . $settings->school_year;
$now = $settings->school_year;
$age = abs($now - $y);

if (abs($thisYearBdate > $firstFridayOfJune)) {
    $yearsOfAge = $age - 1;
} else {
    $yearsOfAge = $age;
}

$next = $sy + 1;

$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetFont('Roboto', 'B', 30);
$pdf->SetTextColor(47, 79, 79);
$pdf->MultiCell(205, 15, 'THE WISER KIDZ', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(10);

$pdf->SetFont('Roboto', 'B', 19);
$pdf->MultiCell(205, 10, 'CHRISTIAN SCHOOL, INC.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(6);

$pdf->SetFont('Roboto', 'B', 15);
$pdf->MultiCell(205, 10, 'Lipa City, Philippines 4217', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);

$pdf->SetFont('Roboto', 'B', 17);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(45, 10, 'Form 9', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetFont('Roboto', 'B', 17);
$pdf->MultiCell(205, 10, 'PROGRESS REPORT CARD', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(6);

$pdf->SetFont('Roboto', 'B', 14);
$pdf->MultiCell(205, 10, 'Grade School Department', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

$pdf->SetFont('Roboto', 'B', 14);
$pdf->SetX(15);
$pdf->MultiCell(17, 7, 'Name', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(155, 7, strtoupper($student->firstname . ' ' . substr($student->middlename, 0, 1) . '. ' . $student->lastname), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->MultiCell(13, 7, 'LRN', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(159, 7, ($student->lrn != '' ? $student->lrn : $student->st_id), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->MultiCell(39, 7, 'Level & Section', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(133, 7, $student->level . ' - ' . $student->section, 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->MultiCell(12, 7, 'Age', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, $age, 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(19, 7, 'Gender', 0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, $student->sex, 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(35, 7, 'School Year', 0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(30, 7, $sy . '-' . $next, 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->MultiCell(20, 7, 'Adviser', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(152, 7, $adv, 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(10);

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);

//---------------- IF MAPEH ---------------------------------------------//
$firstFinal = 0;
$secondFinal = 0;
$thirdFinal = 0;
$fourthFinal = 0;
$subCount = 0;
$mp = 0;
$mapeh1 = 0;
$mapeh2 = 0;
$mapeh3 = 0;
$mapeh4 = 0;
foreach ($subject_ids as $sp):
    $singleSub = Modules::run('academic/getSpecificSubjects', $sp->sub_id);
    if ($singleSub->parent_subject == 11):
        $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 1, $sy);
        $fg1 += $fg->row()->final_rating;
        $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 2, $sy);
        $sg1 += $sg->row()->final_rating;
        $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 3, $sy);
        $tg1 += $tg->row()->final_rating;
        $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $sp->sub_id, 4, $sy);
        $frg1 += $frg->row()->final_rating;
        $mp += 1;
    endif;
endforeach;
$mapeh1 = round(($fg1 / $mp), 2);
$mapeh2 = round(($sg1 / $mp), 2);
$mapeh3 = round(($tg1 / $mp), 2);
$mapeh4 = round(($frg1 / $mp), 2);
$finalMAPEH = ($mapeh1 + $mapeh2 + $mapeh3 + $mapeh4) / 4;

//---------------------------------------------------------------------//

$pdf->SetX(15);
$pdf->setDrawColor(47, 79, 79);
$html = '<hr style="height: 8px;">';
$pdf->MultiCell('175', '1', $html, 0, 'L', 0, 1, '', '', true, 0, true, false, 1, 'T', false);

$pdf->SetXY(15, 117);
$pdf->setDrawColor(47, 79, 79);
$html = '<hr style="height: 8px; background: red; margin-left: 10px">';
$pdf->MultiCell('175', '4', $html, 0, 'L', 0, 1, '', '', true, 0, true, false, 4, 'T', false);
$pdf->Ln();

//$pdf->SetAlpha(0.3);
//$pdf->Image(base_url() . 'images/forms/wiserkidz-grayscale.png', 55, 120, 60, 70);
//$pdf->SetAlpha(1);

$pdf->SetFont('Roboto', 'B', 12);
$pdf->SetLineStyle(array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(154, 205, 50)));
$pdf->RoundedRect(16, 118, 172, (11 + (6.5 * (count($subject_ids) + 1))), 0, '0000', '');

$pdf->SetFillColor(69, 139, 0);
$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0));
$pdf->SetXY(17, 119);
$pdf->setColor(0, 0, 0);
$pdf->MultiCell(60, 10, 'Learning Areas', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '1', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '2', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '3', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '4', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(20, 10, 'FINAL', '', 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(30, 10, 'ACTION TAKEN', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('Roboto', 'B', 10);
foreach ($subject_ids as $s) :
    $pdf->SetX(17);
    $pdf->SetFillColor(154, 205, 50);
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $fg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 1, $sy);
    $sg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 2, $sy);
    $tg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 3, $sy);
    $frg = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, 4, $sy);
    if ($singleSub->subject_id == 18): //------------ MAPEH gen average ---------------------------//
        $pdf->MultiCell(60, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($mapeh1 != 0 ? $mapeh1 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($mapeh2 != 0 ? $mapeh2 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($mapeh3 != 0 ? $mapeh3 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($mapeh4 != 0 ? $mapeh4 : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, ($finalMAPEH != 0 ? $finalMAPEH : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    elseif ($singleSub->parent_subject == 11):
        $pdf->MultiCell(60, 5, '      *' . $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $finalGrade = round(($fg->row()->final_rating + $sg->row()->final_rating + $tg->row->final_rating + $frg->row()->final_rating) / 4);
        $pdf->MultiCell(20, 5, ($finalMAPEH != 0 ? ($frg->row()->final_rating != '' ? $finalMAPEH : '') : ''), 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    else:
        $subCount++;
        $pdf->MultiCell(60, 5, $singleSub->subject, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($fg->row()->final_rating != '' ? $fg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($sg->row()->final_rating != '' ? $sg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($tg->row()->final_rating != '' ? $tg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, ($frg->row()->final_rating != '' ? $frg->row()->final_rating : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $firstFinal += $fg->row()->final_rating;
        $secondFinal += $sg->row()->final_rating;
        $thirdFinal += $tg->row()->final_rating;
        $fourthFinal += $frg->row()->final_rating;
    endif;
    $pdf->Ln();
endforeach;

$pdf->SetX(17);
$pdf->SetFillColor(69, 139, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->MultiCell(60, 5, 'FINAL GEN. AVE', 1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(15, 5, round(($firstFinal) / ($subCount + 1)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, round(($secondFinal) / ($subCount + 1)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, round(($thirdFinal) / ($subCount + 1)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, round(($fourthFinal) / ($subCount + 1)), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFillColor(154, 205, 50);
$pdf->MultiCell(20, 5, '', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);

$pdf->SetFont('Roboto', 'B', 15);
$pdf->SetTextColor(130, 130, 130);
$pdf->MultiCell(205, 10, 'WISER ATTITUDE & ACHIEVEMENT EVALUATION', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetFont('Roboto', 'R', 12);
$pdf->SetX(20);
$pdf->MultiCell(32, 7, 'Attitude Rating', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(90, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(41, 7, 'Achievement Rating', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(8);

$pdf->SetX(15);
$pdf->MultiCell(73, 7, 'A - Consistently diligent and faithful', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(47, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(60, 7, '1 - Ave. grade is 92 & above', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(6);

$pdf->SetX(15);
$pdf->MultiCell(73, 7, 'B - Often diligent and faithful', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(47, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(60, 7, '2 - Ave. grade is 89-91', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(6);

$pdf->SetX(15);
$pdf->MultiCell(73, 7, 'C - Sometimes diligent and faithful', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(47, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(60, 7, '3 - Ave. grade is 86-88', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(6);

$pdf->SetX(15);
$pdf->MultiCell(73, 7, 'D - Rarely diligent and needs improvement', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(47, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(60, 7, '4 - Ave. grade is 83-85', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(6);

$pdf->SetX(15);
$pdf->MultiCell(73, 7, '', '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(47, 7, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->MultiCell(60, 7, '5 - Ave. grade is 82 & below', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B');
$pdf->Ln(7);

$pdf->SetFont('Roboto', 'B', 12);
$pdf->SetX(20);
$pdf->MultiCell(20, 10, '1st Qtr.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '2nd Qtr.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '3rd Qtr.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, '4th Qtr.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(8);

$pdf->SetX(20);
$pdf->MultiCell(20, 13, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(25, 13, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(20, 13, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(25, 13, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(20, 13, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(25, 13, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(20, 13, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');

$pdf->Image($division_logo, 160, 10, 40, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);
$pdf->Image($image_file, 15, 5, 35, '', 'PNG', '', 'T', false, 200, '', false, false, 0, false, false, false);

//$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
//back page



$pdf->AddPage();
$data['bh_group'] = Modules::run('reports/getBhGroup', 2);
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term;
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$this->load->view($short_name . '/reportCardSecondPage', $data);

//$pdf->Ln(10);
//$pdf->StartTransform();
//$pdf->Rotate(90);
//$pdf->Cell(0,0,'This is a sample data',1,1,'L',0,'');
//$pdf->StopTransform();
//Close and output PDF document
ob_end_clean();
$pdf->Output('DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+