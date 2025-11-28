<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard
        
        <?php
            if(!empty(Modules::run('college/subjectmanagement/getAssignedSubjectRaw', $this->session->userdata('employee_id')))):
        ?>
            <button class="btn btn-default pull-right" onclick="document.location='<?php echo base_url('college') ?>'">College</button>
        <?php
            endif;
        ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <?php 
    if($this->session->userdata('is_adviser')):
        echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); 
        echo Modules::run('widgets/getWidget', 'attendance_widgets', 'averageDailyAttendance'); 
    endif;
    ?> 
    <div class="col-lg-4 col-xs-12 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-calendar fa-fw"></i> School Calendar
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" style="padding:0;">
               <?php
                    echo Modules::run('calendar/getCalWidget', date('Y'), date('m'));
                ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
        <?php echo Modules::run('widgets/getWidget', 'notification_widgets', 'dashboard'); ?>
</div>
