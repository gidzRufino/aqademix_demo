<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {

        $this->SetTitle('DepED Form 138-A');
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
$resolution = array(210, 297);
$pdf->AddPage('L', $resolution);

$totalDays = 0;
$total_pdays = 0;
$total_adays = 0;
$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
$bg_image = K_PATH_IMAGES . '/bg_img.jpg';
$division_logo = K_PATH_IMAGES . '/division_logo.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname . ' ' . substr($principal->middlename, 0, 1) . '. ' . $principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL, $sy, $student->section_id);
$adv = ucwords(strtolower($adviser->row()->firstname . ' ' . substr($adviser->row()->middlename, 0, 1) . '. ' . $adviser->row()->lastname)) . ', LPT';
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid, 1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid, 2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid, 3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid, 4, $sy);
$bg_image = K_PATH_IMAGES . '/bg_img.jpg';
$pdf->SetAlpha(0.4);
$pdf->Image($bg_image, 0, 0, 1700, 1000, 'jpg', '', '', true, 300, '', false, false, 0);

$pdf->SetAlpha(1);
$pdf->SetFont('Times', 'R', 9);
$msg = Modules::run('reports/sbeMsg', $settings->short_name);
//$pdf->Ln(5);
$pdf->writeHTMLCell(120, '', '', $pdf->SetX(15), $msg, '', 1, 0, true, 'L', true);
$pdf->Ln();

$pdf->SetXY(10, 45);
$pdf->SetFont('Times', 'R', 10);
$pdf->MultiCell(8, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(50, 5, 'LUCY P. BAGONGON, M.A', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(60, 5, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('Times', 'R', 8);
$pdf->MultiCell(8, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(50, 5, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(10, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(60, 5, 'Adviser', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(7);

$att_img = K_PATH_IMAGES . '/attendance_rec.png';
$pdf->Image($att_img, 45, 55, 55, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln();

$pdf->StartTransform();
$pdf->SetXY(15, 76);
$pdf->Rotate(90);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(12, 35, '', 1, 'L', 0, 0, '', '', true, 0, false, true, 30, 'M');
$pdf->Ln();
$x = 7;
//$pdf->Ln();
//$pdf->SetX(10);
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    endif;
    $pdf->SetX(15);
    $pdf->MultiCell(12, 7, date("M", mktime(0, 0, 0, $m, 1, 2000)), 1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();
}
//$pdf->Ln();
$pdf->SetX(15);
$pdf->MultiCell(12, 10, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->StopTransform();
$pdf->Ln();

$pdf->SetXY(15, 76);
$pdf->SetFont('Helvetica', 'R', 8);
$pdf->MultiCell(35, 5, 'No. of School Days', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$x = 7;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(7, 5, $totalDaysInAMonth, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
}

$pdf->MultiCell(10, 5, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $student->st_id, $student->grade_id, $sy);
$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'School Days Present', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$x = 7;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $monthName = date('F', mktime(0, 0, 0, $m, 10));

    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    if ($this->session->userdata('attend_auto')):
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
    else:
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
    endif;
    if ($pdays > $totalDaysInAMonth):
        $pdays = $totalDaysInAMonth;
    endif;

    $pdf->MultiCell(7, 5, ($attendance->$monthName != '' ? $attendance->$monthName : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $total_pdays += $attendance->$monthName;
    $pdays = 0;
}


$pdf->MultiCell(10, 5, $total_pdays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'School Days Absent', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$tardy = 0;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $monthName = date('F', mktime(0, 0, 0, $m, 10));

    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays - $holiday->num_rows();
    if ($this->session->userdata('attend_auto')):
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
    else:
        $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
    endif;

    if ($pdays > $totalDaysInAMonth):
        $pdays = $totalDaysInAMonth;
    else:
        $pdays = $attendance->$monthName;
    endif;

    $pdf->MultiCell(7, 5, ($totalDaysInAMonth - $pdays), 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $total_adays += ($totalDaysInAMonth - $pdays);
    $pdays = 0;
}
$pdf->MultiCell(10, 5, $total_adays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$attTardy = Modules::run('attendance/attendance_reports/getTardyPerStudent', $student->st_id, NULL, $sy);
$pdf->SetX(15);
$pdf->MultiCell(35, 5, 'No. of Times Tardy', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$tardy = 0;
for ($d = 1; $d <= 10; $d++) {
    $m = $d + $x;
    if ($m < 10):
        $m = '0' . $m;
    endif;
    if ($m > 12):
        $n = $m;
        $schoolYear = $sy + 1;
        $m = $m - 12;
        if ($m < 10):
            $m = '0' . $m;
        endif;
    else:
        $schoolYear = $sy;
    endif;

    $monthName = date('F', mktime(0, 0, 0, $m, 10));

    $pdf->MultiCell(7, 5, ($attTardy->$monthName != 0 ? $attTardy->$monthName : ''), 'BR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

    $tardy += $attTardy->$monthName;
}
$pdf->MultiCell(10, 5, ($tardy != 0 ? $tardy : ''), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$ps_img = K_PATH_IMAGES . '/PS.png';
$pdf->Image($ps_img, 56, 97, 37, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(55, 98);
$pdf->SetFont('Times', 'B', 8);
$pdf->MultiCell(40, 10, 'PARENT\'S SIGNATURE Over Printed Name', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetFont('Times', 'B', 10);
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Times', 'R', 8);
$pdf->MultiCell(5, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '1st Quarter', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(30, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '2nd Quarter', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(8);

$pdf->SetX(10);
$pdf->MultiCell(45, 5, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln();

$pdf->SetX(10);
$pdf->MultiCell(140, 5, '3rd Grading', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(10);

$pdf->SetFont('Times', 'B', 9);
$pdf->SetX(16);
$pdf->MultiCell(113, 5, 'CERTIFICATE OF TRANSFER', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(16);
$pdf->SetFont('Times', 'R', 8);
$pdf->MultiCell(50, 5, 'Eligible for admission to (Level)', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(55, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(16);
$pdf->SetFont('Times', 'R', 9);
$pdf->MultiCell(20, 5, 'Approved:', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, $adv, 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(16);
$pdf->MultiCell(20, 5, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Adviser', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(6);

$pdf->SetX(25);
$pdf->MultiCell(50, 5, 'LUCY P. BAGONGON, M.A ', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->MultiCell(50, 5, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->MultiCell(140, 5, 'CANCELLATION OF ELIGIBILITY TO TRANSFER', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(30, 5, 'Admitted in:', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(95, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(22, 5, 'Date:', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(75, 5, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'LUCY P. BAGONGON, M.A', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->MultiCell(75, 5, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'Principal', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(18, 133, 113, 44, 0, '0000', '');

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(19, 134, 111, 42, 0, '0000', '');

$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(20, 135, 109, 40, 0, '0000', '');

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//------------------------------ |          right side         |-------------------------------------------------------//

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(155, 10, 135, 190, 0, '0000', '');

$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(156, 11, 133, 188, 0, '0000', '');

$pdf->Image($image_file, 210, 13, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetXY(158, 50);
$pdf->SetFont('bernard_mt', 'R', 33);
$pdf->SetTextColor(0, 51, 153);
$pdf->MultiCell(128, 15, 'CHRISTIAN SCHOOL FOR LIFE', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(12);

$pdf->SetX(158);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('bell_mt', 'B', 15);
$pdf->MultiCell(128, 10, 'Cagayan de Oro City', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetX(158);
$pdf->SetFont('bell_mt', 'B', 12);
$pdf->MultiCell(128, 10, 'csfl.cdo@gmail.com', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetX(158);
$pdf->MultiCell(128, 10, 'www.csfl.com', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(12);

$pdf->SetX(158);
$pdf->SetFont('bernard_mt', 'R', 28);
$pdf->MultiCell(128, 15, 'PROGRESS REPORT CARD', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(9);

$pdf->SetX(158);
$pdf->SetFont('bernard_mt', 'R', 25);
$pdf->MultiCell(128, 15, 'Elementary Department', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(9);

$pdf->SetX(158);
$pdf->SetFont('bernard_mt', 'R', 20);
$pdf->MultiCell(128, 15, 'School Year 2020 - 2021', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(15);

$pdf->SetX(158);
$pdf->SetFont('times', 'I', 8);
$pdf->MultiCell(128, 5, '(FORM 138)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(158);
$pdf->SetFont('times', 'R', 9);
$pdf->MultiCell(10, 5, 'Name', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(115, 5, ucwords(strtolower($student->firstname . ' ' . ($student->middlename != '' ? substr($student->middlename, 0, 1) . '.' : '' ) . ' ' . $student->lastname)), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(158);
$pdf->SetFont('times', 'R', 9);
$pdf->MultiCell(18, 5, 'Grade/Level', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(50, 5, $student->level, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 9);
$pdf->MultiCell(12, 5, 'Gender', 0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(45, 5, $student->sex, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(158);
$pdf->SetFont('times', 'R', 9);
$pdf->MultiCell(33, 5, 'Learner Ref. No. (LRN)', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(92, 5, ($student->lrn == '' ? $student->st_id : $student->lrn), 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);

$pdf->SetX(158);
$pdf->SetFont('times', 'R', 9);
$pdf->MultiCell(22, 5, 'Class Adviser', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(103, 5, $adv, 'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(27);

$pdf->SetX(158);
$pdf->SetTextColor(200, 0, 0);
$pdf->SetFont('pristina', 'I', 19);
$pdf->MultiCell(128, 15, 'Training Minds... Touching Hearts... Transforming Lives', 0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(10);
////back page



$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term;
$data['behaviorRate'] = $behavior;
$data['bh_group'] = $bh_group;
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$this->load->view($short_name . '/reportCardSecondPage', $data);
//Close and output PDF document
ob_end_clean();
$pdf->Output($student->lastname . ', ' . substr($student->firstname, 0, 1) . '_DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+