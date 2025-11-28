<?php

//loop through each year
$nextYear = $school_year + 1;
if($nextYear!=1):
    $sy = $school_year.' - '.$nextYear;
else:
    $sy = "";
endif;
$noEntry = $y +40;
if($school_year==""):
    //$pdf->Line($x+35, $y+8, $slashx, $slashy , array('color' => 'black','width' => .5));
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetTextColor(127);
    $pdf->Text(102, $noEntry, 'NO     ENTRY');
    $level = "";
    $pdf->setY($y);
endif;
$pdf->setCellPaddings(0.5,0.5,0.5,0.5);
$pdf->Line(8, $y, 207, $y, array('color' => 'black','width' => .5));
$pdf->SetFont('helvetica', 'N', 8);
$pdf->SetLineWidth(.2);
$pdf->MultiCell(23, 5, 'CLASSIFIED AS',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(31, 5, strtoupper($classified),'B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(8, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(10, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(18, 5, 'SCHOOL',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(60, 5, $school,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(3, 5, '',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(27, 5, 'SCHOOL YEAR',0, 'L', 0, 0, '', '', true, 0, false, true, 5, '');
$pdf->MultiCell(19, 5, $sy,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, '');

$pdf->Ln(6);
$pdf->SetFont('helvetica', 'N', 7);
$pdf->MultiCell(20, 7.5, 'Curr. Year','LTR', 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');
$pdf->MultiCell(75, 7.5, 'S U B J E C T S','LTR', 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');
$pdf->SetFont('helvetica', 'N', 6);
$pdf->setCellPaddings(0,0,0,0);
$pdf->MultiCell(44, 4, 'GRADING PERIODS','LTR', 'C', 0, 0, '', '', true, 0, false, true, 4, 'B');
$pdf->MultiCell(30, 7.5, 'Final
Rating','LTR', 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');
$pdf->MultiCell(30, 7.5, 'Action
Taken','LTR', 'C', 0, 0, '', '', true, 0, false, true, 7.5, 'M');

$pdf->Ln(4.5);
$pdf->SetFont('helvetica', 'N', 6);
$pdf->MultiCell(95, 2.9, '','', 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(11, 2.9, '1',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(11, 2.9, '2',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(11, 2.9, '3',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');
$pdf->MultiCell(11, 2.9, '4',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, '');

//loop through each subject
$pdf->setCellPaddings(1,1,1,1);
$numSubs = 0;
foreach ($subjects as $s){
$numSubs++; 
    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
    $ar = Modules::run('reports/getSPRecords',$user_id, $level_id, $singleSub->subject_id);
    $nextYear = $school_year+1;
    if(is_numeric($ar->row()->first)):
        $first = Modules::run('reports/getGrade', $ar->row()->first);
        if($ar->row()->first!=0):
            $first = $first;
        else:
            $first = "";
        endif;
    else:
        $first = $ar->row()->first;
    endif;
    
    if(is_numeric($ar->row()->second)):
        $second = Modules::run('reports/getGrade', $ar->row()->second);
        if($ar->row()->second!=0):
            $second = $second;
        else:
            $second = "";
        endif;
    else:
        $second = $ar->row()->second;
    endif;
    
    if(is_numeric($ar->row()->third)):
        $third = Modules::run('reports/getGrade', $ar->row()->third);
        if($ar->row()->third!=0):
            $third = $third;
        else:
            $third = "";
        endif;
    else:
        $third = $ar->row()->fourth;
    endif;
    
    if(is_numeric($ar->row()->fourth)):
        $fourth = Modules::run('reports/getGrade', $ar->row()->fourth);
        if($ar->row()->fourth!=0):
            $fourth = $fourth;
        else:
            $fourth = "";
        endif;
    else:
        $fourth = $ar->row()->fourth;
    endif;
    
    if($nextYear!=1):
        $currYear = $school_year.' - '.$nextYear;
    else:
        $currYear = "";
    endif;
    
    if(is_numeric($ar->row()->first)):
        if($first==""):
            $currYear = "";
        endif;

        if($ar->row()->fourth!=0):
            $division = 4;
        else:
            if($ar->row()->third!=0):
                $division = 3;
            else:
                if($ar->row()->second!=0):
                    $division = 2;
                else:
                    $division = 1;
                endif;
            endif;
        endif;

        $ave = round(($ar->row()->first+$ar->row()->second+$ar->row()->third+$ar->row()->fourth)/$division, 2);
        $l_ave = Modules::run('reports/getGrade', $ave);
        $final = $l_ave;
        if($ave>74):
            $AT = 'passed';
        else:    
            $AT = 'failed';
        endif;
        if($ar->row()->fourth==0):
                $final = '';
                $AT = "";
            endif;
    else:
        $final = $ar->row()->avg;
    endif;
            
        
    if($level_id==18):
        $l_ave = '';
        $final = $ave;
        $first = $ar->row()->first;
        $second = $ar->row()->second;
        $third = $ar->row()->third;
        $fourth = $ar->row()->fourth;
        if($first==0):
            $first = '';
        endif;
        if($second==0):
            $second = '';
        endif;
        if($third==0):
            $third = '';
        endif;
        if($fourth==0):
            $fourth = '';
            $final = '';
            $AT = "";
        endif;
    endif;
    
    if($ar->row()->subject != 'Citizen Army Training'):
        
        if($final!=""):
            $fa = $final.' / '.$ave;
        endif;
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 6);
        $pdf->MultiCell(20, 2.9, $currYear,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(75, 2.9, strtoupper($singleSub->subject),1, 'L', 0, 0, '', '', true, 0, false, true, 2.9, '');
        $pdf->MultiCell(11, 2.9, $first,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        $pdf->MultiCell(11, 2.9, $second,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        $pdf->MultiCell(11, 2.9, $third,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        $pdf->MultiCell(11, 2.9, $fourth,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        $pdf->MultiCell(30, 2.9, $fa,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
        $pdf->MultiCell(30, 2.9, $AT,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
    else:
        $pdf->Ln();
        $pdf->SetFont('helvetica', 'B', 6);
        $pdf->MultiCell(20, 2.9, $sy1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(75, 2.9, strtoupper($singleSub->subject),1, 'L', 0, 0, '', '', true, 0, false, true, 2.9, '');
        if($ar->row()->first>0):
            $pdf->MultiCell(11, 2.9, 'taken',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        else:
            $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        endif;
        if($ar->row()->second>0):
            $pdf->MultiCell(11, 2.9, 'taken',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        else:
            $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        endif;
        if($ar->row()->third>0):
            $pdf->MultiCell(11, 2.9, 'taken',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        else:
            $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        endif;
        if($ar->row()->fourth>0):
            $pdf->MultiCell(11, 2.9, 'taken',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        else:
            $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
        endif;
        $pdf->MultiCell(30, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
        $pdf->MultiCell(30, 2.9, $AT,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
    endif;
        
    $ga += $ave;
}


for($i=0;$i<=1;$i++):
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(20, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(75, 2.9, '',1, 'L', 0, 0, '', '', true, 0, false, true, 2.9, '');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(30, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
    $pdf->MultiCell(30, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
endfor;

//General Average
    if($ga!=0):
        $ga = round($ga/$numSubs, 2);
    else:
        $ga = '';
    endif;
    $pdf->Ln();
    $pdf->MultiCell(20, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->SetFont('helvetica', 'B', 6);
    $pdf->MultiCell(75, 2.9, 'General Average',1, 'L', 0, 0, '', '', true, 0, false, true, 2.9, '');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->MultiCell(11, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'T');
    $pdf->SetFont('helvetica', 'B', 6);
    $pdf->MultiCell(30, 2.9, $ga,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');
    $pdf->SetFont('helvetica', 'N', 6);
    $pdf->MultiCell(30, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'C');

//Day of School
    $pdf->Ln();
    $pdf->MultiCell(29, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 6),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 7),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 8),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 9),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 10),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 11),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 12),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 1),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 2),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(15, 2.9, Modules::run('main/getMonthName', 3),1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    $pdf->MultiCell(20, 2.9, 'TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');

//Day of School
    if(!$days['exist']):
        $pdf->Ln();
        $pdf->MultiCell(29, 2.9, 'Days of School',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(20, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    else:
        if(!empty($days['schoolDays'])):
            $schoolDays = $days['schoolDays']->row();
            $schoolDaysTotal = $schoolDays->June+$schoolDays->July+$schoolDays->August+$schoolDays->September+$schoolDays->October+$schoolDays->November+$schoolDays->December+$schoolDays->January+$schoolDays->February+$schoolDays->March;
            $pdf->Ln();
            $pdf->MultiCell(29, 2.9, 'Days of School',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->June,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->July,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->August,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->September,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->October,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->November,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->December,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->January,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->February,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(15, 2.9, $schoolDays->March,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
            $pdf->MultiCell(20, 2.9, $schoolDaysTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
         endif;
     endif;

//Day of School
    if(!$days['exist']):
        $pdf->Ln();
        $pdf->MultiCell(29, 2.9, 'Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(15, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        $pdf->MultiCell(20, 2.9, '',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    else:
        $daysPresent = $days['exist']->row();
        $presentDaysTotal = $daysPresent->June+$daysPresent->July+$daysPresent->August+$daysPresent->September+$daysPresent->October+$daysPresent->November+$daysPresent->December+$daysPresent->January+$daysPresent->February+$daysPresent->March;
         
        $pdf->Ln();
        $pdf->MultiCell(29, 2.9, 'Days Present',1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        if($daysPresent->June > $schoolDays->June):
            $pdf->MultiCell(15, 2.9, $schoolDays->June,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->June - $schoolDays->June);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->June,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->July > $schoolDays->July):
            $pdf->MultiCell(15, 2.9, $schoolDays->July,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->July - $schoolDays->July);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->July,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->August > $schoolDays->August):
            $pdf->MultiCell(15, 2.9, $schoolDays->August,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->August - $schoolDays->August);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->August,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->September > $schoolDays->September):
            $pdf->MultiCell(15, 2.9, $schoolDays->September,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->September - $schoolDays->September);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->September,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->October > $schoolDays->October):
            $pdf->MultiCell(15, 2.9, $schoolDays->October,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->October - $schoolDays->October);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->October,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->November > $schoolDays->November):
            $pdf->MultiCell(15, 2.9, $schoolDays->November,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->November - $schoolDays->November);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->November,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->December > $schoolDays->December):
            $pdf->MultiCell(15, 2.9, $schoolDays->December,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->December - $schoolDays->December);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->December,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->January > $schoolDays->January):
            $pdf->MultiCell(15, 2.9, $schoolDays->January,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->January - $schoolDays->January);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->January,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->February > $schoolDays->February):
            $pdf->MultiCell(15, 2.9, $schoolDays->February,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->February - $schoolDays->February);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->February,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        if($daysPresent->March > $schoolDays->March):
            $pdf->MultiCell(15, 2.9, $schoolDays->March,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
	    $presentDaysTotal = $presentDaysTotal - ($daysPresent->March - $schoolDays->March);
        else:
            $pdf->MultiCell(15, 2.9, $daysPresent->March,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
        endif;
        $pdf->MultiCell(20, 2.9, $presentDaysTotal,1, 'C', 0, 0, '', '', true, 0, false, true, 2.9, 'M');
    endif;

