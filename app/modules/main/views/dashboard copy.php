<?php 
    switch ($this->session->userdata('position')){
        case 'Teacher - I':
        case 'Teacher - II':
        case 'Faculty':
            $this->load->view('teachers_dashboard');
        break;
    
        default :
        
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
        <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresents'); ?>
        <?php 
        if($settings->level_catered==5):
            echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfPresentCollege'); 
        endif;
        ?>
        <?php //echo Modules::run('widgets/getWidget', 'attendance_widgets', 'averageDailyAttendance'); ?>
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
        <!-- /.col-lg-4 -->
        
        <?php echo Modules::run('widgets/getWidget', 'attendance_widgets', 'numberOfEmployeePresents'); ?>
        <div class="row">
            
                <?php echo Modules::run('widgets/getWidget', 'notification_widgets', 'dashboard'); ?>
        
        </div>
        
</div>
<!-- /.row -->

<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url('assets/js/plugins/morris/raphael.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/plugins/morris/morris.min.js'); ?>"></script>
<!--<script src="<?php echo base_url('assets/js/plugins/morris/morris-data.js'); ?>"></script>-->

<?php
            
    }

