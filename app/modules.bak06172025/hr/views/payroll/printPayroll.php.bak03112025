<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                
                
                if($this->page==1):
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
                    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                    $this->Image($image_file, 23, 6, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                    $this->Ln(10);
                    $this->SetFont('helvetica', 'B', 12);
                    $this->Cell(0,4.3,"Payroll ",0,0,'C');
                    $this->Ln(5); 
                    $this->Cell(0,4.3,"[ ".$dateFrom.' - '.$dateTo.' ]',0,0,'C');
                    
                endif;
                
                
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(400,216);
$pdf->AddPage('L', $resolution);

$pdf->SetY(30);
$pdf->setCellPaddings(1, 1, 1, 1);

$charges = Modules::run('hr/payroll/getPayrollCharges', $pc_code);
$countCharges = count($charges);
switch ($countCharges):
    case 2:
        $columnWidth = 150/$countCharges;
        $fixedWidth = $columnWidth - 5;
    break;   
    case 3:
        $columnWidth = 120/$countCharges;
        $fixedWidth = $columnWidth - 5;
    break;   
    case 4:
        $columnWidth = 140/$countCharges;
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

$pdf->Ln(10);
$pdf->SetFont('helvetica', 'N', 10);
// set cell padding
$pdf->SetX(5);
$pdf->MultiCell(10, 12, '#',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(70, 12, 'NAME OF EMPLOYEE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(50, 12, 'POSITION',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 12, 'BASIC PAY',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        foreach($charges as $deductions): 
            $pdf->MultiCell($columnWidth, 12, strtoupper($deductions->pi_item_name),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        endforeach;

$pdf->MultiCell($fixedWidth, 12, 'OTHER DEDUCTIONS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 12, 'TOTAL DEDUCTIONS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 12, 'NET PAY',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$i = 1;
foreach($getPayrollReport as $pr):
    
        if($pr->salary!=0):   
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
            
            
            $salary = number_format(($pr->salary), 2, '.', ',');
            $expectedHours = ($workdays * 8)-4;
            $days = Modules::run('hr/hrdbprocess/getPayrollTimes', $pr->user_id, $startDate, $endDate);
            $days = json_decode($days);
            
            $dailySalary = round($pr->salary/$daysInAMonth, 2, PHP_ROUND_HALF_UP);
            $salaryPerHour = round($dailySalary/8, 2, PHP_ROUND_HALF_UP);
            
            $totalHourTardy = round(($salaryPerHour/60)*$days->undertime,2,PHP_ROUND_HALF_UP);
            //use this if exact deduction
            //$totalDeductibleTardy = round($pr->salary/$schoolDays/8/60*$undertime, 2);
            
            $totalDeductibleTardy = ($pr->pay_type?0:$totalHourTardy);
            $netpay = ($pr->salary/$over);
            
            $pdf->SetX(5);
            $pdf->MultiCell(10, 5, $i,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(70, 5, $pr->firstname.' '.$pr->lastname,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(50, 5, $pr->position,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, $salary,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $totalStat= 0;
            $addOn = 0;
            $totalNetPayroll = 0;
            $items = 1;
            $deduct = array();
            foreach($charges as $deductions): 
                $items++;
                $charge = Modules::run('hr/payroll/getPayrollChargesByItem', $deductions->pc_item_id, $pc_code, $pr->employee_id);
                $amount = ($charge!=NULL?$charge->pc_amount:0);
                $pdf->MultiCell($columnWidth, 5, $amount,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                if($charge!=NULL):
                    if($charge->pi_item_type==1):
                        $addOn += $amount;
                    else:
                        $totalStat += $amount;
                    endif;
                endif;
            endforeach;

        $pdf->MultiCell($fixedWidth, 5, $totalDeductibleTardy,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell($fixedWidth, 5, number_format(($totalDeductibleTardy+$totalStat), 2, '.', ','),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell($fixedWidth, 5, number_format((($netpay+$addOn)-($totalDeductibleTardy+$totalStat)), 2, '.', ','),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();   
       $i++;    
       
        $totalNetPay += $netpay;
        $addOnTotal += $addOn;
        $statTotal += $totalStat;
        $totalOD += ($totalDeductibleTardy+$totalStat);
        $totalTardy += $totalDeductibleTardy;
        unset($addOn);
        unset($totalStat);
        unset($expectedPerHourRate);
        $items = 1;
            
   endif;
endforeach;    

$pdf->SetFont('helvetica', 'B', 10);
// set cell padding
$pdf->SetX(5);
$pdf->MultiCell(130, 5, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(30, 5, number_format($totalNetPay, 2, '.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $totalNetPayroll = (($totalNetPay+$addOnTotal)-($totalOD));
        foreach($charges as $deductions): 
            $charge = Modules::run('hr/payroll/getTotalPayrollChargesByItem', $deductions->pc_item_id, $pc_code);
            $amount = ($charge!=NULL?$charge->total:0);
            $pdf->MultiCell($columnWidth, 5,number_format($amount,2,'.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
            
        endforeach;

$pdf->MultiCell($fixedWidth, 5, number_format($totalTardy,2,'.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 5, number_format($totalOD,2,'.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell($fixedWidth, 5, number_format($totalNetPayroll,2,'.',','),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();


//Close and output PDF document
$pdf->Output('Payroll.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
