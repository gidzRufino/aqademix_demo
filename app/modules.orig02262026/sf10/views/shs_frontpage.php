<?php
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        //Logo
        if ($this->page == 1):
            $this->SetFont('helvetica', 'B', 6);
            $this->SetXY(1,5);
            $this->MultiCell(50, 5, 'Form 137 - A/E', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 15);
            $this->MultiCell(210, 5, 'PILGRIM CHRISTIAN COLLEGE', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 8);
            $this->MultiCell(210, 3, 'UNITED CHURCH OF CHRIST IN THE PHILIPPINES', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 8);
            $this->MultiCell(210, 3, 'Capsitrano-Akut St., Cagayan de Oro City 9000, Philippines', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 8);
            $this->MultiCell(210, 3, 'Tel. Nos. (088) 856 4239 (088) 856 1335 / 72 44 99 / Telefax (088) 856 4232', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $this->SetFont('helvetica', 'B', 8);
            $this->MultiCell(210, 5, 'Email: pilgrimchristiancollege@ymail.com / Website: www.pilgrim.edu.ph', '', 'C', 0, 0, '', '', true);
            $this->Ln(8);
            $this->SetFont('helvetica', 'B', 11);
            $this->MultiCell(210, 5, 'SENIOR HIGH SCHOOL STUDENT\'S PERMANENT RECORD', '', 'C', 0, 0, '', '', true);
            $this->Ln(8);
            $image_file = K_PATH_IMAGES . '/pilgrim.jpg';
            $this->Image($image_file, 20, 10, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $image_file = K_PATH_IMAGES.'/uccp.jpg';
            $this->Image($image_file, 200, 10, 23, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document
$pdf = new MYPDF('P', 'mm', array('250', '350'), true, 'UTF-8', false);
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
// define style for border
// set font
$pdf->AddPage('P', '');
$pdf->Ln();

$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));

$pdf->MultiCell(10, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
//$pdf->SetAlpha(0.2);
$pdf->SetFillColor(0,0,0);
$pdf->Image(AVATAR.($avatar != ""?'/'.$avatar:'/images/forms/pilgrim.png'), 200, 40, 30, 30,'','PNG');
$pdf->SetAlpha(1);
$aveMapeh = 0;
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(24, 5, "Name:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, strtoupper($student->sprp_lastname . ', ' . $student->sprp_firstname . ' ' . $student->sprp_middlename), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(24, 5, "Nationality:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, ucwords(strtolower($student->nationality)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(24, 5, "Date of Birth:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, date('F d, Y', strtotime($student->sprp_bdate)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(24, 5, "Sex:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, ucwords(strtolower($student->sprp_gender)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(24, 5, "Birthplace:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, ucwords(strtolower($student->sprp_bplace)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(24, 5, "Religion:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, $student->sprp_rel_id, '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(24, 5, "Home Address:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, ucwords(strtolower(($student->street!=NULL?$student->street.' ':'') . $student->barangay_id . ' ' . $student->mun_city . ', ' . $student->province . ', ' . $student->zip_code)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(19, 5, "Tel./Cel.No:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, $student->tel_no, '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(24, 5, "Father's Name:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, ucwords(strtolower($student->sprp_father)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(24, 5, "Occupation:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, ucwords(strtolower($student->sprp_father_occ)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(24, 5, "Mother's Name:", '', 'R', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100, 5, ucwords(strtolower($student->sprp_mother)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(24, 5, "Occupation:", '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, ucwords(strtolower($student->sprp_mother_occ)), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$elementaryHistory = Modules::run('sf10/getEdHistory', segment_3, 2, $year);
$elementaryYears = $elementaryHistory->school_year - $elementaryHistory->total_years;

$pdf->MultiCell(35, 5, "Intermediate Competed:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(90, 5, strtoupper($elementaryHistory->name_of_school), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "School Year:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, $elementaryHistory->school_year, '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "General Ave:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, ($elementaryHistory->gen_ave!=0?$elementaryHistory->gen_ave:''), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$juniorHighHistory = Modules::run('sf10/getEdHistory', segment_3, 3, $year);
$juniorHighYears = $juniorHighHistory->school_year - $juniorHighHistory->total_years;

$pdf->MultiCell(45, 5, "Junior High School Completed:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, strtoupper($juniorHighHistory->name_of_school), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "School Year:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, $juniorHighHistory->school_year, '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, "General Ave:", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, ($juniorHighHistory->gen_ave!=0?$juniorHighHistory->gen_ave:''), '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(10, 5, "LRN:", '', 'L', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, $student->sprp_lrn, '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(230, 5, "S  E  C  O  N  D  A  R  Y    R  E  C  O  R  D  S", '', 'C', 0, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
// ------------------------------ ELIGIBILITY FOR JUNIOR HIGH SCHOOL ENROLLMENT ------------------------------


$nYear = ($student->grade_level_id == 12 ? $pYear : ($pYear - 1));

for ($i = 0; $i < 4; $i++):
    switch ($i):
        case 0:
            $x = 10;
            $y = 0;
            break;
        case 1:
            $x = 10;
            $y = 255;
            break;
        case 2:
            $x = 10;
            $y = 10;
            break;
        case 3:
            $x = 10;
            $y = 170;
            break;
        case 4:
            $x = 10;
            $y = 5;
            break;
    endswitch;
//    $data['subjectList'] = Modules::run('subjectmanagement/getAllSHSubjects', $student->grade_level_id, (($i == 0 || $i == 1) ? '1' : '2'), $strand_id);
    $data['strand'] = $student->strandid;
    $data['i'] = $i;
    $data['x'] = $x;
    $data['y'] = $y;
    $data['pdf'] = $pdf;
    $data['student'] = $student;
    $data['year'] = $year;
    $data['sYear'] = ($i == 0 || $i == 1 ? $nYear : ($nYear + 1));

    $this->load->view('shs_main', $data);
endfor;
$pdf->Ln(5);
// ------------------------------ CERTIFICATION ------------------------------

$pdf->SetFont('helvetica', 'R', 7);
$pdf->MultiCell(200, 15, "This is to certify that the foregoing is a true copy of the Academic Records of and the student is eligible for transfer and admission to ".(segment_7!=NULL?segment_7:'_______________'), '', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(200, 15, "REMARKS:", '', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');

$pdf->Ln(20);
$pdf->SetFont('helvetica', 'R', 7);
$pdf->MultiCell(23, 15, "Not Valid without the College Seal", '', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(165, 5, "", '', 'L', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(30, 4, "JOY M. CASINO", 'B', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->MultiCell(23, 15, "", '', 'L', 1, 0, '10', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(163, 5, "", '', 'L', 1, 0, '10', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 4, "OIC-Office of the Registrar", '', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');



function levelDesc($gradeID) {
    switch ($gradeID):
        case 1:
            return 'Kinder';
        case 2:
            return 'Grade 1';
        case 3:
            return 'Grade 2';
        case 4:
            return 'Grade 3';
        case 5:
            return 'Grade 4';
        case 6:
            return 'Grade 5';
        case 7:
            return 'Grade 6';
        case 8:
            return 'Grade 7';
        case 9:
            return 'Grade 8';
        case 10:
            return 'Grade 9';
        case 11:
            return 'Grade 10';
        case 12:
            return 'Grade 11';
        case 13:
            return 'Grade 12';
    endswitch;
}


//$data['pdf'] = $pdf;
//$data['student'] = $student;
//$data['year'] = $year;
//
//$this->load->view('gs_main', $data);
$pdf->Output('Permanent Record - '.strtoupper($student->sprp_lastname . ', ' . $student->sprp_firstname . ' ' . $student->sprp_middlename).'.pdf', 'I');
