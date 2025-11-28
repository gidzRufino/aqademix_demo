<?php
class MYPDF extends Pdf {
    //Page header
	public function Header() {

            $this->SetTitle('DepED Form 138-A');

        }

}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(1.53);
// remove default header/footer
//$resolution= array(166, 200);
$resolution= array(250, 297);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
//$image_file = K_PATH_IMAGES.'/aac.png';
$cardBG = K_PATH_IMAGES.'/card_bg.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname);
$adviser = Modules::run('academic/getAdvisory', NULL,segment_4, $student->section_id);
$adv = strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname);
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);


//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('Y-m-d',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->cal_date;
//    $from = new DateTime($bdate);
//    $to   = new DateTime($firstFridayOfJune);
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $y = $bdateItems[0];

    if(abs(date('m')<$m)){
        $yearsOfAge  = ((date('Y') - date('Y',strtotime($bdate))))-1;

    }else{
        $yearsOfAge = (date('Y') - date('Y',strtotime($bdate)));
    }

$pdf->SetFont('helvetica', 'B', 10);
//start of the left column

$pdf->SetXY(5,3);
$pdf->MultiCell(140, 12, 'This is senior high school',0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->Ln();
$pdf->SetXY(5,3);
$pdf->Ln(150);
$pdf->MultiCell(140, 50, "Adventist Academy of Cebu, as part of the global education system of the Seventh-day Adventist Church, recognizes God as the ultimate source of existence and truth. In the beginning God created a perfect humaniy in His image a perfection later marred by sin. Every human being, although fallen, is endowed with attributes akin to those of the Creator. Therefore, Adventist education seeks to nurture in every student maximum development of one's potential; loving service rather than selfish ambition; and appreciation for all that is beautiful, true and good.",0, 'C', 0, 0, '', '', true, 0, false, true, 50, 'T');




//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

$pdf->Image($cardBG, 148, 8, 230, 350, 'JPG', '', 'T', false, 300, '', false, false, 0);
//$pdf->Image($image_file, 210, 90, 30, '', 'PNG', '', 'T', false, 100, '', false, false, 0);

$pdf->SetXY(148, 0);

$pdf->SetFillColor(57,117,215);
$pdf->MultiCell(150, 15, '', 0, 'C', 1, 0,'','',true,0,false,true, 15,'M');
// Title Right Side Column
$pdf->Ln(20);
$pdf->SetX(155);
$pdf->SetFont('Courier', 'B', 25);
//$pdf->Cell(0,60,strtoupper($settings->set_school_name),0,0,'C');
$pdf->MultiCell(140, 12, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 12, 'M');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(10);
$pdf->SetX(155);
$pdf->MultiCell(140, 5, strtoupper($settings->set_school_address),0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(4);
$pdf->SetX(155);
$pdf->MultiCell(140, 5, 'Tel. No.:(032)233-9593',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');


$pdf->SetFont('helvetica', 'I', 6);
$pdf->SetXY(165,240);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//back page



$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term;
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$data['behaviorRate'] = $behavior;
$data['adv'] = $adv;
$data['name'] = $name;
$this->load->view('reportCard/'.strtolower($settings->short_name).'_back_sh', $data);

//$pdf->Ln(10);
//$pdf->StartTransform();
//$pdf->Rotate(90);
//$pdf->Cell(0,0,'This is a sample data',1,1,'L',0,'');
//$pdf->StopTransform();
//Close and output PDF document
ob_end_clean();
$pdf->Output('DepED Form 138-A.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
