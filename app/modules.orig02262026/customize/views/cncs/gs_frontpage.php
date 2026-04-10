<?php

//require_once('tcpdf_include.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $settings = Modules::run('main/getSet');
        //Logo
        if ($this->page == 1):
            $this->SetFont('Times', 'B', 17);
            $this->SetXY(25, 30);
            $this->SetTextColor(0, 0, 255);
            $this->MultiCell(210, 5, strtoupper($settings->set_school_name) . ', INC.', '', 'C', 0, 0, '', '', true);
            $this->Ln();

            $this->SetFont('Times', 'R', 12);
            $this->SetTextColor(0, 0, 0);
            $this->MultiCell(220, 5, $settings->division, '', 'C', 0, 0, '', '', true);
            $this->Ln();

            $this->SetFont('Times', 'R', 9);
            $this->MultiCell(220, 5, 'www.csflcdo.com', '', 'C', 0, 0, '', '', true);
            $this->Ln(20);

            $this->SetFont('helvetica', 'B', 12);
            $this->SetTextColor(0, 0, 255);
            $this->MultiCell(220, 5, 'LEARNER’S PERMANENT ACADEMIC RECORD FOR ELEMENTARY', '', 'C', 0, 0, '', '', true);
            $this->Ln();
            $image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
            $this->Image($image_file, 20, 20, 35, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        endif;
//        $imgwm = K_PATH_IMAGES . 'watermark.png';
//        $this->Image($imgwm, 0, 0, 50, 50, '', '', '', false, 300, '', false, false, 0);
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
$pdf = new MYPDF('P', 'mm', array('250', '360'), true, 'UTF-8', false);
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
$pdf->Ln(30);


// ------------------------------ LEARNER`S PERSONAL INFORMATION ------------------------------
$st_name = ucwords(strtolower($student->sprp_lastname . ', ' . $student->sprp_firstname . ($student->sprp_middlename != '' ? ' ' . substr($student->sprp_middlename, 0,1) . '.' : '')));
$pdf->SetY(80);
$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(14, 5, "Name:", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(40, 5, ucwords(strtolower($student->sprp_lastname)), 'B', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(40, 5, ucwords(strtolower($student->sprp_firstname)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(40, 5, ucwords(strtolower($student->sprp_middlename)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(18, 5, "Division:", '', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(40, 5, ucwords(strtolower($settings->division)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetFont('Times', '', 7);
$pdf->MultiCell(14, 5, "", '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '( Family Name', '', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'First Name', '', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Middle Name )', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);

$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(9, 5, "Sex:", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(15, 5, ucwords(strtolower($student->sprp_gender)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(30, 5, "Date of Birth:", '', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(80, 5, date('F d, Y', strtotime($student->sprp_bdate)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(21, 5, "Birthplace:", '', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(55, 5, ucwords(strtolower($student->sprp_bplace)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(13, 5, "Father:", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(121, 5, ucwords(strtolower($student->sprp_father)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(17, 5, "Mother:", '', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(59, 5, ucwords(strtolower($student->sprp_mother)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$address = Modules::run('f137/getAddress', $student->st_id, 1, $student->school_year);
$st_add = ($address->street != '' ? $address->street . ', ' : '') . '' . ($address->barangay_id != '' ? $address->barangay_id . ', ' : '') . '' . ($address->city_id != '' ? $address->mun_city : '');
$pdf->SetFont('Times', '', 10);
$pdf->MultiCell(16, 5, "Address:", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(119, 5, $st_add, 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(12, 5, "LRN:", '', 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(63, 5, ucwords(strtolower($student->sprp_lrn)), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$schoolInfo = Modules::run('customize/getPreSchoolInfo', base64_encode($student->st_id));
$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(32, 5, "Preschool Eduction:", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(103, 5, "School/Address", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, "School Year", 0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, "Final Average", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 5, "Days", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(4);

$pdf->MultiCell(32, 5, "Present", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(4);

$nursery = Modules::run('f137/getSchoolInfo', $schoolInfo->nursery_sch_id);
$nursery_add = ($nursery->street != '' ? $nursery->street . ', ' : '') . ($nursery->barangay_id != '' ? $nursery->barangay_id . ', ' : '') . ($nursery->city_id != '' ? $nursery->mun_city : '');
$pdf->MultiCell(15, 5, "Nursery", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(120, 5, ($nursery->school_name != '' ? $nursery->school_name . ' / ' . $nursery_add : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->nursery_sy != '' ? $schoolInfo->nursery_sy : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->nursery_ave != '' ? $schoolInfo->nursery_ave : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 5, ($schoolInfo->nursery_days != '' ? $schoolInfo->nursery_days : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$k1 = Modules::run('f137/getSchoolInfo', $schoolInfo->kinder1_sch_id);
$k1_add = ($k1->street != '' ? $k1->street . ', ' : '') . ($k1->barangay_id != '' ? $k1->barangay_id . ', ' : '') . ($k1->city_id != '' ? $k1->mun_city : '');
$pdf->MultiCell(15, 5, "Kinder 1", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(120, 5, ($k1->school_name != '' ? $k1->school_name . ' / ' . $k1_add : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->kinder1_sy != '' ? $schoolInfo->kinder1_sy . '-' . ($schoolInfo->kinder1_sy + 1) : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->kinder1_ave != '' ? $schoolInfo->kinder1_ave : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 5, ($schoolInfo->kinder1_days != '' ? $schoolInfo->kinder1_days : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(5);

$k2 = Modules::run('f137/getSchoolInfo', $schoolInfo->kinder2_sch_id);
$k2_add = ($k2->street != '' ? $k2->street . ', ' : '') . ($k2->barangay_id != '' ? $k2->barangay_id . ', ' : '') . ($k2->city_id != '' ? $k2->mun_city : '');
$pdf->MultiCell(15, 5, "Kinder 2", '', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(120, 5, ($k2->school_name != '' ? $k2->school_name . ' / ' . $k2_add : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->kinder2_sy != '' ? $schoolInfo->kinder2_sy . '-' . ($schoolInfo->kinder2_sy + 1) : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 5, ($schoolInfo->kinder2_ave != '' ? $schoolInfo->kinder2_ave : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(5, 5, "", '', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 5, ($schoolInfo->kinder2_days != '' ? $schoolInfo->kinder2_days : ''), 'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$nYear = $pYear - ($student->grade_level_id - 2);
for ($i = 2; $i < 8; $i++):
    switch ($i):
        case 2:
            $rectA = 133;
            $rectB = 134;
            $x = 12;
            $y = 134;
            $abx = 180;
            $aby = 144;
            break;
        case 3:
            $rectA = 240;
            $rectB = 241;
            $x = 12;
            $y = 241;
            $abx = 180;
            $aby = 251;
            break;
        case 4:
        case 7:
            $rectA = 25;
            $rectB = 26;
            $x = 12;
            $y = 26;
            $abx = 180;
            $aby = 36;
            break;
        case 5:
            $rectA = 130;
            $rectB = 131;
            $x = 12;
            $y = 131;
            $abx = 180;
            $aby = 141;
            break;
        case 6:
            $rectA = 235;
            $rectB = 236;
            $x = 12;
            $y = 236;
            $abx = 180;
            $aby = 246;
            break;
    endswitch;
    $data['rectA'] = $rectA;
    $data['rectB'] = $rectB;
    $data['i'] = $i;
    $data['x'] = $x;
    $data['y'] = $y;
    $data['abx'] = $abx;
    $data['aby'] = $aby;
    $data['pdf'] = $pdf;
    $data['student'] = $student;
    $data['year'] = $year;
    //$data['imgwm'] = $imgwm;
    $data['nYear'] = $nYear++;

    $this->load->view('gs_main', $data);
endfor;
$pdf->Ln(25);

$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(85, 7, 'ATTENDANCE RECORD', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(7);

$pdf->SetFont('helvetica', 'R', 9);
$pdf->MultiCell(24, 13, 'Grade', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(24, 13, 'No. of School Days', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(24, 13, 'No. of School Days Absent', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(50, 13, 'Cause', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(24, 13, 'No. of Times Tardy', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(50, 13, 'Cause', 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->MultiCell(24, 13, 'No. of School Days Present', 1, 'C', 0, 0, '', '', true, 0, false, true, 13, 'M');
$pdf->Ln();

for ($e = 0; $e <= 5; $e++):
    switch ($e):
        case 0:
            $grd = 'I';
            break;
        case 1:
            $grd = 'II';
            break;
        case 2:
            $grd = 'III';
            break;
        case 3:
            $grd = 'IV';
            break;
        case 4:
            $grd = 'V';
            break;
        case 5:
            $grd = 'VI';
            break;
    endswitch;
    $pdf->MultiCell(24, 7, $grd, 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(24, 7, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(24, 7, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(50, 7, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(24, 7, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(50, 7, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(24, 7, '', 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();
endfor;
$pdf->Ln(8);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(220, 7, 'CERTIFICATE OF TRANSFER', 0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(15);

$pdf->SetFont('Times', 'R', 9);
$msg = Modules::run('customize/cotMsg', $st_name, levelDesc($student->grade_level_id + 1));
$pdf->writeHTMLCell(200, '', '', $pdf->SetX(15), $msg, '', 1, 0, true, 'L', true);
$pdf->Ln(15);

$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(110, 7, 'RUTCHIE C. VERGARA', 0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(110, 7, 'LUCY P. BAGONGON, M.A.', 0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(6);

$pdf->SetFont('Times', 'R', 9);
$pdf->MultiCell(35, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, 'Registrar', 'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(65, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Principal', 'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(15);

$pdf->SetFont('Times', 'I', 10);
$pdf->MultiCell(35, 5, 'Date of Issuance:', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

function emptyRec($pdf, $i, $x, $y){
    $pdf->SetFont('times', 'B', 10);
    $pdf->SetTextColor(30, 100, 90, 10);
    $pdf->MultiCell(15, 7, 'Grade ' . ($i - 1), 0, 'R', 0, 0, $x, $y, true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(100, 60, 10, 5);
    $pdf->MultiCell(15, 7, '- School', 0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(130, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->SetTextColor(100, 60, 10, 5);
    $pdf->MultiCell(23, 7, 'School Year', 0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(35, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln(7);

    $pdf->SetFont('times', 'B', 10);
    $pdf->MultiCell(85, 5, "Learning Areas", 'LT', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(52, 5, "Periodic Rating", 'LTB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "Final", 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->MultiCell(85, 5, '', 'BL', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, "1", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, "2", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, "3", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, "4", 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "Rating", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    for ($c = 0; $c <= 13; $c++):
        $pdf->MultiCell(85, 5, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(20, 5, "", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    endfor;

    $pdf->SetFont('times', 'B', 10);
    $pdf->MultiCell(85, 5, 'Average', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(13, 5, '', 'LB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, "", 'LBR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
}

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

$pdf->Output('SF10-' . $student->lastname . ', ' . $student->firstname . '  --  ' . $student->sprp_lastname . '.pdf', 'I');
