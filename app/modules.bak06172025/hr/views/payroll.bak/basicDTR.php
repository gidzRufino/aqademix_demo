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
$resolution= array(216,330);
$pdf->AddPage('P', $resolution);

$settings = Modules::run('main/getSet');
$from = explode('-', segment_3);
$mFrom = $from[1];
$dFrom = $from[2];
$yFrom = $from[0];

$to = explode('-', segment_4);
$mTo = $to[1];
$dTo = $to[2];
$yTo = $to[0];

$pdf->SetXY(10,5);
$image_file = K_PATH_IMAGES.'/'.$settings->set_logo;
//$pdf->Image($image_file, 30, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(0, 5);
$pdf->SetFont('Times', 'B', 15);
$pdf->MultiCell(216, 10, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(216, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'b', 18);
$pdf->MultiCell(216, 10, 'DAILY TIME RECORD',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln();
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(216, 10, '[ '.date('F d, Y', strtotime(segment_3)).' - '.date('F d, Y', strtotime(segment_4)).' ]',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

$name = strtoupper($info->firstname.' '.substr($info->middlename, 0, 1).'. '.$info->lastname);
$lblfname = "Name of Employee";
$fname = "$lblfname : $name" ;
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(100, 10, $fname,0, 'L', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->Ln();

$pdf->SetX(5);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 10, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 5, 'MORNING',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'AFTERNOON',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'OVERTIME',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 10, 'DAILY 
TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');


$pdf->SetX(112);
$pdf->SetFont('helvetica', 'N', 8);
$pdf->MultiCell(20, 10, 'DATE',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$pdf->MultiCell(20, 5, 'MORNING',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'AFTERNOON',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 5, 'OVERTIME',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(20, 10, 'DAILY 
TOTAL',1, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');


$firstFifteen = Modules::run('hr/searchDtrbyDateForPrint',$yFrom.'-'.$mFrom.'-'.$dFrom, $yFrom.'-'.$mFrom.'-15', $info->uid);
$timeInCompute = 0;
$timeOutCompute = 0;
$timeInPMCompute = 0;
$timeOutPMCompute = 0;
foreach ($firstFifteen as $row)
 {
                if($row->time_in!=""){
                    if(mb_strlen($row->time_in)<=3):
                       $time_in = date("g:i a", strtotime("0".$row->time_in));
                       $forUnderIn = date("g:i:s", strtotime("0".$row->time_in));
                    else:
                        $time_in = date("g:i a", strtotime($row->time_in));
                       $forUnderIn = date("g:i:s", strtotime($row->time_in)); 
                    endif;
                     
                     $timeInCompute = $row->time_in;
                    
                }else{
                    $time_in = "";
                }
                
                if($row->time_out!=""){
                    if(mb_strlen($row->time_out)<=3):
                        $time_out = date("g:i a", strtotime('0'.$row->time_out));
                    else:
                        $time_out = date("g:i a", strtotime($row->time_out));
                    endif;
                    $timeOutCompute = $row->time_out;
                }else{
                    $time_out = "";
                }
                
                
                if($row->time_in_pm!=""){
                        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                      $timeInPMCompute = $row->time_in_pm;  
                }else{
                    $time_in_pm = "";
                }
                if($row->time_out_pm!=""){
                        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                        $timeOutPMCompute = $row->time_out_pm;
                       $forUnderPMOut = date("g:i:s", strtotime($row->time_out_pm));
                }else{
                    $time_out_pm = "";
                       $forUnderPMOut = "";
                    
                    
                }
                
                $undertimeIn = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderIn, 'in');
                $undertimePMOut = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderPMOut, 'out');
                $totalUndertime = $undertimeIn + $undertimePMOut;
                
                if($timeOutCompute=="" && $timeOutPMCompute!=""):
                     $timeOutCompute = 1200;
                endif;
                if($timeInPMCompute=="" && $timeOutPMCompute!=""):
                     $timeInPMCompute = 1300;
                endif;
                
                $HoursAM = $hrdb->getManHours($timeInCompute, $timeOutCompute, $row->date); 
                $HoursPM = $hrdb->getManHours($timeInPMCompute, $timeOutPMCompute, $row->date); 
                $totaltimeAM = json_decode($HoursAM);
                $totaltimePM = json_decode($HoursPM);

                $totalAmH = $totaltimeAM->totalTime;
                $totalPmH = $totaltimePM->totalTime;
                if($time_out=="" && $time_out_pm!=""):
                    $totalAmH = 4;
                endif;

//
//                $totalTimeH = $totalAmH + $totalPmH;
//                $totalTimeMH = $totaltimeAM->minutes + $totaltimePM->minutes;
//                if($totalTimeMH>60):
//                    $totalTimeH = $totalTimeH + 1;
//                endif;
//                $totalTimeM = ($totaltimeAM->minutes + $totaltimePM->minutes) % 60;
                //if to follow strict man hours uncomment this next line;
                //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;

                //uncomment this next line if you are going to be strict in 8 hour mode;
                 $totalHA = (8 * 60)-$totalUndertime;
                
    $pdf->Ln();
    $pdf->SetX(5);
    $pdf->MultiCell(20, 5, $row->date,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');     
    $pdf->MultiCell(10, 5, $time_in,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_out,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_in_pm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_out_pm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, 0,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, 0,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
//    $pdf->MultiCell(20, 5, $totalTimeH.'h '.$totalTimeM.'m',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
    $pdf->MultiCell(20, 5, abs(date('H', mktime(0,$totalHA))).'h '. abs(date('i', mktime(0,$totalHA))).'m',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');   
    $overAllTimeFFH += $totalTimeH;
    $overAllTimeFFM += $totalTimeM;
    $overAllTotalHA += $totalHA;
    $OverAllUndertimeA += $totalUndertime;
    unset($timeOutCompute);
    unset($timeOutPMCompute);
}

$pdf->SetXY(25, 51);
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$pdf->SetXY(132, 51);
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$secondFifteen = Modules::run('hr/searchDtrbyDateForPrint',$yFrom.'-'.$mFrom.'-16', $yFrom.'-'.$mFrom.'-'.$dTo, $info->uid);
foreach ($secondFifteen as $row)
 {
                if($row->time_in!=""){
                    if(mb_strlen($row->time_in)<=3):
                       $time_in = date("g:i a", strtotime("0".$row->time_in));
                       $forUnderIn = date("g:i:s", strtotime("0".$row->time_in));
                    else:
                        $time_in = date("g:i a", strtotime($row->time_in));
                       $forUnderIn = date("g:i:s", strtotime($row->time_in)); 
                    endif;
                     
                     $timeInCompute = $row->time_in;
                    
                }else{
                    $time_in = "";
                }
                
                if($row->time_out!=""){
                    if(mb_strlen($row->time_out)<=3):
                        $time_out = date("g:i a", strtotime('0'.$row->time_out));
                    else:
                        $time_out = date("g:i a", strtotime($row->time_out));
                    endif;
                    $timeOutCompute = $row->time_out;
                }else{
                    $time_out = "";
                }
                
                if($row->time_in_pm!=""){
                        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                      $timeInPMCompute = $row->time_in_pm;  
                }else{
                    $time_in_pm = "";
                }
                if($row->time_out_pm!=""){
                        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                        $timeOutPMCompute = $row->time_out_pm;
                       $forUnderPMOut = date("g:i:s", strtotime($row->time_out_pm));
                }else{
                    $time_out_pm = "";
                       $forUnderPMOut = "";
                }
                
                
                $undertimeIn = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderIn, 'in');
                $undertimePMOut = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderPMOut, 'out');
                $fifteenUndertime = $undertimeIn + $undertimePMOut;
                
                 if($timeOutCompute=="" && $timeOutPMCompute!=""):
                     $timeOutCompute = 1200;
                endif;
                if($timeInPMCompute=="" && $timeOutPMCompute!=""):
                     $timeInPMCompute = 1300;
                endif;
                
                $HoursAM = $hrdb->getManHours($timeInCompute, $timeOutCompute, $row->date); 
                $HoursPM = $hrdb->getManHours($timeInPMCompute, $timeOutPMCompute, $row->date); 
                $totaltimeAM = json_decode($HoursAM);
                $totaltimePM = json_decode($HoursPM);
                
                $totalAmH = $totaltimeAM->totalTime;
                $totalPmH = $totaltimePM->totalTime;
                if($time_out=="" && $time_out_pm!=""):
                    $totalAmH = 4;
                endif;


//                $totalTimeH = $totalAmH + $totalPmH;
//                $totalTimeMH = $totaltimeAM->minutes + $totaltimePM->minutes;
//                if($totalTimeMH>60):
//                    $totalTimeH = $totalTimeH + 1;
//                endif;
//                $totalTimeM = ($totaltimeAM->minutes + $totaltimePM->minutes) % 60;
//                
//                $totalTimeH = $totalAmH + $totalPmH;
//                $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;

                //if to follow strict man hours uncomment this next line;
                //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;

                //uncomment this next line if you are going to be strict in 8 hour mode;
                 $totalH = (8 * 60)- $fifteenUndertime;
                
    $pdf->Ln();
    $pdf->SetX(112);
    $pdf->MultiCell(20, 5, $row->date,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');     
    $pdf->MultiCell(10, 5, $time_in,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_out,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_in_pm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, $time_out_pm,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, 0,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    $pdf->MultiCell(10, 5, 0,1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');        
    //$pdf->MultiCell(20, 5, $totalTimeH.'h '.$totalTimeM.'m',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
    $pdf->MultiCell(20, 5, abs(date('H', mktime(0,$totalH))).'h '. abs(date('i', mktime(0,$totalH))).'m',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');  
    $overAllTimeSFH += $totalTimeH;
    $overAllTimeSFM += $totalTimeM;
    $OverAllUndertime += $fifteenUndertime;
    $overAllTotalH += $totalH;
    
    
    unset($timeOutCompute);
    unset($timeOutPMCompute);
}
    $totalManHours = ($overAllTotalH + $overAllTotalHA);
    $totalHours = (($overAllTimeFFH + $overAllTimeSFH)*60)+($overAllTimeFFM+$overAllTimeSFM);
    $overtotalH = ($totalManHours/60);
    $overtotalM = ($totalManHours % 60);

$pdf->SetXY(5, 115);
$pdf->Cell(30,5,"Number of Late / Undertimes : ".($OverAllUndertime+$OverAllUndertimeA) .' Minutes' );
$pdf->Ln(5); 
$pdf->SetX(5);
$pdf->Cell(30,5,"Number of Hours Worked : ".round($overtotalH,0,PHP_ROUND_HALF_UP).'h '.$overtotalM.'m');


$pdf->Line(108, 45, 108, 110, array('color' => 'black'));
$pdf->SetXY(112, 125);
$pdf->Ln(10);
$pdf->Cell(30,5,"I CERTIFY on my honor that the above is true and correct report on hours performed, recorded with was made daily at the time of arrival and departure.") ;
$pdf->Ln(15);
$pdf->SetX(25);
$pdf->Cell(30,5,"$name",0,0,'C');
$pdf->Ln(1);
$pdf->SetX(40);
$pdf->Cell(2,5,"________________________________",0,0,'C');
$pdf->SetX(170);
$pdf->Cell(2,5,"________________________________",0,0,'C');
$pdf->Ln(5);
$pdf->SetX(25);
$pdf->Cell(30,5,$info->position,0,0,'C');
$pdf->SetX(170);
$pdf->Cell(2,5,"Incharge",0,0,'C');

$pdf->SetXY(0,165);

$pdf->SetFont('helvetica', 'N', 6);
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(0, 0, 0));
$pdf->SetLineStyle($style3);
$pdf->MultiCell(216, 5, 'This is a computer generated form.          ','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');

ob_start();
$pdf->Output($info->lastname.'-DTR_'.segment_3.'-'.segment_4.'.pdf', 'I');
$output = ob_get_contents();
ob_end_clean();
echo $output;