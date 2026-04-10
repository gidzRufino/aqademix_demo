<?php
switch ($grade_id):
    case 8:
        $grade7 = '';
        $grade8 = 'hide';
        $grade9 = 'hide';
        $grade10 = 'hide';
        $sy1 = $sy;
        $sy2 = '';
        $sy3 = '';
        $sy4 = '';
        break;
    case 9:
        $grade7 = '';
        $grade8 = '';
        $grade9 = 'hide';
        $grade10 = 'hide';
        $sy1 = $sy - 1;
        $sy2 = $sy;
        $sy3 = '';
        $sy4 = '';
        break;
    case 10:
        $grade7 = '';
        $grade8 = '';
        $grade9 = '';
        $grade10 = 'hide';
        $sy1 = $sy - 2;
        $sy2 = $sy - 1;
        $sy3 = $sy;
        $sy4 = '';
        break;
    case 11:
        $grade7 = '';
        $grade8 = '';
        $grade9 = '';
        $grade10 = '';
        $sy1 = $sy - 3;
        $sy2 = $sy - 2;
        $sy3 = $sy - 1;
        $sy4 = $sy;
        break;
    default:
        $grade7 = '';
        $grade8 = '';
        $grade9 = '';
        $grade10 = '';
        if($grade_id >= 12):
            $sy = $sy - ($grade_id - 12);
        endif;
        $sy1 = $sy - 4;
        $sy2 = $sy - 3;
        $sy3 = $sy - 2;
        $sy4 = $sy - 1;
        break;
endswitch;
?> 
<!--Academic Records-->
<div class="btn-group btn-group-justified col-lg-12" data-toggle="buttons">

    <label class="btn btn-primary <?php echo $grade7 ?>" onclick="getAcad($('#g7').val(), '<?php echo $sy1 ?>'), $('#gradeLevel').html('Grade 7')" title="<?php echo $sy1 ?>">
        <input type="radio" name="options" id="g7"  value="8"> Grade 7
    </label>
    <label class="btn btn-primary <?php echo $grade8 ?>" onclick="getAcad($('#g8').val(), '<?php echo $sy2 ?>'), $('#gradeLevel').html('Grade 8')" title="<?php echo $sy2 ?>">
        <input type="radio" name="options" id="g8"  value="9" > Grade 8
    </label>
    <label class="btn btn-primary <?php echo $grade9 ?>" onclick="getAcad($('#g9').val(), '<?php echo $sy3 ?>'), $('#gradeLevel').html('Grade 9')" title="<?php echo $sy3 ?>">
        <input type="radio" name="options"  id="g9" value="10"> Grade 9 
    </label>
    <label class="btn btn-primary <?php echo $grade10 ?>" onclick="getAcad($('#g10').val(), '<?php echo $sy4 ?>'), $('#gradeLevel').html('Grade 10')" title="<?php echo $sy4 ?>">
        <input type="radio" name="options"  id="g10" value="11"> Grade 10
    </label>
</div>
<div class=" col-lg-12">
    <div class="alert alert-success clearfix" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Academic Records

            <i id="acadRecordsUnlock" class="fa fa-unlock-alt pull-right hide pointer fa-fw" onclick="lockUnlock('acadRecords', 'Lock')"></i>
            <i id="acadRecordsLock" class="fa fa-lock pull-right pointer hide fa-fw" onclick="lockUnlock('acadRecords', 'Unlock')"></i>
            <i id="acadRecordsMin" class="fa fa-minus pull-right pointer fa-fw" onclick="maxMin('acadRecords', 'min')"></i>
            <i id="acadRecordsMax" class="fa fa-plus pull-right pointer hide fa-fw" onclick="maxMin('acadRecords', 'max')"></i>
        </h4>

    </div>
    <div id="acadRecordsBody">

    </div>
</div>

<input type="hidden" id="selectedLevel" />
<script type="text/javascript">

    function clearDataJS()
    {
        $('#first').val('');
        $('#second').val('');
        $('#third').val('');
        $('#fourth').val('');
        $('#average').val('');
    }   
    
    
    function saveAcademicRecords()
    {
        var url = "<?php echo base_url() . 'sf10/saveAcademicRecords/' ?>" + $('#st_id').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : $('#school_year').val(),
                school          : $('#acad_school').val(),
                semester        : $('#acadSemester').val(),
                first           : $('#first').val(),
                second          : $('#second').val(),
                third           : $('#third').val(),
                fourth          : $('#fourth').val(),
                average         : $('#average').val(),
                generalAverage  : $('#generalAverage').val(),
                subject_id      : $('#inputSubject').val(),
                grade_id        : $('#grade_level_id').val(),
                spr_id          : $('#acadSPRId').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (data)
            {
                $('#acadResults').html(data);
            }
        });
    }


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
                    $('#form137School_year').val(data.year)
                    $('#school').val(data.school)
                    $('#spr_id').val(data.spr_id)
                    $('#updateSY').removeClass('hide');
                }



            }
        });
    }
    function getAcadModal(value, sy)
    {
        $('#selectedLevel').val(value);

        var url = "<?php echo base_url() . 'sf10/checkRecords/' ?>" + $('#st_id').val() + '/'+ sy +'/' + value;
        $.ajax({
            type: "GET",
            url: url,
            data: 'value=' + value,
            success: function (data)
            {
                $('#recordsTbl').html(data);

            }
        });


    }

    function getAcad(value, sy)
    {
        $('#sySelected').val(sy);
        $('#addRecords').removeClass('hidden')
        $('#addAttendance').removeClass('hidden')
        $('#selectedLevel').val(value);

        var url = "<?php echo base_url() . 'sf10/showAcadRecords/' ?>" + $('#st_id').val() + '/' + value + '/' + sy;
//        alert(url);
        $.ajax({
            type: "GET",
            url: url,
            data: 'value=' + value,
            beforeSend: function () {
                showLoading('acadRecordsBody');
            },
            success: function (data)
            {
                $('#acadRecordsBody').html(data)
                getAcadModal(value, sy);

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
        var url = "<?php echo base_url() . 'sf10/printF137/' ?>" + $('#st_id').val() + '/' + <?php echo segment_5 ?> + '/' + 2;
        window.open(url, '_blank');
    }
</script>

