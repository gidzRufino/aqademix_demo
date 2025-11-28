<div class="col-lg-12 no-padding">
    <div class="col-xs-12 no-padding" style="border-bottom: 1px solid #ccc; background: #D3DCE3;">
        <h4 class="text-center">TODAY</h4>
    </div>
    <div class="col-lg-12 no-padding">
        <table class="table table-striped table-responsive table-bordered">
            <tr>
                <th class="text-center">Name</th>
                <th class="text-center">IN</th>
                <th class="text-center">OUT</th>
            </tr>
            
            <?php
                $students = explode(',', $st_ids);
                
                foreach ($students as $s):
                    $student = Modules::run('registrar/getSingleStudent', $s, $school_year);
                    $attendance = Modules::run('api/attendance_api/getDailyAttendance', $s);
                    $time_in = (mb_strlen($attendance->time_in)<=3?"0".$attendance->time_in:$attendance->time_in);
                    $time_out = (mb_strlen($attendance->time_out)<=3?"0".$attendance->time_out:$attendance->time_out);
                    $time_out_pm = (mb_strlen($attendance->time_out_pm)<=3?"0".$attendance->time_out_pm:$attendance->time_out_pm);
                    if(!empty($attendance)):
                        ?>
                        <tr>
                            <th style="width:30%"><?php echo strtoupper($student->firstname) ?></th>
                            <th style="width:25%"><?php echo date('g:i a', strtotime($time_in)) ?></th>
                            <th style="width:25%"><?php echo ($attendance->time_out_pm!=""?date('g:i a', strtotime($time_out_pm)):($attendance->time_out!=""?date('g:i a', strtotime($time_out)):''))?></th>
                        </tr>
                        <?php
                    endif;
                endforeach;
            ?>
        </table>
    </div>
    <div class="col-xs-12 no-padding" style="border-bottom: 1px solid #ccc; background: #D3DCE3;">
        <h4 class="text-center">
            <select onclick="getAttendanceDetails(this.value)" class="selectpicker" style="width: 50%; text-align-last: center">
                <option <?php echo (date('m')==01?'selected':'') ?> value="01">JANUARY</option>
                <option <?php echo (date('m')==02?'selected':'') ?> value="02">FEBRUARY</option>
                <option <?php echo (date('m')==03?'selected':'') ?> value="03">MARCH</option>
                <option <?php echo (date('m')==04?'selected':'') ?> value="04">APRIL</option>
                <option <?php echo (date('m')==05?'selected':'') ?> value="05">MAY</option>
                <option <?php echo (date('m')==06?'selected':'') ?> value="06">JUNE</option>
                <option <?php echo (date('m')==07?'selected':'') ?> value="07">JULY</option>
                <option <?php echo (date('m')==08?'selected':'') ?> value="08">AUGUST</option>
                <option <?php echo (date('m')==09?'selected':'') ?> value="09">SEPTEMBER</option>
                <option <?php echo (date('m')==10?'selected':'') ?> value="10">OCTOBER</option>
                <option <?php echo (date('m')==11?'selected':'') ?> value="11">NOVEMBER</option>
                <option <?php echo (date('m')==12?'selected':'') ?> value="12">DECEMBER</option>
            </select>
        </h4>
    </div>
    <div id="attendanceBody" class="col-xs-12 no-padding">
        <table class="table table-striped table-responsive table-bordered">
            <tr>
                <th class="text-center">DATE</th>
                <th class="text-center" >NAME</th>
                <th class="text-center">IN</th>
                <th class="text-center">OUT</th>
            </tr>
        <?php 
            
            for($x= abs(date('d'));$x>=1;$x--):
            $day = date('D', strtotime(date('Y').'-'.date('m').'-'.($x>=10?$x:'0'.$x)));
            
            if($day=='Sat'||$day=='Sun'):
            else:
        ?>
            <tr>
                <th rowspan="<?php echo count($students) ?>" class="text-center" style="width: 20%;"><?php echo date('F').' '.($x>=10?$x:'0'.$x).', '.date('Y') ?></th>
                
                <?php
                    foreach ($students as $s):
                    $student = Modules::run('registrar/getSingleStudent', $s, $school_year);
                    $attendance = Modules::run('api/attendance_api/getDailyAttendance', $s, date('Y').'-'.date('m').'-'.($x>=10?$x:'0'.$x));
                    $time_in = (mb_strlen($attendance->time_in)<=3?"0".$attendance->time_in:$attendance->time_in);
                    $time_out = (mb_strlen($attendance->time_out)<=3?"0".$attendance->time_out:$attendance->time_out);
                    $time_out_pm = (mb_strlen($attendance->time_out_pm)<=3?"0".$attendance->time_out_pm:$attendance->time_out_pm);
                ?>
                            <th style="width:40%"><?php echo strtoupper($student->firstname) ?></th>
                            <th style="width:20%"><?php echo (empty($attendance)?'':($attendance->time_in!=""?date('g:i a', strtotime($time_in)):'')) ?></th>
                            <th style="width:20%"><?php echo (empty($attendance)?'':($attendance->time_out_pm!=""?date('g:i a', strtotime($time_out_pm)):($attendance->time_out!=""?date('g:i a', strtotime($time_out)):'')))?></th>
            
            </tr> 
                    
                <?php
                    endforeach;
                ?>               
        <?php
            endif;
            endfor;
        ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('.selectpicker').select2({
            minimumResultsForSearch: -1
        });
    });
    
    
    function getAttendanceDetails(month)
     {
         var url = "<?php echo base_url().'api/attendance_api/getAttendanceDetails/' ?>"+'<?php echo $baseId ?>/'+month+'/<?php echo $school_year ?>'; // the script where you handle the form input.

            $.ajax({
                   type: "GET",
                   url: url,
                   data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   success: function(data)
                   {
                       $("#attendanceBody").html(data);
                        
                   }
                 });

            return false;
     }
    
</script>