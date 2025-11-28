<div style="margin: 50px auto 0;" class="modal fade col-lg-5 in" id="attendanceOveride<?php echo $sem; ?>"
    data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="panel panel-info">
        <div class="panel-heading clearfix">
            Overide Attendance
            <button data-dismiss="modal" class="btn btn-danger btn-xs pull-right"><i class="fa fa-close"></i></button>
            <button title="Auto Fetch Attendance" style="margin-right:5px;"
                onclick="autoFetchDaysPresent<?php echo $sem; ?>()" class="btn btn-primary btn-xs pull-right"><i
                    class="fa fa-database "></i></button>
        </div>

        <div class="panel-body" id="attendanceOverideBody<?php echo $sem; ?>">
            <div class="col-lg-12">
                <input type="checkbox" id="is_school<?php echo $sem; ?>" value="1" /> Is School ? <br />
                <input class="form-control hide" style="margin-top:5px;" type="text"
                    id="spr_school_name<?php echo $sem; ?>" name="spr_school_name<?php echo $sem; ?>"
                    placeholder="Name of School" /><br />
            </div>

            <table class="table table-bordered">
                <tr>
                    <th colspan="12" class="text-center alert-danger">Number of School Days
                        <?php echo ($for_school ? '' : 'Present') ?>
                        <small id="confirmMsg" class="muted text-info"></i> </small>
                    </th>
                </tr>
                <tr>
                    <?php
                    for ($i = 6; $i <= 17; $i++):
                        $m = ($i < 10 ? '0' . $i : $i);
                        $monthName = date('M', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                        ?>
                        <td>
                            <?php echo $monthName ?>
                        </td>
                        <?php
                    endfor;
                    ?>
                </tr>
                <tr style="height: 40px;">
                    <?php
                    for ($i = 6; $i <= 17; $i++):
                        $m = ($i < 10 ? '0' . $i : $i);
                        $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                        ?>
                        <td class="overide<?php echo $sem; ?>" id="<?php echo $monthName ?>"></td>
                        <?php
                    endfor;
                    ?>
                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">


    var is_school = 0;
    $(function () {

        $('#is_school<?php echo $sem; ?>').click(function () {
            if ($(this).is(':checked')) {
                $('#spr_school_name<?php echo $sem; ?>').removeClass('hide');
                is_school = 1;
            } else {
                is_school = 0;
            }
        });

        $(".overide<?php echo $sem; ?>").dblclick(function () {
            //var altLockBtnLabel = $('#altLockBtnLabel').val();
            $(this).text('');
            var OriginalContent = $(this).text();
            var month = $(this).attr('id');
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' style='height:30px; text-align:center; width:30px;' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function (e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    var st_id = '<?php echo $st_id ?>';
                    var sy = '<?php echo $school_year ?>';
                    var sem = '<?php echo $sem ?>';
                    var for_school = '<?php echo ($for_school ? '1' : '0') ?>';
                    var school_name = '';
                    if (is_school == 1) {
                        school_name = $('#spr_school_name<?php echo $sem; ?>').val();
                    }

                    var url = '<?php echo base_url() . 'sf10/saveAttendanceOveride/' ?>';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function () {

                            $('#confirmMsg').html('<i class="fa fa-spinner fa-spin">');
                        },
                        data: {
                            value: newContent,
                            st_id: st_id,
                            month: month,
                            school_year: sy,
                            semester: sem,
                            for_school: for_school,
                            is_school: is_school,
                            school_name: school_name,
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        //dataType: 'json',
                        success: function (result) {
                            alert(result);
                        },
                        error: function (result) {
                            //alert('error checking');
                        }
                    });

                    $(this).parent().text(newContent);
                    $(this).parent().removeClass("cellEditing");

                }
            });

            $(this).children().first().blur(function () {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });
    });


    function autoFetchDaysPresent<?php echo $sem; ?>() {
        var st_id = '<?php echo $st_id ?>';
        var sy = '<?php echo $school_year ?>';
        var sem = '<?php echo $sem ?>';
        var for_school = '<?php echo ($for_school ? '1' : '0') ?>';
        var url = "<?php echo base_url() . 'sf10/autoFetchPresent' ?>"
        $.ajax({
            type: "POST",
            url: url,
            //dataType:'json',
            data: {
                st_id: st_id,
                school_year: sy,
                semester: sem,
                for_school: for_school,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            beforeSend: function () {
                showLoading('attendanceOverideBody<?php echo $sem; ?>');
            },
            success: function (data) {
                $('#attendanceOveride<?php echo $sem; ?>').modal('hide');
                alert(data);
                location.reload();
            }
        })

    }
</script>