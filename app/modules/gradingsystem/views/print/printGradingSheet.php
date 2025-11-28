<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {

        $settings = Modules::run('main/getSet');
        // $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
        // $this->Image($image_file, 90, 7, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // $image_file = K_PATH_IMAGES . '/uccp.jpg';
        // $this->Image($image_file, 190, 7, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // $this->Ln(5);
        // $this->SetFont('helvetica', 'B', 12);
        // $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        // $this->Ln();
        // $this->SetFont('helvetica', 'N', 9);
        // $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Ln();
        // $this->SetFont('helvetica', 'n', 8);
        // $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Ln(8);
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
        $this->SetTitle('Class Record');
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

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$resolution = array(203.2, 280);
$pdf->AddPage('L', 'mm', $resolution);

//-------------------------------------------------------------------------------------//
$gs_settings = Modules::run('gradingsystem/getSet');
$subject = Modules::run('academic/getSpecificSubjects', $subject_id);
$section = Modules::run('registrar/getSectionById', $section_id);

switch ($term) {
    case 1:
        $grading = 'first';
        break;
    case 2:
        $grading = 'second';
        break;
    case 3:
        $grading = 'third';
        break;
    case 4:
        $grading = 'fourth';
        break;
}

if ($gs_settings->used_specialization && $subject_id == 10):
    switch ($section->grade_level_id):
        //case 10:
        case 11:
            $getSpecs = Modules::run('academic/getSpecificSubjectAssignment', $this->session->userdata('employee_id'), $section_id, $subject_id);
            $students = Modules::run('academic/getStudentWspecializedSubject', $getSpecs->specs_id);
            $yearSectionName = Modules::run('registrar/getSpecialization', $getSpecs->specs_id)->specialization;
            break;
        default:
            $students = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
            $yearSectionName = $section->level . ' - ' . $section->section;
            break;
    endswitch;
else:
    if ($section->grade_level_id == 12 || $section->grade_level_id == 13):
        if ($subject->is_core):
            $students = Modules::run('registrar/getAllStudentsForExternal', NULL, $section->section_id);
        else:
            $students = Modules::run('registrar/getAllStudentsBasicInfoByGender', $section->grade_level_id, NULL, 1, $school_year, $strand_id);
        //print_r($getAssessment->grade_id.' ');
        endif;
    else:
        $students = Modules::run('registrar/getAllStudentsForExternal', '', $section_id);
        $yearSectionName = $section->level . ' - ' . $section->section;
    endif;
endif;

$cat = Modules::run('gradingsystem/getAssessCatBySubject', $subject_id, $school_year);
if ($cat->num_rows() > 0):
    $sub_id = $subject_id;
else:
    $sub_id = '0';
endif;
$category = Modules::run('gradingsystem/getAssessCategory', $sub_id, $school_year);
$subject_teacher = Modules::run('academic/getSubjectTeacher', $subject_id, $section_id, $school_year);

$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(290, 0, ucwords($grading . ' Grading Class Record'), 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(290, 5, $subject->subject . ' [ ' . $section->level . ' - ' . $section->section . ' ]', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->Setx(7);
$pdf->MultiCell(57, 8, 'Name', 1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(16, 8, 'Gender', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$col = 0;

foreach ($category as $cat => $k) {
    switch ($k->category_name) {
        case 'Written Work':
            $color = '#8CDCFF';
            break;
        case 'Performance Task':
            $color = '#FF8CFB';
            break;
        case 'Quarterly Assessment':
            $color = '#B0FF8C';
            break;
    }

    $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year, $strand_id);

    $col += count($teachersAssessment->result());
    
    $pdf->MultiCell(17 * $teachersAssessment->num_rows(), 8, substr($k->category_name, 0, 1) . ' (' . ($k->weight * 100) . '% )', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
}

$pdf->MultiCell(15, 8, 'FG', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$pdf->Setx(7);
$pdf->SetFont('helvetica', 'R', 9);
$pdf->MultiCell(57, 8, 'NUMBER OF ITEMS', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(16, 8, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');


foreach ($category as $cat => $k) {
    switch ($k->category_name) {
        case 'Written Work':
            $pdf->SetFillColor(0, 200, 255);
            $wdColor = 1;
            $color = '#8CDCFF';
            break;
        case 'Performance Task':
            $pdf->SetFillColor(0, 255, 0);
            $wdColor = 1;
            break;
        case 'Quarterly Assessment':
            $color = '#B0FF8C';
            break;
    }
    $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year, $strand_id);

    foreach ($teachersAssessment->result() as $IABS) {
        $pdf->MultiCell(17, 8, $IABS->no_items, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    }
}
$pdf->MultiCell(15, 8, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$x = 0;
$pdf->SetFont('helvetica', 'R', 8);
foreach ($students->result() as $s) {
    $x++;
    $pdf->Setx(7);
    $pdf->MultiCell(57, 8, $x . ' ' . ucwords(strtolower(($s->lastname . ', ' . $s->firstname . ' ' . ($s->middlename != '' ? substr($s->middlename, 0, 1) . '.' : '')))), 1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->MultiCell(16, 8, substr($s->sex, 0, 1), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');

    foreach ($category as $cat => $k) {
        switch ($k->category_name) {
            case 'Written Work':
                $color = '#8CDCFF; width:40px;';
                break;
            case 'Performance Task':
                $color = '#FF8CFB; width:40px;';
                break;
            case 'Quarterly Assessment':
                $color = '#B0FF8C; width:40px;';
                break;
        }

        $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year, $strand_id);

        foreach ($teachersAssessment->result() as $IABS) {
            $rawScore = Modules::run('gradingsystem/getRawScore', $s->st_id, $IABS->assess_id);
            $pdf->MultiCell(17, 8, $rawScore->row()->raw_score, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        }
    }
    $totalGrade = Modules::run('gradingsystem/getPartialAssessment', $s->st_id, $section_id, $subject_id, $school_year);
    $pdf->MultiCell(15, 8, round($totalGrade->$grading, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
    $pdf->Ln();

    if ($x == 15):
        $pdf->AddPage();
        $pdf->setXY(7, 30);
        $pdf->MultiCell(57, 8, 'Name', 1, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->MultiCell(16, 8, 'Gender', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');

        foreach ($category as $cat => $k) {
            switch ($k->category_name) {
                case 'Written Work':
                    $color = '#8CDCFF';
                    break;
                case 'Performance Task':
                    $color = '#FF8CFB';
                    break;
                case 'Quarterly Assessment':
                    $color = '#B0FF8C';
                    break;
            }

            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year, $strand_id);

            $pdf->MultiCell(17 * $teachersAssessment->num_rows(), 8, substr($k->category_name, 0, 1) . ' (' . ($k->weight * 100) . '% )', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        }

        $pdf->MultiCell(15, 8, 'FG', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->Ln();

        $pdf->Setx(7);
        $pdf->SetFont('helvetica', 'R', 9);
        $pdf->MultiCell(57, 8, 'NUMBER OF ITEMS', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->MultiCell(16, 8, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        foreach ($category as $cat => $k) {
            switch ($k->category_name) {
                case 'Written Work':
                    $pdf->SetFillColor(0, 200, 255);
                    $wdColor = 1;
                    $color = '#8CDCFF';
                    break;
                case 'Performance Task':
                    $pdf->SetFillColor(0, 255, 0);
                    $wdColor = 1;
                    break;
                case 'Quarterly Assessment':
                    $color = '#B0FF8C';
                    break;
            }
            $teachersAssessment = Modules::run('gradingsystem/getAssessmentPerTeacher', $subject_teacher->faculty_id, $section_id, $subject_id, $k->code, $term, $school_year, $strand_id);

            foreach ($teachersAssessment->result() as $IABS) {
                $pdf->MultiCell(17, 8, $IABS->no_items, 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
            }
        }
        $pdf->MultiCell(15, 8, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
        $pdf->Ln();
    endif;
}

if ($section->grade_level_id >= 8 && $section->grade_level_id <= 11):
    $principal = Modules::run('hr/getEmployeeByPosition', 'High School Principal');
else:
    $principal = Modules::run('hr/getEmployeeByPosition', 'Grade School Principal');
endif;

$pdf->ln(30);
$pdf->SetX(30);
$pdf->MultiCell(75, 10, strtoupper($principal->firstname . ' ' . $principal->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(40, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, strtoupper($subject_teacher->firstname . ' ' . $subject_teacher->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();
$pdf->SetX(30);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 10, 'School Principal', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(40, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'Subject Teacher', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->SetX(7);
ob_end_clean();
$pdf->Output('Grading Sheet.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+