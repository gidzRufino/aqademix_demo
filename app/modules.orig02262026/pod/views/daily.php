<div id="attend_widget1" class="col-lg-12" style="margin-top:10px; max-height: 350px; overflow-y: scroll;" >
    <table class="table table-striped">
        <tr>
            <td>Date</td>
            <td>Time In(AM)</td>
            <td>Time Out(AM)</td>
            <td>Time In(PM)</td>
            <td>Time Out(PM)</td>
        </tr>
        <?php
        //print_r($attendance);
        if(!empty($attendance)){
            foreach($attendance as $a){
                if($a->time_in!=""):
                    if($a->time_in<1000){
                        $time_in = date("g:i a", strtotime("0".$a->time_in));
                    }else{
                        $time_in = $a->time_in;
                    }
                else:
                    $time_in = "";
                endif;
                
                if($a->time_out!=""){
                    if($a->time_out<1000    ){
                        $time_out = date("g:i a", strtotime("0".$a->time_out));
                    }else{
                        $time_out =date("g:i a", strtotime($a->time_out));
                    }
                }else{
                    $time_out = "";
                }
                
                if($a->time_in_pm!=""){
                    if($a->time_in_pm<1000){
                        $time_in_pm = date("g:i a", strtotime($a->time_in_pm));
                    }else{
                        $time_in_pm = date("g:i a", strtotime($a->time_in_pm));
                    }
                }else{
                    $time_in_pm = "";
                }
                if($a->time_out_pm!=""){
                    if($a->time_out_pm<1000){
                        $time_out_pm = date("g:i a", strtotime($a->time_out_pm));
                    }else{
                        $time_out_pm = date("g:i a", strtotime($a->time_out_pm));
                    }
                }else{
                    $time_out_pm = "";
                }
                
        ?>
        <tr>
            <td><?php echo $a->date; ?></td>
            <td><?php echo $time_in; ?></td>
            <td><?php echo $time_out; ?></td>
            <td><?php echo $time_in_pm; ?></td>
            <td><?php echo $time_out_pm; ?></td>
        </tr>



        <?php }
            }else{
                echo '<tr><td colspan="5" style="text-align:center">Sorry, Attendance not found!</td></tr>';
            }
        ?>
    </table>
</div>

