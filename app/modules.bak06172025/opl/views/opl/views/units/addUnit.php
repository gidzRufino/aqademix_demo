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
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Subject </label>
                        <select id="subjects" class="form-control">
                            <?php foreach($getSubjects as $sub): 
                                if($subject_id==$sub->subject_id):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                ?>
                            <option <?php echo $selected ?> value="<?php echo $sub->subject_id ?>"><?php echo $sub->subject ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Grade Level </label>
                        <select id="gradeLevel" class="form-control">
                            <?php foreach($gradeLevel as $gl): 
                                if($grade_level==$gl->grade_id):
                                    $selected = 'Selected';
                                else:
                                    $selected = '';
                                endif;
                                ?>
                            <option <?php echo $selected ?> value="<?php echo $gl->grade_id ?>"><?php echo $gl->level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    <button class="btn btn-primary btn-sm" onclick="saveUnit()" style="float:right;">Save Unit</button>
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
        
    
    saveUnit = function()
    {
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var unitObjectives = $('#unitObjectives').val();
        var unitTitle = $('#unitTitle').val();
        var unitOverview = $('#unitOverview').val();


        var url = base + 'opl/saveUnit';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year: school_year,
                unitObjectives: unitObjectives,
                unitTitle: unitTitle,
                unitOverview: unitOverview,
                section_id: $('#section_id').val(),
                subject_id: $('#subject_id').val(),
                grade_level_id : $('#grade_level_id').val(),
                csrf_test_name: $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            //dataType: 'json',
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

    });
    
</script>