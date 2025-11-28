<div id="attPerformance" >  
    <div class="col-lg-4  col-xs-12 pointer" onclick="//getAttendanceProgress('<?php echo $level->row()->section_id ?>','<?php echo $level->row()->level ?>', '<?php echo $level->row()->section ?>')"  >
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-5">
                        <p class="text-center">
                            <!-- <img class="img-circle" style="width:75px; height:80px;" src="<?php // echo base_url().'uploads/'.$advisory->row()->avatar;  ?>" /> -->
                            <?php if($s->avatar != ''): 
                                if (file_exists('uploads/'.$advisory->row()->avatar)):
                                ?>
                                    <img class="img-circle" style="width:75px; height:80px;" src="<?php echo base_url().'uploads/'.$advisory->row()->avatar  ?>" />
                                <?php else: ?>
                                    <img class="img-circle" style="width:75px; height:80px;" src="<?php echo base_url(). 'images/avatar/' . ($advisory->row()->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                                <?php endif; ?>
                            <?php else: ?>
                                <img class="img-circle" style="width:75px; height:80px;" src="<?php echo base_url(). 'images/avatar/' . ($advisory->row()->sex == 'Female' ? 'female.png' : 'male.png')  ?>" />
                            <?php endif; ?>
                        </p>
                        <h4 class="text-center"><?php echo strtoupper($advisory->row()->firstname) ?></h4>
                        <h4 class="text-center"><?php echo strtoupper($advisory->row()->lastname) ?></h4>
                    </div>
                    <div class="col-xs-7 text-right" style="border-left: 1px solid white;">
                        <div class="huge"><?php echo ($numberOfPresents->num_rows()>$numberOfStudents->num_rows()?$numberOfStudents->num_rows():$numberOfPresents->num_rows()) ?> / <?php echo $numberOfStudents->num_rows() ?></div>
                        <div>Students Present</div>
                        <hr />
                        <div class="huge"><?php echo round($presents/($numberOfSchoolDays)); ?></div>
                        <div>Average Daily</div>
                    </div>
                </div>
            </div>
                <div  class="panel-footer pointer" >  
                    <a href="<?php echo base_url();?>attendance/dailyPerSubject/NULL/<?php echo $level->row()->section_id ?>/"><span class="pull-left"><?php echo $level->row()->level.' - '.$level->row()->section  ?></span></a>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>

    <div style="padding:0; margin:20px;" id="attendanceProgress" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="panel panel-green">
            <div class="panel-heading clearfix">
                <h4>Monthly Attendance Progress Report <i data-dismiss="modal" class="fa fa-close fa-fw pointer pull-right"></i><span id="levelSection" class="pull-right"></span> </h4>

            </div>
            <div id="apGraph" class="panel-body">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function getAttendanceProgress(id,level,section)
    {
        $('#levelSection').html(level+' - '+section);
        var url = '<?php echo base_url().'attendance/getApGraph/' ?>'
        $.ajax({
             type: "POST",
             url: url,
             data: 'section_id='+id+"&date="+$('#inputBdate').val()+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
             beforeSend: function() {
                    showLoading('apGraph');
                },
             success: function(data)
             {
                 $('#apGraph').html(data);

             }
         });
    }
</script>