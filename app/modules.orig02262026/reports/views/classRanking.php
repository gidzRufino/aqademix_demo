<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        $CI = &get_instance();
        $section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));
        $settings = Modules::run('main/getSet');

        switch ($CI->uri->segment(5)) {
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
            case 0:
                $term = 'FINAL';
                break;
            case 5:
                $term = 'OVERALL';
                break;
        }

        // $subject = Modules::run('academic/getSpecificSubjects', segment_4);
        $nextYear = $CI->uri->segment(6) + 1;
        $this->SetTitle($settings->short_name . ' Class Ranking ');
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 25, 7, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $image_files = K_PATH_IMAGES . '/' . $settings->set_logo;
        $this->Image($image_files, 170, 7, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Ln(5);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'n', 8);
        $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(4);

        $this->SetFont('helvetica', 'B', 10);
        $this->MultiCell(180, 5, 'CLASS RANKING ' . $term, '', 'C', 0, 0, '', '', true);
        $this->Ln(8);

        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 0, 'S.Y. ' . $CI->uri->segment(6) . ' - ' . $nextYear, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();

        $this->Cell(0, 0, $section->level, 0, false, 'C', 0, '', 0, false, 'M', 'T');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

$CI = &get_instance();

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();


// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->SetXY(15, 45);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(90, 5, '', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 5, 'Average', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 5, 'Rank', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Remarks', 0, 'C', 0, 0, '', '', true);
$pdf->Ln();

$i = 1;
$r = 1;
$x = 0;

$section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));
$adviser = Modules::run('academic/getAdvisory', '', $CI->uri->segment(6), $CI->uri->segment(3));
$principal = Modules::run('hr/getEmployeeByPosition', 'Grade School Principal');
$name = strtoupper($principal->firstname . ' ' . substr($principal->middlename, 0, 1) . '. ' . $principal->lastname);
$student = Modules::run('gradingsystem/gradingsystem_reports/generateTop', $CI->uri->segment(3), $CI->uri->segment(5), $students);
$sameRank = Modules::run('gradingsystem/gradingsystem_reports/getSameRank', $student);
$previousRank = 0;
$it = 1;

foreach ($student as $key => $s):
    $x++;
    $descriptor = json_decode(Modules::run('gradingsystem/gradingsystem_reports/getGSLegend', $s['grade']));
    $remarks = json_decode(Modules::run('gradingsystem/gradingsystem_reports/getGSHonorsLegend', $s['grade']));
    $rank = $it++;
    $previousRank = $rank;
    foreach ($sameRank as $sk => $sr):
        if ($s['grade'] == $sr['grade']):
            $rank = $sr['rank'];
        endif;
    endforeach;

    $pdf->SetFont('times', '', 9);
    $pdf->MultiCell(10, 7, $i++, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(90, 7, $s['student'], 1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(17, 7, number_format($s['grade'], 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(15, 7, $rank, 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(55, 7, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();

    if ($x == 31):
        $pdf->AddPage();
        $pdf->Ln(20);
        $x = 1;
    endif;
endforeach;


$pdf->Ln(15);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(30, 10,  'Prepared By:',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(25, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 10,  '',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10,  'Adviser','T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$pdf->SetFont('helvetica', 'B', 10);
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal');
$pdf->Ln(15);
$pdf->SetX(5);
$pdf->MultiCell(30, 10, 'Verified By:', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(100, 10, 'Validated By: ', '', 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(25, 10, '', '', 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 10, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'Asst. to the Principal', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->MultiCell(25, 10, '', '', 'R', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->MultiCell(75, 10, 'School Principal', 'T', 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

// $pdf->Ln();
// $pdf->MultiCell(75, 10, $name, 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
// $pdf->MultiCell(30, 10, '', '', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
// $pdf->MultiCell(75, 10, strtoupper($adviser->row()->firstname . ' ' . $adviser->row()->lastname), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
// $pdf->Ln();

// $pdf->MultiCell(75, 5, 'OIC - School Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
// $pdf->MultiCell(30, 5, '', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
// $pdf->MultiCell(75, 5, 'Adviser', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

switch ($CI->uri->segment(5)) {
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
    case 0:
        $term = 'FINAL';
        break;
    case 5:
        $term = 'OVERALL';
        break;
}

$pdf->Output('Class Ranking - ' . $section->level . ' - ' . $term . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
