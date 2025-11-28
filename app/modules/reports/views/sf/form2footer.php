<?php

$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln(10);
$pdf->MultiCell(125, 5, 'Guidelines:', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->MultiCell(125, 10, "1. The attendance shall be accomplished daily. Refer to the codes for checking learners' attendance.", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'B');

$pdf->Ln();
$pdf->MultiCell(150, 5, "2. Dates shall be written in the preceding columns beside Learner's Name.", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(150, 5, "3. To compute the following:", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 10, "a. Percentage of Enrollment = ", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 5, "Registered Learner as of End of the Month", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 10, "x 100", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "Enrolment as of 1st Friday of June", 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(20, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 10, "b. Average Daily Attendance =  ", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 5, "Total Daily Attendance", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 10, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "Number of School Days in reporting month", 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(20, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 10, "c. Percentage of Attendance for the month =  ", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 5, "Average daily attendance", 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 10, "x 100", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(4);
$pdf->MultiCell(5, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, "Registered Learner as of End of the month", 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(20, 5, "", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');


//$pdf->MultiCell(75, 5, "3. To compute the following:",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->MultiCell(150, 10, "4. Every End of the month, the teacher/adviser submit this form to the office of the principal for recording of 
    summary table into the Form 3. Once signed by the principal, this form should be returned to the adviser.", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->Ln(8);
$pdf->MultiCell(150, 5, "5. Attendance performance of learner is expected to reflect in Form 137 and Form 138 every grading period", 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(4);
$pdf->MultiCell(150, 10, "* Beginning of School Year cut-off report is every 1st Friday of School Calendar Days", 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetXY(130, 75);
$pdf->MultiCell(75, 5, '1. CODES FOR CHECKING ATTENDANCE', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 10, 'blank- Present;   (x)- Absent; Tardy (half shaded= Upper for Late Commer, Lower for Cutting Classes)', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln(8);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "2. REASONS/CAUSES OF DROP-OUTS.", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "a. Domestic-Related Factors", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "a.1. Had to take care of siblings", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "a.2. Early marriage/pregnancy", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "a.3. Parents' attitude toward schooling", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 10, "a.4. Family problems", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(8);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b. Individual-Related Factors", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.1. Illness", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.2. Overage", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.2. Death", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.2. Drug Abuse", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.4. Poor Academic Performance", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "b.5. Lack of interest/Distractions", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 10, "b.7. Hunger/Malnutrition", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(8);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "c. School-Related Factors", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "c.1. Teacher Factor", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "c.2. Physical condition of classroom", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 10, "c.3. Peer influence", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(8);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "d. Geographic/Environmental", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "d.1. Distance between home and school", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "d.2. Armed conflict (incl. Tribal wars & clan feuds)", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "d.3. Calamities/Disasters", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "e. Financial-Related", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "e.1. Child labor, work", 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(130);
$pdf->MultiCell(75, 5, "f. Others", 'LBR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$holiday = Modules::run('calendar/holidayExist', segment_4, $year);
$pdf->setXY(208, 75);
$pdf->MultiCell(15, 5, 'Month:', 'LT', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 5, $month, 'LT', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(30, 5, 'Number of 
    Days Classes ', 'LTR', 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(10, 5, ($numberOfSchoolDays - $holiday->num_rows()), 'LTR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(36, 5, 'Summary of the Month', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(15, 5, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'M', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'F', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$pdf->MultiCell(80, 5, '* Enrolment  as of  (1st Friday of June)', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleStudents, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleStudents, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleStudents + $femaleStudents, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$pdf->MultiCell(80, 5, 'Late Enrollment (beyond cut-off)', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleLateEnrollee->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleLateEnrollee->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleLateEnrollee->num_rows() + $femaleLateEnrollee->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$maleRegisteredEnd = $maleStudents - $maleEoSY;
$femaleRegisteredEnd = $femaleStudents - $femaleEoSY;
$sumEnd = $maleRegisteredEnd + $femaleRegisteredEnd;
$pdf->MultiCell(80, 5, 'Registered Learner as of end of the month', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleRegisteredEnd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleRegisteredEnd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $sumEnd, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$malePercentageEnd = ($maleRegisteredEnd / $maleStudents) * 100;
$femalePercentageEnd = ($femaleRegisteredEnd / $femaleStudents) * 100;
$sumPercentEnd = ($malePercentageEnd + $femalePercentageEnd) / 2;
$pdf->MultiCell(80, 5, 'Percentage of Enrolment as of end of the month', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($malePercentageEnd, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($femalePercentageEnd, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($sumPercentEnd, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$maleTotalDaily = ($maleDailyTotalAttendance / ($numberOfSchoolDays - $holiday->num_rows()));
$femaleTotalDaily = ($femaleDailyTotalAttendance / ($numberOfSchoolDays - $holiday->num_rows()));
$sumTotalDaily = $maleTotalDaily + $femaleTotalDaily;
$pdf->MultiCell(80, 5, 'Average Daily Attendance', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($maleTotalDaily, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($femaleTotalDaily, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($sumTotalDaily, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->setX(208);
$maleMonthlyPercentage = (round($maleTotalDaily, 2) / $maleRegisteredEnd) * 100;
$femaleMonthlyPercentage = (round($femaleTotalDaily, 2) / $femaleRegisteredEnd) * 100;
$sumMonthlyPercentage = ($maleMonthlyPercentage + $femaleMonthlyPercentage) / 2;


if ($this->session->userdata('attend_auto')):
    Modules::run('attendance/saveMonthlyAttendanceSummary', segment_4, segment_3, $maleRegisteredEnd, $femaleRegisteredEnd, round($maleTotalDaily), round($femaleTotalDaily), $maleMonthlyPercentage, $femaleMonthlyPercentage, 1, $year);
else:
    Modules::run('attendance/saveMonthlyAttendanceSummary', segment_4, segment_3, $maleRegisteredEnd, $femaleRegisteredEnd, round($maleTotalDaily), round($femaleTotalDaily), $maleMonthlyPercentage, $femaleMonthlyPercentage, 0, $year);
endif;
$pdf->MultiCell(80, 5, 'Percentage of Attendance for the month ', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($maleMonthlyPercentage, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($femaleMonthlyPercentage, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, round($sumMonthlyPercentage, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(80, 5, 'Number of students with 5 consecutive days of absences:', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(80, 5, 'Drop out', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleDroppedOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleDroppedOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleDroppedOut->num_rows() + $femaleDroppedOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(80, 5, 'Transferred out', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleTransferredOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleTransferredOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleTransferredOut->num_rows() + $femaleTransferredOut->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(80, 5, 'Transferred in', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleTransferredIn->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $femaleTransferredIn->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(12, 5, $maleTransferredIn->num_rows() + $femaleTransferredIn->num_rows(), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$name = $Principal->firstname . ' ' . $Principal->lastname;

$adv = $adviser->row()->firstname . ' ' . $adviser->row()->lastname;

$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 10, 'I certify that this is a true and correct report:.', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 10, strtoupper($adv), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 5, '(Signature of Teacher over Printed Name)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 10, 'Attested By:', 0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 10, strtoupper($name), 'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->SetFont('helvetica', 'N', 7);
$pdf->Ln();
$pdf->setX(208);
$pdf->MultiCell(116, 5, '(Signature of School Head over Printed Name)', 0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


