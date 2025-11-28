<?php

class MYPDF extends Pdf
{

    //Page header
    public function Header()
    {
        // Logo

        $settings = Modules::run('main/getSet');
        $this->SetY(2);
        $this->SetX(10);
        $this->SetFont('helvetica', 'B', 11);
        // $image_file = K_PATH_IMAGES . '/' . $settings->set_logo;
        // $this->Image($image_file, 40, 5, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $this->SetX(10);
        $this->Ln(5);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
        $this->Ln();
        $this->SetFont('helvetica', 'n', 8);
        $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution = array(330, 216);
$pdf->AddPage('P', $resolution);

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('finance/getBasicStudent', $st_id, $school_year, $semester);
$next = $settings->school_year + 1;



$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);
$charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);

$extraCharges = Modules::run('finance/getExtraFinanceCharges', $student->user_id, $student->semester, $student->school_year);
// $charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);

$transaction = Modules::run('finance/getTransactionASC', $student->st_id, $student->semester, $student->school_year);



// print_r($extraCharges->result());

$misc = 0;
$reg = 0;
$techFee = 0;
$tuitionFee = 0;
$music = 0;
$total = 0;
$booksFee = 0;
$balance = 0;

$tempmisc = 0;
$tempreg = 0;
$temptechFee = 0;
$temptuitionFee = 0;
$tempmusic = 0;
$temptotal = 0;
$eBookFee = 0;
$tempEBookFee = 0;
$discount = 0;

foreach ($charges as $c):
    if ($c->item_description == 'Enrollment Fee'):
        $reg = $c->amount;
    endif;
    if ($c->item_description == 'Miscellaneous'):
        $misc = $c->amount;
        $tempmisc = $misc;
    endif;
    if ($c->item_description == 'Tuition Fee' || $c->item_description == 'Tuition'):
        $tuitionFee = $c->amount;
        $temptuitionFee = $tuitionFee;
    endif;
    // if ($c->item_description == 'Technology Fee'):
    //     $techFee = $c->amount;
    //     $temptechFee = $techFee;
    // endif;
    if ($c->item_description == 'Music'):
        $music = $c->amount;
        $tempmusic = $music;
    endif;
    if (strpos($c->item_description, 'Textbooks') !== false || strpos($c->item_description, 'Textbook') !== false):
        $booksFee += $c->amount;
        $tempbooksFee = $booksFee;
    endif;
    if (strpos($c->item_description, 'E-Book / Quipper Phils.') !== false || strpos($c->item_description, 'quipper/ebook') !== false):
        $eBookFee += $c->amount;
        $$tempEBookFee = $booksFee;
    endif;
endforeach;

foreach ($transaction->result() as $t):
    if ($t->t_type == 2):
        $discount = $discount + $t->t_amount;
    endif;

endforeach;

$pdf->SetXY(5, 5);
$pdf->SetFont('helvetica', 'B', 9);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);


$pdf->SetY(30);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 0, 'STATEMENT OF ACCOUNT', 0, false, 'C', 0, '', 0, false, 'M', 'T');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->Cell(0, 0, 'SY: ' . $settings->school_year . ' - ' . $next . ($student->semester == 3 ? '( SUMMER )' : ''), 0, false, 'C', 0, '', 0, false, 'M', 'T');
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(120, 0, 'Name: ' . strtoupper($student->firstname . ' ' . ($student->middlename != "" ? substr($student->middlename, 0, 1) . '. ' : "") . $student->lastname), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(100, 0, 'Grade Level : ' . strtoupper($student->level), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(6);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(120, 0, 'GUARDIAN: ' . strtoupper($student->ice_name), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(100, 0, 'Tuition Fee : ' . number_format($tuitionFee, 2, '.', ','), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(6);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(120, 0, 'CONTACT NUMBER: ' . $student->ice_contact, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(100, 0, 'Discount: ' . number_format($discount, 2, '.', ','), 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

//BOX
$pdf->Ln(10);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Date', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'O.R. No.', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Reg.', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Misc.', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Books', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Tuition Fee', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
// $pdf->MultiCell(12, 0, 'Music', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Total', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Balance', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(20, 0, 'Date', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(14, 0, 'Amount', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(21, 0, 'EBooks', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');


$tuitionFee -= $discount;
$total = $reg + $misc + $tuitionFee + $booksFee;

$temptotal = $total;



$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, number_format($reg, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, number_format($misc, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format($booksFee, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format($tuitionFee, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
// $pdf->MultiCell(12, 0, ($music == 0 ) ? '' : number_format($music, 2, '.', ',') , 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format($total, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '-', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(34, 0, 'Total Amount', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(21, 0, number_format($eBookFee, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$lastDate = '';
$lastOR = 0;
$tempReg = 0;
$totalPayment = 0;
$tempTotalPaid = 0;
$totalreg = 0;
$totalmisc = 0;
$totalmusic = 0;
$totalTuition = 0;
$totalBookFee = 0;
$totalEBookFee = 0;

$tbf = 0;

$b1y = 0;
$b1x = 0;

$b2y = 0;
$b2x = 0;

$b3y = 0;
$b3x = 0;

$b4y = 0;
$b4x = 0;

$b5y = 0;
$b5x = 0;

$b6y = 0;
$b6x = 0;

$b7y = 0;
$b7x = 0;

$b8y = 0;
$b8x = 0;
$b9y = 0;
$b9x = 0;
$b10y = 0;
$b10x = 0;
$amt_total = 0;
$amt_paid = 0;
$paid_total = 0;

foreach ($transaction->result() as $i => $t):
    if ($t->t_type != 2 && $t->t_type != 3):
        $tBuks = Modules::run('finance/getPerRefNum', $student->st_id, $student->semester, $student->school_year, $t->ref_number);
        foreach ($tBuks as $b):
            if ($b->t_charge_id == 268314 || $b->t_charge_id == 254538):
                $amt_total += $b->t_amount;
            else:
                $paid_total += $b->t_amount;
            endif;
        endforeach;

        if ($t->ref_number != $lastOR):
            if ($totalPayment != 0):
                $tempTotalPaid += $totalPayment;
                $pdf->SetXY($b6x, $b6y);
                $pdf->MultiCell(18, 0, number_format($totalPayment, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
                $temptotal -= $totalPayment;
                $pdf->SetXY($b7x, $b7y);
                $pdf->MultiCell(15, 0, number_format($temptotal, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            $totalPayment = 0;
            $pdf->Ln();
            $pdf->SetX(5);
            $pdf->MultiCell(20, 0, $t->t_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $pdf->MultiCell(15, 0, $t->ref_number, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // Enrollment Fee //
            $b1y = $pdf->GetY();
            $b1x = $pdf->GetX();
            $pdf->MultiCell(15, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // Miscellaneous //
            $b2y = $pdf->GetY();
            $b2x = $pdf->GetX();
            $pdf->MultiCell(15, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // Tech Fee //
            $b3y = $pdf->GetY();
            $b3x = $pdf->GetX();
            $pdf->MultiCell(18, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // Tuition Fee //
            $b4y = $pdf->GetY();
            $b4x = $pdf->GetX();
            $pdf->MultiCell(18, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // Total Payment //
            $b6y = $pdf->GetY();
            $b6x = $pdf->GetX();
            $pdf->MultiCell(18, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // balance
            $b7y = $pdf->GetY();
            $b7x = $pdf->GetX();
            $pdf->MultiCell(15, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

            $pdf->MultiCell(5, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // books //
            $b8y = $pdf->GetY();
            $b8x = $pdf->GetX();
            $pdf->MultiCell(20, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

            $b9y = $pdf->GetY();
            $b9x = $pdf->GetX();
            $pdf->MultiCell(14, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

            $b10y = $pdf->GetY();
            $b10x = $pdf->GetX();
            $pdf->MultiCell(21, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

            // Enrollment Fee //
            if ($t->item_description == 'Enrollment Fee'):
                $totalreg += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b1x, $b1y);
                $pdf->MultiCell(15, 0, number_format($t->t_amount, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // Miscellaneous //
            if ($t->item_description == 'Miscellaneous'):
                $totalmisc += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b2x, $b2y);
                $pdf->MultiCell(15, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // TextBook Fee //
            if ($t->item_description == 'Textbooks' || $t->item_description == 'Textbook'):
                $totalBookFee += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b3x, $b3y);
                $pdf->MultiCell(18, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // Tuition Fee //
            if ($t->item_description == 'Tuition Fee' || $t->item_description == 'Tuition'):
                $totalTuition += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b4x, $b4y);
                $pdf->MultiCell(18, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;

            // Total Payment //
//            $pdf->SetXY($b6x, $b6y);
//            $pdf->MultiCell(18, 0, ($paid_total == 0 ? '' : number_format($paid_total, 2, '.', ',')), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

            // balance
            $pdf->SetXY($b7x, $b7y);
            $pdf->MultiCell(15, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            // books //
            if ($t->t_charge_id == 268314 || $t->t_charge_id == 254538):
                $pdf->SetXY($b8x, $b8y);
                $pdf->MultiCell(20, 0, $t->t_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

                $pdf->SetXY($b9x, $b9y);
                $pdf->MultiCell(14, 0, number_format($amt_total, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

                $totalEBookFee += $t->t_amount;
                $tempEBookFee -= $t->t_amount;
                $pdf->SetXY($b10x, $b10y);
                $amt_paid += $amt_total;
                $pdf->MultiCell(21, 0, number_format(($eBookFee - $amt_paid), 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
        else:
            // Enrollment Fee //
            if ($t->item_description == 'Enrollment Fee'):
                $totalreg += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b1x, $b1y);
                $pdf->MultiCell(15, 0, number_format($t->t_amount, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // Miscellaneous //
            if ($t->item_description == 'Miscellaneous'):
                $totalmisc += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b2x, $b2y);
                $pdf->MultiCell(15, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // Tech Fee //
            if ($t->item_description == 'Textbooks' || $t->item_description == 'Textbook'):
                $totalBookFee += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b3x, $b3y);
                $pdf->MultiCell(18, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
            // Tuition Fee //
            if ($t->item_description == 'Tuition Fee' || $t->item_description == 'Tuition'):
                $totalTuition += $t->t_amount;
                $totalPayment += $t->t_amount;
                $pdf->SetXY($b4x, $b4y);
                $pdf->MultiCell(18, 0, number_format($t->t_amount, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;

            // Books //
            if ($t->t_charge_id == 268314 || $t->t_charge_id == 254538):
                $totalEBookFee += $t->t_amount;
                $pdf->SetXY($b8x, $b8y);
                $pdf->MultiCell(20, 0, $t->t_date, 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

                $pdf->SetXY($b9x, $b9y);
                $pdf->MultiCell(14, 0, number_format($amt_total, 2, '.', ','), 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

                $pdf->SetXY($b10x, $b10y);
                $tempEBookFee -= $t->t_amount;
                $amt_paid += $amt_total;
                $pdf->MultiCell(21, 0, number_format(($eBookFee - $amt_paid), 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            endif;
        endif;
        $lastDate = $t->t_date;
        $lastOR = $t->ref_number;
        if ($i == count($transaction->result()) - 1):
            $tempTotalPaid += $totalPayment;
            $pdf->SetXY($b6x, $b6y);
            $pdf->MultiCell(18, 0, number_format($totalPayment, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
            $temptotal -= $totalPayment;
            $pdf->SetXY($b7x, $b7y);
            $pdf->MultiCell(15, 0, number_format($temptotal, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
        endif;
    endif; //type if

    $amt_total = 0;
    $paid_total = 0;
endforeach;

//box Footer 
$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Total Paid', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, number_format($totalreg, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, ($totalmisc != 0) ? number_format($totalmisc, 2, '.', ',') : '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format($totalBookFee, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format($totalTuition, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
// $pdf->MultiCell(12, 0, ($totalmusic != 0 ) ? number_format($totalmusic, 2, '.', ',') : '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, number_format(($totalreg + $totalmisc + $totalBookFee + $totalTuition), 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
//$pdf->MultiCell(18, 0, number_format($tempTotalPaid, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Total Paid', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(14, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(21, 0, number_format($totalEBookFee, 2, '.', ',') . '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Balance', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15, 0, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, (($reg - $totalreg) == 0) ? '-' : number_format($reg - $totalreg, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, (($misc - $totalmisc) == 0) ? '-' : number_format($misc - $totalmisc, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, (($booksFee - $totalBookFee) == 0) ? '-' : number_format($booksFee - $totalBookFee, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, (($tuitionFee - $totalTuition) == 0) ? '-' : number_format($tuitionFee - $totalTuition, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
// $pdf->MultiCell(12, 0, '-', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, number_format((($reg - $totalreg) + ($misc - $totalmisc) + ($booksFee - $totalBookFee) + ($tuitionFee - $totalTuition)), 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Balance', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(14, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(21, 0, number_format(($eBookFee - $amt_paid), 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

//box end

$regMonthly = $reg - $totalreg;
$miscMonthly = 0;
$techFeeMonthly = 0;
$tuitionMonthly = 0;

$arrears = 0;
// if(($reg - $totalreg)  != 0 ):
// endif;
//$bosy = strtotime($settings->bosy);
$bosy = strtotime($settings->bosy . "+1 month");


$miscMonthly = $misc / 8;
$techFeeMonthly = $techFee / 8;
$tuitionMonthly = $tuitionFee / 8;
$booksFeeMonthly = $booksFee / 5;
$eBooksFeeMonthly = $eBookFee / 8;
$arrearsBooks = 0;
$arrearsEBooks = 0;
$subtot = 0;

$arrears = 0;

foreach ($extraCharges->result() as $ec):
    $arrears += $ec->extra_amount;
endforeach;

if ($total == $tempTotalPaid) {
    $arrears = 0;
}

if (($reg - $totalreg) != 0):
    if (($reg - $totalreg) <= $regMonthly):
        $regMonthly = $reg - $totalreg;
    endif;
    $subtot += $regMonthly;
endif;

if (date('m') > date('m', $bosy)):
    $pMonth = date('m');
else:
    $pMonth = 12 + abs(date('m'));
endif;

// if ((date('m') - date('m', $bosy)) <= 0):
if ((strtotime(date('Y-m')) - strtotime(date('Y-m', $bosy))) <= 0):
    $mo = 1;
else:
    $mo = abs(($pMonth - date('m', $bosy)) + 1);
endif;

$start_pdate = date('Y-m-d', $bosy);
$nxt_date = date('Y-m-d', strtotime($start_pdate . "+" . $mo . "month"));
$nxt_due = date('m-d', strtotime($start_pdate . "+" . $mo . "month"));
$due_next_month = date('m', strtotime($start_pdate . "+" . $mo . "month"));
$due_date = date('m-d');
$due_month = date('m');
$diff = ($due_date === $nxt_due ? 1 : 0);

if ($due_date < $nxt_due):
    $due_for_the_month = date('F');
else:
    if ($due_month == '12'):
        $due_for_the_month = date('F');
    else:
        $due_for_the_month = date('F', strtotime($nxt_date));
    endif;
endif;
// $due_for_the_month = ($due_date < $nxt_due ? date('F') : date('F', strtotime($nxt_date)));

$miscBal = $misc - $totalmisc;
//$tMonth_misc = $misc / $miscMonthly;
if ($miscBal != $misc):
    $misc_rem = fmod($miscBal, $miscMonthly);
    $a = (int) ($miscBal / $miscMonthly);

    $t_month = $miscMonthly * $mo;
    $rr = $t_month - $totalmisc;
    if (strtotime(date("Y-m-d", strtotime("+7 month", $bosy))) < strtotime(date("Y-m-d"))):
        $misc_nxtMonth = $miscBal;
    else:
        $misc_nxtMonth = $miscMonthly + $rr;
        $misc_nxtMonth = ($diff === 1 ? $misc_nxtMonth : $rr);
    endif;

else:
    $misc_nxtMonth = $miscMonthly * $mo;
endif;
$misc_nxtMonth = ($misc_nxtMonth < 0 ? 0 : $misc_nxtMonth);
$subtot += $misc_nxtMonth;

// $techFeeBal = $techFee - $totalTechFee;
// if ($techFeeBal != $techFee):
//     $ttech_month = $techFeeMonthly * $mo;
//     $ss = $ttech_month - $totalTechFee;
//     if (strtotime(date("Y-m-d", strtotime("+7 month", $bosy))) < strtotime(date("Y-m-d"))):
//         $techFeeMonthly_nxt = $techFeeBal;
//     else:
//         $techFeeMonthly_nxt = $techFeeMonthly + $ss;
//         $techFeeMonthly_nxt = ($diff === 1 ? $techFeeMonthly_nxt : $ss);
//     endif;
// else:
//     $techFeeMonthly_nxt = $techFeeMonthly * $mo;
// endif;

// $techFeeMonthly_nxt = ($techFeeMonthly_nxt < 0 ? 0 : $techFeeMonthly_nxt);
// $subtot += $techFeeMonthly_nxt;

$tuitionBal = $tuitionFee - $totalTuition;
if ($tuitionBal != $tuitionFee):
    $tuition_rem = fmod($tuitionBal, $tuitionMonthly);
    $q = (int) ($tuitionBal / $tuitionMonthly);

    $tuition_month = $tuitionMonthly * $mo;
    $tt = $tuition_month - $totalTuition;
    if (strtotime(date("Y-m-d", strtotime("+7 month", $bosy))) < strtotime(date("Y-m-d"))):
        $tuition_nxtMonth = $tuitionBal;
    else:
        $tuition_nxtMonth = $tuitionMonthly + $tt;
        $tuition_nxtMonth = ($diff === 1 ? $tuition_nxtMonth : $tt);
    endif;
    $tuitionMonthly = $tuition_nxtMonth;
else:
    $tuitionMonthly = $tuitionMonthly * $mo;
endif;
$tuitionMonthly = ($tuitionMonthly < 0 ? 0 : $tuitionMonthly);
$subtot += $tuitionMonthly;

$booksBal = $booksFee - $totalBookFee;
if ($booksBal != $booksFee):
    $books_rem = fmod($booksBal, $booksFeeMonthly);
    $q = (int) ($booksBal / $booksFeeMonthly);

    $tbooks_month = $booksFeeMonthly * $mo;
    $uu = $tbooks_month - $totalBookFee;
    if (strtotime(date("Y-m-d", strtotime("+4 month", $bosy))) < strtotime(date("Y-m-d"))):
        $arrearsBooks = $booksBal;
    else:
        $arrearsBooks = $booksFeeMonthly + $uu;
        $arrearsBooks = ($diff === 1 ? $arrearsBooks : $uu);
    endif;
    $booksFeeMonthly = $arrearsBooks;
else:
    if (strtotime(date("Y-m-d", strtotime("+4 month", $bosy))) <= strtotime(date("Y-m-d"))):
        $arrearsBooks = $booksFee;
    else:
        //        $arrearsBooks = $booksFeeMonthly * ($mo < 4 ? ($mo + 1) : $mo);
        $arrearsBooks = $booksFeeMonthly * $mo;
    endif;
endif;
$arrearsBooks = ($arrearsBooks < 0 ? 0 : $arrearsBooks);

$eBookBal = $eBookFee - $totalEBookFee;
if ($eBookBal != $eBookFee):
    $books_rem = fmod($eBookBal, $eBooksFeeMonthly);
    $q = (int) ($eBookBal / $eBooksFeeMonthly);

    $tbooks_month = $eBooksFeeMonthly * $mo;
    $uu = $tbooks_month - $totalEBookFee;
    if (strtotime(date("Y-m-d", strtotime("+7 month", $bosy))) < strtotime(date("Y-m-d"))):
        $arrearsEBooks = $eBookBal;
    else:
        $arrearsEBooks = $eBooksFeeMonthly + $uu;
        $arrearsEBooks = ($diff === 1 ? $arrearsEBooks : $uu);
    endif;
    $eBooksFeeMonthly = $arrearsEBooks;
else:
    if (strtotime(date("Y-m-d", strtotime("+7 month", $bosy))) <= strtotime(date("Y-m-d"))):
        $arrearsEBooks = $eBookFee;
    else:
        //        $arrearsBooks = $booksFeeMonthly * ($mo < 4 ? ($mo + 1) : $mo);
        $arrearsEBooks = $eBooksFeeMonthly * $mo;
    endif;
endif;
$arrearsEBooks = ($arrearsEBooks < 0 ? 0 : $arrearsEBooks);

// Monthly payment
$pdf->Ln(10);
$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50, 0, 'Due for the month: ' . $due_for_the_month, 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln();
$pdf->SetX(25);
$pdf->SetFont('helvetica', 'B', 8);
// $pdf->MultiCell(12, 0, '', 0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Reg.', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Misc.', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Books', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Tuition Fee', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
// $pdf->MultiCell(12, 0, 'Music', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, 'Sub-Total', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, 'Arrears', 1, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 0, 'Books', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(14, 0, 'Php', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(21, 0, 'Total Payable', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln();

$pdf->SetX(25);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15, 0, '', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(15, 0, (($reg - $totalreg) == 0) ? '-' : number_format($regMonthly, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, (($misc - $totalmisc) == 0) ? '-' : number_format($misc_nxtMonth, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, (($booksFee - $totalBookFee) == 0) ? '-' : number_format($arrearsBooks, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, (($tuitionFee - $totalTuition) == 0) ? '-' : number_format($tuitionMonthly, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, ($subtot < 0 ? '0.00' : number_format($subtot, 2, '.', ',')), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(15, 0, number_format($arrears, 2, '.', ','), 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->MultiCell(5, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(20, 0, number_format($arrearsEBooks, 2, '.', ','), 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(14, 0, '', 1, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(21, 0, (($subtot + $arrearsEBooks + $arrears) < 0 ? '0.00' : number_format($subtot + $arrearsEBooks + $arrears, 2, '.', ',')), 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->MultiCell(19, 0, 'Prepared By:', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(46, 0, '', 'B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(18, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(120, 0, 'PLEASE BRING YOUR STATEMENT OF ACCOUNT UPON PAYMENT. THANK YOU', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->Ln();
$pdf->SetX(5);
$pdf->MultiCell(19, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(46, 0, 'Jean Siao - Reambonanza', 0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(5, 0, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Output('Statement of Account.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
