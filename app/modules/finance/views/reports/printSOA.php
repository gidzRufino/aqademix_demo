<?php

set_time_limit(120);

class MYPDF extends Pdf
{

    public function Header()
    { //Page header
        $this->SetTitle('Business Office Collections');
    }

    public function Footer()
    { // Page footer

        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(330, 216);

$school = "Livingstone Christian Academy";
$saddress = "Upper Bagacay, Tayud, Consolacion, Cebu";
$settings = Modules::run('main/getSet');
$start = date('n', strtotime($settings->bosy));
// $sname = $student->lastname;
// foreach student of a certain grade create a page of SOA
$month2date = date("n");
if ($month2date > $start) {
    $sch_month = $month2date - $start; // they started at the month of July
} elseif ($month2date < $start) {
    $sch_month = $month2date + (12 - $start);
} else {
    $sch_month = 0;
}

$cdate = $due_date;
$ac_tdate = date("F d, Y");

$student = Modules::run('registrar/getSingleStudent', $st_id, $this->session->userdata('school_year'));

$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);
$charges = ($plan->fin_plan_id != '' ? Modules::run('finance/financeChargesByPlan', 0, $this->session->userdata('school_year'), 0, $plan->fin_plan_id) : 0);
$addCharge = Modules::run('college/finance/financeChargesByPlan', NULL, $student->school_year, 0);
// print_r($plan);
Modules::run('finance/setFinanceAccount', base64_decode($st_id), $student->school_year, $student->grade_id, null, null);

$financeAccount = Modules::run('finance/getFinanceAccount', $student->u_id);

if ($student->u_id == ""):
    $user_id = $student->us_id;
else:
    $user_id = $student->u_id;
endif;

$i = 1;
$total = 0;
$amount = 0;
$scharge = "";
$misc = 0;
$misc_monthly = 0;
$totalMisc = 0;
$tuition = 0;
$tuition_monthly = 0;
$totalTuition = 0;
$computer = 0;
$comp_monthly = 0;
$totalComp = 0;
$others = 0;
$otherList = [];
$isMonthly = [];

$pdf->AddPage('P', $resolution);

$pdf->SetXY(5, 5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->setCellPaddings(1, 1, 1, 1);


$pdf->SetY(10);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'R', 9);
$pdf->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 0, 'STATEMENT OF ACCOUNT', 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(13, 0, 'Name: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(140, 0, strtoupper($student->firstname . ' ' . ($student->middlename != "" ? substr($student->middlename, 0, 1) . '. ' : "") . $student->lastname), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(25, 0, 'Grade/Level: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(50, 0, $student->level, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(22, 0, 'Student ID: ', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(50, 0, $student->uid, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(10);

//--------------------------- left -------------------------------------------------//
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 0, 'Finance Details', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(5, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, 'Particulars', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(20, 0, 'Amount', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln(4);

$i = 1;
$totalMonthly = 0;
if ($charges != 0):
    $pdf->SetFont('helvetica', 'R', 8);
    foreach ($charges as $c):
        if ($c->payment_term != 0):
            array_push($isMonthly, [$c->item_id, $c->item_description, $c->amount, $c->total_month]);
        else:
            $others += $c->amount;
            array_push($otherList, [$c->item_id, $c->item_description, $c->amount]);
        endif;
        // if ($c->item_id == 215724): // ------------ Miscellaneous Fee ----------------//
        //     $misc = $c->amount;
        // elseif ($c->item_id == 225556): //--------- Tuition Fee ------------------//
        //     $tuition = $c->amount;
        // elseif ($c->item_id == 16): //------------- Computer Fee ---------------------//
        //     $computer = $c->amount;
        // else:
        //     $others += $c->amount;
        //     array_push($otherList, [$c->item_id, $c->item_description, $c->amount]);
        // endif;

        $pdf->MultiCell(5, 0, $i++, 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(35, 0, $c->item_description, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
        $pdf->MultiCell(20, 0, number_format($c->amount, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'B');
        $pdf->Ln(4);
        $total += $c->amount;
    endforeach;

    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->MultiCell(40, 0, 'TOTAL', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
    $pdf->MultiCell(20, 0, number_format($total, 2, '.', ','), 'RB', 'R', 0, 0, '', '', true, 0, false, true, 0, 'B');
    $pdf->Ln();

    $totalExtra = 0;
    $otherExtra = 0;
    $listXtra = [];
    $extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->uid, 0, $student->school_year);
    if ($extraCharges->num_rows() > 0):
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(60, 0, 'Extra Charges', 'LR', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);

        $pdf->SetFont('helvetica', 'R', 8);
        foreach ($extraCharges->result() as $ec):
            if ($ec->amount != 0):
                $pdf->MultiCell(5, 0, $i++, 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
                $pdf->MultiCell(40, 0, $ec->item_description, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
                if ($ec->pcs == 1):
                    $pdf->MultiCell(15, 0, number_format($ec->amount, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
                    $pdf->Ln(5);
                else:
                    $perPcs = $ec->amount / $ec->pcs;
                    $pdf->MultiCell(15, 0, '', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
                    $pdf->Ln(5);

                    $pdf->MultiCell(5, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
                    $pdf->MultiCell(40, 0, '( ' . $ec->pcs . 'pcs x ' . number_format($perPcs, 2, '.', ',') . ' )', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
                    $pdf->MultiCell(15, 0, number_format($ec->amount, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
                    $pdf->Ln(5);
                endif;
                $totalExtra += $ec->amount;
                array_push($listXtra, [$ec->item_id, $ec->item_description, $ec->amount]);
            endif;
        endforeach;
        $total = $total + $totalExtra;

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(40, 0, 'TOTAL FEES', 'LBT', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($total, 2, '.', ','), 'RBT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(10);
    endif;
// foreach ($isMonthly as $ol):
//     $pdf->MultiCell(40, 0, $ol[3], 'LBT', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
//     $pdf->Ln();
// endforeach;
else:
    $pdf->MultiCell(60, 0, 'No Finance Plan Type Set', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln();
endif;

//---------------------------- right -----------------------------------------------//
$pdf->SetXY(72, 46);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(130, 0, 'Payment / Discount History', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Date', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'OR #', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, 'Particulars', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, 'Payment/Discounts', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Balance', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(20, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, 'Total Charge', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(35, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, number_format($total, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

$transaction = Modules::run('college/finance/getTransaction', $student->uid, 0, $student->school_year);
$paymentTotal = 0;
$i = 1;
$tdiscount = 0;
$pd_total = 0;
$totalPTA = 0;
$totalXtraPaid = 0;
$othersPaid = [];
$fees = 0;
$diffXtra = [];
$totalIsMonthly = [];
$totalOthersPaid = 0;
$monthlyPaid = 0;
$discounted = 0;

foreach ($isMonthly as $ol):
    foreach ($transaction->result() as $tr):
        if ($ol[0] == $tr->t_charge_id):
            if ($tr->t_type == 2):
                $discounted += $tr->t_amount;
            else:
                $monthlyPaid += $tr->t_amount;
            endif;
        endif;
    endforeach;
    array_push($totalIsMonthly, [$ol[0], $ol[1], $monthlyPaid, $discounted]);
    $monthlyPaid = 0;
    $discounted = 0;
endforeach;

if ($transaction->num_rows() > 0):
    $balance = 0;

    foreach ($transaction->result() as $tr):
        $i++;
        $total = $total - $tr->t_amount;
        $pd_total = $pd_total + $tr->t_amount;

        // if ($tr->t_charge_id == 215724): // ------------ Miscellaneous Fee ----------------//
        //     $totalMisc += $tr->t_amount;
        // endif;

        // if ($tr->t_charge_id == 225556): //--------- Tuition Fee ------------------//
        //     $totalTuition += $tr->t_amount;
        // endif;

        // if ($tr->t_charge_id == 16): //--------- Computer Fee ------------------//
        //     $totalComp += $tr->t_amount;
        // endif;

        foreach ($listXtra as $lx):
            if ($lx[0] == $tr->item_id):
                $totalXtraPaid += $tr->t_amount;
            // array_push($diffXtra, [$tr->item_id, ($lx[2] - $tr->t_amount), $tr->item_description]);
            endif;
        endforeach;
        if ($tr->t_type == 2):
            $discounts = Modules::run('finance/getDiscountsByItemId', $student->uid, 0, $student->school_year, $tr->disc_id);
            $tdiscount = $tdiscount + $tr->t_amount;

            $pdf->SetX(72);
            $pdf->MultiCell(20, 0, $tr->t_date, 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(20, 0, '-', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(35, 0, $tr->item_description, 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(35, 0, '(' . number_format($tr->t_amount, 2, '.', ',') . ')', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(20, 0, number_format(($total), 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->Ln(4);
        else:
            $pdf->SetX(72);
            $pdf->MultiCell(20, 0, $tr->t_date, 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(20, 0, $tr->ref_number, 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(35, 0, $tr->item_description, 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(35, 0, number_format($tr->t_amount, 2, '.', ','), 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(20, 0, number_format(($total), 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->Ln(4);
        endif;
        $paymentTotal = $total;
    endforeach;
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(110, 0, 'Running Balance', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($paymentTotal, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
endif;

$ot = 0;
$otherBal = [];
$odesc = '';
foreach ($otherList as $ol):
    foreach ($transaction->result() as $tr):
        if ($ol[0] == $tr->item_id):
            $ot += $tr->t_amount;
            $odesc = $tr->item_description;
        endif;
    endforeach;
    $rem = $ol[2] - $ot;
    array_push($otherBal, [$ol[0], $rem, $ol[1]]);
    $ot = 0;
endforeach;

$tMonth = 0;
$tMonthToPay = 0;
$monthArrears = 0;
$tMonthBal = 0;
$listTmonthBal = [];
$listTmonthArrears = [];
$md = 0;

foreach ($isMonthly as $ol):
    foreach ($totalIsMonthly as $tm):
        if ($ol[0] == $tm[0]):
            $md = $ol[2] - $tm[3];
            $tMonth = $md / $ol[3];
            $tMonthToPay = $tMonth * $sch_month;
            if ($tm[2] < $md):
                $monthArrears = ($tMonth * ($sch_month - 1)) - $tm[2];
                $tMonthBal = $tMonth + $monthArrears;
            else:
                $monthArrears = 0;
                $tMonthBal = 0;
            endif;
        // $pdf->SetX(72);
        // $pdf->MultiCell(110, 0, number_format($tMonthToPay, 2, '.', ',') . ' ' . $sch_month, 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        // $pdf->MultiCell(20, 0, $ol[2] . '/' . $ol[3], 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        // $pdf->Ln(4);
        endif;
    endforeach;
    array_push($listTmonthArrears, [$ol[0], $ol[1] . ' Arrears', $monthArrears]);
    array_push($listTmonthBal, [$ol[0], $ol[1], ($tMonthBal - $monthArrears)]);
endforeach;

// ------------- Miscellaneous Fee ------------------//
$miscArr = 0;
$miscMonthBal = 0;
$monthlyMisc = $misc / 8;
$monthMiscToPay = $monthlyMisc * $sch_month;
if ($totalMisc < $misc):
    $miscArr = ($monthlyMisc * ($sch_month - 1)) - $totalMisc;
    $miscMonthBal = $monthlyMisc + $miscArr;
// $miscMonthBal = $monthMiscToPay - $totalMisc;
// $miscArr = $miscMonthBal - $monthlyMisc;
else:
    $miscMonthBal = 0;
    $miscArr = 0;
endif;

// ------------- Tuitiom Fee ------------------------//
$tuitionArr = 0;
$tuitionMonthBal = 0;
$monthlyTuition = $tuition / 8;
$monthTuitionToPay = $monthlyTuition * $sch_month;
if ($totalTuition < $tuition):
    $tuitionArr = ($monthlyTuition * ($sch_month - 1)) - $totalTuition; //---------- if < 0 result over payment else arrears
    $tuitionMonthBal = $monthlyTuition + $tuitionArr;
else:
    $tuitionMonthBal = 0;
    $tuitionArr = 0;
endif;

// --------------- Computer Fee ---------------------//
$compArr = 0;
$compMonthBal = 0;
$monthlyComp = $computer / 8;
$monthCompToPay = $monthlyComp * $sch_month;
if ($totalComp < $computer):
    $compArr = ($monthlyComp * ($sch_month - 1)) - $totalComp;
    $compMonthBal = $monthlyComp + $compArr;
else:
    $compMonthBal = 0;
    $compArr = 0;
endif;

$totalMonthly = $misc + $tuition;
$monthly_fee = $totalMonthly / 8;
$monthlyToPay = $monthly_fee * $sch_month;
$miscTuitionPaid = $totalMisc + $totalTuition;
$miscTuitionBal = $totalMonthly - $miscTuitionPaid;
$monthlyBal = $monthlyToPay - $miscTuitionPaid;
$xtraBal = $totalExtra - $totalXtraPaid;
$amount_paid = $pd_total;
$remBal = 0;
$tt = 0;
$mm = 0;
$cm = 0;
$gt = 0;

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(110, 0, 'Total Payments and Discounts Received', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, number_format($pd_total, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(110, 0, 'Arrears             ', 'LT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'RT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

foreach ($listTmonthArrears as $ol):
    $pdf->SetFont('helvetica', 'R', 8);
    if ($ol[2] > 0):
        $pdf->SetX(72);
        $pdf->MultiCell(110, 0, $ol[1], 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($ol[2], 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
        $gt += $ol[2];
    endif;
endforeach;

foreach ($otherBal as $op):
    if ($op[1] != 0):
        $pdf->SetX(72);
        $pdf->SetFont('helvetica', 'R', 8);
        $pdf->MultiCell(110, 0, $op[2], 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($op[1], 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
        $remBal += $op[1];
        $gt += $op[1];
    endif;
endforeach;

if ($xtraBal != 0):
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Extra Charges', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($xtraBal, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    $remBal += $xtraBal;
    $gt += $xtraBal;
endif;

if ($miscArr > 0):
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Miscellaneous Fee Arrears', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($miscArr, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    $remBal += $miscArr;
endif;

if ($tuitionArr > 0):
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Tuition Fee Arrears', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($tuitionArr, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    $remBal += $tuitionArr;
endif;

if ($compArr > 0):
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Computer Fee Arrears', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($compArr, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    $remBal += $compArr;
endif;

$pdf->SetX(72);
$pdf->MultiCell(110, 0, '', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(2);

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(110, 0, 'Monthly Fee             ', 'LT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'RT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

foreach ($listTmonthBal as $ol):
    $pdf->SetFont('helvetica', 'R', 8);
    if ($ol[2] > 0):
        $pdf->SetX(72);
        $pdf->MultiCell(110, 0, $ol[1], 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($ol[2], 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
        $gt += $ol[2];
    endif;
endforeach;

if ($miscMonthBal > 0):
    $mm = $miscMonthBal - $miscArr;
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Miscellaneous Fee', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($mm, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    if ($miscArr < 0):
        $mm += $miscArr;
        $pdf->SetX(72);
        $pdf->MultiCell(110, 0, '( Less', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($miscArr, 2, '.', ',') . ' )', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
    endif;
endif;

if ($tuitionMonthBal > 0):
    $tt = $tuitionMonthBal - $tuitionArr;
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Tuition Fee', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($monthlyTuition, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    if ($tuitionArr < 0):
        $tt += $tuitionArr;
        $pdf->SetX(72);
        $pdf->MultiCell(110, 0, '( Less', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($tuitionArr, 2, '.', ',') . ' )', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
    endif;
endif;

if ($compMonthBal > 0):
    $cm = $compMonthBal - $compArr;
    $pdf->SetX(72);
    $pdf->SetFont('helvetica', 'R', 8);
    $pdf->MultiCell(110, 0, 'Computer Fee', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->MultiCell(20, 0, number_format($monthlyComp, 2, '.', ','), 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
    $pdf->Ln(4);
    if ($compArr < 0):
        $cm += $compArr;
        $pdf->SetX(72);
        $pdf->MultiCell(110, 0, '( Less', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->MultiCell(20, 0, number_format($compArr, 2, '.', ',') . ' )', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(4);
    endif;
endif;

$pdf->SetX(72);
$pdf->MultiCell(110, 0, '', 'L', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'R', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(2);


$min_amount_due = ($mm < 0 ? 0 : $mm) + ($tt < 0 ? 0 : $tt) + ($cm < 0 ? 0 : $cm) + ($remBal < 0 ? 0 : $remBal);
// $min_amount_due = $monthlyBal + $remBal;
// $paid_discount = $amount_paid - $tdiscount;
// $min_amount_due = ($totalMonthly + $diff) - $amount_paid;

// if ($min_amount_due < 0) {
//     $min_amount_due = 0;
// }

if ($gt < 0):
    $gt = 0;
endif;

$pdf->SetX(72);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(110, 0, 'Amount Due', 'LBT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, number_format($gt, 2, '.', ','), 'RBT', 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(60);

$pdf->SetY(195);
$pdf->SetFont('helvetica', 'R', 6);
$pdf->MultiCell(130, 0, '* All details reflected herewith are as of ' . $ac_tdate . '. It excludes all transactions made after the said date.', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(3);

$pdf->MultiCell(130, 0, '** Please settle this account on or before [ ' . $cdate . ' ]. Please keep this for future reference.', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(10);

$pdf->SetXY(72, 210);
$pdf->SetFont('helvetica', 'R', 7);
$pdf->MultiCell(40, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

$pdf->SetXY(72, 215);
$pdf->MultiCell(40, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(85, 0, 'Not valid without Authorized Signature over Printed Name', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(10);

//set 'width' => 0.1, 'dash' => '1,1,1,1' as per your requirement
$dottedLines = array('width' => 0.5, 'cap' => 'butt', 'dash' => '1,2', 'phase' => 0, 'color' => array(0, 0, 0));
// Line
$pdf->Text(80, 230, '[ cut here and return to ' . $settings->set_school_name . ' ]');
$pdf->Line(5, 235, 210, 235, $dottedLines);

$solidStyle = array('width' => 0.1, 'cap' => 'butt', 'dash' => 0, 'phase' => 0, 'color' => array(0, 0, 0));
$pdf->SetLineStyle($solidStyle);
$pdf->Ln(40);

//----------------------------------------------- left side Acknowledgement ---------------------------------------------
$pdf->SetXY(5, 245);
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(100, 10, $settings->set_school_name, 'TLR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(8);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(100, 0, $settings->set_school_address, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln(4);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(100, 0, $ac_tdate, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(100, 0, 'Statement of Account Acknowledgment Form', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 9);
$pdf->MultiCell(100, 0, 'Name: ' . $student->lastname . ', ' . $student->firstname, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln(4);

$pdf->SetX(5);
$pdf->MultiCell(100, 0, 'Grade / Level: ' . $student->level, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(10, 0, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(90, 0, '___ We have already settled the account. Thank you.', 'R', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln(5);

$pdf->SetX(5);
$pdf->MultiCell(10, 0, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(90, 0, '___ We will settle the account on ________________', 'R', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln(4);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 6);
$pdf->MultiCell(30, 0, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(70, 0, '* please settle on or before [' . $cdate . ']', 'R', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->MultiCell(100, 10, '', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(5, 0, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(65, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(5, 0, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Date', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'B', 'LB', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(65, 0, 'Parent/Guardian Signature over Printed Name', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'RB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();


//--------------------------------------------- right side acknowledgement --------------------------------------------------

$pdf->SetXY(110, 245);
$pdf->SetFont('helvetica', 'R', 10);
$pdf->MultiCell(100, 10, $settings->set_school_name, 'TLR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(9);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(33, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(34, 0, 'Admission Slip', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(33, 0, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->MultiCell(100, 10, '', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(9);

$pdf->SetX(110);
$pdf->MultiCell(100, 0, 'Name: ' . $student->lastname . ', ' . $student->firstname, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(4);

$pdf->SetX(110);
$pdf->MultiCell(100, 0, 'Grade / Level: ' . $student->level, 'LR', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(10, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Remarks: ', 0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(65, 0, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(10, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(80, 0, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(10, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(80, 0, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(10, 0, '', 'L', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(80, 0, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 'R', 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->MultiCell(100, 10, '', 'LR', 'C', 0, 0, '', '', true, 0, false, true, 10, 'B');
$pdf->Ln(6);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(5, 0, '', 'L', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(65, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'R', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);

$pdf->SetX(110);
$pdf->SetFont('helvetica', 'R', 8);
$pdf->MultiCell(5, 0, '', 'LB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, 'Date', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'B', 'LB', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(65, 0, 'Authorized Signature over Printed Name', 'B', 'C', 0, 0, '', '', true, 0, false, true, 0, 'B');
$pdf->MultiCell(5, 0, '', 'RB', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();
// foreach(studperlevel)
//Close and output PDF document
$pdf->Output('business_office_report.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
