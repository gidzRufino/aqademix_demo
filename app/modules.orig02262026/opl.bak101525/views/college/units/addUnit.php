<section class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Add a Unit
                        <small class="muted text-info">This is all about summary</small>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Title</label>
                        <input type="text" class="form-control" id="unitTitle" placeholder="Unit Title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Objectives</label>
                        <textarea class="textarea" id="unitObjectives" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Unit Overview</label>
                        <textarea class="textarea" id="unitOverview" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="form-group col-xs-12 col-lg-6 pull-left">
                        <label>Select Course, Subject and Section</label>
                        <select id="gradeLevel" class="form-control">
                            <option>Select Course, Subject and Section</option>
                                <?php 
                                $determinant = $subject_id."-".$section_id;
                                $selected = '';
                                foreach($getSubjects as $gl):
                                    if($determinant = $gl->s_id.'-'.$gl->section_id):
                                        $selected = 'selected';
                                    endif;
                                ?>
                            <option value="<?php echo $gl->course_id.'-'.$gl->s_id.'-'.$gl->section_id ?>" <?php echo $selected; ?>><?php echo $gl->course.' - '.$gl->s_desc_title.' [ '. $gl->section.' ] '?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label>File Attachment <small class="mute text-danger">[ Optional ]</small></label>
                        <input class="form-control" type="file" name="userfile" id="userfile">
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <button class="btn btn-primary btn-sm" onclick="saveUnit()" style="float:right;">Save Unit</button>
                </div>

            </div>
            <!-- /.col-->
     </div>
</section>

<input type="hidden" id="school_year" value="<?php echo $school_year; ?>" />

<script type="text/javascript">

    $(function () {
        // Summernote
        $('.textarea').summernote();
    
    saveUnitandUpload = function(){
        if ($('#userfile').get(0).files.length === 0) {
            saveUnit();
        }else{
            var base = $('#base').val();
            var school_year = $('#school_year').val();
            var unitObjectives = $('#unitObjectives').val();
            var unitTitle = $('#unitTitle').val();
            var unitOverview = $('#unitOverview').val();
            var fd = new FormData(); 
            var files = $('#userfile')[0].files[0]; 


            var url = base + 'opl/college/saveUnit';
            
            fd.append("userfile", files);
            fd.append("hasUpload", 1);
            fd.append("school_year", school_year);
            fd.append("unitObjectives", unitObjectives);
            fd.append("unitTitle", unitTitle);
            fd.append("unitOverview", unitOverview);
            fd.append("unitSubject", $("#gradeLevel").val());
            fd.append("csrf_test_name", $.cookie("csrf_cookie_name"));
            
            $.ajax({
                type: "POST",
                url: url,
                data: fd, 
                contentType: false, 
                processData: false, 
                beforeSend: function () {
                    $('#loadingModal').modal('show');
                },
                success: function (data)
                {
                    alert(data);
                    document.location = base + '/opl/unitView/' +school_year+'/List/'+ $('#grade_level_id').val() + '/' + $('#section_id').val() + '/' + $('#subject_id').val();
                }
            });
        }
    }
    
    saveUnit = function()
    {
        
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var unitObjectives = $('#unitObjectives').val();
        var unitTitle = $('#unitTitle').val();
        var unitOverview = $('#unitOverview').val();


        var url = base + 'opl/college/saveUnit';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                hasUpload: 0,
                school_year: school_year,
                unitObjectives: unitObjectives,
                unitTitle: unitTitle,
                unitOverview: unitOverview,
                unitSubject: $("#gradeLevel").val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function (data)
            {
                var split = $("#gradeLevel").val().split("-");
                alert(data);
                document.location = base + 'opl/college/unitView/' +school_year+'/List/<?php echo $semester; ?>/' + split[2] + '/' + split[1];
            }
        });

    }

    });
    
</script>