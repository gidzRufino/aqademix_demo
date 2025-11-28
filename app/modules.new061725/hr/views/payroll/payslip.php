<?php
$pdf->Line(108, 5, 108, 1, array('color' => 'black'));
// $pdf->MultiCell(216, 5, count($details), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->SetFont('helvetica', 'R', 10);
$a = 0;
$x = 0;
$y = 0;
$earn = 0;
$deduct = 0;
for ($b = 0; $b < count($details); $b++):
    $name = $details[$b][0][0];
    $position = $details[$b][0][1];
    $basic = $details[$b][0][2];
    $emp_id = $details[$b][0][3];
    $department = $details[$b][0][4];
    $hoursRendered = $details[$b][0][5];
    $leave = $details[$b][0][6];
    $hourly = $details[$b][0][7];
    $otherDeduction = 0;

    $absent = ($workdays * 8) - $hoursRendered - ($leave * 8);
    if ($absent > 0):
        $otherDeduction += ($absent * $hourly);
    else:
        $otherDeduction += 0;
    endif;

    $a++;
    switch ($a):
        case 1:
            $x = 5;
            $y = 5;
            break;
        case 2:
            $x = 113;
            $y = 5;
            break;
        case 3:
            $x = 5;
            $y = 195;
            break;
        case 4:
            $x = 113;
            $y = 195;
    endswitch;

    $pdf->SetXY($x, $y);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->MultiCell(20, 5, '', 'LT', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, 'Payslip', 'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, '', 'TR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(20, 5, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(60, 5, "[ " . date('M d, Y', strtotime($start)) . ' - ' . date('M d, Y', strtotime($end)) . ' ]', 'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, '', 'RB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(100, 5, '', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'R', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Name of Employee: ' . ucwords(strtolower($name)), 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Employee ID: ' . $emp_id, 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Position: ' . $position, 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(95, 5, 'Department: ' . $department, 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(100, 5, '', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFillColor(219, 229, 241);
    $pdf->SetFont('helvetica', 'B', 10);

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(90, 5, 'Earnings', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Description', 1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Amount', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'R', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Basic Pay', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, number_format($basic, 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $earn += $basic;

    for ($c = 0; $c < count($details[$b][1]); $c++):
        if ($details[$b][1][$c][0] != ''):
            $earn += $details[$b][1][$c][1];
            $pdf->SetX($x);
            $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, $details[$b][1][$c][0], 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, number_format($details[$b][1][$c][1], 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
    endfor;

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Total Earnings', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, number_format($earn, 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(90, 5, 'Deductions', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    // print_r($details[$b][2][0][0]);

    $pdf->SetFont('helvetica', 'R', 10);
    for ($d = 0; $d < count($details[$b][2]); $d++):
        if ($details[$b][2][$d][0] != ''):
            $deduct += $details[$b][2][$d][1];
            $pdf->SetX($x);
            $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, $details[$b][2][$d][0], 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(45, 5, number_format($details[$b][2][$d][1], 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->Ln();
        endif;
    endfor;

    if ($otherDeduction != 0):
        $pdf->SetX($x);
        $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(90, 5, 'Other Deductions', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->SetX($x);
        $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(45, 5, 'Absent/Undertime', 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(45, 5, number_format($otherDeduction, 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $deduct += $otherDeduction;
    endif;

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Total Deductions', 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, number_format($deduct, 2), 1, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, 'Net Pay', 'LB', 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(45, 5, number_format(($earn - $deduct), 2), 'RB', 'R', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(100, 5, '', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'R', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, 'Prepared By: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, '', 'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(100, 5, '', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetFont('helvetica', 'R', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(5, 5, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(25, 5, 'Approved By: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(55, 5, '', 'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->MultiCell(100, 5, '', 'LBR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();

    unset($deduct);
    unset($earn);
    if ($a == 4):
        $pdf->AddPage();
        $a = 0;
    endif;
endfor;
