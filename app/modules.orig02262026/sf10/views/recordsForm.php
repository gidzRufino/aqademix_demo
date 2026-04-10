
<!--End of Education History-->
<?php
// this will show or hide the buttons
if ($student->grade_level_id <= 7):
    $gs = '';
    $jhs = 'hide';
    $shs = 'hide';
elseif ($student->grade_level_id >= 7 && $student->grade_level_id < 12):
    $gs = '';
    $jhs = '';
    $shs = 'hide';
else:
    $gs = '';
    $jhs = '';
    $shs = '';
endif;
?> 
<!--Academic Records-->
<div class="col-lg-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="clearfix">
                <span style="font-size:15px;" class="col-lg-11 text-center"><i class="fa fa-book fa-fx"></i> List of Records</span>
                <i id="academicRecordsMin" class="fa fa-minus fa-2x pull-right pointer fa-fw" onclick="maxMin('academicRecords', 'min')"></i>
                <i id="academicRecordsMax" class="fa fa-plus fa-2x pull-right pointer hide fa-fw" onclick="maxMin('academicRecords', 'max')"></i>
                <div class="btn-group btn-group-justified col-lg-12" data-toggle="buttons">
                    <label class="btn btn-primary <?php echo $gs ?>" onclick="displayDept(1)">
                        <input type="radio" name="options" id="g7"  value="8"> Elementary Records
                    </label>
                    <label class="btn btn-primary <?php echo $jhs ?>" onclick="displayDept(2)">
                        <input type="radio" name="options" id="g8"  value="9" > Junior High School Records
                    </label>
                    <label class="btn btn-primary <?php echo $shs ?>" onclick="displayDept(3)">
                        <input type="radio" name="options"  id="g9" value="10"> Senior High School Records 
                    </label>
                </div>
                <div style="margin-top: 10px;" class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            EDUCATION HISTORY
                            <i class="fa fa-plus fa-2x pull-right pointer" onclick="$('#educBody').html($('#educForm').html())"></i>
                            <i class="fa fa-save fa-2x pull-right pointer" onclick="saveEdHistory()"></i>
                        </div>
                        <div class="panel-body" id="educBody">
                            <div class="col-lg-12" id="educHisDetails">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>School</th>
                                        <th>Level</th>
                                        <th>School Year</th>
                                        <th>General Average</th>
                                    </tr>
                                    
                                <?php 
                                foreach ($edHistory as $eh): 
                                        switch ($eh->history_type):
                                            case 1:
                                                $level = 'Kindergarten';
                                                
                                            break;
                                            case 2:
                                                $level = 'Intermediate';
                                            break;
                                            case 3:
                                                $level = 'Junior High';
                                            break;    
                                        endswitch;
                                        
                                        $years = $eh->school_year - $eh->total_years;
                                ?>
                                    <tr>
                                        <td><?php echo strtoupper($eh->name_of_school) ?></td>
                                        <td><?php echo strtoupper($level) ?></td>
                                        <td class="text-center"><?php echo $years.' - '.$eh->school_year ?></td>
                                        <td class="text-center"><?php echo ($eh->gen_ave!=0?$eh->gen_ave:'') ?></td>
                                    </tr>
                                <?php endforeach; ?>    
                                </table>
                            </div>
                            <div class="form-group" id="educForm" style="display:none;">
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
                                <div class="col-lg-4">
                                    <label>Record Type </label> <br />
                                    <select style="width: 100%;"  name="recordType" id="recordType" required>
                                        <option>Please Select</option> 
                                        <option value="1">Kindergarten</option>  
                                        <option value="2">Elementary School</option>  
                                        <option value="3">Junior High School</option>  
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="formRecords" class="panel-body">

        </div>
        <input type="hidden" id="selectedLevel" />
    </div>
</div>


<script type="text/javascript">
    
    function deleteRecord()
    { 
        var ar_id = $('#inputDeleteARID').val();
        var sy    = $('#inputDeleteYear').val();
        var url = '<?php echo base_url() . 'sf10/deleteRecord/'?>'+ar_id + '/'+sy;
        $.ajax({
            type: 'GET',
            data: 'id=' + ar_id,
            url: url,
            success: function (data) {
                alert(data)
                location.reload();
            },
            error: function (data) {
                alert('error');
            }
        });
        
    }

    function displayDept(value) {
        var sy = '<?php echo $sy ?>';
        var grade_id = '<?php echo $student->grade_level_id; ?>';
        var url = '<?php echo base_url() . 'sf10/displayDept/'.base64_encode($student->st_id) ?>/' + value + '/' + grade_id + '/' + sy;
        $.ajax({
            type: 'GET',
            data: 'id=' + value,
            url: url,
            success: function (data) {
                $('#formRecords').html(data);
            },
            error: function (data) {
                alert('error');
            }
        });
    }
    function maxMin(body, action)
    {
        if (action == "max") {
            $('#' + body + 'Min').removeClass('hide');
            $('#' + body + 'Max').addClass('hide')
            $('#' + body + 'Body').removeClass('hide fade');
        }else{
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
        var url = "<?php echo base_url() . 'sf10/lock_unlock_SPR/' ?>"
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
        var url = "<?php echo base_url() . 'sf10/checkSubject/' ?>" + subject_id + '/' + spr_id
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
        var user_id = $('#st_id').val();
        var url = '<?php echo base_url() . 'sf10/checkIfAcadExist/' ?>' + user_id + '/' + levelCode;
        $.ajax({
            type: "POST",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            dataType: 'json',

            success: function (data)
            {
                if (data.status) {
                    $('#form137School_year').val(data.year);
                    $('#school').val(data.school);
                    $('#spr_id').val(data.spr_id);
                    $('#updateSY').removeClass('hide');
                }
            }
        });
    }


    function getAcadModal(value)
    {
        $('#addRecords').removeClass('hidden');
        $('#addAttendance').removeClass('hidden');
        $('#selectedLevel').val(value);

        var url = "<?php echo base_url() . 'sf10/showAcadRecordsModal/' ?>" + $('#user_id').val() + '/' + value;
        $.ajax({
            type: "GET",
            url: url,
            data: 'value=' + value,
            success: function (data)
            {
                $('#acadResults').html(data);
            }
        });


    }

    function getAcad(value, sy)
    {
        $('#addRecords').removeClass('hidden');
        $('#addAttendance').removeClass('hidden');
        $('#selectedLevel').val(value);

        var url = "<?php echo base_url() . 'sf10/showAcadRecords/' ?>" + $('#st_id').val() + '/' + value + '/' + sy;
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

        var url = "<?php echo base_url() . 'sf10/saveEdHistory/' ?>" + st_id;
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

    function printForm(sy)
    {
        var url = "<?php echo base_url() . 'sf10/printF137/' ?>" + $('#st_id').val() + '/' + <?php echo segment_6 ?> + '/' + 2;
        window.open(url, '_blank');
    }
    
    function saveEdHistory()
    {

        var elemSchool = $('#elemSchool').val();
        var genAve = $('#genAve').val();
        var school_year = $('#school_year_history').val();
        var yearsCompleted = $('#yearsCompleted').val();
        var curriculum = $('#curriculum').val();
        var recordType = $('#recordType').val();
        var st_id = $('#st_id').val();

        var url = "<?php echo base_url() . 'sf10/saveEdHistory/' ?>" + st_id;
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: 'st_id=' + st_id + '&recordType=' + recordType+ '&elemSchool=' + elemSchool + '&genAve=' + genAve + '&school_year=' + school_year + '&yearsCompleted=' + yearsCompleted + '&curriculum=' + curriculum + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                alert(data.msg);


            }
        });
    }
</script>

