<?php
$settings = Modules::run('main/getSet');
$subject_ids = Modules::run('academic/getSpecificSubjectPerlevel', $details->grade_id);
//print_r($subject_ids);
//$subject = explode(',', $subject_ids->subject_id);
switch ($this->session->userdata('term')) {
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
    default:
        $grading = 'final';
        break;
}
?>
<div class="panel panel-green">
    <div class="panel-heading clearfix">
        <h4 class="pull-left">Current Class Record Status</h4>
        <div class="btn-group pull-right" data-toggle="buttons">
            <label onclick="getClassRecord('<?php echo base64_encode($details->st_id) ?>','<?php echo $details->grade_id ?>',$('#inputTerm').val(),'<?php echo $details->section_id ?>',$('#inputSY').val())" title="Class Record" data-toggle="tooltip" data-placement="top" class="btn btn-primary active tip-top">
                <input type="radio" name="options" id="option1" checked><i class="fa fa-table"></i>
            </label>
            <?php if ($this->session->userdata('usertype') != 4): ?>
                <label onclick="getProgressReport('<?php echo base64_encode($details->st_id) ?>',$('#inputTerm').val(),$('#inputSY').val())" title="Progress Report" data-toggle="tooltip" data-placement="top" class="btn btn-primary tip-top">
                    <input type="radio" name="options" id="option2"><i class="fa fa-bar-chart "></i>
                </label>
            <?php endif; ?>
            <!-- <label class="btn btn-primary printCC" onclick="printIndividualCC('front')"
                   >
                <input type="radio" name="options" id="option3" /><i class="fa fa-book"></i>
            </label> -->
        </div>
        <span class="pull-right" style="margin-right:10px; color:black;">
            <select tabindex="-1" id="inputTerm" style="width:200px">
                <?php
                $first = "";
                $second = "";
                $third = "";
                $fourth = "";
                switch ($this->session->userdata('term')) {
                    case 1:
                        $first = "selected = selected";
                        break;

                    case 2:
                        $second = "selected = selected";
                        break;

                    case 3:
                        $third = "selected = selected";
                        break;

                    case 4:
                        $fourth = "selected = selected";
                        break;
                }
                ?>
                <option>Select Grading</option>
                <option <?php echo $first ?> value="1">First Grading</option>
                <option <?php echo $second ?> value="2">Second Grading</option>
                <option <?php echo $third ?> value="3">Third Grading</option>
                <option <?php echo $fourth ?> value="4">Fourth Grading</option>

            </select>
            <select tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="">
                <option>School Year</option>
                <?php
                foreach ($ro_year as $ro) {
                    $roYears = $ro->ro_years + 1;
                    if ($this->session->userdata('school_year') == $ro->ro_years):
                        $selected = 'Selected';
                    else:
                        $selected = '';
                    endif;
                ?>
                    <option <?php echo $selected; ?> value="<?php echo $ro->ro_years; ?>"><?php echo $ro->ro_years . ' - ' . $roYears; ?></option>
                <?php } ?>
            </select>
        </span>
    </div>
    <div class="panel-body clearfix" id="acadInfoBody">
        <?php
        foreach ($subject as $s):
            $singleSub = Modules::run('academic/getSpecificSubjects', $s);
            $assessment = Modules::run('gradingsystem/getPartialAssessment', $details->uid, $details->section_id, $s, $details->year);
            $finalAssessment += $assessment->$grading;
        endforeach;

        if ($finalAssessment > 0):
        ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <?php
                        foreach ($subject as $s):
                            $singleSub = Modules::run('academic/getSpecificSubjects', $s);
                        ?>
                            <td><?php echo $singleSub->subject; ?></td>
                        <?php
                        endforeach;
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <td>Partial Number Grade</td>
                    <?php
                    foreach ($subject as $s):
                        $singleSub = Modules::run('academic/getSpecificSubjects', $s);
                        $assessment = Modules::run('gradingsystem/getPartialAssessment', $details->uid, $details->section_id, $s, $details->year);

                    ?>
                        <td><?php echo $assessment->$grading; ?></td>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>

        <?php
        else:
        ?>
            <div class="alert alert-warning">
                <h2 class="text-center">Sorry, No Record Found</h2>
            </div>

        <?php
        endif;
        ?>
    </div>
    <div class="panel-footer clearfix hide" id="acadInfoFooter">
        <div class="btn-group col-lg-12" data-toggle="buttons">
            <?php
            foreach ($subject_ids as $s):
                $singleSub = Modules::run('academic/getSpecificSubjects', $s->sub_id);
            ?>
                <label onclick="getSubjectProgressReport(this.id,$('#inputTerm').val(),'<?php echo base64_encode($details->st_id) ?>',$('#inputSY').val())" id="<?php echo $singleSub->subject_id ?>" title="Class Record" data-toggle="tooltip" data-placement="top" class="btn btn-primary tip-top">
                    <input value="<?php echo $singleSub->subject_id ?>" type="radio" name="options" id="subjects" checked><?php echo $singleSub->short_code; ?>
                </label>
            <?php
            endforeach;
            ?>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#frontBack').select2();
        $(".printCC").clickover({
            placement: 'left',
            html: true
        });
    });

    function getClassRecord(st_id, details, term, section_id, school_year) {
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualClassRecord/' ?>" + st_id + '/' + details + '/' + section_id + '/' + term + '/' + school_year
        $.ajax({
            type: "GET",
            url: url,
            //dataType:'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data)
                $('#acadInfoFooter').addClass('hide')
            }
        })
    }

    function getProgressReport(st_id, term, school_year) {
        //alert(school_year)
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualProgressChart/' ?>" + st_id + '/' + term + '/' + school_year
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data.main)
                $('#acadInfoFooter').removeClass('hide')
            }
        })
    }

    function printIndividualCC(page) {
        var st_id = '<?php echo base64_encode($details->st_id) ?>';
        var term = $('#inputTerm').val();
        var SY = $('#inputSY').val();
        var gl = '<?php echo $details->grade_id ?>';
        var section = '<?php echo $details->section_id ?>'
        if (page != 'none') {
            var url = '<?php echo base_url() . 'reports/class_card/printIndividual/' ?>' + st_id + '/' + term + '/' + SY + '/' + gl + '/' + section
            window.open(url, '_blank');
        }

    }

    function getSubjectProgressReport(subject_id, term, st_id, school_year) {
        //console.log(subject_id)
        var url = "<?php echo base_url() . 'gradingsystem/getIndividualProgressChart/' ?>" + st_id + '/' + term + '/' + school_year + '/' + subject_id
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'csrf_test_name=' + $.cookie('csrf_cookie_name'),
            success: function(data) {
                $('#acadInfoBody').html(data.main)
                //$('#gpa').html(data.gpa)
            }
        })
    }
</script>