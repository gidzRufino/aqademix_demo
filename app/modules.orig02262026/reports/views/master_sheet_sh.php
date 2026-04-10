<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
        $settings = Modules::run('main/getSet');

        // $subject = Modules::run('academic/getSpecificSubjects', segment_4);
        $nextYear = segment_5 + 1;
        $this->SetTitle(ucfirst($settings->short_name) . ' Master Sheet ');

        $this->Ln(5);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'N', 9);
        $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
        if ($settings->set_logo != 'noImage.png'):
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        else:
            $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
            $this->Image($image_file, 300, 8, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 10, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);


        $gradeLevel = Modules::run('registrar/getGradeLevelById', segment_7);
        $strand = Modules::run('registrar/getSeniorHighStrand', segment_6);
        $this->Ln(8);
        switch (segment_4) {
            case 1:
                $term = 'MID TERM (1ST Semester)';
                $sem = 1;
                break;
            case 2:
                $term = 'FINAL TERM (1ST Semester)';
                $sem = 1;
                break;
            case 3:
                $term = 'MID TERM (2ND Semester)';
                $sem = 2;
                break;
            case 4:
                $term = 'FINAL TERM (2ND Semester)';
                $sem = 2;
                break;
        }
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 4.3, 'MASTER SHEET in ' . $term, 0, 0, 'C');
        $this->Ln();
        $this->Cell(0, 4.3, "SY  " . segment_5 . ' - ' . $nextYear, 0, 0, 'C');
        $this->Ln(10);
        $this->Cell(0, 4.3, $gradeLevel->level . ' - ' . $strand->short_code, 0, 0, 'L');
        // $this->Cell(0, 4.3, 'Adviser: ' . $adviser->row()->firstname . ' ' . $adviser->row()->lastname, 0, 0, 'R');
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

switch (segment_4) {
    case 1:
        $sem = 1;
        break;
    case 2:
        $sem = 1;
        break;
    case 3:
        $sem = 2;
        break;
    case 4:
        $sem = 2;
        break;
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(400, 216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(55);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$settings = Modules::run('main/getSet');

$coreSubs = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, $sem, $strand, 1);
$appliedSubs = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, $sem, $strand);

//$subject = explode(',', $subject_ids->subject_id);
$finalAssessment = 0;
$mapeh = 0;
$pdf->SetX(10);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($coreSubs as $s) {

    $pdf->MultiCell(22, 3, $s->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}
foreach ($appliedSubs as $as) {

    $pdf->MultiCell(22, 3, $as->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(18, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->SetX(10);
$pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
foreach ($coreSubs as $s) {
    $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}
foreach ($appliedSubs as $as) {

    $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
}

$pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(35, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
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
        $term = 1;
        break;
    case 2:
        $term = 2;
        break;
    case 3:
        $term = 3;
        break;
    case 4:
        $term = 4;
        break;
}
$z = 0;
foreach ($male->result() as $s) {
    $z++;
    $x++;

    $pdf->SetX(10);
    $pdf->MultiCell(8, 3, $z, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . substr($s->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    foreach ($coreSubs as $sub) {

        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, $term, segment_5);

        $genAve += $finalGrade->row()->final_rating;
        $numSubs++;
        if ($finalGrade->row()->final_rating != 0):
            $pdf->MultiCell(22, 3, $finalGrade->row()->final_rating, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $pdf->MultiCell(22, 3, "0", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }

    foreach ($appliedSubs as $as) {

        $singleSub = Modules::run('academic/getSpecificSubjects', $as->sh_sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $s->st_id, $singleSub->subject_id, $term, segment_5);

        $genAve += $finalGrade->row()->final_rating;
        $numSubs++;
        if ($finalGrade->row()->final_rating != 0):
            $pdf->MultiCell(22, 3, $finalGrade->row()->final_rating, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $pdf->MultiCell(22, 3, "0", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }

    //$genAve += $mfg;

    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(18, 3, round($genAve / ($numSubs), 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    if (round($genAve / ($numSubs), 2) >= 75):
        $pdf->MultiCell(35, 3, 'PASSED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    else:
        $pdf->MultiCell(35, 3, 'FAILED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
    $pdf->ln();

    if ($x == 17):
        $pdf->AddPage();
        $pdf->SetXY(10, 55);
        $x = 0;
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {
            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();


        $pdf->SetX(10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {
            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }

        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;

    unset($mapeh);
    unset($genAve);
    unset($numSubs);
    $mapeh = 0;
    $finalAssessment = 0;
}

for ($bl = 1; $bl <= 1; $bl++) {
    $x++;
    if ($x == 17):
        $pdf->AddPage();
        $pdf->SetY(55);
        $x = 0;

        $pdf->SetX(10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {

            $pdf->MultiCell(22, 3, $s->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, $as->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }

        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {
            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif;

    $pdf->SetX(10);
    $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    foreach ($coreSubs as $s) {
        $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    }
    foreach ($appliedSubs as $as) {

        $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    }
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(35, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
}

$y = 1;
$yn = 0;
$n = 0;
foreach ($female->result() as $fem) {
    $x++;
    if ($x == 17 || $x == 19): // if 18
        $pdf->AddPage();
        $pdf->SetY(55);
        $x = 0;

        $pdf->SetX(10);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {

            $pdf->MultiCell(22, 3, $s->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, $as->short_code, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, 'FINAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, 'REMARKS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

        $pdf->SetX(10);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(8, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(60, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach ($coreSubs as $s) {
            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        foreach ($appliedSubs as $as) {

            $pdf->MultiCell(22, 3, '', 'TB', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        }
        $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(18, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(35, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();

    endif; // end of if 18
    $yn++;

    $pdf->SetX(10);
    $pdf->MultiCell(8, 3, $yn, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(60, 3, strtoupper($fem->lastname . ', ' . $fem->firstname . ' ' . substr($fem->middlename, 0, 1) . '.'), 1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    foreach ($coreSubs as $sub) {

        $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, $term, segment_5);

        $genAve += $finalGrade->row()->final_rating;
        $numSubs++;
        if ($finalGrade->row()->final_rating != 0):
            $pdf->MultiCell(22, 3, $finalGrade->row()->final_rating, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $pdf->MultiCell(22, 3, "0", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }

    foreach ($appliedSubs as $as) {

        $singleSub = Modules::run('academic/getSpecificSubjects', $as->sh_sub_id);
        $finalGrade = Modules::run('gradingsystem/getFinalGrade', $fem->st_id, $singleSub->subject_id, $term, segment_5);

        $genAve += $finalGrade->row()->final_rating;
        $numSubs++;
        if ($finalGrade->row()->final_rating != 0):
            $pdf->MultiCell(22, 3, $finalGrade->row()->final_rating, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        else:
            $pdf->MultiCell(22, 3, "0", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    }
    $plg = round($genAve / ($numSubs), 0);
    $pdf->MultiCell(5, 3, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(18, 3, $plg, 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    if ($plg >= 75):
        $pdf->MultiCell(35, 3, 'PASSED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    else:
        $pdf->MultiCell(35, 3, 'FAILED', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    endif;
    $pdf->ln();
    $f = $tot - $y;
    //$pdf->MultiCell(50, 3,$f,1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $y++;
    $n++;
    unset($genAve);
    unset($numSubs);
    $finalAssessment = 0;
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
$pdf->SetX(80);
$pdf->MultiCell(75, 10, strtoupper($principal->firstname . ' ' . $principal->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(40, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, strtoupper($adviser->row()->firstname . ' ' . $adviser->row()->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(10);
$pdf->SetX(80);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 10, 'School Principal', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(40, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'Adviser', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
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
