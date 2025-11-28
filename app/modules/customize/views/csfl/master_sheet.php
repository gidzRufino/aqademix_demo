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
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        else:
            $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(12);
        switch (segment_4) {
            case 1:
                $term = 'FIRST GRADING';
                break;
            case 2:
                $term = 'SECOND GRADING';
                break;
            case 3:
                $term = 'THIRD GRADING';
                break;
            case 4:
                $term = 'FOURTH GRADING';
                break;
        }
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 4.3, 'MASTER SHEET in ' . $term, 0, 0, 'C');
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(350, 216);
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
$pdf->MultiCell(8, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

    switch ($singleSub->parent_subject) {
        case 0:
        case 18:
            $pdf->MultiCell(18, 10, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case 11:
            if ($singleSub->subject_id == 13):
                $pdf->MultiCell((18 * $tm) + 15, 10, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
            break;
        default:
            $pdf->MultiCell(18, 10, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
    }
}

$pdf->MultiCell(5, 10, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 10, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    switch ($singleSub->parent_subject) {
        case 0:
        case 18:
            $pdf->MultiCell(18, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case 11:
            $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
    }
    if ($s->sub_id == 206517):
        $pdf->MultiCell(15, 3, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
}
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
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
    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        if ($singleSub->parent_subject == 11):
            $fg = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, segment_4, segment_5);
            $tf += $fg->row()->final_rating;
        else:
            $nm++;
        endif;
    endforeach;
    $total_mapeh = round($tf / $tm);

    foreach ($subject_ids as $sub) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, segment_4, segment_5);
        if (!empty($finalGrade)):
            switch ($gs_settings->gs_used):
                case 1:
                    $ass_gr = $finalGrade->row()->final_rating;
                    break;
                case 2:
                    $ass_gr = ($finalGrade->row()->final_rating == "" ? "" : $finalGrade->row()->final_rating);
                    break;
            endswitch;

            if ($singleSub->parent_subject != 11):
                $finalAssessment += $finalGrade->row()->final_rating;
            endif;

            $pdf->MultiCell(18, 3, $ass_gr, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

            if ($sub->sub_id == 206517):
                $pdf->MultiCell(15, 3, $total_mapeh, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        else:
            $finalAssessment += 0;
            $pdf->MultiCell(18, 3, '0', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }



    $plg = round(($finalAssessment + $total_mapeh) / ($nm + 1), 2);
    switch (strlen(substr(strrchr($plg, "."), 1))):
        case 0:
            $val = $plg . '.00';
            break;
        case 1:
            $val = $plg . '0';
            break;
        default :
            $val = $plg;
            break;
    endswitch;
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, $val, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, getDesc($val), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//    if ($plg >= 75):
//    else:
//        $pdf->MultiCell(20, 3, 'FAILED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//    endif;
    $pdf->ln();

    if ($x == 17):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell((18 * $tm) + 15, 3, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 11:
                    $pdf->MultiCell(18, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 18:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }

            if ($s->sub_id == 206517):
                $pdf->MultiCell(15, 3, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        }

        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;

    unset($mapeh);
    unset($finalAssessment);
    $mapeh = 0;
    $finalAssessment = 0;
    $tf = 0;
    $nm = 0;
}

for ($bl = 1; $bl <= 1; $bl++) {
    $x++;
    if ($x == 17):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell((18 * $tm) + 15, 3, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }

        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'AVERAGE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'DESC.', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(18, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;
    $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($subject_ids as $s) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
        $pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        if ($s->sub_id == 206517):
            $pdf->MultiCell(15, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
}

$y = 1;
$yn = 0;
$n = 0;
foreach ($female->result() as $fem) {
    $x++;
    if ($x == 17 || $x == 19): // if 18
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    if ($singleSub->subject_id == 13):
                        $pdf->MultiCell((18 * $tm) + 15, 3, 'MAPEH', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                    break;
            }
        }

        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            switch ($singleSub->parent_subject) {
                case 0:
                case 18:
                    $pdf->MultiCell(18, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
                case 11:
                    $pdf->MultiCell(18, 3, $singleSub->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    break;
            }
            if ($s->sub_id == 206517):
                $pdf->MultiCell(15, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif; // end of if 18
    $yn++;
    $pdf->MultiCell(8, 3, $yn, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($fem->lastname . ', ' . $fem->firstname . ' ' . substr($fem->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    foreach ($subject_ids as $sub):
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        if ($singleSub->parent_subject == 11):
            $fg = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, segment_4, segment_5);
            $tf += $fg->row()->final_rating;
        else:
            $nm++;
        endif;
    endforeach;
    $total_mapeh = round($tf / $tm);

    foreach ($subject_ids as $sub) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, segment_4, segment_5);
        if (!empty($finalGrade)):

            switch ($gs_settings->gs_used):
                case 1:
                    $ass_gr = $finalGrade->row()->final_rating;
                    break;
                case 2:
                    $ass_gr = ($finalGrade->row()->final_rating == "" ? "" : $finalGrade->row()->final_rating);
                    break;
            endswitch;

            if ($singleSub->parent_subject != 11):
                if ($sub->sub_id != 20):
                    $finalAssessment += $ass_gr;
                endif;
            endif;
            $pdf->MultiCell(18, 3, $ass_gr, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $finalAssessment += 0;
            $pdf->MultiCell(15, 3, '0', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;

        if ($sub->sub_id == 206517):
            $pdf->MultiCell(15, 3, $total_mapeh, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }

    $plg = round(($finalAssessment + $total_mapeh) / ($nm + 1), 2);
    switch (strlen(substr(strrchr($plg, "."), 1))):
        case 0:
            $val = $plg . '.00';
            break;
        case 1:
            $val = $plg . '0';
            break;
        default :
            $val = $plg;
            break;
    endswitch;
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, $val, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 3, getDesc($val), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
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
    $tf = 0;
    $nm = 0;
}

$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);

//switch ($x) {
//    case 29:
//        $pdf->ln(10);
//        break;
//    case 2:
//    case 12:
//        $pdf->ln(20);
//        break;
//    case 8:
//        $pdf->ln(70);
//        break;
//}

if ($x >= 15):
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
