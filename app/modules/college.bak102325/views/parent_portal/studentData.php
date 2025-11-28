<div class="col-lg-7">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h5 class="text-center no-margin">Academic Performance</h5>
        </div>
        <div id="acadBody" class="panel-body">
           <table class="table table-striped">
    <thead>
        <tr>
            <th colspan="6" class="text-center">ACADEMIC</th>
        </tr>
        <tr class="quarterTitle">
            <th style="width:20%;">SUBJECT</th>
            <th class="text-center" style="width:15%;">FIRST</th>
            <th class="text-center" style="width:15%;">SECOND</th>
            <th class="text-center" style="width:15%;">THIRD</th>
            <th class="text-center" style="width:15%;">FOURTH</th>
            <th class="text-center" style="width:15%;">FINAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $subject = Modules::run('academic/getSpecificSubjectPerlevel', $grade_id); 
        $gs_settings = Modules::run('gradingsystem/getSet', $year);
        
        $i=0;
        foreach($subject as $s):
            $i++;
            $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            $grade = json_decode(Modules::run('gradingsystem/getGradeForCard', $student->st_id, $s->sub_id, $year));
            switch ($gs_settings->gs_used):
                case 1:
                    $first = $grade->first;
                    $second = $grade->second;
                    $third = $grade->third;
                    $fourth = $grade->fourth;
                break;
                case 2:
                    $first = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->first);
                    $second = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->second);
                    $third = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->third);
                    $fourth = Modules::run('gradingsystem/new_gs/getTransmutation', $grade->fourth);
                    $fg = Modules::run('gradingsystem/getFinalGrade', $student->st_id, $s->sub_id, $term, $year);
                break;
            endswitch;
            
        ?>
        <tr class="data">
            <td><?php echo $singleSub->subject ?></td>
            <td class="text-center text-strong value"><?php echo ($first==""? 0 : $first) ?></td>
            <td class="text-center text-strong value"><?php echo ($second=="" ? 0 : $second) ?></td>
            <td class="text-center text-strong value"><?php echo ($third=="" ? 0 : $third) ?></td>
            <td class="text-center text-strong value"><?php echo ($fourth=="" ? 0 : $fourth) ?></td>
            <td class="text-center"><strong class="sum"></td>
        </tr>
        <?php
        endforeach;    
        ?>
    </tbody>
    
</table>
        </div>
    </div>

</div>
<div class="col-lg-5">
    <div class="panel panel-green">
        <div class="panel-heading">
            <h5 class="text-center no-margin">Attendance Record</h5>
        </div>
        <div id="attendBody" class="panel-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>Month</td>
                    <td class="text-center">School Days</td>
                    <td class="text-center">Days Present</td>
                </tr>
                <tr>
                    <td>June</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 6, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 6, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>July</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 7, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 7, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>August</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 8, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 8, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>September</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 9, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 9, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>October</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 10, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 10, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>November</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 11, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 11, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>December</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 12, $year, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 12, $year, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>January</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 1, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 1, $year+1, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>February</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 2, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 2, $year+1, $year); ?>
                    </td>
                </tr>
                <tr>
                    <td>March</td>
                    <td class="text-center">
                        <?php echo Modules::run('pp/numberOfSchoolDays', 3, $year+1, $year) ?>
                    </td>
                    <td class="text-center">
                        <?php echo Modules::run('attendance/getIndividualMonthlyAttendance', $student->st_id, 3, $year+1, $year); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>