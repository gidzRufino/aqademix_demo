<?php

class MYPDF extends Pdf {
     function Header() {
        
        $settings = Modules::run('main/getSet');
        $nextYear = $settings->school_year + 1;
        $student = Modules::run('registrar/getSingleStudent', base64_decode(segment_3));
         
        $this->SetTitle('Student Permanent Record');
        $this->SetTopMargin(4);
        $depEdLogo = K_PATH_IMAGES.'/depEd_logo.jpg';
        $this->Image($depEdLogo, 175, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $divisionLogo = K_PATH_IMAGES.'/division_logo.jpg';
        $this->Image($divisionLogo, 20, 8, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 6);
        $this->SetXY(5,3);
        $this->Cell(0, 0, 'DepEd Form 137-A  '.$student->level, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->Ln();

        $this->SetFont('Times', 'N', 9);
        // Title
        $this->Cell(0, 0, 'Republic of the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 0, 'Department of Education', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 0, 'Region '.$settings->region, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 0, 'DIVISION OF '.strtoupper($settings->division), 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(0, 0, $settings->division_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('helvetica', 'B', 11);
        $this->Cell(0, 0, 'SECONDARY STUDENT\'S PERMANENT RECORD', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetAlpha(0.2);
        $image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
        $this->Image($image_file, 5, 80, 205, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
     }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetLeftMargin(8);
$pdf->SetRightMargin(5);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

//constants
$settings = Modules::run('main/getSet');
$father = Modules::run('registrar/getFather', $student->pid);
$mother = Modules::run('registrar/getMother', $student->pid);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(215.9, 360);
$pdf->AddPage('P', $resolution);
$pdf->setCellPaddings(1, 1, 1, 1);
//Personal Profile
$pdf->SetY(28);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(13, 5, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(35, 5, '     '.$student->lastname.' ,',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(45, 5, $student->firstname,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(7, 5, substr($student->middlename, 0,1).'.  ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(15, 5, 'School:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(80, 5,'  '.$settings->set_school_name,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(4);

$pdf->SetY(32.5);
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(13, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(36, 3.5, '','T', 'L', 0, 0, '', '', true, 0, false, true, 3.5, '');
$pdf->MultiCell(43, 5, '','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(8, 5, '','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln(-1);

$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(13, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(35, 3.5, '     Surname',0, 'L', 0, 0, '', '', true, 0, false, true, 3.5, '');
$pdf->MultiCell(43, 5, 'Firstname',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->MultiCell(7, 5, 'M.I.',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(2);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(10, 5, 'Sex:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(25, 5, '     '.$student->sex,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(24, 5, ' Date of Birth:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(41, 5, $student->cal_date,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(30, 5, 'Date of Entrance:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 5,'  ','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');

//Parent
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(28, 5, 'Parent / Guardian:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');

if($father->user_id!=""):
    $parentName = $father->firstname.' '.substr($father->middlename, 0,1).'. '.$father->lastname;
    $occupation = $father->occupation;
else:
    $parentName = $mother->firstname.' '.substr($mother->middlename, 0,1).'. '.$mother->lastname;
    $occupation = $mother->occupation;
endif;


$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(72, 5, '     '.$parentName,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, 'Occupation:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(75, 5,'  '.$occupation,0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(3.5);

$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(30, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(70, 5, '(Name)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

//represents line
$pdf->SetY(43);
$pdf->MultiCell(28, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(72, 5, '','T', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(75, 5,'','T', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');

//Address
if($student->street!=""):
    $address = $student->street.', '.$student->barangay.', '.$student->city.' '.$student->province;
else:
    $address = $student->barangay.', '.$student->city.' '.$student->province;
endif;
$pdf->Ln(1);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15, 5, 'Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->setCellPaddings(0.5,0.5,0.5,0.5);
$pdf->MultiCell(183, 5, '     '.$address,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->setCellPaddings(1, 1, 1, 1);

//Previous Elementary School
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(48, 5, 'Elementary Education Completed:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
if($edHistory->name_of_school!=''):
    $pdf->MultiCell(75, 5, $edHistory->name_of_school,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
else:
    $pdf->MultiCell(75, 5, '','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
endif;

$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(21, 5, 'General Ave:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
if($edHistory->gen_ave!=""):
    $pdf->MultiCell(15, 5,$edHistory->gen_ave,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
else:
    $pdf->MultiCell(15, 5,'','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
endif;

$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(21, 5, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
if($edHistory->school_year!=""):
    $pdf->MultiCell(15, 5,$edHistory->school_year,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
else:
    $pdf->MultiCell(15, 5,'','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
endif;

$pdf->Ln(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(73, 5, 'Total Number of years completed Elementary Education:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
if($edHistory->total_years!=""):
    $pdf->MultiCell(27, 5,$edHistory->total_years,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
else:
    $pdf->MultiCell(27, 5,'','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
endif;
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, 'Curriculum:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
if($edHistory->curriculum!=""):
    $pdf->MultiCell(30, 5,$edHistory->curriculum,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
else:
    $pdf->MultiCell(30, 5,'','B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
endif;
$pdf->MultiCell(15, 5, 'LRN:',0, 'R', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 5,$student->st_id,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');


//subject Grades
$y=61;
for($i=1;$i<=3;$i++):
    switch ($i):
        case 1:
            $data['classified'] = 'Grade 7';
            
        break;
        case 2:
            $data['classified'] = 'Grade 8';
        break;
        case 3:
            $data['classified'] = 'Grade 9';
        break;
    endswitch;
    $pdf->Ln(7);
    $data['level_id'] = 7+$i;
    
    $ar = Modules::run('reports/getSPRecords',base64_decode(segment_3), 7+$i);
    $data['school_year'] = $ar->row()->school_year;
    $data['school'] = $ar->row()->school_name;
    $data['days'] = Modules::run('reports/getDaysPresentRaw', $ar->row()->spr);
    $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', 7+$i); 
    $data['y'] = $y;
    $data['user_id'] = base64_decode(segment_3);
    $data['subjects'] =  Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
    $data['pdf'] = $pdf;
    $this->load->view('subject_grades', $data);
    $y = $y + 94.5;
    if($i==3):
        $pdf->setPrintHeader(FALSE);
        $pdf->AddPage();
        $pdf->Ln(1);
         $ar = Modules::run('reports/getSPRecords',base64_decode(segment_3), 11);
        $data['school_year'] = $ar->row()->school_year;
        $data['school'] = $ar->row()->school_name;
        $data['days'] = Modules::run('reports/getDaysPresentRaw', $ar->row()->spr);
        $data['classified'] = 'Grade 10';
        $data['level_id'] = 11;
        $data['y'] = 5;
        $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', 11); 
        $data['subjects'] =  Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
        $data['pdf'] = $pdf;
        $this->load->view('subject_grades', $data);
    endif;
endfor;
$pdf->SetTextColor(000);
//$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
$data['studentName'] = $student->firstname.' '.substr($student->middlename, 0,1).'. '.$student->lastname;
$data['subjects'] = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
$data['pdf'] = $pdf;
$this->load->view('backPage', $data);




//Close and output PDF document
$pdf->Output('DepEdForm137-'.$student->lastname.', '.$student->firstname.'.pdf', 'I');