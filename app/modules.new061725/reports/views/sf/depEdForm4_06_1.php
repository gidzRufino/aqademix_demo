<?php
class MYPDF extends Pdf {
    
	//Page header
	public function Header() {
		// Logo
                $section = Modules::run('registrar/getSectionById', segment_3);
                $this->SetTitle("School Form 4 ( SF4 ) Monthly Learner's Movement and Attendance");
                $this->SetTopMargin(4);
		$image_file = K_PATH_IMAGES.'/depEd_logo.jpg';
		$this->Image($image_file, 5, 10, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 12);
		// Title
		$this->Cell(0, 0, "School Form 4 ( SF4 ) Monthly Learner's Movement and Attendance", 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
		$this->SetFont('helvetica', 'n', 8);
		// Title
                $this->SetXY(40,15);
		$this->Cell(0, 15, '(This replaces Form 3 & STS Form 4-Absenteeism and Dropout Profile)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                
                $settings = Modules::run('main/getSet');
                $nextYear = $settings->school_year + 1;
               
                
                $this->SetFont('helvetica', 'B', 12);
                $this->SetXY(50,20);
                $this->Cell(0,4.3,"School ID : ".$settings->school_id,0,0,'L');
                $this->SetXY(100,20);
                $this->Cell(0,4.3,"Region: ". $settings->region,0,0,'L');
                $this->SetXY(140,20);
                $this->Cell(0,4.3,"Division: ". $settings->division,0,0,'L');
                $this->SetXY(210,20);
                $this->Cell(0,4.3,"District: ". $settings->district,0,0,'L');
                $this->SetXY(160,30);
                $this->Cell(0,4.3,"School Year : ".$settings->school_year.'-'.$nextYear,0,0,'L');
                $this->SetXY(35,30);
                $this->Cell(0,4.3,"School Name : ".$settings->set_school_name,0,0,'L');
                $this->SetXY(240,30);
                $this->Cell(0,4.3,"Report for the Month of : ".date("F", mktime(0, 0, 0, segment_3, 10)),0,0,'L');
//                $this->SetXY(283,30);
//                $this->Cell(0,4.3,"Section: ".$section->section,0,0,'L');
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
$pdf->SetLeftMargin(3);
$pdf->SetRightMargin(3);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// remove default header/footer

//this will get students per level;

function getNumberOfStudentsGradelevel($grade_id, $gender, $status, $school_year)
{
    $students = Modules::run('registrar/getAllStudentsForExternal',$grade_id, NULL, $gender, $status, $school_year);
    return $students->num_rows();
}

$settings = Modules::run('main/getSet');

switch (segment_3):
    default :
        $year = $settings->school_year;
    break;
    case '01':
    case '02':
    case '03':
    case '04':
        $year = date('Y');
    break;
endswitch;

$resolution= array(216, 330);
$pdf->AddPage('L', $resolution);

$pdf->SetY(45);
$pdf->SetFont('helvetica', 'B', 7);
// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->MultiCell(15, 25, 'GRADE/
YEAR LEVEL',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(20, 25, 'SECTION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(33, 25, 'NAME OF ADVISER',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
$pdf->MultiCell(21, 20, 'REGISTERED LEARNERS
(As of End of the Month)',1, 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
$pdf->MultiCell(42, 5, 'ATTENDANCE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(63, 5, 'DROPPED OUT ',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(63, 5, 'TRANSFERRED OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(63, 5, 'TRANSFERRED IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();
$pdf->setX(92);
$pdf->MultiCell(21, 15, 'DAILY AVERAGE',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, 'PERCENTAGE FOR
THE MONTH',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
$pdf->Ln();
$pdf->setX(71);
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->Ln();

$previousMonth = abs(segment_3) - 1;
if($previousMonth<10):
    $previousMonth = '0'.$previousMonth;
else:
    $previousMonth = $previousMonth;
endif;

foreach($section->result() as $sec)
{
    $adviser = Modules::run('academic/getAdvisory',NULL, $school_year, $sec->section_id);
    $male = Modules::run('registrar/getAllStudentsByGender',$sec->section_id, 'Male',"0", $school_year);
    $maleBoSY = Modules::run('registrar/getAllStudentsByGender',$sec->section_id, 'Male',"", $school_year);
    $maleEoSY = $maleBoSY->num_rows() - $male->num_rows();
    $female= Modules::run('registrar/getAllStudentsByGender',$sec->section_id, 'Female',"0", $school_year);
    $femaleBoSY  = Modules::run('registrar/getAllStudentsByGender',$sec->section_id, 'Female',"", $school_year);
    $femaleEoSY = $femaleBoSY->num_rows() - $female->num_rows();
    //$BoSYTotal = $maleBoSY->num_rows() + $femaleBoSY->num_rows();
    $EoSYTotal = $maleEoSY + $femaleEoSY;
    $dailyAttendance = Modules::run('attendance/getMonthlyAttendanceSummary', $sec->section_id, segment_3, $this->session->userdata('attend_auto'), $year);
    
    //$maleAverageDailyAttendance = $dailyAttendance->male_total/$totalNumberOfSchoolDays;
    //$femaleAverageDailyAttendance = $dailyAttendance->female_total/$totalNumberOfSchoolDays;
    $totalAverageDailyAttendance = $dailyAttendance->ave_male_total + $dailyAttendance->ave_female_total;
    //$maleMonthlyPercentage = ($maleAverageDailyAttendance/$maleEoSY)*100;
    //$femaleMonthlyPercentage = ($femaleAverageDailyAttendance/$femaleEoSY)*100;
    $sumMonthlyPercentage = ($dailyAttendance->percent_male+$dailyAttendance->percent_female)/2;
    if($maleEoSY!=0):
        //grade level
        $pdf->MultiCell(15, 5, strtoupper($sec->level),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //section
        $pdf->MultiCell(20, 5, strtoupper($sec->section),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //adviser
        $pdf->MultiCell(33, 5, $adviser->row()->firstname.' '.$adviser->row()->lastname,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //registered learners
        $pdf->MultiCell(7, 5, $maleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $EoSYTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance daily
        $pdf->MultiCell(7, 5, $maleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleEoSY,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $EoSYTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance monthly
        $pdf->MultiCell(7, 5, '100',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '100',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '100',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Drop out
        $maleDrpPm = Modules::run('registrar/getStudentStatus', 3, 'Male', $sec->section_id, segment_3, $school_year,0);
        $femaleDrpPm = Modules::run('registrar/getStudentStatus', 3, 'Female', $sec->section_id, segment_3, $school_year,0);
        $totalDrpPm = $maleDrpPm->num_rows + $femaleDrpPm->num_rows;
        // cumulative drop out
        $pdf->MultiCell(7, 5, $maleDrpPm->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleDrpPm->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleDrpthis = Modules::run('registrar/getStudentStatus', 3, 'Male', $sec->section_id, segment_3, $school_year, 1);
        $femaleDrpthis = Modules::run('registrar/getStudentStatus', 3, 'Female', $sec->section_id, segment_3, $school_year, 1);
        $totalDrpThis = $maleDrpthis->num_rows() + $femaleDrpthis->num_rows();
        // drop out for the month
        $pdf->MultiCell(7, 5, $maleDrpthis->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleDrpthis->num_rows(),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleDrpCum = $maleDrpPm->num_rows + $maleDrpthis->num_rows;
        $femaleDrpCum = $femaleDrpPm->num_rows + $femaleDrpthis->num_rows;
        $totalDrpCum = $maleDrpCum + $femaleDrpCum;
        //cumulative drop out as of end of the month
        $pdf->MultiCell(7, 5, $maleDrpCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleDrpCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        // transfered out
        $maleToPm = Modules::run('registrar/getStudentStatus', 1, 'Male', $sec->section_id, segment_3, $school_year, 0);
        $femaleToPm = Modules::run('registrar/getStudentStatus', 1, 'Female', $sec->section_id, segment_3, $school_year, 0);
        $totalToPm = $maleToPm->num_rows + $femaleToPm->num_rows;
        
        $pdf->MultiCell(7, 5, $maleToPm->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleToPm->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleToThis = Modules::run('registrar/getStudentStatus', 1, 'Male', $sec->section_id, segment_3, segment_4, 1);
        $femaleToThis = Modules::run('registrar/getStudentStatus', 1, 'Female', $sec->section_id, segment_3, segment_4, 1);
        $totalToThis = $maleToThis->num_rows + $femaleToThis->num_rows;
        
        $pdf->MultiCell(7, 5, $maleToThis->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleToThis->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleToCum = $maleToPm->num_rows + $maleToThis->num_rows;
        $femaleToCum = $femaleToPm->num_rows + $femaleToThis->num_rows;
        $totalToCum = $maleToCum + $femaleToCum;
        
        $pdf->MultiCell(7, 5, $maleToCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleToCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Transferred In
        $maleTiPm = Modules::run('registrar/getStudentStatus', 2, 'Male', $sec->section_id, segment_3, $school_year, 0);
        $femaleTiPm = Modules::run('registrar/getStudentStatus', 2, 'Female', $sec->section_id, segment_3, $school_year, 0);
        $totalTiPm = $maleTiPm->num_rows + $femaleTiPm->num_rows;
        
        $pdf->MultiCell(7, 5, $maleTiPm->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleTiPm->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleTiThis = Modules::run('registrar/getStudentStatus', 2, 'Male', $sec->section_id, segment_3, $school_year, 1);
        $femaleTiThis = Modules::run('registrar/getStudentStatus', 2, 'Female', $sec->section_id, segment_3, $school_year, 1);
        $totalTiThis = $maleTiThis->num_rows + $femaleTiThis->num_rows;

        $pdf->MultiCell(7, 5, $maleTiThis->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleTiThis->num_rows,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $maleTiCum = $maleTiPm->num_rows + $maleTiThis->num_rows;
        $femaleTiCum = $femaleTiPm->num_rows + $femaleTiThis->num_rows;
        $totalTiCum = $maleTiCum + $femaleTiCum;
        
        $pdf->MultiCell(7, 5, $maleTiCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleTiCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiCum,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
        switch ($sec->grade_level_id):
            case 8:
                $g7MaleDrpPm += $maleDrpPm->num_rows;
                $g7FemaleDrpPm += $femaleDrpPm->num_rows;
                $g7MaleDrpThis += $maleDrpthis->num_rows;
                $g7FemaleDrpThis += $femaleDrpthis->num_rows;
                $g7MaleToPm += $maleToPm->num_rows;
                $g7FemaleToPm += $femaleToPm->num_rows;
                $g7MaleToThis += $maleToThis->num_rows;
                $g7FemaleToThis += $femaleToThis->num_rows;
                $g7MaleTiPm += $maleTiPm->num_rows;
                $g7FemaleTiPm += $femaleTiPm->num_rows;
                $g7MaleTiThis += $maleTiThis->num_rows;
                $g7FemaleTiThis += $femaleTiThis->num_rows;
            break;
            case 9:
                $g8MaleDrpPm += $maleDrpPm->num_rows;
                $g8FemaleDrpPm += $femaleDrpPm->num_rows;
                $g8MaleDrpThis += $maleDrpthis->num_rows;
                $g8FemaleDrpThis += $femaleDrpthis->num_rows;
                $g8MaleToPm += $maleToPm->num_rows;
                $g8FemaleToPm += $femaleToPm->num_rows;
                $g8MaleToThis += $maleToThis->num_rows;
                $g8FemaleToThis += $femaleToThis->num_rows;
                $g8MaleTiPm += $maleTiPm->num_rows;
                $g8FemaleTiPm += $femaleTiPm->num_rows;
                $g8MaleTiThis += $maleTiThis->num_rows;
                $g8FemaleTiThis += $femaleTiThis->num_rows;
            break;
            case 10:
                $g9MaleDrpPm += $maleDrpPm->num_rows;
                $g9FemaleDrpPm += $femaleDrpPm->num_rows;
                $g9MaleDrpThis += $maleDrpthis->num_rows;
                $g9FemaleDrpThis += $femaleDrpthis->num_rows;
                $g9MaleToPm += $maleToPm->num_rows;
                $g9FemaleToPm += $femaleToPm->num_rows;
                $g9MaleToThis += $maleToThis->num_rows;
                $g9FemaleToThis += $femaleToThis->num_rows;
                $g9MaleTiPm += $maleTiPm->num_rows;
                $g9FemaleTiPm += $femaleTiPm->num_rows;
                $g9MaleTiThis += $maleTiThis->num_rows;
                $g9FemaleTiThis += $femaleTiThis->num_rows;
            break;
            case 11:
                $g10MaleDrpPm += $maleDrpPm->num_rows;
                $g10FemaleDrpPm += $femaleDrpPm->num_rows;
                $g10MaleDrpThis += $maleDrpthis->num_rows;
                $g10FemaleDrpThis += $femaleDrpthis->num_rows;
                $g10MaleToPm += $maleToPm->num_rows;
                $g10FemaleToPm += $femaleToPm->num_rows;
                $g10MaleToThis += $maleToThis->num_rows;
                $g10FemaleToThis += $femaleToThis->num_rows;
                $g10MaleTiPm += $maleTiPm->num_rows;
                $g10FemaleTiPm += $femaleTiPm->num_rows;
                $g10MaleTiThis += $maleTiThis->num_rows;
                $g10FemaleTiThis += $femaleTiThis->num_rows;
            break;
        endswitch;
        endif;
}

// blank rows and columns

        //grade level
        $pdf->MultiCell(15, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //section
        $pdf->MultiCell(20, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //adviser
        $pdf->MultiCell(33, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //registered learners
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance daily
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance monthly
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Drop out
        // cumulative drop out
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        // drop out for the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //cumulative drop out as of end of the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
       
        $pdf->MultiCell(68, 5, 'ELEMENTARY / SECONDARY:',1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //registered learners
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance daily
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance monthly
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Drop out
        // cumulative drop out
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        // drop out for the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //cumulative drop out as of end of the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
         
        $c = 0;
        $d = 0;
        foreach($gradeLevel as $level)
        {
            if($level->grade_id!=18):
            switch ($level->grade_id):
                case 8:
                    $MaleDrpPm = $g7MaleDrpPm;
                    $FemaleDrpPm = $g7FemaleDrpPm;
                    $MaleDrpThis = $g7MaleDrpThis;
                    $FemaleDrpThis = $g7FemaleDrpThis;
                    $MaleToPm = $g7MaleToPm;
                    $FemaleToPm = $g7FemaleToPm;
                    $MaleToThis = $g7MaleToThis;
                    $FemaleToThis = $g7FemaleToThis;
                    $MaleTiPm = $g7MaleTiPm;
                    $FemaleTiPm = $g7FemaleTiPm;
                    $MaleTiThis = $g7MaleTiThis;
                    $FemaleTiThis = $g7FemaleTiThis;
                    $june = 100;
                    
                break;
                case 9:
                    $MaleDrpPm = $g8MaleDrpPm;
                    $FemaleDrpPm = $g8FemaleDrpPm;
                    $MaleDrpThis = $g8MaleDrpThis;
                    $FemaleDrpThis = $g8FemaleDrpThis;
                    $MaleToPm = $g8MaleToPm;
                    $FemaleToPm = $g8FemaleToPm;
                    $MaleToThis = $g8MaleToThis;
                    $FemaleToThis = $g8FemaleToThis;
                    $MaleTiPm = $g8MaleTiPm;
                    $FemaleTiPm = $g8FemaleTiPm;
                    $MaleTiThis = $g8MaleTiThis;
                    $FemaleTiThis = $g8FemaleTiThis;
                    $june = 100;
                break;
                case 10:
                    $MaleDrpPm = $g9MaleDrpPm;
                    $FemaleDrpPm = $g9FemaleDrpPm;
                    $MaleDrpThis = $g9MaleDrpThis;
                    $FemaleDrpThis = $g9FemaleDrpThis;
                    $MaleToPm = $g9MaleToPm;
                    $FemaleToPm = $g9FemaleToPm;
                    $MaleToThis = $g9MaleToThis;
                    $FemaleToThis = $g9FemaleToThis;
                    $MaleTiPm = $g9MaleTiPm;
                    $FemaleTiPm = $g9FemaleTiPm;
                    $MaleTiThis = $g9MaleTiThis;
                    $FemaleTiThis = $g9FemaleTiThis;
                    $june = 100;
                break;
                case 11:
                    $MaleDrpPm = 0;
                    $FemaleDrpPm = 0;
                    $MaleDrpThis = 0;
                    $FemaleDrpThis = 0;
                    $MaleToPm = 0;
                    $FemaleToPm = 0;
                    $MaleToThis = 0;
                    $FemaleToThis = 0;
                    $MaleTiPm = 0;
                    $FemaleTiPm = 0;
                    $MaleTiThis = 0;
                    $FemaleTiThis = 0;
                    $june = 100;
                break;
                case 11:
                    $MaleDrpPm = $g10MaleDrpPm;
                    $FemaleDrpPm = $g10FemaleDrpPm;
                    $MaleDrpThis = $g10MaleDrpThis;
                    $FemaleDrpThis = $g10FemaleDrpThis;
                    $MaleToPm = $g10MaleToPm;
                    $FemaleToPm = $g10FemaleToPm;
                    $MaleToThis = $g10MaleToThis;
                    $FemaleToThis = $g10FemaleToThis;
                    $MaleTiPm = $g10MaleTiPm;
                    $FemaleTiPm = $g10FemaleTiPm;
                    $MaleTiThis = $g10MaleTiThis;
                    $FemaleTiThis = $g10FemaleTiThis;
                    $june = 100;
                break;
                case 12:
                    $MaleDrpPm = 0;
                    $FemaleDrpPm = 0;
                    $MaleDrpThis = 0;
                    $FemaleDrpThis = 0;
                    $MaleToPm = 0;
                    $FemaleToPm = 0;
                    $MaleToThis = 0;
                    $FemaleToThis = 0;
                    $MaleTiPm = 0;
                    $FemaleTiPm = 0;
                    $MaleTiThis = 0;
                    $FemaleTiThis = 0;
                    $june = 0;
                break;
                case 13:
                    $MaleDrpPm = 0;
                    $FemaleDrpPm = 0;
                    $MaleDrpThis = 0;
                    $FemaleDrpThis = 0;
                    $MaleToPm = 0;
                    $FemaleToPm = 0;
                    $MaleToThis = 0;
                    $FemaleToThis = 0;
                    $MaleTiPm = 0;
                    $FemaleTiPm = 0;
                    $MaleTiThis = 0;
                    $FemaleTiThis = 0;
                    
                    $june = 0;
                break;
            endswitch;
            $d++;
            $c++;
            if($c>1):
                $b = 'b';
            else:
                $b = 1;
            endif;
                $dailyAttendanceSum = Modules::run('attendance/getMonthlyAttendanceSummaryPerLevel', segment_3, $level->grade_id, $this->session->userdata('attend_auto'), $year);
                $maleAttendanceAve = $dailyAttendanceSum->male_total;
                $femaleAttendanceAve = $dailyAttendanceSum->female_total;
                $totalAttendanceAve = ($maleAttendanceAve+$femaleAttendanceAve);
                $maleMonthlyPercentageSum = ($maleAttendanceAve/getNumberOfStudentsGradelevel($level->grade_id, 'Male',"1", $school_year))*100;
                $femaleMonthlyPercentageSum = ($femaleAttendanceAve/getNumberOfStudentsGradelevel($level->grade_id, 'Female',"1", $school_year))*100;
                $monthlyPercentageSum = ($maleMonthlyPercentageSum+$femaleMonthlyPercentageSum)/2;
        
                $pdf->MultiCell(68, 5, $level->level,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                //registered learners
                $pdf->MultiCell(7, 5, getNumberOfStudentsGradelevel($level->grade_id, 'Male',1,$school_year),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, getNumberOfStudentsGradelevel($level->grade_id, 'Female',1,$school_year),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, (getNumberOfStudentsGradelevel($level->grade_id, 'Male',1,$school_year))+(getNumberOfStudentsGradelevel($level->grade_id, 'Female',1,$school_year)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                //attendance daily
                $pdf->MultiCell(7, 5, getNumberOfStudentsGradelevel($level->grade_id, 'Male',"1",$school_year),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, getNumberOfStudentsGradelevel($level->grade_id, 'Female',"1",$school_year),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, (getNumberOfStudentsGradelevel($level->grade_id, 'Male',"1",$school_year))+(getNumberOfStudentsGradelevel($level->grade_id, 'Female',"1",$school_year)),1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');

                //attendance monthly
                $pdf->MultiCell(7, 5, $june,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $june,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $june,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                //Drop out
                // cumulative drop out
                 
                $pdf->MultiCell(7, 5, $MaleDrpPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleDrpPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleDrpPm + $FemaleDrpPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                // drop out for the month
                $pdf->MultiCell(7, 5, $MaleDrpThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleDrpThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleDrpThis + $FemaleDrpThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                $TotalMaleDrp = $MaleDrpPm + $MaleDrpThis;
                $TotalFemaleDrp = $FemaleDrpPm + $FemaleDrpThis;
                //cumulative drop out as of end of the month
                $pdf->MultiCell(7, 5, $TotalMaleDrp,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $TotalFemaleDrp,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $TotalMaleDrp + $TotalFemaleDrp,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

                //Transferred Out
                $pdf->MultiCell(7, 5, $MaleToPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleToPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleToPm + $FemaleToPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                
                $pdf->MultiCell(7, 5, $MaleToThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleToThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleToThis + $FemaleToThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                $totalMaleTo = $MaleToPm + $MaleToThis;
                $totalFemaleTo = $FemaleToPm + $FemaleToThis;
                
                $pdf->MultiCell(7, 5, $totalMaleTo,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $totalFemaleTo,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $totalMaleTo + $totalFemaleTo,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                
                $pdf->MultiCell(7, 5, $MaleTiPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleTiPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleTiPm + $FemaleTiPm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                $pdf->MultiCell(7, 5, $MaleTiThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $FemaleTiThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $MaleTiThis + $FemaleTiThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                $totalMaleTi = $MaleTiPm + $MaleTiThis;
                $totalFemaleTi = $FemaleTiPm + $FemaleTiThis;
                
                $pdf->MultiCell(7, 5, $totalMaleTi,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $totalFemaleTi,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                $pdf->MultiCell(7, 5, $totalMaleTi + $totalFemaleTi,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                
                $pdf->Ln();

                
                if($c==10):
                    $c=0;
                    $pdf->AddPage('L', $resolution);

        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        // set cell padding
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 25, 'GRADE/
YEAR LEVEL',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(20, 25, 'SECTION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(33, 25, 'NAME OF ADVISER',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(21, 20, 'REGISTERED LEARNERS
(As of End of the Month)',1, 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
        $pdf->MultiCell(42, 5, 'ATTENDANCE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'DROPPED OUT ',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'TRANSFERRED OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'TRANSFERRED IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $pdf->setX(92);
        $pdf->MultiCell(21, 15, 'DAILY AVERAGE',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, 'PERCENTAGE FOR
THE MONTH',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->Ln();
        $pdf->setX(71);
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
                endif;
        $maleStud += getNumberOfStudentsGradelevel($level->grade_id, 'Male',"1",$school_year);
        $femaleStud += getNumberOfStudentsGradelevel($level->grade_id, 'Female',"1",$school_year);
        $totalMaleAve += $maleAttendanceAve;
        $totalFemaleAve += $femaleAttendanceAve;
        $sumMaleMonthlyPercentage += $maleMonthlyPercentageSum;
        $sumFemaleMonthlyPercentage += $femaleMonthlyPercentageSum;
        
        $totalDrpMalePm += $MaleDrpPm;
        $totalDrpMaleThis += $MaleDrpThis;
        $totalDrpFemalePm += $FemaleDrpPm;
        $totalDrpFemaleThis += $FemaleDrpThis;
        
        $totalToMalePm += $MaleToPm;
        $totalToMaleThis += $MaleToThis;
        $totalToFemalePm += $FemaleToPm;
        $totalToFemaleThis += $FemaleToThis;
        
        $totalTiMalePm += $MaleTiPm;
        $totalTiMaleThis += $MaleTiThis;
        $totalTiFemalePm += $FemaleTiPm;
        $totalTiFemaleThis += $FemaleTiThis;
        
        endif;
        }
        $pdf->MultiCell(68, 5, 'TOTAL FOR NONE GRADED',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //registered learners
        $pdf->MultiCell(7, 5, '',1, '', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance daily
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //attendance monthly
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Drop out
        // cumulative drop out
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        // drop out for the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //cumulative drop out as of end of the month
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, '',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();

        $pdf->MultiCell(68, 5, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        //registered learners
        $pdf->MultiCell(7, 5, $maleStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $maleStud + $femaleStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $totalStud = $maleStud + $femaleStud;
        //attendance daily
        $pdf->MultiCell(7, 5, $maleStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $femaleStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalStud,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $totalStudAve = $totalMaleAve + $totalFemaleAve;
        //attendance monthly
        $pdf->MultiCell(7, 5, 100,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 100,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 100,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //Drop out
        // cumulative drop out
        $pdf->MultiCell(7, 5, $totalDrpMalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpMalePm+$totalDrpFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        // drop out for the month
        $pdf->MultiCell(7, 5, $totalDrpMaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalDrpMaleThis + $totalDrpFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $overAllDrpMale = $totalDrpMalePm + $totalDrpMaleThis;
        $overAllDrpFemale = $totalDrpFemalePm + $totalDrpFemaleThis;
        //cumulative drop out as of end of the month
        $pdf->MultiCell(7, 5, $overAllDrpMale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllDrpFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllDrpMale + $overAllDrpFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //transferred out
        
        $pdf->MultiCell(7, 5, $totalToMalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToMalePm + $totalToFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $pdf->MultiCell(7, 5, $totalToMaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalToMaleThis + $totalToFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $overAllToMale = $totalToMalePm + $totalToMaleThis;
        $overAllToFemale = $totalToFemalePm + $totalToFemaleThis;
        
        $pdf->MultiCell(7, 5, $overAllToMale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllToFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllToMale + $overAllToFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        //transferred in
        
        $pdf->MultiCell(7, 5, $totalTiMalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiMalePm + $totalTiFemalePm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $pdf->MultiCell(7, 5, $totalTiMaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $totalTiMaleThis + $totalTiFemaleThis,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        
        $overAllTiMale = $totalTiMalePm + $totalTiMaleThis;
        $overAllTiFemale = $totalTiFemalePm + $totalTiFemaleThis;
        
        $pdf->MultiCell(7, 5, $overAllTiMale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllTiFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, $overAllTiMale + $overAllTiFemale,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        
                        
                

       $pdf->AddPage('L', $resolution);

        $pdf->SetY(45);
        $pdf->SetFont('helvetica', 'B', 7);
        // set cell padding
        $pdf->setCellPaddings(1, 1, 1, 1);
        $pdf->MultiCell(15, 25, 'GRADE/
YEAR LEVEL',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(20, 25, 'SECTION',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(33, 25, 'NAME OF ADVISER',1, 'C', 0, 0, '', '', true, 0, false, true, 27, 'M');
        $pdf->MultiCell(21, 20, 'REGISTERED LEARNERS
(As of End of the Month)',1, 'C', 0, 0, '', '', true, 0, false, true, 20, 'M');
        $pdf->MultiCell(42, 5, 'ATTENDANCE',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'DROPPED OUT ',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'TRANSFERRED OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(63, 5, 'TRANSFERRED IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln();
        $pdf->setX(92);
        $pdf->MultiCell(21, 15, 'DAILY AVERAGE',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, 'PERCENTAGE FOR
THE MONTH',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A) Cumulative as 
of Previous Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(B) For the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->MultiCell(21, 15, '(A+B)
Cumulative as of End of the Month',1, 'C', 0, 0, '', '', true, 0, false, true, 15, 'M');
        $pdf->Ln();
        $pdf->setX(71);
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'M',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'F',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(7, 5, 'T',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(95);
        
        $Principal =Modules::run('hr/getEmployeeByPosition', 'Principal - High School');
        if(!empty($Principal)){
            $name = $Principal->firstname.' '.$Principal->lastname;
        }else{
            $name = "";
        }
        $pdf->MultiCell(200, 5, "# Need home visitation as per DECS Service Manual (page, section)",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(100, 5, "Prepared and Submitted by:",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->MultiCell(200, 5, "GUIDELINES:",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(100, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->MultiCell(200, 5, '1. This forms shall be accomplished every end of the month using the summary box of Form 1 submitted by the teachers/advisers to update figures for the month. Columns for "Cumulative as of Previous Month" require the figures  in "cumulative total reported from previous month".',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(10, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(70, 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->MultiCell(200, 10, '2. Furnish copy  to Division Office: a week after July 31, October 30 & March 31',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(70, 5, "( Signature of School Head Over Printed Name )",0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->MultiCell(200, 5, '3.  Teachers who are handling advisory class shall be reported. ',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(100, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->Ln();
        $pdf->MultiCell(200, 5, '4. Small school that has one section per grade/year level are not required to fill the columns "Name of Adviser, Grade/Year Level & Section".  Instead, they will only accomplish the summary column per grade/year level. ',0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'T');
        $pdf->MultiCell(20, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        $pdf->MultiCell(100, 5, "",0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
        





//Close and output PDF document
ob_end_clean();
$pdf->Output('DepEdForm4_'.date("F", mktime(0, 0, 0, segment_3, 10)).'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
