<div class="well col-lg-12">
    <div id="success"></div>
    <div class="col-lg-2">
        <img class="img-circle img-responsive" style="width:100px; border:5px solid #fff" src="
        <?php
        if ($student->avatar != ""):
            echo base_url() . 'uploads/' . $student->avatar;
        else:
            echo base_url() . 'uploads/noImage.png';
        endif;
        ?>" />
    </div>
    <div class="col-lg-6">
        <h3 style="color:black; margin:3px 0;">
            <span id="name">
                <?php echo $student->firstname . " " . $student->lastname ?>
            </span>
        </h3>
        <h4 style="color:black; margin:3px 0;">
            <span id="grade">
                <?php echo $student->level ?> -
                <?php echo $student->section ?>
            </span>
        </h4>
        <h5 style="color:black; margin:3px 0;">
            <span id="student_id" style="color:#BB0000;">
                <?php echo $student->uid ?>
            </span>
        </h5>

    </div>
    <div class="col-lg-4 pull-right">
        <button style="margin-top:15px; font-size:285%;" onclick="printCard('<?php echo base64_encode($student->uid) ?>', <?php echo $sy ?>, <?php echo $term ?>)" class="btn btn-xl btn-success pull-right"><i class="fa fa-book fa-fw"></i> Generate Card </button>
        <!-- <button style="margin-top:15px; font-size:285%;"
            onclick="$('#cardPreview').modal('show'), previewCard('<?php // echo base64_encode($student->uid) 
                                                                    ?>', <?php // echo $sy 
                                                                            ?>, <?php // echo $term 
                                                                                ?>)"
            class="btn btn-xl btn-success pull-right"><i class="fa fa-book fa-fw"></i> Generate Card </button> -->
    </div>
</div>

<div class="col-lg-12">
    <div class="col-lg-6">
        <?php
        $subjects = Modules::run('customize/getPreSchoolSubj');
        // echo base_url() . 'images/symbols/gs1.png'
        foreach ($subjects as $ps):
            if ($student->grade_id != 15 && $student->grade_id != 1):
                if ($ps->id != 8):
                    $subj_details = Modules::run('customize/getSubjDetails', $ps->id);
        ?>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2" style="text-align: center;"><?php echo $ps->subj_name ?></th>
                        </tr>
                        <tr>
                            <th style="width: 75%;">Activitiesaa</th>
                            <th style="width: 25%;"></th>
                        </tr>
                        <?php
                        foreach ($subj_details as $sd):
                            if ($sd->dpt_id != 2):
                                $rate = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, $term, $sy);

                                switch ($rate->rate):
                                    case 'A':
                                        $url = 'images/symbols/gs1.png';
                                        break;
                                    case 'B':
                                        $url = 'images/symbols/gs2.png';
                                        break;
                                    case 'C':
                                        $url = 'images/symbols/gs3.png';
                                        break;
                                    case 'D':
                                        $url = 'images/symbols/gs4.png';
                                        break;
                                    default:
                                        $url = 'images/symbols/0.png';
                                        break;
                                endswitch;
                        ?>
                                <tr>
                                    <td><?php echo $sd->details ?></td>
                                    <td>
                                        <div class="dropdown" style="width: 30;">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img src="<?php echo base_url() . $url ?>" id="gs-<?php echo $sd->psd_id ?>" alt="icon" class="me-2" style="width: 25px; height: 25px">
                                            </button>

                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton">
                                                <li class="dropdown-item">
                                                    <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs1.png' ?>', '<?php echo $sd->psd_id ?>', 'A')">
                                                        <img src="<?php echo base_url() . 'images/symbols/gs1.png' ?>"
                                                            width="30" height="30">
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs2.png' ?>', '<?php echo $sd->psd_id ?>', 'B')">
                                                        <img src="<?php echo base_url() . 'images/symbols/gs2.png' ?>"
                                                            width="30" height="30">
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs3.png' ?>', '<?php echo $sd->psd_id ?>', 'C')">
                                                        <img src="<?php echo base_url() . 'images/symbols/gs3.png' ?>"
                                                            width="30" height="30">
                                                    </a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs4.png' ?>', '<?php echo $sd->psd_id ?>', 'D')">
                                                        <img src="<?php echo base_url() . 'images/symbols/gs4.png' ?>"
                                                            width="30" height="30">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </table>
                <?php
                endif;
            else:
                $subj_details = Modules::run('customize/getSubjDetails', $ps->id);
                ?>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" style="text-align: center;"><?php echo $ps->subj_name ?></th>
                    </tr>
                    <tr>
                        <th style="width: 75%;">Activities</th>
                        <th style="width: 25%;"></th>
                    </tr>
                    <?php
                    foreach ($subj_details as $sd):
                        if ($sd->dpt_id != 1):
                            $rate = Modules::run('customize/getLLCrate', $student->uid, $sd->psd_id, $term, $sy);

                            switch ($rate->rate):
                                case 'A':
                                    $url = 'images/symbols/gs1.png';
                                    break;
                                case 'B':
                                    $url = 'images/symbols/gs2.png';
                                    break;
                                case 'C':
                                    $url = 'images/symbols/gs3.png';
                                    break;
                                case 'D':
                                    $url = 'images/symbols/gs4.png';
                                    break;
                                default:
                                    $url = 'images/symbols/gs1.png';
                                    break;
                            endswitch;
                    ?>
                            <tr>
                                <td><?php echo $sd->details ?></td>
                                <td>
                                    <div class="dropdown" style="width: 30;">
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?php echo base_url() . $url ?>" id="gs-<?php echo $sd->psd_id ?>" alt="icon" class="me-2" style="width: 25px; height: 25px">
                                        </button>

                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton">
                                            <li class="dropdown-item">
                                                <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs1.png' ?>', '<?php echo $sd->psd_id ?>', 'A')">
                                                    <img src="<?php echo base_url() . 'images/symbols/gs1.png' ?>"
                                                        width="30" height="30">
                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs2.png' ?>', '<?php echo $sd->psd_id ?>', 'B')">
                                                    <img src="<?php echo base_url() . 'images/symbols/gs2.png' ?>"
                                                        width="30" height="30">
                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs3.png' ?>', '<?php echo $sd->psd_id ?>', 'C')">
                                                    <img src="<?php echo base_url() . 'images/symbols/gs3.png' ?>"
                                                        width="30" height="30">
                                                </a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a href="" onclick="event.preventDefault(), updateRating('<?php echo base_url() . 'images/symbols/gs4.png' ?>', '<?php echo $sd->psd_id ?>', 'D')">
                                                    <img src="<?php echo base_url() . 'images/symbols/gs4.png' ?>"
                                                        width="30" height="30">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </table>
        <?php
            endif;
        endforeach;
        ?>
    </div>
    <div class="col-lg-6">
        <?php
        $sprDetails = Modules::run('sf10/getSPRrec', $student->uid, $sy, NULL, $student->grade_id);
        echo Modules::run('sf10/getAttendanceDetails', $sprDetails->spr_id, $sprDetails->school_year, $sprDetails->semester, $student->uid);
        ?>
    </div>
</div>
<div id="special_table" class="hide">
    <?php
    $data['term'] = $term;
    $data['sy'] = $sy;
    $data['student'] = $student;
    $data['strand'] = $student->str_id;
    $this->load->view('manualEntry', $data);
    ?>
</div>
<?php
$this->load->view('reportCardPreview', $data);

echo Modules::run('sf10/attendanceManualOveride', base64_encode($student->st_id), $sy, $sprDetails->semester, FALSE, TRUE, null);
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#searchAssessDate").select2();

        var st_id = '<?php echo base64_encode($student->st_id) ?>';
        var sy = '<?php echo $sy ?>';
        var sem = '<?php echo $sprDetails->semester ?>';
        var for_school = '0';
        //        alert(st_id + ' ' + sy + ' ' + sem + ' ' + for_school);
        var url = "<?php echo base_url() . 'sf10/autoFetchPresent' ?>";
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                st_id: st_id,
                school_year: sy,
                semester: sem,
                for_school: for_school,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            beforeSend: function() {
                showLoading('attendanceOverideBody<?php echo $sem; ?>');
            },
            success: function(data) {

            }
        });
    });

    function deleteINC(id) {
        var url = "<?php echo base_url() . 'reports/deleteINC/' ?>" + id; // the script where you handle the form input.
        $.ajax({
            type: "GET",
            url: url,
            data: "id=" + id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                $('#tr_' + id).hide();
            }
        })
    }

    function saveINC(st_id) {
        var url = "<?php echo base_url() . 'reports/saveINC/' ?>"; // the script where you handle the form input.
        var sub = $('#inc_subject').val();
        var grade = $('#inputGrade').val();
        var option = $('#inc_option').val();
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: "level_id=" + grade + '&subject_id=' + sub + '&option=' + option + '&st_id=' + st_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (option == 0) {
                    var msg = 'Previous Years Completed';
                } else {
                    msg = 'Current School Year';
                }

                var result = '<tr><td>' + data.subject + '</td><td>' + data.level + '</td><td>' + msg + '</td></tr>';
                $('#inc_table').append(result);
            }
        });

        return false;
    }

    function submitRating(st_id, rating, grading, school_year, bh_id) {

        var url = "<?php echo base_url() . 'gradingsystem/saveBH/' ?>" + st_id + '/' + rating + '/' + grading + '/' + school_year + '/' + bh_id;
        //        alert(url);
        $.ajax({
            type: "GET",
            url: url,
            data: 'qcode=' + grading, // serializes the form's elements.
            success: function(data) {


            }
        });
    }

    function saveRemarks(st_id, grading, school_year) {
        //        var remarks = $('#cardRemarks').val();

        var url = "<?php echo base_url() . 'gradingsystem/saveRemarks/' ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: $('#remCard').serialize() + '&st_id=' + st_id + '&grading=' + grading + '&school_year=' + school_year + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            //            data: 'qcode=' + grading, // serializes the form's elements.
            success: function(data) {
                alert('Remarks Save')
            }
        });
    }

    function previewCard(st_id, sy, term) {
        var url = "<?php echo base_url() . 'reports/cardReview/' ?>" + st_id + '/' + sy + '/' + term;
        $.ajax({
            type: "GET",
            url: url,
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function(data) {
                if (term == 4) {
                    $('#admittedToWrapper').show()
                }
                $('#cardPreviewData').html(data);
            }
        });

        return false;
    }

    function printCard(st_id, sy, term, strnd) {
        var d = new Date();
        var strDate = d.getFullYear() + "-" + (((d.getMonth() + 1) < 10 ? "0" + (d.getMonth() + 1) : d.getMonth() + 1)) + "-" + d.getDate();
        var admittedDate = $('#dateAdmitted').val() == "" ? strDate : $('#dateAdmitted').val();
        var admittedTo = (term == 4 ? $('#admittedTo').val() : '');
        var dateAdmitted = (term == 4 ? admittedDate : 'NULL');
        //        if (term == 4 && admittedTo == '') {
        //            alert('Admitted To cannot be blank');
        //        } else {
        var url = "<?php echo base_url() . 'reports/printReportCard/' ?>" + st_id + '/' + sy + '/' + dateAdmitted + '/' + term + '/' + strnd + '/' + admittedTo;
        window.open(url, '_blank');
        //        }
    }

    function lockFinalCard(st_id, sy) {
        var lockController = $('#cardLockController').val()

        var answer = confirm("Do you really want to Lock the Final Rating? Doing so will prevent you from future Changes.");
        if (answer == true) {
            var url = "<?php echo base_url() . 'gradingsystem/lockFinalCard/' ?>" + st_id + '/' + sy;
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                data: 'qcode=' + sy, // serializes the form's elements.
                success: function(data) {
                    if (data.status) {
                        if (lockController == 0) {
                            $('#final_lock').removeClass('fa-unlock');
                            $('#final_lock').addClass('fa-lock')
                            $('#cardLockController').val(1)
                        } else {
                            $('#final_lock').removeClass('fa-lock');
                            $('#final_lock').addClass('fa-unlock')
                            $('#cardLockController').val(0)
                        }
                    } else {
                        alert('Unable to Finalize Card')
                    }
                }
            });
        }


    }

    function getBHrate(id) {
        var sy = '<?php echo $sy ?>';
        var term = '<?php echo $term ?>';
        var st_id = '<?php echo $student->st_id ?>';
        var school_name = '<?php echo $short_name ?>';
        var dept_id = '<?php echo ($student->grade_id >= 2 && $student->grade_id <= 13 ? 12 : 1) ?>';
        var url = '<?php echo base_url() . 'customize/getBHrate' ?>';

        $.ajax({
            type: 'POST',
            data: 'id=' + id + '&short_name=' + school_name + '&stid=' + st_id + '&term=' + term + '&sy=' + sy + '&dept_id=' + dept_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            url: url,
            success: function(data) {
                $('#cv').html(data);
            }
        });
    }

    $(function() {
        $(".llc").dblclick(function() {
            //var altLockBtnLabel = $('#altLockBtnLabel').val();
            $(this).text('');
            var OriginalContent = $(this).text();
            var details = $(this).attr('id');
            $(this).addClass("cellEditing");
            $(this).html("<input type='text' style='height:30px; text-align:center; width:70%;' value='" + OriginalContent + "' />");
            $(this).children().first().focus();
            $(this).children().first().keypress(function(e) {
                if (e.which == 13) {
                    var newContent = $(this).val();
                    var value = newContent.toUpperCase();
                    var st_id = '<?php echo $student->st_id ?>';
                    var sy = '<?php echo $sy ?>';
                    var url = '<?php echo base_url() . 'customize/updateLLCrate/' ?>';

                    if (value != 'A' && value != 'B' && value != 'D' && value != 'P' && value != 'AP') {
                        alert('You entered an invalid rate');
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: url,
                            beforeSend: function() {

                                $('#confirmMsg').html('<i class="fa fa-spinner fa-spin">');
                            },
                            data: {
                                value: value,
                                st_id: st_id,
                                details: details,
                                school_year: sy,
                                csrf_test_name: $.cookie('csrf_cookie_name')
                            },
                            //dataType: 'json',
                            success: function(result) {
                                $('#attMsg').show().delay(5000).queue(function(n) {
                                    $(this).hide();
                                    n();
                                });
                                $('#attMsg').text('Alert: ' + result);
                            },
                            error: function(result) {
                                //alert('error checking');
                            }
                        });

                        $(this).parent().text(newContent);
                        $(this).parent().removeClass("cellEditing");
                    }

                }
            });

            $(this).children().first().blur(function() {
                $(this).parent().text(OriginalContent);
                $(this).parent().removeClass("cellEditing");
            });
        });
    });

    function updateRating(link, id, value) {
        $('#gs-' + id).attr('src', link);
        var stid = '<?php echo $student->uid ?>';
        var term = '<?php echo $term ?>';
        var sy = '<?php echo $sy ?>';
        var url = '<?php echo base_url('customize/updateLLCrate') ?>';

        $.ajax({
            type: 'POST',
            url: url,
            data: 'value=' + value + '&st_id=' + stid + '&school_year=' + sy + '&sdid=' + id + '&term=' + term + '&csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                // alert('Success');
            }
        })
    }
</script>