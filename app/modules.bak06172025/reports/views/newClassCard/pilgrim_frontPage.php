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
$section = Modules::run('registrar/getSectionById', segment_4);
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $section->grade_id);  
$students = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$sy = $this->session->userdata('school_year');

switch (segment_5){
     case 1:
         $term = 'first';
     break;
     case 2:
         $term = 'second';
     break;
     case 3:
         $term = 'third';
     break;
     case 4:
         $term = 'fourth';
     break;
}
$x=3;
$y=5;
$a=0;
$genAve = 0;

//print_r($students->result());
foreach($students->result() as $mStudent):
    $a++;
    
    if($a==3):
       $y=165;
       $x=3;
    endif;
    

    $pdf->SetXY($x,$y);
    
    $pdf->SetFont('Times', 'B', 12);
    $pdf->MultiCell(110, 7, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->SetX($x);
    $pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->MultiCell(88, 5, 'United Church of Christ in the Philippines',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
    $pdf->Ln();
    $pdf->SetX($x);
    $pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(88, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(7);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->SetX($x);
    
    
    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if($settings->set_logo!='noImage.png'):
        $pdf->Image($image_file, $x+10, $y, 14, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    else:
        $image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
        $pdf->Image($image_file, $x, $y, 12, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    endif;
    
    $image_file = K_PATH_IMAGES.'/uccp.jpg';
    $pdf->Image($image_file, $x+85, $y, 12, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    
    
    $pdf->Ln(25);
    $pdf->MultiCell(105, 5, 'CLASS CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->SetX($x);
    $pdf->MultiCell(28, 5, 'Grading Period :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(15, 5, ucfirst($term),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 5, 'Grade Level :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(35, 5, $mStudent->level.' - '.$section->section,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x);
    $mn = ($mStudent->middlename==""?"":substr($mStudent->middlename, 0,1).'.');
    $pdf->MultiCell(15, 5, 'Name :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(85, 5, strtoupper($mStudent->firstname.' '.$mn.' '.$mStudent->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x+2);
    $pdf->MultiCell(33, 5, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(33, 5, 'GRADE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(33, 5, 'REMARKS',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        foreach($subject_ids as $sub):
          $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sub_id);
            $finalGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, segment_5, $sy); 
            $pdf->Ln();
            $pdf->SetX($x+2);
            
            
            $pdf->MultiCell(33, 5, $singleSub->short_code,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            if($finalGrade->row()->final_rating!=""):
                $genAve += $finalGrade->row()->final_rating;
                $pdf->MultiCell(33, 5, $finalGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            else:
                $pdf->MultiCell(33, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif;
            if($finalGrade->row()->final_rating>=75):
                $pdf->MultiCell(33, 5, 'PASSED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            else:
                $pdf->MultiCell(33, 5, 'FAILED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;

        endforeach;
        $pdf->Ln();
        $pdf->SetX($x+2);
        $pdf->MultiCell(33, 5, 'Gen. Ave.',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(33, 5, round(($genAve/ count($subject_ids)),2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(33, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        
        
        $pdf->SetAlpha(0.1);
        $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
        $pdf->Image($image_file, $x+5, $y+15, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $pdf->SetAlpha(1);
        
        $adviser = Modules::run('academic/getAdvisory', '', $settings->school_year, segment_4);
        

        $pdf->SetXY($x+2,$y+110);
        
        $pdf->MultiCell(40, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(60, 5, strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(40, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(60, 5, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln(20);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(60, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(60, 5, 'Parent\'s Signature',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $x = $x+107;
        $genAve = 0;
        
        
endforeach;
    




$pdf->Output('class_card.pdf', 'I');
