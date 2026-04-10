<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
        $section = Modules::run('registrar/getSectionById', segment_3);
        $settings = Modules::run('main/getSet');
        $adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);

        // $subject = Modules::run('academic/getSpecificSubjects', segment_4);
        $nextYear = segment_5 + 1;
        $this->SetRightMargin(7);
        $this->SetTitle('Master Sheet ');
        $this->SetTopMargin(4);
        $this->Ln(5);
        $this->SetX(10);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'n', 8);
        $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
        if ($settings->set_logo != 'noImage.png'):
            $this->Image($image_file, 650, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        else:
            $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(12);

        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 4.3, 'MASTER SHEET FINAL GRADE AND GENERAL AVERAGE', 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 4.3, "SY  " . segment_5 . ' - ' . $nextYear, 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(0, 4.3, $section->level . ' - ' . $section->section, 0, 0, 'L');
        $this->Cell(0, 4.3, 'Adviser: ' . $adviser->row()->firstname . ' ' . $adviser->row()->lastname, 0, 0, 'R');
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

function getDesc($val) {
    if ($val >= 90 && $val <= 100):
        return 'O';
    elseif ($val >= 85 && $val <= 89.9):
        return 'VS';
    elseif ($val >= 80 && $val <= 84.9):
        return 'S';
    elseif ($val >= 75 && $val <= 79.9):
        return 'FS';
    elseif ($val <= 74.9):
        return 'Failed';
    endif;
}

function twoDec($num) {
    switch (strlen(substr(strrchr($num, "."), 1))):
        case 0:
            return $num . '.00';
        case 1:
            return $num . '0';
        default :
            return $num;
    endswitch;
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(610, 216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_3);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
$tm = 0;
foreach ($subject_ids as $s):
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->parent_subject == 11):
        $tm++;
    endif;
endforeach;
//$subject = explode(',', $subject_ids->subject_id);
$finalAssessment = 0;
$mapeh = 0;

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 10, '', "TL", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 10, '', "TR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

    switch ($singleSub->parent_subject) {
        case 0:
        case 18:
            $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case 11:
            if ($singleSub->subject_id == 13):
                $pdf->MultiCell(53, 10, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
            break;
        default:
            $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
    }
}

$pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 20, 'NAME OF LEARNERS', "R", 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    switch ($singleSub->parent_subject) {
        case 0:
        case 18:
            $pdf->MultiCell(40, 3, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case 11:
            if ($singleSub->subject_id == 13):
                $pdf->MultiCell(40, 3, "QUARTER", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
            break;
    }
}
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, '', "R", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

    if ($singleSub->parent_subject != 11):
        $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    endif;
}

$pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);
$m = 0;
foreach ($male->result() as $s) {
    $m++;
}
$f = 0;
foreach ($female->result() as $s) {
    $f++;
}
$tot = $m + $f;
$x = 0;
switch (segment_4) {
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
$z = 0;
$nm = 0;

foreach ($male->result() as $s) {
    $z++;
    $x++;
    $pdf->MultiCell(8, 3, $z, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . substr($s->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    foreach ($subject_ids as $sub) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);

        if ($singleSub->parent_subject != 11):
            $finalFirst = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 1, segment_5);
            $finalSecond = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 2, segment_5);
            $finalThird = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 3, segment_5);
            $finalFourth = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 4, segment_5);

            $pdf->MultiCell(10, 3, ($finalFirst->row()->final_rating == "" ? "" : $finalFirst->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalSecond->row()->final_rating == "" ? "" : $finalSecond->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalThird->row()->final_rating == "" ? "" : $finalThird->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalFourth->row()->final_rating == "" ? "" : $finalFourth->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $finalGrade = round(($finalFirst->row()->final_rating + $finalSecond->row()->final_rating + $finalThird->row()->final_rating + $finalFourth->row()->final_rating) / 4, 2);

            $finalAssessment1 += $finalFirst->row()->final_rating;
            $finalAssessment2 += $finalSecond->row()->final_rating;
            $finalAssessment3 += $finalThird->row()->final_rating;
            $finalAssessment4 += $finalFourth->row()->final_rating;
            $ave += $finalGrade;

            $pdf->MultiCell(13, 3, twoDec($finalGrade), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $nm++;
        endif;
    }

    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        if ($singleSub->parent_subject == 11):
            $fg1 = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 1, segment_5);
            $fg2 = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 2, segment_5);
            $fg3 = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 3, segment_5);
            $fg4 = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, 4, segment_5);
            $tf1 += $fg1->row()->final_rating;
            $tf2 += $fg2->row()->final_rating;
            $tf3 += $fg3->row()->final_rating;
            $tf4 += $fg4->row()->final_rating;

            $m1 = round(($tf1) / 3);
            $m2 = round(($tf2) / 3);
            $m3 = round(($tf3) / 3);
            $m4 = round(($tf4) / 3);
        endif;
    endforeach;

    $pdf->MultiCell(10, 3, ($m1 != "" ? $m1 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m2 != "" ? $m2 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m3 != "" ? $m3 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m4 != "" ? $m4 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $aveMapeh = round(($m1 + $m2 + $m3 + $m4) / 4, 2);
    $pdf->MultiCell(13, 3, twoDec($aveMapeh), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    $plg = round(($ave + $aveMapeh) / ($nm + 1), 2);
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, twoDec($plg), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, getDesc($plg), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->ln();

    if ($x == 9):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 10, '', "TL", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 10, '', "TR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(53, 10, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
                default:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }
        }

        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 20, 'NAME OF LEARNERS', "R", 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(40, 3, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(40, 3, "QUARTER", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                        $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', "R", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            if ($singleSub->parent_subject != 11):
                $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }

        $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;

    unset($mapeh);
    unset($finalAssessment);
    $mapeh = 0;
    $finalAssessment = 0;
    $tf1 = 0;
    $tf2 = 0;
    $tf3 = 0;
    $tf4 = 0;
    $nm = 0;
    $total_mapeh = 0;
    $ave = 0;
}

for ($bl = 1; $bl <= 1; $bl++) {
    $x++;
    if ($x == 9):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 10, '', "TL", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 10, '', "TR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(53, 10, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
                default:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }
        }

        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 20, 'NAME OF LEARNERS', "R", 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(40, 3, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(40, 3, "QUARTER", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                        $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', "R", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            if ($singleSub->parent_subject != 11):
                $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }

        $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;
    $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($subject_ids as $s) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
        if ($singleSub->parent_subject != 11):
            $pdf->MultiCell(53, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }
    $pdf->MultiCell(53, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
}

$y = 1;
$yn = 0;
$n = 0;
$tf1 = 0;
$tf2 = 0;
$tf3 = 0;
$tf4 = 0;

foreach ($female->result() as $fem) {
    $x++;
    if ($x == 17 || $x == 19): // if 18
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 10, '', "TL", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 10, '', "TR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(53, 10, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
                default:
                    $pdf->MultiCell(53, 10, $singleSub->subject, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }
        }

        $pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 10, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        
        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 20, 'NAME OF LEARNERS', "R", 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(40, 3, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell(40, 3, "QUARTER", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                        $pdf->MultiCell(13, 3, 'FINAL', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', "L", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', "R", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            if ($singleSub->parent_subject != 11):
                $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }

        $pdf->MultiCell(10, 3, '1', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '2', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '3', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 3, '4', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(13, 3, 'GRADE', "LR", 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', "LR", 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif; // end of if 18
    $yn++;
    $pdf->MultiCell(8, 3, $yn, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($fem->lastname . ', ' . $fem->firstname . ' ' . substr($fem->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    foreach ($subject_ids as $sub) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);

        if ($singleSub->parent_subject != 11):
            $finalFirst = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 1, segment_5);
            $finalSecond = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 2, segment_5);
            $finalThird = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 3, segment_5);
            $finalFourth = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 4, segment_5);

            $pdf->MultiCell(10, 3, ($finalFirst->row()->final_rating == "" ? "" : $finalFirst->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalSecond->row()->final_rating == "" ? "" : $finalSecond->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalThird->row()->final_rating == "" ? "" : $finalThird->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $pdf->MultiCell(10, 3, ($finalFourth->row()->final_rating == "" ? "" : $finalFourth->row()->final_rating), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $finalGrade = round(($finalFirst->row()->final_rating + $finalSecond->row()->final_rating + $finalThird->row()->final_rating + $finalFourth->row()->final_rating) / 4, 2);

            $finalAssessment1 += $finalFirst->row()->final_rating;
            $finalAssessment2 += $finalSecond->row()->final_rating;
            $finalAssessment3 += $finalThird->row()->final_rating;
            $finalAssessment4 += $finalFourth->row()->final_rating;
            $ave += $finalGrade;

            $pdf->MultiCell(13, 3, twoDec($finalGrade), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            $nm++;
        endif;
    }

    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        if ($singleSub->parent_subject == 11):
            $fg1 = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 1, segment_5);
            $fg2 = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 2, segment_5);
            $fg3 = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 3, segment_5);
            $fg4 = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, 4, segment_5);
            $tf1 += $fg1->row()->final_rating;
            $tf2 += $fg2->row()->final_rating;
            $tf3 += $fg3->row()->final_rating;
            $tf4 += $fg4->row()->final_rating;

            $m1 = round(($tf1) / 3);
            $m2 = round(($tf2) / 3);
            $m3 = round(($tf3) / 3);
            $m4 = round(($tf4) / 3);
        endif;
    endforeach;

    $pdf->MultiCell(10, 3, ($m1 != "" ? $m1 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m2 != "" ? $m2 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m3 != "" ? $m3 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(10, 3, ($m4 != "" ? $m4 : ""), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $aveMapeh = round(($m1 + $m2 + $m3 + $m4) / 4, 2);
    $pdf->MultiCell(13, 3, twoDec($aveMapeh), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    $plg = round(($ave + $aveMapeh) / ($nm + 1), 2);
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, twoDec($plg), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, getDesc($plg), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//    if ($plg >= 75):
//    else:
//        $pdf->MultiCell(20, 3, 'FAILED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//    endif;
    $pdf->ln();
    $f = $tot - $y;
    //$pdf->MultiCell(50, 3,$f,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $y++;
    $n++;
    unset($finalAssessment);
    $finalAssessment = 0;
    $tf1 = 0;
    $tf2 = 0;
    $tf3 = 0;
    $tf4 = 0;
    $nm = 0;
    $ave = 0;
    $total_mapeh = 0;
    $aveMapeh = 0;
}

$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);

switch ($x) {
    case 29:
        $pdf->ln(10);
        break;
    case 2:
    case 12:
        $pdf->ln(20);
        break;
    case 8:
        $pdf->ln(70);
        break;
}

if ($x >= 8):
    $pdf->AddPage();
    $pdf->SetY(45);
    $x = 0;
endif;
$pdf->Ln(20);
$pdf->SetX(40);
$pdf->MultiCell(25, 10, 'Prepared By: ', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, strtoupper($adviser->row()->firstname . ' ' . $adviser->row()->lastname) . ', LPT', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(10);

$pdf->SetX(40);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'Adviser', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetX(40);
$pdf->MultiCell(25, 10, 'Verified By: ', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'ABIGAIL GRACE O. LAPUT, LPT', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(55, 10, 'Validated By: ', '', 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'LUCY P. BAGONGON, M.A', 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(10);

$pdf->SetX(40);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'Asst. to the Principal', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(55, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'School Principal', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data
//Close and output PDF document
ob_end_clean();
$pdf->Output('master_sheet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
