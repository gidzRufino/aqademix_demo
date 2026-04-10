<div class="col-lg-12 no-padding" style="margin-bottom: 10px;">
    <div class="alert alert-success" style="margin-bottom: 0; padding: 3px;">
        <h4 class="text-center">Attendance Record
            <a href="#" onclick="$('#attendanceOveride<?php echo $semester ?>').modal('show')" id="addAttendance2">
                <i style="font-size: 25px;" class="pull-right fa fa-clock-o pointer"></i>
            </a>  
        </h4>
    </div>
    <div id="attendRecordsBody">
        <table class="table table-bordered">
            <tr>
                <th colspan="12" class="text-center alert-danger">Number of School Days <?php echo ($for_school ? '' : 'Present') ?>
                    <small id="confirmMsg" class="muted text-info"></i> </small></th>
            </tr>
            <tr>
                <?php
                for ($i = 6; $i <= 10; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                endfor;

                for ($i = 11; $i <= 15; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                endfor;
                ?>
            </tr>
            <tr>
                <?php
                for ($i = 6; $i <= 10; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo ($attendanceDetails ? $attendanceDetails->row()->$monthName : 0) ?></td>
                    <?php
                endfor;

                for ($i = 11; $i <= 15; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo ($attendanceDetails ? $attendanceDetails->row()->$monthName : 0) ?></td>
                    <?php
                endfor;
                ?>
            </tr>
        </table>    
    </div>
    <div id="attendRecordsTardy">
        <table class="table table-bordered">
            <tr>
                <th colspan="12" class="text-center alert-danger">Number of Times Tardy
                    <small id="confirmMsg" class="muted text-info"></i> </small></th>
            </tr>
            <tr>
                <?php
                for ($i = 6; $i <= 10; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                endfor;

                for ($i = 11; $i <= 15; $i++):
                    $m = ($i < 10 ? '0' . $i : $i);
                    $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                    ?>
                    <td class="text-center"><?php echo $monthName ?></td>
                    <?php
                endfor;
                ?>
            </tr>
            <?php
            for ($i = 6; $i <= 10; $i++):
                $m = ($i < 10 ? '0' . $i : $i);
                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                ?>
                <td class="text-center overideTardy" id="<?php echo $monthName ?>"><?php echo ($attendaceTardy ? $attendaceTardy->$monthName : 0) ?></td>
                <?php
            endfor;

            for ($i = 11; $i <= 15; $i++):
                $m = ($i < 10 ? '0' . $i : $i);
                $monthName = date('F', strtotime(date('Y-' . ($m > 12 ? (($m - 12) < 10 ? '0' . ($m - 12) : ($m - 12)) : $m) . '-01')));
                ?>
                <td class="text-center overideTardy" id="<?php echo $monthName ?>"><?php echo ($attendaceTardy ? $attendaceTardy->$monthName : 0) ?></td>
                <?php
            endfor;
            ?>
        </table>
        <span id="attMsg" hidden=""></span>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $(".overideTardy").dblclick(function ()
        {
            //var altLockBtnLabel = $('#altLockBtnLabel').val();
            $(this).text('');
            var OriginalContent = $(this).text();
            var month = $(this).attr('id');
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' style='height:30px; text-align:center; width:30px;' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function (e)
            {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    var sprid = '<?php echo $attendaceTardy->spr_id ?>';
                    var st_id = '<?php echo $st_id ?>';
                    var sy = '<?php echo $school_year ?>';
                    var sem = '<?php echo $sem ?>';

                    var url = '<?php echo base_url() . 'sf10/saveTardy/' ?>';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        beforeSend: function () {

                            $('#confirmMsg').html('<i class="fa fa-spinner fa-spin">');
                        },
                        data: {
                            value: newContent,
                            spr_id: sprid,
                            st_id: st_id,
                            month: month,
                            school_year: sy,
                            semester: sem,
                            csrf_test_name: $.cookie('csrf_cookie_name')
                        },
                        //dataType: 'json',
                        success: function (result) {
                            $('#attMsg').show().delay(5000).queue(function (n) {
                                $(this).hide();
                                n();
                            });
                            $('#attMsg').text('Alert: ' + result);
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
    })
</script>