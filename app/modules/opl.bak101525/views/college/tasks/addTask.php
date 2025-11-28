<section id="gvDetails" class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                
                    <?php
                    $attributes = array('class' => '', 'role' => 'form', 'id' => 'addTaskForm', 'onsubmit' => 'event.preventDefault();');
                    echo form_open(base_url() . 'opl/college/addTask', $attributes);
                    ?>
                <div class="card-header">
                    <h3 class="card-title">
                        Add a Task
                        <?php //print_r($unitDetails);  ?>
                        <small class="muted text-info">[ Things that you want the students to do ]</small>
                    </h3>
                    
<!--                        <div class="form-group col-xs-12 col-lg-5 float-right" id="month" style="">
                            
                            <div id="addTerm" class="float-right">
                              <select style="font-size:16px;"  tabindex="-1" id="inputTerm" class="">
                                  <?php
                                     $first = "";
                                     $second = "";
                                     $third = "";
                                     $fourth = "";
                                     switch($this->session->term){
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
                                    <option value="0" >Select Grading Period</option>
                                    <option <?php echo $first ?> value="2">Mid Term</option>
                                    <option <?php echo $second ?> value="4">Final Term</option>
                              </select> 
                            </div>
                        </div>-->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label for="exampleInputEmail1">Task Title</label>
                        <input onclick="if($('#inputTerm').val()==0){alert('Please Select Grading Period!'); $('#inputTerm').focus()};" type="text" class="form-control" id="taskTitle" placeholder="Task Title">
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-3 float-left">
                        <label>Task Type</label>
                        <select id="taskType" class="form-control">
                            <?php foreach($task_type as $tt): ?>
                            <option  value="<?php echo $tt->tt_id ?>"><?php echo $tt->tt_type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-3 float-left">
                        <label>Marking Type</label>
                        <select id="markType" class="form-control">
                            <option value="">Select Marking Type</option>
                            <option value="0">Point System</option>
                            <option value="1">Comment System</option>
                            <option value="2">Rubric System</option>
                        </select>
                    </div>
                    <?php //print_r($getSubjects); ?>
                    <div class="form-group col-xs-12 col-lg-6 pull-left">
                        <label>Select Course, Subject and Section</label>
                        <select id="gradeLevel" class="form-control" onclick="fetchLesson(this.value)">
                            <option>Select Course, Subject and Section</option>
                                <?php 
                                foreach($getSubjects as $gl):
                                ?>
                            <option value="<?php echo $gl->course_id.'-'.$gl->s_id.'-'.$gl->section_id ?>" <?php echo $selected; ?>><?php echo $gl->course.' - '.$gl->s_desc_title.' [ '. $gl->section.' ] '?></option>
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
                    </div>
                    <br />
                    
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label for="exampleInputEmail1">Number of Items</label>
                        <input type="text" class="form-control" id="numItems" placeholder="Total Possible Score">
                    </div>
                    
                    <div class="form-group col-lg-xs col-lg-3 float-left" id="rubricSystem" style="display:none;">
                        <label for="exampleInputEmail1">Search A Rubric</label>
                        <input type="text" onkeyup="searchARubric(this.value)" id="rubricBox"  class="form-control input-lg" aria-label="..." placeholder="Search Rubric Here" />
                        <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 85%; display: none;" class="resultOverflow" id="searchRubric">

                        </div>
                        <input type="hidden" id="ruid" />
                    </div>
                    <div id="submissionWrapper" class="form-group col-xs-12 col-lg-6 float-left">
                        <label>Submission Type</label>
                        <select id="submissionType" class="form-control">
                            <option>Select Submission Type</option>
                            <option selected value="1">Use Editor</option>
                            <option value="2">File Submission</option>
                            <option value="3">Online Quiz Form</option>

                        </select>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="form-group "id="onlineEditor" >
                        <label for="exampleInputEmail1">Task Details</label>
                        <textarea class="textarea" id="taskDetails" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group" id="quizWrapper" style="display:none;">
                        <label for="exampleInputEmail1">Search A Quiz</label>
                        <input type="text" onkeyup="searchAQuiz(this.value)" id="searchBox"  class="form-control input-lg" aria-label="..." placeholder="Search Name Here" />
                        <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 85%; display: none;" class="resultOverflow" id="searchQuestions">

                        </div>
                        <input type="hidden" id="quiz_id" />
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-6">
                        <label>File Attachment <small class="mute text-danger">[ Optional ]</small></label>
                        <input class="form-control" type="file" name="userfile" id="userfile">
                    </div>
                    
                    <div class="form-group col-lg-6 col-xs-12 float-left">
                        <label for="exampleInputEmail1">Start Date</label>
                        <input type="date" class="form-control" id="startDate" placeholder="">
                    </div>
                    <div class="form-group col-lg-6 col-xs-12 float-left">
                        <label for="exampleInputEmail1">Start Time</label>
                        
                        <input type="time" value="00:00 pm" class="form-control timePick" id="timeStart" placeholder="">
                    </div>
                    <div class="form-group col-lg-6 col-xs-12 float-left">
                        <label for="exampleInputEmail1">Date Deadline</label>
                        <input type="date" class="form-control" id="deadlineDate" placeholder="">
                    </div>
                    <div class="form-group col-lg-6 col-xs-12 float-left">
                        <label for="exampleInputEmail1">Time Deadline</label>
                        
                        <input type="time" value="00:00 pm" class="form-control timePick" id="timeDeadline" placeholder="">
                    </div>

                </div>
                <?php echo form_close(); ?>
                <div class="card-footer clearfix">
                    <div class="checkbox float-left" >
                        <label>
                            <input id="goPublic" type="checkbox"> Go Public
                        </label>
                    </div>
                    <button class="btn btn-success btn-sm float-right" onclick="postAndUploadTask()">Post Task</button>
                </div>

            </div>
            <!-- /.col-->
        </div>
</section>

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
        $('#markType').on('select2:select', function (e) {
            
            switch($(this).val())
            {
                case '0':
                    $('#rubricSystem').hide();
                    $('#submissionWrapper').removeClass('col-lg-3');
                    $('#submissionWrapper').addClass('col-lg-6');
                break;    
                case '1':
                    $('#rubricSystem').hide();
                    $('#submissionWrapper').removeClass('col-lg-3');
                    $('#submissionWrapper').addClass('col-lg-6');
                
                break;
                case '2':
                    $('#rubricSystem').show();
                    $('#submissionWrapper').removeClass('col-lg-6');
                    $('#submissionWrapper').addClass('col-lg-3');
                
                break;
            }
            
        });
        
        $('#submissionType').on('select2:select', function(e){
            if($(this).val()==3)
            {
                $('#quizWrapper').show();
            }else{
                $('#quizWrapper').hide();
            }
        });
        
        
        
        searchARubric = function(value) {
        
            var url = "<?php echo base_url() . 'opl/searchARubric/' ?>"+value+'/'+'<?php echo $school_year ?>';
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {
                     $('#searchRubric').show();
                     $('#searchRubric').html(data);
                    
                }
            });
        };
        
        
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
        var url = base + 'opl/college/fetchLesson/'+value+'/'+school_year;
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
        console.log($('#gradeLevel').val());
        if ($('#userfile').get(0).files.length === 0) {
            console.log("dari posttask");
            postTask();
        }else{
            console.log("dari postandUpload");
            var gopublic = 0;
            var isTaskOnline = 0;
            var onlineLink = 0;
            var markingType = $('#markType').val();
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
            
            console.log($('#gradeLevel').val());
            
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
            if(markingType=='2')
            {
                fd.append('ruid', $('#ruid').val());
            }else{
                fd.append('ruid', '');
                
            }
            fd.append('markingType', markingType);
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
            
            var url = base + 'opl/college/addTask';
            

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
                    document.location = base + '/opl/college/classBulletin/'+ school_year+'/NULL/'+data.grade_id+ '/' + data.section_id + '/' + data.subject_id+ '/';
                } 
            }); 
        }
    }
    
    function postTask()
    {

        console.log("postTask ready");
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
        var markingType = $('#markType').val();
        if(markingType=='2')
        {
            var ruid = $('#ruid').val();
        }else{
                ruid = '';
        }
        if ($('#goPublic').is(':checked'))
        {
            gopublic = 1;
        }
        
        if(taskSubmissionType==3)
        {
            isTaskOnline = 1;
            onlineLink = $('#quiz_id').val();
        }
            

        var url = base + 'opl/college/addTask';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                hasUpload       : 0,
                task_is_online  : isTaskOnline,
                task_online_link: onlineLink,
                school_year     : school_year,
                task_submission : taskSubmissionType,
                markingType     : markingType,
                ruid            : ruid,
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
                console.log(data)
                alert(data.msg);
                location.reload();
                // document.location = base + 'opl/college/classBulletin/'+ data.subject_id+'/'+data.section_id + '/' +data.semester+ '/';
            }
        });

    }
</script>