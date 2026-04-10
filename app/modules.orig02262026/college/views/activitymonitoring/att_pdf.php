<?php
class MYPDF extends Pdf {
    public function Header() {
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

$settings = Modules::run('main/getSet');
$sy = $this->session->userdata('school_year');

$x=10;
$y=10;
$a=0;
if($type == 1):
    $pdf->SetX($x);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->MultiCell(195, 7, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->SetX($x);
    $pdf->MultiCell(195, 5, 'United Church of Christ in the Philippines',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell(195, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(7);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->SetX($x);


    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if($settings->set_logo!='noImage.png'):
        $pdf->Image($image_file, $x+55, $y, 14, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    else:
        $image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
        $pdf->Image($image_file, $x, $y, 12, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    endif;
    
    $image_file = K_PATH_IMAGES.'/uccp.jpg';
    $pdf->Image($image_file, $x+127, $y, 12, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    $pdf->Ln(30);
endif;
    
$x += 15;
$pdf->SetFont('helvetica', 'B', 12);
$pdf->setX($x);
$pdf->MultiCell(110, 7, "Activity: ".$activity->act_title,0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(110, 7, "Activity Time: ".Date("h:i a", strtotime($activity->act_time)),0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln();
$pdf->setX($x);
$pdf->MultiCell(110, 7, "Activity Date: ".Date("F d, Y", strtotime($activity->act_date)),0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(110, 7, "Activity Attendee: ".$att_count,0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->Ln(20);

$x = $x-17;
$y = $y+35;
$countLength = 13;
$nameLength = 90;
$gsLength = 45;
$timeLength = 25;
$global = $countLength+$nameLength+$gsLength+($timeLength*2);

$attendances = Modules::run('college/activity/getAttendeeAttendance', $act_id, 1);

if(!empty($attendances)):

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX($x);
    $pdf->MultiCell($global, '', 'GRADE SCHOOL AND HIGHSCHOOL STUDENTS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell($countLength, '', '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($nameLength, '', 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($gsLength, '', 'Grade/Section',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time In',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time Out',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'R', 10);

    $c = 1;
    foreach($attendances AS $att):
        $name = strtoupper($att->firstname." ".$att->lastname);
        $pdf->setX($x);
        $pdf->MultiCell($countLength, '', $c,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($nameLength, '', $name,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($gsLength, '', $att->level." - ".$att->section,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', Date("h:i a", strtotime($att->act_in)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', ($att->act_out != "00:00:00") ? Date("h:i a", strtotime($att->act_out)) : "-",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $c++;
    endforeach;
    $pdf->Ln(10);
endif;

$attendances = Modules::run('college/activity/getAttendeeAttendance', $act_id, 2);

if(!empty($attendances)):
    
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX($x);
    $pdf->MultiCell($global, '', 'COLLEGE STUDENTS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell($countLength, '', '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($nameLength, '', 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($gsLength, '', 'Course & Year',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time In',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time Out',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'R', 10);

    $c = 1;
    foreach($attendances AS $att):
        $name = strtoupper($att->firstname." ".$att->lastname);
        $pdf->setX($x);
        $pdf->MultiCell($countLength, '', $c,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($nameLength, '', $name,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($gsLength, '', $att->short_code." - ".$att->year_level,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', Date("h:i a", strtotime($att->act_in)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', ($att->act_out != "00:00:00") ? Date("h:i a", strtotime($att->act_out)) : "-",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $c++;
    endforeach;
    $pdf->Ln(10);
endif;
$attendances = Modules::run('college/activity/getAttendeeAttendance', $act_id, 3);

if(!empty($attendances)):

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetX($x);
    $pdf->MultiCell($global, '', 'FACULTY AND STAFF',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell($countLength, '', '#',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($nameLength, '', 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($gsLength, '', 'Position',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time In',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell($timeLength, '', 'Time Out',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'R', 10);


    $c = 1;
    foreach($attendances AS $att):
        $name = strtoupper($att->firstname." ".$att->lastname);
        $pdf->setX($x);
        $pdf->MultiCell($countLength, '', $c,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($nameLength, '', $name,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($gsLength, '', $att->position,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', Date("h:i a", strtotime($att->act_in)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell($timeLength, '', ($att->act_out != "00:00:00") ? Date("h:i a", strtotime($att->act_out)) : "-",1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        $c++;
    endforeach;
endif;

$pdf->Output($activity->act_title.'_'.Date("m-d-Y", strtotime($activity->act_date)).'.pdf', 'I');