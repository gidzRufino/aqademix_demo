<!--Education History-->
<?php
if ($edHistory->st_id != ""):
    $nameOfSchool = $edHistory->name_of_school;
    $gen_ave = $edHistory->gen_ave;
    $school_year = $edHistory->school_year;
    $total_years = $edHistory->total_years;
    $curriculum = $edHistory->curriculum;
else:
    $nameOfSchool = '';
    $gen_ave = '';
    $school_year = '';
    $total_years = '';
    $curriculum = '';
endif;
?>

<div class="col-lg-12">
    <div class="panel panel-green">
        <div class="panel-heading">
            EDUCATION HISTORY
            <i id="educMin" class="fa fa-minus fa-2x pull-right pointer" onclick="maxMin('educ', 'min')"></i>
            <i id="educMax" class="fa fa-plus fa-2x pull-right pointer hide" onclick="maxMin('educ', 'max')"></i>
            <i class="fa fa-save fa-2x pull-right pointer" onclick="saveEdHistory()"></i>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body" id="educBody">
            <div class="form-group">
                <div class="col-lg-4">
                    <label>Name of School</label>
                    <input type="text" class="form-control" id="elemSchool" value="<?php echo $nameOfSchool ?>" required/>
                </div>
                <div class="col-lg-4">
                    <label>General Average</label>
                    <input type="text" class="form-control" id="genAve" value="<?php echo $gen_ave ?>"/>
                </div>
                <div class="col-lg-4">
                    <label>School Year</label>
                    <input type="text" class="form-control" id="school_year_history" value="<?php echo $school_year ?>"/>
                </div>
                <div class="col-lg-4">
                    <label>Number of Years Completed    </label>
                    <input type="text" class="form-control" id="yearsCompleted" value="<?php echo $total_years ?>"/>
                </div>
                <div class="col-lg-4">
                    <label>Curriculum    </label>
                    <input type="text" class="form-control" id="curriculum" value="<?php echo $curriculum ?>"/>
                </div>
            </div>
        </div>
    </div>
</div>

<!--End of Education History-->
<?php
// this will show or hide the buttons
switch ($student->grade_level_id):
    case 2:
        $grade1 = '';
        $grade2 = 'hide';
        $grade3 = 'hide';
        $grade4 = 'hide';
        $grade5 = 'hide';
        $grade6 = 'hide';
        $sy1 = $sy;
        $sy2 = '';
        $sy3 = '';
        $sy4 = '';
        $sy5 = '';
        $sy6 = '';
        break;
    case 3:
        $grade1 = '';
        $grade2 = '';
        $grade3 = 'hide';
        $grade4 = 'hide';
        $grade5 = 'hide';
        $grade6 = 'hide';
        $sy1 = $sy - 1;
        $sy2 = $sy;
        $sy3 = '';
        $sy4 = '';
        $sy5 = '';
        $sy6 = '';
        break;
    case 4:
        $grade1 = '';
        $grade2 = '';
        $grade3 = '';
        $grade4 = 'hide';
        $grade5 = 'hide';
        $grade6 = 'hide';
        $sy1 = $sy - 2;
        $sy2 = $sy - 1;
        $sy3 = $sy;
        $sy4 = '';
        $sy5 = '';
        $sy6 = '';
        break;
    case 5:
        $grade1 = '';
        $grade2 = '';
        $grade3 = '';
        $grade4 = '';
        $grade5 = 'hide';
        $grade6 = 'hide';
        $sy1 = $sy - 3;
        $sy2 = $sy - 2;
        $sy3 = $sy - 1;
        $sy4 = $sy;
        $sy5 = '';
        $sy6 = '';
        break;
    case 6:
        $grade1 = '';
        $grade2 = '';
        $grade3 = '';
        $grade4 = '';
        $grade5 = '';
        $grade6 = 'hide';
        $sy1 = $sy - 4;
        $sy2 = $sy - 3;
        $sy3 = $sy - 2;
        $sy4 = $sy - 1;
        $sy5 = $sy;
        $sy6 = '';
        break;
    case 7:
        $grade1 = '';
        $grade2 = '';
        $grade3 = '';
        $grade4 = '';
        $grade5 = '';
        $grade6 = '';
        $sy1 = $sy - 5;
        $sy2 = $sy - 4;
        $sy3 = $sy - 3;
        $sy4 = $sy - 2;
        $sy5 = $sy - 1;
        $sy6 = $sy;
        break;
endswitch;
?> 
<!--Academic Records-->
<div class="col-lg-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix">
                <span style="font-size:15px;" class="col-lg-11 text-center"><i class="fa fa-book fa-fx"></i> List of Records</span>
                <i id="academicRecordsMin" class="fa fa-minus fa-2x pull-right pointer fa-fw" onclick="maxMin('academicRecords', 'min')"></i>
                <i id="academicRecordsMax" class="fa fa-plus fa-2x pull-right pointer hide fa-fw" onclick="maxMin('academicRecords', 'max')"></i>
            </div>



        </div>
        <div id="academicRecordsBody" class="panel-body">
            <div class="btn-group btn-group-justified col-lg-12" data-toggle="buttons">
                <label class="btn btn-primary <?php echo $grade1 ?>"  onclick="getAcad($('#g1').val(), '<?php echo $sy1 ?>'), $('#gradeLevel').html('Grade 1')">
                    <input type="radio" name="options" id="g1"  value="2"> Grade 1
                </label>
                <label class="btn btn-primary <?php echo $grade2 ?>"  onclick="getAcad($('#g2').val(), '<?php echo $sy2 ?>'), $('#gradeLevel').html('Grade 2')">
                    <input type="radio" name="options" id="g2"  value="3"> Grade 2
                </label>
                <label class="btn btn-primary <?php echo $grade3 ?>" onclick="getAcad($('#g3').val(), '<?php echo $sy3 ?>'), $('#gradeLevel').html('Grade 3')">
                    <input type="radio" name="options" id="g3"  value="4"> Grade 3
                </label>
                <label class="btn btn-primary <?php echo $grade4 ?>"  onclick="getAcad($('#g4').val(), '<?php echo $sy4 ?>'), $('#gradeLevel').html('Grade 4')">
                    <input type="radio" name="options" id="g4"  value="5"> Grade 4
                </label>
                <label class="btn btn-primary <?php echo $grade5 ?>" onclick="getAcad($('#g5').val(), '<?php echo $sy5 ?>'), $('#gradeLevel').html('Grade 5')">
                    <input type="radio" name="options" id="g5"  value="6"> Grade 5
                </label>
                <label class="btn btn-primary <?php echo $grade6 ?>" onclick="getAcad($('#g6').val(), '<?php echo $sy6 ?>'), $('#gradeLevel').html('Grade 6')">
                    <input type="radio" name="options" id="g6"  value="7"> Grade 6
                </label>
            </div>
            <div class=" col-lg-12">
                <div class="alert alert-success clearfix" style="margin-bottom: 0; padding: 3px;">
                    <h4 class="text-center">Academic Records
                        <!--                        <a href="#selection" onclick="addRecords()" id="addRecords" data-toggle="modal" class="pull-right">
                                                    <i onclick="checkIfAcadExist()" class="fa fa-folder-open pointer"></i>
                                                </a>-->

                        <i id="acadRecordsUnlock" class="fa fa-unlock-alt pull-right hide pointer fa-fw" onclick="lockUnlock('acadRecords', 'Lock')"></i>
                        <i id="acadRecordsLock" class="fa fa-lock pull-right pointer hide fa-fw" onclick="lockUnlock('acadRecords', 'Unlock')"></i>
                        <i id="acadRecordsMin" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('acadRecords', 'min')"></i>
                        <i id="acadRecordsMax" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('acadRecords', 'max')"></i>
                    </h4>

                </div>
                <div id="acadRecordsBody">

                </div>
            </div>
            <div class="col-lg-12">
                <div class="alert alert-success" style="margin-bottom: 0; padding: 3px;">
                    <h4 class="text-center">Attendance Record
                        <a href="#attendanceInformation" onclick="addRecords()" id="addAttendance" data-toggle="modal">
                            <i onclick="checkIfAcadExist()" class="pull-right fa fa-clock-o pointer"></i>
                        </a>
                        <i id="attendRecordsMin" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('attendRecords', 'min')"></i>
                        <i id="attendRecordsMax" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('attendRecords', 'max')"></i>   
                    </h4>
                </div>
                <div id="attendRecordsBody">

                </div>
            </div>

        </div>
        <input type="hidden" id="selectedLevel" />
    </div>
</div>
<input type="hidden" id="fetchSchoolYear" />

<script type="text/javascript">

    function maxMin(body, action)
    {
        if (action == "max") {
            $('#' + body + 'Min').removeClass('hide');
            $('#' + body + 'Max').addClass('hide')
            $('#' + body + 'Body').removeClass('hide fade');
        } else {
            $('#' + body + 'Min').addClass('hide')
            $('#' + body + 'Max').removeClass('hide');
            $('#' + body + 'Body').addClass('hide fade');

        }
    }

    function lockUnlock(body, action)
    {
        if (action == "Unlock") {

            var con = confirm('Are you sure you want to revoke the validity of the records?');
            if (con == true) {
                $('#' + body + 'Lock').addClass('hide');
                $('#' + body + 'Unlock').removeClass('hide')
                lockRecords(0)
            }

        } else {
            var con = confirm('Are you sure you want validate the records?');
            if (con == true) {
                lockRecords(1)
                $('#' + body + 'Lock').removeClass('hide')
                $('#' + body + 'Unlock').addClass('hide');
            }



        }
    }

    function lockRecords(option)
    {
        var url = "<?php echo base_url() . 'reports/lock_unlock_SPR/' ?>"
        $.ajax({
            type: "POST",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name') + '&spr_id=' + $('#getSPR').val() + '&option=' + option,

            success: function (data)
            {

            }
        });
    }

    function addRecords()
    {
        var selectedLevel = $('#selectedLevel').val()
    }

    function checkSubject(subject_id, spr_id)
    {
        var url = "<?php echo base_url() . 'reports/checkSubject/' ?>" + subject_id + '/' + spr_id
        $.ajax({
            type: "POST",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',

            success: function (data)
            {
                if (data.status) {
                    alert(data.msg)
                }



            }
        });
    }

    function checkIfAcadExist()
    {
        var levelCode = $('#selectedLevel').val();
        var user_id = $('#user_id').val();
        var url = "<?php echo base_url() . 'reports/checkIfAcadExist/' ?>" + user_id + '/' + levelCode
        $.ajax({
            type: "POST",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',

            success: function (data)
            {
                if (data.status) {
                    $('#form137School_year').val(data.year)
                    $('#school').val(data.school)
                    $('#spr_id').val(data.spr_id)
                    $('#updateSY').removeClass('hide');
                }



            }
        });
    }


    function getAcadModal(value)
    {
        $('#addRecords').removeClass('hidden')
        $('#addAttendance').removeClass('hidden')
        $('#selectedLevel').val(value);

        var url = "<?php echo base_url() . 'reports/reports_f137/showAcadRecordsModal/' ?>" + $('#st_id').val() + '/' + value;
        $.ajax({
            type: "GET",
            url: url,
            data: 'value=' + value,
            success: function (data)
            {
                $('#acadResults').html(data)

            }
        });


    }

    function getAcad(value, sy)
    {
        $('#addRecords').removeClass('hidden')
        $('#addAttendance').removeClass('hidden')

        var url = "<?php echo base_url() . 'reports/reports_f137/showAcadRecords/' ?>" + $('#st_id').val() + '/' + value + '/' + sy;
        $.ajax({
            type: "GET",
            url: url,
            data: 'value=' + value,
            beforeSend: function () {
                showLoading('acadRecordsBody');
            },
            success: function (data)
            {
                $('#acadRecordsBody').html(data);

//                var url = "<?php echo base_url() . 'reports/getDaysPresent/' ?>";
//                $.ajax({
//                    type: "POST",
//                    url: url,
//                    data:'csrf_test_name='+$.cookie('csrf_cookie_name')+'&spr_id='+$('#getSPR').val(),
//                    success: function(data1)
//                    {
//                        $('#attendRecordsBody').html(data1);
//                        if($('#spr_status').val()==1)
//                            {
//                                $('#acadRecordsLock').removeClass('hide');
//                                $('#acadRecordsUnlock').addClass('hide');
//                            }else{
//                                $('#acadRecordsUnlock').removeClass('hide');
//                                $('#acadRecordsLock').addClass('hide');
//                            }
//                    }
//                })

            }
        });


    }

    function saveEdHistory()
    {

        var elemSchool = $('#elemSchool').val();
        var genAve = $('#genAve').val();
        var school_year = $('#school_year_history').val();
        var yearsCompleted = $('#yearsCompleted').val();
        var curriculum = $('#curriculum').val();
        var st_id = $('#inputStudent').val()

        var url = "<?php echo base_url() . 'reports/saveEdHistory/' ?>" + st_id;
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: 'st_id=' + st_id + '&elemSchool=' + elemSchool + '&genAve=' + genAve + '&school_year=' + school_year + '&yearsCompleted=' + yearsCompleted + '&curriculum=' + curriculum + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data.msg);


            }
        });
    }

    function printForm(st_id)
    {
        var url = "<?php echo base_url() . 'reports/printF137/' ?>" + $('#st_id').val() + '/' + $('#skulYR').val() + '/' + 1;
        window.open(url, '_blank');
    }
</script>

