<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header" style="margin:5px auto">Employee's Weekly Attendance Log
            <small class="pull-right" >
                <div class="form-group input-group">
                    <input style="height:34px;" name="inputBdate" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $date; ?>" id="inputBdate" placeholder="Search for Date" required>
                    <span class="input-group-btn">
                        <button class="btn btn-success"onclick="searchAttendance($('#inputBdate').val())">
                            <i id="verify_icon" class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                
            </small>
        
        </h3>
        
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-4 pull-right">
            <?php
                echo $links;
            ?>
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th style="width: 5px;">#</th>
                <th style="width: 300px;">Employee</th>
                <th class="text-center">Monday</th>
                <th class="text-center">Tuesday</th>
                <th class="text-center">Wednesday</th>
                <th class="text-center">Thursday</th>
                <th class="text-center">Friday</th>
                <th class="text-center">Saturday</th>
            </tr>
            <?php
            $i=1;
                foreach($employees->result() as $basicInfo):
                ?>
                <tr>
                    <td rowspan="2"><?php echo $i++; ?></td>
                    <td rowspan="2"><?php echo strtoupper($basicInfo->firstname.' '.$basicInfo->lastname) ?></td>
                    
                    <?php
                        $days = Modules::run('hr/daysOftheWeek',Modules::run('hr/time_for_week_day','monday', strtotime($date)));
                        foreach ( $days as $d ):
                            $attendance = Modules::run('hr/getEmployeeDailyAttendance', $basicInfo->employee_id, $d);
                            if($attendance):
                                if(mb_strlen($attendance->time_in)<=3):
                                    $time_in = date("g:i a", strtotime("0".$attendance->time_in));
                                 else:
                                     $time_in = date("g:i a", strtotime($attendance->time_in));
                                 endif;
                            else:
                                $time_in = 'Absent';
                            endif;     
                    ?>
                    <td>AM | <?php echo ($d <= date('Y-m-d')?$time_in:''); ?></td>
                    <?php
                        endforeach;
                    ?>
                </tr>
                <tr>
                    <?php
                        $days = Modules::run('hr/daysOftheWeek',Modules::run('hr/time_for_week_day','monday', strtotime($date)));
                        foreach ( $days as $d ):
                            $attendance = Modules::run('hr/getEmployeeDailyAttendance', $basicInfo->employee_id, $d);
                            if($attendance):
                                if($attendance->time_in_pm!=""):
                                    if(mb_strlen($attendance->time_in_pm)<=3):
                                        $time_in_pm = date("g:i a", strtotime("0".$attendance->time_in_pm));
                                     else:
                                         $time_in_pm = date("g:i a", strtotime($attendance->time_in_pm));
                                     endif;
                                else:
                                    $time_in_pm = '';
                                endif;     
                            else:
                                $time_in_pm = 'Absent';
                            endif; 
                    ?>
                    <td>PM | <?php echo ($d <= date('Y-m-d')?$time_in_pm:''); ?></td>
                    <?php
                        endforeach;
                    ?>
                </tr>
                <?php
                endforeach;
            ?>
        </table>
    </div>
</div>
<div class="row">
    
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(".clickover").clickover({
                placement: 'bottom',
                html: true
              });
    })
    
    function saveTime(id)
    {
        var hour = $('#'+id+'_hr').val();
        var min = $('#'+id+'_min').val();
        var select = $('#'+id+'_ampm').val();
        var t_id = $('#'+id+'_dtr').val();
        var date = $('#inputBdate').val();
        var inout = $('#'+id+'_inout').val();
        
        var url = "<?php echo base_url().'hr/saveManualHrAttendance/'?>";
        $.ajax({
               type: "POST",
               url: url,
               //dataType:'json',
               data: 't_id='+t_id+'&hour='+hour+'&min='+min+'&ampm='+select+'&date='+date+'&inout='+inout+'&csrf_test_name='+$.cookie('csrf_cookie_name'),
               success: function(data)
               {
                   $('#present_em').html(data)
               }
        })
    }
    function searchAttendance(date)
    {
            
            var url = "<?php echo base_url().'hr/getWeeklyAttendance/' ?>"+date; // the script where you handle the form input.
            document.location = url;
    }
</script>