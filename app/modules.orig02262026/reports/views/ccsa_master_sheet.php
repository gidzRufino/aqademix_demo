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
            $this->Image($image_file, 390, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        else:
            $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(12);
        switch (segment_4) {
            case 1:
                $term = 'FIRST QUARTER';
                break;
            case 2:
                $term = 'SECOND QUARTER';
                break;
            case 3:
                $term = 'THIRD QUARTER';
                break;
            case 4:
                $term = 'FOURTH QUARTER';
                break;
        }
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 4.3, 'Composite Grading Sheet', 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 4.3, $term . "     SY  " . segment_5 . ' - ' . $nextYear, 0, 0, 'C');
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);

// set auto page breaks

function getRemarks($pdf, $data) {

    switch (TRUE):
        case ($data > 90):
            return $pdf->MultiCell(30, 3, 'Outstanding', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case ($data >= 85 && $data <= 90):
            return $pdf->MultiCell(30, 3, 'Very Satisfactory', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            break;
        case ($data >= 80 && $data <= 84.99):
            return $pdf->MultiCell(30, 3, 'Satisfactory', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

            break;
        case ($data >= 75 && $data <= 79.99):
            return $pdf->MultiCell(30, 3, 'Fairly Satisfactory', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

            break;
        case ($data < 75):
            return $pdf->MultiCell(30, 3, 'Did not Meet', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

            break;
    endswitch;
}

$pdf->SetAutoPageBreak(TRUE, 5);

$resolution = array(420, 220);
$pdf->AddPage('L', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_3);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);
//$subject_ids = Modules::run('subjectmanagement/getSHSubjects', $section->grade_id, $term, segment_6);

$elect = 0;
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(55, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id == 13):
            $pdf->MultiCell(85, 3, 'MAPEH', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            if ($singleSub->subject_id != 5):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        else:
            $elect++;
        endif;
    endif;
}

$pdf->MultiCell(28, 3, 'QUARTER', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, 'Increase', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(17 * $elect, 3, 'Electives', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(55, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$electiveSub = [];
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);

    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, 'Total', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            if ($singleSub->subject_id != 5):
                $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        else:
            $electiveSub[] = $singleSub->short_code;
        endif;
    endif;
}

$pdf->MultiCell(14, 3, 'Present', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, 'Previous', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '<Decrease>', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electiveSub as $subElect):
    $pdf->MultiCell(17, 3, $subElect, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(55, 3, 'BOYS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $category = Modules::run('gradingsystem/new_gs/getCustomComponentList', $singleSub->subject_id);
    $grade = Modules::run('gradingsystem/gradingsystem_reports/getAssessments', $s, $category, segment_4, $singleSub);
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            if ($singleSub->subject_id != 5):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    endif;
}
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electiveSub as $subElect):
    $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

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
$final = 0;
$mapehAve = 0;
$passed = [];
$substandard = [];
$critical = [];
$totalGrade = 0;
$gradeElect = [];
$totalComTLE = 0;
$b++;
foreach ($male->result() as $s) {
    $z++;
    $x++;
    $mStudentStat = Modules::run('reports/getStudentStat', $s->st_id);
    $pdf->MultiCell(6, 3, $z, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(55, 3, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . substr($s->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $i = 0;
    $j = count($subject_ids);
    if (empty($mStudentStat)) {
        foreach ($subject_ids as $sub):

            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
            $category = Modules::run('gradingsystem/new_gs/getCustomComponentList', $singleSub->subject_id);
            $grade = Modules::run('gradingsystem/gradingsystem_reports/getAssessments', $s, $category, segment_4, $singleSub);
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                if ($singleSub->parent_subject != 11):
                    if ($section->grade_id == 8 || $section->grade_id == 9):
                        if ($singleSub->subject_id == 10 || $singleSub->subject_id == 5):
                            $totalComTLE += $grade;
                        else:
                            $i++;
                            $totalGrade += $grade;
                        endif;
                    else:
                        $i++;
                        $totalGrade += $grade;
                    endif;
                endif;
            endif;
            switch (TRUE):
                case $grade == "":
                    $wdColor = 0;
                    break;
                case $grade <= 74:
                    $pdf->SetFillColor(255, 51, 51);
                    $wdColor = 1;
                    $substandard[$singleSub->subject_id] += 1;
                    break;
                // critical
                case ($grade >= 75 && $grade < 77):
                    $pdf->SetFillColor(255, 255, 51);
                    $wdColor = 1;
                    $critical[$singleSub->subject_id] += 1;
                    break;
//                case $grade <= 74:
//                    $pdf->SetFillColor(195,195,195);
//                    $wdColor = 1;
//                    $substandard[$singleSub->subject_id] += 1;
//                break; 
//                // critical
//                case ($grade >= 75 && $grade <77):
//                    $pdf->SetFillColor(234,232,230);
//                    $wdColor = 1;
//                    $critical[$singleSub->subject_id] += 1;
//                break;    
                //passing
                case $grade >= 77:
                    $wdColor = 0;
                    $passed[$singleSub->subject_id] += 1;
                    break;
            endswitch;
            if ($singleSub->parent_subject == 11):
                $mapehAve += $grade;
                $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                if ($singleSub->subject_id == 16):
                    $pdf->MultiCell(17, 3, ($mapehAve > 0 ? round(($mapehAve / 4)) : ''), 'TBR', 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                //$totalGrade = $totalGrade + ($mapehAve > 0 ? round(($mapehAve / 4)) : 0);
                //$i++;
                endif;
            else:
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($section->grade_id == 8 || $section->grade_id == 9):
                        if ($singleSub->subject_id != 5):
                            if ($singleSub->subject_id == 10):
                                $pdf->MultiCell(17, 3, round($totalComTLE / 2), 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                            else:
                                $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                            endif;
                        endif;
                    else:
                        $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                else:
                    //$pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    $gradeElect[] = $grade;
                endif;

            endif;
            if (segment_4 != 1) {
                $segment = segment_4 - 1;
                $prevGrade = Modules::run('gradingsystem/gradingsystem_reports/getAssessments', $s, $category, $segment, $singleSub);
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($singleSub->parent_subject != 11):
                        if ($section->grade_id == 8 || $section->grade_id == 9):
                            if ($singleSub->subject_id == 5 || $singleSub->subject_id == 10):
                                $prevComTLEGrade += $prevGrade;
                            else:
                                $prevTotalGrade += $prevGrade;
                            endif;
                        else:
                            $prevTotalGrade += $prevGrade;
                        endif;
                    endif;
                endif;
                if ($singleSub->parent_subject == 11):
                    $prevMapehAve += $prevGrade;
//                    if ($singleSub->subject_id == 16):
//                        $prevTotalGrade = $prevTotalGrade + ($prevMapehAve > 0 ? round(($prevMapehAve / 4)) : 0);
//                    endif;
                else:
                    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    //$pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;

                endif;
            }
        endforeach;
    } else {
        $pdf->MultiCell(18.3 * $j, 3, strtoupper($mStudentStat->Indicator) . '    -    ' . $mStudentStat->remark_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    }

    $mdecORin = '';
    $mtotalInDec = '';
    //$j = $i + 2;
    $totalGrade = round($totalGrade / $i);
    $mapehAve = round($mapehAve / 4);
    if ($section->grade_id == 8 || $section->grade_id == 9):
        $totalComTLE = round($totalComTLE / 2);
        $grandTotalGrade = round(($totalGrade + $mapehAve + $totalComTLE) / 3, 3);
    else:
        $grandTotalGrade = round(($totalGrade + $mapehAve) / 2, 3);
    endif;

    $prevTotalGrade = round($prevTotalGrade / $i);
    $prevMapehAve = round($prevMapehAve / 4);
    if ($section->grade_id == 8 || $section->grade_id == 9):
        $prevComTLEGrade = round($prevComTLEGrade / 2);
        $prevGrandTotalGrade = round(($prevTotalGrade + $prevMapehAve + $prevComTLEGrade) / 3, 3);
    else:
        $prevGrandTotalGrade = round(($prevTotalGrade + $prevMapehAve) / 2, 3);
    endif;

    //$totalGrade = (round($totalGrade/$i) + round($mapehAve / 4) + round($totalComTLE / 2))/$j;
    if ($grandTotalGrade && segment_4 != 1) {
        $mdecORin = $grandTotalGrade - $prevGrandTotalGrade;
        if ($mdecORin < 0):
            $mtotalInDec = '(' . abs($mdecORin) . ')';
        else:
            $mtotalInDec = round($mdecORin, 3);
        endif;
    } else {
        $mtotalInDec = '';
    }

    $pdf->MultiCell(14, 3, ($grandTotalGrade != 0 ? $grandTotalGrade : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(14, 3, ($prevGrandTotalGrade != 0 ? $prevGrandTotalGrade : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(25, 3, $mtotalInDec, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($gradeElect as $eGrade):
        $pdf->MultiCell(17, 3, $eGrade, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endforeach;
    getRemarks($pdf, ($grandTotalGrade != 0 ? $grandTotalGrade : 0));
    $pdf->Ln();
    if ($x == 18):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(55, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            if ($singleSub->parent_subject == 11):
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    if ($singleSub->subject_id == 16):
                        $pdf->MultiCell(17, 3, 'Total', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                endif;
            else:
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($singleSub->subject_id != 5):
                        $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                else:
                    $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                endif;

            endif;
        }
        $i = 0;
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;
    $totalGrade = 0;
    $prevTotalGrade = 0;
    $gradeElect = [];
    $totalComTLE = 0;
    $mapehAve = 0;
    $prevMapehAve = 0;
    $prevComTLEGrade = 0;
    $prevGrandTotalGrade = 0;
}
if ($x == 18):
    $pdf->AddPage();
    $pdf->SetY(45);
    $x = 0;
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(55, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($subject_ids as $s) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
        if ($singleSub->parent_subject == 11):
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                if ($singleSub->subject_id == 16):
                    $pdf->MultiCell(17, 3, 'Total', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                endif;
            endif;
        else:
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                if ($singleSub->subject_id != 5):
                    $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                endif;
            else:
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;

        endif;
    }
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(15, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
endif;

//Blank Space

$pdf->MultiCell(6, 3, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(55, 3, 'GIRLS', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(17, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            if ($singleSub->subject_id != 5):
                $pdf->MultiCell(17, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        else:
            $pdf->MultiCell(17, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;

    endif;
}
$pdf->MultiCell(13, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(40, 3, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

//End of Blank Space

$y = 1;
$yn = 0;
$n = 0;
foreach ($female->result() as $fem) {
    $n++;
    $x++;
    $fStudentStat = Modules::run('reports/getStudentStat', $fem->st_id);
    $pdf->MultiCell(6, 3, $n, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(55, 3, strtoupper($fem->lastname . ', ' . $fem->firstname . ' ' . substr($fem->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $i = 0;
    $k = count($subject_ids);
    if (empty($fStudentStat)) {
        foreach ($subject_ids as $sub):

            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
            $category = Modules::run('gradingsystem/new_gs/getCustomComponentList', $singleSub->subject_id);
            $grade = Modules::run('gradingsystem/gradingsystem_reports/getAssessments', $fem, $category, segment_4, $singleSub);
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                if ($singleSub->parent_subject != 11):
                    if ($section->grade_id == 8 || $section->grade_id == 9):
                        if ($singleSub->subject_id == 10 || $singleSub->subject_id == 5):
                            $totalComTLE += $grade;
                        else:
                            $i++;
                            $totalGrade += $grade;
                        endif;
                    else:
                        $i++;
                        $totalGrade += $grade;
                    endif;
                endif;
            endif;
            switch (TRUE):
                case $grade == "":
                    $wdColor = 0;
                    break;
                case $grade <= 74:
                    $pdf->SetFillColor(255, 51, 51);
                    $wdColor = 1;
                    $substandard[$singleSub->subject_id] += 1;
                    break;
                // critical
                case ($grade >= 75 && $grade < 77):
                    $pdf->SetFillColor(255, 255, 51);
                    $wdColor = 1;
                    $critical[$singleSub->subject_id] += 1;
                    break;
                //passing
                case $grade >= 77:
                    $wdColor = 0;
                    $passed[$singleSub->subject_id] += 1;
                    break;
            endswitch;
            if ($singleSub->parent_subject == 11):
                $mapehAve += $grade;
                $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                if ($singleSub->subject_id == 16):
                    $pdf->MultiCell(17, 3, ($mapehAve > 0 ? round(($mapehAve / 4)) : ''), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//                    $totalGrade = $totalGrade + ($mapehAve > 0 ? round(($mapehAve / 4)) : 0);
//                    $i++;
                endif;
            else:
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($section->grade_id == 8 || $section->grade_id == 9):
                        if ($singleSub->subject_id != 5):
                            if ($singleSub->subject_id == 10):
                                $pdf->MultiCell(17, 3, round($totalComTLE / 2), 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                            else:
                                $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                            endif;
                        endif;
                    else:
                        $pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                else:
                    //$pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    $gradeElect[] = $grade;
                endif;

            endif;
            if (segment_4 != 1) {
                $fsegment = segment_4 - 1;
                $fprevGrade = Modules::run('gradingsystem/gradingsystem_reports/getAssessments', $fem, $category, $fsegment, $singleSub);
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($singleSub->parent_subject != 11):
                        if ($section->grade_id == 8 || $section->grade_id == 9):
                            if ($singleSub->subject_id == 5 || $singleSub->subject_id == 10):
                                $prevComTLEGrade += $fprevGrade;
                            else:
                                $fprevTotalGrade += $fprevGrade;
                            endif;
                        else:
                            $fprevTotalGrade += $fprevGrade;
                        endif;
                    endif;
                endif;
                if ($singleSub->parent_subject == 11):
                    $fprevMapehAve += $fprevGrade;
//                    if ($singleSub->subject_id == 16):
//                        $fprevTotalGrade = $fprevTotalGrade + ($fprevMapehAve > 0 ? round(($fprevMapehAve / 4)) : 0);
//                    endif;
                else:
                    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    //$pdf->MultiCell(17, 3, $grade, 1, 'C', $wdColor, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;

                endif;
            }

        endforeach;
    } else {
        $pdf->MultiCell(18.3 * $k, 3, strtoupper($fStudentStat->Indicator) . '    -    ' . $fStudentStat->remark_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    }
    $decORin = '';
    $totalInDec = '';

    $totalGrade = round($totalGrade / $i);
    $mapehAve = round($mapehAve / 4);
    if ($section->grade_id == 8 || $section->grade_id == 9):
        $totalComTLE = round($totalComTLE / 2);
        $grandTotalGrade = round(($totalGrade + $mapehAve + $totalComTLE) / 3, 3);
    else:
        $grandTotalGrade = round(($totalGrade + $mapehAve) / 2, 3);
    endif;

    $fprevTotalGrade = round($fprevTotalGrade / $i);
    $fprevMapehAve = round($fprevMapehAve / 4);
    if ($section->grade_id == 8 || $section->grade_id == 9):
        $prevComTLEGrade = round($prevComTLEGrade / 2);
        $prevGrandTotalGrade = round(($fprevTotalGrade + $fprevMapehAve + $prevComTLEGrade) / 3, 3);
    else:
        $prevGrandTotalGrade = round(($fprevTotalGrade + $fprevMapehAve) / 2, 3);
    endif;

    if ($grandTotalGrade && segment_4 != 1) {
        $decORin = $grandTotalGrade - $prevGrandTotalGrade;
        if ($decORin < 0):
            $totalInDec = '(' . abs($decORin) . ')';
        else:
            $totalInDec = round($decORin);
        endif;
    } else {
        $totalInDec = '';
    }

    $pdf->MultiCell(14, 3, ($grandTotalGrade != 0 ? $grandTotalGrade : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(14, 3, ($prevGrandTotalGrade != 0 ? $prevGrandTotalGrade : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
//    $pdf->MultiCell(25, 3, ($totalGrade != 0 ? round($totalGrade / $i, 3) : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(25, 3, $totalInDec, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($gradeElect as $eGrade):
        $pdf->MultiCell(17, 3, $eGrade, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endforeach;
    getRemarks($pdf, ($grandTotalGrade != 0 ? $grandTotalGrade : 0));
    $pdf->Ln();



    if ($x == 18):
        $pdf->AddPage();
        $pdf->SetY(45);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(6, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(55, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($subject_ids as $s) {
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            if ($singleSub->parent_subject == 11):
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    if ($singleSub->subject_id == 16):
                        $pdf->MultiCell(17, 3, 'Total', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                endif;
            else:
                if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                    if ($singleSub->subject_id != 5):
                        $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                    endif;
                endif;
            endif;
        }
        $pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($gradeElect as $eGrade):
            $pdf->MultiCell(17, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endforeach;
        $pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
    endif;
    $gradeElect = [];
    $totalComTLE = 0;
    $totalGrade = 0;
    $fprevTotalGrade = 0;
    $mapehAve = 0;
    $fprevMapehAve = 0;
    $grandTotalGrade = 0;
    $fprevTotalGrade = 0;
    $fprevMapehAve = 0;
    $prevComTLEGrade = 0;
    $prevGrandTotalGrade = 0;
}

//End of Female Loop
//Blank Space

$pdf->Ln();

//End of Blank Space
//
//
$plus = 0;
if ($x >= 12):
    $pdf->AddPage();
    $pdf->SetY(45);
    $x = 0;
    $pdf->setCellPaddings(1, 1, 1, 1);
    $pdf->MultiCell(61, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($subject_ids as $s) {
        $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
        if ($singleSub->parent_subject == 11):
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                $pdf->MultiCell(17, 3, $singleSub->short_code, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                if ($singleSub->subject_id == 16):
                    $pdf->MultiCell(17, 3, 'Total', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                endif;
            endif;
        else:
            if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
                if ($singleSub->subject_id != 5):
                    $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
                endif;
            else:
                $plus++;
            endif;

        endif;
    }
    $pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($plus as $p):
        $pdf->MultiCell(17, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endforeach;
    $pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
endif;
//
//Over All Remarks
// Passing 
$electPassing = [];
$pdf->MultiCell(61, 3, 'Passing', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
        if ($singleSub->subject_id != 5):
            $pdf->MultiCell(17, 3, (!empty($passed[$singleSub->subject_id]) ? $passed[$singleSub->subject_id] + $critical[$singleSub->subject_id] : ''), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        //$pdf->MultiCell(17, 3, (!empty($passed[$singleSub->subject_id]) ? $passed[$singleSub->subject_id] + $critical[$singleSub->subject_id] : ''), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $electPassing[] = (!empty($passed[$singleSub->subject_id]) ? $passed[$singleSub->subject_id] + $critical[$singleSub->subject_id] : '');
    endif;
}
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electPassing as $ePass):
    $pdf->MultiCell(17, 3, $ePass, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

// Critical 
$electCritical = [];
$pdf->MultiCell(61, 3, 'Critical', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
        if ($singleSub->subject_id != 5):
            $pdf->MultiCell(17, 3, (!empty($critical[$singleSub->subject_id]) ? $critical[$singleSub->subject_id] : ''), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        $electCritical[] = (!empty($critical[$singleSub->subject_id]) ? $critical[$singleSub->subject_id] : '');
    endif;
}
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electCritical as $eCritical):
    $pdf->MultiCell(17, 3, $eCritical, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

// Substandard 
$electSubs = [];
$pdf->MultiCell(61, 3, 'Substandard', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
        if ($singleSub->subject_id != 5):
            $pdf->MultiCell(17, 3, (!empty($substandard[$singleSub->subject_id]) ? $substandard[$singleSub->subject_id] : ''), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        $electSubs[] = (!empty($substandard[$singleSub->subject_id]) ? $substandard[$singleSub->subject_id] : '');
    endif;
}
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electSubs as $eSubs):
    $pdf->MultiCell(17, 3, $eSubs, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

// Teachers Signature
$electTSign = [];
$pdf->MultiCell(61, 3, 'Teacher\'s Signature', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
        if ($singleSub->subject_id != 5):
            $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        $electTSign[] = '';
    endif;
}
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(14, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(25, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electTSign as $eSign):
    $pdf->MultiCell(17, 3, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;
$pdf->MultiCell(30, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

// Teachers Name
$electTName = [];
$pdf->MultiCell(61, 15, 'Teacher\'s Name', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $teacher = Modules::run('academic/getSubjectTeacher', $singleSub->subject_id, segment_3, segment_5);

    $pdf->SetFont('helvetica', 'B', 7);
    if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
        if ($singleSub->subject_id != 5):
            $pdf->MultiCell(17, 15, strtoupper(substr($teacher->firstname, 0, 1) . '. ' . $teacher->lastname), 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(17, 15, '', 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            endif;
        endif;
    else:
        $electTName[] = strtoupper(substr($teacher->firstname, 0, 1) . '. ' . $teacher->lastname);
    endif;
}
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(14, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(14, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(25, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($electTName as $eTname):
    $pdf->MultiCell(17, 15, $eTname, 'TBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
endforeach;
$pdf->MultiCell(30, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(25);


$adviser = Modules::run('academic/getAdvisory', '', segment_5, segment_3);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(3, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            if ($singleSub->subject_id != 5):
                $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        else:
            $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;

    endif;
}
switch (TRUE):
    case ($section->grade_id <= 13 && $section->grade_id >= 12):
        $principal = 'PRINCESS NEL-ANN B. OLO, LPT';
        $position = 'Senior High School Focal Person';
        break;
    case ($section->grade_id <= 11 && $section->grade_id >= 8):
        $principal = 'REGINO T. PANES, EdD';
        $position = 'High School Principal';
        break;
    case ($section->grade_id < 8 && $section->grade_id >= 1 ):
        $principal = 'MYRNA R. REDOBLE, MAT-Math';
        $position = 'Grade School Principal';
        break;

endswitch;
$pdf->MultiCell(60, 5, strtoupper($adviser->row()->firstname . ' ' . $adviser->row()->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, $principal, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, 'ANNE Y. HECHANOVA', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
foreach ($subject_ids as $s) {
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    if ($singleSub->parent_subject == 11):
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            if ($singleSub->subject_id == 16):
                $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            endif;
        endif;
    else:
        if ($singleSub->subject_id != 55 && $singleSub->subject_id != 56 && $singleSub->subject_id != 78):
            $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $pdf->MultiCell(12, 3, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;

    endif;
}
$pdf->MultiCell(60, 5, 'Class Adviser', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(60, 5, $position, 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(60, 5, 'Director, SBE', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


//Close and output PDF document
ob_end_clean();
$pdf->Output('master_sheet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
