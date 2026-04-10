<div class="well col-lg-12">
    <div id="success"></div>
    <div class="col-lg-2">
        <img class="img-circle img-responsive" style="width:100px; border:5px solid #fff" src="<?php
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
        <button style="margin-top:15px; font-size:285%;"
            onclick="$('#cardPreview').modal('show'), previewCard('<?php echo base64_encode($student->uid) ?>', <?php echo $sy ?>, <?php echo $term ?>)"
            class="btn btn-xl btn-success pull-right"><i class="fa fa-book fa-fw"></i> Generate Card </button>
    </div>
</div>

<div class="col-lg-12">
    <div class="col-lg-6">
        <input type="hidden" id="term" value="<?php echo $term ?>" />
        <input type="hidden" id="sy" value="<?php echo $sy ?>" />
        <?php
        //            $rem = Modules::run('main/getAdmissionRemarks', $student->uid, "");
        //            if($rem->num_rows >0):
        //                if($rem->row()->code_indicator_id == 2):
        //                    
        ?>
        <i title="Use this Option with Precaution" onclick="$('#finalGradeData').html($('#special_table').html())"
            class="fa fa-pencil pointer pull-right"></i>
        <?php
        //                endif;
        //            endif;
        ?>
        <?php
        if ($term == 4):
            $lock = Modules::run('gradingsystem/checkIfCardLock', $student->uid, $sy);
            if ($lock):
                $lock = 'fa-lock';
            else:
                $lock = 'fa-unlock';
            endif;
        endif;
        ?>
        <input type="hidden" id="cardLockController" value="0" />
        <h5 class="clearfix"><span class="pull-left">Final Grade </span>
            <?php if ($term == 4): ?><i onclick="lockFinalCard('<?php echo $student->uid ?>',<?php echo $sy ?>)"
                    id="final_lock" style="font-size:200%;"
                    class="fa <?php echo $lock ?> fa-fw pull-right pointer text-danger"></i>
            <?php endif; ?>
        </h5>


        <hr />
        <div id="finalGradeData">
            <table class="table table-striped">
                <tr>
                    <td>
                        Subjects
                    </td>
                    <td>
                        Final Grade
                    </td>
                </tr>
                <?php
                $subject = Modules::run('academic/getSpecificSubjectPerlevel', $student->grade_id);
                $gs_settings = Modules::run('gradingsystem/getSet', $sy);
                //$subject = explode(',', $subject_ids->subject_id);
                //print_r($gs_settings);
                $i = 0;
                foreach ($subject as $s) {
                    $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
                    $finalGrade = Modules::run('gradingsystem/getFinalGrade', $student->uid, $s->sub_id, $term, $sy);
                    //if($singleSub->parent_subject==0):      
                ?>
                    <tr>
                        <td>
                            <?php echo $singleSub->subject; ?>
                        </td>
                        <?php
                        if ($gs_settings->gs_used == 1):
                        ?>
                            <td style="text-align: center;">
                                <?php
                                if ($finalGrade->num_rows() > 0):
                                    echo '<strong>' . $finalGrade->row()->final_rating . '</strong>';
                                else:
                                    $i++;
                                    if ($sy < $this->session->userdata('school_year')):
                                        $assessment = Modules::run('gradingsystem/getPartialAssessment', $student->uid, $student->section_id, $s->sub_id, $sy);
                                        switch ($term) {
                                            case 1:
                                                $grading = 'first';
                                                break;
                                            case 2:
                                                $grading = 'second';
                                                break;
                                            case 3:
                                                $grading = 'third';
                                                break;
                                            case 4:
                                                $grading = 'fourth';
                                                break;
                                        }
                                        //echo $term;
                                        Modules::run('gradingsystem/updateFinalGrade', $student->uid, $s->sub_id, $assessment->$grading, $term, $sy);
                                        echo $assessment->$grading;
                                    else:
                                        echo 'no Final Grade Yet';
                                    endif;
                                endif;
                                ?>

                            </td>
                        <?php
                        else: // gs_used
                        ?>

                            <td style="text-align: center;">
                                <?php
                                if ($finalGrade->num_rows() > 0):
                                    if ($finalGrade->row()->is_manual):
                                        echo '<strong>' . $finalGrade->row()->final_rating . '</strong>';
                                    else:
                                        echo '<strong>' . $finalGrade->row()->final_rating . '</strong>';
                                    endif;
                                else:
                                    $i++;
                                    if ($term <= $this->session->userdata('term')):
                                        $assessment = Modules::run('gradingsystem/getPartialAssessment', $student->uid, $student->section_id, $s->sub_id, $sy);
                                        switch ($term) {
                                            case 1:
                                                $grading = 'first';
                                                break;
                                            case 2:
                                                $grading = 'second';
                                                break;
                                            case 3:
                                                $grading = 'third';
                                                break;
                                            case 4:
                                                $grading = 'fourth';
                                                break;
                                        }
                                        if ($assessment->is_validated > $term):
                                            Modules::run('gradingsystem/updateFinalGrade', $student->uid, $s->sub_id, $assessment->$grading, $term, $sy);
                                        // $assessment->$term;
                                        else:
                                            echo 'no Final Grade Yet';

                                        endif;
                                    // Modules::run('gradingsystem/updateFinalGrade', $student->uid, $s->sub_id, $assessment->$grading, $term, $sy );

                                    else:
                                        echo 'no Final Grade Yet';
                                    endif;
                                endif;
                                ?>

                            </td>
                        <?php
                        endif;
                        ?>
                    </tr>
                <?php
                    //endif;
                }
                ?>
            </table>
        </div>
        <input type="hidden" id="no_subject" value="<?php echo $i ?>" />
        <?php
        // if($gs_settings->gs_used==1):
        $remarks = Modules::run('gradingsystem/getCardRemarks', $student->uid, $term, $sy);
        ?>
        <br /><br /><br />
        <h5 class="pull-left">Remarks for the Card</h5>
        <button onclick="saveRemarks('<?php echo $student->uid ?>',<?php echo $term ?>,<?php echo $sy ?>)"
            class="pull-right btn btn-small btn-success"> Save Remarks</button>
        <br />
        <hr />
        <form id="remCard" role="form">
            <textarea id="cardRemarks" name="cardRemarks" style="width:100%;" rows="5">
                <?php
                if ($remarks->num_rows() > 0):
                    echo $remarks->row()->remarks;
                else:
                    echo '';
                endif;
                ?>
            </textarea>
        </form>
        <?php
        if ($term == 4):
            $data['grade_id'] = $student->grade_id;
            $data['st_id'] = $student->uid;
            $data['grade_level'] = Modules::run('registrar/getGradeLevel');
            $this->load->view('incomplete_subjects', $data);
        endif;

        //      endif;
        ?>
    </div>
    <div class="col-lg-6">
        <?php
        $sprDetails = Modules::run('sf10/getSPRrec', $student->uid, $sy, NULL, $student->grade_id);
        echo Modules::run('sf10/getAttendanceDetails', $sprDetails->spr_id, $sprDetails->school_year, $sprDetails->semester, $student->uid);
        ?>
    </div>
    <div class="col-lg-6">
        <h5>Learner's Observed Values
            <!-- <select class="pull-right">
                <option value="0" selected="">Select Core Values</option>
                <?php // foreach ($core_val as $cv): 
                ?>
                    <option value="<?php // echo $cv->core_id 
                                    ?>" onclick="getBHrate(this.value)">
                        <?php // echo $cv->core_values 
                        ?>
                    </option>
                <?php // endforeach; 
                ?>
            </select> -->
        </h5>
        <hr />
        <?php
        $bhrate = Modules::run('reports/getBhGroup', 2, NULL, NULL);
        ?>
        <table class="table table-bordered" id="cv">
            <tr>
                <th>Core Values</th>
                <th>Details</th>
                <th>Rating</th>
            </tr>
            <?php
            $td = 1;
            $bg = 0;
            foreach ($bhrate as $b):
                $rate = Modules::run('gradingsystem/getBHRating', $student->uid, $term, $sy, $b->bh_id);
                switch ($b->bh_group):
                    case 1:
                        $core = 'MAKA DIYOS';
                        $rs = 1;
                        break;
                    case 2:
                        $core = 'MAKA TAO';
                        $rs = 1;
                        break;
                    case 3:
                        $core = 'MAKA KALIKASAN';
                        $rs = 1;
                        break;
                    case 4:
                        $core = 'MAKA BANSA';
                        $rs = 2;
                        break;
                endswitch;

                if ($rs == 2):
                    if ($td == 1):
            ?>
                        <tr>
                            <td rowspan="2" style="vertical-align: middle; text-align:center"><?php echo $core ?></td>
                            <td><?php echo $b->bh_name ?></td>
                            <td>
                                <select id="bhid-<?php echo $b->bh_id ?>" onclick="submitRating('<?php echo $student->uid ?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $b->bh_id ?>)"
                                    tabindex="-1" style="width:200px" class="span2">
                                    <option>Select Rating</option>
                                    <option <?php echo ($rate->row()->rate == 4 ? 'selected' : '') ?> value="4">Always Observed</option>
                                    <option <?php echo ($rate->row()->rate == 3 ? 'selected' : '') ?> value="3">Sometimes Observed</option>
                                    <option <?php echo ($rate->row()->rate == 2 ? 'selected' : '') ?> value="2">Rarely Observed</option>
                                    <option <?php echo ($rate->row()->rate == 1 ? 'selected' : '') ?> value="1">Not Observed</option>
                                </select>
                            </td>
                        </tr>
                    <?php
                        $td--;
                    else:
                    ?>
                        <tr>
                            <td><?php echo $b->bh_name ?></td>
                            <td>
                                <select id="bhid-<?php echo $b->bh_id ?>" onclick="submitRating('<?php echo $student->uid ?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $b->bh_id ?>)"
                                    tabindex="-1" style="width:200px" class="span2">
                                    <option>Select Rating</option>
                                    <option <?php echo ($rate->row()->rate == 4 ? 'selected' : '') ?> value="4">Always Observed</option>
                                    <option <?php echo ($rate->row()->rate == 3 ? 'selected' : '') ?> value="3">Sometimes Observed</option>
                                    <option <?php echo ($rate->row()->rate == 2 ? 'selected' : '') ?> value="2">Rarely Observed</option>
                                    <option <?php echo ($rate->row()->rate == 1 ? 'selected' : '') ?> value="1">Not Observed</option>
                                </select>
                            </td>
                        </tr>
                    <?php
                    endif;
                    $bg++;
                    if ($bg == 2):
                        $td = 1;
                        $bg = 0;
                    endif;
                else:
                    ?>
                    <tr>
                        <td style="vertical-align: middle; text-align:center"><?php echo $core ?></td>
                        <td><?php echo $b->bh_name ?></td>
                        <td>
                            <select id="bhid-<?php echo $b->bh_id ?>" onclick="submitRating('<?php echo $student->uid ?>', this.value, <?php echo $term ?>,<?php echo $sy ?>, <?php echo $b->bh_id ?>)"
                                tabindex="-1" style="width:200px" class="span2">
                                <option>Select Rating</option>
                                <option <?php echo ($rate->row()->rate == 4 ? 'selected' : '') ?> value="4">Always Observed</option>
                                <option <?php echo ($rate->row()->rate == 3 ? 'selected' : '') ?> value="3">Sometimes Observed</option>
                                <option <?php echo ($rate->row()->rate == 2 ? 'selected' : '') ?> value="2">Rarely Observed</option>
                                <option <?php echo ($rate->row()->rate == 1 ? 'selected' : '') ?> value="1">Not Observed</option>
                            </select>
                        </td>
                    </tr>
            <?php
                endif;
            endforeach;
            ?>
        </table>
    </div>
    <?php if ($student->grade_id == 1 || $student->grade_id == 14 || $student->grade_id == 15 || $student->grade_id == 16): ?>
        <div class="col-lg-12 col-md-12">
            <hr />
            <h4>Language, Literacy and Communication</h4>
            <?php
            $preSchoolSubj = Modules::run('customize/getPreSchoolSubj');

            foreach ($preSchoolSubj as $pss):
                $subj_details = Modules::run('customize/getSubjDetails', $pss->id);
            ?>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50%">
                            <?php echo $pss->subj_name ?>
                        </th>
                        <th>
                            First Quarter
                        </th>
                        <th>
                            Second Quarter
                        </th>
                        <th>
                            Third Quarter
                        </th>
                        <th>
                            Fourth Quarter
                        </th>
                    </tr>
                    <?php
                    foreach ($subj_details as $sd):
                        $first = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 1, $sy);
                        $second = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 2, $sy);
                        $third = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 3, $sy);
                        $fourth = Modules::run('customize/getLLCrate', $student->st_id, $sd->id, 4, $sy);
                    ?>
                        <tr>
                            <td>
                                <?php echo $sd->details ?>
                            </td>
                            <td class="llc" id="<?php echo $sd->id . '-1' ?>">
                                <?php echo $first->rate ?>
                            </td>
                            <td class="llc" id="<?php echo $sd->id . '-2' ?>">
                                <?php echo $second->rate ?>
                            </td>
                            <td class="llc" id="<?php echo $sd->id . '-3' ?>">
                                <?php echo $third->rate ?>
                            </td>
                            <td class="llc" id="<?php echo $sd->id . '-4' ?>">
                                <?php echo $fourth->rate ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach;
            ?>
        </div>
    <?php endif; ?>
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
        var dateAdmitted = (term == 4 ? admittedDate : '');
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
</script>