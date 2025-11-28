<section id="gvDetails" class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                
                    <?php
                    $attributes = array('class' => '', 'role' => 'form', 'id' => 'addRubricForm', 'onsubmit' => 'event.preventDefault();');
                    echo form_open(base_url() . 'opl/addTask', $attributes);
                    $hasDescription = FALSE;
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
                    <div class="form-group col-xs-12 col-lg-12 float-right">
                        <button onclick="addCriteriaModal()" class="btn btn-sm btn-primary float-right">Add Criteria</button>
                        <input type="hidden" id="criteriaCounter" value="0" />
                    </div>
                    <div class="form-group col-lg-12 float-left" id="rubricCriteriaWrapper">
                        <table class="table table-stripped table-hover">
                            <tr><th class="col-lg-1">Criteria</th>
                                <th class="text-center">Percentage</th>
                                <th class="text-center" id="thScale" colspan="<?php echo $rubricDetails->ri_scale ?>">SCALE</th></tr>
                            <tbody id="criteriaBody">
                                <?php $criteria = Modules::run('opl/getRubricCriteria', $ruid, $school_year); 
                                foreach($criteria->result()  as $c):
                                    $scale = Modules::run('opl/getRubricScaleDescription', $c->rcid, $school_year);
                                    ?>
                                    <tr>
                                        <td><?php echo $c->rc_criteria ?></td>
                                        <td class="text-center"><?php echo $c->rc_percentage ?></td>
                                        <?php foreach ($scale->result() as $s): 
                                            if($s->rd_description!=""):
                                                $hasdescription = TRUE;
                                            endif;
                                            ?>
                                            <td id="<?php echo $c->rcid ?>_scale" class="text-center rscale"><?php echo $s->rd_scale ?></td>
                                        <?php endforeach; ?>
                                            <td>
                                                <button onclick="editCriteriaModal($(this))" rcid="<?php echo $c->rcid ?>" criteria="<?php echo $c->rc_criteria ?>" percentage="<?php echo $c->rc_percentage ?>" class="btn btn-xs btn-outline-warning float-right"><i class="fas fa-edit"></i></button>
                                                <button onclick="deleteCriteria($(this))" rcid="<?php echo $c->rcid ?>" criteria="<?php echo $c->rc_criteria ?>" percentage="<?php echo $c->rc_percentage ?>" class="btn btn-xs btn-outline-danger float-right"><i class="fas fa-trash"></i></button>
                                            </td>
                                    </tr>
                                    <?php if($hasdescription): ?>
                                    <tr>
                                        <td colspan="2" ></td>
                                        <?php 
                                        $i=1;
                                        foreach ($scale->result() as $d):  ?>
                                        <td id="<?php echo $c->rcid ?>_desc" scale="<?php echo $i++;  ?>" class='text-center rdescription<?php echo $c->rcid;  ?>'><?php echo $d->rd_description ?></td>
                                        <?php endforeach; 
                                        ?>
                                    </tr>
                                    <?php endif; ?>
                                    
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                    </div>
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
                                <input type="hidden" id="isEdit" value="0" />
                                <button type="button" class="btn btn-success" id="editBtn" onclick="addCriteriaToRubric()">Edit</button>
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
            $('#editBtn').html('Add');
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
        
        editCriteriaModal = function(that)
        {
            $('#addCriteria').modal('show');
            var htmlResponse = "";
            var rubricCode = $('#rubricCode').val();
            var scale = $('#scale').val();
            var desc = "";
            $('#rubricCriteria').val(that.attr('criteria'));
            $('#criteriaPercentage').val(that.attr('percentage'));
            var rcid = that.attr('rcid');
     
            $(".rdescription"+rcid).each(function(){
                desc = $(this).html();
//                    
                htmlResponse +="<div class='form-group float-left'>";
                htmlResponse += "<label>Scale "+$(this).attr('scale')+"</label>";
                htmlResponse += "<input type='text' id='scale_desc_"+$(this).attr('scale')+"' scale='"+$(this).attr('scale')+"' value='"+desc+"' class='form-control scaleCriteria' placeholder='Scale "+$(this).attr('scale')+" description' /> <br />";
                htmlResponse += "</div>";
            });

            if(htmlResponse=="")
            {
                for(var i=1;i<=scale;i++)
                {
                    htmlResponse +="<div class='form-group float-left'>";
                    htmlResponse += "<label>Scale "+i+"</label>";
                    htmlResponse += "<input type='text' id='scale_desc_"+i+"' scale='"+i+"' class='form-control scaleCriteria' placeholder='Scale "+i+" description' /> <br />";
                    htmlResponse += "</div>";
                }
                
            }
            
            $('#scaleDetails').html(htmlResponse);
        };
        
        addCriteriaToRubric = function(that){
            var htmlResponse = "";
            var isEdit = $('#isEdit').val();
            var rcid = 0;
            if(isEdit==1)
            {
                rcid = that.attr('rcid');
            }
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
                    rcid        : rcid,
                    school_year : '<?php echo $school_year ?>',
                    csrf_test_name: $.cookie('csrf_cookie_name')
                },
                success: function (data)
                {

                    $('#rubricCriteriaWrapper').show();
                    alert(data);
                    location.reload();
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
        
        
        deleteCriteria = function(that) {
            
            var rcid = that.attr('rcid');
            
            var con = confirm('Are you sure you want to delete this criteria? Please note that you cannot undo this action');
            if(con==true)
            {
                var url = "<?php echo base_url() . 'opl/deleteCriteria/' ?>";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        school_year : '<?php echo $school_year ?>',
                        rcid            : rcid,
                        csrf_test_name: $.cookie('csrf_cookie_name')
                    },
                    success: function (data)
                    {
                        alert(data);
                        location.reload();
                    }
                });
            }
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