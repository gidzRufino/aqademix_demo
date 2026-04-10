<section id="gvDetails" class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                
                    <?php
                    $attributes = array('class' => '', 'role' => 'form', 'id' => 'addRubricForm', 'onsubmit' => 'event.preventDefault();');
                    echo form_open(base_url() . 'opl/addTask', $attributes);
                    ?>
                <div class="card-header">
                    <h3 class="card-title">
                        <?php //print_r($unitDetails);  ?>
                        <small class="muted text-info"> A rubric is typically an evaluation tool or set of guidelines used to promote the consistent application of learning expectations, learning objectives, or learning standards in the classroom, or to measure their attainment against a consistent set of criteria.</small>
                    </h3>
                    
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label for="exampleInputEmail1">Rubric Title</label>
                        <input type="text" class="form-control" id="rubricTitle" value="<?php echo $rubricDetails->ru_alias ?>" placeholder="Title">
                    </div>

                    <div class="form-group col-xs-12 col-lg-3 float-right">
                        <label for="exampleInputEmail1">Number of Scale</label>
                        <input type="text" class="form-control" id="scale" value="<?php echo $rubricDetails->ri_scale ?>" placeholder="e.g. 5 or 10">
                    </div>
                    <div class="form-group col-xs-12 col-lg-3 float-right">
                            <label for="exampleInputEmail1">Select Rubric Type</label>
                            <select style="font-size:16px;"  tabindex="-1" id="inputType" class="">
                                  <option value="" >Select Rubric Type</option>
                                  <option <?php echo ($rubricDetails->ru_type==0?'Selected':'') ?> value="0">In Test</option>
                                  <option <?php echo ($rubricDetails->ru_type==1?'Selected':'') ?> value="1">Project Type</option>
                            </select> 
                    </div>
                    <input type="hidden" id="rubricCode" value="<?php echo $ruid ?>" />
                    <?php if($ruid==NULL): ?>
                    <button onclick="createRubric()" class="btn btn-sm btn-success float-right">Create Rubric</button>
                    <div class="form-group col-xs-12 col-lg-12 float-right">
                        <div class="border-top my-3"></div>
                    </div>
                    <?php else: ?>
                    
                    <div class="form-group col-xs-12 col-lg-12 float-right">
                        <button onclick="addCriteriaModal()" class="btn btn-sm btn-primary float-right">Add Criteria</button>
                        <input type="hidden" id="criteriaCounter" value="0" />
                    </div>
                    <div class="form-group col-lg-12 float-left" id="rubricCriteriaWrapper" style="display: none;">
                        <table class="table table-stripped table-hover">
                            <tr><th>Criteria</th><th>Percentage</th><th id="thScale" colspan="">SCALE</th></tr>
                            <tbody id="criteriaBody">
                                
                            </tbody>
                        </table>
                    </div>
                    
<!--                    <div class="form-group col-xs-12 col-lg-6 pull-left">
                        <label>Select Subject, Grade Level and Section </label>
                        <select id="gradeLevel" class="form-control" onclick="fetchLesson(this.value)">
                            <option>Select Subject, Grade Level and Section</option>
                            <?php foreach($getSubjects as $gl): 
                                ?>
                            <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->subject.' - '.$gl->level.' [ '. $gl->section.' ] '?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-6 pull-left">
                        <label>Link to Unit</label>
                        <select id="unitLink" class="form-control">
                            <?php foreach($unitDetails as $ud): ?>
                            <option  value="<?php echo $ud->ou_opl_code ?>"><?php echo $ud->ou_unit_title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>-->
                    <?php endif; ?>
                </div>

            </div>
            <!-- /.col-->
        </div>
        
        <div class="modal" id='addCriteria' tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                        <div class="modal-body text-center">
                             <div class="form-group col-xs-12 col-lg-12 float-left">
                                <label for="exampleInputEmail1">Name of Criteria</label>
                                <input onclick="if($('#inputType').val()==''){alert('Please Select Rubric Type!'); $('#inputTerm').focus()};" type="text" class="form-control" id="rubricCriteria" placeholder="e.g. Content / Idea">
                            </div>

                            <div class="form-group col-xs-12 col-lg-12 float-left">
                                <label for="exampleInputEmail1">Percentage of Criteria</label>
                                <input type="text" class="form-control" id="criteriaPercentage" placeholder="Percentage of Criteria">
                            </div>
                            <div id="scaleDetails">
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="deleteBtn" onclick="addCriteriaToRubric()">ADD</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                </div>
            </div>
        </div>
</section>

<input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $gradeDetails->section_id ?>" />
<input type="hidden" id="subject_id" value="<?php echo $subjectDetails->subject_id ?>" />
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />

<script type="text/javascript">

    $(function () {
        // Summernote
        $('.textarea').summernote();
        
        
        $('.timePick').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
        $('#gradeLevel').on('select2:select', function (e) {
            fetchLesson($(this).val());
            getComponent($(this).val());
        });
        
        $('#submissionType').on('select2:select', function(e){
            if($(this).val()==3)
            {
                $('#quizWrapper').show();
            }else{
                $('#quizWrapper').hide();
            }
        });
        
        addCriteriaModal = function()
        {
            $('#addCriteria').modal('show');
            var htmlResponse = "";
            var rubricCode = $('#rubricCode').val();
            var scale = $('#scale').val();
            
            for(var i=1;i<=scale;i++)
            {
                htmlResponse +="<div class='form-group float-left'>";
                htmlResponse += "<label>Scale "+i+"</label>";
                htmlResponse += "<input type='text' id='scale_desc_"+i+"' scale='"+i+"' class='form-control scaleCriteria' placeholder='Scale "+i+" description' /> <br />";
                htmlResponse += "</div>";
            }
            
            $('#scaleDetails').html(htmlResponse);
        };
        
        addCriteriaToRubric = function(){
            var htmlResponse = "";
            var criteraDescription = [];
            var criteriaName = $('#rubricCriteria').val();
            var criteriaPercentage = $('#criteriaPercentage').val();
            var scale = $('#scale').val();
            $('#thScale').attr('colspan',scale);

            $('.scaleCriteria').each(function () {
                var criteriaDesc = {
                    'rd_scale'        : $(this).attr('scale'),
                    'rd_description'  : $(this).val()
                };
                criteraDescription.push(criteriaDesc);
            });

            var criteriaDescription = JSON.stringify(criteraDescription);
            
            var rubricCode = $('#rubricCode').val();
            
            
            var url = "<?php echo base_url() . 'opl/saveCriteria/' ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    scales  : criteriaDescription,
                    criteriaName : criteriaName,
                    criteriaPercentage : criteriaPercentage,
                    ruid        : rubricCode,
                    school_year : '<?php echo $school_year ?>',
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    htmlResponse += '<tr><th>'+criteriaName+'</th>';
                    htmlResponse += '<th>'+criteriaPercentage+'</th>';

                    $('.scaleCriteria').each(function () {
                        htmlResponse += '<th>'+$(this).attr('scale')+'</th>';

                    });
                    htmlResponse += '</tr>';

                    $('#rubricCriteriaWrapper').show();
                    $('#criteriaBody').append(htmlResponse);
                    alert(data);
                }
            });
        };
        
        createRubric = function(){
            var rubricTitle = $('#rubricTitle').val();
            var rubricType = $('#inputType').val();
            var rubricScale = $('#scale').val();
            
            var url = "<?php echo base_url() . 'opl/addRubric'?>";
            $.ajax({
                type: "POST",
                url: url,
                dataType: 'json',
                data: {
                    school_year : '<?php echo $school_year ?>',
                    title   : rubricTitle,
                    type    : rubricType,
                    scale   : rubricScale,
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                    alert('Successfully added');
                    document.location = '<?php echo base_url('opl/createRubric/'.$school_year.'/')?>'+data.code;
                    
                }
            });
        };
        
        
//        addCriteriaToRubric = function() {
//            
//            var rubricCriteria = $('#rubricCriteria').val();
//            var criteriaPercentage = $('#criteriaPercentage').val();
//            
//            
//            
//            var url = "<?php echo base_url() . 'opl/qm/searchAQuiz/' ?>"+value+'/'+'<?php echo $school_year ?>';
//            $.ajax({
//                type: "GET",
//                url: url,
//                data: {
//                    csrf_test_name: $.cookie('csrf_cookie_name')
//                },
//                success: function (data)
//                {
//                     $('#searchQuestions').show();
//                     $('#searchQuestions').html(data);
//                    
//                }
//            });
//        };
        
        searchAQuiz = function(value) {
        
            var url = "<?php echo base_url() . 'opl/qm/searchAQuiz/' ?>"+value+'/'+'<?php echo $school_year ?>';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                     $('#searchQuestions').show();
                     $('#searchQuestions').html(data);
                    
                }
            });
        };
        
    });
    
    
    
    function fetchLesson(value)
    {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/opl_variables/fetchLesson/'+value+'/'+school_year;
        $.ajax({
            type: "GET",
            url: url,
            data:'',
            success: function (data)
            {
                $('#unitLink').html(data);
            }
        });
    }
    
    function getComponent(value)
    {
        var school_year = $('#school_year').val();
        var base = $('#base').val();
        var url = base + 'opl/getAssessCatDropdown/'+value+'/'+school_year;
        $.ajax({
            type: "GET",
            url: url,
            data:'',
            success: function (data)
            {
                $('#gsComponent').html(data);
            }
        });
    }
    
    function postAndUploadTask()
    {
        if ($('#userfile').get(0).files.length === 0) {
            postTask();
        }else{
            
            var gopublic = 0;
            var isTaskOnline = 0;
            var onlineLink = 0;
            var taskSubmissionType = $('#submissionType').val();
            var base = $('#base').val();
            var school_year = $('#school_year').val();
            var postDetails = $('#taskDetails').val();
            var postTitle = $('#taskTitle').val();
            var gradeLevel = $('#gradeLevel').val();
            var section_id = $('#section_id').val();
            var subject_id = $('#subject_id').val();
            var fd = new FormData(); 
            var files = $('#userfile')[0].files[0]; 
            
            
            if ($('#goPublic').is(':checked'))
            {
                gopublic = 1;
            }

            if(taskSubmissionType==3)
            {
                isTaskOnline = 1;
                onlineLink = $('#quiz_id').val();
            }

            fd.append('userfile', files); 
            fd.append('hasUpload', 1);
            fd.append('task_is_online', isTaskOnline);
            fd.append('task_online_link', onlineLink);
            fd.append('school_year', school_year);
            fd.append('task_submission', taskSubmissionType);
            fd.append('inputTerm', $('#inputTerm').val());
            fd.append('numItems', $('#numItems').val());
            fd.append('gsComponent', $('#gsComponent').val());
            fd.append('taskType', $('#taskType').val());
            fd.append('startDate', $('#startDate').val());
            fd.append('timeStart', $('#timeStart').val());
            fd.append('timeDeadline', $('#timeDeadline').val());
            fd.append('deadlineDate', $('#deadlineDate').val());
            fd.append('unitLink', $('#unitLink').val());
            fd.append('postDetails', postDetails);
            fd.append('subGradeSec', gradeLevel);
            fd.append('postTitle', postTitle);
            fd.append('isPublic', gopublic);
            fd.append('csrf_test_name',  $.cookie('csrf_cookie_name'));
            
            var url = base + 'opl/addTask';
            
            $.ajax({ 
                url: url, 
                type: 'post', 
                data: fd, 
                contentType: false, 
                processData: false, 
                dataType:'json',
                beforeSend: function () {
                    $('#loadingModal').modal('show');
                },
                success: function(data){ 
                    alert(data.msg);
                    document.location = base + '/opl/classBulletin/'+ school_year+'/NULL/'+data.grade_id+ '/' + data.section_id + '/' + data.subject_id+ '/';
                } 
            }); 
        }
    }
    
    function postTask()
    {
        var gopublic = 0;
        var isTaskOnline = 0;
        var onlineLink = 0;
        var taskSubmissionType = $('#submissionType').val();
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var postDetails = $('#taskDetails').val();
        var postTitle = $('#taskTitle').val();
        var gradeLevel = $('#gradeLevel').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        

        if ($('#goPublic').is(':checked'))
        {
            gopublic = 1;
        }
        
        if(taskSubmissionType==3)
        {
            isTaskOnline = 1;
            onlineLink = $('#quiz_id').val();
        }
            

        var url = base + 'opl/addTask';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                hasUpload       : 0,
                task_is_online  : isTaskOnline,
                task_online_link: onlineLink,
                school_year     : school_year,
                task_submission : taskSubmissionType,
                inputTerm       : $('#inputTerm').val(),
                numItems        : $('#numItems').val(),
                gsComponent     : $('#gsComponent').val(),
                taskType        : $('#taskType').val(),
                startDate       : $('#startDate').val(),
                timeStart       : $('#timeStart').val(),
                timeDeadline    : $('#timeDeadline').val(),
                deadlineDate    : $('#deadlineDate').val(),
                unitLink        : $('#unitLink').val(),
                postDetails     : postDetails,
                subGradeSec     : gradeLevel,
                postTitle       : postTitle,
                isPublic        : gopublic,
                csrf_test_name  : $.cookie('csrf_cookie_name') 
            }, // serializes the form's elements.
            dataType: 'json',
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function (data)
            {
                alert(data.msg);
                document.location = base + '/opl/classBulletin/'+ school_year+'/NULL/'+data.grade_id+ '/' + data.section_id + '/' + data.subject_id+ '/';
            }
        });

    }
</script>