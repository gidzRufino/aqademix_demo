<?php
// this will show or hide the buttons
switch ($grade_id):
    case 12:
        $grade12 = '';
        $grade13 = 'hide';
        $sy1 = $sy;
        $sy2 = '';
        break;
    case 13:
        $grade11 = '';
        $grade12 = '';
        $sy1 = $sy - 1;
        $sy2 = $sy;
        break;
endswitch;
?> 
<!--Academic Records-->
<div class="btn-group btn-group-justified col-lg-12" data-toggle="buttons">

    <label class="btn btn-primary <?php echo $grade12 ?>" onclick="getAcad($('#g11').val(), '<?php echo $sy1 ?>'), $('#gradeLevel').html('Grade 11')">
        <input type="radio" name="options" id="g11"  value="12"> Grade 11
    </label>
    <label class="btn btn-primary <?php echo $grade13 ?>" onclick="getAcad($('#g12').val(), '<?php echo $sy2 ?>'), $('#gradeLevel').html('Grade 12')">
        <input type="radio" name="options" id="g12"  value="13" > Grade 12
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
    
    $(document).ready(function () {

        $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
               if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
                   $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
               }
           });
           
        $('#inputSubjectSH').select2();
       });
       
    
    function clearData()
    {
        $('#firstSH').val('');
        $('#secondSH').val('');
        $('#thirdSH').val('');
        $('#fourthSH').val('');
        $('#averageSH').val('');
    }   
    
    function editAcademicRecordsSH()
    {
        
        var url = "<?php echo base_url() . 'sf10/editAcademicRecordsSH/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : $('#school_yearSH').val(),
                ar_id           : $('#editARid').val(),
                first           : $('#editFirst').val(),
                second          : $('#editSecond').val(),
                average         : $('#editAverage').val(),
                semester        : $('#editSem').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (data)
            {
                $('#editGrades').modal('hide');
                getAcadModal($('#grade_level_id').val(), $('#school_yearSH').val());
                
            }
        });
    }
    
    function saveAcademicRecordsSH()
    {
        
        var url = "<?php echo base_url() . 'sf10/saveAcademicRecords/' ?>" + $('#st_id').val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : $('#school_yearSH').val(),
                school          : $('#acad_school').val(),
                semester        : $('#acadSemester').val(),
                first           : $('#firstSH').val(),
                second          : $('#secondSH').val(),
                third           : $('#thirdSH').val(),
                fourth          : $('#fourthSH').val(),
                average         : $('#averageSH').val(),
                generalAverage  : $('#generalAverage').val(),
                subject_id      : $('#inputSubjectSH').val(),
                grade_id        : $('#grade_level_id').val(),
                spr_id          : $('#acadSPRId').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            },
            success: function (data)
            {
                $('#acadResultsSH').html(data);
                
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
    
    function printForm(sy, strand)
    {
        if (strand == 0) {
            alert('Please Set Strand First');
        } else {
            var url = "<?php echo base_url() . 'sf10/printF137/' ?>" + $('#st_id').val() + '/' + sy + '/' + 3 + '/' + strand;
            window.open(url, '_blank');
        }
    }
</script>

