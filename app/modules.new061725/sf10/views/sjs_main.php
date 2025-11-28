<?php

class MYPDF extends Pdf {
     function Header() {
         $this->SetTopMargin(4);
         $settings = Modules::run('main/getSet');
         $this->SetXY(5,8);
         $this->SetFont('helvetica', 'B', 20);
         $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'M');
         $this->Ln(5);
         $this->SetFont('helvetica', 'N', 8);
         $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
         $image_file = K_PATH_IMAGES.'/lca.png';
         $this->Image($image_file, 35, 2, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

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
$pdf->SetY(20);
$pdf->SetFont('helvetica', 'B', 6);
$pdf->Cell(0, 0, $settings->short_name.' 137-A  ', 0, false, 'L', 0, '', 0, false, 'M', 'M');
$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(50, 5, 'Name',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5, $student->lastname.' '.$student->firstname.', '.substr($student->middlename, 0,1).'. ',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);
$pdf->MultiCell(50, 5, 'Sex',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5, $student->sex,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

$date = explode('-', $student->cal_date);
$dt = date('F', mktime(0, 0, 0, $date[0], 10));

$pdf->MultiCell(50, 5, 'Date of Birth',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5, $date[2].' '.$dt.' '.$date[1],0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

$pdf->MultiCell(50, 5, 'Place of Birth',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);


//Parent
if($father->user_id!=""):
    $parentName = $father->firstname.' '.substr($father->middlename, 0,1).'. '.$father->lastname;
    $occupation = $father->occupation;
else:
    $parentName = $mother->firstname.' '.substr($mother->middlename, 0,1).'. '.$mother->lastname;
    $occupation = $mother->occupation;
endif;

$pdf->MultiCell(50, 5, 'Parent / Guardian',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5,$parentName,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

$pdf->MultiCell(50, 5, 'Occupation',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5,$occupation,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

//Address
if($student->street!=""):
    $address = $student->street.', '.$student->barangay.', '.$student->mun_city.', '.$student->province;
else:
    $address = $student->barangay.', '.$student->mun_city.', '.$student->province;
endif;

$pdf->MultiCell(50, 5, 'Complete Address',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(145, 5,$address,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(10);

//Previous Elementary School
$next = $edHistory->school_year+1;

$pdf->MultiCell(50, 5, 'Elementary Course Completed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5,$edHistory->name_of_school,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(20, 5, 'General Ave',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(10, 5,$edHistory->gen_ave,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

$pdf->MultiCell(50, 5, 'Total Number of years completed',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(80, 5,$edHistory->total_years,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
//$pdf->MultiCell(20, 5, 'Curriculum',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
//$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
//$pdf->MultiCell(30, 5,$edHistory->curriculum,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);

$pdf->MultiCell(50, 5, 'School Year',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(5, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 5,$edHistory->school_year.' - '.$next,0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(30, 5,'',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(4);


//subject Grades

for($i=7;$i<=10;$i++):
    //echo $i.'<br / >';
    switch ($i):
        case 7:
            $data['classified'] = 'Grade 8';
            $data['x'] = 7;
            $data['y'] = 85;
            $data['yearToDate'] = '7 Years';
            $data['gradingPeriods'] = 34;
            $data['slashy'] = 160;
            $data['slashx'] = 100;
        break;
        case 8:
            $data['x'] = 110;
            $data['y'] = 85;
            $data['classified'] = 'Grade 9';
            $data['yearToDate'] = '8 Years';
            $data['gradingPeriods'] = 137;
            $data['slashy'] = 160;
            $data['slashx'] = 200;
        break;
        case 9:
            $data['classified'] = 'Grade 10';
            $data['x'] = 7;
            $data['y'] = 85+105;
            $data['yearToDate'] = '9 Years';
            $data['gradingPeriods'] = 34;
            $data['slashy'] = 265;
            $data['slashx'] = 95;
        break;
        case 10:
            $data['classified'] = 'Grade 11';
            $data['x'] = 110;
            $data['y'] = 85+105;
            $data['yearToDate'] = '10 Years';
            $data['gradingPeriods'] = 137;
            $data['slashy'] = 265;
            $data['slashx'] = 200;
        break;
    endswitch;
    
    $pdf->Ln(7);
    $data['level_id'] = $i+1;
    $data['pdf'] = $pdf;
    $ar = Modules::run('reports/getSPRecords',base64_decode(segment_3), $i+1);
    $data['school_year'] = $ar->row()->school_year;
    $data['school'] = $ar->row()->school_name;
    $data['days'] = Modules::run('reports/getDaysPresentRaw', $ar->row()->spr);
    $subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $i+1); 
    $data['user_id'] = base64_decode(segment_3);
    $data['subjects'] = explode(',', $subject_ids->subject_id);
//    $data['pdf'] = $pdf;
    $this->load->view('subject_grades', $data);

endfor;

$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id); 
$data['studentName'] = $student->firstname.' '.substr($student->middlename, 0,1).'. '.$student->lastname;
$data['subjects'] = explode(',', $subject_ids->subject_id);
$data['pdf'] = $pdf;
$this->load->view('bottomPage', $data);




//Close and output PDF document
$pdf->Output('DepEdForm137-'.$student->lastname.', '.$student->firstname.'.pdf', 'I');