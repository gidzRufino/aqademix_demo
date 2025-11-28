<div class="col-xs-12">
    <a href="#teachersLoad" data-transition="flow">
        <div class='col-xs-6 panel mobile-panel-blue no-padding no-margin margin-right pointer'>
            <div class='panel-heading text-center no-padding'>
                <img style="width:60px; padding-top:10px; margin-bottom:7px; " src="<?php echo base_url('images/icons/studentInfo.png') ?> " />
                <h5 class='no-margin text-left padding-5'>Teacher's Load</h5>
            </div>

        </div>
    </a>
    <a onclick="document.location=this.href" href="<?php echo base_url().'attendance/dailyPerSubject' ?>#absentPage" data-transition="flow" >
    <div class='col-xs-6 panel mobile-panel-green no-padding no-margin'>
         <div class='panel-heading text-center no-padding'>
            <img style="width:50px; padding-top:10px; margin-bottom:6px; " src="<?php echo base_url('images/icons/attendance.png') ?> " />
            <h5 class='no-margin text-left padding-5'>Attendance Info</h5>
        </div>
    </div>
    </a>    
</div>
<div  onclick="document.location='<?php echo base_url().'gradingsystem' ?>'" class="col-xs-12">
        <div class='panel mobile-panel-orange no-padding no-margin'>
            <div class='panel-heading text-center no-padding'>
                <img style="width:50px; padding-top:10px; margin-bottom:7px; " src="<?php echo base_url('images/icons/grading.png') ?> " />
                <h5 class='no-margin text-left padding-5'>Grading System</h5>
            </div>

        </div>
</div>
<div class="col-xs-12">
    <div class='col-xs-6 panel mobile-panel-red no-padding no-margin margin-right'>
        <div class='panel-heading text-center no-padding'>
            <img style="width:50px; padding-top:10px; margin-bottom:7px; " src="<?php echo base_url('images/icons/teachers.png') ?> " />
            <h5 class='no-margin text-left padding-5'>Daily Time Record</h5>
        </div>
        
    </div>
    <div class='col-xs-6 panel mobile-panel-blue no-padding no-margin'>
        <div class='panel-heading text-center no-padding'>
            <img style="width:50px; padding-top:10px; margin-bottom:25px; " src="<?php echo base_url('images/icons/communication.png') ?> " />
            <h5 class='no-margin text-left padding-5'>Notifications</h5>
        </div>
        
    </div>
</div>
<div class="col-xs-12 no-padding">
    <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'averageDailyAttendance'); ?>
    
</div>
<div class='col-xs-12'>
    <a href='<?php echo base_url('login/logout') ?>'onclick='document.location=this.href'  class='btn btn-info btn-block'>Sign Out</a>
</div>


<script type="text/javascript">
    
    
</script>