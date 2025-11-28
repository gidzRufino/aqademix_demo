<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $this->SetTitle('School Form 7 (SF 7) School Personnel Assignment List and Basic Profile');
                $this->SetTopMargin(4);
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 5, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 12);
		// Title
                $this->Ln();
                $this->SetY(10);
		$this->Cell(0, 0, 'School Form 7 (SF 7)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                $this->Ln();
		$this->Cell(0, 0, 'School Personnel Assignment List and Basic Profile', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
		$this->SetFont('helvetica', 'n', 8);
		// Title
                $this->Ln();
		$this->Cell(0, 15, '(This replaces Form 12 - Monthly Status Report for Teachers, Form 19 - Assignment List', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->Ln(3);
                $this->Cell(0, 15, 'Form 29-Teacher Program and Form 31 - Summary Information of Teachers)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $settings = Modules::run('main/getSet');
                $nextYear = $settings->school_year + 1;
               
                
                $this->SetFont('helvetica', 'B', 12);
                $this->SetXY(50,30);
                $this->Cell(0,4.3,"School ID : ".$settings->school_id, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(130,30);
                $this->Cell(0,4.3,"Region: ". $settings->region, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(200,30);
                $this->Cell(0,4.3,"Division: ". $settings->division, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(50,37);
                $this->Cell(0,4.3,"School Name : ".$settings->set_school_name,0,0,'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(200,37);
                $this->Cell(0,4.3,"District: ". $settings->district, 0, false, 'L', 0, '', 0, false, 'M', 'M');
                $this->SetXY(270,37);
                $this->Cell(0,4.3,"School Year : ".$settings->school_year.'-'.$nextYear, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'School Form 6: Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
$resolution= array(216, 330);
$pdf->AddPage('L', $resolution);


// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

//Header
function multipleLine($pdf)
{
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->SetX(193);
    $pdf->MultiCell(30, 3, 'add',1, 'C', 0, 0, '', '', true, 0, false, true, 3, 'M');
    $pdf->ln();
}

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetXY(282,60);
$pdf->MultiCell(20, 9, 'Teaching',1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');
$pdf->MultiCell(20, 9, 'Non-Teaching',1, 'C', 0, 0, '', '', true, 0, false, true, 9, 'M');

$pdf->Ln();
$pdf->SetXY(8,48);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(80, 5, '(A) Nationally-Funded Teaching Related Items',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(80, 5, '(B) Nationally-Funded Non Teaching Items',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(150, 5, '(C) Other Appointments and Funding Sources ',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(8);
$pdf->MultiCell(60, 15, 'Title of Plantilla Position
(as appeared in the appointment document)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(20, 15, 'Number of Incumbent',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 15, 'Title of Plantilla Position
(as appeared in the appointment document)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(20, 15, 'Number of Incumbent',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 15, 'Nature of Appointment and Designation
(Contractual, Substitute, Volunteer & Others)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(40, 15, 'Funded by
(SEG, PTA, NGO\'s, etc.)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(40, 15, 'Number of Incumbent',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->Ln();


$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(8);
$pdf->MultiCell(60, 5, 'Teacher - I',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(8);
$pdf->MultiCell(60, 5, 'Teacher - II',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(8);
$pdf->MultiCell(60, 5, 'Secondary School Principal - I',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(2, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(70, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(40, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

//end of Header


$pdf->SetLineStyle(array('width'=>0.45));
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetX(8);
$pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(50, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, 'EDUCATIONAL QUALIFICATION',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(30, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(60, 5, '*Daily Program (time duration)',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(39, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->SetX(8);
$pdf->MultiCell(10, 20, 'No.','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(50, 20, 'Name of School Personnel
(Arrange by Position, Descending)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(10, 20, 'Sex','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(15, 20, 'Fund Source','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(20, 20, 'Position / Designation','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(20, 20, 'Nature of Appointment','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

$pdf->MultiCell(20, 20, 'Degree / Post Graduate','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(20, 20, 'Major / Specialization','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(20, 20, 'Minor','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

$pdf->MultiCell(30, 20, 'Subject Taught (include Grade & Section) & Other Ancillary Assignment (Please Specify)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(15, 20, 'DAY (M/T/W/TH/F)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(15, 20, 'From (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(15, 20, 'To (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(15, 20, 'Actual Teaching / Service Render (Mins/Day)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(39, 20, 'Remarks (For Detailed Items, Indicate name of School/office, For IP\'s Ethnicity)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->Ln();

$x=0;
$y=1;
$page = 1;
$p2r = 0;
foreach ($getTeachers->result() as $teacher):
    //multipleLine($pdf);
    $teacher = Modules::run('hr/getEmployee',  base64_encode($teacher->employee_id));
    $major = Modules::run('hr/getMajorSubjects',$teacher->employee_id );
    $minor = Modules::run('hr/getMinorSubjects',$teacher->employee_id );
    $x++;
    $pdf->SetX(8);
    $pdf->MultiCell(10, 20, $y++,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(50, 20, $teacher->lastname.', '.$teacher->firstname.' '.substr($teacher->middlename, 0,1).'.','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(10, 20, substr($teacher->sex, 0,1),'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(15, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(20, 20, $teacher->p_alias,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(20, 20, $teacher->em_status,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

    $pdf->MultiCell(20, 20, $teacher->course,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(20, 20, $major->maj_min,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
    $pdf->MultiCell(20, 20, $minor->maj_min,'LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

    $pdf->MultiCell(30, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

    $pdf->SetFont('helvetica', 'N', 8);
    $pdf->MultiCell(15, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
    $pdf->MultiCell(15, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
    $pdf->MultiCell(15, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
    $pdf->MultiCell(15, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
    $pdf->MultiCell(39, 20, '','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
    $pdf->Ln();

    if($page>=2):
            $p2r++;
            if($p2r==6):
                $pdf->AddPage(); 
                $page++;
                $pdf->SetLineStyle(array('width'=>0.45));
                $pdf->SetFont('helvetica', 'N', 8);
                $pdf->SetXY(8,48);
                $pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(50, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(15, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(60, 5, 'EDUCATIONAL QUALIFICATION',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(30, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(60, 5, '*Daily Program (time duration)',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(39, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->MultiCell(10, 20, 'No.','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
                $pdf->MultiCell(50, 20, 'Name of School Personnel
                (Arrange by Position, Descending)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
                $pdf->MultiCell(10, 20, 'Sex','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
                $pdf->MultiCell(15, 20, 'Fund Source','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
                $pdf->MultiCell(20, 20, 'Position / Designation','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
                $pdf->MultiCell(20, 20, 'Nature of Appointment','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

                $pdf->MultiCell(20, 20, 'Degree / Post Graduate','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                $pdf->MultiCell(20, 20, 'Major / Specialization','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
                $pdf->MultiCell(20, 20, 'Minor','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

                $pdf->MultiCell(30, 20, 'Subject Taught (include Grade & Section) & Other Ancillary Assignment (Please Specify)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

                $pdf->SetFont('helvetica', 'N', 8);
                $pdf->MultiCell(15, 20, 'DAY (M/T/W/TH/F)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
                $pdf->MultiCell(15, 20, 'From (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
                $pdf->MultiCell(15, 20, 'To (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
                $pdf->MultiCell(15, 20, 'Actual Teaching / Service Render (Mins/Day)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
                $pdf->MultiCell(39, 20, 'Remarks (For Detailed Items, Indicate name of School/office, For IP\'s Ethnicity)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
                $pdf->Ln();
                // set cell padding
               $p2r=0;
            endif;
            
    endif;
    
    if($page==1 && $x==4):
            $x==0;
            $page++;
            $pdf->AddPage(); 
            $pdf->SetLineStyle(array('width'=>0.45));
            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->SetXY(8,48);
            $pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(50, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(10, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(15, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(20, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(60, 5, 'EDUCATIONAL QUALIFICATION',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(30, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(60, 5, '*Daily Program (time duration)',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
            $pdf->MultiCell(39, 5, '','LTR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->MultiCell(10, 20, 'No.','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
            $pdf->MultiCell(50, 20, 'Name of School Personnel
            (Arrange by Position, Descending)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
            $pdf->MultiCell(10, 20, 'Sex','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
            $pdf->MultiCell(15, 20, 'Fund Source','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
            $pdf->MultiCell(20, 20, 'Position / Designation','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
            $pdf->MultiCell(20, 20, 'Nature of Appointment','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

            $pdf->MultiCell(20, 20, 'Degree / Post Graduate','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            $pdf->MultiCell(20, 20, 'Major / Specialization','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
            $pdf->MultiCell(20, 20, 'Minor','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');

            $pdf->MultiCell(30, 20, 'Subject Taught (include Grade & Section) & Other Ancillary Assignment (Please Specify)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');

            $pdf->SetFont('helvetica', 'N', 8);
            $pdf->MultiCell(15, 20, 'DAY (M/T/W/TH/F)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
            $pdf->MultiCell(15, 20, 'From (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
            $pdf->MultiCell(15, 20, 'To (00:00)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
            $pdf->MultiCell(15, 20, 'Actual Teaching / Service Render (Mins/Day)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
            $pdf->MultiCell(39, 20, 'Remarks (For Detailed Items, Indicate name of School/office, For IP\'s Ethnicity)','LBR', 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
            $pdf->Ln();
            // set cell padding
     endif;
     
     

endforeach;



//Close and output PDF document
$pdf->Output('DepEdForm6_'.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
