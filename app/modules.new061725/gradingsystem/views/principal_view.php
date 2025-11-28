<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Grading System</h1>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            $gs = Modules::run('gradingsystem/getSet');
                            $post1 = ($gs->is_fg_first_post != '' ? 1 : 0);
                            $post2 = ($gs->is_fg_second_post != '' ? 1 : 0);
                            $post3 = ($gs->is_fg_third_post != '' ? 1 : 0);
                            $post4 = ($gs->is_fg_fourth_post != '' ? 1 : 0);
                            ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="text-align: center">Post Final Grade for Parent's View</th>
                                    </tr>
                                    <tr>
                                        <th>Quarter</th>
                                        <th>Date Posted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>First Quarter</td>
                                        <?php
                                        $pDate1 = explode(',', $gs->is_fg_first_post)
                                        ?>
                                        <td style="text-align: center"><?php echo $pDate1[1]; ?></td>
                                        <td>
                                            <button class="btn <?php echo ($post1 ? 'btn-success' : 'btn-danger') ?>" style="width: 100%; height: 100%" onclick="postFG(1, <?php echo $post1 ?>)"><?php echo ($post1 ? 'POSTED' : 'POST') ?></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Second Quarter</td>
                                        <?php
                                        $pDate2 = explode(',', $gs->is_fg_second_post)
                                        ?>
                                        <td style="text-align: center"><?php echo $pDate2[1]; ?></td>
                                        <td>
                                            <button class="btn  <?php echo ($post2 ? 'btn-success' : 'btn-danger') ?>" style="width: 100%; height: 100%" onclick="postFG(2, <?php echo $post2 ?>)"><?php echo ($post2 ? 'POSTED' : 'POST') ?></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Third Quarter</td>
                                        <?php
                                        $pDate3 = explode(',', $gs->is_fg_third_post)
                                        ?>
                                        <td style="text-align: center"><?php echo $pDate3[1]; ?></td>
                                        <td>
                                            <button class="btn  <?php echo ($post3 ? 'btn-success' : 'btn-danger') ?>" style="width: 100%; height: 100%" onclick="postFG(3, <?php echo $post3 ?>)"><?php echo ($post3 ? 'POSTED' : 'POST') ?></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fourth Quarter</td>
                                        <?php
                                        $pDate4 = explode(',', $gs->is_fg_fourth_post)
                                        ?>
                                        <td style="text-align: center"><?php echo $pDate4[1]; ?></td>
                                        <td>
                                            <button class="btn  <?php echo ($post4 ? 'btn-success' : 'btn-danger') ?>" style="width: 100%; height: 100%" onclick="postFG(4, <?php echo $post4 ?>)"><?php echo ($post4 ? 'POSTED' : 'POST') ?></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <select tabindex="-1" id="inputSY" style="font-size: 16px; margin-top: 16px;" class="pull-right">
                                <option value="0">School Year</option>
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
                            <br/><br/><br/>
                            <select onclick="$('#importTerm').val(this.value)" style="font-size:16px;" id="inputTerm" class="pull-right">
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
                                <option value="0">Select Grading</option>
                                <option <?php echo $first ?> value="1">First Grading</option>
                                <option <?php echo $second ?> value="2">Second Grading</option>
                                <option <?php echo $third ?> value="3">Third Grading</option>
                                <option <?php echo $fourth ?> value="4">Fourth Grading</option>
                            </select> 
                            <br/><br/>
                            <select tabindex="-1" id="inputGL" style="font-size: 16px;" class="pull-right" onchange="getSubjList(this.value)">
                                <option>Select Grade Level</option>
                                <?php
                                $gradeLevel = Modules::run('registrar/getGradeLevel', $settings->level_catered);
                                foreach ($gradeLevel as $gl):
                                    $section = Modules::run('registrar/getSectionBySubject', $gl->grade_id);
                                    foreach ($section->result() as $se):
                                        ?>
                                        <option onclick="$('#section_id').val(<?php echo $se->s_id ?>), $('#grade_id').val(this.value)" value="<?php echo $gl->grade_id ?>"><?php echo $gl->level . ' [ ' . $se->section . ' ]' ?></option>
                                        <?php
                                    endforeach;
                                endforeach;
                                ?>
                            </select>
                            <br/><br/>
                            <select tabindex="-1" id="inputSubj" style="font-size: 16px; margin-top: 16px;" class="pull-right" onchange="$('#subject_id').val(this.value)">
                                <option>Select Subject</option>

                            </select>
                            <?php if (!Modules::run('main/isMobile')): ?>
                                <button onclick="document.location = '<?php echo base_url() . 'gradingsystem/downloadGStemplate/' ?>' + $('#section_id').val() + '/' + $('#subject_id').val() + '/' + $('#selectAssessmentCategory1').val()" id="q_template" class="hide btn btn-info btn-sm pull-left" style="margin-right: 10px; margin-top:5px;">Download Eskwela Quiz Template</button>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-xl btn-block btn-info" style="cursor: pointer" onmouseover="$('#formController').val('classRecord')" onclick="$('#classRecord').fadeIn(), getClassRecord()"><h3>View Grading Sheet</h3></button>
                        </div>
                    </div>
                    <div class="col-md-12" ><br/>
                        <div class="span1 pull-left" style="margin:0; border-right:1px black solid; padding-right:5px;">
                        </div>
                        <div class="span12">
                            <?php echo $this->load->view('gradingsystem/classRecord'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input style="height:30px;" type="hidden" value="" id="section_id" /> 
<input style="height:30px;" type="hidden" value="" id="subject_id" /> 
<input style="height:30px;" type="hidden" value="" id="grade_id" /> 
<input style="height:30px;" type="hidden" value="" id="level_id" />  
<input style="height:30px;" type="hidden" value="0" id="strand_id" />
<?php
$is_admin = $this->session->userdata('is_admin');
?>
<div id="success">

</div>
<script type="text/javascript">

    function getSubjList(level) {
        var school_year = $('#inputSY').val();
        var url = '<?php echo base_url('academic/getSubjectsPerGradeLvl/') ?>' + level;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#inputSubj').html(data);
            }
        });
    }

    function getClassRecord()
    {
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        var grade_id = $('#grade_id').val();
        var term = $('#inputTerm').val();
        var school_year = $('#inputSY').val();
        var proceed = 0;

        if (section_id == '') {
            alert('Section should not be empty!');
            proceed == 0;
        } else if (subject_id == '') {
            alert('Please Select Subject to proceed');
            proceed = 0;
        } else if (grade_id == '') {
            alert('Please select Grade Level to proceed');
            proceed = 0;
        } else if (term == 0) {
            alert('Please select Grading to proceed');
            proceed = 0;
        } else if (school_year == 0) {
            alert('Please select School Year to proceed');
            proceed = 0;
        } else {
            proceed = 1;

//        var strand_id = $('#strand_id').val()

            if (proceed == 1) {
                var url = "<?php echo base_url() . 'gradingsystem/getClassRecord/' ?>" + subject_id + '/' + section_id + '/' + grade_id + '/' + term + '/' + school_year;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: 'details=' + section_id, // serializes the form's elements.
                    beforeSend: function () {
                        showLoading('classRecordTables');
                    },
                    success: function (data)
                    {
                        $('#classRecordTables').html(data)

                    }
                });
            }
        }

    }

    $(document).ready(function () {

        $("#assessDate").datepicker();
        $("#searchAssessDate").select2();
        //$("#subject").select2();
        $("#selectQuizCategory").select2({

        });
        $('#recordStudent').select2({
            minimumInputLength: 1
        });

        $("#inputQuizCategory").select2();
        $("#recordSection").select2({
        });
        $("#selectSection").select2({
        });
        //$("#selectSubject").select2(); 
        $("#selectSubjectA").select2();
        $("#inputGradeModal").select2();
        $("#selectQuizSubject").select2();

        //from gradingSettingsForm
        $('#fromFirstQuarter').datepicker();




    });

    function getDetails(section) {

        var term = $('#inputTerm').val()
        var url = "<?php echo base_url() . 'gradingsystem/getSectionAndSubject/' ?>" + section + '/' + term;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            data: 'details=' + section, // serializes the form's elements.
            success: function (data)
            {
                //alert('hey')
                //$("form#quoteForm")[0].reset()
                // console.log(data)
                $('#section_id').val(data.section_id)
                $('#subject_id').val(data.subject_id)
                $('#grade_id').val(data.grade_id)
                $('#level_id').val(data.level_id)
                $('#strandWrapper').html(data.strand_id)
                $('#selectAssessmentCategory1').html(data.assessment)
                $('#selectAssessmentCat').html(data.assessment)
                $('#q_template').removeClass('hide')
                $('#importTempSub').val(data.subject_id);
                $('#importTempSection').val(data.section_id);
                $('#importTempTerm').val($('#inputTerm').val())
            }
        });
    }
    function getSubject(subject) {
        $('#createSubjectId').val(subject);
    }

    function getQuizBySubject(subject) {
        document.getElementById('setSection').value = 'getQuizBySubject'
        var date = $('#getDate').val()


        var data = new Array();

        data[0] = subject;
        data[1] = date;

        if (data[0] != "") {
            // alert(subject)
            sectionAction(data)
        }
    }

    function postFG(term, opt) {
        var url = '<?php echo base_url() . 'gradingsystem/postFinalGrade/' ?>' + term + '/' + opt;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                if (opt == 0) {
                    alert('Successfuly Posted');
                } else {
                    alert('Unpost Successfuly');
                }
                location.reload();
            }
        });
    }

</script>
