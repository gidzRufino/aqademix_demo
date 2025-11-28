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

//print_r($students->result());
foreach($students->result() as $mStudent):
    $a++;
    
    if($a==3):
       $y=165;
       $x=3;
    endif;
    

    $pdf->SetXY($x,$y);
    $pdf->SetFont('Times', 'B', 18);
    
    $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
    if($settings->set_logo!='noImage.png'):
        $pdf->Image($image_file, $x, $y, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    else:
        $image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
        $pdf->Image($image_file, $x, $y, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    endif;
    $pdf->SetX($x+30);
    $pdf->MultiCell(88, 20, $settings->set_school_name,0, 'L', 0, 0, '', '', true, 0, false, true, 20, 'T');
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 10);
    $pdf->Ln(-12);
    $pdf->SetX($x);
    $pdf->MultiCell(15, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->MultiCell(88, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(7);
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(105, 5, 'CLASS CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->SetX($x);
    $pdf->MultiCell(28, 5, 'Grading Period :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(20, 5, ucfirst($term),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 5, 'Grade Level :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 5, $mStudent->level.' - '.$section->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x);
    $pdf->MultiCell(15, 5, 'Name :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(85, 5, strtoupper($mStudent->firstname.' '.substr($mStudent->middlename, 0,1).'. '.$mStudent->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
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
                if($singleSub->subject_id!=20):
                    $pdf->MultiCell(33, 5, Modules::run('gradingsystem/getEquivalent',round($finalGrade->row()->final_rating, 1)).' / '.round($finalGrade->row()->final_rating, 2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                else:
                    $pdf->MultiCell(33, 5, Modules::run('gradingsystem/getBGBEquivalent',round($finalGrade->row()->final_rating, 1)).' / '.round($finalGrade->row()->final_rating, 2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                endif;
                
            else:
                $pdf->MultiCell(33, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif;

            $pdf->MultiCell(33, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');  

        endforeach;
        
        $x = $x+107;
endforeach;
    




$pdf->Output('class_card.pdf', 'I');
