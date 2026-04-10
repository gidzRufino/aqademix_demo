<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $settings = Modules::run('main/getSet');
                $nextYear = $settings->school_year + 1;
                
                $this->SetY(2);
                $this->SetX(10);
                $this->SetFont('helvetica', 'B', 11);
                $image_file = K_PATH_IMAGES.'/pilgrim.jpg';
                $this->Image($image_file, 60, 5, 18, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

                $image_file = K_PATH_IMAGES.'/uccp.jpg';
                $this->Image($image_file, 140, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->SetX(10);
                $this->Ln(5);
                $this->SetFont('helvetica', 'B', 12);
                $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
                $this->Ln();
                $this->SetFont('helvetica', 'N', 9);
                $this->Cell(0, 0, 'United Church of Christ in the Philippines', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
                $this->SetFont('helvetica', 'n', 8);
                $this->Cell(0, 15, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->SetTitle('Student Clearance Slip');
                
                $this->SetTitle(strtoupper($settings->set_school_name));
                $this->SetTopMargin(4);
                $this->Ln(5);
        }

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(280,216);
$pdf->AddPage('P', $resolution);

$semester = Modules::run('main/getSemester');
if($sem==NULL):
    $sem = $semester;
endif;

//variables
$settings = Modules::run('main/getSet');
$student = Modules::run('college/getSingleStudent', $st_id, $this->session->userdata('school_year'), $sem);
$loadedSubject = Modules::run('college/subjectmanagement/getLoadedSubject', $student->admission_id);
$next = $settings->school_year + 1;

switch ($student->year_level):
    case 1:
        $year_level = '1st';
    break;
    case 2:
        $year_level = '2nd';
    break;
    case 3: 
        $year_level = '3rd';
    break;
    case 4:
        $year_level = '4th';
    break;
    case 5:
        $year_level = '5th';
    break;    
endswitch;

switch($student->semester):
    case 1:
        $sem = '1ST';
    break;
    case 2:
        $sem = '2ND';
    break;
    case 3:
        $sem = 'SUMMER';
    break;
endswitch;

$pdf->SetXY(5,30);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(100, 0,'Name: '. strtoupper($student->firstname.' '.($student->middlename!=""?substr($student->middlename).'. ':""). $student->lastname),0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(10, 0,'',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(90, 0,'Course / Year : '. strtoupper($student->short_code.' '.$year_level.' YR'),0, 'R', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(5);
$pdf->SetX(5);
$pdf->MultiCell(100, 0,'Semester: '.$sem.($student->semester!=3?' SEMESTER ':' ').$settings->school_year.' - '.$next,0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);


$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 0, 'C L E A R A N C E', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 9);
$pdf->Cell(0, 0, '[ Secure the signatures of the following school officials ]', 0, false, 'C', 0, '', 0, false, 'M', 'M');
$pdf->Ln(15);


$pdf->SetXY(5,65);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 0, '1. ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'Guidance Counselor',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 0, '2. ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'School Librarian',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 0, '3. ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'College Dean',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 0, '4. ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'School Registrar',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(5, 0, '5. ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(40, 0, 'School Finance',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);


$pdf->SetXY(110,65);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(40, 0, 'Pilgrim Herald ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(110);
$pdf->MultiCell(40, 0, 'Supreme Student Council ',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(110);
$pdf->MultiCell(40, 0, 'Department Organization',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(110);
$pdf->MultiCell(40, 0, 'School Prefect of Discipline',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);

$pdf->SetX(110);
$pdf->MultiCell(40, 0, 'Dean of Student Affairs',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->MultiCell(54, 0, '','B', 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(12);



$pdf->SetX(5);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(12, 0, 'NOTE:',0, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->SetFont('helvetica', 'N', 9);
$pdf->MultiCell(110, 0, 'This card is to be used by the student for all the four grading period exams'
        . ' and is valid only when stamped and signed by the school finance for each particular exam period. '
        . ' This card is given only once, any loss card requires securing of a new one at a cost. ',0, 'LJ', 0, 0, '', '', true, 0, false, true, 0, 'M');

$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 55, 35, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//Close and output PDF document


$pdf->Output('Clearance Slip.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

