<?php

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

   
	public function Header() {
		// Logo
                //$sections = Modules::run('registrar/getSectionById', $section);
                $settings = Modules::run('main/getSet');
                
                $nextYear = segment_4 + 1;
                
                $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                $this->Image($image_file, 60, 2, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $image_file = K_PATH_IMAGES.'/uccp.jpg';
                $this->Image($image_file, 140, 2, 13, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 10);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
                $this->SetFont('helvetica', 'N', 8);
                $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
                $this->SetFont('helvetica', 'n', 7);
                $this->Cell(0, 0, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
    }

}

// create new PDF document

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, 5);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$resolution = array(215, 175);
$pdf->AddPage('L', $resolution);

$x = 5;
$y = 5;
$nxtYr = $sy + 1;

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
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $gradeLevel, $sy);

$mStudent = Modules::run('registrar/getSingleStudent', $st_id, $sy);
$adviser = Modules::run('academic/getAdviser', $section, $gradeLevel, $sy);

$coreSubs = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, $sem, $mStudent->strnd_id, 1);  
$appliedSubs = Modules::run('subjectmanagement/getSHSubjects', $gradeLevel, $sem, $mStudent->strnd_id);  

ob_start();


$pdf->setXY($x + 5, $y + 16);
$pdf->SetFont('helvetica', 'R', 7);
$pdf->Cell(10, 5, 'NAME:', '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'B', 7);
$pdf->Cell(60, 5, strtoupper($mStudent->lastname . ', ' . $mStudent->firstname . ' ' . substr($mStudent->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);

$pdf->SetFont('helvetica', 'B',12);
$pdf->Cell(65, 5, 'SENIOR HIGH REPORT CARD', '', 'C', 0, 0, '', '', true);

$pdf->SetFont('times', 'R', 7);
$pdf->Cell(15, 5, '', '', 'L', 0, 0, '', '', true);

$pdf->Cell(15, 5, 'LEVEL:', '', 'L', 0, 0, '', '', true);

$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90, 5, $mStudent->level . ' - ' . $mStudent->section, '', 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 19);
$pdf->SetFont('times', 'R', 7);

$pdf->Cell(23, 5, 'ACADEMIC YEAR:', '', 'L', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(34, 5, $sy . ' - ' . $nxtYr, '', 'L', 1, 0, '', '', true);

$pdf->SetFont('times', 'R', 7);
$pdf->Cell(90, 5, '', '', 'L', 0, 0, '', '', true);

$pdf->Cell(18, 5, 'TEACHER:', '', 'L', 0, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(90, 5, strtoupper($adviser->lastname . ', ' . $adviser->firstname . ' ' . substr($adviser->middlename, 0, 1)), '', 'L', 1, 0, '', '', true);
$pdf->Ln();

$pdf->setXY($x + 5, $y + 22);
$pdf->SetFont('times', 'R', 7);

$pdf->Cell(16, 5, '', '', 'C', 1, 0, '', '', true);
$pdf->Cell(7, 5, 'LRN:', '', 'C', 1, 0, '', '', true);

$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetFont('times', 'B', 8);
$pdf->Cell(72, 5, $mStudent->lrn, '', 'L', 1, 0, '', '', true);
$pdf->Ln();


// THIS IS THE LEFT SIDE

$pdf->SetXY($x+2, $y + 30);
    $pdf->MultiCell(45, 10, 'SUBJECTS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->MultiCell(30, 5, 'Quarter',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
    $pdf->MultiCell(25, 10, 'Semester Final Grade',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $pdf->Ln();
    $pdf->SetXY($x+47, $y+35);
    $pdf->MultiCell(15, 5, $one,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
    $pdf->MultiCell(15, 5, $two,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln();

$pdf->SetFillColor(150, 166, 234);
$pdf->SetX($x+2);
$pdf->SetFont('helvetica', 'b', 8);
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
            $pdf->MultiCell(45, 5,'  '.$sub->short_code,1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        endif;
        if($sub->is_core):
            if($firstGrade->row()->final_rating!=""):
                $pdf->MultiCell(15, 5, $firstGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, $secondGrade->row()->final_rating,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
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
$pdf->SetFont('helvetica', 'b', 8);
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

$pdf->SetX($x+2);
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(45, 5, 'GENERAL AVERAGE', 1, 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '', 'TLB', 'L', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '', 1, 'C', (($z % 2) == 0 ? 0 : 1), 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();


$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(53, 5, 'Descriptors', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Grading Scale', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Remarks', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(53, 5, 'Outstanding', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '90 - 100', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(53, 5, 'Very Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '85 - 89', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '80 - 84', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Fairly Satisfactory', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, '75 - 79', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Passed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(0, 0, 0, 0);
$pdf->MultiCell(53, 5, 'Did not meet the Expectations', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(25, 5, 'Below 75', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, 'Failed', '', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5);

if ($mStudent->dept_id == 3):
    if ($eligible == ($numSubj + 2)):
        $q = Modules::run('registrar/getGradeLevelById', ($mStudent->grade_id + 1));
        $prom = $q->level;
    else:
        $prom = '';
    endif;
else:
    if ($eligible == ($numSubj + 1)):
        $q = Modules::run('registrar/getGradeLevelById', ($mStudent->grade_id + 1));
        $prom = $q->level;
    else:
        $prom = '';
    endif;
endif;

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(28, 4, 'Eligible for Admission to', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(50, 4, $prom, 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln();

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(24, 4, 'Has advanced units in', '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(45, 4, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(3, 5, ',', '', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->MultiCell(15, 4, 'lacks units in', '', 'L', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 11);
$pdf->MultiCell(30, 4, '', 'B', 'C', 0, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(40, 4, '', 'B', 'C', 0, 0, '160', '', true, 0, false, true, 4, 'M');
$pdf->Ln(3);

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(85, 4, 'CANCELLATION OF TRANSFER ELIGIBILITY:', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(40, 4, 'SCHOOL PRINCIPAL', '', 'C', 0, 0, '160', '', true, 0, false, true, 4, 'B');
$pdf->Ln();

$pdf->SetFont('times', '', 7);
$pdf->MultiCell(23, 4, 'Has been admitted to', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(50, 4, '', 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(7, 4, 'year', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', 'B', 7);
$pdf->MultiCell(40, 4, '', 'B', 'C', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(10, 4, 'school.', '', 'L', 1, 0, '', '', true, 0, false, true, 4, 'M');
$pdf->Ln(15);



$pdf->SetXY($x + 109, $y + 100);
$pdf->MultiCell(19, 5, '', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'R', 6);
$pdf->MultiCell(6, 5, 'Jul', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Aug', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Sept', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Oct', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Nov', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Dec', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Jan', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Feb', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Mar', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, 'Apr', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'TOTAL', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->SetX($x + 109);
$pdf->SetFont('times', '', 7);
$pdf->MultiCell(19, 5, 'Days of School', 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->SetFont('times', 'B', 6);
$sd = Modules::run('reports/getRawSchoolDays', $sy);
$pdf->MultiCell(6, 5, $sd->row()->June, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->July, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->August, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->September, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->October, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->November, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->December, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->January, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->February, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(6, 5, $sd->row()->March, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$totalDays = $sd->row()->July + $sd->row()->August + $sd->row()->September + $sd->row()->October + $sd->row()->November + $sd->row()->December + $sd->row()->January + $sd->row()->February + $sd->row()->March + $sd->row()->June;
$pdf->MultiCell(10, 5, $totalDays, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetX($x + 109);
$pdf->SetFont('times', '', 7);
$pdf->SetFillColor(200, 218, 247);
$pdf->MultiCell(19, 5, 'Days Present', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
$attendance = Modules::run('attendance/attendance_reports/getAttendancePerStudent', $mStudent->st_id, $gradeLevel, $sy);

$year = $sy;



$pdf->Output('example_001.pdf', 'I');
