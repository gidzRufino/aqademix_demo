<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Reports
            <small class="pull-right">
                <div class="form-group pull-right">
                    <select tabindex="-1" id="inputSY" style="width:200px; font-size: 15px;" class="populate select2-offscreen span2">
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
                </div>
                <select tabindex="-1" id="inputTerm" style="width:200px" class="span2">
                    <option>Select Grading</option>
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
                    <option id="finalGrading" style="display: none;" value="0">Final</option>

                </select> 
            </small>

        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
        if ($this->session->userdata('position') == 'Faculty') {
            $isTeacher = FALSE;
            $subjectAssign = Modules::run('academic/getAssignment', $this->session->employee_id, $this->session->school_year);
            foreach ($subjectAssign as $subA):
                if($subA->subject == 'Araling Panlipunan'):
                    $isTeacher = TRUE;
                endif;
            endforeach;
            ?>

            <div class="control-group pull-left col-lg-3" style="margin-right:20px;">
                <div class="controls span12">
                    
                    <select name="selectReport" onclick="action(this.value)" style="width:100%;" id="selectReport" class="controls-row" required>
                        <option>Select Report</option>           
                        <option value="grading_sheet">Grading Sheet</option>
                        <option value="deportment">Deportment</option>
                        <option value="gradeSummary">Grade Summary</option>
                        <?php if($isTeacher): ?>
                            <option value="generateCard">DepEd Form 138-A</option>
                        <?php endif; ?>    
                        <?php if ($this->session->userdata('is_adviser')): ?>
                            <option value="master_sheet">Master Sheet</option>
                            <option value="enrollmentList">List of Enrollees</option>
                            <option value="printCC">Class Card</option>
                            <option value="depEdForm1">DepEd Form 1 (SF 1)</option>
                            <option value="depEdForm2">DepEd Form 2 (SF 2)</option>
                            <option value="generateCard">DepEd Form 138-A</option>
                            <option value="generateForm137">DepEd Form 137-A</option>
                            <option value="generateTopTen">Get Top Ten</option>
                        <?php endif; ?> 

                    </select>
                </div>
                <div class="hide" id="pageSelection" style="margin-top:10px;">
                    <div class="form-group">
                        <select id="frontBack">
                            <option >Select Option</option>
                            <option onclick="getClassCardCount()" value="printCCFront">Front</option>
                            <option onclick="getClassCardCount()" value="printCCBack">Back</option>
                        </select>

                        <select id="pageID">
                            <option value="2">Page 1</option>
                            <option value="4">Page 2</option>
                            <option value="6">Page 3</option>
                            <option value="8">Page 4</option>
                            <option value="10">Page 5</option>
                            <option value="12">Page 6</option>
                            <option value="14">Page 7</option>
                        </select>              
                    </div>
                </div>
            </div>
            <div class="control-group pull-left hide" id="month" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select  tabindex="-1" id="inputMonthReport" style="width:200px" class="populate select2-offscreen span2">
                        <option >Select Month</option>
                        <option value="annual">Annual</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option> 
                    </select>
                </div>
            </div>
            <div class="control-group pull-left" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select name="inputSection" id="inputSection" style="width:100%;" class="pull-left controls-row span12" required>
                        <option>Select Section</option> 
                        <?php
                        foreach ($getAssignment as $ga) {
                            ?>
                            <option value="<?php echo $ga->section_id; ?>"><?php echo $ga->level . ' ( ' . $ga->section . ' )' ?></option>  
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group pull-left" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select name="inputSubject" id="inputSubject" style="width:100%;"  class="pull-left controls-row span12" required>
                        <option>Select Subject</option> 
                        <?php
                        foreach ($getAssignment as $ga) {
                            ?>
                            <option value="<?php echo $ga->subject_id; ?>"><?php echo $ga->subject ?></option>  
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group pull-left" id="depormentList" style="margin-right:20px; width:200px; display: none;">
                <div class="controls">
                    <select name="deportmentSelect" style="width:220px;" id="deportmentSelect" required>
                        <option>Select Deportment</option>
                        <?php foreach ($deportment->result() as $deportment): ?>
                            <?php if($deportment->bh_id != 22): ?>
                            <option value="<?php echo $deportment->bh_id ?>"><?php echo $deportment->bh_name ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <?php
    }
    if ($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')) {
        ?>
        <div style="margin:25px auto !important;">
            <div class="control-group pull-left" style="margin-right:20px; width:200px;">
                <div class="controls span12">
                    <select name="selectReport" onclick="action(this.value)" style="width:100%;"  id="selectReport" class="controls-row span12" required>
                        <option>Select DepEd Forms</option>           
                        <option value="enrollmentList">List of Enrollees</option>
                        <option value="grading_sheet">Grading Sheet</option>
                        <option value="deportment">Deportment</option>
                        <option value="gradeSummary">Grade Summary</option>
                        <option value="master_sheet">Master Sheet</option>
                        <option value="printCC">Class Card</option>
                        <option value="depEdForm1">DepEd Form 1 (SF 1)</option>
                        <option value="depEdForm2">DepEd Form 2 (SF 2)</option>
                        <option value="depEdForm4">DepEd Form 4 (SF 4)</option>
                        <option value="depEdForm5">DepEd Form 5 (SF 5)</option>
                        <option value="depEdForm6">DepEd Form 6 (SF 6)</option>
                        <option value="depEdForm7">DepEd Form 7 (SF 7)</option>
                        <option value="generateCard">DepEd Form 138-A</option>
                        <option value="generateForm137">DepEd Form 137-A</option>
                        <option value="generateTopTen">Get Top Ten</option>

                    </select>
                </div>
                <div class="hide" id="pageSelection" style="margin-top:10px;">
                    <div class="form-group">
                        <select id="frontBack">
                            <option>Select Option</option>
                            <option onclick="getClassCardCount()"  value="printCCFront">Front</option>
                            <option  onclick="getClassCardCount()" value="printCCBack">Back</option>

                        </select>

                        <select id="pageID">
                            <option value="2">Page 1</option>
                            <option value="4">Page 2</option>
                            <option value="6">Page 3</option>
                            <option value="8">Page 4</option>
                            <option value="10">Page 5</option>
                            <option value="12">Page 6</option>
                            <option value="14">Page 7</option>
                        </select>              
                    </div>
                </div>
            </div>

            <div class="control-group pull-left hide" id="month" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select  tabindex="-1" id="inputMonthReport" style="width:100%;" class="populate select2-offscreen">
                        <option >Select Month</option>
                        <option value="annual">Annual</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option> 
                    </select>
                </div>
            </div>
            <div class="control-group pull-left"  style="margin-right:20px; width:200px;">
                <select name="inputGrade" onclick="selectSection(this.value)" id="inputGrade" style="width:100%;" required>
                    <option>Select Grade Level</option> 
                    <?php
                    foreach ($gradeLevel as $level) {
                        ?>                        
                        <option sec="<?php echo $level->level; ?>" value="<?php echo $level->grade_id; ?>"><?php echo $level->level; ?></option>
                    <?php } ?>
                </select>
            </div>  
            <div class="control-group pull-left" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select name="inputSection" id="inputSection" style="width:100%;" class="pull-left" required>
                        <option>Select Section</option>  
                    </select>
                </div>
            </div>
            <div class="control-group pull-left" style="margin-right:20px; width:200px;">
                <div class="controls" id="AddedSection">
                    <select name="inputSubject" id="inputSubject" style="width:100%;"  class="pull-left controls-row span12" required>
                        <option value=''>Select Subject</option> 
                        <?php
                        foreach ($displaySubject as $ga) {
                            ?>
                            <option value="<?php echo $ga->subject_id; ?>"><?php echo $ga->subject ?></option>  
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="control-group pull-left" id="strandWrapper" style="margin-right:20px; width:200px; display: none;">
                <div class="controls">
                    <select name="inputStrand" id="inputStrand" style="width:100%;"  class="pull-left controls-row span12" required>
                        <option>Select Strand</option> 
                        <?php
                        $strand = Modules::run('subjectmanagement/getSHOfferedStrand');
                        foreach ($strand as $st) {
                            ?>
                            <option value="<?php echo $st->st_id; ?>"><?php echo $st->strand ?></option>  
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="control-group pull-left" id="depormentList" style="margin-right:20px; width:200px; display: none;">
                <div class="controls">
                    <select name="deportmentSelect" style="width:220px;" id="deportmentSelect" required>
                        <option>Select Deportment</option>
                        <?php foreach ($deportment->result() as $deportment): ?>
                            <?php if($deportment->bh_id != 22): ?>
                            <option value="<?php echo $deportment->bh_id ?>"><?php echo $deportment->bh_name ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="form-group input-group ">
        <span class="input-group-btn">
            <?php if ($this->session->userdata('is_admin') || $this->session->userdata('is_superAdmin')): ?>
                <a onclick="getLOFGraph()" data-toggle="modal" href="#proficiency_details" class="btn btn-warning pull-right">
                    <i id="verify_icon" class="fa fa-bar-chart"></i>
                </a>   
            <?php endif; ?>
            <button onclick="generateReport()" class="btn btn-success pull-right">Generate</button>
        </span> 
    </div>

    <div id="deportList" class="col-md-12">

    </div>

    <div id="iframeWrapper" class="col-lg-12">
        <div id="iframeLoader"></div>
        <iframe class="" style="display:none; margin-top:10px;" id="report_iframe" width="100%" height="350" src=""></iframe> 
        <input type="hidden" id="iframeController" value="0" />
    </div>

</div>
<script type="text/javascript">

    function getLOFGraph()
    {
        var subject_id = $('#inputSubject').val();
        var section_id = $('#inputSection').val();
        var grade_id = $('#inputGrade').val();
        var section = $('#inputSection option').attr('sec');
        var term = $('#inputTerm').val();
        var school_year = $("#inputSY").val();
        switch (term) {
            case '1':
                var title = 'First Grading Proficiency Level';
                break;
            case '2':
                title = 'Second Grading Proficiency Level';
                break;
            case '3':
                title = 'Third Grading Proficiency Level';
                break;
            case '4':
                title = 'Fourth Grading Proficiency Level';
                break;
        }
        //alert(title)


        var url = "<?php echo base_url() . 'reports/getLevelOfProficiency/' ?>" + school_year + '/' + term + '/' + grade_id + '/' + section_id; // the script where you handle the form input.

        $.ajax({
            type: "GET",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            beforeSend: function () {
                showLoading('lop_details');
                $('#lop_title').html('Generating PL ... Please Wait Patiently...')
            }, // serializes the form's elements.
            success: function (data)
            {
                $('#lop_title').html(title)
                $('#lop_details').html(data);
            }
        });

        return false;
    }

    function getClassCardCount()
    {
        var section_id = $('#inputSection').val();

        var url = "<?php echo base_url() . 'reports/getClassCardCount/' ?>" + section_id; // the script where you handle the form input.

        $.ajax({
            type: "GET",
            url: url,
            data: "data=" + "" + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#pageID').html(data);
            }
        });

        return false;
    }

    function action(value) {
        //  alert(value)
        switch (value)
        {
            case 'enrollmentList':
                $('#inputSubject').addClass('hide');
                break;
            case 'depEdForm1':
                $('#inputGrade').removeClass('hide');
                $('#inputSection').removeClass('hide');
                break;
            case 'depEdForm2':
                $('#month').removeClass('hide');
                $('#inputSubject').addClass('hide');
                break;
            case 'depEdForm4':
                $('#month').removeClass('hide');
                $('#inputSubject').addClass('hide');
                $('#inputGrade').addClass('hide');
                $('#inputSection').addClass('hide');
                break;
            case 'depEdForm6':
                $('#inputSubject').addClass('hide');
                $('#inputGrade').addClass('hide');
                $('#inputSection').addClass('hide');
                $('#month').addClass('hide');
                break;
            case 'generateCard':
                $('#inputSubject').addClass('hide');
                $('#inputGrade').removeClass('hide');
                $('#inputSection').removeClass('hide');
                break;
            case 'printCC':
                $('#inputSubject').addClass('hide');
                $('#pageSelection').removeClass('hide')
                $('#inputGrade').removeClass('hide');
                $('#inputSection').removeClass('hide');
                break;
            case 'grading_sheet':
                $('#inputSubject').removeClass('hide');
                $('#inputGrade').removeClass('hide');
                $('#inputSection').removeClass('hide');
                break;
            case 'deportment':
                $('#inputSubject').addClass('hide');
                $('#depormentList').show();
                break;
            case 'master_sheet':
                $('#inputSubject').addClass('hide');
                $('#inputGrade').removeClass('hide');
                $('#inputSection').removeClass('hide');
                break;
            case 'generateTopTen':
                $('#finalGrading').show();
                break;
            case 'generateForm137':
                $('#inputGrade').addClass('hide');
                $('#inputSection').addClass('hide');
                $('#inputSubject').addClass('hide');

                break;

        }
    }


    $(document).ready(function () {
        $('#selectReport').select2();
        $('#inputGrade').select2();
        $('#inputSection').select2();
        $('#inputSubject').select2();
        $('#inputMonthReport').select2();
        $("#inputSY").select2();
    });

    function selectSection(level_id) {
        var url = "<?php echo base_url() . 'registrar/getSectionByGL/' ?>" + level_id; // the script where you handle the form input.

        if (level_id == 12 || level_id == 13)
        {
            $('#strandWrapper').show();
            $('#inputTerm').attr('disabled', false);
            $('#inputTerm').html('<option >Select Grading</option><option <?php echo $first ?> value="1">First Semester</option><option <?php echo $second ?> value="3">Second Semester</option><option id="finalGrading" style="display: none;" value="0">Final</option>');
        } else {
            $('#strandWrapper').hide();
            $('#inputTerm').attr('disabled', false);
            $('#inputTerm').html('<option >Select Grading</option><option <?php echo $first ?> value="1">First Grading</option><option <?php echo $second ?> value="2">Second Grading</option><option <?php echo $third ?> value="3">Third Grading</option><option <?php echo $fourth ?> value="4">Fourth Grading</option><option id="finalGrading" style="display: none;" value="0">Final</option>');
        }
        $.ajax({
            type: "POST",
            url: url,
            data: "level_id=" + level_id + '&csrf_test_name=' + $.cookie('csrf_cookie_name'), // serializes the form's elements.
            success: function (data)
            {
                $('#inputSection').html(data);

            }
        });

        return false;
    }

    function generateReport()
    {
        var report = $('#selectReport').val();
        var subject_id = $('#inputSubject').val();
        var section_id = $('#inputSection').val();
        var grade_id = $('#inputGrade').val();
        var section = $('#inputSection option').attr('sec');
        var term = $('#inputTerm').val();
        var school_year = $("#inputSY").val();
        var deportment = $('#deportmentSelect').val();
        switch (report) {
            case 'depEdForm2':
                var month = $('#inputMonthReport').val();
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + month + '/' + school_year;
                window.open(url, '_blank');
                break;
            case 'depEdForm1':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year + '/' + grade_id; // the script where you handle the form input.    
                window.open(url, '_blank');
                break;
            case 'depEdForm5':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year; // the script where you handle the form input.    
                window.open(url, '_blank');
                break;
            case 'depEdForm6':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + school_year; // the script where you handle the form input.    
                window.open(url, '_blank');
                break;
            case 'depEdForm7':
                var url = "<?php echo base_url() ?>reports/" + report + '/'; // the script where you handle the form input.    

                break;
            case 'depEdForm4':
                var month = $('#inputMonthReport').val();
                var url = "<?php echo base_url() ?>reports/" + report + '/' + month + '/' + school_year; // the script where you handle the form input.    
                window.open(url, '_blank');
                break;
            case 'grading_sheet':
                var subject_id = $('#inputSubject').val();

                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + subject_id + '/' + school_year;
                window.open(url, '_blank');
                break;
            case 'master_sheet':

                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + term + '/' + school_year;
                window.open(url, '_blank');
                break;
            case 'enrollmentList':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year;
                window.open(url, '_blank');
                break;
            case 'gradeSummary':
                if(term=='Select Grading'){
                    alert('Please Select Grading Period');
                }else{        
                    var url = "<?php echo base_url() ?>gradingsystem/" + report + '/' + section_id + '/'+term + '/' + school_year;
                    window.open(url, '_blank');
                }    
            break;
            case 'deportment':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + term + '/' + deportment + '/' + school_year;
                break;
            case 'printCC':
                var frontBack = $('#frontBack').val()
                var pageID = $('#pageID').val()
                if (frontBack == 'printCCBack') {
                    var limit = parseInt(pageID - 2)
                } else {
                    var pageID = pageID * 2
                    var limit = parseInt(pageID - 4)
                }
                // document.getElementById(id).href = '<?php echo base_url() . 'registrar/' ?>'+frontBack+'/'+section_id+'/'+limit+'/'+pageID
                if (grade_id != 12 && grade_id != 13) {
                    var url = "<?php echo base_url() ?>reports/cc/" + frontBack + '/' + section_id + '/' + term + '/' + limit + '/' + pageID
                } else {
                    var strand_id = $('#inputStrand').val();
                    url = "<?php echo base_url() ?>reports/cc/printCCSH/" + section_id + '/' + term + '/' + limit + '/' + pageID + '/' + strand_id
                }
                window.open(url, '_blank');
                break;
            case 'generateCard':
                if (grade_id != 12 && grade_id != 13) {
                    var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year;
                } else {
                    var strand_id = $('#inputStrand').val();
                    url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year + '/' + strand_id;
                }
                document.location = url;
                break;
            case 'generateForm137':
                var url = "<?php echo base_url() ?>reports/" + report + '/' + section_id + '/' + school_year;
                window.open(url, '_blank');
                break;
            case 'generateTopTen':
                var url = "<?php echo base_url() ?>reports/getTopTen/" + section_id + '/' + grade_id + '/' + term + '/' + school_year + '/' + subject_id;
                window.open(url, '_blank');
                break;

        }

//          $('#loading').removeClass('hide');
//          $('#loading').html('<img src="<?php echo base_url() ?>images/loading.gif" style="width:200px" />')

        // var iframe = document.createElement('report_iframe');
        if (report != 'deportment') {
//            showLoading('iframeLoader');
//            document.getElementById('report_iframe').src = url;
//            $('#report_iframe').attr('onload', 'iframeloaded()');
//            if ($('#iframeController').val() == 1) {
//                //document.getElementById('report_iframe').Window.location.reload(true);
//                $('#report_iframe').hide();
//            }
        } else {
            $.ajax({
                url: url,
                success: function (data) {
                    $('#deportList').html(data);
                }
            });
        }
        //

        // window.open(url, '_blank');
        //document.title = 'DepEd Form';


    }

    function iframeloaded()
    {
        stopLoading('iframeLoader')
        $('#report_iframe').show();
        $('#iframeController').val('1');
    }
</script>

<?php $this->load->view('levelOfProficiencyGraph'); ?>
