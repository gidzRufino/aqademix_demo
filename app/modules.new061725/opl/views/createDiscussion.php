<section class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Add a Discussion
                        <!--<small class="muted text-info">Things </small>-->
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discussion Title</label>
                        <input type="text" class="form-control" id="discussTitle" placeholder="Discusstion Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Discussion Details</label>
                        <textarea class="textarea" id="discussDetails" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label>Select Subject, Grade Level and Section </label>
                        <select id="gradeLevel" class="form-control" onclick="fetchLesson(this.value)">
                            <option>Select Subject, Grade Level and Section</option>
                            <?php foreach($getSubjects as $gl): 
                                ?>
                            <option value="<?php echo $gl->subject_id.'-'.$gl->grade_id.'-'.$gl->section_id ?>"><?php echo $gl->subject.' - '.$gl->level.' ['.$gl->section.'] '?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label>Link to Unit</label>
                        <select id="unitLink" class="form-control">
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
                    
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label>File Attachment <small class="mute text-danger">[ Optional ]</small></label>
                        <input class="form-control" type="file" name="userfile" id="userfile">
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <div class="checkbox float-left" >
                        <label>
                            <input id="goPublic" value="0" type="checkbox"> Go Public
                        </label>
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="saveUnitandUpload()" style="float:right;">Create a Discussion</button>
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
    
    saveUnitandUpload = function(){
        if ($('#userfile').get(0).files.length === 0) {
            if($('#goPublic').is(":checked"))
            {
                $('#goPublic').val(1);
            }
            saveDiscussion();
        }else{
            var base = $('#base').val();
            var school_year = $('#school_year').val();
            var discussDetails = $('#discussDetails').val();
            var discussTitle = $('#discussTitle').val();
            var unitID = $('#unitLink').val();
            var fd = new FormData(); 
            var files = $('#userfile')[0].files[0]; 


            var url = base + 'opl/addDiscussion';
            
            fd.append("userfile", files);
            fd.append("hasUpload", 1);
            fd.append("school_year", school_year);
            fd.append("discussDetails", discussDetails);
            fd.append("discussTitle", discussTitle);
            fd.append("unitID", unitID);
            fd.append("gradeLevel", $('#gradeLevel').val(),);
            fd.append("subject_id", $("#subject_id").val());
            fd.append("startDate", $('#startDate').val()+' '+ $('#timeStart').val(),);
            fd.append("csrf_test_name", $.cookie("csrf_cookie_name"));
            
            $.ajax({
                type: "POST",
                url: url,
                data: fd, 
                contentType: false, 
                processData: false, 
                dataType: 'json',
                beforeSend: function () {
                    $('#loadingModal').modal('show');
                },
                success: function (data)
                {
                    alert(data.msg);
                    location.reload();
                }
            });
        }
    }
    
    
    saveDiscussion = function()
    {
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var discussDetails = $('#discussDetails').val();
        var discussTitle = $('#discussTitle').val();
        var unitID = $('#unitLink').val();


        var url = base + 'opl/addDiscussion';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : school_year,
                discussDetails  : discussDetails,
                discussTitle    : discussTitle,
                unitID          : unitID,
                gradeLevel      : $('#gradeLevel').val(),
                startDate       : $('#startDate').val()+' '+ $('#timeStart').val(),
                subject_id      : $('#subject_id').val(),
                goPublic        : $('#goPublic').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            dataType: 'json',
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function (data)
            {
                alert(data.msg);
                location.reload();
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
    
</script>