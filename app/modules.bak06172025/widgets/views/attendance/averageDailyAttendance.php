<div class="col-lg-4 col-xs-12">
    <div class="panel panel-green">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-3">
                    <i  class="fa fa-bar-chart fa-5x"></i>
                </div>
                <div class="col-xs-9 text-right">
                    <div id="ave_att" class="huge"><?php echo round(($numberOfPresents/$numberOfSchoolDays)); ?></div>
                    <div id="ave_title">Average Daily Attendance</div>
                </div>
            </div>
        </div>
        <?php 
         if(!Modules::run('main/isMobile')):
            if($this->session->userdata('is_admin')): ?>
            <div class="panel-footer pointer" onclick="getAttendanceProgressForAdmin()" data-toggle="modal" data-target="#attendanceProgress">  
        <?php else: ?>
            <div class="panel-footer pointer" onclick="getAttendanceProgress('<?php echo $level->row()->section_id ?>','<?php echo $level->row()->level ?>', '<?php echo $level->row()->section ?>')" data-toggle="modal" data-target="#attendanceProgress">  
        <?php endif; 
       
        ?>    
            <span onclick="" class="pull-left">View Details</span>
            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
            <div class="clearfix"></div>
        </div>
        <?php  endif; ?>        
                
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
<script type="text/javascript">
    
    $(document).ready(function() {
       getAverageDailyAttendance()
    });
    
    function getAverageDailyAttendance()
    {
        var url = '<?php echo base_url().'widgets/attendance_widgets/getAverageDailyAttendance' ?>'
        $.ajax({
             type: "POST",
             url: url,
             //dataType: 'json',
             data: 'csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
             beforeSend: function() {
                    $('#ave_att').html('...');
                    $('#ave_title').html('Calculating...')
                },
             success: function(data)
             {
                 $('#ave_att').html(data);
                 $('#ave_title').html('Average Daily Attendance')

             }
         });
    }
    
    function getAttendanceProgress(id,level,section)
    {
        $('#levelSection').html(level+' - '+section);
        var url = '<?php echo base_url().'attendance/getApGraph/' ?>'
        $.ajax({
             type: "POST",
             url: url,
             data: 'section_id='+id+"&date="+'<?php echo date('m/d/Y') ?>'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
             beforeSend: function() {
                    showLoading('apGraph');
                },
             success: function(data)
             {
                 $('#apGraph').html(data);

             }
         });
    }
    function getAttendanceProgressForAdmin()
    {
        var url = '<?php echo base_url().'attendance/getApGraph/' ?>'
        $.ajax({
             type: "POST",
             url: url,
             data: 'section_id='+'admin'+"&date="+'<?php echo date('m/d/Y') ?>'+'&csrf_test_name='+$.cookie('csrf_cookie_name'), // serializes the form's elements.
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