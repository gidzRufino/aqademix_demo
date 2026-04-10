<?php
//set_time_limit(120);
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $this->SetTopMargin(4);
                $this->Ln(5);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
		$this->SetFont('helvetica', 'n', 8);
		$this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
                $this->SetTitle('Revenue Summary');
        }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(330,216);
$pdf->AddPage('P', $resolution);


$pdf->SetY(25);
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 0, 'Revenue Summary Report', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, '[  As of '.date('F d, Y', strtotime($date)).' ]', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();
$pdf->SetFont('helvetica', 'N', 9);
$pdf->Cell(0, 0, 'School Year: '.$school_year.' - '.$next, 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->ln(8);
// set cell padding

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, 'Registration and Tuition:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Year Level','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Count','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Accounts','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Discount','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Payments','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Balance','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8.8);

$totalStudents = 0;
$totalTuition = 0;
$totalRegistration = 0;
$totalCollection = 0;
$totalBalance;
$totalDiscount=0;
$discountAmount = 0;
foreach($gradeLevel as $gl):
    $students = Modules::run('registrar/getAllStudentsForExternal', $gl->grade_id, NULL, NULL, 1);
    $charges = Modules::run('finance/getFinanceCharges',$gl->grade_id, 0, ($school_year==NULL?$this->session->school_year:$school_year), 0);
    $collection = Modules::run('finance/finance_reports/getTotalCollectionPerGradeLevel', $gl->grade_id, 2, NULL, 0, $date);
    
    foreach ($charges as $charge):
        switch($charge->item_id):
            case 1:
                $tuition = $charge->amount*$students->num_rows();
                $totalTuition += $tuition;
                $discountTuition = Modules::run('finance/finance_pisd/getDiscountPerLevel', $gl->grade_id, 1, $date);
                $discountAmountTuition = $discountTuition->row()->amount;
                $totalTuitionDiscount += $discountAmountTuition;
            break;
            case 2:
                $registration = $charge->amount * $students->num_rows();
                $totalRegistration += $registration;
                //$totalCollection += $collection->row()->amount;
                
                $discountRegistration = Modules::run('finance/finance_pisd/getDiscountPerLevel', $gl->grade_id, 2, $date);
                $discountAmountRegistration = $discountRegistration->row()->amount;
                $totalRegistrationDiscount += $discountAmountRegistration;
            break;    
        endswitch;
    endforeach;
    $totalStudents += $students->num_rows();
    

    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, $gl->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, $students->num_rows(),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    //$pdf->MultiCell(32, 5, number_format(($tuition+$registration)-($discountAmountTuition),2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format(($tuition+$registration),2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($discountAmountTuition+$discountAmountRegistration,2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($collection->row()->amount,2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format(((($tuition+$registration)-($discountAmountTuition+$discountAmountRegistration))-$collection->row()->amount),2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $totalCollection += $collection->row()->amount;
    $tuition = 0;
    $registration = 0;
    $discountAmountTuition = 0;
    $discountAmountRegistration = 0;
endforeach;
$totalDiscount = $totalTuitionDiscount + $totalRegistrationDiscount;
$totalBalance = ($totalTuition+$totalRegistration)-($totalCollection+$totalDiscount);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(0.5);
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, number_format($totalStudents),'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format(($totalTuition+$totalRegistration),2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalDiscount,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalCollection,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalBalance,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->ln(30);
// set cell padding

$pdf->SetFont('helvetica', 'B', 10);

$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35, 5, 'Books :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Year Level','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'Count','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Accounts','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Discount','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Payments','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, 'Balance','TB', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8.8);

$totalBookStudents = 0;
$totalBooks = 0;
$totalBookCollection = 0;
$totalBookDiscount = 0;
foreach($gradeLevel as $gl):
    $students = Modules::run('registrar/getAllStudentsForExternal', $gl->grade_id, NULL, NULL, 1);
    $charges = Modules::run('finance/getFinanceCharges',$gl->grade_id, 0, ($school_year==NULL?$this->session->school_year:$school_year), 0);
    $collection = Modules::run('finance/finance_reports/getTotalCollectionPerGradeLevel', $gl->grade_id, 4, NULL, 0, $date);

    foreach ($charges as $charge):
        switch($charge->item_id):
            case 3:
                $books = $charge->amount*$students->num_rows();
                $totalBooks += $books;
                
                $bookDiscount = Modules::run('finance/finance_pisd/getDiscountPerLevel', $gl->grade_id, 3, $date);
                $bDiscount = $bookDiscount->row()->amount;
                $totalBookDiscount += $bDiscount;
            break; 
        endswitch;
    endforeach;
    $totalBookStudents += $students->num_rows();
    $totalBookCollection += $collection->row()->amount;

    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, $gl->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(20, 5, $students->num_rows(),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($books,2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($bDiscount,2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(5, 5, '','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format($collection->row()->amount,2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(32, 5, number_format((($books)-($collection->row()->amount+$bDiscount)),2,'.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->Ln();
    $books = 0;
    $bDiscount = 0;
endforeach;
$totalBookBalance = ($totalBooks)-$totalBookCollection;
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(0.5);
$pdf->MultiCell(5, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, number_format($totalStudents),'T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalBooks,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalBookDiscount,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalBookCollection,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(32, 5, number_format($totalBookBalance-$totalBookDiscount,2,'.',','),'T', 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');






//Close and output PDF document
$pdf->Output('Revenue Summary Report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
