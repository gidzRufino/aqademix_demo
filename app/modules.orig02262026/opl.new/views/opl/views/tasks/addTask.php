<section id="gvDetails" class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Add a Task
                        <?php //print_r($unitDetails);  ?>
                        <small class="muted text-info">[ Things that you want the students to do ]</small>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label for="exampleInputEmail1">Task Title</label>
                        <input type="text" class="form-control" id="taskTitle" placeholder="Task Title">
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 float-left">
                        <label>Task Type</label>
                        <select id="taskType" class="form-control">
                            <?php foreach($task_type as $tt): ?>
                            <option  value="<?php echo $tt->tt_id ?>"><?php echo $tt->tt_type ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Task Details</label>
                        <textarea class="textarea" id="taskDetails" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Select Subject, Grade Level and Section </label>
                        <select id="gradeLevel" class="form-control" onclick="fetchLesson(this.value)">
                            <option>Select Subject, Grade Level and Section</option>
                            <?php foreach($getSubjects as $gl): 
                                ?>
                            <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->subject.' - '.$gl->level.' [ '. $gl->section.' ] '?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Link to Unit</label>
                        <select id="unitLink" class="form-control">
                            <?php foreach($unitDetails as $ud): ?>
                            <option  value="<?php echo $ud->ou_opl_code ?>"><?php echo $ud->ou_unit_title ?></option>
                            <?php endforeach; ?>
                        </select>
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

                <div class="card-footer clearfix">
                    <div class="checkbox float-left" >
                        <label>
                            <input id="goPublic" type="checkbox"> Go Public
                        </label>
                    </div>
                    <button class="btn btn-success btn-sm float-right" onclick="postTask()">Post Task</button>
                </div>

            </div>
            <!-- /.col-->
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
        });
        
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
    
    function postTask()
    {
        var gopublic = 0;
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
        ;

        var url = base + 'opl/addTask';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : school_year,
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
            //dataType: 'json',
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function (data)
            {
                alert(data);
                document.location = base + '/opl/classBulletin/'+ school_year+'/List/'+gradeLevel+ '/' + section_id + '/' + subject_id+ '/';
            }
        });

    }
</script>