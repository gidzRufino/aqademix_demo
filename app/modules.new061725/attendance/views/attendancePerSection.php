
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header clearfix" style="margin:0">Generate Attendance Records
            <div class="col-md-2 pull-right" id="ViewGenAtt">
                <button class="btn btn-sm btn-primary" onclick="getStudents($('#grade').val())" style="cursor: pointer; font-size: medium; padding: 5px; width: 100%""><i class="fa fa-file-archive-o"></i>&nbsp;&nbsp;View Generated Attendance</button>
                <button class="btn btn btn-danger" onclick="getStudentsTardy($('#grade').val())" style="cursor: pointer; font-size: medium; padding: 5px; width: 100%""><i class="fa fa-file-archive-o"></i>&nbsp;&nbsp;View Attendance Tardy</button>
                <button class="btn btn-sm btn-warning" onclick="getGeneratedSPR($('#grade').val()) "style="cursor: pointer; font-size: medium; padding: 5px; width: 100%"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Generate Attendance</button>
                <button class="btn btn-sm btn-info" onclick="getGeneratedTardy($('#grade').val()) "style="cursor: pointer; font-size: medium; padding: 5px; width: 100%"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Generate Tardy</button>
            </div>
            <div class="col-md-2 pull-right">
                <select style="font-size:16px; width: 100%;" id="grade" name="section" >
                    <option>Select Grade</option>
                    <?php
                    foreach ($grade as $level) {
                        if ($level->grade_id > 1 && $level->grade_id < 14):
                            ?>                        
                            <option value="<?php echo $level->grade_id ?>"><?php echo $level->level; ?></option>

                            <?php
                        endif;
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-2 pull-right" id="AddedSection">
                <select tabindex="-1" id="inputMonth" style="font-size:16px; width: 100%;" class="populate select2-offscreen span2">
                    <option >Select Month</option>
                    <option value="annual">Annual</option>
                    <option value="13">January</option>
                    <option value="14">February</option>
                    <option value="15">March</option>
                    <option value="16">April</option>
                    <option value="17">May</option>
                    <option selected="selected" value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option> 
                </select>
            </div>
    </div>

</h1>
</div>
<div class="col-lg-12">
    <div style="margin-top:20px; padding:10px 30px;" class="col-lg-12 alert-info" id="messageBoard">
        <h2><i class="fa fa-info-circle"></i>
            <span id="message"></span>
        </h2>
    </div>
    <div id="reportBody">

    </div>
</div>

</div>    

<script type="text/javascript">

    $(document).ready(function () {
        $('#grade').select2();
        $('#inputMonth').select2();
        //monitorSPRAttendanceGeneration(5,0);
    });

    var rows = 0;



    function getGeneratedSPR(level)
    {
        var url = '<?php echo base_url('attendance/attendance_reports/getStudents/') ?>' + level;
        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html('');
                $('#reportBody').html(data);
            }
        });

        return false;
    }
    
    function getStudentsTardy(level){
        var url = '<?php echo base_url('attendance/attendance_reports/getStudentsTardy/') ?>' + level;
        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html('');
                $('#reportBody').html(data);
            }
        });

        return false;
    }
    
    function getGeneratedTardy(level){
        var url = '<?php echo base_url('attendance/attendance_reports/getGeneratedTardy/') ?>' + level;
        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html('');
                $('#reportBody').html(data);
            }
        });

        return false;
    }
    
    function getStudents(level)
    {
        var url = '<?php echo base_url('attendance/attendance_reports/getStudentsByLevel/') ?>' + level;
        $.ajax({
            type: "POST",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html('');
                $('#reportBody').html(data);
            }
        });

        return false;
    }

    function generateSPR(level)
    {
        var url = '<?php echo base_url('attendance/attendance_reports/saveSPR/') ?>' + level;
        $.ajax({
            type: "GET",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html(data);
            }
        });

        return false;
    }

    function generateSPRAttendance(level)
    {
        //monitorSPRAttendanceGeneration(level, 0);
        var url = '<?php echo base_url('attendance/attendance_reports/saveSPRAttendance/') ?>' + level;
        $.ajax({
            type: "GET",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                $('#message').html('Please Wait while the system is fetching records...');
            },
            success: function (data)
            {
                $('#message').html(data);
            }
        });

        return false;
    }

    function monitorSPRAttendanceGeneration(level, row)
    {
        var url = '<?php echo base_url('attendance/attendance_reports/monitorAttendanceUpdates/') ?>' + level + '/' + row;
        $.ajax({
            type: "GET",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            dataType: 'json',
            success: function (data)
            {
                $('#message').html(data.msg);
                rows = data.row;
                //monitorSPRAttendanceGeneration(level, rows)
            }
        });

        return false;
    }

</script>    