<?php

$core_val = Modules::run('reports/getCoreValues');

$pdf->SetFont('Roboto', 'B', 15);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(10);
$pdf->MultiCell(130, 10, 'CORE VALUES', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '1', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '2', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '3', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(15, 10, '4', 1, 'C', 1, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

foreach ($core_val as $cv):
    $pdf->SetFont('Roboto', 'B', 12);
    $pdf->SetX(10);
    $pdf->SetTextColor(0, 100, 0);
    $pdf->MultiCell(40, 28, $cv->core_values, 1, 'C', 0, 0, '', '', true, 0, false, true, 28, 'M');
    $bhRate = Modules::run('reports/getBhRate', $cv->core_id);
    foreach ($bhRate as $bh):
        $pdf->SetFont('Helvetica', 'R', 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(90, ($bh->bh_group == 3 ? 28 : 14), $bh->bh_name, 1, 'C', 0, 0, '', '', true, 0, false, true, ($bh->bh_group == 3 ? 28 : 14), 'M');
        $pdf->MultiCell(15, ($bh->bh_group == 3 ? 28 : 14), '', 1, 'C', 0, 0, '', '', true, 0, false, true, ($bh->bh_group == 3 ? 28 : 14), 'M');
        $pdf->MultiCell(15, ($bh->bh_group == 3 ? 28 : 14), '', 1, 'C', 0, 0, '', '', true, 0, false, true, ($bh->bh_group == 3 ? 28 : 14), 'M');
        $pdf->MultiCell(15, ($bh->bh_group == 3 ? 28 : 14), '', 1, 'C', 0, 0, '', '', true, 0, false, true, ($bh->bh_group == 3 ? 28 : 14), 'M');
        $pdf->MultiCell(15, ($bh->bh_group == 3 ? 28 : 14), '', 1, 'C', 0, 0, '', '', true, 0, false, true, ($bh->bh_group == 3 ? 28 : 14), 'M');
        $pdf->Ln();
        $pdf->SetX(50);
    endforeach;
endforeach;
$pdf->SetX(2);
$pdf->SetFont('Roboto', 'B', 15);
$pdf->MultiCell(51, 8, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(105, 8, 'Performance Code for the Observed Values', 'B', 'C', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln(10);

$pdf->SetTextColor(0, 100, 0);
$pdf->SetX(20);
$pdf->MultiCell(60, 8, 'AO - Always Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(40, 8, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(70, 8, 'SO - Sometimes Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln(7);

$pdf->SetX(20);
$pdf->MultiCell(60, 8, 'RO - Rarely Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(40, 8, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->MultiCell(70, 8, 'NO - Not Observed', 0, 'L', 0, 0, '', '', true, 0, false, true, 8, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->SetFont('Roboto', 'B', 12);
$pdf->MultiCell(35, 7, 'ATTENDANCE',1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
$x = 7;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    endif;
    $pdf->MultiCell(13, 7,date("M",mktime(0,0,0,$m,1,2000)) ,1, 'C', 1, 0, '', '', true, 0, false, true, 7, 'M');
}
$pdf->MultiCell(15, 7, 'TOTAL',1,'C' , 1, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 7, 'Days of School',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$x = 7;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $month = date("F", mktime(0, 0, 0, $m, 10));
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
    $totalDays += $totalDaysInAMonth;
    $pdf->MultiCell(13, 7,$totalDaysInAMonth ,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
}

$pdf->MultiCell(15, 7, $totalDays,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $student->st_id, $student->grade_id, $sy);
$pdf->SetX(15);
$pdf->MultiCell(35, 7, 'Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$x = 7;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
        endif;
    else:
        $schoolYear = $sy;
    endif;
    
    $monthName = date('F', mktime(0, 0, 0, $m, 10));
    
    $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'first');
    $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, $m, 10)), $schoolYear, 'last');
    $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, $m, $schoolYear);
    $holiday = Modules::run('calendar/holidayExist', $m, $schoolYear);
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            endif;
     if($pdays>$totalDaysInAMonth):
         $pdays = $totalDaysInAMonth;
     endif;
     
     $pdf->MultiCell(13, 7, ($attendance->$monthName != '' ? $attendance->$monthName : ''),1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');  
         
    $total_pdays += $attendance->$monthName;
    $pdays = 0;
}
$pdf->MultiCell(15, 7, $total_pdays,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->MultiCell(35, 7, 'Days Absent',1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$tardy = 0;
for($d=1;$d<=10;$d++){
    $m = $d+$x;
    if($m<10):
        $m = '0'.$m;
    endif;
    if($m>12):
        $n = $m;
        $schoolYear = $sy+1;
        $m = $m - 12;
        if($m<10):
            $m = '0'.$m;
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
    $totalDaysInAMonth = $schoolDays-$holiday->num_rows();
            if($this->session->userdata('attend_auto')):
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, $m, $schoolYear, $sy);
            else:    
                $pdays = Modules::run('attendance/getIndividualMonthlyAttendance', $student->uid, $m, $schoolYear, $sy);
            endif;
            
     if($pdays>$totalDaysInAMonth):
         $pdays = $totalDaysInAMonth;
     else:
         $pdays = $attendance->$monthName;
     endif;
    
     $pdf->MultiCell(13, 7, ($totalDaysInAMonth-$pdays),'BR', 'C', 0, 0, '', '', true, 0, false, true, 7, 'M'); 
         
    $total_adays += ($totalDaysInAMonth-$pdays);
    $pdays = 0;
}
$pdf->MultiCell(15, 7, $total_adays,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(15);

$pdf->SetLineStyle(array('width' => 1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(131, 139, 139)));
$pdf->RoundedRect(15, 193, 90, 97, 10, '1111', '');

$pdf->SetX(15);
$pdf->SetFont('Roboto', 'B', 15);
$pdf->MultiCell(90, 10, 'CERTIFICATE OF TRANSFER',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(15);
$pdf->SetFont('Roboto', '', 13);
$pdf->MultiCell(90, 10, 'Eligible for admission to',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->MultiCell(15, 7, 'Level:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(48, 7,'' ,'B' , 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->MultiCell(13, 7, 'Date:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(50, 7,'' ,'B' , 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(20);

$pdf->SetX(15);
$pdf->MultiCell(90, 10, 'EMELIE L. LAMBIO',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetX(15);
$pdf->SetFont('Roboto', 'B', 10);
$pdf->MultiCell(90, 10, 'School Registrar',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(20);

$pdf->SetX(15);
$pdf->SetFont('Roboto', '', 13);
$pdf->MultiCell(90, 10, 'MENAHLIE L. ESCAL',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(5);

$pdf->SetX(15);
$pdf->SetFont('Roboto', 'B', 10);
$pdf->MultiCell(90, 10, 'School Head',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetXY(125,193);
$pdf->SetFont('Roboto', '', 15);
$pdf->MultiCell(60, 15, 'Parent / Guardian\'s Signature',0, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln();

$pdf->SetX(110);
$pdf->MultiCell(20, 12, '1st Qtr.',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(62, 12, '','B' , 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(20);

$pdf->SetX(110);
$pdf->MultiCell(22, 12, '2nd Qtr.',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(60, 12, '','B' , 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(20);

$pdf->SetX(110);
$pdf->MultiCell(22, 12, '3rd Qtr.',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(60, 12, '','B' , 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln(20);

$pdf->SetX(110);
$pdf->MultiCell(22, 12, '4th Qtr.',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->MultiCell(60, 12, '','B' , 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');