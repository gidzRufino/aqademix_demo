<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $this->SetTitle('School Form 1 (SF 1) School Register - '.$section->level);
                $this->SetTopMargin(4);
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 5, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 12);
		// Title
		$this->Cell(0, 0, 'School Form 1 (SF 1) School Register', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
		$this->SetFont('helvetica', 'n', 8);
		// Title
                $this->SetXY(40,15);
		$this->Cell(0, 15, '(This replaces  Form 1, Master List & STS Form 2-Family Background and Profile)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $settings = Modules::run('main/getSet');
                $nextYear = segment_4 + 1;
               
                
                $this->SetFont('helvetica', 'B', 12);
                $this->SetXY(50,20);
                $this->Cell(0,4.3,"School ID : ".$settings->school_id,0,0,'L');
                $this->SetXY(100,20);
                $this->Cell(0,4.3,"Region: ". $settings->region,0,0,'L');
                $this->SetXY(140,20);
                $this->Cell(0,4.3,"Division: ". $settings->division,0,0,'L');
                $this->SetXY(210,20);
                $this->Cell(0,4.3,"District: ". $settings->district,0,0,'L');
                $this->SetXY(0,30);
                $this->Cell(0,4.3,"School Year : ".segment_4.'-'.$nextYear,0,0,'C');
                $this->SetXY(35,30);
                $this->Cell(0,4.3,"School Name : ".$settings->set_school_name,0,0,'L');
                $this->SetXY(210,30);
                $this->Cell(0,4.3,"Grade Level: ".$section->level,0,0,'L');
                $this->SetXY(283,30);
                $this->Cell(0,4.3,"Section: ".$section->section,0,0,'L');
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

$section = Modules::run('registrar/getSectionById', segment_3);

$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer
$resolution= array(216, 330);
$pdf->AddPage('L', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(21, 27, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(30, 27, 'NAME
(Last Name, First Name, Middle Name) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(8, 27, 'SEX
(M/F)  ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'BIRTH DATE
(mm/dd/yyyy) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(10, 27, ' Age as of
1st Friday of June',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'Mother
Tongue',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(17, 27, 'IP
(Ethnic Group)',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(15, 27, 'RELIGION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(67, 10, 'ADDRESS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');;

$pdf->MultiCell(44, 10, 'PARENT',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(36, 10, 'GUARDIAN
(if not parent)',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 27, 'Contact Number
of Guardian / Parent',1, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');
$pdf->MultiCell(20, 10, 'Remarks',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetXY(140, 55);
$pdf->MultiCell(15, 17, 'House #/ 
Street/ Sitio / Purok',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Barangay',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Municipality/City',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Province',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(22, 17, "Father's Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(22, 17, "Mother's Maiden Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Relationship',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->SetXY(307, 55);
$pdf->MultiCell(20, 17, '(Please refer to the legend on last page)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln();

//$student =  Modules::run('registrar/getAllStudentsForExternal', segment_3);
$x = 0;
foreach($getStudents->result() as $s){
    $x++;
    $mother = Modules::run('registrar/getMother', $s->psid);
    $father = Modules::run('registrar/getFather', $s->psid);
    $rem = Modules::run('main/getAdmissionRemarks', $s->psid, "");
    $settings = Modules::run('main/getSet');
    if($rem->num_rows()>0){
        $remarks =  $rem->row()->code.' '.$rem->row()->remarks.' - '.$rem->row()->remark_date;
    }else{
        $remarks = '';
    }
    
    //get the birthday and the age before first friday of june
    $firstFridayOfJune =date('Y-m-d',  strtotime('first Friday of '.'June'.' '.$settings->school_year));
    $bdate = $s->cal_date;
    $age = floor((time()-  strtotime($bdate))/31556926);
    $bdateItems = explode('-', $bdate);
    $y = $bdateItems[0];
    $m = $bdateItems[1];
    $d = $bdateItems[2];
    $thisYearBdate = $settings->school_year.'-'.$m.'-'.$d;
    $now = $settings->school_year;
//    $age = abs($now - $y);
    
    if(abs($thisYearBdate>$firstFridayOfJune)){
        $yearsOfAge = $age - 1;
    }else{
        $yearsOfAge = $age;
    }
    if($s->sex=='Male'){
        $sex = 'M';
    }else{
        $sex = 'F';
    }
    if($father->cd_mobile!=""&&$mother->cd_mobile!=""){
       $separator = ' / ';
    }else{
        $separator = " ";
    }
    if($father->firstname!=""){
        $fatherName = $father->lastname.', '.$father->firstname;
    }else{
        $fatherName = "";
    }
    if($mother->firstname!="")
    {
        $motherName = $mother->lastname.', '.$mother->firstname;
    }else{
        $motherName = "";
    }
    //
    $pdf->MultiCell(21, 16, ($s->lrn!=""?$s->lrn:$s->st_id),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(30, 16, strtoupper($s->lastname.', '.$s->firstname.' '.$s->middlename),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(8, 16, $sex,1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, $s->cal_date,1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(10, 16, $yearsOfAge,1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, strtoupper($s->mother_tongue),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->ethnic_group),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(15, 16, strtoupper($s->religion),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(15, 16, strtoupper($s->street),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->barangay),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, strtoupper($s->mun_city),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(17, 16, strtoupper($s->province),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(22, 16, strtoupper($fatherName),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(22, 16, strtoupper($motherName),1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, '',1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(18, 16, '',1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(20, 16, $father->cd_mobile.$separator. $mother->cd_mobile,1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->MultiCell(20, 16, $remarks,1, 'C', 0, 0, '', '', true, 0, false, true, 16, 'M');
    $pdf->Ln();
    
    //A page is added after six records is inserted in a page
    if($x==8){
        $x=0;
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(21, 27, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(30, 27, 'NAME
(Last Name, First Name, Middle Name) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(8, 27, 'SEX
(M/F)  ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'BIRTH DATE
(mm/dd/yyyy) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(10, 27, ' Age as of
1st Friday of June',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'Mother
Tongue',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(17, 27, 'IP
(Ethnic Group)',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(15, 27, 'RELIGION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(67, 10, 'ADDRESS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');;

$pdf->MultiCell(44, 10, 'PARENT',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(36, 10, 'GUARDIAN
(if not parent)',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 27, 'Contact Number
of Guardian / Parent',1, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');
$pdf->MultiCell(20, 10, 'Remarks',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetXY(140, 55);
$pdf->MultiCell(15, 17, 'House #/ 
Street/ Sitio / Purok',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Barangay',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Municipality/City',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Province',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(22, 17, "Father's Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(22, 17, "Mother's Maiden Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Relationship',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->SetXY(307, 55);
$pdf->MultiCell(20, 17, '(Please refer to the legend on last page)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln();
        
        
    }
    
}
//footer at then end of a page
switch ($x){
    case 0:
        $pdf->Ln(95);
    break;
    case 1:
        $pdf->Ln(75);
    break;
    case 2:
        $pdf->Ln(65);
    break;
    case 3:
        $pdf->Ln(50);
    break;
    case 4:
        $pdf->Ln(35);
    break;
    case 5:
        $pdf->Ln(18);
    break;
    case 6:
        $pdf->Ln(2);
    break;
    case 7:
        $pdf->AddPage();
        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(21, 27, 'LRN',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(30, 27, 'NAME
(Last Name, First Name, Middle Name) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(8, 27, 'SEX
(M/F)  ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'BIRTH DATE
(mm/dd/yyyy) ',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(10, 27, ' Age as of
1st Friday of June',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(18, 27, 'Mother
Tongue',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(17, 27, 'IP
(Ethnic Group)',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(15, 27, 'RELIGION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(67, 10, 'ADDRESS',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');;

$pdf->MultiCell(44, 10, 'PARENT',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

$pdf->MultiCell(36, 10, 'GUARDIAN
(if not parent)',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 27, 'Contact Number
of Guardian / Parent',1, 'C', 0, 0, '', '', true, 0, false, true, 25, 'M');
$pdf->MultiCell(20, 10, 'Remarks',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->SetXY(140, 55);
$pdf->MultiCell(15, 17, 'House #/ 
Street/ Sitio / Purok',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Barangay',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Municipality/City',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(17, 17, 'Province',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(22, 17, "Father's Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'T');
$pdf->MultiCell(22, 17, "Mother's Maiden Name (Last Name, First Name, Middle Name)",1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Name',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(18, 17, 'Relationship',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->SetXY(307, 55);
$pdf->MultiCell(20, 17, '(Please refer to the legend on last page)',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln(110);
        
    break;
}
$settings = Modules::run('main/getSet');
$pdf->SetFont('helvetica', 'B', 7);
$pdf->MultiCell(205, 0, 'List and Code of Indicators under REMARKS column',0, 'C', 0, 0, '', '', true, 0, false, true, 0, 'M');
$pdf->Ln(7);
$pdf->MultiCell(20, 5, 'Indicator',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'Code',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 5, 'Required Information',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'Code',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(66, 5, 'Required Information',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->MultiCell(20, 5, 'Transfered Out','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'T/O','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 5, 'Name of  Public (P) Private (PR) School  & Effectivity Date','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'CCT','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(66, 5, 'CCT Control/reference number & Effectivity Date','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->MultiCell(20, 5, 'Transfered In','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'T/I','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 5, 'Name of  Public (P) Private (PR) School  & Effectivity Date','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'B/A','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(66, 5, 'Name of school last attended & Year','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->MultiCell(20, 5, 'Dropped','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'DRP','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 5, 'Reason  and Effectivity Date','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'LWD','LR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(66, 5, 'Specify','LR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->Ln();
$pdf->MultiCell(20, 5, 'Late Enrollment','BLR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'LE','BLR', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(68, 5, 'Reason  and Effectivity Date','BLR', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(5, 5, '','LRB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'ACL','LRB', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(66, 5, 'Specify Level & Effectivity Data','LRB', 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');

$male = Modules::run('registrar/getAllStudentsBasicInfoByGender',segment_3, 'Male','0',segment_4);
$maleBoSY = Modules::run('registrar/getAllStudentsBasicInfoByGender',segment_3, 'Male',NULL, segment_4);
$maleEoSY = $maleBoSY->num_rows() - $male->num_rows();
$female= Modules::run('registrar/getAllStudentsBasicInfoByGender',segment_3, 'Female','0',segment_4);
$femaleBoSY  = Modules::run('registrar/getAllStudentsBasicInfoByGender',segment_3, 'Female',NULL,segment_4);
$femaleEoSY = $femaleBoSY->num_rows() - $female->num_rows();
$BoSYTotal = $maleBoSY->num_rows() + $femaleBoSY->num_rows();
$EoSYTotal = $maleEoSY + $femaleEoSY;

// this is for number registered
$pdf->Ln(-23);
$pdf->SetX(183);
$pdf->MultiCell(20, 5, 'REGISTERED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'BoSY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 5, 'EoSY',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(5.8);
$pdf->SetX(183);
$pdf->MultiCell(20, 7.3, 'MALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $maleBoSY->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $maleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(183);
$pdf->MultiCell(20, 7.3, 'FEMALE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $femaleBoSY->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $femaleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(183);
$pdf->MultiCell(20, 7.3, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $BoSYTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(15, 7.3, $EoSYTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$principal = Modules::run('hr/getEmployeeByPosition', 'President');
$adviser = Modules::run('academic/getAdvisory', NULL, segment_4, segment_3);

    $name = $principal->firstname.' '.substr($principal->middlename,0,1).'. '.$principal->lastname;

    $adv = $adviser->row()->firstname.' '.  substr($adviser->row()->middlename,0,1).'. '.$adviser->row()->lastname;

//this is for signatories
$pdf->Ln(-22);
$pdf->SetX(234);
$pdf->MultiCell(45, 5, 'Prepared By:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(3, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, 'Certified By:',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln(7.3);
$pdf->SetX(234);
$pdf->MultiCell(45, 5, strtoupper($adv),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(3, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5,  strtoupper($name),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'B');
$pdf->Ln(5);
$pdf->SetX(234);
$pdf->SetFont('helvetica', 'B', 6);
$pdf->MultiCell(45, 3, '(Signature of Adviser Over Printed Name)',0, 'C', 0, 0, '', '', true, 0, false, true, 3, 'T');
$pdf->MultiCell(3, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(45, 5, '(Signature of School Head over Printed Name)',0, 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->Ln(10);
$pdf->SetX(234);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(22.5, 5, $settings->bosy,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(22.5, 5, $settings->eosy,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(3, 5, '',0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(22.5, 5, $settings->bosy,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(22.5, 5, $settings->eosy,'B', 'L', 0, 0, '', '', true, 0, false, true, 5, '');








//$html = Modules::run('reports/form1');
//
//$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
// set default header data



//Close and output PDF document
$pdf->Output('DepEdForm1-'.$section->level.'-'.$section->section.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
