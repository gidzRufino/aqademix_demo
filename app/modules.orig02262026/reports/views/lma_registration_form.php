<?php
class MYPDF extends Pdf {
    //Page header
	public function Header() {
                
                
            $settings = Modules::run('main/getSet');    
            $this->SetTitle('REGISTRATION FORM');
            $this->SetTopMargin(2);
            $this->Ln(5);
            $this->SetX(10);
            $this->SetFont('helvetica', 'B', 18);
            $this->Cell(0, 0, $settings->set_school_name, 0, false, 'C', 0, '', 0, false, 'M', 'T');
            $this->Ln(5);
            $this->SetFont('helvetica', 'n', 8);
            $this->Cell(0, 18, $settings->set_school_address, 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->Ln(2);
            $this->SetFont('times', 'B', 20);
            $this->Cell(0,4.3,"REGISTRATION FORM",0,0,'C');
            $this->Ln();
        }

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
                
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
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

//constants
$settings = Modules::run('main/getSet'); 
$dateEnrolled = date('F d, Y');
$plan = Modules::run('finance/getPlanByCourse', $student->grade_id, 0);
$charges = Modules::run('finance/financeChargesByPlan',0, segment_4, 0, $plan->fin_plan_id );
$addCharge = Modules::run('college/finance/financeChargesByPlan',NULL, segment_4, 0 );

$mother = Modules::run('registrar/getMother', $student->parent_id);
$father = Modules::run('registrar/getFather', $student->parent_id);

    if($father->firstname!=""){
        $fatherName = $father->firstname.' '.$father->lastname;
    }else{
        $fatherName = "";
    }
    if($mother->firstname!="")
    {
        $motherName = $mother->firstname.' '.$mother->lastname;
    }else{
        $motherName = "";
    }



function checkbox( $pdf, $checked = TRUE, $checkbox_size = 5 , $ori_font_family = 'helvetica', $ori_font_size = '10', $ori_font_style = '' )
{
  if($checked == TRUE)
    $check = "4";
  else
    $check = "";

  $pdf->SetFont('ZapfDingbats','', $ori_font_size);
  $pdf->Cell($checkbox_size, $checkbox_size, $check, 1, 0);
  $pdf->SetFont( $ori_font_family, $ori_font_style, $ori_font_size);
}

$pdf->SetY(23);
$pdf->SetFont('helvetica', 'B', 10);

$pdf->SetFillColor(150, 166, 247);
$pdf->Ln();
$pdf->SetX(7);
$pdf->MultiCell(203, 5, 'STUDENT INFORMATION',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'T');


$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(7);
$pdf->SetX(7);
$pdf->MultiCell(60, 7, 'Date: '.$dateEnrolled,0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'OLD',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
checkbox( $pdf, ($student->st_type==1?TRUE:FALSE));
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(12, 7, 'NEW',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
checkbox( $pdf, ($student->st_type==0?TRUE:FALSE));
$pdf->MultiCell(30, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(30, 7, 'LEVEL:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->Ln(5);
$pdf->SetX(7);

$pdf->MultiCell(12, 7, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(60, 7, strtoupper($student->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, strtoupper($student->firstname),'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, strtoupper($student->middlename),'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(60, 5, '(Family)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(First)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(Middle)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

$pdf->Ln(4);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(15, 7, 'Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(57, 7, $student->street,'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, $student->barangay,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, 'Contact No.: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(40, 7, $student->cd_mobile,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(60, 5, '(No & Street)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(Barangay)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'Date of Birth:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(25, 7, date('F', strtotime($student->cal_date)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(1, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(10, 7, date('d', strtotime($student->cal_date)).',','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(1, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(15, 7, date('Y', strtotime($student->cal_date)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'Place of Birth:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(40, 7, strtoupper($student->bplace),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'Age: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(15, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'Sex: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(20, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(25, 5, '(Month ',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(1, 5, ' ',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(10, 5, 'Day',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(1, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(15, 5, 'Year)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(33, 7, 'School Last Attended:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(42, 7, strtoupper($student->school_last_attend),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(15, 7, 'Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7, strtoupper($student->sla_address),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, strtoupper(($student->school_year-1)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, 'Awards Received:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Religion:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7, strtoupper($student->religion),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Nationality:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, strtoupper(($student->nationality)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->Ln(5);
//Parents


$pdf->SetFillColor(150, 166, 247);
$pdf->Ln();
$pdf->SetX(7);
$pdf->MultiCell(203, 5, 'PARENT\'S INFORMATION',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, 'Father\'s Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, strtoupper($fatherName),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Occupation:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7,strtoupper($father->occupation),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Contact No:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, $father->cd_mobile,'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, 'Mother\'s Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, strtoupper($motherName),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Occupation:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7,strtoupper($mother->occupation),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Contact No:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, $mother->cd_mobile,'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, 'Guardian\'s Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Relationship:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7,'','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Contact No:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(63, 7,'','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(36, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(20, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 5, '(Parent\'s/Guardian\'s Signature Over Printed Name)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(63, 5,'(Guidance Counselor)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(56, 5, '(Registrar)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 7, 'Requirements for Officially Enrolled Student:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '1. Comply all documentary requirements by the Registrar.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(55, 7,'','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'B', 15);
$pdf->MultiCell(60, 7, '-- REGISTRAR\'S COPY --',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '2. This Registration Form is stamped "ENROLLED" by the accounting Office.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(55, 7,'(Principal)',0, 'C', 0, 0, '', '', true, 0, false, true, 7,  'T','T');

$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '3. This Registration Form is submitted to the Registrar\'s Office.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(55, 7,'',0, 'C', 0, 0, '', '', true, 0, false, true, 7,  'T','T');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'B', 15);
$pdf->MultiCell(60, 7, 'LRN No.: '. ($student->lrn!=''?$student->lrn:''),'', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(0, 0, 0)));
$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(203, 5, '','B', 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

//BottomPage

$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));


$pdf->SetFillColor(150, 166, 247);
$pdf->Ln(10);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(203, 5, 'STUDENT INFORMATION',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln(7);
$pdf->SetX(7);
$pdf->MultiCell(60, 7, 'Date: '.$dateEnrolled,0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'OLD',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
checkbox( $pdf, ($student->st_type==1?TRUE:FALSE));
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(12, 7, 'NEW',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
checkbox( $pdf, ($student->st_type==0?TRUE:FALSE));
$pdf->MultiCell(30, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(30, 7, 'LEVEL:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');

$pdf->Ln(5);
$pdf->SetX(7);

$pdf->MultiCell(12, 7, 'Name:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(60, 7, strtoupper($student->lastname),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, strtoupper($student->firstname),'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, strtoupper($student->middlename),'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(60, 5, '(Family)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(First)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(Middle)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

$pdf->Ln(4);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(15, 7, 'Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(57, 7, $student->street,'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, $student->barangay,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(20, 7, 'Contact No.: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(40, 7, $student->cd_mobile,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(12, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(60, 5, '(No & Street)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 5, '(Barangay)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'Date of Birth:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(25, 7, date('F', strtotime($student->cal_date)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(1, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(10, 7, date('d', strtotime($student->cal_date)).',','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(1, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(15, 7, date('Y', strtotime($student->cal_date)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'Place of Birth:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(40, 7, strtoupper($student->bplace),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'Age: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(15, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(10, 7, 'Sex: ',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, $student->sex,'B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->Ln(5);
$pdf->SetX(7);
$pdf->MultiCell(20, 7, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(25, 5, '(Month ',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(1, 5, ' ',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(10, 5, 'Day',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(1, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(15, 5, 'Year)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(33, 7, 'School Last Attended:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(42, 7, strtoupper($student->school_last_attend),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(15, 7, 'Address:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7, strtoupper($student->sla_address),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(20, 7, 'School Year:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, strtoupper(($student->school_year-1)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, 'Awards Received:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Religion:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(63, 7, strtoupper($student->religion),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(18, 7, 'Nationality:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(20, 7, strtoupper(($student->nationality)),'B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->Ln(5);


$pdf->SetFillColor(150, 166, 247);
$pdf->Ln(10);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(203, 5, 'ACCOUNT INFORMATION',1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'T');

$pdf->SetLineStyle(array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$pdf->Ln(5);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'B', 9);
$pdf->MultiCell(60, 7, 'Enrolment FEEs:','B', 'C', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 7, 'Discounts','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 7, 'Amount Paid','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(25, 7, 'Balance','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(60, 7, 'Schedule for Installment Scheme:','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');


$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

//Charges
$total=0;
$amount=0;
$i=0;



foreach ($charges as $c):
    $i++;
    $transaction = Modules::run('finance/getTransactionByItemId',$student->st_id, 0, segment_4, $c->item_id);
    $discount = Modules::run('finance/getTransactionByItemId',$student->st_id, 0, segment_4, $c->item_id, 2);
    $partialTotal = $c->amount - ($transaction->row()->t_amount+$discount->row()->t_amount);
    $pdf->Ln(5);
    $pdf->SetX(7);
    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->MultiCell(35, 7, $c->item_description,0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(5, 7, ($i==1?'P':''),0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(20, 7, number_format($c->amount, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, '('.number_format($discount->row()->t_amount, 2, '.',',').')','B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 7, ($i==1?'P':''),0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format($transaction->row()->t_amount, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 7, ($i==1?'P':''),0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format($partialTotal, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $total += $c->amount;
    $totalTransaction += $transaction->row()->t_amount;
    $totalAmountPaid += $partialTotal;
    $totalDiscount += $discount->row()->t_amount;
    unset($partialTotal);
endforeach;


$pdf->SetLineStyle(array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0)));

    $pdf->Ln(5);
    $pdf->SetX(7);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(35, 7, 'TOTAL FEES',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(5, 7, 'P',0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(20, 7, number_format($total, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, '('.number_format($totalDiscount, 2, '.',',').')','B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, ($i==1?'P':''),0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format($totalTransaction, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format($totalAmountPaid, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    

$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    
$previousYear = Modules::run('finance/getExtraFinanceCharges', $student->u_id, 0, ($student->school_year-1));    
foreach ($previousYear->result() as $es):
    $previousTotal += $es->extra_amount;
endforeach;

    $extraTransaction = Modules::run('finance/getTransactionByItemId',$student->st_id, 0, segment_4, 6);
    $pdf->Ln(5);
    $pdf->SetX(7);
    $pdf->SetFont('helvetica', 'N', 9);
    $pdf->MultiCell(35, 7, 'PREVIOUS',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(5, 7, 'P',0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(20, 7, number_format($previousTotal, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');   
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5,'',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format($extraTransaction->row()->t_amount, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format(($previousTotal-$extraTransaction->row()->t_amount), 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    

$pdf->SetLineStyle(array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0)));

    $grand_total = 0;

    $grand_total = $total + $previousTotal;
    $pdf->Ln(5);
    $pdf->SetX(7);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->MultiCell(35, 7, 'GRAND TOTAL',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(5, 7, 'P',0, 'R', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
    $pdf->MultiCell(20, 7, number_format($grand_total, 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');   
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, '('.number_format($totalDiscount, 2, '.',',').')','B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5,'',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format(($totalTransaction+$extraTransaction->row()->t_amount), 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
    $pdf->MultiCell(25, 7, number_format(($grand_total-($totalTransaction+$extraTransaction->row()->t_amount+$totalDiscount)), 2, '.',','),'B', 'R', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
    $pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');    

$pdf->SetXY(153,235);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(65, 5, '*Balance of StudDev & Miscellaneous Fees:',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '1. Upon enrolment ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ':',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '2. 1st Installment ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': JULY 10',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '3. 2nd Installment ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': AUGUST 10',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '4. 3rd Installment ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': SEPTEMBER 10',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '5. 4rd Installment',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': OCTOBER 10',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(60, 5, '* BOOKS : ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '1. 50% ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': Upon Enrolment ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->Ln(4);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '2. 50% ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': 4 Equal Installments ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->Ln(5);
$pdf->SetX(153);
$pdf->MultiCell(30, 5, '* Monthly Tuition Fees',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');
$pdf->MultiCell(30, 5, ': 10th of the Month ',0, 'L', 0, 0, '', '', true, 0, false, true, 5,  'B','B');


//signature
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$pdf->Ln(10);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(30, 7, '','B', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(45, 7, '','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(63, 7,'','B', 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');

$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 5, '(Parent\'s/Guardian\'s Signature Over Printed Name)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->MultiCell(63, 5,'(Stamped & Signed)',0, 'C', 0, 0, '', '', true, 0, false, true, 5,  'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(30, 7, 'Requirements for Officially Enrolled Student:',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln(7);
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '1. Comply all documentary requirements by the Registrar.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(55, 7,'',0, 'C', 0, 0, '', '', true, 0, false, true, 7,  'B','B');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'B', 15);
$pdf->MultiCell(60, 7, '-- STUDENT\'S COPY --',1, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');

$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '2. This Registration Form is stamped "ENROLLED" by the accounting Office.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');



$pdf->Ln();
$pdf->SetX(7);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(75, 7, '3. This Registration Form is submitted to the Registrar\'s Office.',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(55, 7,'',0, 'C', 0, 0, '', '', true, 0, false, true, 7,  'T','T');
$pdf->MultiCell(5, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 7, 'M');
$pdf->SetFont('helvetica', 'B', 15);
$pdf->MultiCell(60, 7, 'LRN No.: '. ($student->lrn!=''?$student->lrn:''),'', 'L', 0, 0, '', '', true, 0, false, true, 7, 'B','B');


$pdf->SetAlpha(0.1);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
$pdf->Image($image_file, 58, 30, 105, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

$pdf->SetAlpha(0.1);
$pdf->Image($image_file, 58, 180, 105, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);


$pdf->Output('registrationForm.pdf', 'I');
