<?php

class MYPDF extends Pdf
{
    public function Header()
    {
        $CI = &get_instance();

        $section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));
        if (!$section) {
            return;
        }

        $settings = Modules::run('main/getSet');
        $nextYear = ((int)$CI->uri->segment(4)) + 1;

        $this->SetTitle('School Form 1 (SF 1) - ' . $section->level);

        $image_file = K_PATH_IMAGES . 'depEd_logo.jpg';
        $this->Image($image_file, 5, 25, 30);

        $this->SetFont('helvetica', 'B', 12);
        $this->SetY(25);
        $this->Cell(0, 0, 'School Form 1 (SF 1) School Register', 0, 1, 'C');

        $this->SetFont('helvetica', '', 8);
        $this->Cell(
            0,
            5,
            '(This replaces Form 1, Master List & STS Form 2)',
            0,
            1,
            'C'
        );

        $this->SetFont('helvetica', 'B', 10);
        $this->SetXY(50, 35);
        $this->Cell(60, 4, 'School ID: ' . $settings->school_id);
        $this->Cell(50, 4, 'Region: ' . $settings->region);
        $this->Cell(60, 4, 'Division: ' . $settings->division);
        $this->Cell(60, 4, 'District: ' . $settings->district, 0, 1);

        $this->SetXY(35, 45);
        $this->Cell(80, 4, 'School Year: ' . $CI->uri->segment(4) . '-' . $nextYear);
        $this->Cell(100, 4, 'School Name: ' . $settings->set_school_name);
        $this->Cell(60, 4, 'Grade Level: ' . $section->level);
        $this->Cell(60, 4, 'Section: ' . $section->section);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(
            0,
            10,
            'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),
            0,
            0,
            'R'
        );
    }
}

$CI = &get_instance();

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetMargins(3, 10, 3);
$pdf->SetAutoPageBreak(true, 5);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$resolution = [216, 330];
$pdf->AddPage('L', $resolution);

/**
 * TABLE HEADER FUNCTION
 */
function renderTableHeader($pdf)
{
    $pdf->SetY(60);
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->setCellPaddings(1, 1, 1, 1);

    $pdf->MultiCell(21, 28, 'LRN', 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(30, 28, "NAME\n(Last, First, Middle)", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(8, 28, "SEX\n(M/F)", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(18, 28, "BIRTH DATE\n(mm/dd/yyyy)", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(10, 28, "AGE\nas of 1st Friday of June", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(18, 28, "Mother\nTongue", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(17, 28, "IP\n(Ethnic)", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(15, 28, "Religion", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(67, 10, "ADDRESS", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(44, 10, "PARENT", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(36, 10, "GUARDIAN", 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(20, 28, "CONTACT NO.", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $pdf->MultiCell(20, 28, "REMARKS", 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');

    $pdf->SetXY(140, 70);
    $pdf->MultiCell(15, 18, "Street", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(17, 18, "Barangay", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(18, 18, "City", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(17, 18, "Province", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(22, 18, "Father's Name (Last Name, First Name, Middle Name)", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(22, 18, "Mother's Maiden Name (Last Name, First Name, Middle Name)", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(18, 18, "Name", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
    $pdf->MultiCell(18, 18, "Relation", 1, 'C', 0, 0, '', '', true, 0, false, true, 18, 'M');
}

renderTableHeader($pdf);

/**
 * LOAD STUDENTS
 */
$pdf->Ln();
$getStudents = Modules::run(
    'registrar/getAllStudentsForExternal',
    $CI->uri->segment(5),
    $CI->uri->segment(3)
);

$x = 0;

foreach ($getStudents->result() as $s) {

    $settings = Modules::run('main/getSet');

    $firstFriday = date(
        'Y-m-d',
        strtotime('first Friday of June ' . $settings->school_year)
    );

    $bdate = $s->temp_bdate;
    $age = floor((strtotime($firstFriday) - strtotime($bdate)) / 31556926);

    $thisYearBday = $settings->school_year . '-' . date('m-d', strtotime($bdate));
    if (strtotime($thisYearBday) > strtotime($firstFriday)) {
        $age--;
    }

    $sex = strtolower($s->sex) === 'male' ? 'M' : 'F';

    $fatherName = $s->f_firstname != null ? trim($s->f_lastname . ', ' . $s->f_firstname) : '';
    $motherName = $s->m_firstname != null ? trim($s->m_lastname . ', ' . $s->m_firstname) : '';

    $contact = trim($s->f_mobile . ' / ' . $s->m_mobile, ' /');

    $bdateFormatted = date('m/d/Y', strtotime($bdate));
    // 17, 17, 'Barangay', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M'
    $pdf->MultiCell(21, 16, $s->lrn ?: $s->st_id, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(30, 16, strtoupper($s->lastname . ', ' . $s->firstname  . ($s->middlename != null ? ' ' . $s->middlename : '')), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(8, 16, $sex, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, $bdateFormatted, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(10, 16, $age, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, strtoupper($s->mother_tongue), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->ethnic_group), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(15, 16, strtoupper($s->religion), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(15, 16, strtoupper($s->street), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->barangay), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, strtoupper($s->mun_city), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->province), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(22, 16, strtoupper($fatherName), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(22, 16, strtoupper($motherName), 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(20, 16, $contact, 1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(20, 16, '', 1, 'C', 0, 1, '', '', true, 0, false, true, 16, 'M');

    $x++;

    if ($x === 7) {
        $x = 0;
        $pdf->AddPage();
        renderTableHeader($pdf);
    }
}

$section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));
$pdf->Output(
    'DepEdForm1-' . $section->level . '-' . $section->section . '.pdf',
    'I'
);
