<div class="modal" tabindex="-1" role="dialog" id="attOverride">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Attendance Manual Override
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="input-group col-md-12">
                    <input type="text" onkeyup="search(this.value)" id="searchBox"  class="form-control" placeholder="Search Name Here" >
                    
                    <div onblur="$(this).hide()" style="min-height: 30px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; z-index: 1000; position: absolute; width: 85%; display: none; margin-top: 45px;" class="resultOverflow" id="searchName">
                    </div>
                </div>
                <input type="hidden" id="overrideDept" />    
                <div id="studentOverride">
                    <input type="hidden" id="overrideAct" />
                    <div class="col-md-5">
                        <img class="img-responsive"  id="overridePic" src="<?php echo site_url('images/icons/who.jpg'); ?>" style="">
                    </div>
                    <div class="col-md-6">
                        <p><span style="font-size: 24px; font-weight: bold; margin-right: 5px;">Name:</span><strong class='overrideForm' id="overrideName"></strong></p>
                        <p><span style="font-size: 24px; font-weight: bold; margin-right: 5px;" id='overrideGradeText'>Grade:</span><strong class='overrideForm' id="overrideGrade"></strong></p>
                        <p><span style="font-size: 24px; font-weight: bold; margin-right: 5px;" id='overrideSectionText'>Section:</span><strong class='overrideForm' id="overrideSection"></strong></p>
                        <p><span style="font-size: 24px; font-weight: bold;">Time In:</span>
                            <div class="bootstrap-timepicker">
                                <div class="form-group">
                                    <div class="input-group clockpicker">
                                        <input type="text" id="overrideTimeIn" class="form-control" placeholder="Now">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </p>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" id="stidOverride" />
                        <button type="button" class="btn btn-success btn-sm pull-right" data-dismiss="modal" aria-label="Close" onclick="submitOverride()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".clockpicker").clockpicker({
        placement: 'top',
        autoclose: true,
        donetext: 'Submit',
        'default': 'now',
    });
    $(document).ready(function(){
        reset();
    });

    function reset(){
        $("#searchBox").val('');
        $("#overridePic").attr('src', '<?php echo site_url('images/icons/who.jpg'); ?>');
        $('#stidOverride').val('');
        $('.overrideForm').html('');
    }

    function submitOverride(){
        var time = $("#overrideTimeIn").val(), st_id = $("#stidOverride").val(), act_id = $("#overrideAct").val();
        $.ajax("<?php echo site_url('college/activity/saveAttendanceManual'); ?>",{
            type: "POST",
            dataType: "JSON",
            data: {
                time: time,
                st_id: st_id,
                act_id: act_id,
                csrf_test_name: $.cookie('csrf_cookie_name')
            },
            success: function(data){
                $("#attlist_bod").html(data);
                reset();
            }
        });
    }

    function search(value)
    {
        if(value != ''){
            $.ajax({
               type: "POST",
               url: '<?php echo base_url().'college/activity/searchAttendee' ?>',
               data: {
                   id: value,
                   dept_id: $("#overrideDept").val(),
                   csrf_test_name: $.cookie('csrf_cookie_name'),
               }, // serializes the form's elements.
               success: function(data)
               {
                     $('#searchName').show();
                     $('#searchName').html(data);
               }
            });
        }
    }

function loadElemDetails(st_id, name, grade, section, img){
    if(img != ''){
        $("#overridePic").attr('src', '<?php echo site_url('uploads/'); ?>'+img);
    }else{
        $("#overridePic").attr('src', '<?php echo site_url('images/icons/who.jpg'); ?>');
    }
    $("#stidOverride").val(st_id);
    $("#overrideName").html(name);
    $("#overrideGradeText").html('Grade:');
    $("#overrideGrade").html(grade);
    $("#overrideSectionText").html('Section:');
    $("#overrideSection").html(section);
}

function loadColDetails(st_id, name, course, year, img){
    var yearText = 'First Year';
    switch(year){
        case 2:{ yearText = 'Second Year'; break; }
        case 3:{ yearText = 'Third Year'; break; }
        case 4:{ yearText = 'Fourth Year'; break; }
    }
    if(img != ''){
        $("#overridePic").attr('src', '<?php echo site_url('uploads/'); ?>'+img);
    }else{
        $("#overridePic").attr('src', '<?php echo site_url('images/icons/who.jpg'); ?>');
    }
    $("#stidOverride").val(st_id);
    $("#overrideName").html(name);
    $("#overrideGradeText").html('Year:');
    $("#overrideGrade").html(yearText);
    $("#overrideSectionText").html('Course:');
    $("#overrideSection").html(course);
}

function loadEmpDetails(emp_id, name, position, dept, img){
    if(img != ''){
        $("#overridePic").attr('src', '<?php echo site_url('uploads/'); ?>'+img);
    }else{
        $("#overridePic").attr('src', '<?php echo site_url('images/icons/who.jpg'); ?>');
    }
    $("#stidOverride").val(emp_id);
    $("#overrideName").html(name);
    $("#overrideGradeText").html('Position:');
    $("#overrideGrade").html(position);
    $("#overrideSectionText").html('Department:');
    $("#overrideSection").html(dept);
}

</script>