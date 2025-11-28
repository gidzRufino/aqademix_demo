<section id="gvDetails" class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        Resource List
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-group col-xs-12 col-lg-6 float-left">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Title">
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="form-group ">
                        <label for="exampleInputEmail1">Details</label>
                        <textarea class="textarea" id="details" placeholder="Place some text here"
                                  style="width: 100%; height: 400px; font-size: 14px; line-height: 15px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Select Subject</label>
                        <select id="subject" class="form-control" onclick="fetchLesson(this.value)">
                            <option>Select Subject</option>
                            <?php foreach($getSubjects as $gl): 
                                ?>
                            <option value="<?php echo $gl->subject_id ?>"><?php echo $gl->subject.' - '.$gl->level.' [ '. $gl->section.' ] '?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Topic</label>
                        <input type="text" class="form-control" id="topic" placeholder="Topic">
                    </div>
                    
                    <div class="col-xs-12 col-lg-6 pull-left">
                        <label>Grade Level</label>
                        <select id="gradelvl" class="form-control">
                            <?php foreach($getGradeLevel as $gg): ?>
                            <option  value="<?php echo $gg->grade_id ?>"><?php echo $gg->level ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-6 col-xs-12 float-left">
                        <label for="">Tags</label>
                        <select name="tags[]" id="tags" multiple="multiple">
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer clearfix">
                    <!-- <div class="checkbox float-left" >
                        <label>
                            <input id="goPublic" type="checkbox"> Go Public
                        </label>
                    </div> -->
                    <button class="btn btn-success btn-sm float-right" onclick="postTask()">Post</button>
                </div>
                
            </div>
            <!-- /.col-->
        </div>
</section>

<!-- <input type="hidden" id="grade_level_id" value="<?php echo $gradeDetails->grade_level_id ?>" />
<input type="hidden" id="section_id" value="<?php echo $gradeDetails->section_id ?>" />
<input type="hidden" id="subject_id" value="<?php echo $subjectDetails->subject_id ?>" /> -->
<input type="hidden" id="school_year" value="<?php echo $school_year ?>" />

<script type="text/javascript">


    $(document).ready(function () {

        $("select#tags").select2({
            placeholder: "Set Tags",
            tags: true,
            tokenSeparators: [',', ' ']
        });

    });

    function test(){
        var tags = $('#tags').val();
        var res ='';

        $.each(tags, function(i, value){
            if(tags.length-1 != i){
                res += value + ', ';
            }
            else{
                res += value;
            }
            
        })
        console.log(tags);
        console.log(res);
        

    }

    $(function () {  
        // Summernote
        $('.textarea').summernote();
        $('.timePick').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        
    });
    
    
    function postTask()
    {
        var gopublic = 0;
        var base = $('#base').val();
        var school_year = $('#school_year').val();
        var details = $('#details').val();
        var title = $('#title').val();
        var subject = $('#subject').val();
        var gradelevel = $('#gradelvl').val();
        var tags = $('#tags').val();
        var topic = $('#topic').val();
        

        var tags = $('#tags').val();
        var res ='';

        $.each(tags, function(i, value){
            if(tags.length-1 != i){
                res += value + ', ';
            }
            else{
                res += value;
            }
            
        })


        var url = base + 'opl/opl_resourcelist/addResourceList';

        $.ajax({
            type: "POST",
            url: url,
            data: {
                school_year     : school_year,
                title           : title,
                details         : details,
                subject         : subject,
                topic           : topic,
                gradelevel      : gradelevel,
                tags            : res,
                csrf_test_name  : $.cookie('csrf_cookie_name') 
            }, // serializes the form's elements.
            //dataType: 'json',
            // beforeSend: function () {
            //     $('#loadingModal').modal('show');
            // },
            success: function (data)
            {
                alert(data);   
                
                //document.location = base + '/opl/classBulletin/'+ school_year+'/List/'+gradeLevel+ '/' + section_id + '/' + subject_id+ '/';
            },
            error: function (data){
                
                console.log(data);
            }
        });

    }
</script>