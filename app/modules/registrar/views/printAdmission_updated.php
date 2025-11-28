<?php

class MYPDF extends Pdf {
    //Page header
    public function Header() {
        // Logo
        $settings = Modules::run('main/getSet');
        $this->SetFont('helvetica', 'B', 23);
        $this->SetTextColor(31,68,30);
        $this->MultiCell(180, 5, $settings->set_school_name, 0, 'C', 0, 1,20,15);
        $this->SetFont('helvetica', '', 10);
        $this->SetTextColor(0,0,0);
        $this->MultiCell(180, 5, $settings->set_school_address, 0, 'C', 0, 1,20);
        $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
        $this->Image($image_file, 15, 15, 20, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
    public function Footer() {

    }
}
// define('K_TCPDF_THROW_EXCEPTION_ERROR', false);
$f_occ = Modules::run('registrar/getOccupation', $students->f_occ);
$m_occ = Modules::run('registrar/getOccupation', $students->m_occ);
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage('P', 'A4');
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->SetFillColor(200,198,167);

// $image_file ='uploads/109.png';
$sy=$details->school_year;

$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(138, 6,"S.Y. ".$sy." - ".++$sy, 0, 'C', 0, 1,41,30);


if($details->avatar != ''){
    $image_file = base_url().'uploads/'.$details->avatar;
}
$pdf->Image($image_file, 15, 41, 35, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

//border
$pdf->SetLineStyle( array( 'width' => 0.5, 'color' => array(0,0,0)));
$pdf->Rect(5, 5, $pdf->getPageWidth()-10, $pdf->getPageHeight()-10);

$pdf->SetFont('helvetica', 'B', 18);
$pdf->SetTextColor(255,0,0);
$pdf->MultiCell(120, 5,$details->firstname . ' ' . ($details->middlename != "" ? substr($details->middlename, 0, 1) . '. ' : "") . $details->lastname, 0, 'L', 0, 1,58,50);

$pdf->SetFont('helvetica', '', 18);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(80, 5,$details->level." - ".$details->section, 0, 'L', 0, 1,58);
$pdf->SetFont('helvetica', '', 11);
$pdf->MultiCell(80, 5,'LRN: '.$details->lrn, 0, 'L', 0, 1,58);

$pdf->SetFont('helvetica', '', 13);
$pdf->MultiCell(80, 5,'', 0, 'L', 0, 1,58);

$pdf->SetFillColor(96,124,60);
$pdf->SetTextColor(255,255,255);

$html = '<h2><b>PERSONAL INFORMATION</b></h2>';
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->writeHTMLCell(180,5,'','',$html,0,1,1);
$pdf->Line($pdf->GetX(), $pdf->GetY(),$pdf->GetX()+180, $pdf->GetY(), $style2);

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 9);

$personal_information = array("Address","Contact No","Gender","Birthdate","Religion");

foreach ($personal_information as $key => $row) {
    $pdf->MultiCell(30, 6,$row." :", 1, 'R', 1, 1,20,'',true,0,false,true,6,'M');
}

$html = '<h2><b>FAMILY INFORMATION</b></h2>';
$pdf->Ln(15);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->writeHTMLCell(180,5,'','',$html,0,1,1);
$pdf->Line($pdf->GetX(), $pdf->GetY(),$pdf->GetX()+180, $pdf->GetY(), $style2);

// $family_information_first_column = array("Father's Name","Education","Occupation","Office","Contact","Office City","Office Street");
$family_information_first_column = array("Father's Name","Education","Occupation","Office","Contact");
$family_information_second_column = array("Mother's Name","Education","Occupation","Office","Contact");

$pdf->Ln(5);
foreach ($family_information_first_column as $key => $row) {
    $pdf->MultiCell(30, 6,$row." :", 1, 'R', 1, 1,20,'',true,0,false,true,6,'M');
}
$pdf->SetY($pdf->GetY()-30);
foreach ($family_information_second_column as $key => $row) {
    $pdf->MultiCell(30, 6,$row." :", 1, 'R', 1, 1,108,'',true,0,false,true,6,'M');
}

$html = '<h2><b>LAST SCHOOL ATTENDED</b></h2>';
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->writeHTMLCell(180,5,'','',$html,0,1,1);
$pdf->Line($pdf->GetX(), $pdf->GetY(),$pdf->GetX()+180, $pdf->GetY(), $style2);

$pdf->Ln(5);
$pdf->MultiCell(30, 6,"School Name:", 1, 'R', 1, 1,20,'',true,0,false,true,6,'M');
$pdf->MultiCell(30, 6,"School Address:", 1, 'R', 1, 1,20,'',true,0,false,true,6,'M');
// $pdf->MultiCell(30, 6,"", 0, 'R', 0, 0,20,'',true,0,false,true,6,'M');

$html = '<h2><b>In Case of Emergency</b></h2>';

$pdf->Ln(25);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->writeHTMLCell(180,5,'','',$html,0,1,1);
$pdf->Line($pdf->GetX(), $pdf->GetY(),$pdf->GetX()+180, $pdf->GetY(), $style2);

$pdf->Ln(5);
$pdf->MultiCell(30, 6,"Contact Name:", 1, 'R', 1, 0,20);
$pdf->MultiCell(30, 6,"Contact Number:", 1, 'R', 1, 0,108);

$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(253,253,150);

//personal data
$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetXY(50,97.3);
$pdf->Cell(138,6,strtoupper($details->street . ', ' . $details->barangay . ', ' . $details->mun_city . ', ' . $details->province . ', ' . $details->zip_code),1,1,'L',1);
//$pdf->MultiCell(138, 6,strtoupper($details->street . ', ' . $details->barangay . ' ' . $details->mun_city . ', ' . $details->province . ', ' . $details->zip_code), 1, 'L', 0, 1,50,97.3,true,0,false,true,6,'M');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(138, 6,$details->cd_mobile, 1, 'L', 0, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(138, 6,$details->sex, 1, 'L', 1, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(138, 6,Date('m/d/Y', strtotime($details->temp_bdate)), 1, 'L', 0, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(138, 6,ucwords($details->religion), 1, 'L', 1, 1,50,'',true,0,false,true,6,'M');
// $pdf->MultiCell(138, 6,$details->school_year, 1, 'L', 0, 1,50,'',true,0,false,true,6,'M');

// family data
$pdf->MultiCell(50, 6,$details->f_firstname == ''? '':$details->f_firstname." ".$details->f_middlename." ".$details->f_lastname, 1, 'L', 1, 1,50,$pdf->GetY()+25.8,true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,'',1, 'L', 0, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$f_occ->occupation == ''? '':$f_occ->occupation,1, 'L', 1, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$details->f_office_name == ''? '':$details->f_office_name,1, 'L', 0, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$details->f_mobile == ''? '':$details->f_mobile,1, 'L', 1, 1,50,'',true,0,false,true,6,'M');

$pdf->MultiCell(50, 6,$details->m_firstname." ".$details->m_middlename." ".$details->m_lastname, 1, 'L', 1, 1,138,$pdf->GetY()-30,true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,'',1, 'L', 0, 1,138,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,'',1, 'L', 1, 1,138,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$m_occ->occupation == ''? '':$m_occ->occupation,1, 'L', 0, 1,138,'',true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$details->m_mobile == ''? '':$details->m_mobile,1, 'L', 1, 1,138,'',true,0,false,true,6,'M');
// $pdf->MultiCell(50, 6,'',1, 'L', 0, 1,138);
// $pdf->MultiCell(50, 6,'',1, 'L', 0, 1,138);


//last school attended
$pdf->MultiCell(138, 6,$details->school_last_attend,1, 'L', 1, 1,50,$pdf->GetY()+20.7,true,0,false,true,6,'M');
$pdf->MultiCell(138, 6,$details->sla_address,1, 'L', 0, 1,50,'',true,0,false,true,6,'M');
$pdf->MultiCell(138, 6,"",0, 'L', 0, 1,50,'',true,0,false,true,6,'M');



//In case of emergency
$pdf->MultiCell(50, 6,$details->ice_name,1, 'L', 1, 0,50,$pdf->GetY()+29.7,true,0,false,true,6,'M');
$pdf->MultiCell(50, 6,$details->ice_contact,1, 'L', 1, 1,$pdf->GetX()+38,'',true,0,false,true,6,'M');


$pdf -> Output();