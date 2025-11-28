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
$pdf->MultiCell(108, 10, $settings->set_school_name,0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln(6);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 10);
$pdf->MultiCell(108, 5, $settings->set_school_address,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'T');
$pdf->Ln();
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'b', 18);
$pdf->MultiCell(108, 10, 'DAILY TIME RECORD',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');
$pdf->Ln();
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'N', 12);
$pdf->MultiCell(108, 10, '[ '.date('F d, Y', strtotime(segment_3)).' - '.date('F d, Y', strtotime(segment_4)).' ]',0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'T');

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


$pdf->SetXY(25, 51);
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'IN',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
$pdf->MultiCell(10, 5, 'OUT',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');

$records = Modules::run('hr/searchDtrbyDateForPrint',segment_3, segment_4, $info->uid);

        $timeOutCompute = 0;
        $timeInPMCompute = 0;
        $timeOutPMCompute = 0;
        $totalUndertimeTardy = 0;
        $totalUndertime = 0;
        foreach ($records as $row)
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
                    $forUnderIn = "";
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
                
        $officialTime = Modules::run('hr/hrdbprocess/getTimeShift', $info->time_group_id);
        //print_r($officialTime);
        $officialTimeInAm = $officialTime->ps_from;
        $officialTimeOutAm = $officialTime->ps_to;
//        
//        $officialTimeInPm = $officialTime->ps_from_pm;
        $officialTimeOutPm = $officialTime->ps_to_pm;
        
       
        if($timeInCompute!=0):// In AM
            $tardyAm = ((strtotime($time_in) - strtotime($officialTimeInAm)))<= 0?0:(strtotime($time_in) - strtotime($officialTimeInAm))/60;
        else:
            $tardyAm = 4*60;
        endif;
        if($timeOutCompute!=0):
            $undertimeAm = ((strtotime($officialTimeOutAm) - strtotime($time_out)))<= 0?0:(strtotime($officialTimeOutAm) - strtotime($time_out))/60;
            $totalUndertime = $tardyAm + $undertimeAm;
        else:
            if($timeOutPMCompute==0):
                $totalUndertime = 4*60;
            else:
                $totalUndertime = $tardyAm;
            endif;
        endif;
        if($timeInPMCompute!=0):
            $tardyPm = ((strtotime($time_in_pm) - strtotime($officialTimeInAm)))<= 0?0:(strtotime($time_in_pm) - strtotime($officialTimeInAm))/60;
        else:
            
        endif;
        if($timeOutPMCompute!=0):
                $undertimePM =  (strtotime($officialTimeOutPm) - strtotime($time_out_pm)) <= 0?0:(strtotime($officialTimeOutPm) - strtotime($time_out_pm))/60;
                $totalUndertimePm = $undertimePM;
            else:
                $totalUndertimePm = 4*60;
            endif;
        //echo $totalUndertimePm+$tardyPm;
       // $totalUndertimeTardy = ($tardyAm + $undertimeAm)+($tardyPm+$undertimePm);
        $totalUndertimeTardy = $totalUndertime+$totalUndertimePm;
                
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
    
    $HoursAM = $hrdb->getManHours($time_in, $time_out, $row->date); 
    $HoursPM = $hrdb->getManHours($time_in_pm, $time_out_pm, $row->date); 
    $totaltimeAM = json_decode($HoursAM);
    $totaltimePM = json_decode($HoursPM);

    $totalAmH = $totaltimeAM->totalTime;
    $totalPmH = $totaltimePM->totalTime;
    if($time_out==0 && $time_out_pm!=0):
        $totalAmH = 4;
    endif;


    $totalTimeH = $totalAmH + $totalPmH;
    $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;

    //if to follow strict man hours uncomment this next line;
    //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;

    //uncomment this next line if you are going to be strict in 8 hour mode;
    $totalH = (8 * 60)-$totalUndertimeTardy;
    
    $pdf->MultiCell(20, 5, abs(date('H', mktime(0,$totalH))).'h '. abs(date('i', mktime(0,$totalTimeM))).'m',1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');   
    $overAllTardy += $totalUndertimeTardy;
    $totalManHours += abs(date('H', mktime(0,$totalH)));
    $totalManMin += $totalTimeM;
    
    
    unset($totalTimeH);
    unset($totalTimeM);
    unset($undertimeAm);
    unset($undertimePM);
    unset($totalUndertime);
    unset($totalUndertimePm);
    $timeInCompute = 0;
    $timeInPMCompute = 0;
    $timeOutCompute = 0;
    $timeOutPMCompute = 0;
}

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->MultiCell(100, 5, "Number of Late / Undertimes : ".($overAllTardy) .' Minutes',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln(5); 
$pdf->SetX(5);
$totalHoursWork = round(($totalManMin/60),2)+$totalManHours;
$pdf->MultiCell(100, 5,"Number of Hours Worked : ".$totalHoursWork.' hours',0, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M'); 

$pdf->Ln(10);
$pdf->SetX(5);
$pdf->MultiCell(108, 5, '"I CERTIFY on my honor that the above is true and correct report on hours performed, recorded with was made daily at the time of arrival and departure."',0, 'L', 0, 0, '', '', true, 0, true, true, 5, 'M');

$pdf->Ln(15);
$pdf->SetX(50);
$pdf->MultiCell(50, 5, $name,'B', 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 
$pdf->Ln();
$pdf->SetX(50);
$pdf->MultiCell(50, 5, $info->position,0, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M'); 

$pdf->SetXY(0,165);

$pdf->SetFont('helvetica', 'N', 6);
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(0, 0, 0));
$pdf->SetLineStyle($style3);
$pdf->MultiCell(108, 5, 'This is a computer generated form.          ','B', 'R', 0, 0, '', '', true, 0, false, true, 5, 'T');

ob_start();
$pdf->Output($info->lastname.'-DTR_'.segment_3.'-'.segment_4.'.pdf', 'I');
$output = ob_get_contents();
ob_end_clean();
echo $output;