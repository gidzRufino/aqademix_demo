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
                    <div class="col-xs-12 col-lg-12 pull-left">
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
                </div>

                <div class="card-footer clearfix">
                    <button class="btn btn-primary btn-sm" onclick="saveDiscussion()" style="float:right;">Create a Discussion</button>
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
                startDate       : $('#startDate').val()+' '+ $('#timeStart').val(),
                subject_id      : $('#subject_id').val(),
                csrf_test_name  : $.cookie('csrf_cookie_name')
            }, // serializes the form's elements.
            //dataType: 'json',
            beforeSend: function () {
                $('#loadingModal').modal('show');
            },
            success: function (data)
            {
                alert(data);
                location.reload();
            }
        });

    }

    });
    
</script>