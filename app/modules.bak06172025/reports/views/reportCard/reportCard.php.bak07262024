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
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
//$resolution= array(166, 200);
$resolution= array(210, 297);
$pdf->AddPage('L', $resolution);

$settings = Modules::run('main/getSet');
$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
$division_logo = K_PATH_IMAGES.'/division_logo.jpg';
$principal = Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
$name = ($principal ? strtoupper($principal->firstname.' '.substr($principal->middlename, 0, 1).'. '.$principal->lastname) : '');
$adviser = Modules::run('academic/getAdvisory', '', $student->section_id);
$adv = ($adviser->num_rows() > 0 ? strtoupper($adviser->row()->firstname.' '.substr($adviser->row()->middlename, 0, 1).'. '.$adviser->row()->lastname) : '');
$first = Modules::run('gradingsystem/getCardRemarks', $student->uid,1, $sy);
$second = Modules::run('gradingsystem/getCardRemarks', $student->uid,2, $sy);
$third = Modules::run('gradingsystem/getCardRemarks', $student->uid,3, $sy);
$fourth = Modules::run('gradingsystem/getCardRemarks', $student->uid,4, $sy);


//get the birthday and the age before first friday of june
    $firstFridayOfJune =date('mdY',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $student->temp_bdate;
    $bdateItems = explode('-', $bdate);
    $m = $bdateItems[0];
    $d = $bdateItems[1];
    $y = $bdateItems[2];
    $thisYearBdate = $m.$d.$settings->school_year;
    $now = $settings->school_year;
    $age = abs($now - $y);
    
    if(abs($thisYearBdate>$firstFridayOfJune)){
        $yearsOfAge = $age - 1;
    }else{
        $yearsOfAge = $age;
    }

$pdf->SetFont('helvetica', 'B', 8);
//start of the left column
$pdf->SetY(3);
$pdf->MultiCell(148, 0, 'Puna ng Guro',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');



$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(8);
$pdf->SetX(10);
$pdf->MultiCell(30, 10, 'Unang Markahan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(100 , 10, ($first->num_rows() > 0 ? $first->row()->remarks : ''),1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
//$pdf->Ln();
//$pdf->SetX(40);
//$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Lagda ng Magulang',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 10, 'Ikalawang
Markahan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(100 , 10, ($second->num_rows() > 0 ? $second->row()->remarks : ''),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
//$pdf->SetX(40);
//$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Lagda ng Magulang',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 10, 'Ikatlong Markahan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(100 , 10, ($third->num_rows() > 0 ? $third->row()->remarks : ''),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
//$pdf->SetX(40);
//$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Lagda ng Magulang',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 10, 'Ikaapat Markahan',1, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(100 , 10, ($fourth->num_rows() > 0 ? $fourth->row()->remarks : ''),1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();
//$pdf->SetX(40);
//$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
//$pdf->Ln();
$pdf->SetX(10);
$pdf->MultiCell(30, 5, 'Lagda ng Magulang',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(10);
$pdf->MultiCell(148, 0, 'BALANGKAS NG PAGMAMARKA',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(75, 5, 'Karapat-dapat ilipat at tanggapin sa',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->MultiCell(75, 5, 'May paunang yunit sa larangan ng',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);    
$pdf->MultiCell(75, 5, 'May kulang na yunit sa larangan ng',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->MultiCell(75, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->MultiCell(75, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 0, 'Tagapagpayo','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(5);
$pdf->SetX(30);
$pdf->MultiCell(40, 5, $name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(30);
$pdf->MultiCell(40, 0, 'Punong - Guro','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(15);
$pdf->MultiCell(148, 0, 'KATIBAYAN SA PAGLIPAT NG TAON',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(40, 5, 'Ililipat sa Taon',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(14 , 5, 'Pangkat',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(40, 5, 'Pinagtibay',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();    
$pdf->MultiCell(40, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Tagapagpayo',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Punong - Guro',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(15);
$pdf->MultiCell(148, 0, 'PAGPAPAWALANG-BISA SA KARAPATANG LUMIPAT',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(40, 5, 'Ililipat sa Taon',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(14 , 5, 'Pangkat',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(35 , 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);    
$pdf->MultiCell(40, 5, 'Pinagtibay',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $adv,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();    
$pdf->MultiCell(40, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Tagapagpayo',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20 , 5, '',0 , 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, 'Punong - Guro',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

//start of right column
$pdf->SetY(3);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);



$pdf->SetFont('helvetica', 'N', 5);
$pdf->SetXY(155, 3);
$pdf->MultiCell(0, 0, 'DepED Form 138-A',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY(155, 10);
$pdf->SetFont('helvetica', 'B', 10);
// Title Right Side Column
$pdf->MultiCell(0, 0, 'Republika ng Pilipinas',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'KAGAWARAN NG EDUKASYON',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'Region '.$settings->region,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(155);
$pdf->MultiCell(0, 0, 'Sangay ng Lungsod ng Cagayan de Oro',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetX(148);
$pdf->MultiCell(50, 5, 'Mataas na Paaralang',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, strtoupper($settings->set_school_name),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(159);
$pdf->MultiCell(20, 5, 'Pangalan',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(100 , 5, strtoupper($student->lastname.', '.$student->firstname.' '.substr($student->middlename, 0, 1).'. '),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(161);
$pdf->MultiCell(15, 5, 'Gulang',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $yearsOfAge,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(8 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Kasarian',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(8);
$pdf->SetX(161);
$pdf->MultiCell(15, 5, 'Taon',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40 , 5, $student->level,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7 , 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Pangkat',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30 , 5, $student->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$next = $sy + 1;

$pdf->Ln(20);
$pdf->SetX(155);
$pdf->MultiCell(0, 5, $sy.' - '.$next,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(185);
$pdf->MultiCell(20, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 0, 'Taong - Panuruan','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 8);
$pdf->Ln(15);
$pdf->SetX(165);
$pdf->MultiCell(0, 0, 'Mahal na Magulang,',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(10);
$pdf->SetX(185);
$pdf->Cell(0,0,'Nakapaloob sa kard na ito ang ulat sa pagunlad ng inyong bilang ng araw at ',0,0,'L');
$pdf->Ln(5);
$pdf->SetX(165);
$pdf->Cell(0,0,'pagpasok, bilang ng pagliban at pagdating ng huli sa klase, at mga pag-uugali at kaasalang',0,0,'L');
$pdf->Ln(5);
$pdf->SetX(165);
$pdf->Cell(0,0,' inpinamalas niya sa loob ng paaralan ',0,0,'L');
$pdf->Ln(10);
$pdf->SetX(165);
$pdf->Cell(0,10,'Mangyari pong makipag-ugnayan sa amin tungkol sa anumang bagay na makatutulong sa',0,0,'L');
$pdf->Ln(5);
$pdf->SetX(165);
$pdf->Cell(0,10,'pag-unlad ng inyong anak.',0,0,'L');
$pdf->Ln(10);
$pdf->SetX(148);
$pdf->Cell(130,10,'Salamat po.',0,0,'R');

$pdf->Ln(15);
$pdf->SetX(148);
$pdf->MultiCell(90, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, $adv,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(148);
$pdf->MultiCell(90, 0, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 0, 'Tagapagpayo','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln(10);
$pdf->SetX(165);
$pdf->MultiCell(40, 5, $name,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->SetX(165);
$pdf->MultiCell(40, 0, 'Punong - Guro','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetFont('helvetica', 'I', 6);
$pdf->Ln(8);
$pdf->Ln();
$pdf->SetX(165);
$pdf->MultiCell(130, 0, '(This is a computer generated school form)',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Image($image_file, 165, 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Image($division_logo, 265 , 15, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Line(148, 5, 148, 1, array('color' => 'black'));


//back page



$pdf->AddPage();
$data['student'] = $student;
$data['sy'] = $sy;
$data['term'] = $term; 
$data['pdf'] = $pdf;
$data['settings'] = $settings;
$this->load->view('reportCard/reportCardSecondPage', $data);

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