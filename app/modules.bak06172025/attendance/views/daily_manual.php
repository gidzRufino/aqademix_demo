<div id="attend_widget1"  style="margin-top:0; max-height: 250px; overflow-y: scroll;" >
    <table class="table table-striped">
        <tr>
            <td>Date</td>
            <td>AM</td>
            <td>PM</td>
            <td>Remarks</td>
            
        </tr>
        <?php
        if(!empty($attendance)){
            foreach($attendance as $a){
                if($a->time_in):
                    $AM = 'Present';
                else:
                    $AM = 'Absent';
                endif;
                if($a->time_in_pm):
                    $PM = 'Present';
                else:
                    $PM = 'Absent';
                endif;
                
        ?>
        <tr>
            <td><?php echo $a->date; ?></td>
            <td><?php echo $AM; ?></td>
            <td><?php echo $PM; ?></td>
            <td></td>
            
        </tr>



        <?php }
            }else{
                echo '<tr><td colspan="5" style="text-align:center">Sorry, Attendance not found!</td></tr>';
            }
        ?>
    </table>
</div>

