
<h1>View Grading sheet</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header clearfix" style="margin:0">
                <div class="row">
                    <div class="col-md-3">
                        <select style="font-size:16px;" id="glevel"  name="level"  onchange="getSubjects(this.value)" >
                            <option>Select Grade Level [ Section ]</option>
                            <?php
                            foreach ($section->result() as $sec) {
                                ?>                        
                                <option value="<?php echo $sec->grade_id; ?>" onclick="$('#section_id').val('<?php echo $sec->section_id ?>')"><?php echo $sec->level . ' [ ' . $sec->section . ' ]'; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select style="font-size:16px; width: 100%" id="selectSub"  name="subjects" disabled="">
                            <option>Select Subjects</option>
                            <?php
                            foreach ($getGradeLvl as $s) {
                                ?>                        
                                <option value="<?php echo $$s->grade_level_id ?>"><?php echo $s->level; ?></option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2" id="month" style="">
                        <div id="addTerm" class="pull-right">
                            <select style="font-size:16px; width: 100%" id="selectGrading"  onchange="$('#gradingID').val(this.value)" tabindex="-1" id="inputTerm" class="">
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
                                <option >Select Grading</option>
                                <option <?php echo $first ?> value="1">First Grading</option>
                                <option <?php echo $second ?> value="2">Second Grading</option>
                                <option <?php echo $third ?> value="3">Third Grading</option>
                                <option <?php echo $fourth ?> value="4">Fourth Grading</option>

                            </select>

                        </div>

                    </div>
                    <div class="col-md-4">
                        <a type="button" class="btn btn-success btn-lg" onclick="viewDetails()" data-toggle="modal" href="#cs_details"><i class="fa fa-archive"></i>&nbsp;&nbsp;View Class Records</a>
                    </div>
                </div>
                <?php if (!Modules::run('main/isMobile')): ?>
                    <button onclick="document.location = '<?php echo base_url() . 'reports/export/' ?>' + $('#section_id').val() + '/' + $('#subject_id').val() + '/' + $('#selectAssessmentCategory1').val()" id="q_template" class="hide btn btn-info btn-sm pull-left" style="margin-right: 10px; margin-top:5px;">Download Eskwela Quiz Template</button>
                <?php endif; ?>
            </h1>
            <input style="height:30px;" type="hidden" value="" id="section_id" /> 
            <input style="height:30px;" type="hidden" value="" id="subject_id" /> 
            <input style="height:30px;" type="hidden" value="" id="grade_id" />
            <input style="height:30px;" type="hidden" value="" id="gradingID" />
            <input style="height: 30px" type="hidden" value="<?php echo $this->session->userdata('school_year') ?>" id="schoolYear" />
        </div>
    </div>
    <div id="cs_details" class="modal fade" style="width:95%; margin: 0 auto;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    </div>
</div>

<script type="text/javascript">
    function getSubjects(gid) {
        $('#grade_id').val($('#glevel option:selected').val());
        var url = '<?php echo base_url() . 'academic/getSubjectsPerGradeLvl/' ?>' + gid;

        $.ajax({
            type: 'GET',
            url: url,
            data: 'id=' + gid,
            success: function (result) {
                $('#selectSub').removeAttr('disabled');
                $('#selectSub').html(result);
            },
            error: function (result) {
                alert('error');
            }
        });
    }

    function viewDetails() {
        var section = $('#section_id').val();
        var subject = $('#subject_id').val();
        var level = $('#grade_id').val();
        var grading = $('#gradingID').val();
        var sy = $('#schoolYear').val();
        var url = '<?php echo base_url() . 'gradingsystem/classRecordDetails/' ?>' + section + '/' + subject + '/' + grading + '/' + sy + '/' + level;

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#cs_details').html(data);
            },
            error: function (data) {

            }

        });
    }
</script>