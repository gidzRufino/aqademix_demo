<?php
class MYPDF extends Pdf
{
    //Page header
    public function Header()
    {

        $this->SetTitle('DepED Form 138-A');
    }
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$res = 25.4;
$pdf->setPageUnit('mm');
$resolution = array(8.5 * $res, 11 * $res);
$pdf->AddPage('L', $resolution);

$totalDays = 0;;
$total_pdays = 0;
$total_adays = 0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES . '/DepEd-MATATAG.png';
$school_logo = K_PATH_IMAGES . '/dpma.png';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname . ' ' . substr($principal->middlename, 0, 1) . '. ' . $principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,  $sy, $student->section_id);
$adv = strtoupper($adviser->row()->firstname . ' ' . substr($adviser->row()->middlename, 0, 1) . '. ' . $adviser->row()->lastname);
$subjects = Modules::run('customize/getPreSchoolSubj');
$st_name = ucwords(strtolower($student->firstname . ' ' . ($student->middlename != '' ? substr($student->middlename, 0, 1) . '.' : '') . ' ' . $student->lastname));

$pdf->Line(140, 200, 140, 15, array('color' => 'black'));
$gs_start = date('m', strtotime($settings->bosy));
$gs_end = date('m', strtotime($settings->eosy));
$gsDays = Modules::run('reports/getRawSchoolDays', $sy, 2);
$sprDetails = Modules::run('sf10/getSPRrec', $student->st_id, $sy, NULL, $student->grade_id);
$pdays = Modules::run('sf10/getAttendanceOveride', $sprDetails->spr_id, $sprDetails->school_year, $student->st_id);

function getImgLink($char, $pdf, $l, $t, $s)
{
    switch ($char):
        case 'A':
            return $pdf->Image(SYMBOL_IMAGES . 'gs1.png', $l, $t, $s, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        case 'B':
            return $pdf->Image(SYMBOL_IMAGES . 'gs2.png', $l, $t, $s, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        case 'C':
            return $pdf->Image(SYMBOL_IMAGES . 'gs3.png', $l, $t, $s, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        case 'D':
            return $pdf->Image(SYMBOL_IMAGES . 'gs4.png', $l, $t, $s, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
        default:
            return '';
    endswitch;
}

//======================================================= Cover Page ===========================================================================//

$school = SYMBOL_IMAGES . '/cardImages/dpma.png';
$pdf->Image($school, 150, 15, 118, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($school_logo, 178, 53, 65, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('impact', 'B', 40);
$pdf->SetTextColor(120, 12, 40);
$pdf->SetXY(140, 112);
$pdf->MultiCell(140, 30, strtoupper($student->level), 0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
$pdf->Ln(12);

$pdf->SetTextColor(19, 38, 147);
$pdf->SetX(140);
$pdf->SetFont('ignotum', 'B', 30);
$pdf->MultiCell(140, 30, 'PROGRESS REPORT CARD', 0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');
$pdf->Ln(22);

$pdf->SetFont('times', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
// $pdf->MultiCell(120, 30, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 30, 'M');

$pdf->SetX(158);
$pdf->MultiCell(33, 7, 'Student\'s Name:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, $st_name, 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(158);
$pdf->MultiCell(33, 7, 'Date of Birth:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, ($student->temp_bdate != '' ? date('F j, Y', strtotime($student->temp_bdate)) : ''), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(158);
$pdf->MultiCell(33, 7, 'LRN:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, ($student->lrn != '' ? $student->lrn : ''), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(158);
$pdf->MultiCell(33, 7, 'School Year:', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, $sy . ' - ' . ($sy + 1), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(20);

$pdf->SetLineStyle(array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(19, 38, 147)));
$pdf->RoundedRect(157, 145, 105, 32, 0, '0000', '');

$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$pdf->SetX(170);
$pdf->MultiCell(80, 7, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(170);
$pdf->MultiCell(80, 7, 'Teacher', 0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

//================================================================================================================================================================//

$pdf->AddPage();
$pdf->Line(140, 200, 140, 15, array('color' => 'black'));
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetXY(0, 15);
$pdf->MultiCell(140, 10, 'THE RIGHT OF EVERY CHILD', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetFont('times', 'R', 13);
$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To be born, to have a name and nationality.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To have a family who will love and care for me.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To live in a peaceful community and a wholesome environment.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To have adequate food and a healthy and active body.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To obtain a good EDUCATION and develop my potential.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To be given opportunities for play and leisure.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To be protected against abuse, exploration, neglect, violence and danger.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To be defended and be given assistance by the government.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(10, 12, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(100, 12, 'To be able to express my own ideas.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(20);

$pdf->SetFont('times', 'I', 13);
$pdf->SetX(15);
$pdf->MultiCell(110, 40, '“Never do for a child what he’s capable of doing for himself. If we parents take time to teach self-mastery, self – radiance and functional independence, we will be doing our children a life – long service."', 0, 'C', 0, 0, '', '', true, 0, false, true, 40, 'M');
$pdf->Ln();

$pdf->SetFont('Times', 'B', 16);
$pdf->SetX(75);
$pdf->MultiCell(60, 10, 'Maria Montessori', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

//=================================================================== Right =============================================================//


$pdf->SetFont('helvetica', 'B', 15);
$pdf->SetXY(140, 10);
$pdf->MultiCell(140, 10, 'GRAPHING SYSTEM', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

$pdf->Image(SYMBOL_IMAGES . 'gs1.png', 160, 25, 15, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image(SYMBOL_IMAGES . 'gs2.png', 160, 43, 15, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image(SYMBOL_IMAGES . 'gs3.png', 160, 61, 15, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image(SYMBOL_IMAGES . 'gs4.png', 160, 79, 15, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('helvetica', 'R', 13);
$pdf->SetX(185);
$pdf->MultiCell(80, 12, 'Presented', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(20);

$pdf->SetX(185);
$pdf->MultiCell(80, 12, 'Presented and the child has practiced the skill.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(18);

$pdf->SetX(185);
$pdf->MultiCell(80, 12, 'Presented and the child has practiced and mastered the skill.', 0, 'L', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(16);

$pdf->SetX(185);
$pdf->MultiCell(80, 19, 'Presented and the child has practiced and mastered the skill and at the same time knows the language involved.', 0, 'L', 0, 0, '', '', true, 0, false, true, 19, 'M');
$pdf->Ln(25);

$pdf->SetFont('helvetica', 'B', 13);
$pdf->SetX(145);
$pdf->SetFillColor(189, 189, 189);
$pdf->MultiCell(120, 7, 'PARENT\'S SIGNATURE', 0, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(12);

$pdf->SetFont('times', 'B', 10);
$pdf->SetX(145);
$pdf->MultiCell(55, 7, 'FIRST GRADING PERIOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(12);

$pdf->SetX(145);
$pdf->MultiCell(55, 7, 'SECOND GRADING PERIOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(12);

$pdf->SetX(145);
$pdf->MultiCell(55, 7, 'THIRD GRADING PERIOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(12);

$pdf->SetX(145);
$pdf->MultiCell(55, 7, 'FOURTH GRADING PERIOD', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(65, 7, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(18);

$pdf->SetFont('times', 'B', 13);
$pdf->SetX(140);
$pdf->MultiCell(140, 10, 'ENGR. JOSELITO S. CABELLO', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'R', 10);
$pdf->SetX(140);
$pdf->MultiCell(140, 10, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(18);

$pdf->SetFont('times', 'B', 13);
$pdf->SetX(140);
$pdf->MultiCell(140, 10, 'MRS. CHRISMORE P. CABELLO', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'R', 10);
$pdf->SetX(140);
$pdf->MultiCell(140, 10, 'Administrator', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(18);

$pdf->AddPage();
$pdf->Line(140, 200, 140, 15, array('color' => 'black'));
//================================================== Page 4 Left =================================================================//
//--------------------------------------- Music -----------------------------------------------------------------------------//
$m1 = SYMBOL_IMAGES . '/cardImages/m1.png';
$m2 = SYMBOL_IMAGES . '/cardImages/m2.png';
$pdf->Image($m1, 10, 5, 25, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($m2, 36, 8, 25, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);


$pdf->SetFont('Times', 'I', 10);
$pdf->SetX(65);
$pdf->MultiCell(60, 10, 'This learning area encourages the child\'s potential and interests in music.', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(16);

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(60, 10, 'Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(60, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(60, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 1);
$left = 75;
$top = 37;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 5);
        getImgLink($rate2->rate, $pdf, ($left + 15), $top, 5);
        getImgLink($rate3->rate, $pdf, ($left + 30), $top, 5);
        getImgLink($rate4->rate, $pdf, ($left + 45), $top, 5);
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(60, 7, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->Ln();
        $top += 7;
    endif;
endforeach;
$pdf->Ln(10);

//-------------------------------------------- Art ---------------------------------------------------------------- //

$a1 = SYMBOL_IMAGES . '/cardImages/art1.png';
$a2 = SYMBOL_IMAGES . '/cardImages/art2.png';
$pdf->Image($a1, 10, 65, 25, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($a2, 36, 68, 25, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetX(65);
$pdf->MultiCell(65, 25, 'This learning area promotes the child’s appreciation and interests upon visually created objects and art pieces. It aids the discovery of each child’s potentials in creating art figures as well.', 0, 'L', 0, 0, '', '', true, 0, false, true, 25, 'M');
$pdf->Ln(28);

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(60, 10, 'Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(60, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(60, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 2);
$left = 75;
$top = 106;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 5);
        getImgLink($rate2->rate, $pdf, ($left + 15), $top, 5);
        getImgLink($rate3->rate, $pdf, ($left + 30), $top, 5);
        getImgLink($rate4->rate, $pdf, ($left + 45), $top, 5);
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(60, 7, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(15, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->Ln();
        $top += 7;
    endif;
endforeach;
$pdf->Ln(10);


//========================================================= End Page 4 =========================================================//
//========================================================= Page 1 =============================================================//

$pdf->SetFont('helvetica', 'R', 12);
$pdf->SetXY(150, 10);
$pdf->MultiCell(30, 10, 'Dear Parents', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(15);

$msg = Modules::run('customize/casaMsg', 2);
$pdf->SetFont('Times', 'I', 16);
$pdf->writeHTMLCell(115, '', '', $pdf->SetX(150), $msg, '', 1, 0, true, 'L', true);
$pdf->Ln(50);

$dmm = SYMBOL_IMAGES . '/cardImages/dmm.png';
$pdf->Image($dmm, 145, 150, 125, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetX(216);
$pdf->SetFont('helvetica', 'R', 11);
$pdf->MultiCell(50, 7, 'DR. MARIA MONTESSORI', 0, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->AddPage();
$pdf->Line(140, 200, 140, 15, array('color' => 'black'));

//==================================================================== Practical Life Skills ============================================================================//

$pls = SYMBOL_IMAGES . '/cardImages/plsCS.png';
$pdf->Image($pls, 10, 13, 60, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetXY(72, 10);
$pdf->MultiCell(65, 15, 'These exercises encourage independence and care of self which leads to good self-esteem, concentration and discipline.', 0, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(17);

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(72, 10, 'Life Skills', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(48, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(72, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 3);
$left = 85;
$top = 38;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        if ($sd->psd_id <= 58):
            $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
            $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
            $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
            $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
            getImgLink($rate1->rate, $pdf, $left, $top, 4);
            getImgLink($rate2->rate, $pdf, ($left + 15), $top, 4);
            getImgLink($rate3->rate, $pdf, ($left + 30), $top, 4);
            getImgLink($rate4->rate, $pdf, ($left + 45), $top, 4);
            $pdf->SetX(10);
            $pdf->SetFont('helvetica', 'R', 9);
            $pdf->MultiCell(72, 6, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
            $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
            $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
            $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
            $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
            $pdf->Ln();
            $top += 6;
        endif;
    endif;
endforeach;
$pdf->Ln(5);

//====================================================================== Geography ================================================================================//

$geo = SYMBOL_IMAGES . '/cardImages/geo.png';
$geo1 = SYMBOL_IMAGES . '/cardImages/geo1.png';
$geo2 = SYMBOL_IMAGES . '/cardImages/geo2.png';
$pdf->Image($geo, 168, 10, 60, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($geo1, 148, 10, 20, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($geo, 170, 27, 18, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($geo2, 170, 30, 18, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetXY(148, 26);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(72, 10, '', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(48, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(148);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(72, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 8);
$left = 224;
$top = 37;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 4);
        getImgLink($rate2->rate, $pdf, ($left + 12), $top, 4);
        getImgLink($rate3->rate, $pdf, ($left + 24), $top, 4);
        getImgLink($rate4->rate, $pdf, ($left + 36), $top, 4);
        $pdf->SetX(148);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(72, 6, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 6, 'M');
        $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
        $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
        $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
        $pdf->MultiCell(12, 6, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 6, 'M');
        $pdf->Ln();
        $top += 6;
    endif;
endforeach;
$pdf->Ln(20);


$pdf->AddPage();
$pdf->Line(140, 200, 140, 15, array('color' => 'black'));

//======================================================================= Science ====================================================================================//

$sci1 = SYMBOL_IMAGES . '/cardImages/sci1.png';
$sci = SYMBOL_IMAGES . '/cardImages/sci.png';
$pdf->Image($sci1, 10, 10, 30, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($sci, 40, 10, 35, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetXY(42, 21);
$pdf->MultiCell(85, 15, '                 These exercises facilitates recognition of scientific facts and realities and promotes critical thinking and observation among existing things.', 0, 'L', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(15);

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(60, 10, 'Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(60, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(60, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 6);
$left = 75;
$top = 47;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
        getImgLink($rate2->rate, $pdf, ($left + 15), $top, 3.5);
        getImgLink($rate3->rate, $pdf, ($left + 30), $top, 3.5);
        getImgLink($rate4->rate, $pdf, ($left + 45), $top, 3.5);
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(60, 5, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $top += 5;
    endif;
endforeach;

//============================================================ Life skills (cont.) =====================================================================//

$pdf->SetXY(150, 10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(72, 10, 'Life Skills', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(48, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(150);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(72, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 3);
$left = 226;
$top = 21;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        if ($sd->psd_id >= 59):
            $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
            $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
            $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
            $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
            getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
            getImgLink($rate2->rate, $pdf, ($left + 12), $top, 3.5);
            getImgLink($rate3->rate, $pdf, ($left + 24), $top, 3.5);
            getImgLink($rate4->rate, $pdf, ($left + 36), $top, 3.5);
            $pdf->SetX(150);
            $pdf->SetFont('helvetica', 'R', 9);
            $pdf->MultiCell(72, 5, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $top += 5;
        endif;
    endif;
endforeach;
$pdf->Ln(5);

$y = 0;
for ($x = 1; $x <= 6; $x++):
    $pdf->Image(SYMBOL_IMAGES . '/cardImages/pls' . $x . '.png', (148 + $y), 122, 18, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
    $y += 20;
endfor;

//=================================================== Sensorial Material Exercise ===============================================================//

$sme = SYMBOL_IMAGES . '/cardImages/sme.png';
$pdf->Image($sme, 150, 142, 120, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetXY(150, 152);
$pdf->MultiCell(110, 10, 'These exercises are an introduction to mathematics and language. They help improve fine motor skills and prepares the child for writing sequence.', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetX(150);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(60, 10, 'Sensory Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(60, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(150);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(60, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 7);
$left = 216;
$top = 173;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        if ($sd->psd_id <= 190):
            $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
            $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
            $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
            $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
            getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
            getImgLink($rate2->rate, $pdf, ($left + 15), $top, 3.5);
            getImgLink($rate3->rate, $pdf, ($left + 30), $top, 3.5);
            getImgLink($rate4->rate, $pdf, ($left + 45), $top, 3.5);
            $pdf->SetX(150);
            $pdf->SetFont('helvetica', 'R', 10);
            $pdf->MultiCell(60, 5, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $top += 5;
        endif;
    endif;
endforeach;
$pdf->Ln(10);

//==================================================== sme ==============================================================================//
//=================================================== sme(cont.) ========================================================================//

$pdf->AddPage();
$pdf->Line(140, 200, 140, 15, array('color' => 'black'));

$subj_details = Modules::run('customize/getSubjDetails', 7);
$left = 86;
$top = 11;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        if ($sd->psd_id >= 191):
            $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
            $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
            $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
            $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
            getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
            getImgLink($rate2->rate, $pdf, ($left + 12), $top, 3.5);
            getImgLink($rate3->rate, $pdf, ($left + 24), $top, 3.5);
            getImgLink($rate4->rate, $pdf, ($left + 36), $top, 3.5);
            $pdf->SetX(10);
            $pdf->SetFont('helvetica', 'R', 10);
            $pdf->MultiCell(72, 5, $sd->details, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
            $top += 5;
        endif;
    endif;
endforeach;
$pdf->Ln(10);

//===================================================================== Language ======================================================================================//

$l1 = SYMBOL_IMAGES . '/cardImages/l1.png';
$lang = SYMBOL_IMAGES . '/cardImages/l.png';
$pdf->Image($l1, 10, 61, 30, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($lang, 40, 61, 50, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetXY(40, 73);
$pdf->MultiCell(90, 10, 'These exercises facilitates recognition of letters and sounds and promotes knowledge on oral and written language.', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(10);

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(72, 10, 'Language Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(48, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(72, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 4);
$left = 86;
$top = 94;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
        getImgLink($rate2->rate, $pdf, ($left + 12), $top, 3.5);
        getImgLink($rate3->rate, $pdf, ($left + 24), $top, 3.5);
        getImgLink($rate4->rate, $pdf, ($left + 36), $top, 3.5);
        $pdf->SetX(10);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(72, 5, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $top += 5;
    endif;
endforeach;

//======================================================================= End Language ====================================================================================//
//======================================================================= Mathematics ====================================================================================//

$math1 = SYMBOL_IMAGES . '/cardImages/math1.png';
$math = SYMBOL_IMAGES . '/cardImages/math.png';
$pdf->Image($math1, 148, 7, 30, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($math, 178, 7, 75, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

$pdf->SetFont('Times', 'I', 10);
$pdf->SetXY(178, 20);
$pdf->MultiCell(80, 10, 'These exercises facilitates recognition of quantities, symbols and simple Mathematical Operations.', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(13);

$pdf->SetX(148);
$pdf->SetFont('pencilant', 'B', 12);
$pdf->MultiCell(72, 10, 'Mathematical Activities', 'RTL', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('Roboto', 'I', 10);
$pdf->MultiCell(48, 5, 'GRADING PERIOD', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(148);
$pdf->SetFont('pencilant', 'B', 10);
$pdf->MultiCell(72, 5, '', 'RBL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '1st', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '2nd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '3rd', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '4th', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$subj_details = Modules::run('customize/getSubjDetails', 5);
$left = 224;
$top = 44;
foreach ($subj_details as $sd):
    if ($sd->dpt_id != 1):
        $rate1 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 1, $sy);
        $rate2 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 2, $sy);
        $rate3 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 3, $sy);
        $rate4 = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, 4, $sy);
        getImgLink($rate1->rate, $pdf, $left, $top, 3.5);
        getImgLink($rate2->rate, $pdf, ($left + 12), $top, 3.5);
        getImgLink($rate3->rate, $pdf, ($left + 24), $top, 3.5);
        getImgLink($rate4->rate, $pdf, ($left + 36), $top, 3.5);
        $pdf->SetX(148);
        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(72, 5, $sd->details, 'RBL', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $top += 5;
    endif;
endforeach;
$pdf->Ln(20);




//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname . ', ' . substr($student->firstname, 0, 1) . '_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+