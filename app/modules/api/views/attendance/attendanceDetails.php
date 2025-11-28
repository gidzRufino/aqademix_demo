<table class="table table-striped table-responsive table-bordered">
        <tr>
            <th class="text-center">DATE</th>
            <th class="text-center" >NAME</th>
            <th class="text-center">IN</th>
            <th class="text-center">OUT</th>
        </tr>
    <?php 
        $students = explode(',', $st_id);
        $lastDay = Modules::run('main/getFirstLastDay', date("F", mktime(0, 0, 0, date('m', strtotime($month)), 10)), $year, 'last');
        
        for($x= abs(date('d'));$x>=1;$x--):
            $day = date('D', strtotime($year.'-'.date('m', strtotime($month)).'-'.($x>=10?$x:'0'.$x)));
            
            if($day=='Sat'||$day=='Sun'):
            else:
    ?>
        <tr>
            <th rowspan="<?php echo count($students) ?>" class="text-center" style="width: 20%;"><?php echo date('F', strtotime($month)).' '.($x>=10?$x:'0'.$x).', '.$year ?></th>

            <?php
                foreach ($students as $s):
                $student = Modules::run('registrar/getSingleStudent', $s, $school_year);
                $attendance = Modules::run('api/attendance_api/getDailyAttendance', $s, $year.'-'.date('m', strtotime($month)).'-'.($x>=10?$x:'0'.$x));
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