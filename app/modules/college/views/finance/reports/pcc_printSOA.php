<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
        $settings = Modules::run('main/getSet');
        $nextYear = $settings->school_year + 1;

        $this->SetTitle(strtoupper($settings->set_school_name));
        $this->SetTopMargin(4);
        $this->Ln(5);

        $image_file = K_PATH_IMAGES . '/pcc.jpg';
        $this->Image($image_file, 13, 10, 30, '', 'jpg', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetFont('times', '', 15);
        $this->MultiCell(15, 5, '', 'TB', 'L', 0, 0, '', '', true);
        $this->MultiCell(135, 5, 'PHILIPPINE COUNTRYVILLE COLLEGE,  INC.', 'TB', 'L', 0, 0, '', '', true);
        $this->Ln();

        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(30, 5, '', '', 'L', 0, 0, '', '', true);
        $this->MultiCell(150, 5, 'P-2B, SAYRE HIGHWAY, PANADTALAN, MARAMAG, BUKIDNON', '', 'C', 0, 0, '', '', true);
        $this->Ln();

        $this->SetFont('helvetica', 'B', 8);
        $this->MultiCell(20, 5, '', '', 'C', 0, 0, '', '', true);
        $this->MultiCell(160, 5, 'MARAMAG, 8714', '', 'C', 0, 0, '', '', true);
        $this->Ln();
    }

    // Page footer
    public function Footer() {
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
$resolution = array(330, 216);
$pdf->AddPage('P', $resolution);

$semester = Modules::run('main/getSemester');
if ($sem == NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'), $sem);
$next = $settings->school_year + 1;

switch ($student->year_level):
    case 1:
        $year_level = 'I';
        break;
    case 2:
        $year_level = 'II';
        break;
    case 3:
        $year_level = 'III';
        break;
    case 4:
        $year_level = 'IV';
        break;
    case 5:
        $year_level = 'V';
        break;
endswitch;

switch ($student->semester):
    case 1:
        $sem = '1ST';
        break;
    case 2:
        $sem = '2ND';
        break;
    case 3:
        $sem = 'SUMMER';
        break;
endswitch;

// define style for border
$border_style = array('all' => array('width' => 2, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0));
$pdf->Ln(35);

$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(65, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(70, 5, 'Statement of Account ', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(65, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(70, 5, 'First Semester School year 2018-2019', '', 'C', 0, 0, '', '', true);
$pdf->Ln(12);

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(24, 5, 'NAME:', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(16, 5, '', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(57, 5, strtoupper($student->firstname . ' ' . ($student->middlename != "" ? substr($student->middlename): "") . $student->lastname), '', 'L', 0, 0, '', '', true);

$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(40, 5, 'COURSE & YEAR:', '', 'C', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, strtoupper($student->short_code . ' - ' . $year_level), '', 'L', 0, 0, '', '', true);
$pdf->Ln(10);


$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(25, 5, 'Date', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Particulars', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Charges', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Payments', 'TB', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, 'Balance', 'TB', 'L', 0, 0, '', '', true);
$pdf->Ln();

//CHARGES / FEES

$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id);

$totalUnits = 0;
foreach ($loadedSubject as $sl):
    $totalUnits += ($sl->s_lect_unit + $sl->s_lab_unit);
endforeach;

$plan = Modules::run('college/finance/getPlanByCourse', $student->course_id, $student->year_level);
$tuition = Modules::run('college/finance/getChargesByCategory', 1, $student->semester, $student->school_year, $plan->fin_plan_id);
$charges = Modules::run('college/finance/financeChargesByPlan', $student->year_level, $student->school_year, $sem, $plan->fin_plan_id);
$transactions = Modules::run('college/finance/getTransactions', $student->uid,'');
$tuitionPaid = Modules::run('college/finance/getTransactions', $student->uid, 1);

//$misc = Modules::run('college/finance/getChargesByCategory',2, $student->semester, $student->school_year, $plan->fin_plan_id );
foreach ($charges as $c):
    $next = $c->school_year + 1;
    $totalCharges += ($c->item_id <= 1 || $c->item_id <= 2 ? 0 : $c->amount);
endforeach;
$totalExtra = 0;
$extraCharges = Modules::run('college/finance/getExtraFinanceCharges', $student->uid, $student->semester, $student->school_year);
if ($extraCharges->num_rows() > 0):
    foreach ($extraCharges->result() as $ec):
        $totalExtra += $ec->extra_amount;
    endforeach;
endif;
$lab = Modules::run('college/finance/getLaboratoryFee', $student->uid, $student->semester, $student->school_year);

$over = Modules::run('college/finance/overPayment', $student->uid, $student->semester, $student->school_year);

$discounts = Modules::run('college/finance/getDiscountsByItemId', $student->uid, $student->semester, $student->school_year);
//$totalDiscount = ($tuition->row()->amount*$totalUnits) * $discounts->disc_amount;
//$totalDiscount = ($discounts->disc_type==0?($tuition->row()->amount*$totalUnits) * $discounts->disc_amount:$discounts->disc_amount);

$totalFees = (($tuition->row()->amount * $totalUnits) + $totalCharges + $lab->row()->extra_amount);

foreach ($tuitionPaid as $tuitionFee) {
    $totalTuitionPaid += $tuitionFee->t_amount;
}


$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(185, 5, '', 'T', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln(0);

$tTuitionBal = ($tuition->row()->amount * $totalUnits) - $totalTuitionPaid;

$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(25, 5, '', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'TUITION (' . $totalUnits . ' UNITS @ ' . (number_format($tuition->row()->amount, 1, '.', ',')) . ')', '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, (number_format($tuition->row()->amount * $totalUnits, 2, '.', ',')), '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, (number_format($totalTuitionPaid, 2, '.', ',')), '', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, (number_format($tTuitionBal, 2, '.', ',')), '', 'L', 0, 0, '', '', true);
$pdf->Ln();

foreach ($charges as $cfitems) {
    $amount = ($cfitems->item_id <= 1 || $cfitems->item_id <= 2 ? 0 : $cfitems->amount);
    if ($cfitems->item_id != 1 && $cfitems != 2):
        $amountTotal = Modules::run('college/finance/getTransactions', $student->uid, $cfitems->item_id);
        if ($amountTotal != "") {
            foreach ($amountTotal as $a) {
                $totalPerItem += $a->t_amount;
            }
        }
        $tAmount = ($amountTotal != "" ? $totalPerItem : 0);
        $tCharges += $amount;
        $tPayment += $tAmount;
        $tBal += $amount - $tAmount;

        $pdf->MultiCell(25, 5, '', '', 'L', 0, 0, '', '', true);
        $pdf->MultiCell(55, 5, $cfitems->item_description, '', 'L', 0, 0, '', '', true);
        $pdf->MultiCell(35, 5, number_format($amount, 2, '.', ','), '', 'L', 0, 0, '', '', true);
        $pdf->MultiCell(35, 5, (number_format($tAmount, 2, '.', ',')), '', 'L', 0, 0, '', '', true);
        $pdf->MultiCell(35, 5, number_format(($amount - $tAmount), 2, '.', ','), '', 'L', 0, 0, '', '', true);
        $pdf->Ln();
        $totalPerItem = 0;
    endif;
}

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(25, 5, '', 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 5, 'Total Charges/Payments', 'T', 'L', 0, 0, '', '', true);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(35, 5, number_format($tCharges + ($tuition->row()->amount * $totalUnits), 2, '.',','), 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, number_format($tPayment + $totalTuitionPaid, 2, '.', ','), 'T', 'L', 0, 0, '', '', true);
$pdf->MultiCell(35, 5, number_format($tBal + $tTuitionBal, 2, '.', ','), 'T', 'L', 0, 0, '', '', true);
$pdf->Ln(0);

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(185, 5, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln(30);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(60, 2, 'Prepared By:', '', 'L', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 7, 20)));
$pdf->MultiCell(40, 5, '', 'B', 'L', 0, 0, '', '', true);
$pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(40, 2, 'ARIANE M. LAZO', '', 'C', 0, 0, '', '', true);
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(40, 2, 'B.O CASHIER', '', 'C', 0, 0, '', '', true);
$pdf->Ln(25);

//Close and output PDF document
$pdf->Output('studyLoad.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
