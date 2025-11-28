<?php
class MYPDF extends Pdf
{

    //Page header
    public function Header()
    {
        // Logo
        $settings = Modules::run('main/getSet');


        if ($this->page == 1):
            //$this->SetTitle('Grading Sheet in '.$subject->subject);
            $this->SetTopMargin(4);
            $this->Ln(5);
            $this->SetX(10);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $this->Ln();
            $this->SetFont('helvetica', 'n', 8);
            $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetTitle(strtoupper($settings->short_name));
            $dateFrom = date('F d, Y', strtotime(segment_4));
            $dateTo = date('F d, Y', strtotime(segment_5));
            $image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
            $this->Image($image_file, 23, 6, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $this->Ln(10);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 4.3, "Payroll", 0, 0, 'C');
            $this->Ln(5);
            $this->Cell(0, 4.3, "[ " . $dateFrom . ' - ' . $dateTo . ' ]', 0, 0, 'C');

        endif;
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom

        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(400, 216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(30);
$pdf->setCellPaddings(1, 1, 1, 1);

// $charges = Modules::run('hr/payroll/getPayrollCharges', $pc_code);
$charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
$income = Modules::run('hr/payroll/getAdditionalIncome', $pc_code);
$defaults = Modules::run('hr/payroll/getPayrollDefaults', '0');
$pdefaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
$amortizedDeduction = Modules::run('hr/payroll/getAmortizedDeduction', $pc_code);
$countCharges = count($charges) + count($income);
switch ($countCharges):
    case 1:
        $columnWidth = 55;
        $fixedWidth = $columnWidth - 5;
        break;
    case 2:
        $columnWidth = 80 / $countCharges;
        $fixedWidth = $columnWidth - 5;
        break;
    case 3:
        $columnWidth = 130 / $countCharges;
        $fixedWidth = $columnWidth - 5;
        break;
    case 4:
        $columnWidth = 140 / $countCharges;
        $fixedWidth = $columnWidth - 5;
        break;
    case 5:
        $columnWidth = 160 / $countCharges;
        $fixedWidth = $columnWidth - 5;
        break;
    case 6:
        $columnWidth = 173 / $countCharges;
        $fixedWidth = $columnWidth - 5;
        break;
endswitch;

//variables

$salaryTotal = 0;
$sssTotal = 0;
$phTotal = 0;
$pagibigTotal = 0;
$tinTotal = 0;
$contTotal = 0;
$netTotal = 0;
$total = 0;
$totalOd = 0;
$totalNet = 0;
$overAllDeductibleTardy = 0;
$start = segment_4;
$end = segment_5;
$dateFrom = date('F d, Y', strtotime($start));
$dateTo = date('F d, Y', strtotime($end));


$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 10);
// set cell padding
$pdf->SetX(5);

$pdf->MultiCell(10, 12, '#', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(55, 12, 'NAME OF EMPLOYEE', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 12, 'POSITION', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 12, 'BASIC PAY', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
if ($income):
    foreach ($income as $additional):
        if ($additional->pi_item_type == 1):
            $pdf->MultiCell($columnWidth, 12, strtoupper($additional->pi_item_name), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    endforeach;
endif;
foreach ($charges as $deductions):
    $pdf->MultiCell($columnWidth, 12, strtoupper($deductions->pi_item_name), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
endforeach;

$pdf->MultiCell($fixedWidth, 12, 'OTHER DEDUCTIONS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 12, 'TOTAL DEDUCTIONS', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 12, 'NET PAY', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$i = 1;
$j = 1;
$td = 0;
$workdays = Modules::run('hr/getNumberOfDaysWork', $dateFrom, $dateTo);
$absent = 0;

$details = [];
$emp_info = [];
$emp_deduct = [];
$emp_earn = [];
foreach ($getPayrollReport as $pr):
    $j++;
    $em = Modules::run('hr/getEmployeeName', $pr->pmh_em_id);
    $getPayrollHours = Modules::run('hr/payroll/getPayrollReport', $pc_code, $pr->pmh_em_id);
    $st = date('d', strtotime($start));
    $en = date('d', strtotime($end));
    $ym = date('Y-m', strtotime($start));
    for ($a = $st; $a <= $en; $a++):
        $att = Modules::run('hr/payroll/attendanceCheck', $em->employee_id, ($ym . '-' . ($a < 10 ? '0' . $a : $a)));
        if ($att->num_rows() > 0):
            $td++;
        endif;
    endfor;

    $leaveDaysCredited = Modules::run('hr/payroll/getLeaveByDates', $start, $end, $em->employee_id);
    $dlCredited = 0; // leave days credited
    foreach ($leaveDaysCredited as $ldc):
        if ($ldc->pld_is_approved):
            $dlCredited += $ldc->pld_num_hours;
        endif;
    endforeach;
    $leave = $dlCredited / 8;

    $totalHoursRendered = 0;
    foreach ($getPayrollHours as $ph):
        $totalHoursRendered += $ph->pmh_num_hours;
    endforeach;

    if ($em->salary != 0):
        $officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $em->time_group_id);
        //print_r($officialTime);
        $officialTimeInAm = ($officialTime ? $officialTime->ps_from : '08:00:00');
        $officialTimeOutAm = ($officialTime ? $officialTime->ps_to : '12:00:00');
        $totalTimeMorning = round(abs(strtotime($officialTimeInAm) - strtotime($officialTimeOutAm)) / 60, 2);
        //        
        $officialTimeInPm = ($officialTime ? $officialTime->ps_from_pm : '13:00:00');
        $officialTimeOutPm = ($officialTime ? $officialTime->ps_to_pm : '17:00:00');
        $totalTimeAfternoon = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutPm)) / 60, 2);

        $lunchBreak = round(abs(strtotime($officialTimeInPm) - strtotime($officialTimeOutAm)) / 60, 2);
        $totalHoursReq = $totalTimeMorning + $totalTimeAfternoon;
        $totalHoursReq = ($totalHoursReq >= 450 ? 480 : $totalHoursReq);
        $hrs = $totalHoursReq / 60;

        $lc = Modules::run('hr/payroll/getTotalLeaveSpent', $em->employee_id, 1, $pc_code);

        $absent = 0;
        $otherDeduction = 0;

        switch ($em->pg_id):
            case 1: // ---------------Monthly Type ---------------------//
                $basic = $em->salary;
                $hourly = ($basic / $workdays) / $hrs;
                $daily = $hourly * $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 2: // -------------- Semi Monthly Type
                $basic = $em->salary / 2;
                $hourly = ($basic / $workdays) / $hrs;
                $daily = $hourly * $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 3: // -------------- Weekly type ---------------------//
                $basic = $em->salary;
                $daily = $basic / 5;
                $hourly = $daily / $hrs;
                $salary = $totalHoursRendered * $hourly;
                break;
            case 4: // ------------ Daily Type ----------------------//
                $hourly = ($em->salary / $hrs);
                $basic = $employee->salary;
                $daysRendered = $totalHoursRendered / $hrs;
                $salary = $basic * $daysRendered;
                break;
            case 5: // ------------ Hourly type ---------------------//
                $hourly = $em->salary;
                $salary = $totalHoursRendered * $hourly;
                break;
        endswitch;
        // $days = Modules::run('hr/hrdbprocess/getPayrollTimes', $em->user_id, $start, $end, $em->time_group_id);
        // $days = json_decode($days);

        // $totalHourTardy = round($hourly * ($days->undertime / 60), 2, PHP_ROUND_HALF_UP);

        // $absent = $workdays - $td;
        // if ($absent > 0):
        //     $absInHrs = $absent * $hrs;
        //     if ($lc):
        //         $absRem = abs($lc->l_num_hours - $absInHrs);
        //     else:
        //         $absRem = $absInHrs;
        //     endif;
        //     $otherDeduction += ($absRem * $hourly);
        // else:
        //     $absRem = 0;
        // endif;

        // $otherDeduction += $totalHourTardy;

        $absent = ($workdays * 8) - $totalHoursRendered - ($leave * 8);

        if ($absent > 0):
            $otherDeduction += ($absent * $hourly);
        else:
            $absInHrs = 0;
        endif;
        $name = $em->firstname . ' ' . $em->lastname;
        array_push($emp_info, $name, $em->position, $basic, $em->employee_id, $em->department, $totalHoursRendered, $leave, $hourly);

        $pdf->SetX(5);
        $pdf->MultiCell(10, 5, $i++, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(55, 5, $em->firstname . ' ' . $em->lastname, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 5, $em->position, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(30, 5, number_format(($basic), 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $totalStat = 0;
        $addOn = 0;
        $items = 1;
        foreach ($income as $additional):
            if ($additional->pi_item_type == 1):
                $add = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, $pc_code, $em->user_id);
                if (!empty($add->row())):
                    $addOn += $add->row()->pc_amount;
                else:
                    if ($additional->pi_item_cat == 2):
                        $addB = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, ($pc_code - 1), $employee->user_id);
                        if (!empty($addB->row())):
                            $addOn += $addB->row()->pc_amount;
                            Modules::run('hr/payroll/setPayrollCharges', $employee->user_id, $additional->pi_item_id, $addOn, $pc_code, 0);
                        else:
                            $addOn += 0;
                        endif;
                    endif;
                endif;
                $pdf->MultiCell($columnWidth, 5, number_format($addOn, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                array_push($emp_earn, [$add->row()->pi_item_name, $add->row()->pc_amount]);
            endif;
        endforeach;
        foreach ($charges as $deductions):
            $items++;
            $charge = Modules::run('hr/payroll/getPayrollChargesByItem', $deductions->pc_item_id, $pc_code, $em->user_id);
            $amount = ($charge != NULL ? $charge->row()->pc_amount : 0);
            if ($charge->row()):
                $pdf->MultiCell($columnWidth, 5, number_format(($amount != '' ? $amount : 0), 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                if ($charge != NULL):
                    if ($charge->row()->pi_item_type == 1):
                        $addOn += $amount;
                    else:
                        $totalStat += $amount;
                    endif;
                endif;
            else:
                $pdf->MultiCell($columnWidth, 5, '0.00', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
            array_push($emp_deduct, [$charge->row()->pi_item_name, $charge->row()->pc_amount]);
        endforeach;

        $netPayLessDeduction = ($basic + $addOn) - ($otherDeduction);
        $totalNet = (($netPayLessDeduction) - ($totalStat));

        $pdf->MultiCell($fixedWidth, 5, number_format($otherDeduction, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell($fixedWidth, 5, number_format(($otherDeduction + $totalStat), 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell($fixedWidth, 5, number_format($totalNet, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $td = 0;

        $totalNetPay += $basic;
        $addOnTotal += $addOn;
        $statTotal += $totalStat;
        $totalOD += ($otherDeduction + $totalStat);
        $totalTardy += $otherDeduction;
        unset($addOn);
        unset($totalStat);
        unset($expectedPerHourRate);
        $items = 1;
        $otherDeduction = 0;
    endif;
    if ($j == 24):
        $pdf->AddPage();
        $pdf->SetY(40);
        $j = 0;
    endif;
    array_push($details, [$emp_info, $emp_earn, $emp_deduct]);
    $emp_info = [];
    $emp_earn = [];
    $emp_deduct = [];
endforeach;

$pdf->SetFont('helvetica', 'B', 10);
// set cell padding
$pdf->SetX(5);
$pdf->MultiCell(115, 5, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 5, number_format($totalNetPay, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$totalNetPayroll = (($totalNetPay + $addOnTotal) - ($totalOD));

if ($income):
    foreach ($income as $additional):
        if ($additional->pi_item_type == 1):
            $add = Modules::run('hr/payroll/getPayrollChargesByItem', $additional->pi_item_id, $pc_code, null);
            foreach ($add->result() as $a):
                $tincome += $a->pc_amount;
            endforeach;

            $pdf->MultiCell($columnWidth, 5, number_format($addOnTotal, 2), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endif;
    endforeach;
endif;

foreach ($charges as $deductions):
    $charge = Modules::run('hr/payroll/getPayrollChargesByItem', $deductions->pc_item_id, $pc_code, null);
    foreach ($charge->result() as $c):
        $tamount += $c->pc_amount;
    endforeach;
    $amount = ($charge != NULL ? $tamount : 0);
    $pdf->MultiCell($columnWidth, 5, number_format($amount, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    unset($tamount);
endforeach;

$pdf->MultiCell($fixedWidth, 5, number_format($totalTardy, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 5, number_format($totalOD, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 5, number_format($totalNetPayroll, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();



// $charges = Modules::run('hr/payroll/getCurrentListOfCharges', $pc_code);
// $income = Modules::run('hr/payroll/getAdditionalIncome', $pc_code);
// $defaults = Modules::run('hr/payroll/getPayrollDefaults', '0');
// $pdefaults = Modules::run('hr/payroll/getPayrollDefaults', $paySched);
// $amortizedDeduction = Modules::run('hr/payroll/getAmortizedDeduction', $pc_code);

$pdf->AddPage('P');
$data['pdf'] = $pdf;
$data['payrollReport'] = $getPayrollReport;
$data['pc_code'] = $pc_code;
$data['start'] = $start;
$data['end'] = $end;
$data['charges'] = $charges;
$data['income'] = $income;
$data['defaults'] = $defaults;
$data['pdefaults'] = $pdefaults;
$data['amortizedDeduction'] = $amortizedDeduction;
$data['workdays'] = $workdays;
$data['details'] = $details;
$this->load->view('payroll/payslip', $data);


//Close and output PDF document
$pdf->Output('Payroll.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
