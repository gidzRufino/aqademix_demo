<div class="row">
    <div class="col-lg-12 ">
        <h3 class="page-header clearfix"><span class="col-lg-6">Parent Dashboard</span><small style="margin-top:10px;"  onclick="logout()" class="pull-right pointer" ><?php echo $settings->set_school_name ?></small></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <!--messeage widget-->
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/studentInfo' ); ?>
    </div>
    
    <!--student rank widget-->
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/subjectTeachers'); ?>
    </div>
    <div class="col-lg-3 col-md-6">
        <?php echo Modules::run('widgets/parent_portal_widgets/dailyReports'); ?>
    </div>
    <?php echo Modules::run('widgets/finance_widgets/show_students'); ?>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-6">
 
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bookmark fa-fw"></i> Current Day Attendance
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" style="height:260px;">
                
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

    </div>
    <!-- /.col-lg-8 -->
    <div class="col-md-6">
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
</div>
<!-- /.row -->

