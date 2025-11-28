<table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table">
        <tr>
           <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5></td>
            <td colspan="2" ><h5>MORNING</h5></td>
            <td colspan="2"><h5>AFTERNOON</h5>
            <td width="5%"><h5>UNDERTIME</h5>
            <td><h5>OVERTIME</h5>
            <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5></td>
        </tr>
        <tr>
            <td style="width:8%">
                <h5>IN</h5>
        
            </td>
            <td style="width:8%">
                <h5>OUT</h5>
            </td>
            <td style="width:8%">
                <h5>IN</h5>
        
            </td>
            <td style="width:8%">
                <h5>OUT</h5>
            </td>
            <td  style="width:5%">
            </td>
            <td style="width:8%; text-align: center">
                <button class="btn btn-xs btn-success">Request OT</button>
            </td>
        </tr>
    </table>
    <table class='table table-striped'> 
        <?php 
        $timeInCompute = 0;
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
        $officialTimeInPm = $officialTime->ps_from_pm;
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
        
        if($row->date!=date('Y-m-d')):
            $totalUndertimeTardy = $totalUndertime;
        endif;
?>  
        <tr>
            <td width="10%">
                <h5><?php echo $row->date ?></h5>
        
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_in ?></h5>
        
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_out ?></h5>
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_in_pm ?></h5>
        
            </td>
            <td style="width:8%; text-align: center;">
                <h5><?php echo $time_out_pm ?></h5>
            </td>
            <td  style="width:8%; text-align: center;">
                <h5><?php echo Modules::run('hr/convertToHoursMins',$totalUndertimeTardy) ?></h5>
            </td>
            <td style="width:8%; text-align: center;">
                <h5>0 </h5>
        
            </td>
            <!-- <td width="10%" style=" text-align: center;" onmouseover="$('#edit_<?php echo $row->att_id ?>').show()" onmouseout="$('#edit_<?php // echo $row->att_id ?>').hide()"> -->
            <td width="10%" style=" text-align: center;">
                <h5 class="pull-left">
                    <?php
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
                        
                        if($row->date!=date('Y-m-d')):
                            $totalH = (8 * 60)-$totalUndertimeTardy;
                        else:    
                            $totalH = 0;
                        endif;
                        
                        echo abs(date('H:i', mktime(0,$totalH))).'h '. abs(date('i', mktime(0,$totalH))).'m';
                        //echo $timeOutCompute;
                        $totalHours += abs(date('H', mktime(0,$totalH)));
                        $totalMin += date('i', mktime(0,$totalH));
                        $overAllTardy += $totalUndertimeTardy;
                    ?>
                    
                </h5>
                <?php if($this->session->is_superAdmin || $this->session->position =='Human Resource Department Head' || $this->session->position =='Human Resource Department Staff' || $this->session->position =='HRMO Secretary' || $this->session->position == 'Accounting - Admin'): ?>
                    <i onclick="editTimeData('<?php echo $row->att_id ?>','<?php echo $row->date ?>','<?php echo $row->u_rfid ?>','<?php echo $row->att_st_id ?>')" style="margin-top:10px; color: green" id="edit_<?php echo $row->att_id ?>" class="fa fa-edit pull-right pointer"></i>
                    <i onclick="delDateTime('<?php echo $row->att_id ?>','<?php echo $row->date ?>')" style="margin-top:10px; color: red" id="delete_<?php echo $row->att_id ?>" class="fa fa-trash pull-right pointer">&nbsp;</i>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            unset($totalTimeH);
            unset($totalTimeM);
            unset($undertimeAm);
            unset($undertimePM);
            unset($totalUndertime);
            unset($totalUndertimePm);
            unset($totalUndertimeTardy);
            $timeInCompute = 0;
            $timeInPMCompute = 0;
            $timeOutCompute = 0;
            $timeOutPMCompute = 0;
            }     
        ?>
            
        
    </table>
<input type="hidden" id="totalHoursRendered" value="<?php echo round(($totalMin/60),2)+$totalHours ?>" />
<input type="hidden" id="hoursRequired" value="<?php echo $hoursRequired ?>" />
<!--<input type="hidden" id="minutesTardy" value="<?php echo abs(date('H', mktime(0,$totalHours))) ?>" />-->
<input type="hidden" id="minutesTardy" value="<?php echo $overAllTardy ?>" />