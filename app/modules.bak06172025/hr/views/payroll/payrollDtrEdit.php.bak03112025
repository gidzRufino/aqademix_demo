<input type="hidden" id="dateFrom" value="<?php echo $dateFrom ?>" />
<input type="hidden" id="dateTo" value="<?php echo $dateTo ?>"/>
<input type="hidden" id="owners_id" value="<?php echo $owners_id ?>"/>
<table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table">
        <tr>
           <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5></td>
            <td colspan="2" ><h5>MORNING</h5></td>
            <td colspan="2"><h5>AFTERNOON</h5>
            <!--<td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5></td>-->
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
        </tr>
    </table>
    <table class='table table-striped'> 
        <?php 
        $timeInCompute = 0;
        $timeOutCompute = 0;
        $timeInPMCompute = 0;
        $timeOutPMCompute = 0;
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
                
        $undertimeIn = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderIn, 'in');
        $undertimePMOut = Modules::run('hr/hrdbprocess/getUndertime', date('w', strtotime($row->date)), $forUnderPMOut, 'out');
        $totalUndertime = $undertimeIn + $undertimePMOut;

?>
        <tr>
            <td width="10%">
                <h5 ><?php echo $row->date ?></h5>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in" style="width:8%">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_in" att_id ="<?php echo $row->att_id ?>" time_option="time_in"><?php echo $time_in ?></h5>
                
                <div id="editMenu<?php echo $row->att_id ?>-time_in">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_in')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out" style="width:8%" >
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_out" att_id ="<?php echo $row->att_id ?>" time_option="time_out"><?php echo $time_out ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_out">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_out')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_in_pm"   style="width:8%">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_in_pm" att_id ="<?php echo $row->att_id ?>" time_option="time_in_pm"><?php echo $time_in_pm ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_in_pm">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_in_pm')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
        
            </td>
            <td data-toggle="context" data-target="#editMenu<?php echo $row->att_id ?>-time_out_pm"   style="width:8%">
                <h5 class="time_input" id="<?php echo $row->att_id ?>-time_out_pm" att_id ="<?php echo $row->att_id ?>" time_option="time_out_pm"><?php echo $time_out_pm ?></h5>
                <div id="editMenu<?php echo $row->att_id ?>-time_out_pm">
                    <ul class="dropdown-menu" role="menu">
                        <li onclick="editTimeData('<?php echo $row->att_id ?>', '<?php echo $row->att_id ?>-time_out_pm')" class="pointer text-danger btn btn-primary btn-block"><i class="fa fa-clock-o fa-fw"></i>&nbsp;&nbsp;Adjust Time</li>
                    </ul>
                </div>
            </td>
            <!--<td width="10%">
                <h5>
                    <?php
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
                        
                        
                        $totalTimeH = $totalAmH + $totalPmH;
                        $totalTimeM = $totaltimeAM->minutes + $totaltimePM->minutes;
                        
                        //if to follow strict man hours uncomment this next line;
                        //$totalH = ($totalTimeH * 60+$totalTimeM)-$totalUndertime;
                        
                        //uncomment this next line if you are going to be strict in 8 hour mode;
                        $totalH = (8 * 60)-$totalUndertime;
                        
                        echo abs(date('H', mktime(0,$totalH))).'h '. abs(date('i', mktime(0,$totalH))).'m';
                        
                       
                                
                            
                        
                    ?>
                    
                </h5>
            </td>-->
        </tr>
        <?php 
            unset($totalTimeH);
            unset($totalTimeM);
            unset($undertime);
            $timeOutCompute = 0;
            $timeOutPMCompute = 0;
            }     
        ?>
            
        <!--records is taken from controller dtr-->
        
</table>
