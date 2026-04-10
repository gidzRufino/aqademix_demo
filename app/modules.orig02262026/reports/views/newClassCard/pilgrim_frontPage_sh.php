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

switch (segment_5){
     case 1:
     case 2:
         $sem = 1;
         $term = 'First';
         $one = '1';
         $two = '2';
     break;
     case 3:
     case 4:
         $sem = 2;
         $term = 'Second';
         $one = '3';
         $two = '4';
     break;
}

$strand_id = $this->uri->segment(8);
$settings = Modules::run('main/getSet');
$section = Modules::run('registrar/getSectionById', segment_4);
$students = Modules::run('registrar/getStudentForCard', segment_7,segment_6, segment_4);
$sy = $this->session->userdata('school_year');
$x=3;
$y=5;
$a=0;

//print_r($students->result());
foreach($students->result() as $mStudent):
    
    $coreSubs = Modules::run('subjectmanagement/getSHSubjects', $section->grade_id, $sem, $mStudent->strnd_id, 1);  
    $appliedSubs = Modules::run('subjectmanagement/getSHSubjects', $section->grade_id, $sem, $mStudent->strnd_id);  
    
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
    
    
    $pdf->Ln(18);
    
    $pdf->SetFont('helvetica', 'b', 10);
    $pdf->SetX($x);
    $pdf->MultiCell(115, 5, 'SENIOR HIGH SCHOOL CLASS CARD',0, 'C', 0, 0, '', '', true, 0, false, true, 30, 'T');
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->SetX($x);
    $pdf->MultiCell(20, 5, 'Semester :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(15, 5, ucfirst($term),'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 5, 'Grade Level :',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(40, 5, $mStudent->level.' - '.$section->section,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x);
    $mn = ($mStudent->middlename==""?"":substr($mStudent->middlename, 0,1).'.');
    $pdf->MultiCell(15, 5, 'Name :',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(85, 5, strtoupper($mStudent->firstname.' '.$mn.' '.$mStudent->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->Ln(8);
    $pdf->SetX($x+2);
    $pdf->MultiCell(45, 10, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 5, 'Quarter',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 10, 'Semester Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->SetXY($x+47, $y+47);
    $pdf->MultiCell(15, 5, $one,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, $two,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    
    $pdf->SetFillColor(150, 166, 234);
    $pdf->Ln();
    $pdf->SetX($x+2);
    $pdf->MultiCell(100, 5, 'Core Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'T');
    $mp = 0;
    $m = 0;
    foreach($coreSubs as $sub):
     
            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
            $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $one, $sy); 
            $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $two, $sy); 
            $pdf->Ln();
            $pdf->SetX($x+2);
            if($sub->is_core):
                $mp++;
                $pdf->SetFont('helvetica', 'b', 7);
                $pdf->MultiCell(45, 5,'     '.$sub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            endif;
            if($sub->is_core):
                if($firstGrade->row()->final_rating!=""):
                    $pdf->MultiCell(15, 5, $firstGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(15, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                    $pdf->MultiCell(25, 5, round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                    $coreTotal += round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2);
                else:
                    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                    $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                    $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                endif; 
            endif; 
            
    endforeach;
    $pdf->Ln();
    $pdf->SetX($x+2);
    $pdf->SetFont('helvetica', 'b', 9);
    $pdf->MultiCell(100, 5, 'Applied and Specialized Subjects',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');   
    
    foreach($appliedSubs as $sub):
            $singleSub = Modules::run('academic/getSpecificSubjects', $sub->sh_sub_id);
            $firstGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $one, $sy); 
            $secondGrade = Modules::run('gradingsystem/getFinalGrade', $mStudent->st_id, $singleSub->subject_id, $two, $sy); 
            $pdf->Ln();
            $pdf->SetX($x+2);
            $pdf->SetFont('helvetica', 'b', 7);
            $pdf->MultiCell(45, 5,'     '.$sub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $mp++;
            if($firstGrade->row()->final_rating!=""):
                $pdf->MultiCell(15, 5, $firstGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, ($secondGrade->row()?$secondGrade->row()->final_rating:''),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(25, 5, round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2), 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $appliedTotal += round(($firstGrade->row()->final_rating+$secondGrade->row()->final_rating)/2,2);
            else:
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
                $pdf->MultiCell(25, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
            endif; 
            

    endforeach; 
            $genTotal = $coreTotal + $appliedTotal;
            $genAve = round($genTotal/$mp, 2);
            $pdf->Ln();
            $pdf->SetX($x+2);
            $pdf->MultiCell(100, 5, '',1, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');$pdf->Ln();
            $pdf->SetX($x+27);
            $pdf->SetFont('helvetica', 'b', 7);
            $pdf->MultiCell(50, 5, 'General Average for the Semester',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(25, 5, $genAve,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
            unset($mp);
        unset($coreTotal);
        unset($appliedTotal);
        
         
        $pdf->SetAlpha(0.1);
        $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
        $pdf->Image($image_file, $x+5, $y+15, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $pdf->SetAlpha(1);
        
        $adviser = Modules::run('academic/getAdvisory', '', $settings->school_year, segment_4);
        

        $pdf->SetXY($x+2,$y+130);
        
        $pdf->MultiCell(50, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(50, 5, strtoupper($adviser->row()->firstname.' '.$adviser->row()->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(50, 5, '',0, 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(50, 5, 'Adviser',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln(5);
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(60, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $pdf->SetX($x+2);
        $pdf->MultiCell(60, 5, 'Parent\'s Signature',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->Ln();
        
        $x = $x+107;
endforeach;



$pdf->Output('class_card.pdf', 'I');
