<?php

class MYPDF extends Pdf
{
    //Page header
    public function Header()
    {
        // Logo
        // $this->SetTitle('School Form 2 (SF 2) Daily Attendance Report of Learners');
        //                $this->SetTopMargin(3);
        $CI = &get_instance();
        $image_file = K_PATH_IMAGES . '/depEd_logo.jpg';
        $this->Image($image_file, 10, 15, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->SetY(25);
        $this->Cell(0, 0, 'School Form 2 (SF 2) Daily Attendance Report of Learners', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();

        $this->SetFont('helvetica', 'n', 8);
        // Title
        //        $this->SetXY(37, 15);
        $this->Cell(0, 15, '(This replaces Form 1, Form 2 & STS Form 4 - Absenteeism and Dropout Profile)', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $settings = Modules::run('main/getSet');
        $nextYear = $settings->school_year + 1;
        $section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));

        $this->SetFont('helvetica', 'B', 12);
        $this->SetXY(50, 35);
        $this->Cell(0, 4.3, "School ID : " . $settings->school_id, 0, 0, 'L');
        $this->SetXY(140, 35);
        $this->Cell(0, 4.3, "School Year: " . $settings->school_year . '-' . $nextYear, 0, 0, 'L');
        $this->SetXY(210, 35);
        $this->Cell(0, 4.3, "Report for the Month of : " . date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10)), 0, 0, 'L');
        $this->SetXY(43, 45);
        $this->Cell(0, 4.3, "School Name : " . $settings->set_school_name, 0, 0, 'L');
        $this->SetXY(200, 45);
        $this->Cell(0, 4.3, "Grade Level: " . $section->level, 0, 0, 'L');
        $this->SetXY(260, 45);
        $this->Cell(0, 4.3, "Section: " . $section->section, 0, 0, 'L');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom

        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);

//constants
$section = Modules::run('registrar/getSectionById', $CI->uri->segment(3));

$month = date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10));
$settings = Modules::run('main/getSet');
$sy = $settings->school_year;

if (abs($CI->uri->segment(4)) < 6 && date('Y') > $sy):
    $year = $sy + 1;
else:
    $year = $sy;
endif;

$firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10)), $year, 'first');
$lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10)), $year, 'last');
$firstDayName = date('D', strtotime('first Day of ' . date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10)) . ' ' . $year));
$holiday = Modules::run('calendar/holidayExist', $CI->uri->segment(4), $year);
$schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $CI->uri->segment(4), $year);
$tdays = date('t', strtotime($year . '-' . $CI->uri->segment(4) . '-01'));
$columnCount = 0;
$ctt = 0;
$k = 0;
$maleTotal = 0;
$femaleTotal = 0;
$pma = 0;
$ma = 0;
$mta = 0;
$mt = 0;
$totDay = 0;
$maleDailyTotalAttendance = 0;
$femaleDailyTotalAttendance = 0;
$dailyTotal = 0;
$tardy = 0;

function upperShades($pdf, $LoLe, $btmL, $UR, $h, $loRi, $btmR)
{
    $UL = $LoLe + 60;
    $bL = $btmL + 71.5;
    $uR = $UR + 53;
    $H = $h + 71.5;
    $LR = $loRi + 53;
    $bR = $btmR + 87;
    //upper shades
    //return $pdf->Polygon(array(60,91.5,60,76,68,76), 'DF', array(222, 222, 222), array(0, 0, 0));
    return $pdf->Polygon(array($UL, $bL, $uR, $H, $LR, $bR), 'DF', array(222, 222, 222), array(0, 0, 0));
}

function lowerShades($pdf, $LoLe, $btmL, $UR, $h, $loRi, $btmR)
{
    $LL = $LoLe + 53;
    $bL = $btmL + 86.5;
    $uR = $UR + 60;
    $H = $h + 71.5;
    $LR = $loRi + 60;
    $bR = $btmR + 86.5;
    //lower shades
    // $pdf->Polygon(array(60,76.3,68,62,68,76.3), 'DF', array(222, 222, 222), array(222, 222, 222));
    //return $pdf->Polygon(array(60,91.5,60,76,68,91.5), 'DF', array(222, 222, 222), array(222, 222, 222));
    return $pdf->Polygon(array($LL, $bL, $uR, $H, $LR, $bR), 'DF', array(222, 222, 222), array(0, 0, 0));
}

function absentLine1($pdf, $x, $y, $x1, $y1)
{
    $x = $x + 60;
    $y = $y + 87;
    $x1 = $x1 + 53;
    $y1 = $y1 + 71;

    return $pdf->Line($x, $y, $x1, $y1, array('color' => array(255, 17, 17)));
}

function absentLine2($pdf, $x, $y, $x1, $y1)
{
    $x = $x + 53;
    $y = $y + 87;
    $x1 = $x1 + 60;
    $y1 = $y1 + 72;

    return $pdf->Line($x, $y, $x1, $y1, array('color' => array(255, 17, 17)));
}

function whatDay($dd)
{
    switch ($dd):
        case 1:
            return 'M';
        case 2:
            return 'T';
        case 3:
            return 'W';
        case 4:
            return 'TH';
        case 5:
            return 'F';
    endswitch;
}

// set auto page breaks
$pdf->SetAutoPageBreak(true, 5);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(216, 330);
$pdf->AddPage('L', $resolution);

for ($x = $firstDay; $x <= $lastDay; $x++) {

    $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

    if ($day == 'Sat' || $day == 'Sun') {
        if ($isClass):
            $ctt++;
        endif;
    } else {
        $ctt++;
    }
}
$pdf->SetY(55);
$pdf->SetFont('helvetica', 'B', 8);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(50, 16.5, "LEARNER'S NAME
(Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
$pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

$pdf->Ln();
$pdf->SetXY(53, 60.5);

for ($x = $firstDay; $x <= $lastDay; $x++) {

    $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

    if ($day == 'Sat' || $day == 'Sun') {
        if ($isClass):
            $columnCount++;
            $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
        endif;
    } else {
        $columnCount++;
        $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
    }
}

$pdf->Ln();
$pdf->SetXY(53, 66);
for ($x = $firstDay; $x <= $lastDay; $x++) {
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
    $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

    $wd = whatDay($day);

    if ($day == 0 || $day == 6):
        if ($day == 0):
            if ($isClass):
                $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        else:
            if ($isClass):
                $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
    endif;
    else:
        $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    endif;
}
$pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$y = 0;

foreach ($male->result() as $s) {
    $y++;
    $pdf->MultiCell(50, 15, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . $s->middlename), 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $columnCount = 0;
    $i = 0;
    for ($x = $firstDay; $x <= $lastDay; $x++) {
        $i++;

        if ($i == 1):
            if (abs($CI->uri->segment(4) == 1)):
                $con = 2;
            else:
                $con = $columnCount;
            endif;

        endif;

        $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
        $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
        $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

        if ($day == 'Sat' || $day == 'Sun') {
            if ($isClass):
                $columnCount++;

                switch ($con):
                    case 0:
                        $conR = ($columnCount - 1) * 7;
                        break;
                    case 4:
                    case 2:
                    case 1:
                        $conR = ($columnCount - 2) * 7;
                        break;
                    case 5:
                    case 3:
                        $conR = ($columnCount - 2) * 7;
                        break;
                endswitch;

                $z = 15;

                $r = $z * ($y - 1);
                if ($this->session->userdata('attend_auto')):
                    $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
                else:
                    $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
                endif;

            if ($ifPresent):
                if ($this->session->userdata('attend_auto')):
                    $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                else:
                    $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                endif;
            $pma += 1;
            $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            if ($remarks->row()->remarks != 0):
                switch ($remarks->row()->remarks) {
                    case 1:
                        upperShades($pdf, $conR, $r, $conR, $r, $conR, $r);
                        break;
                    case 2:
                        lowerShades($pdf, $conR, $r, $conR, $r, $conR, $r);

                        break;
                }

            endif;
            else:
                $ma += 1;
                absentLine1($pdf, $conR, $r, $conR, $r);
                absentLine2($pdf, $conR, $r, $conR, $r);
                $pdf->SetLineStyle(array('color' => array(0, 0, 0)));
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            endif;
            switch (abs($CI->uri->segment(4))) {
                case 04:
                case 06:
                    // $conR = ($columnCount - 1) * 7;
                    // break;
                case 11:
                    // $conR = ($columnCount - 1) * 7;
                    // break;
                case 02:
                    $conR = ($columnCount - 1) * 7;
                    break;
                default:
                    $conR = ($columnCount - 2) * 7;
                    break;
            }

            if ($conR == -7):
                $conR = $conR * (-20);
            endif;
            if ($conR == -14):
                $conR = $conR * (-20);
            endif;
            endif;
        } else {
            $columnCount++;

            switch ($con):
                case 0:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 2:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 4:
                case 1:
                    $conR = ($columnCount - 2) * 7;
                    break;
                case 5:
                case 3:
                    $conR = ($columnCount - 2) * 7;
                    break;
            endswitch;

            $z = 15;

            $r = $z * ($y - 1);
            if ($this->session->userdata('attend_auto')):
                $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
            else:
                $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
            endif;

            if ($isHoliday):
                $pdf->MultiCell(7, 15, '', ($y == 9 ? 'B' : 0), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            else:
                if ($ifPresent):
                    if ($this->session->userdata('attend_auto')):
                        $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                    else:
                        $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                    endif;
                $pma += 1;
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                if ($remarks->row()->remarks != 0):
                    switch ($remarks->row()->remarks) {
                        case 1:
                            upperShades($pdf, $conR, $r, $conR, $r, $conR, $r);
                            break;
                        case 2:
                            lowerShades($pdf, $conR, $r, $conR, $r, $conR, $r);

                            break;
                    }

                endif;
            else:
                $ma += 1;
                absentLine1($pdf, $conR, $r, $conR, $r);
                absentLine2($pdf, $conR, $r, $conR, $r);
                $pdf->SetLineStyle(array('color' => array(0, 0, 0)));
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            endif;
            endif;

            switch (abs($CI->uri->segment(4))) {
                case 04:
                case 06:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 11:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 02:
                    $conR = ($columnCount - 1) * 7;
                    break;
                default:
                    $conR = ($columnCount - 2) * 7;
                    break;
            }

            if ($conR == -7):
                $conR = $conR * (-20);
            endif;
            if ($conR == -14):
                $conR = $conR * (-20);
            endif;
            //lowerShades($pdf, 8, ((30.4)*0), -8, (30*0), 8, (30.4*0));
        }
    }

    //absent
    $pdf->MultiCell(15, 15, $ma, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    if ($this->session->userdata('attend_auto')):
        $tardy = Modules::run('attendance/getTardy', $s->st_id, $CI->uri->segment(4), $year);
    else:
        $tardy = Modules::run('attendance/getTardy', $s->st_id, $CI->uri->segment(4), $year);
    endif;
    $pdf->MultiCell(15, 15, (!empty($tardy) ? $tardy->num_rows() : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //remarks
    $rem = Modules::run('main/getAdmissionRemarks', $s->st_id, $CI->uri->segment(4), $year);
    if ($rem->num_rows() > 0) {
        if ($rem->row()->code_indicator_id != 4):
            $remarks = $rem->row()->code . ' ' . $rem->row()->remarks . ' - ' . $rem->row()->remark_date;
        else:
            $remarks = "";
        endif;
    } else {
        $remarks = '';
    }
    $pdf->MultiCell(70, 15, $remarks, 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();

    unset($p);
    $p = 0;
    unset($ma);

    $ma = 0;
    if ($y == 9) {
        $y = 0;
        $pdf->AddPage();
        $pdf->SetY(55);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(50, 16.5, "LEARNER'S NAME
        (Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
        $pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
        If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

        $pdf->Ln();
        $pdf->SetXY(53, 60.5);

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
                endif;
            } else {
                $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
            }
        }

        $pdf->Ln();
        $pdf->SetXY(53, 66);
        for ($x = $firstDay; $x <= $lastDay; $x++) {
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

            $wd = whatDay($day);

            if ($day == 0 || $day == 6):
                if ($day == 0):
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
                else:
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
            endif;
            else:
                $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }
        $pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    }
} // end of male;

for ($blank = 1; $blank <= 2; $blank++) {
    $y++;
    if ($blank == 1):
        $pdf->MultiCell(50, 15, '<<<  MALE  | DAILY TOTAL   >>>', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $columnCount = 0;

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $columnCount++;
                    if ($x < 10):
                        $date = "0" . $x;
                    else:
                        $date = $x;
                    endif;
                $maleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Male', $CI->uri->segment(5));
                $maleDailyTotalAttendance += $maleTotal;
                $pdf->MultiCell(7, 15, $maleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            } else {
                if ($isHoliday):
                    $pdf->MultiCell(7, 15, '', ($y == 9 ? 'B' : 0), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                else:
                    $columnCount++;
                    if ($x < 10):
                        $date = "0" . $x;
                    else:
                        $date = $x;
                    endif;
                    $maleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Male', $CI->uri->segment(5));
                    $maleDailyTotalAttendance += $maleTotal;
                    $pdf->MultiCell(7, 15, $maleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            }
        }
    switch ($columnCount) {
        case 23:
            $columnCount = 22;
            break;
        case 24:

            $columnCount = 23;
            break;
        case 25:

            $columnCount = 24;
            break;
    }

    //absent
    $pdf->MultiCell(15, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    $pdf->MultiCell(15, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(70, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();
    else:
        $pdf->MultiCell(50, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $columnCount = 0;

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $columnCount++;

                    $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            } else {
                $columnCount++;

                $pdf->MultiCell(7, 15, '', ($isHoliday ? 'B' : 1), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                //lowerShades($pdf, 8, ((30.4)*0), -8, (30*0), 8, (30.4*0));
            }
        }
    switch ($columnCount) {
        case 23:
            $columnCount = 22;
            break;
        case 24:

            $columnCount = 23;
            break;
        case 25:

            $columnCount = 24;
            break;
    }

    //absent
    $pdf->MultiCell(15, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    $pdf->MultiCell(15, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(70, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();
    endif;



    if ($y == 9) {
        $y = 0;
        $pdf->AddPage();
        $pdf->SetY(55);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(50, 16.5, "LEARNER'S NAME
        (Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
        $pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
        If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

        $pdf->Ln();
        $pdf->SetXY(53, 60.5);

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
                endif;
            } else {
                $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
            }
        }

        $pdf->Ln();
        $pdf->SetXY(53, 66);
        for ($x = $firstDay; $x <= $lastDay; $x++) {
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

            $wd = whatDay($day);

            if ($day == 0 || $day == 6):
                if ($day == 0):
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
                else:
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
            endif;
            else:
                $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }
        $pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    }
} // end of blank row;


$fa = 0;
foreach ($female->result() as $s) {
    $y++;
    $pdf->MultiCell(50, 15, strtoupper($s->lastname . ', ' . $s->firstname . ' ' . $s->middlename), 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $columnCount = 0;
    $i = 0;
    for ($x = $firstDay; $x <= $lastDay; $x++) {
        $i++;

        if ($i == 1):
            $con = $columnCount;
        endif;

        $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
        $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
        $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

        if ($day == 'Sat' || $day == 'Sun') {
            if ($isClass):

                $columnCount++;

                switch ($con):
                    case 0:
                        $conR = ($columnCount - 1) * 7;
                        break;
                    case 4:
                    case 2:
                    case 1:
                        $conR = ($columnCount - 2) * 7;
                        break;
                    case 5:
                    case 3:
                        $conR = ($columnCount - 2) * 7;
                        break;
                endswitch;



                $z = 15;

                $r = $z * ($y - 1);
                if ($this->session->userdata('attend_auto')):
                    $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
                else:
                    $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
                endif;

            if ($ifPresent):
                if ($this->session->userdata('attend_auto')):
                    $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                else:
                    $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                endif;
            $pma += 1;
            $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            if ($remarks->row()->remarks != 0):
                switch ($remarks->row()->remarks) {
                    case 1:
                        upperShades($pdf, $conR, $r, $conR, $r, $conR, $r);
                        break;
                    case 2:
                        lowerShades($pdf, $conR, $r, $conR, $r, $conR, $r);

                        break;
                }

            endif;
            else:
                $fa += 1;
                absentLine1($pdf, $conR, $r, $conR, $r);
                absentLine2($pdf, $conR, $r, $conR, $r);
                $pdf->SetLineStyle(array('color' => array(0, 0, 0)));
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            endif;
            switch (abs($CI->uri->segment(4))) {
                case 04:
                case 06:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 11:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 02:
                    $conR = ($columnCount - 1) * 7;
                    break;
                default:
                    $conR = ($columnCount - 2) * 7;
                    break;
            }

            if ($conR == -7):
                $conR = $conR * (-20);
            endif;
            if ($conR == -14):
                $conR = $conR * (-20);
            endif;
            endif;
        } else {
            $columnCount++;

            switch ($con):
                case 0:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 4:
                case 2:
                case 1:
                    $conR = ($columnCount - 2) * 7;
                    break;
                case 5:
                case 3:
                    $conR = ($columnCount - 2) * 7;
                    break;
            endswitch;



            $z = 15;

            $r = $z * ($y - 1);
            if ($this->session->userdata('attend_auto')):
                $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
            else:
                $ifPresent = Modules::run('attendance/ifPresent', $s->st_id, $x, $CI->uri->segment(4), $year);
            endif;

            if ($isHoliday):
                $pdf->MultiCell(7, 15, '', ($y == 9 ? 'B' : 0), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            else:
                if ($ifPresent):
                    if ($this->session->userdata('attend_auto')):
                        $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                    else:
                        $remarks = Modules::run('attendance/getAttendanceRemark', $s->st_id, $year . '-' . $CI->uri->segment(4) . '-' . $x);
                    endif;
                $pma += 1;
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                if ($remarks->row()->remarks != 0):
                    switch ($remarks->row()->remarks) {
                        case 1:
                            upperShades($pdf, $conR, $r, $conR, $r, $conR, $r);
                            break;
                        case 2:
                            lowerShades($pdf, $conR, $r, $conR, $r, $conR, $r);

                            break;
                    }

                endif;
            else:
                $fa += 1;
                absentLine1($pdf, $conR, $r, $conR, $r);
                absentLine2($pdf, $conR, $r, $conR, $r);
                $pdf->SetLineStyle(array('color' => array(0, 0, 0)));
                $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            endif;
            endif;
            switch (abs($CI->uri->segment(4))) {
                case 04:
                case 06:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 11:
                    $conR = ($columnCount - 1) * 7;
                    break;
                case 02:
                    $conR = ($columnCount - 1) * 7;
                    break;
                default:
                    $conR = ($columnCount - 2) * 7;
                    break;
            }

            if ($conR == -7):
                $conR = $conR * (-20);
            endif;
            if ($conR == -14):
                $conR = $conR * (-20);
            endif;
            //lowerShades($pdf, 8, ((30.4)*0), -8, (30*0), 8, (30.4*0));
        }
    }
    switch ($columnCount) {
        case 23:
            $columnCount = 22;
            break;
        case 24:

            $columnCount = 23;
            break;
        case 25:

            $columnCount = 24;
            break;
    }
    //    for ($cC = $columnCount; $cC <= 25; $cC++) {
    //        $pdf->MultiCell(7, 15, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //    }
    //absent
    $pdf->MultiCell(15, 15, $fa, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    if ($this->session->userdata('attend_auto')):
        $tardy = Modules::run('attendance/getTardy', $s->st_id, $CI->uri->segment(4), $year);
    else:
        $tardy = Modules::run('attendance/getTardy', $s->st_id, $CI->uri->segment(4), $year);
    endif;

    $pdf->MultiCell(15, 15, (!empty($tardy) ? $tardy->num_rows() : 0), 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

    //remarks
    $rem = Modules::run('main/getAdmissionRemarks', $s->st_id, $CI->uri->segment(4), $year);
    if ($rem->num_rows() > 0) {
        if ($rem->row()->code_indicator_id != 4):
            $remarks = $rem->row()->code . ' ' . $rem->row()->remarks . ' - ' . $rem->row()->remark_date;
        else:
            $remarks = "";
        endif;
    } else {
        $remarks = '';
    }
    $pdf->MultiCell(70, 15, $remarks, 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();

    unset($p);
    $p = 0;
    unset($fa);
    $fa = 0;


    if ($y == 9) {
        $y = 0;
        $pdf->AddPage();
        $pdf->SetY(55);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(50, 16.5, "LEARNER'S NAME
        (Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
        $pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
        If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

        $pdf->Ln();
        $pdf->SetXY(53, 60.5);

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
                endif;
            } else {
                $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
            }
        }

        $pdf->Ln();
        $pdf->SetXY(53, 66);
        for ($x = $firstDay; $x <= $lastDay; $x++) {
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

            $wd = whatDay($day);

            if ($day == 0 || $day == 6):
                if ($day == 0):
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
                else:
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
            endif;
            else:
                $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }
        $pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    }
} // end of female;



for ($blank = 1; $blank <= 2; $blank++) {
    $y++;
    if ($blank == 2):
        $pdf->MultiCell(50, 12, '<<<  FEMALE  | DAILY TOTAL   >>>', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $columnCount = 0;

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $columnCount++;
                    if ($x < 10):
                        $date = "0" . $x;
                    else:
                        $date = $x;
                    endif;
                $femaleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Female', $CI->uri->segment(5));
                $femaleDailyTotalAttendance += $femaleTotal;
                $pdf->MultiCell(7, 12, $femaleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            } else {
                if ($isHoliday):
                    $pdf->MultiCell(7, 12, '', ($y == 9 ? 'B' : 0), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                else:
                    $columnCount++;
                    if ($x < 10):
                        $date = "0" . $x;
                    else:
                        $date = $x;
                    endif;
                    $femaleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Female', $CI->uri->segment(5));
                    $femaleDailyTotalAttendance += $femaleTotal;
                    $pdf->MultiCell(7, 12, $femaleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            }
        }
    switch ($columnCount) {
        case 23:
            $columnCount = 22;
            break;
        case 24:

            $columnCount = 23;
            break;
        case 25:

            $columnCount = 24;
            break;
    }

    //absent
    $pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    $pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(70, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();
    else:
        $pdf->MultiCell(50, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $columnCount = 0;

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $columnCount++;

                    $pdf->MultiCell(7, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                endif;
            } else {
                if ($isHoliday):
                    $pdf->MultiCell(7, 12, '', ($y == 9 ? 'B' : 0), 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                else:
                    $columnCount++;

                    $pdf->MultiCell(7, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                    //lowerShades($pdf, 8, ((30.4)*0), -8, (30*0), 8, (30.4*0));
                endif;
            }
        }
    switch ($columnCount) {
        case 23:
            $columnCount = 22;
            break;
        case 24:

            $columnCount = 23;
            break;
        case 25:

            $columnCount = 24;
            break;
    }

    //absent
    $pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    //tardy
    $pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(70, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');
    $pdf->Ln();
    endif;


    if ($y == 9) {
        $y = 0;
        $pdf->AddPage();
        $pdf->SetY(55);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(50, 16.5, "LEARNER'S NAME
    (Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
        $pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
        $pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
    If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

        $pdf->Ln();
        $pdf->SetXY(53, 60.5);

        for ($x = $firstDay; $x <= $lastDay; $x++) {

            $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

            if ($day == 'Sat' || $day == 'Sun') {
                if ($isClass):
                    $pdf->MultiCell(7, 4.5, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
                endif;
            } else {
                $pdf->MultiCell(7, 4.5, "", 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
            }
        }

        $pdf->Ln();
        $pdf->SetXY(53, 66);
        for ($x = $firstDay; $x <= $lastDay; $x++) {
            $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
            $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

            $wd = whatDay($day);

            if ($day == 0 || $day == 6):
                if ($day == 0):
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
                else:
                    if ($isClass):
                        $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    endif;
            endif;
            else:
                $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        }
        $pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
    }
} // end of blank row;

$pdf->MultiCell(50, 12, '<< Combined TOTAL PER DAY >>', 1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$columnCount = 0;

for ($x = $firstDay; $x <= $lastDay; $x++) {

    $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
    $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

    if ($day == 'Sat' || $day == 'Sun') {
        if ($isClass):
            $columnCount++;
            if ($x < 10):
                $date = "0" . $x;
            else:
                $date = $x;
            endif;

        $maleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Male', $CI->uri->segment(5));
        $femaleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Female', $CI->uri->segment(5));
        $dT = $maleTotal + $femaleTotal;
        $dailyTotal += $dT;
        $pdf->MultiCell(7, 12, $maleTotal + $femaleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
        endif;
    } else {
        if ($isHoliday):
            $pdf->MultiCell(7, 12, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
        else:
            $columnCount++;
            if ($x < 10):
                $date = "0" . $x;
            else:
                $date = $x;
            endif;

            $maleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Male', $CI->uri->segment(5));
            $femaleTotal = Modules::run('attendance/getDailyTotalByGender', $year . '-' . $CI->uri->segment(4) . '-' . $date, $CI->uri->segment(3), 'Female', $CI->uri->segment(5));
            $dT = $maleTotal + $femaleTotal;
            $dailyTotal += $dT;
            $pdf->MultiCell(7, 12, $maleTotal + $femaleTotal, 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
            //lowerShades($pdf, 8, ((30.4)*0), -8, (30*0), 8, (30.4*0));
        endif;
    }
}
switch ($columnCount) {
    case 23:
        $columnCount = 22;
        break;
    case 24:

        $columnCount = 23;
        break;
    case 25:

        $columnCount = 24;
        break;
}

//absent
$pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
//tardy
$pdf->MultiCell(15, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(70, 12, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();

$pdf->AddPage();
$pdf->SetY(55);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(50, 16.5, "LEARNER'S NAME
    (Last Name, First Name, Middle Name) ", 1, 'C', 0, 0, '', '', true, 0, false, true, 17, 'M');
$pdf->MultiCell((7 * $ctt), 5, '(1st row for Date)', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 11, 'Total for the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 11, 'M');
$pdf->MultiCell(70, 16.5, 'REMARKS (If DROPPED OUT, state reason, please refer to legend number 2.
    If TRANSFERRED IN/OUT, write the name of School.)', 1, 'C', 0, 0, '', '', true, 0, false, true, 16.5, 'M');

$pdf->Ln();
$pdf->SetXY(53, 60.5);

for ($x = $firstDay; $x <= $lastDay; $x++) {

    $day = date('D', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
    $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));

    if ($day == 'Sat' || $day == 'Sun') {
        if ($isClass):
            $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
        endif;
    } else {
        $pdf->MultiCell(7, 4.5, $x, 1, 'C', 0, 0, '', '', true, 0, false, true, 4.5, 'M');
    }
}

$pdf->Ln();
$pdf->SetXY(53, 66);
for ($x = $firstDay; $x <= $lastDay; $x++) {
    $isClass = Modules::run('calendar/getSpecificDateEvent', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
    $isHoliday = Modules::run('calendar/isHoliday', date('Y-m-d', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x)));
    $day = date('w', strtotime($year . '-' . $CI->uri->segment(4) . '-' . $x));

    $wd = whatDay($day);

    if ($day == 0 || $day == 6):
        if ($day == 0):
            if ($isClass):
                $pdf->MultiCell(7, 5, "SU", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
        else:
            if ($isClass):
                $pdf->MultiCell(7, 5, "S", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
    endif;
    else:
        $pdf->MultiCell(7, 5, $wd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    endif;
}
$pdf->MultiCell(15, 5, 'Absent', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'Tardy', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


//footer
$data['maleTransferredOut'] = Modules::run('registrar/getStudentStatus', 1, 'Male', $CI->uri->segment(4), $CI->uri->segment(3));
$data['femaleTransferredOut'] = Modules::run('registrar/getStudentStatus', 1, 'Female', $CI->uri->segment(4), $CI->uri->segment(3));
$data['maleTransferredIn'] = Modules::run('registrar/getStudentStatus', 2, 'Male', $CI->uri->segment(4), $CI->uri->segment(3));
$data['femaleTransferredIn'] = Modules::run('registrar/getStudentStatus', 2, 'Female', $CI->uri->segment(4), $CI->uri->segment(3));
$data['maleDroppedOut'] = Modules::run('registrar/getStudentStatus', 3, 'Male', $CI->uri->segment(4), $CI->uri->segment(3));
$data['femaleDroppedOut'] = Modules::run('registrar/getStudentStatus', 3, 'Female', $CI->uri->segment(4), $CI->uri->segment(3));
$data['maleDailyTotalAttendance'] = $maleDailyTotalAttendance;
$data['femaleDailyTotalAttendance'] = $femaleDailyTotalAttendance;
$data['maleLateEnrollee'] = Modules::run('registrar/getLateEnrolleesByGender', 'Male');
$data['femaleLateEnrollee'] = Modules::run('registrar/getLateEnrolleesByGender', 'Female');
//if ($month != ""):
//    $data['numberOfSchoolDays'] = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $CI->uri->segment(4), $year);
//else:
//    $data['numberOfSchoolDays'] = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay);
//endif;
$data['numberOfSchoolDays'] = $ctt;
$data['year'] = $year;
$data['maleStudents'] = $male->num_rows();
$data['femaleStudents'] = $female->num_rows();
$data['femaleEoSY'] = $femaleEoSY->num_rows();
$data['maleEoSY'] = $maleEoSY->num_rows();
$data['pdf'] = $pdf;
$data['month'] = date("F", mktime(0, 0, 0, $CI->uri->segment(4), 10));
$data['adviser'] = Modules::run('academic/getAdvisory', '', $CI->uri->segment(3));
$data['Principal'] = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$this->load->view('form2footer', $data);



//upperShades($pdf);
//$pdf->Polygon(array(60,76.3,68,62,68,76.3), 'DF', array(222, 222, 222), array(222, 222, 222));
//$pdf->Polygon(array($LoLe,$btmL,$UR,$h,$loRi,$btmR), 'DF', array(222, 222, 222), array(222, 222, 222));
//Close and output PDF document
ob_start();
$pdf->Output('DepEd_Form2_' . $section->level . '-' . $section->section . '_' . $month . '.pdf', 'I');
$output = ob_get_contents();
ob_end_clean();
echo $output;


//============================================================+
// END OF FILE
//============================================================+
