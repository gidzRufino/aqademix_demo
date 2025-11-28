<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


        $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
        
        $top= array(
                'borders' => array(
                    'top' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
         );

$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);        
        
$this->excel->getActiveSheet()->setTitle('Payroll '.(date('M', strtotime($startDate))).' '.(date('d', strtotime($startDate))).' - '.(date('d', strtotime($endDate))).', '.(date('Y', strtotime($startDate))));
$this->excel->getActiveSheet()->setCellValue('A1', 'PAYROLL');
$this->excel->getActiveSheet()->mergeCells('A1:M1');
$this->excel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$this->excel->getActiveSheet()->setCellValue('A2', 'For the period '.(date('M', strtotime($startDate))).' '.(date('d', strtotime($startDate))).' - '.(date('d', strtotime($endDate))).', '.(date('Y', strtotime($startDate))));
$this->excel->getActiveSheet()->mergeCells('A2:M2');
$this->excel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$this->excel->getActiveSheet()->setCellValue('B4', 'NAME');
$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('C4', 'GROSS PAY');
$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('D3', 'SSS');
$this->excel->getActiveSheet()->mergeCells('D3:E3');
$this->excel->getActiveSheet()->getStyle('D3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D3:E3')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('F3', 'PAG-IBIG');
$this->excel->getActiveSheet()->mergeCells('F3:G3');
$this->excel->getActiveSheet()->getStyle('F3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('F3:G3')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('D4', 'PREMIUM');
$this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('D4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('E4', 'LOAN');
$this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('E4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('F4', 'PREMIUM');
$this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('F4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('G4', 'LOAN');
$this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('G4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('H4', 'PHIC');
$this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('I4', 'W/H Tax');
$this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('J4', 'Uniform');
$this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('J4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('K4', 'LAPTOP LOAN');
$this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('K4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('L4', 'NET');
$this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('L4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('M4', 'ADJUSTMENT');
$this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('M4')->applyFromArray($styleArray);

$this->excel->getActiveSheet()->setCellValue('N4', 'TOTAL');
$this->excel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->excel->getActiveSheet()->getStyle('N4')->applyFromArray($styleArray);


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
$in = 4;


foreach($getPayrollReport as $pr):
    
    if($pr->salary!=0):
        $in++;
            switch ($paymentSchedule->monthly):
                case 0:
                    $over = 2;
                    break;
                case 1:
                    $over = 1;
                    break;
                case 2:
                    $over = 4;
                    break;
            endswitch;
            
            
            $firstDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($startDate)), 10)), date('Y', strtotime($startDate)), 'first');
            $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($endDate)), 10)), date('Y', strtotime($endDate)), 'last');
//            $firstDayName = date('D',  strtotime('first Day of '.date("F", mktime(0, 0, 0, segment_4, 10)).' '.date('Y', strtotime($startDate))));
            
            $schoolDays = Modules::run('main/getNumberOfSchoolDays', $firstDay, $lastDay, date('m', strtotime($startDate)), date('Y', strtotime($startDate)));
            
            //calculation of the Basic Pay and the benefits
             $workdays = $hrdb->count_workdays($startDate, $endDate);
            $salary = number_format(($pr->salary), 2, '.', ',');
            
            $expectedHours = $workdays * 8;
            $days = Modules::run('hr/hrdbprocess/getPayrollTimes', $pr->user_id, $startDate, $endDate, $pr->time_group_id);
            $days = json_decode($days);
            
            $totalDailySalary = round(($pr->salary/30),2)*$days->present;
            $daysAbsent = $workdays - $days->present;
            $deductableAbsences = round(($pr->salary/30),2)*$daysAbsent;
            //use this if exact deduction
            
            $totalDeductibleTardy = round(($pr->salary/30/8/60)*$days->undertime, 2)+$deductableAbsences;
            $totalDeductibleTardy = ($pr->pay_type?0:$totalDeductibleTardy);
            $netpay = ($pr->salary/$over);
            
            $netpayLessTardy = $netpay-$totalDeductibleTardy;
            
            $totalPH += ($netpayLessTardy*.01375);
            $totalPI += ($netpayLessTardy*.02);
            
            $pagIbigLoan = Modules::run('hr/payroll/getPayrollChargesByItem', 6, $pc_code, $pr->employee_id);
            $totalPIL += $pagIbigLoan->pc_amount;
            
            $wTax = Modules::run('hr/payroll/getPayrollChargesByItem', 4, $pc_code, $pr->employee_id);
            $totalTax += $wTax->pc_amount;
            
            $sssPremium = Modules::run('hr/payroll/getPayrollChargesByItem', 1, $pc_code, $pr->employee_id);
            $totalSSSP += $sssPremium->pc_amount;
            
            $sssLoan = Modules::run('hr/payroll/getPayrollChargesByItem', 5, $pc_code, $pr->employee_id);
            $totalSSSL += $sssLoan->pc_amount;
            
            $uniform = Modules::run('hr/payroll/getPayrollChargesByItem', 7, $pc_code, $pr->employee_id);
            $totalUniform += $uniform->pc_amount;
            
            $laptop = Modules::run('hr/payroll/getPayrollChargesByItem', 8, $pc_code, $pr->employee_id);
            $totalLaptop += $laptop->pc_amount;
            
            $adjustment = Modules::run('hr/payroll/getPayrollChargesByItem', 11, $pc_code, $pr->employee_id);
            $totalAdjustment += $adjustment->pc_amount;
            
            $totalStatBen = ($netpayLessTardy*.02)+($netpayLessTardy*.01375)+($sssPremium->pc_amount+$sssLoan->pc_amount)+($uniform->pc_amount+$laptop->pc_amount);
            
            $totalNetPayroll += ($netpayLessTardy-$totalStatBen);
                        
            $this->excel->getActiveSheet()->setCellValue('B'.$in, strtoupper($pr->lastname.', '.$pr->firstname));
            
            $this->excel->getActiveSheet()->setCellValue('C'.$in, number_format($netpay,2,'.',','));
            $this->excel->getActiveSheet()->getStyle('C'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('D'.$in, number_format($sssPremium->pc_amount,2,'.',','));
            $this->excel->getActiveSheet()->getStyle('D'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('E'.$in, number_format($sssLoan->pc_amount,2,'.',','));
            $this->excel->getActiveSheet()->getStyle('E'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('F'.$in, number_format(($netpayLessTardy*.02), 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('F'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('G'.$in, number_format($pagIbigLoan, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('G'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('H'.$in, number_format(($netpayLessTardy*.01375), 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('H'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('I'.$in, number_format($wTax, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('I'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('J'.$in, number_format($uniform->pc_amount, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('J'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('K'.$in, number_format($laptop->pc_amount, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('K'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('L'.$in, number_format(($netpayLessTardy-$totalStatBen), 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('L'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('M'.$in, number_format($adjustment->pc_amount, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('M'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('N'.$in, number_format((($netpayLessTardy-$totalStatBen)-$adjustment->pc_amount), 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('N'.$in)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        
    
    endif;
endforeach;
            

            $this->excel->getActiveSheet()->setCellValue('D'.($in+1), number_format($totalSSSP, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('D'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $this->excel->getActiveSheet()->setCellValue('E'.($in+1), number_format($totalSSSL, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('E'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('F'.($in+1), number_format($totalPI, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('F'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('G'.($in+1), number_format($totalPIL, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('G'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('H'.($in+1), number_format($totalPH, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('H'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('I'.($in+1), number_format($totalTax, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('I'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('J'.($in+1), number_format($totalUniform, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('J'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('K'.($in+1), number_format($totalLaptop, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('K'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('L'.($in+1), number_format($totalNetPayroll, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('L'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('M'.($in+1), number_format($totalAdjustment, 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('M'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            $this->excel->getActiveSheet()->setCellValue('N'.($in+1), number_format(($totalNetPayroll-$totalAdjustment), 2, '.', ','));
            $this->excel->getActiveSheet()->getStyle('N'.($in+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            
            
            $this->excel->getActiveSheet()->getStyle('B'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('C'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('D'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('E'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('F'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('G'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('H'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('I'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('J'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('K'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('L'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('M'.($in+1))->applyFromArray($top);
            $this->excel->getActiveSheet()->getStyle('N'.($in+1))->applyFromArray($top);