<table border="1" style="margin:0; border: 1px solid #DDDDDD;"  class="table">
        <tr>
           <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">DATE</h5></td>
            <td colspan="2" ><h5>MORNING</h5></td>
            <td colspan="2"><h5>AFTERNOON</h5>
            <td colspan="2"><h5>OVERTIME</h5>
            <td width="10%" rowspan="2"><h5 style="margin-top:35px; font-size:18px; text-align: center;">Daily<br>Total</h5></td>
        </tr>
        <tr>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
            <td style="width:12%">
                <h5>IN</h5>
        
            </td>
            <td style="width:12%">
                <h5>OUT</h5>
            </td>
        </tr>
    </table>
    <table class='table table-striped'> 
        <?php 
        $finalhours = 0;
        $finaltardy = 0;
        $finalunder = 0;
        $tard = 0;
        $under = 0;
        foreach ($records as $row)
        {
                if($row->time_in!=""){
                    if($row->time_in<1000){
                        $time_in = date("g:i a", strtotime("0".$row->time_in));
                        $timeInCompute = '0'.$row->time_in;
                    }else{
                        $time_in = date("g:i a", strtotime($row->time_in));
                        $timeInCompute = $row->time_in;
                    }
                    
                }else{
                    $time_in = "";
                }
                
                if($row->time_out!=""){
                    if($row->time_out<1000){
                        
                        $time_out = date("g:i a", strtotime("0".$row->time_out));
                    }else{
                        $time_out = date("g:i a", strtotime($row->time_out));
                    }
                    $timeOutCompute = $row->time_out;
                }else{
                    $time_out = "";
                }
                
                if($row->time_in_pm!=""){
                        $time_in_pm = date("g:i a", strtotime($row->time_in_pm));
                      $timeInCompute = $row->time_in_pm;  
                }else{
                    $time_in_pm = "";
                }
                if($row->time_out_pm!=""){
                        $time_out_pm = date("g:i a", strtotime($row->time_out_pm));
                        $timeOutCompute = $row->time_out_pm;
                }else{
                    $time_out_pm = "";
                }

?>
        <tr>
            <td width="10%">
                <h5><?php echo $row->date ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_in ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_out ?></h5>
            </td>
            <td style="width:12%">
                <h5><?php echo $time_in_pm ?></h5>
        
            </td>
            <td style="width:12%">
                <h5><?php echo $time_out_pm ?></h5>
            </td>
            <td style="width:12%">
                <h5>0</h5>
        
            </td>
            <td style="width:12%">
                <h5>0</h5>
        
            </td>
            <td width="10%">
                <h5>
                    <?php
                       
                      $Hours = $hrdb->getNumberOfHoursWork($timeInCompute, $timeOutCompute); 
                       
                      //echo $Hours['early'].'<br>';
                      //echo $Hours['over'].'<br>';
                      echo $Hours['totalTime'];

                    ?>
                    
                </h5>
            </td>
        </tr>
        <?php 
            }     
        ?>
            
        <!--records is taken from controller dtr-->
        
    </table>