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


$first_row = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$second_row = Modules::run('registrar/getStudentForCard', segment_7+2 ,segment_6, segment_4);
$behavior = Modules::run('gradingsystem/getBH');

$sy = $this->session->userdata('school_year');

$x=3;
$y=5;
$a=0;

foreach(array_reverse($first_row->result()) as $student){
    $remarks = Modules::run('gradingsystem/getCardRemarks', $student->st_id,segment_5, $sy);
    $pdf->SetXY($x,$y);
    $pdf->SetFont('helvetica', 'b', 12);
    $pdf->MultiCell(105, 5, 'PERSONALITY ATTRIBUTE ','R', 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->SetX($x+2);
    $pdf->MultiCell(45, 5, 'ATTRIBUTES',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, 'GRADE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(19, 5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    
    foreach ($behavior as $beh):
        $bhRating = getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,segment_5, $sy, $beh->bh_id));
    if($bhRating!=""):
            $r = 'PASSED';
        else:
            $r ='';
        endif;
        $pdf->Ln();
        $pdf->SetX($x+2);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(45, 7, $beh->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->MultiCell(35, 7,$bhRating,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(19, 7, $r,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    endforeach;
    
    
    $pdf->Ln(9);
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->MultiCell(37, 5, 'Teacher\'s Comment',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->SetFont('helvetica', 'n', 8);
    $pdf->MultiCell(63, 5, $remarks->row()->remarks,'B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln();
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(10, 5, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, date('m/d/Y'),'B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(35, 5, 'Teacher\'s Signature',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');

    $pdf->Ln(9);
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->MultiCell(35, 5, 'Parent\'s Feedback',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(65, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln();
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(10, 5, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(35, 5, 'Parent\'s Signature',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $x = $x+107;
}



$x=3;
$y=165;

foreach(array_reverse($second_row->result()) as $student){
    $secondRemarks = Modules::run('gradingsystem/getCardRemarks', $student->st_id,segment_5, $sy);
    $pdf->Ln();
    $pdf->SetXY($x,$y);
    $pdf->SetFont('helvetica', 'b', 12);
    $pdf->MultiCell(105, 5, 'PERSONALITY ATTRIBUTE ','R', 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->SetX($x+2);
    $pdf->MultiCell(45, 5, 'ATTRIBUTES',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, 'GRADE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(19, 5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    
    foreach ($behavior as $beh):
        $bhRating = getRating(Modules::run('gradingsystem/getBHRating', $student->st_id,segment_5, $sy, $beh->bh_id));
        if($bhRating!=""):
            $r = 'PASSED';
        else:
            $r ='';
        endif;
        $pdf->Ln();
        $pdf->SetX($x+2);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell(45, 7, $beh->bh_name,1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->SetFont('helvetica', 'N', 8);
        $pdf->MultiCell(35, 7,$bhRating,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
        $pdf->MultiCell(19, 7, $r,1, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    endforeach;
    
    
    $pdf->Ln(9);
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->MultiCell(37, 5, 'Teacher\'s Comment',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->SetFont('helvetica', 'n', 8);
    $pdf->MultiCell(63, 5,  $secondRemarks->row()->remarks,'B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln();
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(10, 5, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, date('m/d/Y'),'B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(35, 5, 'Teacher\'s Signature',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');

    $pdf->Ln(9);
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->MultiCell(35, 5, 'Parent\'s Feedback',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(65, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln();
    $pdf->SetX($x+1);
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->MultiCell(10, 5, 'Date',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(35, 5, 'Parent\'s Signature',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $x = $x+107;
};

function getRating($behaviorRating)
{
    if($behaviorRating->num_rows()>0):
        $rate = $behaviorRating->row()->rate;
        switch ($rate)
        {
            case 1:
                $star = 'Dapat Pang linangin';
            break;    
            case 2:
                $star = 'Kasiya - siya';
            break;    
            case 3:
                $star = 'Lubhang Kasiya-siya';
            break; 

            default :
                $star = '';
            break;
        }
        return $star;
    endif;
}

$pdf->Output('class_card.pdf', 'I');