<?php

class MYPDF extends Pdf {

    //Page header
    public function Header() {
        // Logo
        $settings = Modules::run('main/getSet');
        $this->SetFont('helvetica', 'B', 12);
        $this->MultiCell(80, 5, $settings->set_school_name, 0, 'C', 0, 1,105,10);
        $this->SetFont('helvetica', '', 9);
        $this->MultiCell(80, 5, $settings->set_school_name, 0, 'C', 0, 1,105);
    }
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
// VARIABLES   
$student = Modules::run('finance/getBasicStudent', $st_id, $school_year, $semester);
$settings = Modules::run('main/getSet');
$tuitionFee=0;
$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0, $student->st_type, $student->school_year);
$charges = Modules::run('finance/financeChargesByPlan', 0, $student->school_year, 0, $plan->fin_plan_id, $student->semester);
$transaction = Modules::run('finance/getTransactionASC', $student->st_id, $student->semester, $student->school_year);
$discounts = Modules::run('finance/getDiscountsByItemId', $student->st_id, $student->semester, $student->school_year);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage('L', 'A4');
$pdf->SetFont('helvetica', 'B', 15);

$registration_array[]= null;
$misc_array[]= null;
$technology_array[]= null;
$tuition_array[]= null;
$books_array[]= null;


//Discount
foreach($transaction->result() as $t):
    if ($t->t_type == 2):
        $discount = $discount + $t->t_amount;
    endif;
endforeach;

$pdf->SetFont('helvetica', '', 11);
$pdf->Ln(30);
$pdf->MultiCell(170, 5, "NAME: " . strtoupper($student->firstname . ' ' . ($student->middlename != "" ? substr($student->middlename, 0, 1) . '. ' : "") . $student->lastname), 0, 'L', 0, 0,30);
$pdf->MultiCell(50, 0, 'GRADE LEVEL: ' . strtoupper($student->level), 0, 'L', 0, 1);
$pdf->MultiCell(170, 0, 'GUARDIAN: ' . strtoupper( $student->ice_name ) , 0, 'L', 0, 1,30);
$pdf->MultiCell(170, 0, 'CONTACT NUMBER: ' . $student->ice_contact, 0, 'L', 0, 0,30);
$pdf->MultiCell(100, 0, 'DISCOUNT: '.number_format($discount, 2, '.', ','), 0, 'L', 0, 0);

$pdf->Ln(13);
$headers=array("Date", "O.R","OLD ACCOUNTS","REGISTRATION 2 MONTH","MISCELLANEOUS 6 MONTHS","TECH FEE 3 MONTHS", "TUITION FEE","BOOKS 6 MONTHS", "TOTAL", "BALANCES");

foreach($headers as $key=>$row){
    $pdf->SetFont('helvetica', 'B', 7.4);
    if($row == "Date" or $row=="O.R" ){
        $pdf->SetFont('helvetica', 'B', 9);
    }
    $pdf->MultiCell(25,12, "\n".$row, 1, 'C',0,0,25+($key*25));
}
$pdf ->Ln();
for($j=1;$j<=4;$j++){
    if($j==4){
        $pdf->MultiCell(25, 5,"---",1, 'C', 0, 0, 250);
        break;
    }
    $pdf->MultiCell(25, 5,"---",1, 'C', 0, 0, 0+($j*25));
}
//Get Total Charges
foreach ($charges as $i=>$c):
    $pdf->SetFont('helvetica', 'N', 10);
    switch ($c->item_description) {
        case 'Tuition Fee(monthly)':
            $tuition_charge = $c->amount;
            $pdf->MultiCell(25, 5,(number_format($c->amount,2,'.',',')),1, 'C', 0, 0, 175);
            break;
        case 'Books':
            $books_charge = $c->amount;
            $pdf->MultiCell(25, 5,(number_format($c->amount,2,'.',',')),1, 'C', 0, 0, 200);
            break;
        case 'Registration':
            $registration_charge = $c->amount;
            $pdf->MultiCell(25, 5,(number_format($c->amount,2,'.',',')),1, 'C', 0, 0, 100);
            break;
        case 'Technology Fee':
            $technology_charge = $c->amount;
            $pdf->MultiCell(25, 5,(number_format($c->amount,2,'.',',')),1, 'C', 0, 0, 150);
            break;
        default:
            $misc_fee+=$c->amount;
            break;
    }
    $totalFees += $c->amount;
endforeach;
$misc_charge = $misc_fee;
$pdf->MultiCell(25, 5,(number_format($totalFees,2,'.',',')),1, 'C', 0, 0, 225);
$pdf->MultiCell(25, 5,(number_format($misc_fee,2,'.',',')),1, 'C', 0, 0, 125);

$pdf->SetFont('helvetica', '', 11);
$pdf->MultiCell(200, 0, 'SCHOOL FEES: '.(number_format($totalFees,2,'.',',')), 0, 'L', 0, 1,200,45);

$pdf->SetY(80);
$pdf->SetFont('helvetica', '', 10);
$per_transaction_total = 0;

$q = $this->db->get('c_finance_transactions');
$pdf->MultiCell(25, 9,$q, 1, 'C', 0, 0,25);

$dates_array = array();
$miscs = array();



function row($pdf){
    for($i=1;$i<=8;$i++){
        $pdf->MultiCell(25, 9,"",1, 'C', 0, 0, 50+($i*25));
    }
}

function row_transaction($pdf,$section,$x_coordinate){
    if($section!=0){
        $pdf->MultiCell(25, 9,"\n".(number_format($section,2,'.',',')),1, 'C', 0, 0, $x_coordinate);
    }else {
        $pdf->MultiCell(25, 9,"",1, 'C', 0, 0, $x_coordinate);
    }
}

$misc_fee = 0;
$previous_OR = NULL;
foreach($transaction->result() as $index => $t){  
    $current_OR = $t->ref_number;
    if($previous_OR == $current_OR){
        continue;
    }
    row($pdf);
    $pdf->MultiCell(25, 9,"\n".$t->t_date, 1, 'C', 0, 0,25);
    $pdf->MultiCell(25, 9, "\n".$t->ref_number, 1, 'C', 0, 0, 50); 
    
    foreach($transaction->result() as $index=>$tr){
        if($current_OR == $tr->ref_number){
                switch ($tr->item_description) {
                    case 'Tuition Fee(monthly)':
                        $transaction_total += $tr->t_amount;
                        $tuition_fee += $tr->t_amount;
                        break;
                    case 'Books':
                        $transaction_total += $tr->t_amount;
                        $books_fee += $tr->t_amount;
                        break;
                    case 'Registration':
                        $transaction_total += $tr->t_amount;
                        $registration_fee += $tr->t_amount;
                        break;
                    case 'Technology Fee':
                        $transaction_total += $tr->t_amount;
                        $technology_fee += $tr->t_amount;
                        break;
                    default:
                        $transaction_total += $tr->t_amount;
                        $misc_fee+=$tr->t_amount;   
                        break;
                }
        }
            continue;
    }
    //array values for columns to use in DUE FOR THE MONTH
    $registration_array[]= $registration_fee;
    $misc_array[]= $misc_fee;
    $technology_array[]= $technology_fee;
    $tuition_array[]= $tuition_fee;
    $books_array[]= $books_fee;
    $date_array[]= $t->t_date;

    //display transaction for each rows
    row_transaction($pdf,$registration_fee,100);
    row_transaction($pdf,$misc_fee,125);
    row_transaction($pdf,$technology_fee,150);
    row_transaction($pdf,$tuition_fee,175);
    row_transaction($pdf,$books_fee,200);

    $totalFees -=$transaction_total;

    row_transaction($pdf,$transaction_total,225);
    row_transaction($pdf,$totalFees,250);

    $registration_fee=0;
    $technology_fee=0;
    $books_fee=0;
    $tuition_fee=0;
    $misc_fee=0;

    $transaction_total =0;
    $previous_OR = $current_OR;
    $pdf->Ln();
}

$pdf->SetXY(25,155);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(100, 5, "DUE FOR THE MONTH: ", 0, 'l', 0, 1,30);

$headers=array("OLD ACCOUNT","REGISTRATION","MISCELLANEOUS", "TECH. FEE", "TUITION", "BOOKS", "SUB-TOTAL", "ARREARS");

foreach($headers as $key=>$row){
    $pdf->SetFont('helvetica', 'B', 7.4);
    $pdf->MultiCell(25,12, "\n".$row, 1, 'C',0,0,75+($key*25),165);
}

//check DUE FOR THE MONTH registration charge
if(new DateTime($date_array[count($date_array)-1]) > new DateTime('2020-10-01')){
    $pdf->MultiCell(25, 9,"\n".(number_format($registration_charge - array_sum($registration_array),2,'.',',')),1, 'C', 0, 0,100,177);
    $subtotal += ($registration_charge - array_sum($registration_array)); 
}
else{
    if($registration_charge/2 < $registration_charge - array_sum($registration_array)){
        $pdf->MultiCell(25, 9,"\n".(number_format($registration_charge/2,2,'.',',')),1, 'C', 0, 0,100,177);
        $subtotal += $registration_charge/2; 
    }
    else{
        $pdf->MultiCell(25, 9,"\n".(number_format($registration_charge - array_sum($registration_array),2,'.',',')),1, 'C', 0, 0,100,177);
        $subtotal += ($registration_charge - array_sum($registration_array)); 
    }
}

//check DUE FOR THE MONTH miscellaneous charge
if(new DateTime($date_array[count($date_array)-1]) > new DateTime('2021-02-01')){
    $pdf->MultiCell(25, 9,"\n".(number_format($misc_charge - array_sum($misc_array),2,'.',',')),1, 'C', 0, 0,125,177);
    $subtotal += ($misc_charge - array_sum($misc_array)); 
}
else{
    if($misc_charge/6 < $misc_charge - array_sum($misc_array)){
        $pdf->MultiCell(25, 9,"\n".(number_format($misc_charge/6,2,'.',',')),1, 'C', 0, 0,125,177);
        $subtotal += $misc_charge/6; 
    }
    else{
        $pdf->MultiCell(25, 9,"\n".(number_format($misc_charge - array_sum($misc_array),2,'.',',')),1, 'C', 0, 0,125,177);
        $subtotal += ($misc_charge - array_sum($misc_array)); 
    }
}

//check DUE FOR THE MONTH technology charge
if(new DateTime($date_array[count($date_array)-1]) > new DateTime('2020-11-01')){
    $pdf->MultiCell(25, 9,"\n".(number_format($technology_charge - array_sum($technology_array),2,'.',',')),1, 'C', 0, 0,150,177);
    $subtotal += ($technology_charge - array_sum($technology_array));
}
else{
    if($technology_charge/3 < $technology_charge - array_sum($technology_array)){
        $pdf->MultiCell(25, 9,"\n".(number_format($technology_charge/3,2,'.',',')),1, 'C', 0, 0,150,177);
        $subtotal += $technology_charge/3;
    }
    else{
        $pdf->MultiCell(25, 9,"\n".(number_format($technology_charge - array_sum($technology_array),2,'.',',')),1, 'C', 0, 0,150,177);
        $subtotal += ($technology_charge - array_sum($technology_array));
    }
}
//check DUE FOR THE MONTH tuition charge
if(new DateTime($date_array[count($date_array)-1]) > new DateTime('2021-06-01')){
    $pdf->MultiCell(25, 9,"\n".(number_format($tuition_charge - array_sum($tuition_array),2,'.',',')),1, 'C', 0, 0,175,177);
    $subtotal += ($tuition_charge - array_sum($tuition_array));
}
else{
    if($tuition_charge/10 < $tuition_charge - array_sum($tuition_array)){
        $pdf->MultiCell(25, 9,"\n".(number_format($tuition_charge/10,2,'.',',')),1, 'C', 0, 0,175,177);
        $subtotal += $tuition_charge/10;
    }
    else{
        $pdf->MultiCell(25, 9,"\n".(number_format($tuition_charge - array_sum($tuition_array),2,'.',',')),1, 'C', 0, 0,175,177);
        $subtotal += ($tuition_charge - array_sum($tuition_array));
    }
}

//check DUE FOR THE MONTH books charge
if(new DateTime($date_array[count($date_array)-1]) > new DateTime('2021-02-01')){
    $pdf->MultiCell(25, 9,"\n".(number_format($books_charge - array_sum($books_array),2,'.',',')),1, 'C', 0, 0,200,177);
    $subtotal += ($books_charge - array_sum($books_array));
}
else{
    if($books_charge/6 < $books_charge - array_sum($books_array)){
        $pdf->MultiCell(25, 9,"\n".(number_format($books_charge/6,2,'.',',')),1, 'C', 0, 0,200,177);
        $subtotal += $books_charge/6;
    }
    else{
        $pdf->MultiCell(25, 9,"\n".(number_format($books_charge - array_sum($books_array),2,'.',',')),1, 'C', 0, 0,200,177);
        $subtotal += ($books_charge - array_sum($books_array));
    }
}

// $subtotal =($books_charge - array_sum($books_array))+ ($tuition_charge - array_sum($tuition_array)) + ($technology_charge - array_sum($technology_array)) + $misc_charge - array_sum($misc_array) + ($registration_charge - array_sum($registration_array));

$pdf->MultiCell(25, 9,"\n".(number_format($subtotal,2,'.',',')),1, 'C', 0, 0,225,177);
//Old accounts and Arrears
$pdf->MultiCell(25, 9,"\n".(number_format(0,2,'.',',')),1, 'C', 0, 0,75,177);
$pdf->MultiCell(25, 9,"\n".(number_format(0,2,'.',',')),1, 'C', 0, 0,250,177);


$pdf -> Output();