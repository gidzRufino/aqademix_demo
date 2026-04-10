<div class="row" style="height: 100vh;" >
        <div class="col-lg-12">
            <h3 style="margin:10px 0;" class="page-header">Subject Management
            <div class="btn-group pull-right" role="group" aria-label="">
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college') ?>'">Dashboard</button>
                <button type="button" class="btn btn-default" onclick="document.location='<?php echo base_url('college/subjectmanagement/listOfSubjects') ?>'">View Subjects Per Course</button>
                <button type="button" class="btn btn-default" onclick="">Schedule Per Subject</button>
                <button type="button" class="btn btn-default" onclick="getAdd('CollegeSubject')">Add Subject</button>
              </div>
            </h3>
        </div>
    <div class="col-lg-12 no-padding">
        <div class="col-lg-12">
            <div style="width:70%; margin: 20px auto" id="subject_body">
                
                <div class="col-lg-12" style="margin-bottom: 20px;">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 ">

                    <select style="font-size: 20px;" id="searchCourse" class="col-lg-12 no-padding" onclick="getSubjectPerCourse(this.value)">
                            <option>Select Course</option>
                            <?php
                                foreach ($courses as $c):
                            ?>
                            <option value="<?php echo $c->course_id ?>"> <?php echo strtoupper($c->course) ?></option>
                            <?php
                                endforeach;
                            ?>   
                        </select>

                </div>
                <div class="col-lg-3"></div>
            </div>
            <div id="links" class="pull-left">
                <?php echo $links; ?>
            </div>
            <table class="table table-striped col-lg-6">
                <thead>
                    <tr>
                        <th style="width:10%;">Course Title</th>
                        <th style="width:50%;">Course Description</th>
                        <th style="width:10%; text-align: center">Lecture Unit</th>
                        <th style="width:10%; text-align: center">Lab Unit</th>
                        <th style="width:10%; text-align: center">Pre-requisite</th>
                        <th style="width:10%; text-align: center">No. of Sections</th>
                        <!--<th style="width:10%;">Pre-requisite</th>-->
                    </tr>
                </thead>
                <tbody id="subjectsWrapper" style="overflow-y: scroll;">
                    <?php  foreach($collegeSubjects->result() as $c): ?>
                    <tr id="<?php echo $c->s_id ?>_li">
                        <td><?php echo $c->sub_code ?></td>
                        <td><?php echo $c->s_desc_title ?></td>
                        <td style="text-align: center"><?php echo $c->s_lect_unit ?></td>
                        <td style="text-align: center"><?php echo $c->s_lab_unit ?></td>
                        <td style="text-align: center"><?php echo $c->pre_req ?></td>
                        <td style="text-align: center" class="pointer">
                            <button  onclick="getAdd('Section'), selectSubject('<?php echo $c->s_id ?>','<?php echo $c->sub_code ?>')" class="btn btn-info btn-xs">
                            <?php echo ($subs->num_rows()>0?$subs->num_rows():0) ?>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
            </div>

        </div>
    </div> 
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        $("#searchCourse").select2();
    })
    
    
        
    function getAdd(data)
    {
        $('#add'+data).modal('show');
    }
    
    function addSection()
    {
        
         var url = "<?php echo base_url().'college/subjectmanagement/addSection/'?>";
             $.ajax({
                   type: "POST",
                   url: url,
                   data: "sub_id="+$('#inputSubject').val()+'&course_id='+$('#searchCourse').val()+'&semester='+$('#inputSem').val()+'&subCode='+$('#Code').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
                   dataType:'json',
//                   beforeSend: function() {
//                            $('#subject_body').show('<i class="fa fa-spinner fa-spin fa-fw text-center"></i>');
//                        },
                   success: function(data)
                   {
                       alert(data.msg)
                       location.reload();
                   }
                 });

            return false;  
    }
    
    function getSubjectPerCourse(value)
    {
        
        var url = "<?php echo base_url().'college/subjectmanagement/getSubjectsPerCourse/'?>"+value; // the script where you handle the form input.

        $.ajax({
               type: "POST",
               url: url,
               data: "value="+value+'&csrf_test_name='+$.cookie('csrf_cookie_name')                                                                                                                                                                                                                                                                              , // serializes the form's elements.
               success: function(data)
               {                   
                   $('#subjectsWrapper').html(data)
               }
        });
        
        return false;
    }
</script>